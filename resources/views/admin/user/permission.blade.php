@php
    $element_counter = 0;
@endphp
<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Role</th>
            <th>Permission *</th>
            <th>Start Date *</th>
            <th>Expiry Date *</th>
            <th></th>
        </thead>
        <tbody class="add-permission-list">
            @if(isset($user->permissions) && !empty($user->permissions) && isset($selected_permissions) && !empty($selected_permissions))
                @foreach($selected_permissions as $sKey => $pValue)
                    <tr class="new-permission">
                        <td>
                            {!! Form::select("roles[$element_counter]", $roles, $sKey, ['class' => 'form-control roles', 'id' => 'roles']) !!}
                        </td>
                        <td class="pselect-box">
                            {!! Form::select("permission[$element_counter][]", $permissions, $pValue, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("start_date[$element_counter]", isset($user_permission_start[$sKey]) ? $user_permission_start[$sKey] : '', ['class' => 'form-control start_date datepicker', 'id' => 'start_date', 'placeholder' => 'Start Date', 'autocomplete' => 'off']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("expiry_date[$element_counter]", isset($user_permission_expiry[$sKey]) ? $user_permission_expiry[$sKey] : '', ['class' => 'form-control expiry_date datepicker', 'id' => 'expiry_date', 'placeholder' => 'Expiry Date', 'autocomplete' => 'off']) !!}
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
            @else
                <tr class="new-permission">
                    <td>
                        {!! Form::select("roles[$element_counter]", $roles, old("roles[$element_counter]"), ['class' => 'form-control roles', 'id' => 'roles']) !!}
                    </td>
                    <td class="pselect-box">
                    	{!! Form::select("permission[$element_counter][]", $permissions, null, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::text("start_date[$element_counter]", old("start_date[$element_counter]"), ['class' => 'form-control start_date datepicker', 'id' => 'start_date', 'placeholder' => 'Start Date', 'autocomplete' => 'off']) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::text("expiry_date[$element_counter]", old("expiry_date[$element_counter]"), ['class' => 'form-control expiry_date datepicker', 'id' => 'expiry_date', 'placeholder' => 'Expiry Date', 'autocomplete' => 'off']) !!}
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
            @endif
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
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){

            addPermission = function(element, permission, element_counter)
            {
                var permission_template = permission.clone();

                permission_template.find(".roles").attr('name', 'roles['+element_counter+']');

                var datepicker_start_element = permission_template.find(".start_date");
                var datepicker_expiry_element = permission_template.find(".expiry_date");
                datepicker_start_element.attr('name', 'start_date['+element_counter+']');
                datepicker_expiry_element.attr('name', 'expiry_date['+element_counter+']');

                var datepicker_element = permission_template.find('.datepicker');
                datepicker_element.val('');
                datepicker_element.datepicker({
                    format: 'yyyy-mm-dd'
                }).on('keypress', function (e) {
                    e.preventDefault();
                    return false;
                }).on('keydown', function (event) {
                    if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
                        event.preventDefault();
                    }
                });

                var permission_select = '{!! Form::select('permission[]', $permissions, null, ['class' => 'form-control permissions-list', 'multiple' => true]) !!}';
                permission_template.find(".pselect-box").html(permission_select);

                permission_template.find(".permissions-list").attr('name', 'permission['+element_counter+'][]');
                permission_template.find(".permissions-list").select2();

                element.append(permission_template)
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-permission', function() {
                $('.error').text('');
                var permission = $(".add-permission-list").children("tr.new-permission:last-child");

                var has_error = false;

                permission.find('select').each(function(){
                    if (!($(this).val() && $(this).val().length)) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                permission.find('input[type=text]').each(function(){
                    if (! $(this).val()) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                /*if (!permission.find('input[type=text]').val()) {
                    permission.find('input[type=text]').trigger('focus');
                    has_error = true;
                    return false;
                }*/

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
            // $(document).on('click', '#add_user_btn', function(e) {
            //     e.preventDefault();

            //     var errors = [];
            //     var $that = $(this);

            //     $(document).find('select.screens').each(function(){
            //         if ($(this).val() == "") {
            //             $(this).addClass("input_error");
            //             errors.push(false);
            //             return false;
            //         }
            //         else {
            //             $(this).removeClass("input_error");
            //         }
            //     });

            //     $(document).find('select.permissions-list').each(function(){
            //         if ($(this).val() == "") {
            //             $(this).addClass("input_error");
            //             errors.push(false);
            //             return false;
            //         }
            //         else {
            //             $(this).removeClass("input_error");
            //         }
            //     });

            //     $(document).find('.add-permission-list input[type=text]').each(function(){
            //         if(!$(this).val()){
            //             $(this).addClass("input_error");
            //             errors.push(false);
            //             return false;
            //         }
            //         else{
            //             $(this).removeClass("input_error");
            //         }
            //     });

            //     var validate_values = errors.includes(false);

            //     if(validate_values){
            //         $(".error").text("Below Values are required.");
            //         return false;
            //     }
            //     else {
            //         $(".error").text('');
            //         console.log("yes");
            //         $('#add_user_btn').submit();
            //         //return false;
            //     }
            //     //e.preventDefault();
            // });
        });
    </script>
@endsection
