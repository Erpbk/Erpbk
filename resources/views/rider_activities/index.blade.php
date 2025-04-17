@extends('layouts.app')

@section('title','Rider Activities')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Rider Activities</h3>
                </div>
                <div class="col-sm-6">
                   {{--  <a class="btn btn-primary float-right"
                       href="{{ route('riderActivities.create') }}">
                        Add New
                    </a> --}}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('rider_activities.table')
        </div>
    </div>

@endsection
