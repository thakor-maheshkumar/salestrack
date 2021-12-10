<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\SalesReturnRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\SalesLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\GeneralLedger;
use App\Models\InventoryUnit;
use App\Models\SalesInvoice;
use App\Models\SalesReturn;
use App\Models\SalesReturnItems;
use App\Models\SalesReturnOtherCharges;
use App\Models\SalesReturnSeries;

class SalesReturnController extends CoreController
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
            'title' => 'Return',
            'route_name' => 'sales',
            'back_link' => route('transactions.sales'),
            'add_link' => route('sales-return.create'),
            'add_link_route' => 'sales-return.create',
            'store_link' => 'sales-return.store',
            'edit_link' => 'sales-return.edit',
            'update_link' => 'sales-return.update',
            'delete_link' => 'sales-return.destroy',
            'listing_link' => 'sales-return.index',
            'order_type' => 2,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $so = SalesReturn::where('active','1')->get();
        return view('admin.transactions.sales.sales-return.index',['other' => $this->other,'sales_return'=>$so]);
    }
    function getSalesReturnDetails(Request $request)
    {
        $pi_id = $request->invoice_id;
        $pi_details = \App\Models\SalesInvoice::with('items','other_charges','branch')->where('id',$pi_id)->first();

        if($pi_id && isset($pi_details->items) && $pi_details->items->isNotEmpty())
        {
            $stockPiItem = $pi_details->items->pluck('stock_item_id');
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->whereIn('id', $stockPiItem)->get();
        }
        else
        {
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        }

        $units = \App\Models\InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();

        $items_view = view('admin.transactions.sales.sales-return.sales_item', ['order' => $pi_details, 'stockItem' => $stockItem, 'units' => $units])->render();

        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();
        $tax_items_view = view('admin.transactions.tax-item', ['order' => $pi_details, 'generalLedger' => $generalLedger])->render();

        return response()->json(['order_details' => $pi_details, 'items_view'  => $items_view, 'tax_items_view' => $tax_items_view]);
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
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $si_data = \App\Models\SalesInvoice::where('active', 1)->get();
        $salesreturnseries=SalesReturnSeries::all();
        $salesreturnseriesstatus=SalesReturnSeries::where('status','true')->get();
        return view('admin.transactions.sales.sales-return.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'invoice_data'=>$si_data,
                'salesreturnseries'=>$salesreturnseries,
                'salesreturnseriesstatus'=>$salesreturnseriesstatus
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesReturnRequest $request)
    {
        //dd($request->all());
       /* $salesreturnseries=SalesReturn::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($salesreturnseries)      
        {
            $number = (int)$salesreturnseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $return_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $return_id=str_replace("XXXX","",$request->return_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $return_id=str_replace("XXXX","",$number.$request->return_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $return_id=str_replace("XXXX","",$number);   
        }
        else
        {$this->validate(
                $request,
                ['manual_id'=>'required|unique:sales_return,return_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $return_id=$request->manual_id;   
        }*/
        $this->validate($request,[
            'return_no'=>'required|unique:sales_return,return_no'
        ]);
        $po = SalesReturn::create([
            'invoice_id' => $request->invoice_id,
            'sales_ledger_id' => $request->customer_id,
            'branch_id'=> $request->branch_id,
             'main_branch'=> $request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'sales_person_id'=> $request->user_id,
            'return_no' => $request->return_no,
            'return_date' => $request->return_date,
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
                            'sales_return_id' => $po->id,
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
                            'total_amount' => $items['total_amount'],
                        ];
                    }
                }
                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    SalesReturnItems::insert($stock_data);
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
                            'sales_return_id' => $po->id,
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
                    SalesReturnOtherCharges::insert($tax_data);
                }

                $update_invoice = ['status'=>2];
                SalesInvoice::where('id', $request->invoice_id)->update($update_invoice);

            }

            $salesreturnseriesdata=SalesReturnSeries::where('status','true')->first();
            if($salesreturnseriesdata)
               {
                $number=(int)$salesreturnseriesdata->series_current_digit+1;
                $salesreturnseriesdata=SalesReturnSeries::find($salesreturnseriesdata->id);
                $salesreturnseriesdata->series_current_digit=$number;
                $salesreturnseriesdata->save();
               } 

            return redirect()->route('sales-return.index')->with('message', __('messages.add', ['name' => 'Sales Invoice']));
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
        $order = SalesReturn::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::pluck('name', 'name')->toArray();
        $si_data = \App\Models\SalesInvoice::get();
        $salesreturnseries=SalesReturnSeries::all();
        return view('admin.transactions.sales.sales-return.show',
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
                'invoice_data'=>$si_data,
                'salesreturnseries'=>$salesreturnseries
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
        $order = SalesReturn::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::where('active', 1)->pluck('ledger_name', 'id')->toArray();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

        if(isset($order->invoice_id) && isset($order->invoice->items) && $order->invoice->items->isNotEmpty())
        {
            $stockPiItem = $order->invoice->items->pluck('stock_item_id');
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->whereIn('id', $stockPiItem)->get();
        }
        else
        {
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        }

        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $si_data = \App\Models\SalesInvoice::where('active', 1)->get();
        $salesreturnseries=SalesReturnSeries::all();
        return view('admin.transactions.sales.sales-return.edit',
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
                'invoice_data'=>$si_data,
                'salesreturnseries'=>$salesreturnseries,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalesReturnRequest $request, $id)
    {
        
        $data = [
            'invoice_id' => $request->invoice_id,
            'sales_ledger_id' => $request->customer_id,
            'branch_id'=> $request->branch_id,
            'main_branch'=>$request->branch_id,
            'warehouse_id'=> $request->warehouse_id,
            'sales_person_id'=> $request->user_id,
            'return_no' => $request->return_no,
            'return_date' => $request->return_date,
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
        ];
        $pi = SalesReturn::find($id);
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
                                'sales_return_id' => $pi->id,
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
                                'discount_in_per' => $items['discount'],
                                'discount' => $items['discount_amount'],
                                'total_amount' => $items['total_amount'],
                                'item_pending' => $items['quantity'],
                                'item_received' => 0,
                                'active' => 1
                            ];

                            $items['item_id'] = (isset($items['item_id']) && !empty($items['item_id'])) ? $items['item_id'] : 0;
                            $piItem = SalesReturnItems::updateOrCreate([
                                'id' => $items['item_id']
                            ], $stock_data);

                            $keep_items[] = $piItem->id;
                        }
                    }

                    if(isset($keep_items) && !empty($keep_items))
                    {
                        SalesReturnItems::where('sales_return_id', $pi->id)->whereNotIn('id', $keep_items)->delete();
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
                                'sales_return_id' => $pi->id,
                                'type' => $taxes['type'],
                                'general_ledger_id' => $taxes['account_head'],
                                'rate' => $taxes['other_rate'],
                                'amount' => $taxes['other_amount'],
                                'tax' => $taxes['other_tax'],
                                'tax_amount' => $taxes['other_tax_amount'],
                                'total_amount' => $taxes['other_total_amount'],
                            ];

                            $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                            $PurchaseReturnOtherCharge = SalesReturnOtherCharges::updateOrCreate([
                                'id' => $items['other_charge_id']
                            ], $tax_data);

                            $keep_other_items[] = $PurchaseReturnOtherCharge->id;
                        }
                    }
                    if(!empty($keep_other_items) && count($keep_other_items) > 0)
                    {
                        SalesReturnOtherCharges::where('sales_return_id', $pi->id)->whereNotIn('id', $keep_other_items)->delete();
                    }
                }
                return redirect()->route('sales-return.index')->with('message', __('messages.update', ['name' => 'Return']));
            }
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = SalesReturn::find($id);

        if ($delete)
        {
            $data = [
                'active' => 0,
            ];
            $delete->update($data);

            return redirect()->route('sales-return.index')->with('message', __('messages.delete', ['name' => 'Sales Return']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));

    }
    public function getdata($id)
    {
        $data=SalesReturnSeries::where('id',$id)->first();
        return response()->json($data);
    }
    public function print($id)
    {
        if($id)
        {
            $salesReturn = SalesReturn::with(['items.stockItems' => function($query) {
                $query->select('id', 'name');
            },'other_charges','invoice', 'target_warehouse'])->find($id);
            
            //dd($salesReturn);

           
            $pdf = \PDF::loadView('admin.transactions.sales.sales-return.print', ['salesReturn' => $salesReturn]);

            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }
        abort(404);
    }
}
