<?php

namespace App\Http\Controllers;

use App\DataTables\DropdownsDataTable;
use App\Http\Requests\CreateDropdownsRequest;
use App\Http\Requests\UpdateDropdownsRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DropdownsRepository;
use Illuminate\Http\Request;
use Flash;

class DropdownsController extends AppBaseController
{
  /** @var DropdownsRepository $dropdownsRepository*/
  private $dropdownsRepository;

  public function __construct(DropdownsRepository $dropdownsRepo)
  {
    $this->dropdownsRepository = $dropdownsRepo;
  }

  /**
   * Display a listing of the Dropdowns.
   */
  public function index(DropdownsDataTable $dropdownsDataTable)
  {

    if (!auth()->user()->hasPermissionTo('dropdown_view')) {
      abort(403, 'Unauthorized action.');
    }
    return $dropdownsDataTable->render('dropdowns.index');
  }


  /**
   * Show the form for creating a new Dropdowns.
   */
  public function create()
  {
    return view('dropdowns.create');
  }

  /**
   * Store a newly created Dropdowns in storage.
   */
  public function store(CreateDropdownsRequest $request)
  {
    //$input = $request->all();

    $dropdowns = $this->dropdownsRepository->save($request);

    Flash::success('Dropdowns saved successfully.');

    return redirect(route('dropdowns.index'));
  }

  /**
   * Display the specified Dropdowns.
   */
  public function show($id)
  {
    $dropdowns = $this->dropdownsRepository->find($id);

    if (empty($dropdowns)) {
      Flash::error('Dropdowns not found');

      return redirect(route('dropdowns.index'));
    }

    return view('dropdowns.show')->with('dropdowns', $dropdowns);
  }

  /**
   * Show the form for editing the specified Dropdowns.
   */
  public function edit($id)
  {
    $dropdowns = $this->dropdownsRepository->find($id);

    if (empty($dropdowns)) {
      Flash::error('Dropdowns not found');

      return redirect(route('dropdowns.index'));
    }

    return view('dropdowns.edit')->with('dropdowns', $dropdowns);
  }

  /**
   * Update the specified Dropdowns in storage.
   */
  public function update($id, UpdateDropdownsRequest $request)
  {
    $dropdowns = $this->dropdownsRepository->find($id);

    if (empty($dropdowns)) {
      Flash::error('Dropdowns not found');

      return redirect(route('dropdowns.index'));
    }

    $dropdowns = $this->dropdownsRepository->save($request, $id);

    Flash::success('Dropdowns updated successfully.');

    return redirect(route('dropdowns.index'));
  }

  /**
   * Remove the specified Dropdowns from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $dropdowns = $this->dropdownsRepository->find($id);

    if (empty($dropdowns)) {
      Flash::error('Dropdowns not found');

      return redirect(route('dropdowns.index'));
    }

    $this->dropdownsRepository->delete($id);

    Flash::success('Dropdowns deleted successfully.');

    return redirect(route('dropdowns.index'));
  }
}
