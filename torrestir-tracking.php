<?php
/**
 * Plugin Name:       Torrestir Tracking
 * Plugin URI:
 * Description:       A micro-plugin for tracking events from Torrestir.
 * Version:           1.0
 * Author:            Naked Cat Plugins (by Webdados)
 * Author URI:        https://nakedcatplugins.com
 * Text Domain:       torrestir-tracking
 * Requires at least: 5.9
 * Tested up to:      7.0
 * Requires PHP:      7.2
 * License:           GPLv3
 */

namespace NakedCatPlugins\TorrestirTracking;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';
