@push('third_party_stylesheets')
@endpush
<table class="table table-striped dataTable no-footer" id="dataTableBuilder">
   <thead class="text-center">
      <tr role="row">
         <th title="Code" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Code: activate to sort column ascending" >Code</th>
         <th title="Plate" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Plate: activate to sort column ascending" >Plate</th>
         <th title="Rider ID" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Rider ID: activate to sort column ascending" >Rider ID</th>
         <th title="Rider Name" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Rider Name: activate to sort column ascending" >Rider Name</th>
         <th title="Contract#" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Contract#: activate to sort column ascending" >Contract#</th>
         <th title="Emirates" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Emirates: activate to sort column ascending" >Emirates</th>
         <th title="Company" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Company: activate to sort column ascending" >Company</th>
         <th title="Expiry" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Expiry: activate to sort column ascending" >Expiry</th>
         <th title="Action" width="120px" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" ><a data-bs-toggle="modal" data-bs-target="#searchModal" href="javascript:void(0);" > <i class="fa fa-search"></i></a></th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending" >
            <a data-bs-toggle="modal" data-bs-target="#customoizecolmn" href="javascript:void(0);" > <i class="fa fa-filter"></i></a> 
         </th>
      </tr>
   </thead>
   <tbody>
      @foreach($data as $r)
      <tr class="text-center">
         <td>{{ $r->bike_code }}</td>
         <td>{{ $r->plate }}</td>
         @php
             $rider = DB::table('riders')->where('id', $r->rider_id)->first();
         @endphp
         <td>{{ $rider->rider_id ?? '-' }}</td>
            
            <td>
                @if ($rider)
                    <a href="{{ route('riders.show', $rider->id) }}">{{ $rider->name }}</a>
                @else
                    -
                @endif
            </td>
         <td>{{ $r->contract_number }}</td>
         <td>{{ $r->emirates }}</td>
         @php
         $company = DB::Table('leasing_companies')->where('id' , $r->company)->first();
         @endphp
         <td>{{ $company ? $company->name : '-' }}</td>
        <td>{{ $r->expiry_date ? \Carbon\Carbon::parse($r->expiry_date)->format('d M Y') : '-' }}</td>
         <td>
            <div class="dropdown">
               <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" id="actiondropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="icon-base ti ti-dots icon-md text-body-secondary"></i>
               </button>
               <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actiondropdown" style="">
                    <!-- <a href="{{ route('bikes.show', $r->id) }}" class='btn btn-default btn-xs'>
                        <i class="fa fa-eye"></i>
                    </a> -->
                    <a  href="javascript:void(0);" data-size="lg" data-title="Assign Rider to Bike # {{$r->plate}}" data-action="{{ route('bikes.assign_rider', $r->id) }}" class='dropdown-item waves-effect btn-sm show-modal'>
                        <i class="fa fa-biking"></i>Assign Rider
                    </a>
                    <a href="{{ route('bikeHistories.index', ['bike_id'=>$r->id]) }}" class='dropdown-item waves-effect'>
                        <i class="fa fa-list-check"></i>History
                    </a>
                    @can('bike_document')
                      <a  href="javascript:void(0);" data-size="sm" data-title="Upload file for Bike # {{$r->plate}}" data-action="{{ route('files.create',['type_id'=>$r->id,'type'=>'bike']) }}" class='dropdown-item waves-effect btn-sm show-modal'>
                        <i class="fa fa-file-upload"></i>Upload File
                    </a>
                    @endcan
                    <a href="{{ route('files.index',['type_id'=>$r->id,'type'=>'bike']) }}" class='dropdown-item waves-effect'>
                      <i class="fa fa-file-lines"></i>Files
                    </a>
                    @can('item_edit')
                    <a  href="javascript:void(0);" data-size="xl" data-title="Update Bike" data-action="{{ route('bikes.edit', $r->id) }}" class='dropdown-item waves-effect show-modal'>
                        <i class="fa fa-edit"></i>Edit
                    </a>
                    @endcan
                    @can('item_delete')
                    <a href="javascript:void(0);"  onclick='confirmDelete("{{route('bikes.delete', $r->id) }}")' class='dropdown-item waves-effect'>
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