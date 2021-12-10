<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Transporter;
use App\Http\Requests\Admin\TransporterRequest;

class TransporterController extends CoreController
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
        $transporter = Transporter::where('active',1)->get();
        return view('admin.transporter.index', ['transporter' => $transporter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transporter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransporterRequest $request)
    {
        $data = $request->all();
        $result = Transporter::create($data);
       
        if($result)
        {
            return redirect()->route('transporter.index')->with('message', __('messages.add', ['name' => 'Transporter']));
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
            $item = Transporter::find($id);

            if($item)
            {
                return view('admin.transporter.edit', ['item' => $item]);
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
    public function update(TransporterRequest $request, $id)
    {
        $item = Transporter::find($id);
        if($item)
        {
            $data = $request->all();
            if ($item->update($data))
            {
                return redirect()->route('transporter.index')->with('message', __('messages.update', ['name' => 'Transporter']));
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
        $item = Transporter::find($id);

        if ($item)
        {
            $data = [
                'active' => 0
            ];
            $item->update($data);

            return redirect()->route('transporter.index')->with('message', __('messages.delete', ['name' => 'Transporter']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function insert(Request $request)
    {
        if($request->import=='override'){
            $validated=$request->validate([
                'file'=>'required|mimes:csv,txt',
            ]);
            if($validated){
                   $truncate=Transporter::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=Transporter::pluck('name','id')->toArray();

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
                                    $tansporter_id  = $line[1];
                                    $gst_no=$line[2];
                                    $doc_no=$line[3];
                                    $doc_date=$line[4];
                                    $active=$line[5];
            
                                // Insert member data in the database
                                    if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                    {
                                        $store[]=$name;
                                        Transporter::create([
                                        'name' => $name,
                                        'tansporter_id' => $tansporter_id,
                                        'gst_no'=>$gst_no,
                                        'doc_no'=>$doc_no,
                                        'doc_date'=>$doc_date,
                                        'active'=>$active,
                                        ]);    
                                    }
                                    
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('transporter.index')->with('message', 'Imported Data successfully.');

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


        $grpup_name_title=Transporter::pluck('name','id')->toArray();
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
                                    $tansporter_id  = $line[1];
                                    $gst_no=$line[2];
                                    $doc_no=$line[3];
                                    $doc_date=$line[4];
                                    $active=$line[5];
              
                                if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                    {
                                        $store[]=$name;
                                        Transporter::create([
                                        'name' => $name,
                                        'tansporter_id' => $tansporter_id,
                                        'gst_no'=>$gst_no,
                                        'doc_no'=>$doc_no,
                                        'doc_date'=>$doc_date,
                                        'active'=>$active,
                                        ]);    
                                    }
                                   
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('transporter.index')->with('message', 'Imported Data successfully.');

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
