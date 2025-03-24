<?php

namespace App\Repositories;

use App\Helpers\Account;
use App\Helpers\HeadAccount;
use App\Models\RiderInvoiceItem;
use App\Models\RiderInvoices;
use App\Models\Transactions;
use App\Repositories\BaseRepository;
use App\Services\TransactionService;

class RiderInvoicesRepository extends BaseRepository
{
  protected $fieldSearchable = [
    'inv_date',
    'rider_id',
    'vendor_id',
    'zone',
    'login_hours',
    'working_days',
    'perfect_attendance',
    'rejection',
    'performance',
    'off',
    'month_invoice',
    'descriptions',
    'total_amount',
    'billing_month',
    'gaurantee',
    'notes'
  ];

  public function getFieldsSearchable(): array
  {
    return $this->fieldSearchable;
  }

  public function model(): string
  {
    return RiderInvoices::class;
  }

  public function record($request, $id = null)
  {
    //$request = $request->except(['_method', '_token']);
    //$input = $request->all();

    $input = $request->except(['item_id', '_method', '_token', 'qty', 'rate', 'amount', 'discount', 'tax']);

    $input['billing_month'] = $request->billing_month . "-01";
    if ($id) {

      $invoice = RiderInvoices::where('id', $id)->first();
      $invoice->update($input);
      RiderInvoiceItem::where('inv_id', $id)->delete();

    } else {
      $invoice = RiderInvoices::create($input);
    }

    foreach ($request['item_id'] as $key => $val) {

      if (!empty($request['item_id'][$key]) && $request['amount'][$key] > 0) {

        $dta['item_id'] = $request['item_id'][$key];
        $dta['qty'] = $request['qty'][$key] ?? 0;
        $dta['rate'] = $request['rate'][$key];
        $dta['amount'] = $request['amount'][$key];
        $dta['tax'] = $request['tax'][$key];
        $dta['discount'] = $request['discount'][$key];
        $dta['inv_id'] = $invoice->id;
        RiderInvoiceItem::create($dta);

      }

    }

    $trans_code = Account::trans_code();
    $transactionService = new TransactionService();

    if ($id) {
      $trans_code = Transactions::where('reference_type', 'Invoice')->where('reference_id', $id)->value('trans_code');
      $transactionService->deleteTransaction($trans_code);
    }

    $transactionData = [
      'account_id' => $invoice->rider->account_id,
      'reference_id' => $invoice->id,
      'reference_type' => 'Invoice',
      'trans_code' => $trans_code,
      'trans_date' => $invoice->inv_date,
      'narration' => "Rider Invoice #" . $invoice->id . ' - ' . $invoice->descriptions,
      //'debit' => $request['dr_amount'][$key] ?? 0,
      'credit' => $invoice->total_amount ?? 0,
      'billing_month' => $invoice->billing_month,
    ];
    $transactionService->recordTransaction($transactionData);


    $transactionData = [
      'account_id' => HeadAccount::SALARY_ACCOUNT, //Salary Account asked to set by Adnan 08-03-2025
      'reference_id' => $invoice->id,
      'reference_type' => 'Invoice',
      'trans_code' => $trans_code,
      'trans_date' => $invoice->inv_date,
      'narration' => "Rider Invoice #" . $invoice->id . ' - ' . $invoice->descriptions,
      'debit' => $invoice->total_amount ?? 0,
      'billing_month' => $invoice->billing_month,
    ];
    $transactionService->recordTransaction($transactionData);


    return $invoice;

  }


}
