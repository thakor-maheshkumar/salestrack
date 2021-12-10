@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_receipt'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h3 class="mb-0">View Receipt</h3>
                            </div>
                            <div class="col-8 text-right">
                                @if(isset($order->payment) && !empty($order->payment))
                                    <a class="btn btn-primary" href="{{ route('payments.edit', $order->payment->id)}}">Go To Payment</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        @include('admin.transactions.purchase.purchase-receipt.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
