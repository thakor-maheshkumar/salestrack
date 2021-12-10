@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'test'
])
@section('content')
    <div class="content">
        
                <h3 class="heading">Purchase Series</h3>
                    <div class="list-group">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('material.index') }}" class="list-group-item list-group-item-action">Material Request</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('purchaseorder.index')}}" class="list-group-item list-group-item-action">Purchase Order</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('purchasereciept.index')}}" class="list-group-item list-group-item-action">Purchase Reciepts</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('purchaseinvoice.index')}}" class="list-group-item list-group-item-action">Purchase Invoice</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('purchasereturn.index')}}" class="list-group-item list-group-item-action">Purchase Return</a>
                            </div>
                        </div>
                         <br>
                        <h3>Sales Series</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('quotation-series.index') }}" class="list-group-item list-group-item-action">Quatation</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('salesorder.index') }}" class="list-group-item list-group-item-action">Sales Order</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('deliveryseries.index') }}" class="list-group-item list-group-item-action">Delivery Note</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('salesinvoice.index') }}" class="list-group-item list-group-item-action">Sales Invoice</a>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('salesreturn.index') }}" class="list-group-item list-group-item-action">Sales Return</a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('stocktransfer.index') }}" class="list-group-item list-group-item-action">Stock Transfer</a>
                            </div>
                        </div>
                        <br>
                        <h3>Manufacturing Series</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('productionplan.index') }}" class="list-group-item list-group-item-action">Production Plan</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('workorder.index') }}" class="list-group-item list-group-item-action">WorkOrder</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('customer.index')}}" class="list-group-item list-group-item-action">Customer </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('supplier.index')}}" class="list-group-item list-group-item-action">Supplier </a>
                            </div>
                        </div>
                        
                    </div>
           
    </div>
@endsection