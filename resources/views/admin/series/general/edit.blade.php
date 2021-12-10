@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'companies'
])
@section('content')

    <!-- Start: main-content -->
    <div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Edit Supplier Request</h3>
                    </div>
                    <div class="card-body">
                        {{-- @include('common.messages') --}}
                        {{--
                            @include('common.errors')
                        --}}

                        <div class="error text-danger"></div>
                         
                    
                        {!! Form::open([
                                'route' => ['supplier.update',$supplierseries->id],
                                'method' => 'PUT',
                                'name' => 'add_series_form',
                                'id' => 'add_series_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button class="btn btn-success" type="submit">Update</button>
                                    <a class="btn btn-primary" href="{{ route('supplier.index') }}">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <b>Series Name *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="series_name" class="form-control"value="{{$supplierseries->series_name}}"
>
                                        @error('series_name')
                                        <b class="text-danger">{{ $message }}</b>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12 manual">
                                        <input type="radio" name="request_type" class="manual_hide" value="manual" {{ $supplierseries->request_type == 'manual' ? 'checked' : ''}}>Manual
                                        <input type="radio" name="request_type" class="manual_show" value="automatic" {{ $supplierseries->request_type == 'automatic' ? 'checked' : ''}}>Automatic
                                        @error('request_type')
                                        <b class="text-danger">{{ $message }}</b>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    @if($supplierseries->request_type=='manual')
                    <div class="material_request" style="display:none">   
                         <div class="form-group">
                            <input type="checkbox" name="prefix" id="checkprefix" value="prefix" {{ $supplierseries->prefix=='prefix' ? 'checked' : '' }}><b style="margin-left: 20px;">Prefix</b>
                            @if(!empty($supplierseries->prefix_static_character))
                            <div class="form-row" id="prefixstatticcharacter">
                                <b>Prefix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="prefix_static_character" class="form-control series_static_character" value="{{$supplierseries->prefix_static_character}}">
                                    </div>
                            </div>
                            @else
                            <div class="form-row" id="prefixstatticcharacter" style="display:none">
                                <b>Prefix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="prefix_static_character" class="form-control series_static_character" value="{{$supplierseries->prefix_static_character}}">
                                    </div>
                            </div>
                            @endif
                        </div>
                        @error('prefix_static_character')
                        <b class="text-danger">{{ $message }}</b>
                        @enderror
                        <div class="form-group">
                            <input type="checkbox" name="suffix" id="checksuffix" value="suffix" {{ $supplierseries->suffix=='suffix' ? 'checked' : '' }}><b style="margin-left:20px">Suffix</b>
                            @if(!empty($supplierseries->suffix_static_character))
                            <div class="form-row" id="suffixstaticcharacter">
                                 <b>Suffix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="suffix_static_character" class="form-control series_static_character" value="{{$supplierseries->suffix_static_character}}">
                                    </div>
                            </div>
                            @else
                            <div class="form-row" id="suffixstaticcharacter" style="display:none">
                                 <b>Suffix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="suffix_static_character" class="form-control series_static_character" value="{{$supplierseries->suffix_static_character}}">
                                    </div>
                            </div>
                            @endif
                        </div>
                        @error('suffix_static_character')
                        <b class="text-danger">{{ $message }}</b>
                        @enderror
                        <div class="form-group">
                            <div class="form-row">
                                <b>Series Starting Digits *:</b>
                                    <div class="col-md-6">
                                        <input type="number" name="series_starting_digits" class="form-control series_starting_digits" 
                                        value="{{$supplierseries->series_starting_digits}}">
                                        @error('series_starting_digits')
                                        <b class="text-danger">{{ $message }}</b>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="material_request">   
                        <div class="form-group">
                            <input type="checkbox" name="prefix" id="checkprefix" value="prefix" {{ $supplierseries->prefix=='prefix' ? 'checked' : '' }}><b style="margin-left: 20px;">Prefix</b>
                            @if(!empty($supplierseries->prefix_static_character))
                            <div class="form-row" id="prefixstatticcharacter">
                                <b>Prefix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="prefix_static_character" class="form-control series_static_character" id="prefix_static_character"  value="{{$supplierseries->prefix_static_character}}">
                                    </div>
                            </div>
                            @else
                            <div class="form-row" id="prefixstatticcharacter" style="display:none">
                                <b>Prefix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="prefix_static_character" class="form-control series_static_character" id="prefix_static_character" value="{{$supplierseries->prefix_static_character}}">
                                    </div>
                            </div>
                            @endif
                        </div>
                        @error('prefix_static_character')
                        <b class="text-danger">{{ $message }}</b>
                        @enderror

                        <div class="form-group">
                            <input type="checkbox" name="suffix" id="checksuffix" value="suffix" {{ 
                                $supplierseries->suffix=='suffix' ? 'checked' : '' }}><b style="margin-left:20px">Suffix</b>
                            @if(!empty($supplierseries->suffix_static_character))
                            <div class="form-row" id="suffixstaticcharacter">
                                 <b>Suffix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="suffix_static_character" class="form-control series_static_character" id="suffix_static_character" value="{{$supplierseries->suffix_static_character}}">
                                    </div>
                            </div>
                            @else
                            <div class="form-row" id="suffixstaticcharacter" style="display:none">
                                 <b>Suffix Static Character *:</b>
                                    <div class="col-md-6">
                                        <input type="text" name="suffix_static_character" class="form-control series_static_character" id="suffix_static_character" value="{{$supplierseries->suffix_static_character}}">
                                    </div>
                            </div>
                            @endif
                        </div>
                        @error('suffix_static_character')
                        <b class="text-danger">{{ $message }}</b>
                        @enderror
                        <div class="form-group">
                            <div class="form-row">
                                <b>Series Starting Digits *:</b>
                                    <div class="col-md-6">
                                        <input type="number" name="series_starting_digits" class="form-control series_starting_digits" 
                                        value="{{$supplierseries->series_starting_digits}}">
                                        @error('series_starting_digits')
                                        <b class="text-danger">{{ $message }}</b>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                     </div>
                     @endif
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button class="btn btn-success" type="submit">Update</button>
                                    <a class="btn btn-primary" href="{{ route('supplier.index') }}">Cancel</a>
                                </div>
                            </div>
                        </div>
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
    $(document).ready(function(){
        $('body').on('click','.manual_show',function(){
            $('.material_request').show();
            $('.prefix').attr('checked', true);
        });
        $('body').on('click','.manual_hide',function(){
            $('.material_request').hide();
            $('.prefix').attr('checked', false);
            $('.suffix').val('');
            $('.prefix').val('');
            $('.series_starting_digits').val('');
            $('.series_static_character').val('');
            $('#checkprefix').attr('checked',false);
            $('#checksuffix').attr('checked',false);

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
        $("input:checkbox#checkprefix").change(function() {
            var ischecked= $(this).is(':checked');
                if(ischecked)
                    $('#prefixstatticcharacter').show();
                else
                    $('#prefixstatticcharacter').hide();
                    $('#prefix_static_character').val('');

        });
        $("input:checkbox#checksuffix").change(function(){
            var ischeckedsuffix=$(this).is(':checked');
            if(ischeckedsuffix)
                    $('#suffixstaticcharacter').show();
                else
                    $('#suffixstaticcharacter').hide();
                    $('#suffix_static_character').val('');
        });
    })
</script>
@endsection
