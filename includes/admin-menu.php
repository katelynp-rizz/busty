<?php
// Registers the Busty admin menu and includes each page’s renderer

add_action( 'admin_menu', 'busty_admin_menus' );
function busty_admin_menus() {
    if ( ! is_super_admin() ) {
        return;
    }

    #add_menu_page(    'Busty Cache Busting', 'Busty',       'manage_options', 'busty-main',        'busty_render_main_page',        'dashicons-shield-alt', 80 );
	    add_menu_page(
        'Busty Cache Busting', 
        'Busty', 
        'manage_options', 
        'busty-main', 
        'busty_render_main_page',
        plugin_dir_url( dirname(__FILE__) ) . 'assets/busty-icon.png',
        80
    );
    add_submenu_page('busty-main',         'Settings',    'Settings',    'manage_options', 'busty-settings',    'busty_render_settings_page' );
    add_submenu_page('busty-main',         'Cache Rules', 'Cache Rules', 'manage_options', 'busty-cache-rules', 'busty_render_cache_rules_page' );
    add_submenu_page('busty-main',         'Routes',      'Routes',      'manage_options', 'busty-routes',      'busty_render_routes_page' );
    add_submenu_page('busty-main',         'Logs',        'Logs',        'manage_options', 'busty-logs',        'busty_render_logs_page' );
    add_submenu_page('busty-main',         'Dictionary',  'Dictionary',  'manage_options', 'busty-dictionary',  'busty_render_dictionary_page' );

    // Include each page’s code
    require_once __DIR__ . '/page-main.php';
    require_once __DIR__ . '/page-settings.php';
    require_once __DIR__ . '/page-cache-rules.php';
    require_once __DIR__ . '/page-routes.php';
    require_once __DIR__ . '/page-logs.php';
    require_once __DIR__ . '/page-dictionary.php';
}
