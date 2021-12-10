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
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="search_block">
                          
                        </div>
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                       
                                        <th>Item Name</th>
                                        <th>Batch</th>
                                        <th>Warehouse</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="bodyData">
                                    
                                </tbody>
                            </table>
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
                $.ajax({
                    type:"get",
                    url:"{{url('admin/reports/stock-overview-report-data')}}",
                    data:{itemname:itemname},
                    dataType:'json',
                    success:function(response){
                        console.log(response);
                        var stockData=response.stockQuantity;
                        var bodyData='';
                        $.each(stockData,function(key,value){
                            if(value.batch==null){
                                var batch='-';
                            }else{
                                var batch=value.batch.batch_id
                            }
                            if(value.warehouse==null){
                                var warehouse='-';
                            }else{
                                var warehouse=value.warehouse.name
                            }
                            if(value.document_number >=2){
                                var quantityData=value.quantity
                            }else{
                                var quantityData="pending"
                            }
                            bodyData+='<tr>'+'<td>'+value.id+'</td>'+
                                              '<td>'+value.stockitem.name+'</td>'+
                                              '<td>'+batch+'</td>'+
                                              '<td>'+warehouse+'</td>'+
                                              '<td>'+quantityData+'</td>'+

                            '</tr>';
                        });
                        $('.bodyData').html(bodyData);    
                    }
                })
            })
        })
    </script>
@endsection