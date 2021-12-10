<?php

//namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\PurchaseOrderRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\PurchaseLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\PurchaseOrder;
use App\Models\PoItems;
use App\Models\PoOtherCharges;
use App\Models\InventoryUnit;
use App\Models\Transporter;
use App\Models\Materials;
use App\Models\PurchaseOrderSeries;

class PurchaseOrderController extends CoreController
{
    protected static $material_type = [
        'Purchase' => 'Purchase'
    ];

    public $other;
    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->other = (Object) [
            'title' => 'Order',
            'route_name' => 'purchase',
            'back_link' => route('transactions.purchase'),
            'add_link' => route('purchase-order.create'),
            'add_link_route' => 'purchase-order.create',
            'store_link' => 'purchase-order.store',
            'edit_link' => 'purchase-order.edit',
            'update_link' => 'purchase-order.update',
            'delete_link' => 'purchase-order.destroy',
            'listing_link' => 'purchase-order.index',
            'order_type' => 1,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $pos = PurchaseOrder::with(['purchase_invoice', 'purchase_receipt'])->get();
        // echo '<pre>';print_r($pos->toArray());echo '</pre>';exit;
        return view('admin.transactions.purchase.purchase-order.index',['other' => $this->other,'purchase_orders' => $pos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consignee_address = array();
        $purchaseorderseries=PurchaseOrderSeries::all();
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $materials = Materials::where('active', 1)->where('po_status',0)->pluck('series_id', 'series_id')->toArray();
        $materials_stock_items = Materials::with('material_items')->where('active', 1)->get();
        // $materials_data = Materials::with('material_items')->where('active', 1)->where('po_status',NULL)->get();
        $materials_data = Materials::doesnthave('purchase_order')->with('material_items')->where('active', 1)->get();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();

        $transporter = Transporter::where('active', 1)->pluck('name', 'id')->toArray();

        return view('admin.transactions.purchase.purchase-order.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'transporter' => $transporter,
                'materials' => $materials,
                'materials_data' => $materials_data,
                'materials_stock_items' => $materials_stock_items,
                'purchase_order_page' => 1,
                'purchaseorderseries'=>$purchaseorderseries,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {

        
        $request->validate([
            'material_id' => 'required_without:po_item_id',
            'po_item_id' => 'required_without:material_id'
        ]);
        $material=PurchaseOrder::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($material)
        {
            $number = (int)$material->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
            $series_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);
        }
        elseif(!empty($request->prefix))
        {
          $series_id=str_replace("XXXX","",$request->order_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $series_id=str_replace("XXXX","",$number.$request->order_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $series_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:purchase_orders,order_no'],
                ['manual_id.required'=>'The Order no field is required',
                'manual_id.unique' =>'The Order no has already been taken'
                ],
            );
         $series_id=$request->manual_id;   
        }

        $po = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            //'supplier_name' => isset($request->supplier_id) ? PurchaseLedger::find($request->supplier_id)->ledger_name : '',
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            //'branch'=> isset($request->branch_id) ? ConsigneeAddress::find($request->branch_id)->address : '',
            'warehouse_id'=> $request->warehouse_id,
            //'warehouse'=> ($request->warehouse_id != 0) ? Warehouse::find($request->warehouse_id)->name : '',
            'order_no'=> isset($series_id) ? $series_id : NULL,
            'material_id'=> $request->material_id,
            'order_date'=> $request->order_date,
            'address'=> $request->address,
            'required_date'=> $request->required_date,
            'net_amount'=> $request->total_net_amount,
            'total_net_amount'=> $request->total_grand_amount,
            'other_net_amount'=> $request->other_net_amount,
            'total_other_net_amount'=> $request->total_other_net_amount,
            //'total_cess_amount' => $request->total_cess_amount,
            'discount_in_per'=> $request->discount_in_per,
            'discount_amount'=> $request->discount_amount,
            'grand_total'=> $request->grand_total,
            'igst'=> $request->igst,
            'sgst'=> $request->sgst,
            'cgst'=> $request->cgst,
            'transporter'=> $request->transporter,
            'reference'=> $request->reference,
            'credit_days'=> $request->credit_days,
            //'series_id' => $request->credit_days,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            //'type' => isset($request->type) ? $request->type : NULL,
            'status' => isset($request->status) ? $request->status : 1,
            'po_item_id' => (isset($request->po_item_id) && !empty($request->po_item_id)) ? $request->po_item_id : NULL,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>$number,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);

        if($po)
        {

            if(isset($request->items) && !empty($request->items))
            {
                $stock_data = [];
                foreach ($request->items as $key => $items)
                {
                    if(isset($items['item_name']))
                    {
                        $stock_data[] = [
                            'po_id' => $po->id,
                            'stock_item_id' => $items['item_name'],
                            'item_code' => $items['item_code'],
                            'unit' => $items['unit'],
                            'quantity' => $items['quantity'],
                            'rate' => $items['rate'],
                            'net_amount' => $items['net_amount'],
                            'tax' => $items['tax'],
                            'tax_amount' => $items['tax_amount'],
                            'discount_in_per' => $items['discount'],
                            'discount' => $items['discount_amount'],
                            //'cess' => $items['cess'],
                            //'cess_amount' => $items['cess_amount'],
                            'total_amount' => $items['total_amount'],
                            'item_pending' => $items['quantity'],
                            'status' => isset($request->status) ? $request->status : 1,
                            'item_received' => 0,
                        ];
                    }
                }

                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    PoItems::insert($stock_data);
                }
            }

            if(isset($request->other_taxes) && !empty($request->other_taxes))
            {
                $tax_data = [];
                foreach ($request->other_taxes as $key => $taxes)
                {
                    if(isset($taxes['type']))
                    {
                        //$tax_data[$taxes['type']] = (isset($tax_data[$taxes['type']]) && !empty($tax_data[$taxes['type']])) ? $tax_data[$taxes['type']] : [];

                        $tax_data[] = [
                            'po_id' => $po->id,
                            'type' => $taxes['type'],
                            'general_ledger_id' => isset($taxes['account_head']) ? $taxes['account_head'] : NULL,
                            'rate' => $taxes['other_rate'],
                            'amount' => $taxes['other_amount'],
                            'tax' => $taxes['other_tax'],
                            'tax_amount' => $taxes['other_tax_amount'],
                            'total_amount' => $taxes['other_total_amount'],
                        ];
                    }
                }
                if(!empty($tax_data) && count($tax_data) > 0)
                {
                    PoOtherCharges::insert($tax_data);
                    //$po->po_other_charges()->createMany($tax_data);
                }
            }


            $update_data = ["po_status"=>1];
            Materials::where('id', $request->material_id)->update($update_data);

            return redirect()->route('purchase-order.index')->with('message', __('messages.add', ['name' => 'PO']));
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
            $order = PurchaseOrder::with('items','other_charges')->find($id);
            $consignee_address = ConsigneeAddress::where('ledger_id',$order->supplier_id)->where('ledger_type',2)->get();
            $suppliers = PurchaseLedger::pluck('ledger_name', 'id')->toArray();
            $warehouses = Warehouse::pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $units = InventoryUnit::pluck('name', 'name')->toArray();
            $transporter = Transporter::pluck('name', 'id')->toArray();
            $materials = Materials::pluck('series_id', 'series_id')->toArray();
            $materials_stock_items = Materials::with('material_items')->get();
            // $materials_data = Materials::get();
            $materials_data = Materials::whereDoesntHave('purchase_order', function($query) use ($order) {
                $query->where('material_id', '!=', $order->material_id);
            })->with('material_items')->where('active', 1)->get();

            return view('admin.transactions.purchase.purchase-order.show',
                        [
                            'is_submit_show'=>1,
                            'other' => $this->other,
                            'stockItem'=>$stockItem,
                            'consignee_address_po'=>$consignee_address,
                            'suppliers' => $suppliers,
                            'warehouses' => $warehouses,
                            'sales_person' => $sales_person,
                            'generalLedger' => $generalLedger,
                            'units' => $units,
                            'order' => $order,
                            'transporter' => $transporter,
                            'materials' => $materials,
                            'materials_data' => $materials_data,
                            'materials_stock_items' => $materials_stock_items,
                            'purchase_order_page' => 1
                        ]);
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
            $order = PurchaseOrder::with('items','other_charges')->find($id);
            $purchaseorderseries=PurchaseOrderSeries::all();
            $consignee_address = ConsigneeAddress::where('ledger_id',$order->supplier_id)->where('ledger_type',2)->where('active',1)->get();
            //$consignee_address = ConsigneeAddress::pluck('branch_name', 'id')->toArray();
            $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
            $transporter = Transporter::where('active', 1)->pluck('name', 'id')->toArray();
            $materials = Materials::where('active', 1)->pluck('series_id', 'series_id')->toArray();
            $materials_stock_items = Materials::with('material_items')->where('active', 1)->get();

            // $materials_data = Materials::where('active', 1)->get();
            $materials_data = Materials::whereDoesntHave('purchase_order', function($query) use ($order) {
                $query->where('material_id', '!=', $order->material_id);
            })->with('material_items')->where('active', 1)->get();

            return view('admin.transactions.purchase.purchase-order.edit',
                        [
                            'other' => $this->other,
                            'stockItem'=>$stockItem,
                            'consignee_address_po'=>$consignee_address,
                            'suppliers' => $suppliers,
                            'warehouses' => $warehouses,
                            'sales_person' => $sales_person,
                            'generalLedger' => $generalLedger,
                            'units' => $units,
                            'order' => $order,
                            'transporter' => $transporter,
                            'materials' => $materials,
                            'materials_data' => $materials_data,
                            'materials_stock_items' => $materials_stock_items,
                            'purchase_order_page' => 1,
                            'purchaseorderseries'=>$purchaseorderseries,
                        ]);
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
    public function update(PurchaseOrderRequest $request, $id){
       // echo '<pre>';
       // print_r($request->all());exit;

        $request->validate([
            'material_id' => 'required_without:po_item_id',
            'po_item_id' => 'required_without:material_id'
        ]);

        $data = [
            'supplier_id' => $request->supplier_id,
            //'supplier_name' => isset($request->supplier_id) ? PurchaseLedger::find($request->supplier_id)->ledger_name : '',
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            //'branch'=> isset($request->branch_id) ? ConsigneeAddress::find($request->branch_id)->address : '',
            'warehouse_id'=> $request->warehouse_id,
            //'warehouse'=> ($request->warehouse_id != 0) ? Warehouse::find($request->warehouse_id)->name : '',
            'order_no'=> $request->order_no,
            'material_id'=> $request->material_id,
            'order_date'=> $request->order_date,
            'address'=> $request->address,
            'required_date'=> $request->required_date,
            'net_amount'=> $request->total_net_amount,
            'total_net_amount'=> $request->total_grand_amount,
            'other_net_amount'=> $request->other_net_amount,
            'total_other_net_amount'=> $request->total_other_net_amount,
            //'total_cess_amount' => $request->total_cess_amount,
            'discount_in_per'=> $request->discount_in_per,
            'discount_amount'=> $request->discount_amount,
            'grand_total'=> $request->grand_total,
            'igst'=> $request->igst,
            'sgst'=> $request->sgst,
            'cgst'=> $request->cgst,
            'transporter'=> $request->transporter,
            'reference'=> $request->reference,
            'credit_days'=> $request->credit_days,
            // 'series_id' => $request->credit_days,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            //'type' => isset($request->type) ? $request->type : NULL,
            'status' => isset($request->status) ? $request->status : 1,
            'po_item_id' => (isset($request->po_item_id) && !empty($request->po_item_id)) ? $request->po_item_id : NULL
        ];

        $po = PurchaseOrder::find($id);

        if($po)
        {
            if ($po->update($data))
            {
                if(isset($request->items) && !empty($request->items))
                {
                    //PoItems::where('po_id',$id)->update(['active' => '0']);
                    $stock_data = $keep_items = [];

                    foreach ($request->items as $key => $items)
                    {
                        if(isset($items['item_name']))
                        {
                            $stock_data = [
                                'po_id' => $po->id,
                                'stock_item_id' => $items['item_name'],
                                'item_code' => $items['item_code'],
                                'unit' => $items['unit'],
                                'quantity' => $items['quantity'],
                                'rate' => $items['rate'],
                                'net_amount' => $items['net_amount'],
                                'tax' => $items['tax'],
                                'tax_amount' => $items['tax_amount'],
                                'discount_in_per' => $items['discount'],
                                'discount' => $items['discount_amount'],
                                // 'cess' => $items['cess'],
                                // 'cess_amount' => $items['cess_amount'],
                                'total_amount' => $items['total_amount'],
                                'item_pending' => $items['quantity'],
                                'item_received' => 0,
                                'status' => isset($request->status) ? $request->status : 1,
                                'active' => 1
                            ];

                            $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                            $poItem = PoItems::updateOrCreate([
                                'id' => $items['item_id']
                            ], $stock_data);

                            $keep_items[] = $poItem->id;
                        }
                    }

                    if(isset($keep_items) && !empty($keep_items))
                    {
                        PoItems::where('po_id', $po->id)->whereNotIn('id', $keep_items)->delete();
                    }
                }

                if(isset($request->other_taxes) && !empty($request->other_taxes))
                {
                    $tax_data = $keep_other_items = [];
                    foreach ($request->other_taxes as $key => $taxes)
                    {
                        if(isset($taxes['type']))
                        {
                            //$tax_data[$taxes['type']] = (isset($tax_data[$taxes['type']]) && !empty($tax_data[$taxes['type']])) ? $tax_data[$taxes['type']] : [];

                            $tax_data = [
                                'po_id' => $po->id,
                                'type' => $taxes['type'],
                                'general_ledger_id' => $taxes['account_head'],
                                'rate' => $taxes['other_rate'],
                                'amount' => $taxes['other_amount'],
                                'tax' => $taxes['other_tax'],
                                'tax_amount' => $taxes['other_tax_amount'],
                                'total_amount' => $taxes['other_total_amount'],
                            ];

                            $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                            $PoOtherCharge = PoOtherCharges::updateOrCreate([
                                'id' => $items['other_charge_id']
                            ], $tax_data);

                            $keep_other_items[] = $PoOtherCharge->id;
                        }
                    }
                    if(!empty($keep_other_items) && count($keep_other_items) > 0)
                    {
                        PoOtherCharges::where('po_id', $po->id)->whereNotIn('id', $keep_other_items)->delete();
                    }
                }

                $update_data = ["po_status"=>1];
                Materials::where('id', $request->material_id)->update($update_data);

                return redirect()->route('purchase-order.index')->with('message', __('messages.update', ['name' => 'PO']));
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
       $purchaseOrder = PurchaseOrder::find($id);

        if ($purchaseOrder)
        {
            $purchaseOrder->material_request->po_status = NULL;
            $purchaseOrder->material_request->save();

            $purchaseOrder->delete();

            return redirect()->route('purchase-order.index')->with('message', __('messages.delete', ['name' => 'Purchase Order']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function GetStockDetails(Request $request)
    {
        //$input = $request->all();
        $stock_item_id = $request->stock_item_id;
        $stock_details = StockItem::find($stock_item_id);
        $unit = $stock_details->InventoryUnit->name;
        $tax=$cess=0;
        if($stock_details->is_gst_detail==1){
            if($stock_details->taxability == 'taxable'){
              $tax =  !empty($stock_details->rate) ?  $stock_details->rate : 0;
              $cess = !empty($stock_details->rate) ?  $stock_details->cess : 0;
            }
        }
        return response()->json(['stock_details'=>$stock_details,'unit'=>$unit,'tax'=>$tax,'cess'=>$cess]);
        //print_r($input);
    }

    function getSupplierDetails(Request $request)
    {
        //$input = $request->all();
        $supplier_id = $request->supplier_id;
        // $supplier_details = PurchaseLedger::find($supplier_id);
        $supplier_details = PurchaseLedger::with('consignee_addresses')->where('active', 1)->where('id',$supplier_id)->first();
        return response()->json(['supplier_details'=>$supplier_details]);
    }

    public function getMaterialItemDetails(Request $request)
    {
        //$input = $request->all();
        $material_id = $request->material_id;
        $material = Materials::with('material_items')->find($material_id);

        if(isset($material) && isset($material->material_items) && $material->material_items->isNotEmpty())
        {
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();

            $view = view('admin.transactions.purchase.purchase-order.stock-item', ['material' => $material, 'stockItem' => $stockItem, 'units' => $units])->render();

            return response()->json(['success' => true, 'view' => $view]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        if($id)
        {
            $purchaseOrder = PurchaseOrder::with(['items.stock_items' => function($query) {
                $query->select('id', 'name');
            },'other_charges', 'target_warehouse'])->find($id);
            dd($purchaseOrder);
            $pdf = \PDF::loadView('admin.transactions.purchase.purchase-order.print', ['purchaseOrder' => $purchaseOrder]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
     public function getdata(Request $request,$id)
    {
        $data=PurchaseOrderSeries::where('id',$id)->first();

        return response()->json($data);
    }
}
