@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('stock-items.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('name', 'Name *') !!}
            {!! Form::text('name', old('name', isset($item->name) ? $item->name : ''), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('part_no', 'Part No') !!}
            {!! Form::text('part_no', old('part_no', isset($item->part_no) ? $item->part_no : ''), ['class' => 'form-control', 'placeholder' => 'Part No']) !!}
            @if ($errors->has('part_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('part_no') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('product_descriptiopn', 'Product Description ') !!}
    {!! Form::text('product_descriptiopn', old('product_descriptiopn', isset($item->product_descriptiopn) ? $item->product_descriptiopn : ''), ['class' => 'form-control', 'placeholder' => 'Product Descriptiopn']) !!}
    @if ($errors->has('product_descriptiopn'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('product_descriptiopn') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('product_image', 'Product Image') !!}
    @if(isset($item->product_image) && !empty($item->product_image))
        <div class="profile-image">
            <img src="{{ \Storage::url($item->product_image) }}" class="img-fluid">
        </div>
    @endif
    {!! Form::file('product_image', ['class' => 'form-control']) !!}
    @if ($errors->has('product_image'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('product_image') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-sm-12">
            {!! Form::label('under', 'Item Group') !!}
            {!! Form::select('under', ['0' => 'Select a Group'] + $stock_groups, old('under', isset($item->under) ? $item->under : ''), ['class' => 'form-control'] ) !!}
            @if ($errors->has('under'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('under') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-sm-12">
            {!! Form::label('category_id', 'Category *') !!}
            {!! Form::select('category_id', ['' => 'Select a Category'] + $stock_categories, old('category_id', isset($item->category_id) ? $item->category_id : ''), ['class' => 'form-control'] ) !!}
            @if ($errors->has('category_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-sm-12">
            {!! Form::label('unit_id', 'Units () *') !!}
            <!-- {!! Form::select('unit_id', ['0' => 'Select a Unit'] + $units, old('unit_id', isset($item->unit_id) ? $item->unit_id : ''), ['class' => 'form-control'] ) !!} -->
            <select class="form-control" name="unit_id" class="form-control">
            <option value="">Select Unit</option>
            @foreach($unitdata as $key=>$value)
            <option value="{{$value->id}}" @if(isset($item->unit_id)){{ $value->id == $item->unit_id ? 'selected' : '' }}@endif>{{$value->name}}({{$value->symbol}})</option>
            @endforeach
            </select>
            @if ($errors->has('unit_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('unit_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-sm-12">
            {!! Form::label('shipper_pack', 'Pack Size *') !!}

            <div>
                {!! Form::text('shipper_pack', old('shipper_pack', isset($item->shipper_pack) ? $item->shipper_pack : ''), ['class' => 'form-control shipper_pack']) !!}
                <span class="selected_unit"></span>
            </div>

            @if ($errors->has('shipper_pack'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('shipper_pack') }}</strong>
                </span>
            @endif
        </div>

    </div>
</div>
<div class="form-group">
   {!! Form::label('alternate_unit_id', 'Alternate Units') !!}

    <div class="alter-select-box">
        {!! Form::select('alternate_unit_id', ['0' => 'Select a Unit'] + $units, old('alternate_unit_id', isset($item->alternate_unit_id) ? $item->alternate_unit_id : ''), ['class' => 'form-control', 'id' => 'alternate_unit_id'] ) !!}
    </div>
    @if ($errors->has('alternate_unit_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('alternate_unit_id') }}</strong>
        </span>
    @endif
</div> 
<div class="form-group">
    {!! Form::label('convertion_rate', 'Conversion Rate *',['class'=>'convertion_rate ']) !!}

    <div>
        {!! Form::number('convertion_rate', old('convertion_rate', isset($item->convertion_rate) ? $item->convertion_rate : ''), ['class' => 'form-control convertion_rate','min'=>0,'max'=>100.00]) !!}
    </div>

    @if ($errors->has('convertion_rate'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('convertion_rate') }}</strong>
        </span>
    @endif
</div>
{{-- @include('admin.inventory.stock-item.grades') --}}
<div class="form-group">
    {!! Form::label('is_allow_mrp', 'Allow MRP') !!}
    <br/>
    {!! Form::radio('is_allow_mrp', 1, isset($item->is_allow_mrp) && ($item->is_allow_mrp == 1) ? true : false, ['id' => 'is_allow_mrp_yes']) !!}
    {!! Form::label('is_allow_mrp_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_allow_mrp', 0, (isset($item->is_allow_mrp) && ($item->is_allow_mrp == 0)) ? true : ((isset($item->is_allow_mrp) && ($item->is_allow_mrp == 1)) ? false : true), ['id' => 'is_allow_mrp_no']) !!}
    {!! Form::label('is_allow_mrp_no', 'No', ['class' => 'form-check-label']) !!}

    @if ($errors->has('is_allow_mrp'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('is_allow_mrp') }}</strong>
        </span>
    @endif
</div>
{{-- <div class="form-group">
    {!! Form::label('is_allow_part_number', 'Allow Part number') !!}
    <br/>
    {!! Form::radio('is_allow_part_number', 1, isset($item->is_allow_part_number) && ($item->is_allow_part_number == 1) ? true : true, ['id' => 'is_allow_part_number_yes']) !!}
    {!! Form::label('is_allow_part_number_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_allow_part_number', 0, isset($item->is_allow_part_number) && ($item->is_allow_part_number == 0) ? true : false, ['id' => 'is_allow_part_number_no']) !!}
    {!! Form::label('is_allow_part_number_no', 'No', ['class' => 'form-check-label']) !!}

    @if ($errors->has('is_allow_part_number'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('is_allow_part_number') }}</strong>
        </span>
    @endif
</div> --}}
<div class="form-group">
    {!! Form::label('is_maintain_in_batches', 'Maintain in batches?') !!}
    <br/>
    {!! Form::radio('is_maintain_in_batches', 1, isset($item->is_maintain_in_batches) && ($item->is_maintain_in_batches == 1) ? true : false, ['id' => 'is_maintain_in_batches_yes']) !!}
    {!! Form::label('is_maintain_in_batches_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_maintain_in_batches', 0, (isset($item->is_maintain_in_batches) && ($item->is_maintain_in_batches == 0)) ? true : ((isset($item->is_maintain_in_batches) && ($item->is_maintain_in_batches == 1)) ? false : true), ['id' => 'is_maintain_in_batches_no']) !!}
    {!! Form::label('is_maintain_in_batches_no', 'No', ['class' => 'form-check-label']) !!}

    @if ($errors->has('is_maintain_in_batches'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('is_maintain_in_batches') }}</strong>
        </span>
    @endif
</div>
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Maintain in batches</legend>
    <div class="form-group">
        {!! Form::label('track_manufacture_date', 'Track Manufacture Date') !!}

        <br/>
        {!! Form::radio('track_manufacture_date', 1, isset($item->track_manufacture_date) && ($item->track_manufacture_date == 1) ? true : true, ['id' => 'track_manufacture_date_yes']) !!}
        {!! Form::label('is_maintain_in_batches_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('track_manufacture_date', 0, isset($item->track_manufacture_date) && ($item->track_manufacture_date == 0) ? true : false, ['id' => 'track_manufacture_date_no']) !!}
        {!! Form::label('is_maintain_in_batches_no', 'No', ['class' => 'form-check-label']) !!}

        {{-- {!! Form::text('track_manufacture_date', old('track_manufacture_date', isset($item->track_manufacture_date) ? $item->track_manufacture_date : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off'] ) !!} --}}

        @if ($errors->has('track_manufacture_date'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('track_manufacture_date') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('use_expiry_dates', 'Use expiry date') !!}

        <br/>
        {!! Form::radio('use_expiry_dates', 1, isset($item->track_manufacture_date) && ($item->use_expiry_dates == 1) ? true : true, ['id' => 'use_expiry_dates_yes']) !!}
        {!! Form::label('use_expiry_dates_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('use_expiry_dates', 0, isset($item->track_manufacture_date) && ($item->use_expiry_dates == 0) ? true : false, ['id' => 'use_expiry_dates_no']) !!}
        {!! Form::label('use_expiry_dates_no', 'No', ['class' => 'form-check-label']) !!}

        {{-- {!! Form::text('use_expiry_dates', old('use_expiry_dates', isset($item->use_expiry_dates) ? $item->use_expiry_dates : ''), ['class' => 'form-control datepicker', 'autocomplete' => 'off'] ) !!} --}}

        @if ($errors->has('use_expiry_dates'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('use_expiry_dates') }}</strong>
            </span>
        @endif
    </div>
</fieldset>
<div class="form-group">
    {!! Form::label('is_gst_detail', 'Set GST Details?') !!}
    <br/>
    {!! Form::radio('is_gst_detail', 1, isset($item->is_gst_detail) && ($item->is_gst_detail == 1) ? true : true, ['id' => 'is_gst_detail_yes']) !!}
    {!! Form::label('is_gst_detail_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('is_gst_detail', 0, isset($item->is_gst_detail) && ($item->is_gst_detail == 0) ? true : false, ['id' => 'is_gst_detail_no']) !!}
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
        {!! Form::select('taxability', $taxablity_types, old('taxability', isset($item->taxability) ? $item->taxability : ''), ['class' => 'form-control taxability', 'id' => 'taxability'] ) !!}
        @if ($errors->has('taxability'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('taxability') }}</strong>
            </span>
        @endif
    </div>
    <div class="gst-detail-subblock d-none">
        <div class="form-group">
            {!! Form::label('is_reverse_charge', 'Is reverse charge applicable?') !!}
            <br/>
            {!! Form::radio('is_reverse_charge', 1, isset($item->is_reverse_charge) && ($item->is_reverse_charge == 1) ? true : true, ['id' => 'is_reverse_charge_yes']) !!}
            {!! Form::label('is_reverse_charge_yes', 'Yes', ['class' => 'form-check-label']) !!}

            {!! Form::radio('is_reverse_charge', 0, isset($item->is_reverse_charge) && ($item->is_reverse_charge == 0) ? true : false, ['id' => 'is_reverse_charge_no']) !!}
            {!! Form::label('is_reverse_charge_no', 'No', ['class' => 'form-check-label']) !!}

            @if ($errors->has('is_reverse_charge'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_reverse_charge') }}</strong>
                </span>
            @endif
        </div>
        {{-- <div class="form-group">
            {!! Form::label('tax_type', 'Tax Type') !!}
            {!! Form::select('tax_type', $tax_types, old('tax_type', isset($item->tax_type) ? $item->tax_type : ''), ['class' => 'form-control'] ) !!}
            @if ($errors->has('tax_type'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('tax_type') }}</strong>
                </span>
            @endif
        </div> --}}
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('rate', 'Rate(%)') !!}
                    {!! Form::text('rate', old('rate', isset($item->rate) ? $item->rate : ''), ['class' => 'form-control', 'placeholder' => 'Rate']) !!}
                    @if ($errors->has('rate'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('rate') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-12">
                    {!! Form::label('applicable_date', 'Applicable Date') !!}
                    {!! Form::text('applicable_date', old('applicable_date', isset($item->applicable_date) ? $item->applicable_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Applicable Date', 'autocomplete' => 'off']) !!}
                    @if ($errors->has('applicable_date'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('applicable_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('cess', 'Cess(%)') !!}
                    {!! Form::text('cess', old('cess', isset($item->cess) ? $item->cess : ''), ['class' => 'form-control', 'placeholder' => 'Cess']) !!}
                    @if ($errors->has('cess'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('cess') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-12">
                    {!! Form::label('cess_applicable_date', 'Applicable Date') !!}
                    {!! Form::text('cess_applicable_date', old('cess_applicable_date', isset($item->cess_applicable_date) ? $item->cess_applicable_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Applicable Date', 'autocomplete' => 'off']) !!}
                    @if ($errors->has('cess_applicable_date'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('cess_applicable_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @if(isset($item->taxability))
        <fieldset class="gst-detail-block scheduler-border">
         <legend class="scheduler-border">Previous GST Detail</legend>
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('rate', 'Rate(%)') !!}
                    @if(isset($gstStock))
                    <input type="text" name="" id="rate" class="form-control rate" value="{{$gstStock->rate}}" readonly>
                    @else
                    <input type="" name="" readonly="" class="form-control" value="-">
                    @endif
                    @if ($errors->has('rate'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('rate') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="col-md-12">
                    {!! Form::label('applicable_date', 'Applicable Date') !!}
                    @if(isset($gstStock))
                    <input type="text" name="" class="form-control" value="{{$gstStock->applicable_date}}"  readonly>
                    @else
                    <input type="" name="" class="form-control" readonly="" value="-">
                    @endif
                    @if ($errors->has('applicable_date'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('applicable_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <input type="hidden" name="stock_item_id" value="{{$item->id}}">
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('cess', 'Cess(%)') !!}
                    @if(isset($gstStock))
                    <input type="text" name="" class="form-control" value="{{$gstStock->cess_rate}}" readonly>
                    @else
                    <input type="text" name="" class="form-control" value="-" readonly>
                    @endif
                    @if ($errors->has('cess'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('cess') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-12">
                    {!! Form::label('cess_applicable_date', 'Applicable Date') !!}
                    @if($gstStock)
                    <input type="text" name="" class="form-control" value="{{$gstStock->cess_applicable_date}}" readonly>
                    @else
                    <input type="text" name="" class="form-control" readonly="" value="-">
                    @endif
                    
                    @if ($errors->has('cess_applicable_date'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('cess_applicable_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
        @endif
    </div>
</fieldset>
<div class="form-group">
    {!! Form::label('default_warehouse', 'Default Warehouse ') !!}
    {!! Form::select('default_warehouse', ['' => 'Select a Default Warehouse'] + $warehouses, old('default_warehouse', isset($item->default_warehouse) ? $item->default_warehouse : ''), ['class' => 'form-control'] ) !!}
    @if ($errors->has('default_warehouse'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('default_warehouse') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-sm-12">
            {!! Form::label('supply_type', 'Type Of Supply') !!}
            {!! Form::select('supply_type', ['0' => 'Select a Type'] + $supply_types, old('supply_type', isset($item->supply_type) ? $item->supply_type : ''), ['class' => 'form-control'] ) !!}
            @if ($errors->has('supply_type'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('supply_type') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-sm-12">
            {!! Form::label('hsn_code', 'HSN Code ') !!}
            {!! Form::number('hsn_code', old('hsn_code', isset($item->hsn_code) ? $item->hsn_code : ''), ['class' => 'form-control', 'placeholder' => 'HSN Code']) !!}
            @if ($errors->has('hsn_code'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('hsn_code') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-sm-12">
            {!! Form::label('opening_stock', 'Opening Stock',['class'=>'opening_stock ']) !!}
            {!! Form::text('opening_stock', old('opening_stock', isset($item->opening_stock) ? $item->opening_stock : ''), ['class' => 'form-control opening_stock','id'=>'opening_stock', 'placeholder' => 'Opening Stock']) !!}
            @if ($errors->has('opening_stock'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('opening_stock') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-sm-12">
            {!! Form::checkbox('maintain_stock', 1, isset($item->maintain_stock) && ($item->maintain_stock==1) ? true : false,['class'=>'maintain_stock','id' => 'maintain_stock'])!!}
            {!! Form::label('maintain_stock', 'Maintain Stock') !!}
            @if ($errors->has('maintain_stock'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('maintain_stock') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-sm-12">
            {!! Form::label('product_code', 'Product Code ') !!}
            {!! Form::text('product_code', old('product_code', isset($item->product_code) ? $item->product_code : ''), ['class' => 'form-control', 'placeholder' => 'Product Code']) !!}
            @if ($errors->has('product_code'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('product_code') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-sm-12">
            {!! Form::label('cas_no', 'Cas No. ') !!}
            {!! Form::text('cas_no', old('cas_no', isset($item->cas_no) ? $item->cas_no : ''), ['class' => 'form-control', 'placeholder' => 'Cas No']) !!}
            @if ($errors->has('cas_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('cas_no') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('pack_code', 'Pack Code. ') !!}
    {!! Form::text('pack_code', old('pack_code', isset($item->pack_code) ? $item->pack_code : ''), ['class' => 'form-control', 'placeholder' => 'Pack Code']) !!}
    @if ($errors->has('pack_code'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('pack_code') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary testIm']) !!}
    {!! link_to_route('stock-items.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            hideShowSection = function(element, type) {
                if(type == 1)
                {
                    element.show();
                }
                else
                {
                    element.hide();
                }
            }

            hideShowGstSubSection = function(selected_val) {
                if(selected_val)
                {
                    if(selected_val == 'taxable')
                    {
                        $('.gst-detail-subblock').removeClass('d-none');
                    }
                    else
                    {
                        $('.gst-detail-subblock').addClass('d-none');
                    }
                }
            }

            setGSTDetailsFromGroup = function(group_id) {
                $(".gst-detail-block input[type='text']").val("");
                $('.gst-detail-block #is_reverse_charge_no').prop('checked', true);
                $('#taxability').get(0).selectedIndex = 0;
                $('.gst-detail-subblock').addClass('d-none');

                var group_route = "{{ route('stock-groups.show', ':id') }}";
                group_route = group_route.replace(':id', group_id);

                $.ajax({
                    type: 'GET',
                    url: group_route,
                    success: function (data) {
                        if(data.success == true && data.group != undefined) {

                            var type = $(':radio[name="is_gst_detail"]:checked').val();

                            if(type == 1) {
                                if(data.group.taxability) {
                                    $('.gst-detail-block .taxability').val(data.group.taxability);

                                    hideShowGstSubSection(data.group.taxability);
                                    if(data.group.taxability == 'taxable') {

                                        var reverse_charge_id = '#is_reverse_charge_no';
                                        if((data.group.is_reverse_charge) != null && (data.group.is_reverse_charge == 1)) {
                                            reverse_charge_id = '#is_reverse_charge_yes';
                                        }

                                        $(document).find(reverse_charge_id).prop('checked', true);
                                        $('.gst-detail-block #rate').val(data.group.gst_rate);
                                        $('.gst-detail-block #applicable_date').val(data.group.gst_applicable_date);
                                        $('.gst-detail-block #cess').val(data.group.cess_rate);
                                        $('.gst-detail-block #cess_applicable_date').val(data.group.cess_applicable_date);
                                    }
                                }
                            }

                        }
                    }
                });
            }

            var type = $(':radio[name="is_gst_detail"]:checked').val();
            hideShowSection($('.gst-detail-block'), type);

            var selected_val = $('.taxability').val();
            hideShowGstSubSection(selected_val);

            var type_1 = $(':radio[name="is_maintain_in_batches"]:checked').val();
            hideShowSection($('.hidden-block'), type_1);

            $(document).on('change', ':radio[name="is_gst_detail"]', function(){
                var type = $(this).val();
                hideShowSection($('.gst-detail-block'), type);
            });

            $(document).on("change", '.taxability', function(){
                var selected_val = $(this).val();
                hideShowGstSubSection(selected_val);
            });

            $(document).on('change', ':radio[name="is_maintain_in_batches"]', function() {
                var type = $(this).val();
                hideShowSection($('.hidden-block'), type);
            });
            $('.opening_stock').hide();
            if ($('input.maintain_stock').is(':checked')) {
                $('.opening_stock').show();
            }
            $(document).on('change', ':checkbox[name="maintain_stock"]', function() {
                // Get the checkbox
                var maintain_stock = document.getElementById("maintain_stock");
                if(maintain_stock.checked == true)
                {
                    var type=1;
                }else{
                    var type=0;
                }
                hideShowSection($('.opening_stock'), type);
            });

            $('.selected_unit').text($('#unit_id option:selected').text());

            $(document).on('change', '#unit_id', function() {
                var unit_id = $(this).val();
                /*alert(unit_id);*/
                var alternate_unit_select = '{!! Form::select('alternate_unit_id', ['0' => 'Select a Unit'] + $units, null, ['class' => 'form-control', 'id' => 'alternate_unit']) !!}';

                $('.alter-select-box').html(alternate_unit_select);

                if(unit_id && (unit_id != 0))
                {
                    $('.selected_unit').text($('#unit_id option:selected').text());
                    $(document).find("#alternate_unit >option[value='" + unit_id + "']").remove();
                }
                else
                {
                    $('.selected_unit').text('');
                }
            });

            $(document).on('change', '#under', function() {
                var group_id = $(this).val();
                setGSTDetailsFromGroup(group_id);
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
            $('.convertion_rate').hide();
            $('body').on('change','#alternate_unit',function(){
                var alternate_unit=$(this).val();
                if(alternate_unit==0){
                    $('.convertion_rate').hide();
                    $('.convertion_rate').val('');
                }else{
                    $('.convertion_rate').show();
                }
            });
            $('body').on('change','#alternate_unit_id',function(){
                var alternate_unit_id=$(this).val();
                if(alternate_unit_id==0){
                    $('.convertion_rate').hide();
                    $('.convertion_rate').val('');
                }else{
                    $('.convertion_rate').show();
                }
            });
            var aui=$('#alternate_unit_id').val();
            if(aui!=0){
                $('.convertion_rate').show();
            }  
            
        });
        
    

    </script>
@endsection
