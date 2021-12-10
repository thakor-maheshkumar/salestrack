@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'delivery_note'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Delivery Note</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->update_link,$order->id), 'method' => 'PUT', 'id' => 'delivery_note']) !!}
                            @include('admin.transactions.sales.delivery-note.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
