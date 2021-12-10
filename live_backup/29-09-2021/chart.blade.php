@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
<div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-auto">
                <h1 class="heading">Dashboard</h1>
            </div>
        </div>
        <form method="post" action="{{route('stockitem.data')}}">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select class="form-control stock_item_id select2" name="stock_item_id">
                    <option value="">Select Stock Item</option>
                    @foreach(\App\Models\StockItem::where('active',1)->get() as  $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control price" name="price">
                        <option value="Select Option">Select Option</option>
                        <option value="price">Price</option>
                        <option value="quantity">Quantity</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="start_date" class="form-control start_date datepicker" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" name="end_date" class="form-control end_date datepicker" placeholder="End Date">
                </div>
                <div class="col-md-3">
                    <select class="form-control groupBy" name="groupby">
                        <option value="Select Option">Select Group</option>
                        <option value="year">Year</option>
                        <option value="month">Month</option>
                    </select>
                </div>
                <!-- <div class="col-md-3">
                    <select class="form-control year" name="year" style="display:none">
                        <option value="Select Option">Select Year</option>
                        <option value=2019>2019</option>
                        <option value=2021>2021</option>
                        <option value=2020>2020</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control newyear" name="newyear" style="display:none">
                        <option value="Select Option">Select Year</option>
                        <option value=2019>2019</option>
                        <option value=2021>2021</option>
                        <option value=2020>2020</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control month" name="month" style="display:none">
                        <option value="Select Option">Select Current Year Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="5">May</option>
                    </select>
                </div> -->
                
               <!--  <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div> -->
            </div>

        </form>
        <div>
            
             <?php
            $sales=$salesOrder ?? '';
            print_r($sales);
            ?>
         
        </div>  
        <div id="columnchart_values" style="width: 900px; height: 300px;float: left;"></div>

</div>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var not_billed_or_received = <?php echo json_encode($sales); ?>;
        //var test =data.salesOrder;
        var data = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Not Billed or Received", not_billed_or_received, "#b87333"],
        /*["Ordered & Billed", three, "color: #e5e4e2"]*/
      ]);
        var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Data based on price Or Quantity",
        width: 400,
        height: 400,
        bar: {groupWidth: "30%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
    }
    
</script> -->


@endsection
@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('change','.groupBy',function(){
            var groupBy=$(this).val();
            var stock_item_id=$('.stock_item_id').val();
            var price=$('.price').val();
            $.ajax({
                url:'{{url("admin/stockitemdata")}}',
                type:'post',
                data:
                    {
                       groupby:groupBy,
                       stock_item_id:stock_item_id,
                       price:price,
                       _token: '{{csrf_token()}}'
                   },
                    dataType:'json',
                    success:function(data){
                    console.log(data);
                    var not_billed_or_received=data.salesOrder;
                    $('.start_date').val('');
                    $('.end_date').val('');
                    console.log(not_billed_or_received);
                    google.charts.load("current", {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);11

                 function drawChart()
                  {
        
                    var data = google.visualization.arrayToDataTable([
                        ["Elements", "Density", { role: "style" } ],
                        ["Not Billed or Received", not_billed_or_received, "#b87333"],
                        ]);
                    var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                            { 
                                calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" 
                            },
                       2]);

                     var options = {
                        title: "Data based on price Or Quantity",
                        width: 400,
                        height: 400,
                        bar: {groupWidth: "30%"},
                        legend: { position: "none" },
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                    chart.draw(view, options);
                }
            }

        })

    });
        
    $('body').on('change','.end_date',function(){
            var end_date=$(this).val();
            var start_date=$('.start_date').val();
            var price=$('.price').val();
            var stock_item_id=$('.stock_item_id').val();
            $.ajax({
                    url:'{{url("admin/stockitemdata")}}',
                    type:'post',
                    data:{
                            start_date:start_date,
                            end_date:end_date,
                            stock_item_id:stock_item_id,
                            price:price,
                        _token: '{{csrf_token()}}'
                        },
                    dataType:'json',
                    success:function(data)
                    {
                    console.log(data);
                    var not_billed_or_received=data.salesOrder;
                    $('.groupBy').val(' ');
                    console.log(not_billed_or_received);
                    google.charts.load("current", {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);11

                        function drawChart() {
        
                        var data = google.visualization.arrayToDataTable([
                        ["Elements", "Density", { role: "style" } ],
                        ["Not Billed or Received", not_billed_or_received, "#b87333"],
        
                        ]);
                            var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                                { calc: "stringify",
                                sourceColumn: 1,
                                type: "string",
                                role: "annotation" 
                            },
                       2]);

                            var options = {
                            title: "Data based on price Or Quantity",
                            width: 400,
                            height: 400,
                            bar: {groupWidth: "30%"},
                            legend: { position: "none" },
                        };
                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                            chart.draw(view, options);
                        }
                    }

                })
            })

        })
</script>
@endsection