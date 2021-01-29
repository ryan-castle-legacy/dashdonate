@include('layouts.header')
<body>
	@csrf
	<div id='app'>
		<form id='logout' action='{{ route('logout') }}' method='POST'>@csrf</form>
		@yield('modals')
		@include('layouts.navbar')
		<main>
			@yield('content')
			@if (@$needsFooter === false)
			@else
				@include('layouts.footer')
			@endif
		</main>
	</div>
	<script type='text/javascript'>var apiURL = "{{ env('API_URL') }}"; var s3URL = "{{ env('S3_URL') }}";</script>
</body>
</html>
