@extends('layouts.app')

@section('title','Files')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  @php
                  $type_name = '';
                    if(request('type') == 1){
                      $type_name = App\Models\Riders::find(request('type'))?->value('name')??'';
                    }
                    if(request('type') == 2){
                      $type_name = App\Models\Bikes::find(request('type'))?->value('plate')??'';
                    }

                  @endphp
                    <h3>{{$type_name}} Files</h3>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-default action-btn mx-2"
                  href="{{url()->previous() }}">
                  <i class="fa fa-arrow-left"></i> &nbsp;Back
               </a>
                  <a class="btn btn-primary show-modal action-btn"
                  href="javascript:void(0);" data-action="{{ route('files.create',['type_id'=>request('type_id')??1,'type'=>request('type')??1]) }}" data-size="sm" data-title="Upload File">
                   Upload File
               </a>

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('files.table')
        </div>
    </div>

@endsection
