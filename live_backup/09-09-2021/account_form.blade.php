<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}

</div>
<div class="form-group">
    {!! Form::label('group_name', 'Group Name * ') !!}
    {!! Form::text('group_name', old('group_name', isset($group->group_name) ? $group->group_name : ''), ['class' => 'form-control', 'placeholder' => 'Group name']) !!}
    @if ($errors->has('group_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('group_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('under', 'Under') !!}
    <br/>
    {!! Form::radio('under', 1, old('under', isset($group->under) && ($group->under == 1) ? true : true), ['id' => 'under_primary']) !!}
    {!! Form::label('under_primary', 'Primary', ['class' => 'form-check-label']) !!}

    {!! Form::radio('under', 2, old('under', isset($group->under) && ($group->under == 2) ? true : false), ['id' => 'under_other']) !!}
    {!! Form::label('under_other', 'Other', ['class' => 'form-check-label']) !!}

    @if ($errors->has('under'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('under') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="select-group-wrapper">

        @if (old('under', isset($group->under) ? $group->under : 1) == 1)
            {!! Form::label('group_type', 'Primary Group') !!}
        @else
            {!! Form::label('group_type', 'Sub Group') !!}
        @endif

        {!! Form::select('group_type', (old('under', isset($group->under) ? $group->under : 1) == 1) ? $primary : $other, isset($group->group_type) ? $group->group_type : '', ['class' => 'form-control'] ) !!}

        @if ($errors->has('group_type'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('group_type') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    {!! Form::label('is_affect', 'Is it affect to the gross profit ?') !!}
    <br/>
    {!! Form::radio('is_affect', 1, isset($group->is_affect) && ($group->is_affect == 1) ? true : true, ['id' => 'is_affect_yes']) !!}
    {!! Form::label('is_affect_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_affect', 0, isset($group->is_affect) && ($group->is_affect == 0) ? true : false, ['id' => 'is_affect_no']) !!}
    {!! Form::label('is_affect_no', 'No', ['class' => 'form-check-label']) !!}

    @if ($errors->has('is_affect'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('is_affect') }}</strong>
        </span>
    @endif

</div>
 <div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}

</div>

@section('script')
    @parent
    <script type="text/javascript">
        // $.custom.getGroupType.init();
        @if(isset($primary) && !empty($primary) && isset($other) && !empty($other))
            var handleGroupTypeList = function(type) {
                var _select = $("<select />", {
                    'class': 'form-control',
                    'id': 'group_type',
                    'name': 'group_type',
                });

                var text = '';

                if (type == 1)
                {
                    var _label = $("<label />", {
                        'for': 'group_type'
                    }).text('Primary Group');

                    var primary = @json($primary);
                    $.each(primary, function(index, el) {
                        $('<option/>', {
                            'value': index,
                            'text': el
                        }).appendTo(_select);
                    });

                    $(".select-group-wrapper").html(_label.add(_select));
                }
                else
                {
                    var _label = $("<label />", {
                        'for': 'group_type'
                    }).text('Sub Group');

                    var other = @json($other);
                    $.each(other, function(index, el) {
                        $('<option/>', {
                            'value': index,
                            'text': el
                        }).appendTo(_select);
                    });

                    $(".select-group-wrapper").html(_label.add(_select));
                }
            }

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
        
                $(document).on("change", ':radio[name="under"]', function(){
                    var type = $(this).val();

                    handleGroupTypeList(type);
                });
            });
        @endif
    </script>
@endsection
