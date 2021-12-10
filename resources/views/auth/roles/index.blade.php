@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'roles'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-auto">
                                <h2 class="mb-0">All Roles</h2>
                            </div>
                            <div class="col-md-auto text-right">
                                <a href="{{ route('roles.create') }}" class="btn btn-success btn-large">Add Role</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($roles) && count($roles) > 0)
                                <table id="example1" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Permissions</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $key => $role)
                                            <tr>
                                                <td>{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td></td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li>
                                                            <a href="{{ route('roles.edit', $role->slug) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Roles not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
