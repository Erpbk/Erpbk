@extends('layouts.app')
@section('title', 'Vouchers')

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Vouchers</h3>
                </div>
                <div class="col-sm-6">
{{--                     <button type="button" class="text-white btn btn-success btn-sm btn-flat float-right" data-toggle="modal" data-target="#excel-modal"><i class="fa fa-file-excel"></i> Import Excel</button>
 --}}
 @can('voucher_create')
 <a class="btn btn-info action-btn show-modal"
 href="javascript:void(0);" data-size="sm" data-title="Import Voucher" data-action="{{ route('voucher.import') }}" >
  Import Voucher
</a>
 @foreach(App\Helpers\General::VoucherType() as $key => $value)
 <a class="show-modal action-btn btn btn-primary" style="margin-right:5px;" href="javascript:void(0);" data-size="xl" data-title="Create {{$value}}"
 data-action="{{ route('vouchers.create',["vt"=>$key]) }}"><i class="fa fa-plus"></i>&nbsp;{{$value}}</a>
 @endforeach


 @endcan
                    {{-- <div class="dropdown action-btn">
                        <button class="btn btn-primary dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-plus"></i> Create Voucher
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach(App\Helpers\General::VoucherType() as $key => $value)
                            <a class="dropdown-item show-modal float-right" href="javascript:void(0);" data-size="xl" data-title="Create {{$value}}"
                            data-action="{{ route('vouchers.create',["vt"=>$key]) }}">{{$value}}</a>
                            @endforeach
                        </div>
                      </div> --}}
                    {{-- <a class="btn btn-primary float-right show-modal" href="javascript:void(0);" data-size="xl" data-title="Create Voucher"
                       data-action="{{ route('vouchers.create') }}">
                        Add New
                    </a> --}}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-0">


        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('vouchers.table')

                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

<script>
   /*  $(document).on("click", ".new_rider_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Riders::dropdown() !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});
$(document).on("click", ".new_expense_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Accounts::dropdown(null) !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});
$(document).on("click", ".new_bike_line", function () {
    $(".append-line").append(`
                        <div class="row">
                            <div class="form-group col-md-4">
                                <select name="id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Riders::dropdown() !!}
                                </select>
                        </div>

                        <div class="form-group col-md-2">
                                <select name="bike_id[]" class="form-control form-control-sm select2">
                                    <option value="">Select</option>
                                    {!! \App\Models\Bikes::dropdown() !!}
                                </select>
                        </div>

                <div class="form-group col-md-3">
                    <textarea name="narration[]" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                </div>

                <div class="form-group col-md-2">
                    <input type="number" step="any" name="amount[]" class="form-control form-control-sm dr_amount" placeholder="Amount" onchange="getTotal();">
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i> </button>
                </div>
            </div>
`);
$(".select2").select2();
});

//upload excelfile
$(document).ready(function (e) {
        $("#upload-excel").on("submit",function (e){
            e.preventDefault();
            $.ajax({
                url:"{{ route('voucher.import') }}",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    $("#upload-excel").find('.save_rec').hide();
                    $("#upload-excel").find('.loader').show();
                },
                success: function(data)
                {
                    toastr.success('Operation Successfully..');
                    $('.data-table').DataTable().ajax.reload();
                    $("#excel-modal").modal('hide');
                },error:function(ajaxcontent) {
                    if(ajaxcontent.responseJSON.success=='false'){
                        toastr.error(ajaxcontent.responseJSON.errors);
                        return false;
                    }
                    vali=ajaxcontent.responseJSON.errors;
                    $.each(vali, function( index, value ) {
                        $("#excel-form input[name~='" + index + "']").css('border', '1px solid red');
                        $("#excel-form select[name~='" + index + "']").parent().find('.select2-container--default .select2-selection--single').css('border','1px solid red');
                        toastr.error(value);
                    });
                },
                complete: function() {
                    $("#upload-excel").find('.save_rec').show();
                    $("#upload-excel").find('.loader').hide();
                },
            });
        });
    }); */
</script>
@endsection

