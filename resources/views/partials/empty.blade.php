<div class="empty-content">
	<i class="glyphicon @if (!empty($icon))glyphicon-{{ $icon }}@else glyphicon-ok @endif"></i>
	@if (!empty($empty_text))
		<p>{{ $empty_text }}</p>
	@endif
</div>