@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_return'
])

@section('content')
    <style type="text/css">
        .select2-container {
            min-width: 87px;
        }
    </style>
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Return</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->update_link, $order->id), 'method' => 'PUT', 'id' => 'purchase_invoice_material']) !!}
                            @include('admin.transactions.purchase.purchase-return.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
