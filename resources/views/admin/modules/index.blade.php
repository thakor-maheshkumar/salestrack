@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => ''
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="main-content--head row justify-content-between">
                            <div class="col-md-auto">
                                <h3 class="card-title">All Modules</h3>
                            </div>
                            <div class="col-md-auto">
                                <a href="{{ route('modules.create') }}" class="btn btn-primary btn-large">Add Module</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($modules) && count($modules) > 0)
                                <table id="example1" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Alias</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modules as $module)
                                            <tr>
                                                <td>{{ $module->id }}</td>
                                                <td>{{ $module->id }}</td>
                                                <td>{{ $module->name }}</td>
                                                <td>{{ $module->alias }}</td>
                                                <td>{{ $module->type }}</td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li class="{{ (\Helper::userHasPageAccess('modules.show')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('modules.show', $module->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                        <li class="{{ (\Helper::userHasPageAccess('modules.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-gray"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Modules not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
