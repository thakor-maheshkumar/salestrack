@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
    <!-- Start: main-content -->
    <div class="content">
        <div class="row justify-content-between">
            <div class="col-md-auto">
                <h1 class="heading">Dashboard</h1>
            </div>
        </div>

<?php  
//if(DB::connection()->getDatabaseName()) {
//echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
//} 
//Purchase Order data by status.
$postat = DB::table('purchase_orders')
    ->select(['po_status',DB::raw('count(*)')])->groupBy('po_status')->get();
$zero=DB::table('purchase_orders')->where('po_status','0')->where('active',1)->count();
$one=DB::table('purchase_orders')->where('po_status','1')->where('active',1)->count();
$two=DB::table('purchase_orders')->where('po_status','2')->where('active',1)->count();
$three=DB::table('purchase_orders')->where('po_status','3')->where('active',1)->count();
//dd($three);
//print_r($postat);
//print_r($one);

//print_r($one);
//print_r($two);
//Sales Order Data by status wise

$pending=DB::table('sales_orders')->where('status','pending')->where('active',1)->count();
$delivered_not_billed=DB::table('sales_orders')->where('status','delivered_not_billed')->where('active',1)->count();
$billed_not_delivered=DB::table('sales_orders')->where('status','billed_not_delivered')->where('active',1)->count();
$completed=DB::table('sales_orders')->where('status','completed')->where('active',1)->count();

//print_r($postat);
//print_r($pending);
?>

     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);


    function drawChart() {


    /*  var data = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Platinum", 8, "#b87333"],
        ["Silver", 4, "silver"],
        ["Gold", 2, "gold"],
        ["Platinum", 5, "color: #e5e4e2"]
      ]); */
  var not_billed_or_received = <?php echo json_encode($zero); ?>;
  var received_not_billed = <?php echo json_encode($one); ?>;
  var billed_not_received = <?php echo json_encode($two); ?>;
  var ordered_billed = <?php echo json_encode($three); ?>;

  //Sales Order data by status
  var pending = <?php echo json_encode($pending); ?>;
  var delivered_not_billed = <?php echo json_encode($delivered_not_billed); ?>;
  var billed_not_delivered = <?php echo json_encode($billed_not_delivered); ?>;
   var completed = <?php echo json_encode($completed); ?>;




      var data = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Not billed or received", not_billed_or_received, "#b87333"],
        ["Received not billed", received_not_billed, "silver"],
        ["Billed not received", billed_not_received, "gold"],
        ["Ordered & Billed", ordered_billed, "blue"],
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Product order data by status",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

       //SalesOrder data by status
      var salesorderdata = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Pending", pending, "#b87333"],
        ["Delivered Not Billed", delivered_not_billed, "silver"],
        ["Billed Not Delivered", billed_not_delivered, "gold"],
         ["Completed", completed, "blue"],
        //["Platinum", 5, "color: #e5e4e2"]
      ]);

      var salesorderview = new google.visualization.DataView(salesorderdata);
      salesorderview.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var salesorderoptions = {
        title: "Sales order data by status",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
      var chart = new google.visualization.ColumnChart(document.getElementById("sales_order_columnchart_values"));
      chart.draw(salesorderview, salesorderoptions);
  }
  </script>
<!-- <div id="columnchart_values" style="width: 900px; height: 300px;"></div> -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="columnchart_values" ></div>
        </div>
        <div class="col-md-12">
            <div id="sales_order_columnchart_values" ></div>
        </div>
    </div>
</div>




        {{--
            <div class="row">
                <div class="link-block">
                    <ul>
                        <li>
                            <a href="{{ route('admin.download.pdf1') }}">PDF 1 Download</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.download.pdf2') }}">PDF 2 Download</a>
                        </li>
                    </ul>
                </div>
            </div>
        --}}
    </div>


    <!-- End: main-content -->


@endsection

