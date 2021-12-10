@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('units.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('symbol', 'Symbol') !!}
    {!! Form::text('symbol', old('symbol', isset($inventoryUnit->symbol) ? $inventoryUnit->symbol : ''), ['class' => 'form-control', 'placeholder' => 'Symbol']) !!}
    @if ($errors->has('symbol'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('symbol') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('name', 'Name *') !!}
    {!! Form::text('name', old('name', isset($inventoryUnit->name) ? $inventoryUnit->name : ''), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    @if ($errors->has('name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('unit_quantity_code', 'Unit Quantity Code (UQC) *') !!}
    {!! Form::select('unit_quantity_code', ['' => 'Not Applicable'] + $unitData, old('unit_quantity_code', isset($inventoryUnit->unit_quantity_code) ? $inventoryUnit->unit_quantity_code : ''), ['class' => 'form-control'] ) !!}
    @if ($errors->has('unit_quantity_code'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('unit_quantity_code') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('no_of_decimal_places', 'Number of decimal places *') !!}
    {!! Form::number('no_of_decimal_places', old('no_of_decimal_places', isset($inventoryUnit->no_of_decimal_places) ? $inventoryUnit->no_of_decimal_places : 2), ['class' => 'form-control', 'placeholder' => 'Number of decimal places','step'=>.01]) !!}
    @if ($errors->has('no_of_decimal_places'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('no_of_decimal_places') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('units.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
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
