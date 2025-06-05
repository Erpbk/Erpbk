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

    <div class="row mb-3">
      @php

    $activity =  new App\Models\RiderActivities();
    $result = $activity->select('*');
    if(request('month')){
      $result->where(\DB::raw('DATE_FORMAT(date, "%Y-%m")'), '=', request('month') ?? date('Y-m'));
    }
    if(request('rider_id')){
      $result->where('rider_id',request('rider_id'));
    }

    //$activity->get();
@endphp
     <div class="col-12 col-md-12">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-0">Statistics</h5>
{{--           <small class="text-body-secondary">Based on Filter</small>
 --}}        </div>
        <div class="card-body d-flex align-items-end">
          <div class="w-100">
            <div class="row gy-3">
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="badge rounded bg-label-primary me-4 p-2"><i class="menu-icon tf-icons ti ti-shopping-cart"></i></div>
                  <div class="card-info">
                    <h5 class="mb-0">{{$result->sum('delivered_orders')+$result->sum('rejected_orders')}}</h5>
                    <small>Total Orders</small>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="badge rounded bg-label-info me-4 p-2"><i class="menu-icon tf-icons ti ti-motorbike"></i></div>
                  <div class="card-info">
                    <h5 class="mb-0">{{$result->sum('delivered_orders')}}</h5>
                    <small>Delivered</small>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="badge rounded bg-label-danger me-4 p-2"><i class="menu-icon tf-icons ti ti-bike-off"></i></div>
                  <div class="card-info">
                    <h5 class="mb-0">{{$result->sum('rejected_orders')}}</h5>
                    <small>Rejected</small>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="badge rounded bg-label-success me-4 p-2"><i class="menu-icon tf-icons ti ti-clock"></i></div>
                  <div class="card-info">
                    <h5 class="mb-0">{{$result->sum('login_hr')}}</h5>
                    <small>Login Hours</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
