@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'test'
])
@section('content')
    <div class="content">
        
                <h1 class="heading">Series</h1>
                    <div class="list-group">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('series.index') }}" class="list-group-item list-group-item-action">Material Request</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="list-group-item list-group-item-action">Sales Order</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="list-group-item list-group-item-action">Sales Invoice</a>
                            </div>
                        </div>
                        
                    </div>
           
    </div>
@endsection