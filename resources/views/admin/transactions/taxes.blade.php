@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border other_charges">
    <legend class="scheduler-border">Other Charges</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper" id="other_charge_table">
            <thead>
                <th>Type</th>
                <th>Account Head</th>
                <th>Rate(%)</th>
                <th>Amount</th>
                <th>Tax(%)</th>
                <th>Tax Amount</th>
                <th>Total Amount</th>
                <th></th>
            </thead>
            <tbody class="add-field-list-2" id="other_charge_tbody">
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
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="btn btn-add add-field-2 btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('total_other_net_amount', 'Total Net Amount') !!}
                    {!! Form::text('other_net_amount', old('other_net_amount', isset($order->other_net_amount) ? $order->other_net_amount : 0), ['class' => 'form-control total_other_net_amount','id'=>'other_net_amount','readonly'=>'readonly']) !!}
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('total_other_grand_amount', 'Total Grand Amount') !!}
                        {!! Form::text('total_other_net_amount', old('total_other_net_amount', isset($order->total_other_net_amount) ? $order->total_other_net_amount : 0), ['class' => 'form-control total_other_grand_amount','id'=>'total_other_grand_amount','readonly'=>'readonly']) !!}
                    </div>
                </div>
            </div>
        </div>
</fieldset>
@section('scripts')
    @parent
    <script type="text/javascript">
        function getChargeType(type)
        {
            var item = $(".add-field-list-2").children("tr.new-field-2:last-child");
            if(type=='1'){
                item.find('.other_rate').attr('readonly','readonly');
                item.find('.other_amount').removeAttr('readonly');
            }else{
                item.find('.other_rate').removeAttr('readonly');
                item.find('.other_amount').attr('readonly','readonly');
            }
            $(".add-field-list-2").children("tr.new-field-2:last-child").find('input').val('');
        }
        /*getOtherAmount = function(amount,tax)
        {
            var item = $(".add-field-list-2").children("tr.new-field-2:last-child");
            var tax_amount = (tax*amount)/100;
            item.find('.other_tax_amount').val(tax_amount);
            var total_amount = parseFloat(amount) + parseFloat(tax_amount);
            item.find('.other_total_amount').val(total_amount);
        };
        function countOtherAmount(amount)
        {
            var item = $(".add-field-list-2").children("tr.new-field-2:last-child");
            var tax = item.find('.other_tax').val();
            getOtherAmount(amount,tax);
        }
        function countOtherTax(tax)
        {
            var item = $(".add-field-list-2").children("tr.new-field-2:last-child");
            var amount = item.find('.other_amount').val();
            getOtherAmount(amount,tax);
        }
        function countOtherRate(rate)
        {
            var item = $(".add-field-list-2").children("tr.new-field-2:last-child");
            var item_net_amount = $('.total_net_amount').val();
            if(item_net_amount != '')
            {
                var rate_amount = (rate*item_net_amount)/100;
                item.find('.other_amount').val(parseFloat(rate_amount));
            }
        }
        function countOtherNetAmount()
        {
            var total_other_net_amount = 0;
            var total_other_grand_amount = 0;
            $('.other_amount').each(function(){
                total_other_net_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
            });

            $('.other_total_amount').each(function(){
                total_other_grand_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
            });
            $('.total_other_net_amount').val(total_other_net_amount);
            $('.total_other_grand_amount').val(total_other_grand_amount);
        }*/
        $(document).ready(function(){

            /*other_rate = countOtherRate
            other_amount = countOtherAmount
            other_tax = countOtherTax*/

            $(document).on('focusout', '.other_rate', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();

                var rate = $("input[name='other_taxes["+index+"][other_rate]']").val()
                var item_net_amount = $('.total_net_amount').val();
                var rate_amount = (rate*item_net_amount)/100;
                //rate_amount = item_net_amount - rate_amount;
                $("input[name='other_taxes["+index+"][other_amount]']").val(rate_amount);
                countOtherNetAmount();
                //countAfterFocusOut(index);
            });

            $(document).on('focusout', '.other_amount', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();
                var amount = $("input[name='other_taxes["+index+"][other_amount]']").val();
                var tax = $("input[name='other_taxes["+index+"][other_tax]']").val();
                getOtherAmount(index);
                countOtherNetAmount();
            });

            $(document).on('focusout', '.other_tax', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();
                var amount = $("input[name='other_taxes["+index+"][other_amount]']").val();
                var tax = $("input[name='other_taxes["+index+"][other_tax]']").val();
                getOtherAmount(index);
                countOtherNetAmount();
            });

            addTax = function(element, department, element_counter)
            {
                var item_template = department.clone();

                item_template.find(".type").attr('name', 'other_taxes['+element_counter+'][type]');
                item_template.find(".account_head").attr('name', 'other_taxes['+element_counter+'][account_head]');
                item_template.find(".other_rate").attr('name', 'other_taxes['+element_counter+'][other_rate]');
                item_template.find(".other_amount").attr('name', 'other_taxes['+element_counter+'][other_amount]');
                item_template.find(".other_tax").attr('name', 'other_taxes['+element_counter+'][other_tax]');
                item_template.find(".other_tax_amount").attr('name', 'other_taxes['+element_counter+'][other_tax_amount]');
                item_template.find(".other_total_amount").attr('name', 'other_taxes['+element_counter+'][other_total_amount]');
                item_template.find('input').val('');
                item_template.find(".other_charge_id").attr('name', 'other_taxes['+element_counter+'][other_charge_id]').val(0);
                element.append(item_template);

                return item_template;
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-field-2', function() {
                $('.error').text('');
                var department = $(".add-field-list-2").children("tr.new-field-2:last-child");

                var has_error = false;

                department.find('select').each(function(){
                    if (!($(this).val() && $(this).val().length)) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                department.find('input[type=text]').each(function(){
                    /*if (! $(this).val()) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }*/
                    has_error = false;
                });

                if (! has_error) {
                    $(".error").text("");
                    element_counter++;

                    //addTax($(".add-field-list-2"),element_counter)
                    addTax($(".add-field-list-2"), department, element_counter);

                    var last_department = $(".add-field-list-2").children("tr.new-field-2:last-child");
                }
            });

            $(document).on('click', '.delete-field-2', function(e) {
                e.preventDefault();
                var department_count = $(this).closest(".add-field-list-2").children("tr.new-field-2").length;

                if(department_count > 1)
                {
                    if(confirm('Are you sure?'))
                    {
                        $(this).parents('.new-field-2').remove();
                    }
                }
                else
                {
                    $(".error").text("You must have to add at least one department.");
                }
            });
        });
    </script>
@endsection
