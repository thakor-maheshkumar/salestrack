<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('terretory.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('terretory_name', 'Name *') !!}
    {!! Form::text('terretory_name', old('terretory_name', isset($terretory->terretory_name) ? $terretory->terretory_name : ''), ['class' => 'form-control', 'placeholder' => 'Terretory name']) !!}
    @if ($errors->has('terretory_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('terretory_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('under', 'Under') !!}
    {!! Form::select('under', ['0' => 'Select a Terretory'] + $terretories, old('under', isset($terretory->under) ? $terretory->under : ''), ['class' => 'form-control'] ) !!}
    @if ($errors->has('under'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('under') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('terretory.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('keypress', 'input,select,textarea', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                    // Get all focusable elements on the page
                    var $canfocus = $(':focusable');
                    var index = $canfocus.index(document.activeElement) + 1;
                        if (index >= $canfocus.length) index = 0;
                        $canfocus.eq(index).focus();
                        }
        });
    })
</script>
@endsection
