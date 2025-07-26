<?php

namespace App\Http\Controllers;

use App\DataTables\BikeHistoryDataTable;
use App\DataTables\BikesDataTable;
use App\DataTables\BikesHistoryDataTable;
use App\Http\Requests\CreateBikesRequest;
use App\Http\Requests\UpdateBikesRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\BikeHistory;
use App\Models\Bikes;
use App\Models\Riders;
use App\Repositories\BikesRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Flash;

class BikesController extends AppBaseController
{
  /** @var BikesRepository $bikesRepository*/
  private $bikesRepository;

  public function __construct(BikesRepository $bikesRepo)
  {
    $this->bikesRepository = $bikesRepo;
  }

  /**
   * Display a listing of the Bikes.
   */
  public function index(Request $request)
  {

    if (!auth()->user()->hasPermissionTo('bike_view')) {
      abort(403, 'Unauthorized action.');
    }
    $perPage = request()->input('per_page', 50);
    $perPage = is_numeric($perPage) ? (int) $perPage : 50;
    $perPage = $perPage > 0 ? $perPage : 50;
    $query = Bikes::query()
        ->orderBy('bike_code', 'desc');
    if ($request->has('bike_code') && !empty($request->bike_code)) {
        $query->where('bike_code', 'like', '%' . $request->bike_code . '%');
    }
    if ($request->has('plate') && !empty($request->plate)) {
        $query->where('plate', 'like', '%' . $request->plate . '%');
    }
    if ($request->has('rider_id') && !empty($request->rider_id)) {
        $query->where('rider_id',$request->rider_id);
    }
    if ($request->has('rider') && !empty($request->rider)) {
        $query->where('rider_id',$request->rider);
    }
    if ($request->has('company') && !empty($request->company)) {
        $query->where('company',$request->company);
    }
    if ($request->has('emirates') && !empty($request->emirates)) {
        $query->where('emirates',$request->emirates);
    }
    if ($request->filled('expiry_date_from')) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-d-m', $request->expiry_date_from);
        $query->where('expiry_date', '>=', $fromDate);
    }

    if ($request->filled('expiry_date_to')) {
        $toDate = \Carbon\Carbon::createFromFormat('Y-d-m', $request->expiry_date_to);
        $query->where('expiry_date', '<=', $toDate);
    }

    if ($request->has('status') && !empty($request->status)) {
        $query->where('status',$request->status);
    }
    $data = $query->paginate($perPage);
    if ($request->ajax()) {
        $tableData = view('bikes.table', [
            'data' => $data,
        ])->render();
        $paginationLinks = $data->links('pagination')->render();
        return response()->json([
            'tableData' => $tableData,
            'paginationLinks' => $paginationLinks,
        ]);
    }
    return view('bikes.index', [
        'data' => $data,
    ]);
    return $bikesDataTable->render('bikes.index');
  }


  /**
   * Show the form for creating a new Bikes.
   */
  public function create()
  {
    return view('bikes.create');
  }

  /**
   * Store a newly created Bikes in storage.
   */
  public function store(CreateBikesRequest $request)
  {
    $input = $request->all();

    $bikes = $this->bikesRepository->create($input);

    return response()->json(['message' => 'Bike added successfully.']);

  }

  /**
   * Display the specified Bikes.
   */
  public function show($id)
  {
    $bikes = $this->bikesRepository->find($id);

    if (empty($bikes)) {
      Flash::error('Bikes not found');

      return redirect(route('bikes.index'));
    }

    return view('bikes.show')->with('bikes', $bikes);
  }

  /**
   * Show the form for editing the specified Bikes.
   */
  public function edit($id)
  {
    $bikes = $this->bikesRepository->find($id);

    if (empty($bikes)) {
      Flash::error('Bikes not found');

      return redirect(route('bikes.index'));
    }

    return view('bikes.edit')->with('bikes', $bikes);
  }

  /**
   * Update the specified Bikes in storage.
   */
  public function update($id, UpdateBikesRequest $request)
  {
    $bikes = $this->bikesRepository->find($id);

    if (empty($bikes)) {
      return response()->json(['errors' => ['error' => 'Bike not found!']], 422);

    }

    $bikes = $this->bikesRepository->update($request->all(), $id);

    return response()->json(['message' => 'Bike updated successfully.']);


  }

  /**
   * Remove the specified Bikes from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $bikes = $this->bikesRepository->find($id);

    if (empty($bikes)) {
      return response()->json(['errors' => ['error' => 'Bike not found!']], 422);

    }

    $this->bikesRepository->delete($id);

    return response()->json(['message' => 'Bike deleted successfully.']);

  }

  public function assign_rider(Request $request, $id)
  {
    if (request()->isMethod('post')) {
      $rules = [
        'bike_id' => 'required',
        'rider_id' => 'nullable|unique:bikes',
      ];
      $message = [
        'bike_id.required' => 'ID Required',
        'rider_id.unique' => 'Rider has already assigned.',
      ];
      $this->validate($request, $rules, $message);
      $data = $request->all();

      \DB::beginTransaction();
      try {

        $bike = Bikes::where('id', $request->bike_id)->orderByDesc('id')->first();

        if ($request->warehouse == 'Active') {

          Riders::where('id', $request->rider_id)->update(['status' => 1]);
          $bike->update(['rider_id' => $request->rider_id, 'warehouse' => $request->warehouse]);

        } else if ($request->warehouse == 'Absconded') {

          $data['rider_id'] = $bike->rider_id;
          Riders::where('id', $bike->rider_id)->update(['status' => 5]);
          $bike->update(['rider_id' => $bike->rider_id, 'warehouse' => $request->warehouse]);

        } else if ($request->warehouse == 'Vacation') {

          $data['rider_id'] = $bike->rider_id;
          Riders::where('id', $bike->rider_id)->update(['status' => 4]);
          $bike->update(['rider_id' => $request->rider_id, 'warehouse' => $request->warehouse]);

        } else {

          Riders::where('id', $bike->rider_id)->update(['status' => 3]);
          $bike->update(['rider_id' => $request->rider_id, 'warehouse' => $request->warehouse]);

        }

        //creating bike hostory
        $ret = BikeHistory::create($data);


        \DB::commit();
        return response()->json(['message' => 'Rider assigned successfully.']);

      } catch (QueryException $e) {
        \DB::rollback();
        return response()->json([
          'success' => 'false',
          'errors' => $e->getMessage(),
        ], 400);
      }
    }

    return view('bikes.assign_rider', compact('id'));
  }

  public function contract($id)
  {
    $contract = BikeHistory::find($id);


    return view('bikes.contract', compact('contract'));
  }
  public function contract_upload(Request $request)
  {
    $contract = BikeHistory::find($request->id);
    if (isset($request->contract)) {

      $doc = $request->contract;
      $extension = $doc->extension();
      $name = time() . '.' . $extension;
      $doc->storeAs('contract', $name);


      $contract->contract = $name;
      $contract->save();

      return response()->json(['message' => $contract->rider->name . '( ' . $contract->rider->rider_id . ' ) Bike Plate # ' . $contract->bike->plate . ' Contract uploaded.']);
      //return redirect(url('bikes'))->with('success', $contract->rider->name . '( ' . $contract->rider->rider_id . ' ) Bike Plate # ' . $contract->bike->plate . ' Contract uploaded.');
    }

    return view('bikes.contract-modal', compact('contract'));
  }
}
