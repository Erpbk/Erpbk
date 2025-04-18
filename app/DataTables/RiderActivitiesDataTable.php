<?php

namespace App\DataTables;

use App\Helpers\Common;
use App\Models\RiderActivities;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RiderActivitiesDataTable extends DataTable
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
    $dataTable->addColumn('date', function (RiderActivities $row) {
      return Common::DateFormat($row->date);
    });

    $dataTable->addColumn('rider_id', function (RiderActivities $row) {
      return $row->rider->name ?? '';
    });

    $dataTable->filterColumn('rider_id', function ($query, $keyword) {
      $query->whereHas('rider', function ($q) use ($keyword) {
        $q->where('name', 'like', "%{$keyword}%");
      });
    });

    $dataTable->addColumn('action', 'rider_activities.datatables_actions');
    return $dataTable;
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\RiderActivities $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(RiderActivities $model)
  {
    $query = $model->newQuery();
    if ($this->rider_id) {
      $query->where('rider_id', $this->rider_id);
      $query->where(\DB::raw('DATE_FORMAT(date, "%Y-%m")'), '=', request('month') ?? date('Y-m'));
    }
    //$query->whereMonth('date', date('m'))->whereYear('date', date('Y'));




    return $query->orderByDesc('date');
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
      //->addAction(['width' => '120px', 'printable' => false])
      ->parameters([
        'dom' => 'Bfrtip',
        'stateSave' => false,
        'ordering' => false,
        'pageLength' => 50,
        'responsive' => true,
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
      'date' => ['title' => 'Date'],
      'd_rider_id' => ['title' => 'ID'],
      'rider_id' => ['title' => 'Name'],
      'payout_type' => ['title' => 'Payout'],
      'delivered_orders' => ['title' => 'Delivered'],
      /*  'ontime_orders' => ['title' => 'Ontime'], */
      'ontime_orders_percentage' => ['title' => 'Ontime%'],
      /*  'avg_time' => ['title' => 'AVG'], */
      'rejected_orders' => ['title' => 'Rejected'],
      /* 'rejected_orders_percentage' => ['title' => 'Rejected%'], */
      'login_hr' => ['title' => 'HR'],
      'delivery_rating' => ['title' => 'Rating'],
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'rider_activities_datatable_' . time();
  }
}
