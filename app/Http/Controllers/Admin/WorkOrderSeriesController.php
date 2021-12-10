<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkOrderSeries;
class WorkOrderSeriesController extends Controller
{
    public function index()
    {
        $data['workorder']=WorkOrderSeries::orderByDesc('id')->get();
        return view('admin.series.work-order.index',$data);
    }
    public function create()
    {
        return view('admin.series.work-order.create');
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
        $workorder=new WorkOrderSeries;
        $workorder->series_name=$request->series_name;
        $workorder->request_type=$request->request_type;
        $workorder->prefix=$request->prefix;
        $workorder->suffix=$request->suffix;
        $workorder->prefix_static_character=$_POST['prefix_static_character'];
        $workorder->suffix_static_character=$_POST['suffix_static_character'];
        $workorder->series_starting_digits=$request->series_starting_digits;
        $workorder->series_current_digit=$request->series_starting_digits;
        $workorder->save();
        return redirect('admin/series/workorder')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['workorder']=WorkOrderSeries::find($id);
        return view('admin.series.work-order.edit',$data);
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
        $workorder=WorkOrderSeries::find($id);
        $workorder->series_name=$request->series_name;
        $workorder->request_type=$request->request_type;
        $workorder->prefix_static_character=$_POST['prefix_static_character'];
        $workorder->suffix_static_character=$_POST['suffix_static_character'];
        $workorder->prefix=$request->prefix;
        $workorder->suffix=$request->suffix;
        $workorder->series_starting_digits=$request->series_starting_digits;
        $workorder->series_current_digit=$request->series_starting_digits;
        $workorder->save();
        return redirect('admin/series/workorder')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $workorder = WorkOrderSeries::find($id);
            if($workorder)
            {
                $workorder->delete();
                return redirect('admin/series/workorder')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/workorder')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=WorkOrderSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];

        $updatedata=WorkOrderSeries::where('id','!=',$id)->update($savedata);
    }
}
