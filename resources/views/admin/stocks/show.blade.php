@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_transfer'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Stock Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('admin.stocks.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
