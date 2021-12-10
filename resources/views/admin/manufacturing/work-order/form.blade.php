<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('work-order.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
<div class="form-group">
    {!! Form::label('plan_id', 'Production Plan') !!}
    {!! Form::select('plan_id', ['' => 'Select Plan'] + $plans, old('plan_id', isset($item->plan_id) ? $item->plan_id : ''), ['class' => 'form-control','id'=>'work_order_plan_id', 'required' => 'required']) !!}
</div>
<div id="plan_items"></div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('work-order.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#work_order_plan_id').on('change',function(e){
            var plan_id = e.target.value;
            window.location.href = config.routes.url + '/admin/production_plan_items/' + plan_id;
            /*$.ajax({
                url: config.routes.url + '/admin/production_plan_items/' + plan_id,
                type: 'GET',
                success:function(response) {
                    console.log(response.data);
                    $("#plan_items").html(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });*/
        });
    });
</script>
@endsection