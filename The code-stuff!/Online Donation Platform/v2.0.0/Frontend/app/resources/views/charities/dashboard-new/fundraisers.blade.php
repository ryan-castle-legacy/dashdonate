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


			<div class='dd_card_pair'>

				<div class='dd_card dd_card-stats_donations'>
					<div class='dd_card_head'>
						<p>Donations</p>
					</div>
					<div class='dd_card_main'>
						<div class='dd_stats_table'>
							<div class='dd_stats_table_row dd_stats_table_row_header'>
								<p class='dd_stats_table_item'>ID</p>
								<p class='dd_stats_table_item dd_stats_table_medium'>Date</p>
								<p class='dd_stats_table_item dd_stats_table_small'>Value</p>
							</div>
							<div class='dd_stats_table_row'>
								<p class='dd_stats_table_item'>12345678904</p>
								<p class='dd_stats_table_item dd_stats_table_medium'>13/12/2020 12:22pm</p>
								<p class='dd_stats_table_item dd_stats_table_small'>&pound;1,234.56</p>
							</div>
						</div>
					</div>
				</div>


				<div class='dd_card dd_card-stats'>
					
				</div>

			</div>


			<div class='dd_card dd_card-stats_donations'>
				<div class='dd_card_head'>
					<p>Fundraisers</p>
				</div>
				<div class='dd_card_main'>
					<div class='dd_stats_table'>
						<div class='dd_stats_table_row dd_stats_table_row_header'>
							<p class='dd_stats_table_item'>Fundraiser Title</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>Organiser</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>Date Started</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>Date Finishing</p>
							<p class='dd_stats_table_item dd_stats_table_small'>Status</p>
							<p class='dd_stats_table_item dd_stats_table_small'>Value</p>
						</div>
						<div class='dd_stats_table_row'>
							<p class='dd_stats_table_item'>Ryan's Birthday Fundraiser</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>Ryan Castle</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>13/12/2020 12:22pm</p>
							<p class='dd_stats_table_item dd_stats_table_medium'>13/12/2020 12:22pm</p>
							<p class='dd_stats_table_item dd_stats_table_small'>Active</p>
							<p class='dd_stats_table_item dd_stats_table_small'>&pound;1,234.56</p>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
@endsection
