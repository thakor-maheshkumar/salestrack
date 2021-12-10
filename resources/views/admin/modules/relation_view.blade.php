<div class="relation-view-block"> 
	<div class="error text-danger"></div>
	{!! Form::open([
			'route' => ['module-relationship.store'], 
			'method' => 'POST',
			'name' => 'add_module_relation_form', 
			'id' => 'add_module_relation_form', 
			'autocomplete' => 'off', 
			'enctype' => 'multipart/form-data'
		]) 
	!!}
		{!! Form::hidden('module_id', $module->id) !!}
		{!! Form::hidden('module_table', $module->table) !!}
		<div class="table-wrapper table-responsive">
			<table class="table table-bordered table-striped dynamic-table--warpper">
				<thead>
					<tr>
						<th>Column</th>
						<th colspan="2">Foreign key constraint</th>
						<th>Action</th>
					</tr>
					<tr>
						<th></th>
						<th>Table</th>
						<th>Column</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="add-column-list">
					@if(isset($module->module_relationships) && $module->module_relationships->isNotEmpty())
						@foreach($module->module_relationships as $key => $relation)
							<tr class="new-column">
								<td>
									{!! Form::select("relationships[$relation->id][table_column]", ['' => ''] + $table_columns, $relation->table_column, ['class' => 'form-control table_column']) !!}
								</td>
								<td>
									{!! Form::select("relationships[$relation->id][rel_table]", ['' => 'Select Relation Table'] + $rel_tables, $relation->related_table, ['class' => 'form-control rel_table']) !!}
								</td>
								<td class="dynamic-block">
									{!! Form::select("relationships[$relation->id][rel_table_column]", ['' => '', $relation->related_table_column => $relation->related_table_column], $relation->related_table_column, ['class' => 'form-control rel_table_column']) !!}
								</td>
								<td>
									<div class="delete-column-block text-center">
										<a href="javascript:void(0);" 
											class="btn btn-remove delete-column" data-toggle="tooltip" 
											data-placement="bottom" 
											title="Delete Relation">
												<i class="fa fa-trash"></i>
										</a>
									</div>
								</td>
							</tr>
						@endforeach
					@endif
					<tr class="new-column">
						<td>
							{!! Form::select('new_relationships[0][table_column]', ['' => ''] + $table_columns, null, ['class' => 'form-control table_column']) !!}
						</td>
						<td>
							{!! Form::select('new_relationships[0][rel_table]', ['' => 'Select Relation Table'] + $rel_tables, null, ['class' => 'form-control rel_table']) !!}
						</td>
						<td class="dynamic-block">
							{!! Form::select('new_relationships[0][rel_table_column]', ['' => ''], null, ['class' => 'form-control rel_table_column']) !!}
						</td>
						<td>
							<div class="delete-column-block text-center">
								<a href="javascript:void(0);" 
									class="btn btn-remove delete-column" data-toggle="tooltip" 
									data-placement="bottom" 
									title="Delete Relation">
										<i class="fa fa-trash"></i>
								</a>
							</div>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<a href="javascript:void(0);" class="btn btn-add add-column" data-toggle="tooltip" data-placement="bottom" title="Add New Relation"><i class="fa fa-plus"></i></a>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							{!! Form::button('Save',['id' => 'relation_submit_btn','class' =>'btn btn-primary relation-submit-btn']) !!}
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	{!! Form::close() !!}
</div>
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			getColumns = function(element, table)
			{
				var url = '{{ route("relation-table.fields", ":table_name") }}';
				url = url.replace(':table_name', table);

				$.get(url, function(data) {
					if(data.success)
					{
						element.empty(); 
						element.append("<option value=''> </option>");
						$.each(data.columns, function(key, item) {
							element.append(
								$('<option></option>').val(item).html(item)
							);
							//element.append("<option value='" + item.Field +"'>" + item.Field + "</option>");
						});
					}
				});
			};

			addColumn = function(element, column, element_counter)
			{
				var column_template = column.clone();
				column_template.find('select').val('');

				column_template.find('.table_column').attr('name', 'new_relationships[' + element_counter + '][table_column]');
				column_template.find('.rel_table').attr('name', 'new_relationships[' + element_counter + '][rel_table]');
				column_template.find('.rel_table_column').attr('name', 'new_relationships[' + element_counter + '][rel_table_column]');

				var rel_table_column = column_template.find('.rel_table_column')
				rel_table_column.empty();
				rel_table_column.append("<option value=''> </option>");

				element.append(column_template)
			};

			$(document).on('change', '.rel_table', function() {
				var $that = $(this);
				var selected_table = $(this).val();

				if(selected_table)
				{
					var rel_table_dropdown = $that.parent('td').siblings('td').find('select.rel_table_column');
					getColumns(rel_table_dropdown, selected_table);
				}
			});

			var element_counter = 0;

			$(document).on('click', '.add-column', function() {
				$('.error').text('');
				var column = $(".add-column-list").children("tr.new-column:last-child");

				var has_error = false;

				column.find('select').each(function(){
					if ($(this).val() == "") {
						$(this).trigger('focus');
						has_error = true;
						return false;
					}
				});

				if (! has_error) {
					$(".error").text("");
					element_counter++;

					addColumn($(".add-column-list"), column, element_counter);

					var last_column = $(".add-column-list").children("tr.new-column:last-child");
				}
			});

			$(document).on('click', '.delete-column', function(e) {
				e.preventDefault();

				var column_count = $(this).closest(".add-column-list").children("tr.new-column").length;
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
	        $(document).on('click', '#relation_submit_btn', function(e) {
	            e.preventDefault();

	            var errors = [];
	            var $that = $(this);

	            $(document).find('.relation-view-block select').each(function(){
	                if ($(this).val() == "") {
	                    $(this).addClass("input_error");
	                    errors.push(false);
	                    return false;
	                }
	                else {
	                    $(this).removeClass("input_error");
	                }
	            });

	            var validate_values = errors.includes(false);
	            if(validate_values){
	                $(".error").text("Below Values are required.");
	                return false;
	            }
	            else {
	                $(".error").text('');
	                $('#add_module_relation_form').submit();
	                return false;
	            }
	        });
		});
	</script>
@endsection