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
                        <h3 class="card-title">Create Work Order</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('work-order.store'), 'id' => 'create_workorder']) !!}
                            @include('admin.manufacturing.work-order.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
@section('script')

@endsection
