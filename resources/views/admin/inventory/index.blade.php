@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'master_inventory'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-24">
                                <h2 class="mb-0">Inventory</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            @if(\Helper::userHasPageAccess('stock-items.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-blue">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-shopping-cart"></i></h3>
                                            <p>Stock Item</p>
                                        </div>

                                        <a href="{{ route('stock-items.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('stock-groups.index'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-green">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-th-large"></i></h3>
                                            <p>Stock Group</p>
                                        </div>

                                        <a href="{{ route('stock-groups.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('units.index'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-film"></i></h3>
                                            <p>Unit</p>
                                        </div>

                                        <a href="{{ route('units.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('stock-categories.index'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-purple">
                                        <div class="inner text-center">
                                            <h3> <i class="fab fa-dribbble"></i></h3>
                                            <p>Stock Categories</p>
                                        </div>

                                        <a href="{{ route('stock-categories.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('bom.index'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-secondary">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-th-large"></i></h3>
                                            <p>BOM</p>
                                        </div>

                                        <a href="{{ route('bom.index') }}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('batches.index'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-red">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-tasks"></i></h3>
                                            <p>Batches</p>
                                        </div>

                                        <a href="{{ route('batches.index') }}" class="small-box-footer">
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
