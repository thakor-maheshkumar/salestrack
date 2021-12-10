@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'payment'
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
                                <h2 class="mb-0">All Payments</h2>
                            </div>
                            <div class="col-8 text-right">
                                @if(\Helper::userHasPageAccess('payments.create'))
                                    <a href="{{route('payments.create')}}" class="btn btn-success">Add Payment</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($payments) && count($payments) > 0)
                                <table id="group_table" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                            <th>Mode Of Payment</th>
                                            <th>Party</th>
                                            <th>Voucher Type</th>
                                            <th>Invoice No</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($payments as $key => $payment)
                                        <?php //echo '<pre>';print_r($payment->amount_items->toArray());echo '</pre>'; ?>

                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ isset($payment_types[$payment->payment_type]) ? $payment_types[$payment->payment_type] : '' }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->payment_mode }}</td>
                                                <td>
                                                    <?php
                                                        if(!empty($payment->amount_items))
                                                        {
                                                            if($payment->amount_items->party_type=='supplier')
                                                            {
                                                                if(isset($payment->amount_items->suppliers)) echo $payment->amount_items->suppliers->ledger_name;
                                                            }else if($payment->amount_items->party_type=='customer'){
                                                                if(isset($payment->amount_items->customers)) echo $payment->amount_items->customers->ledger_name;
                                                            }else{
                                                                if(isset($payment->amount_items->general)) echo $payment->amount_items->general->ledger_name;
                                                            }
                                                            //echo '<pre>';print_r($payment->amount_items->invoice_no);echo '</pre>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    {{ (!empty($payment->amount_items)) ? $payment->amount_items->against : '' }} 
                                                </td>
                                                <td>
                                                    <?php
                                                        if(!empty($payment->amount_items))
                                                        {
                                                            //if(!empty($payment->amount_items))
                                                            if($payment->amount_items->party_type=='supplier')
                                                            {
                                                                if(isset($payment->amount_items->sales_invoice)) echo $payment->amount_items->sales_invoice->invoice_no;
                                                            }else if($payment->amount_items->party_type=='customer'){
                                                                if(isset($payment->amount_items->purchase_invoice)) echo $payment->amount_items->purchase_invoice->invoice_no;
                                                            }
                                                            //echo '<pre>';print_r($payment->amount_items->invoice_no);echo '</pre>';
                                                        }
                                                    ?>
                                                </td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        @if(\Helper::userHasPageAccess('payments.edit'))
                                                        <li class="{{ (\Helper::userHasPageAccess('payments.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                        @endif
                                                        @if(\Helper::userHasPageAccess('payments.destroy'))
                                                            <li>
                                                                {!! Form::open(['url' => route('payments.destroy', $payment->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
