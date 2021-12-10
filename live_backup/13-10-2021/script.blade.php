@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function() {
        getBranch = function(customer_id){
            $.ajax({
                    url: config.routes.url + '/admin/sales_ledger_details/' + customer_id,
                    type: 'GET',
                    success:function(response) {
                        console.log(response.data);
                        $("#address").val(response.customers.address);
                        $('.customerstate').val(response.customers.state);
                        //$('statemahi').val(response.customers.branchname);
                        let branch = $('.branch_id');
                        branch.empty();
                        branch.append("<option value='"+response.customers.branchname+"'>"+response.customers.branchname+"</option>");
                        $.each(response.branches, function(key, value) {
                            console.log(key);
                            branch.append("<option value='"+ key +"'>" + value + "</option>");
                        });
                        $('.branch_id').prop('disabled',false);
                        var cstate=$('.customerstate').val();
                    var companystate=$('.cpstate').val();
                    var tax_amt=$('.tax_amount').val();
                    var total_tax=tax_amt/2;
                    if(cstate==companystate){
                        $('.dstate').show();
                        $('.igst').prop('disabled',true)
                        $('.dstate').prop('disabled',false)
                        $('.igst').hide();
                        /*$('.sgst').val(total_tax);*/
                        $('.samesgst').hide();
                        $('.samesgst').prop('disabled',true);
                        $('.sgst').show();
                        $('.sgst').prop('disabled',false);
                        $('.sgst').val(total_tax);
                        $('.samecgst').hide();
                        $('.samecgst').prop('disabled',true);
                        $('.cgst').show();
                        $('.cgst').prop('disabled',false);
                        $('.cgst').val(total_tax);
                    }else{
                        $('.dstate').hide();
                        $('.igst').show();
                        $('.dstate').prop('disabled',true)
                        $('.igst').prop('disabled',false)
                        $('.igst').val(tax_amt);
                        $('.samesgst').show();
                        $('.samesgst').prop('disabled',false);
                        $('.sgst').hide();
                        $('.sgst').prop('disabled',true);
                        $('.samecgst').show();
                        $('.samecgst').prop('disabled',false);
                        $('.cgst').hide();
                        $('.cgst').prop('disabled',true);
                    }
                    },
                    error: function(error) {
                        console.log(error);
                    }
            });
        };

        $('#customer_id').on('change',function(e){
            var customer_id = e.target.value;
            getBranch(customer_id);
             
        });
        $('#branch_id').on('change',function(e){
                var branch_name=$(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'post',
                    url:'{{url("admin/transactions/sales/getSalesAddressDetails")}}',
                    data:{branch_name:branch_name},
                    success:function(data){
                        $('#address').val(data.address_detail.address);
                    }
                })
            });


        $('#sales_order_id').on('change',function(e){
            var so_id = e.target.value;
            if (so_id != '')
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{url("admin/transactions/sales/getSalesOrderDetails")}}',
                    data: {so_id: so_id},
                    success: function (data) {
                        // console.log(data);
                         //columns would be accessed using the "col" variable assigned in the for loop
                         /*$.each(data.order_details.other_charges, function(k, v) {
                            //alert(v.id);
                            $('.item_name').val(v.stock_item_id);
                            $('.quantity').val(v.quantity);

                        });*/

                        //$('.other_charges').html(data.html);
                        //$('.other_charges').html('');
                        //$('.other_charges').append(data.other_items);

                       /* for(var i =0;i < data.order_details.other_charges.length-1;i++)
                        {
                            var item = data.order_details.other_charges[i];
                            alert(item.amount);
                            //alert(item.Test1 + item.Test2 + item.Test3);
                        }*/
                        $('#address').val(data.order_details.address);
                        $('#credit_days').val(data.order_details.default_credit_period);
                        $('.customerstate').val(data.order_details.state);

                        //var BranchId = data.order_details.branch.id;
                        let branch = $('.branch_id');
                        
                        branch.empty();
                        if(data.order_details.branch != null)
                        {
                            branch.append("<option value='"+ data.order_details.branch.id +"'>" + data.order_details.branch.branch_name + "</option>");
                        }

                        $('#customer_id').val(data.order_details.sales_ledger_id);
                        
                        $('#required_date').val(data.order_details.required_date);

                        //getBranch(data.order_details.sales_ledger_id);
                        $('#warehouse_id').val(data.order_details.warehouse_id);
                        $('#user_id').val(data.order_details.users.id);
                        $('#grand_total').val(data.order_details.grand_total);
                        $('#igst').val(data.order_details.igst);
                        $('#sgst').val(data.order_details.sgst);
                        $('#cgst').val(data.order_details.cgst);
                        $('#credit_days').val(data.order_details.credit_days);
                        $('#total_net_amount').val(data.order_details.net_amount);
                        $('#total_grand_amount').val(data.order_details.total_net_amount);

                        $('.total_other_net_amount').val(data.order_details.other_net_amount);
                        $('.total_other_grand_amount').val(data.order_details.total_other_net_amount);

                        $(".add-items-list").html(data.items_view);
                        $(".add-items-list").find(".select2-elem").select2();

                        $("#other_charge_tbody").html(data.tax_items_view);
                        $("#other_charge_tbody").find(".select2-elem").select2();

                        var cstate=$('.customerstate').val();
                    var companystate=$('.cpstate').val();
                    var tax_amt=$('.tax_amount').val();
                    var total_tax=tax_amt/2;
                    if(cstate==companystate){
                        $('.dstate').show();
                        $('.igst').prop('disabled',true)
                        $('.dstate').prop('disabled',false)
                        $('.igst').hide();
                        /*$('.sgst').val(total_tax);*/
                        $('.samesgst').hide();
                        $('.samesgst').prop('disabled',true);
                        $('.sgst').show();
                        $('.sgst').prop('disabled',false);
                        $('.sgst').val(total_tax);
                        $('.samecgst').hide();
                        $('.samecgst').prop('disabled',true);
                        $('.cgst').show();
                        $('.cgst').prop('disabled',false);
                        $('.cgst').val(total_tax);
                    }else{
                        $('.dstate').hide();
                        $('.igst').show();
                        $('.dstate').prop('disabled',true)
                        $('.igst').prop('disabled',false)
                        $('.igst').val(tax_amt);
                        $('.samesgst').show();
                        $('.samesgst').prop('disabled',false);
                        $('.sgst').hide();
                        $('.sgst').prop('disabled',true);
                        $('.samecgst').show();
                        $('.samecgst').prop('disabled',false);
                        $('.cgst').hide();
                        $('.cgst').prop('disabled',true);
                    }
                    }
                });
            } else {
                $('#address').val('');
                $('#credit_days').val('');
            }
        });


        $('#note_sales_order_id').on('change',function(e){
            var sales_order_id = e.target.value;
            if (sales_order_id != '')
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{url("admin/transactions/sales/getNoteSalesOrderDetails")}}',
                    data: {sales_order_id: sales_order_id},
                    success: function (data) {
                        // console.log(data);
                         //columns would be accessed using the "col" variable assigned in the for loop
                         /*$.each(data.order_details.other_charges, function(k, v) {
                            //alert(v.id);
                            $('.item_name').val(v.stock_item_id);
                            $('.quantity').val(v.quantity);

                        });*/

                        //$('.other_charges').html(data.html);
                        //$('.other_charges').html('');
                        //$('.other_charges').append(data.other_items);

                       /* for(var i =0;i < data.order_details.other_charges.length-1;i++)
                        {
                            var item = data.order_details.other_charges[i];
                            alert(item.amount);
                            //alert(item.Test1 + item.Test2 + item.Test3);
                        }*/
                        $('#address').val(data.order_details.address);
                        $('#approved_vendor_code').val(data.order_details.customers.customer_number);
                        $('.customerstate').val(data.order_details.state);
                        if(data.order_details.branch == null)
                        {}else{
                            $('#branch_id').val(data.order_details.branch.id);
                        }
                        
                        //var BranchId = data.order_details.branch.id;
                        // let branch = $('.branch_id');
                        // branch.empty();
                        // if(data.order_details.branch != null)
                        // {
                        //     branch.append("<option value='"+ data.order_details.branch.id +"'>" + data.order_details.branch.branch_name + "</option>");
                        // }

                        $('#customer_id').val(data.order_details.sales_ledger_id);
                        $('#required_date').val(data.order_details.required_date);
                        //getBranch(data.order_details.sales_ledger_id);
                        $('#warehouse_id').val(data.order_details.warehouse_id);
                        $('#grand_total').val(data.order_details.grand_total);
                        $('#igst').val(data.order_details.igst);
                        $('#sgst').val(data.order_details.sgst);
                        $('#cgst').val(data.order_details.cgst);
                        $('#credit_days').val(data.order_details.credit_days);
                        $('#total_net_amount').val(data.order_details.net_amount);
                        $('#total_grand_amount').val(data.order_details.total_net_amount);

                        $('.total_other_net_amount').val(data.order_details.other_net_amount);
                        $('.total_other_grand_amount').val(data.order_details.total_other_net_amount);

                        $(".add-items-list").html(data.items_view);
                        $(".add-items-list").find(".select2-elem").select2();

                        $("#other_charge_tbody").html(data.tax_items_view);
                        $("#other_charge_tbody").find(".select2-elem").select2();
                        var cstate=$('.customerstate').val();
                    var companystate=$('.cpstate').val();
                    var tax_amt=$('.tax_amount').val();
                    var total_tax=tax_amt/2;
                    if(cstate==companystate){
                        $('.dstate').show();
                        $('.igst').prop('disabled',true)
                        $('.dstate').prop('disabled',false)
                        $('.igst').hide();
                        /*$('.sgst').val(total_tax);*/
                        $('.samesgst').hide();
                        $('.samesgst').prop('disabled',true);
                        $('.sgst').show();
                        $('.sgst').prop('disabled',false);
                        $('.sgst').val(total_tax);
                        $('.samecgst').hide();
                        $('.samecgst').prop('disabled',true);
                        $('.cgst').show();
                        $('.cgst').prop('disabled',false);
                        $('.cgst').val(total_tax);
                    }else{
                        $('.dstate').hide();
                        $('.igst').show();
                        $('.dstate').prop('disabled',true)
                        $('.igst').prop('disabled',false)
                        $('.igst').val(tax_amt);
                        $('.samesgst').show();
                        $('.samesgst').prop('disabled',false);
                        $('.sgst').hide();
                        $('.sgst').prop('disabled',true);
                        $('.samecgst').show();
                        $('.samecgst').prop('disabled',false);
                        $('.cgst').hide();
                        $('.cgst').prop('disabled',true);
                    }


                    }
                });
            } else {
                $('#address').val('');
                $('#credit_days').val('');
            }
        });
        

        $('#sales_order_quotation_id').on('change',function(e){
            var quotation_id = e.target.value;
            if (quotation_id != '')
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{url("admin/transactions/sales/getQuotationDetails")}}',
                    data: {quotation_id: quotation_id},
                    success: function (data) {
                        console.log(data.quotation_details.branch_bc);
                        let branch = $('.branch_id');
                        branch.empty();
                        if(data.quotation_details.branch != null)
                        {
                            branch.append("<option value='"+ data.quotation_details.branch.id +"'>" + data.quotation_details.branch.branch_name + "</option>");
                        }

                        $('#address').val(data.quotation_details.address);
                        $('.customerstate').val(data.quotation_details.state)
                        $('#required_date').val(data.quotation_details.required_date);
                        $('#customer_id').val(data.quotation_details.sales_ledger_id);
                        $('#warehouse_id').val(data.quotation_details.warehouse_id);
                        $('#user_id').val(data.quotation_details.sales_person_id);
                        $('#grand_total').val(data.quotation_details.grand_total);
                        $('#igst').val(data.quotation_details.igst);
                        $('#sgst').val(data.quotation_details.sgst);
                        $('#cgst').val(data.quotation_details.cgst);
                        $('#credit_days').val(data.quotation_details.credit_days);
                        $('#total_net_amount').val(data.quotation_details.net_amount);
                        $('#total_grand_amount').val(data.quotation_details.total_net_amount);

                        $('.total_other_net_amount').val(data.quotation_details.other_net_amount);
                        $('.total_other_grand_amount').val(data.quotation_details.total_other_net_amount);

                        $(".add-items-list").html(data.items_view);
                        $(".add-items-list").find(".select2-elem").select2();

                        $("#other_charge_tbody").html(data.tax_items_view);
                        $("#other_charge_tbody").find(".select2-elem").select2();

                    var cstate=$('.customerstate').val();
                    var companystate=$('.cpstate').val();
                    var tax_amt=$('.tax_amount').val();
                    var total_tax=tax_amt/2;
                    if(cstate==companystate){
                        $('.dstate').show();
                        $('.igst').prop('disabled',true)
                        $('.dstate').prop('disabled',false)
                        $('.igst').hide();
                        /*$('.sgst').val(total_tax);*/
                        $('.samesgst').hide();
                        $('.samesgst').prop('disabled',true);
                        $('.sgst').show();
                        $('.sgst').prop('disabled',false);
                        $('.sgst').val(total_tax);
                        $('.samecgst').hide();
                        $('.samecgst').prop('disabled',true);
                        $('.cgst').show();
                        $('.cgst').prop('disabled',false);
                        $('.cgst').val(total_tax);
                    }else{
                        $('.dstate').hide();
                        $('.igst').show();
                        $('.dstate').prop('disabled',true)
                        $('.igst').prop('disabled',false)
                        $('.igst').val(tax_amt);
                        $('.samesgst').show();
                        $('.samesgst').prop('disabled',false);
                        $('.sgst').hide();
                        $('.sgst').prop('disabled',true);
                        $('.samecgst').show();
                        $('.samecgst').prop('disabled',false);
                        $('.cgst').hide();
                        $('.cgst').prop('disabled',true);
                    }
                    }
                });
            } else {
                $('#address').val('');
                $('#required_date').val('');
            }
        });
    });
</script>
@endsection
