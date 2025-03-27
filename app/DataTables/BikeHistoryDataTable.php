<?php

namespace App\DataTables;

use App\Helpers\Common;
use App\Models\BikeHistory;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class BikeHistoryDataTable extends DataTable
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

    $dataTable->addColumn('note_date', function (BikeHistory $row) {
      return Common::DateFormat($row->note_date);
    })->toJson();

    $dataTable->addColumn('bike_id', function (BikeHistory $row) {
      return @$row->bike->plate ?? '';
    })->toJson();

    $dataTable->addColumn('rider_id', function (BikeHistory $row) {
      return @$row->rider->name ?? '';
    })->toJson();


    return $dataTable->addColumn('action', 'bike_histories.datatables_actions');
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\BikeHistory $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(BikeHistory $model)
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
      'bike_id' => ['title' => 'Bike'],
      'rider_id' => ['title' => 'Rider'],
      'notes',
      'note_date',
      'warehouse',
      'contract'
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'bike_histories_datatable_' . time();
  }
}
