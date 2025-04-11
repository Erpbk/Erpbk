

            {!! Form::open(['route' => 'vouchers.store', 'id'=>'formajax']) !!}


                <div class="">
                    @include('vouchers.fields')
                </div>


            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary','onclick'=>'getTotal();']) !!}
            </div>

            {!! Form::close() !!}
<script>
    $(document).ready(function(){
    getTotal();


});


</script>
