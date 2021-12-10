@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'qc_report'
])
@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">QC Report Details</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('qc-report.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="col-md-12">
                            <p><label>Work Order ID : </label>{{ $workOrder->work_order_id }}</p>
                            <p><label>Plan ID :</label> {{ isset($workOrder->plan->plan_id) ? $workOrder->plan->plan_id : '' }}</p>
                            <p><label>Item Name :</label> {{ isset($workOrder->plan->stockItems->name) ? $workOrder->plan->stockItems->name : '' }}</p>
                            <p><label>Quantity :</label> {{ isset($workOrder->plan->quantity) ? $workOrder->plan->quantity : '' }}</p>
                        </div>
                        <div class="col-md-12">
                            @if(\Helper::userHasPageAccess('qc-report.add.work-order'))
                                <a class="btn btn-primary" href="{{route('qc-report.add.work-order', ['id'=>$workOrder->id,'stock_item_id' => $workOrder->plan->stockItems->id])}}">Add QC</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Series ID</th>
                                        <th>Work order Id</th>
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
                                            <td>{{ $r->work_order_id}}</td>
                                            <td>{{ $r->grades->grade_name}}</td>
                                            <td>{{ $r->product_name }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    <li>
                                                        <a href="{{ route('qc-report.workorder.view', $r->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                    </li>
                                                    <li>
                                                        {!! Form::open(['url' => route('qc-report.work-order.destroy', $r->id), 'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('qc-report.workorder.print', $r->id) }}" class="btn btn-gray"><i class="fas fa-print"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Workorder not found...</td>
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
