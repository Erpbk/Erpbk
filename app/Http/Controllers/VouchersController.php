<?php

namespace App\Http\Controllers;

use App\DataTables\VouchersDataTable;
use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Http\Requests\CreateVouchersRequest;
use App\Http\Requests\UpdateVouchersRequest;
use App\Http\Controllers\AppBaseController;
use App\Imports\ImportVoucher;
use App\Imports\VoucherImport;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\Rider;
use App\Models\RiderInvoice;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Vouchers;
use App\Services\TransactionService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Flash;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Yajra\DataTables\DataTables;

class VouchersController extends Controller
{
  /**
   * Display a listing of the Vouchers.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function index(VouchersDataTable $vouchersDataTable)
  {
    if (!auth()->user()->hasPermissionTo('voucher_view')) {
      abort(403, 'Unauthorized action.');
    }
    return $vouchersDataTable->render('vouchers.index');
  }

  /**
   * Show the form for creating a new Vouchers.
   *
   * @return Response
   */
  public function create()
  {
    return view('vouchers.create');
  }

  /**
   * Store a newly created Vouchers in storage.
   *
   * @param CreateVouchersRequest $request
   *
   * @return Response
   */
  public function store(Request $request, VoucherService $voucherService)
  {
    //dd($request->all());

    $request->billing_month = $request->billing_month . "-01";



    /** @var Vouchers $vouchers */
    if ($request->voucher_type == 'JV') {
      if (array_sum($request->dr_amount) != array_sum($request->cr_amount)) {

        return response()->json(['errors' => ['error' => 'Total debit and credit must be equal.']], 422);
      }
      $result = $voucherService->JournalVoucher($request);
    }
    /* if ($request->voucher_type == 5) {
      $result = $voucherService->InvoiceVoucher($request);
    }
    if ($request->voucher_type == 9) {
      $result = $voucherService->SimVoucher($request);
    } */
    /*  if ($request->voucher_type == 11) {
         $result = $voucherService->FuelVoucher($request);
     }
     if ($request->voucher_type == 10) {
         $result = $voucherService->RentVoucher($request);
     }
     if ($request->voucher_type == 8) {
         $result = $voucherService->RtaVoucher($request);
     } */
    if (in_array($request->voucher_type, ['LV'])) {
      $result = $voucherService->DefaultVoucher($request, 'debit');

    }
    /* if (in_array($request->voucher_type, [13])) {
      $result = $voucherService->DefaultVoucher($request, 2);

    } */

    //$vouchers = Vouchers::create($input);
    return $result;

  }

  /**
   * Display the specified Vouchers.
   *
   * @param int $id
   *
   * @return Response
   */
  public function show($id)
  {
    /** @var Vouchers $vouchers */
    /*  $result = Vouchers::where('trans_code', $id)->first();

     if ($result->voucher_type == 2 || $result->voucher_type == 3) {
       $data = Transactions::where('trans_code', $id)->get();
     } else {
       $data = Transactions::where('trans_code', $id)->get();

     } */
    $voucher = Vouchers::find($id);
    if (empty($voucher)) {
      Flash::error('Vouchers not found');

      return redirect(route('vouchers.index'));
    }

    return view('vouchers.show', compact('voucher'));
  }

  /**
   * Show the form for editing the specified Vouchers.
   *
   * @param int $id
   *
   * @return Response
   */
  public function edit($id)
  {
    /** @var Vouchers $vouchers */
    $vouchers = Vouchers::where('trans_code', $id)->first();
    if ($vouchers->voucher_type == 'JV') {
      $data = Transactions::where('trans_code', $id)->get();
    } else {
      $data = Transactions::where('trans_code', $id)->where('debit', '>', 0)->get();

    }

    if (empty($vouchers)) {
      Flash::error('Vouchers not found');

      return redirect(route('vouchers.index'));
    }

    return view('vouchers.edit', compact('vouchers', 'data'));
  }

  /**
   * Update the specified Vouchers in storage.
   *
   * @param int $id
   * @param UpdateVouchersRequest $request
   *
   * @return Response
   */
  public function update($id, Request $request, VoucherService $voucherService)
  {
    /** @var Vouchers $vouchers */
    $vouchers = Vouchers::find($id);

    $request->billing_month = $request->billing_month . "-01";

    /* if (array_sum($request->dr_amount) != array_sum($request->cr_amount)) {

      return response()->json(['errors' => ['error' => 'Total debit and credit must be equal.']], 422);
    } */

    if (empty($vouchers)) {
      Flash::error('Vouchers not found');

      return redirect(route('vouchers.index'));
    }
    if ($request->voucher_type == 'JV') {
      if (array_sum($request->dr_amount) != array_sum($request->cr_amount)) {

        return response()->json(['errors' => ['error' => 'Total debit and credit must be equal.']], 422);
      }
      $voucherService->JournalVoucher($request);
    }

    if (in_array($request->voucher_type, ['LV'])) {
      $result = $voucherService->DefaultVoucher($request, 'debit');

    }
    /*  if (in_array($request->voucher_type, [13])) {
       $result = $voucherService->DefaultVoucher($request, 2);

     } */
    /*   if ($request->voucher_type == 11) {
          $result = $voucherService->FuelVoucher($request);
      }
      if ($request->voucher_type == 10) {
          $result = $voucherService->RentVoucher($request);
      }
      if ($request->voucher_type == 8) {
          $result = $voucherService->RtaVoucher($request);
      } */
    /*  $vouchers->fill($request->all());
     $vouchers->save();

     Flash::success('Vouchers updated successfully.'); */

    return response()->json(['message' => 'Voucher updated successfully.']);
  }

  /**
   * Remove the specified Vouchers from storage.
   *
   * @param int $id
   *
   * @throws \Exception
   *
   * @return Response
   */
  public function destroy($id)
  {
    /** @var Vouchers $vouchers */
    Vouchers::where('trans_code', $id)->delete();
    $transactions = new TransactionService();
    $transactions->deleteTransaction($id);
    //Flash::success('Vouchers deleted successfully.');

    return redirect(route('vouchers.index'));
  }

  public static function GetInvoiceBalance()
  {
    $id = request('id');
    $type = request('type');
    $date = date('Y-m-d');
    $date = date('Y-m-d', strtotime($date . ' +1 day'));
    $invoice_balance = 0;
    $balance = 0;
    $inv_id = 0;
    if ($type == 5) {
      //Rider Invoice Balance
      $item = RiderInvoice::where('RID', $id)->first();
      if ($item) {
        $total = Transaction::where('SID', $item->id)->where('vt', 4)->sum('amount');
        $paid = Transaction::where('SID', $item->id)->where('vt', 2)->sum('amount');
        $balance = ($total) - ($paid);
        if ($balance > 0) {
          $invoice_balance += $balance;
        }
        $inv_id = $item->id;
      }
      $rider = Rider::find($id);
      $balance = Account::ob($date, $rider->account->id);
      $balance = Account::show_bal($balance);
      return ['invoice_balance' => $invoice_balance, 'inv_id' => $inv_id, 'balance' => $balance];
    }

  }

  public function fetch_invoices($id, $vt)
  {
    $date = date('Y-m-d');
    $date = date('Y-m-d', strtotime($date . ' +1 day'));
    if ($vt == 5) {
      $res = RiderInvoice::where('RID', $id)->whereDate('billing_month', '>=', '2024-04-01')->get();

      $htmlData = '';
      $rider_balance = 0;
      foreach ($res as $item) {
        /* $total = Transaction::where('SID', $item->id)->where('vt', 4)->sum('amount');
        $paid = Transaction::where('SID', $item->id)->where('vt', 2)->sum('amount');
        $balance = ($total) - ($paid); */
        $balance = Account::InvoiceBalance($item->id);
        if ($balance > 0) {
          $trans_acc_id = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $item->RID])->value('id');
          $rider_balance = Account::Monthly_ob($date, $trans_acc_id);
          $htmlData .= '
                <div class="row">
                <input type="hidden" name="inv_id[]" value="' . $item->id . '">
                <input type="hidden" name="id[]" value="' . $item->rider->id . '">
                <input type="hidden" name="inv_billing_month[]" value="' . $item->billing_month . '">

                        <div class="form-group col-md-7">
                            <label>Narration</label>
                            <textarea name="narration[]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">Payment to Rider against Invoice #' . $item->id . ' - Billing Month: ' . $item->billing_month . '</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Invoice Balance</label>
                            <input type="number" name="" class="form-control form-control-sm dr_amount" value="' . $balance . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Amount</label>
                            <input type="number" name="amount[]" step="any" class="form-control form-control-sm cr_amount" onkeyup="getTotal();" placeholder="Paid Amount">
                        </div>
                    </div>
                    <!--row-->
            ';
        }
      }
      //SELECT SUM(t.amount) FROM rider_invoices rv INNER JOIN transactions AS t ON rv.id=t.SID WHERE vt='4' and rv.VID=1
      return compact('htmlData', 'rider_balance');
    } else {
      $res = RiderInvoice::where('VID', $id)->get();
      $htmlData = '';
      $vendor_balance = 0;
      foreach ($res as $item) {
        /* $total = Transaction::where('SID', $item->id)->where('vt', 4)->sum('amount');
        $paid = Transaction::where('SID', $item->id)->where('vt', 2)->sum('amount');
        $balance = ($total) - ($paid); */
        $balance = Account::InvoiceBalance($item->id);
        if ($balance > 0) {
          $trans_acc_id = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $item->RID])->value('id');
          $rider_balance = Account::Monthly_ob($date, $trans_acc_id);
          $htmlData .= '
                <tr><td>
                <div class="row">
                <input type="hidden" name="inv_id[]" value="' . $item->id . '">
                <input type="hidden" name="inv_billing_month[]" value="' . $item->billing_month . '">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment To</label>
                            <input type="hidden" name="id[]" value="' . $item->rider->id . '">
                               ' . $item->rider->name . '(' . $item->rider->rider_id . ')

                        </div>
                        <div class="form-group col-md-4">
                            <label>Narration</label>
                            <textarea name="narration[]" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;">Payment to Rider against #' . $item->id . ' through vendor</textarea>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rider Balance</label>
                            <input type="text" name="" class="form-control form-control-sm" value="' . Account::show_bal($rider_balance) . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Invoice Balance</label>
                            <input type="number" step="any" name="" class="form-control form-control-sm" value="' . $balance . '" readonly placeholder="Balance Amount">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Amount</label>
                            <input type="number" step="any" name="amount[]" class="form-control form-control-sm amount" step="any" onkeyup="getTotal();" placeholder="Paid Amount">
                        </div>
                    </div>
                    </td>
                    <td width="100"><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger " style="margin-top:22px;"  value="Delete"></td>
                    </tr>
                    <!--row-->
            ';

        }
        $vendor_balance += $rider_balance;
      }
      //SELECT SUM(t.amount) FROM rider_invoices rv INNER JOIN transactions AS t ON rv.id=t.SID WHERE vt='4' and rv.VID=1
      $vendor_balance = Account::show_bal($vendor_balance);
      return compact('htmlData', 'vendor_balance');
    }
  }

  public function fileUpload(Request $request, $id)
  {
    $voucher = Vouchers::find($id);
    if (isset($request->attach_file)) {
      $photo = $request->attach_file;
      $docFile = $photo->store('public/vouchers');
      $data['attach_file'] = basename($docFile);

      $voucher->attach_file = $data['attach_file'];
      $voucher->save();


    }

    return view('vouchers.attach_file', compact('id', 'voucher'));


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
      Excel::import(new ImportVoucher(), $request->file('file'));
    }

    return view('vouchers.import');
  }
}
