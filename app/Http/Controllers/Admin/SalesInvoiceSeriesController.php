<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesInvoiceSeries;
class SalesInvoiceSeriesController extends Controller
{
    public function index()
    {
        $data['salesinvoice']=SalesInvoiceSeries::orderByDesc('id')->get();
        return view('admin.series.sales-invoice.index',$data);
    }
    public function create()
    {
        return view('admin.series.sales-invoice.create');
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
        $salesinvoice=new SalesInvoiceSeries;
        $salesinvoice->series_name=$request->series_name;
        $salesinvoice->request_type=$request->request_type;
        $salesinvoice->prefix=$request->prefix;
        $salesinvoice->suffix=$request->suffix;
        $salesinvoice->prefix_static_character=$_POST['prefix_static_character'];
        $salesinvoice->suffix_static_character=$_POST['suffix_static_character'];
        $salesinvoice->series_starting_digits=$request->series_starting_digits;
        $salesinvoice->series_current_digit=$request->series_starting_digits;
        $salesinvoice->save();
        return redirect('admin/series/salesinvoice')->with('success','Series name has added successfully');
    }
    public function edit($id)
    {
        $data['salesinvoice']=SalesInvoiceSeries::find($id);
        return view('admin.series.sales-invoice.edit',$data);
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
        $salesinvoice=SalesInvoiceSeries::find($id);
        $salesinvoice->series_name=$request->series_name;
        $salesinvoice->request_type=$request->request_type;
        $salesinvoice->prefix_static_character=$_POST['prefix_static_character'];
        $salesinvoice->suffix_static_character=$_POST['suffix_static_character'];
        $salesinvoice->prefix=$request->prefix;
        $salesinvoice->suffix=$request->suffix;
        $salesinvoice->series_starting_digits=$request->series_starting_digits;
        $salesinvoice->series_current_digit=$request->series_starting_digits;
        $salesinvoice->save();
        return redirect('admin/series/salesinvoice')->with('success','Series name has updated successfully');
    }
    public function destroy($id)
    {
        $salesinvoice = SalesInvoiceSeries::find($id);
            if($salesinvoice)
            {
                $salesinvoice->delete();
                return redirect('admin/series/salesinvoice')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/salesinvoice')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=SalesInvoiceSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=SalesInvoiceSeries::where('id','!=',$id)->update($savedata);
    }
}
