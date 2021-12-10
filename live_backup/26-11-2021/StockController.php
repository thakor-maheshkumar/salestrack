<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\StockSourceItem;
use App\Http\Requests\Admin\StockRequest;
use App\Models\Batch;
use App\Models\StockItem;
use App\Models\StockManagement;
use App\Models\StockQtyManagement;
use App\Models\InventoryUnit;
use App\Models\StockSeries;

class StockController extends CoreController
{
    protected static $stock_transfer_types = [
        'material_issue' => 'Material Issue',
        'material_receipt' => 'Material Receipt',
        'material_transfer' => 'Material Transfer'
    ];

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
        $stocks = Stock::all();

        return view('admin.stocks.index', ['stocks' => $stocks, 'stock_transfer_types' => self::$stock_transfer_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

        $stock_items = \App\Models\StockItem::with(['unit', 'alternate_unit'])->where('active', 1)->select('id', 'name', 'unit_id', 'alternate_unit_id', 'pack_code')->get();
        $stockItem = \App\Models\StockItem::select('name', 'id','pack_code')->where('active', 1)->get();
        $documentData=\App\Models\Stock::where([['document_no','!=',null],['stock_status','issued'],['active',1]])->get();

        $documentData=\App\Models\Stock::select(\DB::raw('COUNT(document_no) as count'), 'document_no')
                    ->groupBy('document_no')
                    ->having('count', '=', 1)
                    ->where([['stock_transfer_type','!=','material_transfer'],['active',1]])
                    /*->where([['document_no','!=',null],['active',1]])*/
                    ->get();


        $stock_items_names = $stock_items_codes = $stock_items_units = [];
        if($stock_items->isNotEmpty())
        {
            $stock_items_names = $stock_items->pluck('name', 'id')->toArray();
            $stock_items_codes = $stock_items->pluck('pack_code', 'id')->toArray();

            foreach ($stock_items as $key => $stock_item) {
                $stock_items_units[$stock_item->id][$stock_item->unit_id] = isset($stock_item->unit->name) ? $stock_item->unit->name : '';
                $stock_items_units[$stock_item->id][$stock_item->alternate_unit_id] = isset($stock_item->alternate_unit->name) ? $stock_item->alternate_unit->name : '';
            }
        }
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
        $stockseries=StockSeries::all();
        $stockseriesstatus=StockSeries::where('status','true')->get();
        return view('admin.stocks.create', ['stockItem'=>$stockItem,'stock_transfer_types' => self::$stock_transfer_types, 'warehouses' => $warehouses, 'stock_items_names' => $stock_items_names, 'stock_items_codes' => $stock_items_codes, 'stock_items_units' => $stock_items_units,'batches'=>$batches,'stockseries'=>$stockseries,'stockseriesstatus'=>$stockseriesstatus,'documentData'=>$documentData]);
    }

    /**
     * Get units of item.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUnits(Request $request, $id)
    {
        if ($request->ajax())
        {
            $stock_item = \App\Models\StockItem::where(['id' => $id, 'active' => 1])->with(['unit', 'alternate_unit'])->select('id', 'name', 'unit_id', 'alternate_unit_id')->first();

            $stock_items_units = [];
            if (!empty($stock_item))
            {
                $stock_items_units[$stock_item->unit_id] = isset($stock_item->unit->name) ? $stock_item->unit->name : '';
                $stock_items_units[$stock_item->alternate_unit_id] = isset($stock_item->alternate_unit->name) ? $stock_item->alternate_unit->name : '';
            }
            return response()->json([
                'success' => true,
                'data' => $stock_items_units
            ]);
        }

        abort(404);
    }

    public function getBatch(Request $request, $stock_id,$warehouse_id)
    {
        if ($request->ajax())
        {
            $batches = \App\Models\Batch::where(['stock_item_id' => $stock_id, 'warehouse_id'=>$warehouse_id,'active' => 1])->get();

			/*$data=array();
			if($batches)
			{
				$stock_qty = StockQtyManagement::where('stock_item_id',$stock_id)->where('batch_id',$batches->id)->where('warehouse_id',$warehouse_id)->get()->toArray();
				if(!empty($stock_qty))
				{
					if($stock_qty[0]['qty'] > 0)
					{

						$batch = Batch::where('active', 1)->where('id',$stock_qty[0]['batch_id'])->first();

						$data[$stock_qty[0]['batch_id']] = $batch->batch_id.' - '.$stock_qty[0]['qty'];
					}
				}
			}*/

            return response()->json([
                'success' => true,
                'data' => $batches
            ]);
        }

        abort(404);
    }

    function getAvailableQty(Request $request, $stock_id,$warehouse_id,$batch_id)
    {
        if ($request->ajax())
        {
            $stock_qty = StockQtyManagement::where('stock_item_id',$stock_id)->where('batch_id',$batch_id)->where('warehouse_id',$warehouse_id)->get()->toArray();

            return response()->json([
                'success' => true,
                'data' => !empty($stock_qty) ? $stock_qty : ''
            ]);
        }
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$productionplanseries=Stock::where('series_type',$request->series_type)->orderBy('number','desc')->first();
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
          $plan_id=str_replace("XXXX","",$request->stock_transfer_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $plan_id=str_replace("XXXX","",$number.$request->stock_transfer_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $plan_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:stocks,stock_transfer_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $plan_id=$request->manual_id;   
        }*/
        $this->validate($request,[
           'stock_transfer_no'=>'required|unique:stocks,stock_transfer_no' 
        ]);
        if($request->stock_transfer_type=='material_issue' || $request->stock_transfer_type=='material_transfer' ){
            $voucher_no = 'MR-ST-'.date('ymdhi');
            $document_no=preg_replace('/[^0-9]/', '', $request->document_no);
            $document_no_add=(int)$document_no + 1;
            $issued='transfer';
        }
        $voucher_no = 'MR-ST-'.date('ymdhi');
        $stock = Stock::create([
            'voucher_no' => $voucher_no,
            'transaction_type' => 1,
            'stock_transfer_no' => $request->stock_transfer_no,
            'transaction_type' => isset($request->transaction_type) ? $request->transaction_type : NULL,
            'stock_transfer_type' => isset($request->stock_transfer_type) ? $request->stock_transfer_type : NULL,
            'date' => isset($request->date) ? $request->date : NULL,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
            'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
            'stock_status'=>isset($issued) ? $issued :'transfer',
        ]);
        $stock_id_stock=$stock->id;
        if($stock)
        {
            foreach ($request->source_items as $key => $source_item)
            {
                $stock_item = \App\Models\StockItem::where(['id' => $source_item['item_name'], 'active' => 1])->select('id', 'name', 'pack_code')->first();

                /*StockSourceItem::create([
                    'stock_id' => $stock->id,
                    'source_warehouse' => isset($source_item['source_warehouse']) ? $source_item['source_warehouse'] : NULL,
                    'target_warehouse' => isset($source_item['target_warehouse']) ? $source_item['target_warehouse'] : NULL,
                    'item_id' => $source_item['item_code'],
                    'item_code' => isset($stock_item->pack_code) ? $stock_item->pack_code : '',
                    'item_name' => isset($stock_item->name) ? $stock_item->name : '',
                    'uom' => $source_item['uom'],
                    'quantity' => $source_item['quantity']
                ]);*/

                $createdOrUpdated = StockSourceItem::updateOrCreate([
                    'stock_id' =>  $stock_id_stock,
                    'item_id' => isset($source_item['item_name']) ? $source_item['item_name'] : 0
                ],[
                    'stock_id' =>  $stock_id_stock,
                    'source_warehouse' => isset($source_item['source_warehouse']) ? $source_item['source_warehouse'] : NULL,
                    'target_warehouse' => isset($source_item['target_warehouse']) ? $source_item['target_warehouse'] : NULL,
                    'item_id' => $source_item['item_name'],
                    'item_code' => isset($stock_item->pack_code) ? $stock_item->pack_code : '',
                    'item_name' => isset($stock_item->name) ? $stock_item->name : '',
                    'batch_id' => (isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                    'uom' => $source_item['uom'],
                    'rate' => $source_item['rate'],
                    'quantity' => $source_item['quantity'],
					'target_batch_id' => (isset($source_item['target_batch']) && !empty($source_item['target_batch'])) ? $source_item['target_batch'] : NULL,
                    'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                ]);

                /////// STOCK MANAGEMENT START ///////
                $stock = StockManagement::where('stock_item_id',$source_item['item_name'])->where('warehouse_id',$source_item['source_warehouse'])->orderBy('id', 'DESC');

                if(isset($source_item['batch']) && !empty($source_item['batch']))
                {
                    $stock = $stock->where('batch_id',$source_item['batch']);
                }

                $stock = $stock->first();

                if($request->stock_transfer_type == 'material_transfer')
                {
                    $stock_reduce_data =[
                        'voucher_no' => $voucher_no,
                        'stock_item_id'=>$source_item['item_name'],
                        'batch_id'=>(isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                        'warehouse_id'=>isset($source_item['source_warehouse']) ? $source_item['source_warehouse'] : NULL,
                        'item_name'=>StockItem::where('id',$source_item['item_name'])->first()->name,
                        'pack_code'=>StockItem::where('id',$source_item['item_name'])->first()->pack_code,
                        'uom'=> InventoryUnit::where('id',$source_item['uom'])->first()->name,
                        'qty'=> -$source_item['quantity'],
                        'rate'=>$source_item['rate'],
                        'balance_value'=> -($source_item['quantity'] * $source_item['rate']),
                        'total_balance' => isset($stock) ? ($stock->total_balance - ($source_item['quantity'] * $source_item['rate'])) : ($source_item['quantity'] * $source_item['rate']),
                        'voucher_type'=> isset($request->stock_transfer_type) ? 'Stock entry - '.$request->stock_transfer_type : 'Stock entry',
                        'status'=>3,
                        'created' => date('Y-m-d H:i:s'),
                        'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                    ];
                    $stock_op = StockManagement::insert($stock_reduce_data);

                    $stock_data =[
                        'voucher_no' => $voucher_no,
                        'stock_item_id'=>$source_item['item_name'],
                        'batch_id'=>(isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                        'warehouse_id'=>isset($source_item['target_warehouse']) ? $source_item['target_warehouse'] : NULL,
                        'item_name'=>StockItem::where('id',$source_item['item_name'])->first()->name,
                        'pack_code'=>StockItem::where('id',$source_item['item_name'])->first()->pack_code,
                        'uom'=>InventoryUnit::where('id',$source_item['uom'])->first()->name,
                        'qty'=> $source_item['quantity'],
                        'rate'=>$source_item['rate'],
                        'balance_value'=> ($source_item['quantity'] * $source_item['rate']),
                        'total_balance' => isset($stock) ? ($stock->total_balance + ($source_item['quantity'] * $source_item['rate'])) : ($source_item['quantity'] * $source_item['rate']),
                        'voucher_type'=> isset($request->stock_transfer_type) ? 'Stock entry - '.$request->stock_transfer_type : 'Stock entry',
                        'status'=>3,
                        'created' => date('Y-m-d H:i:s'),
                        'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                    ];
                    $stock_op1 = StockManagement::insert($stock_data);
                }else if($request->stock_transfer_type == 'material_receipt'){
                    $stock_data =[
                        'voucher_no' => $voucher_no,
                        'stock_item_id'=>$source_item['item_name'],
                        'batch_id'=>(isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                        'warehouse_id'=>isset($source_item['target_warehouse']) ? $source_item['target_warehouse'] : NULL,
                        'item_name'=>StockItem::where('id',$source_item['item_name'])->first()->name,
                        'pack_code'=>StockItem::where('id',$source_item['item_name'])->first()->pack_code,
                        'uom'=>InventoryUnit::where('id',$source_item['uom'])->first()->name,
                        'qty'=>$source_item['quantity'],
                        'rate'=>$source_item['rate'],
                        'balance_value'=> ($source_item['quantity'] * $source_item['rate']),
                        'total_balance' => isset($stock) ? ($stock->total_balance + ($source_item['quantity'] * $source_item['rate'])) : ($source_item['quantity'] * $source_item['rate']),
                        'voucher_type'=> isset($request->stock_transfer_type) ? 'Stock entry - '.$request->stock_transfer_type : 'Stock entry',
                        'status'=>3,
                        'created' => date('Y-m-d H:i:s'),
                        'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                    ];
                    $stock_op = StockManagement::insert($stock_data);
                }else if($request->stock_transfer_type == 'material_issue'){
                    $stock_data =[
                        'voucher_no' => $voucher_no,
                        'stock_item_id'=>$source_item['item_name'],
                        'batch_id'=>(isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                        'warehouse_id'=>isset($source_item['source_warehouse']) ? $source_item['source_warehouse'] : NULL,
                        'item_name'=>StockItem::where('id',$source_item['item_name'])->first()->name,
                        'pack_code'=>StockItem::where('id',$source_item['item_name'])->first()->pack_code,
                        'uom'=>InventoryUnit::where('id',$source_item['uom'])->first()->name,
                        'qty'=> - $source_item['quantity'],
                        'rate'=>$source_item['rate'],
                        'balance_value'=> (- $source_item['quantity'] * $source_item['rate']),
                        'total_balance' => isset($stock) ? ($stock->total_balance - ($source_item['quantity'] * $source_item['rate'])) : ($source_item['quantity'] * $source_item['rate']),
                        'voucher_type'=> isset($request->stock_transfer_type) ? 'Stock entry - '.$request->stock_transfer_type : 'Stock entry',
                        'status'=>3,
                        'created' => date('Y-m-d H:i:s'),
                        'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                    ];
                    $stock_op = StockManagement::insert($stock_data);
                }
                /////// STOCK MANAGEMENT END ///////
            }
            $stockseriesdata=StockSeries::where('status','true')->first();
            if($stockseriesdata)
            {
                $number=(int)$stockseriesdata->series_current_digit+1;
                $stockseriesdata=StockSeries::find($stockseriesdata->id);
                $stockseriesdata->series_current_digit=$number;
                $stockseriesdata->save();
            }
            return redirect()->route('stocks.index')->with('message', __('messages.add', ['name' => 'Stock']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::with('stock_source_items')->find($id);

        if($stock)
        {
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('name', 'id','pack_code')->where('active', 1)->get();
            $stock_items = \App\Models\StockItem::with(['unit', 'alternate_unit'])->where('active', 1)->select('id', 'name', 'unit_id', 'alternate_unit_id', 'pack_code')->get();
            $stockseries=StockSeries::all();
             $documentData=\App\Models\Stock::where([['document_no','!=',null],['active',1]])->get();
            $stock_items_names = $stock_items_codes = $stock_items_units = [];
            if($stock_items->isNotEmpty())
            {
                $stock_items_names = $stock_items->pluck('name', 'id')->toArray();
                $stock_items_codes = $stock_items->pluck('pack_code', 'id')->toArray();

                foreach ($stock_items as $key => $stock_item) {
                    $stock_items_units[$stock_item->id][$stock_item->unit_id] = isset($stock_item->unit->name) ? $stock_item->unit->name : '';
                    $stock_items_units[$stock_item->id][$stock_item->alternate_unit_id] = isset($stock_item->alternate_unit->name) ? $stock_item->alternate_unit->name : '';
                }
            }
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            $stockseriesstatus=StockSeries::where('status','true')->get();
            return view('admin.stocks.show', ['stockItem'=>$stockItem,'stock_transfer_types' => self::$stock_transfer_types, 'warehouses' => $warehouses, 'stock_items_names' => $stock_items_names, 'stock_items_codes' => $stock_items_codes, 'stock_items_units' => $stock_items_units, 'stock' => $stock,'batches'=>$batches,'stockseries'=>$stockseries, 'is_submit_show' => 0,'stockseriesstatus'=>$stockseriesstatus,'documentData'=>$documentData]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::with('stock_source_items')->find($id);

        if($stock)
        {
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('name', 'id','pack_code')->where('active', 1)->get();
            $stock_items = \App\Models\StockItem::with(['unit', 'alternate_unit'])->where('active', 1)->select('id', 'name', 'unit_id', 'alternate_unit_id', 'pack_code')->get();
            $documentData=\App\Models\Stock::where([['document_no','!=',null],['active',1]])->get();
            $stock_items_names = $stock_items_codes = $stock_items_units = [];
            if($stock_items->isNotEmpty())
            {
                $stock_items_names = $stock_items->pluck('name', 'id')->toArray();
                $stock_items_codes = $stock_items->pluck('pack_code', 'id')->toArray();

                foreach ($stock_items as $key => $stock_item) {
                    $stock_items_units[$stock_item->id][$stock_item->unit_id] = isset($stock_item->unit->name) ? $stock_item->unit->name : '';
                    $stock_items_units[$stock_item->id][$stock_item->alternate_unit_id] = isset($stock_item->alternate_unit->name) ? $stock_item->alternate_unit->name : '';
                }
            }
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            $stockseries=StockSeries::all();
            $stockseriesstatus=StockSeries::where('status','true')->get();
            return view('admin.stocks.edit', ['stockItem'=>$stockItem,'stock_transfer_types' => self::$stock_transfer_types, 'warehouses' => $warehouses, 'stock_items_names' => $stock_items_names, 'stock_items_codes' => $stock_items_codes, 'stock_items_units' => $stock_items_units, 'stock' => $stock,'batches'=>$batches,'stockseries'=>$stockseries,'stockseriesstatus'=>$stockseriesstatus,'documentData'=>$documentData]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        $stock = Stock::find($id);

        if($stock)
        {
            $data = [
                'stock_transfer_no' => isset($request->stock_transfer_no) ? $request->stock_transfer_no : NULL,
                'transaction_type' => isset($request->transaction_type) ? $request->transaction_type : NULL,
                'stock_transfer_type' => isset($request->stock_transfer_type) ? $request->stock_transfer_type : NULL,
                'date' => isset($request->date) ? $request->date : NULL
            ];

            if ($stock->update($data))
            {
                $temp_source_items = [];
                $sourceItemsToDelete = StockSourceItem::where('stock_id', $stock->id)->pluck('id', 'id');

                foreach ($request->source_items as $key => $source_item)
                {
                    $stock_item = \App\Models\StockItem::where(['id' => $source_item['item_name'], 'active' => 1])->select('id', 'name', 'pack_code')->first();

                    $createdOrUpdated = StockSourceItem::updateOrCreate([
                        'stock_id' => $stock->id,
                        'item_id' => isset($source_item['item_name']) ? $source_item['item_name'] : 0
                    ],[
                        'stock_id' => $stock->id,
                        'source_warehouse' => isset($source_item['source_warehouse']) ? $source_item['source_warehouse'] : NULL,
                        'target_warehouse' => isset($source_item['target_warehouse']) ? $source_item['target_warehouse'] : NULL,
                        'item_id' => $source_item['item_name'],
                        'item_code' => isset($stock_item->pack_code) ? $stock_item->pack_code : '',
                        'item_name' => isset($stock_item->name) ? $stock_item->name : '',
                        'batch_id' => (isset($source_item['batch']) && !empty($source_item['batch'])) ? $source_item['batch'] : NULL,
                        'uom' => $source_item['uom'],
                        'rate' => $source_item['rate'],
                        'quantity' => $source_item['quantity'],
						'target_batch_id' => (isset($source_item['target_batch']) && !empty($source_item['target_batch'])) ? $source_item['target_batch'] : NULL,
                        'document_no'=>isset($document_no_add) ?'MR0000'.$document_no_add : $request->receiptvalue,
                    ]);

                    if(isset($sourceItemsToDelete[$createdOrUpdated->id])) {
                        unset($sourceItemsToDelete[$createdOrUpdated->id]);
                    }
                }

                if (count($sourceItemsToDelete) > 0) {
                    StockSourceItem::whereIn('id', $sourceItemsToDelete)->delete();
                }

                return redirect()->route('stocks.index')->with('message', __('messages.update', ['name' => 'Stock']));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);

        if ($stock)
        {
            if($stock->stock_source_items()->count() > 0)
            {
                $stock->stock_source_items()->delete();
            }
            $stock->delete();

            return redirect()->route('stocks.index')->with('message', __('messages.delete', ['name' => 'Stock']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function getdata($id)
    {
        $data=StockSeries::where('id',$id)->first();
        return response()->json($data);
    }
    public function stockSourceItemData(Request $request)
    {
        $receiptValue=$request->receiptvalue;
        $stockSourceData=StockSourceItem::where('document_no',$receiptValue)
        ->with(['batch','unit','warehouse','targetbatchid'])->get();
        //dd($stockSourceData);
        return response()->json([
            'succees'=>true,
            'data'=> $stockSourceData
        ]);

    }

    /// Today New Coding 07-10-2021  /////
    public function addMoreValue(Request $request)
    {
        $warehouses_id=$request->target_warehouse;
        $item_id=$request->item_name;
        $batchGet=Batch::where('warehouse_id',$warehouses_id)->where('stock_item_id',$item_id)->get()->toArray();
        

        return json_encode($batchGet);
    }
}
