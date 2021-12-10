@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => $module->name
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
                                <h3 class="card-title">All {{ $module->name }}</h3>
                            </div>
                            <div class="col-md-auto">
                                <a href="{{ route('custom-module.create', $module->slug) }}" class="btn btn-primary btn-large">Add {{ $module->name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($moduleRows) && count($moduleRows) > 0)
                                <table id="example1" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @php
                                                $titleList = $moduleRows[0];
                                            @endphp
                                            @foreach($titleList as $tKey => $fields)
                                                @if(! in_array($tKey, $exceptColumns))
                                                    <th>{{ getFormattedTableColumnName($tKey)}}</th>
                                                @endif
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($moduleRows as $tKey => $moduleRow)
                                            <tr>
                                                @foreach($moduleRow as $fKey => $fields)
                                                    @if(! in_array($fKey, $exceptColumns))
                                                        <td>{{ $fields }}</td>
                                                    @endif
                                                @endforeach
                                                <td class="action--cell">
                                                    <ul class="action--links">
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
                                <h6>{{ $module->name }} not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
