@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Grade Details</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Grade</th>
                <th>Pack Code</th>
                <th>Pack Size</th>
                <th>Unit</th>
                <th></th>
            </thead>
            <tbody class="add-items-list">
                 @if(isset($item->stock_item_grades) && !empty($item->stock_item_grades))
                    @foreach($item->stock_item_grades as $sKey => $stock_item_grade)
                    <tr class="new-item">
                            {!! Form::hidden("grade_data[$element_counter][stock_item_grade_id]", $stock_item_grade['id'], ['class' => 'form-control stock_item_grade_id', 'id' => 'stock_item_grade_id']) !!}
                        <td>
                            {!! Form::select("grade_data[$element_counter][grade_id]", $grades, $stock_item_grade['grade_id'], ['class' => 'form-control grade_id', 'id' => 'grade_id']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("grade_data[$element_counter][pack_code]", $stock_item_grade['pack_code'], ['class' => 'form-control pack_code', 'id' => 'pack_code', 'placeholder' => 'Pack Code']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::number("grade_data[$element_counter][quantity]", $stock_item_grade['quantity'], ['class' => 'form-control quantity', 'id' => 'quantity', 'placeholder' => 'Quantity']) !!}
                        </td>
                        <td>
                            {!! Form::select("grade_data[$element_counter][unit_id]", $units, $stock_item_grade->InventoryUnit->id, ['class' => 'form-control grade_unit_id', 'id' => 'grade_unit_id']) !!}
                        </td>
                        <td>
                            <div class="delete-item-block">
                                <a href="javascript:void(0);" 
                                    class="btn btn-remove delete-item" data-toggle="tooltip" 
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
                        <td>
                            {!! Form::hidden("grade_data[$element_counter][stock_item_grade_id]", 0, ['class' => 'form-control stock_item_grade_id', 'id' => 'stock_item_grade_id']) !!}
                            {!! Form::select("grade_data[$element_counter][grade_id]", $grades, old("grade_id[$element_counter]"), ['class' => 'form-control grade_id', 'id' => 'grade_id']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("grade_data[$element_counter][pack_code]", old("pack_code[$element_counter]"), ['class' => 'form-control pack_code', 'id' => 'pack_code', 'placeholder' => 'Pack Code']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::number("grade_data[$element_counter][quantity]", old("quantity[$element_counter]"), ['class' => 'form-control quantity', 'id' => 'quantity', 'placeholder' => 'Quantity']) !!}
                        </td>
                        <td>
                            {!! Form::select("grade_data[$element_counter][unit_id]", $units, old("unit_id[$element_counter]"), ['class' => 'form-control grade_unit_id', 'id' => 'grade_unit_id']) !!}
                        </td>
                        <td>
                            <div class="delete-item-block">
                                <a href="javascript:void(0);" 
                                    class="btn btn-remove delete-item" data-toggle="tooltip" 
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
                        <a href="javascript:void(0);" class="btn btn-add add-item" data-toggle="tooltip" data-placement="bottom" title="Add New Item"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</fieldset>
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){

            addItem = function(element, item, element_counter)
            {
                var item_template = item.clone();
                
                item_template.find(".stock_item_grade_id").attr('name', 'grade_data['+element_counter+'][stock_item_grade_id]');
                item_template.find(".grade_id").attr('name', 'grade_data['+element_counter+'][grade_id]');
                item_template.find(".pack_code").attr('name', 'grade_data['+element_counter+'][pack_code]');
                item_template.find(".quantity").attr('name', 'grade_data['+element_counter+'][quantity]');
                item_template.find(".grade_unit_id").attr('name', 'grade_data['+element_counter+'][unit_id]');

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
