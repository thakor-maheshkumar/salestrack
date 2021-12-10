<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('bom.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('bom_name', 'BOM Name *') !!}
    {!! Form::text('bom_name', old('name', isset($bom->bom_name) ? $bom->bom_name : ''), ['class' => 'form-control', 'placeholder' => 'BOM Name', 'required' => 'required']) !!}
    @if ($errors->has('bom_name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('bom_name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('stock_item_id', 'Item Name') !!}
    {!! Form::select('stock_item_id', ['0' => 'Select a Item'] + $stock_items, old('stock_item_id', isset($bom->stock_item_id) ? $bom->stock_item_id : ''), ['data-plugin-selectTwo class' => 'form-control item_code select2-elem select2', 'required' => 'required'] ) !!}
    @if ($errors->has('stock_item_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('stock_item_id') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('no_of_unit', 'No of Unit') !!}
    {!! Form::number('no_of_unit', old('no_of_unit', isset($bom->no_of_unit) ? $bom->no_of_unit : ''), ['class' => 'form-control', 'placeholder' => 'No of Unit']) !!}
</div>
<div class="form-group">
    {!! Form::label('rate_of_material', 'Rate of Material') !!}
    {!! Form::select('rate_of_material', ['' => 'Select a Rate of Material'] + $material_rate, old('rate_of_material', isset($bom->rate_of_material) ? $bom->rate_of_material : ''), ['class' => 'form-control'] ) !!}
    {{-- {!! Form::number('rate_of_material', old('rate_of_material', isset($bom->rate_of_material) ? $bom->rate_of_material : ''), ['class' => 'form-control', 'placeholder' => 'Rate of Material']) !!} --}}
</div>
<div class="row">
    <div class="col-md-24">
        <div class="form-group">
            <label>Add Items</label>
            @include('admin.inventory.bom.item')
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('bom.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
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
