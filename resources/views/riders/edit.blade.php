@extends('riders.view')

@section('page_content')


            {!! Form::model($riders, ['route' => ['riders.update', $riders->id], 'method' => 'patch','id'=>'formajax']) !!}
            <input type="hidden" id="redirect_url" value="{{route('riders.index')}}" />
            <div class="card-body">
                <div class="row">
                    @include('riders.fields')
                </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" >Save Information</button>
                <a href="{{ route('riders.index') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
