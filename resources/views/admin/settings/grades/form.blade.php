<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('grades.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('grade_name', 'Name *') !!}
    {!! Form::text('grade_name', old('grade_name', isset($grades->grade_name) ? $grades->grade_name : ''), ['class' => 'form-control', 'placeholder' => 'Grade name']) !!}
    @if ($errors->has('grade_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('grade_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('grades.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
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

