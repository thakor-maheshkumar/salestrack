@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'transporter'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h5 class="title">{{ __('Create Transporter') }}</h5>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['url' => route('transporter.store'), 'id' => 'create_transporter']) !!}
                            @include('admin.transporter.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
