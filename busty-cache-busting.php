<?php
/**
 * Plugin Name: Busty Cache Busting
 * Description: Prevents stale nonces by disabling caching on ACF validation AJAX calls, admin-edit screens,
 *              REST API responses, custom URL-based rules, and user-defined bust routes.
 *              Provides a dedicated admin menu with Overview, Settings, Cache Rules, Routes, Logs, and Dictionary.
 * Version:     1.11
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
