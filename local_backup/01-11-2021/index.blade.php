@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_order'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">Purchase Orders</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ $other->back_link }}" class="btn btn-success">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-success">New Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Series ID</th>
                                        <th>Supplier Name</th>
                                        <th>Branch Name</th>
                                        <th>Order Date</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Edited By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @if(isset($purchase_orders) && count($purchase_orders) > 0)
                                    @foreach($purchase_orders as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->order_no }}</td>
                                            <td>{{ isset($item->suppliers->ledger_name) ? $item->suppliers->ledger_name : '' }}</td>
                                            <td>{!! (isset($item->branches)) ? $item->branches->branch_name : '-' !!}</td>
                                            <td>{{ $item->order_date }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>{{ isset(\App\Models\PurchaseOrder::$po_statuses[$item->po_status]) ? \App\Models\PurchaseOrder::$po_statuses[$item->po_status] : '' }}</td>
                                            <td>{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('purchase-order.show'))
                                                        <li>
                                                            <a href="{{ route('purchase-order.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                    @endif
                                                    @if((! isset($item->purchase_invoice) || ($item->purchase_invoice->isEmpty())) && (!isset($item->purchase_receipt) || ($item->purchase_receipt->isEmpty())))
                                                        @if(\Helper::userHasPageAccess('purchase-order.edit'))
                                                            <li>
                                                                <a href="{{ route('purchase-order.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                {!! Form::open(['url' => route('purchase-order.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('purchase-order.print', $item->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Orders not found...</td>
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
