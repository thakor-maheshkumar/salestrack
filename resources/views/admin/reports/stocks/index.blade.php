@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_ledger_report'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Stock Ledger</h3>
                    </div>
                    <div class="card-body">
                        <div class="search_block">
                            {!! Form::open(['url' => route('stock-ledger.index'), 'id' => 'create_workorder','method'=>'GET']) !!}
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        {!! Form::label('item_item_id', 'Salect Item') !!}
                                        <select id="item_name" name="item_id" class="form-control item_item_id select2-elem" data-name="item_name">
                                            <option value="">Select Item Code/Name</option>
                                                @if(!empty($items))
                                                    @foreach($items as $value)
                                                        <option value="{{ $value->id }}" @if(isset($request_data['item_id']) && $request_data['item_id']==$value->id){{"selected='selected'"}} @endif> {{ $value->pack_code.'-'.$value->name }} </option>
                                                    @endforeach
                                                @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('warehouse_id', 'Select Warehouse') !!}
                                        {!! Form::select('warehouse_id', ['' => 'Select Warehouse'] + $warehouses, old('warehouse_id', isset($request_data['warehouse_id']) ? $request_data['warehouse_id'] : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_warehouse_id']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('batch_id', 'Salect Batch') !!}
                                        {!! Form::select('batch_id', ['' => 'Select Batch'] + $batches, old('batch_id', isset($request_data['batch_id']) ? $request_data['batch_id'] : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_batch_id']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                        {{-- {!! link_to_route('stocks.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!} --}}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Item Name</th>
                                       
                                        <th>Warehouse</th>
                                        <th>UOM</th>
                                        <th>Quantity</th>
                                        <th>Balance Quantity</th>
                                        <th>Rate</th>
                                        <th>Valuation Value</th>
                                        <th>Balance Value</th>
                                        <th>Voucher Type</th>
                                        <th>Voucher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($stock_report_data) && count($stock_report_data) > 0)
                                        @php $total_rate=0; $total_balance=0; @endphp
                                        @foreach($stock_report_data as $key => $item)
                                            @php $total_rate += $item->qty; $total_balance += $item->total_balance @endphp
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ date('d/m/Y H:i:s',strtotime($item->created)) }}</td>
                                                <td>{{ $item->item_name }} - {{ $item->pack_code }}</td>
                                               
                                                <td>{{ $item->warehouse->name ?? '-'}}</td>
                                                <td>{{ $item->uom }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->balance_qty }}</td>
                                                <td>{{ $item->rate }}</td>
                                                <td>{{ $item->balance_value }}</td>
                                                <td>{{ $item->total_balance }}</td>
                                                <td>{{ $item->voucher_type }}</td>
                                                <td>{{ $item->voucher_no  }}</td>
                                            </tr>
                                        @endforeach
                                            <tr><td></td><td></td><td></td><td></td><td></td><td></td>
                                                <td>{{$total_rate}}</td><td></td><td></td>
                                                <td>{{$total_balance}}</td><td></td><td></td>
                                            </tr>
                                    @else
                                        <tr>
                                            <td colspan="10" align="center">Record not found.</td>
                                        </tr>
                                    @endif
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
