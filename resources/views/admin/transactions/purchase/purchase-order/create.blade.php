@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'purchase_order'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create {{$other->title}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route($other->store_link), 'id' => 'create_purchase_order', 'enctype' => 'multipart/form-data']) !!}
                            @include('admin.transactions.purchase.purchase-order.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/transactions/purchase/purchase-order/getdata/') }}/";
</script>
<script type="text/javascript">
$(document).ready(function(){
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
            if(data.suffix=="suffix" && data.prefix=="prefix")
            {
            $('#order_no').val(data.prefix_static_charcter+'XXXX'+data.suffix_static_charcter); 
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter)
            $('#suffix').val(data.suffix_static_charcter);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#order_no').show();
            $('#manual_id').hide();  
            }
            else if(data.suffix=="suffix"){
            $('#order_no').val('XXXX'+data.suffix_static_charcter);
            $('#series_type').val(data.series_starting_digits);
            $('#suffix').val(data.suffix_static_charcter);
            $('#prefix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#order_no').show();
            $('#manual_id').hide();
            }
            else if(data.prefix=="prefix") {
            $('#order_no').val(data.prefix_static_charcter+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#order_no').show();
            $('#manual_id').hide();   
            }
            else{
                 $('#order_no').val('XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide(); 
            }
            }
            else{
                $('#order_no').hide();
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