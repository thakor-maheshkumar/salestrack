<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\StockGroup;
use App\Models\StockCategory;
use App\Models\InventoryUnit;
use App\Models\Warehouse;
use App\Models\Grades;
use App\Models\StockItemGrades;
use App\Models\StockManagement;
use App\Models\GstHistoryStockItems;

use App\Http\Requests\Admin\StockItemRequest;

class StockItemController extends CoreController
{
    protected static $taxablity_types = [
        'unknown' => 'Unknown',
        'exempt' => 'Exempt',
        'nil_rated' => 'Nil Rated',
        'taxable' => 'Taxable'
    ];

    protected static $units = [
        '1' => 'gm',
        '2' => 'ltr'
    ];

    protected static $tax_types = [
        'GST' => 'GST',
        'Cess' => 'Cess'
    ];

    protected static $supply_types = [
        'goods' => 'Goods',
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
        $stock_items = StockItem::with('stock_category')->where('active',1)->get();

        return view('admin.inventory.stock-item.index', ['stock_items' => $stock_items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_groups = StockGroup::where('active', 1)->pluck('group_name', 'id')->toArray();
        $stock_categories = StockCategory::where('active', 1)->pluck('name', 'id')->toArray();
        $units = InventoryUnit::where('active', 1)->pluck('name', 'id')->toArray();
        $unitdata=InventoryUnit::all();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
        $grades = Grades::where('active', 1)->pluck('grade_name', 'id')->toArray();
        
        return view('admin.inventory.stock-item.create',compact('unitdata'), ['taxablity_types' => self::$taxablity_types, 'stock_groups' => $stock_groups, 'stock_categories' => $stock_categories, 'units' => $units,'warehouses' => $warehouses, 'tax_types' => self::$tax_types, 'supply_types' => self::$supply_types,'grades'=>$grades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockItemRequest $request)
    {
        $product_image = NULL;
        if($request->file('product_image'))
        { 
            $product_image = \Storage::put('inventory', $request->file('product_image'));
        }
        
        $result = StockItem::create([
            'name' => isset($request->name) ? $request->name : NULL,
            'product_descriptiopn' => isset($request->product_descriptiopn) ? $request->product_descriptiopn : NULL,
            'under' => isset($request->under) ? $request->under : NULL,
            'unit_id' => isset($request->unit_id) ? $request->unit_id : NULL,
            'convertion_rate' => isset($request->convertion_rate) ? $request->convertion_rate : NULL,
            'shipper_pack' => isset($request->shipper_pack) ? $request->shipper_pack : NULL,
            'alternate_unit_id' => isset($request->alternate_unit_id) ? $request->alternate_unit_id : NULL,
            'part_no' => isset($request->part_no) ? $request->part_no : NULL,
            'product_image' => $product_image,
            'category_id' => isset($request->category_id) ? $request->category_id : NULL,
            'is_allow_mrp' => isset($request->is_allow_mrp) ? $request->is_allow_mrp : NULL,
            'is_allow_part_number' => isset($request->is_allow_part_number) ? $request->is_allow_part_number : NULL,
            'is_maintain_in_batches' => isset($request->is_maintain_in_batches) ? $request->is_maintain_in_batches : NULL,
            'track_manufacture_date' => isset($request->track_manufacture_date) ? $request->track_manufacture_date : NULL,
            'use_expiry_dates' => isset($request->use_expiry_dates) ? $request->use_expiry_dates : NULL,
            'is_gst_detail' => isset($request->is_gst_detail) ? $request->is_gst_detail : NULL,
            'taxability' => isset($request->taxability) ? $request->taxability : NULL,
            'is_reverse_charge' => isset($request->is_reverse_charge) ? $request->is_reverse_charge : NULL,
            'tax_type' => isset($request->tax_type) ? $request->tax_type : NULL,
            'rate' => isset($request->rate) ? $request->rate : NULL,
            'applicable_date' => isset($request->applicable_date) ? $request->applicable_date : NULL,
            'cess' => isset($request->cess) ? $request->cess : NULL,
            'cess_applicable_date' => isset($request->cess_applicable_date) ? $request->cess_applicable_date : NULL,
            'supply_type' => isset($request->supply_type) ? $request->supply_type : NULL,
            'hsn_code' => isset($request->hsn_code) ? $request->hsn_code : NULL,
            'default_warehouse' => isset($request->default_warehouse) ? $request->default_warehouse : NULL,
            'opening_stock' => (isset($request->opening_stock) && isset($request->maintain_stock)) ? $request->opening_stock : NULL,
            'maintain_stock' => isset($request->maintain_stock) ? 1 : 0,
            'product_code' => isset($request->product_code) ? $request->product_code : NULL,
            'cas_no' => isset($request->cas_no) ? $request->cas_no : NULL,
            'pack_code' => isset($request->pack_code) ? $request->pack_code : NULL,
        ]);

        if(!empty($result))     
        {
            if((isset($request->maintain_stock)) && (isset($request->opening_stock) && !empty($request->opening_stock)))
            {
                $qunatity = $request->opening_stock;
                $stock_item = StockItem::orderBy('id', 'DESC')->first();
                //$stock = StockManagement::where('stock_item_id',$stock_item->id)->orderBy('id', 'DESC')->first();
                //$balance = isset($stock) ? ($stock->total_balance + ($qunatity)) : $qunatity;
                $balance = $qunatity;
                $stock_management_data =[
                    'voucher_no' => NULL,
                    'stock_item_id'=>$stock_item->id,
                    'batch_id'=>NULL,
                    'warehouse_id'=>isset($request->default_warehouse) ? $request->default_warehouse : NULL,
                    'item_name'=>isset($request->name) ? $request->name : NULL,
                    'pack_code'=>isset($request->pack_code) ? $request->pack_code : NULL,
                    'uom'=>isset($request->unit_id) ? $request->unit_id : NULL,
                    'qty'=> $qunatity,
                    'rate'=>1,
                    'balance_value'=> ($qunatity * 1),
                    'total_balance' => $balance,
                    'voucher_type'=>'Stock Entry - opening_stock',
                    'status'=>5,
                    'created' => date('Y-m-d H:i:s'),
                ];
                $stock_op = StockManagement::insert($stock_management_data);
            }
            
            /*if(isset($request->grade_data) && !empty($request->grade_data))
            {
                $grade_data = $final_data = [];
                foreach ($request->grade_data as $key => $grade_stock_items)
                {
                    if(isset($grade_stock_items['grade_id']) && isset($grade_stock_items['pack_code']))
                    {   
                        $grade_data = [
                            'stock_item_id' => $result->id,
                            'grade_id' => $grade_stock_items['grade_id'],
                            'pack_code' => $grade_stock_items['pack_code'],
                            'unit_id' => $grade_stock_items['unit_id'],
                            'quantity' => (isset($grade_data[$grade_stock_items['pack_code']]) && !empty($grade_data[$grade_stock_items['pack_code']])) ? ($grade_data['quantity'] + $grade_data[$grade_stock_items['pack_code']]['quantity']) : $grade_stock_items['quantity']
                        ];
                        $final_data[] = $grade_data;
                    }
                }
                StockItemGrades::insert($final_data);
            }*/

            $gstStock=new GstHistoryStockItems;
            $gstStock->stock_item_id=$result->id;
            $gstStock->rate=$request->rate;
            $gstStock->old_rate=$request->rate;
            $gstStock->applicable_date=$request->applicable_date;
            $gstStock->old_applicable_date=$request->applicable_date;
            $gstStock->cess_rate=$request->cess;
            $gstStock->old_cess_rate=$request->cess;
            $gstStock->cess_applicable_date=$request->cess_applicable_date;
            $gstStock->old_cess_applicable_date=$request->cess_applicable_date;
            $gstStock->save();
        }

        if($result)
        {
            return redirect()->route('stock-items.index')->with('message', __('messages.add', ['name' => 'Stock item']));
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
        if($id)
        {
            $item = StockItem::find($id);

            if($item)
            {
                $stock_groups = StockGroup::where('active', 1)->pluck('group_name', 'id')->toArray();
                $stock_categories = StockCategory::where('active', 1)->pluck('name', 'id')->toArray();
                $units = InventoryUnit::where('active', 1)->pluck('name', 'id')->toArray();
                $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
                $grades = Grades::where('active', 1)->pluck('grade_name', 'id')->toArray();
                $unitdata=InventoryUnit::all();
                $gstStock=GstHistoryStockItems::where('stock_item_id',$item->id)->orderBy('id','desc')->offset(1)->limit(1)->first();

                return view('admin.inventory.stock-item.edit',compact('unitdata'), ['item' => $item, 'taxablity_types' => self::$taxablity_types, 'stock_groups' => $stock_groups, 'stock_categories' => $stock_categories, 'units' => $units,'warehouses' => $warehouses, 'tax_types' => self::$tax_types, 'supply_types' => self::$supply_types,'grades'=>$grades,'gstStock'=>$gstStock]);
            }
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
    public function update(StockItemRequest $request, $id)
    {
        $item = StockItem::find($id);
        if($item)
        {
            $data = [
                'group_name' => $request->group_name,
                'under' => $request->under,
                'is_gst_detail' => $request->is_gst_detail,
                'taxability' => (isset($request->taxability) && $request->is_gst_detail == 1) ? $request->taxability : NULL,
                'is_reverse_charge' => (isset($request->is_reverse_charge) && $request->is_gst_detail == 1) ? $request->is_reverse_charge : NULL,
                'gst_rate' => (isset($request->gst_rate) && $request->is_gst_detail == 1) ? $request->gst_rate : NULL,
                'gst_applicable_date' => (isset($request->gst_applicable_date) && $request->is_gst_detail == 1) ? $request->gst_applicable_date : NULL,
                'cess_rate' => (isset($request->cess_rate) && $request->is_gst_detail == 1) ? $request->cess_rate : NULL,
                'cess_applicable_date' => (isset($request->cess_applicable_date) && $request->is_gst_detail == 1) ? $request->cess_applicable_date : NULL,

                'name' => isset($request->name) ? $request->name : NULL,
                'product_descriptiopn' => isset($request->product_descriptiopn) ? $request->product_descriptiopn : NULL,
                'under' => isset($request->under) ? $request->under : NULL,
                'unit_id' => isset($request->unit_id) ? $request->unit_id : NULL,
                'convertion_rate' => isset($request->convertion_rate) ? $request->convertion_rate : NULL,
                'shipper_pack' => isset($request->shipper_pack) ? $request->shipper_pack : NULL,
                'alternate_unit_id' => isset($request->alternate_unit_id) ? $request->alternate_unit_id : NULL,
                'part_no' => isset($request->part_no) ? $request->part_no : NULL,
                'category_id' => isset($request->category_id) ? $request->category_id : NULL,
                'is_allow_mrp' => isset($request->is_allow_mrp) ? $request->is_allow_mrp : NULL,
                'is_allow_part_number' => isset($request->is_allow_part_number) ? $request->is_allow_part_number : NULL,
                'is_maintain_in_batches' => isset($request->is_maintain_in_batches) ? $request->is_maintain_in_batches : NULL,
                'track_manufacture_date' => (isset($request->track_manufacture_date) && $request->is_maintain_in_batches == 1) ? $request->track_manufacture_date : NULL,
                'use_expiry_dates' => (isset($request->use_expiry_dates) && $request->is_maintain_in_batches == 1) ? $request->use_expiry_dates : NULL,
                'is_gst_detail' => isset($request->is_gst_detail) ? $request->is_gst_detail : NULL,
                'taxability' => (isset($request->taxability) && $request->is_gst_detail == 1) ? $request->taxability : NULL,
                'is_reverse_charge' => (isset($request->is_reverse_charge) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->is_reverse_charge : NULL,
                'tax_type' => (isset($request->tax_type) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->tax_type : NULL,
                'rate' => (isset($request->rate) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->rate : NULL,
                'applicable_date' => (isset($request->applicable_date) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->applicable_date : NULL,
                'cess' => (isset($request->cess) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->cess : NULL,
                'cess_applicable_date' => (isset($request->cess_applicable_date) && $request->is_gst_detail == 1 && $request->taxability == 'taxable') ? $request->cess_applicable_date : NULL,
                'supply_type' => isset($request->supply_type) ? $request->supply_type : NULL,
                'hsn_code' => isset($request->hsn_code) ? $request->hsn_code : NULL,
                'default_warehouse' => isset($request->default_warehouse) ? $request->default_warehouse : NULL,
                'opening_stock' => (isset($request->opening_stock ) && isset($request->maintain_stock)) ? $request->opening_stock : NULL,
                'maintain_stock' => isset($request->maintain_stock) ? 1 : 0,
                'product_code' => isset($request->product_code) ? $request->product_code : NULL,
                'cas_no' => isset($request->cas_no) ? $request->cas_no : NULL,
                'pack_code' => isset($request->pack_code) ? $request->pack_code : NULL,
            ];


            if ($request->file('product_image'))
            {
                if($item->product_image)
                {
                    $this->deleteFiles($item->product_image);
                }

                $data['product_image'] = \Storage::put('inventory', $request->file('product_image'));
            }

            if ($item->update($data))
            {

                if((isset($request->maintain_stock)) && (isset($request->opening_stock)))
                {
                    ///////// minus quantity //////// 
                    //$qunatity = $request->opening_stock;
                    $qunatity = $item->opening_stock;
                    $stock_item = $item;
                    $stock = StockManagement::where('stock_item_id',$stock_item->id)->orderBy('id', 'DESC')->first();
                    
                    
                    $balance = isset($stock) ? ($stock->total_balance - ($qunatity)) : $qunatity;
                    $stock_management_data =[
                        'voucher_no' => NULL,
                        'stock_item_id'=>$stock_item->id,
                        'batch_id'=>NULL,
                        'warehouse_id'=>isset($request->default_warehouse) ? $request->default_warehouse : NULL,
                        'item_name'=>isset($request->name) ? $request->name : NULL,
                        'pack_code'=>isset($request->pack_code) ? $request->pack_code : NULL,
                        'uom'=>isset($request->unit_id) ? $request->unit_id : NULL,
                        'qty'=> '-'.$qunatity,
                        'rate'=>1,
                        'balance_value'=> ('-'.$qunatity * 1),
                        'total_balance' => $balance,
                        'voucher_type'=>'Stock Entry - opening_stock',
                        'status'=>5,
                        'created' => date('Y-m-d H:i:s'),
                    ];
                    $stock_op = $stock->update($stock_management_data);

                    ////// Add quantity //////////
                    $qunatity = $request->opening_stock;
                    $balance = isset($stock) ? ($stock->total_balance + ($qunatity)) : $qunatity;
                    $add_stock_management_data =[
                        'voucher_no' => NULL,
                        'stock_item_id'=>$stock_item->id,
                        'batch_id'=>NULL,
                        'warehouse_id'=>isset($request->default_warehouse) ? $request->default_warehouse : NULL,
                        'item_name'=>isset($request->name) ? $request->name : NULL,
                        'pack_code'=>isset($request->pack_code) ? $request->pack_code : NULL,
                        'uom'=>isset($request->unit_id) ? $request->unit_id : NULL,
                        'qty'=> $qunatity,
                        'rate'=>1,
                        'balance_value'=> ($qunatity * 1),
                        'total_balance' => $balance,
                        'voucher_type'=>'Stock Entry - opening_stock',
                        'status'=>5,
                        'created' => date('Y-m-d H:i:s'),
                    ];
                    $stock_op = $stock->update($add_stock_management_data);
                }
                
                $grade_data = [];
                /*if(isset($request->grade_data) && !empty($request->grade_data))
                {
                    StockItemGrades::where('stock_item_id',$id)->update(['active' => '0']);
                    foreach ($request->grade_data as $key => $grade_stock_items)
                    {
                        $grade_data = [
                            'stock_item_id' => $id,
                            'grade_id' => $grade_stock_items['grade_id'],
                            'pack_code' => $grade_stock_items['pack_code'],
                            'unit_id' => $grade_stock_items['unit_id'],
                            'quantity' => (isset($grade_data[$grade_stock_items['pack_code']]) && !empty($grade_data[$grade_stock_items['pack_code']])) ? ($grade_data['quantity'] + $grade_data[$grade_stock_items['pack_code']]['quantity']) : $grade_stock_items['quantity'],
                            'active' => 1,
                        ];

                        if(isset($grade_stock_items['stock_item_grade_id']) && !empty($grade_stock_items['stock_item_grade_id']))
                        {
                            $grade_stock_items = StockItemGrades::find($grade_stock_items['stock_item_grade_id']);
                            $grade_stock_items->update($grade_data);
                        }else{
                            StockItemGrades::insert($grade_data);
                        }
                    }
                }*/

                $gstStock=new GstHistoryStockItems;
            $gstStock->stock_item_id=$request->stock_item_id;
            $gstStock->rate=$request->rate;
            $gstStock->old_rate=$request->rate;
            $gstStock->applicable_date=$request->applicable_date;
            $gstStock->old_applicable_date=$request->applicable_date;
            $gstStock->cess_rate=$request->cess;
            $gstStock->old_cess_rate=$request->cess;
            $gstStock->cess_applicable_date=$request->cess_applicable_date;
            $gstStock->old_cess_applicable_date=$request->cess_applicable_date;
            $gstStock->save();

                return redirect()->route('stock-items.index')->with('message', __('messages.update', ['name' => 'Stock item']));
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
        $item = StockItem::find($id);

        if ($item)
        {
            $data = [
                'active' => 0
            ];
            $item->update($data);

            return redirect()->route('stock-items.index')->with('message', __('messages.delete', ['name' => 'Stock item']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function import(Request $request)
    {
        if($request->import=='override'){
            $validated=$request->validate([
                'file'=>'required|mimes:csv,txt',
            ]);
            if($validated){
                   $test=StockItem::truncate();
            if(isset($test))
            {
            $grpup_name_title=StockItem::pluck('name','id')->toArray();

               if(isset($_POST['importSubmit']))
               {
    
                 // Allowed mime types
                 $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
                        // Validate whether selected file is a CSV file
                     if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
                     {
        
                        // If the file is uploaded
                         if(is_uploaded_file($_FILES['file']['tmp_name']))
                         {
            
                        // Open uploaded CSV file with read-only mode
                          $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                        
                            fgetcsv($csvFile);
                        // Skip the first line
                            // Parse data from CSV file line by line
                            $store=[];
                            while(($line = fgetcsv($csvFile)) !== FALSE)
                                {
                             // Get row data
                                   
                                    $name   = $line[0];
                                    $product_description  = $line[1];
                                    $under=$line[2];
                                    $unit_id  = $line[3];
                                    $convertion_rate  = $line[4];
                                    $shipper_pack  = $line[5];
                                    $alternate_unit_id  = $line[6];
                                    $part_no  = $line[7];
                                    $category_id=$line[8];
                                    $is_allow_mrp  = $line[9];
                                    $is_allow_part_number  = $line[10];
                                    $is_maintain_in_batches  = $line[11];
                                    $track_manufacture_date  = $line[12];
                                    $use_expiry_dates  = $line[13];
                                    $is_gst_detail  = $line[14];
                                    $taxability  = $line[15];
                                    $is_reverse_charge  = $line[16];
                                    $tax_type  = $line[17];
                                    $rate  = $line[18];
                                    $applicable_date  = $line[19];
                                    $cess  = $line[20];
                                    $cess_applicable_date  = $line[21];
                                    $supply_type  = $line[22];
                                    $hsn_code  = $line[23];
                                    $default_warehouse  = $line[24];
                                    $opening_stock  = $line[25];
                                    $maintain_stock  = $line[26];
                                    $product_code  = $line[27];
                                    $cas_no  = $line[28];
                                    $pack_code  = $line[29];
                                    $active  = $line[30];

            
                                // Insert member data in the database
                                    if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                    {
                                        $store[]=$name;
                                        StockItem::create([
                                        'name' => $name,
                                        'product_descriptiopn'=>$product_description,
                                        'under'=>$under,
                                        'unit_id'=>$unit_id,
                                        'convertion_rate'=>$convertion_rate,
                                        'shipper_pack'=>$shipper_pack,
                                        'alternate_unit_id'=>$alternate_unit_id,
                                        'part_no'=>$part_no,
                                        'category_id'=>$category_id,
                                        'is_allow_mrp'=>$is_allow_mrp,
                                        'is_allow_part_number'=>$is_allow_part_number,
                                        'is_maintain_in_batches'=>$is_maintain_in_batches,
                                        'track_manufacture_date'=>$track_manufacture_date,
                                        'use_expiry_dates'=>$use_expiry_dates,
                                        'is_gst_detail'=>$is_gst_detail,
                                        'taxability'=>$taxability,
                                        'is_reverse_charge'=>$is_reverse_charge,
                                        'tax_type'=>$tax_type,
                                        'rate'=>$rate,
                                        'applicable_date'=>$applicable_date,
                                        'cess'=>$cess,
                                        'cess_applicable_date'=>$cess_applicable_date,
                                        'supply_type'=>$supply_type,
                                        'hsn_code'=>$hsn_code,
                                        'default_warehouse'=>$default_warehouse,
                                        'opening_stock'=>$opening_stock,
                                        'maintain_stock'=>$maintain_stock,
                                        'product_code'=>$product_code,
                                        'cas_no'=>$cas_no,
                                        'pack_code'=>$pack_code,
                                        'active'=>$active,

                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('stock-items.index')->with('message', 'Imported Data successfully.');

                            }
                            else
                            {
                                return redirect()->back()->with('error', 'Something goes to wrong.');
                            }
                      }
                    else
                    {
                        return redirect()->back()->with('error', 'Only CSV file accepted.');
                    }
                }

        }

            }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=StockItem::pluck('name','id')->toArray();
        //dd($grpup_name_title);
        if(isset($_POST['importSubmit']))
        {
    
    // Allowed mime types
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
           if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
            {
        
                // If the file is uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name']))
                    {
            
                    // Open uploaded CSV file with read-only mode
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
                fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
                        $store=[];
                        while(($line = fgetcsv($csvFile)) !== FALSE)
                        {
                // Get row data
                          
                                    $name   = $line[0];
                                    $product_description  = $line[1];
                                    $under=$line[2];
                                    $unit_id  = $line[3];
                                    $convertion_rate  = $line[4];
                                    $shipper_pack  = $line[5];
                                    $alternate_unit_id  = $line[6];
                                    $part_no  = $line[7];
                                    $category_id=$line[8];
                                    $is_allow_mrp  = $line[9];
                                    $is_allow_part_number  = $line[10];
                                    $is_maintain_in_batches  = $line[11];
                                    $track_manufacture_date  = $line[12];
                                    $use_expiry_dates  = $line[13];
                                    $is_gst_detail  = $line[14];
                                    $taxability  = $line[15];
                                    $is_reverse_charge  = $line[16];
                                    $tax_type  = $line[17];
                                    $rate  = $line[18];
                                    $applicable_date  = $line[19];
                                    $cess  = $line[20];
                                    $cess_applicable_date  = $line[21];
                                    $supply_type  = $line[22];
                                    $hsn_code  = $line[23];
                                    $default_warehouse  = $line[24];
                                    $opening_stock  = $line[25];
                                    $maintain_stock  = $line[26];
                                    $product_code  = $line[27];
                                    $cas_no  = $line[28];
                                    $pack_code  = $line[29];
                                    $active  = $line[30];

              
        
                                if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                {
                                    $store[]=$name;
                                    StockItem::create([
                                        'name' => $name,
                                        'product_descriptiopn'=>$product_description,
                                        'under'=>$under,
                                        'unit_id'=>$unit_id,
                                        'convertion_rate'=>$convertion_rate,
                                        'shipper_pack'=>$shipper_pack,
                                        'alternate_unit_id'=>$alternate_unit_id,
                                        'part_no'=>$part_no,
                                        'category_id'=>$category_id,
                                        'is_allow_mrp'=>$is_allow_mrp,
                                        'is_allow_part_number'=>$is_allow_part_number,
                                        'is_maintain_in_batches'=>$is_maintain_in_batches,
                                        'track_manufacture_date'=>$track_manufacture_date,
                                        'use_expiry_dates'=>$use_expiry_dates,
                                        'is_gst_detail'=>$is_gst_detail,
                                        'taxability'=>$taxability,
                                        'is_reverse_charge'=>$is_reverse_charge,
                                        'tax_type'=>$tax_type,
                                        'rate'=>$rate,
                                        'applicable_date'=>$applicable_date,
                                        'cess'=>$cess,
                                        'cess_applicable_date'=>$cess_applicable_date,
                                        'supply_type'=>$supply_type,
                                        'hsn_code'=>$hsn_code,
                                        'default_warehouse'=>$default_warehouse,
                                        'opening_stock'=>$opening_stock,
                                        'maintain_stock'=>$maintain_stock,
                                        'product_code'=>$product_code,
                                        'cas_no'=>$cas_no,
                                        'pack_code'=>$pack_code,
                                        'active'=>$active,
                                    ]);    
                                }
                                
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('stock-items.index')->with('message', 'Imported Data successfully.');

                    }
                    else
                    {
                        return redirect()->back()->with('error', 'Something goes to wrong.');
                    }
                }
                else
                {
                    return redirect()->back()->with('error', 'Only CSV file accepted.');
                }
            }

        }
    }
}
