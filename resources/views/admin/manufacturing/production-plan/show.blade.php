@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'production_plan'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content create-stock-page main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">Production Plan</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('production-plan.index') }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <div class="p-3">
                           <p><label>Plan ID :</label> {{$item->plan_id}}</p>
                           <p><label>Item Name :</label> {{$item->stockItems->name}}</p>
                           <p><label>Quantity :</label> {{$item->quantity}}</p>
                           @if($item->so_id != NULL)
                           <p><label>Sales Order No. :</label> {{$item->salesorder->order_no ?? ''}}</p>
                           @endif
                           <p><label>Status :</label> {!! ($item->status==1) ? '<label class="text-red">Pending</label>' : '<label class="text-green">Executed</label>'  !!}</p>

                           @php
                                $element_counter = 0;
                            @endphp
                            <div class="table-responsive">
                              <table class="dynamic-table--warpper">
                                    <thead>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </thead>
                                    <tbody class="add-items-list">
                                        @if(isset($plan_items) && !empty($plan_items))
                                            @foreach($plan_items as $sKey => $plan_item)
                                            @php
                                            @endphp
                                                <tr class="new-item">
                                                    <td>
                                                        {!! Form::text("plan_item[$element_counter][item_item_id]", $plan_item->stockItems['name'], ['class' => 'form-control item_item_id', 'id' => 'item_item_id', 'placeholder' => 'Item Name','disabled'=>'disabled']) !!}
                                                    </td>
                                                    <td class="datepicker-box">
                                                        {!! Form::number("plan_item[$element_counter][item_qty]", $plan_item['quantity'], ['class' => 'form-control item_qty', 'id' => 'item_qty', 'placeholder' => 'Quantity','disabled'=>'disabled']) !!}
                                                    </td>
                                                </tr>
                                                @php
                                                    $element_counter++;
                                                @endphp
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
