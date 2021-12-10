<!DOCTYPE html>
<html>

<head>
    <title>PDF 1</title>
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
        <table border="1" class="main-table">
            <tbody>
                <tr>
                    <td colspan="7" width="100%"><img class="header-image" src="{{ public_path('images/certificate_pdf_1.jpg') }}" height="150" width="720"></td>
                </tr>
                <tr>
                    <td colspan="4" class="no-border-r"><b>GSTIN: 24AAECE3336Q1ZE</b></td>
                    <td colspan="3" class="no-border-l"><b>PAN:AAECE3336Q</b></td>
                </tr>
                <tr>
                    <td colspan="7" align="center"><b>Purchase Order</b></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p><b>PO Ref  No :  EX /138/ 2019-20</b></p>
                        <p><b>Date:22.10.2019</b></p>
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
                <tr>
                    <td align="center">1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td rowspan="6" colspan="1"></td>
                    <td rowspan="6" colspan="1"></td>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td colspan="4" align="right"><b>TOTAL</b></td>
                    <td align="right"><b>0.00</b></td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="no-border-b">SGST</td>
                    <td align="right">0.00%</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="no-border-b no-border-t">CGST</td>
                    <td align="right">0.00%</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="no-border-t">IGST</td>
                    <td align="right">18.00%</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td colspan="4" align="right">TOTAL AMOUNT</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="4" align="right">FREIGHT</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td colspan="2"><b>Credit Days: 60 Days PDC</b></td>
                    <td colspan="4" align="right"><b>TOTAL GROSS AMOUNT (Rs.)</b></td>
                    <td align="right"><b>0.00</b></td>
                </tr>
                <tr>
                    <td colspan="7">
                        <p><b>Delivery :  at transporter godown</b></p>
                        <p><b>Transpoter :   SAURASHTRA ROADWAYS, BOOKING AT NAROL</b></p>
                        <p><b>Reference  : RAJ DOSHI</b></p>
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
