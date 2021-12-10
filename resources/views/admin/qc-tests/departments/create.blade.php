@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'departments'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Add Department</h3>
                    </div>
                    <div class="card-body">
                        @include('common.messages')
                        @include('common.errors')

                        <div class="error text-danger"></div>

                        {!! Form::open([
                                'route' => ['departments.store'],
                                'method' => 'POST',
                                'name' => 'add_department_form',
                                'id' => 'add_department_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::submit('Add',['class' =>'btn btn-primary btn-submit', 'id' => 'add_department_btn']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::hidden('module_id', $module->id) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Name *</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                    {{--
                                        <div class="form-group">
                                            <label>Parent Unit</label>
                                            {!! Form::select('parent_unit', [0 => 'Select Parent'] + $parent_modules, old('parent_unit'), ['class' => 'form-control', 'id' => 'parent_unit']) !!}
                                        </div>
                                    --}}
                                    <div class="form-group">
                                        <label>Parent Unit</label>
                                        {!! Form::select('parentable_type', ['' => 'Select Parent Type'] + $parent_type, old('parent_type'), ['class' => 'form-control parent_type', 'id' => 'parent_type']) !!}

                                        <div class="parent-unit-data d-none">
                                            {!! Form::select('parentable_id', ['' => 'Select Parent'] + $parent_modules, old('parentable_id'), ['class' => 'form-control', 'id' => 'parentable_id']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address *</label>
                                        {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'id' => 'address', 'rows' => 3, 'required' =>  'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Street</label>
                                        {!! Form::textarea('street', old('street'), ['class' => 'form-control', 'id' => 'street', 'rows' => 2]) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Landmark</label>
                                        {!! Form::text('landmark', old('landmark'), ['class' => 'form-control', 'id' => 'landmark']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        {!! Form::text('city', old('city'), ['class' => 'form-control', 'id' => 'city']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        {!! Form::text('state', old('state'), ['class' => 'form-control', 'id' => 'state']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Country Id *</label>
                                        {!! Form::select('country_id', ['' => 'Select country'] + $countries, old('country_id'), ['class' => 'form-control', 'id' => 'country_id', 'required' => 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Email *</label>
                                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'required' => 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        {!! Form::number('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::submit('Add',['class' =>'btn btn-primary btn-submit', 'id' => 'add_department_btn']) !!}
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
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			addParentDropdown = function(parent_unit)
            {
            	var element = $(".parent-unit-data");
            	var select_element = '';

            	if(parent_unit == 'App\\Models\\Department')
				{
					select_element = '{!! Form::select("parentable_id", [0 => "Select Parent"] + $departments , '', ["class" => "form-control", "id" => "parentable_id"]) !!}';
				}
				else if(parent_unit == 'App\\Models\\Warehouse')
				{
					select_element = '{!! Form::select("parentable_id", [0 => "Select Parent"] + $warehouses , '', ["class" => "form-control", "id" => "parentable_id"]) !!}';
				}

				element.html(select_element);
				element.removeClass('d-none');
            }

            var selected_type = $('.parent_type').val();
            if(selected_type)
            {
            	addParentDropdown(selected_type);
            }

			$('.parent_type').on('change', function() {
				if(selected = $(this).val())
				{
					addParentDropdown(selected);
				}
				else
				{
					$(".parent-unit-data").addClass('d-none');
				}
			});
            $(document).on('keypress', 'input,select,textarea', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                    // Get all focusable elements on the page
                    var $canfocus = $(':focusable');
                    var index = $canfocus.index(document.activeElement) + 1;
                        if (index >= $canfocus.length) index = 0;
                        $canfocus.eq(index).focus();
                        }

            });
		});
	</script>
@endsection
