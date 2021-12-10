@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_items'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h5 class="title">{{ __('Create item') }}</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('stock-items.store'), 'id' => 'create_stock_item', 'enctype' => 'multipart/form-data']) !!}
                            @include('admin.inventory.stock-item.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
