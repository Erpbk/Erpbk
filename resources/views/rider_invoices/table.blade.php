@push('third_party_stylesheets')
@endpush
<table class="table table-striped dataTable no-footer" id="dataTableBuilder">
   <thead class="text-center">
      <tr role="row">
         <th title="Id" class="sorting" rowspan="1" colspan="1" >Id</th>
         <th title="Inv Date" class="sorting" rowspan="1" colspan="1" >Inv Date</th>
         <th title="Billing Month" class="sorting" rowspan="1" colspan="1" >Billing Month</th>
         <th title="Rider" class="sorting" rowspan="1" colspan="1" >Rider</th>
         <th title="Descriptions" class="sorting" rowspan="1" colspan="1" >Descriptions</th>
         <th title="Subtotal" class="sorting" rowspan="1" colspan="1" >Subtotal</th>
         <th title="Vat" class="sorting" rowspan="1" colspan="1" >Vat</th>
         <th title="Total Amount" class="sorting" rowspan="1" colspan="1" >Total Amount</th>
         <th title="Total Amount" class="sorting" rowspan="1" colspan="1" >Status</th>
         <th title="Action" width="120px" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" ><a data-bs-toggle="modal" data-bs-target="#searchModal" href="javascript:void(0);" > <i class="fa fa-search"></i></a></th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending" >
            <a data-bs-toggle="modal" data-bs-target="#customoizecolmn" href="javascript:void(0);" > <i class="fa fa-filter"></i></a> 
         </th>
      </tr>
   </thead>
   <tbody>
      @foreach($data as $r)
      <tr class="text-center">
        <td>{{ $r->id }}</td>
        <td>{{ $r->inv_date }}</td>
        <td>{{ \Carbon\Carbon::parse($r->billing_month)->format('M Y') }}</td>
        @php
        $rider = DB::Table('riders')->where('id' , $r->rider_id)->first();
        @endphp
         <td>{{ $rider->rider_id . '-' . $rider->name }}</td>
         <td>{{ $r->descriptions }}</td>
         <td>{{ number_format($r->subtotal, 1) }}</td>
         <td>{{ $r->vat }}</td>
         <td>{{ number_format($r->total_amount, 1) }}</td>
         <td>
            @if($r->status == 1)
            <span class="badge  bg-success">Active</span>
            @else
            <span class="badge  bg-danger">Inactive</span>
            @endif
         </td>
         <td>
               <div class="dropdown">
                 <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" id="actiondropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="icon-base ti ti-dots icon-md text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actiondropdown" style="">
                        @can('riderinvoice_view')
                        <a href="{{ route('riderInvoices.show', $r->id) }}" class='dropdown-item waves-effect' target="_blank">
                            <i class="fa fa-eye mx-1"></i> View
                        </a>
                        @endcan
                        @can('riderinvoice_edit')
                        <a href="javascript:void(0);" data-action="{{ route('riderInvoices.edit', $r->id) }}" class='dropdown-item waves-effect show-modal' data-size="xl" data-title="Update Invoice">
                        <i class="fa fa-edit mx-1"></i> Update
                        </a>
                        @endcan
                        @can('riderinvoice_delete')
                        <a href="javascript:void(0);"  onclick='confirmDelete("{{route('riderInvoices.delete', $r->id) }}")' class='dropdown-item waves-effect'>
                        <i class="fa fa-trash mx-1"></i> Delete 
                        </a>
                        @endcan
                    </div>
               </div>
            </td>
            <td></td>
        </tr>
      @endforeach
    </tbody>
</table>
{!! $data->links('pagination') !!}
<div class="modal modal-default filtetmodal fade" id="customoizecolmn" tabindex="-1" data-bs-backdrop="static"role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-slide-top modal-full-top">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Filter Riders</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" id="searchTopbody">
            <div style="display: none;" class="loading-overlay" id="loading-overlay">
               <div class="spinner-border text-primary" role="status"></div>
            </div>
            <form id="filterForm" action="{{ route('banks.index') }}" method="GET">
               <div class="row">
                  <div class="form-group col-md-12">
                     <input type="number" name="search" class="form-control" placeholder="Search">
                  </div>
                  <div class="col-md-12 form-group text-center">
                     <button type="submit" class="btn btn-primary pull-right mt-3"><i class="fa fa-filter mx-2"></i> Filter Data</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>