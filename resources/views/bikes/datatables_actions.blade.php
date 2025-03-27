{!! Form::open(['route' => ['bikes.destroy', $id], 'method' => 'delete','id'=>'formajax']) !!}
<div class='btn-group'>
    {{-- <a href="{{ route('bikes.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a> --}}

    <a  href="javascript:void(0);" data-size="lg" data-title="Assign Rider to Bike # {{$plate}}" data-action="{{ route('bikes.assign_rider', $id) }}" class='btn btn-success btn-sm show-modal'>
      <i class="fa fa-biking"></i>
  </a>

    @can('item_edit')
    <a  href="javascript:void(0);" data-size="lg" data-title="Update Bike" data-action="{{ route('bikes.edit', $id) }}" class='btn btn-info btn-sm show-modal'>
        <i class="fa fa-edit"></i>
    </a>
    @endcan

    @can('item_delete')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => 'return confirm("Are you sure?")'

    ]) !!}
    @endcan
</div>
{!! Form::close() !!}
