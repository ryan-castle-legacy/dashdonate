@extends('../layouts.workflows-apply')

@section('content')
	@csrf
	<div class='workflow_apply_header flexi_container'>
		<h1>{{ $workflow->workflow->name }}</h1>
	</div>
	<div class='progress_header flexi_container'>
		<div class='progress_bar'>
			@php
				if ($workflow->stage_data->application_stage_count == 1) {
					$completion = 1;
				} else {
					$completion = ($workflow->stage_data->order - 1) / (($workflow->stage_data->application_stage_count - 1));
				}
			@endphp
			<div class='bar'><span class='fill' style='width: {{ $completion * 100 }}%;'></span></div>
			@php $passed = false; @endphp
			@for ($i = 0; $i < $workflow->stage_data->application_stage_count; $i++)
				@php
					if ($i + 1 == $workflow->stage_data->order) {
						$passed = true;
					}
				@endphp
				@if ($passed)
					@if ($i + 1 == $workflow->stage_data->order)
						<div class='stage current'>
					@else
						<div class='stage'>
					@endif
				@else
					<div class='stage passed'>
				@endif
					<div class='circle'><i>{{ $i + 1 }}</i><span>{{ @$workflow->stage_data->all_stages[$i]->name }}</span></div>
				</div>
			@endfor
		</div>
	</div>
	<div class='apply_review_container flexi_container'>
		{!! @$workflow->stage_data->content->content !!}
		<div class='text-center mt-3'>
		</div>
	</div>
@endsection

@section('post-content')
	<div id='toast_container'></div>

	@include('internal/workflows/modals/file-upload')
@endsection

@section('pre-scripts')
	<script type='text/javascript'>
		var quiz = @json($workflow)
	</script>
@endsection
