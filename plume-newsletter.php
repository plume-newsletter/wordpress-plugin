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

// Includes are wired in later tasks:
//   require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-client.php';   (Task 2)
//   require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-form.php';     (Task 3)
//   require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-handler.php';  (Task 4)
//   require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-settings.php'; (Task 5)
//   require_once PLUME_NEWSLETTER_DIR . 'includes/class-plume-widget.php';   (Task 5)
