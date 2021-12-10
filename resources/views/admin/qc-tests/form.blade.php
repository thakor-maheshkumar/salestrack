@include('common.messages')
@include('common.errors')
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('stock_item_id', 'Product Namesss') !!}
            {!! Form::select('stock_item_id', ['' => 'Select an Item'] + $stock_items, old('stock_item_id', isset($item->stock_item_id) ? $item->stock_item_id : ''), ['class' => 'form-control','required'=>'required'] ) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('grade_id', 'Grade') !!}
                {!! Form::select('grade_id', ['' => 'Select a Grade'] + $grades, old('grade_id', isset($item->grade_id) ? $item->grade_id : ''), ['class' => 'form-control','required'=>'required'] ) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('casr_no', 'CASR No.') !!}
            {!! Form::text('casr_no', old('casr_no', isset($item->casr_no) ? $item->casr_no : ''), ['class' => 'form-control', 'placeholder' => 'CASR No.']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('molecular_formula', 'Molecular Formula') !!}
                {!! Form::text('molecular_formula', old('molecular_formula', isset($item->molecular_formula) ? $item->molecular_formula : ''), ['class' => 'form-control', 'placeholder' => 'Molecular Formula']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('molecular_weight', 'Molecular Weight') !!}
            {!! Form::text('molecular_weight', old('molecular_weight', isset($item->molecular_weight) ? $item->molecular_weight : ''), ['class' => 'form-control', 'placeholder' => 'Molecular Weight']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('spec_no', 'Spec.No.') !!}
                {!! Form::text('spec_no', old('spec_no', isset($item->spec_no) ? $item->spec_no : ''), ['class' => 'form-control', 'placeholder' => 'Spec.No.']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('characters', 'Characters') !!}
            {!! Form::textarea('characters', old('characters', isset($item->characters) ? $item->characters : ''), ['class' => 'form-control', 'placeholder' => 'Characters','rows'=>3]) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('storage_condition', 'Storage Condition') !!}
                {!! Form::textarea('storage_condition', old('storage_condition', isset($item->storage_condition) ? $item->storage_condition : ''), ['class' => 'form-control', 'placeholder' => 'Storage Condition','rows'=>3]) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-group">
        {!! Form::label('remarks', 'Remarks') !!}
        {!! Form::textarea('remarks', old('remarks', isset($item->remarks) ? $item->remarks : ''), ['class' => 'form-control', 'placeholder' => 'Remarks','rows'=>3]) !!}
    </div>
</div>
@include('admin.qc-tests.tests')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('qc-tests.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
@section('script')
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
    });
</script>
@endsection
