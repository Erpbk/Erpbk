@extends('layouts.app')

@section('title','Traffic Fine Details')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Traffic Fine Ticket  #{{ $data->ticket_no }}</h3>
                </div>
                <div class="col-sm-6">
                    <div class="modal modal-default filtetmodal fade" id="createaccount" tabindex="-1" data-bs-backdrop="static"role="dialog" aria-hidden="true">
                       <div class="modal-dialog modal-lg modal-slide-top modal-full-top">
                          <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                             <div class="modal-body" id="searchTopbody">
                                <form action="{{ route('rtaFines.accountcreate') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Your Account Name" required>
                                        </div>
                                        <div class="col-md-12 form-group text-center">
                                            <button type="submit" class="btn btn-primary pull-right mt-3"><i class="fa fa-filter mx-2"></i> Submit</button>
                                        </div>
                                    </div>
                                </form>
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
        <div class="row">
            <div class="col-xl-3 col-md-3 col-lg-5 order-1 order-md-0">
                <div class="card mb-6">
                    <div class="card-body pt-12">
                        <div class="user-avatar-section">
                            <div class=" d-flex align-items-center flex-column">
                                <div class="user-info text-center">
                                    <h6>{{ $accounts->name }}</h6>
                                </div>
                            </div>
                        </div>
                        <h5 class="pb-4 border-bottom mb-4"></h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-6">
                                <ul class="p-0 mb-3">
                                    <li class="list-group-item pb-1">
                                        <b>Account Code:</b> <span class="float-right">{{ $accounts->account_code }}</span>
                                    </li>

                                    <li class="list-group-item pb-1">
                                        <b>Account Type:</b> <span class="float-right">{{ $accounts->account_type }}</span>
                                    </li>
                                    <li class="list-group-item pb-1">
                                        <b>Status:</b> <span class="float-right">
                                        @if($accounts->status == '1')
                                        <span class="badge  bg-success">Active</span></span>
                                        @else
                                        <span class="badge  bg-success">Active</span></span>
                                        @endif
                                    </li>
                                </ul>
                            </ul>
                        </div>
                  </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-9 col-lg-7 order-0 order-md-1">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-3 row-gap-2">

                        <li class="nav-item"><a class="nav-link  active  " href="https://erpbk.com/public/bank/files/11"><i class="ti ti-file-upload ti-sm me-1_5"></i>Files</a></li>
                        <li class="nav-item"><a class="nav-link " href="https://erpbk.com/public/bank/ledger/11"><i class="ti ti-file ti-sm me-1_5"></i>Ledger</a></li>
                  </ul>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Ticket Number</th>
                                        <td class="text-end">{{ $data->ticket_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rider name</th>
                                        @php
                                        $bikes = DB::table('bikes')->where('id' , $data->bike_id)->first();
                                            $rider = DB::table('riders')->where('id', $bikes->rider_id)->first();
                                        @endphp
                                        <td class="text-end">{{ $rider->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bike Number</th>
                                        <td class="text-end">{{ $data->plate_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Credit Account</th>
                                        <td class="text-end">{{ DB::Table('accounts')->where('id' , $data->rta_account_id)->first()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <td class="text-end">{{ $data->trip_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction Time</th>
                                        <td class="text-end">{{ $data->trip_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Service Charges</th>
                                        <td class="text-end">AED {{ number_format($accounts->account_tax , 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fine</th>
                                        <td class="text-end">AED {{ number_format($data->amount , 2)  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        @php
                                            $total
                                        @endphp
                                        <td class="text-end">AED {{ number_format($accounts->account_tax + $data->amount, 2)  }}</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td class="text-end"><a href="{{ route('rtaFines.payfine' , $data->id) }}" class="btn btn-action btn-primary">Proceed to Pay Fine</a> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('page-script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
function confirmDelete(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    })
}
$(document).ready(function () {
    $('#parent_id').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Add Parent Account",
    });
    $('#rider_id').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Rider",
    });
    $('#bike_id').select2({
        dropdownParent: $('#searchTopbody'),
        placeholder: "Filter By Bike Plate",
    });
});
</script>