@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'transaction_sales'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Sales</h3>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            @if(\Helper::userHasPageAccess('quotation.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-blue">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-quote-right"></i></h3>
                                            <p>Quotation</p>
                                        </div>

                                        <a href="{{ route('quotation.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('sales-order.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-green">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-list"></i></h3>
                                            <p>Sales Orders</p>
                                        </div>

                                        <a href="{{ route('sales-order.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('delivery-note.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-yellow">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-list"></i></h3>
                                            <p>Delivery Note</p>
                                        </div>

                                        <a href="{{ route('delivery-note.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('sales-invoice.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-print"></i></h3>
                                            <p>Sales Invoice</p>
                                        </div>

                                        <a href="{{ route('sales-invoice.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('sales-return.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-undo"></i></h3>
                                            <p>Sales Return</p>
                                        </div>

                                        <a href="{{ route('sales-return.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
