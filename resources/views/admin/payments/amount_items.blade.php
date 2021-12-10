@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Payment Reference</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Against *</th>
                <th class="invoice_no_th">Invoice No</th>
                <th>Amount</th>
            </thead>
            <tbody class="add-items-list">
                
                @if(isset($amount_items) && $amount_items)
                    @foreach($amount_items as $sKey => $item)
                    <?php //echo '<pre>';print_r($item);echo '</pre>'; exit;?>
                    <tr class="new-item">
                        <td>
                            <input type="hidden" class="payment_item_id" name="items[{{$element_counter}}][payment_item_id]" value="{{$item['id']}}">
                            <input type="hidden" class="element_counter" name="items[{{$element_counter}}][element_counter]" value="{{$element_counter}}">

                            {!! Form::select("items[$element_counter][against]", ['' => 'Select Against'] + $against_list, old('against', isset($item['against']) ? $item['against'] : ''), ['class' => 'form-control against', 'id' => 'against']) !!}
                        </td>
                        <td>
                        @php
                            $invoice_no = ['' => 'Select Invoice'];
                            if(isset($item['against']))
                            {
                                if($item['against'] == 'sales_invoice')
                                    $invoice_no = $invoice_no + $purchase_invoices;
                                else if($item['against'] == 'purchase_invoice')
                                    $invoice_no = $invoice_no + $purchase_invoices;
                            }
                        @endphp
                        <div class="invoice_block">
                            @if(isset($item['against']) && ($item['against'] == 'other'))
                                {!! Form::text("items[$element_counter][invoice_no]", old('invoice_no', isset($item['invoice_no']) ? $item['invoice_no'] : ''), ['class' => 'form-control invoice_no select2-elem select2', 'id' => 'invoice_no']) !!}
                            @else
                                {!! Form::select("items[$element_counter][invoice_no]", $invoice_no, old('invoice_no', isset($item['invoice_no']) ? $item['invoice_no'] : ''), ['class' => 'form-control invoice_no select2-elem select2', 'id' => 'invoice_no']) !!}
                            @endif
                        </div>
                    </td>
                        <td>
                            {!! Form::text("items[$element_counter][amount]", old('amount', isset($item['amount']) ? $item['amount'] : ''), ['class' => 'form-control amount', 'placeholder' => 'Amount','required'=>'required']) !!}
                        </td>
                        {{-- <td>
                            <div class="delete-field-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-field btn-danger" data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Delete row">
                                        <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td> --}}
                    </tr>
                    @php
                        $element_counter++;
                    @endphp

                    @endforeach                
                @else
                <tr class="new-item">
                    <td>

                        <input type="hidden" class="element_counter" name="items[{{$element_counter}}][element_counter]" value="{{$element_counter}}">

                        {!! Form::select("items[$element_counter][against]", ['' => 'Select Against'] + $against_list, old('against', isset($item->against) ? $item->against : ''), ['class' => 'form-control against', 'id' => 'against']) !!}
                    </td>
                    <td>
                        @php
                            $invoice_no = ['' => 'Select Invoice'];
                            if(isset($item->against))
                            {
                                if($item->against == 'sales_invoice')
                                    $invoice_no = $invoice_no + $sales_invoices;
                                else if($item->against == 'purchase_invoice')
                                    $invoice_no = $invoice_no + $purchase_invoices;
                            }
                        @endphp
                        <div class="invoice_block">
                            @if(isset($item->against) && ($item->against == 'other'))
                                {!! Form::text("items[$element_counter][invoice_no]", old('invoice_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control invoice_no', 'id' => 'invoice_no']) !!}
                            @else
                                {!! Form::select("items[$element_counter][invoice_no]", $invoice_no, old('invoice_no', isset($item->voucher_no) ? $item->voucher_no : ''), ['class' => 'form-control invoice_no select2-elem select2', 'id' => 'invoice_no']) !!}
                            @endif
                        </div>
                    </td>
                    <td>
                        {!! Form::text("items[$element_counter][amount]", old('amount', isset($item->amount) ? $item->amount : ''), ['class' => 'form-control amount', 'placeholder' => 'Amount','required'=>'required']) !!}
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
            @if(!isset($amount_items))
            <tfoot>
                <tr>
                    <td colspan="3">
                        <a href="javascript:void(0);" class="btn btn-add add-item btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
            @endif
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
                item_template.find(".against").attr('name', 'items['+element_counter+'][against]');
                item_template.find(".invoice_no").attr('name', 'items['+element_counter+'][invoice_no]');
                item_template.find(".amount").attr('name', 'items['+element_counter+'][amount]');
                item_template.find(".payment_item_id").attr('name', 'items['+element_counter+'][payment_item_id]');
                item_template.find(".element_counter").attr('name', 'items['+element_counter+'][element_counter]');

                item_template.find('select').each(function() {
                    $(this).val("");
                    //$(this).select2();
                });

                // item_template.find('.select2-elem').val('');
                // item_template.find(".select2-elem").select2();

                item_template.find('input').val('');

                //item_template.find(".element_counter").val(element_counter);

                element.append(item_template);
            }
            var element_counter = "{{ $element_counter }}";
           
            var user_amount = on_account_balance=0;
            // $('.amount').each(function(){
            //     if ((! $(this).val()) && ($(this).val() == '')) {
            //         // $(this).trigger('focus');
            //         // has_error = true;
            //         // return false;
            //     }
            //     user_amount = user_amount + parseFloat($(this).val());
            //            //alert(user_amount);

            //     if($(".use_on_account").is(':checked'))
            //     {
                    
            //         user_amount = user_amount + parseFloat($(this).val());
            //         on_account_balance = parseFloat($('.show_balance').attr('data-balance'));
                    
            //         if(user_amount > on_account_balance)
            //         {
            //             $(this).trigger('focus');
            //             has_error = true;
            //             return false;
            //         }
            //     }
            //     //has_error = false;
            // });
            $(document).on('click', '.add-item', function() {

                $('.error').text('');
                var item = $(".add-items-list").children("tr.new-item:last-child");

                var has_error = false;

                item.find('.against').each(function(){
                    if ((! $(this).val()) && ($(this).val() == '')) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                if (! has_error) {
                    
                    item.find('.amount').each(function(){
                        if ((! $(this).val()) && ($(this).val() == '')) {
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
                    $(".element_counter").val(element_counter);

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

        });
    </script>
@endsection
