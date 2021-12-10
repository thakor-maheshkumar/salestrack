<?php

namespace App\Traits;

trait PaymentRecord
{
    /**
     * PaymentRecord boot logic.
     *
     * @return void
     */
    public static function bootPaymentRecord()
    {

        static::saved(function ($model) {
            switch (static::class) {
                case 'App\Models\SalesInvoice':
                    $report_type = 'Sales Invoice';

                    $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$model->customers->id)->where('ledger_type','customer')->first();
                    $total_balance = ($customer_balance) ? (float)$customer_balance->total_balance : 0;
                    $data = [
                        'posting_date' => $model->created_at,
                        'user_id' => (isset($model->customers->id) && !empty($model->customers->id)) ? $model->customers->id : NULL,
                        'party' => (isset($model->customers->id) && !empty($model->customers->id)) ? $model->customers->id : NULL,
                        'account' => '',
                        'opening_balance' => number_format($total_balance,3),
                        'debit' => number_format($model->grand_total, 3),
                        'credit' => '0.000',
                        'balance' => number_format($model->grand_total, 3),
                        'voucher_type' => $report_type,
                        //'voucher_no' => $model->voucher_no,
                        //'against_account' => isset($model->sales_person->name) ? $model->sales_person->name : NULL,
                        'party_type' => 'Customer',
                        //'party' => (isset($model->customers->ledger_name) && !empty($model->customers->ledger_name)) ? $model->customers->ledger_name : NULL,
                        //'against_voucher_type' => $report_type,
                       // 'supplier_invoice' => NULL,
                       // 'remarks' => NULL,
                    ];

                    break;
                
                case 'App\Models\PurchaseInvoice':
                    //$report_type = 'Purchase Invoice';

                    //$customer_balance =\App\Models\UserBalanceInfo::where('user_id',$model->suppliers->id)->where('ledger_type','supplier')->first();
                    /*if(!isset($customer_balance)){
                        $customerdata=[
                            'user_id'=>$model->suppliers->id,
                            'total_balance'=>0,
                            'ledger_type'=>'supplier',
                        ];
                        $customer_balance=\App\Models\UserBalanceInfo::insert($customerdata);
                        $total_balance = 0;

                    }
                    else
                    {
                        $total_balance = ($customer_balance->total_balance) ? (float)$customer_balance->total_balance : 0;
                    }*/
                    // $grand_total = $model->grand_total;
                    // $balance_amount = (float)$grand_total;
                    // if($customer_balance)
                    // {
                    //     $total_balance = (float)$customer_balance->total_balance ;
                    //     $update_blance = $total_balance + $balance_amount;
                    //     $toal_balance = $update_blance;
                    //     $balance_data = [
                    //         'total_balance'=>$update_blance
                    //     ];
                    //     $balance = \App\Models\UserBalanceInfo::where('user_id',$model->suppliers->id)->update($balance_data);
                    // }else{
                    //     $total_balance = $balance_amount;
                    //     $balance_data = [
                    //         'user_id'=>$model->suppliers->id,
                    //         'total_balance'=> $balance_amount,
                    //         'ledger_type'=>'supplier'
                    //     ];
                    //     $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                    // }


                    // $data = [
                    //     'posting_date' => $model->created_at,
                    //     'user_id' => (isset($model->suppliers->id) && !empty($model->suppliers->id)) ? $model->suppliers->id : NULL,
                    //     'party' => (isset($model->suppliers->id) && !empty($model->suppliers->id)) ? $model->suppliers->id : NULL,
                    //     'account' => '',
                    //     'opening_balance' => number_format($total_balance,3),
                    //     'debit' => '0.000',
                    //     'credit' => number_format($model->grand_total, 3),
                    //     //'balance' => number_format($model->grand_total, 3),
                    //     'balance' => number_format($total_balance, 3),
                    //     'voucher_type' => $report_type,
                    //     'party_type' => 'Supplier',
                    //     //'party' => (isset($model->suppliers->ledger_name) && !empty($model->suppliers->ledger_name)) ? $model->suppliers->ledger_name : NULL,
                       
                    // ];

                    break;
                
                // case 'App\Models\PurchaseReceipt':
                //     $report_type = 'Purchase Receipt';
                //     $rate = isset($model->po_id) ? \App\Models\PoItems::select('rate')->where('po_id',$model->po_id)->first()->rate : 0;

                //     $data = [
                //         'posting_date' => $model->created_at,
                //         'user_id' => (isset($model->suppliers->id) && !empty($model->suppliers->id)) ? $model->suppliers->id : NULL,
                //         'party' => (isset($model->suppliers->id) && !empty($model->suppliers->id)) ? $model->suppliers->id : NULL,
                //         'account' => '',
                //         'debit' => number_format($model->receipt_quantity * $rate, 3),
                //         'credit' => '0.000',
                //         'balance' => number_format($model->receipt_quantity * $rate, 3),
                //         'voucher_type' => $report_type,
                //         //'voucher_no' => $model->voucher_no,
                //         //'against_account' => NULL,
                //         'party_type' => 'Supplier',
                //         //'party' => (isset($model->suppliers->ledger_name) && !empty($model->suppliers->ledger_name)) ? $model->suppliers->ledger_name : NULL,
                //         // 'against_voucher_type' => $report_type,
                //         // 'supplier_invoice' => NULL,
                //         // 'remarks' => NULL,
                //     ];

                //     break;
                   
                    
                // case 'App\Models\Payments':

                    
                //     echo $payment_id = $model->id;
                //     echo $payment = \App\Models\PaymentAmountItems::where('payment_id',$payment_id)->toSql();exit;
                //     echo '<pre>';print_r($payment);
                //     if($payment->party_type=='supplier')
                //     {
                //         $supplier = \App\Models\PurchaseLedger::where('id',$model->party)->first();
                //         $user_id = (isset($supplier) && !empty($supplier)) ? $supplier->id : NULL;
                //     }else if($payment->party_type=='customer'){
                //         $sales = \App\Models\SalesLedger::where('id',$model->party)->first();
                //         $user_id = (isset($sales) && !empty($sales)) ? $sales->id : NULL;
                //     }else{
                //         $general = \App\Models\GeneralLedger::where('id',$model->party)->first();
                //         $user_id = (isset($general) && !empty($general)) ? $general->id : NULL;
                //     }
                //     $data = [
                //         'posting_date' => $payment->created_at,
                //         'user_id' => $user_id,
                //         'account' => NULL,
                //         'balance' => number_format($payment->amount, 3),
                //         //'voucher_no' => NULL,
                //         //'against_account' => NULL,
                //         'party_type' => $payment->party_type,
                //         'party' => isset($payment->party) ? $payment->party : NULL,
                //         // 'against_voucher_type' => $model->against,
                //         // 'against_voucher' => $model->voucher_no,
                //         // 'supplier_invoice' => NULL,
                //         // 'remarks' => $model->remarks,
                //     ];

                //     if(isset($payment->payment_type) && $payment->payment_type == 'pay') {
                //         $report_type = 'Payment Paid';

                //         $data['voucher_type'] = $report_type;
                //         $data['debit'] = number_format($payment->amount, 3);
                //         $data['credit'] = '0.000';
                //     }
                //     else if(isset($payment->payment_type) && $payment->payment_type == 'receive') {
                //         $report_type = 'Payment Received';

                //         $data['voucher_type'] = $report_type;
                //         $data['debit'] = '0.000';
                //         $data['credit'] = number_format($payment->amount, 3);
                //     }

                //     break;

                case 'App\Models\SalesLedger':
                    $report_type = 'Sales Ledger';
                    $data = [
                        'posting_date' => $model->created_at,
                        'user_id' => $model->id,
                        'account' => NULL,
                        'opening_balance' => '0.000',
                        'balance' => (isset($model->opening_balance) && $model->opening_balance == 'debit') ? '-'.number_format($model->opening_balance_amount, 3) : number_format($model->opening_balance_amount, 3),
                        //'voucher_no' => NULL,
                        'against_account' => NULL,
                        'party_type' => 'Customer',
                        'party' => $model->id,
                        // 'against_voucher_type' => 'Customer',
                        // 'against_voucher' => NULL,
                        // 'supplier_invoice' => NULL,
                        // 'remarks' => NULL,
                        'voucher_type' => $report_type
                    ];

                    if(isset($model->opening_balance) && $model->opening_balance == 'debit') {
                        $data['debit'] = number_format($model->opening_balance_amount, 3);
                        $data['credit'] = '0.000';
                    }
                    else if(isset($model->opening_balance) && $model->opening_balance == 'credit') {
                        $data['debit'] = '0.000';
                        $data['credit'] = number_format($model->opening_balance_amount, 3);
                    }

                    break;

                case 'App\Models\PurchaseLedger':

                    $report_type = 'Purchase Ledger';

                    $data = [
                        /*'recordable_id' => $model->id,*/
                        'posting_date' => $model->created_at,
                        'user_id' => $model->id,
                        'account' => NULL,
                        'opening_balance' => '0.000',
                        'balance' => (isset($model->opening_balance) && $model->opening_balance == 'debit') ? '-'.number_format($model->opening_balance_amount, 3) : number_format($model->opening_balance_amount, 3),
                        'voucher_type' => $report_type,
                        //'voucher_no' => NULL,
                        //'against_account' => NULL,
                        'party_type' => 'Supplier',
                        //'party' => (isset($model->ledger_name) && !empty($model->ledger_name)) ? $model->ledger_name : NULL,
                        'party' => $model->id,
                        // 'against_voucher_type' => 'Supplier',
                        // 'supplier_invoice' => NULL,
                        // 'remarks' => NULL,
                    ];

                    if(isset($model->opening_balance) && $model->opening_balance == 'debit') {
                        $data['debit'] = number_format($model->opening_balance_amount, 3);
                        $data['credit'] = '0.000';
                    }
                    else if(isset($model->opening_balance) && $model->opening_balance == 'credit') {
                        $data['debit'] = '0.000';
                        $data['credit'] = number_format($model->opening_balance_amount, 3);
                    }

                    break;

                default:
                    $data = [];
                    $report_type = '';
                    break;
            }

            if(!empty($data) && !empty($report_type)) {
                $result = $model->records()->updateOrCreate([
                    'voucher_type' => $report_type,
                    'recordable_id' => $model->id
                ], $data);
            }
        });
    }

    /**
     * Define the relation between PaymentRecord and model.
     */
    public function records()
    {
        return $this->morphMany('\App\Models\PaymentRecord', 'recordable');
    }
}
