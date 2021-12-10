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
                        <h3 class="card-title">Edit Role</h3>
                    </div>
                    <div class="card-body">
                        @include('common.messages')
                        @include('common.errors')

                        <div class="error text-danger"></div>

                        {!! Form::open([
                                'route' => ['roles.update', $role->id],
                                'method' => 'PUT',
                                'name' => 'update_role_form',
                                'id' => 'update_role_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                        <div class="form-group">
                                        {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'update_role_btn']) !!}
                                    </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        {!! Form::text('name', old('name', (isset($role->name) && $role->name) ? $role->name : ''), ['id' => 'name', 'class' => 'form-control', 'required' =>  'required']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-24">
                                    <div class="form-group">
                                        <label>Permission</label>
                                        @php
                                            $element_counter = 0;
                                        @endphp
                                        @if(isset($role->permissions) && !empty($role->permissions) && isset($selected_permissions) && !empty($selected_permissions))
                                            <div class="table-responsive">
                                                <table class="dynamic-table--warpper">
                                                    <thead>
                                                        <th>Screen</th>
                                                        <th>Permission</th>
                                                        <th></th>
                                                    </thead>
                                                        <tbody class="add-permission-list">
                                                            @foreach($selected_permissions as $sKey => $pValue)
                                                                <tr class="new-permission">
                                                                    <td>
                                                                        {!! Form::select("screens[$element_counter]", $screens, $sKey, ['class' => 'form-control screens', 'id' => 'screens']) !!}
                                                                    </td>
                                                                    <td class="pselect-box">
                                                                        {!! Form::select("permission[$element_counter][]", $permissions, $pValue, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}
                                                                    </td>
                                                                    <td>
                                                                        <div class="delete-permission-block">
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-remove delete-permission btn-danger" data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Delete PermissioP">
                                                                                    <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $element_counter++;
                                                                @endphp
                                                            @endforeach
                                                        </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">
                                                                <a href="javascript:void(0);" class="btn btn-add add-permission btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Permission"><i class="fa fa-plus"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @else
                                            @include('auth.roles.permission')
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'update_role_btn']) !!}
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

	        var element_counter = "{{ $element_counter }}";

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

	                //addPermission($(".add-permission-list"),element_counter)
	                addPermission($(".add-permission-list"), permission, element_counter);

	                element_counter++;
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
