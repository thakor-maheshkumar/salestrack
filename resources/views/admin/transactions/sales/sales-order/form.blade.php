@include('common.messages')
@include('common.errors')
<div class="form-group">
    @if(isset($is_submit_show))
        {!! Form::button('Print', ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    @endif
        {!! link_to_route($other->listing_link, 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <!-- {!! Form::label('order_no', 'Sales Order No') !!}
            {!! Form::text('order_no', old('order_no', isset($order->order_no) ? $order->order_no : ''), ['class' => 'form-control', 'placeholder' => 'Order No','required' => 'required']) !!}
            @if ($errors->has('order_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('order_no') }}</strong>
                </span>
            @endif

            {!! Form::label('order_no', 'Sales Order Series') !!}
            @if(isset($order))
            <select class="form-control" id="select1" name="series_type" disabled="true">
                <option>Select Series</option>
                @foreach($salesorderseries as $key=>$value)
                <option value="{{ $value->id }}" @if($order->series_type==$value->id){{'selected'}}@endif>{{ $value->series_name }}</option>
                @endforeach
            </select>
            @else
            <select class="form-control" id="select1" name="series_type">
                <option>Select Series</option>
                @foreach($salesorderseries as $key=>$value)
                <option value="{{ $value->id }}">{{ $value->series_name }}</option>
                @endforeach
            </select>
            @endif -->
            <label>Sales Order No</label>
            @if(isset($order))
            <input type="text" name="order_no" value="{{$order->order_no}}" class="form-control" readonly>
            @else
            @foreach($salesorderseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="order_no" class="form-control" placeholder="Order No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="order_no" class="form-control" placeholder="Order No">
            @endif
            @endforeach
            @endif
        </div>
        <div class="col-md-12">
            <!-- {!! Form::label('order_date', 'Order Date') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
           <!--  {!! Form::label('order_no', 'Sales Order No *') !!}
            {!! Form::text('order_no', old('order_no', isset($order->order_no) ? $order->order_no : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!}
            <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
            @if ($errors->has('manual_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('manual_id') }}</strong>
                    </span>
            @endif

            <input type="hidden" name="suffix" id="suffix">
            <input type="hidden" name="prefix" id="prefix">
            <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->
            {!! Form::label('order_date', 'Order Date *') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <!-- {!! Form::label('customer_id', 'Customer') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->customers->id) ? $order->customers->id : ''), ['class' => 'form-control','required' => 'required'] ) !!} -->
             <!-- {!! Form::label('order_date', 'Order Date *') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
             {!! Form::label('customer_id', 'Customer *') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->customers->id) ? $order->customers->id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
        </div>
        <div class="col-md-12">
            <!-- {!! Form::label('quotation_id', 'Quotation') !!}
            <select id="sales_order_quotation_id" name="quotation_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="quotation_id">
                <option value="">Select a Quotation</option>
                @if(!empty($quotations))
                    @foreach($quotations as $value)
                        <option value="{{ $value->id }}"   @if(isset($order->quotation_id)) @if($order->quotation_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->quotation_no }} </option>
                    @endforeach
                @endif
            </select> -->
           <!--  {!! Form::label('customer_id', 'Customer *') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->customers->id) ? $order->customers->id : ''), ['class' => 'form-control','required' => 'required'] ) !!} -->
            {!! Form::label('quotation_id', 'Quotation *') !!}
            <select id="sales_order_quotation_id" name="quotation_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="quotation_id">
                <option value="">Select a Quotation</option>
                @if(!empty($quotations))
                    @foreach($quotations as $value)
                        <option value="{{ $value->id }}"   @if(isset($order->quotation_id)) @if($order->quotation_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->quotation_no }} </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <!-- {!! Form::label('quotation_id', 'Quotation *') !!}
            <select id="sales_order_quotation_id" name="quotation_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="quotation_id">
                <option value="">Select a Quotation</option>
                @if(!empty($quotations))
                    @foreach($quotations as $value)
                        <option value="{{ $value->id }}"   @if(isset($order->quotation_id)) @if($order->quotation_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->quotation_no }} </option>
                    @endforeach
                @endif
            </select> -->
        </div>
    </div>
</div>
@include('admin.transactions.common')
@include('admin.transactions.sales.script')
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/transactions/sales/salesorder/getdata/') }}/";
</script>
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
            else if(data.prefix=='prefix') {
            $('#series_id').val(data.prefix_static_character+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            else {
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