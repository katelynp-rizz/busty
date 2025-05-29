<?php
// Adds Busty debug info to the admin bar

add_action( 'admin_bar_menu', 'busty_add_admin_bar_debug', 100 );
function busty_add_admin_bar_debug( $wp_admin_bar ) {
    global $busty_debug_type;

    if ( ! is_super_admin() || ! busty_is_topbar_debug_enabled() || ! is_admin_bar_showing() ) {
        return;
    }

    $header = 'none';
    foreach ( headers_list() as $h ) {
        if ( 0 === stripos( $h, 'X-Busty-Cache-Bust:' ) ) {
            $header = trim( substr( $h, strlen( 'X-Busty-Cache-Bust:' ) ) );
            break;
        }
    }

    $wp_admin_bar->add_node([ 'id'=>'busty-root',   'title'=>'Busty ⚡', 'href'=>false ]);
    $wp_admin_bar->add_node([ 'id'=>'busty-hook',   'parent'=>'busty-root', 'title'=>'Hook: '.esc_html($busty_debug_type) ]);
    $wp_admin_bar->add_node([ 'id'=>'busty-header', 'parent'=>'busty-root', 'title'=>'Header: '.esc_html($header) ]);
    $wp_admin_bar->add_node([ 'id'=>'busty-open',   'parent'=>'busty-root', 'title'=>'Settings',       'href'=>admin_url('admin.php?page=busty-settings') ]);
}
