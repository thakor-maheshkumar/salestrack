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
            <label>Quotation NO *</label>
            @if(isset($order))
            <input type="text" name="quotation_no" value="{{$order->quotation_no}}" class="form-control" readonly>
            @else
            @foreach($quotationseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="quotation_no" class="form-control" placeholder="Quotation No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="quotation_no" class="form-control" placeholder="Quotation No">
            @endif
            @endforeach
            @endif
        </div>
        {{-- <div class="col-md-12">
            {!! Form::label('order_date', 'Order Date') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div> --}}

        <div class="col-md-12">
            {!! Form::label('customer_id', 'Customer *') !!}
            <select id="customer_id" name="customer_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="customer_id" required="required">
                <option value="">Select a Customer</option>
                @if(!empty($customers))
                @foreach($customers as $value)
                    <option value="{{ $value->id }}"   @if(isset($order->sales_ledger_id)) @if($order->sales_ledger_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->ledger_name }} </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('valid_till', 'Valid Till *') !!}
            {!! Form::text('valid_till', old('valid_till', isset($order->valid_till) ? $order->valid_till : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Valid Till','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
        
    </div>
</div>
@include('admin.transactions.common')
@include('admin.transactions.sales.script')
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/transactions/sales/quotation/getdata/') }}/";
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
            else if(data.prefix=='prefix'){
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
