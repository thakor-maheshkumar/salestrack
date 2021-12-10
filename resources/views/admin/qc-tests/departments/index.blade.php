@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'departments'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">All Departments</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('departments.create') }}" class="btn btn-primary btn-large">Add Departments</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($departments) && count($departments) > 0)
                                <table id="example1" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Other Address</th>
                                            <th>Landmark</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($departments as $key => $department)
                                            <tr>
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->address }}</td>
                                                <td>{{ $department->address_1 }}</td>
                                                <td>{{ $department->landmark }}</td>
                                                <td>{{ $department->city }}</td>
                                                <td>{{ $department->state }}</td>
                                                <td>{{ isset($department->country->name) ? $department->country->name : '' }}</td>
                                                <td>{{ $department->email }}</td>
                                                <td>{{ $department->phone }}</td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li class="{{ (\Helper::userHasPageAccess('departments.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Department not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
