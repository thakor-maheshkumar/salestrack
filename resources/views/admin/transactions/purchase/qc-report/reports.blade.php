@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'qc_report'
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
                                <h2 class="mb-0">QC Test Report</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('qc-report.index') }}" class="btn btn-info">Back</a>
                                {{-- <a href="{{ $other->add_link }}" class="btn btn-success">New Order</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Series ID</th>
                                        <th>Receipt No</th>
                                        <th>Grade Name</th>
                                        <th>Product Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @if(isset($items) && count($items) > 0)
                                    @foreach($items as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->receipt_no}}</td>
                                            <td>{{ $item->grades->grade_name}}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    <li>
                                                        {!! Form::open(['url' => route('qc-report.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                            <button type="submit" class="confirm-action"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Receipt not found...</td>
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
