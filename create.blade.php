@extends('layouts.backend.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/css/icheck.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('asset/plugins/jquery-ui/jquery-ui.css') }}">
                                                       
@endpush
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{asset('asset')}}/#">Home</a></li>
              <li class="breadcrumb-item active">Transaction</li>
              <li class="breadcrumb-item active">Purchase Order</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <!-- /.card -->
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Purchase Order Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="post" action="{{ route('purchase-order.store') }}">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <div class="col-md-6">
                    <label for="inputEmail3" class="col-sm-6 col-form-label">Date</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="date" placeholder="Date" name="date">
                    </div>  
                    </div>
                     <div class="col-md-6">
                    <label for="inputEmail3" class="col-sm-6 col-form-label">Invoice No</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="inputEmail3" placeholder="Invoice No" name="invoice_no">
                    </div>  
                    </div>                 
                  </div>
                  <div class="form-group row">
                  <div class="col-md-12">  
                   <label for="inputEmail3" class="col-sm-6 col-form-label">Information</label>
                   <textarea class="form-control" name="information"></textarea>
                  </div>
                  </div>
                   <div class="form-group row">
                      <div class="col-md-12">  
                      <label for="inputEmail3" class="col-sm-6 col-form-label">Supplier Name</label>
                       </div>
                      <div class="col-sm-4"> 
                      <input type="hidden" name="id_ven" id="id_ven" readonly="true" class="form-control">
                      <input type="text" name="name_ven" id="name_ven" readonly="true" class="form-control" placeholder="Supplier Name">
                      </div>
                      <div class="col-sm-4"> 
                      <a href="/trasaction/purchase-order/vendor/popup_media" class="btn btn-info" title="Vendor" data-toggle="modal" data-target="#modal-default">Supplier</a>
                      </div>                  
                     
                  </div>
                  <div class="col-md-12 fieldWrapper">                  
                  <div class="form-group row">
                    <div class="col-md-12">
                      <label>Product Name</label>
                    </div>
                      <div class="col-sm-3">
                        <input type="hidden" name="id_raw_product[]" id="id_raw_product_1" class="form-control" placeholder="Product Name" readonly="true">
                        <input type="text" name="name_raw_product[]" id="name_raw_product_1" class="form-control" placeholder="Product Name" readonly="true">
                      </div>
                      <div class="col-sm-2">
                        <a href="/trasaction/purchase-order/product/popup_media/1" class="btn btn-info" data-toggle="modal" data-target="#modal-default">Product</a>
                      </div>
                   
                       <div class="col-sm-3">
                        <input type="text" name="price[]" id="price_1" class="form-control">
                      </div>
                      <div class="col-sm-2">
                        <input type="text" name="total[]" id="total_1" class="form-control">
                      </div>
                       <div class="col-sm-2">
                       <a href="javascript:;void(0)" class="btn btn-primary addButton" title="Add Row"><i class="fas -fa-plus"></i></a>
                      </div>
                    </div>
                  </div>
               
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-default float-right">Submit</button>
                  
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Default Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
            </div>
           
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    <!-- /.content -->
   
@endsection
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
  var addButton=$('.addButton');
  var fieldWrapper=$('.fieldWrapper');
  var x="{{ $count_detail+1 }}";
   $(addButton).click(function(){
    x++;
    $(fieldWrapper).append(
      '<div class="form-group row">'
                     +'<div class="col-sm-3">'
                      +'<input type="hidden" name="id_raw_product[]" id="id_raw_product_'+x+'" class="form-control" placeholder="Product Name" readonly="true">'+
                        '<input type="text" name="name_raw_product[]" id="name_raw_product_'+x+'" class="form-control" placeholder="Product Name" readonly="true">'+
                      '</div>'+
                      '<div class="col-sm-2">'
                        +'<a href="/trasaction/purchase-order/product/popup_media/'+x+'" class="btn btn-info" data-toggle="modal" data-target="#modal-default">Product</a>'
                      +'</div>'
                   
                       +'<div class="col-sm-3">'
                        +'<input type="text" name="price[]" id="price_'+x+'" class="form-control">'+
                      '</div>'+
                      '<div class="col-sm-2">'+
                        '<input type="text" name="total[]" id="total_'+x+'" class="form-control" placeholder="total">'+
                      '</div>'+
                       '<div class="col-sm-2">'+
                       '<a href="javascript:;void(0)" class="btn btn-danger remove" title="Add Row">Remove</a>'+
                      '</div>'
                    +'</div>'
                  +'</div>'
      );
  });
   $(fieldWrapper).on('click','.remove',function(e){
    if(confirm("Are you")){
      e.preventDefault(e)
    $(this).parent().parent().remove();
}
  });
  });
</script>
<script type="text/javascript">
  $(function(){
    $('#date').datepicker({
      autoclose:true,
      dateFormat:'dd-mm-yy',
    });
  })
</script>
<script type="text/javascript">
  $('#modal-default').bind("show.bs.modal",function(e){
    var link=$(e.relatedTarget);
    $(this).find('.modal-body').load(link.attr("href"));
  })
</script>
@endpush