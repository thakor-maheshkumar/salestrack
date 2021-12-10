@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'sales_return'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Return Details</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        @include('admin.transactions.sales.sales-return.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
