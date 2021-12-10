<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Terretory;
use App\Http\Requests\Admin\TerretoryRequest;



class TerretoryController extends CoreController
{
    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    function index()
    {
        $terretories = Terretory::all();

        return view('admin.settings.terretory.index', ['terretories' => $terretories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $terretories = Terretory::where('active', 1)->pluck('terretory_name', 'id')->toArray();

        return view('admin.settings.terretory.create', ['terretories' => $terretories]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerretoryRequest $request)
    {
        $result = Terretory::create([
            'terretory_name' => $request->terretory_name,
            'under' => $request->under,
        ]);

        if($result)
        {
            return redirect()->route('terretory.index')->with('message', __('messages.add', ['name' => 'Terretory']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id)
        {
            $terretories = Terretory::find($id);
            if($terretories)
            {
                $terretory = Terretory::where('active', 1)->where('id', '!=', $id)->pluck('terretory_name', 'id')->toArray();
                return view('admin.settings.terretory.edit', ['terretories' => $terretory,'terretory' => $terretories]);
            }
        }

        abort(404);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TerretoryRequest $request, $id)
    {
        $data = [
            'terretory_name' => $request->terretory_name,
            'under' => $request->under,
        ];

        $group = Terretory::find($id);

        if($group)
        {
            if ($group->update($data))
            {
                return redirect()->route('terretory.index')->with('message', __('messages.update', ['name' => 'Terretory']));
            }
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Terretory::find($id);

        if ($group)
        {
            $data = [
                'location' => 0,
            ];

            $general_ledgers = \App\Models\GeneralLedger::where('location', '=', $id);
            if($general_ledgers)
            {
               $general_ledgers->update($data);
            }
            $sales_ledgers = \App\Models\SalesLedger::where('location', '=', $id);
            if($sales_ledgers)
            {
               $sales_ledgers->update($data);
            }
            $PurchaseLedger = \App\Models\PurchaseLedger::where('location', '=', $id);
            if($PurchaseLedger)
            {
               $PurchaseLedger->update($data);
            }

            $group->delete();

            return redirect()->route('terretory.index')->with('message', __('messages.delete', ['name' => 'Terretory']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

}