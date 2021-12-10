@include('common.messages')
@include('common.errors')
<div class="form-group">
    @if(isset($is_submit_show))
        {!! Form::button('Print', ['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('Submit', ['class' => 'btn btn-primary submitdata']) !!}
    @endif
        {!! link_to_route($other->listing_link, 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    <div class="form-row">
        
            <!-- {{-- <label for="order_no">Purchase Order No</label>
            <input type="text" class="form-control order_no" id="order_no" name="order_no" value="{{old('order_no', isset($order->order_no) ? $order->order_no : '')}}" placeholder="Purchase Order No">
            @if ($errors->has('order_no'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('order_no') }}</strong>
            </span>
            @endif --}}
            <label>Select Series</label>
            @if(isset($order))
            <select class="form-control select1"  name="series_type" disabled="true">
                        <option>Select Series</option> 
                            @if(!empty($purchaseorderseries))
                                @foreach($purchaseorderseries as $value)
                                    <option value="{{ $value->id }}" @if(isset($order->series_type)) 
                                        @if($order->series_type == $value->id){{"selected='selected'"}}{{ "disabled='true'" }} @endif @endif> {{ $value->series_name }} </option>
                                @endforeach
                            @endif
                    </select>
            @else
           <select class="form-control select1"  name="series_type">
                        <option>Select Series</option> 
                            @if(!empty($purchaseorderseries))
                                @foreach($purchaseorderseries as $value)
                                    <option value="{{ $value->id }}" @if(isset($order->series_type)) 
                                        @if($order->series_type == $value->id){{"selected='selected'"}}@endif @endif> {{ $value->series_name }} </option>
                                @endforeach
                            @endif
                    </select>
            @endif -->
        @if(isset($order))
        <div class="col-md-12">
            <label>Pr No</label>
            <input type="text" name="order_no" id="order_no" class="form-control" value="{{$order->order_no}}" readonly=""> 
        </div>
        @else
        <div class="col-md-12">
         @foreach($purchaseseries as $key=>$value)
            @if($value->request_type=='automatic')
             <label>Pr No</label>
            <input type="text" name="order_no" id="order_no" class="form-control" value="{{$value->prefix_static_charcter}}{{$value->series_current_digit}}{{$value->suffix_static_charcter}}" readonly="">
            @else
            <label>Pr No</label>
            <input type="text" name="order_no" class="form-control" placeholder="order_no">
            @endif 
            @endforeach
        </div>
        @endif
        <div class="col-md-12">
            <label for="order_no">Material Request Number *</label>
            <select id="material_id" name="material_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="material_id">
                <option value="">Select Material ID</option>
                @if(!empty($materials_data))
                    @foreach($materials_data as $value)
                        @php
                            $material_item = $value->material_items()->first();
                            $item_name = ((isset($material_item->item->name) && !empty($material_item->item->name))) ? $material_item->item->name : '';
                        @endphp
                        <option value="{{ $value->id }}"   @if(isset($order->material_id)) @if($order->material_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->series_id . ((!empty($item_name)) ? ' (' . $item_name . ')' : '') }} </option>
                    @endforeach
                @endif
            </select>
        </div>
        <!-- <div class="col-md-12">
            <label for="order_no">PR NO *</label>
            {{-- <select id="material_id" name="material_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="material_id">
                <option value="">Select Material ID</option>
                @if(!empty($materials_data))
                    @foreach($materials_data as $value)
                        @php
                            $material_item = $value->material_items()->first();
                            $item_name = ((isset($material_item->item->name) && !empty($material_item->item->name))) ? $material_item->item->name : '';
                        @endphp
                        <option value="{{ $value->id }}"   @if(isset($order->material_id)) @if($order->material_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->series_id . ((!empty($item_name)) ? ' (' . $item_name . ')' : '') }} </option>
                    @endforeach
                @endif
            </select> --}}
             <input type="text" class="form-control order_no" id="order_no" name="order_no" value="{{old('order_no', isset($order->order_no) ? $order->order_no : '')}}" placeholder="Purchase Order No" readonly>
            @if ($errors->has('order_no'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('order_no') }}</strong>
            </span>
            @endif
            <input type="text" name="manual_id" class="form-control material_id" id="manual_id" style="display:none"> 
             @if ($errors->has('manual_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('manual_id') }}</strong>
        </span>
    @endif
        </div> -->
        
    </div>
</div>

<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <!-- <label for="order_no">Material Request Number *</label>
            <select id="material_id" name="material_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="material_id">
                <option value="">Select Material ID</option>
                @if(!empty($materials_data))
                    @foreach($materials_data as $value)
                        @php
                            $material_item = $value->material_items()->first();
                            $item_name = ((isset($material_item->item->name) && !empty($material_item->item->name))) ? $material_item->item->name : '';
                        @endphp
                        <option value="{{ $value->id }}"   @if(isset($order->material_id)) @if($order->material_id == $value->id){{"selected='selected'"}} @endif @endif > {{ $value->series_id . ((!empty($item_name)) ? ' (' . $item_name . ')' : '') }} </option>
                    @endforeach
                @endif
            </select> -->
            {!! Form::label('order_date', 'Order Date *') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : date('d/m/Y')), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!}
        </div>
        <div class="col-md-12">
            <!-- {!! Form::label('order_date', 'Order Date *') !!}
            {!! Form::text('order_date', old('order_date', isset($order->order_date) ? $order->order_date : date('Y-m-d')), ['class' => 'form-control datepicker', 'placeholder' => 'Order Date','required' => 'required', 'autocomplete' => 'off']) !!} -->
            <!-- <label for="order_no">Select Item</label>
            <select id="po_item_id" name="po_item_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="po_item_id">
                <option value="">Select Item Code/Name</option>
                @if(!empty($stockItem))
                    @foreach($stockItem as $value)
                        <option value="{{ $value->id }}" @if(isset($order->po_item_id)) @if($order->po_item_id == $value->id){{"selected='selected'"}} @endif @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                    @endforeach
                @endif
            </select> -->
              {!! Form::label('supplier_id', 'Supplier *') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['onchange'=>'getSupplierDetails(this.value)','class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('supplier_id') }}</strong>
    </span>
    @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
        <!-- <label for="order_no">Select Item</label>
            <select id="po_item_id" name="po_item_id" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="po_item_id">
                <option value="">Select Item Code/Name</option>
                @if(!empty($stockItem))
                    @foreach($stockItem as $value)
                        <option value="{{ $value->id }}" @if(isset($order->po_item_id)) @if($order->po_item_id == $value->id){{"selected='selected'"}} @endif @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                    @endforeach
                @endif
            </select> -->
          <!--   {!! Form::label('supplier_id', 'Supplier *') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['onchange'=>'getSupplierDetails(this.value)','class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('supplier_id') }}</strong>
    </span>
    @endif -->
    
    </div>
    <div class="col-md-12">
         <!-- {!! Form::label('supplier_id', 'Supplier *') !!}
    {!! Form::select('supplier_id', ['' => 'Select a Supplier'] + $suppliers, old('supplier_id', isset($order->supplier_id) ? $order->supplier_id : ''), ['onchange'=>'getSupplierDetails(this.value)','class' => 'form-control','required' => 'required'] ) !!}
    @if ($errors->has('supplier_id'))
    <span class="help-block text-danger">
        <strong>{{ $errors->first('supplier_id') }}</strong>
    </span>
    @endif -->
</div>
</div>
</div>
{{--
<div class="form-group">
    <label for="order_no">Status</label>
    <select id="status" name="status" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="status" >
        <option value="1" id="status_1" @if(isset($order->status)) @if($order->status == 1){{"selected='selected'"}} @endif @else {{"selected='selected'"}} @endif >Open</option>
        <option value="2" id="status_2" @if(isset($order->status)) @if($order->status == 2){{"selected='selected'"}} @endif @endif>Partial</option>
        <option value="3" id="status_3" @if(isset($order->status)) @if($order->status == 3){{"selected='selected'"}} @endif @endif>Close</option>
    </select>
</div>
--}}

@include('admin.transactions.common')
