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
                        <h3 class="heading">Update Module</h3>
                    </div>
                </div>
                <div class="card-body">
                    @include('common.messages')
                    @include('common.errors')

                    <div class="error text-danger"></div>

                    {!! Form::open([
                            'route' => ['modules.update', $module->id],
                            'method' => 'PUT',
                            'name' => 'update_module_form',
                            'id' => 'update_module_form',
                            'autocomplete' => 'off',
                            'enctype' => 'multipart/form-data'
                        ])
                    !!}
                        {!! Form::hidden('type', $module->type) !!}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    {!! Form::text('name', old('name', (isset($module->name) && $module->name) ? $module->name : ''), ['id' => 'name', 'class' => 'form-control', 'required' =>  'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Alias</label>
                                    {!! Form::text('alias', old('alias', (isset($module->alias) && $module->alias) ? $module->alias : ''), ['id' => 'alias', 'class' => 'form-control', 'required' =>  'required']) !!}
                                </div>
                                <div class="form-group {{ ($module->type == 2) ? 'd-none' : '' }}">
                                    <label>Is Under</label>
                                    {!! Form::select('parent_module', ['' => 'Select Module'] + $modules, old('parent_unit', isset($module->parent_module) ? $module->parent_module : ''), ['class' => 'form-control parent_module', 'id' => 'parent_module']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'update_module_btn']) !!}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
