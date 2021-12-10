@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'units'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Unit</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('units.update', $inventoryUnit->id), 'method' => 'PUT', 'id' => 'update_unit']) !!}
                            @include('admin.inventory.unit.form')
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
