<?php 
/*Plugin Name: MC Annual Upcounter
Plugin URI: https://Mid-Coast.com/annual-upcounter
Description: Enter a total number of anything for the year. This plugin displays, on any website page, the accumulated number for this date and time througout the year, and will reset to zero at midnight on December 31.
Version: 2.1.2
Author: Mike Hickcox
Author URI: https://Mid-Coast.com
License: GPLv2 or later license
URI: https://www.gnu.org/licenses/gpl-2.0.html


    Copyright (C)2021  Mike Hickcox
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program. If not, see https://www.gnu.org/licenses.

*/
	if ( ! defined( 'ABSPATH' ) ) exit;


	// INCLUDE NEEDED FILE
     	include 'inc/mc6397au_shortcode.php';


	// EXECUTE ON EVERY PAGE HEADER

	add_action('wp_head', 'mc6397au_counter');
	function mc6397au_counter()
{

	$mc6397au_increment = esc_attr (get_option('mc6397au_total')) / (31536000000);
  	$mc6397au_frequency = esc_attr (get_option('mc6397au_seconds'))*(1000);

	?>

	<script>

	var increment = "<?php echo"$mc6397au_increment"?>"; 
	var frequency = "<?php echo"$mc6397au_frequency"?>"; 

	// Get Unix Timestamp seconds since beginning of current year

	startSeconds = new Date(new Date().getFullYear(), 0, 1);

	// Subtract current seconds from January 1 seconds and multiply by a factor per second

	function counter()
{
	i = Math.round((((new Date()).getTime()) - startSeconds) * increment)

	// Set frequency of updates

	timeR=setTimeout("counter()", frequency);

	// Send updates to web page, with commas
  	document.getElementById('mc6397au_Counter').innerHTML=i.toLocaleString();
}

	</script>
	<?php
}
	// END OF PAGE HEADER CODE


	// ADD OPTIONS
	add_option('mc6397au_total','365');
	add_option('mc6397au_seconds','60');


	// REGISTER SETTINGS
	function register_mc6397au_upcounter_setting () {


    add_settings_section(
        'au-settings-section',
        '',
        'mc6397au_settings_section_callback',
        'mc6397-annual-upcounter'
    );


    add_settings_field(
        'mc6397au_total', 
        'TOTAL number for one entire year:',
        'mc6397au_total_input_callback',
        'mc6397-annual-upcounter',
        'au-settings-section');

    add_settings_field(
        'mc6397au_seconds', 
        'SECONDS between updates on the website:',
        'mc6397au_seconds_input_callback',
        'mc6397-annual-upcounter',
        'au-settings-section');


	register_setting('mc6397-annual-upcounter', 'mc6397au_total'); 
	register_setting('mc6397-annual-upcounter', 'mc6397au_seconds'); 
}


	// ADD SETTINGS LINK TO MENU
	function mc6397au_upcounter_plugin_menu() {


    add_options_page('MC Annual Upcounter', 
                     'MC Annual Upcounter', 
                     'manage_options', 
                     'mc6397-annual-upcounter', 
                     'mc6397au_upcounter_options');
}


	// CALL DATA


	function mc6397au_total_input_callback() {
	echo '<input name="mc6397au_total" id="mc6397au_total" type="number" min="12" value="' . (string) ((int) get_option('mc6397au_total')) . '"/> <br>Minimum of 12';
}

	function mc6397au_seconds_input_callback() {
    echo '<input name="mc6397au_seconds" id="mc6397au_seconds" type="number" min="1" max="120" value="' . (string) ((int) get_option('mc6397au_seconds')) . '"/> <br>Range: 1-120';
}


	function mc6397au_settings_section_callback() {
    echo '';
}


	function mc6397au_upcounter_options() {
?>

	<div class="bootstrap-wrapper" > <br/>
		<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/MC-AU-Head.jpg'; ?>">
		<h2> MC Annual Upcounter Settings</h3>
		<h4>Note: The default when you install this plugin is an annual total of 365, incrementing every 60 seconds. Set your own numbers below:<br>
1. Enter the total number for the year. This plugin will divide that number into seconds and increment by the second all year long.<br>The website readout will show the accumulated number for this date and time to the nearest whole number.<br>
2. Enter how often (in seconds) you want your website page to check and update the number.<br/> If you have a very large number, changing every few seconds, you might want to update frequently. For a smaller total number, choose 120 seconds.<br>
3. Add the shortcode  [mcau_annual_upcounter]  where you want the counter to appear on your website, on any number of pages.</h4>
<strong> Note: The counter will automatically re-set to zero at midnight on December 31 on the user's device.</strong>

	<form method="post" action="options.php">
            <?php settings_fields('mc6397-annual-upcounter');
                  do_settings_sections('mc6397-annual-upcounter');
                  submit_button(); ?>
        </form>
    </div>
<?php
}


	if(is_admin()) {
    add_action('admin_menu', 'mc6397au_upcounter_plugin_menu');
    add_action('admin_init', 'register_mc6397au_upcounter_setting');
}


	// ADD SETTINGS LINK ON PLUGINS PAGE
	function mc6397au_upcounter_link($links) { 
		$settings_link = '<a href="options-general.php?page=mc6397-annual-upcounter">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
}


	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'mc6397au_upcounter_link' );
