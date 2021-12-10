@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'ledgers'
])
@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-sm-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">Ledgers</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            <div class=" col-lg-6 col-6">
                                <div class="small-box bg-pink">
                                    <div class="inner text-center">
                                        <h3> <i class="fas fa-users"></i></h3>
                                        <p>Sales</p>
                                    </div>

                                    <a href="{{route('sales.index')}}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner text-center">
                                        <h3> <i class="fas fa-film"></i></h3>
                                        <p>Purchase</p>
                                    </div>

                                    <a href="{{route('purchase.index')}}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner text-center">
                                        <h3> <i class="fas fa-film"></i></h3>
                                        <p>General</p>
                                    </div>

                                    <a href="{{route('general.index')}}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
