<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\InventoryUnit;
use App\Models\UnitData;

class InventoryUnitController extends CoreController
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
        $inventoryUnits = InventoryUnit::all();

        return view('admin.inventory.unit.index', ['inventoryUnits' => $inventoryUnits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unitData = UnitData::pluck('name', 'id')->toArray();

        return view('admin.inventory.unit.create', ['unitData' => $unitData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'unit_quantity_code' => 'required|exists:units_data,id',
            'no_of_decimal_places'=>'required'
        ]);

        $result = InventoryUnit::create([
            'symbol' => isset($request->symbol) ? $request->symbol : NULL,
            'name' => isset($request->name) ? $request->name : NULL,
            'unit_quantity_code' => $request->unit_quantity_code,
            'no_of_decimal_places' => isset($request->no_of_decimal_places) ? $request->no_of_decimal_places : NULL
        ]);

        if($result)
        {
            return redirect()->route('units.index')->with('message', __('messages.add', ['name' => 'Unit']));
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
            $inventoryUnit = InventoryUnit::find($id);
            $unitData = UnitData::pluck('name', 'id')->toArray();

            if($inventoryUnit)
            {
                return view('admin.inventory.unit.edit', ['inventoryUnit' => $inventoryUnit, 'unitData' => $unitData]);
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'unit_quantity_code' => 'required|exists:units_data,id'
        ]);

        $inventoryUnit = InventoryUnit::find($id);

        if($inventoryUnit)
        {
            $data = [
                'symbol' => isset($request->symbol) ? $request->symbol : NULL,
                'name' => isset($request->name) ? $request->name : NULL,
                'unit_quantity_code' => $request->unit_quantity_code,
                'no_of_decimal_places' => isset($request->no_of_decimal_places) ? $request->no_of_decimal_places : NULL
            ];

            if ($inventoryUnit->update($data))
            {
                return redirect()->route('units.index')->with('message', __('messages.update', ['name' => 'Unit']));
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
        $inventoryUnit = InventoryUnit::find($id);

        if ($inventoryUnit)
        {
            $inventoryUnit->delete();

            return redirect()->route('units.index')->with('message', __('messages.delete', ['name' => 'Unit']));
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
                   $truncate=InventoryUnit::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=InventoryUnit::pluck('name','id')->toArray();

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
                                   
                                    $symbol   = $line[0];
                                    $name  = $line[1];
                                    $unit_quantity_code=$line[2];
                                    $no_of_decimal_places=$line[3];
                                    $active=$line[4];
            
                                // Insert member data in the database
                                    if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                    {
                                        $store[]=$name;
                                        InventoryUnit::create([
                                        'symbol' => $symbol,
                                        'name' => $name,
                                        'unit_quantity_code'=>$unit_quantity_code,
                                        'no_of_decimal_places'=>$no_of_decimal_places,
                                        'active'=>$active,
                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('units.index')->with('message', 'Imported Data successfully.');

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


        $grpup_name_title=InventoryUnit::pluck('name','id')->toArray();
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
                          
                                    $symbol   = $line[0];
                                    $name  = $line[1];
                                    $unit_quantity_code=$line[2];
                                    $no_of_decimal_places=$line[3];
                                    $active=$line[4];
              
                
                                if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                {
                                    $store[]=$name;
                                    InventoryUnit::create([
                                        'symbol' => $symbol,
                                        'name' => $name,
                                        'unit_quantity_code'=>$unit_quantity_code,
                                        'no_of_decimal_places'=>$no_of_decimal_places,
                                        'active'=>$active,
                                    ]);    
                                }
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('units.index')->with('message', 'Imported Data successfully.');

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
