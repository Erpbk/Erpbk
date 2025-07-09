<script src="{{ asset('js/modal_custom.js') }}"></script>

<!-- Trip Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_date', 'Trip Date:') !!}
    {!! Form::date('trip_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Trip Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_time', 'Trip Time:') !!}
    {!! Form::time('trip_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Billing Month Field -->
<div class="form-group col-sm-6">
    {!! Form::label('billing_month', 'Billing Month:') !!}
    {!! Form::month('billing_month', null, ['class' => 'form-control']) !!}
</div>


<!-- Ticket No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ticket_no', 'Ticket No:') !!}
    {!! Form::text('ticket_no', null, ['class' => 'form-control', 'maxlength' => 50]) !!}
</div>

<!-- Rider Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bike_id', 'Bike:') !!}
    {!! Form::select('bike_id',App\Models\Bikes::riderBikes(), null, ['class' => 'form-select select2']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('rta_account_id', 'RTA Account:') !!}
    {!! Form::select('rta_account_id',App\Models\Accounts::dropdown(App\Helpers\HeadAccount::RTA_FINE), null, ['class' => 'form-select select2']) !!}
</div>
<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','step'=>'any']) !!}
</div>


<!-- Detail Field -->
<div class="form-group col-sm-12">
    {!! Form::label('detail', 'Detail:') !!}
    {!! Form::textarea('detail', null, ['class' => 'form-control', 'maxlength' => 500,'rows'=>3]) !!}
</div>



