<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\DeliveyNoteRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\SalesLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\InventoryUnit;
use App\Models\SalesOrders;
use App\Models\SalesOrdersItems;
use App\Models\DeliveryNote;
use App\Models\DeliveryNoteItems;
use App\Models\DeliveryNoteOtherCharges;
use App\Models\SalesInvoice;
use App\Models\DeliveryNoteSeries;
class DeliveryNoteController extends CoreController
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
            'title' => 'Delivery Note',
            'route_name' => 'sales',
            'back_link' => route('transactions.sales'),
            'add_link' => route('delivery-note.create'),
            'add_link_route' => 'delivery-note.create',
            'store_link' => 'delivery-note.store',
            'edit_link' => 'delivery-note.edit',
            'update_link' => 'delivery-note.update',
            'delete_link' => 'delivery-note.destroy',
            'listing_link' => 'delivery-note.index',
            'order_type' => 20
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // $so = DeliveryNote::with(['sales_order' => function($q) {
        //     $q->select('id', 'delivery_note_id');
        // }])->where('active','1')->get();

        $delivery_note = DeliveryNote::where('active',1)->orderBy('id','desc')->get();
        return view('admin.transactions.sales.delivery-note.index',
        [
            'other' => $this->other,
            'delivery_notes'=>$delivery_note,
            'statuses' => DeliveryNote::$statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consignee_address = ConsigneeAddress::pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $deliveryseriesstatus=DeliveryNoteSeries::where('status','true')->get();
        $q = SalesOrders::select('order_no', 'id')->where(function ($query) {
            $query->where('active', '=', 1);
        })->where(function ($query) {
            $query->where('status', '=', 'pending')
                  ->orWhere('status', '=', 'billed_not_delivered');
        });
        $sales_order = $q->orderBy('id','desc')->get();
        //$sales_order = SalesOrders::select('order_no', 'id')->where('active','1')->get();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();


        return view('admin.transactions.sales.delivery-note.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'sales_order' => $sales_order,
                'deliveryseriesstatus'=>$deliveryseriesstatus
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
        $voucher_no = 'MR-DN-'.date('ymdhi');

        // $this->validate(
        //     $request,
        //     ['manual_id'=>'required|unique:sales_delivery_note,delivery_no'],
        //     ['manual_id.required'=>'The Delivery no field is required',
        //     'manual_id.unique' =>'The Delivery no has already been taken'
        //     ],
        // );

        $this->validate($request,[
            'delivery_no'=>'required|unique:sales_delivery_note,delivery_no'

        ]);
        $po = DeliveryNote::create([
            'voucher_no' => $voucher_no,
            'delivery_no' => $request->delivery_no,
            'sales_order_id' => $request->sales_order_id,
            'required_date' => $request->required_date,
            'branch_id'=> $request->branch_id,
            'main_branch'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'customer_id'=> $request->customer_id,
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
            'approved_vendor_code'=>$request->approved_vendor_code
        ]);
        //
        if($po)
        {
            if(isset($request->sales_order_id) && !empty($request->sales_order_id))
            {
                $Checkinvoice = SalesInvoice::where('sales_order_id',$request->sales_order_id)->get();
                $invoiceCount = $Checkinvoice->count();
                if($invoiceCount > 0)
                {
                    $order_status='completed';
                }else{
                    $order_status='delivered_not_billed';
                }
                $sals_order_data = [
                    'status' => $order_status,
                ];

                $so = SalesOrders::find($request->sales_order_id);
                if($so)
                {
                    if ($so->update($sals_order_data))
                    {}
                }
            }
            if(isset($request->items) && !empty($request->items))
            {
                $stock_data = [];
                foreach ($request->items as $key => $items)
                {
                    if(isset($items['item_name']))
                    {
                        $stock_data[] = [
                            'delivery_note_id' => $po->id,
                            'stock_item_id' => $items['item_name'],
                            'item_code' => $items['item_code'],
                            //'batch_id' => $items['batch'],
                            'unit' => $items['unit'],
                            'quantity' => $items['quantity'],
                            'rate' => $items['rate'],
                            'net_amount' => $items['net_amount'],
                            'tax' => $items['tax'],
                            'tax_amount' => $items['tax_amount'],
                            'discount_in_per' => $items['discount'],
                            'discount' => $items['discount_amount'],
                            'total_amount' => $items['total_amount'],
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
                    DeliveryNoteItems::insert($stock_data);
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
                            'delivery_note_id' => $po->id,
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
                    DeliveryNoteOtherCharges::insert($tax_data);
                }
            }

            $deliverynoteseriesdata=DeliveryNoteSeries::where('status','true')->first();
            if($deliverynoteseriesdata)
            {
                $number=(int)$deliverynoteseriesdata->series_current_digit+1;
                $dns=DeliveryNoteSeries::find($deliverynoteseriesdata->id);
                $dns->series_current_digit=$number;
                $dns->save();
            }
            return redirect()->route('delivery-note.index')->with('message', __('messages.add', ['name' => 'Delivery Note']));
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
            $delivery_note = DeliveryNote::with('items','other_charges')->find($id);
            $consignee_address = ConsigneeAddress::where('ledger_type',1)->pluck('branch_name', 'id')->toArray();
            $customers = SalesLedger::pluck('ledger_name', 'id')->toArray();
            $sales_order = SalesOrders::select('order_no', 'id')->get();
            $warehouses = Warehouse::pluck('name', 'id')->toArray();
            $branches = Warehouse::pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                    })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $units = InventoryUnit::pluck('name', 'name')->toArray();
            //$salesorderseries=SalesOrderSeries::all(); 
            $deliveryseriesstatus=DeliveryNoteSeries::where('status','true')->get();
            return view('admin.transactions.sales.delivery-note.show',
                    [
                        'is_submit_show'=>1,
                        'order' => $delivery_note,
                        'other' => $this->other,
                        'stockItem'=>$stockItem,
                        'consignee_address'=>$consignee_address,
                        'customers' => $customers,
                        'warehouses' => $warehouses,
                        'sales_person' => $sales_person,
                        'generalLedger' => $generalLedger,
                        'units' => $units,
                        'sales_order' => $sales_order,
                        'deliveryseriesstatus'=>$deliveryseriesstatus
                        //'salesorderseries'=>$salesorderseries
                    ]);
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
        $delivery_note = DeliveryNote::with('items','other_charges')->find($id);
        //echo '<pre>';print_r($delivery_note['sales_order_id']);exit;
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::pluck('ledger_name', 'id')->toArray();
        //$sales_order = SalesOrders::select('order_no', 'id')->get();
        $warehouses = Warehouse::pluck('name', 'id')->toArray();
        $branches = Warehouse::pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::pluck('name', 'name')->toArray();
        $sales_order_id = $delivery_note['sales_order_id'];
        $q = SalesOrders::select('order_no', 'id')->where(function ($query) {
            $query->where('active', '=', 1);
        })->where(function ($query){
            $query->where('status', '=', 'pending')
            ->orWhere('status', '=', 'billed_not_delivered');
        });
        $q2 = $q->orderBy('id','desc')->get();
        $q1 = SalesOrders::select('order_no', 'id')->where('id',$sales_order_id)->get();
        $sales_order = $q2->merge($q1);
        $deliveryseriesstatus=DeliveryNoteSeries::where('status','true')->get();
        return view('admin.transactions.sales.delivery-note.edit',
                [
                    'order' => $delivery_note,
                    'other' => $this->other,
                    'stockItem'=>$stockItem,
                    'consignee_address'=>$consignee_address,
                    'customers' => $customers,
                    'warehouses' => $warehouses,
                    'sales_person' => $sales_person,
                    'generalLedger' => $generalLedger,
                    'units' => $units,
                    'sales_order' => $sales_order,
                    'deliveryseriesstatus'=>$deliveryseriesstatus
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveyNoteRequest $request, $id)
    {
        if($id)
        {
            $data = [
                'delivery_no' => $request->delivery_no,
                'sales_order_id' => $request->sales_order_id,
                'branch_id'=> $request->branch_id,
                'main_branch'=> $request->branch_id,
                'warehouse_id'=> $request->warehouse_id,
                'customer_id'=> $request->customer_id,
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
                'approved_vendor_code'=>$request->approved_vendor_code
            ];


            $so = DeliveryNote::find($id);
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
                                    'delivery_note_id' => $so->id,
                                    //'batch_id' => $items['batch'],
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
                                    'active' => 1
                                ];

                                $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                                $poItem = DeliveryNoteItems::updateOrCreate([
                                    'id' => $items['item_id']
                                ], $stock_data);

                                $keep_items[] = $poItem->id;
                            }
                        }

                        if(isset($keep_items) && !empty($keep_items))
                        {
                            DeliveryNoteItems::where('delivery_note_id', $so->id)->whereNotIn('id', $keep_items)->delete();
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
                                    'delivery_note_id' => $so->id,
                                    'type' => $taxes['type'],
                                    'general_ledger_id' => $taxes['account_head'],
                                    'rate' => $taxes['other_rate'],
                                    'amount' => $taxes['other_amount'],
                                    'tax' => $taxes['other_tax'],
                                    'tax_amount' => $taxes['other_tax_amount'],
                                    'total_amount' => $taxes['other_total_amount'],
                                ];

                                $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                                $PoOtherCharge = DeliveryNoteOtherCharges::updateOrCreate([
                                    'id' => $items['other_charge_id']
                                ], $tax_data);

                                $keep_other_items[] = $PoOtherCharge->id;
                            }
                        }
                        if(!empty($keep_other_items) && count($keep_other_items) > 0)
                        {
                            DeliveryNoteOtherCharges::where('delivery_note_id', $so->id)->whereNotIn('id', $keep_other_items)->delete();
                        }
                    }
                    return redirect()->route('delivery-note.index')->with('message', __('messages.update', ['name' => 'Delivery Note']));

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
        $delivery_note = DeliveryNote::with('items','other_charges')->find($id);
        //echo '<pre>';print_r($delivery_note->toArray());exit;
        //if ($delivery_note && ((!isset($delivery_note->items)) || (isset($delivery_note->items) && $delivery_note->items->isEmpty())) && ((!isset($delivery_note->other_charges)) || (isset($delivery_note->other_charges) && $delivery_note->other_charges->isEmpty())))
        //{
            $data = [
                'active' => 0,
            ];
            $delivery_note->update($data);

            return redirect()->route('delivery-note')->with('message', __('messages.delete', ['name' => 'Delivery Note']));
        //}
        //return redirect()->back()->with('error', __('messages.somethingWrong'));
    }


    public function getNoteSalesOrderDetails(Request $request)
    {
        $sales_order_id = $request->sales_order_id;
        $order_details = \App\Models\SalesOrders::with('items','other_charges','branch','customers')->where('id', $sales_order_id)->first();

        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $units = \App\Models\InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        //$batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

        $items_view = view('admin.transactions.sales.sales_single_item', ['is_batch_hide'=>1,'order' => $order_details, 'stockItem' => $stockItem, 'units' => $units, 'batches' => []])->render();

        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $tax_items_view = view('admin.transactions.sales.sales-order.tax-item', ['quotation' => $order_details, 'generalLedger' => $generalLedger])->render();

        return response()->json(['order_details' => $order_details, 'items_view' => $items_view, 'tax_items_view' => $tax_items_view]);
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
            $deliveryNote = DeliveryNote::with(['items.stockItems' => function($query) {
                $query->select('id', 'name');
            },'other_charges', 'target_warehouse'])->find($id);
            
            $pdf = \PDF::loadView('admin.transactions.sales.delivery-note.print', ['deliveryNote' => $deliveryNote]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }

}
