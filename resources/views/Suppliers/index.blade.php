@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Suppliers</h3>
                </div>
                <div class="col-sm-6">
                    @can('supplier_create')
                    <a class="btn btn-primary action-btn show-modal me-2"
   href="javascript:void(0);" data-size="lg" data-title="New Supplier" data-action="{{ route('suppliers.create') }}">
    Add New
</a>
                    @endcan
                </div>
            </div>
        </div>
    </section>

    <div class="content px-0">
        <div class="card">
            @include('suppliers.table')
        </div>
    </div>
@endsection