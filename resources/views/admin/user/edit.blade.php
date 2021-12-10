@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'users'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h1>
                    </div>
                    <div class="card-body">
                        <div class="main-content--subblock">
                            @include('common.messages')
                            @include('common.errors')

                            <div class="error text-danger"></div>

                            {!! Form::open([
                                    'route' => ['users.update', $user->id],
                                    'method' => 'PUT',
                                    'name' => 'update_user_form',
                                    'id' => 'update_user_form',
                                    'class' => 'user_form',
                                    'autocomplete' => 'off',
                                    'enctype' => 'multipart/form-data'
                                ])
                            !!}
                                {{--
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>User Type</label>
                                            {!! Form::select('role[]', $roles, old('role[]', isset($user->roles) ? $user->roles : ''), ['class' => 'form-control role select2-elem', 'id' => 'role', 'required' =>  'required', 'multiple' => true]) !!}
                                        </div>
                                    </div>
                                </div>
                                --}}
                                <div class="form-group">
                                            {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'add_user_btn']) !!}
                                        </div>
                                <div class="row">
                                    <div class="col-md-24">
                                        <div class="form-group">
                                            <label>Roles</label>
                                            @include('admin.user.permission')
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-24">
                                        <div class="form-group">
                                            <label>Departments</label>
                                            @include('admin.user.department')
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {{--
                                        <div class="form-group">
                                            <label>Company</label>
                                            {!! Form::select('company_id', ['' => 'Select Company'] + $companies, old('company_id', isset($user->company_id) ? $user->company_id : ''), ['class' => 'form-control', 'id' => 'company_id']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Is Manager</label>
                                            {!! Form::checkbox('is_manager', 1, (isset($user->is_manager) && $user->is_manager == 1) ? 1 : null, ['id'=>'is_manager']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Department</label>
                                            {!! Form::select('dept_id', ['' => 'Select Department'] + $departments, old('dept_id', isset($user->dept_id) ? $user->dept_id : ''), ['class' => 'form-control', 'id' => 'dept_id']) !!}
                                        </div>
                                        --}}
                                        <div class="form-group">
                                            <label>Suffix</label>
                                            {!! Form::select('suffix', $suffix_list, old('suffix', isset($user->suffix) ? $user->suffix : ''), ['class' => 'form-control', 'id' => 'suffix']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>First Name *</label>
                                            {!! Form::text('first_name', old('first_name', isset($user->first_name) ? $user->first_name : ''), ['class' => 'form-control', 'id' => 'first_name', 'required' =>  'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Middle Name *</label>
                                            {!! Form::text('middle_name', old('middle_name', isset($user->middle_name) ? $user->middle_name : ''), ['class' => 'form-control', 'id' => 'middle_name', 'required' =>  'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name *</label>
                                            {!! Form::text('last_name', old('last_name', isset($user->last_name) ? $user->last_name : ''), ['class' => 'form-control', 'id' => 'last_name', 'required' =>  'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Sex</label>
                                            {!! Form::select('sex', ['' => 'Select Sex'] + $gender, old('sex', isset($user->sex) ? $user->sex : ''), ['class' => 'form-control', 'id' => 'sex']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Date Of Birth *</label>
                                            {!! Form::text('date_of_birth', old('date_of_birth', isset($user->date_of_birth) ? $user->date_of_birth : ''), ['class' => 'form-control datepicker', 'id' => 'date_of_birth', 'autocomplete' => 'off']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Landline No</label>
                                            {!! Form::number('landline_no', old('landline_no', isset($user->landline_no) ? $user->landline_no : ''), ['class' => 'form-control', 'id' => 'landline_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            {!! Form::number('mobile_no', old('mobile_no', isset($user->mobile_no) ? $user->mobile_no : ''), ['class' => 'form-control', 'id' => 'mobile_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Email *</label>
                                            {!! Form::email('email', old('email', isset($user->email) ? $user->email : ''), ['class' => 'form-control', 'id' => 'email']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Password *</label>
                                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            {!! Form::textarea('address', old('address', isset($user->address) ? $user->address : ''), ['class' => 'form-control', 'id' => 'address', 'rows' => 2]) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Other Address</label>
                                            {!! Form::textarea('address_1', old('address_1', isset($user->address_1) ? $user->address_1 : ''), ['class' => 'form-control', 'id' => 'address_1', 'rows' => 2]) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Landmark</label>
                                            {!! Form::text('landmark', old('landmark', isset($user->landmark) ? $user->landmark : ''), ['class' => 'form-control', 'id' => 'landmark']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            {!! Form::text('city', old('city', isset($user->city) ? $user->city : ''), ['class' => 'form-control', 'id' => 'city']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>State</label>
                                            {!! Form::select('state', ['' => 'Select a State'] + $states,isset($user->state) ? $user->state : '', ['class' => 'form-control','id'=>'state'] ) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Country *</label>
                                            {!! Form::select('country_id', ['' => 'Select country'] + $countries, old('country_id', isset($user->country_id) ? $user->country_id : ''), ['class' => 'form-control', 'id' => 'country_id', 'required' => 'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Pincode</label>
                                            {!! Form::text('pincode', old('pincode', isset($user->pincode) ? $user->pincode : ''), ['class' => 'form-control', 'id' => 'pincode']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Pan No</label>
                                            {!! Form::text('pan_no', old('pan_no', isset($user->pan_no) ? $user->pan_no : ''), ['class' => 'form-control', 'id' => 'pan_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Pan Card Photo</label>
                                            @if(isset($user->pan_photo) && !empty($user->pan_photo))
                                                <div class="profile-image">
                                                    <img src="{{ \Storage::url($user->pan_photo) }}" class="img-fluid">
                                                </div>
                                            @endif
                                            {!! Form::file('pan_photo', ['class' => 'form-control', 'id' => 'pan_photo']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhar No</label>
                                            {!! Form::number('aadhar_no', old('aadhar_no', isset($user->aadhar_no) ? $user->aadhar_no : ''), ['class' => 'form-control', 'id' => 'aadhar_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Aadhar Card Photo</label>
                                            @if(isset($user->aadhar_photo) && !empty($user->aadhar_photo))
                                                <div class="profile-image">
                                                    <img src="{{ \Storage::url($user->aadhar_photo) }}" class="img-fluid">
                                                </div>
                                            @endif
                                            {!! Form::file('aadhar_photo', ['class' => 'form-control', 'id' => 'aadhar_photo']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Photo</label>
                                            @if(isset($user->photo) && !empty($user->photo))
                                                <div class="profile-image">
                                                    <img src="{{ \Storage::url($user->photo) }}" class="img-fluid">
                                                </div>
                                            @endif
                                            {!! Form::file('photo', ['class' => 'form-control', 'id' => 'photo']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Id Card</label>
                                            {!! Form::text('id_card', old('id_card', isset($user->id_card) ? $user->id_card : ''), ['class' => 'form-control', 'id' => 'id_card']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            {!! Form::text('bank_name', old('bank_name', isset($user->bank_name) ? $user->bank_name : ''), ['class' => 'form-control', 'id' => 'bank_name']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Account No</label>
                                            {!! Form::text('bank_acc_no', old('bank_acc_no', isset($user->bank_acc_no) ? $user->bank_acc_no : ''), ['class' => 'form-control', 'id' => 'bank_acc_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Ifsc</label>
                                            {!! Form::text('bank_ifsc', old('bank_ifsc', isset($user->bank_ifsc) ? $user->bank_ifsc : ''), ['class' => 'form-control', 'id' => 'bank_ifsc']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Document</label>
                                            @if(isset($user->bank_document) && !empty($user->bank_document))
                                                <div class="profile-image">
                                                    <img src="{{ \Storage::url($user->bank_document) }}" class="img-fluid">
                                                </div>
                                            @endif
                                            {!! Form::file('bank_document', ['class' => 'form-control', 'id' => 'bank_document']) !!}
                                        </div>
                                        {{--
                                        <div class="form-group">
                                            <label>Valid Till</label>
                                            {!! Form::text('valid_till', old('valid_till', isset($user->valid_till) ? $user->valid_till : ''), ['class' => 'form-control', 'id' => 'valid_till']) !!}
                                        </div>
                                        --}}
                                        <div class="form-group">
                                            <label>Pf No</label>
                                            {!! Form::text('pf_no', old('pf_no', isset($user->pf_no) ? $user->pf_no : ''), ['class' => 'form-control', 'id' => 'pf_no']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Employee Code *</label>
                                            {!! Form::text('employee_code', old('employee_code', isset($user->employee_code) ? $user->employee_code : ''), ['class' => 'form-control', 'id' => 'employee_code', 'required' => 'required']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'add_user_btn']) !!}
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </h3>
            </div>
        </div>
	</div>
	<!-- End: main-content -->
@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$( ".past-datepicker" ).datepicker({
				format: 'yyyy-mm-dd',
				endDate: '+0d',
			}).on('keypress', function (e) {
                e.preventDefault();
                return false;
            }).on('keydown', function (event) {
                if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
                    event.preventDefault();
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
