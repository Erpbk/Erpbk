
            {!! Form::model($rtaFines, ['route' => ['rtaFines.update', $rtaFines->id], 'method' => 'patch']) !!}

                <div class="row">
                    @include('rta_fines.fields')
                </div>

            <div class="action-btn">
                <button type="button" class="btn btn-default"  data-bs-dismiss="modal">Cancel</button>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
