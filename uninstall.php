<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit; }
delete_option( 'plume_newsletter_base_url' );
delete_option( 'plume_newsletter_list_id' );
