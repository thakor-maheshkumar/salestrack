@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'terretory'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create Terretory</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('terretory.store'), 'id' => 'create_terretory']) !!}
                            @include('admin.settings.terretory.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
