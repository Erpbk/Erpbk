{!! Form::open(['route' => ['bikeHistories.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
   {{--  <a href="{{ route('bikeHistories.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('bikeHistories.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => 'return confirm("'.__('crud.are_you_sure').'")'

    ]) !!} --}}
</div>
{!! Form::close() !!}
