@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'customer_ledger'
])
@section('style')
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}
</style>
@endsection
@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create {{$other->title}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @include('common.messages')
                        @include('common.errors')
                        {!! Form::open(['url' => route($other->store_link), 'id' => 'create_sales_ledger']) !!}
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
