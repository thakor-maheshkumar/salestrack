<fieldset class="scheduler-border" id="consignee-address">
    <legend class="scheduler-border">Consignee Address Details</legend>
            @if(!empty($consignee_addresses) && $ledger->consignee_address == 1)
            @foreach($consignee_addresses as $key=>$c) 
            <div class="form-group">
                {!! Form::label('branch_name', 'Branch Name') !!}
                {!! Form::text('branch_name[]', old('branch_name[0]', isset($c->branch_name) ? $c->branch_name : ''), ['class' => 'form-control consignee_addresses', 'placeholder' => 'Branch Name']) !!}
                @if ($errors->has('branch_name'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('branch_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('address', 'Address') !!}
                {!! Form::textarea('consignee_addresses[]',  old('consignee_addresses[0]', isset($c->address) ? $c->address : ''), ['class' => 'form-control consignee_addresses', 'rows' => 2 , 'id'=>'consignee_address_id']) !!}
                @if ($errors->has('consignee_addresses'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_addresses') }}</strong>
                    </span>
                @endif
            </div>
        <div class="diffrent">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        {!! Form::label('state', 'State') !!}
                        {!! Form::select('consignee_state_select[]',$states, old('consignee_state_select[0]', isset($c->state) ? $c->state : ''), ['class' => 'form-control state-dd',]) !!}
                        @if ($errors->has('consignee_state_select'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_state_select') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('city', 'City') !!}

                        {!! Form::select('consignee_city[]',$city, old('consignee_city[0]', isset($c->city) ? $c->city : ''), ['class' => 'form-control city-dd','disabled']) !!}
                       
                    </div>
                </div>
            </div>
        </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        {!! Form::label('pincode', 'Pincode') !!}
                        {!! Form::text('consignee_pincode[]', old('consignee_pincode[0]', isset($c->pincode) ? $c->pincode : ''), ['class' => 'form-control', 'placeholder' => 'Pincode']) !!}
                        @if ($errors->has('consignee_pincode'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_pincode') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('location', 'Location') !!}
                        {!! Form::select('consignee_location[]', ['0' => 'All'] + $territories, old('consignee_location[]', isset($c->location) ? $c->location : ''),['class' => 'form-control'] ) !!}
                        {{-- {!! Form::text('location', old('consignee_location[0]', isset($c->location) ? $c->location : ''), ['class' => 'form-control', 'placeholder' => 'Location']) !!} --}}
                        @if ($errors->has('consignee_location'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_location') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        {!! Form::label('mobile_no', 'Mobile No') !!}
                        {!! Form::text('consignee_mobile_no[]', old('consignee_mobile_no[]', isset($c->mobile_no) ? $c->mobile_no : ''), ['class' => 'form-control', 'placeholder' => 'Mobile No']) !!}
                        @if ($errors->has('consignee_mobile_no'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_mobile_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('landline_no', 'Landline No') !!}
                        {!! Form::text('consignee_landline_no[]', old('consignee_landline_no[]', isset($c->landline_no) ? $c->landline_no : ''), ['class' => 'form-control', 'placeholder' => 'Landline No']) !!}
                        @if ($errors->has('consignee_landline_no'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_landline_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        {!! Form::label('fax_no', 'Fax No') !!}
                        {!! Form::text('consignee_fax_no[]', old('consignee_fax_no[]', isset($c->fax_no) ? $c->fax_no : ''), ['class' => 'form-control', 'placeholder' => 'Fax no']) !!}
                        @if ($errors->has('consignee_fax_no'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_fax_no') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('website', 'Website') !!}
                        {!! Form::text('consignee_website[]', old('consignee_website[]', isset($c->website) ? $c->website : ''), ['class' => 'form-control', 'placeholder' => 'Website']) !!}
                        @if ($errors->has('consignee_website'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('consignee_website') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::hidden('consignee_address_id[]', old('consignee_address_id[]', isset($c->id) ? $c->id : ''), ['class' => 'form-control']) !!}
            <div class="form-group">
                <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{route($other->delete_consignee_address_link, ['address_id'=>$c->id,'ledger_id'=>$ledger->id])}}"><i class="fa fa-trash"></i></a>
            </div>
    @endforeach
    @endif
    <div id="more_consignee_address" class="more_consignee_address">
    <div class="form-group">
        {!! Form::label('branch_name', 'Branch Name') !!}
        {!! Form::text('branch_name[]', old('branch_name[0]',''), ['class' => 'form-control consignee_addresses', 'placeholder' => 'Branch Name','id'=>'gps']) !!}
        @if ($errors->has('branch_name'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('branch_name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('address', 'Address') !!}
        {!! Form::textarea('consignee_addresses[]',  old('consignee_addresses[0]',''), ['class' => 'form-control consignee_addresses', 'rows' => 2 , 'id'=>'consignee_address_id']) !!}
        @if ($errors->has('consignee_addresses'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('consignee_addresses') }}</strong>
            </span>
        @endif
    </div>
    <div class="diffrent">
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                <!-- {!! Form::label('city', 'City') !!}
                {!! Form::text('consignee_city[]', old('consignee_city[0]', ''), ['class' => 'form-control', 'placeholder' => 'City']) !!}
                @if ($errors->has('consignee_city'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_city') }}</strong>
                    </span>
                @endif -->
                {!! Form::label('state', 'State') !!}
                {!! Form::select('consignee_state_select[]', ['' => 'Select state'] + $states, old('state', isset($ledger->state) ? $ledger->state : null), ['class' => 'form-control state-dd', 'id' => 'state-dd','required']) !!}

                @if ($errors->has('state'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('state') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                <!-- {!! Form::label('state', 'State') !!}
                {!! Form::hidden('consignee_state[]', old('consignee_state[0]', ''), ['class' => 'consignee_state']) !!}
                {!! Form::select('consignee_state_select[]', $states, old('consignee_state[0]', ''), ['class' => 'form-control consignee_state', 'disabled']) !!}
                
                @if ($errors->has('consignee_state'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_state') }}</strong>
                    </span>
                @endif -->
                {!! Form::label('city', 'City') !!}
                {!! Form::select('consignee_city[]', ['' => 'Select city'] + $city , old('state', isset($ledger->city) ? $ledger->city : null), ['class' => 'form-control city-dd', 'id' => 'city-dd','disabled']) !!}
            </div>
        </div>
    </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('pincode', 'Pincode') !!}
                {!! Form::text('consignee_pincode[]', old('consignee_pincode[0]', ''), ['class' => 'form-control', 'placeholder' => 'Pincode']) !!}
                @if ($errors->has('consignee_pincode'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_pincode') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('location', 'Location') !!}
                {!! Form::select('consignee_location[]', ['0' => 'All'] + $territories, old('consignee_location[]', isset($c->location) ? $c->location : ''),['class' => 'form-control'] ) !!}
                {{-- {!! Form::text('location', old('consignee_location[0]', ''), ['class' => 'form-control', 'placeholder' => 'Location']) !!} --}}
                @if ($errors->has('consignee_location'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_location') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('mobile_no', 'Mobile No') !!}
                {!! Form::text('consignee_mobile_no[]', old('consignee_mobile_no[]',''), ['class' => 'form-control', 'placeholder' => 'Mobile No']) !!}
                @if ($errors->has('consignee_mobile_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_mobile_no') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('landline_no', 'Landline No') !!}
                {!! Form::text('consignee_landline_no[]', old('consignee_landline_no[]', ''), ['class' => 'form-control', 'placeholder' => 'Landline No']) !!}
                @if ($errors->has('consignee_landline_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_landline_no') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12">
                {!! Form::label('fax_no', 'Fax No') !!}
                {!! Form::text('consignee_fax_no[]', old('consignee_fax_no[]', ''), ['class' => 'form-control', 'placeholder' => 'Fax no']) !!}
                @if ($errors->has('consignee_fax_no'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_fax_no') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12">
                {!! Form::label('website', 'Website') !!}
                {!! Form::text('consignee_website[]', old('consignee_website[]', ''), ['class' => 'form-control', 'placeholder' => 'Website']) !!}
                @if ($errors->has('consignee_website'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('consignee_website') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    </div>
    
    <div class="form-group">
        {!! Form::Button('+', ['class' => 'btn btn-primary','id'=>'add_consignee_adderess']) !!}
    </div>
</fieldset>

@section('scripts')
    @parent
<!-- <script type="text/javascript">
    $(document).ready(function(){
        $('.state-ddA').on('change', function () {
                var idState = this.value;
                //alert(idState);
                $(".city-ddS").html('');
                $('.city-ddS').attr('readonly',false);
               /*  $('#state-ddA').attr('readonly',false);*/
            
                $.ajax({
                    url: "{{url('admin/masters/ledger/api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {

                        $('.city-ddS').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $(".city-ddS").append('<option value="' + value
                                .city + '">' + value.city + '</option>');

                        });
                    }
                });
            });
         
    })

</script> -->
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.state-dd', function(){
           
                var idState = this.value;

                var closest=$(this).closest('.diffrent').find(".city-dd");
                //console.log(closest)

                closest.html('');
                closest.prop('disabled',false);
                $.ajax({
                    url: "{{url('admin/masters/ledger/api/fetch-cities')}}",
                    type: "post",
                    data: {
                        state: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        closest.html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            closest.append('<option value="' + value
                                .city + '">' + value.city + '</option>');
                        });
                    }
                });
            });
        
    })
</script>
@endsection



