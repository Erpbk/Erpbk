@extends('riders.view')
@section('page_content')
<div class="card border">
  <div class="card-header"><b>Personal Information</b></div>
      <div class="card-body">
              <div class="row">
                  <div class="col-md-3 form-group col-3">

                      <label class="required">Rider ID </label>
                      <p>{{$result['rider_id']}}</p>
                  </div>
                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>Rider Name </label>
                      <p>{{@$result['name']}}</p>
                  </div>
                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>Rider Contact</label>
                      <p>{{@$result['personal_contact']}}</p>
                  </div>

                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>Company Contact</label>
                      <p>{{@$result['company_contact']}}</p>
                  </div>
                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>Personal Gmail ID  </label>
                      <p>{{@$result['personal_email']}}</p>
                  </div>
                  <!--col-->
                  {{-- <div class="col-md-3 form-group">
                      <label>Email</label>
                      <input type="text" class="form-control form-control-sm" name="email" placeholder="Person Email">
                  </div> --}}
                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>Nationality </label>
                      <p>{{$rider?->country?->name}}</p>

                  </div>
                  <div class="col-md-3 form-group col-3">
                      <label>Ethnicity</label>
                      <p>{{@$result['ethnicity']}}</p>

                  </div>
                  <!--col-->
                  <div class="col-md-3 form-group col-3">
                      <label>DOB </label>
                      <p>{{@App\Helpers\General::DateFormat($result['dob'])}}</p>
                  </div>
              </div>

  </div>
</div>

<div class="card border">
  <div class="card-header"><b>Job Detail</b></div>
  <div class="card-body">
      <div class="row">
          <div class="col-md-3 form-group col-3">
              <label>Date of Joining </label>
              <p>{{@App\Helpers\General::DateFormat($result['doj'])}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>Project </label>
              <p>{{@$rider->project->name}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
              <label>Designation </label>
              <p>{{@$result['designation']}}</p>


          </div>


          <!--col-->
          {{-- <div class="col-md-3 form-group">
              <label>NF DID</label>
              <input type="text" class="form-control form-control-sm" name="NFDID" placeholder="NF DID">
          </div> --}}
          <!--col-->
          <div class="col-md-3 form-group col-3">
              <label>CDM Deposit ID</label>
              <p>{{@$result['cdm_deposit_id']}}</p>
          </div>
          <!--col-->

          <!--col-->

          <!--col-->

          <!--col-->

          <!--col-->
          {{-- <div class="col-md-3 form-group">
              <label>Dept</label>
              <input type="text" class="form-control form-control-sm dat" name="DEPT" placeholder="Dept">
          </div> --}}
          <!--col-->

          <!--col-->
          <div class="col-md-3 form-group col-3">
              <label>Branded Plate Number</label>
              <p>{{@$result['branded_plate_no']}}</p>
          </div>
          <!--col-->
          <div class="col-md-3 form-group col-3">
              <label>Fleet Supervisor </label>
              <p>{{@$result['fleet_supervisor']}}</p>

          </div>

          <div class="col-md-3 form-group col-3">
              <label>Status </label>
              <p>{{App\Helpers\General::RiderStatus(@$result['status'])}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
              <label>Salary Model </label>
              <p>{{@$result['salary_model']}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
              <label>Rider Reference </label>
              <p>{{@$result['rider_reference']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>WPS</label>
              <p>{{@$result['wps']}}</p>

          </div>
          <div class="col-md-6 form-group col-6">
              <label>C3 Card</label>
              <p>{{$result['c3_card']}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
                      <label>Vendor </label>
                      <p>{{@$rider->vendor->name}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
              <label>Customer </label>
              <p>{{@$rider->customer->name}}</p>

          </div>
          <div class="col-md-12 form-group col-12">
              <label>Other Details</label>
              <p>{{@$result['other_details']}}</p>
          </div>
      </div>
      </div>
  </div>


<div class="card border">
  <div class="card-header"><b>Visa & Registerations</b></div>
  <div class="card-body">
      <div class="row">
          <div class="col-md-3 form-group col-3">
              <label>Visa Sponsor</label>
              <p>{{@$result['visa_sponsor']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>Occupation on Visa </label>
              <p>{{@$result['visa_occupation']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>Visa Status</label>
              <p>{{@$result['visa_status']}}</p>

          </div>
          <div class="col-md-3 form-group col-3">
              <label>Person Code</label>
              <p>{{@$result['person_code']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>Labor Card Number</label>
              <p>{{@$result['labor_card_number']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label @if(strtotime($result['labor_card_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Labor Card Expiry </label>
              <p @if(strtotime($result['labor_card_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@App\Helpers\General::DateFormat($result['labor_card_expiry'])}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label>Insurance</label>
              <p>{{@$result['insurance']}}</p>
          </div>
          <div class="col-md-3 form-group col-3">
              <label @if(strtotime($result['insurance_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Insurance Expiry</label>
              <p @if(strtotime($result['insurance_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@App\Helpers\General::DateFormat($result['insurance_expiry'])}}</p>
          </div>


              <div class="col-md-3 form-group col-3">
                  <label>Emirate (Hub) </label>
                  <p>{{@$result['emirate_hub']}}</p>

              </div>
              <!--col-->
              <div class="col-md-3 form-group col-3">
                  <label>Emirate ID </label>
                  <p>{{@$result['emirate_id']}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label @if(strtotime($result['emirate_exp']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>EID EXP Date </label>
                  <p @if(strtotime($result['emirate_exp']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@App\Helpers\General::DateFormat($result['emirate_exp'])}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label>Licence No </label>
                  <p>{{@$result['license_no']}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label @if(strtotime($result['license_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Licence Expiry </label>
                  <p @if(strtotime($result['license_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@App\Helpers\General::DateFormat($result['license_expiry'])}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label>Passport </label>
                  <p>{{@$result['passport']}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label @if(strtotime($result['passport_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>Passport Expiry </label>
                  <p @if(strtotime($result['passport_expiry']) <= strtotime(date('Y-m-d'))) style="color:red;" @endif>{{@App\Helpers\General::DateFormat($result['passport_expiry'])}}</p>
              </div>
              <div class="col-md-3 form-group col-3">
                  <label>Passport Handover </label>
                  <p>{{@$result['passport_handover']}}</p>

              </div>
              {{-- <div class="col-md-3 form-group">
                  <label>NOON No. </label>
                  <input type="text" class="form-control form-control-sm" name="noon_no" placeholder="Noon No.">
              </div> --}}

              <div class="col-md-3 form-group col-3">
                  <label>Mashreq ID</label>
                  <p>{{@$result['mashreq_id']}}</p>
              </div>
      </div>
  </div>
</div>

 <div class="card border">
  <div class="card-header"><b>Items & Prices</b></div>
  <div class="card-body">


  <div class="row border" >
      <table  class="table border" style="border-radius:10px;">
<thead>
<tr class="">
<th>Items</th>
<th>Price</th>
</tr>
</thead>

</table>
<table id="myTable" class="table order-list2 border">
@isset($riders['items'])
@foreach($riders['items'] as $riderItemId)
@php
$item = \App\Models\Items::find($riderItemId->item_id);
@endphp
@if($item)
<td width="250"><label>{{@$item->name}}</label></td>
<td width="240">{{@$riderItemId->price}}</td>
@endif

</tr>
@endforeach
@endisset
</table>


</div>
</div>
</div>

{{-- <div class="row m-1 border">
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Name</b><br/> {{@$rider->name}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Rider ID</b><br/> {{@$rider->rider_id}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Contact</b><br/> {{@$rider->personal_contact}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Rider ID</b><br/> {{@$rider->rider_id}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Vendor</b><br/> {{@$rider->vendor->name}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Company Contact</b><br/> {{@$rider->company_contact}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Nationality</b><br/> {{@$rider->nationality}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Personal Email ID</b><br/> {{@$rider->personal_email}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Email ID</b><br/> {{@$rider->email}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Visa Sponsor</b><br/> {{@$rider->visa_sponsor}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Occupation On Visa</b><br/> {{@$rider->visa_occupation}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Visa Status</b><br/> {{@$rider->visa_status}}
  </div>

  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>CDM Deposit ID</b><br/> {{@$rider->cdm_deposit_id}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Mashreq ID</b><br/> {{@$rider->mashreq_id}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Date of Joining</b><br/> {{@$rider->doj}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Project</b><br/> {{@$rider->project->name}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Designation</b><br/> {{@$rider->designation}}
  </div>

  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Ethnicity</b><br/> {{@$rider->ethnicity}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>DOB</b><br/> {{@$rider->dob}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Branded Plate Number</b><br/> {{@$rider->branded_plate_no}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Fleet Supervisor</b><br/> {{@$rider->fleet_supervisor}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Passport Handover</b><br/> {{@$rider->passport_handover}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Status</b><br/> {{App\Helpers\General::RiderStatus(@$rider->status)}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Emirate (Hub)</b><br/> {{@$rider->emirate_hub}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Emirate ID</b><br/> {{@$rider->emirate_id}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Licence No</b><br/> {{@$rider->license_no}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>Passport</b><br/> {{@$rider->passport}}
  </div>

  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>WPS</b><br/> {{@$rider->wps}}
  </div>
  <div class="col-md-4 border-right border-bottom" style="height: 45px;">
      <b>C3 Card</b><br/> {{@$rider->c3_card}}
  </div>
  <div class="col-md-12">
      <b>Other Details</b><br/> {{@$rider->other_details}}
  </div>

</div>
--}}


@endsection


