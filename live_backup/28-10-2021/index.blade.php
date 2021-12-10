@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'materials'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h2 class="mb-0">Material Request</h2>
                            </div>
                            <div class="col-12 text-right">
                                <button id="test"></button>
                                <a href="{{ route('transactions.purchase') }}" class="btn btn-primary">Back</a>
                                @if(\Helper::userHasPageAccess('materials.create'))
                                    <a href="{{ route('materials.create') }}" class="btn btn-success">New Material Request</a>
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
                                        <th>Series ID</th>
                                        <th>Required Date</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Edited By</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- <tr>
                                        <th></th>
                                        <th>Series ID</th>
                                        <th>Required Date</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Edited By</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody style="outline:thin solid black;">
                                 @if(isset($materials) && count($materials) > 0)
                                    @foreach($materials as $key => $item)
                                    @if($item->status=="Pending")
                                        <tr class="pending">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->series_id }}</td>
                                            <td>{{ $item->required_date }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(! isset($item->purchase_order) || empty($item->purchase_order))
                                                        @if(\Helper::userHasPageAccess('materials.edit'))
                                                            <li>
                                                                <a href="{{ route('materials.edit', $item->id) }}" class="btn btn-gray"><i class="fas fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                {!! Form::open(['url' => route('materials.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                        @elseif($item->status=="Ordered")
                                        <tr class="ordered">
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->series_id }}</td>
                                            <td>{{ $item->required_date }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(! isset($item->purchase_order) || empty($item->purchase_order))
                                                        @if(\Helper::userHasPageAccess('materials.edit'))
                                                            <li>
                                                                <a href="{{ route('materials.edit', $item->id) }}" class="btn btn-gray"><i class="fas fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                {!! Form::open(['url' => route('materials.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Material not found...</td>
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
                    "bInfo": false,
                    "destroy":true,
                    "order": [[ 5, "desc" ]],
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
                                    return 'Series Id';
                                }
                                else if(columnIdx==2){
                                return 'Required Date';
                                }
                                else if(columnIdx==3){
                                return 'Type';
                                }
                                else if(columnIdx==4){
                                return 'Date';
                                }
                                else if(columnIdx==5){
                                return 'Status';
                                }
                                else if(columnIdx==6){
                                return 'Edited By';
                                }
                                else{
                                return 'test';
                                }
                            }
                        }
                    },
                },
            ],

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
         $('table .ordered:first')
        .css("outline","thin solid black");
    })
</script>
@endsection
