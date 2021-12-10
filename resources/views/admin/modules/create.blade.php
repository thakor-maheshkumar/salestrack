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
                        <h3 class="heading">Add Module</h3>
                    </div>
                </div>
                <div class="card-body">
                    @include('common.messages')
                    @include('common.errors')

                    <div class="error text-danger"></div>

                    {!! Form::open([
                            'route' => ['modules.store'],
                            'method' => 'POST',
                            'name' => 'add_module_form',
                            'id' => 'add_module_form',
                            'autocomplete' => 'off',
                            'enctype' => 'multipart/form-data'
                        ])
                    !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Module Type</label>
                                    {!! Form::select('type', $types, old('types'), ['class' => 'form-control module_type', 'id' => 'type']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'form-control', 'required' =>  'required']) !!}
                                </div>
                                <div class="form-group">
                                    <label>Alias</label>
                                    {!! Form::text('alias', old('alias'), ['id' => 'alias', 'class' => 'form-control', 'required' =>  'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div id="custom_module_block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Is Under</label>
                                        {!! Form::select('parent_module', ['' => 'Select Module'] + $modules, old('parent_module'), ['class' => 'form-control parent_module', 'id' => 'parent_module']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Table</label>
                                        {!! Form::text('table', old('table'), ['id' => 'table', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-24">
                                    @include('admin.modules.create_table')
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::submit('Add',['class' =>'btn btn-primary btn-submit', 'id' => 'add_module_btn']) !!}
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
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#type').val() == 2)
			{
				$('#custom_module_block').hide();
				$('#custom_module_block').find('#table').val('');
			}
			$('#type').change(function(){
				if($('#type').val() == 1) {
					$('#custom_module_block').show();
				} else {
					$('#custom_module_block').hide();
					$('#custom_module_block').find('#table').val('');
				}
			});

			addColumn = function(element, column)
	        {
	            /*var column_template = '<tr class="new-column">'+
								            '<td><input id="column_name" class="form-control column_name" name="column_name[]" type="text">'+
								            '</td>'+
								            '<td>'+
								            	'{{ Form::select('column_type[]', ['' => 'Select Column Type'] + $data_types, null, ['class' => 'form-control column_type'])  }}'
								            '</td>'+
								            '<td>'+
								                '<div class="delete-column-block">'+
	                                                '<a href="javascript:void(0);"'+
	                                                    'class="btn btn-remove delete-column" data-toggle="tooltip" '+
	                                                    'data-placement="bottom" '+
	                                                    'title="Delete Column"> '+
	                                                    '<i class="fa fa-trash"></i>'+
	                                                '</a>'+
	                                            '</div>'+
								            '</td>'+
								        '</tr>';*/

				var column_template = column.clone();
                column_template.find("input:text").val("");

	            element.append(column_template)
	        };

	        var element_counter = 0;

	        $(document).on('click', '.add-column', function() {
	            $('.error').text('');
	            var column = $(".add-column-list").children("tr.new-column:last-child");

	            var has_error = false;
	            if (!column.find('.column_name').val()) {
	                column.find('.column_name').trigger('focus');
	                has_error = true;
	                return false;
	            }
	            if (column.find('select.column_type').val() == "") {
	                column.find('select.column_type').trigger('focus');
	                has_error = true;
	                return false;
	            }

	            if (! has_error) {
	                $(".error").text("");
	                element_counter++;

	                //addColumn($(".add-column-list"),element_counter)
	                addColumn($(".add-column-list"), column);

	                var last_column = $(".add-column-list").children("tr.new-column:last-child");

	            }
	        });

	        $(document).on('click', '.delete-column', function(e) {
	            e.preventDefault();
	            var column_count = $(this).closest(".add-column-list").children("tr.new-column").length;
	            console.log(column_count);
	            if(column_count > 1)
	            {
	                if(confirm('Are you sure?'))
	                {
	                    $(this).parents('.new-column').remove();
	                }
	            }
	            else
	            {
	                $(".error").text("You must have to add at least one column.");
	            }
	        });

	        // Validate table fields on submit
	        $(document).on('click', '#add_module_btn', function(e) {
	            e.preventDefault();

	            var errors = [];

	            var $that = $(this);
	            var module_type = $(document).find('select.module_type').val();
	            if(module_type == '1')
                {
		            $(document).find('select.column_type').each(function(){
		                if ($(this).val() == "") {
		                    $(this).addClass("input_error");
		                    errors.push(false);
		                    return false;
		                }
		                else {
		                    $(this).removeClass("input_error");
		                }
		            });

		            $(document).find('.column_name').each(function(){
		                if(!$(this).val()){
		                    $(this).addClass("input_error");
		                    errors.push(false);
		                    return false;
		                }
		                else{
		                    $(this).removeClass("input_error");
		                }
		            });
                }

	            var validate_values = errors.includes(false);
	            if(validate_values){
	                $(".error").text("Below Values are required.");
	                return false;
	            }
	            else {
	                $(".error").text('');
	                $('#add_module_form').submit();
	                return false;
	            }
	            //e.preventDefault();
	        });
		});
	</script>
@endsection
