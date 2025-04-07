@extends('layouts.app')

@section('title','Bikes')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Bikes</h3>
                </div>
                <div class="col-sm-6">
                  @can('item_create')
                    <a class="btn btn-primary action-btn show-modal"
                    href="javascript:void(0);" data-size="xl" data-title="New Bike" data-action="{{ route('bikes.create') }}">
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
            @include('bikes.table')
        </div>
    </div>

@endsection
