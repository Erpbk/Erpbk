@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card-body  table-responsive px-2">
    <form id="filterForm" method="GET" action="{{url('riders/riders')}}">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Rider ID</label>
                    <input placeholder="Search Rider By ID" type="text" class="form-control" name="id" value="{{ request('id') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Name</label>
                    <input placeholder="Search Rider By Name" type="text" class="form-control" name="name" value="{{ request('name') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Fleet Supervisors</label>
                    @php
                    // Get fleet supervisor list from dropdowns table
                    $supervisors = DB::table('dropdowns')
                        ->where('name', 'Fleet Supervisor')
                        ->value('values');

                    $supervisors = json_decode($supervisors, true); // Convert JSON array to PHP array

                    // Now loop through each supervisor and count their riders
                    $supervisorStats = collect($supervisors)->map(function ($name) {
                        $active = DB::table('riders')
                            ->where('fleet_supervisor', $name)
                            ->where('status', 1)
                            ->count();

                        $inactive = DB::table('riders')
                            ->where('fleet_supervisor', $name)
                            ->where('status', 3)
                            ->count();

                        return [
                            'name' => $name,
                            'active' => $active,
                            'inactive' => $inactive,
                        ];
                    });
                    @endphp
                    <select name="fleet_supervisors" id="fleet_supervisors" class="form-control">
                        <option value="">Select Supervisor</option>
                        @foreach($supervisorStats as $s)
                            <option value="{{ $s['name'] }}">
                                {{ $s['name'] }} (Active: {{ $s['active'] }}, Inactive: {{ $s['inactive'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>HUB</label>
                    @Php
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="" >Category</option>
                    </select> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Bike</label>
                    <input placeholder="Search Bike By Number" type="text" class="form-control" name="name" value="{{ request('name') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Status</option>
                        <option value="1" selected>Enable</option>
                       
                    </select> 
                </div>
            </div>
        </div>
    </form>
    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped dataTable']) !!}
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
