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
        <?php  
//if(DB::connection()->getDatabaseName()) {
//echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
//} 
//Purchase Order data by status.
$postat = DB::table('purchase_orders')
    ->select(['po_status',DB::raw('count(*)')])->groupBy('po_status')->get();
$zero=DB::table('purchase_orders')->where('po_status','0')->count();
$one=DB::table('purchase_orders')->where('po_status','1')->count();
$two=DB::table('purchase_orders')->where('po_status','2')->count();
$three=DB::table('purchase_orders')->where('po_status','3')->count();

//Sales Order Data by status wise
$pending=DB::table('sales_orders')->where('status','pending')->count();
$delivered_not_billed=DB::table('sales_orders')->where('status','delivered_not_billed')->count();
$billed_not_delivered=DB::table('sales_orders')->where('status','billed_not_delivered')->count();
$completed=DB::table('sales_orders')->where('status','completed')->count();
/*print_r($postat);*/
?>
    <div class="row">
        <div class="col-md-12">
            <div id="columnchart_values" ></div>
        </div>
        <div class="col-md-12">
            <div id="sales_order_columnchart_values" ></div>
         </div>
        </div>
        <br>
        <br>
       <h4>Day Beetween, weekly, monthly and yearly data</h4>
        <div class="row-md-12">
                <form method="post" action="{{route('stockitem.data')}}">
                    @csrf
                    <div class="row">
                         <div class="col-md-4">
                                <select class="form-control stock_item_id select2" name="stock_item_id" id="select2">
                                        <option value="">Select Stock Item</option>
                                         @foreach(\App\Models\StockItem::where('active',1)->get() as  $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                </select>
                         </div>
                        <div class="col-md-4">
                            <select class="form-control price" name="price" id="select2">
                                <option value="Select Option">Select Option</option>
                                <option value="price">Price</option>
                                <option value="quantity">Quantity</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="start_date" class="form-control start_date datepicker" placeholder="Start Date">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="end_date" class="form-control end_date datepicker" placeholder="End Date" id="select2">
                        </div>
                        <div class="col-md-4">
                            <select class="form-control groupBy" name="groupby" id="select2">
                                <option value="">Select Group</option>
                                <option value="year">Year</option>
                                <option value="month">Month</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>    
                    </div>
                </form>
                        <div id="columnchart_yearly" style="width: 900px; height: 1000px;float: left;"></div>
                        <div id="yearly" style="width: 900px; height: 300px;float: left;"></div>
        </div>
    </div>
</div>

@endsection
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);


    function drawChart() {
        //Purchase order data by staus
  var not_billed_or_received = <?php echo json_encode($zero); ?>;
  var received_not_billed = <?php echo json_encode($one); ?>;
  var billed_not_received = <?php echo json_encode($two); ?>;
  var ordered_billed = <?php echo json_encode($three); ?>;

  //Sales Order data by status
  var pending = <?php echo json_encode($pending); ?>;
  var delivered_not_billed = <?php echo json_encode($delivered_not_billed); ?>;
  var billed_not_delivered = <?php echo json_encode($billed_not_delivered); ?>;
 var completed = <?php echo json_encode($completed); ?>;


    //Purchase order data by status
      var data = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Not Billed or Received", not_billed_or_received, "#b87333"],
        ["Received - Not Billed", received_not_billed, "silver"],
        ["Billed - Not Received", billed_not_received, "gold"],
        ["Ordered & Billed", ordered_billed, "blue"],
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
        title: "Purchase Order data by status",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

      //SalesOrder data by status
      var salesorderdata = google.visualization.arrayToDataTable([
        ["Elements", "Density", { role: "style" } ],
        ["Pending", pending, "#b87333"],
        ["Delivered not billed", delivered_not_billed, "silver"],
        ["Billed not delivered", billed_not_delivered, "gold"],
        ["Completed", completed, "blue"],
        //["Platinum", 5, "color: #e5e4e2"]
      ]);

      var salesorderview = new google.visualization.DataView(salesorderdata);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var salesorderoptions = {
        title: "Sales Order data by status",
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
  @section('script')
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
                    if(fullStartEndDate =='NaN/NaN/NaN-NaN/NaN/NaN'){
                        fullStartEndDate="";
                    }
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
                        /*vAxis: {
                          title:'Profit' ,
                          scaleType: 'log',
                        },*/
                        vAxis   : {
                        minorGridlines : {
                            count : 5
                        },
                        gridlines : {
                            count : 6
                        },
                        textStyle : {
                            fontSize : 20
                        },
                        title : "Quantity Or Price",
                        titleTextStyle : {
                            fontName : "Oswald",
                            italic : false,
                            color : "#990000"
                        },
                        viewWindow : {
                            min : 0,
                            
                        }
                    },
                        colors:['#b87333'],
                        chartArea:{
                          //width:'100%',
                          //height:'80%',
                          left:'10%',
                          bottom:'35%'
                        },
                        bar:{
                            groupWidth: 50
                        }
                       };

                    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_yearly"));
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
           /* $('.end_date').change(function(){
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
            })*/
        })
</script>
@endsection