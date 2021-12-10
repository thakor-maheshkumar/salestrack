@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'workorder'
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
                                <h2 class="mb-0">Work Orders</h2>
                            </div>
                            <div class="col-8 text-right">
                                <button id="test"></button>
                                @if(\Helper::userHasPageAccess('work-order.create'))
                                    <a href="{{ route('work-order.create') }}" class="btn btn-success">Create</a>
                                @endif
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
                                        <th>Work ID</th>
                                        <th>Plan ID</th>
                                        <th>Status</th>
                                        <th>View</th>
                                        <th>Delete</th>
                                    </tr>
                                    <!-- <tr>
                                        <th></th>
                                        <th>Work ID</th>
                                        <th>Plan ID</th>
                                        <th>Status</th>
                                        <th>View</th>
                                        <th>Delete</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                    @if(isset($items) && count($items) > 0)
                                        @foreach($items as $key => $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->work_order_id }}</td>
                                                <td>{{ $item->plan->plan_id }}</td>
                                                <td>
                                                    @if($item->status==1)
                                                        <label class="text-red">Pending</label>
                                                    @elseif($item->status==2)
                                                        <label class="text-info">In Progress</label>
                                                    @elseif($item->status==3)
                                                        <label class="text-green">Executed</label>
                                                    @endif
                                                </td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li>
                                                            <a href="{{ route('work-order.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                @if(\Helper::userHasPageAccess('work-order.destroy'))
                                                    <td>
                                                        {!! Form::open(['url' => route('work-order.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                            <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center">Order not found...</td>
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

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#group_table thead tr:eq(1) th').each( function () {
            var title = $(this).text();
                $(this).html( '<input type="text" style="width:100px";"height:50px";"font-size:2px" placeholder=" '+title+'" />' );
        });
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
                                return 'Id';
                                }
                                else if(columnIdx==1)
                                {
                                    return 'Work Id';
                                }
                                else if(columnIdx==2){
                                return 'Plan Id';
                                }
                                else if(columnIdx==3){
                                return 'Status';
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
                    'columnDefs': [{
                    'targets': [1,2,3], 
                    'orderable': false, 
                }]
        
         });
                    table.buttons().container().appendTo($('#test'));
                    table.columns().every( function () {
                    var that = this;
 
                    $( 'input', this.header() ).on( 'keyup change', function () {
                    console.log('keypu')
                        if ( that.search() !== this.value ) {
                         that
                        .column( $(this).parent().index() )
                        .search( this.value )
                        .draw();

                }
            });
        });
    })
</script>
@endsection
