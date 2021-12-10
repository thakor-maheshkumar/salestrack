<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\SalesOrderRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\SalesLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\InventoryUnit;
use App\Models\Quotation;
use App\Models\SalesOrders;
use App\Models\SalesOrdersItems;
use App\Models\SalesOrdersOtherCharges;
use App\Models\StockManagement;
use App\Models\Batch;
use App\Models\SalesOrderSeries;


class SalesOrderController extends CoreController
{
    protected static $material_type = [
        'Sales' => 'Sales'
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
            'route_name' => 'sales',
            'back_link' => route('transactions.sales'),
            'add_link' => route('sales-order.create'),
            'add_link_route' => 'sales-order.create',
            'store_link' => 'sales-order.store',
            'edit_link' => 'sales-order.edit',
            'update_link' => 'sales-order.update',
            'delete_link' => 'sales-order.destroy',
            'listing_link' => 'sales-order.index',
            'order_type' => 2,
            'show_sales_batch' => 1,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $so = SalesOrders::with(['sales_invoices' => function($q) {
            $q->select('id', 'sales_order_id');
        },'salesPerson'])->where('active','1')->orderBy('id','desc')->get();

        return view('admin.transactions.sales.sales-order.index',['other' => $this->other,'sales_orders'=>$so, 'statuses' => SalesOrders::$statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();

        $sales_orders = SalesOrders::select('id','quotation_id')->where('active','1')->where('quotation_id','!=',NULL)->distinct('quotation_id')->pluck('quotation_id')->toArray();
        $sales_orders_ids= array_unique($sales_orders);
        
        if(!empty($sales_orders_ids))
        {
           $quotations = Quotation::select('quotation_no', 'id')->where('active','1')->whereNotIn('id',$sales_orders_ids)->orderBy('id','desc')->get();
        }else{
            $quotations = Quotation::select('quotation_no', 'id')->where('active','1')->orderBy('id','desc')->get();
        }
        
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $salesorderseries=SalesOrderSeries::all();
        $salesorderseriesstatus=SalesOrderSeries::where('status','true')->get();
        return view('admin.transactions.sales.sales-order.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'quotations' => $quotations,
                'batches'=>$batches,
                'salesorderseries'=>$salesorderseries,
                'salesorderseriesstatus'=>$salesorderseriesstatus
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $voucher_no = 'MR-SO-'.date('ymdhi');
        /*$salesorderseries=SalesOrders::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($salesorderseries)      
        {
            $number = (int)$salesorderseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $order_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $order_id=str_replace("XXXX","",$request->order_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $order_id=str_replace("XXXX","",$number.$request->order_no); 
        }elseif(!empty($request->series_starting_digits))
        {
            $order_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:sales_orders,order_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $order_id=$request->manual_id;   
        }*/

        $this->validate($request,[
            'order_no'=>'required|unique:sales_orders,order_no'
        ]);
        $po = SalesOrders::create([
            'voucher_no' => $voucher_no,
            'order_no' => $request->order_no,
            'quotation_id' => $request->quotation_id,
            'sales_ledger_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'branch_id'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'sales_person_id'=> $request->user_id,
            'address'=> $request->address,
            'state'=>$request->state,
            'net_amount'=> $request->total_net_amount,
            'total_net_amount'=> $request->total_grand_amount,
            'other_net_amount'=> $request->other_net_amount,
            'total_other_net_amount'=> $request->total_other_net_amount,
            'discount_in_per'=> $request->discount_in_per,
            'discount_amount'=> $request->discount_amount,
            'grand_total'=> $request->grand_total,
            'igst'=> $request->igst,
            'sgst'=> $request->sgst,
            'cgst'=> $request->cgst,
            'credit_days'=> $request->credit_days,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);
        //
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
                            'sales_order_id' => $po->id,
                            'stock_item_id' => $items['item_name'],
                            'item_code' => $items['item_code'],
                            'batch_id' => $items['batch'],
                            'unit' => $items['unit'],
                            'quantity' => $items['quantity'],
                            'rate' => $items['rate'],
                            'net_amount' => $items['net_amount'],
                            'tax' => $items['tax'],
                            'tax_amount' => $items['tax_amount'],
                            'discount_in_per' => $items['discount'],
                            'discount' => $items['discount_amount'],
                            'total_amount' => $items['total_amount'],
                            'created_at' => date('Y-m-d H:i:s'),
                             'updated_at' => date('Y-m-d H:i:s'),
                        ];

                        /*$stock = StockManagement::where('stock_item_id',$items['item_name'])->orderBy('id', 'DESC')->first();
                        $balance = isset($stock) ? ($stock->total_balance - ($items['quantity'] * $items['rate'])) : $items['quantity'] * $items['rate'];
                        $stock_management_data =[
                            'voucher_no' => $voucher_no,
                            'stock_item_id'=>$items['item_name'],
                            'batch_id'=>$items['batch'],
                            'warehouse_id'=>$request->warehouse_id,
                            'item_name'=>StockItem::where('id',$items['item_name'])->first()->name,
                            'pack_code'=>StockItem::where('id',$items['item_name'])->first()->pack_code,
                            'uom'=>$items['unit'],
                            'qty'=> -($items['quantity']),
                            'rate'=>$items['rate'],
                            'balance_value'=> -($items['quantity'] * $items['rate']),
                            'total_balance' => $balance,
                            'voucher_type'=>'Sales Order',
                            'status'=>2,
                            'created' => date('Y-m-d H:i:s'),
                        ];
                        $stock_op = StockManagement::insert($stock_management_data);*/
                    }
                }
                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    SalesOrdersItems::insert($stock_data);
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
                            'sales_order_id' => $po->id,
                            'type' => $taxes['type'],
                            'general_ledger_id' => $taxes['account_head'],
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
                    SalesOrdersOtherCharges::insert($tax_data);
                }
            }
            $salesorderseries=SalesOrderSeries::where('status','true')->first();
            if($salesorderseries)
            {
                $number=(int)$salesorderseries->series_current_digit+1;
                $salesorderseries=SalesOrderSeries::find($salesorderseries->id);
                $salesorderseries->series_current_digit=$number;
                $salesorderseries->save();
            }
            return redirect()->route('sales-order.index')->with('message', __('messages.add', ['name' => 'Sales Order']));
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
            $order = SalesOrders::with('items','other_charges')->find($id);
            $consignee_address = ConsigneeAddress::where('ledger_type',1)->pluck('branch_name', 'id')->toArray();
            $customers = SalesLedger::pluck('ledger_name', 'id')->toArray();
            $quotations = Quotation::select('quotation_no', 'id')->get();
            $warehouses = Warehouse::pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $units = InventoryUnit::pluck('name', 'name')->toArray();
            $salesorderseries=SalesOrderSeries::all(); 
            $salesorderseriesstatus=SalesOrderSeries::where('status','true')->get();
            return view('admin.transactions.sales.sales-order.show',
                    [
                        'is_submit_show'=>1,
                        'order' => $order,
                        'other' => $this->other,
                        'stockItem'=>$stockItem,
                        'consignee_address'=>$consignee_address,
                        'customers' => $customers,
                        'warehouses' => $warehouses,
                        'sales_person' => $sales_person,
                        'generalLedger' => $generalLedger,
                        'units' => $units,
                        'quotations' => $quotations,
                        'salesorderseries'=>$salesorderseries,
                        'salesorderseriesstatus'=>$salesorderseriesstatus
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
        $order = SalesOrders::with('items','other_charges','sales_invoices')->find($id);

        if((!isset($order->sales_invoices)) || (isset($order->sales_invoices) && $order->sales_invoices->isEmpty()))
        {

            $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
            $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $quotations = Quotation::select('quotation_no', 'id')->where('active','1')->get();

            $q1 = Quotation::select('quotation_no', 'id')->where('id',$order->quotation_id)->get();

            $sales_orders = SalesOrders::select('id','quotation_id')->where('active','1')->where('quotation_id','!=',NULL)->distinct('quotation_id')->pluck('quotation_id')->toArray();
            $sales_orders_ids= array_unique($sales_orders);
            
            if(!empty($sales_orders_ids))
            {
                $q2 = Quotation::select('quotation_no', 'id')->where('active','1')->whereNotIn('id',$sales_orders_ids)->orderBy('id','desc')->get();
            }else{
                $q2 = Quotation::select('quotation_no', 'id')->where('active','1')->orderBy('id','desc')->get();
            }
            
            $quotations = $q2->merge($q1);
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                     })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            $salesorderseries=SalesOrderSeries::all();
            $salesorderseriesstatus=SalesOrderSeries::where('status','true')->get();
            return view('admin.transactions.sales.sales-order.edit',
                        [
                            'order' => $order,
                            'other' => $this->other,
                            'stockItem'=>$stockItem,
                            'consignee_address'=>$consignee_address,
                            'customers' => $customers,
                            'warehouses' => $warehouses,
                            'sales_person' => $sales_person,
                            'generalLedger' => $generalLedger,
                            'units' => $units,
                            'quotations' => $quotations,
                            'batches'=>$batches,
                            'salesorderseries'=>$salesorderseries,
                            'salesorderseriesstatus'=>$salesorderseriesstatus
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
    public function update(Request $request, $id)
    {
       if($id)
       {
            $data = [
                'order_no' => $request->order_no,
                'quotation_id' => $request->quotation_id,
                'sales_ledger_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'branch_id'=> $request->branch_id,
                'warehouse_id'=> $request->warehouse_id,
                'sales_person_id'=> $request->user_id,
                'address'=> $request->address,
                'state'=>$request->state,
                'net_amount'=> $request->total_net_amount,
                'total_net_amount'=> $request->total_grand_amount,
                'other_net_amount'=> $request->other_net_amount,
                'total_other_net_amount'=> $request->total_other_net_amount,
                'discount_in_per'=> $request->discount_in_per,
                'discount_amount'=> $request->discount_amount,
                'grand_total'=> $request->grand_total,
                'igst'=> $request->igst,
                'sgst'=> $request->sgst,
                'cgst'=> $request->cgst,
                'credit_days'=> $request->credit_days,
                'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            ];

            $so = SalesOrders::find($id);
            if($so)
            {
                if ($so->update($data))
                {
                    if(isset($request->items) && !empty($request->items))
                    {
                        $stock_data = $keep_items = [];

                        foreach ($request->items as $key => $items)
                        {
                            if(isset($items['item_name']))
                            {
                                $stock_data = [
                                    'sales_order_id' => $so->id,
                                    'batch_id' => $items['batch'],
                                    'stock_item_id' => $items['item_name'],
                                    'item_code' => $items['item_code'],
                                    'unit' => $items['unit'],
                                    'quantity' => $items['quantity'],
                                    'rate' => $items['rate'],
                                    'net_amount' => $items['net_amount'],
                                    'tax' => $items['tax'],
                                    'tax_amount' => $items['tax_amount'],
                                    /*'cess' => $items['cess'],
                                    'cess_amount' => $items['cess_amount'],*/
                                    'total_amount' => $items['total_amount'],
                                    'discount_in_per' => $items['discount'],
                                    'discount' => $items['discount_amount'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'active' => 1
                                ];

                                $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                                $poItem = SalesOrdersItems::updateOrCreate([
                                    'id' => $items['item_id']
                                ], $stock_data);

                                $keep_items[] = $poItem->id;
                            }
                        }

                        if(isset($keep_items) && !empty($keep_items))
                        {
                            SalesOrdersItems::where('sales_order_id', $so->id)->whereNotIn('id', $keep_items)->delete();
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
                                    'sales_order_id' => $so->id,
                                    'type' => $taxes['type'],
                                    'general_ledger_id' => $taxes['account_head'],
                                    'rate' => $taxes['other_rate'],
                                    'amount' => $taxes['other_amount'],
                                    'tax' => $taxes['other_tax'],
                                    'tax_amount' => $taxes['other_tax_amount'],
                                    'total_amount' => $taxes['other_total_amount'],
                                ];

                                $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                                $PoOtherCharge = SalesOrdersOtherCharges::updateOrCreate([
                                    'id' => $items['other_charge_id']
                                ], $tax_data);

                                $keep_other_items[] = $PoOtherCharge->id;
                            }
                        }
                        if(!empty($keep_other_items) && count($keep_other_items) > 0)
                        {
                            SalesOrdersOtherCharges::where('sales_order_id', $so->id)->whereNotIn('id', $keep_other_items)->delete();
                        }
                    }
                    return redirect()->route('sales-order.index')->with('message', __('messages.update', ['name' => 'Sales Order']));

                }
            }
       }
       abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salesOrder = SalesOrders::with('sales_invoices')->find($id);

        if ($salesOrder && ((!isset($salesOrder->sales_invoices)) || (isset($salesOrder->sales_invoices) && $salesOrder->sales_invoices->isEmpty())))
        {
            $data = [
                'active' => 0,
            ];
            $salesOrder->update($data);

            return redirect()->route('sales-order.index')->with('message', __('messages.delete', ['name' => 'Sales Order']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));

    }

    public function getQuotationDetails(Request $request)
    {
        $quotation_id = $request->quotation_id;
        $quotation_details = \App\Models\Quotation::with('items','other_charges','branch')->where('id', $quotation_id)->first();

        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $units = \App\Models\InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

        $items_view = view('admin.transactions.sales.sales_single_item', ['order' => $quotation_details, 'stockItem' => $stockItem, 'units' => $units, 'batches' => $batches])->render();

        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $tax_items_view = view('admin.transactions.sales.sales-order.tax-item', ['quotation' => $quotation_details, 'generalLedger' => $generalLedger])->render();

        return response()->json(['quotation_details' => $quotation_details, 'items_view' => $items_view, 'tax_items_view' => $tax_items_view]);
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
            $salesOrder = SalesOrders::with(['items.stockItems' => function($query) {
                $query->select('id', 'name');
            },'other_charges','sales_invoices', 'target_warehouse','customers'])->find($id);

            $pdf = \PDF::loadView('admin.transactions.sales.sales-order.print', ['salesOrder' => $salesOrder]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata($id)
    {
        $data=SalesOrderSeries::where('id',$id)->first();
        return response()->json($data);
    }
}
