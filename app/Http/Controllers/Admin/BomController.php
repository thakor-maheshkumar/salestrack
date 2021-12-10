<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\BomStockItems;
use App\Http\Requests\Admin\BomRequest;

class BomController extends CoreController
{

    protected static $material_rate = [
        //'Valuation Rate' => 'Valuation Rate',
        'Purchase Rate'=>'Purchase Rate',
        'Last Purchase Rate' => 'Last Purchase Rate',
        'Price List' => 'Price List'
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
        $bom = Bom::all();

        return view('admin.inventory.bom.index', ['bom' => $bom]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
        $stock_items = !empty($stock_items_list) ? $stock_items_list : array();
        return view('admin.inventory.bom.create',['stock_items'=>$stock_items,'material_rate' => static::$material_rate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BomRequest $request)
    {
        $bom = Bom::create([
            'bom_name' => $request->bom_name,
            'stock_item_id' => $request->stock_item_id,
            'no_of_unit' => isset($request->no_of_unit) ? $request->no_of_unit : NULL,
            'rate_of_material' => isset($request->rate_of_material) ? $request->rate_of_material : NULL,
             'additional_cost' => isset($request->additional_cost) ? $request->additional_cost : NULL
        ]);

        if(!empty($bom))
        {
            if(isset($request->bom_stock_items) && !empty($request->bom_stock_items))
            {
                $bom_stock_data = [];
                foreach ($request->bom_stock_items as $key => $bom_stock_items)
                {
                    if(isset($bom_stock_items['item_item_id']) && isset($bom_stock_items['item_qty']))
                    {   
                        $bom_stock_data[$bom_stock_items['item_item_id']] = (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? $bom_stock_data[$bom_stock_items['item_item_id']] : [];

                        $bom_stock_data[$bom_stock_items['item_item_id']] = [
                            'bom_id' => $bom->id,
                            'stock_item_id' => $bom_stock_items['item_item_id'],
                            'quantity' => (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? ($bom_stock_items['item_qty'] + $bom_stock_data[$bom_stock_items['item_item_id']]['quantity']) : $bom_stock_items['item_qty']
                        ];
                    }
                }

                if(!empty($bom_stock_data) && count($bom_stock_data) > 0)
                {
                    $bom->bom_items()->createMany($bom_stock_data);
                }
            }
        }
       

        if($bom)
        {
            return redirect()->route('bom.index')->with('message', __('messages.add', ['name' => 'BOM']));
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
            $bom = Bom::with('bom_items')->find($id);

            if($bom)
            {
                $stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
                $stock_items = !empty($stock_items_list) ? $stock_items_list : [];
                
                return view('admin.inventory.bom.edit', ['bom' => $bom , 'stock_items'=>$stock_items,'material_rate' => static::$material_rate]);
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
    public function update(BomRequest $request, $id)
    {
        $data = [
            'bom_name' => $request->bom_name,
            'stock_item_id' => $request->stock_item_id,
            'no_of_unit' => isset($request->no_of_unit) ? $request->no_of_unit : NULL,
            'rate_of_material' => isset($request->rate_of_material) ? $request->rate_of_material : NULL,
            'additional_cost' => isset($request->additional_cost) ? $request->additional_cost : NULL
        ];

        $bom = Bom::find($id);

        if($bom)
        {
            if ($bom->update($data))
            {
                $bom_stock_data = [];
                $keep_items = [];
                foreach ($request->bom_stock_items as $key => $bom_stock_items)
                {
                    if(isset($bom_stock_items['item_item_id']) && isset($bom_stock_items['item_qty']))
                    {   
                        $bom_stock_data[$bom_stock_items['item_item_id']] = (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? $bom_stock_data[$bom_stock_items['item_item_id']] : [];

                        $bom_stock_data[$bom_stock_items['item_item_id']] = [
                            'bom_id' => $bom->id,
                            'stock_item_id' => $bom_stock_items['item_item_id'],
                            'quantity' => (isset($bom_stock_data[$bom_stock_items['item_item_id']]) && !empty($bom_stock_data[$bom_stock_items['item_item_id']])) ? ($bom_stock_items['item_qty'] + $bom_stock_data[$bom_stock_items['item_item_id']]['quantity']) : $bom_stock_items['item_qty']
                        ];
                    }
                }

                if(!empty($bom_stock_data))
                {
                    $keep_items = array_keys($bom_stock_data);

                    foreach ($bom_stock_data as $key => $value) {
                        BomStockItems::updateOrCreate([
                            'bom_id' => $bom->id,
                            'stock_item_id' => $value['stock_item_id']
                        ], $value);
                    }

                    BomStockItems::where('bom_id', $bom->id)->whereNotIn('stock_item_id', $keep_items)->delete();
                }

                return redirect()->route('bom.index')->with('message', __('messages.update', ['name' => 'BOM']));
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
        $group = Bom::find($id);

        if ($group)
        {
            $group->delete();

            return redirect()->route('bom.index')->with('message', __('messages.delete', ['name' => 'BOM']));
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
                   $truncate=Bom::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=Bom::pluck('bom_name','id')->toArray();

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
                                   
                                    $bom_name   = $line[0];
                                    $stock_item_id  = $line[1];
                                    $no_of_unit=$line[2];
                                    $rate_of_material=$line[3];
                                    $active=$line[4];
            
                                // Insert member data in the database
                                    if(!(in_array($bom_name,$grpup_name_title)) && !in_array($bom_name,$store))
                                    {
                                        $store[]=$bom_name;
                                        Bom::create([
                                        'bom_name'=>$bom_name,
                                        'stock_item_id'=>$stock_item_id,
                                        'no_of_unit'=>$no_of_unit,
                                        'rate_of_material'=>$rate_of_material,
                                        'active'=>$active,
                                        ]);    
                                    }
                                
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('bom.index')->with('message', 'Imported Data successfully.');

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
            }else{
                return redirect()->back()->with('error', 'Only CSV file accepted.');
            }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=Bom::pluck('bom_name','id')->toArray();
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
                          
                                    $bom_name   = $line[0];
                                    $stock_item_id  = $line[1];
                                    $no_of_unit=$line[2];
                                    $rate_of_material=$line[3];
                                    $active=$line[4];
                                if(!(in_array($bom_name,$grpup_name_title)) && !in_array($bom_name,$store))
                                    {
                                        $store[]=$bom_name;
                                        Bom::create([
                                        'bom_name'=>$bom_name,
                                        'stock_item_id'=>$stock_item_id,
                                        'no_of_unit'=>$no_of_unit,
                                        'rate_of_material'=>$rate_of_material,
                                        'active'=>$active,
                                        ]);    
                                    }
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('bom.index')->with('message', 'Imported Data successfully.');

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
