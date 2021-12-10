<div class="flash-msg-block">
	@if($message && $message_type)
		<div class="alert alert-{{ $message_type }}">
	        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	        <i class="glyphicon glyphicon-{{ $message_type == 'success' ? 'ok' : 'remove'}}"></i> {{ $message }}
	    </div>
	@endif
</div>