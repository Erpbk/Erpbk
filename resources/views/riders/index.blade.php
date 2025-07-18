@extends('layouts.app')

@section('title','Riders')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <h5>Fleet Supervisors</h5>
          <div class="d-flex flex-row">
           
            @foreach($fleets as $fleet)
            <div class="mb-2">
              @php
                  $riders = app\Models\Riders::select('status')->where('fleet_supervisor',$fleet)->get();
                  $inactive = $riders->where('status',3)->count();
                  $active = $riders->where('status',1)->count();
              @endphp
            <a href="{{route('riders.index',['fleet'=>$fleet])}}" class="btn btn-default @if($fleet==request('fleet')) btn-primary @endif btn-sm text-left">{{$fleet}}<br/>Active: {{$active}} &nbsp; Inactive: {{$inactive}}</a>
          </div>
          @endforeach
          </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Riders</h3>

                </div>
                <div class="col-sm-6">
                  <a class="btn btn-info action-btn show-modal"
                  href="javascript:void(0);" data-size="sm" data-title="Import Rider Activities" data-action="{{ route('rider.activities_import') }}" >
                   Import Activities
               </a>

                  <a class="btn btn-success action-btn show-modal me-2"
                  href="javascript:void(0);" data-size="sm" data-title="Import Today Attendance" data-action="{{ route('rider.attendance_import') }}" >
                   Today Attendance
               </a>
                  @can('rider_create')
                    <a class="btn btn-primary action-btn show-modal me-2"
                       href="{{ route('riders.create') }}">
                        Add New
                    </a>
                    @endcan
                    <a class="btn btn-success action-btn me-2"
                    href="{{ route('rider.exportRiders') }}" >
                     <i class="fa fa-file-excel"></i>&nbsp; Export Riders
                 </a>

                </div>
            </div>
        </div>
    </section>

    <div class="content px-0">

        <div class="card">

            @include('riders.table')
        </div>
    </div>

@endsection
