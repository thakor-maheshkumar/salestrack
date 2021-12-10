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
                        <h3 class="card-title">Edit Material</h3>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('materials.update', $material->id), 'method' => 'PUT', 'id' => 'update_material']) !!}
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
                if(data.prefix=="suffix"){
            $('#series_id').val('XXXX'+data.series_static_character);
            $('#series_type').val(data.series_starting_digits);
            $('#suffix').val(data.series_static_character);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();
            }
            else{
            $('#series_id').val(data.series_static_character+'XXXX');
            $('#series_type').val(data.series_starting_digits);
            $('#prefix').val(data.series_static_character);
            $('#series_starting_digits').val(data.series_starting_digits);
            $('#series_id').show();
            $('#manual_id').hide();   
            }
            }
            else{
                $('#series_id').hide();
                $('#manual_id').show();
            }       
        }
   })
  });
});
</script>
@endsection