<?php

namespace App\DataTables;

use App\Helpers\General;
use App\Models\Riders;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RidersDataTable extends DataTable
{
  public function dataTable($query)
  {
    $dataTable = new EloquentDataTable($query);

    $dataTable
      ->addColumn('action', 'riders.datatables_actions')
      ->addColumn('status', function (Riders $rider) {
        $statusText = General::RiderStatus($rider->status);
        $badgeClass = ($rider->status == 1) ? 'bg-label-success' : 'bg-label-danger';
        return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
      })
      ->addColumn('job_status', function (Riders $rider) {
        $statusText = General::JobStatus($rider->job_status);
        $badgeClass = ($rider->job_status == 1) ? 'bg-label-success' : 'bg-label-info';
        return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
      })
      ->addColumn('name', function (Riders $rider) {
        return '<a href="' . route('riders.show', $rider->id) . '">' . $rider->name . '</a>';
      })
      ->addColumn('bike', function (Riders $rider) {
        return $rider->bikes->plate ?? '-';
      })
      ->addColumn('company_contact', function (Riders $rider) {
        if (!$rider->company_contact)
          return 'N/A';

        $phone = preg_replace('/[^0-9]/', '', $rider->company_contact);
        $whatsappNumber = '+971' . ltrim($phone, '0');

        return '<a href="https://wa.me/' . $whatsappNumber . '" target="_blank" class="text-success">
                        <i class="fab fa-whatsapp"></i> ' . $rider->company_contact . '
                    </a>';
      })
      // Status filter
      ->filterColumn('status', function ($query, $keyword) {
        $searchTerm = strtolower(trim($keyword));
        if ($searchTerm === 'active') {
          $query->where('status', 1);
        } elseif ($searchTerm === 'inactive') {
          $query->where('status', 3);
        } else {
          if (str_contains($searchTerm, 'inactive')) {
            $query->where('status', 3);
          } elseif (str_contains($searchTerm, 'active')) {
            $query->where('status', 1);
          }
        }
      })
      // Name filter (CRUCIAL FIX)
      ->filterColumn('name', function ($query, $keyword) {
        $query->where('name', 'LIKE', "%{$keyword}%");
      })
      // Contact filter
      ->filterColumn('company_contact', function ($query, $keyword) {
        $query->where('company_contact', 'LIKE', "%{$keyword}%");
      })
      // Fleet Supervisor filter
      ->filterColumn('fleet_supervisor', function ($query, $keyword) {
        $query->where('fleet_supervisor', 'LIKE', "%{$keyword}%");
      })
      // Emirate Hub filter
      ->filterColumn('emirate_hub', function ($query, $keyword) {
        $query->where('emirate_hub', 'LIKE', "%{$keyword}%");
      })
      ->rawColumns(['name', 'status', 'action', 'company_contact', 'job_status']);

    return $dataTable;
  }
  public function query(Riders $model)
  {
    return $model->newQuery()->select([
      'id',
      'rider_id',
      'name',
      'company_contact',
      'fleet_supervisor',
      'emirate_hub',
      'status',
      'job_status'
    ]);
  }

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
        'pageLength' => 100,
        'responsive' => true,
        'buttons' => [],
        'initComplete' => "function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var header = $(column.header());

                        if (header.text() === 'Status') {
                            var input = $('<input type=\"text\" placeholder=\"Search Status\" class=\"form-control form-control-sm\"/>')
                                .appendTo(header)
                                .on('keyup change clear', function () {
                                    column.search($(this).val()).draw();
                                });
                        }
                    });
                }"
      ]);
  }

  protected function getColumns()
  {
    return [
      [
        'data' => 'rider_id',
        'title' => 'Rider ID',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'name',
        'title' => 'Name',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'company_contact',
        'title' => 'Contact',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'fleet_supervisor',
        'title' => 'Fleet Supervisor',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'emirate_hub',
        'title' => 'Emirate Hub',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'bike',
        'title' => 'Bike',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'status',
        'title' => 'Status',
        'searchable' => true,
        'orderable' => true
      ],
      [
        'data' => 'job_status',
        'title' => 'Job Status',
        'searchable' => true,
        'orderable' => true
      ]
    ];
  }

  protected function filename(): string
  {
    return 'riders_datatable_' . time();
  }
}
