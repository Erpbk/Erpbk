<?php

namespace App\Http\Controllers;

use App\DataTables\RtaFinesDataTable;
use App\Helpers\Account;
use App\Helpers\Common;
use App\Http\Requests\CreateRtaFinesRequest;
use App\Http\Requests\UpdateRtaFinesRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Bikes;
use App\Models\Riders;
use App\Models\RtaFines;
use App\Models\Accounts;
use App\Models\Transactions;
use App\Repositories\RtaFinesRepository;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;

class RtaFinesController extends AppBaseController
{
  /** @var RtaFinesRepository $rtaFinesRepository*/
  private $rtaFinesRepository;

  public function __construct(RtaFinesRepository $rtaFinesRepo)
  {
    $this->rtaFinesRepository = $rtaFinesRepo;
  }

  /**
   * Display a listing of the RtaFines.
   */
  public function accountcreate(Request $request)
  {
      $exists = Accounts::where('name', $request->name)->exists();
      if ($exists) {
          Flash::success('Account with this name already exists.');
      }

      // Get the parent account
      $parent = Accounts::where('name', 'RTA Fines')->first();
      if (!$parent) {
          Flash::success('Parent account "RTA Fines" not found.');
      }
      // Create new account
      $newdata = new Accounts();
      $newdata->name = $request->name;
      $newdata->account_tax = $request->account_tax;
      $newdata->parent_id = $parent->id;
      $newdata->account_type = 'Liability';

      $newdata->status = 1;
      $newdata->save();
      $newdata->account_code = 'ACCT-' . str_pad($newdata->id, 5, '0', STR_PAD_LEFT);
      $newdata->save();

      Flash::success('Account added successfully.');
      return redirect()->back();
  }

  public function editaccount(Request $request)
  {
      $parent = Accounts::where('name', 'RTA Fines')->first();
      if (!$parent) {
          Flash::error('Parent account "RTA Fines" not found.');
      }
      $newdata = Accounts::find($request->id);
      $newdata->name = $request->name;
      $newdata->account_tax = $request->account_tax;
      $newdata->parent_id = $parent->id;
      $newdata->account_type = 'Liability';
      $newdata->status = 1;
      $newdata->save();
      $newdata->account_code = 'ACCT-' . str_pad($newdata->id, 5, '0', STR_PAD_LEFT);
      $newdata->save();

      Flash::success('Account Updated successfully.');
      return redirect()->back();
  }
  public function deleteaccount($id)
  {
    rtaFines::where('rta_account_id' , $id)->delete();
    Accounts::where('id' , $id)->delete();
    Flash::success('Account Deleted successfully.');
      return redirect()->back();
  }
  public function index(Request $request)
  {
    if (!auth()->user()->hasPermissionTo('rtafine_view')) {
      abort(403, 'Unauthorized action.');
    }
    $parent = Accounts::where('name', 'RTA Fines')->first();
    $perPage = request()->input('per_page', 50);
    $perPage = is_numeric($perPage) ? (int) $perPage : 50;
    $perPage = $perPage > 0 ? $perPage : 50;
    $query = Accounts::query()
        ->orderBy('id', 'asc')->where('parent_id' , $parent->id);
    if ($request->has('account_code') && !empty($request->account_code)) {
        $query->where('account_code', 'like', '%' . $request->account_code . '%');
    }
    if ($request->has('name') && !empty($request->name)) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->has('account_type') && !empty($request->account_type)) {
        $query->where('account_type',$request->account_type);
    }
    $data = $query->paginate($perPage);
    if ($request->ajax()) {
        $tableData = view('rta_fines.account_table', [
            'data' => $data,
        ])->render();
        $paginationLinks = $data->links('pagination')->render();
        return response()->json([
            'tableData' => $tableData,
            'paginationLinks' => $paginationLinks,
        ]);
    }
    return view('rta_fines.account_index', [
        'data' => $data,
    ]);
  }
  public function tickets(Request $request, $id)
  {
    if (!auth()->user()->hasPermissionTo('rtafine_view')) {
      abort(403, 'Unauthorized action.');
    }
    $perPage = request()->input('per_page', 50);
    $perPage = is_numeric($perPage) ? (int) $perPage : 50;
    $perPage = $perPage > 0 ? $perPage : 50;
    $query = RtaFines::query()
        ->orderBy('id', 'asc')->where('rta_account_id' , $id)->where('status' , 'unpaid');
    if ($request->has('ticket_no') && !empty($request->ticket_no)) {
        $query->where('ticket_no', 'like', '%' . $request->ticket_no . '%');
    }
     if ($request->filled('trip_date_from')) {
        $fromDate = \Carbon\Carbon::createFromFormat('Y-d-m', $request->trip_date_from);
        $query->where('trip_date', '>=', $fromDate);
    }

    if ($request->filled('trip_date_to')) {
        $toDate = \Carbon\Carbon::createFromFormat('Y-d-m', $request->trip_date_to);
        $query->where('trip_date', '<=', $toDate);
    }
    if ($request->has('trans_code') && !empty($request->trans_code)) {
        $query->where('trans_code',$request->trans_code);
    }
    if ($request->has('rider_id') && !empty($request->rider_id)) {
        $query->where('rider_id',$request->rider_id);
    }
    if ($request->has('bike_id') && !empty($request->bike_id)) {
        $query->where('bike_id',$request->bike_id);
    }
    $data = $query->paginate($perPage);
    $account = Accounts::where('id' , $id)->first();
    if ($request->ajax()) {
        $tableData = view('rta_fines.table', [
            'data' => $data,
            'account' => $account,
        ])->render();
        $paginationLinks = $data->links('pagination')->render();
        return response()->json([
            'tableData' => $tableData,
            'paginationLinks' => $paginationLinks,
        ]);
    }
    return view('rta_fines.index', [
        'data' => $data,
        'account' => $account,
    ]);
  }
  public function payfine($id)
  {
    $updatestatus  = RtaFines::find($id);
    if($updatestatus->status == 'paid')
    {
        $updatestatus->status = 'unpaid';
    }else{
        $updatestatus->status = 'paid';
    }
    $updatestatus->save();
    Flash::success('Status Updated Successfully');
    return redirect()->back();
  }
  public function viewvoucher($id)
  {
    $data = rtaFines::where('id' , $id)->first();
    $accounts = Accounts::where('id' , $data->rta_account_id)->first();
    return view('rta_fines.viewvoucher' , compact('data' , 'accounts'));
  }

  /**
   * Show the form for creating a new RtaFines.
   */
  public function create($id)
  {
    $data = Accounts::where('id' , $id)->first();
    return view('rta_fines.create' , compact('data'));
  }
  /**
   * Store a newly created RtaFines in storage.
   */
  public function store(CreateRtaFinesRequest $request)
  {
    $input = $request->all();
    $bike = Bikes::find($input['bike_id']);
    $trans_code = Account::trans_code();
    $path = $request->file('attachment')->store('fines/files', 'public');
    $input['billing_month'] = $input['billing_month'] . "-01";
    $input['rider_id'] = $input['debit_account'];
    $input['attachment'] = $request->file('attachment')->getClientOriginalName();
    $input['attachment_path'] = $path;
    $input['plate_no'] = $bike->plate;
    $input['trans_date'] = Carbon::today();
    $input['trans_code'] = $trans_code;
    $input['status'] = 'unpaid';
    $input['admin_fee'] = Common::getSetting('rta_admin_fee');
    $input['total_amount'] = $input['admin_fee'] + $input['amount'];

    $rtaFines = $this->rtaFinesRepository->create($input);

    /* Create transactions */
    $TransactionService = new TransactionService();
    $transactionData = [
      'account_id' => $bike->rider->account_id,
      'reference_id' => $rtaFines->id,
      'reference_type' => 'RTA',
      'trans_code' => $trans_code,
      'trans_date' => $rtaFines->trans_date,
      'narration' => $rtaFines->detail,
      'debit' => $rtaFines->total_amount,
      //'credit' => $data['credit'] ?? 0,
      'billing_month' => $rtaFines->billing_month ?? date('Y-m-01'),
    ];
    $TransactionService->recordTransaction($transactionData);

    $transactionData = [
      'account_id' => $rtaFines->rta_account_id,
      'reference_id' => $rtaFines->id,
      'reference_type' => 'RTA',
      'trans_code' => $trans_code,
      'trans_date' => $rtaFines->trans_date,
      'narration' => $rtaFines->detail,
      'credit' => $rtaFines->total_amount,
      //'credit' => $data['credit'] ?? 0,
      'billing_month' => $rtaFines->billing_month ?? date('Y-m-01'),
    ];
    $TransactionService->recordTransaction($transactionData);


    return response()->json(['message' => 'RTA Fine added successfully.']);

  }
  public function fileUpload(Request $request, $id)
  {
      $fines = rtaFines::find($id);

      if ($request->hasFile('attachment_path')) {
          $photo = $request->file('attachment_path');

          // Store file in storage/app/public/fines/files
          $docFile = $photo->store('fines/files', 'public');

          // Save original name and stored path
          $fines->attachment = $photo->getClientOriginalName(); 
          $fines->attachment_path = $docFile;

          $fines->save();
      }

      return view('rta_fines.attach_file', compact('id', 'fines'));
  }

  /**
   * Display the specified RtaFines.
   */
  public function show($id)
  {
    $rtaFines = $this->rtaFinesRepository->find($id);

    if (empty($rtaFines)) {
      Flash::error('Rta Fines not found');

      return redirect(route('rtaFines.index'));
    }

    return view('rta_fines.show')->with('rtaFines', $rtaFines);
  }

  /**
   * Show the form for editing the specified RtaFines.
   */
  public function edit($id)
  {
    $rtaFines = $this->rtaFinesRepository->find($id);

    if (empty($rtaFines)) {
      Flash::error('Rta Fines not found');

      return redirect(route('rtaFines.index'));
    }

    return view('rta_fines.edit')->with('rtaFines', $rtaFines);
  }

  /**
   * Update the specified RtaFines in storage.
   */
  public function update($id, UpdateRtaFinesRequest $request)
  {
    $rtaFines = $this->rtaFinesRepository->find($id);

    if (empty($rtaFines)) {
      Flash::error('Rta Fines not found');

      return redirect(route('rtaFines.index'));
    }

    $rtaFines = $this->rtaFinesRepository->update($request->all(), $id);

    Flash::success('Rta Fines updated successfully.');

    return redirect(route('rtaFines.index'));
  }

  /**
   * Remove the specified RtaFines from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $rtaFines = $this->rtaFinesRepository->find($id);

    //$banks = $this->banksRepository->find($id);

    if (empty($rtaFines)) {
      Flash::error('Rta Fines not found');
    }
    Transactions::where('trans_code', $rtaFines->trans_code)->delete();
    $this->rtaFinesRepository->delete($id);
    /* if ($rtaFines->transactions->count() > 0) {
      return response()->json(['errors' => ['error' => 'RTA Fine have transactions!']], 422);

    } else {
      $this->rtaFinesRepository->delete($id);
    } */
    Flash::success('RTA Fine deleted successfully.');
    return redirect()->back();
  }

  public function getrider($id)
  {
      $bike = Bikes::find($id); // cleaner way
      if (!$bike || !$bike->rider_id) {
          echo '<option value="">There is no rider against this bike</option>';
          return;
      }

      $riders = Riders::where('id', $bike->rider_id)->get();

      if ($riders->isEmpty()) {
          echo '<option value="">There is no rider against this bike</option>';
      } else {
          echo '<option value="">Select Rider</option>';
          foreach ($riders as $r) {
              echo '<option value="'.$r->id.'">'.$r->name.'</option>';
          }
      }
  }

  
}
