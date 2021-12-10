@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'settings'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="row p-3">
                            <div class=" col-lg-6 col-6 {{ (\Helper::userHasPageAccess('terretory.index')) ? '' : 'not-access' }}">
                                <div class="small-box bg-blue">
                                    <div class="inner text-center">
                                        <h3> <i class="fas fa-shopping-cart"></i></h3>
                                        <p>Terretories</p>
                                    </div>

                                    <a href="{{ route('terretory.index') }}" class="small-box-footer">
                                    More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class=" col-lg-6 col-6 {{ (\Helper::userHasPageAccess('grades.index')) ? '' : 'not-access' }}">
                                <div class="small-box bg-green">
                                    <div class="inner text-center">
                                        <h3> <i class="fas fa-list"></i></h3>
                                        <p>Grades</p>
                                    </div>

                                    <a href="{{ route('grades.index') }}" class="small-box-footer">
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
