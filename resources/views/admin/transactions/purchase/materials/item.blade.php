@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Stock Items</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Item Code/Name</th>
                <th>UOM</th>
                <th>Quantity</th>
                <th></th>
            </thead>
            <tbody class="add-items-list">
                @if(isset($material->material_items) && !empty($material->material_items))
                    @foreach($material->material_items as $sKey => $material_item)
                        <tr class="new-item">
                            <td>
                                <select id="item_code" name="items[{{$element_counter}}][item_code]" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="item_code" required="required">
                                <option value="">Select Item Code/Name</option>
                                @if(!empty($pack_code))

                                @foreach($pack_code as $value)
                                <option value="{{ $value->id }}" @if($material['material_items'][0]->stock_item_id == $value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <input type="hidden" class="item_name" name="items[{{$element_counter}}][item_item_id]" value="{{$material['material_items'][0]->stock_item_id}}">
                            </td>
                            <td>
                                {!! Form::text("items[$element_counter][uom]", $material_item->uom, ['class' => 'form-control uom', 'placeholder' => 'UOM','required'=>'required','readonly'=>'readonly', 'data-name' => 'uom']) !!}
                            </td>
                            <td>
                                {!! Form::number("items[$element_counter][quantity]", $material_item->quantity, ['class' => 'form-control quantity', 'placeholder' => 'Quantity', 'data-name' => 'quantity']) !!}
                            </td>
                            <td>
                                {{-- <div class="delete-field-block">
                                    <a href="javascript:void(0);"
                                        class="btn btn-remove delete-field btn-danger" data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Delete row">
                                            <i class="fa fa-trash"></i>
                                    </a>
                                </div> --}}
                            </td>
                        </tr>
                        @php
                            $element_counter++;
                        @endphp
                    @endforeach
                @else
                    <tr class="new-item">

                        <td>
                            <select id="item_code" name="items[{{$element_counter}}][item_code]" data-plugin-selectTwo class="form-control item_code select2-elem select2" data-name="item_code" required="required">
                                <option value="">Select Item Code/Name</option>
                                @if(!empty($pack_code))
                                @foreach($pack_code as $value)
                                <option value="{{ $value->id }}"> {{ $value->pack_code.'-'.$value->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <input type="hidden" class="item_name" name="items[{{$element_counter}}][item_item_id]" value="0">
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][uom]", old("uom[$element_counter]"), ['class' => 'form-control uom', 'placeholder' => 'UOM','required'=>'required','readonly'=>'readonly', 'data-name' => 'uom']) !!}
                        </td>
                        <td>
                            {!! Form::number("items[$element_counter][quantity]", old("amount[$element_counter]"), ['class' => 'form-control quantity', 'placeholder' => 'Quantity', 'data-name' => 'quantity']) !!}
                        </td>
                        <td>
                            {{-- <div class="delete-field-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-field btn-danger" data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Delete row">
                                        <i class="fa fa-trash"></i>
                                </a>
                            </div> --}}
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                {{-- <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                    </td>
                </tr> --}}
            </tfoot>
        </table>
    </div>
</fieldset>
@section('scripts')
    @parent
    <script type="text/javascript">

        $(document).ready(function(){



            /*$('#editable-select-0').editableSelect();*/
            addItem = function(element, item, element_counter)
            {
                item.find(".select2-elem").each(function(index)
                {
                    $(this).select2('destroy');
                });

                var item_template = item.clone();

                item_template.find('input, select').each(function() {
                    this.name = 'items[' + element_counter + '][' + $(this).data('name') + ']';
                });

                /*item_template.find(".item_code").attr('name', 'items['+element_counter+'][item_code]');
                item_template.find(".stock_item_id").attr('name', 'items['+element_counter+'][stock_item_id]');
                item_template.find(".item_item_id").attr('id', 'editable-select-'+element_counter);
                item_template.find(".item_item_id").attr('name', 'items['+element_counter+'][item_item_id]');
                item_template.find(".uom").attr('name', 'items['+element_counter+'][uom]');
                item_template.find(".quantity").attr('name', 'items['+element_counter+'][quantity]');*/

                item_template.find('input').val('');
                item_template.find(".select2-elem").select2();

                //$('#editable-select-'+element_counter).editableSelect();

                element.append(item_template)
            };

            setUOM = function(element, item_id) {
                var unit = element.find(".uom");

                $.ajax({
                    url: config.routes.url + '/admin/transactions/purchase/item_by_id/' + item_id,
                    type: 'GET',
                    success:function(response) {
                        if (response.success)
                        {
                            unit.val(response.data.unit.name);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-item', function() {
                $('.error').text('');
                var item = $(".add-items-list").children("tr.new-item:last-child");

                var errors = [];
                var has_error = false;

                item.find('input').each(function(){
                    if (! $(this).val()) {
                        $(this).trigger('focus');
                        has_error = true;
                        errors.push(false);
                        return false;
                    }
                    has_error = false;
                });

                item.find('select').each(function(){
                    if (!($(this).val() && $(this).val().length)) {
                        if($(this).hasClass('select2-elem'))
                        {
                            $(this).select2('open');
                        }
                        else
                        {
                            $(this).trigger('focus');
                        }
                        has_error = true;
                        errors.push(false);
                        return false;
                    }
                    has_error = false;
                });

                var validate_values = errors.includes(false);

                if ((! has_error) && (! validate_values)) {
                    $(".error").text("");
                    element_counter++;

                    //addItem($(".add-items-list"),element_counter)
                    addItem($(".add-items-list"), item, element_counter);
                    //$('#editable-select-'+element_counter).editableSelect();

                    //var last_item = $(".add-items-list").children("tr.new-item:last-child");
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


            $(document).on('change', '.item_code', function() {

                var selected = $(this).val();
                var element = $(this).closest('.new-item').find('.item_name');
                var org_selected = element.val();
                if(selected != org_selected)
                {
                    element.val(selected);
                    setUOM($(this).closest('.new-item'), selected);
                }
            });

//            $(document).on('change', '.item_name', function() {
//                var selected = $(this).val();
//                var element = $(this).closest('.new-item').find('.item_code');
//                var org_selected = element.val();
//
//                if(selected != org_selected)
//                {
//                    element.select2("val", selected);
//                    setUOM($(this).closest('.new-item'), selected);
//                }
//            });

        });
    </script>
@endsection
