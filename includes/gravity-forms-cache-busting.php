<?php
// includes/gravity-forms-cache-busting.php

// 1) Catch GF AJAX submissions & previews
add_action( 'send_headers', 'busty_gravity_forms_ajax_bust', 5 );
function busty_gravity_forms_ajax_bust() {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    foreach ( [
        'admin-ajax.php?action=gform_ajax_submit',
        'admin-ajax.php?action=gform_ajax_get_form'
    ] as $pattern ) {
        if ( false !== strpos( $uri, $pattern ) ) {
            nocache_headers();
            header( 'Set-Cookie: busty_route_bust=1; Path=/; HttpOnly' );
            header( 'X-Busty-Cache-Bust: gf-ajax' );
            if ( function_exists( 'busty_log_event' ) ) {
                busty_log_event([
                    'type'             => 'gf-ajax',
                    'uri'              => $uri,
                    'request_headers'  => busty_get_request_headers(),
                    'response_headers' => headers_list(),
                ]);
            }
            return;
        }
    }
}

// 2) Bust any front-end post that has a Gravity Forms shortcode
add_action( 'template_redirect', 'busty_gravity_forms_embed_bust', 1 );
function busty_gravity_forms_embed_bust() {
    if ( is_singular() ) {
        global $post;
        // look for [gravityform ...] or [gravityforms ...]
        if ( has_shortcode( $post->post_content, 'gravityform' )
          || has_shortcode( $post->post_content, 'gravityforms' )
        ) {
            nocache_headers();
            header( 'Set-Cookie: busty_route_bust=1; Path=/; HttpOnly' );
            header( 'X-Busty-Cache-Bust: gf-embed' );
            if ( function_exists( 'busty_log_event' ) ) {
                busty_log_event([
                    'type'             => 'gf-embed',
                    'uri'              => $_SERVER['REQUEST_URI'] ?? '',
                    'request_headers'  => busty_get_request_headers(),
                    'response_headers' => headers_list(),
                ]);
            }
        }
    }
}

// 3) (Optional) Bust GF REST API if we need
add_action( 'send_headers', 'busty_gravity_forms_rest_bust', 5 );
function busty_gravity_forms_rest_bust() {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if ( false !== stripos( $uri, '/gravityformsapi/' ) ) {
        nocache_headers();
        header( 'Set-Cookie: busty_route_bust=1; Path=/; HttpOnly' );
        header( 'X-Busty-Cache-Bust: gf-rest' );
        if ( function_exists( 'busty_log_event' ) ) {
            busty_log_event([
                'type'             => 'gf-rest',
                'uri'              => $uri,
                'request_headers'  => busty_get_request_headers(),
                'response_headers' => headers_list(),
            ]);
        }
    }
}
