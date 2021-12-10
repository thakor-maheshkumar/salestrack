@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_transfer'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar create-stock-page">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create Stock</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('stocks.store'), 'id' => 'create_stock']) !!}
                            @include('admin.stocks.form')
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
@section('script')
<script type="text/javascript">
</script>
@endsection
