{!! Form::open(['route' => ['riderInvoices.destroy', $id], 'method' => 'delete','id'=>'formajax']) !!}
<div class='btn-group'>
    <a href="{{ route('riderInvoices.show', $id) }}" class='btn btn-default btn-sm' target="_blank">
        <i class="fa fa-eye"></i>
    </a>
    {{-- <a href="{{ route('riderInvoices.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    --}}
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => 'return confirm("Are you sure?")'

    ]) !!}
</div>
{!! Form::close() !!}
