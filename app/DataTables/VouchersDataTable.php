<?php

namespace App\DataTables;

use App\Helpers\Common;
use App\Helpers\General;
use App\Models\Vouchers;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class VouchersDataTable extends DataTable
{
  /**
   * Build DataTable class.
   *
   * @param mixed $query Results from query() method.
   * @return \Yajra\DataTables\DataTableAbstract
   */
  public function dataTable($query)
  {
    $dataTable = new EloquentDataTable($query);


    $dataTable->addColumn('id', function (Vouchers $row) {
      return $row->voucher_type . '-' . str_pad($row->id, '4', '0', STR_PAD_LEFT);
    })->filterColumn('id', function ($query, $keyword) {
      $query->whereRaw("CONCAT(voucher_type, '-', LPAD(id, 4, '0')) LIKE ?", ["%{$keyword}%"]);
    })->toJson();

    $dataTable->addColumn('trans_date', function (Vouchers $row) {
      return Common::DateFormat($row->trans_date);
    })->toJson();

    $dataTable->addColumn('billing_month', function (Vouchers $row) {
      return Common::MonthFormat($row->billing_month);
    })->toJson();

    $dataTable->addColumn('voucher_type', function (Vouchers $row) {
      return General::VoucherType($row->voucher_type);
    })->toJson();

    $dataTable->addColumn('Created_By', function (Vouchers $row) {
      return Common::UserName($row->Created_By);
    })->toJson();

    $dataTable->addColumn('Updated_By', function (Vouchers $row) {
      return Common::UserName($row->Updated_By);
    })->toJson();
    $dataTable->addColumn('attach_file', function (Vouchers $row) {
      $view_file = '';
      if ($row->attach_file) {
        $view_file = '  <a href="' . url('storage/vouchers/' . $row->attach_file) . '" class="no-print"  target="_blank">View</a>';
      }
      return $view_file;
    })->toJson();




    $dataTable->rawColumns(['role', 'action', 'attach_file']);
    $dataTable->addColumn('action', 'vouchers.datatables_actions');

    return $dataTable;

  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\Vouchers $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Vouchers $model)
  {
    return $model->newQuery()->orderByDesc('id');
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html()
  {
    return $this->builder()
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->addAction(['width' => '120px', 'printable' => false])
      ->parameters([
        'dom' => 'Bfrtip',
        'stateSave' => false,
        'order' => [[0, 'desc']],
        'pageLength' => 50,
        'responsive' => true,
        'buttons' => [
          // Enable Buttons as per your need
          //                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
          //                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
          //                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
          //                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
          //                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
        ],
        'language' => [
          'processing' => '<div class="loading-overlay"><div class="spinner-border text-primary" role="status"></div></div>'
        ],
      ]);
  }

  /**
   * Get columns.
   *
   * @return array
   */
  protected function getColumns()
  {
    return [
      'id' => ['searchable' => true],
      'trans_date' => ['title' => 'Date'],
      'billing_month' => ['title' => 'Month'],
      'voucher_type' => ['title' => 'Type'],
      'amount',
      'Created_By',
      'Updated_By',
      'attach_file' => ['title' => 'File']

    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'vouchers_datatable_' . time();
  }
}
