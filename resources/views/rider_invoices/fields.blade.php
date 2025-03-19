<script src="{{ asset('js/modal_custom.js') }}"></script>

<div class="row">
  <div class="col-md-2 form-group">
      <label>Invoice Date</label>
      <input type="date" class="form-control form-control" value="{{ date('Y-m-d') }}" name="inv_date" placeholder="Invoice Date">
  </div>
  <!--col-->
  <div class="col-md-4 form-group">
      <label>Rider</label>
      {!! Form::select('rider_id', $riders, null, ['class' => 'form-select form-select-sm select2','id'=>'rider_id']) !!}

  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Zone</label>
      <input type="text" class="form-control form-control" name="zone" placeholder="Zone">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Login Hours</label>
      <input type="text" class="form-control form-control" name="login_hours" placeholder="Login Hours">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Working Days</label>
      <input type="text" class="form-control form-control" name="working_days" placeholder="Working Days">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Perfect Attendance</label>
      <input type="text" class="form-control form-control" name="perfect_attendance" placeholder="Perfect Attendance">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Rejection</label>
      <input type="text" class="form-control form-control" name="rejection" placeholder="Rejection">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Performance</label>
      <input type="text" class="form-control form-control" name="performance" placeholder="Performance">
  </div>
  <!--col-->
  <div class="col-md-2 form-group">
      <label>Off</label>
      <input type="text" class="form-control form-control" name="off" placeholder="Performance">
  </div>
  <!--col-->
 {{--  <div class="col-md-3 form-group">
      <label>Month of Invoice</label>
      <select class="form-control form-control" name="month_invoice">
          @for($i=1; $i<=12; $i++)
              <option value="{{ $i }}">{{ date('F',mktime(0, 0, 0, $i, 10)) }}</option>
          @endfor
      </select>
  </div> --}}
  <div class="form-group col-md-2">
      <label for="exampleInputEmail1">Billing Month</label>
      <input type="month" name="billing_month"  class="form-control form-control" id="billing_month" />

{{--                         {!! Form::select('billing_month',App\Helpers\CommonHelper::BillingMonth(),null ,['class' => 'form-control form-control select2 ','id'=>'billing_month']) !!}
--}}                    </div>
  <!--col-->
  <div class="col-md-6 form-group">
      <label>Descriptions</label>
      <textarea class="form-control form-control" name="descriptions" placeholder="Descriptions"></textarea>
  </div>
  <div class="col-md-6 form-group">
      <label>Notes</label>
      <textarea class="form-control form-control" name="notes" placeholder="Notes"></textarea>
  </div>
  <!--col-->
</div>
<!--row-->
<div class="">
  <div class="card-header bg-blue mt-3">
      <b class="card-title ">Item Details</b>
  </div>
  <!-- /.card-header -->
  <div class="" id="rows-container">

      <div class="row">
          <div class="col-md-3 form-group">
              <label>Item Description</label>
              {!! Form::select('item_id[]', $items, null, ['class' => 'form-select form-select-sm select2','onchange'=>'rider_price(this);']) !!}
          </div>
          <!--col-->
          <div class="col-md-1 form-group">
              <label>Qty</label>
              <input type="text" class="form-control form-control qty" name="qty[]" placeholder="0" value="1" onchange="calculate_price(this);">
          </div>
          <!--col-->
          <div class="col-md-2 form-group">
              <label>Rate</label>
              <input type="text" class="form-control form-control rate" name="rate[]" placeholder="0" value="0" onchange="calculate_price(this);">
          </div>
          <!--col-->
          <div class="col-md-2 form-group">
              <label>Discount</label>
              <input type="text" class="form-control form-control discount" name="discount[]" placeholder="0" value="0" onchange="calculate_price(this);">
          </div>
          <!--col-->
          <div class="col-md-1 form-group">
              <label>Tax</label>
              <input type="text" class="form-control form-control tax" name="tax[]" placeholder="0" value="0" onchange="calculate_price(this);">
          </div>
          <!--col-->
          <div class="col-md-2 form-group">
              <label>Amount</label>
              <input type="text" class="form-control form-control amount" readonly name="amount[]" placeholder="0" value="0" onkeyup="getTotal();">
          </div>
          <!--col-->
          <div class="form-group col-md-1 d-flex align-items-end">
            <a href="javascript:void(0);" class="text-danger btn-remove-row"><i class="fa fa-trash"></i></a>
        </div>
          <!--col-->
      </div>
  </div>

      <!--row-->
      <div class="append-line"></div>
      <div class="col-md-1 form-group">
          <label style="visibility: hidden">Assign Price</label>
{{--           <button type="button" class="btn btn-sm btn-primary new_line_item"><i class="fa fa-plus"></i> </button>
 --}}          <button type="button" id="add-new-row" class="btn btn-success btn-sm mt-3 mb-3">Add New</button>

      </div>
      <div class="row">
          <div class="col-md-2 offset-7 form-group text-right">
              <label><strong>Sub Total</strong>:</label>
          </div>
          <div class="col-md-2 form-group text-left">
              <input type="text" name="total_amount" class="form-control form-control" id="sub_total" placeholder="0.00" value="0.00" readonly>
          </div>
      </div>
