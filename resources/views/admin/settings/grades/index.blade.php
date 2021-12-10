@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'grades'
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
                                <h2 class="mb-0">Grades</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('settings-listing.index') }}" class="btn btn-primary">Back</a>
                                <a href="{{ route('grades.create') }}" class="btn btn-success">Create Grade</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table datatable table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Grade Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($grades) && count($grades) > 0)
                                    @foreach($grades as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->grade_name }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    <li>
                                                        <a href="{{ route('grades.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        {!! Form::open(['url' => route('grades.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Grades not found...</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
