@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'payment'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Payment</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="alert alert-danger error d-none"></div>
                        {!! Form::open(['url' => route('payments.update', $payment->id), 'method' => 'PUT', 'id' => 'update_payment']) !!}
                            @include('admin.payments.form')
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
