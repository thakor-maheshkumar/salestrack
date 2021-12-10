<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\ProductionPlan;
use App\Models\ProductionPlanItems;
use App\Models\WorkOrders;
use App\Models\Warehouse;
use App\Models\Batch;
use App\Models\WorkOrderItems;
use App\Models\StockManagement;
use App\Models\StockQtyManagement;
use App\Models\StockItem;
use App\Models\InventoryUnit;
use App\Models\WorkOrderSeries;

class WorkOrderController extends CoreController
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
        $wo = WorkOrders::with('plan')->where('active','1')->get();
        return view('admin.manufacturing.work-order.index',['items'=>$wo]);
    }


    function planItems($plan_id)
    {
        //if ($request->ajax())
        //{
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $production_plan = ProductionPlan::with('stockItems')->where('id',$plan_id)->first();
            $plan_items = ProductionPlanItems::with('stockItems')->where('plan_id',$plan_id)->get();
            $workorderseries=WorkOrderSeries::all();
            $workorderseriesstatus=WorkOrderSeries::where('status','true')->get();
            //print_r($plan_items);exit;
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            //echo '<pre>';print_r($production_plan->plan_id);echo '/pre>';
            return view('admin.manufacturing.work-order.plan_items', ['production_plan'=>$production_plan,'stockItem'=>$stockItem,'plan_items' => $plan_items,'warehouses'=>$warehouses,'batches'=>$batches,'workorderseries'=>$workorderseries,'workorderseriesstatus'=>$workorderseriesstatus]);
        //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = ProductionPlan::where('status',1)->where('active', 1)->pluck('plan_id', 'id')->toArray();
        return view('admin.manufacturing.work-order.create',['plans'=>$plans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo '<pre>';echo $request->plan_id;print_r($request->plan_item);echo '</pre>';exit;
        //$voucher_no = 'MR-ST-'.date('ymdhi');
        $voucher_no = 'MR-WO-'.date('ymdhi');

        if((isset($request->warehouse_id) && !empty($request->warehouse_id)) || (isset($request->batch_id) && !empty($request->batch_id)))
        {
            $product_plan_data = [
                'warehouse_id' => isset($request->warehouse_id) ? $request->warehouse_id : '',
                'batch_id' => isset($request->batch_id) ? $request->batch_id : '',
            ];
            $production_plan = ProductionPlan::find($request->plan_id);
            if($production_plan)
            {
               $production_plan->update($product_plan_data);
            }
        }
        /*$workorderseries=WorkOrders::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($workorderseries)      
        {
            $number = (int)$workorderseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $work_order_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $work_order_id=str_replace("XXXX","",$request->work_order_id.$number);
        }
        elseif(!empty($request->suffix))
        {
          $work_order_id=str_replace("XXXX","",$number.$request->work_order_id); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $work_order_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:workorders,work_order_id'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $work_order_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'work_order_id'=>'required|unique:workorders,work_order_id'
        ]);
        $work_order = WorkOrders::create([
            'work_order_id' => $request->work_order_id,
            'voucher_no' => $voucher_no,
            'plan_id' => $request->plan_id,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number:NULL,
            'series_type'=>$request->series_type
        ]);

        if(!empty($work_order))
        {
            $plan_id = $request->plan_id;
            if(!empty($plan_id))
            {
                if(isset($request->plan_item) && !empty($request->plan_item))
                {
                    foreach ($request->plan_item as $key => $plan_item)
                    {
                        $stock_item = \App\Models\StockItem::where(['id' => $plan_item['item_item_id'], 'active' => 1])->select('id', 'name', 'pack_code')->first();

                        $createdOrUpdated = WorkOrderItems::updateOrCreate([
                            'wo_id' => $work_order->id,
                            'stock_item_id' => isset($plan_item['item_item_id']) ? $plan_item['item_item_id'] : 0,
                            'warehouse_id' => isset($plan_item['warehouse_id']) ? $plan_item['warehouse_id'] : 0,
                            'batch_id' => isset($plan_item['batch_id']) ? $plan_item['batch_id'] : 0,
                            'quantity' => $plan_item['item_qty'],
                        ],[
                            'wo_id' => $work_order->id,
                            'warehouse_id' => isset($plan_item['warehouse_id']) ? $plan_item['warehouse_id'] : NULL,
                            'stock_item_id' => isset($plan_item['item_item_id']) ? $plan_item['item_item_id'] : NULL,
                            'batch_id' => isset($plan_item['batch_id']) ? $plan_item['batch_id'] : NULL,
                            'quantity' => $plan_item['item_qty'],
                        ]);
                    }
                }

                $data = [
                    'status' => 2,
                ];
                $pp = ProductionPlan::find($plan_id);
                $pp->update($data);
            }

            $workorderseriesdata=WorkOrderSeries::where('status','true')->first();
            if($workorderseriesdata)
            {
                $number=(int)$workorderseriesdata->series_current_digit+1;
                $workorderseriesdata=WorkOrderSeries::find($workorderseriesdata->id);
                $workorderseriesdata->series_current_digit=$number;
                $workorderseriesdata->save();
            }
        }

        if($work_order)
        {
            return redirect()->route('work-order.index')->with('message', __('messages.add', ['name' => 'Work Order']));
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
            $work_order = WorkOrders::with('plan')->find($id);
            $plan_items = WorkOrderItems::with('stockItems','batch','warehouse')->where('wo_id',$work_order->id)->get();
            return view('admin.manufacturing.work-order.show', ['item' => $work_order , 'plan_items'=>$plan_items]);
        }
        abort(404);
    }

    function OrdertoProcess($work_order_id,$plan_id)
    {
        if($work_order_id)
        {
            $wo_items = WorkOrderItems::with('stockItems','batch','warehouse')->where('wo_id',$work_order_id)->get()->toArray();

            foreach($wo_items as $r)
            {
                $stock = StockManagement::where('stock_item_id',$r['stock_item_id'])->where('batch_id',$r['batch_id'])->where('warehouse_id',$r['warehouse_id'])->orderBy('id', 'DESC')->first();
                //echo '<pre>';print_r($r);echo '</pre>';
                $stock_data =[
                    'voucher_no' => WorkOrders::where('id',$work_order_id)->first()->voucher_no,
                    'stock_item_id'=>$r['stock_item_id'],
                    'batch_id'=>$r['batch_id'],
                    'warehouse_id'=>$r['warehouse_id'],
                    'item_name'=>StockItem::where('id',$r['stock_item_id'])->first()->name,
                    'pack_code'=>StockItem::where('id',$r['stock_item_id'])->first()->pack_code,
                    'uom'=>InventoryUnit::where('id',$r['stock_items']['unit_id'])->first()->name,
                    'qty'=> -$r['quantity'],
                    'rate'=>1,
                    'balance_value'=> -($r['quantity'] * 1),
                    'total_balance' => isset($stock) ? ($stock->total_balance + ($r['quantity'] * 1)) : ($r['quantity'] * 1),
                    'voucher_type'=> 'Work Order in Progress',
                    'status'=> 4,
                    'created' => date('Y-m-d H:i:s'),
                ];
                $stock_op = StockManagement::insert($stock_data);

                $rate = 1;
                $receipt_quantity = $r['quantity'];
                $stock_item_id = $r['stock_item_id'];
                $batch_id = $r['batch_id'];
                $warehouse_id = $r['warehouse_id'];

                $stock_qty_management = StockQtyManagement::where('stock_item_id',$stock_item_id)->where('batch_id',$batch_id)->where('warehouse_id',$warehouse_id)->first();
                if($stock_qty_management)
                {
                    $stock_qty_id = $stock_qty_management->id;
                    $qty = $stock_qty_management->qty;
                    $balance = $stock_qty_management->balance_value;

                    $stock_qty_data =[
                        'stock_item_id'=>$stock_item_id,
                        'batch_id'=>$batch_id,
                        'warehouse_id'=>$warehouse_id,
                        'qty'=>$qty - $receipt_quantity,
                        'balance_value'=> $balance - ($receipt_quantity * $rate)
                    ];
                    $stock_qty = StockQtyManagement::where('id', $stock_qty_id)->update($stock_qty_data);
                }else{
                    $stock_qty_data =[
                        'stock_item_id'=>$stock_item_id,
                        'batch_id'=>$batch_id,
                        'warehouse_id'=>$warehouse_id,
                        'qty'=> -$receipt_quantity,
                        'balance_value'=> -($receipt_quantity * $rate),
                        'created_at'=> date('Y-m-d H:i:s')
                    ];
                    $stock_qty = StockQtyManagement::insert($stock_qty_data);
                }
            }
            $data = [
                'status' => 2,
            ];
            $pp = WorkOrders::find($work_order_id);
            $pp->update($data);

            return redirect()->route('work-order.index')->with('message', __('messages.update', ['name' => 'Order Executed']));

        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));

    }
    function OrdertoExecute($work_order_id,$plan_id)
    {
        if($work_order_id)
        {
           $data = [
                'status' => 3,
            ];
            $pp = WorkOrders::find($work_order_id);
            $pp->update($data);

            $data = [
                'status' => 2,
            ];
            $pp = ProductionPlan::find($plan_id);
            $pp->update($data);

            $plan = ProductionPlan::with('stockItems')->where('id',$plan_id)->first();
            $stock = StockManagement::where('stock_item_id',$plan->stock_item_id)->where('batch_id',$plan->batch_id)->where('warehouse_id',$plan->warehouse_id)->orderBy('id', 'DESC')->first();
            //echo '<pre>';print_r($plan->stockItems->unit_id);echo '</pre>';exit;
            $stock_data =[
                'voucher_no' => WorkOrders::where('id',$work_order_id)->first()->voucher_no,
                'stock_item_id'=>$plan->stock_item_id,
                'batch_id'=>$plan->batch_id,
                'warehouse_id'=>$plan->warehouse_id,
                'item_name'=>StockItem::where('id',$plan->stock_item_id)->first()->name,
                'pack_code'=>StockItem::where('id',$plan->stock_item_id)->first()->pack_code,
                'uom'=>InventoryUnit::where('id',$plan->stockItems->unit_id)->first()->name,
                'qty'=> $plan->quantity,
                'rate'=>1,
                'balance_value'=> ($plan->quantity * 1),
                'total_balance' => isset($stock) ? ($stock->total_balance + ($plan->quantity * 1)) : ($plan->quantity * 1),
                'voucher_type'=> 'Work Order Executed',
                'status'=> 4,
                'created' => date('Y-m-d H:i:s'),
            ];
            $stock_op = StockManagement::insert($stock_data);

            return redirect()->route('work-order.index')->with('message', __('messages.update', ['name' => 'Order Executed']));

        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));
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
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workorder = WorkOrders::find($id);

        if ($workorder)
        {
            $data = [
                'active' => 0,
            ];
            $workorder->update($data);

            return redirect()->route('work-order.index')->with('message', __('messages.delete', ['name' => 'Work Order']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function getdata($id)
    {
        $data=WorkOrderSeries::where('id',$id)->first();
        return response()->json($data);
    }
}
