<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\PurchaseLedger;
use App\Models\SalesLedger;
use App\Models\GeneralLedger;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReceipt;
use App\Models\SalesInvoice;
use App\Models\PaymentAmountItems;
use App\Http\Requests\Admin\PaymentRequest;

class PaymentController extends CoreController
{
    protected static $payment_types = [
        'pay' => 'Pay',
        'receive' => 'Receive'
    ];

    protected static $party_types = [
        'supplier' => 'Supplier',
        'customer' => 'Customer',
        'other' => 'Other'
    ];

    protected static $against_list = [
        'sales_invoice' => 'Sales Invoice',
        'purchase_invoice' => 'Purchase Invoice',
        'other' => 'On Account'
    ];

    protected static $modes_of_payment = [
        'cash' => 'Cash',
        'bank' => 'Bank'
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
        $payments = Payments::with('amount_items')->get();

        return view('admin.payments.index', [
            'payment_types' => self::$payment_types,
            'party_types' => self::$party_types,
            'against_list' => self::$against_list,
            'modes_of_payment' => self::$modes_of_payment,
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $others = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $sales_vouchers = SalesInvoice::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();
        $purchase_vouchers = PurchaseReceipt::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();

        $sales_invoices = SalesInvoice::where('active', 1)->where('invoice_no', '!=', '')->where('payment_status','!=','paid')->pluck('invoice_no', 'id')->toArray();
        $purchase_invoices = PurchaseInvoice::where('active', 1)->where('invoice_no', '!=', '')->where('payment_status','!=','paid')->pluck('invoice_no', 'id')->toArray();

        
        return view('admin.payments.create', [
            'payment_types' => self::$payment_types,
            'party_types' => self::$party_types,
            //'against_list' => self::$against_list,
            'against_list' => array(),
            'modes_of_payment' => self::$modes_of_payment,
            'suppliers' => $suppliers,
            'customers' => $customers,
            'others' => $others,
            'sales_vouchers' => $sales_vouchers,
            'purchase_vouchers' => $purchase_vouchers,
            'sales_invoices' => $sales_invoices,
            'purchase_invoices' => $purchase_invoices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        //echo '<pre>';print_r($_POST);exit;

        $pdata = [
            'payment_type' => $request->payment_type,
            'party_type' => $request->party_type,
            'party' => $request->party,
            'amount' => $request->amount,
            //'other_amount' => $request->other_amount,
            'payment_mode' => $request->payment_mode,
            'cheque_no' => $request->cheque_no,
            'cheque_date' => $request->cheque_date,
            'contact' => $request->contact,
            'remarks' => $request->remarks
        ];

        $payment = new Payments($pdata);
        $checkbox_ticked = $request->use_on_account;
        if($payment->save())
        {
            if(isset($request->items) && !empty($request->items))
            {
                $temp_items = [];
                foreach ($request->items as $key => $item)
                {
                    $temp_items[] = [
                        'payment_id' => $payment->id,
                        'against' => $item['against'],
                        'invoice_no' => isset($item['invoice_no']) ? $item['invoice_no'] : NULL,
                        'amount' => $item['amount']
                    ];
                    PaymentAmountItems::insert($temp_items);

                    
                    $amount = $item['amount'];
                    if($item['against']=='purchase_invoice')
                    {
                        $ledger = \App\Models\PurchaseLedger::where('id',$request->party)->first();
                        $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->first();
                        $user_on_account_balance=0;
                       

                        $invoice_id=$item['invoice_no'];
                        $invoice = \App\Models\PurchaseInvoice::where('id',$invoice_id)->first();
                        $invoice_amount = $invoice->grand_total;
                        $received = $invoice->received;
                        $remaining_amount = $invoice_amount - $received;

                        if(isset($checkbox_ticked) && $user_on_ac_bal)
                        {
                            $user_on_account_balance = $user_on_ac_bal->total_on_account_balance;
                            if($user_on_account_balance >= $amount)
                            {
                                $status_data = [
                                    'payment_status' =>  'paid',
                                    'received' => $amount,
                                    'pending'=>0
                                ];
                                $invoice->update($status_data);
                                $update_s_amount_data = [
                                    'total_on_account_balance' =>  $user_on_account_balance - $amount
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->update($update_s_amount_data);
                            }else if($user_on_account_balance < $amount){
                                $status_data = [
                                    'payment_status' =>  'partially_paid',
                                    'received' => $amount,
                                    'pending' => $invoice_amount - ($received+$amount)
                                ];
                                $invoice->update($status_data);
                                $update_s_amount_data = [
                                    'total_on_account_balance' =>  0
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->update($update_s_amount_data);
                            
                            }
                        }else if($amount == $invoice_amount){
                            $status_data = [
                                'payment_status' =>  'paid',
                                'received' => $amount,
                                'pending'=>0
                            ];
                        }else if($remaining_amount <= $amount){
                            $status_data = [
                                'payment_status' => 'paid',
                                'received' => $invoice_amount,
                                'pending'=>0
                            ];
                        }else{
                            $status_data = [
                                'payment_status' =>  'partially_paid',
                                'received' => $received+$amount,
                                'pending'=> $invoice_amount - ($received+$amount)
                            ];
                        }
                        $invoice->update($status_data);

                        $amount = $item['amount'];
                        if($ledger->maintain_balance_bill_by_bill==1 && $amount >= $invoice_amount)
                        {
                            $amount_to_be_added = $amount-$invoice_amount;
                            $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->first();
                            if($user_on_ac_bal){
                                $on_account_balance = $user_on_ac_bal->total_on_account_balance;
                                $on_account_balance = $on_account_balance + $amount_to_be_added; 
                                $update_amount_data = [
                                    'total_on_account_balance' =>  $on_account_balance
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->update($update_amount_data);
                            }else{
                                $on_account_balance = $amount_to_be_added;
                                $user_on_account_blance = \App\Models\UserOnAccountBalanceInfo::create([
                                    'user_id' => $request->party,
                                    'ledger_type' => 'supplier',
                                    'total_on_account_balance' => $on_account_balance,
                                ]);
                            }
                        }
                    }else if($item['against']=='sales_invoice'){

                        $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->first();
                        $user_on_account_balance=0;

                        $ledger = \App\Models\SalesLedger::where('id',$request->party)->first();

                        $invoice_id=$item['invoice_no'];

                        $invoice = \App\Models\SalesInvoice::where('id',$invoice_id)->first();
                        $invoice_amount = $invoice->grand_total;
                        $received = $invoice->received;
                        $remaining_amount = $invoice_amount - $received;

                        if(isset($checkbox_ticked) && $user_on_ac_bal)
                        {
                            $user_on_account_balance = $user_on_ac_bal->total_on_account_balance;
                            if($user_on_account_balance >= $amount)
                            {
                                $status_data = [
                                    'payment_status' =>  'paid',
                                    'received' => $amount,
                                    'pending'=>0
                                ];
                                $invoice->update($status_data);
                                $update_s_amount_data = [
                                    'total_on_account_balance' =>  $user_on_account_balance - $amount
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->update($update_s_amount_data);
                            }else if($user_on_account_balance < $amount){
                                $status_data = [
                                    'payment_status' =>  'partially_paid',
                                    'received' => $amount,
                                    'pending' => $invoice_amount - ($received+$amount)
                                ];
                                $invoice->update($status_data);
                                $update_s_amount_data = [
                                    'total_on_account_balance' =>  0
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->update($update_s_amount_data);
                            
                            }
                        }else if($amount == $invoice_amount){
                            $status_data = [
                                'payment_status' =>  'paid',
                                'received' => $amount,
                                'pending' => 0
                            ];
                        }else if($remaining_amount <= $amount){
                            $status_data = [
                                'payment_status' =>  'paid',
                                'received' => $invoice_amount,
                                'pending' => 0
                            ];
                        }else{
                            $status_data = [
                                'payment_status' =>  'partially_paid',
                                'received' => $received+$amount,
                                'pending' => $invoice_amount - ($received+$amount)
                            ];
                        }
                        $invoice->update($status_data); 
                        
                        if($ledger->maintain_balance_bill_by_bill==1 && $amount >= $invoice_amount)
                        {
                            $amount_to_be_added = $amount-$invoice_amount;
                            $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->first();
                            if($user_on_ac_bal){
                                $on_account_balance = $user_on_ac_bal->total_on_account_balance;
                                $on_account_balance = $on_account_balance + $amount_to_be_added; 
                                $update_amount_data = [
                                    'total_on_account_balance' =>  $on_account_balance
                                ];
                                \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->update($update_amount_data);
                            }else{
                                $on_account_balance = $amount_to_be_added;
                                $user_on_account_blance = \App\Models\UserOnAccountBalanceInfo::create([
                                    'user_id' => $request->party,
                                    'ledger_type' => 'customer',
                                    'total_on_account_balance' => $on_account_balance,
                                ]);
                            }
                        }
                        
                    }else{
                        ///// Complted.... see sales invoice 2nd else if .....//
                        if($request->party_type=='supplier')
                        {
                            $ledger = \App\Models\PurchaseLedger::where('id',$request->party)->first();
                            if($ledger->maintain_balance_bill_by_bill==1)
                            {
                                $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->first();
                                if($user_on_ac_bal){
                                    $on_account_balance = $user_on_ac_bal->total_on_account_balance;
                                    $on_account_balance = $on_account_balance + $item['amount']; 
                                    $update_amount_data = [
                                        'total_on_account_balance' =>  $on_account_balance
                                    ];
                                    \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','supplier')->update($update_amount_data);
                                }else{
                                    $on_account_balance = $item['amount'];
                                    $user_on_account_blance = \App\Models\UserOnAccountBalanceInfo::create([
                                        'user_id' => $request->party,
                                        'ledger_type' => 'supplier',
                                        'total_on_account_balance' => $on_account_balance,
                                    ]);
                                }
                            }else{
                                $invoices = \App\Models\PurchaseInvoice::where('supplier_id',$request->party)->where('payment_status','!=','paid')->orderBy('id','asc')->get()->toArray();
                                if(!empty($invoices))
                                {
                                    $update_data=array();
                                    $total_amount = $item['amount'];
                                    foreach($invoices as $in)
                                    {
                                        if($total_amount > 0)
                                        {
                                            //$taken_amount = $in['grand_total']-$in['received'];
                                            $taken_amount = $in['pending'];
                                            if($taken_amount <= $total_amount)
                                            {
                                                $grand_total = $taken_amount;
                                                $update_data = [
                                                    'payment_status' =>  'paid',
                                                    'received' => $in['grand_total'],
                                                    'pending'=>0
                                                ];
                                            }else{
                                                $grand_total = $in['received'] + $total_amount;
                                                $update_data = [
                                                    'payment_status' =>  'partially_paid',
                                                    'received' => $in['received'] + $total_amount,
                                                    'pending'=>$in['grand_total'] - $grand_total
                                                ];
                                            }

                                            //echo '<pre>';print_r($update_data);
                                            \App\Models\PurchaseInvoice::where('id',$in['id'])->update($update_data);

                                            $total_amount -= $grand_total;
                                        }
                                    }
                                } 
                            }
                        }else if($request->party_type=='customer'){

                            $ledger = \App\Models\SalesLedger::where('id',$request->party)->first();

                            if($ledger->maintain_balance_bill_by_bill==1)
                            {
                                $user_on_ac_bal  = \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->first();
                                if($user_on_ac_bal){
                                    $on_account_balance = $user_on_ac_bal->total_on_account_balance;
                                    $on_account_balance = $on_account_balance + $item['amount']; 
                                    $update_amount_data = [
                                        'total_on_account_balance' =>  $on_account_balance
                                    ];
                                    \App\Models\UserOnAccountBalanceInfo::where('user_id',$request->party)->where('ledger_type','customer')->update($update_amount_data);
                                }else{
                                    $on_account_balance = $item['amount'];
                                    $user_on_account_blance = \App\Models\UserOnAccountBalanceInfo::create([
                                        'user_id' => $request->party,
                                        'ledger_type' => 'customer',
                                        'total_on_account_balance' => $on_account_balance,
                                    ]);
                                }
                            }else{
                                $invoices = \App\Models\SalesInvoice::where('sales_ledger_id',$request->party)->where('payment_status','!=','paid')->orderBy('id','asc')->get()->toArray();
                                if(!empty($invoices))
                                {
                                    $update_data=array();
                                    $total_amount = $item['amount'];
                                    foreach($invoices as $in)
                                    {
                                        // echo "Invoice No: ".$in['id'];
                                        // echo '<pre>';print_r($in);
                                        // echo "Total Amount :".$total_amount;
                                        if($total_amount > 0)
                                        {
                                            //$taken_amount = $in['grand_total']-$in['received'];
                                            $taken_amount = $in['pending'];
                                            if($taken_amount <= $total_amount)
                                            {
                                                $grand_total = $taken_amount;
                                                $update_data = [
                                                    'payment_status' =>  'paid',
                                                    'received' => $in['grand_total'],
                                                    'pending'=>0
                                                ];
                                            }else{
                                                $grand_total = $in['received'] + $total_amount;
                                                $update_data = [
                                                    'payment_status' =>  'partially_paid',
                                                    'received' => $in['received'] + $total_amount,
                                                    'pending'=>$in['grand_total'] - $grand_total
                                                ];
                                            }
    
                                            //echo '<pre>';print_r($update_data);
                                            \App\Models\SalesInvoice::where('id',$in['id'])->update($update_data);
    
                                            $total_amount -= $grand_total;
                                        }
                                    }
                                }
                            }
                            
                       }
                    }

                }

                $customer_id=$request->party;
                $sales_ledger = \App\Models\SalesLedger::where('id',$customer_id)->get()->toArray();
                // $opening_balance = $sales_ledger[0]['opening_balance'];
                // $opening_balance_amount = $sales_ledger[0]['opening_balance_amount'];
                //$grand_total = $item['amount'];
                $grand_total = $request->amount;
                $balance_amount = (float)$grand_total;

                if($request->party_type=='customer')
                {
                    $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->first();
                }else if($request->party_type=='supplier'){
                    $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','supplier')->first();
                }else{
                    $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','general')->first();
                }
                
                if($customer_balance)
                {
                    $total_balance = (float)$customer_balance->total_balance ;
                }else{
                    $total_balance = 0;
                }
                
                if(isset($request->payment_type) && $request->payment_type == 'pay') {

                    $update_blance = $total_balance - $balance_amount;
                }else if(isset($request->payment_type) && $request->payment_type == 'receive') {
                    $update_blance = $total_balance + $balance_amount;
                }
                $balance_data = [
                    'total_balance'=>$update_blance
                ];
                if($request->party_type=='customer')
                {
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','customer')->update($balance_data);
                }else if($request->party_type=='supplier'){
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','supplier')->update($balance_data);
                }else{
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$customer_id)->where('ledger_type','general')->update($balance_data);
                }
                
                $payment_id = $payment->id;
                $payment_items = \App\Models\PaymentAmountItems::where('payment_id',$payment_id)->first();
                if($payment_items->party_type=='supplier')
                {
                    $supplier = \App\Models\PurchaseLedger::where('id',$payment_items->party)->first();
                    $user_id = (isset($supplier) && !empty($supplier)) ? $supplier->id : NULL;
                }else if($payment_items->party_type=='customer'){
                    $sales = \App\Models\SalesLedger::where('id',$payment_items->party)->first();
                    $user_id = (isset($sales) && !empty($sales)) ? $sales->id : NULL;
                }else{
                    $general = \App\Models\GeneralLedger::where('id',$payment_items->party)->first();
                    $user_id = (isset($general) && !empty($general)) ? $general->id : NULL;
                }

                if(isset($payment->payment_type) && $payment->payment_type == 'pay') {
                    $report_type = 'Payment Paid';

                    $voucher_type = $report_type;
                    $debit = number_format($payment_items->amount, 3);
                    $credit = '0.000';
                }
                else if(isset($payment->payment_type) && $payment->payment_type == 'receive') {
                    $report_type = 'Payment Received';

                    $voucher_type = $report_type;
                    $debit = '0.000';
                    $credit = number_format($payment_items->amount, 3);
                }

                $data = [
                    'posting_date' => $payment->created_at,
                    'user_id' => $user_id,
                    'party' => $user_id,
                    'account' => NULL,
                    'opening_balance' => number_format($total_balance,3),
                    'balance' => number_format($update_blance, 3),
                    'party_type' => $payment_items->party_type,
                    //'party' => isset($payment_items->party) ? $payment_items->party : NULL,
                    'voucher_type'=>$voucher_type,
                    'debit'=>$debit,
                    'credit' => $credit,
                    'recordable_type' => 'App\Models\Payments',
                    'recordable_id' => $payment->id
                ];
                \App\Models\PaymentRecord::insert($data);
            }
            //exit;
            return redirect()->route('payments.index')->with('message', __('messages.add', ['name' => 'Payment']));
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
            $payment = Payments::find($id);
            $amount_items = PaymentAmountItems::where('payment_id',$id)->get()->toArray();
            //echo '<pre>';print_r($payment);echo '</pre>';exit;
            $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $others = GeneralLedger::pluck('ledger_name', 'id')->toArray();

            $sales_vouchers = SalesInvoice::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();
            $purchase_vouchers = PurchaseReceipt::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();

            $sales_invoices = SalesInvoice::where('active', 1)->where('invoice_no', '!=', '')->pluck('invoice_no', 'id')->toArray();
            $purchase_invoices = PurchaseInvoice::where('active', 1)->where('invoice_no', '!=', '')->pluck('invoice_no', 'id')->toArray();


            return view('admin.payments.edit', [
                'payment_types' => self::$payment_types,
                'amount_items' => $amount_items,
                'party_types' => self::$party_types,
                'against_list' => self::$against_list,
                'modes_of_payment' => self::$modes_of_payment,
                'suppliers' => $suppliers,
                'customers' => $customers,
                'others' => $others,
                'sales_vouchers' => $sales_vouchers,
                'purchase_vouchers' => $purchase_vouchers,
                'payment' => $payment,
                'sales_invoices' => $sales_invoices,
                'purchase_invoices' => $purchase_invoices
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
            $payment = Payments::find($id);
            $amount_items = PaymentAmountItems::where('payment_id',$id)->get()->toArray();
            //echo '<pre>';print_r($payment);echo '</pre>';exit;
            $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
            $others = GeneralLedger::pluck('ledger_name', 'id')->toArray();

            $sales_vouchers = SalesInvoice::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();
            $purchase_vouchers = PurchaseReceipt::where('active', 1)->where('voucher_no', '!=', '')->pluck('voucher_no', 'id')->toArray();

            $sales_invoices = SalesInvoice::where('active', 1)->where('invoice_no', '!=', '')->pluck('invoice_no', 'id')->toArray();
            $purchase_invoices = PurchaseInvoice::where('active', 1)->where('invoice_no', '!=', '')->pluck('invoice_no', 'id')->toArray();


            return view('admin.payments.edit', [
                'payment_types' => self::$payment_types,
                'amount_items' => $amount_items,
                'party_types' => self::$party_types,
                'against_list' => self::$against_list,
                'modes_of_payment' => self::$modes_of_payment,
                'suppliers' => $suppliers,
                'customers' => $customers,
                'others' => $others,
                'sales_vouchers' => $sales_vouchers,
                'purchase_vouchers' => $purchase_vouchers,
                'payment' => $payment,
                'sales_invoices' => $sales_invoices,
                'purchase_invoices' => $purchase_invoices
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
    public function update(PaymentRequest $request, $id)
    {
        if($id)
        {
            $payment = Payments::find($id);

            if($payment)
            {
                $data = [
                    'payment_type' => $request->payment_type,
                    'amount' => $request->amount,
                    'other_amount' => $request->other_amount,
                    'payment_mode' => $request->payment_mode,
                    'cheque_no' => $request->cheque_no,
                    'cheque_date' => $request->cheque_date,
                    'contact' => $request->contact,
                    'remarks' => $request->remarks
                ];

                if($payment->update($data))
                {
                    if(isset($request->items) && !empty($request->items))
                    {
                        $temp_items = $keep_items = [];
                        foreach ($request->items as $key => $item)
                        {
                            $temp_items = [
                                'payment_id' => $payment->id,
                                'party_type' => $request->party_type,
                                'party' => $request->party,
                                'against' => $item['against'],
                                'invoice_no' => $item['invoice_no'],
                                'amount' => $item['amount']
                            ];

                            $paymentAmoutItem = PaymentAmountItems::updateOrCreate([
                                'payment_id' => $payment->id,
                                'id' => $item['payment_item_id']
                            ], $temp_items);

                            if(!empty($paymentAmoutItem))
                            {
                                $keep_items[] = $paymentAmoutItem->id;
                            }
                        }

                        if(!empty($keep_items)) {
                            PaymentAmountItems::where('payment_id', $payment->id)->whereNotIn('id', $keep_items)->delete();
                        }
                    }

                    return redirect()->route('payments.index')->with('message', __('messages.update', ['name' => 'Payment']));
                }
            }

            return redirect()->back()->with('error', __('messages.somethingWrong'));
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
        $payment = Payments::find($id);

        if ($payment)
        {
            if($payment->delete())
            {
                return redirect()->route('payments.index')->with('message', __('messages.delete', ['name' => 'Payment']));
            }
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function getInvoice(Request $request,$voucher_id,$against)
    {
        if ($request->ajax())
        {
            if($against=='sales_invoice'){
                //$data = SalesInvoice::where('active', 1)->where('id', $voucher_id)->pluck('invoice_no', 'id')->toArray();
                $data = SalesInvoice::where('active', 1)->where('id', $voucher_id)->first();
                return response()->json(['id'=>$data->id]);
            }else if($against=='purchase_invoice'){

            }else{

            }
           
        }
    }

    function getVoucher(Request $request,$invoice_id,$against)
    {
        if ($request->ajax())
        {
            if($against=='sales_invoice'){
                //$data = SalesInvoice::where('active', 1)->where('id', $voucher_id)->pluck('invoice_no', 'id')->toArray();
                $data = SalesInvoice::where('active', 1)->where('id', $invoice_id)->first();
                return response()->json(['id'=>$data->id]);
            }else if($against=='purchase_invoice'){

            }else{

            }
           
        }
    }

    function getAgaistDropdownValue(Request $request,$party_type,$party)
    {
        $total_balance=0;
        if ($request->ajax())
        {
            $against_list=array();
            if($party_type=='supplier')
            {
                $purchase_ladger = PurchaseLedger::where('id', $party)->first();
                if($purchase_ladger->maintain_balance_bill_by_bill==1)
                {
                    $against_list['purchase_invoice'] = 'Purchase Invoice';
                    $is_show_invoice=1;
                    $balance = \App\Models\UserOnAccountBalanceInfo::where('user_id',$party)->where('ledger_type','supplier')->first();
                    if(!empty($balance))
                    {
                        $total_balance = $balance->total_on_account_balance;
                    }
                }else{
                    //$against_list['other']='On Account';
                    $is_show_invoice=0;
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$party)->where('ledger_type','supplier')->first();
                    if(!empty($balance))
                    {
                        $total_balance = $balance->total_balance;
                    }
                }
                $invoices = PurchaseInvoice::where('active', 1)->where('supplier_id',$party)->where('invoice_no', '!=', '')->where('payment_status','!=','paid')->pluck('invoice_no', 'id')->toArray();
            }
            if($party_type=='customer')
            {
                $sales_ladger = SalesLedger::where('id', $party)->first();
                
                if($sales_ladger->maintain_balance_bill_by_bill==1)
                {
                    $against_list['sales_invoice'] = 'Sales Invoice';
                    $is_show_invoice=1;
                    $balance = \App\Models\UserOnAccountBalanceInfo::where('user_id',$party)->where('ledger_type','customer')->first();
                    if(!empty($balance))
                    {
                        $total_balance = $balance->total_on_account_balance;
                    }
                }else{
                   // $against_list['other']='On Account';
                    $is_show_invoice=0;
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$party)->where('ledger_type','customer')->first();
                    if(!empty($balance))
                    {
                        $total_balance = $balance->total_balance;
                    }
                }
                $invoices = SalesInvoice::where('active', 1)->where('sales_ledger_id',$party)->where('invoice_no', '!=', '')->where('payment_status','!=','paid')->pluck('invoice_no', 'id')->toArray();

            }
            if($party_type=='other')
            {
                $balance = \App\Models\UserBalanceInfo::where('user_id',$party)->where('ledger_type','general')->first();
                if(!empty($balance))
                {
                    $total_balance = $balance->total_balance;
                }
                $invoices='';
            }

            
            $against_list['other']='On Account';
            return response()->json(['against_list'=>$against_list,'is_show_invoice'=>$is_show_invoice,'balance'=>$total_balance,'invoices'=>$invoices]);           
        }
    }

    function getPaymentInvoiceDetails($invoice_no,$party_type,$party)
    {
        if($party_type=='supplier')
        {
            $invoice_details = \App\Models\PurchaseInvoice::where('id',$invoice_no)->first();
        }
        else if($party_type=='customer')
        {
            $invoice_details = \App\Models\SalesInvoice::where('id',$invoice_no)->first();
        }
        if($invoice_details)
        {
            if($invoice_details->received != 0)
            {
                $data['amount']=$invoice_details->grand_total - $invoice_details->received;
            }else{
                $data['amount']=$invoice_details->grand_total;
            }
        }else{
            $data['amount']=0;
        }
        return response()->json(['data'=>$data]);           

    }
    function showUserBalance($party_type,$party)
    {
        if($party_type=='supplier')
        {
            $balance = \App\Models\UserOnAccountBalanceInfo::where('user_id',$party)->where('ledger_type','supplier')->first();
        }
        if($party_type=='customer')
        {
            $balance = \App\Models\UserOnAccountBalanceInfo::where('user_id',$party)->where('ledger_type','customer')->first();
        }
        if(!empty($balance))
        {
            $total_on_account_balance = $balance->total_on_account_balance;
        }else{
            $total_on_account_balance=0;
        }
        return response()->json(['balance'=>$total_on_account_balance]);  
        
    }
}
