<!DOCTYPE html>
<html>
<head>
    <title>Purchase Receipt</title>
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
    <main>
        <script type="text/php">
            if ( isset($pdf) ) {
                $x = 500;
                $y = 700;
                $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
                $font = $fontMetrics->get_font("helvetica", "bold");
                $size = 8;
                $color = array(255,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
        <h2>Good Receipt Note</h2>
        <section class="purchase-receipt">
            <div class="top-header">
                <div class="inline-block">
            <table border="1" style="width:700px">

            <tbody>
                @foreach(\App\Models\Company::all() as $cp)
                <tr>
                    <td colspan="7" width="100%" height="120"><img class="header-image" style="padding-bottom: 30px" height="120" width="200" src="{{ public_path("images/post_images/".$cp->logo_image) }}"></td>
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
                </div>
                
            </div>
            <div class="content">
                <div class="content-block-1">
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>Name of Material:</td>
                                <td class="even">{{ isset($purchaseReceipt->receipt_no) ? $purchaseReceipt->receipt_no : '' }}</td>
                                <td>Type:</td>
                                <td class="even"><span class="sqare-block"></span><span> RM, </span><span class="sqare-block"></span><span> PM</span></td>
                            </tr>
                            <tr>
                                <td>GRN No.:</td>
                                <td>&nbsp;</td>
                                <td>Date:</td>
                                <td>{{ isset($purchaseReceipt->created_at) ? $purchaseReceipt->created_at : '' }}</td>
                            </tr>
                            <tr>
                                <td>PO Reference:</td>
                                <td>{{ isset($purchaseReceipt->purchase_order->order_no) ? $purchaseReceipt->purchase_order->order_no : '' }}</td>
                                <td>PO Qty:</td>
                                <td>{{ isset($purchaseReceipt->purchase_items->po_quantity) ? $purchaseReceipt->purchase_items->po_quantity : '' }}</td>
                            </tr>
                            <tr>
                                <td>Receipt qty:</td>
                                <td>{{ isset($purchaseReceipt->purchase_items->receipt_quantity) ? $purchaseReceipt->purchase_items->receipt_quantity : '' }}</td>
                                <td>Nos of container:</td>
                                <td>{{ isset($purchaseReceipt->purchase_items->no_of_container) ? $purchaseReceipt->purchase_items->no_of_container : '' }}</td>
                            </tr>
                            <tr>
                                <td>Approved vendor code:</td>
                                <td>{{ isset($purchaseReceipt->approved_vendor_code) ? $purchaseReceipt->approved_vendor_code : '' }}</td>
                                <td>Any shortage/Excess Qty:</td>
                                <td>{{ isset($purchaseReceipt->shortage_qty) ? $purchaseReceipt->shortage_qty : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content-block-2">
                    <div class="title">GRN Checks:</div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Check Point</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1. All containers are good condition.</td>
                                <td>{{ (isset($purchaseReceipt->good_condition_container) && $purchaseReceipt->good_condition_container == 1) ? 'OK' : 'Not OK' }} </td>
                            </tr>
                            <tr>
                                <td>2. All containers have product name & grade</td>
                                <td>{{ (isset($purchaseReceipt->container_have_product) && $purchaseReceipt->container_have_product == 1) ? 'OK' : 'Not OK' }}</td>
                            </tr>
                            <tr>
                                <td>3. All containers are identified with B.No. & Tare weight</td>
                                <td>{{ (isset($purchaseReceipt->container_have_tare_weight) && $purchaseReceipt->container_have_tare_weight == 1) ? 'OK' : 'Not OK' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content-block-3">
                    <div class="title">Dedusting record:</div>
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>1. All containers are dedust with ...</td>
                                <td>{{ isset($purchaseReceipt->container_dedust_with) ? $purchaseReceipt->container_dedust_with : '' }}</td>
                            </tr>
                            <tr>
                                <td>2. Dedusting done by</td>
                                <td>{{ isset($purchaseReceipt->dedust_done_by) ? $purchaseReceipt->dedust_done_by : '' }}</td>
                            </tr>
                            <tr>
                                <td>3. Dedusting check by</td>
                                <td>{{ isset($purchaseReceipt->dedust_check_by) ? $purchaseReceipt->dedust_check_by : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="content-block-4">
                    <div class="title">QC status of GRN : Released / Reject.</div>
                    <table border="1">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="inline-block">
                                        GRN Prepared by : 
                                    </div>
                                    <div class="inline-block">
                                        <p class="line"></p>
                                        <p>(Store)</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="inline-block">
                                        Sign of QC: 
                                    </div>
                                    <div class="inline-block">
                                        <p class="line"></p>
                                        <p>(Sign/Date)</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <br>
    <!-- <footer class="purchase-receipt"> -->
        <table border="1"  style="width:700px">
            <tbody>
                <tr>
                    <td>Format No.:{{ isset($purchaseReceipt->receipt_no) ? $purchaseReceipt->receipt_no : '' }}</td>
                    <td>Effective Date: {{ date('Y-m-d') }}</td>
                    <td><div class="pagenum-container">Page <span class="pagenum"></span></div></td>
                </tr>
            </tbody>
        </table>
   <!--  </footer> -->
</body>
</html>
