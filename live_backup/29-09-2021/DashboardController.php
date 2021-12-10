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
        //dd($year);
        $newyear=$request->newyear;
        $month=$request->month;
        $week=$request->week;   
       
        $startdate=(!empty($request->start_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->start_date)->format('Y-m-d') : '';

       
        $enddate=(!empty($request->end_date)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$request->end_date)->format('Y-m-d') : '';
        
        $price=$request->price;

            if($price =="price")
                {
                    

                    if($startdate && $enddate )
                    {
               
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->whereBetween('created_at',[$startdate,$enddate])
                                                    ->sum('sales_order_items.net_amount');
                                                    /*return view('admin.dashboard.chart',
                                                    ['salesOrder'=>$salesOrder]);    */
                                                     return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                    ]);
                    }
                    else if($year=="year")
                    {
                        
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->sum('sales_order_items.net_amount');
                                                    return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                    ]);

                    }
                    
                    $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->whereMonth('created_at',$month)
                                                    ->sum('sales_order_items.net_amount');
                                                    return view('admin.dashboard.chart',['salesOrder'=>$salesOrder]);
                }
         
            elseif($price=='quantity')
                {
                    if($startdate && $enddate)
                    {
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->whereBetween('created_at',[$startdate,$enddate])
                                                    ->sum('sales_order_items.quantity');
                                                    return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                    ]);
                                                  /*  return view('admin.dashboard.chart',
                                                    ['salesOrder'=>$salesOrder]);     */
                    }
                    else if($year=="year")
                    {
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->sum('sales_order_items.quantity');
                                                    return response()->json([
                                                        'salesOrder'=>$salesOrder
                                                    ]);
                                                    /*return view('admin.dashboard.chart',
                                                    ['salesOrder'=>$salesOrder]);    */
                    }
                    //dd($week);
                    
                        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)
                                                    ->where('active',1)
                                                    ->whereMonth('created_at',$month)
                                                    ->whereYear('created_at',$newyear)
                                                    ->sum('sales_order_items.quantity');

                                                    return view('admin.dashboard.chart',
                                                    ['salesOrder'=>$salesOrder]);
                }
        
    }
}
