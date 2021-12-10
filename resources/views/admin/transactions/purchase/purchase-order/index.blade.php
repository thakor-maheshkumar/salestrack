@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_order'
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
                                <h2 class="mb-0">Purchase Orders</h2>
                            </div>
                            
                            <div class="col-12 text-right">
                                <button id="test"></button>  
                                <a href="{{ $other->back_link }}" class="btn btn-success">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-success">New Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table datatable table-condensed" style="width:100%">
                            <button class="btn btn-primary select_field">Select Field</button><br>
                            <div class="field_list" style="display:none">
                            <input type="checkbox" name="" class="series_id" checked> Series Id<br>
                            <input type="checkbox" name="" class="supplier_name" checked> Supplier Name<br>
                            <input type="checkbox" name="" class="branch_name" checked> Branch Name<br>
                            <input type="checkbox" name="" class="order_date" checked> Order Date<br>
                            <input type="checkbox" name="" class="date" checked> Date<br>
                            <input type="checkbox" name="" class="status" checked> Status<br>
                            <input type="checkbox" name="" class="edit" checked> Edited By<br>
                            <input type="checkbox" name="" class="vendor_code"> Vendor Code<br>
                             <input type="checkbox" name="" class="warehouse"> WareHouse<br>
                             </div>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="series_id_label">Series ID</th>
                                        <th class="supplier_name_label">Supplier Name</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="order_date_label">Order Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="status_label">Status</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="vendor_code_label" style="display: none;">Approved Vendor code</th>
                                        <th class="warehouse_label" style="display:none">WareHouse</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- <tr>
                                        <th></th>
                                        <th class="series_id_label">Series ID</th>
                                        <th class="supplier_name_label">Supplier Name</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="order_date_label">Order Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="status_label">Status</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="vendor_code_label" style="display: none;">Approved Vendor code</th>
                                        <th class="warehouse_label" style="display:none">WareHouse</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                 @if(isset($purchase_orders) && count($purchase_orders) > 0)
                                    @foreach($purchase_orders as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td class="series_id_value">{{ $item->order_no }}</td>
                                            <td class="supplier_name_value">{{ isset($item->suppliers->ledger_name) ? $item->suppliers->ledger_name : '' }}</td>
                                            <td class="branch_name_value">{!! (isset($item->branches)) ? $item->branches->branch_name : $item->main_branch !!}</td>
                                            <td class="order_date_value">{{ $item->order_date }}</td>
                                            <td class=date_value>{{ $item->updated_at }}</td>
                                            <td class="status_value">{{ isset(\App\Models\PurchaseOrder::$po_statuses[$item->po_status]) ? \App\Models\PurchaseOrder::$po_statuses[$item->po_status] : '' }}</td>
                                            <td class="edit_value">{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                            <td class="vendor_code_value" style="display:none">{{$item->approved_vendor_code}}</td>
                                            <td class="warehouse_value" style="display:none">{{isset($item->target_warehouse->name) ? $item->target_warehouse->name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('purchase-order.show'))
                                                        <li>
                                                            <a href="{{ route('purchase-order.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                    @endif
                                                    @if($item->po_status==0)
                                                     <li>
                                                                <a href="{{ url('admin/transactions/purchase/purchase-order/createPurchaseInvoice', $item->id) }}" class="btn btn-info">Purchase Invoice</a>
                                                            </li>
                                                        <li>
                                                                <a href="{{ url('admin/transactions/purchase/purchase-order/createPurchaseReceipt', $item->id) }}" class="btn btn-success">CREATE PR</a>
                                                            </li>
                                                    @elseif($item->po_status==1)
                                                    <li>
                                                                <a href="{{ url('admin/transactions/purchase/purchase-order/createPurchaseInvoice', $item->id) }}" class="btn btn-info">Purchase Invoice</a>
                                                            </li>
                                                    @elseif($item->po_status==2)
                                                     <li>
                                                                <a href="{{ url('admin/transactions/purchase/purchase-order/createPurchaseReceipt', $item->id) }}" class="btn btn-success">CREATE PR</a>
                                                            </li>
                                                    @endif
                                                    @if((! isset($item->purchase_invoice) || ($item->purchase_invoice->isEmpty())) && (!isset($item->purchase_receipt) || ($item->purchase_receipt->isEmpty())))
                                                        @if(\Helper::userHasPageAccess('purchase-order.edit'))
                                                         
                                                            <li>
                                                                <a href="{{ route('purchase-order.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                {!! Form::open(['url' => route('purchase-order.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('purchase-order.print', $item->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Orders not found...</td>
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
        $('body').on('click','.select_field',function(){
            $('.field_list').toggle();
        });
        $('body').on('click','.series_id',function(){
            if($(this).is(":checked")){
                $('.series_id_value').show();
                $('.series_id_label').show();
            }else{
              $('.series_id_value').hide();
              $('.series_id_label').hide();       
            }
        });
        $('body').on('click','.supplier_name',function(){
            if($(this).is(":checked")){
                $('.supplier_name_label').show();
                $('.supplier_name_value').show();
            }else{
              $('.supplier_name_label').hide();
              $('.supplier_name_value').hide();       
            }
        });
        $('body').on('click','.branch_name',function(){
            if($(this).is(":checked")){
                $('.branch_name_label').show();
                $('.branch_name_value').show();
            }else{
              $('.branch_name_label').hide();
              $('.branch_name_value').hide();       
            }
        });
        $('body').on('click','.order_date',function(){
            if($(this).is(":checked")){
                $('.order_date_label').show();
                $('.order_date_value').show();
            }else{
              $('.order_date_label').hide();
              $('.order_date_value').hide();       
            }
        });
        $('body').on('click','.date',function(){
            if($(this).is(":checked")){
                $('.date_label').show();
                $('.date_value').show();
            }else{
              $('.date_label').hide();
              $('.date_value').hide();       
            }
        });
        $('body').on('click','.status',function(){
            if($(this).is(":checked")){
                $('.status_label').show();
                $('.status_value').show();
            }else{
              $('.status_label').hide();
              $('.status_value').hide();       
            }
        });
        $('body').on('click','.edit',function(){
            if($(this).is(":checked")){
                $('.edit_label').show();
                $('.edit_value').show();
            }else{
              $('.edit_label').hide();
              $('.edit_value').hide();       
            }
        });
        $('body').on('click','.vendor_code',function(){
            if($(this).is(":checked")){
                $('.vendor_code_label').show();
                $('.vendor_code_value').show();
            }else{
              $('.vendor_code_label').hide();
              $('.vendor_code_value').hide();       
            }
        });
        $('body').on('click','.warehouse',function(){
            if($(this).is(":checked")){
                $('.warehouse_label').show();
                $('.warehouse_value').show();
            }else{
              $('.warehouse_label').hide();
              $('.warehouse_value').hide();       
            }
        });

    $('#group_table thead tr:eq(1) th').each( function () {
            var title = $(this).text();
                $(this).html( '<input type="text" style="width:100px";"height:50px";"font-size:2px" placeholder=" '+title+'" />' );
        });
            var table = $('#group_table').DataTable( {
                dom: 'Blfrtip',
                text: 'Export',
                 order: [[6, 'asc'], [0, 'desc']],
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
                                return 'Supplier Name';
                                }
                                else if(columnIdx==3){
                                return 'Invoice No';
                                }
                                else if(columnIdx==4){
                                return 'Purchase Order';
                                }
                                else if(columnIdx==5){
                                return 'Invoice Date';
                                }
                                else if(columnIdx==6){
                                return 'Date';
                                }
                                else if(columnIdx==7){
                                return 'Edited By';
                                }
                                else if(columnIdx==8){
                                return 'Status';
                                }
                                else if(columnIdx==9){
                                return 'Approved Vendor Code';
                                }
                                else if(columnIdx==9){
                                return 'Warehouse';
                                }
                                else{
                                return 'test';
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
