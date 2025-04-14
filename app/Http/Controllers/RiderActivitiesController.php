<?php

namespace App\Http\Controllers;

use App\DataTables\RiderActivitiesDataTable;
use App\Http\Requests\CreateRiderActivitiesRequest;
use App\Http\Requests\UpdateRiderActivitiesRequest;
use App\Http\Controllers\AppBaseController;
use App\Imports\ImportRiderActivities;
use App\Repositories\RiderActivitiesRepository;
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
  public function index(RiderActivitiesDataTable $riderActivitiesDataTable)
  {
    return $riderActivitiesDataTable->render('rider_activities.index');
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
