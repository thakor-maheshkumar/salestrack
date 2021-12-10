<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductionPlanSeries;
class ProductionPlanSeriesController extends Controller
{
    public function index()
    {
        $data['productionplan']=ProductionPlanSeries::orderByDesc('id')->get();
        return view('admin.series.production-plan.index',$data);
    }
    public function create()
    {
        return view('admin.series.production-plan.create');
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
        $productionplan=new ProductionPlanSeries;
        $productionplan->series_name=$request->series_name;
        $productionplan->request_type=$request->request_type;
        $productionplan->prefix=$request->prefix;
        $productionplan->suffix=$request->suffix;
        $productionplan->prefix_static_character=$_POST['prefix_static_character'];
        $productionplan->suffix_static_character=$_POST['suffix_static_character'];
        $productionplan->series_starting_digits=$request->series_starting_digits;
        $productionplan->series_current_digit=$request->series_starting_digits;
        $productionplan->save();
        return redirect('admin/series/productionplan')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['productionplan']=ProductionPlanSeries::find($id);
        return view('admin.series.production-plan.edit',$data);
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
        $productionplan=ProductionPlanSeries::find($id);
        $productionplan->series_name=$request->series_name;
        $productionplan->request_type=$request->request_type;
        $productionplan->prefix_static_character=$_POST['prefix_static_character'];
        $productionplan->suffix_static_character=$_POST['suffix_static_character'];
        $productionplan->prefix=$request->prefix;
        $productionplan->suffix=$request->suffix;
        $productionplan->series_starting_digits=$request->series_starting_digits;
        $productionplan->series_current_digit=$request->series_starting_digits;
        $productionplan->save();
        return redirect('admin/series/productionplan')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $productionplan = ProductionPlanSeries::find($id);
            if($productionplan)
            {
                $productionplan->delete();
                return redirect('admin/series/productionplan')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/productionplan')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=ProductionPlanSeries::where('id',$id)->first();
        $data->status="true";
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=ProductionPlanSeries::where('id','!=',$id)->update($savedata);
    }
}
