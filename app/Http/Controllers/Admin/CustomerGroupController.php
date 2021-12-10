<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\CustomerGroup;

class CustomerGroupController extends CoreController
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
        $groups = CustomerGroup::with('parentGroup')->get();

        return view('admin.customer-group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$primary = CustomerGroup::where(['under' => 0, 'group_type' => 0])->pluck('group_name', 'id')->toArray();
        $other = CustomerGroup::where('under', '<>', 0)->where('group_type', '<>', 0)->pluck('group_name', 'id')->toArray();*/

        $customer_groups = CustomerGroup::pluck('group_name', 'id')->toArray();


        return view('admin.customer-group.create', ['customer_groups' => $customer_groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'group_name' => 'required',
            'under' => 'sometimes|required|nullable|exists:customer_groups,id'
        ];

        /*switch ($request->under) {
            case '1':
                $ids = implode(',', CustomerGroup::where(['under' => 0, 'group_type' => 0])->pluck('id')->toArray());
                $rules['group_type'] = 'required|in:'. $ids;
                break;

            case '2':
                $rules['group_type'] = 'required|exists:customer_groups,id';
                break;

            default:
                $rules['group_type'] = 'required|exists:customer_groups,id';
                break;
        }

        $this->validate($request, $rules);*/

        CustomerGroup::create([
            'group_name' => $request->group_name,
            'under' => $request->under
        ]);

        return redirect()->route('customer-groups.index')->with('message', 'Group Added successfully.');
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
        $group = CustomerGroup::find($id);

        if($group)
        {
            $customer_groups = CustomerGroup::pluck('group_name', 'id')->toArray();

            return view('admin.customer-group.edit', ['group' => $group, 'customer_groups' => $customer_groups]);
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
        $rules = [
            'group_name' => 'required',
            'under' => 'sometimes|required|nullable|exists:customer_groups,id'
        ];

        /*switch ($request->under) {
            case '1':
                $ids = implode(',', CustomerGroup::where(['under' => 0, 'group_type' => 0])->pluck('id')->toArray());
                $rules['group_type'] = 'required|in:'. $ids;
                break;

            case '2':
                $rules['group_type'] = 'required|exists:groups,id';
                break;

            default:
                $rules['group_type'] = 'required|exists:groups,id';
                break;
        }

        $this->validate($request, $rules);*/

        $data = [
            'group_name' => $request->group_name,
            'under' => $request->under
        ];

        $group = CustomerGroup::find($id);

        if($group)
        {
            if ($group->update($data))
                return redirect()->route('customer-groups.index')->with('message', 'Groups update successfully.');
        }

        return redirect()->back()->with('error', 'Something goes wrong.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = CustomerGroup::find($id);

        if ($group)
        {
            $group->delete();

            return redirect()->route('customer-groups.index')->with('message', 'Group deleted successfully.');
        }

        return redirect()->back()->with('error', 'Something goes to wrong.');
    }

    /**
     * Get the groups type.
     *
     */
    public function getGroupType(Request $request, $id)
    {
        if ($request->ajax())
        {
            if ($id == 1)
                $groups = CustomerGroup::where(['under' => 0, 'group_type' => 0])->pluck('group_name', 'id')->toArray();
            else
                $groups = CustomerGroup::where('under', '<>', 0)->where('group_type', '<>', 0)->pluck('group_name', 'id')->toArray();

            return response()->json([
                'success' => true,
                'data' => $groups
            ]);
        }

        abort(404);
    }
    public function insert(Request $request)
    {
        if($request->import=='override'){
            $validated=$request->validate([
                'file'=>'required|mimes:csv,txt',
            ]);
            if($validated){
                   $test=CustomerGroup::truncate();
            if(isset($test))
            {
            $grpup_name_title=CustomerGroup::pluck('group_name','id')->toArray();

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
                                    
                                    $group_name   = $line[0];
                                    $under  = $line[1];
            
                                // Insert member data in the database
                                    if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                    {
                                        $store[]=$group_name;
                                        CustomerGroup::create([
                                        'group_name' => $group_name,
                                        'under' => $under
                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('customer-groups.index')->with('message', 'Imported Data successfully.');

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


        $grpup_name_title=CustomerGroup::pluck('group_name','id')->toArray();
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
                           
                            $group_name   = $line[0];
                            $under  = $line[1];
              
                                if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                {
                                    $store[]=$group_name;
                                    CustomerGroup::create([
                                    'group_name' => $group_name,
                                    'under' => $under
                                    ]);    
                                }
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('customer-groups.index')->with('message', 'Imported Data successfully.');

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
