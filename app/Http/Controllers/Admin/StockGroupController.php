<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockGroup;
use App\Http\Requests\Admin\StockGroupRequest;
use App\Models\StockGroupGstHistory;
class StockGroupController extends CoreController
{
    protected static $taxablity_types = [
        'unknown' => 'Unknown',
        'exempt' => 'Exempt',
        'nil_rated' => 'Nil Rated',
        'taxable' => 'Taxable'
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
        $stock_groups = StockGroup::all();

        return view('admin.inventory.stock-group.index', ['stock_groups' => $stock_groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_groups = StockGroup::where('active', 1)->pluck('group_name', 'id')->toArray();

        return view('admin.inventory.stock-group.create', ['taxablity_types' => self::$taxablity_types, 'stock_groups' => $stock_groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $result = StockGroup::create([
            'group_name' => $request->group_name,
            'under' => $request->under,
            'is_gst_detail' => $request->is_gst_detail,
            'taxability' => isset($request->taxability) ? $request->taxability : NULL,
            'is_reverse_charge' => isset($request->is_reverse_charge) ? $request->is_reverse_charge : NULL,
            'gst_rate' => isset($request->gst_rate) ? $request->gst_rate : NULL,
            'gst_applicable_date' => isset($request->gst_applicable_date) ? $request->gst_applicable_date : NULL,
            'cess_rate' => isset($request->cess_rate) ? $request->cess_rate : NULL,
            'cess_applicable_date' => isset($request->cess_applicable_date) ? $request->cess_applicable_date : NULL,
        ]);

        if($result)
        {
            if($result && $result->is_gst_detail==1){
            $group=new StockGroupGstHistory;
            $group->stock_group_id=$result->id;
            $group->gst_rate=$request->gst_rate;
            $group->cess_rate=$request->cess_rate;
            $group->gst_rate_applicable_date=$request->gst_applicable_date;
            $group->cess_rate_applicable_date=$request->cess_applicable_date;
            $group->save();    
            }
            return redirect()->route('stock-groups.index')->with('message', __('messages.add', ['name' => 'Stock group']));
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
        if($id)
        {
            $group = StockGroup::find($id);

            if($group)
            {
                return response()->json(['success' => true, 'group' => $group]);
            }
        }

        return response()->json(['success' => false]);
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
            $group = StockGroup::find($id);

            if($group)
            {
                $stock_groups = StockGroup::where('active', 1)->where('id', '!=', $id)->pluck('group_name', 'id')->toArray();
                $gstStock=StockGroupGstHistory::where('stock_group_id',$group->id)->orderBy('id','desc')->offset(1)->limit(1)->first();

                return view('admin.inventory.stock-group.edit', ['group' => $group, 'taxablity_types' => self::$taxablity_types, 'stock_groups' => $stock_groups,'gstStock'=>$gstStock]);
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
        $request->validate([
            'group_name' => 'required|unique:stock_group,group_name,'.$id,
            'is_gst_detail' => 'required|in:0,1',
            'taxability' => 'required_if:is_gst_detail,1',
            'is_reverse_charge' => 'required_if:is_gst_detail,1',
            'gst_rate' => 'required_if:is_gst_detail,1',
            'gst_applicable_date' => 'required_if:is_gst_detail,1',
            'cess_rate' => 'required_if:is_gst_detail,1',
            'cess_applicable_date' => 'required_if:is_gst_detail,1',
        ]);
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
        ];

        $group = StockGroup::find($id);

        if($group)
        {
            if ($group->update($data))
            {
                $group=new StockGroupGstHistory;
                $group->stock_group_id=$request->stock_group_id;
                $group->gst_rate=$request->gst_rate;
                $group->cess_rate=$request->cess_rate;
                $group->gst_rate_applicable_date=$request->gst_applicable_date;
                $group->cess_rate_applicable_date=$request->cess_applicable_date;
                $group->save();
                return redirect()->route('stock-groups.index')->with('message', __('messages.update', ['name' => 'Groups']));
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
        $group = StockGroup::find($id);

        if ($group)
        {
            $group->delete();

            return redirect()->route('stock-groups.index')->with('message', __('messages.delete', ['name' => 'Stock group']));
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
            $truncate=StockGroup::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=StockGroup::pluck('group_name','id')->toArray();

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
                                    $is_gst_detail=$line[2];
                                    $taxability=$line[3];
                                    $is_reverse_charge=$line[4];
                                    $gst_rate=$line[5];
                                    $gst_applicable_date=$line[6];
                                    $cess_rate=$line[7];
                                    $cess_applicable_date=$line[8];
                                    $active=$line[9];
            
                                // Insert member data in the database
                                    if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                    {
                                        $store[]=$group_name;
                                        StockGroup::create([
                                        'group_name' => $group_name,
                                        'under' => $under,
                                        'is_gst_detail'=>$is_gst_detail,
                                        'taxability'=>$taxability,
                                        'is_reverse_charge'=>$is_reverse_charge,
                                        'gst_rate'=>$gst_rate,
                                        'gst_applicable_date'=>$gst_applicable_date,
                                        'cess_rate'=>$cess_rate,
                                        'cess_applicable_date'=>$cess_applicable_date,
                                        'active'=>$active,
                                        ]);    
                                    }
                                    
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('stock-groups.index')->with('message', 'Imported Data successfully.');

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
            else{
                return redirect()->back()->with('error', 'Only CSV file accepted.');
            }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=StockGroup::pluck('group_name','id')->toArray();
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
                                    $is_gst_detail=$line[2];
                                    $taxability=$line[3];
                                    $is_reverse_charge=$line[4];
                                    $gst_rate=$line[5];
                                    $gst_applicable_date=$line[6];
                                    $cess_rate=$line[7];
                                    $cess_applicable_date=$line[8];
                                    $active=$line[9];
              
        
                                if(!(in_array($group_name,$grpup_name_title)) && !in_array($group_name,$store))
                                {
                                    $store[]=$group_name;
                                    StockGroup::create([
                                        'group_name' => $group_name,
                                        'under' => $under,
                                        'is_gst_detail'=>$is_gst_detail,
                                        'taxability'=>$taxability,
                                        'is_reverse_charge'=>$is_reverse_charge,
                                        'gst_rate'=>$gst_rate,
                                        'gst_applicable_date'=>$gst_applicable_date,
                                        'cess_rate'=>$cess_rate,
                                        'cess_applicable_date'=>$cess_applicable_date,
                                        'active'=>$active,
                                    ]);    
                                }
                                
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('stock-groups.index')->with('message', 'Imported Data successfully.');

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
