@extends('layouts.app')

@section('title','RTA Fines')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Rta Fines</h3>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary action-btn show-modal"
                       href="javascript:void(0);" data-action="{{ route('rtaFines.create') }}" data-size="lg" data-title="New Fine">
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
            @include('rta_fines.table')
        </div>
    </div>

@endsection
