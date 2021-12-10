<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\CoreController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderSeries;

class PurchaseorderseriesController extends CoreController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('admin.series.purchase-order.index');
        $data['purchaseorderseries']=PurchaseOrderSeries::orderByDesc('id')->get();
        return view('admin.series.purchaseorders.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.series.purchaseorders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->request_type=='automatic'){
           $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
            'series_starting_digits'=>'required|max:10',
            'prefix' => 'sometimes',
            'prefix_static_charcter'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_charcter'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $series=new PurchaseOrderSeries;
        
        $series->series_name=$request->series_name;
        $series->request_type=$request->request_type;
        $series->prefix_static_charcter=$_POST['prefix_static_charcter'];
        $series->suffix_static_charcter=$_POST['suffix_static_charcter'];
        $series->prefix=$request->prefix;
        $series->suffix=$request->suffix;
        $series->series_starting_digits=$request->series_starting_digits;
        $series->series_current_digit=$request->series_starting_digits;
        $series->save();
        return redirect('admin/series/purchaseorder')->with('success','Purchaseorder series has added successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['purchaseorderseries']=PurchaseOrderSeries::find($id);
        return view('admin.series.purchaseorders.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->request_type=='automatic'){
           $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
            'series_starting_digits'=>'required|max:10',
             'prefix' => 'sometimes',
            'prefix_static_charcter'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_charcter'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $series=PurchaseOrderSeries::find($id);
        $series->series_name=$request->series_name;
        $series->request_type=$request->request_type;
        $series->prefix_static_charcter=$_POST['prefix_static_charcter'];
        $series->suffix_static_charcter=$_POST['suffix_static_charcter'];
        $series->prefix=$request->prefix;
        $series->suffix=$request->suffix;
        $series->series_starting_digits=$request->series_starting_digits;
        $series->series_current_digit=$request->series_starting_digits;
        $series->save();
        return redirect('admin/series/purchaseorder')->with('success','Purchaseorder series has updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $series = PurchaseOrderSeries::find($id);
            if($series)
            {
                $series->delete();
                return redirect('admin/series/purchaseorder')->with('success','Purchaseorder series has deleted successfully !');
            }else{
                return redirect('admin/series/purchaseorder')->with('Error','Something has wrong');
            }
    }
    public function getdata(Request $request,$id)
    {
        
       $data=PurchaseOrderSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();
        $savedata = [
            'status' =>'false',
        ];
        $updatedata=PurchaseOrderSeries::where('id','!=',$id)->update($savedata);
    }
}
