@push('third_party_stylesheets')
@endpush
<table class="table table-striped dataTable no-footer" id="dataTableBuilder">
   <thead class="text-center">
      <tr role="row">
         <th title="Ticket No" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Ticket No: activate to sort column ascending" aria-sort="descending">Name</th>
         <th title="Trip Time" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Trip Time: activate to sort column ascending">Parent Account</th>
         <th title="Rider" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Rider: activate to sort column ascending">Opening Balance</th>
         <th title="Rider" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Rider: activate to sort column ascending">Tax</th>
         <th title="Billing Month" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Billing Month: activate to sort column ascending">Status</th>
         <th title="Action" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action"><a data-bs-toggle="modal" data-bs-target="#searchModal" href="javascript:void(0);" > <i class="fa fa-search"></i></a></th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending">
            <a data-bs-toggle="modal" data-bs-target="#customoizecolmn" href="javascript:void(0);" > <i class="fa fa-filter"></i></a> 
         </th>
      </tr>
   </thead>
   <tbody>
      @foreach($data as $r)
      <tr class="text-center">
         <td> <a href="{{ route('rtaFines.tickets' , $r->id) }}">{{$r->name}}</a><br> </td>
            @php
                $account = DB::table('accounts')->where('id', $r->parent_id)->first();
            @endphp
            <td>
                @if ($account)
                   {{ $account->name }}
                @else
                    -
                @endif
            </td>
         <td>{{ $r->opening_balance }}</td>
         <td>@if($r->account_tax == '') - @else AED {{ $r->account_tax }}@endif</td>
         <td>
            @if($r->status == 1)
                <span class="badge  bg-success">Active</span>
            @else
                <span class="badge  bg-danger">Inactive</span>
            @endif
         </td>
         <td>
            <div class='btn-group'>
                <a href="{{ route('rtaFines.tickets' , $r->id) }}" class='btn btn-default btn-xs'>
                    <i class="fa fa-eye"></i>
                </a>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editaccount{{ $r->id }}" class='btn btn-default btn-xs'>
                    <i class="fa fa-edit"></i>
                </a>
               <a href="javascript:void(0);"  onclick='confirmDelete("{{route('rtaFines.deleteaccount', $r->id) }}")' class='btn btn-danger btn-sm confirm-modal' data-size="lg" data-title="Delete Account">
               <i class="fa fa-trash"></i>
               </a>
            </div>
         </td>
         <td></td>
      </tr>

     <div class="modal modal-default filtetmodal fade" id="editaccount{{ $r->id }}" tabindex="-1" data-bs-backdrop="static"role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-slide-top modal-full-top">
           <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Update Account</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
              <div class="modal-body" id="searchTopbody">
                 <form action="{{ route('rtaFines.editaccount') }}" method="POST">
                     @csrf
                     <input type="hidden" name="id" name="id" value="{{ $r->id }}">
                     <div class="row">
                         <div class="form-group col-md-12">
                             <label for="name">Name</label>
                             <input type="text" name="name" class="form-control" placeholder="Enter Your Account Name" value="{{ $r->name }}">
                         </div>
                         <div class="form-group col-md-12">
                             <label for="account_tax">Account Tax</label>
                             <input type="number" name="account_tax" class="form-control" placeholder="Enter Your Account Tax" value="{{ $r->account_tax }}">
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