<!DOCTYPE html>
<html>

<head>
    <title>Purchase Invoice</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
</head>
<body>
    <section class="pdf-block">
        {{--<div class="top-header">
            <img src="{{ public_path('images/certificate_pdf_1.jpg') }}">
        </div>--}}
        <table border="1">
            <tbody>
                @foreach(\App\Models\Company::all() as $cp)
                <tr>
                    <td colspan="7" width="100%"><img class="header-image" height="150" width="200" src="{{ public_path("images/post_images/".$cp->logo_image) }}"></td>
                </tr>
                <div class="test" style="position: absolute;color: black; padding-left: 220px;">
                {{$cp->name}}<br>
                {{$cp->address}},{{$cp->street}},{{$cp->landmark}}<br>
                {{$cp->city}}-{{$cp->zipcode}},{{$cp->state}},{{$cp->country->name}}<br>
                Phone:{{$cp->phone}} Email:{{$cp->email}}<br>
                Website:{{$cp->website}}<br>
                </div>
                @endforeach
            </tbody>
        </table>
        <table border="1" class="main-table" style="width:680px">
            <tbody>
                <!-- <tr>
                    <td colspan="7" width="100%"><img class="header-image" src="{{ public_path('images/certificate_pdf_1.jpg') }}" height="150" width="720"></td>
                </tr> -->
                <tr>
                    <td colspan="4" class="no-border-r"><b>GSTIN: 24AAECE3336Q1ZE</b></td>
                    <td colspan="3" class="no-border-l"><b>PAN:AAECE3336Q</b></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Purchase Invoice</b></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p><b>Purchase Invoice No :  {{ isset($purchaseInvoice->invoice_no) ? $purchaseInvoice->invoice_no : '' }}</b></p>
                        
                        <p><b>PO Ref  No :  {{ isset($purchaseInvoice->purchase_order->order_no) ? $purchaseInvoice->purchase_order->order_no : '' }}</b></p>
                        <p><b>Invoice Date: {{ isset($purchaseInvoice->invoice_date) ? $purchaseInvoice->invoice_date : '' }}</b></p>
                        <p><b>Supplier Name: {{ isset($purchaseInvoice->suppliers->ledger_name) ? $purchaseInvoice->suppliers->ledger_name : '' }}</b></p>
                        <p><b>Approved Vendor Code: {{ isset($purchaseInvoice->approved_vendor_code) ? $purchaseInvoice->approved_vendor_code : '' }}</b></p>
                        <p><b>Address: {{ isset($purchaseInvoice->address) ? $purchaseInvoice->address : '' }}</b></p>

                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p><b>Supplier Ref.:</b></p>
                        <p><b>R.R.INNOVATIVE PVT LTD</b></p>
                        <p>Kanmoor House</p>
                        <p>B-9/10, Ground Floor,</p>
                        <p>281/87, Narshi Natha Street,</p>
                        <p>Mumbai 400 009.  (Ph.)022-61207777</p>
                    </td>
                </tr>
                <tr>
                    <td align="center" width="1%"><b>Sr No</b></td>
                    <td align="center" width="48%"><b>ITEM</b></td>
                    <td align="center" width="10%"><b>Expct. Date</b></td>
                    <td align="center" width="10%"><b>PO QTY</b></td>
                    <td align="center" width="10%"><b>Unit</b></td>
                    <td align="center" width="10%"><b>Unit Rate Per Unit</b></td>
                    <td align="center" width="10%"><b>Amount</b></td>
                </tr>
                @if(isset($purchaseInvoice->items) && $purchaseInvoice->items->isNotEmpty())
                    @php
                        $i = 1;
                    @endphp
                    @foreach($purchaseInvoice->items as $key => $item)
                        <tr>
                            <td align="center">{{ $i }}</td>
                            <td>{{ isset($item->stock_items->name) ? $item->stock_items->name : '' }}</td>
                            <td>{{$purchaseInvoice->required_date}}</td>
                            <td>{{ isset($item->quantity) ? $item->quantity : '' }}</td>
                            <td>{{ isset($item->unit) ? $item->unit : '' }}</td>
                            <td>{{ isset($item->rate) ? $item->rate : '' }}</td>
                            <td align="right">{{ isset($item->net_amount) ? $item->net_amount : '0.00' }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @else
                    <tr>
                        <td align="center">1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right">0.00</td>
                    </tr>
                @endif
                <tr>
                    <td rowspan="6" colspan="1"></td>
                    <td rowspan="6" colspan="1"></td>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="no-border-b">DISCOUNT</td>
                    @php
                   $remain = ((int)$item->net_amount - (int)$purchaseInvoice->items->get(0)->discount);
                    @endphp
                    <td align="right">{{ isset($purchaseInvoice->items->get(0)->discount_in_per) ? $purchaseInvoice->items->get(0)->discount_in_per : '0.00' }}%</td>
                    <td align="right">{{ isset($purchaseInvoice->items->get(0)->discount) ? $purchaseInvoice->items->get(0)->discount: '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>TOTAL</b></td>
                    <td align="right"><b>{{$remain}}</b></td>
                </tr>
                @php
                    $state=\App\Models\Company::all();
                @endphp
                <tr>
                    @php
                    $sgst=((int)$purchaseInvoice->items->get(0)->tax/2)
                    @endphp
                    <td colspan="3" align="right" class="no-border-b">SGST</td>
                    @foreach($state as $key=>$value)
                    @if($value->state==$purchaseInvoice->state)
                    <td align="right">{{$sgst}}%</td>
                    @else
                    <td align="right">0</td>
                    @endif
                    @endforeach
                    <td align="right">{{ isset($purchaseInvoice->sgst) ? $purchaseInvoice->sgst : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="no-border-b no-border-t">CGST</td>
                    @foreach($state as $key=>$value)
                    @if($value->state==$purchaseInvoice->state)
                    <td align="right">{{$sgst}}%</td>
                    @else
                    <td align="right">0</td>
                    @endif
                    @endforeach
                    <td align="right">{{ isset($purchaseInvoice->cgst) ? $purchaseInvoice->cgst : '0.00' }}</td>
                </tr>
                <tr>
                    
                    <td colspan="3" align="right" class="no-border-t">IGST</td>
                    @foreach($state as $key=>$value)
                    @if($value->state==$purchaseInvoice->state)
                    <td align="right">0%</td>
                    @else
                    <td align="right">{{$purchaseInvoice->items->get(0)->tax}}%</td>                    
                    @endif
                    @endforeach
                    <td align="right">{{ isset($purchaseInvoice->igst) ? $purchaseInvoice->igst : '0.00' }}.00</td>
                </tr>
                <tr>
                    <td colspan="6" align="right">TOTAL AMOUNT</td>
                    <td align="right">{{$purchaseInvoice->items->get(0)->total_amount}}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="4" align="right">FREIGHT</td>
                    <td align="right">{{$purchaseInvoice->total_other_net_amount}}</td>
                </tr>
                <tr>
                    <td colspan="2"><b>Credit Days: {{ isset($purchaseInvoice->credit_days) ? $purchaseInvoice->credit_days : 0 }} Days PDC</b></td>
                    <td colspan="4" align="right"><b>TOTAL GROSS AMOUNT (Rs.)</b></td>
                    <td align="right"><b>{{ isset($purchaseInvoice->grand_total) ? $purchaseInvoice->grand_total : '0.00' }}</b></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p><b>Delivery : at {{ isset($purchaseInvoice->target_warehouse->name) ? ' ' . $purchaseInvoice->target_warehouse->name : '' }}</b></p>
                        <p><b>Transpoter : {{ isset($purchaseInvoice->transporter) ? $purchaseInvoice->transporter : '' }}</b></p>
                        <p><b>Reference  : {{ isset($purchaseInvoice->reference) ? $purchaseInvoice->reference : '' }}</b></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <b><u>Terms And Condition</u></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">1) IMP NOTE:-</p>
                        <p>I)The Supply Should Be Accompanied With Manufacturers Test Certificate'S Enable Us To Pass Your Bill For Payment.</p>
                        <p>ii) Please Clearly Indicate Our Purchase Order No And Date On Your Invoice,Delivery Challan And All Correspondence.</p>
                        <p>iii)Please Mention Item Code And  Description On The Invoice And Challan Same As Mentioned In The Purchase Order.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">2) Material To Be Invoiced At The Given Below Address:</p>
                        <p><b>EXPRESOLV PVT. LTD.</b></p>
                        <p><b>17,RJD Industrial Estate</b></p>
                        <p><b>Nr. Aarvee Denim, Narol Cross Road</b></p>
                        <p><b>Narol Ahmedabad-382405,</b></p>
                        <p><b>Tel.: (079) 26569988/26409988</b></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">3) Material To Delivered At The Given Below Address (Consignee Address):</p>
                        <p><b>EXPRESOLV PVT. LTD.</b></p>
                        <p><b>17,RJD Industrial Estate</b></p>
                        <p><b>Nr. Aarvee Denim, Narol Cross Road</b></p>
                        <p><b>Narol Ahmedabad-382405,</b></p>
                        <p><b>Tel.: (079) 26569988/26409988</b></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">4) Taxes & Duties</p>
                        <p>A) Sales Tax / GST : IGST 18% Extra as applicable.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">5) Inspection : By Our Quality Control At Our Works On Receipt Of Material.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">6) Insurance :</p>
                        <p>I)To Be Covered By Buyer.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">7) Packaging And Forwarding Charges: Included In Basic Unit Rate.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">8) Payment Terms: </p>
                        <p>I) Payment : 60 Days PDC from the Date of receipt of Materials</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">9) Freight : </p>
                        <p>I)freight extra at actual will be paid by Us.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">10) Delivery Schedule:</p>
                        <p>I)Please Dispatch The Material As Per The Schedule Given In The Purchase Order.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">11) Rejection Clause: Material Will Be Rejected By Us If It Does Not Meet As Per Our Requirement/Specs With No Additional Cost To Us Within 2 Days.And same will be replace by you without any additional cost to us. </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">12) Tax  Details</p>
                        <p>1.GSTIN: 24AAECE3336Q1ZE</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-1">13) Transit Loss / Excess(For Bulk Chemical)      Not Applicable</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">14) Documents Required:</p>
                        <p>I)Original Invoice</p>
                        <p>II)Copy Of Delivery Challan</p>
                        <p>III)Copy Of Lorry Receipt</p>
                        <p>IV)Material Test Certificate.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t no-border-b">
                        <p class="title-type-2">15) Jurisdiction / Dispute Resolution:</p>
                        <p>In Case Of Any Disputes, The Final Authority For Any Dispute Resolution Shall Be The Managing Director Of  Our Organization . Court of  jurisdiction will be Ahmedabad , Gujarat.</p>
                        <p class="title-type-1"><b>NOTE :</b></p>
                        <p><b>[1] CERTIFICATE OF ANALYSIS (C.O.A) & M.S.D.S REQUIRED ALONG WITH SUPPLY ONLY. </b></p>
                        <p><b>[2]. 80% Retest/Expiry period should be available at the time of receipt of material,Packing must be intact and of original manufacturer</b></p>
                        <p><b>[3] DESPATCH BY ROAD-  SAURASHTRA ROADWAYS, BOOKING AT NAROL <br> 20-Bgt A Coumpound, Anjur Phata, Nr. Railway Bridge <br> BHIWANDI-421302,  (M) 9594328000/9323596498</b></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="empty-block no-border-t no-border-b"></td>
                </tr>
                <tr class="signature-block">
                    <!-- <td colspan="4" class="no-border-tr"><b>Prepared By/Check By:</b></td>
                    <td colspan="3" class="no-border-tl"><b>Approved By (Director)</b></td> -->
                    <td class="no-border-tr no-border-b"></td>
                    <td colspan="2" class="no-border-ltr no-border-b"><b>Prepared By/Check By:</b></td>
                    <td class="no-border-ltr no-border-b"></td>
                    <td colspan="2" class="no-border-ltr no-border-b" align="right"><b>Approved By (Director)</b></td>
                    <td class="no-border-tl no-border-b"></td>
                </tr>
                <tr>
                    <td colspan="7" class="no-border-t" height="20"></td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>
