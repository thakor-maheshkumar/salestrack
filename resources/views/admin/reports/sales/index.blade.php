@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'sales_report'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Sales Report</h3>
                    </div>
                    <div class="card-body">
                        <div class="search_block">
                            {!! Form::open(['url' => route('sales-report.index'), 'id' => 'sales_report','method'=>'GET']) !!}
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            {!! Form::text('from_date', old('from_date', isset($request_data['from_date']) ? $request_data['from_date'] : ''), ['class' => 'form-control datepicker custom_range_search', 'id'=>'from_date', 'placeholder' => 'From Date', 'autocomplete' => "off"]) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::text('to_date', old('to_date', isset($request_data['to_date']) ? $request_data['to_date'] : ''), ['class' => 'form-control datepicker custom_range_search','id'=>'to_date', 'placeholder' => 'To Date', 'autocomplete' => "off"]) !!}
                                        </div>
                                        {{-- <div class="col-md-6">
                                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                                        </div> --}}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        @include('common.messages')
                        <div class="table-wrapper table-responsive">
                            <table id="sales_report_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Invoice No</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($sales_invoices) && count($sales_invoices) > 0)
                                        @foreach($sales_invoices as $key => $sales_record)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ $sales_record->required_date }}</td>
                                                <td>{{ isset($sales_record->customers->ledger_name) ? $sales_record->customers->ledger_name : '' }}</td>
                                                <td>{{ $sales_record->invoice_no }}</td>
                                                <td>{{ $sales_record->grand_total }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" align="center">Record not found.</td>
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
@section('script')
    <script type="text/javascript">
        var table = $('#sales_report_table').DataTable();


        /* Custom filtering function which will search data in column four between two values */
        $.fn.dataTable.ext.search.push(
            function( oSettings, aData, iDataIndex ) {
                var min = $('#from_date').datepicker('getDate');
                var max = $('#to_date').datepicker('getDate');
                var startDate = new Date(aData[1]);
                if (min == null && max == null) return true;
                if (min == null && startDate <= max) return true;
                if (max == null && startDate >= min) return true;
                if (startDate <= max && startDate >= min) return true;
                return false;
            }
        );

        $('.custom_range_search').on( 'keyup change clear', function () {
            table.draw();
        });
    </script>
@endsection
