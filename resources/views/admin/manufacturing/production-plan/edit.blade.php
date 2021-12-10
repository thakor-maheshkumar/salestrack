@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'production_plan'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Stock</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('production-plan.update', $pp->id), 'method' => 'PUT', 'id' => 'update_pp']) !!}
                            @include('admin.manufacturing.production-plan.form')
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
