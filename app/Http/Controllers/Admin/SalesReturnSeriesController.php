<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesReturnSeries;
class SalesReturnSeriesController extends Controller
{
    public function index()
    {
        $data['salesreturn']=SalesReturnSeries::orderByDesc('id')->get();
        return view('admin.series.sales-return.index',$data);
    }
    public function create()
    {
        return view('admin.series.sales-return.create');
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
        $salesreturn=new SalesReturnSeries;
        $salesreturn->series_name=$request->series_name;
        $salesreturn->request_type=$request->request_type;
        $salesreturn->prefix=$request->prefix;
        $salesreturn->suffix=$request->suffix;
        $salesreturn->prefix_static_character=$_POST['prefix_static_character'];
        $salesreturn->suffix_static_character=$_POST['suffix_static_character'];
        $salesreturn->series_starting_digits=$request->series_starting_digits;
        $salesreturn->series_current_digit=$request->series_starting_digits;
        $salesreturn->save();
        return redirect('admin/series/salesreturn')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['salesreturn']=SalesReturnSeries::find($id);
        return view('admin.series.sales-return.edit',$data);
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
        $salesreturn=SalesReturnSeries::find($id);
        $salesreturn->series_name=$request->series_name;
        $salesreturn->request_type=$request->request_type;
        $salesreturn->prefix_static_character=$_POST['prefix_static_character'];
        $salesreturn->suffix_static_character=$_POST['suffix_static_character'];
        $salesreturn->prefix=$request->prefix;
        $salesreturn->suffix=$request->suffix;
        $salesreturn->series_starting_digits=$request->series_starting_digits;
        $salesreturn->series_current_digit=$request->series_starting_digits;
        $salesreturn->save();
        return redirect('admin/series/salesreturn')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $salesreturn = SalesReturnSeries::find($id);
            if($salesreturn)
            {
                $salesreturn->delete();
                return redirect('admin/series/salesreturn')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/salesreturn')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=SalesReturnSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=SalesReturnSeries::where('id','!=',$id)->update($savedata);
    }   
}
