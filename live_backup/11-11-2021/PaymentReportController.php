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
                            ->with(['suppliers','customers'])
    ->selectRaw('year(created_at) year, monthname(created_at) month, count(party) data,sum(credit) as credit,sum(debit) as debit,id,opening_balance,debit,balance,voucher_type,party,party_type')
                           ->where('active',1)
                           ->groupBy('month')
                           ->get();
        //dd($data);
        return json_encode(['payementData'=>$data]);
    }
}
