@extends('layouts.app')

@section('title','Riders')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Riders</h3>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-success action-btn show-modal"
                  href="javascript:void(0);" data-size="sm" data-title="Import Rider Attendance" data-action="{{ route('rider.attendance_import') }}" >
                   Import Attendance
               </a>
                  @can('rider_create')
                    <a class="btn btn-primary action-btn show-modal me-3"
                       href="{{ route('riders.create') }}">
                        Add New
                    </a>
                    @endcan


                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <div class="card">
            @include('riders.table')
        </div>
    </div>

@endsection
