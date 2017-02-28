<?php
/**
 * Plugin Name: Custom Post Type Sponsors
 * Plugin URI: https://horttcore.de
 * Description: Manage sponsors
 * Version: 1.1.0
 * Author: Ralf Hortt
 * Author URI: https://horttcore.de
 * Text Domain: custom-post-type-sponsors
 * Domain Path: /languages/
 * License: GPL2
 */


/**
 * Security, checks if WordPress is running
 **/
if ( !function_exists( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;

require( 'classes/custom-post-type-sponsors.php' );

if ( is_admin() )
	require( 'classes/custom-post-type-sponsors.admin.php' );
