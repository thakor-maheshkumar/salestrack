@php
    $element_counter = 0;
@endphp
<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Stock Items</legend>
    <div class="table-responsive">
        <table class="dynamic-table--warpper">
            <thead>
                <th>Item Code/Name</th>
                <th>Batch</th>
                <th>UOM</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Net Amount</th>
                <th>Discount(%)</th>
                <th>Discount Amount</th>
                <th>Tax(%)</th>
                <th>Tax Amount</th>
                <th>Total Amount</th>
                <th></th>
            </thead>
            <tbody class="add-items-list">

            @if(isset($order->items) && !empty($order->items))
                @foreach($order->items as $sKey => $item)
                <?php
//                print'<pre>';
//                print_r($item);
//                die;
                ?>
                    <tr class="new-item">
                       <td>
                            <input type="hidden" class="item_id" name="items[{{$element_counter}}][item_id]" value="{{$item->id}}">
                            <select id="item_name" name="items[{{$element_counter}}][item_name]" data-plugin-selectTwo class="form-control item_name select2-elem select2" data-name="item_name" required="required">
                                <option value="">Select Item Code/Name</option>
                                @if(!empty($stockItem))
                                @foreach($stockItem as $value)
                                <option value="{{ $value->id }}" @if($item->stock_item_id == $value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                                @endforeach
                                @endif
                            </select>
                            <input type="hidden" class="item_code" name="items[{{$element_counter}}][item_code]" value="{{$item->item_code}}">
                        </td>
                        <td>
                            {{Form::select("items[$element_counter][batch]", (!empty($batches)) ? [''=>'Select a Batch']+$batches : [''=>'Select a Batch'], $item->batch_id, ['id'=>'batch','class'=>'form-control batch' ])}}
                        </td>
                        <td>
                            {{Form::select("items[$element_counter][unit]", [''=>'Select an Item']+$units, $item->unit, ['id'=>'unit','class'=>'form-control unit' ])}}
                            {{-- {!! Form::text("items[$element_counter][unit]",$item->unit, ['class' => 'form-control unit', 'id' => 'unit', 'placeholder' => 'UOM','required'=>'required']) !!} --}}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][quantity]",$item->quantity, ['class' => 'form-control quantity', 'placeholder' => 'Quantity','required'=>'required']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][rate]", $item->rate, ['class' => 'form-control rate', 'placeholder' => 'Rate','required'=>'required']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][net_amount]", $item->net_amount, ['class' => 'form-control net_amount', 'placeholder' => 'Net Amount','readonly'=>'readonly']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][discount]", $item->discount_in_per, ['class' => 'form-control discount', 'placeholder' => 'Discount(%)']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][discount_amount]", $item->discount, ['class' => 'form-control discount_amount', 'placeholder' => 'Discount Amount']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][tax]", $item->tax, ['class' => 'form-control tax', 'placeholder' => 'Tax(%)']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][tax_amount]", $item->tax_amount, ['class' => 'form-control tax_amount', 'placeholder' => 'Tax Amount','readonly'=>'readonly']) !!}
                        </td>
                        {{-- <td>
                            {!! Form::text("items[$element_counter][cess]", $item->cess, ['class' => 'form-control cess', 'placeholder' => 'Cess(%)']) !!}
                        </td>
                        <td>
                            {!! Form::text("items[$element_counter][cess_amount]", $item->cess_amount, ['class' => 'form-control cess_amount', 'placeholder' => 'Cess Amount','readonly'=>'readonly']) !!}
                        </td> --}}
                        <td>
                            {!! Form::text("items[$element_counter][total_amount]", $item->total_amount, ['class' => 'form-control total_amount', 'placeholder' => 'Total Amount','readonly'=>'readonly']) !!}
                        </td>
                        <td>
                            <div class="delete-field-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-field btn btn-danger" data-toggle="tooltip"
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
                        <input type="hidden" class="item_id" name="items[{{$element_counter}}][item_id]" value="">
                        <select id="item_name" name="items[{{$element_counter}}][item_name]" data-plugin-selectTwo class="form-control item_name select2-elem select2" data-name="item-name" required="required">
                            <option value="">Select Item Code/Name</option>
                            @if(!empty($stockItem))
                            @foreach($stockItem as $value)
                            <option value="{{ $value->id }}"> {{ $value->pack_code.'-'.$value->name }} </option>
                            @endforeach
                            @endif
                        </select>
                        <input type="hidden" class="item_code" name="items[{{$element_counter}}][item_code]" value="">
                    </td>
                    <td>
                        {{Form::select("items[$element_counter][batch]", [''=>'Select a Batch']+$batches, null, ['id'=>'batch','class'=>'form-control batch' ])}}
                    </td>
                    <td>

                        {{Form::select("items[$element_counter][unit]", [''=>'Select an Item']+$units, null, ['id'=>'unit','class'=>'form-control unit' ])}}
                        {{-- {!! Form::text("items[$element_counter][unit]", old("unit[$element_counter]"), ['class' => 'form-control unit', 'id' => 'unit', 'placeholder' => 'UOM','required'=>'required']) !!} --}}
                    </td>
                    <td>
                        {!! Form::text("items[$element_counter][quantity]",1, ['class' => 'form-control quantity', 'placeholder' => 'Quantity','required'=>'required']) !!}
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
                                class="btn btn-remove delete-field btn btn-danger" data-toggle="tooltip"
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
                        <a href="javascript:void(0);" class="btn btn-add add-item btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            </tfoot>
        </table>


        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('total_net_amount', 'Total Net Amount') !!}
                    {!! Form::text('total_net_amount', old('net_amount', isset($order->net_amount) ? $order->net_amount : 0), ['class' => 'form-control total_net_amount','readonly'=>'readonly']) !!}
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('total_grand_amount', 'Total Grand Amount') !!}
                        {!! Form::text('total_grand_amount', old('total_grand_amount', isset($order->total_net_amount) ? $order->total_net_amount : 0), ['class' => 'form-control total_grand_amount','readonly'=>'readonly']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
@section('scripts')
    @parent
    <script type="text/javascript">
        /*function countRateAmount(rate,index)
        {
            var item_count = $(this).closest(".add-items-list").children("tr.new-item");
            alert(item_count.find('.element_counter').index());
            var item = $(".add-items-list").closest("tr.new-item").index();
            //$('.element_counter').closest('tr.new-item').index();
            alert(item);
            if(rate != '')
            {
                //var item = $(".add-items-list").children("tr.new-item:last-child");
                //var index = $('.element_counter').val();
                alert(index);
                var quantity = $("input[name='items["+index+"][quantity]']").val();
                getAmount(rate,quantity);
                countNetAmount();
            }
        }
        function countQtyAmount(quantity)
        {
            if(quantity != '')
            {
                var item = $(".add-items-list").children("tr.new-item:last-child");
                var index = $('.element_counter').val();
                var rate = $("input[name='items["+index+"][rate]']").val();
                getAmount(rate,quantity);
                countNetAmount();
            }
        }*/
        /*function countNetAmount()
        {
            var total_net_amount = 0;
            var total_grand_amount = 0;
            $('.net_amount').each(function(){
                total_net_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
            });
            //$('.total_net_amount').val(total_net_amount);

            $('.total_amount').each(function(){
                total_grand_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
            });
            $('.total_net_amount').val(total_net_amount);
            $('.total_grand_amount').val(total_grand_amount);
        }*/
        $(document).ready(function(){

            getStockDetails = function(element, stock_item_id)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{url("admin/transactions/purchase/GetStockDetails")}}',
                    data:{stock_item_id:stock_item_id},
                    success:function(data){
                        //var item_id = $("input[name='items["+index+"][item_id]']").val();
                        console.log(data);
                        var parent_item = element.closest('tr.new-item');

                        parent_item.find('.item_id').each(function(){
                            $(this).val(data.stock_details.id);
                        });
                        parent_item.find('.item_code').each(function(){
                            $(this).val(data.stock_details.product_code);
                        });

                        parent_item.find('.unit').each(function(){
                            $(this).val(data.unit);
                        });

                        parent_item.find('.tax').each(function(){
                            $(this).val(data.tax);
                        });

                        /*parent_item.find('.cess').each(function(){
                            $(this).val(data.cess);
                        });*/
                    }
                });
            };

            addItem = function(element, item, element_counter)
            {
                item.find(".select2-elem").each(function(index)
                {
                    $(this).select2('destroy');
                });
                var item_template = item.clone();

                item_template.find(".item_id").attr('name', 'items['+element_counter+'][item_id]');
                item_template.find(".item_name").attr('name', 'items['+element_counter+'][item_name]');
                item_template.find(".item_code").attr('name', 'items['+element_counter+'][item_code]');
                item_template.find(".batch").attr('name', 'items['+element_counter+'][batch]');
                item_template.find(".unit").attr('name', 'items['+element_counter+'][unit]');
                item_template.find(".quantity").attr('name', 'items['+element_counter+'][quantity]');
                item_template.find(".rate").attr('name', 'items['+element_counter+'][rate]');
                item_template.find(".net_amount").attr('name', 'items['+element_counter+'][net_amount]');
                item_template.find(".discount").attr('name', 'items['+element_counter+'][discount]');
                item_template.find(".discount_amount").attr('name', 'items['+element_counter+'][discount_amount]');
                item_template.find(".tax").attr('name', 'items['+element_counter+'][tax]');
                item_template.find(".tax_amount").attr('name', 'items['+element_counter+'][tax_amount]');
                //item_template.find(".cess").attr('name', 'items['+element_counter+'][cess]');
                //item_template.find(".cess_amount").attr('name', 'items['+element_counter+'][cess_amount]');
                item_template.find(".total_amount").attr('name', 'items['+element_counter+'][total_amount]');

                item_template.find('input').val('');
                item_template.find(".select2-elem").select2();
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

                    //addItem($(".add-items-list"),element_counter)
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

            getAmount = function(rate,quantity,discount,index)
            {
                var tax = $("input[name='items["+index+"][tax]']").val();
                var discount_in_per = $("input[name='items["+index+"][discount]']").val();
                //var cess =$("input[name='items["+index+"][cess]']").val();
                if(discount != 0)
                {
                    var dis_rate = ((rate*discount)/100);
                    dis_rate = rate - dis_rate;
                }else{
                    var dis_rate = rate;
                }
                var net_amount = quantity * dis_rate;
                $("input[name='items["+index+"][net_amount]']").val(net_amount);
                var tax_amount = (tax*net_amount)/100;
                //tax_amount = net_amount - tax_amount;
                $("input[name='items["+index+"][tax_amount]']").val(tax_amount);
                /*var cess_amount = (cess*net_amount)/100;
                $("input[name='items["+index+"][cess_amount]']").val(cess_amount);*/
                //var total_amount = net_amount + tax_amount + cess_amount;
                var total_amount = net_amount + tax_amount;
                $("input[name='items["+index+"][total_amount]']").val(total_amount);

                if(discount_in_per != 0)
                {
                    var discount_amount = ((discount_in_per*net_amount)/100);
                    var total_discount_ammount = net_amount - discount_amount;
                    //discount_amount = net_amount - discount_amount;
                    $("input[name='items["+index+"][discount_amount]']").val(discount_amount);
                    var tax_amount = (tax*total_discount_ammount)/100;
                    $("input[name='items["+index+"][tax_amount]']").val(tax_amount);
                    var total_amount = (net_amount + tax_amount) - discount_amount;
                    $("input[name='items["+index+"][total_amount]']").val(total_amount);
                }
            };

            countNetAmount = function(){
                var total_net_amount = 0;
                var total_grand_amount = 0;
                $('.net_amount').each(function(){
                    total_net_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                });
                $('.total_amount').each(function(){
                    total_grand_amount += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
                });
                $('.total_net_amount').val(total_net_amount);
                $('.total_grand_amount').val(total_grand_amount);
                countGrandTotal();
                countGSTTax();
            };

            countAfterFocusOut = function(index){
                var rate = $("input[name='items["+index+"][rate]']").val();
                var quantity = $("input[name='items["+index+"][quantity]']").val();
                //var discount = $("#discount_in_per").val();
                var discount = 0;
                getAmount(rate,quantity,discount,index);
                countNetAmount();

                $('.type').each(function(){
                    var type = $(this).val();
                    if(type == 2)
                    {
                        var $tr = $(this).closest('tr');
                        var index = $tr.index();
                        var rate = $("input[name='other_taxes["+index+"][other_rate]']").val()
                        var item_net_amount = $('.total_net_amount').val();
                        var rate_amount = (rate*item_net_amount)/100;
                        $("input[name='other_taxes["+index+"][other_amount]']").val(rate_amount);
                        countOtherNetAmount();
                    }
                });
                $('.other_tax').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    var amount = $("input[name='other_taxes["+index+"][other_amount]']").val();
                    var tax = $("input[name='other_taxes["+index+"][other_tax]']").val();
                    getOtherAmount(index);
                    countOtherNetAmount();
                });
            };

            countOtherTaxes = function(index){
                var amount = $("input[name='other_taxes["+index+"][other_amount]']").val();
                var tax = $("input[name='other_taxes["+index+"][other_tax]']").val();
                getOtherAmount(index);
                countOtherNetAmount();
            };

            countOtherNetAmount = function(){
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
                countGrandTotal();
                countGSTTax();
            };

            getOtherAmount = function(index)
            {
                var amount = $("input[name='other_taxes["+index+"][other_amount]']").val();
                var tax = $("input[name='other_taxes["+index+"][other_tax]']").val();
                var tax_amount = (tax*amount)/100;
                //tax_amount = amount - tax_amount;
                $("input[name='other_taxes["+index+"][other_tax_amount]']").val(tax_amount);
                var total_amount = parseFloat(amount) + parseFloat(tax_amount);
                $("input[name='other_taxes["+index+"][other_total_amount]']").val(total_amount);
            };

            countGrandTotal = function(){
                var total_item_amount = $('.total_grand_amount').val();
                var total_other_amount = $('.total_other_grand_amount').val();
                var grand_total = parseFloat(total_item_amount) + parseFloat(total_other_amount);
                $('.grand_total').val(grand_total);

                /*var total_cess=0;
                $('.cess_amount').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    var cess_amnt = $(this).val();
                    total_cess += parseFloat(cess_amnt);
                });
                $('.total_cess_amount').val(total_cess);*/
            }

            countGSTTax = function(){
                var tax_sum = 0;
                $('.tax_amount').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    var tax = $(this).val();
                    tax = parseFloat(tax);
                    tax_sum += tax;
                });
                var StategstTax = tax_sum/2;
                StategstTax = StategstTax.toFixed(2);
                $('.cgst').val(StategstTax);
                $('.sgst').val(StategstTax);
                $('.igst').val(tax_sum);
            }

            $(document).on('focusout', '.rate', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();
                countAfterFocusOut(index);
            });

            $(document).on('focusout', '.quantity', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();
                countAfterFocusOut(index);
                /*var $tr = $(this).closest('tr');
                var index = $tr.index();
                var quantity = $("input[name='items["+index+"][quantity]']").val();
                if(quantity != '')
                {
                    var rate = $("input[name='items["+index+"][rate]']").val();
                    getAmount(rate,quantity,index);
                    countNetAmount();
                }*/

            });

            $(document).on('focusout', '.discount', function(e) {
                var $tr = $(this).closest('tr');
                var index = $tr.index();
                countAfterFocusOut(index);
            });


            countDiscount = function(){
                $('.rate').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    countAfterFocusOut(index);
                });
                $('.quantity').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    countAfterFocusOut(index);
                });
            };

            $(document).on('focusout', '#discount_in_per', function(e) {
                var discount = $(this).val();
                countDiscount();
                var sum = 0;
                $('.rate').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    var rate = $("input[name='items["+index+"][rate]']").val();
                    var quantity = $("input[name='items["+index+"][quantity]']").val();
                    var total_amount = rate * quantity;
                    sum += total_amount;
                });
                if(sum != 0)
                {
                    //var discount = (discount*sum)/100;
                    //$("#discount_amount").val(discount);
                    countDiscount();
                }
            });

            /*$(document).on('focusout', '#discount_amount', function(e) {
                var discount_amount = $(this).val();
                var sum = 0;
                $('.rate').each(function(){
                    var $tr = $(this).closest('tr');
                    var index = $tr.index();
                    var rate = $("input[name='items["+index+"][rate]']").val();
                    var quantity = $("input[name='items["+index+"][quantity]']").val();
                    var total_amount = rate * quantity;
                    sum += total_amount;
                });
                if(sum != 0)
                {
                    var discount = (discount_amount/sum)*100;
                    $("#discount_in_per").val(discount);
                    countDiscount();
                }
            });*/

            $(document).on('change', '.item_name', function(e) {
                var stock_item_id = $(this).val();
                console.log(stock_item_id);
                if(stock_item_id)
                {
                    getStockDetails($(this), stock_item_id);
                }
            });
        });
    </script>
@endsection
