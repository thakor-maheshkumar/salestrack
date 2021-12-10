<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\PaymentRecord;
use App\Models\PurchaseLedger;
use App\Models\SalesLedger;
use DB;
class PaymentReportController extends CoreController
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
    public function index(Request $request)
    {
        $payment_records = PaymentRecord::with(['suppliers','customers','recordable'])->where('active',1)->orderBy('id', 'desc')->get();
        //echo '<pre>';print_r($payment_records);exit;
        // pred($items->toArray());
        return view('admin.reports.payment.index', [
            'payment_records' => $payment_records,
            /*'request_data' => $request_data*/
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function supplierPayementReport()
    {
        $payment_records = PaymentRecord::with(['suppliers','customers','recordable'])
                                        ->where('active',1)
                                        ->orderBy('id', 'desc')
                                        ->get();
        $purcheaseLedger=PurchaseLedger::where('active',1)->get();
        
         $salesLedger=SalesLedger::where('active',1)->get();   
         
         return view('admin.reports.payment.supplier',
            [
            'purcheaseLedger'=>$purcheaseLedger,
            'salesLedger'=>$salesLedger,
            'payment_records'=>$payment_records

            ]);
    }
    public function supplierPayementReportData(Request $request)
    {
        $purcheaseLedger=$request->puchase_ledger;
        
        $data=PaymentRecord::where('party',$purcheaseLedger)
                            ->where('active',1)
                            ->with(['suppliers','customers'])
                            
                            ->selectRaw('year(posting_date) year, monthname(posting_date) month,count(party) as data, sum(REPLACE(credit, ",", "")) as credit , sum(REPLACE(debit, ",","")) as debit,id,balance,voucher_type,party,party_type,posting_date,opening_balance,max(posting_date) as createAt')
                            ->groupBy('month','year')
                             ->orderBy('createAt','desc')
                            ->get();
       
        $results=PaymentRecord::where('party',$purcheaseLedger)->latest('id')->first();
        $balanceData=$results->balance ?? 0;
        return json_encode(['payementData'=>$data,'balanceData'=>$balanceData]);
    }
}
