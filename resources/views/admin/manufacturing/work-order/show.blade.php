@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'workorder'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar create-stock-page">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Work Order</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <div class="p-3">
                           <p><label>Work Order ID : </label>{{$item->work_order_id}}</p>
                           <p><label>Plan ID :</label> {{$item->plan->plan_id}}</p>
                           <p><label>Item Name :</label> {{$item->plan->stockItems->name}}</p>
                            @if(isset($item->plan->warehouse_id) && !empty($item->plan->warehouse_id))
                                <p><label>Warehouse :</label> {{$item->plan->warehouse->name}}</p>
                            @endif

                            @if(isset($item->plan->batch_id) && !empty($item->plan->batch_id))
                                <p><label>Batch :</label> {{$item->plan->batch->batch_id}}</p>
                            @endif

                            @if($item->plan->so_id != '')
                                <div>
                                    <p><label>Order No : </label> {{$item->plan->salesorder->order_no}}</p>
                                </div>
                            @endif

                           <p><label>Quantity :</label> {{$item->plan->quantity}}</p>
                           <p><label>Status :</label>
                            @if($item->status==1)
                                <label class="text-red">Pending</label>
                                @if(\Helper::userHasPageAccess('work-order.order_to_process'))
                                    <a href="{{ route('work-order.order_to_process', ['work_order_id'=>$item->id,'plan_id' => $item->plan_id]) }}" class="confirm-action">Click to In Progress</a>
                                @endif
                            @elseif($item->status==2)
                                <label class="text-info">In Progress</label>
                                @if(\Helper::userHasPageAccess('work-order.order_to_execute'))
                                    <a href="{{ route('work-order.order_to_execute', ['work_order_id'=>$item->id,'plan_id' => $item->plan_id]) }}" class="confirm-action">Click to Execute</a>
                                @endif
                            @elseif($item->status==3)
                                <label class="text-green">Executed</label>
                            @endif
                            </p>
                           @php
                                $element_counter = 0;
                            @endphp
                            <div class="table-responsive">
                                <table class="dynamic-table--warpper table table-condensed">
                                    <thead>
                                        <th>Item</th>
                                        <th>Warehouse</th>
                                        <th>Batch</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </thead>
                                    <tbody class="add-items-list">
                                        @if(isset($plan_items) && ($plan_items->isNotEmpty()))
                                            @foreach($plan_items as $sKey => $plan_item)
                                                @if(isset($plan_item->stockItems) && !empty($plan_item->stockItems))
                                                    <tr class="new-item">
                                                        <td>
                                                            {!! Form::text("plan_item[$element_counter][item_item_id]", isset($plan_item->stockItems->name) ? $plan_item->stockItems->name : '', ['class' => 'form-control item_item_id', 'id' => 'item_item_id', 'placeholder' => 'Item Name','disabled'=>'disabled']) !!}
                                                        </td>
                                                        <td class="datepicker-box">
                                                            {!! Form::text("plan_item[$element_counter][warehouse]", isset($plan_item->warehouse->name) ? $plan_item->warehouse->name : '', ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Warehouse','disabled'=>'disabled']) !!}
                                                        </td>
                                                        <td class="datepicker-box">
                                                            {!! Form::text("plan_item[$element_counter][batch]", isset($plan_item->batch->batch_id) ? $plan_item->batch->batch_id : '', ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Batch','disabled'=>'disabled']) !!}
                                                        </td>
                                                        <td class="datepicker-box">
                                                            {!! Form::number("plan_item[$element_counter][item_qty]", isset($plan_item->quantity) ? $plan_item->quantity : '', ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Quantity','disabled'=>'disabled']) !!}
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $element_counter++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
@section('script')

@endsection
