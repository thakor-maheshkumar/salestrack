@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('materials.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<!-- <div class="form-group">
     <label>Select Series</label>
        @if(isset($material))
           <select class="form-control select1"  name="series_type" disabled="true">
                <option>Select Series</option> 
                    @if(!empty($seriesname))
                        @foreach($seriesname as $value)
                            <option value="{{ $value->id }}" @if(isset($material->series_type)) @if($material->series_type == $value->id){{"selected='selected'"}}{{ 'readonly' }} @endif @endif> {{ $value->series_name }} </option>
                        @endforeach
                    @endif
            </select>
        @else
        <select class="form-control select1"  name="series_type">
                <option>Select Series</option> 
                    @if(!empty($seriesname))
                        @foreach($seriesname as $value)
                            <option value="{{ $value->id }}" @if(isset($material->series_type)) @if($material->series_type == $value->id){{"selected='selected'"}}{{ 'readonly' }} @endif @endif> {{ $value->series_name }} </option>
                        @endforeach
                    @endif
            </select>
        @endif 
</div> -->
<!-- <div class="form-group">
    {!! Form::label('mr no', 'MR No *') !!}
    {!! Form::text('series_id', old('series_id', isset($material->series_id) ? $material->series_id : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly'=>'readonly' ]) !!}
    
    <input type="text" name="manual_id" class="form-control" id="manual_id" style="display:none">
    <input type="hidden" name="suffix" id="suffix">
    <input type="hidden" name="prefix" id="prefix">
    <input type="hidden" name="series_starting_digits" id="series_starting_digits">

    @if ($errors->has('manual_id'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('manual_id') }}</strong>
        </span>
    @endif
</div> -->
@if(isset($material->series_id))
    <div class="form-group">
            {!! Form::label('series_id', 'MR No *') !!}
                {!! Form::text('series_id', old('series_id', isset($material->series_id) ? $material->series_id : ''), ['class' => 'form-control', 'placeholder' => 'MR No','readonly']) !!}
                @if ($errors->has('series_id'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('series_id') }}</strong>
                    </span>
                @endif
    </div>
    @elseif(!isset($material->series_id))
    <div class="form-group">
                <label>MR No</label>
            @foreach($materialseries as $key=>$value)
            <!-- <option value={{$value->series_current_digit}}>{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}</option> -->
            @if($value->request_type=='automatic')
            <input type="text" name="series_id" class="form-control"  value="{{$value->prefix_static_charcter}}{{$value->series_current_digit}}{{$value->suffix_static_charcter}}" id="testMahesh" readonly>
            @else
             <input type="text" name="series_id" class="form-control" placeholder="MR No" id="series_id">
             @endif
            @endforeach
    </div>
    @endif
<div class="form-group">
    {!! Form::label('required_date', 'Required Date *') !!}
    {!! Form::text('required_date', old('required_date', isset($material->required_date) ? $material->required_date : ''), ['class' => 'form-control datepicker', 'id' => 'date_of_birth', 'autocomplete' => 'off']) !!}
    @if ($errors->has('required_date'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('required_date') }}</strong>
        </span>
    @endif
   </div>
<div class="form-group">
    {!! Form::label('type', 'Type') !!}
    {!! Form::select('type', $material_type, old('type', isset($material->type) ? $material->type : ''), ['class' => 'form-control','required'=>'required'] ) !!}
    @if ($errors->has('type'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('type') }}</strong>
        </span>
    @endif
</div>

@include('admin.transactions.purchase.materials.item')

<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('materials.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>



