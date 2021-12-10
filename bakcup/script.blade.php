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
                        let branch = $('.branch_id');
                        branch.empty();
                        branch.append("<option value=''>Select Branch</option>");
                        $.each(response.branches, function(key, value) {
                            console.log(key);
                            branch.append("<option value='"+ key +"'>" + value + "</option>");
                        });
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
                        //var BranchId = data.order_details.branch.id;
                        /*let branch = $('.branch_id');
                        branch.empty();
                        if(data.order_details.branch != null)
                        {
                            branch.append("<option value='"+ data.order_details.branch.id +"'>" + data.order_details.branch.branch_name + "</option>");
                        }*/

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
                        /*let branch = $('.branch_id');
                        branch.empty();
                        if(data.quotation_details.branch != null)
                        {
                            branch.append("<option value='"+ data.quotation_details.branch.id +"'>" + data.quotation_details.branch.branch_name + "</option>");
                        }*/

                        $('#address').val(data.quotation_details.address);
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
