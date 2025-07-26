<?php

namespace App\Http\Controllers;

use App\DataTables\RiderActivitiesDataTable;
use App\Http\Requests\CreateRiderActivitiesRequest;
use App\Http\Requests\UpdateRiderActivitiesRequest;
use App\Http\Controllers\AppBaseController;
use App\Imports\ImportRiderActivities;
use App\Repositories\RiderActivitiesRepository;
use App\Models\RiderActivities;
use Illuminate\Http\Request;
use Flash;
use Maatwebsite\Excel\Facades\Excel;

class RiderActivitiesController extends AppBaseController
{
  /** @var RiderActivitiesRepository $riderActivitiesRepository*/
  private $riderActivitiesRepository;

  public function __construct(RiderActivitiesRepository $riderActivitiesRepo)
  {
    $this->riderActivitiesRepository = $riderActivitiesRepo;
  }

  /**
   * Display a listing of the RiderActivities.
   */
  public function index(Request $request)
  {
    $perPage = request()->input('per_page', 50);
    $perPage = is_numeric($perPage) ? (int) $perPage : 50;
    $perPage = $perPage > 0 ? $perPage : 50;
    $query = RiderActivities::query()
        ->orderBy('id', 'desc');
    if ($request->has('id') && !empty($request->id)) {
        $query->where('d_rider_id', 'like', '%' . $request->id . '%');
    }
    if ($request->has('rider_id') && !empty($request->rider_id)) {
        $query->where('rider_id', 'like', '%' . $request->rider_id . '%');
    }
    if ($request->has('billing_month_from') && !empty($request->billing_month_from)) {
        $fromDate = \Carbon\Carbon::parse($request->billing_month_from)->startOfMonth();
        $query->where('date', '>=', $fromDate);
    }

    if ($request->has('billing_month_to') && !empty($request->billing_month_to)) {
        $toDate = \Carbon\Carbon::parse($request->billing_month_to)->endOfMonth();
        $query->where('date', '<=', $toDate);
    }
    if ($request->has('payout_type') && !empty($request->payout_type)) {
        $query->where('payout_type',$request->payout_type);
    }
    $data = $query->paginate($perPage);
    if ($request->ajax()) {
        $tableData = view('rider_activities.table', [
            'data' => $data,
        ])->render();
        $paginationLinks = $data->links('pagination')->render();
        return response()->json([
            'tableData' => $tableData,
            'paginationLinks' => $paginationLinks,
        ]);
    }
    return view('rider_activities.index', [
        'data' => $data,
    ]);
  }


  /**
   * Show the form for creating a new RiderActivities.
   */
  public function create()
  {
    return view('rider_activities.create');
  }

  /**
   * Store a newly created RiderActivities in storage.
   */
  public function store(CreateRiderActivitiesRequest $request)
  {
    $input = $request->all();

    $riderActivities = $this->riderActivitiesRepository->create($input);

    Flash::success('Rider Activities saved successfully.');

    return redirect(route('riderActivities.index'));
  }

  /**
   * Display the specified RiderActivities.
   */
  public function show($id)
  {
    $riderActivities = $this->riderActivitiesRepository->find($id);

    if (empty($riderActivities)) {
      Flash::error('Rider Activities not found');

      return redirect(route('riderActivities.index'));
    }

    return view('rider_activities.show')->with('riderActivities', $riderActivities);
  }

  /**
   * Show the form for editing the specified RiderActivities.
   */
  public function edit($id)
  {
    $riderActivities = $this->riderActivitiesRepository->find($id);

    if (empty($riderActivities)) {
      Flash::error('Rider Activities not found');

      return redirect(route('riderActivities.index'));
    }

    return view('rider_activities.edit')->with('riderActivities', $riderActivities);
  }

  /**
   * Update the specified RiderActivities in storage.
   */
  public function update($id, UpdateRiderActivitiesRequest $request)
  {
    $riderActivities = $this->riderActivitiesRepository->find($id);

    if (empty($riderActivities)) {
      Flash::error('Rider Activities not found');

      return redirect(route('riderActivities.index'));
    }

    $riderActivities = $this->riderActivitiesRepository->update($request->all(), $id);

    Flash::success('Rider Activities updated successfully.');

    return redirect(route('riderActivities.index'));
  }

  /**
   * Remove the specified RiderActivities from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $riderActivities = $this->riderActivitiesRepository->find($id);

    if (empty($riderActivities)) {
      Flash::error('Rider Activities not found');

      return redirect(route('riderActivities.index'));
    }

    $this->riderActivitiesRepository->delete($id);

    Flash::success('Rider Activities deleted successfully.');

    return redirect(route('riderActivities.index'));
  }

  public function import(Request $request)
  {
    if ($request->isMethod('post')) {
      $rules = [
        'file' => 'required|max:50000|mimes:xlsx,csv'
      ];
      $message = [
        'file.required' => 'Excel File Required'
      ];
      $this->validate($request, $rules, $message);
      Excel::import(new ImportRiderActivities(), $request->file('file'));
    }

    return view('rider_activities.import');
  }
}
