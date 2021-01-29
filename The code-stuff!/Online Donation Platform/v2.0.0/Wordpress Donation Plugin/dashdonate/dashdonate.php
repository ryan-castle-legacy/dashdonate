<?php


/*
 # 	Plugin Name: 	DashDonate.org
 # 	Plugin URI: 	https://dashdonate.org
 #	Description: 	This plugin enables charities to integrate with DashDonate.org's services.
 #	Version: 		1.0.0
 #	Author: 		DashDonate.org
 #	Author URI: 	https://dashdonate.org
*/




// Create settings in Wordpress
function dashdonate_register_settings() {
	// Create option
	add_option('dashdonate_charity_site_id', 'Test test test');
	// Register the setting to Wordpress database
	register_setting('dashdonate_settings', 'dashdonate_charity_site_id', 'myplugin_callback');
}

// Register the settings
add_action('admin_init', 'dashdonate_register_settings');




// Settings page
function dashdonate_register_settings_page() {
	// Create options page
	add_options_page('DashDonate.org', 'DashDonate.org', 'manage_options', 'dashdonate', 'dashdonate_settings_page');
}

// Generate settings page
add_action('admin_menu', 'dashdonate_register_settings_page');




// Display settings page
function dashdonate_settings_page() { ?>
	<div>
		<?php screen_icon(); ?>
		<h2>DashDonate.org Settings</h2>
		<p>No settings to change here! - Manage your widgets via your DashDonate.org charity dashboard.</p>
	</div>
<?php }




// Register scripts
function dashdonate_register_scripts() {
	// Register script
	wp_register_script('dashdonate_add_donation_widget_js', 'http://ec2-0-0-0-0.eu-west-2.compute.amazonaws.com/widgets/donation-2.js');
}

// Enqueue scripts
add_action('wp_enqueue_scripts', 'dashdonate_register_scripts');




// Create shortcode
function dashdonate_add_donation_widget() {
	// Add script
	wp_enqueue_script('dashdonate_add_donation_widget_js');

	// Create output
	$output = 	'<h1>test</h1>';
	$output .= 	'<div id="dd_widget"></div>';

	// Get site ID:
	$site_id = 'x';

	$output .= 	'<script>window.DashDonate=window.DashDonate||{};window.DashDonate.key="'.$site_id.'";</script>';

	// Return output
	return $output;
}

// Register shortcode
add_shortcode('donation-widget', 'dashdonate_add_donation_widget');
