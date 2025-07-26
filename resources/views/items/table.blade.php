@push('third_party_stylesheets')
@endpush
<table class="table table-striped dataTable no-footer" id="dataTableBuilder">
   <thead class="text-center">
      <tr role="row">
         <th title="Name" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-sort="descending" aria-label="Name: activate to sort column ascending" >Name</th>
         <th title="Customer" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" >Customer</th>
         <th title="Supplier" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Supplier: activate to sort column ascending" >Supplier</th>
         <th title="Price" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" >Price</th>
         <th title="Vat" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Vat: activate to sort column ascending" >Vat</th>
         <th title="Status" class="sorting" tabindex="0" aria-controls="dataTableBuilder" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >Status</th>
         <th title="Action" width="120px" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action" ><a data-bs-toggle="modal" data-bs-target="#searchModal" href="javascript:void(0);" > <i class="fa fa-search"></i></a></th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending" >
            <a data-bs-toggle="modal" data-bs-target="#customoizecolmn" href="javascript:void(0);" > <i class="fa fa-filter"></i></a> 
         </th>
      </tr>
   </thead>
   <tbody>
      @foreach($data as $r)
      <tr class="text-center">
         <td>{{$r->name}}<br/></td>
         <td>{{ DB::table('customers')->where('id', $r->customer_id)->first()->name ?? '-' }}</td>
         <td>{{ DB::Table('suppliers')->where('id' , $r->supplier_id)->first()->name ?? '-' }}</td>
         <td>{{$r->price }}</td>
         <td>{{$r->vat }}</td>
         <td>
            @if($r->status == 1)
            <span class="badge  bg-success">Active</span>
            @else
            <span class="badge  bg-danger">Inactive</span>
            @endif
         </td>
         <td>
            <div class='btn-group'>
               <!-- <a href="javascript:void(0);" data-action="{{ route('items.show', $r->id) }}" class='btn btn-default btn-sm show-modal' data-size="lg" data-title="View">
                  <i class="fa fa-eye"></i>
                  </a> -->
               @can('item_edit')
               <a href="javascript:void(0);" data-action="{{ route('items.edit', $r->id) }}" class='btn btn-info btn-sm show-modal' data-size="lg" data-title="Update Item">
               <i class="fa fa-edit"></i>
               </a>
               @endcan
               @can('item_delete')
               <a href="javascript:void(0);"  onclick='confirmDelete("{{route('items.delete', $r->id) }}")' class='btn btn-danger btn-sm confirm-modal' data-size="lg" data-title="Delete Item">
               <i class="fa fa-trash"></i>
               </a>
               @endcan
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