@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'account_groups'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Account Group</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('groups.update', $group->id), 'method' => 'PUT', 'id' => 'update_group']) !!}
                            @include('admin.group.form')
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
        // $.custom.getGroupType.init();
    </script>
@endsection
