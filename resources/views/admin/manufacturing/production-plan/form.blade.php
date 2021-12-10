<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('production-plan.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
    @error('plan_id')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
<!-- <div class="form-group">
    <label>Production Series</label>
<select class="form-control" id="select1" name="series_type">
    <option>Select Production Series</option>
    @foreach($productionplanseries as $key=>$value)
    <option value="{{ $value->id }}">{{ $value->series_name }}</option>
    @endforeach
</select> 
</div> -->
<div class="form-group">
    {!! Form::label('return_no', 'MR No *') !!}
           <!--  {!! Form::text('plan_id', old('plan_id', isset($order->return_no) ? $order->return_no : ''), ['class' => 'form-control series_id', 'id' => 'series_id','readonly' ]) !!}
            <input type="text" name="manual_id" class="form-control" id="manual_id"  style="display:none" >
            @if ($errors->has('manual_id'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('manual_id') }}</strong>
                </span>
            @endif
            <input type="hidden" name="suffix" id="suffix">
            <input type="hidden" name="prefix" id="prefix">
            <input type="hidden" name="series_starting_digits" id="series_starting_digits"> -->

            @foreach($productionplanseriestatus as $key => $value)
            @if($value->request_type=='automatic')
            <input type="text" name="plan_id" class="form-control" placeholder="MR NO" value="{{$value->prefix_static_character}}{{$value->series_current_digit}}{{$value->suffix_static_character}}" readonly>
            @else
            <input type="text" name="plan_id" class="form-control" placeholder="MR NO">
            @endif
            @endforeach
</div>

<div class="form-group">
    {!! Form::label('stock_item_id', 'Stock Item *') !!}
    {!! Form::select('stock_item_id', ['' => 'Select Item'] + $stock_items, old('stock_item_id', isset($item->stock_item_id) ? $item->stock_item_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_stock_item', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('warehouse_id', 'Select Warehouse') !!}
    {!! Form::select('warehouse_id', ['' => 'Select Warehouse'] + $warehouses, old('warehouse_id', isset($item->warehouse_id) ? $item->warehouse_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_warehouse_id']) !!}
</div>

<div class="form-group">
    {!! Form::label('production_date', 'Production Date') !!}
    {!! Form::text('production_date', old('production_date', isset($item->production_date) ? $item->production_date : date('d/m/Y')), ['class' => 'form-control datepicker', 'id'=>'production_date']) !!}
</div>

<div class="form-group">
    {!! Form::label('batch_id', 'Salect Batch') !!}
    {!! Form::select('batch_id', ['' => 'Select Batch'], old('batch_id', isset($item->batch_id) ? $item->batch_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_batch_id']) !!}
</div>


<div class="form-group">
    {!! Form::label('so_id', 'Sales Order') !!}
    {!! Form::select('so_id', ['' => 'Select Order'] + $sales_order, old('so_id', isset($item->so_id) ? $item->so_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_so_id']) !!}
</div>

<div class="form-group" id=bom_details>
    <div class="form-group">
        {!! Form::label('bom_id', 'BOM') !!}
        {!! Form::select('bom_id', ['' => 'Select BOM'], old('bom_id', isset($item->bom_id) ? $item->bom_id : ''), ['class' => 'form-control select2-elem','id'=>'production_plan_bom']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('quantity', 'No of Unit') !!}
        {!! Form::number('quantity', old('quantity', isset($order->quantity) ? $order->quantity : ''), ['class' => 'form-control plan_quantity','placeholder' => 'Quantity','id'=>'plan_quantity']) !!}
    </div>
</div>
<div id="bom_items"></div>
<div class="form-group">
    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('production-plan.index', 'Cancel', [], ['class' => 'btn    btn-info']) !!}
</div>
@section('scripts')
<script type="text/javascript">
    var getdata="{{ url('admin/manufacturing/productionplan/getdata/') }}/";
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#production_plan_stock_item').on('change',function(e){
            var stock_id = e.target.value;
            $.ajax({
                url: config.routes.url + '/admin/stock_bom/' + stock_id,
                type: 'GET',
                success:function(response) {
                    console.log(response.data);
                    let bom = $('#production_plan_bom');
                    bom.empty();

                    bom.append("<option value=''>Select BOM</option>");
                    $.each(response.data, function(key, value) {
                        bom.append("<option value='"+ key +"'>" + value + "</option>");
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });

            $.ajax({
                url: config.routes.url + '/admin/stock_batch/' + stock_id,
                type: 'GET',
                success:function(response) {
                    let batch = $('#production_plan_batch_id');
                    batch.empty();

                    batch.append("<option value=''>Select Batch</option>");
                    $.each(response.data, function(key, value) {
                        batch.append("<option value='"+ key +"'>" + value + "</option>");
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#production_plan_bom').on('change',function(e){
            var bom_id =  e.target.value;
            $.ajax({
                url: config.routes.url + '/admin/bom_items/' + bom_id,
                type: 'GET',
                dataType: 'html',
                success:function(response) {
                    console.log(response);
                    //$("#plan_quantity").val(response.quantity);
                    $("#bom_items").html(response);
                    $("#plan_quantity").val($("#temp_quantity").val());
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        $('.plan_quantity').on('focusout',function(){
            var quantity =  $(this).val();
            var bom_id = $("#production_plan_bom").val();
            $.ajax({
                url: config.routes.url + '/admin/plan_quantity_calc/' + bom_id+'/'+quantity,
                type: 'GET',
                success:function(response) {
                    //console.log(response.data);
                    $("#bom_items").html(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
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
        $("#select1").change(function(){
    var air_id =  $(this).val();
   $.ajax({
        type:"get",
        url:getdata+air_id,
        data:{'id':air_id},
        dataType:'json',
        success:function(data){
            console.log(data);
            if(data.request_type=='automatic'){
            if(data.suffix == "suffix" && data.prefix =="prefix")
            {
            $('#series_id').val(data.prefix_static_character+'XXXX'+data.suffix_static_character);
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val(data.suffix_static_character);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();  
            }
            else if(data.suffix=="suffix"){
            $('#series_id').val('XXXX'+data.suffix_static_character);
            $('#series_type').val(data.series_starting_digits);
            $('#suffix').val(data.suffix_static_character);
            $('#prefix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();
            }
            else if(data.prefix=="prefix") {
            $('#series_id').val(data.prefix_static_character+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            else {
            $('#series_id').val('XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_character);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            }
            else{
                $('#series_id').hide();
                $('#prefix').val('');
                $('#suffix').val('');
                $('#series_starting_digits').val('');
                $('#manual_id').show();
            }    
        }
   })
  });

    });
</script>
@endsection
