<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\Grades;
use App\Models\Qc;
use App\Models\QcTests;

class QcController extends CoreController
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
    public function index()
    {
        $qc = Qc::all();
        return view('admin.qc-tests.index',['qc'=>$qc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock_items_list = StockItem::where('active',1)->pluck('name', 'id')->toArray();
        $stock_items = !empty($stock_items_list) ? $stock_items_list : array();
        $grades = Grades::where('active', 1)->pluck('grade_name', 'id')->toArray();

        return view('admin.qc-tests.create',['stock_items'=>$stock_items,'grades'=>$grades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'casr_no' => [
                'required',
                'regex:/^[\d]{2,7}-[\d]{2}-[\d]{1}$/',
            ]
        ];

        $this->validate($request, $rules);

        $qc = Qc::create([
            'stock_item_id' => $request->stock_item_id,
            'grade_id' => $request->grade_id,
            'casr_no' => $request->casr_no,
            'molecular_formula' => $request->molecular_formula,
            'molecular_weight' => $request->molecular_weight    ,
            'spec_no' => $request->spec_no,
            'characters' => $request->characters,
            'storage_condition' => $request->storage_condition,
            'remarks' => $request->remarks
        ]);

        if($qc)
        {
            if(isset($request->qc_tests) && !empty($request->qc_tests))
            {
                $qc_tests = $final_data = [];
                foreach ($request->qc_tests as $key => $tests)
                {
                    if(isset($tests['tests']))
                    {   
                        $qc_tests = [
                            'qc_id' => $qc->id,
                            'tests' => $tests['tests'],
                            'acceptance_criteria' => $tests['acceptance_criteria'],
                        ];
                        $final_data[] = $qc_tests;
                    }
                }
                QcTests::insert($final_data);
            }

            return redirect()->route('qc-tests.index')->with('message', __('messages.add', ['name' => 'QC Test']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
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
        if($id)
        {
            $item = Qc::find($id);

            if($item)
            {
                $stock_items = StockItem::where('active', 1)->pluck('name', 'id')->toArray();
                $grades = Grades::where('active', 1)->pluck('grade_name', 'id')->toArray();
                
                return view('admin.qc-tests.edit', ['item' => $item,'stock_items'=>$stock_items,'grades'=>$grades]);
            }
        }

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
        $item = Qc::find($id);

        $qc_data = [
            'stock_item_id' => $request->stock_item_id,
            'grade_id' => $request->grade_id,
            'casr_no' => $request->casr_no,
            'molecular_formula' => $request->molecular_formula,
            'molecular_weight' => $request->molecular_weight    ,
            'spec_no' => $request->spec_no,
            'characters' => $request->characters,
            'storage_condition' => $request->storage_condition,
            'remarks' => $request->remarks,
        ];

        if ($item->update($qc_data))
        {
            if(isset($request->qc_tests) && !empty($request->qc_tests))
            {
                QcTests::where('qc_id',$id)->update(['active' => '0']);
                $qc_tests = $final_data = [];
                foreach ($request->qc_tests as $key => $tests)
                {
                    $qc_tests = [
                        'qc_id' => $id,
                        'tests' => $tests['tests'],
                        'acceptance_criteria' => $tests['acceptance_criteria'],
                        'active'=>1
                    ];
                    if(isset($tests['qc_test_id']) && !empty($tests['qc_test_id']))
                    {
                        QcTests::where('id', $tests['qc_test_id'])->update($qc_tests);
                    }else{
                        QcTests::insert($qc_tests);
                    }
                }
            }

            return redirect()->route('qc-tests.index')->with('message', __('messages.update', ['name' => 'QC Test']));
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
        $qc = Qc::with('qc_items')->find($id);

        if ($qc)
        {
            $qc_tests = QcTests::where('qc_id',$qc->id)->delete();

            $qc->delete();

            return redirect()->route('qc-tests.index')->with('message', __('messages.delete', ['name' => 'QC']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
}
