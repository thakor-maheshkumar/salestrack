<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockCategory;

class StockCategoriesController extends CoreController
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
		$stock_categories = StockCategory::all();

		return view('admin.inventory.stock-category.index', ['stock_categories' => $stock_categories]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$stock_groups = \App\Models\StockGroup::where('active', 1)->pluck('group_name', 'id')->toArray();

		return view('admin.inventory.stock-category.create', ['stock_groups' => $stock_groups]);
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
			'name' => 'required|unique:stock_categories,name',
			'group_id' => 'required|exists:stock_group,id'
		]);

		$result = StockCategory::create([
			'name' => $request->name,
			'group_id' => $request->group_id
		]);

		if($result)
		{
			return redirect()->route('stock-categories.index')->with('message', __('messages.add', ['name' => 'Stock category']));
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
			$category = StockCategory::find($id);

			if($category)
			{
				$stock_groups = \App\Models\StockGroup::where('active', 1)->pluck('group_name', 'id')->toArray();

				return view('admin.inventory.stock-category.edit', ['stock_groups' => $stock_groups, 'category' => $category]);
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
			'name' => 'required|unique:stock_categories,name,' . $id,
			'group_id' => 'required|exists:stock_group,id'
		]);

		$category = StockCategory::find($id);

		if($category)
		{
			if ($category->update(['name' => $request->name, 'group_id' => $request->group_id]))
			{
				return redirect()->route('stock-categories.index')->with('message', __('messages.update', ['name' => 'Category']));
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
		$category = StockCategory::find($id);

		if ($category)
		{
			$category->delete();

			return redirect()->route('stock-categories.index')->with('message', __('messages.delete', ['name' => 'Stock category']));
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
            	   $truncate=StockCategory::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=StockCategory::pluck('name','id')->toArray();

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
                                    $group_id  = $line[1];
                                    $active=$line[2];
            
                                // Insert member data in the database
                                    if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store));
                                    {
                                    	$store[]=$name;
                                        StockCategory::create([
                                        'name' => $name,
                                        'group_id' => $group_id,
                                        'active'=>$active,
                                        ]);    
                                    }
                            
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('stock-categories.index')->with('message', 'Imported Data successfully.');

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


        $grpup_name_title=StockCategory::pluck('name','id')->toArray();
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
                            $group_id  = $line[1];
                            $active=$line[2];
              
                                if(!(in_array($name,$grpup_name_title)) && !in_array($name,$store))
                                {
                                	$store[]=$name;
                                    StockCategory::create([
                                    'name' => $name,
                                    'group_id' => $group_id,
                                    'active'=>$active,
                                    ]);    
                                }
                                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('stock-categories.index')->with('message', 'Imported Data successfully.');

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
