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
            {!! Form::label('sales_order_id', 'MR No *') !!}
            @if(isset($order))
            <input type="text" name="receipt_no" class="form-control" value="{{$order->invoice_no}}" readonly>
            @else
            @foreach($salesinvoiceseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="receipt_no" class="form-control" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="receipt_no" class="form-control" placeholder="Invoice No">
            @endif
            @endforeach
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('sales_order_id', 'Sales Order') !!}
            <select id="sales_order_id" name="sales_order_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="sales_order_id">
                <option value="">Select a Order</option>
                @if(!empty($sales_orders))
                    @foreach($sales_orders as $value)
                        <option value="{{ $value->id }}"   @if(isset($order->sales_order_id)) @if($order->sales_order_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->order_no }} </option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- {{-- <div class="col-md-12">
            {!! Form::label('order_date', 'Order Date') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div> --}} -->
         
    </div>
</div>
<div class="form-group">
    {!! Form::label('payment_status', 'Sales Invoice Status') !!}
    {!! Form::select('payment_status', isset($invoice_status) ? $invoice_status : [], old('payment_status', isset($order->payment_status) ? $order->payment_status : ''), ['class' => 'form-control','disabled']) !!}
       
    <!-- {!! Form::select('payment_status', isset($invoice_status) ? $invoice_status : [], old('payment_status', isset($order->payment_status) ? $order->payment_status : ''), ['class' => 'form-control','disabled']) !!} -->
    <input type="hidden" name="payment_status" value="unpaid">
</div>
<div class="form-group">
    {!! Form::label('customer_id', 'Customer') !!}
    {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->sales_ledger_id) ? $order->sales_ledger_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('customer_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('customer_id') }}</strong>
        </span>
    @endif
</div>
@include('admin.transactions.common')
@include('admin.transactions.sales.script')
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/transactions/sales/salesinvoice/getdata/') }}/";
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
    })
</script>
@endsection