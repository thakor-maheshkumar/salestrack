<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Screen</th>
            <th>Permission</th>
            <th></th>
        </thead>
        <tbody class="add-permission-list">
            <tr class="new-permission">
                <td>
                    {!! Form::select('screens[0]', $screens, old('screens[]'), ['class' => 'form-control screens', 'id' => 'screens']) !!}
                </td>
                <td class="pselect-box">
                	{!! Form::select('permission[0][]', $permissions, null, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}
                </td>
                <td>
                    <div class="delete-permission-block">
                        <a href="javascript:void(0);"
                            class="btn btn-remove delete-permission btn-danger" data-toggle="tooltip"
                            data-placement="bottom"
                            title="Delete Permission">
                                <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
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

