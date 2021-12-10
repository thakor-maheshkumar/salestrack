@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'account_groups'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">Accounts</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            @if(\Helper::userHasPageAccess('groups.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-pink">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-users"></i></h3>
                                            <p>Account Groups</p>
                                        </div>

                                        <a href="{{route('groups.index')}}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('masters.ledger'))
                                <div class="col-lg-6 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-film"></i></h3>
                                            <p>Ledgers</p>
                                        </div>

                                        <a href="{{route('masters.ledger')}}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('customer-groups.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-green">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-users"></i></h3>
                                            <p>Customer Groups</p>
                                        </div>

                                        <a href="{{route('customer-groups.index')}}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(\Helper::userHasPageAccess('supplier-groups.index'))
                                <div class=" col-lg-6 col-6">
                                    <div class="small-box bg-purple">
                                        <div class="inner text-center">
                                            <h3> <i class="fas fa-users"></i></h3>
                                            <p>Supplier Groups</p>
                                        </div>

                                        <a href="{{route('supplier-groups.index')}}" class="small-box-footer">
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
