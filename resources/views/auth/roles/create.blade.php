@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'roles'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Add Role</h3>
                    </div>
                    <div class="card-body">
                        @include('common.messages')
                        @include('common.errors')

                        <div class="error text-danger"></div>

                        {!! Form::open([
                                'route' => ['roles.store'],
                                'method' => 'POST',
                                'name' => 'add_role_form',
                                'id' => 'add_role_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                        <div class="form-group">
                                        {!! Form::submit('Add',['class' =>'btn btn-large btn-primary btn-submit', 'id' => 'add_role_btn']) !!}
                                    </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control', 'required' =>  'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-24">
                                    <div class="form-group">
                                        <label>Permission</label>
                                        @include('auth.roles.permission')
                                    </div>
                                    <div class="form-group">
                                        {!! Form::submit('Add',['class' =>'btn btn-large btn-primary btn-submit', 'id' => 'add_role_btn']) !!}
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
		$(document).ready(function(){

			addPermission = function(element, permission, element_counter)
	        {
				var permission_template = permission.clone();

				permission_template.find(".screens").attr('name', 'screens['+element_counter+']');

				var permission_select = '{!! Form::select('permission[]', $permissions, null, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}';
				permission_template.find(".pselect-box").html(permission_select);

				permission_template.find(".permissions-list").attr('name', 'permission['+element_counter+'][]');
				permission_template.find(".permissions-list").select2();

	            element.append(permission_template)
	        };

	        var element_counter = 0;

	        $(document).on('click', '.add-permission', function() {
	            $('.error').text('');
	            var permission = $(".add-permission-list").children("tr.new-permission:last-child");

	            var has_error = false;
	            if (permission.find('select.screens').val() == "") {
	                permission.find('select.screens').trigger('focus');
	                has_error = true;
	                return false;
	            }
	            if (permission.find('select.permissions-list').val() == "") {
	                permission.find('select.permissions-list').trigger('focus');
	                has_error = true;
	                return false;
	            }

	            if (! has_error) {
	                $(".error").text("");
	                element_counter++;

	                //addPermission($(".add-permission-list"),element_counter)
	                addPermission($(".add-permission-list"), permission, element_counter);

	                var last_permission = $(".add-permission-list").children("tr.new-permission:last-child");

	            }
	        });

	        $(document).on('click', '.delete-permission', function(e) {
	            e.preventDefault();
	            var permission_count = $(this).closest(".add-permission-list").children("tr.new-permission").length;

	            if(permission_count > 1)
	            {
	                if(confirm('Are you sure?'))
	                {
	                    $(this).parents('.new-permission').remove();
	                }
	            }
	            else
	            {
	                $(".error").text("You must have to add at least one permission.");
	            }
	        });

	        // Validate table fields on submit
	        $(document).on('click', '#add_role_btn', function(e) {
	            e.preventDefault();

	            var errors = [];
	            var $that = $(this);

	            /*$(document).find('select.screens').each(function(){
	                if ($(this).val() == "") {
	                    $(this).addClass("input_error");
	                    errors.push(false);
	                    return false;
	                }
	                else {
	                    $(this).removeClass("input_error");
	                }
	            });

	            $(document).find('select.permissions-list').each(function(){
	                if(!$(this).val() == ""){
	                    $(this).addClass("input_error");
	                    errors.push(false);
	                    return false;
	                }
	                else{
	                    $(this).removeClass("input_error");
	                }
	            });*/

	            var validate_values = errors.includes(false);
	            if(validate_values){
	                $(".error").text("Below Values are required.");
	                return false;
	            }
	            else {
	                $(".error").text('');
	                $('#add_role_form').submit();
	                return false;
	            }
	            //e.preventDefault();
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
