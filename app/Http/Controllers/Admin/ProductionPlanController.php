<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\BomStockItems;
use App\Models\ProductionPlan;
use App\Models\ProductionPlanItems;
use App\Models\SalesOrders;
use App\Models\Batch;
use App\Models\Warehouse;
use App\Models\ProductionPlanSeries;
class ProductionPlanController extends CoreController
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
        $plans = ProductionPlan::with('bom')->where('active','1')->get();
        $sales_order = SalesOrders::where('active','1')->pluck('order_no','id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
        return view('admin.manufacturing.production-plan.index', ['plans' => $plans,'sales_order'=>$sales_order,'warehouses'=>$warehouses,'batches'=>$batches]);
    }

    function stockBom(Request $request,$stock_id)
    {
        if ($request->ajax())
        {
            $bom = BOM::where('stock_item_id',$stock_id)->pluck('bom_name', 'id');

            return response()->json([
                'success' => true,
                'data' => $bom,
            ]);
        }
        //print_r($bom);
        //$bom = BomStockItems::with('bom')->where('stock_item_id',$stock_id)->pluck('name', 'id')->toArray();
    }
    function bomItems(Request $request,$bom_id)
    {
        if ($request->ajax())
        {
            $bom = Bom::where('id',$bom_id)->get()->first();
            $bom_items = BomStockItems::where('bom_id',$bom_id)->get();
            $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
            $stock_items = !empty($stock_items_list) ? $stock_items_list : [];
            $bom_items_arr = BomStockItems::where('bom_id',$bom_id)->get();
            if(!empty($bom_items_arr))
            {
                $i=0;$bom_stock_data=[];
                foreach($bom_items_arr as $b)
                {
                    $bom_stock_data['stock_data'][$i]['bom_id'] = $b->bom_id;
                    $bom_stock_data['stock_data'][$i]['stock_item_id'] = $b->stock_item_id;
                    $bom_stock_data['stock_data'][$i]['quantity'] = $b->quantity;
                    $stock_entry = \App\Models\StockQtyManagement::with('stockItems')->where('stock_item_id',$b->stock_item_id)->orderBy('id','desc')->first();
                    $bom_stock_data['stock_data'][$i]['available_qty'] = $stock_entry->qty;
                    $i++;
                }
            }
            return view('admin.manufacturing.production-plan.bom_items', ['bom'=>$bom,'items' => $bom_items,'stock_items'=>$stock_items,'quantity'=>$bom->no_of_unit,'bom_stock_data'=>$bom_stock_data]);
        }
    }

    function planQuantityCalc(Request $request,$bom_id,$quantity)
    {
        if ($request->ajax())
        {
            $bom = Bom::where('id',$bom_id)->get()->first();
            $bom_items = BomStockItems::where('bom_id',$bom_id)->get();
            $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
            $stock_items = !empty($stock_items_list) ? $stock_items_list : [];

            return view('admin.manufacturing.production-plan.bom_items', ['bom'=>$bom,'items' => $bom_items,'stock_items'=>$stock_items,'quantity'=>$quantity]);

        }
    }

    function stockBatch(Request $request,$stock_id)
    {
        if ($request->ajax())
        {
            $batches = Batch::where('stock_item_id',$stock_id)->pluck('batch_id', 'id');

            return response()->json([
                'success' => true,
                'data' => $batches,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
        $stock_items = !empty($stock_items_list) ? $stock_items_list : array();
        $sales_order = SalesOrders::where('active','1')->pluck('order_no','id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

        $boms = Bom::where('active', 1)->get();
        $productionplanseries=ProductionPlanSeries::all();
        $productionplanseriestatus=ProductionPlanSeries::where('status','true')->get();
        return view('admin.manufacturing.production-plan.create',['stock_items'=>$stock_items,'sales_order'=>$sales_order,'warehouses'=>$warehouses,'batches'=>$batches, 'boms' => $boms,'productionplanseries'=>$productionplanseries,'productionplanseriestatus'=>$productionplanseriestatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$productionplanseries=ProductionPlan::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($productionplanseries)      
        {
            $number = (int)$productionplanseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $plan_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $plan_id=str_replace("XXXX","",$request->plan_id.$number);
        }
        elseif(!empty($request->suffix))
        {
          $plan_id=str_replace("XXXX","",$number.$request->plan_id); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $plan_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:production_plan,plan_id'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $plan_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'plan_id'=>'required|unique:production_plan,plan_id'
        ]);
        $plan_id = ProductionPlan::create([
            'plan_id' => $request->plan_id,
            'stock_item_id' => $request->stock_item_id,
            'quantity' => $request->quantity,
            'bom_id' => $request->bom_id,
            'so_id' => $request->so_id,
            'warehouse_id' => $request->warehouse_id,
            'batch_id' => $request->batch_id,
            'production_date' => (isset($request->production_date) && !empty($request->production_date)) ? $request->production_date : date('Y-m-d H:i:s'),
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);

        if(!empty($plan_id))
        {
            if(isset($request->bom_stock_items) && !empty($request->bom_stock_items))
            {
                $production_data = [];
                foreach ($request->bom_stock_items as $key => $items)
                {
                    if(isset($items['item_item_id']))
                    {
                        $production_data[] = [
                            'plan_id'=>$plan_id->id,
                            'stock_item_id' => $items['item_item_id'],
                            'quantity' => $items['item_qty']
                        ];
                    }
                }
                if(!empty($production_data) && count($production_data) > 0)
                {
                    ProductionPlanItems::insert($production_data);
                }
            }

            /*$bom_id = $request->bom_id;
            $bom_items = BomStockItems::where('bom_id',$bom_id)->get();
            if(!empty($bom_items))
            {
                $bom_stock_data = [];
                foreach ($bom_items as $key => $bom_stock_items)
                {
                    $bom_stock_data[] = [
                        'plan_id'=>$plan_id->id,
                        'stock_item_id' => $bom_stock_items->stock_item_id,
                        'quantity' => $bom_stock_items->quantity
                    ];
                }
                if(!empty($bom_stock_data) && count($bom_stock_data) > 0)
                {
                    ProductionPlanItems::insert($bom_stock_data);
                }
            }*/
            $productionplanseriesdata=ProductionPlanSeries::where('status','true')->first();
            if($productionplanseriesdata)
            {
                $number=(int)$productionplanseriesdata->series_current_digit+1;
                $productionplanseriesdata=ProductionPlanSeries::find($productionplanseriesdata->id);
                $productionplanseriesdata->series_current_digit=$number;
                $productionplanseriesdata->save();
            }
        }

        if($plan_id)
        {
            return redirect()->route('production-plan.index')->with('message', __('messages.add', ['name' => 'Plan']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id)
        {
            $plan = ProductionPlan::with('salesorder')->find($id);
            $plan_items = ProductionPlanItems::with('stockItems')->where('plan_id',$plan->id)->get();

            return view('admin.manufacturing.production-plan.show', ['item' => $plan,'plan_items'=>$plan_items]);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id)
        {
            $bom = Bom::with('bom_items')->find($id);

            if($bom)
            {
                $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
                $stock_items = !empty($stock_items_list) ? $stock_items_list : [];
                $boms = Bom::where('active', 1)->get();

                return view('admin.inventory.bom.edit', ['bom' => $bom , 'stock_items'=>$stock_items,'material_rate' => static::$material_rate,'sales_order'=>$sales_order, 'boms' => $boms]);
            }
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BomRequest $request, $id)
    {
        $data = [
            'bom_name' => $request->bom_name,
            'stock_item_id' => $request->stock_item_id,
            'no_of_unit' => isset($request->no_of_unit) ? $request->no_of_unit : NULL,
            'rate_of_material' => isset($request->rate_of_material) ? $request->rate_of_material : NULL,
            'so_id' => $request->so_id,
            'production_date' => (isset($request->production_date) && !empty($request->production_date)) ? $request->production_date : NULL
        ];

        $bom = Bom::find($id);

        if($bom)
        {
            if ($bom->update($data))
            {
                $bom_stock_data = [];
                $keep_items = [];
                foreach ($request->bom_stock_items as $key => $bom_stock_items)
                {
                    if(isset($bom_stock_items['item_item_id']) && isset($bom_stock_items['item_qty']))
                    {
                        $bom_stock_data[$bom_stock_items['item_item_id']] = (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? $bom_stock_data[$bom_stock_items['item_item_id']] : [];

                        $bom_stock_data[$bom_stock_items['item_item_id']] = [
                            'bom_id' => $bom->id,
                            'stock_item_id' => $bom_stock_items['item_item_id'],
                            'quantity' => (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? ($bom_stock_items['item_qty'] + $bom_stock_data[$bom_stock_items['item_item_id']]['quantity']) : $bom_stock_items['item_qty']
                        ];
                    }
                }

                if(!empty($bom_stock_data))
                {
                    $keep_items = array_keys($bom_stock_data);

                    foreach ($bom_stock_data as $key => $value) {
                        BomStockItems::updateOrCreate([
                            'bom_id' => $bom->id,
                            'stock_item_id' => $value['stock_item_id']
                        ], $value);
                    }

                    BomStockItems::where('bom_id', $bom->id)->whereNotIn('stock_item_id', $keep_items)->delete();
                }

                return redirect()->route('bom.index')->with('message', __('messages.update', ['name' => 'BOM']));
            }
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = ProductionPlan::find($id);

        if ($plan)
        {
            $data = [
                'active' => 0,
            ];
            $plan->update($data);

            return redirect()->route('production-plan.index')->with('message', __('messages.delete', ['name' => 'Production Plan']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function getdata($id)
    {
        $data=ProductionPlanSeries::where('id',$id)->first();
        return response()->json($data);
    }
}
