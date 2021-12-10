@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'delivery_note'
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
                                <h2 class="mb-0">Delivery Note</h2>
                            </div>
                            <div class="col-12 text-right">
                                <button id="test"></button>
                                <a href="{{ $other->back_link }}" class="btn btn-primary">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-success">New Delivery Note</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                             <table id="group_table" class="table table-condensed">
                            <button class="btn btn-primary select_field">Select Field</button><br>
                            <div class="field_list" style="display:none">
                            <input type="checkbox" name="" class="delivery_no" checked> Delivery No<br>
                            <input type="checkbox" name="" class="sales_order" checked> Sales Order No<br>
                            <input type="checkbox" name="" class="customer_name" checked> Customer Name<br>
                            <input type="checkbox" name="" class="branch_name" checked>Branch Name<br>
                            <input type="checkbox" name="" class="required_date" checked> Required Date<br>
                            <input type="checkbox" name="" class="vendor_code" checked> Approved Vendor Code<br>
                            <input type="checkbox" name="" class="warehouse" checked>Warehouse<br>
                             </div>
                                <thead>
                                    <tr>
                                        <th class="delivery_no_label">Delivery No</th>
                                        <th class="sales_order_label">Sales Order No</th>
                                        <th class="customer_name_label">Customer Name</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="required_date_label">Required Date</th>
                                        <th class="vendor_code_label">Approved Vendor Code</th>
                                        <th class="warehouse_label">Warehouse</th>
                                        <th>Action</th>
                                    </tr>
                                   <!--  <tr>
                                        <th class="delivery_no_label">Delivery No</th>
                                        <th class="sales_order_label">Sales Order No</th>
                                        <th class="customer_name_label">Customer Name</th>
                                        <th class="branch_name_label">Branch Name</th>
                                        <th class="required_date_label">Required Date</th>
                                        <th class="vendor_code_label">Approved Vendor Code</th>
                                        <th class="warehouse_label">Warehouse</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                 @if(isset($delivery_notes) && count($delivery_notes) > 0)
                                    @foreach($delivery_notes as $key => $item)
                                        <tr>
                                            <td class="delivery_no_value">{{ $item->delivery_no }}</td>
                                            <td class="sales_order_value">{{ isset($item->sales_order->order_no) ? $item->sales_order->order_no : '' }}</td>
                                            <td class="customer_name_value">{{ isset($item->customers->ledger_name) ? $item->customers->ledger_name : '' }}</td>
                                            <td class="branch_name_value">{!! (isset($item->branch)) ? $item->branch->branch_name : $item->main_branch !!}</td>
                                            <td class="required_date_value">{{ $item->required_date }}</td>
                                            <td class="vendor_code_value">{{$item->approved_vendor_code}}</td>
                                            <td class="warehouse_value">{{isset($item->target_warehouse->name) ? $item->target_warehouse->name : '' }}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess('delivery-note.show'))
                                                        <li>
                                                            <a href="{{ route('delivery-note.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                    @endif
                                                    {{-- @if((! isset($item->sales_invoices)) || (isset($item->sales_invoices) && $item->sales_invoices->isEmpty())) --}}
                                                        @if(\Helper::userHasPageAccess('delivery-note.edit'))
                                                            <li>
                                                                <a href="{{ route('delivery-note.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                {!! Form::open(['url' => route('delivery-note.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                                    <button type="submit" class="confirm-action btn btn-danger"><i class="fas fa-trash"></i></button>
                                                                {!! Form::close(); !!}
                                                            </li>
                                                        @endif
                                                        {{-- @endif --}}
                                                      <li>
                                                        <a href="{{ route('delivery-note.print', $item->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                    </li>  
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">Note not found...</td>
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
    $('body').on('click','.delivery_no',function(){
            if($(this).is(":checked")){
                $('.delivery_no_value').show();
                $('.delivery_no_label').show();
            }
            else{
              $('.delivery_no_value').hide();
              $('.delivery_no_label').hide();       
            }
    });
    $('body').on('click','.sales_order',function(){
            if($(this).is(":checked")){
                $('.sales_order_value').show();
                $('.sales_order_label').show();
            }
            else{
              $('.sales_order_value').hide();
              $('.sales_order_label').hide();       
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
     $('body').on('click','.vendor_code',function(){
            if($(this).is(":checked")){
                $('.vendor_code_value').show();
                $('.vendor_code_label').show();
            }
            else{
              $('.vendor_code_value').hide();
              $('.vendor_code_label').hide();       
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
                                return 'Delivery No';
                                }
                                else if(columnIdx==1)
                                {
                                    return 'Sales Order No';
                                }
                                else if(columnIdx==2){
                                return 'Customer Name';
                                }
                                else if(columnIdx==3){
                                return 'Branch Name';
                                }
                                else if(columnIdx==4){
                                return 'Required Date';
                                }
                                else if(columnIdx==5){
                                return 'Approved Vendor Code';
                                }
                                else if(columnIdx==6){
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
                    'targets': [0,1,2,3,4,5,6,7], 
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
