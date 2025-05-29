<?php
// Adds custom headers or busts based on user-defined routes and rules

add_action( 'send_headers', 'busty_apply_custom_rules', 5 );
function busty_apply_custom_rules() {
    global $busty_debug_type;
    $uri = $_SERVER['REQUEST_URI'] ?? '';

    // 1) Route-based bust: match any configured pattern
    foreach ( busty_get_bust_routes() as $pattern ) {
        if ( false !== strpos( $uri, $pattern ) ) {
            // prevent caching at browser and edge
            nocache_headers();

            // determine cookie scope:
            // if pattern starts with '/', use that path (strip query if present)
            // otherwise fall back to root
            if ( 0 === strpos( $pattern, '/' ) ) {
                $cookie_path = strtok( $pattern, '?' );
            } else {
                $cookie_path = '/';
            }

            // emit a cookie so caches can bypass based on its presence
            header( "Set-Cookie: busty_route_bust=1; Path={$cookie_path}; HttpOnly" );

            // add debug header and log the event
            header( 'X-Busty-Cache-Bust: route-bust' );
            $busty_debug_type = 'route-bust';
            busty_log_event( [
                'type'             => $busty_debug_type,
                'uri'              => $uri,
                'request_headers'  => busty_get_request_headers(),
                'response_headers' => headers_list(),
            ] );

            return;
        }
    }

    // 2) Custom Cache Control rules
    foreach ( busty_parse_rules( 'busty_cache_control_rules' ) as $r ) {
        if ( false !== strpos( $uri, $r['pattern'] ) ) {
            header( 'Cache-Control: ' . $r['value'] );
            header( 'X-Busty-Custom-Cache: ' . $r['value'] );
        }
    }

    // 3) Custom Set Cookie rules
    foreach ( busty_parse_rules( 'busty_cookie_rules' ) as $r ) {
        if ( false !== strpos( $uri, $r['pattern'] ) ) {
            header( 'Set-Cookie: ' . $r['value'] );
            header( 'X-Busty-Custom-Cookie: ' . $r['value'] );
        }
    }
}
