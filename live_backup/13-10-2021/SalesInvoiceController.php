<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\SalesInvoiceRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\SalesLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\InventoryUnit;
use App\Models\SalesOrders;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItems;
use App\Models\SalesInvoiceOtherCharges;
use App\Models\StockManagement;
use App\Models\StockQtyManagement;
use App\Models\Batch;
use App\Models\SalesInvoiceSeries;
use App\Models\DeliveryNote;


class SalesInvoiceController extends CoreController
{
    protected static $material_type = [
        'Sales' => 'Sales'
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
            'title' => 'Receipt',
            'route_name' => 'sales',
            'back_link' => route('transactions.sales'),
            'add_link' => route('sales-invoice.create'),
            'add_link_route' => 'sales-invoice.create',
            'store_link' => 'sales-invoice.store',
            'edit_link' => 'sales-invoice.edit',
            'update_link' => 'sales-invoice.update',
            'delete_link' => 'sales-invoice.destroy',
            'listing_link' => 'sales-invoice.index',
            'is_account_details' => 1,
            'order_type' => 2,
            'show_sales_batch' => 1,
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $items = SalesInvoice::where('active','1')->get();
        return view('admin.transactions.sales.sales-invoice.index',['other' => $this->other,'items'=>$items, 'invoice_status' => $this->invoice_status]);
    }

    function getSalesOrderDetails(Request $request)
    {
        /*$so_id = $request->so_id;
        $other_charges = \App\Models\SalesOrders::with('other_charges')->where('id',$so_id)->get();

        $html = view('admin.transactions.sales.other_charges_ajax')->with(compact('other_charges'))->render();
        return json_encode(['success' => true, 'html' => $html]);
        exit;*/
        $so_id = $request->so_id;
        $so_details = \App\Models\SalesOrders::with('items','other_charges','branch','users')->where('id',$so_id)->first();
        //echo $other_charges_ajax = view('admin.transactions.sales.other_charges_ajax',['other_charges'=>$other_charges->other_charges]);
        //echo '<pre>';print_r($other_charges->other_charges);
        //exit;

        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $units = \App\Models\InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();

        $items_view = view('admin.transactions.sales.sales_single_item', ['order' => $so_details, 'stockItem' => $stockItem, 'units' => $units, 'batches' => $batches])->render();

        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $tax_items_view = view('admin.transactions.tax-item', ['order' => $so_details, 'generalLedger' => $generalLedger])->render();

       

        return response()->json(['order_details' => $so_details, 'items_view'  => $items_view, 'tax_items_view' => $tax_items_view,]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$sales_orders = SalesOrders::where('active','1')->get();

        $q = SalesOrders::select('order_no', 'id')->where(function ($query) {
            $query->where('active', '=', 1);
        })->where(function ($query) {
            $query->where('status', '=', 'pending')
                ->orWhere('status', '=', 'delivered_not_billed');
        });
        $sales_orders = $q->orderBy('id','desc')->get();

        $consignee_address = ConsigneeAddress::pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();

        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
        $salesinvoice=SalesInvoiceSeries::all();
        $salesinvoiceseriesstatus=SalesInvoiceSeries::where('status','true')->get();
        return view('admin.transactions.sales.sales-invoice.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'sales_orders'=>$sales_orders,
                'batches' => $batches,
                'invoice_status' => $this->invoice_status,
                'salesinvoice'=>$salesinvoice,
                'salesinvoiceseriesstatus'=>$salesinvoiceseriesstatus
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
        $voucher_no = 'MR-SO-'.date('ymdhi');
       /* $salesinvoiceseries=SalesInvoice::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($salesinvoiceseries)      
        {
            $number = (int)$salesinvoiceseries->number + 1;
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
          $invoice_id=str_replace("XXXX","",$request->receipt_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $invoice_id=str_replace("XXXX","",$number.$request->receipt_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $invoice_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:sales_invoice,invoice_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $invoice_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'receipt_no'=>'required|unique:sales_invoice,invoice_no'
        ]);
        $po = SalesInvoice::create([
            'voucher_no' => $voucher_no,
            'invoice_no' => $request->receipt_no,
            'sales_order_id' => $request->sales_order_id,
            'sales_ledger_id' => $request->customer_id,
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
            'debit_to' => $request->debit_to,
            'income_account' => $request->income_account,
            'expense_account' => $request->expense_account,
            'asset' => $request->asset,
            'credit_days'=> $request->credit_days,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'payment_status' => isset($request->payment_status) ? $request->payment_status : NULL,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);

        //
        if($po)
        {

            if(isset($request->sales_order_id) && !empty($request->sales_order_id))
            {
                // delivered_not_billed' => 'Delivered not Billed',
                // 'billed_not_delivered' => 'Billed not Delivered',
                $Checkdeliverynote = DeliveryNote::where('sales_order_id',$request->sales_order_id)->get();
                $noteCount = $Checkdeliverynote->count();
                if($noteCount > 0)
                {
                    $order_status='completed';
                }else{
                    $order_status='billed_not_delivered';
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
                            'sales_invoice_id' => $po->id,
                            'stock_item_id' => $items['item_name'],
                            'item_code' => $items['item_code'],
                            'batch_id' => isset($items['batch']) ? $items['batch'] : NULL,
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

                        $stock = StockManagement::where('stock_item_id',$items['item_name'])->orderBy('id', 'DESC')->first();
                        $balance = isset($stock) ? ($stock->total_balance - ($items['quantity'] * $items['rate'])) : $items['quantity'] * $items['rate'];
                        $stock_management_data =[
                            'voucher_no' => $voucher_no,
                            'stock_item_id'=>$items['item_name'],
                            'batch_id'=> isset($items['batch']) ? $items['batch'] : NULL,
                            'warehouse_id'=>$request->warehouse_id,
                            'item_name'=>StockItem::where('id',$items['item_name'])->first()->name,
                            'pack_code'=>StockItem::where('id',$items['item_name'])->first()->pack_code,
                            'uom'=>$items['unit'],
                            'qty'=> -($items['quantity']),
                            'rate'=>$items['rate'],
                            'balance_value'=> -($items['quantity'] * $items['rate']),
                            'total_balance' => $balance,
                            'voucher_type'=>'Sales Invoice',
                            'status'=>2,
                            'created' => date('Y-m-d H:i:s'),
                        ];
                        $stock_op = StockManagement::insert($stock_management_data);

                        $rate = $items['rate'];
                        $receipt_quantity = $items['quantity'];

                        $stock_qty_management = StockQtyManagement::where('stock_item_id',$items['item_name'])->where('batch_id',$items['batch'])->where('warehouse_id',$request->warehouse_id)->first();
                        if($stock_qty_management)
                        {
                            $stock_qty_id = $stock_qty_management->id;
                            $qty = $stock_qty_management->qty;
                            $balance = $stock_qty_management->balance_value;

                            $stock_qty_data =[
                                'stock_item_id'=>$items['item_name'],
                                'batch_id'=>$items['batch'],
                                'warehouse_id'=>$request->warehouse_id,
                                'qty'=>$qty - $items['quantity'],
                                'balance_value'=> $balance - ($receipt_quantity * $rate)
                            ];
                            $stock_qty = StockQtyManagement::where('id', $stock_qty_id)->update($stock_qty_data);
                        }else{
                            $stock_qty_data =[
                                'stock_item_id'=>$items['item_name'],
                                'batch_id'=>$items['batch'],
                                'warehouse_id'=>$request->warehouse_id,
                                'qty'=> -$items['quantity'],
                                'balance_value'=> -($items['quantity'] * $rate),
                                'created_at'=> date('Y-m-d H:i:s')
                            ];
                            $stock_qty = StockQtyManagement::insert($stock_qty_data);
                        }
                    }
                }
                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    SalesInvoiceItems::insert($stock_data);
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
                            'sales_invoice_id' => $po->id,
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
                    SalesInvoiceOtherCharges::insert($tax_data);
                }
            }

            if(!empty($request->grand_total))
            {
                $customer_id = $request->customer_id;
                $customer_balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->first();
                if($customer_balance)
                {
                    if($customer_balance->total_balance > 0)
                    {
                        if($customer_balance->total_balance > $request->grand_total)
                        {
                            $payment_status = 'paid';
                            $received = $request->grand_total;
                            $pending=0;
                        }else{
                            $payment_status = 'partially_paid';
                            $pending = $request->grand_total - $customer_balance->total_balance;
                            $received = $customer_balance->total_balance;
                        }
                    }else{
                        $payment_status = 'unpaid';  
                        $received=0;
                        $pending=$request->grand_total;
                    }
                }else{
                    $payment_status = 'unpaid';
                    $received=0;
                    $pending=$request->grand_total;
                }
                $status_data = [
                    'payment_status' =>  $payment_status,
                    'received' => $received,
                    'pending'=>$pending
                ];
                $po->update($status_data);

                $sales_ledger = \App\Models\SalesLedger::where('id',$request->customer_id)->get()->toArray();
                $opening_balance = $sales_ledger[0]['opening_balance'];
                $opening_balance_amount = $sales_ledger[0]['opening_balance_amount'];
                $grand_total = $request->grand_total;
                $balance_amount = (float)$grand_total;
                
                
                $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->first();
                //echo '<pre>';print_r($customer_balance);echo '</pre>';
                if($customer_balance)
                {
                    //echo "===== 1 =====";
                    $total_balance = (float)$customer_balance->total_balance ;
                    $update_blance = $total_balance - $balance_amount;
                    $toal_balance = $update_blance;
                    $balance_data = [
                        'total_balance'=>$update_blance
                    ];
                    //echo '<pre>';print_r($balance_data);echo '</pre>';
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->update($balance_data);
                }else{
                    //echo "===== 2 =====";
                    $toal_balance = $balance_amount;
                    $balance_data = [
                        'user_id'=>$customer_id,
                        'total_balance'=> $balance_amount,
                        'ledger_type'=>'customer'
                    ];
                    $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                }
            }
            $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->first();

            \App\Models\PaymentRecord::create([
                'posting_date' => $request->created_at,
                'user_id' => $request->user_id,
                'party' => $request->user_id,
                'account' => '',
                'opening_balance' => ($customer_balance) ? number_format($customer_balance->total_balance,3) : 0,
                'debit' => number_format($request->grand_total, 3),
                'credit' => '0.000',
                'balance' =>number_format($toal_balance,3),
                'voucher_type'=> 'App\Models\SalesInvoice',
                'recordable_type' => 'App\Models\SalesInvoice',
                'recordable_id'=>$po,
                'party_type' => 'Customer'
            ]);

            // $sales_ledger = \App\Models\SalesLedger::where('id',$request->customer_id)->get()->toArray();
            // $opening_balance = $sales_ledger[0]['opening_balance'];
            // $opening_balance_amount = $sales_ledger[0]['opening_balance_amount'];
            // $grand_total = $request->grand_total;
            // if($opening_balance == 'credit')
            // {
                
            //     // $data = [
            //     //     'payment_type' => 'receive',
            //     //     'amount' => $grand_total,
            //     //     'other_amount' => $grand_total,
            //     //     'payment_mode' => 'Opening Balance',
            //     // ];
            //     // $payment_data = new \App\Models\Payments($data);
            //     // $payment = $payment_data->save();

                
            //     // if($payment_data)
            //     // {
            //     //     $temp_items = [
            //     //         'payment_id' => $payment_data->id,
            //     //         'party_type' => 'customer',
            //     //         'party' => $request->customer_id,
            //     //         'against' => 'sales_invoice',
            //     //         'invoice_no' => $po->id,
            //     //         'amount' => $grand_total
            //     //     ];
            //     //     $payment_item_data = new \App\Models\PaymentAmountItems($temp_items);
            //     //     $payment_ii = $payment_item_data->save();
            //     // }

            //     // $sale_update_rate = $opening_balance_amount - $grand_total;
            //     // $ledger_up_data = [
            //     //     'opening_balance_amount'=>$sale_update_rate
            //     // ];
            //     // $so = \App\Models\SalesLedger::find($request->customer_id);
            //     // if($so)
            //     // {
            //     //     if ($so->update($ledger_up_data)){}
            //     // }
            // }

               $seriesinvoicedata=SalesInvoiceSeries::where('status','true')->first();
               if($seriesinvoicedata)
               {
                $number=(int)$seriesinvoicedata->series_current_digit+1;
                $seriesinvoicedata=SalesInvoiceSeries::find($seriesinvoicedata->id);
                $seriesinvoicedata->series_current_digit=$number;
                $seriesinvoicedata->save();
               } 
            return redirect()->route('sales-invoice.index')->with('message', __('messages.add', ['name' => 'Sales Invoice']));
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
        $order = SalesInvoice::with('items','other_charges')->find($id);
        $sales_orders = SalesOrders::where('active','1')->get();
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
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
        $salesinvoice=SalesInvoiceSeries::all();

        return view('admin.transactions.sales.sales-invoice.show',
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
                'sales_orders'=>$sales_orders,
                'batches'=>$batches,
                'invoice_status' => $this->invoice_status,
                'salesinvoice'=>$salesinvoice
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
        $order = SalesInvoice::with('items','other_charges')->find($id);
        //$sales_orders = SalesOrders::where('active','1')->get();
        $sales_order_id = $order['sales_order_id'];

        $q = SalesOrders::select('order_no', 'id')->where(function ($query) {
            $query->where('active', '=', 1);
        })->where(function ($query){
            $query->where('status', '=', 'pending')
            ->orWhere('status', '=', 'delivered_not_billed');
        });
        $q2 = $q->orderBy('id','desc')->get();
        $q1 = SalesOrders::select('order_no', 'id')->where('id',$sales_order_id)->get();
        $sales_orders = $q2->merge($q1);
        
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
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
        $salesinvoice=SalesInvoiceSeries::all();
        $salesinvoiceseriesstatus=SalesInvoiceSeries::where('status','true')->get();
        return view('admin.transactions.sales.sales-invoice.edit',
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
                'sales_orders'=>$sales_orders,
                'batches' => $batches,
                'invoice_status' => $this->invoice_status,
                'salesinvoice'=>$salesinvoice,
                'salesinvoiceseriesstatus'=>$salesinvoiceseriesstatus
            ]);
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
                'invoice_no' => $request->receipt_no,
                'sales_order_id' => $request->sales_order_id,
                'sales_ledger_id' => $request->customer_id,
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
                'debit_to' => $request->debit_to,
                'income_account' => $request->income_account,
                'expense_account' => $request->expense_account,
                'asset' => $request->asset,
                'credit_days'=> $request->credit_days,
                'required_date' => isset($request->required_date) ? $request->required_date : NULL,
                'payment_status' => isset($request->payment_status) ? $request->payment_status : NULL
            ];

             $so = SalesInvoice::find($id);
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
                                     'sales_invoice_id' => $so->id,
                                     'stock_item_id' => $items['item_name'],
                                     'item_code' => $items['item_code'],
                                     'batch_id' => $items['batch'],
                                     'unit' => $items['unit'],
                                     'quantity' => $items['quantity'],
                                     'rate' => $items['rate'],
                                     'net_amount' => $items['net_amount'],
                                     'tax' => $items['tax'],
                                     'tax_amount' => $items['tax_amount'],
                                    // 'cess' => $items['cess'],
                                    // 'cess_amount' => $items['cess_amount'],
                                     'total_amount' => $items['total_amount'],
                                     'discount_in_per' => $items['discount'],
                                     'discount' => $items['discount_amount'],
                                     'active' => 1
                                 ];

                                 $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                                 $poItem = SalesInvoiceItems::updateOrCreate([
                                     'id' => $items['item_id']
                                 ], $stock_data);

                                 $keep_items[] = $poItem->id;
                             }
                         }

                         if(isset($keep_items) && !empty($keep_items))
                         {
                            SalesInvoiceItems::where('sales_invoice_id', $so->id)->whereNotIn('id', $keep_items)->delete();
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
                                     'sales_invoice_id' => $so->id,
                                     'type' => $taxes['type'],
                                     'general_ledger_id' => $taxes['account_head'],
                                     'rate' => $taxes['other_rate'],
                                     'amount' => $taxes['other_amount'],
                                     'tax' => $taxes['other_tax'],
                                     'tax_amount' => $taxes['other_tax_amount'],
                                     'total_amount' => $taxes['other_total_amount'],
                                 ];

                                 $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                                 $PoOtherCharge = SalesInvoiceOtherCharges::updateOrCreate([
                                     'id' => $items['other_charge_id']
                                 ], $tax_data);

                                 $keep_other_items[] = $PoOtherCharge->id;
                             }
                         }
                         if(!empty($keep_other_items) && count($keep_other_items) > 0)
                         {
                            SalesInvoiceOtherCharges::where('sales_invoice_id', $so->id)->whereNotIn('id', $keep_other_items)->delete();
                         }
                     }

                    $sales_ledger = \App\Models\SalesLedger::where('id',$request->customer_id)->get()->toArray();
                    $opening_balance = $sales_ledger[0]['opening_balance'];
                    $opening_balance_amount = $sales_ledger[0]['opening_balance_amount'];
                    $grand_total = $request->grand_total;
                    if($opening_balance == 'credit' && $opening_balance_amount >= $grand_total)
                    {
                        
                        $data = [
                            'payment_type' => 'receive',
                            'amount' => $grand_total,
                            'other_amount' => $grand_total,
                            'payment_mode' => 'Opening Balance',
                        ];
                        $payment_data = new \App\Models\Payments($data);
                        $payment = $payment_data->save();

                        
                        if($payment_data)
                        {
                            $temp_items = [
                                'payment_id' => $payment_data->id,
                                'party_type' => 'customer',
                                'party' => $request->customer_id,
                                'against' => 'sales_invoice',
                                'invoice_no' => $po->id,
                                'amount' => $grand_total
                            ];
                            $payment_item_data = new \App\Models\PaymentAmountItems($temp_items);
                            $payment_ii = $payment_item_data->save();
                        }

                        $sale_update_rate = $opening_balance_amount - $grand_total;
                        $ledger_up_data = [
                            'opening_balance_amount'=>$sale_update_rate
                        ];
                        $so = \App\Models\SalesLedger::find($request->customer_id);
                        if($so)
                        {
                            if ($so->update($ledger_up_data)){}
                        }
                    }


                     return redirect()->route('sales-invoice.index')->with('message', __('messages.update', ['name' => 'Sales Invoice']));

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
        $sales_invoice = SalesInvoice::find($id);

        if ($sales_invoice)
        {
            $data = [
                'active' => 0,
            ];
            $sales_invoice->update($data);

            return redirect()->route('sales-invoice.index')->with('message', __('messages.delete', ['name' => 'Sales Invoice']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));

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
            $salesInvoice = SalesInvoice::with('items','other_charges','sales_order','target_warehouse')->find($id);

            $pdf = \PDF::loadView('admin.transactions.sales.sales-invoice.print', ['salesInvoice' => $salesInvoice]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata($id)
    {
        $data=SalesInvoiceSeries::where('id',$id)->first();
        return response()->json($data);
    }
}
