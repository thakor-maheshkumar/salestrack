@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'qc_report'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">QC Report Details</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('qc-report.index') }}" class="btn btn-info">Back</a>
                                {{-- <a href="{{ $other->add_link }}" class="btn btn-success">New Order</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <p><label>Item Name :</label> {{ $item->purchase_items->stockItems->name }} </p>
                            <p><label>Item Code :</label> {{ $item->purchase_items->item_code }} </p>
                            <p><label>Quantity :</label> {{ $item->purchase_items->receipt_quantity }}</p>
                            <p><label>Receipt No :</label> {{ $item->receipt_no }}</p>
                            <p><label>Warehouse :</label> {!! isset($item->warehouse->name) ? $item->warehouse->name : '-' !!}</p>
                            <p><label>Batch :</label> {!! isset($item->batch->batch_id) ? $item->batch->batch_id : '-' !!}</p>
                        </div>
                        <div class="col-md-12">
                            @if(\Helper::userHasPageAccess('qc-report.add'))
                                <a class="btn btn-primary {{ (($item->warehouse_id == NULL) && ($item->batch_id == NULL)) ? 'confirm-qc' : '' }}" href="{{route('qc-report.add', ['id'=>$item->id,'stock_item_id' => $item->purchase_items->stockItems->id])}}">Add QC</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if( $item->qc_status == 0)
            <div class="row">
                <div class="col-md-24 mb-2">
                    <div class="card card-primary">
                        <div class="card-body">
                            {!! Form::open(['url' => route('qc-report.reset_purchase_receipt_basic_info', $item->id), 'method' => 'PUT', 'id' => 'update_qc_report']) !!}
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            {!! Form::label('warehouse_id', 'Warehouse') !!}
                                            {!! Form::select('warehouse_id', ['' => 'Select a Warehouse'] + $warehouses, old('warehouse_id', isset($item->warehouse_id) ? $item->warehouse_id : ''), ['class' => 'form-control','required'=>'required'] ) !!}
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {!! Form::label('batch_id', 'Batch') !!}
                                                {!! Form::select('batch_id', ['' => 'Select a Batch'] + $batches, old('batch_id', isset($item->batch_id) ? $item->batch_id : ''), ['class' => 'form-control','required'=>'required'] ) !!}
                                            </div>
                                        </div>
                                        @if(\Helper::userHasPageAccess('qc-report.reset_purchase_receipt_basic_info'))
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::submit('Change', ['class' => 'btn btn-primary']) !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-24 mb-2">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
            				<table id="group_table" class="table table-condensed">
            					<thead>
            						<tr>
                                        <th>Series ID</th>
                                        <th>Receipt No</th>
                                        <th>Grade Name</th>
            							<th>Product Name</th>
            							<th>Action</th>
            						</tr>
            					</thead>
            					<tbody>
                                    @if(isset($reports) && count($reports) > 0)
                						@foreach($reports as $key => $r)
                							<tr>
                								<td>{{ $r->id }}</td>
                								<td>{{ $r->receipt_no}}</td>
                                                <td>{{ $r->grades->grade_name}}</td>
                								<td>{{ $r->product_name }}</td>
                								<td class="action--cell">
                									<ul class="action--links">
                                                        <li>
                                                            <a href="{{ route('qc-report.view', $r->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                		            					<li>
                											{!! Form::open(['url' => route('qc-report.destroy', $r->id), 'method' => 'DELETE']) !!}
                				            					<button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                				            				{!! Form::close(); !!}
                		            					</li>
                                                        <li>
                                                            <a href="{{ route('qc-report.print', $r->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                        </li>
                		            				</ul>
                								</td>
                							</tr>
                						@endforeach
            						@else
            				        	<tr>
            				        		<td colspan="5" align="center">Receipt not found...</td>
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
