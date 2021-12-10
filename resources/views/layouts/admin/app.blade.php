@extends('layouts.admin.master')

@section('body_class', 'hold-transition sidebar-mini layout-fixed')

@section('page')
	<!-- Navigation And Header-->
	@include('layouts.admin.partials.header')

	@include('layouts.admin.partials.sidebar')

    @yield('content')

	@include('layouts.admin.partials.footer')

@stop