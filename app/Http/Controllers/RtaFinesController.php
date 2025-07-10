<?php

namespace App\Http\Controllers;

use App\DataTables\RtaFinesDataTable;
use App\Helpers\Account;
use App\Helpers\Common;
use App\Http\Requests\CreateRtaFinesRequest;
use App\Http\Requests\UpdateRtaFinesRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Bikes;
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
  public function index(RtaFinesDataTable $rtaFinesDataTable)
  {
    if (!auth()->user()->hasPermissionTo('rtafine_view')) {
      abort(403, 'Unauthorized action.');
    }
    return $rtaFinesDataTable->render('rta_fines.index');
  }


  /**
   * Show the form for creating a new RtaFines.
   */
  public function create()
  {
    return view('rta_fines.create');
  }

  /**
   * Store a newly created RtaFines in storage.
   */
  public function store(CreateRtaFinesRequest $request)
  {
    $input = $request->all();
    $bike = Bikes::find($input['bike_id']);
    $trans_code = Account::trans_code();

    $input['billing_month'] = $input['billing_month'] . "-01";
    $input['rider_id'] = $bike->rider->id;
    $input['plate_no'] = $bike->plate;
    $input['trans_date'] = Carbon::today();
    $input['trans_code'] = $trans_code;
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
      return response()->json(['errors' => ['error' => 'RTA Fine not found!']], 422);
    }
    Transactions::where('trans_code', $rtaFines->trans_code)->delete();
    $this->rtaFinesRepository->delete($id);
    /* if ($rtaFines->transactions->count() > 0) {
      return response()->json(['errors' => ['error' => 'RTA Fine have transactions!']], 422);

    } else {
      $this->rtaFinesRepository->delete($id);
    } */
    return response()->json(['message' => 'RTA Fine deleted successfully.']);
  }
}
