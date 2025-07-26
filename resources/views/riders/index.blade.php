@extends('layouts.app')
@section('title','Riders')
@section('content')

<div style="display: none;" class="loading-overlay" id="loading-overlay"><div class="spinner-border text-primary" role="status"></div></div>
<section class="content-header">
   <div class="container-fluid">
        <h5>Fleet Supervisors</h5>
        <div class="d-flex flex-row flex-wrap mb-3">
            @php
                $dropdown = DB::table('dropdowns')->where('label', 'Fleet Supervisor')->first();
                $fleetSupervisors = $dropdown && $dropdown->values ? json_decode($dropdown->values, true) : [];
            @endphp

            @foreach($fleetSupervisors as $fleet)
                <div class="me-2 mb-2">
                    <button type="button"
                        class="btn btn-default fleet-filter-btn btn-sm @if($fleet == request('fleet_supervisor')) btn-primary @endif"
                        data-fleet_supervisor="{{ $fleet }}">
                        {{ $fleet }}<br/>
                        Active: {{ \App\Models\Riders::where('fleet_supervisor', $fleet)->where('status', 1)->count() }}
                        &nbsp;
                        Inactive: {{ \App\Models\Riders::where('fleet_supervisor', $fleet)->where('status', 3)->count() }}
                    </button>
                </div>
            @endforeach
        </div>
      <div class="row mb-2">
         <div class="col-sm-6">
            <h3>Riders</h3>
         </div>
         <div class="col-sm-6">
            <div class="d-flex justify-content-end" style="align-items: baseline;">
                @can('rider_create')
                <a class="btn btn-primary action-btn show-modal me-2"
                   href="{{ route('riders.create') }}">
                Add New
                </a>
                @endcan
                <div class="dropdown mx-3">
                    <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect bg-white" type="button" id="actiondropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="icon-base ti ti-dots icon-md text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actiondropdown" style="">
                        <a class="dropdown-item show-modal waves-effect"
                           href="javascript:void(0);" data-size="sm" data-title="Import Today Attendance" data-action="{{ route('rider.attendance_import') }}" >
                        Today Attendance
                        </a>
                        <a class="dropdown-item show-modal waves-effect"
                           href="javascript:void(0);" data-size="sm" data-title="Import Rider Activities" data-action="{{ route('rider.activities_import') }}" >
                        Import Activities
                        </a>
                        <a class="dropdown-item show-modal waves-effect"
                           href="{{ route('rider.exportRiders') }}" >
                        <i class="fa fa-file-excel"></i>&nbsp; Export Riders
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal modal-default filtetmodal fade" id="searchModal" tabindex="-1" data-bs-backdrop="static"role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-slide-top modal-full-top">
                  <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Filter Riders</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                     <div class="modal-body" id="searchTopbody">
                        <form id="filterForm" action="{{ route('riders.index') }}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="id">Rider Id</label>
                                    <input type="number" name="rider_id" class="form-control" placeholder="Filter By Rider ID"  value="{{ request('rider_id') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name">Rider Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Filter By Name" value="{{ request('name') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fleet_supervisor">Filter by Fleet SuperVisor</label>
                                    <select class="form-control " id="fleet_supervisor" name="fleet_supervisor">
                                        @php
                                        $supervisorRow = DB::table('dropdowns')
                                            ->where('label', 'Fleet Supervisor')
                                            ->whereNotNull('values')
                                            ->first();
                                        $fleetSupervisors = [];
                                        if ($supervisorRow && $supervisorRow->values) {
                                            $fleetSupervisors = json_decode($supervisorRow->values, true);
                                        }
                                        @endphp
                                        <option value="" selected>Select</option>
                                        @foreach($fleetSupervisors as $supervisor)
                                            <option value="{{ $supervisor }}" {{ request('fleet_supervisor') == $supervisor ? 'selected' : '' }}>{{ $supervisor }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="hub">Filter by HUB</label>
                                    <select class="form-control " id="hub" name="hub">
                                        @php
                                        $emirateHubs = DB::table('riders')
                                            ->whereNotNull('designation')
                                            ->where('designation', '!=', '')
                                            ->select('designation')
                                            ->distinct()
                                            ->pluck('designation');
                                        @endphp
                                        <option value="" selected>Select</option>
                                        @foreach($emirateHubs as $hub)
                                            <option value="{{ $hub }}" {{ request('hub') == $hub ? 'selected' : '' }}>{{ $hub }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="customer_id">Filter by Customer</label>
                                    <select class="form-control " id="customer_id" name="customer_id">
                                        @php
                                        $customerIds = DB::table('riders')
                                            ->whereNotNull('customer_id')
                                            ->where('customer_id', '!=', '')
                                            ->pluck('customer_id')
                                            ->unique();

                                        $customers = DB::table('customers')
                                            ->whereIn('id', $customerIds)
                                            ->select('id', 'name')
                                            ->get();
                                        @endphp
                                        <option value="" selected>Select</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bike">Bike Number</label>
                                    <input type="text" name="bike" value="{{ request('bike') }}" class="form-control" placeholder="Filter By Bike Number">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="designation">Filter by Designation</label>
                                    <select class="form-control " id="designation" name="designation">
                                        @php
                                        $emiratedesignation = DB::table('riders')
                                            ->whereNotNull('designation')
                                            ->where('designation', '!=', '')
                                            ->select('designation')
                                            ->distinct()
                                            ->pluck('designation');
                                        @endphp
                                        <option value="" selected>Select</option>
                                        @foreach($emiratedesignation as $des)
                                            <option value="{{ $des }}" {{ request('designation') == $des ? 'selected' : '' }}>{{ $des }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="attandence">Filter by Attandence</label>
                                    <select class="form-control " id="attendance" name="attendance">
                                        @php
                                        $attandence = DB::table('riders')
                                            ->whereNotNull('attendance')
                                            ->where('attendance', '!=', '')
                                            ->select('attendance')
                                            ->distinct()
                                            ->pluck('attendance');
                                        @endphp
                                        <option value="" selected>Select</option>
                                        @foreach($attandence as $att)
                                            <option value="{{ $att }}" {{ request('attandence') == $att ? 'selected' : '' }}>{{ $att }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">Filter by Status</label>
                                    <select class="form-control " id="status" name="status">
                                        <option value="" selected>Select</option>
                                        <option value="1"  {{ request('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>In Active</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group text-center">
                                    <button type="submit" class="btn btn-primary pull-right mt-3"><i class="fa fa-filter mx-2"></i> Filter Data</button>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="content px-0">
    @include('flash::message')
    <div class="card">
        <div class="card-body table-responsive px-2 py-0"  id="table-data">
            @include('riders.table', ['data' => $data])
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script type="text/javascript">
$(document).ready(function () {
    $('#fleet_supervisor').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Fleet SuperVisor",
    });
    $('#hub').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By HUB",
    });
    $('#customer_id').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Customer",
    });
    $('#designation').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Designation",
    });
    $('#status').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By status",
    });
    $('#attendance').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Attandence",
    });
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        $('#loading-overlay').show();
        $('#searchModal').modal('hide');
        const loaderStartTime = Date.now();
        let filteredFields = $(this).serializeArray().filter(field => field.name !== '_token' && field.value.trim() !== '');
        let formData = $.param(filteredFields);
        $.ajax({
            url: "{{ route('riders.index') }}",
            type: "GET",
            data: formData,
            success: function (data) {
                $('#table-data').html(data.tableData);
                let newUrl = "{{ route('riders.index') }}" + (formData ? '?' + formData : '');
                history.pushState(null, '', newUrl);
                if (filteredFields.length > 0) {
                    $('#clearFilterBtn').show();
                } else {
                    $('#clearFilterBtn').hide();
                }
                const elapsed = Date.now() - loaderStartTime;
                const remaining = 1000 - elapsed;
                setTimeout(() => $('#loading-overlay').hide(), remaining > 0 ? remaining : 0);
            },
            error: function (xhr, status, error) {
                console.error(error);
                const elapsed = Date.now() - loaderStartTime;
                const remaining = 1000 - elapsed;
                setTimeout(() => $('#loading-overlay').hide(), remaining > 0 ? remaining : 0);
            }
        });
    });
});
</script>
<script>
$(document).ready(function () {
    $('.fleet-filter-btn').on('click', function () {
        const fleet_supervisor = $(this).data('fleet_supervisor');
        const loaderStartTime = Date.now();
        $('#loading-overlay').show();
        $('.fleet-filter-btn').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');
        $.ajax({
            url: "{{ route('riders.index') }}",
            type: "GET",
            data: { fleet_supervisor: fleet_supervisor },
            success: function (data) {
                $('#table-data').html(data.tableData);
                let newUrl = "{{ route('riders.index') }}" + '?fleet_supervisor=' + encodeURIComponent(fleet_supervisor);
                history.pushState(null, '', newUrl);
                const elapsed = Date.now() - loaderStartTime;
                const remaining = 1000 - elapsed;
                setTimeout(() => $('#loading-overlay').hide(), remaining > 0 ? remaining : 0);
            },
            error: function () {
                console.error(error);
                const elapsed = Date.now() - loaderStartTime;
                const remaining = 1000 - elapsed;
                setTimeout(() => $('#loading-overlay').hide(), remaining > 0 ? remaining : 0);
            }
        });
    });
});
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#dataTableBuilder');
    const headers = table.querySelectorAll('th.sorting');
    const tbody = table.querySelector('tbody');

    headers.forEach((header, colIndex) => {
      header.addEventListener('click', () => {
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const isAsc = header.classList.contains('sorted-asc');

        // Clear previous sort classes
        headers.forEach(h => h.classList.remove('sorted-asc', 'sorted-desc'));

        // Add new sort direction
        header.classList.add(isAsc ? 'sorted-desc' : 'sorted-asc');

        // Sort logic
        rows.sort((a, b) => {
          let aText = a.children[colIndex]?.textContent.trim().toLowerCase();
          let bText = b.children[colIndex]?.textContent.trim().toLowerCase();

          const aVal = isNaN(aText) ? aText : parseFloat(aText);
          const bVal = isNaN(bText) ? bText : parseFloat(bText);

          if (aVal < bVal) return isAsc ? 1 : -1;
          if (aVal > bVal) return isAsc ? -1 : 1;
          return 0;
        });

        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
      });
    });
  });
</script>
@endsection