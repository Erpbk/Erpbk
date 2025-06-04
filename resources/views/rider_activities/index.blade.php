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
            <form action="" method="get">
    <div class="row mb-3">
        <div class="col-md-3">
          {!! Form::select('rider_id', App\Models\Riders::dropdown(null), request('rider_id'), ['class' => 'form-select form-select-sm select2']) !!}
        </div>
        <div class="col-md-3">
            <input type="month" name="month" value="{{request('month')}}" class="form-control" placeholder="Billing Month">
        </div>
        <div class="col-md-3">
            <button id="filter" class="btn btn-primary">Filter</button>
        </div>
    </div>
  </form>
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
