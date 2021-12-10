@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'customer_ledger'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit {{$other->title}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->update_link, $ledger->id), 'id' => 'edit_sales_ledger', 'method' => 'PUT']) !!}
                            @include('admin.ledger.sales.form')
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
        $.custom.getGroupType.init();
    </script>
@endsection
