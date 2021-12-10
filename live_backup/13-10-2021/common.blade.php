@if($other->order_type != 2)
<div class="form-group">
    {!! Form::label('approved_vendor_code', 'Customer Code *') !!}
    {!! Form::text('approved_vendor_code', old('approved_vendor_code', isset($order->approved_vendor_code) ? $order->approved_vendor_code : ''), ['class' => 'form-control approved_vendor_code','id'=>'approved_vendor_code','required' => 'required'] ) !!}
</div>
@endif
<div class="form-group">
    {!! Form::label('address', 'Address *') !!}
    {!! Form::textarea('address', old('address', isset($order->address) ? $order->address : ''), ['class' => 'form-control','rows'=>2, 'placeholder' => 'Address','required' => 'required']) !!}
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            
            @if(isset($consignee_address_po) && $consignee_address_po->count() && $order->branch_id!=0)
                    <label>Branch</label>
                    <select id="branch_id" name="branch_id" data-plugin-selectTwo class="form-control branch_id" data-name="branch_id" disabled="true">
                        
                        @foreach($consignee_address_po as $value)
                        <option value="{{ $value->id }}"   @if(isset($order->branch_id)) @if($order->branch_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->branch_name }} </option>
                        @endforeach
                    </select>
            @elseif(isset($order))
                {!! Form::label('branch_id', 'Branch') !!}
                {!! Form::select('branch_id', (!empty($consignee_address)) ? ['' => $order->branch]+$consignee_address : [$order->branch => $order->branch], old('branch_id', isset($order->branch_id) ? $order->branch_id : ''), ['class' => 'form-control branch_id','id'=>'branch_id','disabled'] ) !!}
            @else
            {!! Form::label('branch_id', 'Branch') !!}
                {!! Form::select('branch_id', (!empty($consignee_address)) ? ['' => 'Select a Branch']+$consignee_address : ['' => 'Select branch'], old('branch_id', isset($order->branch_id) ? $order->branch_id : ''), ['class' => 'form-control branch_id','id'=>'branch_id'] ) !!}
            @endif
        </div>
        
        <div class="col-md-12">
            {!! Form::label('required_date', 'Required By Date *') !!}
            {!! Form::text('required_date', old('required_date', isset($order->required_date) ? $order->required_date : ''), ['class' => 'form-control datepicker','placeholder' => 'Required Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>

    </div>
</div>
<div class="form-group">
    <div class="form-row">

        @if($other->order_type == 2)
        <div class="col-md-12">
            {!! Form::label('user_id', 'Sales Person *') !!}
            {!! Form::select('user_id', ['' => 'Select a Sales Person'] + $sales_person, old('user_id', isset($order->sales_person_id) ? $order->sales_person_id : ''), ['class' => 'form-control','required' => 'required'] ) !!}
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
@if(isset($other->show_sales_batch))
    @include('admin.transactions.sales.sales_items')
@else
    @include('admin.transactions.items')
@endif

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
           {!! Form::hidden('state', old('state', isset($order->state) ? $order->state : ''), ['class' => 'form-control customerstate','rows'=>2, 'placeholder' => 'state','required' => 'required']) !!}  
          {{--  <input type="text" name="" class="customerstate" value=""> --}}

        </div>
        <div class="col-md-12">
            <!-- <label>Company State</label> -->
            @foreach(\App\Models\Company::all() as $cp)
            <input type="hidden" name="" class="form-control cpstate" class="form-control" value="{{$cp->state}}">
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
            {!! Form::number('grand_total', old('total_grand_amount', isset($order->grand_total) ? $order->grand_total : 0), ['class' => 'form-control grand_total','placeholder' => 'Grand Total','readonly' => 'readonly']) !!}
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
            {{-- {!! Form::text('transporter', old('credit_days', isset($order->credit_days) ? $order->transporter : ''), ['class' => 'form-control','id'=>'credit_days',placeholder' => 'Transporter']) !!} --}}
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
        {!! Form::submit('Submit', ['class' => 'btn btn-primary submitdata']) !!}
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
        $('body').submit('.submitdata',function(){
            $('.branch_id').prop('disabled',false);
        })

    });
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
                    $('#address').val(data.supplier_details.address);
                    $('#credit_days').val(data.supplier_details.default_credit_period);
                    $('.approved_vendor_code').val(data.supplier_details.approved_vendor_code);
                    $('.customerstate').val(data.supplier_details.state);
                    var optionsa =data.supplier_details.branchname;
                    //$('#testone').val(optionsa);
                    var consineeAdd = data.supplier_details.consignee_addresses;
                    var options = '<option value="'+optionsa+'">'+optionsa+'</option>';

                    $.each(consineeAdd, function(key, obj) { // Cycle through each associated role  
                          options += '<option value="'+obj.id+'">' +obj.branch_name+ '</option>';    
                    });

                    $('.branch_id').html(options);
                    $('.branch_id').prop('disabled',false);
                    //$('.branch_id').append(optionsa);
                    //$( ".branch_id option:selected" ).text();
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
    $('body').on('change','.branch_id',function(){
        var branch_id=$(this).val();
        //alert(branch_id);
            if(branch_id!=null){
                $.ajax({
                type:'post',
                url:'{{url("admin/transactions/purchase/getAddressDetails")}}',
                data:{branch_id:branch_id},
                success:function(data){    
                    $('#address').val(data.address_details.address);
                }
            })    
            }
            
    })
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
