<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\PurchaseReceiptRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\PurchaseLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\InventoryUnit;
use App\Models\PurchaseOrder;
use App\Models\PoItems;
use App\Models\PoOtherCharges;
use App\Models\PurchaseReceiptItems;
use App\Models\PurchaseReceipt;
use App\Models\Batch;
use App\Models\QcReports;
use App\Models\StockManagement;
use App\Models\StockQtyManagement;
use App\Models\PurchaseRecieptSeries;


class PurchaseReceiptController extends CoreController
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
            'title' => 'Receipt',
            'route_name' => 'purchase',
            'back_link' => route('transactions.purchase'),
            'add_link' => route('purchase-receipt.create'),
            'add_link_route' => 'purchase-receipt.create',
            'store_link' => 'purchase-receipt.store',
            'edit_link' => 'purchase-receipt.edit',
            'update_link' => 'purchase-receipt.update',
            'delete_link' => 'purchase-receipt.destroy',
            'listing_link' => 'purchase-receipt.index',
            'order_type' => 10,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $pr = PurchaseReceipt::orderByDesc('id')->get();
        return view('admin.transactions.purchase.purchase-receipt.index',['other' => $this->other,'receipts'=>$pr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        /*$po_Item = PoItems::with('stock_items')->where('status','<>',3)->get();
        foreach($po_Item as $p)
        {
            $data['stock_item_id'] = $p->stock_items->id;
            $data['stock_item_name'] = $p->stock_items->name;
            $final[] = $data;
        }
        $result = array_column($final, 'stock_item_name', 'stock_item_id');
        echo '<pre>';print_r($result);exit;*/
        //$combine_items = array_combine($final);
       // $serialize_items = array_map("unserialize", array_unique(array_map("serialize", $combine_items)));
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = StockItem::select('name', 'id','pack_code')->where('active', 1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $purchase_orders = PurchaseOrder::orderBy('id','desc')->where('po_status','!=', 1)->where('po_status','!=',3)->pluck('order_no', 'id')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();

        $series = 'PR-'.date('Ymdhis');
        $purchasereciptseries=PurchaseRecieptSeries::all();
        $purchasereciptseriesstatus=PurchaseRecieptSeries::where('status','true')->get();
//        print'<pre>';
//        print_r($stockItem);
//        die;
        return view('admin.transactions.purchase.purchase-receipt.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units'=>$units,
                'purchase_orders'=>$purchase_orders,
                'batches'=>$batches,
                'series' => $series,
                'purchasereciptseries'=>$purchasereciptseries,
                'purchasereciptseriesstatus'=>$purchasereciptseriesstatus

            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseReceiptRequest $request)
    {
       // dd($request->all());
        //dd($request->all());
        $voucher_no = 'MR-PR-'.date('ymdhi');

        // $warehouse = (isset($request->warehouse_id) && !empty($request->warehouse_id)) ? $request->warehouse_id : '';
        /*$purchasereceiptseries=PurchaseReceipt::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($purchasereceiptseries)      
        {
            $number = (int)$purchasereceiptseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $receipt_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $receipt_id=str_replace("XXXX","",$request->receipt_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $receipt_id=str_replace("XXXX","",$number.$request->receipt_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $receipt_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:purchase_receipt,receipt_no'],
                ['manual_id.required'=>'The Receipt id field is required',
                'manual_id.unique'=>'The Receipt id has already been taken',
                ],
            );
         $receipt_id=$request->manual_id;   
        }*/
            $this->validate($request,[
                'receipt_no'=>'required|unique:purchase_receipt,receipt_no',
            ]);

        $pr = PurchaseReceipt::create([
            'voucher_no' => $voucher_no,
            'supplier_id' => $request->supplier_id,
            'branch_id'=> isset($request->branch_id) ? $request->branch_id : NULL,
             'main_branch'=> isset($request->branch_id) ? $request->branch_id : NULL,
            'warehouse_id'=> isset($request->warehouse_id) ? $request->warehouse_id : NULL,
            /*'batch_id' => $request->batch_id,*/
            'batch_id' => (isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL,
            'receipt_no'=> $request->receipt_no,
            'po_id'=> $request->po_id,
            'address'=> $request->address,
            'date'=> $request->date,
            'qc_status' => isset($request->qc_status) ? $request->qc_status : 0,
            'approved_vendor_code'=> $request->approved_vendor_code,
            'shortage_qty'=> $request->po_quantity - $request->receipt_quantity,
            'good_condition_container'=> $request->good_condition_container,
            'container_have_product'=> $request->container_have_product,
            'container_have_tare_weight' => $request->container_have_tare_weight,
            'container_have_product_remark' => isset($request->container_have_product_remarks) ? $request->container_have_product_remarks : '',
            'good_condition_container_remark' => isset($request->good_condition_container_remarks) ? $request->good_condition_container_remarks : '',
            'container_have_tare_weight_remark' => isset($request->container_have_tare_weight_remarks) ? $request->container_have_tare_weight_remarks : '',
            'container_dedust_with'=> $request->container_dedust_with,
            'dedust_done_by'=> $request->dedust_done_by,
            'dedust_check_by'=> $request->dedust_check_by,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);

        if($pr)
        {
            $rate = isset($request->po_id) ? PoItems::select('rate')->where('po_id',$request->po_id)->first()->rate : 0;
            $pri = PurchaseReceiptItems::create([
                'receipt_id' => $pr->id,
                'stock_item_id'=> $request->stock_item_id,
                'item_code'=> $request->item_code,
                'unit'=> $request->unit,
                'po_quantity'=> $request->po_quantity,
                'receipt_quantity'=> $request->receipt_quantity,
                'rate'=> $rate,
                'balance'=> ($request->receipt_quantity * $rate),
                'no_of_container'=> $request->no_of_container,
                'batch_id' => (isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL
            ]);

            if($pri)
            {
                $remaining_items = $request->po_quantity - $request->receipt_quantity;

                $status = ($request->receipt_quantity >= $remaining_items) ? 3 : 2;
                $update_poitem = [
                    'item_received' => $request->receipt_quantity,
                    'item_pending' => $remaining_items,
                    'status' => $status
                ];
                $poItems = PoItems::where('po_id',$request->po_id)->where('stock_item_id',$request->stock_item_id)->update($update_poitem);
                //if ($poItems->update($update_poitem)){}
            }

            $stock = StockManagement::where('stock_item_id',$request->stock_item_id)->orderBy('id', 'DESC')->first();
            $balance_quantity=StockManagement::where('stock_item_id',$request->stock_item_id)
                                                ->where('warehouse_id',$request->warehouse_id)
                                                ->orderBy('id', 'DESC')->first();
            $stock_data =[
                'voucher_no' => $voucher_no,
                'stock_item_id'=>$request->stock_item_id,
                /*'batch_id'=>$request->batch_id,*/
                'batch_id'=>(isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL,
                'warehouse_id'=>$request->warehouse_id,
                'item_name'=>PurchaseReceiptItems::where('stock_item_id',$request->stock_item_id)->first()->stockItems->name,
                'pack_code'=>PurchaseReceiptItems::where('stock_item_id',$request->stock_item_id)->first()->stockItems->pack_code,
                'uom'=>$request->unit,
                'qty'=>$request->receipt_quantity,
                'balance_qty'=> isset($balance_quantity) ? ($balance_quantity->balance_qty+$request->receipt_quantity) : ($request->receipt_quantity),
                'rate'=>$rate,
                'balance_value'=> ($request->receipt_quantity * $rate),
                'total_balance' => isset($stock) ? ($stock->total_balance + ($request->receipt_quantity * $rate)) : ($request->receipt_quantity * $rate),
                'voucher_type'=>'Purchase Receipt',
                'status'=>1,
                'created' => date('Y-m-d H:i:s'),
            ];

            $stock_op = StockManagement::insert($stock_data);

            $stock_qty_management = StockQtyManagement::where('stock_item_id',$request->stock_item_id)->where('warehouse_id',$request->warehouse_id);
            if(isset($request->item_batch_id) && !empty($request->item_batch_id))
            {
                $stock_qty_management->where('batch_id',$request->batch_id);
            }
            $stock_qty_management = $stock_qty_management->first();

            if($stock_qty_management)
            {
                $stock_qty_id = $stock_qty_management->id;
                $qty = $stock_qty_management->qty;
                $balance = $stock_qty_management->balance_value;
                $receipt_quantity = $request->receipt_quantity;
                $stock_qty_data =[
                    'stock_item_id'=>$request->stock_item_id,
                    'batch_id'=> (isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL,
                    'warehouse_id'=>$request->warehouse_id,
                    'qty'=>$qty + $receipt_quantity,
                    'balance_value'=> $balance + ($receipt_quantity * $rate)
                ];
                $stock_qty = StockQtyManagement::where('id', $stock_qty_id)->update($stock_qty_data);
            }else{
                $stock_qty_data =[
                    'stock_item_id'=>$request->stock_item_id,
                    'batch_id'=>(isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL,
                    'warehouse_id'=>$request->warehouse_id,
                    'qty'=>$request->receipt_quantity,
                    'balance_value'=> ($request->receipt_quantity * $rate)
                ];

                $stock_qty = StockQtyManagement::insert($stock_qty_data);
            }

            /*if($stock)
            {
                $stock_op = StockManagement::where('stock_item_id',$request->stock_item_id)->where('batch_id',$request->batch_id)->where('warehouse_id',$request->warehouse_id)->update($stock_data);
            }else{
                $stock_op = StockManagement::insert($stock_data);
            }*/
            $purchasereceiptseries=PurchaseRecieptSeries::where('status','true')->first();
            if($purchasereceiptseries){
                $number=(int)$purchasereceiptseries->series_current_digit+1;
                $purchasereceiptseries=PurchaseRecieptSeries::find($purchasereceiptseries->id);
                $purchasereceiptseries->series_current_digit=$number;
                $purchasereceiptseries->save();
            }
            return redirect()->route('purchase-receipt.index')->with('message', __('messages.add', ['name' => 'Purchase Receipt']));
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
        if($id)
        {
            $order = PurchaseReceipt::with('purchase_items')->find($id);
            
            $consignee_address = ConsigneeAddress::where('ledger_type',2)->pluck('branch_name', 'id')->toArray();
            
            $suppliers = PurchaseLedger::pluck('ledger_name', 'id')->toArray();
            
            $warehouses = Warehouse::pluck('name', 'id')->toArray();
            
            $user = Sentinel::getUser();
            
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            
            $units = InventoryUnit::pluck('name', 'name')->toArray();

            $purchase_orders = PurchaseOrder::pluck('order_no', 'id')->toArray();
            
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

            $stockItemIds = StockItem::pluck('id', 'id')->toArray();
            $purchasereciptseries=PurchaseRecieptSeries::all();
            $purchasereciptseriesstatus=PurchaseRecieptSeries::where('status','true')->get();
            if($stockItemIds[$order->purchase_items->stock_item_id] == $order->purchase_items->stock_item_id)
            {
//                $stockItem = StockItem::where('active', 1)->where('id',$order->purchase_items->stock_item_id)->pluck('name', 'id')->toArray();
                $stockItem = StockItem::select('name', 'id','pack_code')->where('id',$order->purchase_items->stock_item_id)->get();
            }else{
                $stockItem = StockItem::select('name', 'id','pack_code')->get();
//                $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            }

            return view('admin.transactions.purchase.purchase-receipt.show',
                        [
                            'is_submit_show'=>1,
                            'other' => $this->other,
                            'stockItem'=>$stockItem,
                            'consignee_address'=>$consignee_address,
                            'suppliers' => $suppliers,
                            'warehouses' => $warehouses,
                            'sales_person' => $sales_person,
                            'generalLedger' => $generalLedger,
                            'units' => $units,
                            'purchase_orders' => $purchase_orders,
                            'order' => $order,
                            'batches'=>$batches,
                           'purchasereciptseries'=>$purchasereciptseries,
                            'purchasereciptseriesstatus'=>$purchasereciptseriesstatus
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
            $order = PurchaseReceipt::with('purchase_items')->find($id);
            $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
            $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
            $purchase_orders = PurchaseOrder::where('status', 1)->pluck('order_no', 'id')->toArray();
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

            $stockItemIds = StockItem::where('active', 1)->pluck('id', 'id')->toArray();
            if($stockItemIds[$order->purchase_items->stock_item_id] == $order->purchase_items->stock_item_id)
            {
                // $stockItem = StockItem::where('active',1)->where('id',$order->purchase_items->stock_item_id)->pluck('name', 'id')->toArray();
                $stockItem = StockItem::select('name', 'id','pack_code')->where('id',$order->purchase_items->stock_item_id)->where('active', 1)->get();
            }else{
                $stockItem = StockItem::select('name', 'id','pack_code')->where('active', 1)->get();
                // $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            }

            return view('admin.transactions.purchase.purchase-receipt.edit',
                        [
                            'other' => $this->other,
                            'stockItem'=>$stockItem,
                            'consignee_address'=>$consignee_address,
                            'suppliers' => $suppliers,
                            'warehouses' => $warehouses,
                            'sales_person' => $sales_person,
                            'generalLedger' => $generalLedger,
                            'units' => $units,
                            'purchase_orders' => $purchase_orders,
                            'order' => $order,
                            'batches' => $batches
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
    public function update(PurchaseReceiptRequest $request, $id)
    {

        $data = [
            'supplier_id' => $request->supplier_id,
            'branch_id'=> isset($request->branch_id) ? $request->branch_id : NULL,
            'warehouse_id'=> isset($request->warehouse_id) ? $request->warehouse_id : NULL,
            /*'batch_id' => $request->batch_id,*/
            'batch_id' => (isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL,
            'receipt_no'=> $request->receipt_no,
            'po_id'=> $request->po_id,
            'address'=> $request->address,
            'date'=> $request->date,
            'qc_status' => $request->qc_status,
            'approved_vendor_code'=> $request->approved_vendor_code,
            'shortage_qty'=> $request->po_quantity - $request->receipt_quantity,
            'good_condition_container'=> $request->good_condition_container,
            'container_have_product'=> $request->container_have_product,
            'container_have_tare_weight' => $request->container_have_tare_weight,
            'container_have_product_remark' => isset($request->container_have_product_remarks) ? $request->container_have_product_remarks : '',
            'good_condition_container_remark' => isset($request->good_condition_container_remarks) ? $request->good_condition_container_remarks : '',
            'container_have_tare_weight_remark' => isset($request->container_have_tare_weight_remarks) ? $request->container_have_tare_weight_remarks : '',
            'container_dedust_with'=> $request->container_dedust_with,
            'dedust_done_by'=> $request->dedust_done_by,
            'dedust_check_by'=> $request->dedust_check_by
        ];
        //echo '<pre>';print_r($data);exit;

        $pr = PurchaseReceipt::find($id);

        if($pr)
        {
            if ($pr->update($data))
            {
                $rate = isset($request->po_id) ? PoItems::select('rate')->where('po_id',$request->po_id)->first()->rate : 0;
                $ItemData = [
                    'receipt_id' => $pr->id,
                    'stock_item_id'=> $request->stock_item_id,
                    'item_code'=> $request->item_code,
                    'unit'=> $request->unit,
                    'po_quantity'=> $request->po_quantity,
                    'receipt_quantity'=> $request->receipt_quantity,
                    'rate'=> $rate,
                    'balance'=> ($request->receipt_quantity * $rate),
                    'no_of_container'=> $request->no_of_container,
                    'batch_id' => (isset($request->item_batch_id) && !empty($request->item_batch_id)) ? $request->item_batch_id : NULL
                ];
                $poItems = PurchaseReceiptItems::where('receipt_id',$pr->id)->where('stock_item_id',$request->stock_item_id)->update($ItemData);

                if($poItems)
                {
                    $remaining_items = $request->po_quantity - $request->receipt_quantity;

                    $status = ($request->receipt_quantity >= $remaining_items) ? 3 : 2;
                    $update_poitem = [
                        'item_received' => $request->receipt_quantity,
                        'item_pending' => $remaining_items,
                        'status' => $status
                    ];
                    $poItems = PoItems::where('po_id',$request->po_id)->where('stock_item_id',$request->stock_item_id)->update($update_poitem);
                    //if ($poItems->update($update_poitem)){}
                }
            }
        }


        $qc_pr = QcReports::where('purchase_receipt_id',$id)->get();
        if($qc_pr)
        {
            if(isset($request->warehouse_id))
            {
                QcReports::where('purchase_receipt_id', '=', $id)
                ->update(['warehouse_id' => $request->warehouse_id]);
            }
            if(isset($request->item_batch_id))
            {
                QcReports::where('purchase_receipt_id', '=', $id)
                ->update(['batch_id'=>$request->item_batch_id]);
            }
        }
        return redirect()->route('purchase-receipt.index')->with('message', __('messages.add', ['name' => 'Purchase Receipt']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return redirect()->route('purchase-receipt.index');

        $purchaseReceipt = PurchaseReceipt::find($id);

        if ($purchaseReceipt)
        {
            $purchaseReceipt->delete();

            return redirect()->route('purchase-receipt.index')->with('message', __('messages.delete', ['name' => 'Purchase Receipt']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    public function getPoItemsDetails(Request $request)
    {
        //print_r($request);
        $po_id = $request->po_id;
        $po_Item = PoItems::with('stock_items')->where('po_id',$po_id)->get();

        $final = [];
        foreach($po_Item as $p)
        {
            if(isset($p->stock_items->id))
            {
                $data['stock_item_id'] = $p->stock_items->id;
                $data['stock_item_name'] = $p->stock_items->pack_code.'-'.$p->stock_items->name;
                $final[] = $data;
            }
        }

        
        $sfinal = [];
        $po_suppliers = PurchaseOrder::with('suppliers')->get();
        foreach($po_suppliers as $s)
        {
            if(isset($s->suppliers->id)) {
                $sdata['supplier_id'] = $s->suppliers->id;
                $sdata['supplier_name'] = $s->suppliers->ledger_name;
                $sfinal[] = $sdata;
            }
        }

        $bfinal = [];
        $po_branches = PurchaseOrder::with('branches')->get();
        foreach($po_branches as $b)
        {
            if(isset($b->branches->id)) {
                $bdata['branch_id'] = isset($b->branches->id) ? $b->branches->id : '';
                $bdata['branch_name'] = isset($b->branches->branch_name) ? $b->branches->branch_name : '';
                $bfinal[] = $bdata;
            }
        }

        //print_r($sfinal);
        $serialize_items = array_map("unserialize", array_unique(array_map("serialize", $final)));
        $result = array_column($final, 'stock_item_name', 'stock_item_id');

        $serialize_sup = array_map("unserialize", array_unique(array_map("serialize", $sfinal)));
        $sup_result = array_column($sfinal, 'supplier_name', 'supplier_id');

        $serialize_br = array_map("unserialize", array_unique(array_map("serialize", $bfinal)));
        $branch_result = array_column($bfinal, 'branch_name', 'branch_id');

        $po_order_details = PurchaseOrder::where('id',$po_id)->first();

        $po_stock_item = PoItems::with('stock_items')->where('po_id',$po_id)->first();

        //print_r($po_Item);
        return response()->json(['po_order_details'=>$po_order_details,'po_items'=>$result,'suppliers'=>$sup_result,'branches'=>$branch_result, 'po_stock_item' => $po_stock_item]);

    }

    function getStockItems(Request $request)
    {
        $item_id = $request->item_id;
        $po_id= $request->po_id;

        $stockItem = StockItem::find($item_id);
        $poDetails = PoItems::where('po_id',$po_id)->where('stock_item_id',$item_id)->get()->toArray();

        $batches = Batch::where(['stock_item_id' => $item_id, 'active' => 1])->pluck('batch_id', 'id')->toArray();

        return response()->json(['stockItem'=>$stockItem,'poDetails'=>$poDetails, 'batches' => $batches]);
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
            $purchaseReceipt = PurchaseReceipt::with(['purchase_items', 'purchase_order'])->find($id);

            $pdf = \PDF::loadView('admin.transactions.purchase.purchase-receipt.print', ['purchaseReceipt' => $purchaseReceipt]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            // return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata(Request $request,$id)
    {
        $data=PurchaseRecieptSeries::where('id',$id)->first();

        return response()->json($data);
    }
    public function getReceiptDetails(Request $request)
    {
        $branch_id=$request->branch_id;
        $supplier_details = ConsigneeAddress::where('active', 1)->where('ledger_id',$branch_id)->get();
        return response()->json(['supplier_details'=>$supplier_details]);
    }
}
