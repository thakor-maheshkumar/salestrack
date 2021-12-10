<div class="table-structure-block">
	<div class="table-wrapper table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Key</th>
					<th>Extra</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($columns))
					@foreach($columns as $column)
						<tr>
							<td>{{ $column->Field }}</td>
							<td>{{ $column->Type }}</td>
							<td>{{ $column->Key }}</td>
							<td>{{ $column->Extra }}</td>
							<td></td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>