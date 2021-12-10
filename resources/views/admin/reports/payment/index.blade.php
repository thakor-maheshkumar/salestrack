@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'payment_report'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Payment Ledger</h3>
                    </div>
                    <div class="card-body">
                        <div class="search_block">
                            {!! Form::open(['url' => route('payment-report.index'), 'id' => 'create_workorder','method'=>'GET']) !!}
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
                            <table id="payment_report_table" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Posting Date</th>
                                        <th>Opening Balance</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                        <th>Voucher Type</th>
                                        <!--<th>Voucher No</th>-->
                                        <!--<th>Against Account</th>-->
                                        <th>Invoice</th>
                                        <th>Party</th>
                                        <th>Party Type</th>
                                        <!--<th>Against Voucher Type</th>
                                        <th>Against Voucher</th>
                                        <th>Supplier Invoice</th>
                                        <th>Remarks</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($payment_records) && count($payment_records) > 0)
                                        @foreach($payment_records as $key => $payment_record)
                                            <?php
                                                //echo '<pre>';print_r($payment_record->customers);echo '</pre>';
                                            ?>
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{ $payment_record->posting_date }}</td>
                                                <td>{{ $payment_record->opening_balance }}</td>
                                                <td>{{ $payment_record->debit }}</td>
                                                <td>{{ $payment_record->credit }}</td>
                                                <td>{{ $payment_record->balance }}</td>
                                                <td>{{ $payment_record->voucher_type }}</td>
                                                <!--<td>{{ $payment_record->voucher_no }}</td>
                                                <td>{{ $payment_record->against_account }}</td>-->
                                                <td>
                                                    <?php
                                                    if(isset($payment_record->recordable))
                                                    {
                                                        echo $payment_record->recordable->invoice_no;
                                                    }
                                                        // if($payment_record->party_type=='Supplier')
                                                        // {
                                                        //     if(isset($payment_record->suppliers))
                                                        //     {
                                                        //         echo $payment_record->suppliers->ledger_name;
                                                        //     }
                                                        // }else{
                                                        //     if(isset($payment_record->customers))
                                                        //     {
                                                        //         echo $payment_record->customers->ledger_name;
                                                        //     }
                                                        // }
                                                    ?>
                                                <td>
                                                    @if(is_numeric($payment_record->party))
                                                        @if($payment_record->party_type=='Supplier')
                                                            {{ isset($payment_record->suppliers) ? $payment_record->suppliers->ledger_name : '-' }}
                                                        @else
                                                        {{ isset($payment_record->customers) ? $payment_record->customers->ledger_name : '-'}}
                                                        @endif
                                                    @else
                                                        {{ $payment_record->party }}
                                                    @endif
                                                </td>
                                                <td>{{ $payment_record->party_type }}</td>

                                                {{-- <td>{{ $payment_record->against_voucher_type }}</td>
                                                <td>{{ $payment_record->against_voucher  }}</td>
                                                <td>{{ $payment_record->supplier_invoice }}</td>
                                                <td>{{ $payment_record->remarks }}</td> --}}
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
        var table = $('#payment_report_table').DataTable();


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
