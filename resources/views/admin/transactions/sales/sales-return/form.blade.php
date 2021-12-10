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
           <label>Sales Return No</label>
           @if(isset($order))
           <input type="text" class="form-control" name="return_no" placeholder="Return no" value="{{$order->return_no}}" readonly>
           @else
           @foreach($salesreturnseriesstatus as $key=>$value)
           @if($value->request_type=='automatic')
           <input type="text" name="return_no" class="form-control" placeholder="Return No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
           @else
           <input type="text" name="return_no" placeholder="Return No" class="form-control">
           @endif
           @endforeach
           @endif
        </div>

        <div class="col-md-12">
           <label for="return_date">Sales Invoice No *</label>
            <select id="invoice_id" name="invoice_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="invoice_id" required="required" onchange="getInvoiceDetails(this.value)">
                <option value="">Select Sales Invoice</option>
                @if(!empty($invoice_data))
                @foreach($invoice_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->invoice_id)) @if($order->invoice_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->invoice_no }} </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
<div class="form-row">
        <div class="col-md-12">
            <!-- {!! Form::label('customer_id', 'Customer') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->sales_ledger_id) ? $order->sales_ledger_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
            @if ($errors->has('customer_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('customer_id') }}</strong>
                </span>
            @endif -->
            <!-- <label for="return_date">Sales Invoice No *</label>
            <select id="invoice_id" name="invoice_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="invoice_id" required="required" onchange="getInvoiceDetails(this.value)">
                <option value="">Select Sales Invoice</option>
                @if(!empty($invoice_data))
                @foreach($invoice_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->invoice_id)) @if($order->invoice_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->invoice_no }} </option>
                @endforeach
                @endif
            </select> -->
             {!! Form::label('customer_id', 'Customer *') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->sales_ledger_id) ? $order->sales_ledger_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
            @if ($errors->has('customer_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('customer_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12">
            <!-- {!! Form::label('return_date', 'Return Date') !!}
            {!! Form::text('return_date', old('return_date', isset($order->return_date) ? $order->return_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Return Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
             <!-- {!! Form::label('customer_id', 'Customer *') !!}
            {!! Form::select('customer_id', ['' => 'Select a Customer'] + $customers, old('customer_id', isset($order->sales_ledger_id) ? $order->sales_ledger_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
            @if ($errors->has('customer_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('customer_id') }}</strong>
                </span>
            @endif -->
            {!! Form::label('return_date', 'Return Date *') !!}
            {!! Form::text('return_date', old('return_date', isset($order->return_date) ? $order->return_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Return Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div><!-- 
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('return_date', 'Return Date *') !!}
            {!! Form::text('return_date', old('return_date', isset($order->return_date) ? $order->return_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Return Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div> -->
@include('admin.transactions.common')
<script type="text/javascript">
    var getdata="{{ url('admin/transactions/sales/salesreturn/getdata/') }}/";
</script>
@section('scripts')
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

@parent
<script type="text/javascript">
    function getInvoiceDetails(pi_id)
    {
        if (pi_id != '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{url("admin/transactions/sales/getSalesInvoiceDetails")}}',
                data: {invoice_id: pi_id},
                success: function (data) {
                    $('#address').val(data.order_details.address);
                    $('.customerstate').val(data.order_details.state);
                    $('#credit_days').val(data.order_details.default_credit_period);
                    $('.approved_vendor_code').val(data.order_details.approved_vendor_code);

                    var BranchId = (data.order_details.branch != null) ? data.order_details.branch.id : '';
                    var mainBranch=data.order_details.branch_id;
                    if(mainBranch==0){
                        $('.mainBranch').show();
                        $('.branch_id').hide();
                        $('.mainBranch').val(data.order_details.main_branch);
                        $('.mainBranch').prop('disabled',false);
                    }else{
                        $('.branch_id').show();
                        $('.mainBranch').hide();
                        $('.mainBranch').prop('disabled',true);
                    }
                    $('#branch_id').val(BranchId);
                    $('#customer_id').val(data.order_details.sales_ledger_id);
                    $('#required_date').val(data.order_details.required_date);
                    $('#warehouse_id').val(data.order_details.warehouse_id);
                    $('#user_id').val(data.order_details.sales_person_id);

                    $('#grand_total').val(data.order_details.grand_total);
                    $('#igst').val(data.order_details.igst);
                    $('#sgst').val(data.order_details.sgst);
                    $('#cgst').val(data.order_details.cgst);
                    $('#credit_days').val(data.order_details.credit_days);
                    $('#total_net_amount').val(data.order_details.net_amount);
                    $('#total_grand_amount').val(data.order_details.total_net_amount);

                    $('#total_other_grand_amount').val(data.order_details.total_other_net_amount);
                    $('#other_net_amount').val(data.order_details.other_net_amount);

                    $(".add-items-list").html(data.items_view);
                    $(".add-items-list").find(".select2-elem").select2();

                    $("#other_charge_tbody").html(data.tax_items_view);
                    $("#other_charge_tbody").find(".select2-elem").select2();
                    /*$.each(data.order_details.items, function(key, value) {

                        console.log(value.stock_item_id);
                        $('#item_name').val(value.stock_item_id);
                        $('#item_code').val(value.item_code);
                        // $('#unit option:selected').val(value.unit);
                        $('#unit option:contains('+value.unit+')').attr('selected', 'selected');
                        $('.quantity').val(value.quantity);
                        $('.rate').val(value.rate);
                        $('.net_amount').val(value.net_amount);
                        $('.discount').val(value.discount_in_per);
                        $('.discount_amount').val(value.discount);
                        $('.tax').val(value.tax);
                        $('.tax_amount').val(value.tax_amount);
                        $('.total_amount').val(value.total_amount);
                        $('#item_name').select2();
                    });*/
                    /*$.each(data.order_details.other_charges, function(okey, ovalue) {
                        console.log(okey);
                         $('#other_charge_type').val(ovalue.type);
                         $('.account_head').val(ovalue.general_ledger_id);
                         $('.other_rate').val(ovalue.rate);
                         $('.other_amount').val(ovalue.amount);
                         $('.other_tax').val(ovalue.tax);
                         $('.other_tax_amount').val(ovalue.tax_amount);
                         $('.other_total_amount').val(ovalue.total_amount);
                    });*/

                    var cstate=$('.customerstate').val();
                    var companystate=$('.cpstate').val();
                    var tax_amt=$('.tax_amount').val();
                    var total_tax=tax_amt/2;
                    if(cstate==companystate){
                        $('.dstate').show();
                        $('.igst').prop('disabled',true)
                        $('.dstate').prop('disabled',false)
                        $('.igst').hide();
                        /*$('.sgst').val(total_tax);*/
                        $('.samesgst').hide();
                        $('.samesgst').prop('disabled',true);
                        $('.sgst').show();
                        $('.sgst').prop('disabled',false);
                        $('.sgst').val(total_tax);
                        $('.samecgst').hide();
                        $('.samecgst').prop('disabled',true);
                        $('.cgst').show();
                        $('.cgst').prop('disabled',false);
                        $('.cgst').val(total_tax);
                    }else{
                        $('.dstate').hide();
                        $('.igst').show();
                        $('.dstate').prop('disabled',true)
                        $('.igst').prop('disabled',false)
                        $('.igst').val(tax_amt);
                        $('.samesgst').show();
                        $('.samesgst').prop('disabled',false);
                        $('.sgst').hide();
                        $('.sgst').prop('disabled',true);
                        $('.samecgst').show();
                        $('.samecgst').prop('disabled',false);
                        $('.cgst').hide();
                        $('.cgst').prop('disabled',true);
                    }
                }
            });
        } else {
            $('#address').val('');
            $('#credit_days').val('');
        }
    }
</script>
@endsection
