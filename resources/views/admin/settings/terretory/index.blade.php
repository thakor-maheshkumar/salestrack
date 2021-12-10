@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'terretory'
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
                                <h2 class="mb-0">Terretories</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('settings-listing.index') }}" class="btn btn-primary">Back</a>
                                <a href="{{ route('terretory.create') }}" class="btn btn-success">Create Terretory</a>
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
                                        <th>Terretory Name</th>
                                        <th>Under</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(isset($terretories) && count($terretories) > 0)
                                    @foreach($terretories as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->terretory_name }}</td>
                                            <td>{{ $item->under == 0 ? 'Primary' : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    <li>
                                                        <a href="{{ route('terretory.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        {!! Form::open(['url' => route('terretory.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Groups not found...</td>
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
