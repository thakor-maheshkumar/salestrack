@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'users'
])

@section('content')
	<!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">All Users</h2>
                            </div>
                            <div class="col-8 text-right">
                                @if(\Helper::userHasPageAccess('users.create'))
                                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-large">Add User</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($users) && count($users) > 0)
                                <table id="example1" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>User Id</th>
                                            <th>Email</th>
                                            <th>First Name</th>
                                            <th>Company</th>
                                            <th>Country</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->company_id }}</td>
                                                <td>{{ isset($user->country->name) ? $user->country->name : '' }}</td>
                                                <td></td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li class="{{ (\Helper::userHasPageAccess('users.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Users not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
