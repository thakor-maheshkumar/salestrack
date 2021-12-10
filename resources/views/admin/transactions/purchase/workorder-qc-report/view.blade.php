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
                                <h2 class="mb-0">QC Report Details</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ route('qc-report.workorder.show', $work_order_item->id) }}" class="btn btn-info">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        <div class="col-md-12">
                            <p><label>Work order Id :</label> {{ $item->work_order_id }}</p>
                            <p><label>Grade :</label> {{ $item->grades->grade_name }}</p>
                            <p><label>Product Name :</label> {{ $item->product_name }}</p>
                            <p><label>CASR No :</label> {{ $item->qc->casr_no }}</p>
                            <p><label>Molecular Formula :</label> {{ $item->qc->molecular_formula }}</p>
                            <p><label>Molecular Weight :</label> {{ $item->qc->molecular_weight }}</p>
                            <p><label>Spec.No. :</label> {{ $item->qc->spec_no }}</p>
                            <p><label>A.R.No :</label> {{ $item->ar_no }}</p>
                            <p><label>Reset Date :</label> {{ $item->reset_date }}</p>
                            <p><label>Remarks :</label> {{ !empty($item->remarks) ? $item->remarks : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-24">
                <div class="card-header">
                    <h3 class="card-title">Test Results</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @php
                            $element_counter = 0;
                        @endphp
                        <table class="table table-condensed">
                            <thead>
                                <th>Tests</th>
                                <th>Acceptance criteria</th>
                                <th>Test result</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody class="add-items-list">
                                @if(isset($qc_test_results) && !empty($qc_test_results))
                                    @foreach($qc_test_results as $qc_item)
                                    <tr>
                                        <td>{{ $qc_item->qc_test->tests}} </td>
                                        <td>{{ $qc_item->qc_test->acceptance_criteria}} </td>
                                        <td>{{ $qc_item->test_result}} </td>
                                        <td>{{ $qc_item->remarks}} </td>
                                        @php
                                            $element_counter++;
                                        @endphp
                                    </tr>
                                    @endforeach
                                @else
                                @endif
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
