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
            <!-- <label for="invoice_no">Purchase Return Series</label>
            @if(isset($order))
            <select class="form-control" id="select1" name="series_type" disabled="true">
                <option>Select Series</option>
                @foreach($purchasereturnseries as $key=>$value)
                <option value="{{ $value->id }}" 
                @if($order->series_type==$value->id){{"selected='selected'"}}@endif>
                {{ $value->series_name }}</option>
                @endforeach
            </select>
            @else
            <select class="form-control" id="select1" name="series_type">
                <option>Select Series</option>
                @foreach($purchasereturnseries as $key=>$value)
                <option value="{{ $value->id }}">{{ $value->series_name }}</option>
                @endforeach
            </select>
            @endif
            <input type="text" class="form-control return_no" id="return_no" name="return_no" value="{{old('return_no', isset($order->return_no) ? $order->return_no : '')}}" placeholder="Purchase Return No">
            @if ($errors->has('invoice_no'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('invoice_no') }}</strong>
            </span>
            @endif -->
            {!! Form::label('mr no', 'Purchase Return No  *') !!}
            @if(isset($order))
            <input type="text" name="return_no" class="form-control" value="{{$order->return_no}}" readonly>
            @else
            @foreach($purchasereturnseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="return_no" class="form-control" placeholder="Return No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="return_no" class="form-control" placeholder="Return No">
            @endif
            @endforeach
            @endif
        </div>
        <div class="col-md-12">
           
            <!-- <select id="invoice_id" name="invoice_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="invoice_id" required="required" onchange="getInvoiceDetails(this.value)">
                <option value="">Select Purchase Invoice</option>
                @if(!empty($invoice_data))
                @foreach($invoice_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->invoice_id)) @if($order->invoice_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->invoice_no }} </option>
                @endforeach
                @endif
            </select> -->
            
           <!-- {!! Form::text('return_no', old('return_no', isset($order->return_no) ? $order->return_no : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!} -->
            <!-- <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
            @if ($errors->has('manual_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('manual_id') }}</strong>
                </span>
            @endif

            <input type="hidden" name="suffix" id="suffix">
            <input type="hidden" name="prefix" id="prefix">
            <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->
            <!-- @if(isset($order))
            <input type="text" name="return_no" class="form-control" value="{{$order->return_no}}" readonly>
            @else
            @foreach($purchasereturnseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <input type="text" name="return_no" class="form-control" placeholder="Return No" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="return_no" class="form-control" placeholder="Return No">
            @endif
            @endforeach
            @endif -->
            <label for="return_date">Purchase Invoice No *</label>
            <select id="invoice_id" name="invoice_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="invoice_id" required="required" onchange="getInvoiceDetails(this.value)">
                <option value="">Select Purchase Invoice</option>
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
            <!-- <label for="return_date">Purchase Invoice No *</label>
            <select id="invoice_id" name="invoice_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="invoice_id" required="required" onchange="getInvoiceDetails(this.value)">
                <option value="">Select Purchase Invoice</option>
                @if(!empty($invoice_data))
                @foreach($invoice_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->invoice_id)) @if($order->invoice_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->invoice_no }} </option>
                @endforeach
                @endif
            </select> -->
            {!! Form::label('invoice_date', 'Return Date *') !!}
            {!! Form::text('return_date', old('return_date', isset($order->return_date) ? $order->return_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Return Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="col-md-12">
            <!-- {!! Form::label('invoice_date', 'Return Date *') !!}
            {!! Form::text('return_date', old('return_date', isset($order->return_date) ? $order->return_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Return Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
        </div>
    </div>
</div>
<div class="form-group">
    <label>Supplier</label>
    {!! Form::label('supplier_id', 'Supplier') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('supplier_id') }}</strong>
    </span>
    @endif
</div>

@include('admin.transactions.common')

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
                url: '{{url("admin/transactions/purchase/getInvoiceDetails")}}',
                data: {invoice_id: pi_id},
                success: function (data) {
                    console.log(data);
                    $('#address').val(data.order_details.address);
                    $('#credit_days').val(data.order_details.default_credit_period);
                    $('.approved_vendor_code').val(data.order_details.approved_vendor_code);
                     $('.customerstate').val(data.order_details.state);
                    //var BranchId = (data.order_details.branch != null) ? data.order_details.branch.id : '';
                    //console.log(BranchId);
                    //$('#branch_id').val(BranchId);
                    let branch=$('.branch_id');
                    var mainBranch=data.order_details.branch_id;
                    if(mainBranch==0){
                        $('.branch_id').prop('disabled',true);
                        $('.mainBranch').show();
                        $('.branch_id').hide();
                        $('.mainBranch').val(data.order_details.main_branch);
                        $('.mainBranch').prop('disabled',false);
                    }else{

                        $('.branch_id').show();
                        $('.branch_id').prop('disabled',false);
                        $('.mainBranch').hide();
                        $('.mainBranch').prop('disabled',true);
                        
                    }
                       branch.empty();
                        if(data.order_details.branch != null)
                        {
                            branch.append("<option value='"+ data.order_details.branch.id +"'>" + data.order_details.branch.branch_name + "</option>");
                        }


                    $('#supplier_id').val(data.order_details.supplier_id);
                    $('#required_date').val(data.order_details.required_date);
                    $('#warehouse_id').val(data.order_details.warehouse_id);
                    $('#grand_total').val(data.order_details.grand_total);
                    /*$('#igst').val(data.order_details.igst);
                    $('#sgst').val(data.order_details.sgst);
                    $('#cgst').val(data.order_details.cgst);*/
                    $('#credit_days').val(data.order_details.credit_days);
                    $('#total_net_amount').val(data.order_details.net_amount);
                    $('#total_grand_amount').val(data.order_details.total_net_amount);

                    $('#total_other_grand_amount').val(data.order_details.total_other_net_amount);
                    $('#other_net_amount').val(data.order_details.other_net_amount);

                    var options = '';
                    $.each(data.stockItem, function(key, obj) { // Cycle through each associated role
                          options += '<option value="'+obj.id+'">' + obj.pack_code + '-' + obj.name + '</option>';
                    });
                    $('.item_name').html(options);
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
                        $('#sgst').val(data.order_details.sgst);
                        $('#cgst').val(data.order_details.cgst);
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
                        $('#igst').val(data.order_details.igst);
                    }
                   

                    if(data.order_details.items.length)
                    {
                        addPRItem(data.order_details.items);
                    }
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

                    if(data.order_details.other_charges.length) {
                        addPROtherItem(data.order_details.other_charges);
                    }
                }
            });
        } else {
            $('#address').val('');
            $('#credit_days').val('');
        }
    }

    addPRItem = function(pr_items)
    {
        var item = $(".add-items-list").children("tr.new-item:last-child");

        item.find(".select2-elem").each(function(index)
        {
            $(this).select2('destroy');
        });
        var item_template = item.clone();

        var element_counter = 0;
        $(".add-items-list").empty();

        $.each(pr_items, function(key, value) {

            item_template.find(".item_id").attr('name', 'items['+element_counter+'][item_id]').val(value.stock_item_id);
            item_template.find(".item_name").attr('name', 'items['+element_counter+'][item_name]').val(value.stock_item_id);
            item_template.find(".item_code").attr('name', 'items['+element_counter+'][item_code]').val(value.item_code);
            item_template.find(".unit").attr('name', 'items['+element_counter+'][unit]');
            item_template.find(".quantity").attr('name', 'items['+element_counter+'][quantity]').val(value.quantity);
            item_template.find(".rate").attr('name', 'items['+element_counter+'][rate]').val(value.rate);
            item_template.find(".net_amount").attr('name', 'items['+element_counter+'][net_amount]').val(value.net_amount);
            item_template.find(".discount").attr('name', 'items['+element_counter+'][discount]').val(value.discount_in_per);
            item_template.find(".discount_amount").attr('name', 'items['+element_counter+'][discount_amount]').val(value.discount);
            item_template.find(".tax").attr('name', 'items['+element_counter+'][tax]').val(value.tax);
            item_template.find(".tax_amount").attr('name', 'items['+element_counter+'][tax_amount]').val(value.tax_amount);

            item_template.find(".total_amount").attr('name', 'items['+element_counter+'][total_amount]').val(value.total_amount);

            item_template.find(".unit option:contains("+value.unit+")").attr('selected', 'selected');
            item_template.find(".select2-elem").select2();
            $(document).find(".add-items-list").append(item_template);

            element_counter++;

            item_template.find(".select2-elem").each(function(index)
            {
                $(this).select2('destroy');
            });
            item_template = item_template.clone();

        });

        $(document).find(".add-items-list .select2-elem").each(function(index)
        {
            $(this).select2();
        });
    };

    addPROtherItem = function(pr_items)
    {
        var item = $(".add-field-list-2").children("tr.new-field-2:last-child");

        item.find(".select2-elem").each(function(index)
        {
            $(this).select2('destroy');
        });
        var item_template = item.clone();

        var element_counter = 0;
        $(".add-field-list-2").empty();

        $.each(pr_items, function(okey, ovalue) {
            setOtherTaxValues(item_template, element_counter, ovalue);

            element_counter++;
            item_template.find(".select2-elem").each(function(index)
            {
                $(this).select2('destroy');
            });
            item_template = item_template.clone();
        });
    };

    setOtherTaxValues = function(item_template, element_counter, item) {
        item_template.find('input').val('');
        item_template.find(".type").attr('name', 'other_taxes['+element_counter+'][type]').val(item.type);
        item_template.find(".account_head").attr('name', 'other_taxes['+element_counter+'][account_head]').val(item.general_ledger_id);
        item_template.find(".other_rate").attr('name', 'other_taxes['+element_counter+'][other_rate]').val(item.rate);
        item_template.find(".other_amount").attr('name', 'other_taxes['+element_counter+'][other_amount]').val(item.amount);
        item_template.find(".other_tax").attr('name', 'other_taxes['+element_counter+'][other_tax]').val(item.tax);
        item_template.find(".other_tax_amount").attr('name', 'other_taxes['+element_counter+'][other_tax_amount]').val(item.tax_amount);
        item_template.find(".other_total_amount").attr('name', 'other_taxes['+element_counter+'][other_total_amount]').val(item.total_amount);
        item_template.find(".other_charge_id").attr('name', 'other_taxes['+element_counter+'][other_charge_id]').val(0);

        item_template.find(".select2-elem").select2();
        $(document).find(".add-field-list-2").append(item_template);
    }
</script>
@endsection
