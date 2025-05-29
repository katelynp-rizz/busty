<?php
// Helper functions shared across pages

function busty_ensure_log_dir() {
    if ( ! file_exists( BUSTY_LOG_DIR ) ) {
        wp_mkdir_p( BUSTY_LOG_DIR );
    }
}

function busty_is_logging_enabled() {
    return (bool) get_option( 'busty_enable_logging', false );
}

function busty_is_topbar_debug_enabled() {
    return (bool) get_option( 'busty_enable_topbar_debug', false );
}

function busty_is_bust_ajax_enabled() {
    return (bool) get_option( 'busty_bust_ajax', false );
}

function busty_get_request_headers() {
    if ( function_exists( 'getallheaders' ) ) {
        return getallheaders();
    }
    $headers = [];
    foreach ( $_SERVER as $key => $value ) {
        if ( 0 === strpos( $key, 'HTTP_' ) ) {
            $name = str_replace( '_', '-', substr( $key, 5 ) );
            $headers[ $name ] = $value;
        }
    }
    return $headers;
}

function busty_log_event( $entry ) {
    if ( ! busty_is_logging_enabled() ) {
        return;
    }
    busty_ensure_log_dir();
    $entry['time'] = current_time( 'mysql' );
    file_put_contents( BUSTY_LOG_FILE, wp_json_encode( $entry ) . "\n", FILE_APPEND );
}

function busty_parse_rules( $opt ) {
    $lines = preg_split( '/\r?\n/', get_option( $opt, '' ) );
    $rules = [];
    foreach ( $lines as $line ) {
        if ( false !== strpos( $line, '|' ) ) {
            list( $pattern, $value ) = explode( '|', $line, 2 );
            $rules[] = [
                'pattern' => trim( $pattern ),
                'value'   => trim( $value ),
            ];
        }
    }
    return $rules;
}

function busty_get_bust_routes() {
    $lines = preg_split( '/\r?\n/', get_option( 'busty_bust_routes', '' ) );
    return array_filter( array_map( 'trim', $lines ), 'strlen' );
}
