
<script src="{{ asset('js/modal_custom.js') }}"></script>
<form action="{{ route('bikes.assign_rider', $id) }}" method="post" id="formajax">
  <input type="hidden" name="bike_id" value="{{$id}}"/>
       <div class="row">

                  <div class="col-md-4 form-group">
                      <label>Change Status</label>
                      <select class="form-control warehouse form-select" name="warehouse" id="warehouse" onchange="bike_status()">
                          {!! App\Helpers\General::get_warehouse() !!}
                      </select>
                  </div>
                  <div class="col-md-4 form-group" id="rider_select">
                      <label>Change Rider</label>
                      {!! Form::select('rider_id',\App\Models\Riders::dropdown(),null ,['class' => 'form-select select2 ','id'=>'rider_id']) !!}

                  </div>
                  <div class="form-group col-md-3">
                      <label for="exampleInputEmail1">Date</label>
                      <input type="date"  name="note_date" class="form-control" placeholder="Date" value="{{ date('Y-m-d') }}">
                  </div>
                  </div>
                  <!--col-->
                  <div class="row mt-3">
                  <div class="col-md-8">
                      <textarea class="form-control" placeholder="Note....." name="notes"></textarea>
                  </div>

                  <!--col-->
              </div>
              <div class="row">
                  <div class="col-md-12 mt-2">
                      <button type="submit"  class="btn btn-primary pull-right save_rec">Save</button>

                  </div>
              </div>
            </form>
              <!--row-->
