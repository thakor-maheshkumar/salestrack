@include('common.messages')
@include('common.errors')
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('transporter.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', old('name', isset($item->name) ? $item->name : ''), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    @if ($errors->has('name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('tansporter_id', 'Tansporter ID') !!}
            {!! Form::text('tansporter_id', old('tansporter_id', isset($item->tansporter_id) ? $item->tansporter_id : ''), ['class' => 'form-control tansporter_id', 'placeholder' => 'Tansporter ID']) !!}
            @if ($errors->has('tansporter_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('tansporter_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('gst_no', 'GST NO') !!}
            {!! Form::text('gst_no', old('gst_no', isset($item->gst_no) ? $item->gst_no : ''), ['class' => 'form-control gst_no', 'placeholder' => 'GST No']) !!}
            @if ($errors->has('gst_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('gst_no') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="form-group">
    <div class="form-row">
        <div class="col-md-12">
            {!! Form::label('doc_no', 'Doc No') !!}
            {!! Form::text('doc_no', old('doc_no', isset($item->doc_no) ? $item->doc_no : ''), ['class' => 'form-control doc_no', 'placeholder' => 'Doc No']) !!}
            @if ($errors->has('doc_no'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('doc_no') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-12">
            {!! Form::label('doc_date', 'Doc Date') !!}
            {!! Form::text('doc_date', old('doc_date', isset($item->doc_date) ? $item->doc_date : ''), ['class' => 'form-control datepicker doc_date', 'placeholder' => 'Doc Date', 'autocomplete' => 'off']) !!}
            @if ($errors->has('doc_date'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('doc_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('transporter.index', 'Cancel', [], ['class' => 'btn btn-info']) !!}
</div>
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
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
    })
</script>
@endsection