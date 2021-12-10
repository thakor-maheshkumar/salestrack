@include('common.messages')
@include('common.errors')

<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('delivery_no', 'Sales Delivery No') !!}
            <!-- {!! Form::text('delivery_no', old('delivery_no', isset($order->delivery_no) ? $order->delivery_no : ''), ['class' => 'form-control', 'placeholder' => 'Delivery No','required' => 'required']) !!} -->
            @if(isset($order))
            <input type="text" name="delivery_no" class="form-control" value="{{$order->delivery_no}}" readonly>
            @else
            @foreach($deliveryseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="delivery_no" class="form-control" placeholder="Delivery No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="delivery_no" class="form-control" placeholder="Delivery No">
            @endif
            @endforeach
            @endif
        </div>
        {{-- <div class="col-md-12">
            {!! Form::label('order_date', 'Order Date') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div> --}}
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('sales_order_id', 'Sales Order') !!}
            <select id="note_sales_order_id" name="sales_order_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="sales_order_id">
                <option value="">Select a Sales order</option>
                @if(!empty($sales_order))
                    @foreach($sales_order as $value)
                        <option value="{{ $value->id }}"  @if(isset($order->sales_order_id)) @if($order->sales_order_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->order_no }} </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('customer_id', 'Customer') !!}
    {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->customer_id) ? $order->customer_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('customer_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('customer_id') }}</strong>
        </span>
    @endif
</div>
@include('admin.transactions.common')
@include('admin.transactions.sales.script')
