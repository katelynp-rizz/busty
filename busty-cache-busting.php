<?php
/**
 * Plugin Name: Busty Cache Busting
 * Description: Handles targeted cache busting for routes and requests that must always return fresh data.
 *              Prevents issues with ACF validation, admin edit screens, REST API responses, and other
 *              dynamic endpoints by disabling caching and applying rule-based busting. Also supports
 *              custom URL rules and user-defined bust routes. Includes an admin panel with Overview,
 *              Settings, Cache Rules, Routes, Logs, and a Dictionary for quick reference.
 * Version:     1.12
 * Author:      Katelyn Pauley
 * Author URI:  https://katelynpauley.com/
 * License:     GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -- Constants ---------------------------------------------------------------
define( 'BUSTY_LOG_DIR',  plugin_dir_path( __FILE__ ) . 'logs' );
define( 'BUSTY_LOG_FILE', BUSTY_LOG_DIR    . '/busty-cache-busting.log' );

global $busty_debug_type;
$busty_debug_type = 'none';

// -- Includes ---------------------------------------------------------------
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/custom-header-injection.php';
require_once __DIR__ . '/includes/core-bust-logic.php';
require_once __DIR__ . '/includes/admin-menu.php';
require_once __DIR__ . '/includes/admin-bar-debug.php';
require_once __DIR__ . '/includes/gravity-forms-cache-busting.php';
