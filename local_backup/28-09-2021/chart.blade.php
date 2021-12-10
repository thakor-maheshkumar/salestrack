@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
     
      </script>
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
                    <select class="form-control stock_item_id select2" name="stock_item_id" id="select2">
                    <option value="">Select Stock Item</option>
                    @foreach(\App\Models\StockItem::where('active',1)->get() as  $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control price" name="price" id="select2">
                        <option value="Select Option">Select Option</option>
                        <option value="price">Price</option>
                        <option value="quantity">Quantity</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="start_date" class="form-control start_date datepicker" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" name="end_date" class="form-control end_date datepicker" placeholder="End Date" id="select2">
                </div>
                <div class="col-md-3">
                    <select class="form-control groupBy" name="groupby" id="select2">
                        <option value="Select Option">Select Group</option>
                        <option value="year">Year</option>
                        <option value="month">Month</option>
                        <option value="weekly">Weekly</option>
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
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>

        </form>
        <div>
            
             <?php
            $sales=$salesOrder ?? '';
            print_r($sales);
            ?>
         
        </div>
        

</div>
<div id="columnchart_values" style="width: 900px; height: 300px;float: left;"></div>
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
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawMonthlychart);
                 function drawMonthlychart(chart_data)
                  {
                    let jsondata=chart_data;
                    
                    var data = new google.visualization.DataTable();
                   
                    data.addColumn('string', 'year');
                    
                    data.addColumn('number', 'Quantity or Price');

                    $.each(jsondata, (i,jsondata)=>{
                    let month=jsondata.month;
                    let profit = parseFloat($.trim(jsondata.quantity));
                    
                    data.addRows([[month,profit]])
                     
                    });


                     var options = {
                        title:'Monthly or yearly quantity or price data',
                        
                          /*hAxis: {
                          title:"Months"
                        },*/
                        vAxis: {
                          title:'Profit' 
                        },
                        colors:['#b87333'],
                        chartArea:{
                          width:'50%',
                          height:'80%',
                        },
                        bar:{
                            groupWidth: 50
                        }
                       };

                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                    chart.draw(data, options);
                }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('change','#select2',function(){
            var groupBy=$('.groupBy').val();
            
            var start_date=$('.start_date').val();
            var end_date=$('.end_date').val();
            var stock_item_id=$('.stock_item_id').val();
            var price=$('.price').val();
            //alert('hello');
            //var title="test";
            //var year='kk';

            // const tem_title=title +''+year;
            
            
            $.ajax({
                url:'{{url("admin/stockitemdata")}}',
                type:'post',
                data:
                    {
                    start_date:start_date,
                    end_date:end_date,
                    groupby:groupBy,
                    stock_item_id:stock_item_id,
                    price:price,
                    _token: '{{csrf_token()}}'
                   },
                    dataType:"Json",
                    success:function(data){
                    console.log(data);
                    drawMonthlychart(data);
                    
                   
                    
                   /* google.charts.load("current", {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);*/

            }

        })

    });
        
    $('body').on('change','#select2',function(){
            var test="test";
            var groupBy=$('.groupBy').val();
            var end_date=$('.end_date').val();
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
                    var not_billed_or_received=data.salesOrder;                
                    google.charts.load("current", {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

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
                            chartArea:{
                            width:'50%',
                            height:'80%',
                            },
                            bar: {
                            groupWidth: 50
                            }


                           //bar: {groupWidth: "30%"},
                        };
                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                            chart.draw(view, options);
                        }
                    }

                })
            });
            $('.end_date').change(function(){
                var groupByWeek=$('.groupBy').val();

                if(groupByWeek !="weekly"){
                    $('groupBy').val('');
                }
            })
            $('.groupBy').change(function(){
                var week=$(this).val();
                //alert(test);
                if(week !="weekly"){
                    $('.start_date').val("");
                    $('.end_date').val("");     
                }
               
            })
        })
</script>
@endsection



