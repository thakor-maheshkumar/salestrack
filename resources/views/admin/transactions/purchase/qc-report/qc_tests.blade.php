{{-- <tbody class="add-items-list"> --}}
    @if(isset($qc_tests->qc_items) && $qc_tests->qc_items->isNotEmpty())
        @php
            $element_counter = 0;
        @endphp
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
{{-- </tbody> --}}
