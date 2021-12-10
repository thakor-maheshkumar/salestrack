<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierSeries;

class SupplierSeriesController extends Controller
{
    public function index()
    {
        $data['supplierseries']=SupplierSeries::all();
        return view('admin.series.suppliers.index',$data);
    }
    public function create()
    {
        return view('admin.series.suppliers.create');
    }
    public function store(Request $request)
    {
        if($request->request_type=='automatic'){
           $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
            'series_starting_digits'=>'required|max:10',
            'prefix' => 'sometimes',
            'prefix_static_character'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_character'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $supplierseries=new SupplierSeries;
        $supplierseries->series_name=$request->series_name;
        $supplierseries->request_type=$request->request_type;
        $supplierseries->prefix=$request->prefix;
        $supplierseries->suffix=$request->suffix;
        $supplierseries->prefix_static_character=$_POST['prefix_static_character'];
        $supplierseries->suffix_static_character=$_POST['suffix_static_character'];
        $supplierseries->series_starting_digits=$request->series_starting_digits;
        $supplierseries->series_current_digit=$request->series_starting_digits;
        $supplierseries->save();
        return redirect('admin/series/supplier')->with('success','Purchase reciept series added successfully');
    }
    public function edit($id)
    {
        $data['supplierseries']=SupplierSeries::find($id);

        return view('admin.series.suppliers.edit',$data);
    }
    public function update(Request $request,$id)
    {
        if($request->request_type=='automatic'){
           $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
            'series_starting_digits'=>'required|max:10',
            'prefix' => 'sometimes',
            'prefix_static_character'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_character'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $supplierseries=SupplierSeries::find($id);
        $supplierseries->series_name=$request->series_name;
        $supplierseries->request_type=$request->request_type;
        $supplierseries->prefix_static_character=$_POST['prefix_static_character'];
        $supplierseries->suffix_static_character=$_POST['suffix_static_character'];
        $supplierseries->prefix=$request->prefix;
        $supplierseries->suffix=$request->suffix;
        $supplierseries->series_starting_digits=$request->series_starting_digits;
        $supplierseries->series_current_digit=$request->series_starting_digits;
        $supplierseries->save();
        return redirect('admin/series/supplier')->with('success','Series name has updated successfully');
   
    }
    public function destroy($id)
    {
        $supplierseries = SupplierSeries::find($id);
            if($supplierseries)
            {
                $supplierseries->delete();
                return redirect('admin/series/supplier')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/supplier')->with('Error','Something has wrong');
            }
    }
    public function getdata(Request $request,$id)
    {
        
        $data=SupplierSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata = [
            'status' =>'false',
        ];
        $updatedata=SupplierSeries::where('id','!=',$id)->update($savedata);
    }
    
}
