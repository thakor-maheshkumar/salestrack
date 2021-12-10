@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'stock_items'
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
                                <h2 class="mb-0">Stock Items</h2>
                                <div class="col-md-12" id="importFrm" >
                                    <form action="{{route('stock-items.import')}}" method="post" enctype="multipart/form-data">
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
                                <a href="{{route('inventory.index')}}" class="btn btn-primary">Back</a>
                                @if(\Helper::userHasPageAccess('stock-items.create'))
                                    <a href="{{route('stock-items.create')}}" class="btn btn-success">Create Stock-Item</a>
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
                                        <th>Name</th>
                                        <th style="display:none;">Product Description</th>
                                        <th>Under</th>
                                        <th style="display:none;">Unit Id</th>
                                        <th style="display:none;">Convertion Rate</th>
                                        <th style="display:none;">Shipper Pack</th>
                                        <th style="display:none;">Alternate Unit Id</th>
                                        <th style="display:none;">Part No</th>
                                        <th style="display:none">Category Id</th>
                                        <th style="display:none;">Is Allow Mrp</th>
                                        <th style="display:none;">Is Allow Part Number</th>
                                        <th style="display:none;">Is Maintain In Batches</th>
                                        <th style="display:none;">Track Manufecturing Date</th>
                                        <th style="display:none;">Use Expiry Date</th>
                                        <th style="display:none;">Is GST Detail</th>
                                        <th style="display:none;">Taxability</th>
                                        <th style="display:none;">Is Reverse Charge</th>
                                        <th style="display:none;">Tax Type</th>
                                        <th style="display:none;">Rate</th>
                                        <th style="display:none;">Applicable Date</th>
                                        <th style="display:none;">Cess</th>
                                        <th style="display:none;">Cess Applicable Date</th>
                                        <th style="display:none;">Supply Type</th>
                                        <th style="display:none;">Hsn Code</th>
                                        <th style="display:none;">Default Warehouse</th>
                                        <th style="display:none;">Opening Stock</th>
                                        <th style="display:none;">Maintain Stock</th>
                                        <th style="display:none;">Product Code</th>
                                        <th style="display:none;">Cas No</th>
                                        <th style="display:none;">Pack Code</th>
                                        <th style="display:none;">Active</th>
                                        <th>Action</th>
                                    <!-- </tr>
                                     <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th style="display:none;">Product Description</th>
                                        <th>Under</th>
                                        <th style="display:none;">Unit Id</th>
                                        <th style="display:none;">Convertion Rate</th>
                                        <th style="display:none;">Shipper Pack</th>
                                        <th style="display:none;">Alternate Unit Id</th>
                                        <th style="display:none;">Part No</th>
                                        <th style="display:none">Category Id</th>
                                        <th style="display:none;">Is Allow Mrp</th>
                                        <th style="display:none;">Is Allow Part Number</th>
                                        <th style="display:none;">Is Maintain In Batches</th>
                                        <th style="display:none;">Track Manufecturing Date</th>
                                        <th style="display:none;">Use Expiry Date</th>
                                        <th style="display:none;">Is GST Detail</th>
                                        <th style="display:none;">Taxability</th>
                                        <th style="display:none;">Is Reverse Charge</th>
                                        <th style="display:none;">Tax Type</th>
                                        <th style="display:none;">Rate</th>
                                        <th style="display:none;">Applicable Date</th>
                                        <th style="display:none;">Cess</th>
                                        <th style="display:none;">Cess Applicable Date</th>
                                        <th style="display:none;">Supply Type</th>
                                        <th style="display:none;">Hsn Code</th>
                                        <th style="display:none;">Default Warehouse</th>
                                        <th style="display:none;">Opening Stock</th>
                                        <th style="display:none;">Maintain Stock</th>
                                        <th style="display:none;">Product Code</th>
                                        <th style="display:none;">Cas No</th>
                                        <th style="display:none;">Pack Code</th>
                                        <th style="display:none;">Active</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                @if(isset($stock_items) && count($stock_items) > 0)
                                    @foreach($stock_items as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td style="display:none;">{{ $item->product_descriptiopn}}</td>
                                            <td>{{ isset($item->group->group_name) ? $item->group->group_name : '' }}</td>
                                           <!--  <td>{{$item->under}}</td> -->
                                            <td style="display:none;">{{$item->unit_id}}</td>
                                            <td style="display:none;">{{$item->convertion_rate}}</td>
                                            <td style="display:none;">{{$item->shipper_pack}}</td>
                                            <td style="display:none;">{{$item->alternate_unit_id}}</td>
                                            <td style="display:none;">{{$item->part_no}}</td>
                                            <!-- <td style="display:none">{{ isset($item->stock_category->name) ? $item->stock_category->name : '' }}</td> -->
                                            <td style="display:none">{{$item->category_id}}</td>
                                            <td style="display:none;">{{$item->is_allow_mrp}}</td>
                                            <td style="display:none;">{{$item->is_allow_part_number}}</td>
                                            <td style="display:none;">{{$item->is_maintain_in_batches}}</td>
                                            <td style="display:none;">{{$item->track_manufacture_date}}</td>
                                            <td style="display:none;">{{$item->use_expiry_dates}}</td>
                                            <td style="display:none;">{{$item->is_gst_detail}}</td>
                                            <td style="display:none;">{{$item->taxability}}</td>
                                            <td style="display:none;">{{$item->is_reverse_charge}}</td>
                                            <td style="display:none;">{{$item->tax_type}}</td>
                                            <td style="display:none;">{{$item->rate}}</td>
                                            <td style="display:none;">{{$item->applicable_date}}</td>
                                            <td style="display:none;">{{$item->cess}}</td>
                                            <td style="display:none;">{{$item->cess_applicable_date}}</td>
                                            <td style="display:none;">{{$item->supply_type}}</td>
                                            <td style="display:none;">{{$item->hsn_code}}</td>
                                            <td style="display:none;">{{$item->default_warehouse}}</td>
                                            <td style="display:none;">{{$item->opening_stock}}</td>
                                            <td style="display:none;">{{$item->maintain_stock}}</td>
                                            <td style="display:none;">{{$item->product_code}}</td>
                                            <td style="display:none;">{{$item->cas_no}}</td>
                                            <td style="display:none;">{{$item->pack_code}}</td>
                                            <td style="display:none;">{{$item->active}}</td>

                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('stock-items.edit'))
                                                        <li>
                                                            <a href="{{ route('stock-items.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                        <li>
                                                            {!! Form::open(['url' => route('stock-items.destroy', $item->id), 'method' => 'DELETE']) !!}
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
                                            <td colspan="5" align="center">Stock items not found...</td>
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
                    columns:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
                    modifier: {
                    page: 'all'
                    },
                    
                    format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==1)
                                {
                                    return 'Name';
                                }
                                else if(columnIdx==2)
                                {
                                    return 'Product Description';
                                }
                                else if(columnIdx==3){
                                return 'Under';
                                }
                                else if(columnIdx==4){
                                return 'Unit Id';
                                }
                                else if(columnIdx==5){
                                return 'Convertion Rate';
                                }
                                else if(columnIdx==6){
                                return 'Shipper Pack';
                                }
                                else if(columnIdx==7){
                                return 'Alternate Unit Id';
                                }
                                else if(columnIdx==8){
                                return 'Part No';
                                }
                                else if(columnIdx==9){
                                return 'Category Id';
                                }
                                else if(columnIdx==10){
                                return 'Is Allow Mrp';
                                }
                                else if(columnIdx==11){
                                return 'Is Allow Part Number';
                                }
                                else if(columnIdx==12){
                                return 'Is Maintain In Batches';
                                }
                                else if(columnIdx==13){
                                return 'Track Manufecturing Date';
                                }
                                else if(columnIdx==14){
                                return 'Use Expiry Date';
                                }
                                else if(columnIdx==15){
                                return 'Is GST Detail';
                                }
                                else if(columnIdx==16){
                                return 'Taxability';
                                }
                                else if(columnIdx==17){
                                return 'Is Reverse Charge';
                                }
                                else if(columnIdx==18){
                                return 'Tax Type';
                                }
                                else if(columnIdx==19){
                                return 'Rate';
                                }
                                else if(columnIdx==20){
                                return 'Applicable Date';
                                }
                                else if(columnIdx==21){
                                return 'Cess';
                                }
                                else if(columnIdx==22){
                                return 'Cess Applicable Date';
                                }
                                else if(columnIdx==23){
                                return 'Supply Type';
                                }
                                else if(columnIdx==24){
                                return 'Hsn Code';
                                }
                                else if(columnIdx==25){
                                return 'Default Warehouse';
                                }
                                else if(columnIdx==26){
                                return 'Opening Stock';
                                }
                                else if(columnIdx==27){
                                return 'Maintain Stock';
                                }
                                else if(columnIdx==28){
                                return 'Product Code';
                                }
                                else if(columnIdx==29){
                                return 'Cas No';
                                }
                                else if(columnIdx==30){
                                return 'Pack Code';
                                }
                                else if(columnIdx==31){
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

