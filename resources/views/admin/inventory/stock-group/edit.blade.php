@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_groups'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary  main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Stock Group</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('stock-groups.update', $group->id), 'method' => 'PUT', 'id' => 'update_stock_group']) !!}
                            @include('admin.inventory.stock-group.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
