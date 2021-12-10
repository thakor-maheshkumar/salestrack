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
                        <h3 class="card-title">Edit Return</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->update_link, $order->id), 'method' => 'PUT', 'id' => 'sales_return']) !!}
                            @include('admin.transactions.sales.sales-return.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
