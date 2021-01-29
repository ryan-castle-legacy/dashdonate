
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>Bootstrap TLDR</title>
    <meta name="description" content="All Bootstrap's components in one page. Briefly presented with their own CSS selectors.">
    <meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="{{ asset('ui_kit/fonts/fontawesome.all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ui_kit/styles_1.css') }}">
	<link rel="stylesheet" href="{{ asset('ui_kit/styles_main.css') }}">
	<script defer src="{{ asset('js/jquery.js') }}"></script>
    <script defer src="{{ asset('ui_kit/modernizr.js') }}"></script>
  </head>
  <body data-spy="scroll" data-target="#sidebar">
    <!--[if lt IE 10]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" type="button">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="{{ route('ui_kit') }}">Theme</a>
          <a class="navbar-brand" href="{{ route('ui_kit_fontawesome_cheatsheet') }}">Font Awesome Cheatsheet</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#css">CSS</a></li>
            <li><a href="#components">Components</a></li>
            <li><a href="#javascript">Javascript</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <p><strong>.container .row .col-md-9</strong></p>

<h2 id="fontawesome">Font Awesome</h2>
<p>
  <a href="http://fontawesome.com/" target="_blank">Font Awesome</a> classes:
  <code>far fa-*</code>, <code>fas fa-*</code> or <code>fab fa-*</code>.
</p>
<h3 id='fontawesome_regular'>Regular Icons</h3>
<table class="table table-responsive-lg table-hover">
	<thead>
		<tr>
			<th>Icon</th>
			<th>CSS Reference</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><i class='far fa-address-book'></i></td>
			<td><code>far fa-address-book</code></td>
		</tr>
		<tr>
			<td><i class='far fa-address-card'></i></td>
			<td><code>far fa-address-card</code></td>
		</tr>
		<tr>
			<td><i class='far fa-angry'></i></td>
			<td><code>far fa-angry</code></td>
		</tr>
		<tr>
			<td><i class='far fa-arrow-alt-circle-down'></i></td>
			<td><code>far fa-arrow-alt-circle-down</code></td>
		</tr>
		<tr>
			<td><i class='far fa-arrow-alt-circle-left'></i></td>
			<td><code>far fa-arrow-alt-circle-left</code></td>
		</tr>
		<tr>
			<td><i class='far fa-arrow-alt-circle-right'></i></td>
			<td><code>far fa-arrow-alt-circle-right</code></td>
		</tr>
		<tr>
			<td><i class='far fa-arrow-alt-circle-up'></i></td>
			<td><code>far fa-arrow-alt-circle-up</code></td>
		</tr>
		<tr>
			<td><i class='far fa-bell'></i></td>
			<td><code>far fa-bell</code></td>
		</tr>
		<tr>
			<td><i class='far fa-bell-slash'></i></td>
			<td><code>far fa-bell-slash</code></td>
		</tr>
		<tr>
			<td><i class='far fa-bookmark'></i></td>
			<td><code>far fa-bookmark</code></td>
		</tr>
		<tr>
			<td><i class='far fa-building'></i></td>
			<td><code>far fa-building</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar'></i></td>
			<td><code>far fa-calendar</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar-alt'></i></td>
			<td><code>far fa-calendar-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar-check'></i></td>
			<td><code>far fa-calendar-check</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar-minus'></i></td>
			<td><code>far fa-calendar-minus</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar-plus'></i></td>
			<td><code>far fa-calendar-plus</code></td>
		</tr>
		<tr>
			<td><i class='far fa-calendar-times'></i></td>
			<td><code>far fa-calendar-times</code></td>
		</tr>
		<tr>
			<td><i class='far fa-caret-square-down'></i></td>
			<td><code>far fa-caret-square-down</code></td>
		</tr>
		<tr>
			<td><i class='far fa-caret-square-left'></i></td>
			<td><code>far fa-caret-square-left</code></td>
		</tr>
		<tr>
			<td><i class='far fa-caret-square-right'></i></td>
			<td><code>far fa-caret-square-right</code></td>
		</tr>
		<tr>
			<td><i class='far fa-caret-square-up'></i></td>
			<td><code>far fa-caret-square-up</code></td>
		</tr>
		<tr>
			<td><i class='far fa-chart-bar'></i></td>
			<td><code>far fa-chart-bar</code></td>
		</tr>
		<tr>
			<td><i class='far fa-check-circle'></i></td>
			<td><code>far fa-check-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-check-square'></i></td>
			<td><code>far fa-check-square</code></td>
		</tr>
		<tr>
			<td><i class='far fa-circle'></i></td>
			<td><code>far fa-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-clipboard'></i></td>
			<td><code>far fa-clipboard</code></td>
		</tr>
		<tr>
			<td><i class='far fa-clock'></i></td>
			<td><code>far fa-clock</code></td>
		</tr>
		<tr>
			<td><i class='far fa-clone'></i></td>
			<td><code>far fa-clone</code></td>
		</tr>
		<tr>
			<td><i class='far fa-closed-captioning'></i></td>
			<td><code>far fa-closed-captioning</code></td>
		</tr>
		<tr>
			<td><i class='far fa-comment'></i></td>
			<td><code>far fa-comment</code></td>
		</tr>
		<tr>
			<td><i class='far fa-comment-alt'></i></td>
			<td><code>far fa-comment-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-comment-dots'></i></td>
			<td><code>far fa-comment-dots</code></td>
		</tr>
		<tr>
			<td><i class='far fa-comments'></i></td>
			<td><code>far fa-comments</code></td>
		</tr>
		<tr>
			<td><i class='far fa-compass'></i></td>
			<td><code>far fa-compass</code></td>
		</tr>
		<tr>
			<td><i class='far fa-copy'></i></td>
			<td><code>far fa-copy</code></td>
		</tr>
		<tr>
			<td><i class='far fa-copyright'></i></td>
			<td><code>far fa-copyright</code></td>
		</tr>
		<tr>
			<td><i class='far fa-credit-card'></i></td>
			<td><code>far fa-credit-card</code></td>
		</tr>
		<tr>
			<td><i class='far fa-dizzy'></i></td>
			<td><code>far fa-dizzy</code></td>
		</tr>
		<tr>
			<td><i class='far fa-dot-circle'></i></td>
			<td><code>far fa-dot-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-edit'></i></td>
			<td><code>far fa-edit</code></td>
		</tr>
		<tr>
			<td><i class='far fa-envelope'></i></td>
			<td><code>far fa-envelope</code></td>
		</tr>
		<tr>
			<td><i class='far fa-envelope-open'></i></td>
			<td><code>far fa-envelope-open</code></td>
		</tr>
		<tr>
			<td><i class='far fa-eye'></i></td>
			<td><code>far fa-eye</code></td>
		</tr>
		<tr>
			<td><i class='far fa-eye-slash'></i></td>
			<td><code>far fa-eye-slash</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file'></i></td>
			<td><code>far fa-file</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-alt'></i></td>
			<td><code>far fa-file-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-archive'></i></td>
			<td><code>far fa-file-archive</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-audio'></i></td>
			<td><code>far fa-file-audio</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-code'></i></td>
			<td><code>far fa-file-code</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-excel'></i></td>
			<td><code>far fa-file-excel</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-image'></i></td>
			<td><code>far fa-file-image</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-pdf'></i></td>
			<td><code>far fa-file-pdf</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-powerpoint'></i></td>
			<td><code>far fa-file-powerpoint</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-video'></i></td>
			<td><code>far fa-file-video</code></td>
		</tr>
		<tr>
			<td><i class='far fa-file-word'></i></td>
			<td><code>far fa-file-word</code></td>
		</tr>
		<tr>
			<td><i class='far fa-flag'></i></td>
			<td><code>far fa-flag</code></td>
		</tr>
		<tr>
			<td><i class='far fa-flushed'></i></td>
			<td><code>far fa-flushed</code></td>
		</tr>
		<tr>
			<td><i class='far fa-folder'></i></td>
			<td><code>far fa-folder</code></td>
		</tr>
		<tr>
			<td><i class='far fa-folder-open'></i></td>
			<td><code>far fa-folder-open</code></td>
		</tr>
		<tr>
			<td><i class='far fa-frown'></i></td>
			<td><code>far fa-frown</code></td>
		</tr>
		<tr>
			<td><i class='far fa-frown-open'></i></td>
			<td><code>far fa-frown-open</code></td>
		</tr>
		<tr>
			<td><i class='far fa-futbol'></i></td>
			<td><code>far fa-futbol</code></td>
		</tr>
		<tr>
			<td><i class='far fa-gem'></i></td>
			<td><code>far fa-gem</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grimace'></i></td>
			<td><code>far fa-grimace</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin'></i></td>
			<td><code>far fa-grin</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-alt'></i></td>
			<td><code>far fa-grin-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-beam'></i></td>
			<td><code>far fa-grin-beam</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-beam-sweat'></i></td>
			<td><code>far fa-grin-beam-sweat</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-hearts'></i></td>
			<td><code>far fa-grin-hearts</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-squint'></i></td>
			<td><code>far fa-grin-squint</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-squint-tears'></i></td>
			<td><code>far fa-grin-squint-tears</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-stars'></i></td>
			<td><code>far fa-grin-stars</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-tears'></i></td>
			<td><code>far fa-grin-tears</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-tongue'></i></td>
			<td><code>far fa-grin-tongue</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-tongue-squint'></i></td>
			<td><code>far fa-grin-tongue-squint</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-tongue-wink'></i></td>
			<td><code>far fa-grin-tongue-wink</code></td>
		</tr>
		<tr>
			<td><i class='far fa-grin-wink'></i></td>
			<td><code>far fa-grin-wink</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-lizard'></i></td>
			<td><code>far fa-hand-lizard</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-paper'></i></td>
			<td><code>far fa-hand-paper</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-peace'></i></td>
			<td><code>far fa-hand-peace</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-point-down'></i></td>
			<td><code>far fa-hand-point-down</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-point-left'></i></td>
			<td><code>far fa-hand-point-left</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-point-right'></i></td>
			<td><code>far fa-hand-point-right</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-point-up'></i></td>
			<td><code>far fa-hand-point-up</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-pointer'></i></td>
			<td><code>far fa-hand-pointer</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-rock'></i></td>
			<td><code>far fa-hand-rock</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-scissors'></i></td>
			<td><code>far fa-hand-scissors</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hand-spock'></i></td>
			<td><code>far fa-hand-spock</code></td>
		</tr>
		<tr>
			<td><i class='far fa-handshake'></i></td>
			<td><code>far fa-handshake</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hdd'></i></td>
			<td><code>far fa-hdd</code></td>
		</tr>
		<tr>
			<td><i class='far fa-heart'></i></td>
			<td><code>far fa-heart</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hospital'></i></td>
			<td><code>far fa-hospital</code></td>
		</tr>
		<tr>
			<td><i class='far fa-hourglass'></i></td>
			<td><code>far fa-hourglass</code></td>
		</tr>
		<tr>
			<td><i class='far fa-id-badge'></i></td>
			<td><code>far fa-id-badge</code></td>
		</tr>
		<tr>
			<td><i class='far fa-id-card'></i></td>
			<td><code>far fa-id-card</code></td>
		</tr>
		<tr>
			<td><i class='far fa-image'></i></td>
			<td><code>far fa-image</code></td>
		</tr>
		<tr>
			<td><i class='far fa-images'></i></td>
			<td><code>far fa-images</code></td>
		</tr>
		<tr>
			<td><i class='far fa-keyboard'></i></td>
			<td><code>far fa-keyboard</code></td>
		</tr>
		<tr>
			<td><i class='far fa-kiss'></i></td>
			<td><code>far fa-kiss</code></td>
		</tr>
		<tr>
			<td><i class='far fa-kiss-beam'></i></td>
			<td><code>far fa-kiss-beam</code></td>
		</tr>
		<tr>
			<td><i class='far fa-kiss-wink-heart'></i></td>
			<td><code>far fa-kiss-wink-heart</code></td>
		</tr>
		<tr>
			<td><i class='far fa-laugh'></i></td>
			<td><code>far fa-laugh</code></td>
		</tr>
		<tr>
			<td><i class='far fa-laugh-beam'></i></td>
			<td><code>far fa-laugh-beam</code></td>
		</tr>
		<tr>
			<td><i class='far fa-laugh-squint'></i></td>
			<td><code>far fa-laugh-squint</code></td>
		</tr>
		<tr>
			<td><i class='far fa-laugh-wink'></i></td>
			<td><code>far fa-laugh-wink</code></td>
		</tr>
		<tr>
			<td><i class='far fa-lemon'></i></td>
			<td><code>far fa-lemon</code></td>
		</tr>
		<tr>
			<td><i class='far fa-life-ring'></i></td>
			<td><code>far fa-life-ring</code></td>
		</tr>
		<tr>
			<td><i class='far fa-lightbulb'></i></td>
			<td><code>far fa-lightbulb</code></td>
		</tr>
		<tr>
			<td><i class='far fa-list-alt'></i></td>
			<td><code>far fa-list-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-map'></i></td>
			<td><code>far fa-map</code></td>
		</tr>
		<tr>
			<td><i class='far fa-meh'></i></td>
			<td><code>far fa-meh</code></td>
		</tr>
		<tr>
			<td><i class='far fa-meh-blank'></i></td>
			<td><code>far fa-meh-blank</code></td>
		</tr>
		<tr>
			<td><i class='far fa-meh-rolling-eyes'></i></td>
			<td><code>far fa-meh-rolling-eyes</code></td>
		</tr>
		<tr>
			<td><i class='far fa-minus-square'></i></td>
			<td><code>far fa-minus-square</code></td>
		</tr>
		<tr>
			<td><i class='far fa-money-bill-alt'></i></td>
			<td><code>far fa-money-bill-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-moon'></i></td>
			<td><code>far fa-moon</code></td>
		</tr>
		<tr>
			<td><i class='far fa-newspaper'></i></td>
			<td><code>far fa-newspaper</code></td>
		</tr>
		<tr>
			<td><i class='far fa-object-group'></i></td>
			<td><code>far fa-object-group</code></td>
		</tr>
		<tr>
			<td><i class='far fa-object-ungroup'></i></td>
			<td><code>far fa-object-ungroup</code></td>
		</tr>
		<tr>
			<td><i class='far fa-paper-plane'></i></td>
			<td><code>far fa-paper-plane</code></td>
		</tr>
		<tr>
			<td><i class='far fa-pause-circle'></i></td>
			<td><code>far fa-pause-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-play-circle'></i></td>
			<td><code>far fa-play-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-plus-square'></i></td>
			<td><code>far fa-plus-square</code></td>
		</tr>
		<tr>
			<td><i class='far fa-question-circle'></i></td>
			<td><code>far fa-question-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-registered'></i></td>
			<td><code>far fa-registered</code></td>
		</tr>
		<tr>
			<td><i class='far fa-sad-cry'></i></td>
			<td><code>far fa-sad-cry</code></td>
		</tr>
		<tr>
			<td><i class='far fa-sad-tear'></i></td>
			<td><code>far fa-sad-tear</code></td>
		</tr>
		<tr>
			<td><i class='far fa-save'></i></td>
			<td><code>far fa-save</code></td>
		</tr>
		<tr>
			<td><i class='far fa-share-square'></i></td>
			<td><code>far fa-share-square</code></td>
		</tr>
		<tr>
			<td><i class='far fa-smile'></i></td>
			<td><code>far fa-smile</code></td>
		</tr>
		<tr>
			<td><i class='far fa-smile-beam'></i></td>
			<td><code>far fa-smile-beam</code></td>
		</tr>
		<tr>
			<td><i class='far fa-smile-wink'></i></td>
			<td><code>far fa-smile-wink</code></td>
		</tr>
		<tr>
			<td><i class='far fa-snowflake'></i></td>
			<td><code>far fa-snowflake</code></td>
		</tr>
		<tr>
			<td><i class='far fa-square'></i></td>
			<td><code>far fa-square</code></td>
		</tr>
		<tr>
			<td><i class='far fa-star'></i></td>
			<td><code>far fa-star</code></td>
		</tr>
		<tr>
			<td><i class='far fa-star-half'></i></td>
			<td><code>far fa-star-half</code></td>
		</tr>
		<tr>
			<td><i class='far fa-sticky-note'></i></td>
			<td><code>far fa-sticky-note</code></td>
		</tr>
		<tr>
			<td><i class='far fa-stop-circle'></i></td>
			<td><code>far fa-stop-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-sun'></i></td>
			<td><code>far fa-sun</code></td>
		</tr>
		<tr>
			<td><i class='far fa-surprise'></i></td>
			<td><code>far fa-surprise</code></td>
		</tr>
		<tr>
			<td><i class='far fa-thumbs-down'></i></td>
			<td><code>far fa-thumbs-down</code></td>
		</tr>
		<tr>
			<td><i class='far fa-thumbs-up'></i></td>
			<td><code>far fa-thumbs-up</code></td>
		</tr>
		<tr>
			<td><i class='far fa-times-circle'></i></td>
			<td><code>far fa-times-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-tired'></i></td>
			<td><code>far fa-tired</code></td>
		</tr>
		<tr>
			<td><i class='far fa-trash-alt'></i></td>
			<td><code>far fa-trash-alt</code></td>
		</tr>
		<tr>
			<td><i class='far fa-user'></i></td>
			<td><code>far fa-user</code></td>
		</tr>
		<tr>
			<td><i class='far fa-user-circle'></i></td>
			<td><code>far fa-user-circle</code></td>
		</tr>
		<tr>
			<td><i class='far fa-window-close'></i></td>
			<td><code>far fa-window-close</code></td>
		</tr>
		<tr>
			<td><i class='far fa-window-maximize'></i></td>
			<td><code>far fa-window-maximize</code></td>
		</tr>
		<tr>
			<td><i class='far fa-window-minimize'></i></td>
			<td><code>far fa-window-minimize</code></td>
		</tr>
		<tr>
			<td><i class='far fa-window-restore'></i></td>
			<td><code>far fa-window-restore</code></td>
		</tr>
	</tbody>
</table>
<h3 id='fontawesome_solid'>Solid Icons</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Icon</th>
			<th>CSS Reference</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><i class='far fa-address-book'></i></td>
			<td><code>far fa-address-book</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ad'></i></td>
			<td><code>fas fa-ad</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-address-book'></i></td>
			<td><code>fas fa-address-book</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-address-card'></i></td>
			<td><code>fas fa-address-card</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-adjust'></i></td>
			<td><code>fas fa-adjust</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-air-freshener'></i></td>
			<td><code>fas fa-air-freshener</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-align-center'></i></td>
			<td><code>fas fa-align-center</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-align-justify'></i></td>
			<td><code>fas fa-align-justify</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-align-left'></i></td>
			<td><code>fas fa-align-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-align-right'></i></td>
			<td><code>fas fa-align-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-allergies'></i></td>
			<td><code>fas fa-allergies</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ambulance'></i></td>
			<td><code>fas fa-ambulance</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-american-sign-language-interpreting'></i></td>
			<td><code>fas fa-american-sign-language-interpreting</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-anchor'></i></td>
			<td><code>fas fa-anchor</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-double-down'></i></td>
			<td><code>fas fa-angle-double-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-double-left'></i></td>
			<td><code>fas fa-angle-double-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-double-right'></i></td>
			<td><code>fas fa-angle-double-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-double-up'></i></td>
			<td><code>fas fa-angle-double-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-down'></i></td>
			<td><code>fas fa-angle-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-left'></i></td>
			<td><code>fas fa-angle-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-right'></i></td>
			<td><code>fas fa-angle-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angle-up'></i></td>
			<td><code>fas fa-angle-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-angry'></i></td>
			<td><code>fas fa-angry</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ankh'></i></td>
			<td><code>fas fa-ankh</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-apple-alt'></i></td>
			<td><code>fas fa-apple-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-archive'></i></td>
			<td><code>fas fa-archive</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-archway'></i></td>
			<td><code>fas fa-archway</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-alt-circle-down'></i></td>
			<td><code>fas fa-arrow-alt-circle-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-alt-circle-left'></i></td>
			<td><code>fas fa-arrow-alt-circle-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-alt-circle-right'></i></td>
			<td><code>fas fa-arrow-alt-circle-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-alt-circle-up'></i></td>
			<td><code>fas fa-arrow-alt-circle-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-circle-down'></i></td>
			<td><code>fas fa-arrow-circle-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-circle-left'></i></td>
			<td><code>fas fa-arrow-circle-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-circle-right'></i></td>
			<td><code>fas fa-arrow-circle-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-circle-up'></i></td>
			<td><code>fas fa-arrow-circle-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-down'></i></td>
			<td><code>fas fa-arrow-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-left'></i></td>
			<td><code>fas fa-arrow-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-right'></i></td>
			<td><code>fas fa-arrow-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrow-up'></i></td>
			<td><code>fas fa-arrow-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrows-alt'></i></td>
			<td><code>fas fa-arrows-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrows-alt-h'></i></td>
			<td><code>fas fa-arrows-alt-h</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-arrows-alt-v'></i></td>
			<td><code>fas fa-arrows-alt-v</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-assistive-listening-systems'></i></td>
			<td><code>fas fa-assistive-listening-systems</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-asterisk'></i></td>
			<td><code>fas fa-asterisk</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-at'></i></td>
			<td><code>fas fa-at</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-atlas'></i></td>
			<td><code>fas fa-atlas</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-atom'></i></td>
			<td><code>fas fa-atom</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-audio-description'></i></td>
			<td><code>fas fa-audio-description</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-award'></i></td>
			<td><code>fas fa-award</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-baby'></i></td>
			<td><code>fas fa-baby</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-baby-carriage'></i></td>
			<td><code>fas fa-baby-carriage</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-backspace'></i></td>
			<td><code>fas fa-backspace</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-backward'></i></td>
			<td><code>fas fa-backward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bacon'></i></td>
			<td><code>fas fa-bacon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bahai'></i></td>
			<td><code>fas fa-bahai</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-balance-scale'></i></td>
			<td><code>fas fa-balance-scale</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-balance-scale-left'></i></td>
			<td><code>fas fa-balance-scale-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-balance-scale-right'></i></td>
			<td><code>fas fa-balance-scale-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ban'></i></td>
			<td><code>fas fa-ban</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-band-aid'></i></td>
			<td><code>fas fa-band-aid</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-barcode'></i></td>
			<td><code>fas fa-barcode</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bars'></i></td>
			<td><code>fas fa-bars</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-baseball-ball'></i></td>
			<td><code>fas fa-baseball-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-basketball-ball'></i></td>
			<td><code>fas fa-basketball-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bath'></i></td>
			<td><code>fas fa-bath</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-battery-empty'></i></td>
			<td><code>fas fa-battery-empty</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-battery-full'></i></td>
			<td><code>fas fa-battery-full</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-battery-half'></i></td>
			<td><code>fas fa-battery-half</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-battery-quarter'></i></td>
			<td><code>fas fa-battery-quarter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-battery-three-quarters'></i></td>
			<td><code>fas fa-battery-three-quarters</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bed'></i></td>
			<td><code>fas fa-bed</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-beer'></i></td>
			<td><code>fas fa-beer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bell'></i></td>
			<td><code>fas fa-bell</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bell-slash'></i></td>
			<td><code>fas fa-bell-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bezier-curve'></i></td>
			<td><code>fas fa-bezier-curve</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bible'></i></td>
			<td><code>fas fa-bible</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bicycle'></i></td>
			<td><code>fas fa-bicycle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-biking'></i></td>
			<td><code>fas fa-biking</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-binoculars'></i></td>
			<td><code>fas fa-binoculars</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-biohazard'></i></td>
			<td><code>fas fa-biohazard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-birthday-cake'></i></td>
			<td><code>fas fa-birthday-cake</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-blender'></i></td>
			<td><code>fas fa-blender</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-blender-phone'></i></td>
			<td><code>fas fa-blender-phone</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-blind'></i></td>
			<td><code>fas fa-blind</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-blog'></i></td>
			<td><code>fas fa-blog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bold'></i></td>
			<td><code>fas fa-bold</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bolt'></i></td>
			<td><code>fas fa-bolt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bomb'></i></td>
			<td><code>fas fa-bomb</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bone'></i></td>
			<td><code>fas fa-bone</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bong'></i></td>
			<td><code>fas fa-bong</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-book'></i></td>
			<td><code>fas fa-book</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-book-dead'></i></td>
			<td><code>fas fa-book-dead</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-book-medical'></i></td>
			<td><code>fas fa-book-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-book-open'></i></td>
			<td><code>fas fa-book-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-book-reader'></i></td>
			<td><code>fas fa-book-reader</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bookmark'></i></td>
			<td><code>fas fa-bookmark</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-border-all'></i></td>
			<td><code>fas fa-border-all</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-border-none'></i></td>
			<td><code>fas fa-border-none</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-border-style'></i></td>
			<td><code>fas fa-border-style</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bowling-ball'></i></td>
			<td><code>fas fa-bowling-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-box'></i></td>
			<td><code>fas fa-box</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-box-open'></i></td>
			<td><code>fas fa-box-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-boxes'></i></td>
			<td><code>fas fa-boxes</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-braille'></i></td>
			<td><code>fas fa-braille</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-brain'></i></td>
			<td><code>fas fa-brain</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bread-slice'></i></td>
			<td><code>fas fa-bread-slice</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-briefcase'></i></td>
			<td><code>fas fa-briefcase</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-briefcase-medical'></i></td>
			<td><code>fas fa-briefcase-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-broadcast-tower'></i></td>
			<td><code>fas fa-broadcast-tower</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-broom'></i></td>
			<td><code>fas fa-broom</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-brush'></i></td>
			<td><code>fas fa-brush</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bug'></i></td>
			<td><code>fas fa-bug</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-building'></i></td>
			<td><code>fas fa-building</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bullhorn'></i></td>
			<td><code>fas fa-bullhorn</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bullseye'></i></td>
			<td><code>fas fa-bullseye</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-burn'></i></td>
			<td><code>fas fa-burn</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bus'></i></td>
			<td><code>fas fa-bus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-bus-alt'></i></td>
			<td><code>fas fa-bus-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-business-time'></i></td>
			<td><code>fas fa-business-time</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calculator'></i></td>
			<td><code>fas fa-calculator</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar'></i></td>
			<td><code>fas fa-calendar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-alt'></i></td>
			<td><code>fas fa-calendar-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-check'></i></td>
			<td><code>fas fa-calendar-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-day'></i></td>
			<td><code>fas fa-calendar-day</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-minus'></i></td>
			<td><code>fas fa-calendar-minus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-plus'></i></td>
			<td><code>fas fa-calendar-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-times'></i></td>
			<td><code>fas fa-calendar-times</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-calendar-week'></i></td>
			<td><code>fas fa-calendar-week</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-camera'></i></td>
			<td><code>fas fa-camera</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-camera-retro'></i></td>
			<td><code>fas fa-camera-retro</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-campground'></i></td>
			<td><code>fas fa-campground</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-candy-cane'></i></td>
			<td><code>fas fa-candy-cane</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cannabis'></i></td>
			<td><code>fas fa-cannabis</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-capsules'></i></td>
			<td><code>fas fa-capsules</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-car'></i></td>
			<td><code>fas fa-car</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-car-alt'></i></td>
			<td><code>fas fa-car-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-car-battery'></i></td>
			<td><code>fas fa-car-battery</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-car-crash'></i></td>
			<td><code>fas fa-car-crash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-car-side'></i></td>
			<td><code>fas fa-car-side</code></td>
		</tr>

		<tr>
			<td><i class='fas fa-caravan'></i></td>
			<td><code>fas fa-caravan</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-down'></i></td>
			<td><code>fas fa-caret-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-left'></i></td>
			<td><code>fas fa-caret-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-right'></i></td>
			<td><code>fas fa-caret-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-square-down'></i></td>
			<td><code>fas fa-caret-square-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-square-left'></i></td>
			<td><code>fas fa-caret-square-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-square-right'></i></td>
			<td><code>fas fa-caret-square-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-square-up'></i></td>
			<td><code>fas fa-caret-square-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-caret-up'></i></td>
			<td><code>fas fa-caret-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-carrot'></i></td>
			<td><code>fas fa-carrot</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cart-arrow-down'></i></td>
			<td><code>fas fa-cart-arrow-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cart-plus'></i></td>
			<td><code>fas fa-cart-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cash-register'></i></td>
			<td><code>fas fa-cash-register</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cat'></i></td>
			<td><code>fas fa-cat</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-certificate'></i></td>
			<td><code>fas fa-certificate</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chair'></i></td>
			<td><code>fas fa-chair</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chalkboard'></i></td>
			<td><code>fas fa-chalkboard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chalkboard-teacher'></i></td>
			<td><code>fas fa-chalkboard-teacher</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-charging-station'></i></td>
			<td><code>fas fa-charging-station</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chart-area'></i></td>
			<td><code>fas fa-chart-area</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chart-bar'></i></td>
			<td><code>fas fa-chart-bar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chart-line'></i></td>
			<td><code>fas fa-chart-line</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chart-pie'></i></td>
			<td><code>fas fa-chart-pie</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-check'></i></td>
			<td><code>fas fa-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-check-circle'></i></td>
			<td><code>fas fa-check-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-check-double'></i></td>
			<td><code>fas fa-check-double</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-check-square'></i></td>
			<td><code>fas fa-check-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cheese'></i></td>
			<td><code>fas fa-cheese</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess'></i></td>
			<td><code>fas fa-chess</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-bishop'></i></td>
			<td><code>fas fa-chess-bishop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-board'></i></td>
			<td><code>fas fa-chess-board</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-king'></i></td>
			<td><code>fas fa-chess-king</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-knight'></i></td>
			<td><code>fas fa-chess-knight</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-pawn'></i></td>
			<td><code>fas fa-chess-pawn</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-queen'></i></td>
			<td><code>fas fa-chess-queen</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chess-rook'></i></td>
			<td><code>fas fa-chess-rook</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-circle-down'></i></td>
			<td><code>fas fa-chevron-circle-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-circle-left'></i></td>
			<td><code>fas fa-chevron-circle-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-circle-right'></i></td>
			<td><code>fas fa-chevron-circle-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-circle-up'></i></td>
			<td><code>fas fa-chevron-circle-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-down'></i></td>
			<td><code>fas fa-chevron-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-left'></i></td>
			<td><code>fas fa-chevron-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-right'></i></td>
			<td><code>fas fa-chevron-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-chevron-up'></i></td>
			<td><code>fas fa-chevron-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-child'></i></td>
			<td><code>fas fa-child</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-church'></i></td>
			<td><code>fas fa-church</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-circle'></i></td>
			<td><code>fas fa-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-circle-notch'></i></td>
			<td><code>fas fa-circle-notch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-city'></i></td>
			<td><code>fas fa-city</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clinic-medical'></i></td>
			<td><code>fas fa-clinic-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clipboard'></i></td>
			<td><code>fas fa-clipboard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clipboard-check'></i></td>
			<td><code>fas fa-clipboard-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clipboard-list'></i></td>
			<td><code>fas fa-clipboard-list</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clock'></i></td>
			<td><code>fas fa-clock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-clone'></i></td>
			<td><code>fas fa-clone</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-closed-captioning'></i></td>
			<td><code>fas fa-closed-captioning</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud'></i></td>
			<td><code>fas fa-cloud</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-download-alt'></i></td>
			<td><code>fas fa-cloud-download-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-meatball'></i></td>
			<td><code>fas fa-cloud-meatball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-moon'></i></td>
			<td><code>fas fa-cloud-moon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-moon-rain'></i></td>
			<td><code>fas fa-cloud-moon-rain</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-rain'></i></td>
			<td><code>fas fa-cloud-rain</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-showers-heavy'></i></td>
			<td><code>fas fa-cloud-showers-heavy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-sun'></i></td>
			<td><code>fas fa-cloud-sun</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-sun-rain'></i></td>
			<td><code>fas fa-cloud-sun-rain</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cloud-upload-alt'></i></td>
			<td><code>fas fa-cloud-upload-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cocktail'></i></td>
			<td><code>fas fa-cocktail</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-code'></i></td>
			<td><code>fas fa-code</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-code-branch'></i></td>
			<td><code>fas fa-code-branch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-coffee'></i></td>
			<td><code>fas fa-coffee</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cog'></i></td>
			<td><code>fas fa-cog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cogs'></i></td>
			<td><code>fas fa-cogs</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-coins'></i></td>
			<td><code>fas fa-coins</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-columns'></i></td>
			<td><code>fas fa-columns</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment'></i></td>
			<td><code>fas fa-comment</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment-alt'></i></td>
			<td><code>fas fa-comment-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment-dollar'></i></td>
			<td><code>fas fa-comment-dollar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment-dots'></i></td>
			<td><code>fas fa-comment-dots</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment-medical'></i></td>
			<td><code>fas fa-comment-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comment-slash'></i></td>
			<td><code>fas fa-comment-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comments'></i></td>
			<td><code>fas fa-comments</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-comments-dollar'></i></td>
			<td><code>fas fa-comments-dollar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-compact-disc'></i></td>
			<td><code>fas fa-compact-disc</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-compass'></i></td>
			<td><code>fas fa-compass</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-compress'></i></td>
			<td><code>fas fa-compress</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-compress-alt'></i></td>
			<td><code>fas fa-compress-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-compress-arrows-alt'></i></td>
			<td><code>fas fa-compress-arrows-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-concierge-bell'></i></td>
			<td><code>fas fa-concierge-bell</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cookie'></i></td>
			<td><code>fas fa-cookie</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cookie-bite'></i></td>
			<td><code>fas fa-cookie-bite</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-copy'></i></td>
			<td><code>fas fa-copy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-copyright'></i></td>
			<td><code>fas fa-copyright</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-couch'></i></td>
			<td><code>fas fa-couch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-credit-card'></i></td>
			<td><code>fas fa-credit-card</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crop'></i></td>
			<td><code>fas fa-crop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crop-alt'></i></td>
			<td><code>fas fa-crop-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cross'></i></td>
			<td><code>fas fa-cross</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crosshairs'></i></td>
			<td><code>fas fa-crosshairs</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crow'></i></td>
			<td><code>fas fa-crow</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crown'></i></td>
			<td><code>fas fa-crown</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-crutch'></i></td>
			<td><code>fas fa-crutch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cube'></i></td>
			<td><code>fas fa-cube</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cubes'></i></td>
			<td><code>fas fa-cubes</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-cut'></i></td>
			<td><code>fas fa-cut</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-database'></i></td>
			<td><code>fas fa-database</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-deaf'></i></td>
			<td><code>fas fa-deaf</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-democrat'></i></td>
			<td><code>fas fa-democrat</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-desktop'></i></td>
			<td><code>fas fa-desktop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dharmachakra'></i></td>
			<td><code>fas fa-dharmachakra</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-diagnoses'></i></td>
			<td><code>fas fa-diagnoses</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice'></i></td>
			<td><code>fas fa-dice</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-d20'></i></td>
			<td><code>fas fa-dice-d20</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-d6'></i></td>
			<td><code>fas fa-dice-d6</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-five'></i></td>
			<td><code>fas fa-dice-five</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-four'></i></td>
			<td><code>fas fa-dice-four</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-one'></i></td>
			<td><code>fas fa-dice-one</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-six'></i></td>
			<td><code>fas fa-dice-six</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-three'></i></td>
			<td><code>fas fa-dice-three</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dice-two'></i></td>
			<td><code>fas fa-dice-two</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-digital-tachograph'></i></td>
			<td><code>fas fa-digital-tachograph</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-directions'></i></td>
			<td><code>fas fa-directions</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-divide'></i></td>
			<td><code>fas fa-divide</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dizzy'></i></td>
			<td><code>fas fa-dizzy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dna'></i></td>
			<td><code>fas fa-dna</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dog'></i></td>
			<td><code>fas fa-dog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dollar-sign'></i></td>
			<td><code>fas fa-dollar-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dolly'></i></td>
			<td><code>fas fa-dolly</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dolly-flatbed'></i></td>
			<td><code>fas fa-dolly-flatbed</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-donate'></i></td>
			<td><code>fas fa-donate</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-door-closed'></i></td>
			<td><code>fas fa-door-closed</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-door-open'></i></td>
			<td><code>fas fa-door-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dot-circle'></i></td>
			<td><code>fas fa-dot-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dove'></i></td>
			<td><code>fas fa-dove</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-download'></i></td>
			<td><code>fas fa-download</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-drafting-compass'></i></td>
			<td><code>fas fa-drafting-compass</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dragon'></i></td>
			<td><code>fas fa-dragon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-draw-polygon'></i></td>
			<td><code>fas fa-draw-polygon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-drum'></i></td>
			<td><code>fas fa-drum</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-drum-steelpan'></i></td>
			<td><code>fas fa-drum-steelpan</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-drumstick-bite'></i></td>
			<td><code>fas fa-drumstick-bite</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dumbbell'></i></td>
			<td><code>fas fa-dumbbell</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dumpster'></i></td>
			<td><code>fas fa-dumpster</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dumpster-fire'></i></td>
			<td><code>fas fa-dumpster-fire</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-dungeon'></i></td>
			<td><code>fas fa-dungeon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-edit'></i></td>
			<td><code>fas fa-edit</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-egg'></i></td>
			<td><code>fas fa-egg</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-eject'></i></td>
			<td><code>fas fa-eject</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ellipsis-h'></i></td>
			<td><code>fas fa-ellipsis-h</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ellipsis-v'></i></td>
			<td><code>fas fa-ellipsis-v</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-envelope'></i></td>
			<td><code>fas fa-envelope</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-envelope-open'></i></td>
			<td><code>fas fa-envelope-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-envelope-open-text'></i></td>
			<td><code>fas fa-envelope-open-text</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-envelope-square'></i></td>
			<td><code>fas fa-envelope-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-equals'></i></td>
			<td><code>fas fa-equals</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-eraser'></i></td>
			<td><code>fas fa-eraser</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ethernet'></i></td>
			<td><code>fas fa-ethernet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-euro-sign'></i></td>
			<td><code>fas fa-euro-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-exchange-alt'></i></td>
			<td><code>fas fa-exchange-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-exclamation'></i></td>
			<td><code>fas fa-exclamation</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-exclamation-circle'></i></td>
			<td><code>fas fa-exclamation-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-exclamation-triangle'></i></td>
			<td><code>fas fa-exclamation-triangle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-expand'></i></td>
			<td><code>fas fa-expand</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-expand-alt'></i></td>
			<td><code>fas fa-expand-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-expand-arrows-alt'></i></td>
			<td><code>fas fa-expand-arrows-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-external-link-alt'></i></td>
			<td><code>fas fa-external-link-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-external-link-square-alt'></i></td>
			<td><code>fas fa-external-link-square-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-eye'></i></td>
			<td><code>fas fa-eye</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-eye-dropper'></i></td>
			<td><code>fas fa-eye-dropper</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-eye-slash'></i></td>
			<td><code>fas fa-eye-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fan'></i></td>
			<td><code>fas fa-fan</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fast-backward'></i></td>
			<td><code>fas fa-fast-backward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fast-forward'></i></td>
			<td><code>fas fa-fast-forward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fax'></i></td>
			<td><code>fas fa-fax</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-feather'></i></td>
			<td><code>fas fa-feather</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-feather-alt'></i></td>
			<td><code>fas fa-feather-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-female'></i></td>
			<td><code>fas fa-female</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fighter-jet'></i></td>
			<td><code>fas fa-fighter-jet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file'></i></td>
			<td><code>fas fa-file</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-alt'></i></td>
			<td><code>fas fa-file-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-archive'></i></td>
			<td><code>fas fa-file-archive</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-audio'></i></td>
			<td><code>fas fa-file-audio</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-code'></i></td>
			<td><code>fas fa-file-code</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-contract'></i></td>
			<td><code>fas fa-file-contract</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-csv'></i></td>
			<td><code>fas fa-file-csv</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-download'></i></td>
			<td><code>fas fa-file-download</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-excel'></i></td>
			<td><code>fas fa-file-excel</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-export'></i></td>
			<td><code>fas fa-file-export</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-image'></i></td>
			<td><code>fas fa-file-image</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-import'></i></td>
			<td><code>fas fa-file-import</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-invoice'></i></td>
			<td><code>fas fa-file-invoice</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-invoice-dollar'></i></td>
			<td><code>fas fa-file-invoice-dollar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-medical'></i></td>
			<td><code>fas fa-file-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-medical-alt'></i></td>
			<td><code>fas fa-file-medical-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-pdf'></i></td>
			<td><code>fas fa-file-pdf</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-powerpoint'></i></td>
			<td><code>fas fa-file-powerpoint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-prescription'></i></td>
			<td><code>fas fa-file-prescription</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-signature'></i></td>
			<td><code>fas fa-file-signature</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-upload'></i></td>
			<td><code>fas fa-file-upload</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-video'></i></td>
			<td><code>fas fa-file-video</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-file-word'></i></td>
			<td><code>fas fa-file-word</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fill'></i></td>
			<td><code>fas fa-fill</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fill-drip'></i></td>
			<td><code>fas fa-fill-drip</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-film'></i></td>
			<td><code>fas fa-film</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-filter'></i></td>
			<td><code>fas fa-filter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fingerprint'></i></td>
			<td><code>fas fa-fingerprint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fire'></i></td>
			<td><code>fas fa-fire</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fire-alt'></i></td>
			<td><code>fas fa-fire-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fire-extinguisher'></i></td>
			<td><code>fas fa-fire-extinguisher</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-first-aid'></i></td>
			<td><code>fas fa-first-aid</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fish'></i></td>
			<td><code>fas fa-fish</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-fist-raised'></i></td>
			<td><code>fas fa-fist-raised</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-flag'></i></td>
			<td><code>fas fa-flag</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-flag-checkered'></i></td>
			<td><code>fas fa-flag-checkered</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-flag-usa'></i></td>
			<td><code>fas fa-flag-usa</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-flask'></i></td>
			<td><code>fas fa-flask</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-flushed'></i></td>
			<td><code>fas fa-flushed</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-folder'></i></td>
			<td><code>fas fa-folder</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-folder-minus'></i></td>
			<td><code>fas fa-folder-minus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-folder-open'></i></td>
			<td><code>fas fa-folder-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-folder-plus'></i></td>
			<td><code>fas fa-folder-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-font'></i></td>
			<td><code>fas fa-font</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-football-ball'></i></td>
			<td><code>fas fa-football-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-forward'></i></td>
			<td><code>fas fa-forward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-frog'></i></td>
			<td><code>fas fa-frog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-frown'></i></td>
			<td><code>fas fa-frown</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-frown-open'></i></td>
			<td><code>fas fa-frown-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-funnel-dollar'></i></td>
			<td><code>fas fa-funnel-dollar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-futbol'></i></td>
			<td><code>fas fa-futbol</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gamepad'></i></td>
			<td><code>fas fa-gamepad</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gas-pump'></i></td>
			<td><code>fas fa-gas-pump</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gavel'></i></td>
			<td><code>fas fa-gavel</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gem'></i></td>
			<td><code>fas fa-gem</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-genderless'></i></td>
			<td><code>fas fa-genderless</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ghost'></i></td>
			<td><code>fas fa-ghost</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gift'></i></td>
			<td><code>fas fa-gift</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gifts'></i></td>
			<td><code>fas fa-gifts</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-glass-cheers'></i></td>
			<td><code>fas fa-glass-cheers</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-glass-martini'></i></td>
			<td><code>fas fa-glass-martini</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-glass-martini-alt'></i></td>
			<td><code>fas fa-glass-martini-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-glass-whiskey'></i></td>
			<td><code>fas fa-glass-whiskey</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-glasses'></i></td>
			<td><code>fas fa-glasses</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-globe'></i></td>
			<td><code>fas fa-globe</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-globe-africa'></i></td>
			<td><code>fas fa-globe-africa</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-globe-americas'></i></td>
			<td><code>fas fa-globe-americas</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-globe-asia'></i></td>
			<td><code>fas fa-globe-asia</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-globe-europe'></i></td>
			<td><code>fas fa-globe-europe</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-golf-ball'></i></td>
			<td><code>fas fa-golf-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-gopuram'></i></td>
			<td><code>fas fa-gopuram</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-graduation-cap'></i></td>
			<td><code>fas fa-graduation-cap</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-greater-than'></i></td>
			<td><code>fas fa-greater-than</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-greater-than-equal'></i></td>
			<td><code>fas fa-greater-than-equal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grimace'></i></td>
			<td><code>fas fa-grimace</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin'></i></td>
			<td><code>fas fa-grin</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-alt'></i></td>
			<td><code>fas fa-grin-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-beam'></i></td>
			<td><code>fas fa-grin-beam</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-beam-sweat'></i></td>
			<td><code>fas fa-grin-beam-sweat</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-hearts'></i></td>
			<td><code>fas fa-grin-hearts</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-squint'></i></td>
			<td><code>fas fa-grin-squint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-squint-tears'></i></td>
			<td><code>fas fa-grin-squint-tears</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-stars'></i></td>
			<td><code>fas fa-grin-stars</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-tears'></i></td>
			<td><code>fas fa-grin-tears</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-tongue'></i></td>
			<td><code>fas fa-grin-tongue</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-tongue-squint'></i></td>
			<td><code>fas fa-grin-tongue-squint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-tongue-wink'></i></td>
			<td><code>fas fa-grin-tongue-wink</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grin-wink'></i></td>
			<td><code>fas fa-grin-wink</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grip-horizontal'></i></td>
			<td><code>fas fa-grip-horizontal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grip-lines'></i></td>
			<td><code>fas fa-grip-lines</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grip-lines-vertical'></i></td>
			<td><code>fas fa-grip-lines-vertical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-grip-vertical'></i></td>
			<td><code>fas fa-grip-vertical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-guitar'></i></td>
			<td><code>fas fa-guitar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-h-square'></i></td>
			<td><code>fas fa-h-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hamburger'></i></td>
			<td><code>fas fa-hamburger</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hammer'></i></td>
			<td><code>fas fa-hammer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hamsa'></i></td>
			<td><code>fas fa-hamsa</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-holding'></i></td>
			<td><code>fas fa-hand-holding</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-holding-heart'></i></td>
			<td><code>fas fa-hand-holding-heart</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-holding-usd'></i></td>
			<td><code>fas fa-hand-holding-usd</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-lizard'></i></td>
			<td><code>fas fa-hand-lizard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-middle-finger'></i></td>
			<td><code>fas fa-hand-middle-finger</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-paper'></i></td>
			<td><code>fas fa-hand-paper</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-peace'></i></td>
			<td><code>fas fa-hand-peace</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-point-down'></i></td>
			<td><code>fas fa-hand-point-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-point-left'></i></td>
			<td><code>fas fa-hand-point-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-point-right'></i></td>
			<td><code>fas fa-hand-point-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-point-up'></i></td>
			<td><code>fas fa-hand-point-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-pointer'></i></td>
			<td><code>fas fa-hand-pointer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-rock'></i></td>
			<td><code>fas fa-hand-rock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-scissors'></i></td>
			<td><code>fas fa-hand-scissors</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hand-spock'></i></td>
			<td><code>fas fa-hand-spock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hands'></i></td>
			<td><code>fas fa-hands</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hands-helping'></i></td>
			<td><code>fas fa-hands-helping</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-handshake'></i></td>
			<td><code>fas fa-handshake</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hanukiah'></i></td>
			<td><code>fas fa-hanukiah</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hard-hat'></i></td>
			<td><code>fas fa-hard-hat</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hashtag'></i></td>
			<td><code>fas fa-hashtag</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hat-cowboy'></i></td>
			<td><code>fas fa-hat-cowboy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hat-cowboy-side'></i></td>
			<td><code>fas fa-hat-cowboy-side</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hat-wizard'></i></td>
			<td><code>fas fa-hat-wizard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hdd'></i></td>
			<td><code>fas fa-hdd</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-heading'></i></td>
			<td><code>fas fa-heading</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-headphones'></i></td>
			<td><code>fas fa-headphones</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-headphones-alt'></i></td>
			<td><code>fas fa-headphones-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-headset'></i></td>
			<td><code>fas fa-headset</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-heart'></i></td>
			<td><code>fas fa-heart</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-heart-broken'></i></td>
			<td><code>fas fa-heart-broken</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-heartbeat'></i></td>
			<td><code>fas fa-heartbeat</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-helicopter'></i></td>
			<td><code>fas fa-helicopter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-highlighter'></i></td>
			<td><code>fas fa-highlighter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hiking'></i></td>
			<td><code>fas fa-hiking</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hippo'></i></td>
			<td><code>fas fa-hippo</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-history'></i></td>
			<td><code>fas fa-history</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hockey-puck'></i></td>
			<td><code>fas fa-hockey-puck</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-holly-berry'></i></td>
			<td><code>fas fa-holly-berry</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-home'></i></td>
			<td><code>fas fa-home</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-horse'></i></td>
			<td><code>fas fa-horse</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-horse-head'></i></td>
			<td><code>fas fa-horse-head</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hospital'></i></td>
			<td><code>fas fa-hospital</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hospital-alt'></i></td>
			<td><code>fas fa-hospital-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hospital-symbol'></i></td>
			<td><code>fas fa-hospital-symbol</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hot-tub'></i></td>
			<td><code>fas fa-hot-tub</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hotdog'></i></td>
			<td><code>fas fa-hotdog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hotel'></i></td>
			<td><code>fas fa-hotel</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hourglass'></i></td>
			<td><code>fas fa-hourglass</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hourglass-end'></i></td>
			<td><code>fas fa-hourglass-end</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hourglass-half'></i></td>
			<td><code>fas fa-hourglass-half</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hourglass-start'></i></td>
			<td><code>fas fa-hourglass-start</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-house-damage'></i></td>
			<td><code>fas fa-house-damage</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-hryvnia'></i></td>
			<td><code>fas fa-hryvnia</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-i-cursor'></i></td>
			<td><code>fas fa-i-cursor</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ice-cream'></i></td>
			<td><code>fas fa-ice-cream</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-icicles'></i></td>
			<td><code>fas fa-icicles</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-icons'></i></td>
			<td><code>fas fa-icons</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-id-badge'></i></td>
			<td><code>fas fa-id-badge</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-id-card'></i></td>
			<td><code>fas fa-id-card</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-id-card-alt'></i></td>
			<td><code>fas fa-id-card-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-igloo'></i></td>
			<td><code>fas fa-igloo</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-image'></i></td>
			<td><code>fas fa-image</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-images'></i></td>
			<td><code>fas fa-images</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-inbox'></i></td>
			<td><code>fas fa-inbox</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-indent'></i></td>
			<td><code>fas fa-indent</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-industry'></i></td>
			<td><code>fas fa-industry</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-infinity'></i></td>
			<td><code>fas fa-infinity</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-info'></i></td>
			<td><code>fas fa-info</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-info-circle'></i></td>
			<td><code>fas fa-info-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-italic'></i></td>
			<td><code>fas fa-italic</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-jedi'></i></td>
			<td><code>fas fa-jedi</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-joint'></i></td>
			<td><code>fas fa-joint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-journal-whills'></i></td>
			<td><code>fas fa-journal-whills</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-kaaba'></i></td>
			<td><code>fas fa-kaaba</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-key'></i></td>
			<td><code>fas fa-key</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-keyboard'></i></td>
			<td><code>fas fa-keyboard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-khanda'></i></td>
			<td><code>fas fa-khanda</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-kiss'></i></td>
			<td><code>fas fa-kiss</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-kiss-beam'></i></td>
			<td><code>fas fa-kiss-beam</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-kiss-wink-heart'></i></td>
			<td><code>fas fa-kiss-wink-heart</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-kiwi-bird'></i></td>
			<td><code>fas fa-kiwi-bird</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-landmark'></i></td>
			<td><code>fas fa-landmark</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-language'></i></td>
			<td><code>fas fa-language</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laptop'></i></td>
			<td><code>fas fa-laptop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laptop-code'></i></td>
			<td><code>fas fa-laptop-code</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laptop-medical'></i></td>
			<td><code>fas fa-laptop-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laugh'></i></td>
			<td><code>fas fa-laugh</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laugh-beam'></i></td>
			<td><code>fas fa-laugh-beam</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laugh-squint'></i></td>
			<td><code>fas fa-laugh-squint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-laugh-wink'></i></td>
			<td><code>fas fa-laugh-wink</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-layer-group'></i></td>
			<td><code>fas fa-layer-group</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-leaf'></i></td>
			<td><code>fas fa-leaf</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-lemon'></i></td>
			<td><code>fas fa-lemon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-less-than'></i></td>
			<td><code>fas fa-less-than</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-less-than-equal'></i></td>
			<td><code>fas fa-less-than-equal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-level-down-alt'></i></td>
			<td><code>fas fa-level-down-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-level-up-alt'></i></td>
			<td><code>fas fa-level-up-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-life-ring'></i></td>
			<td><code>fas fa-life-ring</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-lightbulb'></i></td>
			<td><code>fas fa-lightbulb</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-link'></i></td>
			<td><code>fas fa-link</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-lira-sign'></i></td>
			<td><code>fas fa-lira-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-list'></i></td>
			<td><code>fas fa-list</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-list-alt'></i></td>
			<td><code>fas fa-list-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-list-ol'></i></td>
			<td><code>fas fa-list-ol</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-list-ul'></i></td>
			<td><code>fas fa-list-ul</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-location-arrow'></i></td>
			<td><code>fas fa-location-arrow</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-lock'></i></td>
			<td><code>fas fa-lock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-lock-open'></i></td>
			<td><code>fas fa-lock-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-long-arrow-alt-down'></i></td>
			<td><code>fas fa-long-arrow-alt-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-long-arrow-alt-left'></i></td>
			<td><code>fas fa-long-arrow-alt-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-long-arrow-alt-right'></i></td>
			<td><code>fas fa-long-arrow-alt-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-long-arrow-alt-up'></i></td>
			<td><code>fas fa-long-arrow-alt-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-low-vision'></i></td>
			<td><code>fas fa-low-vision</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-luggage-cart'></i></td>
			<td><code>fas fa-luggage-cart</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-magic'></i></td>
			<td><code>fas fa-magic</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-magnet'></i></td>
			<td><code>fas fa-magnet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mail-bulk'></i></td>
			<td><code>fas fa-mail-bulk</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-male'></i></td>
			<td><code>fas fa-male</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map'></i></td>
			<td><code>fas fa-map</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-marked'></i></td>
			<td><code>fas fa-map-marked</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-marked-alt'></i></td>
			<td><code>fas fa-map-marked-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-marker'></i></td>
			<td><code>fas fa-map-marker</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-marker-alt'></i></td>
			<td><code>fas fa-map-marker-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-pin'></i></td>
			<td><code>fas fa-map-pin</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-map-signs'></i></td>
			<td><code>fas fa-map-signs</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-marker'></i></td>
			<td><code>fas fa-marker</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mars'></i></td>
			<td><code>fas fa-mars</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mars-double'></i></td>
			<td><code>fas fa-mars-double</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mars-stroke'></i></td>
			<td><code>fas fa-mars-stroke</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mars-stroke-h'></i></td>
			<td><code>fas fa-mars-stroke-h</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mars-stroke-v'></i></td>
			<td><code>fas fa-mars-stroke-v</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mask'></i></td>
			<td><code>fas fa-mask</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-medal'></i></td>
			<td><code>fas fa-medal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-medkit'></i></td>
			<td><code>fas fa-medkit</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-meh'></i></td>
			<td><code>fas fa-meh</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-meh-blank'></i></td>
			<td><code>fas fa-meh-blank</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-meh-rolling-eyes'></i></td>
			<td><code>fas fa-meh-rolling-eyes</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-memory'></i></td>
			<td><code>fas fa-memory</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-menorah'></i></td>
			<td><code>fas fa-menorah</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mercury'></i></td>
			<td><code>fas fa-mercury</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-meteor'></i></td>
			<td><code>fas fa-meteor</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microchip'></i></td>
			<td><code>fas fa-microchip</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microphone'></i></td>
			<td><code>fas fa-microphone</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microphone-alt'></i></td>
			<td><code>fas fa-microphone-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microphone-alt-slash'></i></td>
			<td><code>fas fa-microphone-alt-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microphone-slash'></i></td>
			<td><code>fas fa-microphone-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-microscope'></i></td>
			<td><code>fas fa-microscope</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-minus'></i></td>
			<td><code>fas fa-minus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-minus-circle'></i></td>
			<td><code>fas fa-minus-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-minus-square'></i></td>
			<td><code>fas fa-minus-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mitten'></i></td>
			<td><code>fas fa-mitten</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mobile'></i></td>
			<td><code>fas fa-mobile</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mobile-alt'></i></td>
			<td><code>fas fa-mobile-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-bill'></i></td>
			<td><code>fas fa-money-bill</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-bill-alt'></i></td>
			<td><code>fas fa-money-bill-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-bill-wave'></i></td>
			<td><code>fas fa-money-bill-wave</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-bill-wave-alt'></i></td>
			<td><code>fas fa-money-bill-wave-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-check'></i></td>
			<td><code>fas fa-money-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-money-check-alt'></i></td>
			<td><code>fas fa-money-check-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-monument'></i></td>
			<td><code>fas fa-monument</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-moon'></i></td>
			<td><code>fas fa-moon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mortar-pestle'></i></td>
			<td><code>fas fa-mortar-pestle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mosque'></i></td>
			<td><code>fas fa-mosque</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-motorcycle'></i></td>
			<td><code>fas fa-motorcycle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mountain'></i></td>
			<td><code>fas fa-mountain</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mouse'></i></td>
			<td><code>fas fa-mouse</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mouse-pointer'></i></td>
			<td><code>fas fa-mouse-pointer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-mug-hot'></i></td>
			<td><code>fas fa-mug-hot</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-music'></i></td>
			<td><code>fas fa-music</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-network-wired'></i></td>
			<td><code>fas fa-network-wired</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-neuter'></i></td>
			<td><code>fas fa-neuter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-newspaper'></i></td>
			<td><code>fas fa-newspaper</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-not-equal'></i></td>
			<td><code>fas fa-not-equal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-notes-medical'></i></td>
			<td><code>fas fa-notes-medical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-object-group'></i></td>
			<td><code>fas fa-object-group</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-object-ungroup'></i></td>
			<td><code>fas fa-object-ungroup</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-oil-can'></i></td>
			<td><code>fas fa-oil-can</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-om'></i></td>
			<td><code>fas fa-om</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-otter'></i></td>
			<td><code>fas fa-otter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-outdent'></i></td>
			<td><code>fas fa-outdent</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pager'></i></td>
			<td><code>fas fa-pager</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paint-brush'></i></td>
			<td><code>fas fa-paint-brush</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paint-roller'></i></td>
			<td><code>fas fa-paint-roller</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-palette'></i></td>
			<td><code>fas fa-palette</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pallet'></i></td>
			<td><code>fas fa-pallet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paper-plane'></i></td>
			<td><code>fas fa-paper-plane</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paperclip'></i></td>
			<td><code>fas fa-paperclip</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-parachute-box'></i></td>
			<td><code>fas fa-parachute-box</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paragraph'></i></td>
			<td><code>fas fa-paragraph</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-parking'></i></td>
			<td><code>fas fa-parking</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-passport'></i></td>
			<td><code>fas fa-passport</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pastafarianism'></i></td>
			<td><code>fas fa-pastafarianism</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paste'></i></td>
			<td><code>fas fa-paste</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pause'></i></td>
			<td><code>fas fa-pause</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pause-circle'></i></td>
			<td><code>fas fa-pause-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-paw'></i></td>
			<td><code>fas fa-paw</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-peace'></i></td>
			<td><code>fas fa-peace</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pen'></i></td>
			<td><code>fas fa-pen</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pen-alt'></i></td>
			<td><code>fas fa-pen-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pen-fancy'></i></td>
			<td><code>fas fa-pen-fancy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pen-nib'></i></td>
			<td><code>fas fa-pen-nib</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pen-square'></i></td>
			<td><code>fas fa-pen-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pencil-alt'></i></td>
			<td><code>fas fa-pencil-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pencil-ruler'></i></td>
			<td><code>fas fa-pencil-ruler</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-people-carry'></i></td>
			<td><code>fas fa-people-carry</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pepper-hot'></i></td>
			<td><code>fas fa-pepper-hot</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-percent'></i></td>
			<td><code>fas fa-percent</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-percentage'></i></td>
			<td><code>fas fa-percentage</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-person-booth'></i></td>
			<td><code>fas fa-person-booth</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone'></i></td>
			<td><code>fas fa-phone</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone-alt'></i></td>
			<td><code>fas fa-phone-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone-slash'></i></td>
			<td><code>fas fa-phone-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone-square'></i></td>
			<td><code>fas fa-phone-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone-square-alt'></i></td>
			<td><code>fas fa-phone-square-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-phone-volume'></i></td>
			<td><code>fas fa-phone-volume</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-photo-video'></i></td>
			<td><code>fas fa-photo-video</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-piggy-bank'></i></td>
			<td><code>fas fa-piggy-bank</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pills'></i></td>
			<td><code>fas fa-pills</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pizza-slice'></i></td>
			<td><code>fas fa-pizza-slice</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-place-of-worship'></i></td>
			<td><code>fas fa-place-of-worship</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plane'></i></td>
			<td><code>fas fa-plane</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plane-arrival'></i></td>
			<td><code>fas fa-plane-arrival</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plane-departure'></i></td>
			<td><code>fas fa-plane-departure</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-play'></i></td>
			<td><code>fas fa-play</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-play-circle'></i></td>
			<td><code>fas fa-play-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plug'></i></td>
			<td><code>fas fa-plug</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plus'></i></td>
			<td><code>fas fa-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plus-circle'></i></td>
			<td><code>fas fa-plus-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-plus-square'></i></td>
			<td><code>fas fa-plus-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-podcast'></i></td>
			<td><code>fas fa-podcast</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-poll'></i></td>
			<td><code>fas fa-poll</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-poll-h'></i></td>
			<td><code>fas fa-poll-h</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-poo'></i></td>
			<td><code>fas fa-poo</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-poo-storm'></i></td>
			<td><code>fas fa-poo-storm</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-poop'></i></td>
			<td><code>fas fa-poop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-portrait'></i></td>
			<td><code>fas fa-portrait</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pound-sign'></i></td>
			<td><code>fas fa-pound-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-power-off'></i></td>
			<td><code>fas fa-power-off</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-pray'></i></td>
			<td><code>fas fa-pray</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-praying-hands'></i></td>
			<td><code>fas fa-praying-hands</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-prescription'></i></td>
			<td><code>fas fa-prescription</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-prescription-bottle'></i></td>
			<td><code>fas fa-prescription-bottle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-prescription-bottle-alt'></i></td>
			<td><code>fas fa-prescription-bottle-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-print'></i></td>
			<td><code>fas fa-print</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-procedures'></i></td>
			<td><code>fas fa-procedures</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-project-diagram'></i></td>
			<td><code>fas fa-project-diagram</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-puzzle-piece'></i></td>
			<td><code>fas fa-puzzle-piece</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-qrcode'></i></td>
			<td><code>fas fa-qrcode</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-question'></i></td>
			<td><code>fas fa-question</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-question-circle'></i></td>
			<td><code>fas fa-question-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-quidditch'></i></td>
			<td><code>fas fa-quidditch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-quote-left'></i></td>
			<td><code>fas fa-quote-left</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-quote-right'></i></td>
			<td><code>fas fa-quote-right</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-quran'></i></td>
			<td><code>fas fa-quran</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-radiation'></i></td>
			<td><code>fas fa-radiation</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-radiation-alt'></i></td>
			<td><code>fas fa-radiation-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-rainbow'></i></td>
			<td><code>fas fa-rainbow</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-random'></i></td>
			<td><code>fas fa-random</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-receipt'></i></td>
			<td><code>fas fa-receipt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-record-vinyl'></i></td>
			<td><code>fas fa-record-vinyl</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-recycle'></i></td>
			<td><code>fas fa-recycle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-redo'></i></td>
			<td><code>fas fa-redo</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-redo-alt'></i></td>
			<td><code>fas fa-redo-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-registered'></i></td>
			<td><code>fas fa-registered</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-remove-format'></i></td>
			<td><code>fas fa-remove-format</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-reply'></i></td>
			<td><code>fas fa-reply</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-reply-all'></i></td>
			<td><code>fas fa-reply-all</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-republican'></i></td>
			<td><code>fas fa-republican</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-restroom'></i></td>
			<td><code>fas fa-restroom</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-retweet'></i></td>
			<td><code>fas fa-retweet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ribbon'></i></td>
			<td><code>fas fa-ribbon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ring'></i></td>
			<td><code>fas fa-ring</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-road'></i></td>
			<td><code>fas fa-road</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-robot'></i></td>
			<td><code>fas fa-robot</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-rocket'></i></td>
			<td><code>fas fa-rocket</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-route'></i></td>
			<td><code>fas fa-route</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-rss'></i></td>
			<td><code>fas fa-rss</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-rss-square'></i></td>
			<td><code>fas fa-rss-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ruble-sign'></i></td>
			<td><code>fas fa-ruble-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ruler'></i></td>
			<td><code>fas fa-ruler</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ruler-combined'></i></td>
			<td><code>fas fa-ruler-combined</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ruler-horizontal'></i></td>
			<td><code>fas fa-ruler-horizontal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ruler-vertical'></i></td>
			<td><code>fas fa-ruler-vertical</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-running'></i></td>
			<td><code>fas fa-running</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-rupee-sign'></i></td>
			<td><code>fas fa-rupee-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sad-cry'></i></td>
			<td><code>fas fa-sad-cry</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sad-tear'></i></td>
			<td><code>fas fa-sad-tear</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-satellite'></i></td>
			<td><code>fas fa-satellite</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-satellite-dish'></i></td>
			<td><code>fas fa-satellite-dish</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-save'></i></td>
			<td><code>fas fa-save</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-school'></i></td>
			<td><code>fas fa-school</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-screwdriver'></i></td>
			<td><code>fas fa-screwdriver</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-scroll'></i></td>
			<td><code>fas fa-scroll</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sd-card'></i></td>
			<td><code>fas fa-sd-card</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-search'></i></td>
			<td><code>fas fa-search</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-search-dollar'></i></td>
			<td><code>fas fa-search-dollar</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-search-location'></i></td>
			<td><code>fas fa-search-location</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-search-minus'></i></td>
			<td><code>fas fa-search-minus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-search-plus'></i></td>
			<td><code>fas fa-search-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-seedling'></i></td>
			<td><code>fas fa-seedling</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-server'></i></td>
			<td><code>fas fa-server</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shapes'></i></td>
			<td><code>fas fa-shapes</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-share'></i></td>
			<td><code>fas fa-share</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-share-alt'></i></td>
			<td><code>fas fa-share-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-share-alt-square'></i></td>
			<td><code>fas fa-share-alt-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-share-square'></i></td>
			<td><code>fas fa-share-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shekel-sign'></i></td>
			<td><code>fas fa-shekel-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shield-alt'></i></td>
			<td><code>fas fa-shield-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ship'></i></td>
			<td><code>fas fa-ship</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shipping-fast'></i></td>
			<td><code>fas fa-shipping-fast</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shoe-prints'></i></td>
			<td><code>fas fa-shoe-prints</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shopping-bag'></i></td>
			<td><code>fas fa-shopping-bag</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shopping-basket'></i></td>
			<td><code>fas fa-shopping-basket</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shopping-cart'></i></td>
			<td><code>fas fa-shopping-cart</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shower'></i></td>
			<td><code>fas fa-shower</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-shuttle-van'></i></td>
			<td><code>fas fa-shuttle-van</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sign'></i></td>
			<td><code>fas fa-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sign-in-alt'></i></td>
			<td><code>fas fa-sign-in-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sign-language'></i></td>
			<td><code>fas fa-sign-language</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sign-out-alt'></i></td>
			<td><code>fas fa-sign-out-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-signal'></i></td>
			<td><code>fas fa-signal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-signature'></i></td>
			<td><code>fas fa-signature</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sim-card'></i></td>
			<td><code>fas fa-sim-card</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sitemap'></i></td>
			<td><code>fas fa-sitemap</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-skating'></i></td>
			<td><code>fas fa-skating</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-skiing'></i></td>
			<td><code>fas fa-skiing</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-skiing-nordic'></i></td>
			<td><code>fas fa-skiing-nordic</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-skull'></i></td>
			<td><code>fas fa-skull</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-skull-crossbones'></i></td>
			<td><code>fas fa-skull-crossbones</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-slash'></i></td>
			<td><code>fas fa-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sleigh'></i></td>
			<td><code>fas fa-sleigh</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sliders-h'></i></td>
			<td><code>fas fa-sliders-h</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smile'></i></td>
			<td><code>fas fa-smile</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smile-beam'></i></td>
			<td><code>fas fa-smile-beam</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smile-wink'></i></td>
			<td><code>fas fa-smile-wink</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smog'></i></td>
			<td><code>fas fa-smog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smoking'></i></td>
			<td><code>fas fa-smoking</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-smoking-ban'></i></td>
			<td><code>fas fa-smoking-ban</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sms'></i></td>
			<td><code>fas fa-sms</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-snowboarding'></i></td>
			<td><code>fas fa-snowboarding</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-snowflake'></i></td>
			<td><code>fas fa-snowflake</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-snowman'></i></td>
			<td><code>fas fa-snowman</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-snowplow'></i></td>
			<td><code>fas fa-snowplow</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-socks'></i></td>
			<td><code>fas fa-socks</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-solar-panel'></i></td>
			<td><code>fas fa-solar-panel</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort'></i></td>
			<td><code>fas fa-sort</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-alpha-down'></i></td>
			<td><code>fas fa-sort-alpha-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-alpha-down-alt'></i></td>
			<td><code>fas fa-sort-alpha-down-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-alpha-up'></i></td>
			<td><code>fas fa-sort-alpha-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-alpha-up-alt'></i></td>
			<td><code>fas fa-sort-alpha-up-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-amount-down'></i></td>
			<td><code>fas fa-sort-amount-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-amount-down-alt'></i></td>
			<td><code>fas fa-sort-amount-down-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-amount-up'></i></td>
			<td><code>fas fa-sort-amount-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-amount-up-alt'></i></td>
			<td><code>fas fa-sort-amount-up-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-down'></i></td>
			<td><code>fas fa-sort-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-numeric-down'></i></td>
			<td><code>fas fa-sort-numeric-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-numeric-down-alt'></i></td>
			<td><code>fas fa-sort-numeric-down-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-numeric-up'></i></td>
			<td><code>fas fa-sort-numeric-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-numeric-up-alt'></i></td>
			<td><code>fas fa-sort-numeric-up-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sort-up'></i></td>
			<td><code>fas fa-sort-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-spa'></i></td>
			<td><code>fas fa-spa</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-space-shuttle'></i></td>
			<td><code>fas fa-space-shuttle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-spell-check'></i></td>
			<td><code>fas fa-spell-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-spider'></i></td>
			<td><code>fas fa-spider</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-spinner'></i></td>
			<td><code>fas fa-spinner</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-splotch'></i></td>
			<td><code>fas fa-splotch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-spray-can'></i></td>
			<td><code>fas fa-spray-can</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-square'></i></td>
			<td><code>fas fa-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-square-full'></i></td>
			<td><code>fas fa-square-full</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-square-root-alt'></i></td>
			<td><code>fas fa-square-root-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stamp'></i></td>
			<td><code>fas fa-stamp</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star'></i></td>
			<td><code>fas fa-star</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star-and-crescent'></i></td>
			<td><code>fas fa-star-and-crescent</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star-half'></i></td>
			<td><code>fas fa-star-half</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star-half-alt'></i></td>
			<td><code>fas fa-star-half-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star-of-david'></i></td>
			<td><code>fas fa-star-of-david</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-star-of-life'></i></td>
			<td><code>fas fa-star-of-life</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-step-backward'></i></td>
			<td><code>fas fa-step-backward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-step-forward'></i></td>
			<td><code>fas fa-step-forward</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stethoscope'></i></td>
			<td><code>fas fa-stethoscope</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sticky-note'></i></td>
			<td><code>fas fa-sticky-note</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stop'></i></td>
			<td><code>fas fa-stop</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stop-circle'></i></td>
			<td><code>fas fa-stop-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stopwatch'></i></td>
			<td><code>fas fa-stopwatch</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-store'></i></td>
			<td><code>fas fa-store</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-store-alt'></i></td>
			<td><code>fas fa-store-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stream'></i></td>
			<td><code>fas fa-stream</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-street-view'></i></td>
			<td><code>fas fa-street-view</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-strikethrough'></i></td>
			<td><code>fas fa-strikethrough</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-stroopwafel'></i></td>
			<td><code>fas fa-stroopwafel</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-subscript'></i></td>
			<td><code>fas fa-subscript</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-subway'></i></td>
			<td><code>fas fa-subway</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-suitcase'></i></td>
			<td><code>fas fa-suitcase</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-suitcase-rolling'></i></td>
			<td><code>fas fa-suitcase-rolling</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sun'></i></td>
			<td><code>fas fa-sun</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-superscript'></i></td>
			<td><code>fas fa-superscript</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-surprise'></i></td>
			<td><code>fas fa-surprise</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-swatchbook'></i></td>
			<td><code>fas fa-swatchbook</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-swimmer'></i></td>
			<td><code>fas fa-swimmer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-swimming-pool'></i></td>
			<td><code>fas fa-swimming-pool</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-synagogue'></i></td>
			<td><code>fas fa-synagogue</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sync'></i></td>
			<td><code>fas fa-sync</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-sync-alt'></i></td>
			<td><code>fas fa-sync-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-syringe'></i></td>
			<td><code>fas fa-syringe</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-table'></i></td>
			<td><code>fas fa-table</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-table-tennis'></i></td>
			<td><code>fas fa-table-tennis</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tablet'></i></td>
			<td><code>fas fa-tablet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tablet-alt'></i></td>
			<td><code>fas fa-tablet-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tablets'></i></td>
			<td><code>fas fa-tablets</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tachometer-alt'></i></td>
			<td><code>fas fa-tachometer-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tag'></i></td>
			<td><code>fas fa-tag</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tags'></i></td>
			<td><code>fas fa-tags</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tape'></i></td>
			<td><code>fas fa-tape</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tasks'></i></td>
			<td><code>fas fa-tasks</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-taxi'></i></td>
			<td><code>fas fa-taxi</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-teeth'></i></td>
			<td><code>fas fa-teeth</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-teeth-open'></i></td>
			<td><code>fas fa-teeth-open</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-temperature-high'></i></td>
			<td><code>fas fa-temperature-high</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-temperature-low'></i></td>
			<td><code>fas fa-temperature-low</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tenge'></i></td>
			<td><code>fas fa-tenge</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-terminal'></i></td>
			<td><code>fas fa-terminal</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-text-height'></i></td>
			<td><code>fas fa-text-height</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-text-width'></i></td>
			<td><code>fas fa-text-width</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-th'></i></td>
			<td><code>fas fa-th</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-th-large'></i></td>
			<td><code>fas fa-th-large</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-th-list'></i></td>
			<td><code>fas fa-th-list</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-theater-masks'></i></td>
			<td><code>fas fa-theater-masks</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer'></i></td>
			<td><code>fas fa-thermometer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer-empty'></i></td>
			<td><code>fas fa-thermometer-empty</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer-full'></i></td>
			<td><code>fas fa-thermometer-full</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer-half'></i></td>
			<td><code>fas fa-thermometer-half</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer-quarter'></i></td>
			<td><code>fas fa-thermometer-quarter</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thermometer-three-quarters'></i></td>
			<td><code>fas fa-thermometer-three-quarters</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thumbs-down'></i></td>
			<td><code>fas fa-thumbs-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thumbs-up'></i></td>
			<td><code>fas fa-thumbs-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-thumbtack'></i></td>
			<td><code>fas fa-thumbtack</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-ticket-alt'></i></td>
			<td><code>fas fa-ticket-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-times'></i></td>
			<td><code>fas fa-times</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-times-circle'></i></td>
			<td><code>fas fa-times-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tint'></i></td>
			<td><code>fas fa-tint</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tint-slash'></i></td>
			<td><code>fas fa-tint-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tired'></i></td>
			<td><code>fas fa-tired</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-toggle-off'></i></td>
			<td><code>fas fa-toggle-off</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-toggle-on'></i></td>
			<td><code>fas fa-toggle-on</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-toilet'></i></td>
			<td><code>fas fa-toilet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-toilet-paper'></i></td>
			<td><code>fas fa-toilet-paper</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-toolbox'></i></td>
			<td><code>fas fa-toolbox</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tools'></i></td>
			<td><code>fas fa-tools</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tooth'></i></td>
			<td><code>fas fa-tooth</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-torah'></i></td>
			<td><code>fas fa-torah</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-torii-gate'></i></td>
			<td><code>fas fa-torii-gate</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tractor'></i></td>
			<td><code>fas fa-tractor</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trademark'></i></td>
			<td><code>fas fa-trademark</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-traffic-light'></i></td>
			<td><code>fas fa-traffic-light</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trailer'></i></td>
			<td><code>fas fa-trailer</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-train'></i></td>
			<td><code>fas fa-train</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tram'></i></td>
			<td><code>fas fa-tram</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-transgender'></i></td>
			<td><code>fas fa-transgender</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-transgender-alt'></i></td>
			<td><code>fas fa-transgender-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trash'></i></td>
			<td><code>fas fa-trash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trash-alt'></i></td>
			<td><code>fas fa-trash-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trash-restore'></i></td>
			<td><code>fas fa-trash-restore</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trash-restore-alt'></i></td>
			<td><code>fas fa-trash-restore-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tree'></i></td>
			<td><code>fas fa-tree</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-trophy'></i></td>
			<td><code>fas fa-trophy</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-truck'></i></td>
			<td><code>fas fa-truck</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-truck-loading'></i></td>
			<td><code>fas fa-truck-loading</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-truck-monster'></i></td>
			<td><code>fas fa-truck-monster</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-truck-moving'></i></td>
			<td><code>fas fa-truck-moving</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-truck-pickup'></i></td>
			<td><code>fas fa-truck-pickup</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tshirt'></i></td>
			<td><code>fas fa-tshirt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tty'></i></td>
			<td><code>fas fa-tty</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-tv'></i></td>
			<td><code>fas fa-tv</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-umbrella'></i></td>
			<td><code>fas fa-umbrella</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-umbrella-beach'></i></td>
			<td><code>fas fa-umbrella-beach</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-underline'></i></td>
			<td><code>fas fa-underline</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-undo'></i></td>
			<td><code>fas fa-undo</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-undo-alt'></i></td>
			<td><code>fas fa-undo-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-universal-access'></i></td>
			<td><code>fas fa-universal-access</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-university'></i></td>
			<td><code>fas fa-university</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-unlink'></i></td>
			<td><code>fas fa-unlink</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-unlock'></i></td>
			<td><code>fas fa-unlock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-unlock-alt'></i></td>
			<td><code>fas fa-unlock-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-upload'></i></td>
			<td><code>fas fa-upload</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user'></i></td>
			<td><code>fas fa-user</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-alt'></i></td>
			<td><code>fas fa-user-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-alt-slash'></i></td>
			<td><code>fas fa-user-alt-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-astronaut'></i></td>
			<td><code>fas fa-user-astronaut</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-check'></i></td>
			<td><code>fas fa-user-check</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-circle'></i></td>
			<td><code>fas fa-user-circle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-clock'></i></td>
			<td><code>fas fa-user-clock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-cog'></i></td>
			<td><code>fas fa-user-cog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-edit'></i></td>
			<td><code>fas fa-user-edit</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-friends'></i></td>
			<td><code>fas fa-user-friends</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-graduate'></i></td>
			<td><code>fas fa-user-graduate</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-injured'></i></td>
			<td><code>fas fa-user-injured</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-lock'></i></td>
			<td><code>fas fa-user-lock</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-md'></i></td>
			<td><code>fas fa-user-md</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-minus'></i></td>
			<td><code>fas fa-user-minus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-ninja'></i></td>
			<td><code>fas fa-user-ninja</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-nurse'></i></td>
			<td><code>fas fa-user-nurse</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-plus'></i></td>
			<td><code>fas fa-user-plus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-secret'></i></td>
			<td><code>fas fa-user-secret</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-shield'></i></td>
			<td><code>fas fa-user-shield</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-slash'></i></td>
			<td><code>fas fa-user-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-tag'></i></td>
			<td><code>fas fa-user-tag</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-tie'></i></td>
			<td><code>fas fa-user-tie</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-user-times'></i></td>
			<td><code>fas fa-user-times</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-users'></i></td>
			<td><code>fas fa-users</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-users-cog'></i></td>
			<td><code>fas fa-users-cog</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-utensil-spoon'></i></td>
			<td><code>fas fa-utensil-spoon</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-utensils'></i></td>
			<td><code>fas fa-utensils</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vector-square'></i></td>
			<td><code>fas fa-vector-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-venus'></i></td>
			<td><code>fas fa-venus</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-venus-double'></i></td>
			<td><code>fas fa-venus-double</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-venus-mars'></i></td>
			<td><code>fas fa-venus-mars</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vial'></i></td>
			<td><code>fas fa-vial</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vials'></i></td>
			<td><code>fas fa-vials</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-video'></i></td>
			<td><code>fas fa-video</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-video-slash'></i></td>
			<td><code>fas fa-video-slash</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vihara'></i></td>
			<td><code>fas fa-vihara</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-voicemail'></i></td>
			<td><code>fas fa-voicemail</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-volleyball-ball'></i></td>
			<td><code>fas fa-volleyball-ball</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-volume-down'></i></td>
			<td><code>fas fa-volume-down</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-volume-mute'></i></td>
			<td><code>fas fa-volume-mute</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-volume-off'></i></td>
			<td><code>fas fa-volume-off</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-volume-up'></i></td>
			<td><code>fas fa-volume-up</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vote-yea'></i></td>
			<td><code>fas fa-vote-yea</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-vr-cardboard'></i></td>
			<td><code>fas fa-vr-cardboard</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-walking'></i></td>
			<td><code>fas fa-walking</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wallet'></i></td>
			<td><code>fas fa-wallet</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-warehouse'></i></td>
			<td><code>fas fa-warehouse</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-water'></i></td>
			<td><code>fas fa-water</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wave-square'></i></td>
			<td><code>fas fa-wave-square</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-weight'></i></td>
			<td><code>fas fa-weight</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-weight-hanging'></i></td>
			<td><code>fas fa-weight-hanging</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wheelchair'></i></td>
			<td><code>fas fa-wheelchair</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wifi'></i></td>
			<td><code>fas fa-wifi</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wind'></i></td>
			<td><code>fas fa-wind</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-window-close'></i></td>
			<td><code>fas fa-window-close</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-window-maximize'></i></td>
			<td><code>fas fa-window-maximize</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-window-minimize'></i></td>
			<td><code>fas fa-window-minimize</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-window-restore'></i></td>
			<td><code>fas fa-window-restore</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wine-bottle'></i></td>
			<td><code>fas fa-wine-bottle</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wine-glass'></i></td>
			<td><code>fas fa-wine-glass</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wine-glass-alt'></i></td>
			<td><code>fas fa-wine-glass-alt</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-won-sign'></i></td>
			<td><code>fas fa-won-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-wrench'></i></td>
			<td><code>fas fa-wrench</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-x-ray'></i></td>
			<td><code>fas fa-x-ray</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-yen-sign'></i></td>
			<td><code>fas fa-yen-sign</code></td>
		</tr>
		<tr>
			<td><i class='fas fa-yin-yang'></i></td>
			<td><code>fas fa-yin-yang</code></td>
		</tr>
	</tbody>
</table>
<h3 id='fontawesome_brand'>Brand Icons</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Icon</th>
			<th>CSS Reference</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><i class='fab fa-500px'></i></td>
			<td><code>fab fa-500px</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-accessible-icon'></i></td>
			<td><code>fab fa-accessible-icon</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-accusoft'></i></td>
			<td><code>fab fa-accusoft</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-acquisitions-incorporated'></i></td>
			<td><code>fab fa-acquisitions-incorporated</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-adn'></i></td>
			<td><code>fab fa-adn</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-adobe'></i></td>
			<td><code>fab fa-adobe</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-adversal'></i></td>
			<td><code>fab fa-adversal</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-affiliatetheme'></i></td>
			<td><code>fab fa-affiliatetheme</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-airbnb'></i></td>
			<td><code>fab fa-airbnb</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-algolia'></i></td>
			<td><code>fab fa-algolia</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-alipay'></i></td>
			<td><code>fab fa-alipay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-amazon'></i></td>
			<td><code>fab fa-amazon</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-amazon-pay'></i></td>
			<td><code>fab fa-amazon-pay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-amilia'></i></td>
			<td><code>fab fa-amilia</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-android'></i></td>
			<td><code>fab fa-android</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-angellist'></i></td>
			<td><code>fab fa-angellist</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-angrycreative'></i></td>
			<td><code>fab fa-angrycreative</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-angular'></i></td>
			<td><code>fab fa-angular</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-app-store'></i></td>
			<td><code>fab fa-app-store</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-app-store-ios'></i></td>
			<td><code>fab fa-app-store-ios</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-apper'></i></td>
			<td><code>fab fa-apper</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-apple'></i></td>
			<td><code>fab fa-apple</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-apple-pay'></i></td>
			<td><code>fab fa-apple-pay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-artstation'></i></td>
			<td><code>fab fa-artstation</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-asymmetrik'></i></td>
			<td><code>fab fa-asymmetrik</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-atlassian'></i></td>
			<td><code>fab fa-atlassian</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-audible'></i></td>
			<td><code>fab fa-audible</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-autoprefixer'></i></td>
			<td><code>fab fa-autoprefixer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-avianex'></i></td>
			<td><code>fab fa-avianex</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-aviato'></i></td>
			<td><code>fab fa-aviato</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-aws'></i></td>
			<td><code>fab fa-aws</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bandcamp'></i></td>
			<td><code>fab fa-bandcamp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-battle-net'></i></td>
			<td><code>fab fa-battle-net</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-behance'></i></td>
			<td><code>fab fa-behance</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-behance-square'></i></td>
			<td><code>fab fa-behance-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bimobject'></i></td>
			<td><code>fab fa-bimobject</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bitbucket'></i></td>
			<td><code>fab fa-bitbucket</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bitcoin'></i></td>
			<td><code>fab fa-bitcoin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bity'></i></td>
			<td><code>fab fa-bity</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-black-tie'></i></td>
			<td><code>fab fa-black-tie</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-blackberry'></i></td>
			<td><code>fab fa-blackberry</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-blogger'></i></td>
			<td><code>fab fa-blogger</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-blogger-b'></i></td>
			<td><code>fab fa-blogger-b</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bluetooth'></i></td>
			<td><code>fab fa-bluetooth</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bluetooth-b'></i></td>
			<td><code>fab fa-bluetooth-b</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-bootstrap'></i></td>
			<td><code>fab fa-bootstrap</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-btc'></i></td>
			<td><code>fab fa-btc</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-buffer'></i></td>
			<td><code>fab fa-buffer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-buromobelexperte'></i></td>
			<td><code>fab fa-buromobelexperte</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-buy-n-large'></i></td>
			<td><code>fab fa-buy-n-large</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-buysellads'></i></td>
			<td><code>fab fa-buysellads</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-canadian-maple-leaf'></i></td>
			<td><code>fab fa-canadian-maple-leaf</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-amazon-pay'></i></td>
			<td><code>fab fa-cc-amazon-pay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-amex'></i></td>
			<td><code>fab fa-cc-amex</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-apple-pay'></i></td>
			<td><code>fab fa-cc-apple-pay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-diners-club'></i></td>
			<td><code>fab fa-cc-diners-club</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-discover'></i></td>
			<td><code>fab fa-cc-discover</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-jcb'></i></td>
			<td><code>fab fa-cc-jcb</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-mastercard'></i></td>
			<td><code>fab fa-cc-mastercard</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-paypal'></i></td>
			<td><code>fab fa-cc-paypal</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-stripe'></i></td>
			<td><code>fab fa-cc-stripe</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cc-visa'></i></td>
			<td><code>fab fa-cc-visa</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-centercode'></i></td>
			<td><code>fab fa-centercode</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-centos'></i></td>
			<td><code>fab fa-centos</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-chrome'></i></td>
			<td><code>fab fa-chrome</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-chromecast'></i></td>
			<td><code>fab fa-chromecast</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cloudscale'></i></td>
			<td><code>fab fa-cloudscale</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cloudsmith'></i></td>
			<td><code>fab fa-cloudsmith</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cloudversify'></i></td>
			<td><code>fab fa-cloudversify</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-codepen'></i></td>
			<td><code>fab fa-codepen</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-codiepie'></i></td>
			<td><code>fab fa-codiepie</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-confluence'></i></td>
			<td><code>fab fa-confluence</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-connectdevelop'></i></td>
			<td><code>fab fa-connectdevelop</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-contao'></i></td>
			<td><code>fab fa-contao</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cotton-bureau'></i></td>
			<td><code>fab fa-cotton-bureau</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cpanel'></i></td>
			<td><code>fab fa-cpanel</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons'></i></td>
			<td><code>fab fa-creative-commons</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-by'></i></td>
			<td><code>fab fa-creative-commons-by</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-nc'></i></td>
			<td><code>fab fa-creative-commons-nc</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-nc-eu'></i></td>
			<td><code>fab fa-creative-commons-nc-eu</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-nc-jp'></i></td>
			<td><code>fab fa-creative-commons-nc-jp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-nd'></i></td>
			<td><code>fab fa-creative-commons-nd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-pd'></i></td>
			<td><code>fab fa-creative-commons-pd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-pd-alt'></i></td>
			<td><code>fab fa-creative-commons-pd-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-remix'></i></td>
			<td><code>fab fa-creative-commons-remix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-sa'></i></td>
			<td><code>fab fa-creative-commons-sa</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-sampling'></i></td>
			<td><code>fab fa-creative-commons-sampling</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-sampling-plus'></i></td>
			<td><code>fab fa-creative-commons-sampling-plus</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-share'></i></td>
			<td><code>fab fa-creative-commons-share</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-creative-commons-zero'></i></td>
			<td><code>fab fa-creative-commons-zero</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-critical-role'></i></td>
			<td><code>fab fa-critical-role</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-css3'></i></td>
			<td><code>fab fa-css3</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-css3-alt'></i></td>
			<td><code>fab fa-css3-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-cuttlefish'></i></td>
			<td><code>fab fa-cuttlefish</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-d-and-d'></i></td>
			<td><code>fab fa-d-and-d</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-d-and-d-beyond'></i></td>
			<td><code>fab fa-d-and-d-beyond</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dailymotion'></i></td>
			<td><code>fab fa-dailymotion</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dashcube'></i></td>
			<td><code>fab fa-dashcube</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-delicious'></i></td>
			<td><code>fab fa-delicious</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-deploydog'></i></td>
			<td><code>fab fa-deploydog</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-deskpro'></i></td>
			<td><code>fab fa-deskpro</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dev'></i></td>
			<td><code>fab fa-dev</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-deviantart'></i></td>
			<td><code>fab fa-deviantart</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dhl'></i></td>
			<td><code>fab fa-dhl</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-diaspora'></i></td>
			<td><code>fab fa-diaspora</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-digg'></i></td>
			<td><code>fab fa-digg</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-digital-ocean'></i></td>
			<td><code>fab fa-digital-ocean</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-discord'></i></td>
			<td><code>fab fa-discord</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-discourse'></i></td>
			<td><code>fab fa-discourse</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dochub'></i></td>
			<td><code>fab fa-dochub</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-docker'></i></td>
			<td><code>fab fa-docker</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-draft2digital'></i></td>
			<td><code>fab fa-draft2digital</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dribbble'></i></td>
			<td><code>fab fa-dribbble</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dribbble-square'></i></td>
			<td><code>fab fa-dribbble-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dropbox'></i></td>
			<td><code>fab fa-dropbox</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-drupal'></i></td>
			<td><code>fab fa-drupal</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-dyalog'></i></td>
			<td><code>fab fa-dyalog</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-earlybirds'></i></td>
			<td><code>fab fa-earlybirds</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ebay'></i></td>
			<td><code>fab fa-ebay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-edge'></i></td>
			<td><code>fab fa-edge</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-elementor'></i></td>
			<td><code>fab fa-elementor</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ello'></i></td>
			<td><code>fab fa-ello</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ember'></i></td>
			<td><code>fab fa-ember</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-empire'></i></td>
			<td><code>fab fa-empire</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-envira'></i></td>
			<td><code>fab fa-envira</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-erlang'></i></td>
			<td><code>fab fa-erlang</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ethereum'></i></td>
			<td><code>fab fa-ethereum</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-etsy'></i></td>
			<td><code>fab fa-etsy</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-evernote'></i></td>
			<td><code>fab fa-evernote</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-expeditedssl'></i></td>
			<td><code>fab fa-expeditedssl</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-facebook'></i></td>
			<td><code>fab fa-facebook</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-facebook-f'></i></td>
			<td><code>fab fa-facebook-f</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-facebook-messenger'></i></td>
			<td><code>fab fa-facebook-messenger</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-facebook-square'></i></td>
			<td><code>fab fa-facebook-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fantasy-flight-games'></i></td>
			<td><code>fab fa-fantasy-flight-games</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fedex'></i></td>
			<td><code>fab fa-fedex</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fedora'></i></td>
			<td><code>fab fa-fedora</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-figma'></i></td>
			<td><code>fab fa-figma</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-firefox'></i></td>
			<td><code>fab fa-firefox</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-firefox-browser'></i></td>
			<td><code>fab fa-firefox-browser</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-first-order'></i></td>
			<td><code>fab fa-first-order</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-first-order-alt'></i></td>
			<td><code>fab fa-first-order-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-firstdraft'></i></td>
			<td><code>fab fa-firstdraft</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-flickr'></i></td>
			<td><code>fab fa-flickr</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-flipboard'></i></td>
			<td><code>fab fa-flipboard</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fly'></i></td>
			<td><code>fab fa-fly</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-font-awesome'></i></td>
			<td><code>fab fa-font-awesome</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-font-awesome-alt'></i></td>
			<td><code>fab fa-font-awesome-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-font-awesome-flag'></i></td>
			<td><code>fab fa-font-awesome-flag</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fonticons'></i></td>
			<td><code>fab fa-fonticons</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fonticons-fi'></i></td>
			<td><code>fab fa-fonticons-fi</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fort-awesome'></i></td>
			<td><code>fab fa-fort-awesome</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fort-awesome-alt'></i></td>
			<td><code>fab fa-fort-awesome-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-forumbee'></i></td>
			<td><code>fab fa-forumbee</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-foursquare'></i></td>
			<td><code>fab fa-foursquare</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-free-code-camp'></i></td>
			<td><code>fab fa-free-code-camp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-freebsd'></i></td>
			<td><code>fab fa-freebsd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-fulcrum'></i></td>
			<td><code>fab fa-fulcrum</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-galactic-republic'></i></td>
			<td><code>fab fa-galactic-republic</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-galactic-senate'></i></td>
			<td><code>fab fa-galactic-senate</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-get-pocket'></i></td>
			<td><code>fab fa-get-pocket</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gg'></i></td>
			<td><code>fab fa-gg</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gg-circle'></i></td>
			<td><code>fab fa-gg-circle</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-git'></i></td>
			<td><code>fab fa-git</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-git-alt'></i></td>
			<td><code>fab fa-git-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-git-square'></i></td>
			<td><code>fab fa-git-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-github'></i></td>
			<td><code>fab fa-github</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-github-alt'></i></td>
			<td><code>fab fa-github-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-github-square'></i></td>
			<td><code>fab fa-github-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gitkraken'></i></td>
			<td><code>fab fa-gitkraken</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gitlab'></i></td>
			<td><code>fab fa-gitlab</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gitter'></i></td>
			<td><code>fab fa-gitter</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-glide'></i></td>
			<td><code>fab fa-glide</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-glide-g'></i></td>
			<td><code>fab fa-glide-g</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gofore'></i></td>
			<td><code>fab fa-gofore</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-goodreads'></i></td>
			<td><code>fab fa-goodreads</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-goodreads-g'></i></td>
			<td><code>fab fa-goodreads-g</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google'></i></td>
			<td><code>fab fa-google</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-drive'></i></td>
			<td><code>fab fa-google-drive</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-play'></i></td>
			<td><code>fab fa-google-play</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-plus'></i></td>
			<td><code>fab fa-google-plus</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-plus-g'></i></td>
			<td><code>fab fa-google-plus-g</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-plus-square'></i></td>
			<td><code>fab fa-google-plus-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-google-wallet'></i></td>
			<td><code>fab fa-google-wallet</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gratipay'></i></td>
			<td><code>fab fa-gratipay</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-grav'></i></td>
			<td><code>fab fa-grav</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gripfire'></i></td>
			<td><code>fab fa-gripfire</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-grunt'></i></td>
			<td><code>fab fa-grunt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-gulp'></i></td>
			<td><code>fab fa-gulp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hacker-news'></i></td>
			<td><code>fab fa-hacker-news</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hacker-news-square'></i></td>
			<td><code>fab fa-hacker-news-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hackerrank'></i></td>
			<td><code>fab fa-hackerrank</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hips'></i></td>
			<td><code>fab fa-hips</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hire-a-helper'></i></td>
			<td><code>fab fa-hire-a-helper</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hooli'></i></td>
			<td><code>fab fa-hooli</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hornbill'></i></td>
			<td><code>fab fa-hornbill</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hotjar'></i></td>
			<td><code>fab fa-hotjar</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-houzz'></i></td>
			<td><code>fab fa-houzz</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-html5'></i></td>
			<td><code>fab fa-html5</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-hubspot'></i></td>
			<td><code>fab fa-hubspot</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ideal'></i></td>
			<td><code>fab fa-ideal</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-imdb'></i></td>
			<td><code>fab fa-imdb</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-instagram'></i></td>
			<td><code>fab fa-instagram</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-instagram-square'></i></td>
			<td><code>fab fa-instagram-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-intercom'></i></td>
			<td><code>fab fa-intercom</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-internet-explorer'></i></td>
			<td><code>fab fa-internet-explorer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-invision'></i></td>
			<td><code>fab fa-invision</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ioxhost'></i></td>
			<td><code>fab fa-ioxhost</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-itch-io'></i></td>
			<td><code>fab fa-itch-io</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-itunes'></i></td>
			<td><code>fab fa-itunes</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-itunes-note'></i></td>
			<td><code>fab fa-itunes-note</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-java'></i></td>
			<td><code>fab fa-java</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-jedi-order'></i></td>
			<td><code>fab fa-jedi-order</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-jenkins'></i></td>
			<td><code>fab fa-jenkins</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-jira'></i></td>
			<td><code>fab fa-jira</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-joget'></i></td>
			<td><code>fab fa-joget</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-joomla'></i></td>
			<td><code>fab fa-joomla</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-js'></i></td>
			<td><code>fab fa-js</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-js-square'></i></td>
			<td><code>fab fa-js-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-jsfiddle'></i></td>
			<td><code>fab fa-jsfiddle</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-kaggle'></i></td>
			<td><code>fab fa-kaggle</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-keybase'></i></td>
			<td><code>fab fa-keybase</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-keycdn'></i></td>
			<td><code>fab fa-keycdn</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-kickstarter'></i></td>
			<td><code>fab fa-kickstarter</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-kickstarter-k'></i></td>
			<td><code>fab fa-kickstarter-k</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-korvue'></i></td>
			<td><code>fab fa-korvue</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-laravel'></i></td>
			<td><code>fab fa-laravel</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-lastfm'></i></td>
			<td><code>fab fa-lastfm</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-lastfm-square'></i></td>
			<td><code>fab fa-lastfm-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-leanpub'></i></td>
			<td><code>fab fa-leanpub</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-less'></i></td>
			<td><code>fab fa-less</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-line'></i></td>
			<td><code>fab fa-line</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-linkedin'></i></td>
			<td><code>fab fa-linkedin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-linkedin-in'></i></td>
			<td><code>fab fa-linkedin-in</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-linode'></i></td>
			<td><code>fab fa-linode</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-linux'></i></td>
			<td><code>fab fa-linux</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-lyft'></i></td>
			<td><code>fab fa-lyft</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-magento'></i></td>
			<td><code>fab fa-magento</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mailchimp'></i></td>
			<td><code>fab fa-mailchimp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mandalorian'></i></td>
			<td><code>fab fa-mandalorian</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-markdown'></i></td>
			<td><code>fab fa-markdown</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mastodon'></i></td>
			<td><code>fab fa-mastodon</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-maxcdn'></i></td>
			<td><code>fab fa-maxcdn</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mdb'></i></td>
			<td><code>fab fa-mdb</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-medapps'></i></td>
			<td><code>fab fa-medapps</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-medium'></i></td>
			<td><code>fab fa-medium</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-medium-m'></i></td>
			<td><code>fab fa-medium-m</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-medrt'></i></td>
			<td><code>fab fa-medrt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-meetup'></i></td>
			<td><code>fab fa-meetup</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-megaport'></i></td>
			<td><code>fab fa-megaport</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mendeley'></i></td>
			<td><code>fab fa-mendeley</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-microblog'></i></td>
			<td><code>fab fa-microblog</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-microsoft'></i></td>
			<td><code>fab fa-microsoft</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mix'></i></td>
			<td><code>fab fa-mix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mixcloud'></i></td>
			<td><code>fab fa-mixcloud</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mixer'></i></td>
			<td><code>fab fa-mixer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-mizuni'></i></td>
			<td><code>fab fa-mizuni</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-modx'></i></td>
			<td><code>fab fa-modx</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-monero'></i></td>
			<td><code>fab fa-monero</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-napster'></i></td>
			<td><code>fab fa-napster</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-neos'></i></td>
			<td><code>fab fa-neos</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-nimblr'></i></td>
			<td><code>fab fa-nimblr</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-node'></i></td>
			<td><code>fab fa-node</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-node-js'></i></td>
			<td><code>fab fa-node-js</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-npm'></i></td>
			<td><code>fab fa-npm</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ns8'></i></td>
			<td><code>fab fa-ns8</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-nutritionix'></i></td>
			<td><code>fab fa-nutritionix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-odnoklassniki'></i></td>
			<td><code>fab fa-odnoklassniki</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-odnoklassniki-square'></i></td>
			<td><code>fab fa-odnoklassniki-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-old-republic'></i></td>
			<td><code>fab fa-old-republic</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-opencart'></i></td>
			<td><code>fab fa-opencart</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-openid'></i></td>
			<td><code>fab fa-openid</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-opera'></i></td>
			<td><code>fab fa-opera</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-optin-monster'></i></td>
			<td><code>fab fa-optin-monster</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-orcid'></i></td>
			<td><code>fab fa-orcid</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-osi'></i></td>
			<td><code>fab fa-osi</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-page4'></i></td>
			<td><code>fab fa-page4</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pagelines'></i></td>
			<td><code>fab fa-pagelines</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-palfed'></i></td>
			<td><code>fab fa-palfed</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-patreon'></i></td>
			<td><code>fab fa-patreon</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-paypal'></i></td>
			<td><code>fab fa-paypal</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-penny-arcade'></i></td>
			<td><code>fab fa-penny-arcade</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-periscope'></i></td>
			<td><code>fab fa-periscope</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-phabricator'></i></td>
			<td><code>fab fa-phabricator</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-phoenix-framework'></i></td>
			<td><code>fab fa-phoenix-framework</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-phoenix-squadron'></i></td>
			<td><code>fab fa-phoenix-squadron</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-php'></i></td>
			<td><code>fab fa-php</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pied-piper'></i></td>
			<td><code>fab fa-pied-piper</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pied-piper-alt'></i></td>
			<td><code>fab fa-pied-piper-alt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pied-piper-hat'></i></td>
			<td><code>fab fa-pied-piper-hat</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pied-piper-pp'></i></td>
			<td><code>fab fa-pied-piper-pp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pied-piper-square'></i></td>
			<td><code>fab fa-pied-piper-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pinterest'></i></td>
			<td><code>fab fa-pinterest</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pinterest-p'></i></td>
			<td><code>fab fa-pinterest-p</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pinterest-square'></i></td>
			<td><code>fab fa-pinterest-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-playstation'></i></td>
			<td><code>fab fa-playstation</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-product-hunt'></i></td>
			<td><code>fab fa-product-hunt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-pushed'></i></td>
			<td><code>fab fa-pushed</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-python'></i></td>
			<td><code>fab fa-python</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-qq'></i></td>
			<td><code>fab fa-qq</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-quinscape'></i></td>
			<td><code>fab fa-quinscape</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-quora'></i></td>
			<td><code>fab fa-quora</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-r-project'></i></td>
			<td><code>fab fa-r-project</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-raspberry-pi'></i></td>
			<td><code>fab fa-raspberry-pi</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ravelry'></i></td>
			<td><code>fab fa-ravelry</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-react'></i></td>
			<td><code>fab fa-react</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-reacteurope'></i></td>
			<td><code>fab fa-reacteurope</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-readme'></i></td>
			<td><code>fab fa-readme</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-rebel'></i></td>
			<td><code>fab fa-rebel</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-red-river'></i></td>
			<td><code>fab fa-red-river</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-reddit'></i></td>
			<td><code>fab fa-reddit</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-reddit-alien'></i></td>
			<td><code>fab fa-reddit-alien</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-reddit-square'></i></td>
			<td><code>fab fa-reddit-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-redhat'></i></td>
			<td><code>fab fa-redhat</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-renren'></i></td>
			<td><code>fab fa-renren</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-replyd'></i></td>
			<td><code>fab fa-replyd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-researchgate'></i></td>
			<td><code>fab fa-researchgate</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-resolving'></i></td>
			<td><code>fab fa-resolving</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-rev'></i></td>
			<td><code>fab fa-rev</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-rocketchat'></i></td>
			<td><code>fab fa-rocketchat</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-rockrms'></i></td>
			<td><code>fab fa-rockrms</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-safari'></i></td>
			<td><code>fab fa-safari</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-salesforce'></i></td>
			<td><code>fab fa-salesforce</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sass'></i></td>
			<td><code>fab fa-sass</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-schlix'></i></td>
			<td><code>fab fa-schlix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-scribd'></i></td>
			<td><code>fab fa-scribd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-searchengin'></i></td>
			<td><code>fab fa-searchengin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sellcast'></i></td>
			<td><code>fab fa-sellcast</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sellsy'></i></td>
			<td><code>fab fa-sellsy</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-servicestack'></i></td>
			<td><code>fab fa-servicestack</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-shirtsinbulk'></i></td>
			<td><code>fab fa-shirtsinbulk</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-shopify'></i></td>
			<td><code>fab fa-shopify</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-shopware'></i></td>
			<td><code>fab fa-shopware</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-simplybuilt'></i></td>
			<td><code>fab fa-simplybuilt</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sistrix'></i></td>
			<td><code>fab fa-sistrix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sith'></i></td>
			<td><code>fab fa-sith</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sketch'></i></td>
			<td><code>fab fa-sketch</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-skyatlas'></i></td>
			<td><code>fab fa-skyatlas</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-skype'></i></td>
			<td><code>fab fa-skype</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-slack'></i></td>
			<td><code>fab fa-slack</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-slack-hash'></i></td>
			<td><code>fab fa-slack-hash</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-slideshare'></i></td>
			<td><code>fab fa-slideshare</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-snapchat'></i></td>
			<td><code>fab fa-snapchat</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-snapchat-ghost'></i></td>
			<td><code>fab fa-snapchat-ghost</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-snapchat-square'></i></td>
			<td><code>fab fa-snapchat-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-soundcloud'></i></td>
			<td><code>fab fa-soundcloud</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sourcetree'></i></td>
			<td><code>fab fa-sourcetree</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-speakap'></i></td>
			<td><code>fab fa-speakap</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-speaker-deck'></i></td>
			<td><code>fab fa-speaker-deck</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-spotify'></i></td>
			<td><code>fab fa-spotify</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-squarespace'></i></td>
			<td><code>fab fa-squarespace</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stack-exchange'></i></td>
			<td><code>fab fa-stack-exchange</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stack-overflow'></i></td>
			<td><code>fab fa-stack-overflow</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stackpath'></i></td>
			<td><code>fab fa-stackpath</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-staylinked'></i></td>
			<td><code>fab fa-staylinked</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-steam'></i></td>
			<td><code>fab fa-steam</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-steam-square'></i></td>
			<td><code>fab fa-steam-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-steam-symbol'></i></td>
			<td><code>fab fa-steam-symbol</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-sticker-mule'></i></td>
			<td><code>fab fa-sticker-mule</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-strava'></i></td>
			<td><code>fab fa-strava</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stripe'></i></td>
			<td><code>fab fa-stripe</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stripe-s'></i></td>
			<td><code>fab fa-stripe-s</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-studiovinari'></i></td>
			<td><code>fab fa-studiovinari</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stumbleupon'></i></td>
			<td><code>fab fa-stumbleupon</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-stumbleupon-circle'></i></td>
			<td><code>fab fa-stumbleupon-circle</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-superpowers'></i></td>
			<td><code>fab fa-superpowers</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-supple'></i></td>
			<td><code>fab fa-supple</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-suse'></i></td>
			<td><code>fab fa-suse</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-swift'></i></td>
			<td><code>fab fa-swift</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-symfony'></i></td>
			<td><code>fab fa-symfony</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-teamspeak'></i></td>
			<td><code>fab fa-teamspeak</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-telegram'></i></td>
			<td><code>fab fa-telegram</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-telegram-plane'></i></td>
			<td><code>fab fa-telegram-plane</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-tencent-weibo'></i></td>
			<td><code>fab fa-tencent-weibo</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-the-red-yeti'></i></td>
			<td><code>fab fa-the-red-yeti</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-themeco'></i></td>
			<td><code>fab fa-themeco</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-themeisle'></i></td>
			<td><code>fab fa-themeisle</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-think-peaks'></i></td>
			<td><code>fab fa-think-peaks</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-trade-federation'></i></td>
			<td><code>fab fa-trade-federation</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-trello'></i></td>
			<td><code>fab fa-trello</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-tripadvisor'></i></td>
			<td><code>fab fa-tripadvisor</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-tumblr'></i></td>
			<td><code>fab fa-tumblr</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-tumblr-square'></i></td>
			<td><code>fab fa-tumblr-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-twitch'></i></td>
			<td><code>fab fa-twitch</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-twitter'></i></td>
			<td><code>fab fa-twitter</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-twitter-square'></i></td>
			<td><code>fab fa-twitter-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-typo3'></i></td>
			<td><code>fab fa-typo3</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-uber'></i></td>
			<td><code>fab fa-uber</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ubuntu'></i></td>
			<td><code>fab fa-ubuntu</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-uikit'></i></td>
			<td><code>fab fa-uikit</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-umbraco'></i></td>
			<td><code>fab fa-umbraco</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-uniregistry'></i></td>
			<td><code>fab fa-uniregistry</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-unity'></i></td>
			<td><code>fab fa-unity</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-untappd'></i></td>
			<td><code>fab fa-untappd</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ups'></i></td>
			<td><code>fab fa-ups</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-usb'></i></td>
			<td><code>fab fa-usb</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-usps'></i></td>
			<td><code>fab fa-usps</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-ussunnah'></i></td>
			<td><code>fab fa-ussunnah</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vaadin'></i></td>
			<td><code>fab fa-vaadin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-viacoin'></i></td>
			<td><code>fab fa-viacoin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-viadeo'></i></td>
			<td><code>fab fa-viadeo</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-viadeo-square'></i></td>
			<td><code>fab fa-viadeo-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-viber'></i></td>
			<td><code>fab fa-viber</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vimeo'></i></td>
			<td><code>fab fa-vimeo</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vimeo-square'></i></td>
			<td><code>fab fa-vimeo-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vimeo-v'></i></td>
			<td><code>fab fa-vimeo-v</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vine'></i></td>
			<td><code>fab fa-vine</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vk'></i></td>
			<td><code>fab fa-vk</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vnv'></i></td>
			<td><code>fab fa-vnv</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-vuejs'></i></td>
			<td><code>fab fa-vuejs</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-waze'></i></td>
			<td><code>fab fa-waze</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-weebly'></i></td>
			<td><code>fab fa-weebly</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-weibo'></i></td>
			<td><code>fab fa-weibo</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-weixin'></i></td>
			<td><code>fab fa-weixin</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-whatsapp'></i></td>
			<td><code>fab fa-whatsapp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-whatsapp-square'></i></td>
			<td><code>fab fa-whatsapp-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-whmcs'></i></td>
			<td><code>fab fa-whmcs</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wikipedia-w'></i></td>
			<td><code>fab fa-wikipedia-w</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-windows'></i></td>
			<td><code>fab fa-windows</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wix'></i></td>
			<td><code>fab fa-wix</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wizards-of-the-coast'></i></td>
			<td><code>fab fa-wizards-of-the-coast</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wolf-pack-battalion'></i></td>
			<td><code>fab fa-wolf-pack-battalion</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wordpress'></i></td>
			<td><code>fab fa-wordpress</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wordpress-simple'></i></td>
			<td><code>fab fa-wordpress-simple</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wpbeginner'></i></td>
			<td><code>fab fa-wpbeginner</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wpexplorer'></i></td>
			<td><code>fab fa-wpexplorer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wpforms'></i></td>
			<td><code>fab fa-wpforms</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-wpressr'></i></td>
			<td><code>fab fa-wpressr</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-xbox'></i></td>
			<td><code>fab fa-xbox</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-xing'></i></td>
			<td><code>fab fa-xing</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-xing-square'></i></td>
			<td><code>fab fa-xing-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-y-combinator'></i></td>
			<td><code>fab fa-y-combinator</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yahoo'></i></td>
			<td><code>fab fa-yahoo</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yammer'></i></td>
			<td><code>fab fa-yammer</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yandex'></i></td>
			<td><code>fab fa-yandex</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yandex-international'></i></td>
			<td><code>fab fa-yandex-international</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yarn'></i></td>
			<td><code>fab fa-yarn</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yelp'></i></td>
			<td><code>fab fa-yelp</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-yoast'></i></td>
			<td><code>fab fa-yoast</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-youtube'></i></td>
			<td><code>fab fa-youtube</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-youtube-square'></i></td>
			<td><code>fab fa-youtube-square</code></td>
		</tr>
		<tr>
			<td><i class='fab fa-zhihu'></i></td>
			<td><code>fab fa-zhihu</code></td>
		</tr>
	</tbody>
</table>


</div>
<div class="col-md-3">
  <div data-spy="affix">
<div class="sidebar hidden-print" id="sidebar">
<ul class="nav active">
<li>
  <a href="#fontawesome">Font Awesome</a>
  <ul class="nav active">
	<li><a href="#fontawesome_regular">Regular Icons</a></li>
	<li><a href="#fontawesome_solid">Solid Icons</a></li>
	<li><a href="#fontawesome_brand">Brand Icons</a></li>
  </ul>
</li>
</ul>
<a class="back-to-top" href="#top">Back to top</a>
</div>

  </div>
</div>
</div>
</div>

<div class="modal" id="dialog-html-inspector">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
	<button class="close" data-dismiss="modal" type="button">&times;</button>
	<h4 class="modal-title">Source Code</h4>
  </div>
  <div class="modal-body">
	<pre><code></code></pre>
  </div>
</div>
</div>
</div>

<div id="footer">
<div class="container">

<div class="footer-content">
<!-- @TODO: Use extra CSS for 'dist' footer -->
<div style="margin-bottom: 5px;">
<a target="_blank" href="http://www.opensource.org/licenses/mit-license.php">MIT</a>
© <a href="https://github.com/anvoz" target="_blank">anvoz</a>
v1.2.1 - Nov 03 2014
</div>
<div>
</div>
</div>

</div>
</div>

<script defer src="{{ asset('ui_kit/vendor.js') }}"></script>

<script defer src="{{ asset('ui_kit/plugins.js') }}"></script>

<script defer src="{{ asset('ui_kit/main.js') }}"></script>
</body>
</html>
