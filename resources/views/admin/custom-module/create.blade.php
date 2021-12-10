@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => ''
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Add {{ $module->name }}</h3>
                    </div>
                    <div class="card-body">
                        @include('common.messages')
                        @include('common.errors')

                        <div class="error text-danger"></div>

                        {!! Form::open([
                                'route' => ['custom-module.store', $module->slug],
                                'method' => 'POST',
                                'name' => 'add_custom_module_form',
                                'id' => 'add_custom_module_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($moduleColumns) && !empty($moduleColumns))
                                        @foreach($moduleColumns as $key => $moduleColumn)
                                            @if(! in_array($moduleColumn->Field, $exceptColumns))
                                                <div class="form-group">
                                                    <label>{{ getFormattedTableColumnName($moduleColumn->Field) }}</label>
                                                    {!! Form::text($moduleColumn->Field, old($moduleColumn->Field), ['class' => 'form-control', 'id' => $moduleColumn->Field]) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::submit('Add',['class' =>'btn btn-primary btn-submit', 'id' => 'add_custom_module_btn']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
