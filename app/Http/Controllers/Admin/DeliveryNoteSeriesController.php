<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryNoteSeries;

class DeliveryNoteSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['deliverynoteseries']=DeliveryNoteSeries::latest()->get();
        return view('admin.series.delivery-note.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.series.delivery-note.create');
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
        $deliveryNote=new DeliveryNoteSeries;
        $deliveryNote->series_name=$request->series_name;
        $deliveryNote->request_type=$request->request_type;
        $deliveryNote->prefix=$request->prefix;
        $deliveryNote->suffix=$request->suffix;
        $deliveryNote->prefix_static_character=$_POST['prefix_static_character'];
        $deliveryNote->suffix_static_character=$_POST['suffix_static_character'];
        $deliveryNote->series_starting_digits=$request->series_starting_digits;
        $deliveryNote->series_current_digit=$request->series_starting_digits;
        $deliveryNote->save();
        return redirect('admin/series/deliveryseries')->with('success','Delivery Note series added successfully');
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
        $data['deliveryseries']=DeliveryNoteSeries::find($id);
        return view('admin.series.delivery-note.edit',$data);
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
        $series=DeliveryNoteSeries::find($id);
        $series->series_name=$request->series_name;
        $series->request_type=$request->request_type;
        $series->prefix_static_character=$_POST['prefix_static_character'];
        $series->suffix_static_character=$_POST['suffix_static_character'];
        $series->prefix=$request->prefix;
        $series->suffix=$request->suffix;
        $series->series_starting_digits=$request->series_starting_digits;
        $series->save();
        return redirect('admin/series/deliveryseries')->with('success','Delivery Note series has updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $series = DeliveryNoteSeries::find($id);
            if($series)
            {
                $series->delete();
                return redirect('admin/series/deliveryseries')->with('success','Series name has deleted successfully');
            }else{
                return redirect('admin/series/deliveryseries')->with('Error','Something has wrong');
            }
    }
    public function getdata($id)
    {
        $data=DeliveryNoteSeries::where('id',$id)->first();
        $data->status='true';
        $data->save();

        $savedata=[
            'status'=>'false'
        ];

        $updatedata=DeliveryNoteSeries::where('id','!=',$id)->update($savedata);
    }
}
