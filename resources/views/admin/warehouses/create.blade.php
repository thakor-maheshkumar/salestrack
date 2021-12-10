@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'warehouse'
])
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}
</style>
@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-12">
                @include('common.messages')
                @include('common.errors')

                <div class="error text-danger"></div>

                {!! Form::open([
                        'route' => ['warehouses.store'],
                        'method' => 'POST',
                        'name' => 'add_warehouse_form',
                        'id' => 'add_warehouse_form',
                        'autocomplete' => 'off',
                        'enctype' => 'multipart/form-data'
                    ])
                !!}
                    <div class="card main-content--subblock">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Warehouse') }}</h5>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-24 text-center">
                                    <button type="submit" class="btn btn-primary btn-round" id="add_warehouse_btn">{{ __('Add') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group">
                                    {!! Form::hidden('module_id', $module->id) !!}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Name *') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{--
                                <div class="form-group">
                                    <label>Parent Unit</label>
                                    {!! Form::select('parent_unit', [0 => 'Select Parent'] + $parent_modules, old('parent_unit'), ['class' => 'form-control', 'id' => 'parent_unit']) !!}
                                </div>
                            --}}
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Parent Unit') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::select('parentable_type', ['' => 'Select Parent Type'] + $parent_type, old('parent_type'), ['class' => 'form-control parent_type', 'id' => 'parent_type']) !!}

                                        <div class="parent-unit-data d-none">
                                            {!! Form::select('parentable_id', ['' => 'Select Parent'] + $parent_modules, old('parentable_id'), ['class' => 'form-control', 'id' => 'parentable_id']) !!}
                                        </div>
                                    </div>
                                    @if ($errors->has('parentable_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('parentable_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Address') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'id' => 'address', 'rows' => 3, 'required' =>  'required']) !!}
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Street') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::textarea('street', old('street'), ['class' => 'form-control', 'id' => 'street', 'rows' => 2]) !!}
                                    </div>
                                    @if ($errors->has('street'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('street') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Landmark') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::text('landmark', old('landmark'), ['class' => 'form-control', 'id' => 'landmark']) !!}
                                    </div>
                                    @if ($errors->has('landmark'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('landmark') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('City') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::text('city', old('city'), ['class' => 'form-control', 'id' => 'city']) !!}
                                    </div>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Country') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::select('country_id', ["Select country"] + $countries, old('country_id'), ['class' => 'form-control', 'id' => 'country_id', 'required' => 'required']) !!}
                                    </div>
                                    @if ($errors->has('country_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('State') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::text('state', old('state'), ['class' => 'form-control', 'id' => 'state']) !!}
                                    </div>
                                    @if ($errors->has('state'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('City') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::text('city', old('city'), ['class' => 'form-control', 'id' => 'city']) !!}
                                    </div>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Country') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::select('country_id', ["Select country"] + $countries, old('country_id'), ['class' => 'form-control', 'id' => 'country_id', 'required' => 'required']) !!}
                                    </div>
                                    @if ($errors->has('country_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('country_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Email') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'id' => 'email', 'required' => 'required']) !!}
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-6 col-form-label">{{ __('Phone') }}</label>
                                <div class="col-md-18">
                                    <div class="form-group">
                                        {!! Form::number('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone']) !!}
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-24 text-center">
                                    <button type="submit" class="btn btn-primary btn-round" id="add_warehouse_btn">{{ __('Add') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
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
            ///form submitting stop after click on enter button //
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
