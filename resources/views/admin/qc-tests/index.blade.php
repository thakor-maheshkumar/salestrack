@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'qc_tests'
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
                                <h2 class="mb-0">QC Tests</h2>
                            </div>
                            <div class="col-8 text-right">
                                <button id="test"></button>
                                @if(\Helper::userHasPageAccess('qc-tests.create'))
                                    <a href="{{route('qc-tests.create')}}" class="btn btn-success">Create QC Test</a>
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
                                        <th>Product Name</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- <tr>
                                        <th></th>
                                        <th>Product Name</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                @if(isset($qc) && count($qc) > 0)
                                    @foreach($qc as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->stockItems->name }}</td>
                                            <td>{{ $item->grades->grade_name }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('qc-tests.edit'))
                                                        <li>
                                                            <a href="{{ route('qc-tests.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                        <li>
                                                            {!! Form::open(['url' => route('qc-tests.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                            {!! Form::close(); !!}
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" align="center">QC not found...</td>
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
                                    return 'Production Name';
                                }
                                else if(columnIdx==2){
                                return 'Grade';
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
                    'targets': [1,2,], 
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
