@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
    <div class="content">
                <h3 class="heading">Delivery Note Series</h3>
                <a href="{{route('deliveryseries.create')}}" class="btn btn-primary seriesadd" >Add</a>
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
                                @if(isset($deliverynoteseries) && count($deliverynoteseries) > 0)
                        
                                @foreach($deliverynoteseries as $key=>$value)
                                <ul class="list-group">
                                    
                                    <li class="list-group-item">{{$value->series_name}} {!! Form::open(['url' => route('deliveryseries.destroy', $value->id), 'method' => 'DELETE']) !!}

                                                        <button type="submit"  class="btn btn-danger confirm-action float-right btn-sm">Delete</button>
                                                    {!! Form::close(); !!}
                                                    <input type="radio" name="status[]" 
                                                    {{ $value->status == 'true' ? 'checked' : ''}} class="delivery_note_series" data-id="{{$value->id}}">
                                                    <a class="btn btn-success float-right btn-sm" href="{{ route('deliveryseries.edit', $value->id) }}">Edit</a></li>


                                </ul>

                                <ul>
                        
                                </ul>
                                @endforeach
                                @else

                                <ul class="list-group">
                                    <li class="list-group-item">No Purchase receipt series found<li>
                                @endif

                            </div>
                                
                            
                        </div>
                    </div>
                </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    var getdata="{{ url('admin/series/deliveryseriesdata') }}/";
</script>
<script type="text/javascript">
    $(document).ready(function(){
           $('.delivery_note_series').change(function(){
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
