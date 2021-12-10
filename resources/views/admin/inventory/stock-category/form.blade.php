<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('stock-categories.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('name', 'Name *') !!}
    {!! Form::text('name', old('name', isset($category->name) ? $category->name : ''), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    @if ($errors->has('name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('group_id', 'Under') !!}
    {!! Form::select('group_id', ['0' => 'Select a Group'] + $stock_groups, old('group_id', isset($category->group_id) ? $category->group_id : ''), ['class' => 'form-control', 'required' => 'required'] ) !!}
    @if ($errors->has('group_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('group_id') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('stock-categories.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        ///Form submitting process stop on enter button ///
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