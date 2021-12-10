@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => ''
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
		<div class="container">
			<div class="details-block">
				<div class="main-content--subblock">
					<h1>{{ $module->name }}</h1>
					<p class="subtitle">Alias : {{ $module->alias }}</p>
					<p class="subtitle">Type : {{ $types[$module->type] }}</p>
					@if($module->type == 1)
						<p class="subtitle">Table : {{ $module->table }}</p>
					@endif
				</div>

				@include('common.messages')
				@include('common.errors')

				@if($module->type == 1)
					<div class="module-details--subblock">
						<ul class="tabs responsive-tabs">
							<li rel="1" class="active">Table structure</li>
							<li rel="2">Relation view</li>
						</ul>
						<div class="tab_container">
							<!-- #tab1 -->
							<h3 class="d_active tab_drawer_heading" rel="1">Table structure</h3>
							<div id="1" class="tab_content db-table--content">
								<div class="row">
									@include('admin.modules.table_structure')
								</div>
							</div>

							<!-- #tab2 -->
							<h3 class="d_active tab_drawer_heading" rel="2">Relation view</h3>
							<div id="2" class="tab_content db-table--content">
								<div class="row">
									@include('admin.modules.relation_view')
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
    <!-- End: main-content -->
@endsection
