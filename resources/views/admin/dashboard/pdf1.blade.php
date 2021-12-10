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
    <section class="certificate-block">
        <div class="top-header">
            <img src="{{ public_path('images/certificate_pdf_1.jpg') }}">
        </div>
        <div class="content">
            <div class="content-block-1">
                <div class="title">Certificate of Analysis</div>
                <div class="description-block">
                    <div class="inline-block side-block">
                        <p>
                            <div class="inline-block">Product Name:</div>
                            <div class="inline-block">Acetone HP</div>
                        </p>
                        <p>
                            <div class="inline-block">Grade:</div>
                            <div class="inline-block">HP (High Purity)</div>
                        </p>
                        <p>
                            <div class="inline-block">Molecular Formula:</div>
                            <div class="inline-block">(CH3)2CO</div>
                        </p>
                        <p>
                            <div class="inline-block">Batch No.:</div>
                            <div class="inline-block">100.19P001</div>
                        </p>
                        <p>
                            <div class="inline-block">Spec.No.</div>
                            <div class="inline-block">100.S.HP (Rev.00)</div>
                        </p>
                        <p>
                            <div class="inline-block">Manufacturing date:</div>
                            <div class="inline-block">January 2019</div>
                        </p>
                    </div>
                    <div class="inline-block side-block">
                        <p>
                            <div class="inline-block">CASR No.</div>
                            <div class="inline-block">[67-64-1]</div>
                        </p>
                        <p>
                            <div class="inline-block">Molecular Weight:</div>
                            <div class="inline-block">58.08</div>
                        </p>
                        <p>
                            <div class="inline-block">Batch Size:</div>
                            <div class="inline-block">400 Ltr</div>
                        </p>
                        <p>
                            <div class="inline-block">A.R.No.</div>
                            <div class="inline-block">ARP190001</div>
                        </p>
                        <p>
                            <div class="inline-block">Retest date:</div>
                            <div class="inline-block">December 2023</div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="content-block-2">
                <div class="title-type-1">CHARACTERS:</div>
                <div class="description-block">
                    <p>Appearance: A clear colourless liquid with characteristic odour.</p>
                    <p>Miscibility: Miscible with water forming clear colourless solution.</p>
                </div>
            </div>
            <div class="content-block-3">
                <div class="title-type-1">TESTS:</div>
                <table>
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Tests</th>
                            <th>Acceptance criteria</th>
                            <th>Test Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01.</td>
                            <td>Wt. per ml (20°C)</td>
                            <td>Between 0.788 to 0.791 g</td>
                            <td>0.788 g</td>
                        </tr>
                        <tr>
                            <td>02.</td>
                            <td>Acidity (as acetic acid)</td>
                            <td>0.005% max</td>
                            <td>NMT 0.005%</td>
                        </tr>
                        <tr>
                            <td>03.</td>
                            <td>Non-volatile matter</td>
                            <td>0.005% max</td>
                            <td>0.003%</td>
                        </tr>
                        <tr>
                            <td>04.</td>
                            <td>Assay (By GC)</td>
                            <td>Min. 99.00%</td>
                            <td>99.98%</td>
                        </tr>
                        <tr>
                            <td>05.</td>
                            <td>Water content</td>
                            <td>0.30% max</td>
                            <td>0.18%</td>
                        </tr>
                    </tbody>
                </table>
                <p><b>Status:</b> The above batch material meets the above acceptance criteria.</p>
            </div>
            <div class="content-block-4">
                <div class="title-type-1">STORAGE CONDITION:</div>
                <ul>
                    <li>Stored in segregated, well ventilated and approved area.</li>
                </ul>
            </div>
            <div class="content-block-5">
                <div class="inline-block side-block">
                    <p><b>Prepared & checked by:</b></p>
                    <br>
                    <br>
                    <p>(In charge - Quality Control)</p>
                    <p>Date of batch release: 07th January 2019.</p>
                    <ul>
                        <li>Keep container tightly closed, away from heat.</li>
                    </ul>
                </div>
                <div class="inline-block side-block">
                    <p><b>Approved by:</b></p>
                    <br>
                    <br>
                    <p>Signature</p>
                    <p>(Head-Quality)</p>
                </div>
            </div>
            <div class="content-block-6">
                <table border="1">
                    <thead>
                        <tr>
                            <th>ADDITIONAL INFORMATION:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <br>
                                Refer our MSDS for safe handling of the product.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
