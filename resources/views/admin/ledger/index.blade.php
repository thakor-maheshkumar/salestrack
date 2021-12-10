@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'general_ledger'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                @include('common.messages')
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h2 class="mb-0">General Master List </h2>
                                <!-- <div class="col-md-12" id="importFrm" >
                                    <form action="{{route('general.import')}}" method="post" enctype="multipart/form-data">
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
                                 <form action="{{route('general.import')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <input type="file" name="file" required="" />
                                <input type="radio" name="import" checked="true"> Append
                                    <input type="radio" name="import" value="override"> Overide
                                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                                <button id="test"></button>
                                <a href="{{ $other->back_link }}" class="btn btn-large btn-primary btn-group-link">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-large btn-success btn-group-link">Add</a>
                                @endif
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            <table id="group_table" class="table datatable table-condensed">
                                <thead>
                                    
                                        <tr>
                                            <th></th>
                                            <th>Ledger Name</th>
                                            <th>Under</th>
                                            <th style="display:none">GST Reg Type</th>
                                            <th>GSTIN/UIN</th>
                                            <th style="display:none">GSTIN Applicable Date</th>
                                            <th>Party Type</th>
                                            <th style="display:none">Pan It No</th>
                                            <th style="display:none">Uid No</th>
                                            <th style="display:none">TDS Deductable</th>
                                            <th style="display:none">Include Assessable Value</th>
                                            <th style="display:none">Applicable</th>
                                            <th style="display:none">Address</th>
                                            <th style="display:none">City</th>
                                            <th style="display:none">State</th>
                                            <th style="display:none">Pincode</th>
                                            <th style="display:none">Location</th>
                                            <th style="display:none">Mobile No</th>
                                            <th style="display:none">Landline No</th>
                                            <th style="display:none">Fax No</th>
                                            <th style="display:none">Website</th>
                                            <th style="display:none">Email</th>
                                            <th style="display:none">CC Email</th>
                                            <th style="display:none">Consignee Address</th>
                                            <th style="display:none">Maintain Balance Bill By Bill</th>
                                            <th style="display:none">Default Credit Period</th>
                                            <th style="display:none">Default Credit Amount</th>
                                            <th style="display:none">Credit Days During Voucher Entry</th>
                                            <th style="display:none">Credit Amount During Voucher Entry</th>
                                            <th style="display:none">Active Interest Calculation</th>
                                            <th>Edit</th>
                                            <th>Delete</th>

                                        </tr>
                                        <!-- <tr>
                                           <th></th>
                                            <th>Ledger Name</th>
                                            <th>Under</th>
                                            <th style="display:none">GST Reg Type</th>
                                            <th>GSTIN/UIN</th>
                                            <th style="display:none">GSTIN Applicable Date</th>
                                            <th>Party Type</th>
                                            <th style="display:none">Pan It No</th>
                                            <th style="display:none">Uid No</th>
                                            <th style="display:none">TDS Deductable</th>
                                            <th style="display:none">Include Assessable Value</th>
                                            <th style="display:none">Applicable</th>
                                            <th style="display:none">Address</th>
                                            <th style="display:none">City</th>
                                            <th style="display:none">State</th>
                                            <th style="display:none">Pincode</th>
                                            <th style="display:none">Location</th>
                                            <th style="display:none">Mobile No</th>
                                            <th style="display:none">Landline No</th>
                                            <th style="display:none">Fax No</th>
                                            <th style="display:none">Website</th>
                                            <th style="display:none">Email</th>
                                            <th style="display:none">CC Email</th>
                                            <th style="display:none">Consignee Address</th>
                                            <th style="display:none">Maintain Balance Bill By Bill</th>
                                            <th style="display:none">Default Credit Period</th>
                                            <th style="display:none">Default Credit Amount</th>
                                            <th style="display:none">Credit Days During Voucher Entry</th>
                                            <th style="display:none">Credit Amount During Voucher Entry</th>
                                            <th style="display:none">Active Interest Calculation</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr> -->
                                    
                                </thead>
                                <tbody>
                                @if(isset($tablerow) && count($tablerow) > 0)
                                    @foreach($tablerow as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->ledger_name }}</td>
                                            <!-- <td>{{ $item->under }}</td> -->
                                            <td>{{$item->group->group_name}}</td>
                                            <td style="display:none">{{ $item->gst_reg_type }}</td>
                                            {{-- <td>{{ isset($item->territory) ? $item->territory->terretory_name : 'All' }}</td> --}}
                                            <td>{{ isset($item->gstin_uin) ? $item->gstin_uin : '' }}</td>
                                            <td style="display:none">{{$item->gstin_applicable_date}}</td>
                                            <td>{{ isset($partyType[$item->party_type]) ? $partyType[$item->party_type] : ''}}</td>
                                            <td style="display:none">{{$item->pan_it_no}}</td>
                                            <td style="display:none">{{$item->uid_no}}</td>
                                            <td style="display:none">{{$item->is_tds_deductable}}</td>
                                             <td style="display:none">{{$item->include_assessable_value}}</td>
                                             <td style="display:none">{{$item->applicable}}</td>
                                             <td style="display:none">{{$item->address}}</td>
                                             <td style="display:none">{{$item->city}}</td>
                                             <td style="display:none">{{$item->state}}</td>
                                             <td style="display:none">{{$item->pincode}}</td>
                                             <td style="display:none">{{$item->location}}</td>
                                             <td style="display:none">{{$item->mobile_no}}</td>
                                             <td style="display:none">{{$item->landline_no}}</td>
                                             <td style="display:none">{{$item->fax_no}}</td>
                                             <td style="display:none">{{$item->website}}</td>
                                             <td style="display:none">{{$item->email}}</td>
                                             <td style="display:none">{{$item->cc_email}}</td>
                                             <td style="display:none">{{$item->consignee_address}}</td>
                                             <td style="display:none">{{$item->maintain_balance_bill_by_bill}}</td>
                                             <td style="display:none">{{$item->default_credit_period}}</td>
                                             <td style="display:none">{{$item->default_credit_amount}}</td>
                                             <td style="display:none">{{$item->credit_days_during_voucher_entry}}</td>
                                             <td style="display:none">{{$item->credit_amount_during_voucher_entry}}</td>
                                             <td style="display:none">{{$item->active_interest_calculation}}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess($other->edit_link))
                                                        <li>
                                                            <a href="{{ route($other->edit_link, $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                @if(\Helper::userHasPageAccess($other->edit_link))
                                                    {!! Form::open(['url' => route($other->update_link, $item->id), 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                    {!! Form::close(); !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center">{!! __('messages.notfound', ['name' => $other->title]) !!}</td>
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
                $(this).html( '<input type="text" class="form-control" style="width:150px";"height:20px";"font-size:5px"; placeholder=" '+title+'" />' );
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
                    columns:[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29],
                    modifier: {
                    page: 'all'
                    },
                    //columns: ':visible',
                    format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==1)
                                {
                                    return 'Ledger Name';
                                }
                                else if(columnIdx==2){
                                return 'Under';
                                }
                                else if(columnIdx==3){
                                return 'GST Reg Type';
                                }
                                else if(columnIdx==4){
                                return 'GSTIN/UIN';
                                }
                                else if(columnIdx==5){
                                return 'GSTIN Applicable Date';
                                }
                                else if(columnIdx==6){
                                return 'Party Type';
                                }
                                else if(columnIdx==7){
                                return 'Pan It No';
                                }
                                else if(columnIdx==8){
                                return 'Uid No';
                                }
                                else if(columnIdx==9){
                                return 'TDS Deductable';
                                }
                                else if(columnIdx==10){
                                return 'Include Assessable Value';
                                }
                                else if(columnIdx==11){
                                return 'Applicable';
                                }
                                else if(columnIdx==12){
                                return 'Address';
                                }
                                else if(columnIdx==13){
                                return 'City';
                                }
                                else if(columnIdx==14){
                                return 'State';
                                }
                                else if(columnIdx==15){
                                return 'Pincode';
                                }
                                else if(columnIdx==16){
                                return 'Location';
                                }
                                else if(columnIdx==17){
                                return 'Mobile No';
                                }
                                else if(columnIdx==18){
                                return 'Landline No';
                                }
                                else if(columnIdx==19){
                                return 'Fax No';
                                }
                                else if(columnIdx==20){
                                return 'Website';
                                }
                                else if(columnIdx==21){
                                return 'Email';
                                }
                                else if(columnIdx==22){
                                return 'CC Email';
                                }
                                else if(columnIdx==23){
                                return 'Consignee Address';
                                }else if(columnIdx==24){
                                return 'Maintain Balance Bill By Bill';
                                }
                                else if(columnIdx==25){
                                return 'Default Credit Period';
                                }
                                else if(columnIdx==26){
                                return 'Default Credit Amount';
                                }
                                else if(columnIdx==27){
                                return 'Credit Days During Voucher Entry';
                                }
                                else if(columnIdx==28){
                                return 'Credit Amount During Voucher Entry';
                                }
                                else if(columnIdx==29){
                                return 'Active Interest Calculation';
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

