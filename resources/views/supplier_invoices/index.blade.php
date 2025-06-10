@extends('layouts.app')

@section('title','Supplier Invoices')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>supplier Invoices</h3>
                </div>
                <div class="col-sm-6">
                   
                    <a class="btn btn-success action-btn show-modal"
                       href="javascript:void(0);" data-size="sm" data-title="Import supplier Invoices" data-action="{{ route('supplier_invoices.import') }}" >
                        Import Invoices
                    </a>
                   

                 
                    <a class="btn btn-primary action-btn show-modal me-2"
   href="javascript:void(0);" data-size="xl" data-title="Add Supplier Invoice" data-action="{{ route('supplierInvoices.create') }}">
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
            @include('supplier_invoices.table')
        </div>
    </div>

@endsection
