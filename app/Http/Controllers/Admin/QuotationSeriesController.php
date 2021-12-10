<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuotationSeries;
class QuotationSeriesController extends Controller
{
    public function index()
    {
        $data['quotation']=QuotationSeries::orderByDesc('id')->get();
        return view('admin.series.quotation.index',$data);
    }
    public function create()
    {
        return view('admin.series.quotation.create');   
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
        $quotation=new QuotationSeries;
        $quotation->series_name=$request->series_name;
        $quotation->request_type=$request->request_type;
        $quotation->prefix=$request->prefix;
        $quotation->suffix=$request->suffix;
        $quotation->prefix_static_character=$_POST['prefix_static_character'];
        $quotation->suffix_static_character=$_POST['suffix_static_character'];
        $quotation->series_starting_digits=$request->series_starting_digits;
        $quotation->series_current_digit=$request->series_starting_digits;
        $quotation->save();
        return redirect('admin/series/quotation-series')->with('success','Purchase reciept series added successfully');

    }
    public function edit($id)
    {
        $data['quotation']=QuotationSeries::find($id);
        return view('admin.series.quotation.edit',$data);
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
        $quotation=QuotationSeries::find($id);
        $quotation->series_name=$request->series_name;
        $quotation->request_type=$request->request_type;
        $quotation->prefix_static_character=$_POST['prefix_static_character'];
        $quotation->suffix_static_character=$_POST['suffix_static_character'];
        $quotation->prefix=$request->prefix;
        $quotation->suffix=$request->suffix;
        $quotation->series_starting_digits=$request->series_starting_digits;
        $quotation->series_current_digit=$request->series_starting_digits;
        $quotation->save();
        return redirect('admin/series/quotation-series')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $quotation = QuotationSeries::find($id);
            if($quotation)
            {
                $quotation->delete();
                return redirect('admin/series/quotation-series')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/quotation-series')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=QuotationSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=QuotationSeries::where('id','!=',$id)->update($savedata);
    }
}
