@include('common.messages')
@include('common.errors')
<div class="form-group">
    @if(isset($is_submit_show))
        {!! Form::button('Print', ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    @endif
    {!! link_to_route('purchase-receipt.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>



<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
           <!--  <label>Purchase Receipt Series</label>
            <select class="form-control"  name="series_type">
                <option>Select Series</option>
                @foreach($purchasereciptseries as $key=>$value)
                <option value="{{$value->id}}">{{$value->series_name}}</option>
                @endforeach
            </select> -->
            @foreach($purchasereciptseriesstatus as $key=>$value)
            @if($value->request_type=='automatic')
            <label>Po Reference</label>
            <input type="text" name="receipt_no" class="form-control" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly="">
            @else
            <label>Po Reference</label>
            <input type="text" name="receipt_no" class="form-control">
            @endif
            @endforeach
            
        </div>
        <div class="col-md-12">
           <!--  {!! Form::label('po_id', 'PO Reference') !!}
            {!! Form::select('po_id', ['0' => 'Select a PO'] + $purchase_orders , old('po_id', isset($order->po_id) ? $order->po_id : ''), ['class' => 'form-control po_id','required' => 'required'] ) !!} -->
           <!--  {!! Form::label('mr no', 'PR No *') !!}
           {!! Form::text('receipt_no', old('receipt_no', isset($order->receipt_no) ? $order->receipt_no : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!}
            <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
            @if ($errors->has('manual_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('manual_id') }}</strong>
                </span>
            @endif
            <input type="hidden" name="suffix" id="suffix">
            <input type="hidden" name="prefix" id="prefix">
            <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->
            {!! Form::label('po_id', 'PO Reference') !!}
            {!! Form::select('po_id', ['0' => 'Select a PO'] + $purchase_orders , old('po_id', isset($order->po_id) ? $order->po_id : ''), ['class' => 'form-control po_id','required' => 'required'] ) !!}
            
        </div>
        {{-- <div class="col-md-12">
            {!! Form::label('order_date', 'Order Date') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div> --}}
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('supplier_id', 'Supplier *') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['onchange'=>'getSupplierDetails(this.value)','class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('supplier_id') }}</strong>
        </span>
    @endif        
        </div>
    <div class="col-md-12">
    {!! Form::label('branch_id', 'Branch') !!}
            {!! Form::select('branch_id', ['' => isset($order->main_branch)? $order->main_branch :'Select a Branch'] + $consignee_address, old('branch_id', isset($order->supplier_id) ? $order->branch_id : ''), ['class' => 'form-control branch_id', (count($consignee_address) == 0) ? 'disabled' : ''] ) !!}
            @if ($errors->has('branch_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('branch_id') }}</strong>
                </span>
            @endif
            <input type="text" name="branch_id" class="form-control mainBranch" style="display:none">
    </div>
</div>
</div>
{{-- <div class="form-group">
    {!! Form::label('address', 'Address') !!}
    {!! Form::textarea('address', old('address', isset($order->address) ? $order->address : ''), ['class' => 'form-control','rows'=>2, 'placeholder' => 'Address','required' => 'required']) !!}
</div> --}}
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('date', 'Date *') !!}
            {!! Form::text('date', old('date', isset($order->date) ? $order->date : ''), ['class' => 'form-control datepicker','placeholder' => 'Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('warehouse_id', 'Set Target Warehouse') !!}
            {!! Form::select('warehouse_id', ['0' => 'Select a Warehouse'] + $warehouses, old('warehouse_id', isset($order->warehouse_id) ? $order->warehouse_id : ''), ['class' => 'form-control', (count($warehouses) == 0) ? 'disabled' : ''] ) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            
        </div>
        {{--
            <div class="col-md-12">
                {!! Form::label('batch_id', 'Batch') !!}
                {!! Form::select('batch_id', ['0' => 'Select a Batch'] + $batches , old('batches', isset($order->batch_id) ? $order->batch_id : ''), ['class' => 'form-control batch_id'] ) !!}
            </div>
        --}}
    </div>
</div>
{{-- @include('admin.transactions.purchase.purchase-receipt.item') --}}
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Stock Items</legend>
    <div class="form-group">

        <div class="form-row">
            <div class="col-md-12">
                <label>Item Code/Name *</label>
                <select id="stock_item_id" name="stock_item_id" data-plugin-selectTwo class="form-control stock_item_id select2-elem select2" data-name="stock_item_id" required="required">
                    <option value="">Select Item Code/Name</option>
                    @if(!empty($stockItem))

                    @foreach($stockItem as $value)
                    <option value="{{ $value->id }}" @if(isset($order->purchase_items->stock_item_id)) @if($order->purchase_items->stock_item_id == $value->id){{"selected='selected'"}} @endif @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                    @endforeach
                    @endif
                </select>
                <input type="hidden" name="item_code" id="item_code" value="{{old('item_code', isset($order->purchase_items->item_code) ? $order->purchase_items->item_code : '')}}">
            </div>
            <div class="col-md-12">
                {!! Form::label('item_batch_id', 'Batch') !!}
                {!! Form::select('item_batch_id', ['0' => 'Select a Batch'] , old('item_batch_id', isset($order->purchase_items->batch_id) ? $order->purchase_items->batch_id : ''), ['class' => 'form-control batch_id'] ) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('unit', 'UOM') !!}
                {!! Form::select("unit", $units, old('unit', isset($order->unit) ? $order->unit : ''), ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('po_quantity', 'PO Quantity *') !!}
                {!! Form::text('po_quantity', old('po_quantity', isset($order->purchase_items->po_quantity) ? $order->purchase_items->po_quantity : ''), ['class' => 'form-control po_quantity','placeholder' => 'PO Quantity','required' => 'required']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('receipt_quantity', 'Receipt Quantity *') !!}
                {!! Form::text('receipt_quantity', old('receipt_quantity', isset($order->purchase_items->receipt_quantity) ? $order->purchase_items->receipt_quantity : ''), ['class' => 'form-control','placeholder' => 'Receipt Quantity','required' => 'required']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('no_of_container', 'No of Container *') !!}
                {!! Form::number('no_of_container', old('no_of_container', isset($order->purchase_items->no_of_container) ? $order->purchase_items->no_of_container : ''), ['class' => 'form-control','placeholder' => 'No of Container','required' => 'required']) !!}
            </div>
        </div>
    </div>
</fieldset>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('approved_vendor_code', 'Approved Vendor Code') !!}
            {!! Form::text('approved_vendor_code', old('approved_vendor_code', isset($order->approved_vendor_code) ? $order->approved_vendor_code : ''), ['class' => 'form-control approved_vendor_code','placeholder' => 'Approved Vendor Code','readonly'=>'readonly']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('shortage_qty', 'Any shortage/Excess Qty') !!}
            {!! Form::number('shortage_qty', old('shortage_qty', isset($order->shortage_qty) ? $order->shortage_qty : ''), ['class' => 'form-control','placeholder' => 'Any shortage/Excess Qty']) !!}
        </div>
    </div>
</div>
<div class="form-group">
        {!! Form::label('qc_status', 'QC Status') !!}
        <br/>
        {!! Form::radio('qc_status', 1, isset($order->qc_status) && ($order->qc_status == 1) ? true : false, ['id' => 'qc_status_yes', 'disabled']) !!}
        {!! Form::label('qc_status', 'Approved', ['class' => 'form-check-label']) !!}

        {!! Form::radio('qc_status', 0, isset($order->qc_status) && ($order->qc_status == 0) ? true : false, ['id' => 'qc_status_no', 'disabled']) !!}
        {!! Form::label('qc_status', 'Pending', ['class' => 'form-check-label']) !!}
    </div>
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">GRN Details</legend>
    <div class="form-group">
        {!! Form::label('good_condition_container', 'All Containers are good condition') !!}
        <br/>
        {!! Form::radio('good_condition_container', 1, isset($order->good_condition_container) && ($order->good_condition_container == 1) ? true : true, ['id' => 'good_condition_container_yes','class'=>'good_condition_container']) !!}
        {!! Form::label('good_condition_container_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('good_condition_container', 0, isset($order->good_condition_container) && ($order->good_condition_container == 0) ? true : false, ['id' => 'good_condition_container_no','class'=>'good_condition_container']) !!}
        {!! Form::label('good_condition_container_no', 'No', ['class' => 'form-check-label']) !!}

        {!! Form::text('good_condition_container_remarks', old('good_condition_container_remarks', isset($order->good_condition_container_remark) ? $order->good_condition_container_remark : ''), ['class' => 'col-md-5 good_condition_container_remarks','placeholder' => 'Remarks']) !!}

    </div>
    <div class="form-group">
        {!! Form::label('container_have_product', 'All Containers have product name & grade') !!}
        <br/>
        {!! Form::radio('container_have_product', 1, isset($order->container_have_product) && ($order->container_have_product == 1) ? true : true, ['id' => 'container_have_product_yes']) !!}
        {!! Form::label('container_have_product_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('container_have_product', 0, isset($order->container_have_product) && ($order->container_have_product == 0) ? true : false, ['id' => 'container_have_product_no']) !!}
        {!! Form::label('container_have_product_no', 'No', ['class' => 'form-check-label']) !!}

        {!! Form::text('container_have_product_remarks', old('container_have_product_remarks', isset($order->container_have_product_remark) ? $order->container_have_product_remark : ''), ['class' => 'col-md-5 container_have_product_remarks','placeholder' => 'Remarks']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('container_have_tare_weight', 'All Containers are identified with B.No. & Tare Weight') !!}
        <br/>
        {!! Form::radio('container_have_tare_weight', 1, isset($order->container_have_tare_weight) && ($order->container_have_tare_weight == 1) ? true : true, ['id' => 'container_have_tare_weight_yes']) !!}
        {!! Form::label('container_have_tare_weight_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('container_have_tare_weight', 0, isset($order->container_have_tare_weight) && ($order->container_have_tare_weight == 0) ? true : false, ['id' => 'container_have_tare_weight_no']) !!}
        {!! Form::label('container_have_tare_weight_no', 'No', ['class' => 'form-check-label']) !!}

        {!! Form::text('container_have_tare_weight_remarks', old('container_have_tare_weight_remarks', isset($order->container_have_tare_weight_remark) ? $order->container_have_tare_weight_remark : ''), ['class' => 'col-md-5 container_have_tare_weight_remarks','placeholder' => 'Remarks']) !!}
    </div>
</fieldset>

<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Dedusting Record</legend>
        <div class="form-group">
            {!! Form::label('container_dedust_with', 'All containers are dedust with') !!}
            {!! Form::text('container_dedust_with', old('container_dedust_with', isset($order->container_dedust_with) ? $order->container_dedust_with : ''), ['class' => 'form-control','placeholder' => '']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('dedust_done_by', 'Dedusting Done by') !!}
            {!! Form::text('dedust_done_by', old('dedust_done_by', isset($order->dedust_done_by) ? $order->dedust_done_by : ''), ['class' => 'form-control','placeholder' => '']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('dedust_check_by', 'Dedusting check by') !!}
            {!! Form::text('dedust_check_by', old('dedust_check_by', isset($order->dedust_check_by) ? $order->dedust_check_by : ''), ['class' => 'form-control','placeholder' => '']) !!}
        </div>
</fieldset>
<div class="form-group">
    @if(isset($is_submit_show))
        {!! Form::button('Print', ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    @endif
    {!! link_to_route('purchase-receipt.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('change', '.po_id', function(e) {
                e.preventDefault();
                var po_id = $(this).val();
//                console.log(po_id);
                //alert(po_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{url("admin/transactions/purchase/getPoItemsDetails")}}',
                    data:{po_id:po_id},
                    success:function(data){
                            console.log(data);

                            $('.approved_vendor_code').val(data.po_order_details.approved_vendor_code);
                            var stock_ids = $('#stock_item_id');
                            stock_ids.empty();
                            stock_ids.append($("<option />").val('').text('Select Item'));
                            $.each(data.po_items, function(index, value) {
                                stock_ids.append($("<option />").val(index).text(value));
                            });

                            var supplier_id = $('#supplier_id');
                            supplier_id.empty();
                            $.each(data.suppliers, function(index2, value2) {
                                supplier_id.append($("<option />").val(index2).text(value2));
                            });

                            $("#supplier_id").val(data.po_order_details.supplier_id);
                            //$("#branch_id").val(data.po_order_details.branch_id);
                            var mainBranch=data.po_order_details.branch_id;
                            if(mainBranch==0){
                                $('.mainBranch').show();
                                $('.branch_id').hide();
                                $('.branch_id').prop('disabled',true);
                                $('.mainBranch').prop('disabled',false);
                                $('.mainBranch').val(data.po_order_details.main_branch);
                            }else{
                                 $('.mainBranch').hide();
                                $('.branch_id').show();
                                $('.mainBranch').prop('disabled',true);
                                $('.branch_id').prop('disabled',false);
                            }
                            console.log('mamata');
                            console.log(data.branches);
                          let branch = $('.branch_id');
                          branch.empty();
                        if(data.branches != null)
                        {
                            $.each(data.branches, function(index, value) {
                                branch.append($("<option />").val(index).text(value));
                            });
                        }
                            if(data.po_stock_item != null || data.po_stock_item != undefined)
                            {
                                $("#stock_item_id").val(data.po_stock_item.stock_item_id);
                                $("#unit").val(data.po_stock_item.unit);
                                $("#po_quantity").val(data.po_stock_item.quantity);
                            }
                        }
                    });
            });

            $(document).on('change', '.stock_item_id', function() {
                var item_id = $(this).val();
                var po_id = $('#po_id option:selected').val();
//                console.log(po_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{url("admin/transactions/purchase/getStockItems")}}',
                    data:{item_id:item_id,po_id:po_id},
                    success:function(data){
                            //console.log(data);
                            $("#item_code").val(data.stockItem.product_code);
                            $.each(data.poDetails, function(key, value) {
                                $(".po_quantity").val(value.item_pending);
                            });

                            var item_batch_ids = $('#item_batch_id');
                            item_batch_ids.empty();
                            item_batch_ids.append($("<option />").val('').text('Select a Batch'));
                            if(data.batches != null || data.batches != undefined)
                            {
                                $.each(data.batches, function(index, value) {
                                    item_batch_ids.append($("<option />").val(index).text(value));
                                });
                            }
                        }
                    });
            });

            $(document).on('keyup', '#receipt_quantity', function (e) {
                var ReceiptQty = $('#receipt_quantity').val();
                if (ReceiptQty != undefined && ReceiptQty != '') {
                    var POQty = $('.po_quantity').val();
//                    console.log(POQty);
//                    console.log(ReceiptQty);
                    var RemainQty = parseFloat(POQty) - parseFloat(ReceiptQty);
                    $('#shortage_qty').val(RemainQty);
                }
            });

            grnRemarksSetting = function(value,class_name)
            {
                if (value == '1') {
                    $('.'+class_name).hide();
                }
                else if (value == '0') {
                    $('.'+class_name).show();
                }
            };

            var good_condition_container = $('input[type=radio][name=good_condition_container]:checked').val();
            grnRemarksSetting(good_condition_container,'good_condition_container_remarks');
            grnRemarksSetting($('input[type=radio][name=container_have_product]:checked').val(),'container_have_product_remarks');
            grnRemarksSetting($('input[type=radio][name=container_have_tare_weight]:checked').val(),'container_have_tare_weight_remarks');

            $('input[type=radio][name=good_condition_container]').change(function() {
                grnRemarksSetting(this.value,'good_condition_container_remarks');
            });

            $('input[type=radio][name=container_have_product]').change(function() {
                grnRemarksSetting(this.value,'container_have_product_remarks');
            });

            $('input[type=radio][name=container_have_tare_weight]').change(function() {
                grnRemarksSetting(this.value,'container_have_tare_weight_remarks');
            });
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

        });
    </script>
    @endsection
