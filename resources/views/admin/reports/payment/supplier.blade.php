@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'payment_report'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Payment Report Based On Supplier</h3>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-4">
                    <form>
                        <label>Supplliers</label>
                        <select class="form-control purchaseLedger" name="puchase_ledger">
                            <option value=" ">Select Customer</option>
                            @foreach($purcheaseLedger as $key=>$value)
                            <option value="{{$value->ledger_name}}">{{$value->ledger_name}}</option>
                            @endforeach
                        </select>
                    </form>
                    </div>
                    <div class="col-md-4">
                        <label>Customers</label>
                        <select class="form-control purchaseLedger" name="sales_ledger">
                            <option value=" ">Select Supplier</option>
                            @foreach($salesLedger as $key=>$value)
                            <option value="{{$value->ledger_name}}">{{$value->ledger_name}}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="col-md-4">
                        <label>Supplier</label>
                        <select class="form-control purchaseLedger" name="puchase_ledger">
                            <option value=" ">Select Supplier</option>
                            @foreach($purcheaseLedger as $key=>$value)
                                <option value="{{$value->id}}">{{$value->ledger_name}}</option>
                            @endforeach
                            @foreach($salesLedger as $key=>$value)
                                <option value="{{$value->id}}">{{$value->ledger_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Available Balance</label>
                         <input type="text" name="available_balance" class="form-control available_balance" id="available_balance">   
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="search_block">
                            <!-- {!! Form::open(['url' => route('payment-report.index'), 'id' => 'create_workorder','method'=>'GET']) !!} -->
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                          <!--   {!! Form::text('from_date', old('from_date', isset($request_data['from_date']) ? $request_data['from_date'] : ''), ['class' => 'form-control datepicker custom_range_search', 'id'=>'from_date', 'placeholder' => 'From Date', 'autocomplete' => "off"]) !!} -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- {!! Form::text('to_date', old('to_date', isset($request_data['to_date']) ? $request_data['to_date'] : ''), ['class' => 'form-control datepicker custom_range_search','id'=>'to_date', 'placeholder' => 'To Date', 'autocomplete' => "off"]) !!} -->
                                        </div>
                                        {{-- <div class="col-md-6">
                                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                        </div> --}}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        @include('common.messages')
                        <div class="table-wrapper table-responsive">
                            <table id="payment_report_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Month </th>
                                        <th>Opening Balance</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Party Type</th>
                
                                       
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
    <!-- End: main-content -->
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('#payment_report_table').DataTable({
                 "paging":   false,
            });
            $('body').on('change','.purchaseLedger',function(){
                var purchaseLedger=$(this).val();
                    $.ajax({
                        type:'get',
                        url:"{{url('admin/reports/supplier/payment-report/data')}}",
                        data:{
                               puchase_ledger:purchaseLedger,
                            },
                        dataType:"json",
                            success:function(response){
                                var bodyData='';
                                $('.available_balance').val(response.balanceData);
                                var payementData=response.payementData;
                                    $.each(payementData,function(key,value){
                            
                                        if(value.party_type=='Supplier')
                                        {
                                            var party=value.suppliers.ledger_name;
                                        }
                                        else
                                        {
                                            var party=value.customers.ledger_name;
                                        }
                                                bodyData+='<tr>'+
                                                              
                                                                '<td>'+value.month+"-"+value.year+'</td>'+
                                                                '<td>'+value.opening_balance+'</td>'+
                                                                '<td>'+value.debit+'</td>'+
                                                                '<td>'+value.credit+'</td>'+
                                                                '<td>'+value.balance+'</td>'+
                                                               
                                                                '<td>'+value.party_type+'</td>'+
                                                         '</tr>';
                                                    })
                                                $('.bodyData').html(bodyData);

                                            }
                                });
                            })
                       })   
        
    </script>
@endsection
