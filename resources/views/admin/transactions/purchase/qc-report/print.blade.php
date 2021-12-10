<!DOCTYPE html>
<html>

<head>
    <title>QC Report</title>
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
                    <table border="1" width="100%">
                        <tbody>
                            <tr>
                                <td>Product Name:</td>
                                <td colspan="3">{{ isset($qc_report->product_name) ? $qc_report->product_name : '' }}</td>
                            </tr>
                            <tr>
                                <td>Grade:</td>
                                <td>{{ isset($qc_report->grades->grade_name) ? $qc_report->grades->grade_name : '' }}</td>
                                <td>CASR No.</td>
                                <td>{{ isset($qc_report->qc->casr_no) ? '[' . $qc_report->qc->casr_no . ']' : '' }}</td>
                            </tr>
                            <tr>
                                <td>Molecular Formula:</td>
                                <td>{{ isset($qc_report->qc->molecular_formula) ? $qc_report->qc->molecular_formula : '' }}</td>
                                <td>Molecular Weight:</td>
                                <td>{{ isset($qc_report->qc->molecular_weight) ? $qc_report->qc->molecular_weight : '' }}</td>
                            </tr>
                            <tr>
                                <td>Batch No.:</td>
                                <td>{{ isset($qc_report->batch->batch_id) ? $qc_report->batch->batch_id : '' }}</td>
                                <td>Batch Size:</td>
                                <td>{{ isset($qc_report->batch->batch_size) ? $qc_report->batch->batch_size : '' }}</td>
                            </tr>
                            <tr>
                                <td>Spec.No.</td>
                                <td>{{ isset($qc_report->qc->spec_no) ? $qc_report->qc->spec_no : '' }}</td>
                                <td>A.R.No.</td>
                                <td>{{ isset($qc_report->ar_no) ? $qc_report->ar_no : '' }}</td>
                            </tr>
                            <tr>
                                <td>Manufacturing date: </td>
                                <td>{{ (isset($qc_report->batch->manufacturing_date) && checkIsAValidDate($qc_report->batch->manufacturing_date)) ? \Carbon\Carbon::parse($qc_report->batch->manufacturing_date)->format('F Y') : '' }}</td>
                                <td>Retest date:</td>
                                <td>{{ (isset($qc_report->reset_date) && checkIsAValidDate($qc_report->reset_date)) ? \Carbon\Carbon::parse($qc_report->reset_date)->format('F Y') : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content-block-2">
                <div class="title-type-1">CHARACTERS:</div>
                <div class="description-block">
                    {{ isset($qc_report->qc->characters) ? $qc_report->qc->characters : '' }}
                </div>
            </div>
            <div class="content-block-3">
                <div class="title-type-1">TESTS:</div>
                <table class="tests-block">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Tests</th>
                            <th>Acceptance criteria</th>
                            <th>Test Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($qc_report->qc_test_reports) && $qc_report->qc_test_reports->isNotEmpty())
                            @php
                                $count = 01;
                            @endphp
                            @foreach($qc_report->qc_test_reports as $key => $qc_item)
                                <tr>
                                    <td>{{ $count }}.</td>
                                    <td>{{ isset($qc_item->qc_test->tests) ? $qc_item->qc_test->tests : '' }}</td>
                                    <td>{{ isset($qc_item->qc_test->acceptance_criteria) ? $qc_item->qc_test->acceptance_criteria : '' }}</td>
                                    <td>{{ isset($qc_item->test_result) ? $qc_item->test_result : '' }}</td>
                                </tr>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <p><b>Status:</b> The above batch material meets the above acceptance criteria.</p>
            </div>
            <div class="content-block-4">
                <div class="title-type-1">STORAGE CONDITION:</div>
                <ul>
                    <li>{{ isset($qc_report->qc->storage_condition) ? $qc_report->qc->storage_condition : '' }}</li>
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
                                {{ isset($qc_report->remarks) ? $qc_report->remarks : '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
