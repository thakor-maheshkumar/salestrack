@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('batches.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('batch_id', 'Batch ID *') !!}
    {!! Form::text('batch_id', old('batch_id', isset($item->batch_id) ? $item->batch_id : ''), ['class' => 'form-control', 'placeholder' => 'Batch ID', 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('warehouse_id', 'Item Warehouse') !!}
    {!! Form::select('warehouse_id', ['0' => 'Select a Warehouse'] + $warehouses, old('warehouse_id', isset($item->warehouse_id) ? $item->warehouse_id : ''), ['class' => 'form-control select2-elem', 'required' => 'required'] ) !!}
</div>
<div class="form-group">
    {!! Form::label('batch_size', 'Batch Size') !!}
    {!! Form::number('batch_size', old('batch_size', isset($item->batch_size) ? $item->batch_size : ''), ['class' => 'form-control', 'placeholder' => 'Batch ID', 'required' => 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('stock_item_id', 'Item Name') !!}
    {!! Form::select('stock_item_id', ['0' => 'Select a Item'] + $stock_items, old('stock_item_id', isset($item->stock_item_id) ? $item->stock_item_id : ''), ['class' => 'form-control select2-elem', 'required' => 'required'] ) !!}
</div>
<div class="form-group">
    {!! Form::label('manufacturing_date', 'Manufacturing Date') !!}
    {!! Form::text('manufacturing_date', old('manufacturing_date', isset($item->manufacturing_date) ? $item->manufacturing_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Manufacturing Date', 'autocomplete' => 'off']) !!}
</div>
<div class="form-group">
    {!! Form::label('expiry_date', 'Expiry Date') !!}
    {!! Form::text('expiry_date', old('expiry_date', isset($item->expiry_date) ? $item->expiry_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'Expiry Date', 'autocomplete' => 'off']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', old('description', isset($item->description) ? $item->description : ''), ['class' => 'form-control', 'placeholder' => 'Description','rows'=>3]) !!}
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('batches.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
        ///Form submitting process stop on enter button ///
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