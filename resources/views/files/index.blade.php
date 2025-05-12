@extends('layouts.app')

@section('title','Files')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Files</h3>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary show-modal action-btn"
                       href="javascript:void(0);" data-action="{{ route('files.create','rider_id',request()->segment(2)) }}" data-size="sm" data-title="Upload Document">
                        Add New
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
