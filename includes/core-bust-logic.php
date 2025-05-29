<?php
// Core bust logic for admin edit screens and REST API (I know admin screens are typically supposed to be bypassed by default - this is just a failsafe and for extra visibility - don't come for me)

add_action( 'admin_init', 'busty_admin_bust_cache' );
function busty_admin_bust_cache() {
    global $busty_debug_type;
    $uri  = $_SERVER['REQUEST_URI'] ?? '';
    $ajax = busty_is_bust_ajax_enabled();

    if (
        false !== strpos( $uri, 'post.php' ) ||
        false !== strpos( $uri, 'acf/validate' ) ||
        ( $ajax && false !== strpos( $uri, 'admin-ajax.php' ) )
    ) {
        nocache_headers();
        header( 'X-Busty-Cache-Bust: admin-edit' );
        $busty_debug_type = 'admin-edit';
        busty_log_event([
            'type'             => $busty_debug_type,
            'uri'              => $uri,
            'request_headers'  => busty_get_request_headers(),
            'response_headers' => headers_list(),
        ]);
    }
}

add_filter( 'rest_post_dispatch', 'busty_rest_no_cache', 10, 3 );
function busty_rest_no_cache( $res ) {
    global $busty_debug_type;
    if ( is_a( $res, 'WP_REST_Response' ) ) {
        $res->header( 'Cache-Control', 'no-cache, must-revalidate, max-age=0' );
        $res->header( 'X-Busty-Cache-Bust', 'rest-api' );
    } else {
        header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
        header( 'X-Busty-Cache-Bust: rest-api' );
    }
    $busty_debug_type = 'rest-api';
    busty_log_event([
        'type'             => $busty_debug_type,
        'uri'              => $_SERVER['REQUEST_URI'] ?? '',
        'request_headers'  => busty_get_request_headers(),
        'response_headers' => headers_list(),
    ]);
    return $res;
}
