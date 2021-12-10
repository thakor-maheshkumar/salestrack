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
            <!-- <label for="invoice_no">Purchase Invoice Series</label>
            @if(isset($order))
            <select class="form-control"  name="series_type" disabled="true">
                 @foreach($purchaseinvoiceseries as $key=>$value)
                <option value="{{ $value->id }}" @if($order->series_type==$value->id){{'selected'}}@endif>{{ $value->series_name }}</option>
                @endforeach
                <option></option>
            </select>
            @else
            <input type="text" class="form-control invoice_no" id="invoice_no" name="invoice_no" value="{{old('invoice_no', isset($order->invoice_no) ? $order->invoice_no : '')}}" placeholder="Purchase Invoice No">
            @if ($errors->has('invoice_no'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('invoice_no') }}</strong>
            </span>
            @endif
            <select class="form-control"  name="series_type">
                <option>Select Series</option>
                @foreach($purchaseinvoiceseries as $key=>$value)
                <option value="{{ $value->id }}">{{ $value->series_name }}</option>
                @endforeach
            </select>
            @endif -->
            <label for="po_id">Purchase Invoice No*</label>
             @if(isset($order))
             @if($order->invoice_no!='')
             <input type="text" name="invoice_no" class="form-control" 
            value="{{$order->invoice_no}}" readonly="">
            @else
            <!----new Logic here --->
            @foreach($purchaseinvoiceseriesstatus as $key=>$value)
            @if($value->request_type =='automatic')
            <input type="text" name="invoice_no" class="form-control" 
            value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly="">
            @else
            <input type="text" name="invoice_no" class="form-control">
            @endif
            @endforeach
            @endif
             @else
            @foreach($purchaseinvoiceseriesstatus as $key=>$value)
            @if($value->request_type =='automatic')
            <input type="text" name="invoice_no" class="form-control" 
            value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly="">
            @else
            <input type="text" name="invoice_no" class="form-control">
            @endif
            @endforeach
            @endif
        </div>
        <div class="col-md-12">
             <!-- <label for="po_id">Purchase Invoice No*</label>
             @if(isset($order))
             <input type="text" name="invoice_no" class="form-control" 
            value="{{$order->invoice_no}}" readonly="">
             @else
            @foreach($purchaseinvoiceseriesstatus as $key=>$value)
            @if($value->request_type =='automatic')
            <input type="text" name="invoice_no" class="form-control" 
            value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly="">
            @else
            <input type="text" name="invoice_no" class="form-control">
            @endif
            @endforeach
            @endif -->
             <label for="po_id">Purchase Order</label>
            <select id="po_id" name="po_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="po_id" onchange="getOrderDetails(this.value)">
                <option value="">Select Purchase Order</option>
                @if(!empty($po_data))
                @foreach($po_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->po_id)) @if($order->po_id == $value->id){{"selected='selected'"}} @endif @elseif(isset($order->id)) @if($order->id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->order_no }} </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
           <!--  <label for="po_id">Purchase Order</label>
            <select id="po_id" name="po_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="po_id" onchange="getOrderDetails(this.value)">
                <option value="">Select Purchase Order</option>
                @if(!empty($po_data))
                @foreach($po_data as $value)
                <option value="{{ $value->id }}"   @if(isset($order->po_id)) @if($order->po_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->order_no }} </option>
                @endforeach
                @endif
            </select> -->
            {!! Form::label('invoice_date', 'Invoice Date *') !!}
            {!! Form::text('invoice_date', old('invoice_date', isset($order->invoice_date) ? $order->invoice_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Invoice Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="col-md-12">
            <!-- {!! Form::label('invoice_date', 'Invoice Date *') !!}
            {!! Form::text('invoice_date', old('invoice_date', isset($order->invoice_date) ? $order->invoice_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Invoice Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('payment_status', 'Purchase Invoice Status') !!}
    {!! Form::select('payment_status', isset($invoice_status) ? $invoice_status : [], old('payment_status', isset($order->payment_status) ? $order->payment_status : ''), ['class' => 'form-control','disabled']) !!}
    <input type="hidden" name="payment_status" value="unpaid">
</div>
<div class="form-group">
    {{--  <label>Supplier</label> --}}
    {!! Form::label('supplier_id', 'Supplier') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['onchange'=>'getSupplierDetails(this.value)','class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('supplier_id') }}</strong>
    </span>
    @endif
</div>

@if($other->order_type != 2)
<div class="form-group">
    {!! Form::label('approved_vendor_code', 'Approved Vendor Code') !!}
    {!! Form::text('approved_vendor_code', old('approved_vendor_code', isset($order->approved_vendor_code) ? $order->approved_vendor_code : ''), ['class' => 'form-control approved_vendor_code','required' => 'required'] ) !!}
</div>
@endif
<div class="form-group">
    {!! Form::label('address', 'Address') !!}
    {!! Form::textarea('address', old('address', isset($order->address) ? $order->address : ''), ['class' => 'form-control','rows'=>2, 'placeholder' => 'Address','required' => 'required']) !!}
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('branch_id', 'Branch') !!}
            @if(isset($order))
            @if($order->branch_id!=0)
            {!! Form::select('branch_id', ['' => isset($order->main_branch) ? $order->main_branch :'Select a Branch']+ $consignee_address, old('branch_id', isset($order->supplier_id) ? $order->branch_id : ''),  ['class' => 'form-control branch_id','id'=>'branch_id'] ) !!}
            <input type="text" name="branch_id" class="form-control mainBranch" style="display:none">
            @else
            {!! Form::select('branch_id', [$order->main_branch => isset($order->main_branch) ? $order->main_branch :'Select a Branch']+ $consignee_address, old('branch_id', isset($order->supplier_id) ? $order->branch_id : ''),  ['class' => 'form-control branch_id','id'=>'branch_id'] ) !!}
            <input type="text" name="branch_id" class="form-control mainBranch" style="display:none">
            @endif
            @else
             {!! Form::select('branch_id', ['' => isset($order->main_branch) ? $order->main_branch :'Select a Branch']+ $consignee_address, old('branch_id', isset($order->supplier_id) ? $order->branch_id : ''),  ['class' => 'form-control branch_id','id'=>'branch_id'] ) !!}
            <input type="text" name="branch_id" class="form-control mainBranch" style="display:none">
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('required_date', 'Required By Date') !!}
            {!! Form::text('required_date', old('required_date', isset($order->required_date) ? $order->required_date : ''), ['class' => 'form-control datepicker','placeholder' => 'Required Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>

    </div>
</div>
<div class="form-group">
    <div class="form-row">

        @if($other->order_type == 2)
        <div class="col-md-12">
            {!! Form::label('user_id', 'Sales Person') !!}
            {!! Form::select('user_id', ['' => 'Select a Sales Person'] + $sales_person, old('user_id', isset($order->user_id) ? $order->user_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
            @if ($errors->has('user_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>
        @endif
        <div class="col-md-12">
            {!! Form::label('warehouse_id', 'Set Target Warehouse') !!}
            {!! Form::select('warehouse_id', ['0' => 'Select a Warehouse'] + $warehouses, old('warehouse_id', isset($order->warehouse_id) ? $order->warehouse_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
            @if ($errors->has('warehouse_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('warehouse_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
@include('admin.transactions.items')
{{-- <div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('shipping_amount', 'Shipping Amount') !!}
            {!! Form::number('shipping_amount', old('shipping_amount', isset($order->shipping_amount) ? $order->shipping_amount : ''), ['class' => 'form-control','placeholder' => 'Shipping Amount','required' => 'required']) !!}
        </div>
    </div>
</div> --}}
@include('admin.transactions.taxes')
<div class="form-group">
    <div class="form-row">
    {{-- <div class="col-md-12">
            {!! Form::label('tax', 'Total Taxes and Charges') !!}
            {!! Form::number('tax', old('tax', isset($order->tax) ? $order->tax : ''), ['class' => 'form-control','placeholder' => 'Total Taxes and Charges']) !!}
        </div>  --}}
        {{-- <div class="col-md-12">
            {!! Form::label('discount_in_per', 'Discount Percentage') !!}
            {!! Form::number('discount_in_per', old('discount_in_per', isset($order->discount_in_per) ? $order->discount_in_per : ''), ['class' => 'form-control','placeholder' => 'Discount Percentage']) !!}
        </div> --}}
        {{-- 149HP025L 149 --}}
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <!-- <label>Customer State</label> -->
           {!! Form::text('state', old('state', isset($order->state) ? $order->state : ''), ['class' => 'form-control customerstate','rows'=>2, 'placeholder' => 'state','required' => 'required']) !!}  
          

        </div>
        <div class="col-md-12">
           <!--  <label>Company State</label> -->
            @foreach(\App\Models\Company::all() as $cp)
            <input type="text" name="" class="form-control cpstate" class="form-control" value="{{$cp->state}}">
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        {{-- <div class="col-md-12">
            {!! Form::label('discount_amount', 'Discount Amount') !!}
            {!! Form::number('discount_amount', old('discount_amount', isset($order->discount_amount) ? $order->discount_amount : ''), ['class' => 'form-control','placeholder' => 'Discount Amount']) !!}
        </div> --}}
        <div class="col-md-12">
            {!! Form::label('grand_total', 'Grand Total') !!}
            {!! Form::number('grand_total', old('grand_total', isset($order->grand_total) ? $order->grand_total : ''), ['class' => 'form-control grand_total','placeholder' => 'Grand Total','readonly' => 'readonly']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('igst', 'IGST') !!}
            {!! Form::number('igst', old('igst', isset($order->igst) ? $order->igst : 0), ['class' => 'form-control igst','placeholder' => 'IGST','readonly' => 'readonly']) !!}
             <input type="number" name="igst" class="form-control dstate" readonly value="0" style="display:none">
        </div>
        {{-- <div class="col-md-12">
            {!! Form::label('discount_on_total', 'Apply Additional Discount On (Grand Total / Net Total)') !!}
            {!! Form::number('discount_on_total', old('discount_on_total', isset($order->discount_on_total) ? $order->discount_on_total : ''), ['class' => 'form-control','placeholder' => 'Apply Additional Discount On (Grand Total / Net Total)','required' => 'required']) !!}
        </div> --}}
    </div>
</div>

<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('sgst', 'SGST') !!}
            {!! Form::number('sgst',old('igst', isset($order->sgst) ? $order->sgst : 0), ['class' => 'form-control sgst','placeholder' => 'SGST','readonly' => 'readonly']) !!}
            <input type="number" name="sgst"  value="0" class="form-control samesgst" style="display:none" readonly="">
        </div>
        <div class="col-md-12">
            {!! Form::label('cgst', 'CGST') !!}
            {!! Form::number('cgst', old('cgst', isset($order->cgst) ? $order->cgst : 0), ['class' => 'form-control cgst','placeholder' => 'CGST','readonly' => 'readonly']) !!}
            <input type="number" name="cgst"  value="0" class="form-control samecgst" style="display:none" readonly="">
        </div>
    </div>
</div>
{{-- <div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('total_cess_amount', 'Total Cess Amount') !!}
            {!! Form::number('total_cess_amount', old('total_cess_amount', isset($order->total_cess_amount) ? $order->total_cess_amount : 0), ['class' => 'form-control total_cess_amount','placeholder' => 'Total Cess Amount','readonly' => 'readonly']) !!}
        </div>
    </div>
</div> --}}
{{-- <div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('total_tax_amount', 'Total Tax Amount') !!}
            {!! Form::number('total_tax_amount', old('total_tax_amount', isset($order->total_tax_amount) ? $order->total_tax_amount : ''), ['class' => 'form-control','placeholder' => 'Total Tax Amount','required' => 'required']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('total_amount', 'Total Amount') !!}
            {!! Form::number('total_amount', old('total_amount', isset($order->total_amount) ? $order->total_amount : 0), ['class' => 'form-control','placeholder' => 'Total Amount','required' => 'required']) !!}
        </div>
    </div>
</div> --}}
@if(isset($other->is_account_details))
    {{-- @include('admin.transactions.account_details') --}}
@endif
@if(isset($transporter))
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('transporter', 'Transporter') !!}
            {!! Form::select('transporter', ['' => 'Select a Transporter'] + $transporter, old('transporter', isset($order->transporter) ? $order->transporter : ''), ['class' => 'form-control transporter'] ) !!}
            {{-- {!! Form::text('transporter', old('credit_days', isset($order->credit_days) ? $order->transporter : ''), ['class' => 'form-control','placeholder' => 'Transporter']) !!} --}}
        </div>
        <div class="col-md-12">
            {!! Form::label('reference', 'Reference') !!}
            {!! Form::text('reference', old('reference', isset($order->reference) ? $order->reference : ''), ['class' => 'form-control','placeholder' => 'Reference']) !!}
        </div>
    </div>
</div>
@endif
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('credit_days', 'Credit Days') !!}
            {!! Form::number('credit_days', old('credit_days', isset($order->credit_days) ? $order->credit_days : ''), ['class' => 'form-control','placeholder' => 'Credit Days']) !!}
        </div>
        {{-- <div class="col-md-12">
            {!! Form::label('due_date', 'Due Date') !!}
            {!! Form::text('due_date', old('due_date', isset($order->due_date) ? $order->due_date : ''), ['class' => 'form-control datepicker','placeholder' => 'Due Date', 'autocomplete' => 'off']) !!}
        </div> --}}
    </div>
</div>
<div class="form-group">
    @if(isset($is_submit_show))
        {!! Form::button('Print', ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    @endif

    {!! link_to_route($other->listing_link, 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>

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
        $('.mainBranch').prop('disabled',true);
    })
</script>
@parent
<script type="text/javascript">
    function getSupplierDetails(supplier_id)
    {
        if (supplier_id != '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{url("admin/transactions/purchase/getSupplierDetails")}}',
                data: {supplier_id: supplier_id},
                success: function (data) {
                    console.log(data);
                    $('#address').val(data.supplier_details.address);
                    $('#credit_days').val(data.supplier_details.default_credit_period);
                    $('.approved_vendor_code').val(data.supplier_details.approved_vendor_code);
                    $('.customerstate').val(data.supplier_details.state);
                    var consineeAdd = data.supplier_details.consignee_addresses;
                    var options = '';
                    $.each(consineeAdd, function(key, obj) { // Cycle through each associated role
                          options += '<option value="'+obj.id+'">' +obj.branch_name+ '</option>';
                    });
                    $('#branch_id').html(options);
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
    function getOrderDetails(po_id)
    {
        if (po_id != '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{url("admin/transactions/purchase/getOrderDetails")}}',
                data: {po_id: po_id},
                success: function (data) {
                    console.log(data);
                    $('#address').val(data.order_details.address);
                    $('#credit_days').val(data.order_details.default_credit_period);
                    $('.approved_vendor_code').val(data.order_details.approved_vendor_code);
                     $('.customerstate').val(data.order_details.state);
                    console.log(data.order_details.branch_id);
                    var BranchId = (data.order_details.branch != null) ? data.order_details.branch.id : '';
                    //console.log(BranchId)
                    
                    let branch = $('.branch_id');
                        branch.empty();
                    $('#branch_id').val(BranchId);
                    var mainBranch=data.order_details.branch_id;
                    if(mainBranch==0){
                        $('.branch_id').hide();
                        $('.mainBranch').show();
                        $('.branch_id').prop('disabled',true);
                        $('.mainBranch').prop('disabled',false);
                        $('.mainBranch').val(data.order_details.main_branch);
                    }else{
                        $('.mainBranch').hide();
                        $('.mainBranch').prop('disabled',true);
                        $('.branch_id').show();
                        $('.branch_id').prop('disabled',false);
                        /*$.each(data.order_details.branch, function(key,value){
                            console.log('asha');
                        })*/
                    }
                     if(data.order_details.branches != null)
                        {
                            branch.append("<option value='"+ data.order_details.branches.id +"'>" + data.order_details.branches.branch_name + "</option>");
                        }


                    $('#supplier_id').val(data.order_details.supplier_id);
                    $('#required_date').val(data.order_details.required_date);
                    $('#warehouse_id').val(data.order_details.warehouse_id);
                    $('#grand_total').val(data.order_details.grand_total);
                    $('#igst').val(data.order_details.igst);
                    $('.samesgst').val(data.order_details.sgst);
                    $('.samecgst').val(data.order_details.cgst);
                    $('#credit_days').val(data.order_details.credit_days);
                    $('#total_net_amount').val(data.order_details.net_amount);
                    $('#total_grand_amount').val(data.order_details.total_net_amount);

                    $('#total_other_grand_amount').val(data.order_details.total_other_net_amount);
                    $('#other_net_amount').val(data.order_details.other_net_amount);

                    if(data.order_details.items.length)
                    {
                        addPIItem(data.order_details.items);
                    }

                    if(data.order_details.other_charges.length) {
                        addPIOtherItem(data.order_details.other_charges);
                    }

                    /*$.each(data.order_details.items, function(key, value) {

                        // console.log(value.stock_item_id);
                        $('.add-items-list .item_name').val(value.stock_item_id);
                        $('.add-items-list .item_code').val(value.item_code);
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
                         $('#other_charge_type').val(ovalue.type);
                         $('.account_head').val(ovalue.general_ledger_id);
                         $('.other_rate').val(ovalue.rate);
                         $('.other_amount').val(ovalue.amount);
                         $('.other_tax').val(ovalue.tax);
                         $('.other_tax_amount').val(ovalue.tax_amount);
                         $('.other_total_amount').val(ovalue.total_amount);
                    });*/
                }
            });
        } else {
            $('#address').val('');
            $('#credit_days').val('');
        }
    }

    addPIItem = function(pi_items)
    {
        var item = $(".add-items-list").children("tr.new-item:last-child");

        item.find(".select2-elem").each(function(index)
        {
            $(this).select2('destroy');
        });
        var item_template = item.clone();

        var element_counter = 0;
        $(".add-items-list").empty();

        $.each(pi_items, function(key, value) {

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

    addPIOtherItem = function(pr_items)
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
    }
</script>
<script type="text/javascript">
    var customerstate=$('.customerstate').val();
    var cpstate=$('.cpstate').val();
    if(customerstate==cpstate){
        $('.dstate').show();
        $('.igst').prop('disabled',true)
        $('.dstate').prop('disabled',false)
        $('.igst').hide();
        $('.sgst').show();
        $('.sgst').prop('disabled',false);
        $('.samesgst').hide();
        $('.samesgst').prop('disabled',true);
        $('.samecgst').hide();
        $('.samecgst').prop('disabled',true);
        $('.cgst').show();
        $('.cgst').prop('disabled',false);
    }else{
        $('.dstate').hide();
        $('.igst').show();
        $('.dstate').prop('disabled',true)
        $('.igst').prop('disabled',false)
        $('.samesgst').show();
        $('.sgst').hide();
        $('.samecgst').show();
        $('.cgst').hide();
    }
</script>
@endsection
