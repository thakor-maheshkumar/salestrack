@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'warehouse'
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
                                <h2 class="mb-0">All Warehouses</h2>
                                <div class="col-md-12" id="importFrm" >
                                <form action="{{route('warehouse.insert')}}" method="post" enctype="multipart/form-data">
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
                                <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-large">Add Warehouse</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($warehouses) && count($warehouses) > 0)
                                <table id="group_table" class="table datatable table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="display: none;">Parentable Id</th>
                                            <th style="display:none">Parentable Type</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Other Address</th>
                                            <th>Landmark</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th style="display:none">Module Id</th>
                                            <th style="display:none">Active</th>
                                            <th>Action</th>
                                        </tr>
                                        <!-- <tr>
                                            <th></th>
                                            <th style="display:none">Parentable Id</th>
                                            <th style="display:none">Parentable Type</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Other Address</th>
                                            <th>Landmark</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th style="display:none">Module Id</th>
                                            <th style="display:none">Active</th>
                                            <th>Action</th>
                                        </tr> -->
                                    </thead>
                                    <tbody>
                                        @foreach($warehouses as $key => $warehouse)
                                            <tr>
                                                <td>{{ $warehouse->id }}</td>
                                                <td style="display:none">{{$warehouse->parentable_id}}</td>
                                                <td style="display:none">{{$warehouse->parentable_type}}</td>
                                                <td>{{ $warehouse->name }}</td>
                                                <td>{{ $warehouse->address }}</td>
                                                <td>{{ $warehouse->address_1 }}</td>
                                                <td>{{ $warehouse->landmark }}</td>
                                                <td>{{ $warehouse->city }}</td>
                                                <td>{{ $warehouse->state }}</td>
                                                <!-- <td>{{ isset($warehouse->country->name) ? $warehouse->country->name : '' }}</td> -->
                                                <td>{{$warehouse->country_id}}</td>
                                                <td>{{ $warehouse->email }}</td>
                                                <td>{{ $warehouse->phone }}</td>
                                                <td style="display:none">{{$warehouse->module_id}}</td>
                                                <td style="display:none">{{$warehouse->active}}</td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li class="{{ (\Helper::userHasPageAccess('warehouses.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Warehouse not found.</h6>
                            @endif
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
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
                    format: {
                            header: function ( data, columnIdx ) {
                                
                                if(columnIdx==1)
                                {
                                    return 'Parentable Id';
                                }
                                else if(columnIdx==2){
                                return 'Parentable Type';
                                }
                                else if(columnIdx==3){
                                return 'Name';
                                }
                                else if(columnIdx==4){
                                return 'Address';
                                }
                                else if(columnIdx==5){
                                return 'Street';
                                }
                                else if(columnIdx==6){
                                return 'Landmark';
                                }
                                else if(columnIdx==7){
                                return 'City';
                                }
                                else if(columnIdx==8){
                                return 'State';
                                }
                                else if(columnIdx==9){
                                return 'Coutntry';
                                }
                                else if(columnIdx==10){
                                return 'Email';
                                }
                                else if(columnIdx==11){
                                return 'Phone';
                                }
                                else if(columnIdx==12){
                                return 'Module Id';
                                }
                                else if(columnIdx==13){
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
                    'targets': [1,2,3,4,5,6,7,8,9], 
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
