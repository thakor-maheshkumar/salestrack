@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Payment Reference</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Party Type *</th>
                <th>Party *</th>
                <th>Against *</th>
                <!--<th>Voucher No</th>-->
                <th class="invoice_no_th">Invoice No</th>
                <th>Amount</th>
            </thead>
            <tbody class="add-items-list">
                @if(isset($payment->amount_items) && $payment->amount_items->isNotEmpty())
                    @foreach($payment->amount_items as $sKey => $item)
                    <?php
                       /*print'<pre>';
                       print_r($item);
                       die;*/
                    ?>
                        <tr class="new-item">
                            <td>
                                <input type="hidden" class="payment_item_id" name="items[{{$element_counter}}][payment_item_id]" value="{{$item->id}}">
                                <input type="hidden" class="element_counter" name="items[{{$element_counter}}][element_counter]" value="{{$element_counter}}">

                                {!! Form::select("items[$element_counter][party_type]", ['' => 'Select Party Type'] + $party_types, old('party_type', isset($item->party_type) ? $item->party_type : ''), ['class' => 'form-control party_type select2-elem select2', 'id' => 'party_type']) !!}
                            </td>
                            <td>
                                @php
                                    $parties = ['' => 'Select Party'];
                                    if(isset($item->party_type))
                                    {
                                        if($item->party_type == 'supplier')
                                            $parties = $parties + $suppliers;
                                        else if($item->party_type == 'customer')
                                            $parties = $parties + $customers;
                                        else
                                            $parties = $parties + $others;
                                    }
                                @endphp
                                {!! Form::select("items[$element_counter][party]", $parties, old('party', isset($item->party) ? $item->party : ''), ['class' => 'form-control party select2-elem select2', 'id' => 'party']) !!}
                            </td>
                            <td>
                                {!! Form::select("items[$element_counter][against]", ['' => 'Select Against'] + $against_list, old('against', isset($item->against) ? $item->against : ''), ['class' => 'form-control against select2-elem select2', 'id' => 'against']) !!}
                            </td>
                            {{-- <td>
                                @php
                                    $vouchers = ['' => 'Select Voucher'];
                                    if(isset($item->against))
                                    {
                                        if($item->against == 'sales_invoice')
                                            $vouchers = $vouchers + $sales_vouchers;
                                        else if($item->against == 'purchase_invoice')
                                            $vouchers = $vouchers + $purchase_vouchers;
                                    }
                                @endphp
                                <div class="voucher_block">
                                    @if(isset($item->against) && ($item->against == 'other'))
                                        {!! Form::text("items[$element_counter][voucher_no]", old('voucher_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control voucher_no', 'id' => 'voucher_no']) !!}
                                    @else
                                        {!! Form::select("items[$element_counter][voucher_no]", $vouchers, old('voucher_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control voucher_no', 'id' => 'voucher_no']) !!}
                                    @endif
                                </div>
                            </td> --}}
                            <td>
                                {!! Form::text("items[$element_counter][amount]", old('amount', isset($item->amount) ? $item->amount : ''), ['class' => 'form-control amount', 'placeholder' => 'Amount']) !!}
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
                        @php
                            $element_counter++;
                        @endphp
                    @endforeach
                @else
                    <tr class="new-item f">
                        <td>
                            <input type="hidden" class="payment_item_id" name="items[{{$element_counter}}][payment_item_id]" value="">
                            <input type="hidden" class="element_counter" name="items[{{$element_counter}}][element_counter]" value="{{$element_counter}}">
                            {!! Form::select("items[$element_counter][party_type]", ['' => 'Select Party Type'] + $party_types, old('party_type', isset($item->party_type) ? $item->party_type : ''), ['class' => 'form-control party_type select2-elem select2', 'id' => 'party_type']) !!}
                        </td>
                        <td>
                            @php
                                $parties = ['' => 'Select Party'];
                                if(isset($item->party_type))
                                {
                                    if($item->party_type == 'supplier')
                                        $parties = $parties + $suppliers;
                                    else if($item->party_type == 'customer')
                                        $parties = $parties + $customers;
                                    else
                                        $parties = $parties + $others;
                                }
                            @endphp
                            {!! Form::select("items[$element_counter][party]", $parties, old('party', isset($item->party) ? $item->party : ''), ['class' => 'form-control party', 'id' => 'party']) !!}
                        </td>
                        <td>
                            {!! Form::select("items[$element_counter][against]", ['' => 'Select Against'] + $against_list, old('against', isset($item->against) ? $item->against : ''), ['class' => 'form-control against select2-elem select2', 'id' => 'against']) !!}
                        </td>
                        {{-- <td>
                            @php
                                $vouchers = ['' => 'Select Voucher'];
                                if(isset($item->against))
                                {
                                    if($item->against == 'sales_invoice')
                                        $vouchers = $vouchers + $sales_vouchers;
                                    else if($item->against == 'purchase_invoice')
                                        $vouchers = $vouchers + $purchase_vouchers;
                                }
                            @endphp
                            <div class="voucher_block">
                                @if(isset($item->against) && ($item->against == 'other'))
                                    {!! Form::text("items[$element_counter][voucher_no]", old('voucher_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control voucher_no select2-elem select2', 'id' => 'voucher_no']) !!}
                                @else
                                    {!! Form::select("items[$element_counter][voucher_no]", $vouchers, old('voucher_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control voucher_no select2-elem select2', 'id' => 'voucher_no']) !!}
                                @endif
                            </div>
                        </td> --}}

                        <td>
                            @php
                                $invoice_no = ['' => 'Select Invoice'];
                                if(isset($item->against))
                                {
                                    if($item->against == 'sales_invoice')
                                        $invoice_no = $invoice_no + $sales_vouchers;
                                    else if($item->against == 'purchase_invoice')
                                        $invoice_no = $invoice_no + $purchase_vouchers;
                                }
                            @endphp
                            <div class="invoice_block">
                                @if(isset($item->against) && ($item->against == 'other'))
                                    {!! Form::text("items[$element_counter][invoice_no]", old('invoice_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control invoice_no select2-elem select2', 'id' => 'invoice_no']) !!}
                                @else
                                    {!! Form::select("items[$element_counter][invoice_no]", $invoice_no, old('invoice_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control invoice_no select2-elem select2', 'id' => 'invoice_no']) !!}
                                @endif
                            </div>
                        </td>

                        <td>
                            {!! Form::text("items[$element_counter][amount]", old('amount', isset($item->amount) ? $item->amount : ''), ['class' => 'form-control amount', 'placeholder' => 'Amount']) !!}
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
                    @php
                        $element_counter++;
                    @endphp
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('other_amount', 'Total Amount') !!}

                    {!! Form::text('other_amount', old('other_amount', isset($payment->other_amount) ? $payment->other_amount : 0), ['class' => 'form-control other_amount','readonly'=>'readonly']) !!} 
                    {{-- {!! Form::text('amount', old('amount', isset($payment->amount) ? $payment->amount : 0), ['class' => 'form-control total_amount','id' => 'amount','readonly'=>'readonly']) !!} --}}
                </div>
            </div>
        </div>
    </div>
</fieldset>

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){
            addItem = function(element, item, element_counter)
            {
                var item_template = item.clone();

                item_template.find(".party_type").attr('name', 'items['+element_counter+'][party_type]');
                item_template.find(".party").attr('name', 'items['+element_counter+'][party]');
                item_template.find(".against").attr('name', 'items['+element_counter+'][against]');
                //item_template.find(".voucher_no").attr('name', 'items['+element_counter+'][voucher_no]');
                item_template.find(".invoice_no").attr('name', 'items['+element_counter+'][invoice_no]');
                item_template.find(".amount").attr('name', 'items['+element_counter+'][amount]');
                item_template.find(".payment_item_id").attr('name', 'items['+element_counter+'][payment_item_id]');
                item_template.find(".element_counter").attr('name', 'items['+element_counter+'][element_counter]');

                item_template.find('select').each(function() {
                    $(this).val("");
                });
                item_template.find('input').val('');

                item_template.find(".element_counter").val(element_counter);

                element.append(item_template)
            };

            calculateOtherAmount = function() {
                var total_amount = $.trim( $(document).find('.total_amount').val() );
                total_amount = (total_amount) ? total_amount : 0;
                // var arr = $(document).find('.amount').map((i, e) => e.value).get();

                var sum = 0;

                $(document).find('.amount').each(function() {
                    var val = $.trim( $(this).val() );
                    if ( val ) {
                        val = parseFloat( val.replace( /^\$/, "" ) );

                        sum += !isNaN( val ) ? val : 0;
                    }
                });

                if(total_amount >= sum) {
                    var other_amount = parseFloat(total_amount) - sum;
                    $(document).find('.other_amount').val(other_amount);
                    return true;
                }
                else {
                    return false;
                }
            }

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-item', function() {
                $('.error').text('');
                var item = $(".add-items-list").children("tr.new-item:last-child");

                var has_error = false;

                item.find('select').each(function(){
                    if ((! $(this).val()) && ($(this).val() == '')) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                if (! has_error) {
                    item.find('input[type=text]').each(function(){
                        if (! $(this).val()) {
                            $(this).trigger('focus');
                            has_error = true;
                            return false;
                        }
                        has_error = false;
                    });
                }

                if (! has_error) {
                    $(".error").text("");

                    addItem($(".add-items-list"), item, element_counter);
                    element_counter++;
                }
            });

            $(document).on('click', '.delete-field', function(e) {
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

            //calculateOtherAmount();
            $(document).on('blur', '.amount', function() {
                var $this = $(this);

                $('.total_amount').val($this.val());
              

                // var is_valid  = calculateOtherAmount();
                // if(! is_valid) {
                //     $this.val("");
                //     $(this).trigger('focus');
                //     return false;
                // }
            });

            // $(document).on('blur', '.total_amount', function() {
            //     var $this = $(this);
            //     var is_valid  = calculateOtherAmount();
            //     if(! is_valid) {
            //         $(".amount").val("");
            //         $(".amount").trigger('focus');
            //         return false;
            //     }
            // });

            $(document).on('click', '#payment_submit_btn', function(e) {
                e.preventDefault();
                console.log($(this));
                var is_valid  = calculateOtherAmount();
                if(is_valid) {
                    $(".error").addClass('d-none');
                    $(this).closest('form').submit();
                }
                else {
                    $(".error").text("Please provide correct data for amount");
                    $(".error").removeClass('d-none');
                }
            })
        });
    </script>
@endsection
