<?php

namespace App\Http\Controllers;

use App\DataTables\ItemsDataTable;
use App\Http\Requests\CreateItemsRequest;
use App\Http\Requests\UpdateItemsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Items;
use App\Models\RiderItemPrice;
use App\Repositories\ItemsRepository;
use Illuminate\Http\Request;
use Flash;

class ItemsController extends AppBaseController
{
  /** @var ItemsRepository $itemsRepository*/
  private $itemsRepository;

  public function __construct(ItemsRepository $itemsRepo)
  {
    $this->itemsRepository = $itemsRepo;
  }

  /**
   * Display a listing of the Items.
   */
  public function index(ItemsDataTable $itemsDataTable)
  {

    if (!auth()->user()->hasPermissionTo('item_view')) {
      abort(403, 'Unauthorized action.');
    }
    return $itemsDataTable->render('items.index');
  }


  /**
   * Show the form for creating a new Items.
   */
  public function create()
  {
    return view('items.create');
  }

  /**
   * Store a newly created Items in storage.
   */
  public function store(CreateItemsRequest $request)
  {
    $input = $request->all();

    $items = $this->itemsRepository->create($input);

    return response()->json(['message' => 'Item added successfully.']);
  }

  /**
   * Display the specified Items.
   */
  public function show($id)
  {
    $items = $this->itemsRepository->find($id);

    if (empty($items)) {
      Flash::error('Items not found');

      return redirect(route('items.index'));
    }

    return view('items.show')->with('items', $items);
  }

  /**
   * Show the form for editing the specified Items.
   */
  public function edit($id)
  {
    $items = $this->itemsRepository->find($id);

    if (empty($items)) {
      Flash::error('Items not found');

      return redirect(route('items.index'));
    }

    return view('items.edit')->with('items', $items);
  }

  /**
   * Update the specified Items in storage.
   */
  public function update($id, UpdateItemsRequest $request)
  {
    $items = $this->itemsRepository->find($id);

    if (empty($items)) {
      return response()->json(['errors' => ['error' => 'Item not found!']], 422);

    }

    $items = $this->itemsRepository->update($request->all(), $id);

    return response()->json(['message' => 'Item updated successfully.']);

  }

  /**
   * Remove the specified Items from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $items = $this->itemsRepository->find($id);

    if (empty($items)) {
      return response()->json(['errors' => ['error' => 'Item not found!']], 422);

    }

    $this->itemsRepository->delete($id);

    return response()->json(['message' => 'Item deleted successfully.']);

  }

  public function search_item_price($rider_id, $item_id)
  {
    $result = RiderItemPrice::where('item_id', $item_id)->where('RID', $rider_id)->first();
    if ($result && $result->price > 0) {
      return $result;
    } else {
      $result = Items::where('id', $item_id)->first();
      return $result;
    }
  }
  public function get_item_price($item_id)
  {

    $result = Items::where('id', $item_id)->first();
    return $result;

  }
}
