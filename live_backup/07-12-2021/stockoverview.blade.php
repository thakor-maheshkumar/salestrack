@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_ledger_report'
])

@section('content')

<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Stock Quantity Overview Report</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control item_name">
                                        <option value="">Select Item</option>
                                        @foreach($stockItem as $key=>$value)
                                        <option value="{{$value->id}}" data-id="{{$value->default_warehouse}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                    @php

                    @endphp
                    <div class="card-body">
                        <div class="search_block">
                          
                        </div>
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Warehouse</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="bodyData">
                                <tr>
                                </tbody>  
                            </table>
                           <div class="remainingQty" style="display:none">
                                    <table  id="group_table" class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="" class="border-0" placeholder="Integral Value" value="intransit value"></td>
                                                <td><input type="text" name="" class="border-0 qty" style="margin-left:260px"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('body').on('change','.item_name',function(){
                var itemname=$(this).val();
                var defaultwar=$('.item_name option:selected').attr('data-id');
                $.ajax({
                    type:"get",
                    url:"{{url('admin/reports/stock-overview-report-data')}}",
                    data:
                    {
                        itemname:itemname,
                        defaultwar:defaultwar
                    },
                    dataType:'json',
                    success:function(response){
                        console.log(response);

                        var stockData=response.stockQuantity;

                        var receiptQty=response.receiptQty.remaining_qty;
                        console.log(receiptQty);
                        var bodyData='';
                       /* var sumQty=0;*/
                        $.each(stockData,function(key,value){
                            if(value.warehouse==null){
                                var warehouse='-';
                            }else{
                                var warehouse=value.warehouse.name
                            }
                            bodyData+='<tr>'+'<td>'+warehouse+'</td>'+
                                              '<td class="pmo">'+value.quantity+'</td>'+
                            '</tr>';
                           /* sumQty+=parseFloat(value.quantity);
                            remainingQty=(receiptQty-parseFloat(sumQty)||0);
                            console.log(remainingQty);*/
                        });
                        
                        $('.bodyData').html(bodyData);
                        $('.remainingQty').show();
                        var mainQty=$('.qty').val(receiptQty);
                    }
                })
            })
        })
    </script>
@endsection