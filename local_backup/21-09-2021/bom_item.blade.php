@php
    $element_counter = 0;
@endphp
<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Item</th>
            <th>Quantity</th>
            <th></th>
        </thead>
        <tbody class="add-items-list">
            @if(isset($bom->bom_items) && !empty($bom->bom_items))
                @foreach($bom->bom_items as $sKey => $bom_item)
                    <tr class="new-item">
                        <td>
                            {!! Form::select("bom_stock_items[$element_counter][item_item_id]", $stock_items, $bom_item['stock_item_id'] , ['class' => 'form-control item_item_id', 'id' => 'item_item_id']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::number("bom_stock_items[$element_counter][item_qty]", $bom_item['quantity'], ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Quantity']) !!}
                        </td>
                        <td>
                            <div class="delete-item-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove btn-danger delete-item" data-toggle="tooltip"
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
                        {!! Form::select("bom_stock_items ,+[$element_counter][item_item_id]", ['' => 'Select a Items     ']+$stock_items,  old("item_item_id[$element_counter]"), ['class' => 'form-control item_item_id select2-elem select2', 'id' => 'item_item_id']) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::number("bom_stock_items[$element_counter][item_qty]", old("item_qty[$element_counter]"), ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Quantity']) !!}
                    </td>
                    <td>
                        <div class="delete-item-block">
                            <a href="javascript:void(0);"
                                class="btn btn-remove btn-danger delete-item" data-toggle="tooltip"
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
                    <a href="javascript:void(0);" class="btn btn-add btn-success add-item" data-toggle="tooltip" data-placement="bottom" title="Add New Item"><i class="fa fa-plus"></i></a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @parent
    <script type="text/javascript">
        $(document).ready(function(){
            
            addItem = function(element, item, element_counter)
            {
                 item.find(".select2-elem").each(function(index)
                {
                    $(this).select2('destroy');
                });

                var item_template = item.clone();

                item_template.find(".item_item_id").attr('name', 'bom_stock_items['+element_counter+'][item_item_id]');
                item_template.find(".item_qty").attr('name', 'bom_stock_items['+element_counter+'][item_qty]');

                item_template.find('input').val('');
                item_template.find('.select2-elem').val('');
                item_template.find(".select2-elem").select2();

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
