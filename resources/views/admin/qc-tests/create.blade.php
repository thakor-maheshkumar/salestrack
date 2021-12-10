@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'qc_tests'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create QC Test</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('qc-tests.store'), 'id' => 'create_qc_tests']) !!}
                            @include('admin.qc-tests.form')
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
