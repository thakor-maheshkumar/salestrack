<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesOrderSeries;
class SalesOrderSeriesController extends Controller
{
    public function index()
    {
        $data['salesorder']=SalesOrderSeries::orderByDesc('id')->get();
        return view('admin.series.sales-order.index',$data);
    }
    public function create()
    {
        return view('admin.series.sales-order.create');
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
        $salesorder=new SalesOrderSeries;
        $salesorder->series_name=$request->series_name;
        $salesorder->request_type=$request->request_type;
        $salesorder->prefix=$request->prefix;
        $salesorder->suffix=$request->suffix;
        $salesorder->prefix_static_character=$_POST['prefix_static_character'];
        $salesorder->suffix_static_character=$_POST['suffix_static_character'];
        $salesorder->series_starting_digits=$request->series_starting_digits;
        $salesorder->series_current_digit=$request->series_starting_digits;
        $salesorder->save();
        return redirect('admin/series/salesorder')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['salesorder']=SalesOrderSeries::find($id);
        return view('admin.series.sales-order.edit',$data);
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
        $salesorder=SalesOrderSeries::find($id);
        $salesorder->series_name=$request->series_name;
        $salesorder->request_type=$request->request_type;
        $salesorder->prefix_static_character=$_POST['prefix_static_character'];
        $salesorder->suffix_static_character=$_POST['suffix_static_character'];
        $salesorder->prefix=$request->prefix;
        $salesorder->suffix=$request->suffix;
        $salesorder->series_starting_digits=$request->series_starting_digits;
        $salesorder->series_current_digit=$request->series_starting_digits;
        $salesorder->save();
        return redirect('admin/series/salesorder')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $salesorder = SalesOrderSeries::find($id);
            if($salesorder)
            {
                $salesorder->delete();
                return redirect('admin/series/salesorder')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/salesorder')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=SalesOrderSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=SalesOrderSeries::where('id','!=',$id)->update($savedata);
    }
}
