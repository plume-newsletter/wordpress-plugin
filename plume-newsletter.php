<?php
/**
 * Plugin Name:       Plume Newsletter
 * Plugin URI:        https://plumenewsletter.com/docs/wordpress/
 * Description:       Add a signup form to your WordPress site that enrolls subscribers into a Plume list via double opt-in.
 * Version:           0.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Plume
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       plume-newsletter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'PLUME_NEWSLETTER_VERSION', '0.1.0' );
define( 'PLUME_NEWSLETTER_FILE', __FILE__ );
define( 'PLUME_NEWSLETTER_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUME_NEWSLETTER_URL', plugin_dir_url( __FILE__ ) );

require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-client.php';
require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-form.php';
require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-handler.php';

add_shortcode( 'plume_signup', array( 'Plume_Form', 'shortcode' ) );

add_action( 'admin_post_plume_subscribe', array( 'Plume_Handler', 'handle' ) );
add_action( 'admin_post_nopriv_plume_subscribe', array( 'Plume_Handler', 'handle' ) );

require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-settings.php';

add_action( 'admin_init', array( 'Plume_Settings', 'register' ) );
add_action( 'admin_menu', array( 'Plume_Settings', 'menu' ) );

add_action( 'widgets_init', function () {
	require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-widget.php';
	register_widget( 'Plume_Widget' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'plume-newsletter', PLUME_NEWSLETTER_URL . 'assets/plume.css', array(), PLUME_NEWSLETTER_VERSION );
	wp_enqueue_script( 'plume-newsletter', PLUME_NEWSLETTER_URL . 'assets/plume.js', array(), PLUME_NEWSLETTER_VERSION, true );
} );
