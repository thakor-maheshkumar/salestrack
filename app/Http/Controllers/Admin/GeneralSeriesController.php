<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSeriesController extends Controller
{
    //
    public function index()
    {
        $data['generalseries']=GeneralSeries::all();
        return view('admin.series.general.index',$data);
    }
    public function create()
    {
        return view('admin.series.general.create');
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
        $purchasereturn=new GeneralSeries;
        $purchasereturn->series_name=$request->series_name;
        $purchasereturn->request_type=$request->request_type;
        $purchasereturn->prefix=$request->prefix;
        $purchasereturn->suffix=$request->suffix;
        $purchasereturn->prefix_static_character=$_POST['prefix_static_character'];
        $purchasereturn->suffix_static_character=$_POST['suffix_static_character'];
        $purchasereturn->series_starting_digits=$request->series_starting_digits;
        $purchasereturn->series_current_digit=$request->series_starting_digits;
        $purchasereturn->save();
        return redirect('admin/series/generalseries')->with('success','Purchase reciept series added successfully');
    }
}
