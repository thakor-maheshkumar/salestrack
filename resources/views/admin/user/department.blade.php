@php
    $element_counter = 0;
@endphp
<div class="table-responsive">
    <table class="dynamic-table--warpper">
        <thead>
            <th>Department</th>
            <th>Start Date *</th>
            <th>End Date *</th>
            <th>Is Manager</th>
            <th></th>
        </thead>
        <tbody class="add-department-list">
            @if(isset($user->departments) && ($user->departments->isNotEmpty()))
                @foreach($user->departments as $sKey => $department)
                    <tr class="new-department">
                        <td>
                            {!! Form::select("departments[$element_counter][department]", $departments, $department->id, ['class' => 'form-control departments-list']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("departments[$element_counter][start_date]", \Carbon\Carbon::parse($department->pivot->start_date)->format('d/m/Y'), ['class' => 'form-control start_date datepicker', 'id' => 'start_date', 'placeholder' => 'Start Date']) !!}
                        </td>
                        <td class="datepicker-box">
                            {!! Form::text("departments[$element_counter][end_date]", \Carbon\Carbon::parse($department->pivot->end_date)->format('d/m/Y'), ['class' => 'form-control end_date datepicker', 'id' => 'end_date', 'placeholder' => 'End Date']) !!}
                        </td>
                        <td class="text-center">
                            {!! Form::checkbox("departments[$element_counter][is_manager]", 1, $department->pivot->is_manager, ['class' => 'is_manager', 'id' => 'is_manager']) !!}
                        </td>
                        <td>
                            <div class="delete-department-block">
                                <a href="javascript:void(0);"
                                    class="btn btn-remove delete-department btn-danger" data-toggle="tooltip"
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
                <tr class="new-department">
                    <td>
                        {!! Form::select("departments[$element_counter][department]", $departments, null, ['class' => 'form-control departments-list']) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::text("departments[$element_counter][start_date]", old("start_date[$element_counter]"), ['class' => 'form-control start_date datepicker', 'id' => 'start_date', 'placeholder' => 'Start Date', 'autocomplete' => 'off']) !!}
                    </td>
                    <td class="datepicker-box">
                        {!! Form::text("departments[$element_counter][end_date]", old("expiry_date[$element_counter]"), ['class' => 'form-control end_date datepicker', 'id' => 'end_date', 'placeholder' => 'End Date', 'autocomplete' => 'off']) !!}
                    </td>
                    <td class="text-center">
                        {!! Form::checkbox("departments[$element_counter][is_manager]", 1, null, ['class' => 'is_manager', 'id' => 'is_manager']) !!}
                    </td>
                    <td>
                        <div class="delete-department-block">
                            <a href="javascript:void(0);"
                                class="btn btn-remove delete-department btn-danger" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Delete department">
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
                    <a href="javascript:void(0);" class="btn btn-add add-department btn-success" data-toggle="tooltip" data-placement="bottom" title="Add New Department"><i class="fa fa-plus"></i></a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function(){

            addDepartment = function(element, department, element_counter)
            {
                var department_template = department.clone();

                department_template.find(".departments-list").attr('name', 'departments['+element_counter+'][department]');

                department_template.find(".is_manager").attr('name', 'departments['+element_counter+'][is_manager]');

                var datepicker_start_element = department_template.find(".start_date");
                var datepicker_end_element = department_template.find(".end_date");
                datepicker_start_element.attr('name', 'departments['+element_counter+'][start_date]');
                datepicker_end_element.attr('name', 'departments['+element_counter+'][end_date]');

                var datepicker_element = department_template.find('.datepicker');
                datepicker_element.val('');
                datepicker_element.datepicker({
                    format: 'dd/mm/yyyy'
                }).on('keypress', function (e) {
                    e.preventDefault();
                    return false;
                }).on('keydown', function (event) {
                    if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
                        event.preventDefault();
                    }
                });

                element.append(department_template)
            };

            var element_counter = "{{ $element_counter }}"

            $(document).on('click', '.add-department', function() {
                $('.error').text('');
                var department = $(".add-department-list").children("tr.new-department:last-child");

                var has_error = false;

                department.find('select').each(function(){
                    if (!($(this).val() && $(this).val().length)) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                department.find('input[type=text]').each(function(){
                    if (! $(this).val()) {
                        $(this).trigger('focus');
                        has_error = true;
                        return false;
                    }
                    has_error = false;
                });

                if (! has_error) {
                    $(".error").text("");
                    element_counter++;

                    //adddepartment($(".add-department-list"),element_counter)
                    addDepartment($(".add-department-list"), department, element_counter);

                    var last_department = $(".add-department-list").children("tr.new-department:last-child");
                }
            });

            $(document).on('click', '.delete-department', function(e) {
                e.preventDefault();
                var department_count = $(this).closest(".add-department-list").children("tr.new-department").length;

                if(department_count > 1)
                {
                    if(confirm('Are you sure?'))
                    {
                        $(this).parents('.new-department').remove();
                    }
                }
                else
                {
                    $(".error").text("You must have to add at least one department.");
                }
            });

            //Validate table fields on submit
            $(document).on('click', '#add_user_btn', function(e) {
                e.preventDefault();

                var errors = [];
                var $that = $(this);

                $(document).find('select.departments-list').each(function(){
                    if ($(this).val() == "") {
                        $(this).addClass("input_error");
                        errors.push(false);
                        return false;
                    }
                    else {
                        $(this).removeClass("input_error");
                    }
                });

                $(document).find('.add-department-list input[type=text]').each(function(){
                    if(!$(this).val()){
                        $(this).addClass("input_error");
                        errors.push(false);
                        return false;
                    }
                    else{
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
                    $('form.user_form').submit();
                    //return false;
                }
                //e.preventDefault();
            });
        });
    </script>
@endsection
