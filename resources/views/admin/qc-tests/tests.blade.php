@php
    $element_counter = 0;
@endphp
<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Tests</th>
            <th>Acceptance criteria</th>
            <th></th>
        </thead>
        <tbody class="add-items-list">
             @if(isset($item->qc_items) && !empty($item->qc_items))
                @foreach($item->qc_items as $sKey => $qc_item)
                    <tr class="new-item">
                        {!! Form::hidden("qc_tests[$element_counter][qc_test_id]", $qc_item->id, ['class' => 'form-control qc_test_id', 'id' => 'qc_test_id','required'=>'required']) !!}
                        <td>
                            {!! Form::text("qc_tests[$element_counter][tests]", $qc_item->tests, ['class' => 'form-control tests', 'id' => 'tests', 'placeholder' => 'Tests']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("qc_tests[$element_counter][acceptance_criteria]", $qc_item->acceptance_criteria, ['class' => 'form-control acceptance_criteria', 'id' => 'acceptance_criteria', 'placeholder' => 'Acceptance Criteria']) !!}
                        </td>
                        <td>
                            <div class="delete-item-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-item btn-danger" data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Delete Item">
                                        <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $element_counter++;
                    @endphp
                @endforeach
            @else
                <tr class="new-item">
                        {!! Form::hidden("qc_tests[$element_counter][qc_test_id]", '', ['class' => 'form-control qc_test_id', 'id' => 'qc_test_id']) !!}
                    <td>
                        {!! Form::text("qc_tests[$element_counter][tests]", old("qc_tests[$element_counter]"), ['class' => 'form-control tests', 'id' => 'tests', 'placeholder' => 'Tests']) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::text("qc_tests[$element_counter][acceptance_criteria]", old("qc_tests[$element_counter]"), ['class' => 'form-control acceptance_criteria', 'id' => 'acceptance_criteria', 'placeholder' => 'Acceptance Criteria']) !!}
                    </td>
                    <td>
                        <div class="delete-item-block">
                            <a href="javascript:void(0);"
                                class="btn btn-remove delete-item btn-danger" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Delete Item">
                                    <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">
                    <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Item"><i class="fa fa-plus"></i></a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){

            addItem = function(element, item, element_counter)
            {
                var item_template = item.clone();

                item_template.find(".qc_test_id").attr('name', 'qc_tests['+element_counter+'][qc_test_id]');
                item_template.find(".tests").attr('name', 'qc_tests['+element_counter+'][tests]');
                item_template.find(".acceptance_criteria").attr('name', 'qc_tests['+element_counter+'][acceptance_criteria]');

                item_template.find('input').val('');

                element.append(item_template)
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-item', function() {
                $('.error').text('');
                var item = $(".add-items-list").children("tr.new-item:last-child");

                var has_error = false;

                item.find('.item_qty').each(function(){
                    if (!($(this).val() && $(this).val().length)) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                item.find('input[type=text]').each(function(){
                    if (! $(this).val()) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                /*if (!item.find('input[type=text]').val()) {
                    item.find('input[type=text]').trigger('focus');
                    has_error = true;
                    return false;
                }*/

                if (! has_error) {
                    $(".error").text("");
                    element_counter++;

                    //addItem($(".add-items-list"),element_counter)
                    addItem($(".add-items-list"), item, element_counter);

                    var last_item = $(".add-items-list").children("tr.new-item:last-child");
                }
            });

            $(document).on('click', '.delete-item', function(e) {
                e.preventDefault();
                var item_count = $(this).closest(".add-items-list").children("tr.new-item").length;

                if(item_count > 1)
                {
                    if(confirm('Are you sure?'))
                    {
                        $(this).parents('.new-item').remove();
                    }
                }
                else
                {
                    $(".error").text("You must have to add at least one item.");
                }
            });
        });
    </script>
@endsection
