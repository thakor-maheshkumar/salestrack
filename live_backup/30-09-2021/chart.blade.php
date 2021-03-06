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
                    data.addColumn('string', 'year');
                    data.addColumn('number', 'Quantity or Price');
                    data.addRows([["",sales]]);
                    $.each(jsondata, (i,jsondata)=>{
                    let month=jsondata.month;
                    let profit = parseFloat($.trim(jsondata.quantity));
                    data.addRows([[month, profit]])
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
            
  $.plot($("#columnchart_values"), [[]]);

        })
</script>
@endsection



