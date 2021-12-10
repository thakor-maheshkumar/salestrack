@php
    $element_counter = 0;
@endphp
@if(isset($order->other_charges) && $order->other_charges->isNotEmpty())
    @foreach($order->other_charges as $sKey => $other_charge)
        <tr class="new-field-2">
            <td>
                {!! Form::hidden("other_taxes[$element_counter][other_charge_id]", $other_charge->id, ['class' => 'form-control other_charge_id', 'id' => 'other_charge_id']) !!}

                {!! Form::select("other_taxes[$element_counter][type]", [''=>'Select Type',1 => 'Actual',2 => 'On Net Total'], $other_charge->type, ['onchange' => 'getChargeType(this.value)','class' => 'form-control type','id' => 'other_charge_type']) !!}
            </td>
            <td>
                {!! Form::select("other_taxes[$element_counter][account_head]", $generalLedger, $other_charge->general_ledger_id, ['class' => 'form-control account_head']) !!}
            </td>
            <td>
                {!! Form::text("other_taxes[$element_counter][other_rate]", $other_charge->rate, ['class' => 'form-control other_rate', 'placeholder' => 'Rate']) !!}
            </td>
            <td>
                {!! Form::text("other_taxes[$element_counter][other_amount]", $other_charge->amount, ['class' => 'form-control other_amount', 'placeholder' => 'Amount']) !!}
            </td>
            <td>
                {!! Form::text("other_taxes[$element_counter][other_tax]", $other_charge->tax, ['class' => 'form-control other_tax', 'placeholder' => 'Tax']) !!}
            </td>
            <td>
                {!! Form::text("other_taxes[$element_counter][other_tax_amount]", $other_charge->tax_amount, ['class' => 'form-control other_tax_amount', 'placeholder' => 'Tax Amount']) !!}
            </td>
            <td>
                {!! Form::text("other_taxes[$element_counter][other_total_amount]", $other_charge->total_amount, ['class' => 'form-control other_total_amount', 'placeholder' => 'Total Amount']) !!}
            </td>
            <td>
                <div class="delete-field-block">
                    <a href="javascript:void(0);"
                        class="btn btn-remove delete-field-2 btn btn-danger" data-toggle="tooltip"
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
@else
    <tr class="new-field-2">
        <td>
            {!! Form::hidden("other_taxes[$element_counter][other_charge_id]", 0, ['class' => 'form-control other_charge_id', 'id' => 'other_charge_id']) !!}

            {!! Form::select("other_taxes[$element_counter][type]", [''=>'Select Type',1 => 'Actual',2 => 'On Net Total'], null, ['onchange' => 'getChargeType(this.value)','class' => 'form-control type','id' => 'other_charge_type']) !!}
        </td>
        <td>
            {!! Form::select("other_taxes[$element_counter][account_head]", $generalLedger, null, ['class' => 'form-control account_head']) !!}
        </td>
        <td>
            {!! Form::text("other_taxes[$element_counter][other_rate]", 0, ['class' => 'form-control other_rate', 'placeholder' => 'Rate']) !!}
        </td>
        <td>
            {!! Form::text("other_taxes[$element_counter][other_amount]", 0, ['class' => 'form-control other_amount', 'placeholder' => 'Amount']) !!}
        </td>
        <td>
            {!! Form::text("other_taxes[$element_counter][other_tax]", 0, ['class' => 'form-control other_tax', 'placeholder' => 'Tax']) !!}
        </td>
        <td>
            {!! Form::text("other_taxes[$element_counter][other_tax_amount]", 0, ['class' => 'form-control other_tax_amount', 'placeholder' => 'Tax Amount']) !!}
        </td>
        <td>
            {!! Form::text("other_taxes[$element_counter][other_total_amount]", 0, ['class' => 'form-control other_total_amount', 'placeholder' => 'Total Amount']) !!}
        </td>
        <td>
            <div class="delete-field-block">
                <a href="javascript:void(0);"
                    class="btn btn-remove delete-field-2 btn btn-danger" data-toggle="tooltip"
                    data-placement="bottom"
                    title="Delete row">
                        <i class="fa fa-trash"></i>
                </a>
            </div>
        </td>
    </tr>
@endif
