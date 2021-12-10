@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'sales_order'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">View Sales Order</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        @include('admin.transactions.sales.sales-order.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
