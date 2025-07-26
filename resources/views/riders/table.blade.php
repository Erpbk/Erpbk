@push('third_party_stylesheets')
@endpush
<table class="table table-striped dataTable no-footer" id="dataTableBuilder">
   <thead class="text-center">
      <tr role="row">
         <th title="Rider ID" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rider ID: activate to sort column ascending" >Rider ID</th>
         <th title="Name" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" >Name</th>
         <th title="Contact" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Contact: activate to sort column ascending" >Contact</th>
         <th title="Fleet Supv" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Fleet Supv: activate to sort column ascending" >Fleet Supv</th>
         <th title="Hub" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Hub: activate to sort column ascending" >Hub</th>
         <th title="Customer" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" >Customer</th>
         <th title="Desig" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Desig: activate to sort column ascending" >Desig</th>
         <th title="Bike" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Bike" >Bike</th>
         <th title="Status" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" >Status</th>
         <th title="Shift" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Shift: activate to sort column ascending" >Shift</th>
         <th title="ATTN" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="ATTN: activate to sort column ascending" >ATTN</th>
         <th title="Orders" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Orders: activate to sort column ascending" >Orders</th>
         <th title="Days" class="sorting" tabindex="0" rowspan="1" colspan="1" aria-label="Days: activate to sort column ascending" >Days</th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending" >
            <a data-bs-toggle="modal" data-bs-target="#searchModal"href="javascript:void(0);" > <i class="fa fa-search"></i></a> </th>
         <th tabindex="0" rowspan="1" colspan="1" aria-sort="descending">
            <a data-bs-toggle="modal" data-bs-target="#customoizecolmn" href="javascript:void(0);" > <i class="fa fa-filter"></i></a> </th>
      </tr>
   </thead>
   <tbody >
      @foreach($data as $r)
         <tr class="text-center">
            <td>{{ $r->rider_id }}</td>
            <td><a href="{{ route('riders.show', $r->id) }}">{{ $r->name }}</a><br/></td>
            @php
                

               $phone = preg_replace('/[^0-9]/', '', $r->company_contact);
               $whatsappNumber = '+971' . ltrim($phone, '0');
            @endphp  
            <td>
               @if ($r->company_contact)
               <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="text-success">
                  <i class="fab fa-whatsapp"></i>{{ $r->company_contact }}
               </a>
               @else
               N/A
               @endif
            </td>
            <td>{{ $r->fleet_supervisor }}</td>
            <td>{{ $r->emirate_hub }}</td>
            <td>{{ DB::table('customers')->where('id' , $r->customer_id)->first()->name }}</td>
            <td>{{ $r->designation }}</td>
            @php
            $bike = DB::table('bikes')->where('rider_id', $r->id)->first();
            @endphp
            <td>{{ $bike ? $bike->plate : '-' }}</td>
            @php
                $statusLabels = [
                    1 => 'bg-label-success',
                    3 => 'bg-label-danger',
                ];

                $badgeClass = $statusLabels[$r->status] ?? 'bg-label-secondary'; // default fallback class
            @endphp
            <td>
               <span class="badge {{ $badgeClass }}">
                  @if($r->status == 1)Active
                  @elseif($r->status == 3)Inactive
                  @else Unknown
                  @endif
               </span>
            </td>

            <td>{{ $r->shift }}</td>
            @php
               $rider = DB::Table('riders')->find($r->id);
               $timeline = DB::Table('job_status')->select('id')->where('RID', $r->id)->whereDate('created_at', '=', $r->attendance_date)->first();
               $emails = DB::Table('rider_emails')->select('id')->where('rider_id', $r->id)->whereDate('created_at', '=', $r->attendance_date)->first();
            @endphp
            <td>
               @if($timeline)
                  <a href="{{ route('rider.timeline') }}/{{ $rider->id }}"><span class="text-danger cursor-pointer" title="Timeline Added">●</span></a>&nbsp;
               @endif
               @if($emails)
                  <a href="{{ route('rider.emails') }}/{{ $rider->id }}"><span class="text-success cursor-pointer" title="Email Sent">●</span></a>&nbsp;
               @endif
               <a href="javascript:void(0);" data-action="{{ url('riders/job_status', $rider->id) }}" data-size="md" data-title="Add Timeline" class="show-modal">
                  {{ $r->attendance }}
               </a>
            </td>
            @php 
                $rider_sum = DB::table('rider_activities')->where('d_rider_id', $r->rider_id)->sum('delivered_orders');
            @endphp
            <td>{{ $rider_sum ? $rider_sum : '-' }}</td>
            @php 
                $days= DB::table('rider_activities')->where('d_rider_id', $r->rider_id)->count('date');
            @endphp
            <td>{{ $days ? $days : '-' }}</td>
            <td>
               <div class="dropdown">
                 <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1 waves-effect" type="button" id="actiondropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="icon-base ti ti-dots icon-md text-body-secondary"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actiondropdown" style="">
                     <a href="javascript:void();" data-action="{{route('rider_contract_upload', $r->id)}}" data-size="md"
                      data-title="{{ $r->name }} ({{ $r->rider_id }}) Contract" class="dropdown-item waves-effect show-modal"><i class="fas fa-file my-1"></i> Contract</a>
                     <a href="javascript:void();" data-action="{{route('rider.sendemail', $r->id)}}" data-size="md"
                      data-title="{{ $r->name }} ({{ $r->rider_id }})" class="dropdown-item waves-effect show-modal"><i class="fas fa-envelope my-1"></i> Send Email</a>

                     @can('rider_edit')
                     <a href="{{ route('riders.edit', $r->id) }}" class='dropdown-item waves-effect'>
                        <i class="fa fa-edit my-1"></i> Edit
                     </a>
                     @endcan
                     @can('rider_delete')
                     <a href="{{ route('rider.delete', $r->id) }}" class='dropdown-item waves-effect'>
                        <i class="fa fa-trash my-1"></i> Delete
                     </a>
                     @endcan
                  </div>
               </div>
            </td>
            <td></td>
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
            <div style="display: none;" class="loading-overlay" id="loading-overlay"><div class="spinner-border text-primary" role="status"></div></div>
            <form id="filterForm" action="{{ route('riders.index') }}" method="GET">
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