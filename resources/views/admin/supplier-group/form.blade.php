<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('supplier-groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}

</div>
<div class="form-group">
    {!! Form::label('group_name', 'Group Name') !!}
    {!! Form::text('group_name', old('group_name', isset($group->group_name) ? $group->group_name : ''), ['class' => 'form-control', 'placeholder' => 'Group name']) !!}
    @if ($errors->has('group_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('group_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('under', 'Under') !!}

    {!! Form::select('under', [0 => 'Select Group'] + $supplier_groups, isset($group->under) ? $group->under : '', ['class' => 'form-control'] ) !!}

    @if ($errors->has('under'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('under') }}</strong>
        </span>
    @endif
</div>
 <div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('supplier-groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}

</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
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
        });
    </script>
 @endsection   