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
                
                
            </div>

        </form>
<div id="columnchart_values" style="width: 900px; height: 1000px;float: left;"></div>
<div id="yearly" style="width: 900px; height: 300px;float: left;"></div>


</div>



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
                    let year=jsondata.year;
                    let week=jsondata.week;
                    
                    /*let yearGetDate=jsondata.year;*/

                    var startDate=(4+(week-1)*7);
                    console.log(startDate);
                    var newStartDate=new Date(year,0,startDate);
                    console.log(newStartDate);
                    let dayStartDate=newStartDate.getDate();
                    let monthStartDate = newStartDate.getMonth()+1;
                    let yearStartDate = newStartDate.getFullYear();
                    let fullStartDate=(dayStartDate+"/"+monthStartDate+"/"+yearStartDate);
                    
                    var endDate=newStartDate;
                    endDate.setDate(endDate.getDate()+6);
                 
                    let dayEndDate=endDate.getDate();
                    let monthEndDate=endDate.getMonth()+1;
                    let yearEndDate=endDate.getFullYear();
                    let fullEndDate=(dayEndDate+"/"+monthEndDate+"/"+yearEndDate);
                    let fullStartEndDate=(fullStartDate+"-"+fullEndDate);
                    let yearDate=jsondata.yearData;

                    //alert(yearDate);
                   /* console.log(endDate);*/
                    data.addRows([[month ?? yearDate ?? fullStartEndDate, profit]])
                    });
                   

                     var options = {
                        title:'Monthly or yearly quantity or price data',
                        
                          hAxis: {
                            direction:-1,
                            slantedText:true,
                            slantedTextAngle:90 // here you can even use 180
                        },
                        vAxis: {
                          title:'Profit' ,
                        scaleType: 'log'
                        },
                        colors:['#b87333'],
                        chartArea:{
                          //width:'100%',
                          //height:'80%',
                          left:'10%',
                          bottom:'50%'
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
            
           
        })
</script>
@endsection



