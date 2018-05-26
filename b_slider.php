<?php
/*
Plugin Name: B slider
Description: A simple slider plugin for add slider on pages  and posts.
Author: kamlesh jangir
Version: 0.1
Author URI:  http://www.omeguru.com/
Text Domain: omeguru
Domain Path: /languages
License:     GPL2
 
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.

*/


function bslider_install() {
	include( plugin_dir_path( __FILE__ ) . 'bslider_install.php');
	}
register_activation_hook( __FILE__, 'bslider_install' );


function bslider_uninstall()
{
	include( plugin_dir_path( __FILE__ ) . 'bslider_uninstall.php');
}
register_deactivation_hook( __FILE__, 'bslider_uninstall' );


/// for admin menu
add_action('admin_menu', 'b_slider');
function b_slider() {
    add_menu_page('B slider', 'B slider', 'manage_options', 'b-slider', 'bsliders', 'dashicons-format-gallery' );
    add_submenu_page('b-slider', 'Add new slider', 'Add new', 'manage_options', 'add_new', 'add_new');
    add_submenu_page('', 'Add new slider', 'Edit bslider', 'manage_options', 'edit_bslider', 'edit_bslider');

}




function bsliders() {
	include( plugin_dir_path( __FILE__ ) . 'manage_bslider.php');
}

function add_new() {
	include( plugin_dir_path( __FILE__ ) . 'add_bslider.php');
}


function edit_bslider()
{
	include( plugin_dir_path( __FILE__ ) . 'edit_bslider.php');
}

/// for short code
function getBSilder( $atts ) {
    $bid =  $atts['bid'];
	include( plugin_dir_path( __FILE__ ) . 'bslider_template.php');
    return $template;
}
add_shortcode( 'bslider', 'getBSilder' );

?>