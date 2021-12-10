<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Company;
use App\Models\Department;
use App\Models\Warehouse;
use App\Http\Requests\Admin\WarehouseRequest;
use App\Http\Controllers\Admin\CustomModuleController;

class WarehouseController extends CoreController
{
    protected $module_name;

    protected static $parent_type = [
        'App\Models\Department' => 'Department',
        'App\Models\Warehouse' => 'Warehuse',
    ];

    /**
     * Create the constructor
     *
     */
    public function __construct(CustomModuleController $customObj)
    {
        parent::__construct();

        $this->customObj = $customObj;
        $this->module_name = 'warehouse';
    }

    /**
     * Get parent module data list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWarehouseParentDataList($module)
    {
        $parent_modules = [];

        if(!empty($module) && !empty($module->parent_module))
        {
            $parent_modules = $this->customObj->getParentModuleDataList($module);
        }
        else
        {
            $parent_modules = Department::active()->pluck('name', 'id')->toArray();
        }

        return $parent_modules;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::all();

        return view('admin.warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_modules = [];
        $module = $this->getModule($this->module_name);

        if(!empty($module))
        {
            $parent_modules = $this->getWarehouseParentDataList($module);
            $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();

            $departments = \App\Models\Department::where('active', 1)->pluck('name', 'id')->toArray();
            $warehouses = \App\Models\Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

            return view('admin.warehouses.create', ['countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'parent_type' => static::$parent_type, 'departments' => $departments, 'warehouses' => $warehouses]);
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)
    {
        $post = $request->all();

        if($post)
        {
            $warehouse = new Warehouse($post);

            if($warehouse->save())
            {
                return redirect()->route('warehouses.index')->with('message', __('messages.add', ['name' => 'Warehouse']));
            }
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
            $warehouse = Warehouse::find($id);

            if($warehouse)
            {
                $module = $this->getModule($this->module_name);

                if(!empty($module))
                {
                    $parent_modules = $this->getWarehouseParentDataList($module);

                    $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();

                    $departments = \App\Models\Department::where('active', 1)->pluck('name', 'id')->toArray();
                    $warehouses = \App\Models\Warehouse::where('active', 1)->where('id', '!=', $warehouse->id)->pluck('name', 'id')->toArray();

                    return view('admin.warehouses.edit', ['warehouse' => $warehouse, 'countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'parent_type' => static::$parent_type, 'departments' => $departments, 'warehouses' => $warehouses]);
                }

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
    public function update(WarehouseRequest $request, $id)
    {
        if($id)
        {
            $post = $request->all();

            $warehouse = Warehouse::find($id);

            if($post && $warehouse)
            {
                if($warehouse->update($post))
                {
                    return redirect()->route('warehouses.index')->with('message', __('messages.update', ['name' => 'Warehouse']));
                }
            }

            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }

        abort(404);
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
    public function insert(Request $request)
    {
        if($request->import=='override'){
            $validated=$request->validate([
                'file'=>'required|mimes:csv,txt',
            ]);
            if($validated){
                $test=Warehouse::truncate();
            if(isset($test))
            {
            $grpup_name_title=Warehouse::pluck('name','id')->toArray();

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
                                    $parentable_id=$line[0];
                                    $parentable_type=$line[1];
                                    $name   = $line[2];
                                    $address  = $line[3];
                                    $street= $line[4];
                                    $landmark=  $line[5];
                                    $city= $line[6];
                                    $state=$line[7];
                                    $country_id=$line[8];
                                    $email=$line[9];
                                    $phone=$line[10];
                                    $module_id=$line[11];
                                    $active=$line[12];
                    
            
                                // Insert member data in the database
                                    if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                    {
                                        $store[]=$name;
                                        Warehouse::create([
                                        'parentable_id'=>$parentable_id,
                                        'parentable_type'=> $parentable_type,
                                        'name' => $name,
                                        'address' => $address,
                                        'street'=>$street,
                                        'landmark'=>$landmark,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'country_id'=>$country_id,
                                        'email'=>$email,
                                        'phone'=>$phone,
                                        'module_id'=>$module_id,
                                        'active'=>$active,
                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('warehouses.index')->with('message', 'Imported Data successfully.');

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


        $grpup_name_title=Warehouse::pluck('name','id')->toArray();
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
                        while(($line = fgetcsv($csvFile)) !== FALSE)
                        {
                // Get row data
                          
                                    $parentable_id=$line[0];
                                    $parentable_type=$line[1];
                                    $name   = $line[2];
                                    $address  = $line[3];
                                    $street= $line[4];
                                    $landmark=  $line[5];
                                    $city= $line[6];
                                    $state=$line[7];
                                    $country_id=$line[8];
                                    $email=$line[9];
                                    $phone=$line[10];
                                    $module_id=$line[11];
                                    $active=$line[12];
                    
              
                
                // Check whether member already exists in the database with the same email
                /*$prevQuery = "SELECT id FROM members WHERE email = '".$line[1]."'";
                $prevResult = query($prevQuery);*/
                
                /*if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
                }*/
                // Insert member data in the database
                                if(!(in_array($name,$grpup_name_title)))
                                {
                                    Warehouse::create([
                                        'parentable_id'=>$parentable_id,
                                        'parentable_type'=> $parentable_type,
                                        'name' => $name,
                                        'address' => $address,
                                        'street'=>$street,
                                        'landmark'=>$landmark,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'country_id'=>$country_id,
                                        'email'=>$email,
                                        'phone'=>$phone,
                                        'module_id'=>$module_id,
                                        'active'=>$active,
                                    ]);    
                                }
                                else if((in_array('id',$grpup_name_title)))
                                {
                                    Warehouse::upate([
                                        'parentable_id'=>$parentable_id,
                                        'parentable_type'=> $parentable_type,
                                        'name' => $name,
                                        'address' => $address,
                                        'street'=>$street,
                                        'landmark'=>$landmark,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'country_id'=>$country_id,
                                        'email'=>$email,
                                        'phone'=>$phone,
                                        'module_id'=>$module_id,
                                        'active'=>$active,
                                    ]);
                                }
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('warehouses.index')->with('message', 'Imported Data successfully.');

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
