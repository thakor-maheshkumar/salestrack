<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\SalesOrdersItems;
use Dompdf\Dompdf;

class DashboardController extends CoreController
{
    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
    public function mainDashboard()
    {
        return view('admin.dashboard.main');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf1()
    {
        $pdf = \PDF::loadView('admin.dashboard.pdf1');
        // $pdf->setOptions(['isPhpEnabled' => true]);

        //return view('admin.dashboard.pdf1');

        /*$pdf->setPaper('a4', 'landscape');*/
        //return $pdf->stream();
        $pdf_name = time() . '.pdf';
        return $pdf->download($pdf_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf2()
    {
        $pdf = \PDF::loadView('admin.dashboard.pdf2');
        // $pdf->setOptions(['isPhpEnabled' => true]);

        // return view('admin.dashboard.pdf2');

        /*$pdf->setPaper('a4', 'landscape');*/
        //return $pdf->stream();
        $pdf_name = time() . '.pdf';
        return $pdf->download($pdf_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function chart()
    {
        /*$stockitems=StockItem::where('active',1)->get();
        return view('admin.dashboard.chart',[
            'stockitems'=>$stockitems
        ]);*/
        return view('admin.dashboard.chart');
    }
    public function stockitemdata(Request $request)
    {
        $stockItem=$request->stock_item_id;
        $year=$request->groupby;
        $newyear=$request->newyear;
        $month=$request->month;
        $week=$request->week;   
       $output[]=0;
        $startdate=(!empty($request->start_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->start_date)->format('Y-m-d H:i:s') : '';
        //dd($startdate);
       
        $enddate=(!empty($request->end_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->end_date)->format('Y-m-d H:i:s') : '';
        
        $price=$request->price;

        if($startdate && $enddate && empty($year))
        {
             if($price =="price")
                {
               
                    $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                 ->where('active',1)
                                                 ->whereBetween('created_at',[$startdate,$enddate])
                                                    ->sum('sales_order_items.net_amount');
                                                     return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                        ]);
                }
                    
            elseif($price=='quantity')
                {
                    
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->whereBetween('created_at',[$startdate,$enddate])
                                                    ->sum('sales_order_items.quantity');
                                                    return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                    ]);
                }
        }else if($startdate && $enddate && $year)
        {
            $startdate=(!empty($request->start_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->start_date)->format('Y-m-d H:i:s') : '';
             $enddate=(!empty($request->end_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->end_date)->format('Y-m-d H:i:s') : '';

            if($price =="price"){

            $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                      ->where('active',1)
                                                      ->selectRaw('WEEK(created_at) as week, date(created_at) as startdate ,date(created_at + INTERVAL 7 DAY) as due_date, sum(net_amount) as total_sale,count(*) as totalbook,year(created_at) as year')
                                                      ->whereBetween('created_at',[$startdate,$enddate])
                                                      ->groupBy('week')
                                                      ->orderByRaw('week')
                                                      ->get();
                                                    
                                                    foreach($salesOrdernew->toArray() as $row)
                                                    {   
                                                        $output[] = array(
                                                        'year'=>(string)$row['year'],
                                                        'week'=>(string)$row['week'],
                                                        'created_date'=>\Carbon\Carbon::parse($row['startdate'])->format('d/m/Y')."-".\Carbon\Carbon::parse($row['due_date'])->format('d/m/Y'),
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                    }
                                                echo json_encode($output);
            }else if($price =="quantity"){

            $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                      ->where('active',1)
                                                      ->selectRaw('WEEK(created_at) as week,date(created_at) as startdate ,date(created_at + INTERVAL 7 DAY) as due_date, sum(quantity) as total_sale,count(*) as totalbook,year(created_at) as year')
                                                      ->whereBetween('created_at',[$startdate,$enddate])
                                                      ->groupBy('week')
                                                      ->orderByRaw('week')
                                                      ->get();
                                                    foreach($salesOrdernew->toArray() as $row)
                                                    {
                                                        $output[] = array(
                                                        'week'=>(string)$row['week'],
                                                        'year'=>(string)$row['year'],
                                                        'created_date'=>\Carbon\Carbon::parse($row['startdate'])->format('d/m/Y')."-".\Carbon\Carbon::parse($row['due_date'])->format('d/m/Y'),
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                    }
                                                echo json_encode($output);
            }
                                            //dd($output);
        }
        else if($year)
        {
            if($year=="year")
            {

                if($price=="price")
                {
                    $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                      ->where('active',1)
                                                      ->selectRaw('year(created_at) as year, sum(net_amount) as total_sale,count(*) as totalbook')
                                                      ->groupBy('year')
                                                      ->orderByRaw('year')
                                                      ->get();
                                                    foreach($salesOrdernew->toArray() as $row)
                                                    {
                                                        $output[] = array(
                                                        'yearData'=>(string)$row['year'],
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                    }
                                                    
                                                    echo json_encode($output);
                    }
                else if($price=="quantity")
                {
                    $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                      ->where('active',1)
                                                      ->selectRaw('year(created_at) as year, sum(quantity) as total_sale,count(*) as totalbook')
                                                      ->groupBy('year')
                                                      ->orderByRaw('year')
                                                      ->get();
                                                    foreach($salesOrdernew->toArray() as $row)
                                                    {
                                                        $output[] = array(
                                                        'yearData'=>(string)$row['year'],
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                    }
                                                    
                                                echo json_encode($output);
                    }
                             
            }   
            else if($year=="month")
            {

                if($price=="price")
                {
                    $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                      ->where('active',1)
                                                      ->selectRaw('monthname(created_at) as month, sum(net_amount) as total_sale,count(*) as totalbook')
                                                      ->groupBy('month')
                                                      ->orderByRaw('month')
                                                      ->get();
                                                     foreach($salesOrdernew->toArray() as $row){
                                                     $output[] = array(
                                                        'month'=>$row['month'],
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                            }
                                                            //dd($output);
                                                    echo json_encode($output);

                }
                elseif ($price=="quantity")
                {

                    $salesOrdernew = SalesOrdersItems::where('stock_item_id',$stockItem)
                                                     ->where('active',1)
                                                     ->selectRaw('monthname(created_at) as month, sum(quantity) as total_sale,count(*) as totalbook')
                                                     ->groupBy('month')
                                                     ->orderByRaw('month')
                                                     ->get();
                                                    foreach($salesOrdernew->toArray() as $row){
                                                    $output[] = array(
                                                        'month'=>$row['month'],
                                                         'quantity'=>floatval($row['total_sale']),
                                                            );
                                                            }
                                                            //dd($output);
                                                    echo json_encode($output);
                                // code...
                }

            }
        }
        
            
    }
    
}
