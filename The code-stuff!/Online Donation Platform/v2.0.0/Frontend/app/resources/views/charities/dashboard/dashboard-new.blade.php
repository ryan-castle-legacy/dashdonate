@extends('layouts.main', ['charity' => $charity])




@section('pre-scripts')
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
								<p>THIS WEEK (wc. 8th JUN)</p>
								<h1>&pound;1,234.50</h1>
								<div class='swatch'></div>
							</div>
							<div class='dd_graph_overview-past'>
								<p>LAST WEEK (wc. 15th JUN)</p>
								<h2>&pound;832.50</h2>
								<div class='swatch'></div>
							</div>
						</div>
						<div class='dd_graph_main'>
							<div class='dd_graph_main_data' id='dd_char-weeklyreview' dd_graph_progress='6' dd_graph_subset='dd_char-weeklyreview_lastweek'></div>
						</div>
					</div>
					<div class='dd_card_section'>
						<div class='dd_donation_split'>
							<div class='dd_donation_split-oneoff'>
								<div>
									<p>One-Off Donations</p>
									<h1>&pound;1,234.50</h1>
								</div>
								<h6>152 donations (avg £15.00)</h6>
							</div>
							<div class='dd_donation_split-recurring'>
								<div>
									<p>Recurring Donations</p>
									<h1>&pound;832.50</h1>
								</div>
								<h6>72 donations (avg £14.45)</h6>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class='dd_card'>
				<pre>{{ var_dump($charity) }}</pre>
			</div>


		</div>
	</div>
@endsection
