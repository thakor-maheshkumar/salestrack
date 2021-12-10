<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Materials;
use App\Models\MaterialStockItems;
use App\Models\InvetoryUnit;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Series;

class MaterialController extends CoreController
{

    protected static $material_type = [
        'Purchase' => 'Purchase'
    ];


    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->access_permissions = [
            'create' => 'Create',
            'edit' => 'Edit',
            'view' => 'View',
            /*'all' => 'All',
            'none' => 'None'*/
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function purchase()
    {
        return view('admin.transactions.purchase.index');

    }

    public function index()
    {
        $materials = Materials::with('purchase_order')->get();
        //$materialsStatus = Materials::with('purchase_order')->where('status','Ordered')->get();
        return view('admin.transactions.purchase.materials.index',['materials'=>$materials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seriesname=Series::all();
        //$stock_items_list = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
        //$stock_items = !empty($stock_items_list) ? $stock_items_list : array();
        $stock_items = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
        //$pack_code = \App\Models\StockItem::where('active',1)->pluck('pack_code','id')->toArray();
        $pack_code = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
        $materialseries=Series::where('status','true')->get();
        $series = 'MR-'.date('Ymdhis');
        return view('admin.transactions.purchase.materials.create',['permissions'=>$this->access_permissions,'stock_items'=>$stock_items,'pack_code'=>$pack_code,'material_type' => static::$material_type,'series'=>$series,'seriesname'=>$seriesname,'materialseries'=>$materialseries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialRequest $request)
    {

//        echo '<pre>';print_r($request->all());echo '</pre>';exit;
     $this->validate($request,[
            'series_id'=>'required|unique:materials,series_id'
        ]); 

        $material = Materials::create([

            'series_id' =>$request->series_id,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'type' => isset($request->type) ? $request->type : NULL,
            'po_status' => 0,
            'suffix'=>$request->suffix,
            'prefix'=>$request->prefix,
            'number'=>isset($request->number) ? $request->number : NULL,
            'series_type'=>isset($request->series_type) ? $request->series_type : NULL,
        ]);

        if(!empty($material))
        {
            if(isset($request->items) && !empty($request->items))
            {
                $stock_data = [];
                foreach ($request->items as $key => $items)
                {
                    //dd($items['item_code']);
                    $stock_item = \App\Models\StockItem::where(['id' => $items['item_code'], 'active' => 1])->select('id', 'name', 'pack_code')->first();
                    
                    if(isset($items['item_item_id']))
                    {

                        $stock_data[$items['item_item_id']] = (isset($stock_data[$items['item_item_id']]) && !empty($stock_data[$items['item_item_id']])) ? $stock_data[$items['item_item_id']] : [];

                        $stock_data[$items['item_item_id']] = [
                            'material_id' => $material->id,
                            'stock_item_id' => $items['item_item_id'],
                            'item_code' => isset($stock_item->pack_code) ? $stock_item->pack_code : '',
                            'uom' => $items['uom'],
                            'quantity' => (isset($stock_data[$items['item_item_id']]) && !empty($stock_data[$items['item_item_id']])) ? ($items['quantity'] + $stock_data[$items['item_item_id']]['quantity']) : $items['quantity']
                        ];
                        
                    }
                }

                if(!empty($stock_data) && count($stock_data) > 0)
                {
                    $material->material_items()->createMany($stock_data);
                }
            }
            $materialSeries=\App\Models\Series::where('status','true')->first();
           // dd($customerSeries);
            if($materialSeries)
                {
                $number = (int)$materialSeries->series_current_digit + 1;
                $materialseries=\App\Models\Series::find($materialSeries->id);
                $materialseries->series_current_digit=$number;
                $materialseries->save();
            }
        }
        if($material)
        {
            return redirect()->route('materials.index')->with('message', __('messages.add', ['name' => 'Material']));
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
            $seriesname=Series::all();
            $material = Materials::with('material_items')->find($id);
            
            $stock_items = \App\Models\StockItem::where('active',1)->pluck('name', 'id')->toArray();
//            $pack_code = \App\Models\StockItem::where('active',1)->pluck('pack_code','id')->toArray();
            $pack_code = \App\Models\StockItem::select('pack_code', 'name','id')->where('active',1)->get();
            $materialseries=Series::where('status','true')->get();
            if($material)
            {
                return view('admin.transactions.purchase.materials.edit',['material' => $material,'material_type' => static::$material_type, 'stock_items' => $stock_items,'pack_code'=>$pack_code,'seriesname'=>$seriesname,'materialseries'=>$materialseries]);
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
    public function update(MaterialRequest $request, $id)
    {
//        echo '<pre>';print_r($request->all());echo '</pre>';exit;
        $data = [
            'series_id' => $request->series_id,
            'required_date' => isset($request->required_date) ? $request->required_date : NULL,
            'type' => isset($request->type) ? $request->type : NULL,
        ];

        $material = Materials::find($id);

        if($material)
        {
            if ($material->update($data))
            {
                if(isset($request->items) && !empty($request->items))
                {
                    $stock_data = $keep_items = [];

                    foreach ($request->items as $key => $items)
                    {
                        $stock_item = \App\Models\StockItem::where(['id' => $items['item_code'], 'active' => 1])->select('id', 'name', 'pack_code')->first();
                        if(isset($items['item_item_id']))
                        {
                            $stock_data[$items['item_item_id']] = (isset($stock_data[$items['item_item_id']]) && !empty($stock_data[$items['item_item_id']])) ? $stock_data[$items['item_item_id']] : [];

                            $stock_data[$items['item_item_id']] = [
                                'material_id' => $material->id,
                                'stock_item_id' => $items['item_item_id'],
                                'item_code' => isset($stock_item->pack_code) ? $stock_item->pack_code : '',
                                'uom' => $items['uom'],
                                'quantity' => (isset($stock_data[$items['item_item_id']]) && !empty($stock_data[$items['item_item_id']])) ? ($items['quantity'] + $stock_data[$items['item_item_id']]['quantity']) : $items['quantity']
                            ];
                        }
                    }

                    if(!empty($stock_data))
                    {
                        $keep_items = array_keys($stock_data);

                        foreach ($stock_data as $key => $value) {
                            MaterialStockItems::updateOrCreate([
                                'material_id' => $material->id,
                                'stock_item_id' => $value['stock_item_id']
                            ], $value);
                        }

                        MaterialStockItems::where('material_id', $material->id)->whereNotIn('stock_item_id', $keep_items)->delete();
                    }
                }

                return redirect()->route('materials.index')->with('message', __('messages.update', ['name' => 'Material']));
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
        $material = Materials::find($id);

        if ($material)
        {
            $material->delete();

            return redirect()->route('materials.index')->with('message', __('messages.delete', ['name' => 'Material']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }
    public function getUnitFronItemId($item_id)
    {
        //echo $item_id;exit;
        //$stock_items = \App\Models\StockItem::where('id',$item_id)->get();
        $stock_items = \App\Models\StockItem::with(['InventoryUnit'])->where('id',$item_id)->first();
        $data = array('unit'=>$stock_items->InventoryUnit->name);
        echo json_encode($data);exit;
    }

    function getStockdetailsById(Request $request, $id)
    {
        if ($request->ajax())
        {
            $stock_item = \App\Models\StockItem::where(['id' => $id, 'active' => 1])->with(['unit', 'alternate_unit'])->select('id', 'name', 'unit_id', 'alternate_unit_id','pack_code')->first();

            return response()->json([
                'success' => true,
                'data' => $stock_item,
            ]);
        }
    }

    function getStockdetailsByPackcode(Request $request, $pack_code)
    {
        if ($request->ajax())
        {
            $stock_item = \App\Models\StockItem::where(['pack_code' => $pack_code, 'active' => 1])->with(['unit', 'alternate_unit'])->select('id', 'name', 'unit_id', 'alternate_unit_id','pack_code')->first();

            $stock_items = [];
            if (!empty($stock_item))
            {
                $stock_items[$stock_item->id] = isset($stock_item->name) ? $stock_item->name : '';
            }
            $unit = isset($stock_item->unit->name) ? $stock_item->unit->name : '';

            return response()->json([
                'success' => true,
                'stock_items' => $stock_items,
                'unit' => $unit
            ]);
        }
    }
    public function getdata(Request $request,$id)
    {
        $data=Series::where('id',$id)->first();

        return response()->json($data);
    }
    public function testdata(Request $request)
    {
        
        $data=Series::all();

        return json_encode(array('data'=>$data));
    }
}
