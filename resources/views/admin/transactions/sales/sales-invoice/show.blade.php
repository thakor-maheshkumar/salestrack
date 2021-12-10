@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'sales_invoice'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-sm-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Invoice</h3>
                        {{-- @if(isset($order->payment) && !empty($order->payment))
                            <a class="btn btn-primary float-right" href="{{ route('payments.edit', $order->payment->id)}}">Go To Payment</a>
                        @endif --}}
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->update_link, $order->id), 'method' => 'PUT', 'id' => 'sales_invoice']) !!}
                            @include('admin.transactions.sales.sales-invoice.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
