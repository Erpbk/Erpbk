<script src="{{ asset('js/modal_custom.js') }}"></script>
<!-- Trip Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_date', 'Trip Date:' , ['class' => 'required']) !!}
    {!! Form::date('trip_date', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Trip Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trip_time', 'Trip Time:', ['class' => 'required']) !!}
    {!! Form::time('trip_time', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Billing Month Field -->
<div class="form-group col-sm-6">
    {!! Form::label('billing_month', 'Billing Month:', ['class' => 'required']) !!}
    {!! Form::month('billing_month', null, ['class' => 'form-control', 'required']) !!}
</div>


<!-- Ticket No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ticket_no', 'Ticket No:', ['class' => 'required']) !!}
    {!! Form::text('ticket_no', null, ['class' => 'form-control', 'maxlength' => 50, 'required']) !!}
</div>

<!-- Rider Id Field -->
<div class="form-group col-sm-6">
    <label class="required">Bike:</label>
    <select class="form select select2" onchange="selectbike(this.value)" id="bike_id" name="bike_id" required>
        <option value=""></option>
        @foreach(DB::table('bikes')->where('status', 1)->orderBy('id', 'desc')->get() as $b)
        @php
            $company = DB::table('leasing_companies')->where('id', $b->company)->first();
        @endphp
        <option value="{{ $b->id }}">
            {{ $b->plate }} - {{ $company ? $company->name : 'N/A' }}
        </option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    <label class="required">Debit Account:</label>
    <select class="form select select2" id="debit_account" name="debit_account" required>
        <option value=""></option>
    </select>
</div>
<div class="form-group col-sm-6">
    <label  class="required">Credit Account:</label>
    <select class="form select select2" id="rta_account_id" name="rta_account_id" required>
        <option value=""></option>
        @foreach(DB::table('accounts')->where('status' , 1)->get() as $a)
            <option value="{{ $a->id }}" @if($data->id == $a->id) selected @endif>{{ $a->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('attachment', 'Attachment:', ['class' => 'required']) !!}
    {!! Form::file('attachment', ['class' => 'form-control', 'required']) !!}
</div>
<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:', ['class' => 'required']) !!}
    {!! Form::number('amount', null, ['class' => 'form-control','step'=>'any', 'required']) !!}
</div>


<!-- Detail Field -->
<div class="form-group col-sm-12">
    {!! Form::label('detail', 'Detail:', ['class' => 'required']) !!}
    {!! Form::textarea('detail', null, ['class' => 'form-control', 'maxlength' => 500,'rows'=>3, 'required']) !!}
</div>

<script type="text/javascript">
function selectbike(id) {
    if(id){
        $.ajax({
            type: 'get',
            url: '{{ url("rtaFines/getrider") }}/'+id,
            success: function(res) {
                $('#debit_account').html(res);
            }
        });
    } else {
        $('#debit_account').html('');
    }
}
</script>