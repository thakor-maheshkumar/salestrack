@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('stock-groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('group_name', 'Name *') !!}
    {!! Form::text('group_name', old('group_name', isset($group->group_name) ? $group->group_name : ''), ['class' => 'form-control', 'placeholder' => 'Group name','required'=>'required']) !!}
    @if ($errors->has('group_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('group_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('under', 'Under') !!}
    {!! Form::select('under', ['0' => 'Select a Group'] + $stock_groups, old('under', isset($group->under) ? $group->under : ''), ['class' => 'form-control'] ) !!}
    @if ($errors->has('under'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('under') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('is_gst_detail', 'Set GST Details?') !!}
    <br/>
    {!! Form::radio('is_gst_detail', 1, isset($group->is_gst_detail) && ($group->is_gst_detail == 1) ? true : false, ['id' => 'is_gst_detail_yes']) !!}
    {!! Form::label('is_gst_detail_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_gst_detail', 0, (isset($group->is_gst_detail) && ($group->is_gst_detail == 0)) ? true : ((isset($group->is_gst_detail) && ($group->is_gst_detail == 1)) ? false : true), ['id' => 'is_gst_detail_no']) !!}
    {!! Form::label('is_gst_detail_no', 'No', ['class' => 'form-check-label']) !!}

    @if ($errors->has('is_gst_detail'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('is_gst_detail') }}</strong>
        </span>
    @endif
</div>
<fieldset class="gst-detail-block scheduler-border">
    <legend class="scheduler-border">GST Details</legend>
    <div class="form-group">
        {!! Form::label('taxability', 'Taxability') !!}
        {!! Form::select('taxability', $taxablity_types, old('taxability', isset($group->taxability) ? $group->taxability : ''), ['class' => 'form-control'] ) !!}
        @if ($errors->has('taxability'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('taxability') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('is_reverse_charge', 'Is reverse charge applicable?') !!}
        <br/>
        {!! Form::radio('is_reverse_charge', 1, isset($group->is_reverse_charge) && ($group->is_reverse_charge == 1) ? true : false, ['id' => 'is_reverse_charge_yes']) !!}
        {!! Form::label('is_reverse_charge_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('is_reverse_charge', 0, (isset($group->is_reverse_charge) && ($group->is_reverse_charge == 0)) ? true : ((isset($group->is_reverse_charge) && ($group->is_reverse_charge == 1)) ? false : true), ['id' => 'is_reverse_charge_no']) !!}
        {!! Form::label('is_reverse_charge_no', 'No', ['class' => 'form-check-label']) !!}

        @if ($errors->has('is_reverse_charge'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('is_reverse_charge') }}</strong>
            </span>
        @endif
    </div>
    <fieldset class="gst-detail-block scheduler-border">
    <legend class="scheduler-border">Current GST Details</legend>
    <table>
        <thead>
            <th>Tax Type</th>
            <th>Rate</th>
            <th>Applicable Date</th>
        </thead>
        <tbody>
            <tr>
                <td>GST</td>
                <td>
                    <div class="input-group form-group">
                        {!! Form::text('gst_rate', old('gst_rate', isset($group->gst_rate) ? $group->gst_rate : ''), ['class' => 'form-control', 'id' => 'gst_rate']) !!}
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="gst_rate">%</span>
                        </div>
                    </div>
                </td>
                {!! Form::hidden('stock_group_id', old('gst_rate', isset($group->id) ? $group->id : ''), ['class' => 'form-control', 'id' => 'gst_rate']) !!}
                <td>
                    <div class="form-group">
                        {!! Form::text('gst_applicable_date', old('gst_applicable_date', isset($group->gst_applicable_date) ? $group->gst_applicable_date : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                        {{--
                            @if ($errors->has('gst_applicable_date'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('gst_applicable_date') }}</strong>
                                </span>
                            @endif
                        --}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>CESS</td>
                <td>
                    <div class="input-group form-group">
                        {!! Form::text('cess_rate', old('cess_rate', isset($group->cess_rate) ? $group->cess_rate : ''), ['class' => 'form-control', 'id' => 'cess_rate']) !!}
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="cess_rate">%</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('cess_applicable_date', old('cess_applicable_date', isset($group->cess_applicable_date) ? $group->cess_applicable_date : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                        {{--
                            @if ($errors->has('cess_applicable_date'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('cess_applicable_date') }}</strong>
                                </span>
                            @endif
                        --}}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>

@if(isset($group->is_gst_detail))
    @if($group->is_gst_detail==1)
    <fieldset class="gst-detail-block scheduler-border">
    <legend class="scheduler-border">Previous GST Details</legend>
        <table>
        <thead>
            <th>Tax Type</th>
            <th>Rate</th>
            <th>Applicable Date</th>
        </thead>
        <tbody>
            <tr>
                <td>GST</td>
                <td>
                    <div class="input-group form-group">
                        {!! Form::text('gst_old_rate', old('gst_rate', isset($gstStock->gst_rate) ? $gstStock->gst_rate : ''), ['class' => 'form-control', 'id' => 'gst_rate','readonly']) !!}
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="gst_rate">%</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('gst_rate_applicable_date', old('gst_applicable_date', isset($gstStock->gst_rate_applicable_date) ? $gstStock->gst_rate_applicable_date : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off','readonly']) !!}
                        {{--
                            @if ($errors->has('gst_applicable_date'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('gst_applicable_date') }}</strong>
                                </span>
                            @endif
                        --}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>CESS</td>
                <td>
                    <div class="input-group form-group">
                        {!! Form::text('cess_old_rate', old('cess_rate', isset($gstStock->cess_rate) ? $gstStock->cess_rate : ''), ['class' => 'form-control', 'id' => 'cess_rate','readonly']) !!}
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="cess_rate">%</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        {!! Form::text('cess_rate_applicable_date', old('cess_applicable_date', isset($gstStock->cess_rate_applicable_date) ? $gstStock->cess_rate_applicable_date : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off','readonly']) !!}
                        {{--
                            @if ($errors->has('cess_applicable_date'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('cess_applicable_date') }}</strong>
                                </span>
                            @endif
                        --}}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </fieldset>
    @endif
    @endif
</fieldset>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('stock-groups.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            hideShowGstSection = function(type) {
                if(type == 1)
                {
                    $('.gst-detail-block').show();
                }
                else
                {
                    $('.gst-detail-block').hide();
                }
            }

            var type = $(':radio[name="is_gst_detail"]:checked').val();
            hideShowGstSection(type);

            $(document).on("change", ':radio[name="is_gst_detail"]', function(){
                var type = $(this).val();
                hideShowGstSection(type);
            });
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
