<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\Batch;
use App\Models\Warehouse;
use App\Http\Requests\Admin\BatchRequest;


class BatchController extends CoreController
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
    public function index()
    {
        $batches = Batch::where('active','1')->get();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

        return view('admin.inventory.batches.index',['batches'=>$batches,'warehouses'=>$warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_items_list = StockItem::where('active',1)->where('is_maintain_in_batches', 1)->pluck('name','id')->toArray();
        $stock_items = !empty($stock_items_list) ? $stock_items_list : array();
        $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

        return view('admin.inventory.batches.create',['stock_items'=>$stock_items,'warehouses'=>$warehouses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BatchRequest $request)
    {
        $batch = Batch::create([
            'stock_item_id' => $request->stock_item_id,
            'warehouse_id' => $request->warehouse_id,
            'batch_id' => $request->batch_id,
            'batch_size' => $request->batch_size,
            'manufacturing_date' => $request->manufacturing_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ]);

        if($batch)
        {
            return redirect()->route('batches.index')->with('message', __('messages.add', ['name' => 'Batch']));
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
            $item = Batch::find($id);

            if($item)
            {
                $stock_items = StockItem::where('active', 1)->where('is_maintain_in_batches', 1)->pluck('name', 'id')->toArray();
                $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

                return view('admin.inventory.batches.edit', ['item' => $item,'stock_items'=>$stock_items,'warehouses'=>$warehouses]);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BatchRequest $request, $id)
    {
        $item = Batch::find($id);

        $data = [
            'stock_item_id' => $request->stock_item_id,
            'warehouse_id' => $request->warehouse_id,
            'batch_id' => $request->batch_id,
            'batch_size' => $request->batch_size,
            'manufacturing_date' => $request->manufacturing_date,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
        ];

        if ($item->update($data))
        {
            return redirect()->route('batches.index')->with('message', __('messages.update', ['name' => 'Batches']));
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
        $item = Batch::find($id);

        $data = [
            'active' => 0
        ];

        if ($item->update($data))
        {
            return redirect()->route('batches.index')->with('message', __('messages.delete', ['name' => 'Batches']));
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
                    $truncate=Batch::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=Batch::pluck('batch_id','id')->toArray();

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
                                   
                                    $batch_id   = $line[0];
                                    $warehouse_id=$line[1];
                                    $batch_size=$line[2];
                                    $stock_item_id=$line[3];
                                    $manufacturing_date  = $line[4];
                                    $expiry_date  = $line[5];
                                    $description  = $line[6];
                                    $is_enabled  = $line[7];
                                    $active  = $line[8];
            
                                // Insert member data in the database
                                    if(!(in_array($batch_id,$grpup_name_title)) && !in_array($batch_id,$store))
                                    {
                                        $store[]=$batch_id;
                                        Batch::create([
                                        'batch_id' => $batch_id,
                                        'warehouse_id' => $warehouse_id,
                                        'batch_size'=>$batch_size,
                                         'stock_item_id'=>$stock_item_id,
                                        'manufacturing_date'=>$manufacturing_date,
                                        'expiry_date'=>$expiry_date,
                                        'description'=>$description,
                                        'is_enabled'=>$is_enabled,
                                        'active'=>$active,
                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('batches.index')->with('message', 'Imported Data successfully.');

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
            else
            {
                return redirect()->back()->with('error', 'Only CSV file accepted.');
            }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=Batch::pluck('batch_id','id')->toArray();
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
                                    $batch_id   = $line[0];
                                    $warehouse_id=$line[1];
                                    $batch_size=$line[2];
                                    $stock_item_id=$line[3];
                                    $manufacturing_date  = $line[4];
                                    $expiry_date  = $line[5];
                                    $description  = $line[6];
                                    $is_enabled  = $line[7];
                                    $active  = $line[8];
            
              
                                if(!(in_array($batch_id,$grpup_name_title)) && !in_array($batch_id,$store))
                                {
                                     $store[]=$batch_id;
                                    Batch::create([
                                        'batch_id' => $batch_id,
                                        'warehouse_id' => $warehouse_id,
                                        'batch_size'=>$batch_size,
                                        'stock_item_id'=>$stock_item_id,
                                        'manufacturing_date'=>$manufacturing_date,
                                        'expiry_date'=>$expiry_date,
                                        'description'=>$description,
                                        'is_enabled'=>$is_enabled,
                                        'active'=>$active,
                                        ]);     
                                }
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('batches.index')->with('message', 'Imported Data successfully.');

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
