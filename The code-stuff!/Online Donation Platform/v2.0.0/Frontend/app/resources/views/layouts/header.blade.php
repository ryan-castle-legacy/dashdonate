<!DOCTYPE html>
<html lang='en-gb'>
<head>
	<meta charset='utf-8'/>
	<meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
	<meta name='csrf-token' content='{{ csrf_token() }}'/>
	@if (@isset($page_title))
		<title>{{ $page_title }} - DashDonate.org</title>
	@else
		@if (@$charity && @$public_seo)
			@if (@$charity->details->display_name)
				<title>{{ $charity->details->display_name }} - DashDonate.org</title>
			@else
				<title>{{ $charity->name }} - DashDonate.org</title>
			@endif
		@else
			<title>DashDonate.org - A better way to donate.</title>
		@endif
	@endif
	<meta name='description' content='With more transparency, better control over your donations, and greater connection to the causes you care about - help us make fundraising more rewarding for everyone.'/>
	<link rel='icon' type='image/png' href='{{ asset('favicon.png') }}'/>
	<script type='text/javascript'>var chartData = {};</script>
	@yield('pre-scripts')
	<script src='{{ asset('js/jquery.js') }}' type='text/javascript'></script>
	<script src='{{ asset('js/bootstrap.js') }}' type='text/javascript'></script>
	<script src='{{ asset('js/graph.js') }}' type='text/javascript'></script>
	<script src='{{ asset('js/script.js') }}' type='text/javascript'></script>
	{{-- <script src='https://kit.fontawesome.com/ec5546fb0b.js' crossorigin='anonymous'></script> --}}
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-9ZfPnbegQSumzaE7mks2IYgHoayLtuto3AS6ieArECeaR8nCfliJVuLh/GaQ1gyM" crossorigin="anonymous">


	@yield('post-scripts')
	@yield('pre-styles')
	<link href='{{ asset('css/bootstrap.min.css') }}' rel='stylesheet' type='text/css'/>
	<link href='{{ asset('css/graph.css') }}' rel='stylesheet' type='text/css'/>
	{{-- <link href='{{ asset('css/fontawesome.min.css') }}' rel='stylesheet' type='text/css'/> --}}
	<link href='{{ asset('css/dashdonate.css') }}' rel='stylesheet' type='text/css'/>
	@yield('post-styles')


	{{-- <meta property="og:site_name" content="Scotch">
	<meta property="og:url" content="https://scotch.io">
	<meta property="og:type" content="website">
	/* or this depending content type */
	<meta property="og:type" content="article">
	<meta property="og:title" content="Scotch Web Development">
	<meta property="og:description" content="Scotch is a web development blog discussing all things programming, development, web, and life.">
	<meta property="og:image" content="https://scotch.io/wp-content/themes/scotch/img/scotch-home.jpg">
	<meta property="fb:app_id" content="1389892087910588"> --}}


	@if (env('APP_ENV') != 'dev')
		{{-- Hotjar.com Tracking Code--}}
		<script defer>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:1807865,hjsv:6};a=o.getElementsByTagName('head')[0];r=o.createElement('script');r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
		{{-- Google Analytics Tracking Code --}}
		<script defer async src='https://www.googletagmanager.com/gtag/js?id=UA-162206655-1'></script>
		<script defer>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','UA-162206655-1');</script>
	@endif
</head>
