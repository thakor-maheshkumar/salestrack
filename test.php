<?php
$date = new DateTime();

$date->setISODate(2008, 2);
echo $date->format('Y-m-d') . "\n";

$date->setISODate(2008, 2, 7);
echo $date->format('Y-m-d') . "\n";
?>


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
                        <option value="">Select Group</option>
                        <option value="year">Year</option>
                        <option value="month">Month</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>

        </form>

</div>
<div id="columnchart_values" style="width: 900px; height: 300px;float: left;"></div>
<div id="yearly" style="width: 900px; height: 300px;float: left;"></div>


@endsection
@section('script')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawMonthlychart);
                 function drawMonthlychart(chart_data)
                  {
                    let jsondata=chart_data;

                    let sales=chart_data.salesOrder;
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'month',);
                    data.addColumn('number', 'Quantity or Price');
                    data.addRows([["",sales]]);
                    $.each(jsondata, (i,jsondata)=>{
                    let month=jsondata.month;
                    let profit = jsondata.quantity;

                    data.addRows([[month, profit]])
                    });
                    var data1 = new google.visualization.DataTable();
                    data1.addColumn('number', 'year',);
                    data1.addColumn('number', 'Quantity or Price');
                   // data1.addRows([["",sales]]);
                    $.each(jsondata, (i,jsondata)=>{
                    let year=jsondata.year;
                    let week=jsondata.week;
                    let created_date=jsondata.created_date;
                    alert(created_date);
                    let profit = jsondata.quantity;

                    data1.addRows([[year ?? week ?? created_date, profit]])
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
                    var chartbc = new google.visualization.ColumnChart(document.getElementById("yearly"));
                    chart.draw(data, options);
                    chartbc.draw(data1, options);
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
            }

        })

    });
   
            $('.end_date').change(function(){
                var groupByWeek=$('.groupBy').val();

                if(groupByWeek !="weekly"){
                    $('.groupBy').val('');
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
            
            /*$('.end_date').change(function(){
                var end=$('.end_date').val();
                var gr=$('.groupBy').val();
                 if(end && gr=="weekly"){
                     $('#yearly').show();
                     $('#columnchart_values').hide();
                }
            })
            $('.groupBy').change(function(){
                var end=$('.end_date').val();
                var gr=$('.groupBy').val();
                if(end || gr=="month"){
                    $('#yearly').hide();
                    $('#columnchart_values').show();
                }else{
                    $('#yearly').show();
                    $('#columnchart_values').hide();
                }
            });*/
            $('.end_date').change(function(){
                var end_date=$('.end_date').val();
                var groupBy=$('.groupBy').val();
                if(end_date && groupBy=="weekly"){
                    $('#columnchart_values').hide();
                    $('#yearly').show();
                }else if(end_date && groupBy==""){
                    $('#columnchart_values').show();
                    $('#yearly').hide();
                }
            });
            $('.groupBy').change(function(){
                var groupBy=$('.groupBy').val();
                var end_date=$('.end_date').val();
                if(end_date && groupBy=="weekly"){
                    $('#columnchart_values').hide();
                    $('#yearly').show();
                }else if(groupBy=="month"){
                    $('#columnchart_values').show();
                    $('#yearly').hide();
                }else if(groupBy=="year"){
                     $('#columnchart_values').hide();
                    $('#yearly').show();
                }
                //alert(groupBy);
            })
        })
</script>
@endsection



