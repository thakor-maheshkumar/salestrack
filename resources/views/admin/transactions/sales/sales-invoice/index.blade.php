@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'sales_invoice'
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
                                <h2 class="mb-0">Sales Invoice</h2>
                            </div>
                            <div class="col-12 text-right">
                                <button id="test"></button>
                                <a href="{{ $other->back_link }}" class="btn btn-primary">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-success">New Invoice</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            <table id="group_table" class="table datatable table-condensed">
                            <button class="btn btn-primary select_field">Select Field</button><br>
                            <div class="field_list" style="display:none">
                            <input type="checkbox" name="" class="invoice_id" checked> Invoice Id<br>
                            <input type="checkbox" name="" class="order_id" checked> Order Id<br>
                            <input type="checkbox" name="" class="customer_name" checked> Customer Name<br>
                            <input type="checkbox" name="" class="sales_person" checked> Sales Person<br>
                            <input type="checkbox" name="" class="branch_name" checked>Branch Name<br>
                            <input type="checkbox" name="" class="required_date" checked> Required Date<br>
                            <input type="checkbox" name="" class="date" checked> Date<br>
                            <input type="checkbox" name="" class="edit" checked>Edited By<br>
                            <input type="checkbox" name="" class="status" checked>Status<br>
                            <input type="checkbox" name="" class="warehouse" checked>Warehouse<br>
                             </div>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="invoice_id_label">Invoice ID</th>
                                        <th class="order_id_label">Order ID</th>
                                        <th class="customer_name_label">Customer Name</th>
                                        <th class="sales_person_label">Sales Person</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="required_date_label">Required Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="status_label">Status</th>
                                        <th class="warehouse_label">Warehouse</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- <tr>
                                        <th></th>
                                        <th class="invoice_id_label">Invoice ID</th>
                                        <th class="order_id_label">Order ID</th>
                                        <th class="customer_name_label">Customer Name</th>
                                        <th class="sales_person_label">Sales Person</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="required_date_label">Required Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="status_label">Status</th>
                                        <th class="warehouse_label">Warehouse</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                 @if(isset($items) && count($items) > 0)
                                    @foreach($items as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td class="invoice_id_value">{{ $item->invoice_no }}</td>
                                            <td class="order_id_value">{{ isset($item->sales_order->order_no) ? $item->sales_order->order_no : '' }}</td>
                                            <td class="customer_name_value">{{ isset($item->customers->ledger_name) ? $item->customers->ledger_name : '' }}</td>
                                            <td class="sales_person_value">{{ isset($item->sales_person->name) ? $item->sales_person->name : '' }}</td>
                                            <td class="branch_name_value">{!! (isset($item->branch)) ? $item->branch->branch_name : $item->main_branch !!}</td>
                                            <td class="required_date_value">{{ $item->required_date }}</td>
                                            <td class="date_value">{{ $item->updated_at }}</td>
                                            <td class="edit_value">{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                            <td class="status_value">{{ (isset($item->payment_status) && $invoice_status[$item->payment_status]) ? $invoice_status[$item->payment_status] : '' }}</td>
                                            <td class="warehouse_value">{{isset($item->target_warehouse->name) ? $item->target_warehouse->name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('sales-invoice.show'))
                                                        <li>
                                                            <a href="{{ route('sales-invoice.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                    @endif
                                                    @if(\Helper::userHasPageAccess('sales-invoice.edit'))
                                                        {{-- <li>
                                                            <a href="{{ route('sales-invoice.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li> --}}
                                                        <li>
                                                            {!! Form::open(['url' => route('sales-invoice.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                <button type="submit" class="confirm-action btn btn-danger"><i class="fas fa-trash"></i></button>
                                                            {!! Form::close(); !!}
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('sales-invoice.print', $item->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
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
         $('body').on('click','.select_field',function(){
            $('.field_list').toggle();
        });
         $('body').on('click','.invoice_id',function(){
            if($(this).is(":checked")){
                $('.invoice_id_value').show();
                $('.invoice_id_label').show();
            }
            else{
              $('.invoice_id_value').hide();
              $('.invoice_id_label').hide();       
            }
        });
         $('body').on('click','.order_id',function(){
            if($(this).is(":checked")){
                $('.order_id_value').show();
                $('.order_id_label').show();
            }
            else{
              $('.order_id_value').hide();
              $('.order_id_label').hide();       
            }
        });
         $('body').on('click','.customer_name',function(){
            if($(this).is(":checked")){
                $('.customer_name_value').show();
                $('.customer_name_label').show();
            }
            else{
              $('.customer_name_value').hide();
              $('.customer_name_label').hide();       
            }
        });
         $('body').on('click','.sales_person',function(){
            if($(this).is(":checked")){
                $('.sales_person_value').show();
                $('.sales_person_label').show();
            }
            else{
              $('.sales_person_value').hide();
              $('.sales_person_label').hide();       
            }
        });
         $('body').on('click','.branch_name',function(){
            if($(this).is(":checked")){
                $('.branch_name_value').show();
                $('.branch_name_label').show();
            }
            else{
              $('.branch_name_value').hide();
              $('.branch_name_label').hide();       
            }
        });
         $('body').on('click','.required_date',function(){
            if($(this).is(":checked")){
                $('.required_date_value').show();
                $('.required_date_label').show();
            }
            else{
              $('.required_date_value').hide();
              $('.required_date_label').hide();       
            }
        });
         $('body').on('click','.date',function(){
            if($(this).is(":checked")){
                $('.date_value').show();
                $('.date_label').show();
            }
            else{
              $('.date_value').hide();
              $('.date_label').hide();       
            }
        });
         $('body').on('click','.edit',function(){
            if($(this).is(":checked")){
                $('.edit_value').show();
                $('.edit_label').show();
            }
            else{
              $('.edit_value').hide();
              $('.edit_label').hide();       
            }
        });
         $('body').on('click','.status',function(){
            if($(this).is(":checked")){
                $('.status_value').show();
                $('.status_label').show();
            }
            else{
              $('.status_value').hide();
              $('.status_label').hide();       
            }
        });
         $('body').on('click','.warehouse',function(){
            if($(this).is(":checked")){
                $('.warehouse_value').show();
                $('.warehouse_label').show();
            }
            else{
              $('.warehouse_value').hide();
              $('.warehouse_label').hide();       
            }
        });
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
                                    return 'Invoice Id';
                                }
                                else if(columnIdx==2){
                                return 'Order Id';
                                }
                                else if(columnIdx==3){
                                return 'Customer Name';
                                }
                                else if(columnIdx==4){
                                return 'Sales Person';
                                }
                                else if(columnIdx==5){
                                return 'Branch Name';
                                }
                                else if(columnIdx==6){
                                return 'Required Date';
                                }
                                else if(columnIdx==7){
                                return 'Date';
                                }
                                else if(columnIdx==8){
                                return 'Edited By';
                                }
                                else if(columnIdx==9){
                                return 'Status';
                                }
                                else if(columnIdx==10){
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
    });
</script>
@endsection
