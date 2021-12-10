@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
    <div class="content">
                <h3 class="heading">Work Order Series</h3>
                <a href="{{ route('workorder.create') }}" class="btn btn-primary seriesadd">Add</a>
                {{-- @include('common.messages')
                    
                @include('common.errors') --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block" id="successMessage">
                        
                        <strong>{{ $message }}</strong>
                        </div>
                @endif
                <div>
                    <div class="list-group">
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($workorder) && count($workorder) > 0)
                                @foreach($workorder as $key=>$value)
                                <ul class="list-group">
                                    <li class="list-group-item">{{$value->series_name}} {!! Form::open(['url' => route('workorder.destroy', $value->id), 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="btn btn-danger confirm-action float-right btn-sm">Delete</button>
                                                    {!! Form::close(); !!}
                                                    <input type="radio" name="status[]" 
                                                    {{ $value->status == 'true' ? 'checked' : ''}} class="work_order_series" data-id="{{$value->id}}">
                                                    <a class="btn btn-success float-right btn-sm" href="{{ route('workorder.edit', $value->id) }}">Edit</a></li>
                                </ul>
                                @endforeach
                                @else
                                <ul class="list-group">
                                    <li class="list-group-item">No Work order series found<li>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/series/workorderseries') }}/";
</script>
<script type="text/javascript">
    $(document).ready(function(){
           $("#successMessage").delay(2000).slideUp(300);
            $('.work_order_series').change(function(){
                var series_id=$(this).attr('data-id');
                $.ajax({
                    type:"get",
                    url:getdata+series_id,
                    dataType:'json',
                    success:function(data){
                    $('#mahi').val(data.prefix_static_character);
                    }
                })
           })
    });
</script>
@endsection
