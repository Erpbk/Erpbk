<?php

namespace App\Http\Controllers;

use App\DataTables\FilesDataTable;
use App\Http\Requests\CreateFilesRequest;
use App\Http\Requests\UpdateFilesRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\FilesRepository;
use Illuminate\Http\Request;
use Flash;

class FilesController extends AppBaseController
{
  /** @var FilesRepository $filesRepository*/
  private $filesRepository;

  public function __construct(FilesRepository $filesRepo)
  {
    $this->filesRepository = $filesRepo;
  }

  /**
   * Display a listing of the Files.
   */
  public function index(FilesDataTable $filesDataTable)
  {
    abort(404);
    return $filesDataTable->render('files.index');
  }


  /**
   * Show the form for creating a new Files.
   */
  public function create()
  {
    return view('files.create');
  }

  /**
   * Store a newly created Files in storage.
   */
  public function store(CreateFilesRequest $request)
  {
    $input = $request->all();

    if (isset($input['file_name'])) {

      $extension = $input['file_name']->extension();
      $name = $input['type'] . '-' . $input['type_id'] . '-' . time() . '.' . $extension;
      $input['file_name']->storeAs('rider', $name);

      $input['file_name'] = $name;
      $input['file_type'] = $extension;
    }



    $files = $this->filesRepository->create($input);

    Flash::success('Files saved successfully.');

    return redirect(route('files.index'));
  }

  /**
   * Display the specified Files.
   */
  public function show($id)
  {
    $files = $this->filesRepository->find($id);

    if (empty($files)) {
      Flash::error('Files not found');

      return redirect(route('files.index'));
    }

    return view('files.show')->with('files', $files);
  }

  /**
   * Show the form for editing the specified Files.
   */
  public function edit($id)
  {
    $files = $this->filesRepository->find($id);

    if (empty($files)) {
      Flash::error('Files not found');

      return redirect(route('files.index'));
    }

    return view('files.edit')->with('files', $files);
  }

  /**
   * Update the specified Files in storage.
   */
  public function update($id, UpdateFilesRequest $request)
  {
    $files = $this->filesRepository->find($id);

    if (empty($files)) {
      Flash::error('Files not found');

      return redirect(route('files.index'));
    }

    $files = $this->filesRepository->update($request->all(), $id);

    Flash::success('Files updated successfully.');

    return redirect(route('files.index'));
  }

  /**
   * Remove the specified Files from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $files = $this->filesRepository->find($id);
    if (file_exists(storage_path('app/rider/' . $files->file_name))) {
      unlink(storage_path('app/rider/' . $files->file_name));

    }

    if (empty($files)) {
      Flash::error('Files not found');

      return redirect(route('files.index'));
    }

    $this->filesRepository->delete($id);

    Flash::success('Files deleted successfully.');

    return redirect(route('files.index'));
  }
}
