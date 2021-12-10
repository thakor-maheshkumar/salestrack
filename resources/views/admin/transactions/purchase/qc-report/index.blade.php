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
                                <h2 class="mb-0">QC Report</h2>
                            </div>
                            <div class="col-8 text-right">
                                {{-- <a href="{{ $other->back_link }}" class="btn btn-info">Back</a>
                                <a href="{{ $other->add_link }}" class="btn btn-success">New Order</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body qc-report-page">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="receipt-tab" data-toggle="tab" href="#receipt" role="tab" aria-controls="receipt" aria-selected="true">Purchase Receipts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="work-tab" data-toggle="tab" href="#work" role="tab" aria-controls="work" aria-selected="false">Work Orders</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="receipt" role="tabpanel" aria-labelledby="receipt-tab">
                                <div class="table-wrapper table-responsive">
                                    @include('common.messages')
                                    <table id="group_table" class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Series ID</th>
                                                <th>Receipt No</th>
                                                <th>QC Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @if(isset($items) && count($items) > 0)
                                            @foreach($items as $key => $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->receipt_no}}</td>
                                                    <td>{!! ($item->qc_status==1) ? '<label class="text-green">Approved</label>' : '<label class="text-red">Pending</label>'; !!}</td>
                                                    <td>{{ $item->date }}</td>
                                                    <td class="action--cell">
                                                        <ul class="action--links">
                                                            <li>
                                                                <a href="{{ route('qc-report.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                            </li>
                                                            {{--<li>
                                                                {!! Form::open(['url' => route('qc-report.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>--}}
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
                            <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                <div class="table-wrapper table-responsive">
                                    @include('common.messages')
                                    <table id="group_table_work" class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Series ID</th>
                                                <th>Work ID</th>
                                                <th>QC Status</th>
                                                <th>Plan ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @if(isset($work_orders) && count($work_orders) > 0)
                                            @foreach($work_orders as $key => $work_order)
                                                <tr>
                                                    <td>{{ $work_order->id }}</td>
                                                    <td>{{ $work_order->work_order_id}}</td>
                                                    <td>{!! ($work_order->qc_status == 1) ? '<label class="text-green">Approved</label>' : '<label class="text-red">Pending</label>'; !!}</td>
                                                    <td>{{ $work_order->plan_id }}</td>
                                                    <td class="action--cell">
                                                        <ul class="action--links">
                                                            <li>
                                                                <a href="{{ route('qc-report.workorder.show', $work_order->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" align="center">Work orders not found...</td>
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
        </div>
	</div>
    <!-- End: main-content -->
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
            var table = $('#group_table').DataTable( {
                dom: 'Blfrtip',
                text: 'Export',
                "order": [[ 0, "desc" ]],
                buttons: [
                {
                    extend:'excelHtml5',
                    text:'<button class="btn btn-success">Export</button>',
                    titleAttr: 'Excel',
                    exportOptions: {
                    modifier: {
                    page: 'all'
                    },
                    columns: ':visible',
                    format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==0){
                                return 'Series Id';
                                }
                                else if(columnIdx==1)
                                {
                                    return 'Receipt No';
                                }
                                else if(columnIdx==2){
                                return 'Qc Status';
                                }
                                else if(columnIdx==3){
                                return 'Date';
                                }
                                else if(columnIdx==4){
                                return 'Series Id';
                                }
                                else{
                                return '';
                                }
                            }
                        }
                    },
                },
            ],
                    "bInfo": false,
                    "destroy":true,
        
         });
                    
                    var table = $('#group_table_work').DataTable( {
                dom: 'Blfrtip',
                text: 'Export',
                "order": [[ 0, "desc" ]],
                buttons: [
                {
                    extend:'excelHtml5',
                    text:'<button class="btn btn-success">Export</button>',
                    titleAttr: 'Excel',
                    exportOptions: {
                    modifier: {
                    page: 'all'
                    },
                    columns: ':visible',
                    format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==0){
                                return 'Series Id';
                                }
                                else if(columnIdx==1)
                                {
                                    return 'Work Id';
                                }
                                else if(columnIdx==2){
                                return 'Qc Status';
                                }
                                else if(columnIdx==3){
                                return 'Plan Id';
                                }
                                else{
                                return '';
                                }
                            }
                        }
                    },
                },
            ],
                    "bInfo": false,
                    "destroy":true,
        
         });
                    
    })
</script>
@endsection
