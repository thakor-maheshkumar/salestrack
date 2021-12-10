@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_return'
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
                                <h2 class="mb-0">Purchase Return</h2>
                            </div>
                            <div class="col-12 text-right">
                                <button id="test"></button>
                                <a href="{{ $other->back_link }}" class="btn btn-primary">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-success">Create Purchase Return</a>
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
                                    <input type="checkbox" name="" class="series_id" checked> Series Id<br>
                                    <input type="checkbox" name="" class="supplier_name" checked> Supplier Name<br>
                                    <input type="checkbox" name="" class="return_no" checked> Return No<br>
                                    <input type="checkbox" name="" class="invoice_no" checked> Invoice No<br>
                                    <input type="checkbox" name="" class="return_date" checked> Return Date<br>
                                    <input type="checkbox" name="" class="date" checked> Date<br>
                                    <input type="checkbox" name="" class="edit" checked> Edited By<br>
                                    <input type="checkbox" name="" class="vendor_code"> Vendor Code<br>
                                    <input type="checkbox" name="" class="warehouse"> WareHouse<br>
                                </div>
                                <thead>
                                    <tr>
                                        <th style="display:none"></th>
                                        <th class="series_id_label">Series ID</th>
                                        <th class="supplier_name_label">Supplier Name</th>
                                        <th class="return_no_label">Return No</th>
                                        <th class="invoice_no_label">Invoice No</th>
                                        <th class="return_date_label">Return Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="vendor_code_label" style="display:none">Approved Vendor Code</th>
                                        <th class="warehouse_label" style="display:none">Warehouse</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- <tr>
                                        <th style="display:none"></th>
                                        <th class="series_id_label">Series ID</th>
                                        <th class="supplier_name_label">Supplier Name</th>
                                        <th class="return_no_label">Return No</th>
                                        <th class="invoice_no_label">Invoice No</th>
                                        <th class="return_date_label">Return Date</th>
                                        <th class="date_label">Date</th>
                                        <th class="edit_label">Edited By</th>
                                        <th class="vendor_code_label" style="display:none">Approved Vendor Code</th>
                                        <th class="warehouse_label" style="display:none">Warehouse</th>
                                        <th>Action</th>
                                    </tr> -->
                                </thead>
                                <tbody>
                                    @if(isset($purchase_returns) && count($purchase_returns) > 0)
                                    @foreach($purchase_returns as $key => $item)
                                    <tr>
                                        <td style="display:none">{{ $item->id }}</td>
                                        <td class="series_id_value">{{ $item->id }}</td>
                                        <td class="supplier_name_value">{{ isset($item->suppliers->ledger_name) ? $item->suppliers->ledger_name : '' }}</td>
                                        <td class="return_no_value">{{ $item->return_no }}</td>
                                        <td class="invoice_no_value">{{$item->invoice->invoice_no}}</td>
                                        <td class="return_date_value">{{ $item->return_date }}</td>
                                        <td class="date_value">{{ $item->updated_at }}</td>
                                        <td class="edit_value">{{ isset($item->editedBy->first_name) ? $item->editedBy->first_name : '' }}</td>
                                        <td class="vendor_code_value" style="display:none">{{$item->approved_vendor_code}}</td>
                                        <td class="warehouse_value" style="display:none">{{isset($item->target_warehouse->name) ? $item->target_warehouse->name : '' }}</td>
                                        <td class="action--cell">
                                            <ul class="action--links">
                                                @if(\Helper::userHasPageAccess('purchase-return.show'))
                                                    <li>
                                                        <a href="{{ route('purchase-return.show', $item->id) }}" class="btn btn-gray"><i class="fas fa-eye"></i></a>
                                                    </li>
                                                @endif
                                                @if(\Helper::userHasPageAccess('purchase-return.edit'))
                                                    <li>
                                                        <a href="{{ route('purchase-return.edit', $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        {!! Form::open(['url' => route('purchase-return.destroy', $item->id), 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="confirm-action btn btn-danger"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close(); !!}
                                                    </li>
                                                @endif
                                                <li>
                                                            <a href="{{ route('purchase-return.print', $item->id) }}" class="btn btn-warning"><i class="fas fa-print"></i></a>
                                                        </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" align="center">Purchase Return not found...</td>
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
                $('.supplier_name_value').show();
                $('.supplier_name_label').show();
            }else{
              $('.supplier_name_value').hide();
              $('.supplier_name_label').hide();       
            }
        });
        $('body').on('click','.return_no',function(){
            if($(this).is(":checked")){
                $('.return_no_value').show();
                $('.return_no_label').show();
            }else{
              $('.return_no_value').hide();
              $('.return_no_label').hide();       
            }
        });
        $('body').on('click','.invoice_no',function(){
            if($(this).is(":checked")){
                $('.invoice_no_value').show();
                $('.invoice_no_label').show();
            }else{
              $('.invoice_no_value').hide();
              $('.invoice_no_label').hide();       
            }
        });
        $('body').on('click','.return_date',function(){
            if($(this).is(":checked")){
                $('.return_date_value').show();
                $('.return_date_label').show();
            }else{
              $('.return_date_value').hide();
              $('.return_date_label').hide();       
            }
        });
        $('body').on('click','.date',function(){
            if($(this).is(":checked")){
                $('.date_value').show();
                $('.date_label').show();
            }else{
              $('.date_value').hide();
              $('.date_label').hide();       
            }
        });
        $('body').on('click','.edit',function(){
            if($(this).is(":checked")){
                $('.edit_value').show();
                $('.edit_label').show();
            }else{
              $('.edit_value').hide();
              $('.edit_label').hide();       
            }
        });
        $('body').on('click','.vendor_code',function(){
            if($(this).is(":checked")){
                $('.vendor_code_value').show();
                $('.vendor_code_label').show();
            }else{
              $('.vendor_code_value').hide();
              $('.vendor_code_label').hide();       
            }
        });
        $('body').on('click','.warehouse',function(){
            if($(this).is(":checked")){
                $('.warehouse_value').show();
                $('.warehouse_label').show();
            }else{
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
                                return 'Series Id';
                                }
                                else if(columnIdx==1)
                                {
                                    return 'Series Id';
                                }
                                else if(columnIdx==2){
                                return 'Supplier Name';
                                }
                                else if(columnIdx==3){
                                return 'Return No';
                                }
                                else if(columnIdx==4){
                                return 'Invoice No';
                                }
                                else if(columnIdx==5){
                                return 'Retuen Date';
                                }
                                else if(columnIdx==6){
                                return 'Date';
                                }
                                else if(columnIdx==7){
                                return 'Edited By';
                                }
                                else if(columnIdx==8){
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
    });
</script>
@endsection