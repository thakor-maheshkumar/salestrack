<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockSeries;

class StockSeriesController extends Controller
{
    public function index()
    {
        $data['stock']=StockSeries::orderByDesc('id')->get();
        return view('admin.series.stock.index',$data);
    }
    public function create()
    {
        return view('admin.series.stock.create');
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
        $stock=new StockSeries;
        $stock->series_name=$request->series_name;
        $stock->request_type=$request->request_type;
        $stock->prefix=$request->prefix;
        $stock->suffix=$request->suffix;
        $stock->prefix_static_character=$_POST['prefix_static_character'];
        $stock->suffix_static_character=$_POST['suffix_static_character'];
        $stock->series_starting_digits=$request->series_starting_digits;
        $stock->series_current_digit=$request->series_starting_digits;
        $stock->save();
        return redirect('admin/series/stocktransfer')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['stock']=StockSeries::find($id);
        return view('admin.series.stock.edit',$data);
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
        $stock=StockSeries::find($id);
        $stock->series_name=$request->series_name;
        $stock->request_type=$request->request_type;
        $stock->prefix_static_character=$_POST['prefix_static_character'];
        $stock->suffix_static_character=$_POST['suffix_static_character'];
        $stock->prefix=$request->prefix;
        $stock->suffix=$request->suffix;
        $stock->series_starting_digits=$request->series_starting_digits;
        $stock->series_current_digit=$request->series_starting_digits;
        $stock->save();
        return redirect('admin/series/stocktransfer')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $stock = StockSeries::find($id);
            if($stock)
            {
                $stock->delete();
                return redirect('admin/series/stocktransfer')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/stocktransfer')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=StockSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];

        $updatedata=StockSeries::where('id','!=',$id)->update($savedata);
    }
}
