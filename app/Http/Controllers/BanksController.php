<?php

namespace App\Http\Controllers;

use App\DataTables\BanksDataTable;
use App\DataTables\FilesDataTable;
use App\DataTables\LedgerDataTable;
use App\Helpers\Account;
use App\Helpers\General;
use App\Http\Requests\CreateBanksRequest;
use App\Http\Requests\UpdateBanksRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Accounts;
use App\Models\Banks;
use App\Models\Files;
use App\Models\Transactions;
use App\Repositories\BanksRepository;
use Illuminate\Http\Request;
use Flash;

class BanksController extends AppBaseController
{
  /** @var BanksRepository $banksRepository*/
  private $banksRepository;

  public function __construct(BanksRepository $banksRepo)
  {
    $this->banksRepository = $banksRepo;
  }

  /**
   * Display a listing of the Banks.
   */
  public function index(BanksDataTable $banksDataTable)
  {

    if (!auth()->user()->hasPermissionTo('bank_view')) {
      abort(403, 'Unauthorized action.');
    }
    return $banksDataTable->render('banks.index');
  }


  /**
   * Show the form for creating a new Banks.
   */
  public function create()
  {
    return view('banks.create');
  }

  /**
   * Store a newly created Banks in storage.
   */
  public function store(CreateBanksRequest $request)
  {
    $input = $request->all();

    $banks = $this->banksRepository->create($input);

    //Adding Account and setting reference

    $parentAccount = Accounts::firstOrCreate(
      ['name' => 'Bank', 'account_type' => 'Asset', 'parent_id' => null],
      ['name' => 'Bank', 'account_type' => 'Asset', 'account_code' => Account::code()]
    );

    $account = new Accounts();
    $account->account_code = 'BK' . str_pad($banks->id, 4, "0", STR_PAD_LEFT);
    $account->account_type = 'Asset';
    $account->name = $banks->name;
    $account->parent_id = $parentAccount->id;
    $account->ref_name = 'Bank';
    $account->ref_id = $banks->id;
    $account->status = $banks->status;
    $account->save();

    $banks->account_id = $account->id;
    $banks->save();

    return response()->json(['message' => 'Bank added successfully.']);
  }

  /**
   * Display the specified Banks.
   */
  public function show($id)
  {
    $banks = $this->banksRepository->find($id);

    if (empty($banks)) {
      Flash::error('Banks not found');

      return redirect(route('banks.index'));
    }

    return view('banks.show')->with('banks', $banks);
  }

  /**
   * Show the form for editing the specified Banks.
   */
  public function edit($id)
  {
    $banks = $this->banksRepository->find($id);

    if (empty($banks)) {
      Flash::error('Banks not found');

      return redirect(route('banks.index'));
    }

    return view('banks.edit')->with('banks', $banks);
  }

  /**
   * Update the specified Banks in storage.
   */
  public function update($id, UpdateBanksRequest $request)
  {
    $banks = $this->banksRepository->find($id);

    if (empty($banks)) {

      return response()->json(['errors' => ['error' => 'Bank not found!']], 422);
    }

    $banks = $this->banksRepository->update($request->all(), $id);
    $banks->account->status = $banks->status;
    $banks->save();

    return response()->json(['message' => 'Bank updated successfully.']);
  }

  /**
   * Remove the specified Banks from storage.
   *
   * @throws \Exception
   */
  public function destroy($id)
  {
    $banks = $this->banksRepository->find($id);

    if (empty($banks)) {
      return response()->json(['errors' => ['error' => 'Bank not found!']], 422);
    }


    if ($banks->transactions->count() > 0) {
      return response()->json(['errors' => ['error' => 'Bank have transactions!']], 422);

    } else {

      if ($banks->account) {
        $banks->account->delete();
      }
      $this->banksRepository->delete($id);

    }


    return response()->json(['message' => 'Bank deleted successfully.']);

  }

  public function ledger($id, LedgerDataTable $ledgerDataTable)
  {
    $banks = Banks::find($id);
    $files = Transactions::where('account_id', $banks->account_id)->get();
    $account_id = $banks->account_id;

    return $ledgerDataTable->with(['account_id' => $account_id])->render('banks.bank_ledger', compact('files', 'banks'));
  }

  public function files($id, FilesDataTable $filesDataTable)
  {
    return $filesDataTable->with(['type_id' => $id, 'type' => 'bank'])->render('banks.document');
  }
}
