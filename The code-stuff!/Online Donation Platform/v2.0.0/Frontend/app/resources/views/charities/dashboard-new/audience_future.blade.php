@extends('layouts.main', ['charity' => $charity])




@section('pre-scripts')
	<script type='text/javascript'>
		chartData['dd_char-pagevisits-weeklyreview'] = {
			@php
			for ($i = 0; $i < 7; $i++) {
				$xx = 0;
				foreach ($charity->dashboard->audience->visits->thisweek as $item) {
					if ($dateWeekdays[$i] == date('D', strtotime($item->date))) {
						$xx = $item->counter;
					}
				}
				echo '"'.$dateWeekdays[$i].'": '.$xx.',';
			}
			@endphp
		};
		chartData['dd_char-pagevisits-weeklyreview_lastweek'] = {
			@php
			for ($i = 0; $i < 7; $i++) {
				$xx = 0;
				foreach ($charity->dashboard->audience->visits->lastweek as $item) {
					if ($dateWeekdays[$i] == date('D', strtotime($item->date))) {
						$xx = $item->counter;
					}
				}
				echo '"'.$dateWeekdays[$i].'": '.$xx.',';
			}
			@endphp
		};
	</script>
@endsection




@section('post-scripts')
@endsection




@section('pre-styles')
@endsection




@section('post-styles')
@endsection




@section('content')
	<div class='dd_dashboard dd_dashboard-charity'>
		@include('layouts.charityDashboard-navbar')
		<div class='dd_main'>


			<div class='dd_card dd_card-stats'>
				<div class='dd_card_head'>
					<p>Page visits this week</p>
				</div>
				<div class='dd_card_main'>
					<div class='dd_graph'>
						<div class='dd_graph_overview'>
							<div class='dd_graph_overview-current'>
								<p>THIS WEEK (wc. {{ $charity->dashboard->thisweek_weekstart }})</p>
								<h1>{{ number_format($charity->dashboard->audience->visits->thisweek_total) }}</h1>
								<div class='swatch'></div>
							</div>
							<div class='dd_graph_overview-past'>
								<p>LAST WEEK (wc. {{ $charity->dashboard->lastweek_weekstart }})</p>
								<h1>{{ number_format($charity->dashboard->audience->visits->lastweek_total) }}</h1>
								<div class='swatch'></div>
							</div>
						</div>
						<div class='dd_graph_main'>
							<div class='dd_graph_main_data' id='dd_char-pagevisits-weeklyreview' dd_graph_progress='{{ date('w', time()) }}' dd_graph_subset='dd_char-pagevisits-weeklyreview_lastweek'></div>
						</div>
					</div>
					<div class='dd_card_section'>
						<div class='dd_donation_split'>
							<div class='dd_donation_split-oneoff'>
								<div>
									<p>Visitor conversion</p>
									<h1>{{ number_format($charity->dashboard->audience->visits->thisweek_conversion, 2) }}%</h1>
								</div>
								<h6>£0.00 average donation</h6>
							</div>
							<div class='dd_donation_split-oneoff'>
								<div>
									<p>New visitors</p>
									<h1>{{ number_format($charity->dashboard->audience->visits->thisweek_newvisitors, 2) }}</h1>
								</div>
								<h6>0 returning visitors (0.00%)</h6>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class='dd_card_pair dd_card_pair-audience'>


				<div class='dd_card dd_card-stats_sources'>
					<div class='dd_card_head'>
						<p>Where do your visitors come from?</p>
					</div>
					<div class='dd_card_main'>
						<div class='dd_stats_table'>
							<div class='dd_stats_table_row dd_stats_table_row_header'>
								<p class='dd_stats_table_item'>Source</p>
								<p class='dd_stats_table_item dd_stats_table_extrasmall'>Visits</p>
								<p class='dd_stats_table_item dd_stats_table_small'>Value</p>
							</div>
							@if (@sizeof($charity->dashboard->audience->sources) > 0)
								@foreach ($charity->dashboard->audience->sources AS $item)
									<div class='dd_stats_table_row'>
										<p class='dd_stats_table_item'>{{ $item->host_webpage }}</p>
										<p class='dd_stats_table_item dd_stats_table_extrasmall'>{{ number_format($item->counter) }}</p>
										<p class='dd_stats_table_item dd_stats_table_small'>&pound;0.00</p>
									</div>
								@endforeach
							@else
								No data to show
							@endif
						</div>
					</div>
				</div>


				<div class='dd_card dd_card-stats_timeofday'>
					<div class='dd_card_head'>
						<p>When do your visitors visit?</p>
					</div>
					<div class='dd_card_main'>
						<div class='dd_stats_time_of_day'>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>12am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>2am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>4am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>6am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>8am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>10am</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>12pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>2pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>4pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>6pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>8pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'>10pm</div>
							</div>
							<div class='dd_stats_time_of_day_row'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								{{-- <div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div> --}}
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_0'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>

							<div class='dd_stats_time_of_day_row dd_stats_time_of_day_row_day'>
								<div class='dd_stats_time_of_day_item'>Mon</div>
								<div class='dd_stats_time_of_day_item'>Tue</div>
								<div class='dd_stats_time_of_day_item'>Wed</div>
								<div class='dd_stats_time_of_day_item'>Thu</div>
								<div class='dd_stats_time_of_day_item'>Fri</div>
								<div class='dd_stats_time_of_day_item'>Sat</div>
								<div class='dd_stats_time_of_day_item'>Sun</div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row dd_stats_time_of_day_row_key'>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_25'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_50'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_75'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_100'></div>
								<div class='dd_stats_time_of_day_item dd_stats_time_of_day_item_label'></div>
							</div>
							<div class='dd_stats_time_of_day_row dd_stats_time_of_day_row_key_label'>
								<div class='dd_stats_time_of_day_item'>1</div>
								<div class='dd_stats_time_of_day_item'>2</div>
								<div class='dd_stats_time_of_day_item'>3</div>
								<div class='dd_stats_time_of_day_item'>4</div>
								<div class='dd_stats_time_of_day_item'>5</div>
							</div>
						</div>
					</div>
				</div>


			</div>

		</div>
	</div>
@endsection
