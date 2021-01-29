@extends('layouts.main', ['charity' => $charity])




@section('pre-scripts')
	<script type='text/javascript'>


		chartData['dd_char-donations-weeklyreview'] = {
		@php
			// Set default
			$value = 0;
			// Loop through days
			for ($i = 0; $i < 7; $i++) {
				// Get label value
				$label = $dateWeekdays[$i];
				// Loop through data items
				foreach ($charity->dashboard->donations->recent->thisweek as $item) {
					// Check if data
					if ($dateWeekdays[$i] == date('D', strtotime($item->date))) {
						$value += (($item->amount_total - $item->fees_total) / 100);
					}
				}
				// Output data
				echo '"'.$label.'" : '.$value.',';
			}
		@endphp
		};


		chartData['dd_char-donations-weeklyreview_lastweek'] = {
		@php
			// Set default
			$value = 0;
			// Loop through days
			for ($i = 0; $i < 7; $i++) {
				// Get label value
				$label = $dateWeekdays[$i];
				// Loop through data items
				foreach ($charity->dashboard->donations->recent->lastweek as $item) {
					// Check if data
					if ($dateWeekdays[$i] == date('D', strtotime($item->date))) {
						$value += (($item->amount_total - $item->fees_total) / 100);
					}
				}
				// Output data
				echo '"'.$label.'" : '.$value.',';
			}
		@endphp
		};


		chartData['dd_char-donations-next6months'] = {
		@php
			for ($i = 1; $i <= 6; $i++) {
				// Get label value
				$label = $charity->dashboard->donations->next6months->{'sixmonth_label_month'.$i};
				// Set default
				$value = 0;
				// Loop through data
				foreach ($charity->dashboard->donations->next6months->graph as $key => $val) {
					// Check if label is the same as key
					if ($key == $label) {
						// Set value
						$value = ($val / 100);
					}
				}
				// Output data
				echo '"'.$label.'" : '.$value.',';
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
					<p>Donations this week</p>
				</div>
				<div class='dd_card_main'>
					<div class='dd_graph'>
						<div class='dd_graph_overview'>
							<div class='dd_graph_overview-current'>
								<p>THIS WEEK (wc. {{ $charity->dashboard->thisweek_weekstart }})</p>
								<h1>&pound;{{ number_format(($charity->dashboard->donations->recent->thisweek_total - $charity->dashboard->donations->recent->thisweek_totalfees) / 100, 2) }}</h1>
								<div class='swatch'></div>
							</div>
							<div class='dd_graph_overview-past'>
								<p>LAST WEEK (wc. {{ $charity->dashboard->lastweek_weekstart }})</p>
								<h2>&pound;{{ number_format(($charity->dashboard->donations->recent->lastweek_total - $charity->dashboard->donations->recent->lastweek_totalfees) / 100, 2) }}</h2>
								<div class='swatch'></div>
							</div>
						</div>
						<div class='dd_graph_main'>
							<div class='dd_graph_main_data dd_graph_main_data_currency' id='dd_char-donations-weeklyreview' dd_graph_progress='{{ date('w', time()) }}' dd_graph_subset='dd_char-donations-weeklyreview_lastweek'></div>
						</div>
					</div>
					<div class='dd_card_section'>
						<div class='dd_donation_split'>
							<div class='dd_donation_split-oneoff'>
								<div>
									<p>One-Off Donations</p>
									<h1>&pound;0.00</h1>
								</div>
								<h6>0 donations (avg £0.00)</h6>
							</div>
							<div class='dd_donation_split-recurring'>
								<div>
									<p>Recurring Donations</p>
									<h1>&pound;0.00</h1>
								</div>
								<h6>0 donations (avg £0.00)</h6>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class='dd_card_pair'>

				<div class='dd_card dd_card-stats_donations'>
					<div class='dd_card_head'>
						<p>All donations</p>
					</div>
					<div class='dd_card_main'>
						<div class='dd_stats_table'>
							<div class='dd_stats_table_row dd_stats_table_row_header'>
								<p class='dd_stats_table_item'>ID</p>
								<p class='dd_stats_table_item dd_stats_table_medium'>Date</p>
								<p class='dd_stats_table_item dd_stats_table_small'>Value</p>
							</div>

							@if (@$charity->dashboard->donations->all && @sizeof($charity->dashboard->donations->all) > 0)
								@foreach ($charity->dashboard->donations->all as $item)
									<div class='dd_stats_table_row'>
										<p class='dd_stats_table_item'>{{ $item->unique_id }}</p>
										<p class='dd_stats_table_item dd_stats_table_medium'>{{ date('d/m/Y h:ia', strtotime($item->date_taken)) }}</p>
										<p class='dd_stats_table_item dd_stats_table_small'>&pound;{{ number_format(($item->amount - $item->total_fees) / 100, 2) }}</p>
									</div>
								@endforeach
							@else
								<div class='dd_stats_table_row dd_stats_table_row_empty'>
									<p>No data to display</p>
								</div>
							@endif
						</div>
					</div>
				</div>


				<div class='dd_card_cont_half'>
					<div class='dd_card dd_card-stats'>
						<div class='dd_card_head'>
							<p>Scheduled donations</p>
						</div>
						<div class='dd_card_main'>
							<div class='dd_graph'>
								<div class='dd_graph_overview'>
									<div class='dd_graph_overview-current'>
										<p>THE NEXT 6 MONTHS ({{ $charity->dashboard->donations->next6months->sixmonth_start }} - {{ $charity->dashboard->donations->next6months->sixmonth_end }})</p>
										<h1>&pound;{{ number_format($charity->dashboard->donations->next6months->total / 100, 2) }}</h1>
									</div>
								</div>
								<div class='dd_graph_main'>
									<div class='dd_graph_main_data dd_graph_main_data_currency' id='dd_char-donations-next6months' dd_graph_progress='6'></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
