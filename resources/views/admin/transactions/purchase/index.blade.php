@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'transaction_purchase'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-header">Purchase</h3>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            @if(\Helper::userHasPageAccess('materials.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-blue">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-list"></i></h3>
                                            <p>Material Request</p>
                                        </div>

                                        <a href="{{ route('materials.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('purchase-order.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-green">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-shopping-cart"></i></h3>
                                            <p>Purchase Orders</p>
                                        </div>

                                        <a href="{{ route('purchase-order.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('purchase-receipt.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-yellow">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-print"></i></h3>
                                            <p>Purchase Reciepts</p>
                                        </div>

                                        <a href="{{ route('purchase-receipt.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('purchase-invoice.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-orange">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-file-import"></i></h3>
                                            <p>Purchase Invoice</p>
                                        </div>

                                        <a href="{{ route('purchase-invoice.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('purchase-return.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-undo"></i></h3>
                                            <p>Purchase Return</p>
                                        </div>

                                        <a href="{{ route('purchase-return.index') }}" class="small-box-footer">
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
