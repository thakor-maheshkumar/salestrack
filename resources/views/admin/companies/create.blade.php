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
                        <h3 class="card-title">Update Company</h3>
                    </div>
                    <div class="card-body">
                        @include('common.messages')
                        {{--
                            @include('common.errors')
                        --}}

                        <div class="error text-danger"></div>

                        {!! Form::open([
                                'route' => ['companies.store'],
                                'method' => 'POST',
                                'name' => 'add_company_form',
                                'id' => 'add_company_form',
                                'autocomplete' => 'off',
                                'enctype' => 'multipart/form-data'
                            ])
                        !!}
                            <div class="row">
                                <div class="col-md-24">
                                    @include('admin.companies.form')
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-24">
                                    <div class="form-group">
                                        {!! Form::submit('Update',['class' =>'btn btn-primary btn-submit', 'id' => 'update_company_btn']) !!}
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
