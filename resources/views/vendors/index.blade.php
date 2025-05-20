@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Vendors</h3>
                </div>
                <div class="col-sm-6">
                  @can('vendor_create')
                  <a class="btn btn-primary float-right show-modal action-btn"
                     href="javascript:void(0);" data-action="{{ route('vendors.create') }}" data-title="Add New" data-size="lg">
                      Add New
                  </a>
                  @endcan
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('vendors.table')
        </div>
    </div>

@endsection
