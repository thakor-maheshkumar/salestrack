@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::button('Submit', ['class' => 'btn btn-primary', 'id' => 'payment_submit_btn']) !!}
    {!! link_to_route('payments.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('payment_type', 'Payment Type *') !!}
    {!! Form::select('payment_type', ['' => 'Select Payment Type'] + $payment_types, old('payment_type', isset($payment->payment_type) ? $payment->payment_type : ''), ['class' => 'form-control payment_type select2-elem select2', 'id' => 'payment_type']) !!}

    @if ($errors->has('payment_type'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('payment_type') }}</strong>
        </span>
    @endif
</div>
{{--
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('party_type', 'Party Type') !!}
                {!! Form::select('party_type', ['' => 'Select Party Type'] + $party_types, old('party_type', isset($payment->party_type) ? $payment->party_type : ''), ['class' => 'form-control party_type', 'id' => 'party_type']) !!}

                @if ($errors->has('party_type'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('party_type') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('party', 'Party') !!}
                @php
                    $parties = ['' => 'Select Party'];
                    if(isset($payment->party_type))
                    {
                        if($payment->party_type == 'supplier')
                            $parties = $parties + $suppliers;
                        else if($payment->party_type == 'customer')
                            $parties = $parties + $customers;
                        else
                            $parties = $parties + $others;
                    }
                @endphp
                {!! Form::select('party', $parties, old('party', isset($payment->party) ? $payment->party : ''), ['class' => 'form-control party', 'id' => 'party']) !!}

                @if ($errors->has('party'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('party') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('against', 'Against') !!}
                {!! Form::select('against', ['' => 'Select Against'] + $against_list, old('against', isset($payment->against) ? $payment->against : ''), ['class' => 'form-control against', 'id' => 'against']) !!}

                @if ($errors->has('against'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('against') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('voucher_no', 'Voucher No') !!}
                @php
                    $vouchers = ['' => 'Select Voucher'];
                    if(isset($payment->against))
                    {
                        if($payment->against == 'sales_invoice')
                            $vouchers = $vouchers + $sales_vouchers;
                        else if($payment->against == 'purchase_invoice')
                            $vouchers = $vouchers + $purchase_vouchers;
                    }
                @endphp
                <div class="voucher_block">
                    @if(isset($payment->against) && ($payment->against == 'other'))
                        {!! Form::text('voucher_no', old('voucher_no', isset($payment->voucher_no) ? $payment->voucher_no : ''), ['class' => 'form-control voucher_no', 'id' => 'voucher_no']) !!}
                    @else
                        {!! Form::select('voucher_no', $vouchers, old('voucher_no', isset($payment->voucher_no) ? $payment->voucher_no : ''), ['class' => 'form-control voucher_no', 'id' => 'voucher_no']) !!}
                    @endif
                </div>

                @if ($errors->has('voucher_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('voucher_no') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
--}}
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('amount', 'Total Amount *') !!}
            {!! Form::text('amount', old('amount', isset($payment->amount) ? $payment->amount : ''), ['class' => 'form-control total_amount', 'id' => 'amount']) !!}

            @if ($errors->has('amount'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div> 
        <div class="col-md-12">
            {!! Form::label('payment_mode', 'Mode of Payment') !!}
            {!! Form::select('payment_mode', $modes_of_payment, old('payment_mode', isset($payment->payment_mode) ? $payment->payment_mode : ''), ['class' => 'form-control payment_mode select2-elem select2', 'id' => 'payment_mode']) !!}

            @if ($errors->has('payment_mode'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('payment_mode') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    @include('admin.payments.amount_items')
</div>
<div class="form-group payment-mode-data">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('cheque_no', 'Cheque/Reference No') !!}
            {!! Form::text('cheque_no', old('cheque_no', isset($payment->cheque_no) ? $payment->cheque_no : ''), ['class' => 'form-control cheque_no', 'id' => 'cheque_no']) !!}

            @if ($errors->has('cheque_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('cheque_no') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('cheque_date', 'Cheque/Reference Date') !!}
            {!! Form::text('cheque_date', old('cheque_date', isset($payment->cheque_date) ? $payment->cheque_date : ''), ['class' => 'form-control cheque_date datepicker', 'id' => 'cheque_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('cheque_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('cheque_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('contact', 'Contact *') !!}
    {!! Form::text('contact', old('contact', isset($payment->contact) ? $payment->contact : ''), ['class' => 'form-control contact', 'id' => 'contact']) !!}

    @if ($errors->has('contact'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('contact') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::label('remarks', 'Remarks *') !!}
    {!! Form::textarea('remarks', old('remarks', isset($payment->remarks) ? $payment->remarks : ''), ['class' => 'form-control remarks', 'id' => 'remarks', 'rows' => 3]) !!}

    @if ($errors->has('remarks'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('remarks') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::button('Submit', ['class' => 'btn btn-primary', 'id' => 'payment_submit_btn']) !!}
    {!! link_to_route('payments.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>

@section('script')
    <script type="text/javascript">
        hideBankDetailsField = function(selected_val)
        {
            if(selected_val == 'cash')
            {
                $(".payment-mode-data").addClass('d-none');
            }
            else
            {
                $(".payment-mode-data").removeClass('d-none');
            }
        }

        handlePartyDropdown = function(selected_val, parent_element)
        {
            //$("#against option:selected").attr('disabled','disabled');
            //$("#against option[value='purchase_invoice']").attr('disabled','disabled');

            $('.party').select2();
            var data = '';
            if(selected_val == 'customer')
            {
                data = {!! json_encode($customers) !!};
            }
            else if(selected_val == 'supplier')
            {
                data = {!! json_encode($suppliers) !!};
            }
            else if(selected_val == 'other')
            {
                data = {!! json_encode($others) !!};
            }

            var options = '<option value="">Select Party</option>';
            $.each(data, function(i, item) {
                options += '<option value="' + i + '">' + item + '</option>';
            });

            // $('#party').empty().html(options);
            parent_element.find('.party').empty().html(options);
        }

        handleVoucherDropdown = function(selected_val, parent_element)
        {
            var voucher_html = '';
            var element_counter = parent_element.find(".element_counter").val();
            if(selected_val == 'sales_invoice')
            {
                voucher_html = '{!! Form::select("items[:element_counter][voucher_no]", $sales_vouchers, null, ["class" => "form-control voucher_no", "id" => "voucher_no"]) !!}';
            }
            else if(selected_val == 'purchase_invoice')
            {
                voucher_html = '{!! Form::select("items[:element_counter][voucher_no]", $purchase_vouchers, null, ["class" => "form-control voucher_no", "id" => "voucher_no"]) !!}';
            }
            else if(selected_val == 'other')
            {
                var voucher_html = '{!! Form::text("items[:element_counter][voucher_no]", old("voucher_no", ""), ["class" => "form-control voucher_no", "id" => "voucher_no"]) !!}';
            }

            // $(".voucher_block").empty().html(voucher_html);
            voucher_html = voucher_html.replace(':element_counter', element_counter);
            console.log(voucher_html);
            parent_element.find('.voucher_block').empty().html(voucher_html);
        }

        handleInvoiceDropdown = function(selected_val, parent_element)
        {
            var invoice_html = '';
            var element_counter = parent_element.find(".element_counter").val();
            if(selected_val == 'sales_invoice')
            {
                invoice_html = '{!! Form::select("items[:element_counter][invoice_no]", ["" => "Select Invoice"]+$sales_invoices, null, ["class" => "form-control invoice_no select2-elem select2", "id" => "invoice_no"]) !!}';
            }
            else if(selected_val == 'purchase_invoice')
            {
                invoice_html = '{!! Form::select("items[:element_counter][invoice_no]", ["" => "Select Invoice"]+$purchase_invoices, null, ["class" => "form-control invoice_no select2-elem select2", "id" => "invoice_no"]) !!}';
            }
            else if(selected_val == 'other')
            {
                var invoice_html = '{!! Form::text("items[:element_counter][invoice_no]", old("voucher_no", ""), ["class" => "form-control invoice_no select2-elem select2", "id" => "invoice_no","disabled"=>"disabled"]) !!}';
            }
            // $(".voucher_block").empty().html(voucher_html);
            invoice_html = invoice_html.replace(':element_counter', element_counter);
            parent_element.find('.invoice_block').empty().html(invoice_html);
            // $(document).find(".add-items-list .select2-elem").each(function(index)
            // {
            //     $(this).select2();
            // });
            $('.invoice_no').select2();
        }

        hideBankDetailsField($(".payment_mode").val());

        $(document).on('change', '.payment_mode', function() {
            var selected = $(this).val();
            if(selected)
            {
                hideBankDetailsField(selected);
            }
        });

        $(document).on('change', '.party_type', function() {
            var selected = $(this).val();
            if(selected)
            {
                var parent_element = $(this).closest('.new-item');
                handlePartyDropdown(selected, parent_element);
            }
        });

        $(document).on('change', '.party', function() {
            var selected = $(this).val();
            if(selected)
            {
                var party_type =  $('.party_type :selected').val();
                var parent_element = $(this).closest('.new-item');
                handleAgainstDropdown(party_type,selected,parent_element);
            }
        });

        var handleAgainstDropdown = function(party_type,party,element){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: config.routes.url + '/admin/get_agaist_dropdown_value/' + party_type+'/'+party,
                type: 'GET',
                success:function(response) {
                    
                    var options = '<option value="">Select Against</option>';
                    $.each(response.against_list, function(i, item) {
                        options += '<option value="' + i + '">' + item + '</option>';
                    });
                    element.find('.against').empty().html(options);
                    if(response.is_show_invoice==0)
                    {
                        $(".invoice_no").attr('disabled','disabled');
                    }else{
                        $(".invoice_no").removeAttr('disabled');
                        //$(".invoice_no_th").css('display','block');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };

        $(document).on('change', '.against', function() {
            var selected = $(this).val();
            if(selected)
            {
                var parent_element = $(this).closest('.new-item');
                handleVoucherDropdown(selected, parent_element);
                handleInvoiceDropdown(selected, parent_element);
            }
        });


        $(document).on('change', '.voucher_no', function(e) {
            var voucher_no = $(this).val();
            var against =  $('.against :selected').val();
            if(voucher_no)
            {
                getInvoiceDetails($(this), voucher_no,against);
            }
        });

        var getInvoiceDetails = function(element,voucher_no,against){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: config.routes.url + '/admin/get_payment_invoice/' + voucher_no+'/'+against,
                type: 'GET',
                success:function(response) {
                    console.log(response);
                    var parent_item = element.closest('tr.new-item');

                    parent_item.find('.invoice_no').each(function(){
                        $(this).val(response.id);
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };
        $(document).on('change', '.invoice_no', function(e) {
            var invoice_no = $(this).val();
            var party_type =  $('.party_type :selected').val();
            var party =  $('.party :selected').val();
            if(invoice_no)
            {
                //getVoucherDetails($(this), invoice_no,against);
                getInvoiceDetails($(this), invoice_no,party_type,party);
            }
        });

        var getInvoiceDetails = function(element,invoice_no,party_type,party){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: config.routes.url + '/admin/get_payment_invoice_details/' + invoice_no+'/'+party_type+'/'+party,
                type: 'GET',
                success:function(response) {
                    console.log(response);
                    $('.amount').val(response.data.amount);
                    $('.total_amount').val(response.data.amount);
                    $('.other_amount').val(0);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        var getVoucherDetails = function(element,invoice_no,against){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: config.routes.url + '/admin/get_payment_voucher/' + invoice_no+'/'+against,
                type: 'GET',
                success:function(response) {
                    console.log(response);
                    var parent_item = element.closest('tr.new-item');

                    parent_item.find('.voucher_no').each(function(){
                        $(this).val(response.id);
                    });
                    $('.invoice_no').select2();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        };

    </script>
@endsection
