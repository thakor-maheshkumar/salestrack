@include('common.messages')
@include('common.errors')
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('grade_id', 'Grade') !!}
            <select class="form-control" name="grade_id" onchange="getDetailsFromGrade(this.value)" required>
                 <option value="">Select a Grade</option>
                    @if(!empty($stock_grade))
                        @foreach($stock_grade as $grade)
                            <option value='{{$grade->grades->id}}'>{{$grade->grades->grade_name}}</option>
                        @endforeach
                    @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('work_order_id', 'Work Order No') !!}
            {!! Form::text('work_order_id', old('work_order_id', isset($item->work_order_id) ? $item->work_order_id : ''), ['class' => 'form-control', 'placeholder' => 'Work Order No','readonly' => 'readonly']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('product_name', 'Product Name') !!}
            {!! Form::text('product_name', $stock_details->name, ['class' => 'form-control', 'placeholder' => 'Product Name','readonly' => 'readonly']) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('casr_no', 'CASR No.') !!}
            {!! Form::text('casr_no',isset($qc_tests->casr_no) ? $qc_tests->casr_no : '', ['class' => 'form-control', 'placeholder' => 'CASR No.','disabled' => 'disabled']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('molecular_formula', 'Molecular Formula') !!}
                {!! Form::text('molecular_formula', old('molecular_formula', isset($qc_tests->molecular_formula) ? $qc_tests->molecular_formula : ''), ['class' => 'form-control', 'placeholder' => 'Molecular Formula','disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('molecular_weight', 'Molecular Weight') !!}
            {!! Form::text('molecular_weight', old('molecular_weight', isset($qc_tests->molecular_weight) ? $qc_tests->molecular_weight : ''), ['class' => 'form-control', 'placeholder' => 'Molecular Weight','disabled' => 'disabled']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('spec_no', 'Spec.No.') !!}
                {!! Form::text('spec_no', old('spec_no', isset($qc_tests->spec_no) ? $qc_tests->spec_no : ''), ['class' => 'form-control', 'placeholder' => 'Spec.No.','disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('plan_id', 'Plan') !!}
                {!! Form::select('plan_id', ['' => 'Select a Plan'] + $plans, old('plan_id', isset($item->plan_id) ? $item->plan_id : ''), ['class' => 'form-control','required'=>'required','disabled' => 'disabled'] ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('manufacturing_date', 'Manufacturing Date') !!}
                {!! Form::text('manufacturing_date', '', ['class' => 'form-control manufacturing_date', 'placeholder' => 'Manufacturing Date','disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('ar_no', 'A.R.No.') !!}
            {!! Form::text('ar_no', '' , ['class' => 'form-control ar_no', 'placeholder' => 'A.R.No.']) !!}
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('retest_date', 'Retest Date') !!}
                {!! Form::text('retest_date', '', ['class' => 'form-control datepicker retest_date', 'placeholder' => 'Retest Date', 'autocomplete' => 'off']) !!}
                {!! Form::hidden('purchase_receipt_id', $item->id, ['class' => 'form-control']) !!}
                @if(isset($qc_tests) && !empty($qc_tests))
                    {!! Form::hidden('qc_id', $qc_tests->id, ['class' => 'form-control']) !!}
                @endif
                {!! Form::hidden('stock_item_id', $stock_details->id, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-group">
        {!! Form::label('remarks', 'Remarks') !!}
        {!! Form::textarea('remarks', old('remarks', isset($qc_tests->remarks) ? $item->remarks : ''), ['class' => 'form-control', 'placeholder' => 'Remarks','rows'=>3,'readonly'=>'readonly']) !!}
    </div>
</div>

@php
    $element_counter = 0;
@endphp
<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Tests</th>
            <th>Acceptance criteria</th>
            <th>Test</th>
            <th>Remarks</th>
        </thead>
        <tbody class="qc-test add-items-list">
             @if(isset($qc_tests->qc_items) && !empty($qc_tests->qc_items))
                @foreach($qc_tests->qc_items as $sKey => $qc_item)
                    <tr class="new-item">
                         {!! Form::hidden("qc_tests[$element_counter][qc_test_id]", $qc_item->id, ['class' => 'form-control qc_test_id', 'id' => 'qc_test_id']) !!}
                        <td>
                            {!! Form::text("qc_tests[$element_counter][tests]", $qc_item->tests, ['class' => 'form-control tests', 'id' => 'tests', 'placeholder' => 'Tests','disabled'=>'disabled']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("qc_tests[$element_counter][acceptance_criteria]", $qc_item->acceptance_criteria, ['class' => 'form-control acceptance_criteria', 'id' => 'acceptance_criteria', 'placeholder' => 'Acceptance Criteria','disabled'=>'disabled']) !!}
                        </td>
                        <td>
                            {!! Form::text("qc_tests[$element_counter][test_result]", $qc_item->test_result, ['class' => 'form-control test_result', 'id' => 'test_result', 'placeholder' => 'Test Result']) !!}
                        </td>
                        <td>
                            {!! Form::text("qc_tests[$element_counter][remarks]", $qc_item->remarks, ['class' => 'form-control remarks', 'id' => 'remarks', 'placeholder' => 'Remarks']) !!}
                        </td>
                    </tr>
                    @php
                        $element_counter++;
                    @endphp
                @endforeach
            @else
            @endif
        </tbody>
        <tfoot></tfoot>
    </table>
</div>

<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('qc-report.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
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
    });
</script>
    @parent
    <script type="text/javascript">
        function getDetailsFromGrade(grade_id)
        {
            if(grade_id != '')
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{url("admin/transactions/purchase/getDetailsFromGrade")}}',
                    data:{grade_id:grade_id},
                    success:function(data){
                        console.log(data);
                        $('.qc-test.add-items-list').html(data.qc_tests);
                    }
                });
            }
        }
    </script>
@endsection
