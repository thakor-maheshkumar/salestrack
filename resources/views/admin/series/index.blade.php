@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'dashboard'
])
@section('content')
    <div class="content">
                <h3 class="heading">Material Request Series</h3>
                <a href="{{ route('series.create') }}" class="btn btn-primary seriesadd">Add</a>
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
                                @if(isset($series) && count($series) > 0)
                                @foreach($series as $key=>$value)
                                <ul class="list-group">
                                    <li class="list-group-item">{{$value->series_name}} {!! Form::open(['url' => route('series.destroy', $value->id), 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="btn btn-danger confirm-action float-right btn-sm">Delete</button>
                                                    {!! Form::close(); !!}

                                                    <a class="btn btn-success float-right btn-sm" href="{{ route('series.edit', $value->id) }}">Edit</a></li>
                                </ul>
                                @endforeach
                                @else
                                <ul class="list-group">
                                    <li class="list-group-item">No Material Request found<li>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
           $("#successMessage").delay(2000).slideUp(300);
    });
</script>
@endsection