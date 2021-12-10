<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRecieptSeries;
class PurchaseRecieptSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['purchaserecieptseries']=PurchaseRecieptSeries::all();
        return view('admin.series.purchase-receipt.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.series.purchase-receipt.create');
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
            'prefix_static_character'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_character'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $purchaserecipt=new PurchaseRecieptSeries;
        $purchaserecipt->series_name=$request->series_name;
        $purchaserecipt->request_type=$request->request_type;
        $purchaserecipt->prefix=$request->prefix;
        $purchaserecipt->suffix=$request->suffix;
        $purchaserecipt->prefix_static_character=$_POST['prefix_static_character'];
        $purchaserecipt->suffix_static_character=$_POST['suffix_static_character'];
        $purchaserecipt->series_starting_digits=$request->series_starting_digits;
        $purchaserecipt->series_current_digit=$request->series_starting_digits;
        $purchaserecipt->save();
        return redirect('admin/series/purchasereciept')->with('success','Purchase reciept series added successfully');
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
        $data['purchasereceipt']=PurchaseRecieptSeries::find($id);
        return view('admin.series.purchase-receipt.edit',$data);
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
            'prefix_static_character'=> 'required_with:prefix,on',
            'suffix' => 'sometimes',
            'suffix_static_character'=> 'required_with:suffix,on',
        ]); 
        }
        $validated = $request->validate([
            'series_name' => 'required',
            'request_type'=>'required',
        ]);
        $series=PurchaseRecieptSeries::find($id);
        $series->series_name=$request->series_name;
        $series->request_type=$request->request_type;
        $series->prefix_static_character=$_POST['prefix_static_character'];
        $series->suffix_static_character=$_POST['suffix_static_character'];
        $series->prefix=$request->prefix;
        $series->suffix=$request->suffix;
        $series->series_starting_digits=$request->series_starting_digits;
        $series->series_current_digit=$request->series_starting_digits;
        $series->save();
        return redirect('admin/series/purchasereciept')->with('success','Series name has updated successfully');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $series = PurchaseRecieptSeries::find($id);
            if($series)
            {
                $series->delete();
                return redirect('admin/series/purchasereciept')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/purchasereciept')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $purchasereceiptseries=PurchaseRecieptSeries::where('id',$id)->first();
        $purchasereceiptseries->status='true';
        $purchasereceiptseries->save();
        $savedata=[
            'status'=>'false'
        ];
        $purchasereceiptupdate=PurchaseRecieptSeries::where('id','!=',$id)->update($savedata); 
    }
}
