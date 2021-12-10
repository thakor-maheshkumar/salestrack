<table class="dynamic-table--warpper">
    <thead>
        <th>Name</th>
        <th>Type</th>
        <th></th>
    </thead>
    <tbody class="add-column-list">
        <tr class="new-column">
            <td>
                {!! Form::text('column_name[]', old('column_name[]'), ['id' => 'column_name', 'class' => 'form-control column_name']) !!}
            </td>
            <td>
            	{!! Form::select('column_type[]', ['' => 'Select Column Type'] + $data_types, null, ['class' => 'form-control column_type']) !!}
            </td>
            <td>
                <div class="delete-column-block">
                    <a href="javascript:void(0);" 
                        class="btn btn-remove delete-column" data-toggle="tooltip" 
                        data-placement="bottom" 
                        title="Delete Column">
                            <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <a href="javascript:void(0);" class="btn btn-add add-column" data-toggle="tooltip" data-placement="bottom" title="Add New Column"><i class="fa fa-plus"></i></a>
            </td>
        </tr>
    </tfoot>
</table>

