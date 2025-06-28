<?php

namespace App\DataTables;

use App\Models\Customers;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CustomersDataTable extends DataTable
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

    $dataTable->addColumn('action', 'customers.datatables_actions');

    $dataTable->addColumn('name', function (Customers $customers) {
      $name = '<a href="' . route('customer.files', $customers->id) . '">' . $customers->name . '</a><br/>';
      return $name;
    });
    $dataTable
      ->addColumn('status', function (Customers $customers) {
        if ($customers->status == 1) {
          return '<span class="badge  bg-success">Active</span>';
        } else {
          return '<span class="badge  bg-danger">Inactive</span>';
        }
      })
      ->toJson();

    $dataTable->rawColumns(['action', 'name', 'status']);
    return $dataTable;
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\Customers $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Customers $model)
  {
    return $model->newQuery();
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
        'stateSave' => true,
        'order' => [[0, 'desc']],
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
      'name',
      'contact_number',
      'status'
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'customers_datatable_' . time();
  }
}
