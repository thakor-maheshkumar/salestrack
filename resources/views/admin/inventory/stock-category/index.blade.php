@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_categories'
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
                                <h2 class="mb-0">Stock Categories</h2>
                                <!-- <div class="col-md-12" id="importFrm" >
                                    <form action="{{route('stock-categories.import')}}" method="post" enctype="multipart/form-data">
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
                                </div> -->
                            </div>
                            <div class="col-24 text-right">
                                 <form action="{{route('stock-categories.import')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                    <input type="file" name="file" required="" />
                                    @error('file')
                                    <div class="alert alert-danger alert-error " style="width:500px">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ $message }}
                                    </div>
                                    @enderror
                                    <input type="radio" name="import" checked="true"> Append
                                    <input type="radio" name="import" value="override"> Overide
                                    <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                                <button id="test"></button>
                                <a href="{{route('inventory.index')}}" class="btn btn-primary">Back</a>
                                @if(\Helper::userHasPageAccess('stock-categories.create'))
                                    <a href="{{route('stock-categories.create')}}" class="btn btn-success">Create Stock-Category</a>
                                @endif
                            </form>
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
                                        <th>Name</th>
                                        <th>Under</th>
                                        <th style="display: none;">Active</th>
                                        <th>Action</th>
                                    </tr>
                                   <!--  <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Under</th>
                                        <th style="display:none">Active</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                @if(isset($stock_categories) && count($stock_categories) > 0)
                                    @foreach($stock_categories as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>@if(isset($item->stock_category)){{ $item->stock_category->name }}@else {{''}} @endif</td>
                                        
                                            <td style="display:none">{{$item->active}}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('stock-categories.edit'))
                                                        <li>
                                                            <a href="{{ route('stock-categories.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                        <li>
                                                            {!! Form::open(['url' => route('stock-categories.destroy', $item->id), 'method' => 'DELETE']) !!}
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
                                            <td colspan="5" align="center">Categories not found...</td>
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
                    columns:[1,2,3],
                    format: {
                            header: function ( data, columnIdx ) {
                               
                                if(columnIdx==1)
                                {
                                    return 'Name';
                                }
                                else if(columnIdx==2){
                                return 'Under';
                                }
                                else if(columnIdx==3){
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
                    'targets': [1,2], 
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

