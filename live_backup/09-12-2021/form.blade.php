@php
    $element_counter = 0;
@endphp
<div class="form-group">
    @if(! isset($is_submit_show))
        {!! Form::submit('Submit', ['class' => 'btn btn-primary submitData']) !!}
    @endif
    {!! link_to_route('stocks.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
    @error('stock_transfer_no')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<!-- <div class="form-group">
    {{-- {!! Form::label('stock_transfer_no', 'Stock Transfer No') !!}
    {!! Form::text('stock_transfer_no', old('stock_transfer_no', isset($stock->stock_transfer_no) ? $stock->stock_transfer_no : ''), ['class' => 'form-control', 'placeholder' => 'Stock Transfer No', 'required' => 'required']) !!} --}}

    {{-- @if ($errors->has('stock_transfer_no'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('stock_transfer_no') }}</strong>
        </span>
    @endif --}}
    {{-- @if ($errors->has('manual_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('manual_id') }}</strong>
        </span>
    @endif --}}
    @if(isset($stock))
    <select class="form-control"  id="select1" name="series_type" disabled="true">
        <option>Select Stock Series</option>
        @foreach($stockseries as $key=>$value)    
        <option value="{{ $value->id }}" @if($stock->series_type==$value->id){{'selected'}}@endif>{{ $value->series_name }}</option>
        @endforeach
    </select>
    @else
    <select class="form-control"  id="select1" name="series_type" >
        <option>Select Stock Series</option>
        @foreach($stockseries as $key=>$value)    
        <option value="{{ $value->id }}">{{ $value->series_name }}</option>
        @endforeach
    </select>
    @endif
</div> -->
<div class="form-group">
     <div class="form-row">
        <div class="col-md-12">
    {!! Form::label('return_no', 'MR No *') !!}
           <!--  {!! Form::text('stock_transfer_no', old('stock_transfer_no', isset($stock->stock_transfer_no) ? $stock->stock_transfer_no : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!}
            <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
            @if ($errors->has('manual_id'))
                <span class="help-block text-danger">
                <strong>{{ $errors->first('manual_id') }}</strong>
                </span>
            @endif
            <input type="hidden" name="suffix" id="suffix">
            <input type="hidden" name="prefix" id="prefix">
            <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->
            @if(isset($stock))
            <input type="text" name="stock_transfer_no" value="{{$stock->stock_transfer_no}}" class="form-control" readonly>
            @else
            @foreach($stockseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="stock_transfer_no" class="form-control" placeholder="MR NO" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="stock_transfer_no" class="form-control" placeholder="Stock Transfer No">
            @endif
            @endforeach
            @endif
            

</div>
@if(!(isset($stock)))
        <div class="col-md-12">
            @php
            $document_no=\App\Models\Stock::orderBy('document_no','desc')->where('document_no','!=','0')->first();
            $document_no_app=$document_no->document_no ?? 'MR0000';
            @endphp
            <div class="document_no_issue">
                <label>Document No</label>
                {!! Form::text('document_no',old('document_no',isset($stock->document_no) ? $stock->document_no :$document_no_app),['class'=>'form-control document_no','readonly',]) !!}
            </div>
            <div class="document_no_receipt" style="display:none">
                <label>Document No</label>
                    <select class="form-control receipt_value" name="receiptvalue">
                        <option value="Select Document No">Select Document No</option>
                        @foreach($documentData as $documentDataValue)
                        <option value="{{$documentDataValue->document_no}}" qty_data="{{$documentDataValue->qty}}" 
                            sum_qty="{{$documentDataValue->quantity}}">{{$documentDataValue->document_no}}</option>

                        @endforeach
                    </select>
             </div>
        </div>
        @elseif((isset($stock)))
        <div class="col-md-12">
            @php
            $document_no=\App\Models\Stock::orderBy('id','desc')->where('document_no','!=','0')->first();
            $document_no_app=$document_no->document_no;
            @endphp
            <div class="document_no_issue">
                <label>Document No</label>
                {!! Form::text('document_no',old('document_no',isset($stock->document_no) ? $stock->document_no :'MR0000'),['class'=>'form-control document_no','readonly',]) !!}
            </div>
            <div class="document_no_receipt" style="display:none">
                <label>Document No</label>
                    <select class="form-control receipt_value" name="receiptvalue">
                        <option value="Select Document No">Select Document No</option>
                        @foreach($documentData as $documentDataValue)
                        <option value="{{$documentDataValue->document_no}}">{{$documentDataValue->document_no}}</option>
                        @endforeach
                    </select>
             </div>
        </div>
        @endif
    </div>
</div>
<div class="form-group">
    {!! Form::label('stock_transfer_type', 'Stock Transfer Type *') !!}
    {!! Form::select('stock_transfer_type', ['' => 'Select Type'] + $stock_transfer_types, old('stock_transfer_type', isset($stock->stock_transfer_type) ? $stock->stock_transfer_type : ''), ['class' => 'form-control', 'required' => 'required']) !!}

    @if ($errors->has('stock_transfer_type'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('stock_transfer_type') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('date', 'Date *') !!}
    {!! Form::text('date', old('date', isset($stock->date) ? $stock->date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Date', 'required' => 'required', 'autocomplete' => 'off']) !!}

    @if ($errors->has('date'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('date') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('default_source_warehouse', 'Default Source Warehouse') !!}
            {!! Form::select('default_source_warehouse', ['' => 'Select Warehouse'] + $warehouses, null, ['class' => 'form-control source_warehouse warehouse_select', 'id' => 'default_source_warehouse']) !!}

            @if ($errors->has('default_source_warehouse'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('default_source_warehouse') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('default_target_warehouse', 'Default Target Warehouse') !!}
            {!! Form::select('default_target_warehouse', ['' => 'Select Warehouse'] + $warehouses, null, ['class' => 'form-control target_warehouse warehouse_select', 'id' => 'default_target_warehouse']) !!}

            @if ($errors->has('default_target_warehouse'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('default_target_warehouse') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('items', 'Items') !!}
    <table class="table table-bordered">
        <thead>
            <tr>
                {{-- <th scope="col"></th> --}}
                <th scope="col">Source Warehouse</th>
                {{-- <th scope="col">Item Code</th> --}}
                <th scope="col">Item Name</th>
                <th scope="col">Source Batch</th>
                <th scope="col">UOM</th>
                <th scope="col" class="available_qtyData">Available Quantity</th>
                <th scope="col">Quantity *</th>

                <th scope="col">Rate *</th>
                <th scope="col">Target Warehouse</th>
                <th scope="col">Target Batch</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody class="add-items-list">
            @if(isset($stock->stock_source_items) && !empty($stock->stock_source_items))
                @foreach($stock->stock_source_items as $sKey => $stock_source_item)
                    <tr class="new-item">
                        {{-- <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label>
                            </div>
                        </td> --}}
                        <td>
                            {!! Form::select("source_items[$element_counter][source_warehouse]", $warehouses, $stock_source_item->source_warehouse, ['class' => 'form-control source_warehouse warehouse_select swarehouse', 'data-name' => 'source_warehouse', 'required' => 'required']) !!}
                        </td>

                        {{-- <td>
                            {!! Form::select("source_items[$element_counter][item_code]", ['' => 'Select Item Code'] + $stock_items_codes, $stock_source_item->item_id, ['class' => 'form-control item_code select2-elem','data-name' => 'item_code', 'required' => 'required']) !!}
                        </td> --}}
                        <td>
                            <select id="item_name" name="source_items[{{$element_counter}}][item_name]" data-plugin-selectTwo class="form-control item_name select2-elem select2 selected_item" data-name="item_name" required="required">
                                <option value="">Select Item</option>
                                    @if(!empty($stockItem))
                                        @foreach($stockItem as $value)
                                            <option value="{{ $value->id }}" @if($stock_source_item->item_id == $value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                                        @endforeach
                                    @endif
                            </select>
                        </td>
                        <td>
                            <!-- {!! Form::select("source_items[$element_counter][batch]", ['' => 'Select Batch'], $stock_source_item->batch_id, ['class' => 'form-control batch select2-elem', 'data-name' => 'batch']) !!} -->

                              {!! Form::select("source_items[$element_counter][batch]", ['' => 'Select Batch'] + $batches, $stock_source_item->batch_id, ['class' => 'form-control source_batch select2-elem', 'data-name' => 'batch']) !!}
                        </td>
                        <td>
                            {!! Form::select("source_items[$element_counter][uom]", isset($stock_items_units[$stock_source_item->item_id]) ? $stock_items_units[$stock_source_item->item_id] : '', $stock_source_item->uom, ['class' => 'form-control uom', 'data-name' => 'uom', 'required' => 'required']) !!}
                        </td>
                       
                        <td>
                         @if(!empty($stock->stock_managements[$element_counter]->balance_qty))
                           {!! Form::text("balance_qty", 
                           $stock->stock_managements[$element_counter]->balance_qty, ['class' => 'form-control available_qty', 'placeholder' => 'Quantity', 'data-name' => 'quantity', 'required' => 'required','disabled']) !!}
                           @endif
                        </td>
                        
                        <td>
                            {!! Form::text("source_items[$element_counter][quantity]", $stock_source_item->quantity, ['class' => 'form-control', 'placeholder' => 'Quantity', 'data-name' => 'quantity', 'required' => 'required']) !!}
                        </td>
                        <td>
                            {!! Form::text("source_items[$element_counter][rate]", $stock_source_item->rate, ['class' => 'form-control', 'placeholder' => 'Rate', 'data-name' => 'rate', 'required' => 'required']) !!}
                        </td>
                        <td>
                            {!! Form::select("source_items[$element_counter][target_warehouse]", $warehouses, $stock_source_item->target_warehouse, ['class' => 'form-control target_warehouse warehouse_select', 'data-name' => 'target_warehouse', 'required' => 'required']) !!}
                        </td>
                        <td>
                           <!--  {!! Form::select("source_items[$element_counter][target_batch]", ['' => 'Select Batch'] + $batches, $stock_source_item->target_batch_id, ['class' => 'form-control tbatch select2-elem', 'data-name' => 'batch']) !!} -->
                            {!! Form::select("source_items[$element_counter][target_batch]", ['' => 'Select Batch'] + $batches, $stock_source_item->target_batch_id, ['class' => 'form-control target_batch tbatch', 'data-name' => 'target_batch']) !!}
                        </td>
                        <td>
                            <div class="delete-item-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-item btn-danger" data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Delete Item">
                                        <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $element_counter++;
                    @endphp
                @endforeach
            @else
                <tr class="new-item">
                    {{-- <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1"></label>
                        </div>
                    </td> --}}
                    <td>
                        <!-- {!! Form::select("source_items[$element_counter][source_warehouse]", ['' => 'Select Warehouse'] + $warehouses, null, ['class' => 'form-control source_warehouse warehouse_select', 'data-name' => 'source_warehouse']) !!} -->
                        {!! Form::select("source_items[$element_counter][source_warehouse]", ['' => 'Select Warehouse'] 
                        +$warehouses, null, ['class' => 'form-control source_warehouse warehouse_select swarehouse', 'data-name' => 'source_warehouse']) !!}
                    </td>
                    <td>
                        <select id="item_name" name="source_items[{{$element_counter}}][item_name]" data-plugin-selectTwo class="form-control item_name select2-elem select2 selected_item" data-name="item_name" required="required">
                            <option value="">Select Item</option>
                                @if(!empty($stockItem))
                                    @foreach($stockItem as $value)
                                        <option value="{{ $value->id }}"> {{ $value->pack_code.'-'.$value->name }} </option>
                                    @endforeach
                                @endif
                        </select>
                       {{--  {!! Form::select("source_items[$element_counter][item_code]", ['' => 'Select Item Code'] + $stock_items_codes, null, ['class' => 'form-control item_code select2-elem','data-name' => 'item_code', 'required' => 'required']) !!} --}}
                    </td>
                    <td>
                        <!-- {!! Form::select("source_items[$element_counter][batch]", ['' => 'Select Batch'] , null, ['class' => 'form-control batch select2-elem', 'data-name' => 'batch']) !!} -->
                         {!! Form::select("source_items[$element_counter][batch]", ['' => 'Select Batch'], null, ['class' => 'form-control source_batch batch select2-elem', 'data-name' => 'batch']) !!}
                    </td>
                   {{--  <td>
                        {!! Form::select("source_items[$element_counter][item_name]", ['' => 'Select Item Name'] + $stock_items_names, null, ['class' => 'form-control item_name select2-elem', 'data-name' => 'item_name', 'required' => 'required']) !!}
                    </td>  --}}
                    <td>
                        {!! Form::select("source_items[$element_counter][uom]", ['' => 'Select Unit'], null, ['class' => 'form-control uom', 'data-name' => 'uom', 'required' => 'required']) !!}
                    </td>
                    <td>
                        <input type="text" name="" class="form-control available_qty" value="0" readonly>
                       
                    </td>
                    <td>
                        {!! Form::text("source_items[$element_counter][quantity]", old('quantity'), ['class' => 'form-control', 'placeholder' => 'Quantity', 'data-name' => 'quantity', 'required' => 'required']) !!}
                    </td>
                    
                    <td>
                        {!! Form::text("source_items[$element_counter][rate]", old('quantity'), ['class' => 'form-control', 'placeholder' => 'Rate', 'data-name' => 'rate', 'required' => 'required']) !!}
                    </td>
                    <td>
                        {!! Form::select("source_items[$element_counter][target_warehouse]",['' => 'Select Warehouse'] +$warehouses, null, ['class' => 'form-control target_warehouse warehouse_select', 'data-name' => 'target_warehouse']) !!}
                    </td>
                    <td>
                        <!-- {!! Form::select("source_items[$element_counter][target_batch]", ['' => 'Select Batch'] + $batches, null, ['class' => 'form-control tbatch select2-elem', 'data-name' => 'batch']) !!} -->
                         {!! Form::select("source_items[$element_counter][target_batch]", ['' => 'Select Batch'], null, ['class' => 'form-control target_batch tbatch','data-name' => 'target_batch']) !!}

                    </td>
                    <td>
                        <div class="delete-item-block">
                            <a href="javascript:void(0);"
                                class="btn btn-remove delete-item btn-danger" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Delete Item">
                                    <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
             @if(isset($stock))
            @php
                $test=\App\Models\Stock::where('document_no',$stock->document_no)->count();
            @endphp
            @endif
            <tr>
                <td colspan="9">
                    @if(isset($test))
                    @if($test==1)
                    <a href="javascript:void(0);" class="btn btn-add add-item btn-success add-button" data-toggle="tooltip" data-placement="bottom" title="Add New Item">Add Row</a>
                    @endif
                    @else
                    <a href="javascript:void(0);" class="btn btn-add add-item btn-success add-button" data-toggle="tooltip" data-placement="bottom" title="Add New Item">Add Row</a>
                    @endif
                </td>
                
               
                
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group">
    @if(! isset($is_submit_show))
        {!! Form::submit('Submit', ['class' => 'btn btn-primary submitData']) !!}
    @endif
    {!! link_to_route('stocks.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>

@section('scripts')
<script type="text/javascript">
    var getdata="{{ url('admin/stockdata/') }}/";
</script>
<script type="text/javascript">
    $(document).ready(function() {
        addItem = function(element, item, element_counter)
        {
            item.find(".select2-elem").each(function(index)
            {
                $(this).select2('destroy');
            });

            var item_template = item.clone();

            item_template.find('input, select').each(function() {
                this.name = 'source_items[' + element_counter + '][' + $(this).data('name') + ']';
                this.value = '';

                if($(this).data('name') == 'source_warehouse')
                {
                    if($("#default_source_warehouse").val())
                        this.value = $("#default_source_warehouse").val();
                }
                else if($(this).data('name') == 'target_warehouse')
                {
                    if($("#default_target_warehouse").val())
                        this.value = $("#default_target_warehouse").val();
                }
                else if($(this).data('name') == 'uom')
                {
                    $(this).find('option').remove();
                }
            });

            item_template.find(".select2-elem").select2();

            element.append(item_template);
        };

        handleWarehouseShow = function(type) {
            $('.warehouse_select').prop("disabled", false);

            if(type == 'material_issue')
            {
                $('.target_warehouse').prop("disabled", true);
            }
            else if(type == 'material_receipt')
            {
                $('.source_warehouse').prop("disabled", true);
            }
        };

        setUOM = function(element, item_id) {
            var select_box = element.find(".uom");
            $.ajax({
                url: config.routes.url + '/admin/item/' + item_id + '/units',
                type: 'GET',
                success:function(response) {
                    if (response.success)
                    {
                        select_box.find('option').remove();

                        $.each(response.data, function(index, el) {
                            $('<option/>', {
                                'value': index,
                                'text': el
                            }).appendTo(select_box);
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };

        setBatch = function(element, item_id,warehouse_id) {
            if(item_id != '' && warehouse_id != 'undefined')
            {
                var select_box = element.find(".source_batch");
                 /*var select_box = element.find(".batch");*/
                $.ajax({
                    url: config.routes.url + '/admin/warehouse_stock/' + item_id + '/' + warehouse_id +'/batches',
                    type: 'GET',
                    success:function(response) {
                        if (response.success)
                        {
                            select_box.find('option').remove();

                            /*$.each(response.data, function(index, el) {
                                $('<option/>', {
                                    'value': index,
                                    'text': el
                                }).appendTo(select_box);
                            });*/
                            $.each(response.data, function(key,value) {
                                $('<option value='+value.id+'>'+value.batch_id+'</option>').appendTo(select_box);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        };
        /// New Code for target batch fetch ///
        setTargetBatch = function(element, item_id,warehouse_id) {
            if(item_id != '' && warehouse_id != 'undefined')
            {
                var select_box = element.find(".target_batch");
                
                $.ajax({
                    url: config.routes.url + '/admin/warehouse_stock/' + item_id + '/' + warehouse_id +'/batches',
                    type: 'GET',
                    success:function(response) {
                       
                        //console.log(response.data);
                        if (response.success)
                        {
                            select_box.find('option').remove();

                            $.each(response.data, function(key,value) {
                                $('<option value='+value.id+'>'+value.batch_id+'</option>').appendTo(select_box);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        };
         /// End code target batch fetch ///
        var selected_val = $('#stock_transfer_type').val();
        handleWarehouseShow(selected_val);

        $(document).on('change', '#stock_transfer_type', function() {
            var selected_val = $(this).val();
            handleWarehouseShow(selected_val);
             if(selected_val=='material_receipt')
            {
                $('.document_no_receipt').show();
                $('.document_no_issue').hide();
                $('.add-button').hide();
            }
            else if(selected_val=='material_issue' || selected_val=='material_transfer')
            {
                $('.document_no_receipt').hide();
                $('.document_no_issue').show();
                $('.add-button').show();

            }
        });

        var element_counter = "{{ $element_counter }}"

        $(document).on('click', '.add-item', function(e) {
            e.preventDefault();
            $('.error').text('');
            var errors = [];
            var $that = $(this);

            var item = $(".add-items-list").children("tr.new-item:last-child");

            var has_error = false;

            item.find('input[type=text]').each(function(){
                if (! $(this).val()) {
                    $(this).trigger('focus');
                    has_error = true;
                    errors.push(false);
                    return false;
                }
                has_error = false;
            });

            var transfer_type = $("#stock_transfer_type").val();

            item.find('.select2-elem').each(function(){
                if(((transfer_type == 'material_issue') && ($(this).data('name') == 'target_warehouse')) || ((transfer_type == 'material_receipt') && ($(this).data('name') == 'source_warehouse')))
                {
                    has_error = false;
                }
                else if (!($(this).val() && $(this).val().length)) {
                    if($(this).hasClass('select2-elem'))
                    {
                        $(this).select2('open');
                    }
                    else
                    {
                        $(this).trigger('focus');
                    }
                    has_error = true;
                    errors.push(false);
                    return false;
                }
                has_error = false;
            });

            var validate_values = errors.includes(false);

            if ((! has_error) && (! validate_values)) {
                $(".error").text("");
                element_counter++;

                //addItem($(".add-item-list"),element_counter)
                addItem($(".add-items-list"), item, element_counter);

                //var last_item = $(".add-items-list").children("tr.new-item:last-child");
            }
        });

        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            var item_count = $(this).closest(".add-items-list").children("tr.new-item").length;

            if(item_count > 1)
            {
                if(confirm('Are you sure?'))
                {
                    $(this).parents('.new-item').remove();
                }
            }
            else
            {
                $(".error").text("You must have to add at least one item.");
            }
        });

        $(document).on('change', '#default_source_warehouse', function() {
            var selected = $(this).val();
            var item_count = $(".add-items-list").children("tr.new-item").length;

            if((item_count == 1) && selected)
            {
                $(".add-items-list .source_warehouse").val(selected);
            }
        });

        $(document).on('change', '#default_target_warehouse', function() {
            var selected = $(this).val();
            var item_count = $(".add-items-list").children("tr.new-item").length;

            if((item_count == 1) && selected)
            {
                $(".add-items-list .target_warehouse").val(selected);
            }

            ///New Coding for selected batch in material Receipt
            var target_warehouse=$('.default_target_warehouse').val(selected);
            var target_warehouse_value=target_warehouse.val();

            var add_more_item=$('td.add-more-value').find('.maheshItem').val();
          
            var inputs = $(".maheshItem");
            var inputs2 = $(".add-more-item");
            
            for(var i = 0; i < inputs.length; i++){
            var bc=($(inputs[i]).val());
            console.log(bc);
            //var index2 = i;
            //alert(bc);
             var data = {
                    "_token": "{{ csrf_token() }}",
                    target_warehouse:target_warehouse_value,
                    item_name:bc,
                }
             resolveAfter2Seconds(data, i);
            }           
        });

         function resolveAfter2Seconds(data, i) {
          return new Promise(resolve => {

            $.ajax({
                url:"{{url('admin/stockaddmorevalue')}}",
                data:data,
                dataType:'json',
                success:function(response){
                    
                    console.log(response);
                    var mahi=response;
                    $('.target_mahesh_batch')[i].value ='';
                    $.each(mahi,function(key,value){


                        $( ".add-more-item" ).each(function( index ) {
                          //console.log( index + ": " + $( this ).text() );
                          if(index == i){
                            console.log($( this ).find('.mka'))
                           /* $( this ).find('.mka').find('.target_mahesh_batch').val(bv)*/
                           $( this ).find('.mka').find('.target_mahesh_batch').html('<option value="'+value.id+'">'+value.batch_id+'</option>')

                          }
                        });
                        resolve(true);
                        //$(inputs2[i]).find('.target_mahesh_batch').val(bv);
                       // $('.target_mahesh_batch').val(bv);

                    })
                }

            })
            //setTimeout(() => {
             // resolve('resolved');
            //}, 2000);
          });
        }
//// Finish Here/////////////////
        $(document).on('change', '.item_code', function() {
            var selected = $(this).val();
            var element = $(this).closest('.new-item').find('.item_name');
            var org_selected = element.val();

            if(selected != org_selected)
            {
                element.select2("val", selected);
                setUOM($(this).closest('.new-item'), selected);
            }
        });

        $(document).on('change', '.item_name', function() {
            var selected = $(this).val();
            var element = $(this).closest('.new-item').find('.item_code');
            var org_selected = element.val();
            if(selected != org_selected)
            {
                element.select2("val", selected);
                setUOM($(this).closest('.new-item'), selected);

                var warehouse_id;

                var type = $("#stock_transfer_type").val();

                if(type == 'material_issue')
                {
                    warehouse_id = $(this).closest('.new-item').find(".source_warehouse").val();
                }
                else if(type == 'material_receipt')
                {
                    warehouse_id = $(this).closest('.new-item').find(".target_warehouse").val();
                }else{
                    warehouse_id = $(this).closest('.new-item').find(".source_warehouse").val();
                }
                if(type=='')
                {
                    alert('Please select stock transfet type');
                }else if(warehouse_id==''){
                    alert('Please select warehouse');
                }else{
                    setBatch($(this).closest('.new-item'), selected,warehouse_id);
                }

            }
        });

        $(document).on('change', '.target_warehouse', function() {
            var selected = $(this).val();
            var element = $(this).closest('.new-item').find('.target_warehouse');
            var org_selected = element.val();
            if(selected != org_selected)
            {
                element.select2("val", selected);
                setUOM($(this).closest('.new-item'), selected);
            }

            var type = $("#stock_transfer_type").val();
            /*var type = $("#stock_transfer_type").val();
            if(type == 'material_issue')
            {
                warehouse_id = element.find(".source_warehouse").val();
            }
            else if(type == 'material_receipt')
            {
                warehouse_id = element.find(".target_warehouse").val();
            }else{
                warehouse_id = element.find(".target_warehouse").val();
            }*/
            var item_id = $(this).closest('.new-item').find('.item_name').val();
            if(item_id != '')
            {
                if(type=='')
                {
                    alert('Please select stock transfet type');
                }else{
                    //setBatch($(this).closest('.new-item'), item_id,selected);
                    setTargetBatch($(this).closest('.new-item'), item_id,selected);
                }
            }
        });

        $(document).on('change', '.source_warehouse', function() {
            var selected = $(this).val();
            var element = $(this).closest('.new-item').find('.source_warehouse');
            var org_selected = element.val();
            if(selected != org_selected)
            {
                element.select2("val", selected);
                setUOM($(this).closest('.new-item'), selected);
            }
            var type = $("#stock_transfer_type").val();
            if(type == 'material_issue')
            {
                var item_id = $(this).closest('.new-item').find('.item_name').val();
                if(item_id != '')
                {
                    if(type=='')
                    {
                        alert('Please select stock transfet type');
                    }else{
                        setBatch($(this).closest('.new-item'), item_id,selected);
                    }
                }

            }
        });
        var stock_transfer_type=$('#stock_transfer_type').val();
        if(stock_transfer_type == 'material_receipt'){
            $('.add-button').hide();
        }
//// New Coding for material Receipt
    
        $(document).on('change','.receipt_value',function(){
                        @php
                        $element_counter = 0;
                        @endphp
            $('.add-button').hide();
            var receiptvalue=$(this).val();
             var maheshItem=$('.maheshItem').val();   
             $('.remaining_qty').show();


            $.ajax({
                url:"{{url('admin/stocksourceitemdata')}}",
                 type:"get",
                data:{

                      "_token": "{{ csrf_token() }}",
                      receiptvalue:receiptvalue,
                      maheshItem:maheshItem,

                },
                dataType:'JSON',
                success:function(response){
                        @php
                        $element_counter++;
                    @endphp
                    var warehousevalue = {!! json_encode($warehouses) !!};
                    var warrhouseoption='<option value="Select Warehouse">Select Warehouse</option>';

                        $.each(warehousevalue,function(key,value){

                            warrhouseoption+='<option value="'+key+'">'+value+'</option>'
                        });
                        var remaining_qty='';
                        /*$.each(response.stockIssueData,function(key,value){
                            console.log('asha');
                            console.log(value.remaining_qty);
                            remaining_qty+='<option value="'+key+'">'+value.remaining_qty+'</option>'
                        });*/


                    $.each(response.data,function(key,value){
                        if(value.batch!=null){
                            var batch=value.batch.batch_id
                        }else{
                            var batch='';
                        }
                        var rq = response.remaining_data[key].remaining_qty;          
                        
                    var tableData='<tr class="new-item add-more-item">'+
                        /*'<td>'+
                        '<input type="text" name="source_items['+element_counter+'][source_warehouse]"class="form-control" value='+value.source_warehouse+'>'+'</td>'+*/
                        '<td>'+'<select name="source_items['+element_counter+'][source_warehouse]" class="form-control warehousesMahesh" >'+'<option value="'+value.source_warehouse+'">'+value.warehouse.name+'</option>'+'</select>'+'</td>'+
                                    
                                    '<td class="add-more-value">'+'<select name="source_items['+element_counter+'][item_name]" class="form-control item_name maheshItem">'+'<option value="'+value.stock_item_id+'">'+value.stock_item_id+'</option>'+'</select>'+'</td>'+
                                    /*'<td>'+'<input type="text" name="source_items['+element_counter+'][batch]" class="form-control" value='+value.batch_id+'>'+'</td>'+
                                    */
                                    '<td>'+'<select name="source_items['+element_counter+'][batch]" >'+'<option value="'+batch+'">'+batch+'</option>'+'</select>'+'</td>'+


                                    /*'<td>'+'<input type="text" name="source_items['+element_counter+'][uom]"class="form-control" value='+value.uom+'>'+'</td>'+*/
                                    '<td>'+'<select name="source_items['+element_counter+'][uom]" class="form-control">'+'<option value="'+value.uom+'">'+value.uom+'</option>'+'</select>'+'</td>'+

                                    '<td>'+'<input type="text" name="source_items['+element_counter+'][quantity]" required="required"class="form-control remaining_qty_data" value="'+rq+'" readonly="true">'+'</td>'+

                                    '<td>'+'<input type="text" name="source_items['+element_counter+'][quantity]" required="required"class="form-control source_quantity" value='+''+'>'+'</td>'+

                                    '<td>'+'<input type="text" name="source_items['+element_counter+'][rate]" class="form-control" value='+value.rate+' >'+'</td>'+
 

                                    /*'<td>'+'<input type="text" name="source_items['+element_counter+'][target_warehouse]" class ="form-control target_warehouse warehouse_select default_target_warehouse", "data-name" = "target_warehouse">'+'</td>'+*/

                       '<td>'+'<select name="source_items['+element_counter+'][target_warehouse]" class="form-control target_warehouse warehouse_select default_target_warehouse" >'+warrhouseoption+'</select></td>'+
                                    /*
                                    '<td>'+'<select name="source_items['+element_counter+'][target_warehouse]" class="form-control target_warehouse warehouse_select default_target_warehouse" >'+'<option value="'+value.source_warehouse+'">'+value.warehouse.name+'</option>'+'</select>'+'</td>'+*/




 

                                     /*'<td class="mka">'+'<input type="text" name="source_items['+element_counter+'][target_batch]" class="form-control target_mahesh_batch">'+'</td>'+*/
                                     '<td class="mka">'+'<select class="form-control target_batch tbatch select2-elem target_mahesh_batch " name=" source_items['+element_counter+'][target_batch]"></select>'+'</td>'+ 
                                        
                        '</tr>';
                            //$('.add-items-list').children().remove();                           
                             $('.add-items-list').append(tableData);
                             element_counter++;

                             $(document).on('change','.maheshItem',function(){
                                alert('hello');
                             })
                       
                    });
                }
            })
        });
        $(document).on('change','.receipt_value',function(){
            var tbodyremove=$('.add-items-list');
            $(tbodyremove).children().remove();
        })
        
        $(document).on('change','.source_quantity',function(){
            var $this=this;
            var take_quantity=$(this).val();
            var inttq=parseInt(take_quantity);
            var source_quantity=$($this).closest('tr').find('.remaining_qty_data').val();
               
            var intsq=parseInt(source_quantity);
            var sum_quanity=$('.receipt_value option:selected').attr('sum_qty');
                sum_quanity=sum_quanity.replace('-','');
            var intsum=parseInt(sum_quanity);

            if(inttq > intsq){
                alert('can not add more then remaining Quantity');
                $($this).closest('tr').find('.source_quantity').val('');
            }

        })

         /*$(document).on('click','.submitData',function(){
            var $this=this;
            var take_quantity=$($this).closest('tr').find('.source_quantity').val();
            var inttq=parseInt(take_quantity);
            var source_quantity=$($this).closest('tr').find('remaining_qty_data').val();
                
            var intsq=parseInt(source_quantity);
            var sum_quanity=$('.receipt_value option:selected').attr('sum_qty');
                sum_quanity=sum_quanity.replace('-','');
            var intsum=parseInt(sum_quanity);

            if(inttq > intsq){
                alert('can not add more then Source Quantity');
                $($this).closest('tr').find('.source_quantity').val('');
                $($this).closest('tr').find('.source_quantity').prop('required',true);
            }else if(inttq > intsum){
                alert('can not add more quantity')
                $('.source_quantity').val('');
            }

        })*/

/// Endign Here

    $(document).on('change','.swarehouse',function(e){
        e.preventDefault();
        var $this=this;
        var warehouse_id=$(this).val();
        var item_id=$('.item_name').val();
        $.ajax({
            type:'get',
            url:"{{url('admin/stockavailablequantity')}}",
            data:{
                warehouse_id:warehouse_id,
                item_id:item_id,
            },
            dataType:'json',
            success:function(data){
                var available_qty=data.data.balance_qty ?? 0;
                //  $('.available_qty').val(available_qty);
                $($this).closest('tr').find('.available_qty').val(available_qty);
            }
        })
    })
$(document).on('change','.selected_item',function(e){
        e.preventDefault();
        var $this=this;
        var item_id=$(this).val();
        var warehouse_id=$($this).closest('tr').find('.swarehouse').val();
       
        $.ajax({
            type:'get',
            url:"{{url('admin/stockavailablequantity')}}",
            data:{
                warehouse_id:warehouse_id,
                item_id:item_id,
            },
            dataType:'json',
            success:function(data){
                var available_qty=data.data.balance_qty ?? 0; 
                
                $($this).closest('tr').find('.available_qty').val(available_qty);
            }
        })
    })

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
        $("#select1").change(function(){
    var air_id =  $(this).val();
   $.ajax({
        type:"get",
        url:getdata+air_id,
        data:{'id':air_id},
        dataType:'json',
        success:function(data){
            console.log(data);
            if(data.request_type=='automatic'){
            if(data.suffix == "suffix" && data.prefix =="prefix")
            {
            $('#series_id').val(data.prefix_static_character+'XXXX'+data.suffix_static_character);
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val(data.suffix_static_character);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();  
            }
            else if(data.suffix=="suffix"){
            $('#series_id').val('XXXX'+data.suffix_static_character);
            $('#series_type').val(data.series_starting_digits);
            $('#suffix').val(data.suffix_static_character);
            $('#prefix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();
            }
            else if(data.prefix=="prefix"){
            $('#series_id').val(data.prefix_static_character+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }else{
            $('#series_id').val('XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            }
            else{
                $('#series_id').hide();
                $('#prefix').val('');
                $('#suffix').val('');
                $('#series_starting_digits').val('');
                $('#manual_id').show();
            }    
        }
   })
  });
    });
</script>
@endsection
