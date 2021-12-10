<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseReturnSeries;

class PurchaseReturnSeriesController extends Controller
{
    public function index()
    {
        $data['purchasereturnseries']=PurchaseReturnSeries::all();
        return view('admin.series.purchase-return.index',$data);
    }
    public function create()
    {
        return view('admin.series.purchase-return.create');
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
        $purchasereturn=new PurchaseReturnSeries;
        $purchasereturn->series_name=$request->series_name;
        $purchasereturn->request_type=$request->request_type;
        $purchasereturn->prefix=$request->prefix;
        $purchasereturn->suffix=$request->suffix;
        $purchasereturn->prefix_static_character=$_POST['prefix_static_character'];
        $purchasereturn->suffix_static_character=$_POST['suffix_static_character'];
        $purchasereturn->series_starting_digits=$request->series_starting_digits;
        $purchasereturn->series_current_digit=$request->series_starting_digits;
        $purchasereturn->save();
        return redirect('admin/series/purchasereturn')->with('success','Purchase reciept series added successfully');
    }
    public function edit($id)
    {
        $data['purchasereturnseries']=PurchaseReturnSeries::find($id);

        return view('admin.series.purchase-return.edit',$data);
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
        $series=PurchaseReturnSeries::find($id);
        $series->series_name=$request->series_name;
        $series->request_type=$request->request_type;
        $series->prefix_static_character=$_POST['prefix_static_character'];
        $series->suffix_static_character=$_POST['suffix_static_character'];
        $series->prefix=$request->prefix;
        $series->suffix=$request->suffix;
        $series->series_starting_digits=$request->series_starting_digits;
        $series->series_current_digit=$request->series_starting_digits;
        $series->save();
        return redirect('admin/series/purchasereturn')->with('success','Series name has updated successfully');
   
    }
    public function destroy($id)
    {
        $series = PurchaseReturnSeries::find($id);
            if($series)
            {
                $series->delete();
                return redirect('admin/series/purchasereturn')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/purchasereturn')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=PurchaseReturnSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false',
        ];
        $updatedata=PurchaseReturnSeries::where('id','!=',$id)->update($savedata);
    }
}
