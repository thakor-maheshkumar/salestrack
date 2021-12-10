<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\InventoryUnit;
use App\Models\Warehouse;
use App\Models\Grades;
use App\Models\StockItemGrades;
use App\Models\StockManagement;


class StockReportController extends CoreController
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
    public function index(Request $request)
    {
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $warehouses = \App\Models\Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $batches = \App\Models\Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
        $stock_report_data = StockManagement::all();

        /*if(!empty($request->query('warehouse_id')))
        {
            $warehouse_id = $request->query('warehouse_id');
        }
        if(!empty($request->query('batch_id')))
        {
            $batch_id = $request->query('batch_id');
        }
        if(!empty($request->query('item_id')))
        {
            $item_id = $request->query('item_id');
        }*/

        $warehouse_id = $request->query('warehouse_id');
        $batch_id = !empty($request->query('batch_id')) ? $request->query('batch_id') : '';
        $item_id = !empty($request->query('item_id')) ? $request->query('item_id') : '';

        $request_data['item_id'] = $item_id;
        $request_data['batch_id'] = $batch_id;
        $request_data['warehouse_id'] = $warehouse_id;

        $item_id = $request->input('item_id', null);
        $batch_id = $request->input('batch_id', null);;
        $warehouse_id = $request->input('warehouse_id', null);;
        //echo '<pre>';print_r($request_data);echo '</pre>';
        $query = StockManagement::query();

        $query->when($item_id, function ($q) use ($item_id) {
        return $q->where('stock_item_id', $item_id);
        });

        $query->when($batch_id, function ($q) use ($batch_id) {
        return $q->where('batch_id', $batch_id);
        });

        $query->when($warehouse_id, function ($q) use ($warehouse_id) {
        return $q->where('warehouse_id', $warehouse_id);
        });


        $stock_report_data = $query->orderByDesc('id')->get();
        //$warehouse_id = $request->query('warehouse_id');
        //$stock_report_data =  StockManagement::where('warehouse_id ' , $warehouse_id )->where('batch_id',$batch_id)->where('stock_item_id',$item_id)->get();

       // $entries = StockManagement::filter(['warehouse_id'])->get()->toArray();
        //echo '<pre>';print_r(compact('entries'));echo '</pre>';
        return view('admin.reports.stocks.index', ['items'=>$stockItem,'warehouses'=>$warehouses,'batches'=>$batches,'stock_report_data' => $stock_report_data,'request_data'=>$request_data]);
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
    public function stockOverviewReport(Request $request)
    {
        $stockItem=StockItem::where('active',1)->get();
        return view('admin.reports.stocks.stockoverview',[
            'stockItem'=>$stockItem
        ]);
    }
    public function stockOverviewReportData(Request $request)
    {
        $itemname=$request->itemname;
        $stockQuantity=StockManagement::where('stock_item_id',$itemname)
                        ->with(['stockitem','batch','warehouse'])
                        ->where('active',1)
                        ->selectRaw('id,stock_item_id,batch_id,warehouse_id,sum(qty) as quantity')
                        ->groupBy('stock_item_id','warehouse_id')
                        ->get();
       
        return json_encode(['stockQuantity'=>$stockQuantity]);
    }
}
