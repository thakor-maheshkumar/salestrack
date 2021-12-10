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

$postat = DB::table('purchase_orders')
    ->select(['po_status',DB::raw('count(*)')])->groupBy('po_status')->get();

print_r($postat);
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

      var data = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Platinum", 8, "#b87333"],
        ["Silver", 4, "silver"],
        ["Gold", 2, "gold"],
        ["Platinum", 5, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>




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

