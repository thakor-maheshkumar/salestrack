@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'units'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h2 class="mb-0">Unit</h2>
                                <div class="col-md-12" id="importFrm" >
                                    <form action="{{route('units.import')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                     <input type="file" name="file" required="" />
                                    <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                                     <input type="radio" name="import" checked="true"> Append
                                    <input type="radio" name="import" value="override"> Overide
                                    @error('file')
                                    <div class="alert alert-danger alert-error " style="width:500px">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ $message }}
                                    </div>
                                    @enderror
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button id="test"></button>
                                <a href="{{ route('inventory.index') }}" class="btn btn-primary">Back</a>
                                @if(\Helper::userHasPageAccess('units.create'))
                                    <a href="{{ route('units.create') }}" class="btn btn-success">Create Unit</a>
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
                                        <th>Symbol</th>
                                        <th>Name</th>
                                        <th>Unit Quantity Code</th>
                                        <th>No Of Decimal Places</th>
                                        <th style="display: none;">Active</th>
                                        <th>Action</th>
                                    </tr>
                                   <!--  <tr>
                                        <th></th>
                                        <th>Symbol</th>
                                        <th>Name</th>
                                        <th>Unit Quantity Code</th>
                                        <th>No Of Decimal Places</th>
                                        <th style="display:none">Active</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                @if(isset($inventoryUnits) && count($inventoryUnits) > 0)
                                    @foreach($inventoryUnits as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ isset($item->symbol) ? $item->symbol : '' }}</td>
                                            <td>{{ isset($item->name) ? $item->name : '' }}</td>
                                            <!-- <td>{{ isset($item->unit_code->name) ? $item->unit_code->name : '' }}</td> -->
                                            <td>{{$item->unit_quantity_code}}</td>
                                            <td>{{ isset($item->no_of_decimal_places) ? $item->
                                            no_of_decimal_places : '' }}</td>
                                            <td style="display:none">{{$item->active}}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('units.edit'))
                                                        <li>
                                                            <a href="{{ route('units.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                        <li>
                                                            {!! Form::open(['url' => route('units.destroy', $item->id), 'method' => 'DELETE']) !!}
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
                                            <td colspan="5" align="center">Units not found...</td>
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
                    columns:[1,2,3,4,5],
                    modifier: {
                    page: 'all'
                    },
                    format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==1)
                                {
                                    return 'Symbol';
                                }
                                else if(columnIdx==2){
                                return 'Name';
                                }
                                else if(columnIdx==3){
                                return 'Unit quantity code';
                                }
                                else if(columnIdx==4){
                                return 'No of decimal places';
                                }
                                else if(columnIdx==5){
                                return 'Active';
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
                    'targets': [1,2,3,4], 
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

