<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Http\Requests\Admin\PurchaseOrderRequest;
use App\Models\ConsigneeAddress;
use App\Models\Warehouse;
use App\Models\PurchaseLedger;
use App\Models\User;
use App\Models\StockItem;
use App\Models\PurchaseReceiptItems;
use App\Models\PurchaseReceipt;
use App\Models\StockItemGrades;
use App\Models\Qc;
use App\Models\Batch;
use App\Models\QcReports;
use App\Models\QcTestReports;
use App\Models\QcTests;
use App\Models\WorkOrders;
use App\Models\WorkorderQcReport;
use App\Models\QcWorkorderTestReport;

class QcReportController extends CoreController
{
    protected static $material_type = [
        'QC' => 'QC'
    ];

    public $other;
    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->other = (Object) [
            'title' => 'Order',
            'route_name' => 'purchase',
            'back_link' => route('transactions.purchase'),
            'add_link' => route('purchase-order.create'),
            'add_link_route' => 'purchase-order.create',
            'store_link' => 'purchase-order.store',
            'edit_link' => 'purchase-order.edit',
            'update_link' => 'purchase-order.update',
            'delete_link' => 'purchase-order.destroy',
            'listing_link' => 'purchase-order.index',
            'order_type' => 1,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $items = PurchaseReceipt::where('active',1)->orderBy('id', 'desc')->get();

        $work_orders = WorkOrders::where('active',1)->orderBy('id', 'desc')->get();

        return view('admin.transactions.purchase.qc-report.index',['other' => $this->other,'items' => $items, 'work_orders' => $work_orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add($receipt_id,$stock_item_id)
    {
        if($receipt_id)
        {
            $receipt_details = PurchaseReceipt::find($receipt_id);
            $qc_tests  = Qc::with('qc_items')->where('stock_item_id',$stock_item_id)->first();
            $stock_details  = StockItem::find($stock_item_id);

            $batch  = Batch::where('stock_item_id',$stock_item_id)->pluck('batch_id','id')->toArray();
            $qc_reports = QcReports::where('purchase_receipt_id',$receipt_id)->get();
            if(count($qc_reports) > 0)
            {
                $grades=[];
                foreach($qc_reports as $q)
                {
                    $grades[] = $q->grade_id;
                }
                $stock_grade = Qc::with('grades')->whereNotIn('grade_id',$grades)->where('stock_item_id',$stock_item_id)->get();
            }else{
                $stock_grade = Qc::with('grades')->where('stock_item_id',$stock_item_id)->get();
            }

            //echo '<pre>';print_r($stock_grade);exit;
            return view('admin.transactions.purchase.qc-report.create',['batch'=>$batch,'stock_grade' => $stock_grade,'item' => $receipt_details,'qc_tests'=>$qc_tests,'stock_details'=>$stock_details]);
        }
        abort(404);
    }

    public function insert(PurchaseOrderRequest $request)
    {
        $qc_report = QcReports::create([
            'purchase_receipt_id' => $request->purchase_receipt_id,
            'grade_id' => $request->grade_id,
            'batch_id'=> $request->batch_id,
            'qc_id'=> $request->qc_id,
            'stock_item_id'=> $request->stock_item_id,
            'receipt_no'=> $request->receipt_no,
            'product_name'=> $request->product_name,
            'ar_no'=> $request->ar_no,
            'reset_date'=> $request->retest_date,
            'remarks'=> $request->remarks,
        ]);

        if($qc_report)
        {
            if(isset($request->qc_tests) && !empty($request->qc_tests))
            {
                $item_data = [];
                foreach ($request->qc_tests as $key => $items)
                {
                    if(isset($items['test_result']))
                    {
                        $item_data[] = [
                            'qc_report_id' => $qc_report->id,
                            'qc_test_id' => $items['qc_test_id'],
                            'test_result' => $items['test_result'],
                            'remarks' => $items['remarks'],
                        ];
                    }
                }
                if(!empty($item_data) && count($item_data) > 0)
                {
                    QcTestReports::insert($item_data);
                }
            }
            PurchaseReceipt::where('id', '=', $request->purchase_receipt_id)
            ->update(['qc_status' => 1]);

            return redirect()->route('qc-report.index')->with('message', __('messages.add', ['name' => 'QC Test']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    public function reports($id)
    {
        $qc_reports = QcReports::with('grades')->where('active',1)->get();
        //echo '<pre>';print_r($qc_reports);exit;
        return view('admin.transactions.purchase.qc-report.reports',['other' => $this->other,'items' => $qc_reports]);
    }

    function getBatchDetails(Request $request)
    {
        $batch_id = $request->batch_id;
        $batch_details = Batch::find($batch_id);
        return response()->json(['batch'=>$batch_details]);
    }

    function getDetailsFromGrade(Request $request)
    {
        $grade_id = $request->grade_id;
        $qc_test = QC::with('qc_items')->where('grade_id',$grade_id)->first();
        $returnHTML = view('admin.transactions.purchase.qc-report.qc_tests', ['qc_tests' => $qc_test])->render();

        return response()->json(['qc_tests'=> $returnHTML]);
        //return response()->json(['qc_test'=>$qc_test]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id)
        {
            $item = PurchaseReceipt::with('purchase_items','batch')->find($id);
            $warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            $batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            $qc_reports = QcReports::with('grades')->where('active',1)->where('purchase_receipt_id',$id)->get();
            return view('admin.transactions.purchase.qc-report.show',
                [
                    'other' => $this->other,
                    'item' => $item,
                    'reports'=>$qc_reports,
                    'warehouses'=>$warehouses,
                    'batches'=>$batches
                ]);
        }
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWorkOrders($id)
    {
        if($id)
        {
            $workOrder = WorkOrders::with(['plan', 'plan.stockItems'])->find($id);

            //$item = PurchaseReceipt::with('purchase_items','batch')->find($id);
            //$warehouses = Warehouse::where('active', 1)->pluck('name', 'id')->toArray();
            //$batches = Batch::where('active', 1)->pluck('batch_id', 'id')->toArray();
            $qc_reports = WorkorderQcReport::with('grades')->where('active',1)->where('id',$id)->get();

            return view('admin.transactions.purchase.workorder-qc-report.show',
                [
                    'other' => $this->other,
                    'workOrder' => $workOrder,
                    'reports'=>$qc_reports
                ]);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addWorkOrdersQc($work_order_id,$stock_item_id)
    {
        if($work_order_id)
        {
            $workOrder = WorkOrders::find($work_order_id);
            $qc_tests  = Qc::with('qc_items')->where('stock_item_id',$stock_item_id)->first();
            $stock_details  = StockItem::find($stock_item_id);
            $plans = \App\Models\ProductionPlan::where('active', 1)->pluck('plan_id', 'id')->toArray();

            //$batch  = Batch::where('stock_item_id',$stock_item_id)->pluck('batch_id','id')->toArray();
            $qc_reports = WorkorderQcReport::where('work_order_id',$work_order_id)->get();

            if(count($qc_reports) > 0)
            {
                $grades=[];
                foreach($qc_reports as $q)
                {
                    $grades[] = $q->grade_id;
                }
                $stock_grade = Qc::with('grades')->whereNotIn('grade_id',$grades)->where('stock_item_id',$stock_item_id)->get();
            }else{
                $stock_grade = Qc::with('grades')->where('stock_item_id',$stock_item_id)->get();
            }

            return view('admin.transactions.purchase.workorder-qc-report.create',['stock_grade' => $stock_grade,'item' => $workOrder,'qc_tests'=>$qc_tests,'stock_details'=>$stock_details, 'plans' => $plans]);
        }
        abort(404);
    }

    public function insertWorkOrdersQc(Request $request)
    {
        $qc_report = WorkorderQcReport::create([
            'work_order_id' => $request->work_order_id,
            'grade_id' => $request->grade_id,
            'plan_id'=> $request->plan_id,
            'qc_id'=> $request->qc_id,
            'stock_item_id'=> $request->stock_item_id,
            /*'receipt_no'=> $request->receipt_no,*/
            'product_name'=> $request->product_name,
            'ar_no'=> $request->ar_no,
            'reset_date'=> $request->retest_date,
            'remarks'=> $request->remarks,
        ]);

        if($qc_report)
        {
            if(isset($request->qc_tests) && !empty($request->qc_tests))
            {
                $item_data = [];
                foreach ($request->qc_tests as $key => $items)
                {
                    if(isset($items['test_result']))
                    {
                        $item_data[] = [
                            'qc_report_id' => $qc_report->id,
                            'qc_test_id' => $items['qc_test_id'],
                            'test_result' => $items['test_result'],
                            'remarks' => $items['remarks'],
                        ];
                    }
                }
                if(!empty($item_data) && count($item_data) > 0)
                {
                    QcWorkorderTestReport::insert($item_data);
                }
            }
            WorkOrders::where('work_order_id', '=', $request->work_order_id)->update(['qc_status' => 1]);

            return redirect()->route('qc-report.index')->with('message', __('messages.add', ['name' => 'QC Test']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyWorkOrderQc($id)
    {
        $qc_report = WorkorderQcReport::find($id);

        if ($qc_report)
        {
            $qc_test_report = QcWorkorderTestReport::where('qc_report_id',$id)->delete();

            $qc_report->delete();

            return redirect()->route('qc-report.index')->with('message', __('messages.delete', ['name' => 'QC Test']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function viewWorkOrderQc($qc_report_id)
    {
        if($qc_report_id)
        {
            $item = WorkorderQcReport::with('grades')->find($qc_report_id);

            $work_order_id = $item->work_order_id;
            $work_order_item = WorkOrders::where('work_order_id', $work_order_id)->first();
            $qc_tests  = Qc::with('qc_items')->where('stock_item_id',$item->stock_item_id)->first();
            $stock_details  = StockItem::find($item->stock_item_id);
            $qc_test_results = QcWorkorderTestReport::where('qc_report_id',$qc_report_id)->get();

            return view('admin.transactions.purchase.workorder-qc-report.view',
            [
                'item' => $item,
                'work_order_item'=>$work_order_item,
                'qc_tests' => $qc_tests,
                'stock_details' => $stock_details,
                'qc_test_results' => $qc_test_results
            ]);
        }
        abort(404);
    }

    function reset_purchase_receipt_basic_info(Request $request,$purchase_receipt_id)
    {
        if($purchase_receipt_id)
        {
            $data = [
                'warehouse_id'=>$request->warehouse_id,
                'batch_id'=>$request->batch_id,
            ];
            $pr = PurchaseReceipt::find($purchase_receipt_id);
            if($pr)
            {
                $pr->update($data);
            }



            $qc_pr = QcReports::where('purchase_receipt_id',$purchase_receipt_id)->get();
            if($qc_pr)
            {
                QcReports::where('purchase_receipt_id', '=', $purchase_receipt_id)
                ->update(['warehouse_id' => $request->warehouse_id,'batch_id'=>$request->batch_id]);
            }
            return redirect()->route('qc-report.show',$purchase_receipt_id)->with('message', __('messages.add', ['name' => 'Purchase Receipt']));
        }else{
            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }
        abort(404);
    }

    function view($qc_report_id)
    {
        if($qc_report_id)
        {
            $item = QcReports::with('grades')->find($qc_report_id);
            $purchase_receipt_id = $item->purchase_receipt_id;
            $receipt_item = PurchaseReceipt::with('purchase_items')->find($purchase_receipt_id);
            $qc_tests  = Qc::with('qc_items')->where('stock_item_id',$item->stock_item_id)->first();
            $stock_details  = StockItem::find($item->stock_item_id);
            $batch  = Batch::find($item->batch_id);
            $qc_test_results = QcTestReports::where('qc_report_id',$qc_report_id)->get();
            //echo '<pre>';print_r($qc_test_results);echo '</pre>';exit;
            return view('admin.transactions.purchase.qc-report.view',
            [
                'item' => $item,
                'receipt_item'=>$receipt_item,
                'qc_tests' => $qc_tests,
                'stock_details' => $stock_details,
                'qc_test_results' => $qc_test_results,
                'batch' => $batch,
            ]);
        }
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qc_report = QcReports::find($id);

        if ($qc_report)
        {
            $qc_test_report = QcTestReports::where('qc_report_id',$id)->delete();

            $qc_report->delete();

            return redirect()->route('qc-report.index')->with('message', __('messages.delete', ['name' => 'QC Test']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    function GetStockDetails(Request $request)
    {
        //$input = $request->all();
        $stock_item_id = $request->stock_item_id;
        $stock_details = StockItem::find($stock_item_id);
        $unit = $stock_details->InventoryUnit->name;
        $tax=$cess=0;
        if($stock_details->is_gst_detail==1){
            if($stock_details->taxability == 'taxable'){
              $tax =  !empty($stock_details->rate) ?  $stock_details->rate : 0;
              $cess = !empty($stock_details->rate) ?  $stock_details->cess : 0;
            }
        }
        return response()->json(['stock_details'=>$stock_details,'unit'=>$unit,'tax'=>$tax,'cess'=>$cess]);
        //print_r($input);
    }

    function getSupplierDetails(Request $request)
    {
        //$input = $request->all();
        $supplier_id = $request->supplier_id;
        $supplier_details = PurchaseLedger::find($supplier_id);
        return response()->json(['supplier_details'=>$supplier_details]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print($qc_report_id)
    {
        if($qc_report_id)
        {
            $qc_report = QcReports::with(['grades','qc','batch','qc_test_reports','purchase_receipt'])->find($qc_report_id);

            $pdf = \PDF::loadView('admin.transactions.purchase.qc-report.print', ['qc_report' => $qc_report]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printWorkOrder($qc_report_id)
    {
        if($qc_report_id)
        {
            $qc_report = WorkorderQcReport::with(['grades','qc','workOrder','qc_workorder_test_reports'])->find($qc_report_id);

            $pdf = \PDF::loadView('admin.transactions.purchase.workorder-qc-report.print', ['qc_report' => $qc_report]);
            // $pdf->setOptions(['isPhpEnabled' => true]);

            //return $pdf->stream();
            $pdf_name = time() . '.pdf';
            return $pdf->download($pdf_name);
        }

        abort(404);
    }
}
