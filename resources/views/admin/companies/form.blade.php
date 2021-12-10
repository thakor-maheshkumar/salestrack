<div class="form-group">
	{!! Form::hidden('module_id', isset($module->id) ? $module->id : 0) !!}
</div>
<div class="form-group">
    {!! Form::hidden('company_id', isset($company->id) ? $company->id : 1) !!}
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Company Name</label>
            {!! Form::text('name', old('name', (isset($company->name) && $company->name) ? $company->name : ''), ['class' => 'form-control', 'id' => 'name', 'required' => 'required']) !!}

            @if ($errors->has('name'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif

        	{{--
            	<div class="form-group">
                    <label>Parent Unit</label>
                    {!! Form::select('parent_unit', [0 => 'Select Parent'] + $parent_modules, old('parent_unit', (isset($company->parent_unit) && $company->parent_unit) ? $company->parent_unit : ''), ['class' => 'form-control', 'id' => 'parent_unit']) !!}
                </div>
            --}}
        </div>
        <div class="col-md-12">
            <label>Firm Type</label>
            {!! Form::select('firm_type', $firm_types, old('firm_type', (isset($company->firm_type) && $company->firm_type) ? $company->firm_type : ''), ['class' => 'form-control', 'id' => 'firm_type']) !!}

            @if ($errors->has('firm_type'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('firm_type') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>PAN NO</label>
            {!! Form::text('pan_no', old('pan_no', (isset($company->pan_no) && $company->pan_no) ? $company->pan_no : ''), ['class' => 'form-control', 'id' => 'pan_no']) !!}

            @if ($errors->has('pan_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('pan_no') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>PAN APPLICABLE DATE</label>
            {!! Form::text('pan_applicable_date', old('pan_applicable_date', (isset($company->pan_applicable_date) && $company->pan_applicable_date) ? $company->pan_applicable_date : ''), ['class' => 'form-control datepicker', 'id' => 'pan_applicable_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('pan_applicable_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('pan_applicable_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>GST NO</label>
            {!! Form::text('gst_no', old('gst_no', (isset($company->gst_no) && $company->gst_no) ? $company->gst_no : ''), ['class' => 'form-control', 'id' => 'gst_no']) !!}

            @if ($errors->has('gst_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('gst_no') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>GST REGISTER TYPE</label>
            {!! Form::text('gst_reg_type', old('gst_reg_type', (isset($company->gst_reg_type) && $company->gst_reg_type) ? $company->gst_reg_type : ''), ['class' => 'form-control', 'id' => 'gst_reg_type']) !!}

            @if ($errors->has('gst_reg_type'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('gst_reg_type') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>GST APPLICABLE DATE</label>
            {!! Form::text('gst_applicable_date', old('gst_applicable_date', (isset($company->gst_applicable_date) && $company->gst_applicable_date) ? $company->gst_applicable_date : ''), ['class' => 'form-control datepicker', 'id' => 'gst_applicable_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('gst_applicable_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('gst_applicable_date') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>DL NO</label>
            {!! Form::text('dl_no', old('dl_no', (isset($company->dl_no) && $company->dl_no) ? $company->dl_no : ''), ['class' => 'form-control', 'id' => 'dl_no']) !!}

            @if ($errors->has('dl_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('dl_no') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>DL APPLICABLE DATE</label>
            {!! Form::text('dl_applicable_date', old('dl_applicable_date', (isset($company->dl_applicable_date) && $company->dl_applicable_date) ? $company->dl_applicable_date : ''), ['class' => 'form-control datepicker', 'id' => 'dl_applicable_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('dl_applicable_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('dl_applicable_date') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>DL EXPIRY DATE</label>
            {!! Form::text('dl_expiry_date', old('dl_expiry_date', (isset($company->dl_expiry_date) && $company->dl_expiry_date) ? $company->dl_expiry_date : ''), ['class' => 'form-control datepicker', 'id' => 'dl_expiry_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('dl_expiry_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('dl_expiry_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>FSSAI</label>
            {!! Form::number('fssai', old('fssai', (isset($company->fssai) && $company->fssai) ? $company->fssai : ''), ['class' => 'form-control', 'id' => 'fssai']) !!}

            @if ($errors->has('fssai'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fssai') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>FSSAI APPLICABLE DATE</label>
            {!! Form::text('fssai_applicable_date', old('fssai_applicable_date', (isset($company->fssai_applicable_date) && $company->fssai_applicable_date) ? $company->fssai_applicable_date : ''), ['class' => 'form-control datepicker', 'id' => 'fssai_applicable_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('fssai_applicable_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fssai_applicable_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>FSSAI EXPIRY DATE</label>
            {!! Form::text('fssai_expiry_date', old('fssai_expiry_date', (isset($company->fssai_expiry_date) && $company->fssai_expiry_date) ? $company->fssai_expiry_date : ''), ['class' => 'form-control datepicker', 'id' => 'fssai_expiry_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('fssai_expiry_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fssai_expiry_date') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>CIN</label>
            {!! Form::text('cin', old('cin', (isset($company->cin) && $company->cin) ? $company->cin : ''), ['class' => 'form-control', 'id' => 'cin']) !!}

            @if ($errors->has('cin'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('cin') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <label>AADHAR NO</label>
    {!! Form::number('aadhar_no', old('aadhar_no', (isset($company->aadhar_no) && $company->aadhar_no) ? $company->aadhar_no : ''), ['class' => 'form-control', 'id' => 'aadhar_no']) !!}

    @if ($errors->has('aadhar_no'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('aadhar_no') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Address</label>
            {!! Form::textarea('address', old('address', (isset($company->address) && $company->address) ? $company->address : ''), ['class' => 'form-control', 'id' => 'address', 'rows' => 3]) !!}

            @if ($errors->has('address'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Street</label>
            {!! Form::textarea('street', old('street', (isset($company->street) && $company->street) ? $company->street : ''), ['class' => 'form-control', 'id' => 'street', 'rows' => 2]) !!}

            @if ($errors->has('street'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('street') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Landmark</label>
            {!! Form::text('landmark', old('landmark', (isset($company->landmark) && $company->landmark) ? $company->landmark : ''), ['class' => 'form-control', 'id' => 'landmark']) !!}

            @if ($errors->has('landmark'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('landmark') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>City</label>
            {!! Form::text('city', old('city', (isset($company->city) && $company->city) ? $company->city : ''), ['class' => 'form-control', 'id' => 'city']) !!}

            @if ($errors->has('city'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>State</label>
            {!! Form::text('state', old('state', (isset($company->state) && $company->state) ? $company->state : ''), ['class' => 'form-control', 'id' => 'state']) !!}

            @if ($errors->has('state'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Country</label>
            {!! Form::select('country_id', ["Select country"] + $countries, old('country_id', (isset($company->country_id) && $company->country_id) ? $company->country_id : ''), ['class' => 'form-control', 'id' => 'country_id', 'required' => 'required']) !!}

            @if ($errors->has('country_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('country_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <label>Zipcode</label>
    {!! Form::number('zipcode', old('zipcode', (isset($company->zipcode) && $company->zipcode) ? $company->zipcode : ''), ['class' => 'form-control', 'id' => 'zipcode']) !!}

    @if ($errors->has('zipcode'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('zipcode') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Phone</label>
            {!! Form::number('phone', old('phone', (isset($company->phone) && $company->phone) ? $company->phone : ''), ['class' => 'form-control', 'id' => 'phone']) !!}

            @if ($errors->has('phone'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Phone 1</label>
            {!! Form::text('phone_1', old('phone_1', (isset($company->phone_1) && $company->phone_1) ? $company->phone_1 : ''), ['class' => 'form-control', 'id' => 'phone_1']) !!}

            @if ($errors->has('phone_1'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone_1') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Phone 2</label>
            {!! Form::text('phone_2', old('phone_2', (isset($company->phone_2) && $company->phone_2) ? $company->phone_2 : ''), ['class' => 'form-control', 'id' => 'phone_2']) !!}

            @if ($errors->has('phone_2'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('phone_2') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Mobile No</label>
            {!! Form::text('mobile_no', old('mobile_no', (isset($company->mobile_no) && $company->mobile_no) ? $company->mobile_no : ''), ['class' => 'form-control', 'id' => 'mobile_no']) !!}

            @if ($errors->has('mobile_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('mobile_no') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Fax</label>
            {!! Form::number('fax', old('fax', (isset($company->fax) && $company->fax) ? $company->fax : ''), ['class' => 'form-control', 'id' => 'fax']) !!}

            @if ($errors->has('fax'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fax') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Email</label>
            {!! Form::email('email', old('email', (isset($company->email) && $company->email) ? $company->email : ''), ['class' => 'form-control', 'id' => 'email', 'required' => 'required']) !!}

            @if ($errors->has('email'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Other Email</label>
            {!! Form::email('email_1', old('email_1', (isset($company->email_1) && $company->email_1) ? $company->email_1 : ''), ['class' => 'form-control', 'id' => 'email_1']) !!}

            @if ($errors->has('email_1'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('email_1') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Website</label>
            {!! Form::text('website', old('website', (isset($company->website) && $company->website) ? $company->website : ''), ['class' => 'form-control', 'id' => 'website']) !!}

            @if ($errors->has('website'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>IEC CODE</label>
            {!! Form::number('iec_code', old('iec_code', (isset($company->iec_code) && $company->iec_code) ? $company->iec_code : ''), ['class' => 'form-control', 'id' => 'iec_code']) !!}
            @if ($errors->has('iec_code'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('iec_code') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>IEC APPLICABLE DATE</label>
            {!! Form::text('iec_applicable_date', old('iec_applicable_date', (isset($company->iec_applicable_date) && $company->iec_applicable_date) ? $company->iec_applicable_date : ''), ['class' => 'form-control datepicker', 'id' => 'iec_applicable_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('iec_applicable_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('iec_applicable_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>TAN NO</label>
            {!! Form::text('tan_no', old('tan_no', (isset($company->tan_no) && $company->tan_no) ? $company->tan_no : ''), ['class' => 'form-control', 'id' => 'tan_no']) !!}

            @if ($errors->has('tan_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('tan_no') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>TAN DATE</label>
            {!! Form::text('tan_date', old('tan_date', (isset($company->tan_date) && $company->tan_date) ? $company->tan_date : ''), ['class' => 'form-control datepicker', 'id' => 'tan_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('tan_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('tan_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            <label>Fiscal Start Date</label>
            {!! Form::text('fiscal_start_date', old('fiscal_start_date', (isset($company->fiscal_start_date) && $company->fiscal_start_date) ? $company->fiscal_start_date : ''), ['class' => 'form-control datepicker', 'id' => 'fiscal_start_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('fiscal_start_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fiscal_start_date') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            <label>Fiscal End Date</label>
            {!! Form::text('fiscal_end_date', old('fiscal_end_date', (isset($company->fiscal_end_date) && $company->fiscal_end_date) ? $company->fiscal_end_date : ''), ['class' => 'form-control datepicker', 'id' => 'fiscal_end_date', 'autocomplete' => 'off']) !!}

            @if ($errors->has('fiscal_end_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('fiscal_end_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
 <strong>Logo</strong>
        @if ("/images/post_images/{{ $company->logo_image }}")
        <img src="{{URL::to('/')}}/images/post_images/{{$company->logo_image}}" width="80">
        @else
            <p>No image found</p>
        @endif
        Logo <input type="file" name="logo_image" value=""/>

