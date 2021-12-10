@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'workorder'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create Work Order</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div>
                            <p><b>Production Plan : {{$production_plan->plan_id}}</b></p>
                        </div>
                        <div>
                            <p><b>Finish Good : {{$production_plan->stockItems->name}}</b></p>
                        </div>

                        {{-- @if($production_plan->warehouse_id != '')
                            <div>
                                <p><b>Warehouse : {{$production_plan->warehouse->name}}</b></p>
                            </div>
                        @endif

                        @if($production_plan->batch_id != '')
                            <div>
                                <p><b>Batch : {{$production_plan->batch->batch_id}}</b></p>
                            </div>
                        @endif --}}

                        @if($production_plan->so_id != '')
                            <div>
                                <p><b>Order : {{$production_plan->salesorder->order_no}}</b></p>
                            </div>
                        @endif

                        <div>
                            <h4>Required Production Plan Details : </h4><hr />
                            @if(isset($plan_items) && count($plan_items) > 0)
                                @foreach($plan_items as $key => $display_plan_item)
                                    <p><b> {{$key+1}}) Item name : </b>{{$display_plan_item->stockItems->pack_code.'-'.$display_plan_item->stockItems->name}}</p>
                                    <p><b>Quantity: </b> {{$display_plan_item['quantity']}}</p>
                                    <p></p>
                                @endforeach
                            @endif
                        </div><hr />
                        @error('work_order_id')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        {!! Form::open(['url' => route('work-order.store'), 'id' => 'create_workorder']) !!}
                    
                        <div class="form-group">
                        {!! Form::label('return_no', 'MR No *') !!}
                       <!--  {!! Form::text('work_order_id', old('work_order_id', isset($order->work_order_id) ? $order->work_order_id : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!}
                         <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
                         @if ($errors->has('manual_id'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('manual_id') }}</strong>
                        </span>
                        @endif
                        <input type="hidden" name="suffix" id="suffix">
                        <input type="hidden" name="prefix" id="prefix">
                        <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->
                        @foreach($workorderseriesstatus as $key=>$value)
                        @if($value->request_type=='automatic')
                        <input type="text" name="work_order_id" class="form-control" placeholder="MR No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
                        @else
                        <input type="text" name="work_order_id" class="form-control" placeholder="MR NO">
                        @endif
                        @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('warehouse_id', 'Select Warehouse') !!}
                            {!! Form::select('warehouse_id', ['' => 'Select Warehouse'] + $warehouses, old('warehouse_id', isset($production_plan->warehouse_id) ? $production_plan->warehouse_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_warehouse_id','required'=>'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('batch_id', 'Salect Batch') !!}
                            {!! Form::select('batch_id', ['' => 'Select Batch'] + $batches, old('batch_id', isset($production_plan->batch_id) ? $production_plan->batch_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_batch_id','required'=>'required']) !!}
                        </div>

                        {!! Form::hidden("plan_id", $production_plan->id, ['class' => 'form-control']) !!}
                        @php
                            $element_counter = 0;
                        @endphp
                        <div class="table-responsive">
                            <table class="dynamic-table--warpper">
                                <thead>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Warehouse</th>
                                    <th>Batch</th>
                                    <th></th>
                                </thead>
                                <tbody class="add-items-list">
                                    @if(isset($plan_items) && count($plan_items) > 0)
                                        @foreach($plan_items as $key => $plan_item)
                                            <tr class="new-item">
                                                <td>
                                                    <select id="item_name" name="plan_item[{{$element_counter}}][item_item_id]" class="form-control item_item_id select2-elem" data-name="item_name" required="required">
                                                        <option value="">Select Item Code/Name</option>
                                                            @if(!empty($stockItem))
                                                                @foreach($stockItem as $value)
                                                                    <option value="{{ $value->id }}" @if($plan_item->stock_item_id == $value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                                                                @endforeach
                                                            @endif
                                                    </select>
                                                </td>
                                                <td class="datepicker-box">
                                                    {!! Form::number("plan_item[$element_counter][item_qty]", $plan_item['quantity'], ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Quantity','required'=>'required']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select("plan_item[$element_counter][warehouse_id]", ['' => 'Select Warehouse'] + $warehouses, old('warehouse_id', isset($item->warehouse_id) ? $item->warehouse_id : ''), ['class' => 'form-control select2-elem warehouse_id','id'=>'work_order_warehouse_id']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select("plan_item[$element_counter][batch_id]", ['' => 'Select Batch'] + $batches, old('batch_id', isset($item->batch_id) ? $item->batch_id : ''), ['class' => 'form-control select2-elem batch_id','id'=>'work_order_batch_id']) !!}
                                                </td>
                                                <td>
                                                    <div class="delete-item-block">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-remove delete-item btn-danger" data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="Delete Item">
                                                                <i class="fa fa-trash"></i>
                                                        </a>
                                                        <span class="availble_qty"></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $element_counter++;
                                                @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">
                                            <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Item"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            {!! link_to_route('stocks.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/manufacturing/workorder/getdata/') }}/";
</script>
<script type="text/javascript">
$(document).ready(function(){

    addItem = function(element, item, element_counter)
    {
        item.find(".select2-elem").each(function(index)
        {
            $(this).select2('destroy');
        });

        var item_template = item.clone();

        item_template.find(".item_item_id").attr('name', 'plan_item['+element_counter+'][item_item_id]');
        item_template.find(".item_qty").attr('name', 'plan_item['+element_counter+'][item_qty]');
        item_template.find(".warehouse_id").attr('name', 'plan_item['+element_counter+'][warehouse_id]');
        item_template.find(".batch_id").attr('name', 'plan_item['+element_counter+'][batch_id]');

        item_template.find('input').val('');
        item_template.find('select').val('');
        item_template.find('.availble_qty').html('');
        item_template.find(".select2-elem").select2();
        element.append(item_template)
    };

    var element_counter = "{{ $element_counter }}"

    $(document).on('click', '.add-item', function() {
        $('.error').text('');
        var item = $(".add-items-list").children("tr.new-item:last-child");
        var errors = [];
        var has_error = false;
        var has_warehouse_error = false;
        var has_batch_error = false;

        item.find('.item_qty').each(function(){
            if (!($(this).val() && $(this).val().length)) {
                $(this).trigger('focus');
                has_error = true;
                return false;
            }
            has_error = false;
        });

        item.find('.warehouse_id').each(function(){
            if (!($(this).val() && $(this).val().length)) {
                $(this).select2('focus');
                has_warehouse_error = true;
                return false;
            }
            has_warehouse_error = false;
        });

        item.find('.batch_id').each(function(){
            if (!($(this).val() && $(this).val().length)) {
                $(this).select2('focus');
                has_batch_error = true;
                return false;
            }
            has_batch_error = false;
        });

        var validate_values = errors.includes(false);

        if ((! has_error) && (! has_batch_error) && (! has_warehouse_error) && (! validate_values)) {
            $(".error").text("");
            element_counter++;

            //addItem($(".add-items-list"),element_counter)
            addItem($(".add-items-list"), item, element_counter);

            var last_item = $(".add-items-list").children("tr.new-item:last-child");
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

    avilableQty = function(element, item_id,warehouse_id,batch_id,quantity) {
        if(item_id != '' && warehouse_id != '' && batch_id != '')
        {
            $.ajax({
                url: config.routes.url + '/admin/warehouse_stock_available_qty/' + item_id + '/' + warehouse_id + '/' + batch_id + '/qty',
                type: 'GET',
                success:function(response) {
                    if (response.success)
                    {
                        if(response.data != '')
                        {
                            var availalbe_qty = element.find(".availble_qty");
                            var qty;
                            if(response.data[0].qty > 0)
                            {
                                qty = '<span style="color:green">Availale Qty '+response.data[0].qty+'</span>';
                                /*var $tr = element.closest('tr');
                                var index = $tr.index();
                                var item_qty = $('input[name="plan_item['+index+'][item_qty]').val();*/

                                if(quantity > response.data[0].qty)
                                {
                                    element.find('.item_qty').val('');
                                    element.find('.item_qty').focus();
                                    alert('You can not entered greater than available qauntity.');
                                }
                            }else{
                                qty = '<span style="color:red">Quantity not available</span>';
                                element.find('.item_qty').val('');
                            }
                            availalbe_qty.html(qty);
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    };
    $(document).on('change', '.item_item_id', function() {
        var item_id = $(this).val();
        var warehouse_id = $(this).closest('.new-item').find(".warehouse_id").val();
        var batch_id = $(this).closest('.new-item').find(".batch_id").val();
        var qty = $(this).closest('.new-item').find(".item_qty").val();
        avilableQty($(this).closest('.new-item'),item_id,warehouse_id,batch_id,qty);
    });

    $(document).on('change', '.warehouse_id', function() {
        var qty = $(this).closest('.new-item').find(".item_qty").val();
        var item_id = $(this).closest('.new-item').find(".item_item_id").val();
        var warehouse_id = $(this).val();
        var batch_id = $(this).closest('.new-item').find(".batch_id").val();
        avilableQty($(this).closest('.new-item'),item_id,warehouse_id,batch_id,qty);
    });

    $(document).on('change', '.batch_id', function() {
        var qty = $(this).closest('.new-item').find(".item_qty").val();
        var item_id = $(this).closest('.new-item').find(".item_item_id").val();
        var warehouse_id = $(this).closest('.new-item').find(".warehouse_id").val();
        var batch_id = $(this).val();
        avilableQty($(this).closest('.new-item'),item_id,warehouse_id,batch_id,qty);
    });

    $(document).on('keyup', '.item_qty', function() {
        var qty = $(this).val();
        var item_id = $(this).closest('.new-item').find(".item_item_id").val();
        var warehouse_id = $(this).closest('.new-item').find(".warehouse_id").val();
        var batch_id = $(this).closest('.new-item').find(".batch_id").val();
        avilableQty($(this).closest('.new-item'),item_id,warehouse_id,batch_id,qty);
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
            else if(data.prefix=="prefix") {
            $('#series_id').val(data.prefix_static_character+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            else{
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
