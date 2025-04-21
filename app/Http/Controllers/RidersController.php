<?php

namespace App\Http\Controllers;

use App\DataTables\LedgerDataTable;
use App\DataTables\RiderActivitiesDataTable;
use App\DataTables\RiderAttendanceDataTable;
use App\DataTables\RiderInvoicesDataTable;
use App\DataTables\RidersDataTable;
use App\Helpers\Account;
use App\Helpers\General;
use App\Helpers\HeadAccount;
use App\Http\Requests\CreateAccountsRequest;
use App\Http\Requests\CreateRidersRequest;
use App\Http\Requests\UpdateRidersRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Accounts;
use App\Models\RiderItemPrice;
use App\Models\JobStatus;
use App\Models\Riders;
use App\Models\Files;
use App\Models\Transactions;
use App\Repositories\RidersRepository;
use Illuminate\Http\Request;
use Flash;

class RidersController extends AppBaseController
{
  /** @var RidersRepository $ridersRepository*/
  private $ridersRepository;

  public function __construct(RidersRepository $ridersRepo)
  {
    $this->ridersRepository = $ridersRepo;
  }

  /**
   * Display a listing of the Riders.
   */
  public function index(RidersDataTable $ridersDataTable)
  {

    if (!auth()->user()->hasPermissionTo('rider_view')) {
      abort(403, 'Unauthorized action.');
    }

    return $ridersDataTable->render('riders.index');
  }


  /**
   * Show the form for creating a new Riders.
   */
  public function create()
  {
    return view('riders.create');
  }

  /**
   * Store a newly created Riders in storage.
   */
  public function store(CreateRidersRequest $request)
  {
    $input = $request->all();
    $items = $request->get('items');

    $riders = $this->ridersRepository->create($input);
    if ($riders) {

      /* $parentAccount = Accounts::firstOrCreate(
        ['name' => 'Riders', 'account_type' => 'Liability', 'parent_id' => null],
        ['name' => 'Riders', 'account_type' => 'Liability', 'account_code' => Account::code()]
      ); */

      $account = new Accounts();
      $account->account_code = 'RD' . str_pad($riders->rider_id, 4, "0", STR_PAD_LEFT);
      $account->name = $riders->name;
      $account->account_type = 'Liability';
      $account->ref_name = 'Rider';
      $account->parent_id = HeadAccount::RIDER;
      $account->ref_id = $riders->id;
      $account->save();

      if ($items) {
        foreach ($items['id'] as $key => $val) {
          if ($items['id'][$key] != 0) {
            $riderItemPrice = new RiderItemPrice();
            $riderItemPrice->item_id = $items['id'][$key];
            $riderItemPrice->price = isset($item['price'][$key]) ? $items['price'][$key] : 0;
            $riderItemPrice->RID = $riders->id;
            $riderItemPrice->save();
          }
        }
      }

      $riders->account_id = $account->id;
      $riders->save();

    }
    return response()->json(['message' => 'Rider created successfully.']);
  }

  /**
   * Display the specified Riders.
   */
  public function show($id)
  {
    $riders = $this->ridersRepository->find($id);
    // $rider_items = $rider->items;
    $result = $riders->toArray();
    $job_status = JobStatus::where('RID', $id)->orderByDesc('id')->get();

    return view('riders.show_fields', compact('result', 'riders', 'job_status'));

  }

  /**
   * Show the form for editing the specified Riders.
   */
  public function edit($id)
  {
    // $riders = $this->ridersRepository->find($id);
    $riders = $this->ridersRepository->getRiderWithItemsRelations($id);

    if (empty($riders)) {
      Flash::error('Riders not found');

      return redirect(route('riders.index'));
    }

    return view('riders.edit')->with('riders', $riders);
  }

  /**
   * Update the specified Riders in storage.
   */
  public function update($id, UpdateRidersRequest $request)
  {
    $riders = $this->ridersRepository->getRiderWithItemsRelations($id);
    // $items = $riders->items;
    $items = $request->get('items');
    if (empty($riders)) {
      Flash::error('Riders not found');

      return redirect(route('riders.index'));
    }

    $riders = $this->ridersRepository->update($request->all(), $id);
    if ($riders) {

      $riders->account->name = $riders->name;
      $riders->account->account_code = 'RD' . str_pad($riders->rider_id, 4, "0", STR_PAD_LEFT);
      $riders->account->save();

      if ($request->items) {
        RiderItemPrice::where('RID', $id)->delete();
        $items = $request->items;
        foreach ($items['id'] as $key => $val) {

          $riderItemPrice = new RiderItemPrice();
          $riderItemPrice->item_id = $items['id'][$key];
          $riderItemPrice->price = $items['price'][$key] ?? 0;
          $riderItemPrice->RID = $riders->id;
          $riderItemPrice->save();

        }
      }
    }
    /*     Flash::success('Riders updated successfully.');
     */
    return redirect(route('riders.index'));
  }

  /**
   * Remove the specified Riders from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $riders = $this->ridersRepository->find($id);

    if (empty($riders)) {
      Flash::error('Riders not found');

      return redirect(route('riders.index'));
    }

    //$this->ridersRepository->delete($id);

    Flash::success('Riders deleted successfully.');

    return redirect(route('riders.index'));
  }

  public function getItems(Request $request)
  {
    /* $random = rand(0,999);
    $row = '<td>';
    $row .= '<select name="items['.$random.'][item_id]" class="form-control form-control-sm""><option value="0">Select Item</option>';
        $items = Item::all();
        foreach($items as $item){
            $row .='<option value="'.$item->id.'">'.$item->item_name.' - '.$item->pirce.'</option>';
        }
    $row .='</select></td>';
    $row .='<td><label>Price: &nbsp;</label>';
    $row .='<input type="number" step="any" name="items['.$random.'][price]" /></td>';

    $row .='<td><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td>'; */

    $item = Item::find($request->item_id);
    $row = '<td width="250"><label>' . $item->item_name . '(Price: ' . $item->pirce . ')</label></td>
      <td width="130"><input type="number" name="items[' . $item->id . ']" id="item-' . $item->id . '" value="' . $request->item_price . '" step="any" class="form-control form-control-sm" /></td>';

    $row .= '<td width="300"><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td>';
    return $row;
  }
  /*
   *
   */

  public function document($rider_id)
  {
    if (request()->post()) {

      foreach (request('documents') as $document) {

        if ($document['expiry_date']) {
          $data = [];
          if (isset($document['file_name'])) {

            $extension = $document['file_name']->extension();
            $name = $document['type'] . '-' . $rider_id . '-' . time() . '.' . $extension;
            $document['file_name']->storeAs('rider', $name);

            $data['file_name'] = $name;
            $data['file_type'] = $extension;
          }

          $data['type_id'] = $rider_id;
          $data['type'] = $document['type'];
          $data['expiry_date'] = $document['expiry_date'];

          $condition = [
            'type' => $document['type'],
            'type_id' => $rider_id
          ];

          Files::updateOrCreate($condition, $data);
        } else {
          if (isset($document['file_name'])) {
            return response()->json(['errors' => ['error' => General::file_types($document['type']) . ' expiry date must be selected.']], 422);
          }
        }
      }
      return 1;
    }

    $files = Files::where('type_id', $rider_id)->get();
    $rider = Riders::find($rider_id);

    return view('riders.document', compact('files', 'rider'));
  }
  public function timeline($id)
  {
    $riders = Riders::find($id);
    $job_status = JobStatus::where('RID', $id)->orderByDesc('id')->get();
    return view('riders.timeline', compact('riders', 'job_status'));
  }

  public function contract($id)
  {
    $rider = Riders::find($id);

    return view('riders.contract', compact('rider'));
  }
  public function contract_upload(Request $request, $id)
  {
    if (isset($request->contract)) {

      $doc = $request->contract;
      $extension = $doc->extension();
      $name = time() . '.' . $extension;
      $doc->storeAs('contract', $name);

      $rider = Riders::find($request->id);
      $rider->contract = $name;
      $rider->save();

      return redirect(route('riders.index'))->with('success', $rider->name . '( ' . $rider->rider_id . ' ) Contract uploaded.');
    } else {
      $rider = Riders::find($id);
      return view('riders.contract-modal', compact('rider'));
    }
  }

  public function picture_upload(Request $request, $id)
  {
    if (isset($request->image_name)) {

      $image_name = $request->image_name;
      $extension = $image_name->extension();
      $name = time() . '.' . $extension;
      $image_name->storeAs('profile', $name);

      $rider = Riders::find($request->id);
      $rider->image_name = $name;
      $rider->save();

      return response()->json(['message' => 'Profile picture uploaded successfully.']); //redirect(url('rider'))->with('success', $rider->name . '( ' . $rider->rider_id . ' ) Profile Picture uploaded.');
    }
  }

  public function job_status($id, Request $request)
  {
    $rider = Riders::find($id);

    if ($request->isMethod('post')) {
      $input = $request->all();
      $input['RID'] = $id;
      $input['status_by'] = auth()->user()->id;
      JobStatus::create($input);
      /*  $rider = Riders::find($id);
       $rider->job_status = $input['job_status'];
       $rider->save(); */
      return "Timeline added successfully";
    }
    return view('riders.job_status-modal', compact('rider'));
  }

  public function updateRider()
  {
    $riders = Riders::all();

    $parentAccount = Accounts::firstOrCreate(
      ['name' => 'Riders', 'account_type' => 'Liability', 'parent_id' => null],
      ['name' => 'Riders', 'account_type' => 'Liability', 'account_code' => Account::code()]
    );

    foreach ($riders as $rider) {

      $account = new Accounts();
      $account->account_code = 'RD' . str_pad($rider->rider_id, 4, "0", STR_PAD_LEFT);
      $account->name = $rider->name;
      $account->account_type = 'Liability';
      $account->ref_name = 'Rider';
      $account->parent_id = $parentAccount->id;
      $account->ref_id = $rider->id;
      $account->save();

      $rider->account_id = $account->id;
      $rider->save();
    }

  }

  public function ledger($rider_id, LedgerDataTable $ledgerDataTable)
  {
    $rider = Riders::find($rider_id);
    $files = Transactions::where('account_id', $rider->account_id)->get();
    $account_id = $rider->account_id;

    return $ledgerDataTable->with(['account_id' => $account_id])->render('riders.ledger', compact('files', 'rider'));
  }

  public function attendance($rider_id, RiderAttendanceDataTable $riderAttendanceDataTable)
  {
    return $riderAttendanceDataTable->with(['rider_id' => $rider_id])->render('riders.attendance');
  }
  public function activities($rider_id, RiderActivitiesDataTable $riderActivitiesDataTable)
  {
    return $riderActivitiesDataTable->with(['rider_id' => $rider_id])->render('riders.activities');
  }
  public function invoices($rider_id, RiderInvoicesDataTable $riderInvoicesDataTable)
  {
    return $riderInvoicesDataTable->with(['rider_id' => $rider_id])->render('riders.invoices');
  }

}
