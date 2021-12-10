<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class DashboardController extends CoreController
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
        return view('admin.dashboard.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf1()
    {
        $pdf = \PDF::loadView('admin.dashboard.pdf1');
        // $pdf->setOptions(['isPhpEnabled' => true]);

        //return view('admin.dashboard.pdf1');

        /*$pdf->setPaper('a4', 'landscape');*/
        //return $pdf->stream();
        $pdf_name = time() . '.pdf';
        return $pdf->download($pdf_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf2()
    {
        $pdf = \PDF::loadView('admin.dashboard.pdf2');
        // $pdf->setOptions(['isPhpEnabled' => true]);

        // return view('admin.dashboard.pdf2');

        /*$pdf->setPaper('a4', 'landscape');*/
        //return $pdf->stream();
        $pdf_name = time() . '.pdf';
        return $pdf->download($pdf_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
