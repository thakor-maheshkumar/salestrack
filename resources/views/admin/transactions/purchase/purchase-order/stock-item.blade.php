@php
    $element_counter = 0;
@endphp
@if(isset($material->material_items) && !empty($material->material_items))
    @foreach($material->material_items as $sKey => $item)
        <tr class="new-item f">
            <td>
                <input type="hidden" class="item_id" name="items[{{$element_counter}}][item_id]" value="">
                <select id="item_name" name="items[{{$element_counter}}][item_name]" data-plugin-selectTwo class="form-control item_name select2-elem select2" data-name="item-name" required="required">
                    <option value="">Select Item Code/Name</option>
                    @if(!empty($stockItem))
                        @foreach($stockItem as $value)
                            <option value="{{ $value->id }}" @if($item->stock_item_id == $value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                        @endforeach
                    @endif
                </select>
                <input type="hidden" class="item_code" name="items[{{$element_counter}}][item_code]" value="{{ $item->item_code }}">
            </td>
            <td>

                {{Form::select("items[$element_counter][unit]", [''=>'Select an Item']+$units, $item->uom, ['id'=>'unit','class'=>'form-control unit' ])}}
            </td>
            <td>
                {!! Form::text("items[$element_counter][quantity]", $item->quantity, ['class' => 'form-control quantity', 'placeholder' => 'Quantity','required'=>'required']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][rate]", 0, ['class' => 'form-control rate', 'placeholder' => 'Rate','required'=>'required']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][net_amount]", 0, ['class' => 'form-control net_amount', 'placeholder' => 'Net Amount','readonly'=>'readonly']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][discount]", 0, ['class' => 'form-control discount', 'placeholder' => 'Discount(%)']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][discount_amount]", 0 , ['class' => 'form-control discount_amount', 'placeholder' => 'Discount Amount']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][tax]", 0, ['class' => 'form-control tax', 'placeholder' => 'Tax(%)']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][tax_amount]", 0, ['class' => 'form-control tax_amount', 'placeholder' => 'Tax Amount','readonly'=>'readonly']) !!}
            </td>
            {{-- <td>
                {!! Form::text("items[$element_counter][cess]", 0, ['class' => 'form-control cess', 'placeholder' => 'Cess(%)']) !!}
            </td>
            <td>
                {!! Form::text("items[$element_counter][cess_amount]", 0, ['class' => 'form-control cess_amount', 'placeholder' => 'Cess Amount','readonly'=>'readonly']) !!}
            </td> --}}
            <td>
                {!! Form::text("items[$element_counter][total_amount]", 0, ['class' => 'form-control total_amount', 'placeholder' => 'Total Amount','readonly'=>'readonly']) !!}
            </td>
            <td>
                <div class="delete-field-block">
                    <a href="javascript:void(0);"
                        class="btn btn-remove delete-fieldbtn-danger" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Delete row">
                            <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
        @php
            $element_counter++;
        @endphp
    @endforeach
@endif
