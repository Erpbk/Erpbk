

            {!! Form::open(['route' => 'accounts.store','id'=>'formajax']) !!}

            <div class="card-body">

                <div class="row">
                    @include('accounts.fields')
                </div>

            </div>

            <div class="action-btn">
              <button type="button" class="btn btn-default"  data-bs-dismiss="modal">Cancel</button>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
