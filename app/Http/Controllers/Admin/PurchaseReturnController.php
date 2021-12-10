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
use App\Models\PurchaseReturnItems;
use App\Models\PurchaseReturnOtherCharges;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnSeries;


class PurchaseReturnController extends CoreController
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
        $poi = PurchaseReturn::with(['invoice','target_warehouse'])->get();
        return view('admin.transactions.purchase.purchase-return.index',['other' => $this->other,'purchase_returns' => $poi]);
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
        $pi_data = \App\Models\PurchaseInvoice::where('active', 1)->get();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $purchasereturnseries=PurchaseReturnSeries::all();
        $purchasereturnseriesstatus=PurchaseReturnSeries::where('status','true')->get();
        return view('admin.transactions.purchase.purchase-return.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'invoice_data' => $pi_data,
                'purchasereturnseries'=>$purchasereturnseries,
                'purchasereturnseriesstatus'=>$purchasereturnseriesstatus
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
        /*$purchasereceiptseries=PurchaseReturn::where('series_type',$request->series_type)->orderBy('number','desc')->first();
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
          $receipt_id=str_replace("XXXX","",$request->return_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $receipt_id=str_replace("XXXX","",$number.$request->return_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $receipt_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:purchase_returns,return_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $receipt_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'return_no'=>'required|unique:purchase_returns,return_no',

        ]);
        $po = PurchaseReturn::create([
            'invoice_id' => $request->invoice_id,
            'supplier_id' => $request->supplier_id,
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            'main_branch'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'return_no'=> $request->return_no,
            'return_date'=> $request->return_date,
            'address'=> $request->address,
            'state'=>$request->state,
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
            'debit_to' => $request->debit_to,
            'income_account' => $request->income_account,
            'expense_account' => $request->expense_account,
            'asset' => $request->asset,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'type' => isset($request->type) ? $request->type : NULL,
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
                            'purchase_return_id' => $po->id,
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

                        \App\Models\StockItem::find($items['item_name'])->decrement('opening_stock', $items['quantity']);
                    }
                }
                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    PurchaseReturnItems::insert($stock_data);
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
                            'purchase_return_id' => $po->id,
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
                    PurchaseReturnOtherCharges::insert($tax_data);
                    //$po->po_other_charges()->createMany($tax_data);
                }
            }
            $purchasereturnseries=PurchaseReturnSeries::where('status','true')->first();
            if($purchasereturnseries)
            {
                $number=(int)$purchasereturnseries->series_current_digit+1;
                $purchasereturnseries=PurchaseReturnSeries::find($purchasereturnseries->id);
                $purchasereturnseries->series_current_digit=$number;
                $purchasereturnseries->save();
            }
            return redirect()->route('purchase-return.index')->with('message', __('messages.add', ['name' => 'Return']));
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
        $purchasereturnseries=PurchaseReturnSeries::all();
        $return = PurchaseReturn::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::pluck('name', 'id')->toArray();
//        $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
        $pi_data = \App\Models\PurchaseInvoice::get();
        $units = InventoryUnit::pluck('name', 'name')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        return view('admin.transactions.purchase.purchase-return.show',
            [
                'is_submit_show'=>1,
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'invoice_data' => $pi_data,
                'order' => $return,
                'units' => $units,
                'purchasereturnseries'=>$purchasereturnseries
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
        $return = PurchaseReturn::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',2)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $suppliers = PurchaseLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
//        $stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();

        if(isset($return->invoice_id) && isset($return->invoice->items) && $return->invoice->items->isNotEmpty())
        {
            $stockPiItem = $return->invoice->items->pluck('stock_item_id');
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->whereIn('id', $stockPiItem)->get();
        }
        else
        {
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        }

        $pi_data = \App\Models\PurchaseInvoice::where('active', 1)->get();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $purchasereturnseries=PurchaseReturnSeries::all();
        return view('admin.transactions.purchase.purchase-return.edit',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'suppliers' => $suppliers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'invoice_data' => $pi_data,
                'order' => $return,
                'units' => $units,
                'purchasereturnseries'=>$purchasereturnseries,
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
            'invoice_id' => $request->invoice_id,
            'supplier_id' => $request->supplier_id,
            'approved_vendor_code' => $request->approved_vendor_code,
            'branch_id'=> $request->branch_id,
            'main_branch'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'return_no'=> $request->return_no,
            'return_date'=> $request->return_date,
            'state'=>$request->state,
            'address'=> $request->address,
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
        ];

        $pi = PurchaseReturn::find($id);

        if($pi)
        {
            if ($pi->update($data))
            {
                if(isset($request->items) && !empty($request->items))
                {
                    //PoItems::where('$pi_id',$id)->update(['active' => '0']);
                    $stock_data = $keep_items = [];

                    foreach ($request->items as $key => $items)
                    {
                        if(isset($items['item_name']))
                        {
                            $stock_data = [
                                'purchase_return_id' => $pi->id,
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
//                                'cess' => $items['cess'],
//                                'cess_amount' => $items['cess_amount'],
                                'total_amount' => $items['total_amount'],
                                'item_pending' => $items['quantity'],
                                'item_received' => 0,
                                'active' => 1
                            ];

                            $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                            $piItem = PurchaseReturnItems::updateOrCreate([
                                'id' => $items['item_id']
                            ], $stock_data);

                            $keep_items[] = $piItem->id;
                        }
                    }

                    if(isset($keep_items) && !empty($keep_items))
                    {
                        PurchaseReturnItems::where('purchase_return_id', $pi->id)->whereNotIn('id', $keep_items)->delete();
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
                                'purchase_return_id' => $pi->id,
                                'type' => $taxes['type'],
                                'general_ledger_id' => $taxes['account_head'],
                                'rate' => $taxes['other_rate'],
                                'amount' => $taxes['other_amount'],
                                'tax' => $taxes['other_tax'],
                                'tax_amount' => $taxes['other_tax_amount'],
                                'total_amount' => $taxes['other_total_amount'],
                            ];

                            $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                            $PurchaseReturnOtherCharge = PurchaseReturnOtherCharges::updateOrCreate([
                                'id' => $items['other_charge_id']
                            ], $tax_data);

                            $keep_other_items[] = $PurchaseReturnOtherCharge->id;
                        }
                    }
                    if(!empty($keep_other_items) && count($keep_other_items) > 0)
                    {
                        PurchaseReturnOtherCharges::where('purchase_return_id', $pi->id)->whereNotIn('id', $keep_other_items)->delete();
                    }

                }

                return redirect()->route('purchase-return.index')->with('message', __('messages.update', ['name' => 'Return']));
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
       $pi = PurchaseReturn::find($id);

        if ($pi)
        {
            $pi->delete();

            return redirect()->route('purchase-return.index')->with('message', __('messages.delete', ['name' => 'Purchase Return']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function getPurchaseReturnDetails(Request $request)
    {
        //$input = $request->all();
        $pi_id = $request->invoice_id;
//        $supplier_details = PurchaseLedger::find($supplier_id);
        $pi_details = \App\Models\PurchaseInvoice::with('items','other_charges','branch')->where('id',$pi_id)->first();

        if(isset($pi_id) && isset($pi_details->items) && $pi_details->items->isNotEmpty())
        {
            $stockPiItem = $pi_details->items->pluck('stock_item_id');
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->whereIn('id', $stockPiItem)->get();
        }
        else
        {
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        }

        return response()->json(['order_details'=>$pi_details, 'stockItem' => $stockItem]);
    }
    public function print($id)
    {
        if($id)
        {
            $purchaseReturn = PurchaseReturn::with(['items','other_charges','invoice'])->find($id);


            $pdf = \PDF::loadView('admin.transactions.purchase.purchase-return.print', ['purchaseReturn' => $purchaseReturn]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata($id)
    {
        $data=PurchaseReturnSeries::where('id',$id)->first();

        return response()->json($data);
    }
}
