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
use App\Models\Quotation;
use App\Models\QuotationItems;
use App\Models\QuotationeOtherCharges;
use App\Models\QuotationSeries;


class QuotationController extends CoreController
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
            'title' => 'Quotation',
            'route_name' => 'quotation',
            'back_link' => route('transactions.sales'),
            'add_link' => route('quotation.create'),
            'add_link_route' => 'quotation.create',
            'store_link' => 'quotation.store',
            'edit_link' => 'quotation.edit',
            'update_link' => 'quotation.update',
            'delete_link' => 'quotation.destroy',
            'listing_link' => 'quotation.index',
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
        $qt = Quotation::with(['sales_orders' => function($q) {
            $q->select('id', 'quotation_id');
        },'salesPerson'])->where('active','1')->get();

        return view('admin.transactions.sales.quotation.index',['other' => $this->other,'quotations'=>$qt]);
    }

    function customerDetails(Request $request,$id)
    {
        if ($request->ajax())
        {
            $customers = SalesLedger::where('id', $id)->where('active', 1)->first();
            $consignee_address = ConsigneeAddress::where(['ledger_id'=>$customers->id,'ledger_type'=>'1','active'=>'1'])->pluck('branch_name','id');
            return response()->json([
                'success' => true,
                'customers' => $customers,
                'branches' => $consignee_address
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::select('ledger_name', 'id')->where('active', 1)->get();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
        $quotationseries=QuotationSeries::all();
        $quotationseriesstatus=QuotationSeries::where('status','true')->get();

        return view('admin.transactions.sales.quotation.create',
            [
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'quotationseries'=>$quotationseries,
                'quotationseriesstatus'=>$quotationseriesstatus
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
        $validated = $request->validate([
            'valid_till' => 'sometimes|nullable',
            'required_date' => 'sometimes|nullable',
            'quotation_no'=>'required|unique:quotation,quotation_no'
        ]);
        /*$quotationseries=Quotation::where('series_type',$request->series_type)->orderBy('number','desc')->first();
        if($quotationseries)      
        {
            $number = (int)$quotationseries->number + 1;
        }
        else
        {
            $number = $request->series_starting_digits;
        }
        if(!empty($request->prefix) && !empty($request->suffix))
        {
          $quotation_id=str_replace("XXXX","",$request->prefix.$number.$request->suffix);  
        }
        elseif(!empty($request->prefix))
        {
          $quotation_id=str_replace("XXXX","",$request->quotation_no.$number);
        }
        elseif(!empty($request->suffix))
        {
          $quotation_id=str_replace("XXXX","",$number.$request->quotation_no); 
        }
        elseif(!empty($request->series_starting_digits))
        {
            $quotation_id=str_replace("XXXX","",$number);   
        }
        else
        {
            $this->validate(
                $request,
                ['manual_id'=>'required|unique:quotation,quotation_no'],
                ['manual_id.required'=>'The Series id field is required',
                'manual_id.unique' =>'The Series id has already been taken'
                ],
            );
         $quotation_id=$request->manual_id;   
        }*/

        $po = Quotation::create([
            'quotation_no' => $request->quotation_no,
            'sales_ledger_id' => $request->customer_id,
            'valid_till' => $request->valid_till,
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
                            'quotation_id' => $po->id,
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
                    QuotationItems::insert($stock_data);
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
                            'quotation_id' => $po->id,
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
                    QuotationeOtherCharges::insert($tax_data);
                    //$po->po_other_charges()->createMany($tax_data);
                }
            }
            $quotationseries=QuotationSeries::where('status','true')->first();
            if($quotationseries)
            {
                $number=$quotationseries->series_current_digit+1;
                $quotationseries=QuotationSeries::find($quotationseries->id);
                $quotationseries->series_current_digit=$number;
                $quotationseries->save();
            }
            return redirect()->route('quotation.index')->with('message', __('messages.add', ['name' => 'Quotation']));
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
        $quotationseries=QuotationSeries::all();
        $quotationseriesstatus=QuotationSeries::where('status','true')->get();
        $order = Quotation::with('items','other_charges')->find($id);
        $consignee_address = ConsigneeAddress::where('ledger_type',1)->pluck('branch_name', 'id')->toArray();
        $customers = SalesLedger::select('ledger_name', 'id')->get();
        $warehouses = Warehouse::pluck('name', 'id')->toArray();
        //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
        $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->get();
        $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

        $user = Sentinel::getUser();
        $sales_person = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::pluck('name', 'name')->toArray();


        return view('admin.transactions.sales.quotation.show',
            [
                'is_submit_show'=>1,
                'order'=>$order,
                'other' => $this->other,
                'stockItem'=>$stockItem,
                'consignee_address'=>$consignee_address,
                'customers' => $customers,
                'warehouses' => $warehouses,
                'sales_person' => $sales_person,
                'generalLedger' => $generalLedger,
                'units' => $units,
                'quotationseries'=>$quotationseries,
                'quotationseriesstatus'=>$quotationseriesstatus
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
        $order = Quotation::with('items','other_charges', 'sales_orders')->find($id);
        $quotationseriesstatus=QuotationSeries::where('status','true')->get();
        if((!isset($order->sales_orders)) || (isset($order->sales_orders) && $order->sales_orders->isEmpty()))
        {
            $consignee_address = ConsigneeAddress::where('ledger_type',1)->where('active',1)->pluck('branch_name', 'id')->toArray();
            $customers = SalesLedger::select('ledger_name', 'id')->where('active', 1)->get();
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            //$stockItem = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
            $stockItem = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $generalLedger = GeneralLedger::pluck('ledger_name', 'id')->toArray();

            $user = Sentinel::getUser();
            $sales_person = User::with('country')->whereHas('roles', function($query) {
                        $query->where('slug', '!=', 'admin');
                     })->where('id', '!=', $user->id)->pluck('name', 'id')->toArray();
            $units = InventoryUnit::where('active', 1)->pluck('name', 'name')->toArray();
            $quotationseries=QuotationSeries::all();

            return view('admin.transactions.sales.quotation.edit',
                [
                    'order'=>$order,
                    'other' => $this->other,
                    'stockItem'=>$stockItem,
                    'consignee_address'=>$consignee_address,
                    'customers' => $customers,
                    'warehouses' => $warehouses,
                    'sales_person' => $sales_person,
                    'generalLedger' => $generalLedger,
                    'units' => $units,
                    'quotationseries'=>$quotationseries,
                    'quotationseriesstatus'=>$quotationseriesstatus,
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
        $validated = $request->validate([
             'valid_till' => 'sometimes|nullable',
             'required_date' => 'sometimes|nullable',
        ]);

        $data = [
            'quotation_no' => $request->quotation_no,
            'sales_ledger_id' => $request->customer_id,
            'valid_till' => $request->valid_till,
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
        $po = Quotation::find($id);
        if($po)
        {
            if ($po->update($data))
            {
                if(isset($request->items) && !empty($request->items))
                {
                    $stock_data = $keep_items = [];

                    foreach ($request->items as $key => $items)
                    {
                        if(isset($items['item_name']))
                        {
                            $stock_data = [
                                'quotation_id' => $po->id,
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
                            $poItem = QuotationItems::updateOrCreate([
                                'id' => $items['item_id']
                            ], $stock_data);

                            $keep_items[] = $poItem->id;
                        }
                    }


                    if(isset($keep_items) && !empty($keep_items))
                    {
                        QuotationItems::where('quotation_id', $po->id)->whereNotIn('id', $keep_items)->delete();
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
                                'quotation_id' => $po->id,
                                'type' => $taxes['type'],
                                'general_ledger_id' => $taxes['account_head'],
                                'rate' => $taxes['other_rate'],
                                'amount' => $taxes['other_amount'],
                                'tax' => $taxes['other_tax'],
                                'tax_amount' => $taxes['other_tax_amount'],
                                'total_amount' => $taxes['other_total_amount'],
                            ];

                            $items['other_charge_id'] = (isset($items['other_charge_id']) && !empty($items['other_charge_id'])) ? $items['other_charge_id'] : 0;

                            $PoOtherCharge = QuotationeOtherCharges::updateOrCreate([
                                'id' => $items['other_charge_id']
                            ], $tax_data);

                            $keep_other_items[] = $PoOtherCharge->id;
                        }
                    }
                    if(!empty($keep_other_items) && count($keep_other_items) > 0)
                    {
                        QuotationeOtherCharges::where('quotation_id', $po->id)->whereNotIn('id', $keep_other_items)->delete();
                    }
                }

                return redirect()->route('quotation.index')->with('message', __('messages.update', ['name' => 'Quotation']));

            }


            return redirect()->route('quotation.index')->with('message', __('messages.add', ['name' => 'Quotation']));
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
        $quotation = Quotation::with('sales_orders')->find($id);

        if ($quotation && ((!isset($quotation->sales_orders)) || (isset($quotation->sales_orders) && $quotation->sales_orders->isEmpty())))
        {
            $data = [
                'active' => 0,
            ];
            $quotation->update($data);

            return redirect()->route('quotation.index')->with('message', __('messages.delete', ['name' => 'Quotation']));
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
            $quotation = Quotation::with(['items','other_charges', 'sales_orders','target_warehouse'])->find($id);

            $pdf = \PDF::loadView('admin.transactions.sales.quotation.print', ['quotation' => $quotation]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
    public function getdata($id)
    {
        $data=QuotationSeries::where('id',$id)->first();
        return response()->json($data);
    }
}
