@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'materials'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create Material Requests</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('materials.store'), 'id' => 'create_material']) !!}
                            @include('admin.transactions.purchase.materials.form')
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
    var getdata="{{ url('admin/transactions/purchase/materials/getdata/') }}/";
    
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
            if(data.suffix == "suffix" && data.prefix =="prefix")
            {
            $('#series_id').val(data.prefix_static_charcter+'XXXX'+data.suffix_static_charcter);
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter);
            $('#suffix').val(data.suffix_static_charcter);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();  
            }
            else if(data.suffix=="suffix"){
            $('#series_id').val('XXXX'+data.suffix_static_charcter);
            $('#series_type').val(data.series_starting_digits);
            $('#suffix').val(data.suffix_static_charcter);
            $('#prefix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();
            }
            else if(data.prefix=="prefix") {
            $('#series_id').val(data.prefix_static_charcter+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter);
            $('#suffix').val('');
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
             else{
                 $('#series_id').val('XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.prefix_static_charcter);
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

  $('#series_id').on('focusout',function(){
        var series_id=$(this).val();
        var testdata="{{url('admin/transactions/purchase/materials/getstatus')}}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:"get",
            url:'{{url("admin/transactions/purchase/getstatus")}}',
            success:function(dataResult){
               console.log(dataResult);

               /*var resultData = dataResult.data;
               console.log(resultData);*/
            }
        })
  })
});
</script>
@endsection
