@extends('layouts.app')

@section('title','Bike History')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Bike History</h4>
                </div>
                <div class="col-sm-6">
                   {{--  <a class="btn btn-primary action-btn"
                       href="{{ route('bikeHistories.create') }}">
                        Add New
                    </a> --}}
                    <a class="btn btn-default action-btn"
                       href="{{url()->previous() }}">
                       <i class="fa fa-arrow-left"></i> &nbsp;Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('bike_histories.table')
        </div>
    </div>

@endsection
