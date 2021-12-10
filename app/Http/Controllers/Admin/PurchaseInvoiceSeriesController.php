<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoiceSeries;
class PurchaseInvoiceSeriesController extends Controller
{
    public function index()
    {
        $data['purchaseinvoice']=PurchaseInvoiceSeries::orderByDesc('id')->get();
        return view('admin.series.purchase-invoice.index',$data);
    }
    public function create()
    {
        return view('admin.series.purchase-invoice.create');
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
        $purchaseinvoice=new PurchaseInvoiceSeries;
        
        $purchaseinvoice->series_name=$request->series_name;
        $purchaseinvoice->request_type=$request->request_type;
        $purchaseinvoice->prefix_static_character=$_POST['prefix_static_character'];
        $purchaseinvoice->suffix_static_character=$_POST['suffix_static_character'];
        $purchaseinvoice->prefix=$request->prefix;
        $purchaseinvoice->suffix=$request->suffix;
        $purchaseinvoice->series_starting_digits=$request->series_starting_digits;
        $purchaseinvoice->series_current_digit=$request->series_starting_digits;
        $purchaseinvoice->save();
        return redirect('admin/series/purchaseinvoice')->with('success','PurchaseInvoice series has added successfully !');
    }
    public function edit($id)
    {
        $data['purchaseinvoice']=PurchaseInvoiceSeries::find($id);
        return view('admin.series.purchase-invoice.edit',$data);
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
        $purchaseinvoice=PurchaseInvoiceSeries::find($id);
        $purchaseinvoice->series_name=$request->series_name;
        $purchaseinvoice->request_type=$request->request_type;
        $purchaseinvoice->prefix_static_character=$_POST['prefix_static_character'];
        $purchaseinvoice->suffix_static_character=$_POST['suffix_static_character'];
        $purchaseinvoice->prefix=$request->prefix;
        $purchaseinvoice->suffix=$request->suffix;
        $purchaseinvoice->series_starting_digits=$request->series_starting_digits;
        $purchaseinvoice->series_current_digit=$request->series_starting_digits;
        $purchaseinvoice->save();
        return redirect('admin/series/purchaseinvoice')->with('success','PurchaseInvoice series has updated successfully !');
    }
    public function destroy($id)
    {
        $purchaseinvoice = PurchaseInvoiceSeries::find($id);
            if($purchaseinvoice)
            {
                $purchaseinvoice->delete();
                return redirect('admin/series/purchaseinvoice')->with('success','PurchaseInvoice series has deleted successfully !');
            }else{
                return redirect('admin/series/purchaseinvoice')->with('Error','Something has wrong');
            }
    }
    public function getdata(Request $request,$id)
    {
        /*$data=PurchaseInvoiceSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata=[
            'status'=>'false'
        ];
        $updatedata=PurchaseInvoiceSeries::where('id','!=',$id)->update($savedata);*/

        $data=PurchaseInvoiceSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata = [
            'status' =>'false',
        ];
        $updatedata=PurchaseInvoiceSeries::where('id','!=',$id)->update($savedata);
    }
}
