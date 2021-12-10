<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route($other->listing_link, 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Ledger Details</legend>
    <div class="form-group">
        {!! Form::label('ledger_name', 'Supplier Name *') !!}
        {!! Form::text('ledger_name', old('ledger_name', isset($ledger->ledger_name) ? $ledger->ledger_name : ''), ['class' => 'form-control', 'placeholder' => 'Ledger name']) !!}
        @if ($errors->has('ledger_name'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('ledger_name') }}</strong>
            </span>
        @endif
    </div>
   <!--  <div class="form-group">
        {!! Form::label('approved_vendor_code', 'Approved Vendor Code') !!}
        {!! Form::text('approved_vendor_code', old('approved_vendor_code', isset($ledger->approved_vendor_code) ? $ledger->approved_vendor_code : ''), ['class' => 'form-control approved_vendor_code'] ) !!}
    </div> -->
    @if(isset($ledger->approved_vendor_code))
    <div class="form-group">
            {!! Form::label('approved_vendor_code', 'Approved Vendor Code') !!}
                {!! Form::text('approved_vendor_code', old('approved_vendor_code', isset($ledger->approved_vendor_code) ? $ledger->approved_vendor_code : ''), ['class' => 'form-control', 'placeholder' => 'approved_vendor_code','readonly']) !!}
                @if ($errors->has('customer_number'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('customer_number') }}</strong>
                    </span>
                @endif
    </div>
    @elseif(!isset($ledger->approved_vendor_code))
    <div class="form-group">
                <label>Approved Vendor Code</label>
            @foreach($supplierseries as $key=>$value)
            <!-- <option value={{$value->series_current_digit}}>{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}</option> -->
            @if($value->request_type=='automatic')
            <input type="text" name="approved_vendor_code" class="form-control"  value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="approved_vendor_code" class="form-control" placeholder="Approved Vendor Code">
            @endif
            @endforeach
    </div>
    @endif
    <div class="form-group">
        {!! Form::label('supplier_group', 'Supplier Groups') !!}
        {!! Form::select('supplier_group', isset($supplier_groups) ?['' => ''] + $supplier_groups : [], isset($ledger->supplier_group) ? $ledger->supplier_group : '', ['class' => 'form-control'] ) !!}

        @if ($errors->has('supplier_group'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('supplier_group') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('under', 'Under') !!}
        {!! Form::hidden('under', isset($selected_group) ? $selected_group : '') !!}
        {!! Form::select('under', isset($groups) ? $groups : [], isset($selected_group) ? $selected_group : '', ['class' => 'form-control under_group', 'id' => 'under_group', 'disabled'] ) !!}

        @if ($errors->has('under'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('under') }}</strong>
            </span>
        @endif
    </div>
</fieldset>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Tax Details</legend>
    
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('gstin_uin', 'GSTIN/UIN ') !!}
                {!! Form::text('gstin_uin', old('gstin_uin', isset($ledger->gstin_uin) ? $ledger->gstin_uin : ''), ['class' => 'form-control', 'placeholder' => 'GSTIN/UIN']) !!}
                @if ($errors->has('gstin_uin'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('gstin_uin') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('gstin_applicable_date', 'GSTIN Applicable Date ') !!}
                {!! Form::text('gstin_applicable_date', old('gstin_applicable_date', isset($ledger->gstin_applicable_date) ? $ledger->gstin_applicable_date : ''), ['class' => 'form-control datepicker', 'placeholder' => 'GSTIN Applicable Date', 'autocomplete' => 'off']) !!}
                @if ($errors->has('gstin_applicable_date'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('gstin_applicable_date') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('gst_reg_type', 'GST Reg. Type') !!}
        {!! Form::select('gst_reg_type', isset($gstRegType) ? $gstRegType : [],  old('gst_reg_type', isset($ledger->gst_reg_type) ? $ledger->gst_reg_type : ''), ['class' => 'form-control']) !!}
        @if ($errors->has('gst_reg_type'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('gst_reg_type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('party_type', 'Party Type') !!}
        {!! Form::select('party_type', isset($partyType) ? $partyType : [],  old('party_type', isset($ledger->party_type) ? $ledger->party_type : ''), ['class' => 'form-control']) !!}
        @if ($errors->has('party_type'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('party_type') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('pan_it_no', 'PAN/IT No. ') !!}
                {!! Form::text('pan_it_no', old('pan_it_no', isset($ledger->pan_it_no) ? $ledger->pan_it_no : ''), ['class' => 'form-control', 'placeholder' => 'PAN/IT No.','id'=>'pan_it_no']) !!}
                @if ($errors->has('pan_it_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('pan_it_no') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('uid_no', 'UID No ') !!}
                {!! Form::text('uid_no', old('uid_no', isset($ledger->uid_no) ? $ledger->uid_no : ''), ['class' => 'form-control', 'placeholder' => 'UID No','id'=>'uid_no']) !!}
                @if ($errors->has('uid_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('uid_no') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Statutory Information</legend>
    <div class="form-group">
        {!! Form::label('is_tds_deductable', 'Is TDS deductable?') !!}
        <br/>
        {!! Form::radio('is_tds_deductable', 1, isset($ledger->is_tds_deductable) && ($ledger->is_tds_deductable == 1) ? true : false, ['id' => 'is_tds_deductable_yes']) !!}
        {!! Form::label('is_tds_deductable_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('is_tds_deductable', 0, (isset($ledger->is_tds_deductable) && ($ledger->is_tds_deductable == 0)) ? true : ((isset($ledger->is_tds_deductable) && ($ledger->is_tds_deductable == 1)) ? false : true), ['id' => 'is_tds_deductable_no']) !!}
        {!! Form::label('is_tds_deductable_no', 'No', ['class' => 'form-check-label']) !!}

        @if ($errors->has('is_tds_deductable'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('is_tds_deductable') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('include_assessable_value', 'Include in assessable value calculation for') !!}
                    {!! Form::select('include_assessable_value', isset($assessable) ? $assessable : [],  old('include_assessable_value', isset($ledger->include_assessable_value) ? $ledger->include_assessable_value : ''), ['class' => 'form-control']) !!}
                    @if ($errors->has('include_assessable_value'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('include_assessable_value') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('applicable', 'Applicable to') !!}
                    {!! Form::select('applicable', isset($applicable) ? $applicable : [],  old('applicable', isset($ledger->applicable) ? $ledger->applicable : ''), ['class' => 'form-control']) !!}
                    @if ($errors->has('applicable'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('applicable') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="scheduler-border">
    <legend class="scheduler-border">Mailing Details</legend>
      <div class="form-group">
         {!! Form::label('branchname', 'Branch Namess ') !!}
                {!! Form::text('branchname', old('branchname', isset($ledger->branchname) ? $ledger->branchname : ''), ['class' => 'form-control', 'placeholder' => 'Branch Name','id'=>'branchname']) !!}
                @if ($errors->has('branchname'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('branchname') }}</strong>
                    </span>
                @endif
    </div>
    <div class="form-group">
        {!! Form::label('address', 'Address *') !!}
        {!! Form::textarea('address',  old('address', isset($ledger->address) ? $ledger->address : ''), ['class' => 'form-control', 'rows' => 2]) !!}
        @if ($errors->has('address'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                <!-- {!! Form::label('city', 'City *') !!}
                {!! Form::text('city', old('city', isset($ledger->city) ? $ledger->city : ''), ['class' => 'form-control', 'placeholder' => 'City']) !!} -->
                {!! Form::label('state', 'State *') !!}
                {!! Form::select('state', ['' => 'Select state'] + $states, old('state', isset($ledger->state) ? $ledger->state : null), ['class' => 'form-control', 'id' => 'mailing_state']) !!}
                @if ($errors->has('state'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('state') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                <!-- {!! Form::label('state', 'State *') !!}
                {!! Form::select('state', ['' => 'Select state'] + $states, old('state', isset($ledger->state) ? $ledger->state : null), ['class' => 'form-control', 'id' => 'mailing_state']) !!} -->

                 <!-- {!! Form::label('city', 'City *') !!}
                {!! Form::text('city', old('city', isset($ledger->city) ? $ledger->city : ''), ['class' => 'form-control', 'placeholder' => 'City']) !!} -->

                {!! Form::label('city', 'City') !!}
                {!! Form::select('city', ['' => 'Select city'] + $city, old('state', isset($ledger->city) ? $ledger->city : null), ['class' => 'form-control', 'id' => 'city-dd','readonly']) !!}

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
                {!! Form::label('pincode', 'Pincode *') !!}
                {!! Form::number('pincode', old('pincode', isset($ledger->pincode) ? $ledger->pincode : ''), ['class' => 'form-control', 'placeholder' => 'Pincode']) !!}
                @if ($errors->has('pincode'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('pincode') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('location', 'Location') !!}
                {!! Form::select('location', ['0' => 'All'] + $territories, old('location', isset($ledger->location) ? $ledger->location : ''),['class' => 'form-control'] ) !!}
                {{-- {!! Form::text('location', old('location', isset($ledger->location) ? $ledger->location : ''), ['class' => 'form-control', 'placeholder' => 'Location']) !!} --}}
                @if ($errors->has('location'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('mobile_no', 'Mobile No *') !!}
                {!! Form::number('mobile_no', old('mobile_no', isset($ledger->mobile_no) ? $ledger->mobile_no : ''), ['class' => 'form-control', 'placeholder' => 'Mobile No']) !!}
                @if ($errors->has('mobile_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('mobile_no') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('landline_no', 'Landline No *') !!}
                {!! Form::number('landline_no', old('landline_no', isset($ledger->landline_no) ? $ledger->landline_no : ''), ['class' => 'form-control', 'placeholder' => 'Landline No']) !!}
                @if ($errors->has('landline_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('landline_no') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('fax_no', 'Fax No *') !!}
                {!! Form::number('fax_no', old('fax_no', isset($ledger->fax_no) ? $ledger->fax_no : ''), ['class' => 'form-control', 'placeholder' => 'Fax no']) !!}
                @if ($errors->has('fax_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('fax_no') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('website', 'Website *') !!}
                {!! Form::text('website', old('website', isset($ledger->website) ? $ledger->website : ''), ['class' => 'form-control', 'placeholder' => 'Website']) !!}
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
                {!! Form::label('email', 'Email *') !!}
                {!! Form::email('email', old('email', isset($ledger->email) ? $ledger->email : ''), ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('cc_email', 'Email(CC) *') !!}
                {!! Form::email('cc_email', old('cc_email', isset($ledger->cc_email) ? $ledger->cc_email : ''), ['class' => 'form-control', 'placeholder' => 'Email(CC)']) !!}
                @if ($errors->has('cc_email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('cc_email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</fieldset>
<hr />
<div class="form-group">
    {!! Form::label('consignee_address', 'Add more Consignee address?') !!}

    {!! Form::radio('consignee_address', 1, isset($ledger->consignee_address) && ($ledger->consignee_address == 1) ? true : false, ['class'=>'consignee_address_checkbox','id' => 'consignee_address_yes']) !!}
    {!! Form::label('consignee_address_yes', 'Yes', ['class' => 'form-check-label']) !!}

    {!! Form::radio('consignee_address', 0, isset($ledger->consignee_address) && ($ledger->consignee_address == 0) ? true : false, ['class'=>'consignee_address_checkbox','id' => 'consignee_address_no']) !!}
    {!! Form::label('consignee_address_no', 'No', ['class' => 'form-check-label']) !!}

    @include('admin.ledger.purchase.consinee_address')
</div>

<hr />
<div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('opening_balance', 'Opening Balance') !!}
                {{-- {!! Form::select('opening_balance', isset($opening_balances) ? $opening_balances : [], isset($ledger->opening_balance) ? $ledger->opening_balance : '', ['class' => 'form-control opening_balance', 'id' => 'opening_balance'] ) !!} --}}
                
                @if(isset($ledger->opening_balance))
                    <br/><span>{{$ledger->opening_balance}}</span>
                @else
                    {!! Form::select('opening_balance', isset($opening_balances) ? $opening_balances : [], isset($ledger->opening_balance) ? $ledger->opening_balance : '', ['class' => 'form-control opening_balance', 'id' => 'opening_balance','required'=>'required'] ) !!}
                @endif

                @if ($errors->has('opening_balance'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('opening_balance') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('opening_balance_amount', 'Opening Balance Amount') !!}
                {{--  {!! Form::text('opening_balance_amount', old('opening_balance_amount', isset($ledger->opening_balance_amount) ? $ledger->opening_balance_amount : ''), ['class' => 'form-control', 'placeholder' => 'Opening Balance Amount']) !!} --}}
                
                @if(isset($ledger->opening_balance_amount))
                    <br/><span>{{$ledger->opening_balance_amount}}</span>
                @else
                    {!! Form::text('opening_balance_amount', old('opening_balance_amount', isset($ledger->opening_balance_amount) ? $ledger->opening_balance_amount : ''), ['class' => 'form-control', 'placeholder' => 'Opening Balance Amount','required'=>'required']) !!}
                @endif

                @if ($errors->has('opening_balance_amount'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('opening_balance_amount') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
<div class="credit_block">
    <div class="form-group">
        {!! Form::label('maintain_balance_bill_by_bill', 'Maintain balance bill by bill?') !!}

        {!! Form::radio('maintain_balance_bill_by_bill', 1, isset($ledger->maintain_balance_bill_by_bill) && ($ledger->maintain_balance_bill_by_bill == 1) ? true : false, ['id' => 'maintain_balance_bill_by_bill_yes']) !!}
        {!! Form::label('maintain_balance_bill_by_bill_yes', 'Yes', ['class' => 'form-check-label']) !!}

        {!! Form::radio('maintain_balance_bill_by_bill', 0, isset($ledger->maintain_balance_bill_by_bill) && ($ledger->maintain_balance_bill_by_bill == 0) ? true : ((isset($ledger->maintain_balance_bill_by_bill) && ($ledger->maintain_balance_bill_by_bill == 1)) ? false : true), ['id' => 'maintain_balance_bill_by_bill_no']) !!}
        {!! Form::label('maintain_balance_bill_by_bill_no', 'No', ['class' => 'form-check-label']) !!}

        @if ($errors->has('maintain_balance_bill_by_bill'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('maintain_balance_bill_by_bill') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('default_credit_period', 'Default Credit period') !!}

                {!! Form::text('default_credit_period', old('default_credit_period', isset($ledger->default_credit_period) ? $ledger->default_credit_period : ''), ['class' => 'form-control', 'placeholder' => 'Credit period']) !!}
                @if ($errors->has('default_credit_period'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('default_credit_period') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('default_credit_amount', 'Default Credit Amount') !!}

                {!! Form::text('default_credit_amount', old('default_credit_amount', isset($ledger->default_credit_amount) ? $ledger->default_credit_amount : ''), ['class' => 'form-control', 'placeholder' => 'Credit amount']) !!}
                @if ($errors->has('default_credit_amount'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('default_credit_amount') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <!-- <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('opening_balance', 'Opening Balance') !!}
                {{-- {!! Form::select('opening_balance', isset($opening_balances) ? $opening_balances : [], isset($ledger->opening_balance) ? $ledger->opening_balance : '', ['class' => 'form-control opening_balance', 'id' => 'opening_balance'] ) !!} --}}
                
                @if(isset($ledger->opening_balance))
                    <br/><span>{{$ledger->opening_balance}}</span>
                @else
                    {!! Form::select('opening_balance', isset($opening_balances) ? $opening_balances : [], isset($ledger->opening_balance) ? $ledger->opening_balance : '', ['class' => 'form-control opening_balance', 'id' => 'opening_balance','required'=>'required'] ) !!}
                @endif

                @if ($errors->has('opening_balance'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('opening_balance') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('opening_balance_amount', 'Opening Balance Amount') !!}
                {{--  {!! Form::text('opening_balance_amount', old('opening_balance_amount', isset($ledger->opening_balance_amount) ? $ledger->opening_balance_amount : ''), ['class' => 'form-control', 'placeholder' => 'Opening Balance Amount']) !!} --}}
                
                @if(isset($ledger->opening_balance_amount))
                    <br/><span>{{$ledger->opening_balance_amount}}</span>
                @else
                    {!! Form::text('opening_balance_amount', old('opening_balance_amount', isset($ledger->opening_balance_amount) ? $ledger->opening_balance_amount : ''), ['class' => 'form-control', 'placeholder' => 'Opening Balance Amount','required'=>'required']) !!}
                @endif

                @if ($errors->has('opening_balance_amount'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('opening_balance_amount') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div> -->
    <div class="form-group">
        {!! Form::hidden('credit_days_during_voucher_entry', 0) !!}
        {!! Form::hidden('credit_amount_during_voucher_entry', 0) !!}
        {!! Form::hidden('active_interest_calculation', 0) !!}
    </div>
    {{--
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    {!! Form::label('credit_days_during_voucher_entry', 'Check for credit days during voucher entry?') !!}

                    {!! Form::radio('credit_days_during_voucher_entry', 1, isset($ledger->credit_days_during_voucher_entry) && ($ledger->credit_days_during_voucher_entry == 1) ? true : false, ['id' => 'credit_days_during_voucher_entry_yes']) !!}
                    {!! Form::label('credit_days_during_voucher_entry_yes', 'Yes', ['class' => 'form-check-label']) !!}

                    {!! Form::radio('credit_days_during_voucher_entry', 0, (isset($ledger->credit_days_during_voucher_entry) && ($ledger->credit_days_during_voucher_entry == 0)) ? true : ((isset($ledger->credit_days_during_voucher_entry) && ($ledger->credit_days_during_voucher_entry == 1)) ? false : true), ['id' => 'credit_days_during_voucher_entry_no']) !!}
                    {!! Form::label('credit_days_during_voucher_entry_no', 'No', ['class' => 'form-check-label']) !!}

                    @if ($errors->has('credit_days_during_voucher_entry'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('credit_days_during_voucher_entry') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-12">
                    {!! Form::label('credit_amount_during_voucher_entry', 'Check for credit amount during voucher entry?') !!}

                    {!! Form::radio('credit_amount_during_voucher_entry', 1, isset($ledger->credit_amount_during_voucher_entry) && ($ledger->credit_amount_during_voucher_entry == 1) ? true : false, ['id' => 'credit_amount_during_voucher_entry_yes']) !!}
                    {!! Form::label('credit_amount_during_voucher_entry_yes', 'Yes', ['class' => 'form-check-label']) !!}

                    {!! Form::radio('credit_amount_during_voucher_entry', 0, (isset($ledger->credit_amount_during_voucher_entry) && ($ledger->credit_amount_during_voucher_entry == 0)) ? true : ((isset($ledger->credit_amount_during_voucher_entry) && ($ledger->credit_amount_during_voucher_entry == 1)) ? false : true), ['id' => 'credit_amount_during_voucher_entry_no']) !!}
                    {!! Form::label('credit_amount_during_voucher_entry_no', 'No', ['class' => 'form-check-label']) !!}

                    @if ($errors->has('credit_amount_during_voucher_entry'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('credit_amount_during_voucher_entry') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('active_interest_calculation', 'Activate interest calculation?') !!}

            {!! Form::radio('active_interest_calculation', 1, isset($ledger->active_interest_calculation) && ($ledger->active_interest_calculation == 1) ? true : false, ['id' => 'active_interest_calculation_yes']) !!}
            {!! Form::label('active_interest_calculation_yes', 'Yes', ['class' => 'form-check-label']) !!}

            {!! Form::radio('active_interest_calculation', 0, (isset($ledger->active_interest_calculation) && ($ledger->active_interest_calculation == 0)) ? true : ((isset($ledger->active_interest_calculation) && ($ledger->active_interest_calculation == 1)) ? false : true), ['id' => 'active_interest_calculation_no']) !!}
            {!! Form::label('active_interest_calculation_no', 'No', ['class' => 'form-check-label']) !!}

            @if ($errors->has('active_interest_calculation'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('active_interest_calculation') }}</strong>
                </span>
            @endif
        </div>
    --}}
</div>
 <div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route($other->listing_link, 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            ///Code for enter stop submitting form ///
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
            //console.log($('input[name=consignee_address]:checked').val());
            if($('input[name=consignee_address]:checked').val() == 1)
            {
                $("#consignee-address").css('display','block');
                $("#add_consignee_adderess").css('display','block');
            }else{
                $("#consignee-address").css('display','none');
                $("#add_consignee_adderess").css('display','none');
            }
            $(".consignee_address_checkbox").change(function(){
                if($(this).val() == 1)
                {
                    $("#consignee-address").css('display','block');
                    $("#add_consignee_adderess").css('display','block');
                }else{
                    $("#consignee-address").css('display','none');
                    $("#add_consignee_adderess").css('display','none');
                }
            });

            if($("#mailing_state").val() != '')
            {
                $(document).find('#consignee-address .consignee_state').val($("#mailing_state").val());
            }

            $("#add_consignee_adderess").click( function(){
                var $values = $(".consignee_addresses[value!='']");
                if($values.last().val() == '')
                {
                    $($values.last()).focus();
                }else{
                    $(this).before($(document).find('#more_consignee_address').html());

                    $(document).find('#consignee-address .consignee_state').val($("#mailing_state").val());

                    //$('.reset-form').find('form')[0].reset();
                }
            });

            if(($('#under_group').val() == 13) || ($('#under_group').val() == 14))
            {
                $(".credit_block").css("display", 'block');
            }
            else {
                $(".credit_block").css("display", 'none');
            }

            $("#under_group").on("change", function() {
                if(($(this).val() == 13) || ($(this).val() == 14))
                {
                    $(".credit_block").css("display", 'block');
                }
                else
                {
                    $(".credit_block").css("display", 'none');
                }
            });

            $("#mailing_state").on("change", function() {
                if($(this).val() != '')
                {
                    $(document).find('#consignee-address .consignee_state').val($(this).val());
                    //$("#more_consignee_address .consignee_state").val($(this).val());
                }
            });

            $('input[type=radio][name=maintain_balance_bill_by_bill]').change(function() {
                if($(this).val()==1)
                {
                    $("#opening_balance").attr('disabled','disabled');
                    $("#opening_balance_amount").attr('disabled','disabled');

                    document.getElementById("opening_balance_amount").required = false;
                    document.getElementById("opening_balance").required = false;
                }else{
                    $("#opening_balance").removeAttr('disabled');
                    $("#opening_balance_amount").removeAttr('disabled');

                    document.getElementById("opening_balance_amount").required = true;
                    document.getElementById("opening_balance").required = true;
                }
            });
            $('#gst_reg_type').on('change',function(){
                var selected=$(this).val();
                if(selected==3 || selected==2){
                    $('#pan_it_no').prop('disabled',true);
                    $('#uid_no').prop('disabled',true);
                }else{
                      $('#pan_it_no').prop('disabled',false);
                      $('#uid_no').prop('disabled',false);   
                }
            });
               var gst_reg_type=$('#gst_reg_type').val();
               if(gst_reg_type==3){
                $('#pan_it_no').prop('disabled',true);
                $('#uid_no').prop('disabled',true);
               }

               $('#mailing_state').on('change', function () {

                var idState = this.value;
                //alert(idState);
                $("#city-dd").html('');
               
                $('#city-dd').attr('readonly',false);
                $.ajax({
                    url: "{{url('admin/masters/ledger/api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .city + '">' + value.city + '</option>');
                        });
                    }
                });
            }); 
        });
    </script>
@endsection
