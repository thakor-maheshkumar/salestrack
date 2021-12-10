<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Groups;

class GroupController extends CoreController
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
    public function account(Request $request)
    {
        return view('admin.group.account');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ledger(Request $request)
    {
        return view('admin.ledger.type');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Groups::with('parentGroup')->where('under', '<>', 0)->where('group_type', '<>', 0)->get();
        
        return view('admin.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $primary = Groups::where(['under' => 0, 'group_type' => 0])->pluck('group_name', 'id')->toArray();

        $others = Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->get();
        $other = [];
        if(isset($others) && !empty($others))
        {
            foreach ($others as $key => $group) {
                $other[$group->id] =  $group->group_name . (isset($group->underGroup->group_name) ? ' (' . $group->underGroup->group_name . ')' : '');
            }
        }

        return view('admin.group.create', ['primary' => $primary, 'other' => $other]);
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
            'under' => 'required|in:1,2',
            'is_affect' => 'required|in:0,1',
        ];

        switch ($request->under) {
            case '1':
                $ids = implode(',', Groups::where(['under' => 0, 'group_type' => 0])->pluck('id')->toArray());
                $rules['group_type'] = 'required|in:'. $ids;
                break;

            case '2':
                $rules['group_type'] = 'required|exists:groups,id';
                break;

            default:
                $rules['group_type'] = 'required|exists:groups,id';
                break;
        }

        $this->validate($request, $rules);

        Groups::create([
            'group_name' => $request->group_name,
            'under' => $request->under,
            'group_type' => $request->group_type,
            'is_affect' => $request->is_affect,
        ]);

        return redirect()->route('groups.index')->with('message', 'Group Added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Groups $group)
    {
        $primary = Groups::where(['under' => 0, 'group_type' => 0])->pluck('group_name', 'id')->toArray();
        $others = Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->get();

        $other = [];
        if(isset($others) && !empty($others))
        {
            foreach ($others as $key => $ogroup) {
                $other[$ogroup->id] =  $ogroup->group_name . (isset($ogroup->underGroup->group_name) ? ' (' . $ogroup->underGroup->group_name . ')' : '');
            }
        }

        return view('admin.group.edit', ['group' => $group, 'primary' => $primary, 'other' => $other]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groups $group)
    {
        $rules = [
            'group_name' => 'required',
            'under' => 'required|in:1,2',
            'is_affect' => 'required|in:0,1',
        ];

        switch ($request->under) {
            case '1':
                $ids = implode(',', Groups::where(['under' => 0, 'group_type' => 0])->pluck('id')->toArray());
                $rules['group_type'] = 'required|in:'. $ids;
                break;

            case '2':
                $rules['group_type'] = 'required|exists:groups,id';
                break;

            default:
                $rules['group_type'] = 'required|exists:groups,id';
                break;
        }

        $this->validate($request, $rules);

        $data = [
            'group_name' => $request->group_name,
            'under' => $request->under,
            'group_type' => $request->group_type,
            'is_affect' => $request->is_affect,
        ];

        if ($group->update($data))
            return redirect()->route('groups.index')->with('message', 'Groups update successfully.');

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
        $group = Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->find($id);

        if ($group)
        {
            $group->delete();

            return redirect()->route('groups.index')->with('message', 'Group deleted successfully.');
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
            {
                $groups = Groups::where(['under' => 0, 'group_type' => 0])->pluck('group_name', 'id')->toArray();
            }
            else
            {
                $others = Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->get();

                $groups = [];
                if(isset($others) && !empty($others))
                {
                    foreach ($others as $key => $group) {
                        $groups[$group->id] =  $group->group_name . (isset($group->underGroup->group_name) ? ' (' . $group->underGroup->group_name . ')' : '');
                    }
                }
            }

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
                   $test=Groups::truncate();
            
            if(isset($test))
            {
            $grpup_name_title=Groups::pluck('group_name','id')->toArray();

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
                                    $group_type=$line[2];
                                    $group_details=$line[3];
                                    $is_affect=$line[4];
            
                                // Insert member data in the database
                                    if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                    {
                                        $store[]=$group_name;
                                        Groups::create([
                                        'group_name' => $group_name,
                                        'under' => $under,
                                        'group_type'=>$group_type,
                                        'group_details'=>$group_details,
                                        'is_affect'=>$is_affect,
                                        ]);    
                                    }
                            
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('groups.index')->with('message', 'Imported Data successfully.');

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
    }else
    {
        return redirect()->back()->with('error', 'Only CSV file accepted.');
    }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=Groups::pluck('group_name','id')->toArray();
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
                                    $group_type=$line[2];
                                    $group_details=$line[3];
                                    $is_affect=$line[4];
            
              
                
                // Check whether member already exists in the database with the same email
                /*$prevQuery = "SELECT id FROM members WHERE email = '".$line[1]."'";
                $prevResult = query($prevQuery);*/
                
                /*if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
                }*/
                // Insert member data in the database
                                if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                {
                                    $store[]=$group_name;
                                    Groups::create([
                                        'group_name' => $group_name,
                                        'under' => $under,
                                        'group_type'=>$group_type,
                                        'group_details'=>$group_details,
                                        'is_affect'=>$is_affect,
                                    ]);    
                                }
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('groups.index')->with('message', 'Imported Data successfully.');

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
    public function fetchgroup(Request $request)
    {
        $group_type=$request->group_type;
        $data=Groups::where('group_type',$group_type)->get();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
}
