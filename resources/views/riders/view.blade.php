@extends('layouts.app')
@section('title', 'Rider Profile')

@section('content')
<style>
.myform .required:after {
  content: " *";
    color: red;
    font-weight: 200;
}
@media print{
    body .content{
        font-size: 18px !important;

    }
}
</style>
@php
if(is_numeric(request()->segment(3))){
  session()->put('rider_id',request()->segment(3));
  $riders = App\Models\Riders::find(request()->segment(3));
  }
  if(isset($riders)){
      $result = $riders->toArray();
    }
@endphp
<div class="row" style="">
  <div class="col-xl-3 col-md-3 col-lg-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-6">
      <div class="card-body pt-12">
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            @isset($result)
            <form action="{{url('riders/picture_upload/'.$result['id'])}}" method="POST" enctype="multipart/form-data" id="formajax2">
                @endisset
                @csrf
            @php
                        if(@$result['image_name']){
                            $image_name = url('storage2/profile/'.$result['image_name']);//Storage::url('app/profile/'.$result['image_name']);
                        }else{
                            $image_name = asset('uploads/default.png');
                        }
                    @endphp
                        <img src="{{ $image_name}}" id="output" width="270"  class="profile-user-img img-fluid" />

                        @isset($result)
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-default me-2 mb-3 mt-3" tabindex="0">
                            <span class="d-none d-sm-block">Change Photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="image_name" class="account-file-input " hidden accept="image/png, image/jpeg" onchange="loadFile(event)" />
                          </label>
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                        @endisset
                    </form>

            <div class="user-info text-center">
              <h6>@isset($result){{$result['name']??'not-set'}}@endisset</h6>
              <span class="badge bg-label-primary">@isset($result){{$result['designation']??'not-set'}}@endisset</span>

            </div>
          </div>
        </div>
      {{--   <h5 class="pb-4 border-bottom mb-4"></h5>

        <div class="d-flex flex-row gap-3">
          <div class="d-flex align-items-center me-1 gap-4">
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded">
                <i class="ti ti-checkbox ti-lg"></i>
              </div>
            </div>
            <div>
              <h5 class="mb-0">1.23k</h5>
              <span>Rides</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4">
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded">
                <i class="ti ti-briefcase ti-lg"></i>
              </div>
            </div>
            <div>
              <h5 class="mb-0">568</h5>
              <span>Project</span>
            </div>
          </div>
        </div>--}}
        <h5 class="pb-4 border-bottom mb-4"></h5>
        <div class="info-container">
          <ul class="list-unstyled mb-6">
            <script>

                        var loadFile = function (event) {
                          var image = document.getElementById("output");
                          image.src = URL.createObjectURL(event.target.files[0]);
                        };


                        </script>
                      {{-- <div class="text-center">
                         <img class="profile-user-img img-fluid" src="https://placehold.co/400X400" alt="User profile picture">
                      </div> --}}


                      <ul class="p-0 mb-3" >
                        <li class="list-group-item pb-1" >
                            <b>Rider ID:</b> <span class="float-right">@isset($result){{$result['rider_id']??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item pb-1">
                            <b>Bike Number:</b> <span class="float-right">@isset($result){{$riders->bikes->plate??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item pb-1">
                            <b>Date Of Joining:</b> <span class="float-right">@isset($result){{App\Helpers\General::DateFormat($result['doj'])??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item pb-1 @if(@$result['status'] == 1) text-success @else text-danger @endif">
                            <b>Status:</b> <span class="float-right">@isset($result){{App\Helpers\General::RiderStatus($result['status'])??'not-set'}}@endisset</span>
                         </li>
                         <li class="list-group-item pb-1">
                          <b>Shift:</b> <span class="float-right">@isset($result){{$result['shift']??'not-set'}}@endisset</span>
                       </li>
                       <li class="list-group-item pb-1">
                        <b>Attendance:</b> <span class="float-right">@isset($result){{$result['attendance']??'not-set'}}@endisset</span>

                     </li>
                        {{--  <li class="list-group-item pb-1 @if(@$result['job_status'] == 1) text-success @else text-danger @endif" >
                            <b>Job Status:</b> <span class="float-right">
                                @isset($result)<a href="javascript:void(0);" data-action="{{url('riders/job_status/'.$result['id'])}}" data-title="Change Job Status" class="btn btn-light btn-sm show-modal">Change Status</a>@endisset
                                 @isset($result['job_status']){{App\Helpers\General::JobStatus($result['job_status'])??'not-set'}}@endisset</span>
                               @isset($rider->jobstatus)
                                <hr/>
                                <b>Reason:</b>
                                {{$rider->jobstatus->reason??'not-set'}}
                                @endisset
                         </li> --}}
                         <li class="list-group-item pb-1 ">
                            <b>Balance:</b> <span class="float-right">{{-- @isset($rider->account->id){{App\Helpers\Account::show_bal(App\Helpers\Account::Monthly_ob(date('y-m-d'), $rider->account->id))??'not-set'}}@endisset --}}</span>
                         </li>
                      </ul>

          </ul>
          <div class="d-flex justify-content-center">
            @isset($result)
            <a href="{{route('riders.edit', $result['id'])}}" class="btn btn-outline-primary btn-sm waves-effect waves-light btn-block me-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>

            <a href="javascript:void();" data-action="{{route('rider.sendemail', $result['id'])}}" data-size="md"
data-title="{{$result['name'] . ' (' . $result['rider_id'] }}')" class="btn btn-outline-warning btn-sm show-modal text-nowrap"><i class="fas fa-envelope"></i>&nbsp;Send Email</a>

<a href="javascript:void(0);" data-action="{{url('riders/job_status/' . $result['id']) }}" data-size="md" data-title="Add Timeline" class="btn btn-outline-success btn-sm text-nowrap show-modal mx-1"><i class="fas fa-chart-bar"></i>&nbsp;Add Timeline</a>
            @endisset
{{--             <a href="javascript:void(0);" class="btn btn-default btn-block no-print" onclick="window.print();"><i class="fa fa-print"></i>&nbsp;<b>Print</b></a>
 --}}
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card -->

  </div>
  <div class="col-xl-9 col-md-9 col-lg-7 order-0 order-md-1">
    <div class="nav-align-top">
      <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-3 row-gap-2">
        <li class="nav-item"><a class="nav-link @if(is_numeric(request()->segment(2)) ||request()->segment(2)=='create' ) active @endif" href="@isset($result['id']){{route('riders.show',$result['id'])}}@else#@endif"><i class="ti ti-user-check ti-sm me-1_5"></i>Account</a></li>
        @isset($result)
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='timeline') active @endif" href="{{route('rider.timeline',$result['id'])}}"><i class="ti ti-timeline ti-sm me-1_5"></i>Timeline</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='files') active @endif" href="{{route('rider.files',$result['id'])}}"><i class="ti ti-file-upload ti-sm me-1_5"></i>Files</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='invoices') active @endif" href="{{route('rider.invoices',$result['id'])}}"><i class="ti ti-file-invoice ti-sm me-1_5"></i>Invoices</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='ledger') active @endif" href="{{route('rider.ledger',$result['id'])}}"><i class="ti ti-file ti-sm me-1_5"></i>Ledger</a></li>
        {{-- <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='attendance') active @endif" href="{{route('rider.attendance',$result['id'])}}"><i class="ti ti-calendar-check ti-sm me-1_5"></i>Attendance</a></li> --}}
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='activities') active @endif" href="{{route('rider.activities',$result['id'])}}"><i class="ti ti-motorbike ti-sm me-1_5"></i>Activities</a></li>
        <li class="nav-item"><a class="nav-link @if(request()->segment(2) =='emails') active @endif" href="{{route('rider.emails',$result['id'])}}"><i class="ti ti-mail ti-sm me-1_5"></i>Emails</a></li>
        @endisset

      </ul>
    </div>

    <div class="card mb-5" id="cardBody" style="height:660px !important;overflow: auto;">
      @yield('page_content')
    </div>



  </div>
</div>



@endsection
