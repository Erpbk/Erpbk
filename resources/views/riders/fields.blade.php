<!-- Rider Info Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white fs-5 fw-bold p-2">Rider Info</div>
    <div class="card-body">
        <div class="row">
            <!-- Rider ID -->
            <div class="form-group col-sm-4">
                {!! Form::label('rider_id', 'Rider ID:',['class'=>'required']) !!}
                {!! Form::number('rider_id', null, ['class' => 'form-control','required']) !!}
            </div>

            <!-- Name -->
            <div class="form-group col-sm-4">
                {!! Form::label('name', 'Name:',['class'=>'required']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 191, 'required']) !!}
            </div>

            <!-- Rider Contact -->
            <div class="form-group col-sm-4">
                {!! Form::label('personal_contact', 'Rider Contact:') !!}
                {!! Form::tel('personal_contact', null, ['class' => 'form-control', 'placeholder' => '+9715XXXXXXXX', 'maxlength' => 13]) !!}
            </div>
        </div>

        <div class="row">
            <!-- Personal Email -->
            <div class="form-group col-sm-4">
                {!! Form::label('personal_email', 'Personal Email:',['class'=>'required']) !!}
                {!! Form::email('personal_email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email ID','maxlength' => 191, 'required']) !!}
            </div>

            <!-- Nationality -->
            <div class="form-group col-sm-4">
                {!! Form::label('nationality', 'Nationality:',['class'=>'required']) !!}
                {!! Form::select('nationality',
                    App\Models\Countries::list()->toArray(),
                    null,
                    [
                        'class' => 'form-control form-select select2',
                        'required',
                        'placeholder' => 'Select Nationality'
                    ]) !!}
            </div>

            <!-- Ethnicity -->
            <div class="form-group col-sm-4">
                {!! Form::label('ethnicity', 'Ethnicity:') !!}
                {!! Form::select('ethnicity',
                    Common::Dropdowns('ethnicity'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select Ethnicity'
                    ]) !!}
            </div>
        </div>

        <div class="row">
            <!-- Date of Birth -->
            <div class="form-group col-sm-4">
                {!! Form::label('dob', 'Date Of Birth:') !!}
                {!! Form::date('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
            </div>
        </div>
    </div>
</div>

<!-- Job Info Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white fs-5 fw-bold p-2">Job Info</div>
    <div class="card-body">
        <div class="row">

            <!-- Company Contact -->
            <div class="form-group col-sm-4">
                {!! Form::label('company_contact', 'Company Contact:') !!}
                {!! Form::tel('company_contact', null, ['class' => 'form-control', 'placeholder' => '+9715XXXXXXXX', 'maxlength' => 13]) !!}
            </div>

            <!-- Date of Joining -->
            <div class="form-group col-sm-4">
                {!! Form::label('doj', 'Date Of Joining:',['class'=>'required']) !!}
                {!! Form::date('doj', null, ['class' => 'form-control','id'=>'doj','required']) !!}
            </div>

            <!-- Designation -->
            <div class="form-group col-sm-4">
                {!! Form::label('designation', 'Designation:',['class'=>'required']) !!}
                {!! Form::select('designation',
                     Common::Dropdowns('designation'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select designation',
                        'required'
                    ]) !!}
            </div>
        </div>

        <div class="row">
            <!-- CDM Deposit ID -->
            <div class="form-group col-sm-4">
                {!! Form::label('cdm_deposit_id', 'CDM Deposit ID:') !!}
                {!! Form::text('cdm_deposit_id', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
            </div>

            <!-- Mashreq ID -->
            <div class="form-group col-sm-4">
                {!! Form::label('mashreq_id', 'Mashreq Id:') !!}
                {!! Form::text('mashreq_id', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
            </div>

            <!-- Branded Plate No -->
            <div class="form-group col-sm-4">
                {!! Form::label('branded_plate_no', 'Branded Plate No:') !!}
                {!! Form::text('branded_plate_no', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>

        <div class="row">
            <!-- Fleet Supervisor -->
            <div class="form-group col-sm-4">
                {!! Form::label('fleet_supervisor', 'Fleet Supervisor:',['class'=>'required']) !!}
                {!! Form::select('fleet_supervisor',
                     Common::Dropdowns('fleet-supervisor'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select Fleet Supervisor',
                        'required'
                    ]) !!}
            </div>

            <!-- Salary Model -->
            <div class="form-group col-sm-4">
                {!! Form::label('salary_model', 'Salary Model:',['class'=>'required']) !!}
                {!! Form::select('salary_model',
                     Common::Dropdowns('salary-model'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select Salary Model',
                        'required'
                    ]) !!}
            </div>

            <!-- Emirate Hub -->
            <div class="form-group col-sm-4">
                {!! Form::label('emirate_hub', 'Emirate Hub:',['class'=>'required']) !!}
                {!! Form::select('emirate_hub',Common::Dropdowns('emirates-hub'),null,
                    ['class' => 'form-select', 'required']) !!}
            </div>
        </div>

        <div class="row">
            <!-- Rider Reference -->
            <div class="form-group col-sm-4">
                {!! Form::label('rider_reference', 'Rider Reference:',['class'=>'required']) !!}
                {!! Form::text('rider_reference', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group col-sm-4">
              {!! Form::label('VID', 'Vendor:',['class'=>'required']) !!}
              {!! Form::select('VID',App\Models\Vendors::dropdown(),null,
                  ['class' => 'form-select', 'required']) !!}
          </div>
          <div class="form-group col-sm-4">
            <label>VAT</label>
            <div class="form-check">
              <input type="hidden" name="vat" value="2"/>
               <input type="checkbox" name="vat" id="vat" class="form-check-input" value="1" @isset($riders) @if($riders->vat == 1) checked @endif @else checked  @endisset/>
               <label for="vat" class="pt-0">Apply on Invoice</label>

            </div>
          </div>
        </div>
    </div>
</div>

<!-- Visa Info Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white fs-5 fw-bold p-2">Visa Info</div>
    <div class="card-body">
        <div class="row">
            <!-- Visa Sponsor -->
            <div class="form-group col-sm-4">
                {!! Form::label('visa_sponsor', 'Visa Sponsor:') !!}
                {!! Form::text('visa_sponsor', null, ['class' => 'form-control', 'placeholder' => 'Enter Visa Sponsor', 'maxlength' => 50]) !!}
            </div>

            <!-- Visa Occupation -->
            <div class="form-group col-sm-4">
                {!! Form::label('visa_occupation', 'Visa Occupation:',['class'=>'required']) !!}
                {!! Form::text('visa_occupation', null, ['class' => 'form-control', 'placeholder' => 'Enter Visa Occupation','maxlength' => 50, 'required' ]) !!}
            </div>

            <!-- Visa Status -->
            <div class="form-group col-sm-4">
                {!! Form::label('visa_status', 'Visa Status:') !!}
                {!! Form::select('visa_status',
                    Common::Dropdowns('visa-status'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select Visa Status'
                    ]) !!}
            </div>
        </div>

        <div class="row">
            <!-- Emirate ID -->
            <div class="form-group col-sm-4">
                {!! Form::label('emirate_id', 'Emirate ID:',['class'=>'required']) !!}
                <!-- {!! Form::text('emirate_id', null, ['class' => 'form-control','id'=>'emirate_id','placeholder' => '784-2000-6871718-8', 'required']) !!} -->
                {!! Form::text('emirate_id', null, [
    'class' => 'form-control',
    'required',
    'id' => 'emirate_id',
    'placeholder' => '784-2000-6871718-8',
    'oninput' => 'formatEmirateId(this)',
    'maxlength' => '18'
]) !!}
            </div>

            <!-- Emirate Expiry -->
            <div class="form-group col-sm-4">
                {!! Form::label('emirate_exp', 'Emirate Expiry:',['class'=>'required']) !!}
                {!! Form::date('emirate_exp', null, ['class' => 'form-control','id'=>'emirate_exp','required']) !!}
            </div>

            <!-- License No -->
            <div class="form-group col-sm-4">
                {!! Form::label('license_no', 'License No:',['class'=>'required']) !!}
                {!! Form::text('license_no', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
            </div>
        </div>

        <div class="row">
            <!-- License Expiry -->
            <div class="form-group col-sm-4">
                {!! Form::label('license_expiry', 'License Expiry:',['class'=>'required']) !!}
                {!! Form::date('license_expiry', null, ['class' => 'form-control','id'=>'license_expiry']) !!}
            </div>

            <!-- Passport -->
            <div class="form-group col-sm-4">
                {!! Form::label('passport', 'Passport:',['class'=>'required']) !!}
                {!! Form::text('passport', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
            </div>

            <!-- Passport Expiry -->
            <div class="form-group col-sm-4">
                {!! Form::label('passport_expiry', 'Passport Expiry:',['class'=>'required']) !!}
                {!! Form::date('passport_expiry', null, ['class' => 'form-control','id'=>'passport_expiry']) !!}
            </div>
        </div>

        <div class="row">
            <!-- Passport Handover -->
            <div class="form-group col-sm-4">
                {!! Form::label('passport_handover', 'Passport Handover:',['class'=>'required']) !!}
                {!! Form::select('passport_handover',
                     Common::Dropdowns('passport-handover'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select Passport Handover'
                    ]) !!}
            </div>
        </div>
    </div>
</div>

<!-- Labor Info Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white fs-5 fw-bold p-2">Labor Info</div>
    <div class="card-body">
        <div class="row">
            <!-- Person Code -->
            <div class="form-group col-sm-4">
                {!! Form::label('person_code', 'Person Code:') !!}
                {!! Form::text('person_code', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
            </div>

            <!-- Labor Card Number -->
            <div class="form-group col-sm-4">
                {!! Form::label('labor_card_number', 'Labor Card Number:') !!}
                {!! Form::text('labor_card_number', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
            </div>

            <!-- Labor Card Expiry -->
            <div class="form-group col-sm-4">
                {!! Form::label('labor_card_expiry', 'Labor Card Expiry:') !!}
                {!! Form::date('labor_card_expiry', null, ['class' => 'form-control','id'=>'labor_card_expiry']) !!}
            </div>
        </div>

        <div class="row">
            <!-- Insurance -->
            <div class="form-group col-sm-4">
                {!! Form::label('insurance', 'Insurance:') !!}
                {!! Form::select('insurance',
                    Common::Dropdowns('insurance'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select insurance'
                    ]) !!}
            </div>

            <!-- Insurance Expiry -->
            <div class="form-group col-sm-4">
                {!! Form::label('insurance_expiry', 'Insurance Expiry:') !!}
                {!! Form::date('insurance_expiry', null, ['class' => 'form-control','id'=>'insurance_expiry']) !!}
            </div>

            <!-- Policy No -->
            <div class="form-group col-sm-4">
                {!! Form::label('policy_no', 'Policy No:') !!}
                {!! Form::text('policy_no', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
            </div>
        </div>

        <div class="row">
            <!-- Wps -->
            <div class="form-group col-sm-4">
                {!! Form::label('wps', 'Wps:') !!}
                {!! Form::select('wps',
                     Common::Dropdowns('wps'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select wps'
                    ]) !!}
            </div>

            <!-- C3 Card -->
            <div class="form-group col-sm-4">
                {!! Form::label('c3_card', 'C3 Card:') !!}
                {!! Form::select('c3_card',
                     Common::Dropdowns('c3-card'),
                    null,
                    [
                        'class' => 'form-select',
                        'placeholder' => 'Select C3 Card'
                    ]) !!}
            </div>
        </div>
    </div>
</div>

<!-- Additional Information Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white fs-5 fw-bold p-2">Additional Information</div>
    <div class="card-body">
        <div class="row">
            <!-- Other Details -->
            <div class="form-group col-sm-12">
                {!! Form::label('other_details', 'Other Details:') !!}
                {!! Form::textarea('other_details', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
        </div>

        <!-- Price Assignment Section -->
        <div class="row pr-5 pl-5">
            <label><h5>Assign Price</h5></label>
            <span id="error_message_duplicate_id"></span>
            <div id="rows-container">
                @php
                    $counter = 1;
                    $sum = 1;
                @endphp
                @if(isset($riders['items']) && count($riders['items'])>0)
                    @php $resultItems = $riders['items']; @endphp
                    @foreach($resultItems as $rowItem)
                        @php $sum = count($riders['items']); @endphp
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Select Items</label>
                                <select value="0" name="items[id][]" class="form-select select2" required>
                                    <option value="0">Select Item</option>
                                    @foreach(\App\Models\Items::all() as $item)
                                    <option value="{{$item->id}}" @if(isset($rowItem->item_id) && $rowItem->item_id == $item->id) selected @endif>
                                        {{$item->name.' - '.$item->price}}
                                    </option>
                                    @endforeach
                                </select>
                                <span id="notification1" style="font-size: 13px;color:red"></span>
                            </div>
                            <div class="col-sm-4">
                                <label>Price</label>
                                <input type="number" class="form-control" step="any" value="@if(isset($rowItem)){{(int)$rowItem->price}}@endif" name="items[price][]" placeholder="Items Price"/>
                            </div>
                            <div class="col-sm-2">
                                <label></label>
                                <a href="javascript:void(0);" class="text-danger btn-remove-row"><i class="fa fa-close"></i></a>
                            </div>
                        </div>
                        @php $counter++; @endphp
                    @endforeach
                @else
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Select Items</label>
                            <select value="0" name="items[id][]" class="form-select select2" required>
                                <option value="0">Select Item</option>
                                @foreach(\App\Models\Items::all() as $item)
                                <option value="{{$item->id}}">{{$item->name.' - '.$item->price}}</option>
                                @endforeach
                            </select>
                            <span id="notification1" style="font-size: 13px;color:red"></span>
                        </div>
                        <div class="col-sm-4">
      <label>Price</label>
        <input type="number" class="form-control" step="any" value="@if(isset($rowItem)) $rowItem->price @endif"
        name="items[price][]" id="item_price" placeholder="Items Price"/>
      </div>
      <div class="col-sm-4">
        <label></label>
        <a href="javascript:void(0);" class="text-danger btn-remove-row"><i class="fa fa-close"></i></a>
      </div>

    </div>
      @endif
</div>

<button type="button" class="btn btn-success btn-sm mt-3 mb-3 col-sm-2" id="add-new-row">
  <i class="fa fa-plus"></i> Add Row</button>
</div>
