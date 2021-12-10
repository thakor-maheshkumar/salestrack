@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Stock Items</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Item Name</th>
                <th>Item Code</th>
                <th>UOM</th>
                <th>Quantity</th>
                <th>PO Quantity</th>
                <th>No of Container</th>
                <th></th>
            </thead>
            <tbody class="add-items-list">
                <tr class="new-item">
                    <td>
                        {!! Form::select("items[$element_counter][item_name]", $stockItem, null, ['class' => 'form-control departments-list']) !!}
                    </td>
                    <td>
                        {!! Form::text("items[$element_counter][item_code]", old("item_code[$element_counter]"), ['class' => 'form-control item_code', 'id' => 'item_code', 'placeholder' => 'Item Code','required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::number("items[$element_counter][unit]", old("unit[$element_counter]"), ['class' => 'form-control unit', 'id' => 'unit', 'placeholder' => 'UOM','required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::number("items[$element_counter][quantity]", old("quantity[$element_counter]"), ['class' => 'form-control quantity', 'placeholder' => 'Quantity','required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::number("items[$element_counter][po_quantity]", old("po_quantity[$element_counter]"), ['class' => 'form-control po_quantity', 'placeholder' => 'PO Quantity','required'=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::number("items[$element_counter][no_of_container]", old("no_of_container[$element_counter]"), ['class' => 'form-control no_of_container', 'placeholder' => 'No of Container']) !!}
                    </td>
                    <td>
                        <div class="delete-field-block">
                            <a href="javascript:void(0);"
                                class="btn btn-remove delete-field btn-danger" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Delete row">
                                    <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
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

                item_template.find(".item_item_id").attr('name', 'items['+element_counter+'][item_item_id]');
                item_template.find(".item_code").attr('name', 'items['+element_counter+'][item_code]');
                item_template.find(".uom").attr('name', 'items['+element_counter+'][uom]');
                item_template.find(".quantity").attr('name', 'items['+element_counter+'][quantity]');
                item_template.find(".po_quantity").attr('name', 'items['+element_counter+'][po_quantity]');
                item_template.find(".no_of_container").attr('name', 'items['+element_counter+'][no_of_container]');

                item_template.find('input').val('');

                element.append(item_template)
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-item', function() {
                $('.error').text('');
                var item = $(".add-items-list").children("tr.new-item:last-child");

                var has_error = false;

                item.find('.item_code').each(function(){
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
