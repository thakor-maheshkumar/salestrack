<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\InventoryUnit;
use App\Models\PurchaseInvoiceItems;
use App\Models\PurchaseInvoiceOtherCharges;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceSeries;
use App\Models\PurchaseReturnSeries;


class PurchaseInvoiceController extends CoreController
{
    protected static $material_type = [
        'Purchase' => 'Purchase'
    ];

    public $other, $invoice_status;

    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->other = (Object) [
            'title' => 'Invoice',
            'route_name' => 'purchase',
            'back_link' => route('transactions.purchase'),
            'add_link' => route('purchase-invoice.create'),
            'add_link_route' => 'purchase-invoice.create',
            'store_link' => 'purchase-invoice.store',
            'edit_link' => 'purchase-invoice.edit',
            'update_link' => 'purchase-invoice.update',
            'delete_link' => 'purchase-invoice.destroy',
            'listing_link' => 'purchase-invoice.index',
            'is_account_details' => 1,
            'order_type' => 11,
        ];

        $this->invoice_status = [
            /*'paid' => 'Paid',
            'partially_paid' => 'Partially Paid',
            'due' => 'Due',
            'overdue' => 'Overdue'*/
            'unpaid' => 'Unpaid',
            'partially_paid' => 'Partially Paid',
            'paid' => 'Paid',
            'overdue' => 'Overdue'
        ];
         $this->other_invoice = (Object) [
            'title' => 'Return',
            'route_name' => 'purchase',
            'back_link' => route('transactions.purchase'),
            'add_link' => route('purchase-return.create'),
            'add_link_route' => 'purchase-return.create',
            'store_link' => 'purchase-return.store',
            'edit_link' => 'purchase-return.edit',
            'update_link' => 'purchase-return.update',
            'delete_link' => 'purchase-return.destroy',
            'listing_link' => 'purchase-return.index',
            'is_account_details' => 1,
            'order_type' => 11,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $poi = PurchaseInvoice::all();
        return view('admin.transactions.purchase.purchase-invoice.index',['other' => $this->other,'purchase_invoices' => $poi, 'invoice_status' => $this->invoice_status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
//        $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $po_data = \App\Models\PurchaseOrder::orderBy('id','desc')->where('po_status','!=', 2)->where('po_status','!=',3)->get();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();

        $purchaseinvoiceseries=PurchaseInvoiceSeries::all();
        $purchaseinvoiceseriesstatus=PurchaseInvoiceSeries::where('status','true')->get();
       
        return view('admin.transactions.purchase.purchase-invoice.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'po_data' => $po_data,
                'invoice_status' => $this->invoice_status,
                'purchaseinvoiceseries'=>$purchaseinvoiceseries,
                'purchaseinvoiceseriesstatus'=>$purchaseinvoiceseriesstatus,
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
//        echo '<pre>'; print_r($request->all()); die;
        /*$purchaseinvoiceseries=PurchaseInvoice::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($purchaseinvoiceseries)      
        {
            $number = (int)$purchaseinvoiceseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $invoice_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $invoice_id=str_replace("XXXX","",$request->invoice_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $invoice_id=str_replace("XXXX","",$number.$request->invoice_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $invoice_id=str_replace("XXXX","",$number);   
        }
        else
        {
        $this->validate(
                $request,
                ['manual_id'=>'required|unique:purchase_invoices,invoice_no'],
                ['manual_id.required'=>'The Invoice id field is required',
                'manual_id.unique' =>'The Invoice id has already been taken'
                ],
            );
         $invoice_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'invoice_no'=>'required|unique:purchase_invoices,invoice_no'
        ]);
        $po = PurchaseInvoice::create([
            'po_id' => $request->po_id,
            'supplier_id' => $request->supplier_id,
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            'main_branch'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'invoice_no'=> $request->invoice_no,
            'invoice_date'=> $request->invoice_date,
            'address'=> $request->address,
            'state'=>$request->state,
            'net_amount'=> $request->net_amount,
            'total_net_amount'=> $request->total_net_amount,
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
            'debit_to' => $request->debit_to,
            'income_account' => $request->income_account,
            'expense_account' => $request->expense_account,
            'asset' => $request->asset,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'type' => isset($request->type) ? $request->type : NULL,
            'payment_status' => isset($request->payment_status) ? $request->payment_status : NULL,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);
        //
        if($po)
        {
            $purchasereceiptseries=PurchaseInvoiceSeries::where('status','true')->first();
            if($purchasereceiptseries){
                $number=(int)$purchasereceiptseries->series_current_digit+1;
                $purchasereceiptseries=PurchaseInvoiceSeries::find($purchasereceiptseries->id);
                $purchasereceiptseries->series_current_digit=$number;
                $purchasereceiptseries->save();
            }
            if(isset($request->items) && !empty($request->items))
            {
                $stock_data = [];
                foreach ($request->items as $key => $items)
                {
                    if(isset($items['item_name']))
                    {
                        $stock_data[] = [
                            'purchase_invoice_id' => $po->id,
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
                            'item_received' => 0,
                        ];

                        \App\Models\StockItem::find($items['item_name'])->increment('opening_stock', $items['quantity']);
                    }
                }
                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    PurchaseInvoiceItems::insert($stock_data);
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
                            'purchase_invoice_id' => $po->id,
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
                    PurchaseInvoiceOtherCharges::insert($tax_data);
                    //$po->po_other_charges()->createMany($tax_data);
                }
            }

            if(!empty($request->grand_total))
            {
                $customer_id = $request->supplier_id;
                $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','supplier')->first();


                if($customer_balance)
                {
                    if($customer_balance->total_balance < 0)
                    {
                        if($customer_balance->total_balance < $request->grand_total)
                        {
                            $received_amount = $customer_balance->total_balance + $request->grand_total;
                            if($received_amount < 0)
                            {
                                $payment_status = 'paid';
                                $received = $request->grand_total;
                                $pending=0;
                            }else{
                                $payment_status = 'partially_paid';
                                $received = abs($customer_balance->total_balance);
                                $pending = $received_amount;
                            }
                        }else{
                            $payment_status = 'unpaid';
                            $received = 0;
                            $pending = $request->grand_total;
                        }
                    }else{
                        $payment_status = 'unpaid';
                        $received = 0; 
                        $pending = $request->grand_total;
                    }
                    $status_data = [
                        'payment_status' =>  $payment_status,
                        'received' => $received,
                        'pending' => $pending
                    ];
                    $po->update($status_data);
                }


                $purchase_ledger = \App\Models\PurchaseLedger::where('id',$request->supplier_id)->get()->toArray();
                $opening_balance = $purchase_ledger[0]['opening_balance'];
                $opening_balance_amount = $purchase_ledger[0]['opening_balance_amount'];
                $grand_total = $request->grand_total;
                $balance_amount = (float)$grand_total;

                
                if($customer_balance)
                {
                    $total_balance = (float)$customer_balance->total_balance ;
                    $update_blance = $total_balance + $balance_amount;
                    $toal_balance = $update_blance;
                    $balance_data = [
                        'total_balance'=>$update_blance
                    ];
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->update($balance_data);
                }else{
                    $toal_balance = $balance_amount;
                    $balance_data = [
                        'user_id'=>$customer_id,
                        'total_balance'=> $balance_amount,
                        'ledger_type'=>'supplier'
                    ];
                    $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                }
                
                // $toal_balance = ($customer_balance) ? (float)$customer_balance->total_balance : 0;
                \App\Models\PaymentRecord::create([
                    'posting_date' => $request->created_at,
                    'user_id' => $request->supplier_id,
                    'party' => $request->supplier_id,
                    'account' => '',
                    'opening_balance' => ($customer_balance) ? number_format($customer_balance->total_balance,3) : 0,
                    'debit' => '0.000',
                    'credit' => number_format($request->grand_total, 3),
                    'balance' =>number_format($toal_balance,3),
                    'voucher_type'=> 'App\Models\PurchaseInvoice',
                    'recordable_type' => 'App\Models\PurchaseInvoice',
                    'recordable_id'=>$po,
                    'party_type' => 'Supplier'
                ]);
                
                // $payment_record = \App\Models\PaymentRecord::where('user_id',$customer_id)->orderBy('id','desc')->first();
                // if($payment_record)
                // {
                //     $payment_record_data = [
                //         'balance'=> number_format($toal_balance,3)
                //     ];
                //     \App\Models\PaymentRecord::where('id',$payment_record->id)->update($payment_record_data);
                //     //print_r($payment_record_data);exit;

                // }
                
            }

            
            // if($opening_balance == 'credit' && $opening_balance_amount >= $grand_total)
            // {
                
                // $data = [
                //     'payment_type' => 'receive',
                //     'amount' => $grand_total,
                //     'other_amount' => $grand_total,
                //     'payment_mode' => 'Opening Balance',
                // ];
                // $payment_data = new \App\Models\Payments($data);
                // $payment = $payment_data->save();

                
                // if($payment_data)
                // {
                //     $temp_items = [
                //         'payment_id' => $payment_data->id,
                //         'party_type' => 'supplier',
                //         'party' => $request->customer_id,
                //         'against' => 'purchase_invoice',
                //         'invoice_no' => $po->id,
                //         'amount' => $grand_total
                //     ];
                //     $payment_item_data = new \App\Models\PaymentAmountItems($temp_items);
                //     $payment_ii = $payment_item_data->save();
                // }

                // $pur_update_rate = $opening_balance_amount - $grand_total;
                // $ledger_up_data = [
                //     'opening_balance_amount'=>$pur_update_rate
                // ];
                // $so = \App\Models\PurchaseLedger::find($request->supplier_id);
                // if($so)
                // {
                //     if ($so->update($ledger_up_data)){}
                // }
            //}

            return redirect()->route('purchase-invoice.index')->with('message', __('messages.add', ['name' => 'Invoice']));
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
        $purchaseinvoiceseries=PurchaseInvoiceSeries::all();
        $invoice = PurchaseInvoice::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::pluck('name', 'id')->toArray();
//        $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
        $po_data = \App\Models\PurchaseOrder::get();
        $units = InventoryUnit::pluck('name', 'name')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $purchaseinvoiceseriesstatus=PurchaseInvoiceSeries::where('status','true')->get();
        return view('admin.transactions.purchase.purchase-invoice.show',
            [
                'is_submit_show'=>1,
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'po_data' => $po_data,
                'order' => $invoice,
                'units' => $units,
                'invoice_status' => $this->invoice_status,
                'purchaseinvoiceseries'=>$purchaseinvoiceseries,
                'purchaseinvoiceseriesstatus'=>$purchaseinvoiceseriesstatus,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = PurchaseInvoice::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
//        $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $po_data = \App\Models\PurchaseOrder::where('active', 1)->get();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $purchaseinvoiceseries=PurchaseInvoiceSeries::all();
        return view('admin.transactions.purchase.purchase-invoice.edit',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'po_data' => $po_data,
                'order' => $invoice,
                'units' => $units,
                'invoice_status' => $this->invoice_status,
                'purchaseinvoiceseries'=>$purchaseinvoiceseries,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, $id)
    {
//        echo '<pre>';
//        print_r($request->all());exit;
        $data = [
            'po_id' => $request->po_id,
            'supplier_id' => $request->supplier_id,
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'invoice_no'=> $request->invoice_no,
            'invoice_date'=> $request->invoice_date,
            'address'=> $request->address,
            'state'=>$request->state,
            'net_amount'=> $request->total_net_amount,
            'total_net_amount'=> $request->total_grand_amount,
            'other_net_amount'=> $request->other_net_amount,
            'total_other_net_amount'=> $request->total_other_net_amount,
//            'total_cess_amount' => $request->total_cess_amount,
            'discount_in_per'=> $request->discount_in_per,
            'discount_amount'=> $request->discount_amount,
            'grand_total'=> $request->grand_total,
            'igst'=> $request->igst,
            'sgst'=> $request->sgst,
            'cgst'=> $request->cgst,
            'transporter'=> $request->transporter,
            'reference'=> $request->reference,
            'credit_days'=> $request->credit_days,
            'debit_to' => $request->debit_to,
            'income_account' => $request->income_account,
            'expense_account' => $request->expense_account,
            'asset' => $request->asset,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'type' => isset($request->type) ? $request->type : NULL,
            'payment_status' => isset($request->payment_status) ? $request->payment_status : NULL
        ];

        $po = PurchaseInvoice::find($id);

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
                                'purchase_invoice_id' => $po->id,
                                'stock_item_id' => $items['item_name'],
                                'item_code' => $items['item_code'],
                                'unit' => $items['unit'],
                                'quantity' => $items['quantity'],
                                'rate' => $items['rate'],
                                'net_amount' => $items['net_amount'],
                                'tax' => $items['tax'],
                                'tax_amount' => $items['tax_amount'],
//                                'cess' => $items['cess'],
//                                'cess_amount' => $items['cess_amount'],
                                'total_amount' => $items['total_amount'],
                                'item_pending' => $items['quantity'],
                                'item_received' => 0,
                                'active' => 1
                            ];

                            $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                            $poItem = PurchaseInvoiceItems::updateOrCreate([
                                'id' => $items['item_id']
                            ], $stock_data);

                            $keep_items[] = $poItem->id;
                        }
                    }

                    if(isset($keep_items) && !empty($keep_items))
                    {
                        PurchaseInvoiceItems::where('purchase_invoice_id', $po->id)->whereNotIn('id', $keep_items)->delete();
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
                                'purchase_invoice_id' => $po->id,
                                'type' => $taxes['type'],
                                'general_ledger_id' => $taxes['account_head'],
                                'rate' => $taxes['other_rate'],
                                'amount' => $taxes['other_amount'],
                                'tax' => $taxes['other_tax'],
                                'tax_amount' => $taxes['other_tax_amount'],
                                'total_amount' => $taxes['other_total_amount'],
                            ];

                            $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                            $PurchaseInvoiceOtherCharge = PurchaseInvoiceOtherCharges::updateOrCreate([
                                'id' => $items['other_charge_id']
                            ], $tax_data);

                            $keep_other_items[] = $PurchaseInvoiceOtherCharge->id;
                        }
                    }
                    if(!empty($keep_other_items) && count($keep_other_items) > 0)
                    {
                        PurchaseInvoiceOtherCharges::where('purchase_invoice_id', $po->id)->whereNotIn('id', $keep_other_items)->delete();
                    }

                }

                $purchase_ledger = \App\Models\PurchaseLedger::where('id',$request->supplier_id)->get()->toArray();
                $opening_balance = $purchase_ledger[0]['opening_balance'];
                $opening_balance_amount = $purchase_ledger[0]['opening_balance_amount'];
                $grand_total = $request->grand_total;
                if($opening_balance == 'credit' && $opening_balance_amount >= $grand_total)
                {
                    
                    $pur_data = [
                        'payment_type' => 'receive',
                        'amount' => $grand_total,
                        'other_amount' => $grand_total,
                        'payment_mode' => 'Opening Balance',
                    ];
                    $payment_data = new \App\Models\Payments($pur_data);
                    $payment = $payment_data->save();

                    
                    if($payment_data)
                    {
                        $temp_items = [
                            'payment_id' => $payment_data->id,
                            'party_type' => 'supplier',
                            'party' => $request->customer_id,
                            'against' => 'purchase_invoice',
                            'invoice_no' => $po->id,
                            'amount' => $grand_total
                        ];
                        $payment_item_data = new \App\Models\PaymentAmountItems($temp_items);
                        $payment_ii = $payment_item_data->save();
                    }

                    $pur_update_rate = $opening_balance_amount - $grand_total;
                    $ledger_up_data = [
                        'opening_balance_amount'=>$pur_update_rate
                    ];
                    $so = \App\Models\PurchaseLedger::find($request->supplier_id);
                    if($so)
                    {
                        if ($so->update($ledger_up_data)){}
                    }
                }

                return redirect()->route('purchase-invoice.index')->with('message', __('messages.update', ['name' => 'Invoice']));
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
       $pi = PurchaseInvoice::find($id);

        if ($pi)
        {
            $pi->delete();

            return redirect()->route('purchase-invoice.index')->with('message', __('messages.delete', ['name' => 'Purchase Invoice']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function getPurchaseOrderDetails(Request $request)
    {
        //$input = $request->all();
        $po_id = $request->po_id;
        // $supplier_details = PurchaseLedger::find($supplier_id);
        $po_details = \App\Models\PurchaseOrder::with('items','other_charges','branches')->where('id',$po_id)->first();
        return response()->json(['order_details'=>$po_details]);
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
            /*$purchaseInvoice = PurchaseInvoice::with(['items','other_charges','purchase_order'])->find($id);*/
            /*$purchaseInvoice = PurchaseInvoice::with(['items.stock_items' => function($query) {
                $query->select('id', 'name');
            },'other_charges', 'target_warehouse','purchase_order'])->find($id);*/
            $purchaseInvoice = PurchaseInvoice::with(['items','other_charges','purchase_order'])->find($id);

            $pdf = \PDF::loadView('admin.transactions.purchase.purchase-invoice.print', ['purchaseInvoice' => $purchaseInvoice]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata($id)
    {
        $data=PurchaseInvoiceSeries::where('id',$id)->first();
        
        return response()->json($data);
    }
    public function createPurchaseReturn($id)
    {
         $order = PurchaseInvoice::with('items','other_charges')->find($id);
         
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $purchasereturnseries=PurchaseReturnSeries::all();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $pi_data = \App\Models\PurchaseInvoice::where('active', 1)->get();
        $purchasereturnseriesstatus=PurchaseReturnSeries::where('status','true')->get();
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
        return view('admin.transactions.purchase.purchase-invoice.createpurchasereturn',[
            'order'=>$order,
            'other'=>$this->other_invoice,
            'purchasereturnseries'=>$purchasereturnseries,
            'suppliers'=>$suppliers,
            'warehouses'=>$warehouses,
            'units'=>$units,
            'generalLedger'=>$generalLedger,
            'stockItem'=>$stockItem,
            'invoice_data'=>$pi_data,
            'consignee_address'=>$consignee_address,
            'purchasereturnseriesstatus'=>$purchasereturnseriesstatus
        ]);
    }
}
