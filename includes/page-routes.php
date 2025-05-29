<?php
// includes/page-routes.php

function busty_render_routes_page() {
    // Handle form submission
    if ( isset( $_POST['save_routes'] ) ) {
        check_admin_referer( 'busty_save_routes' );
        update_option( 'busty_bust_routes', sanitize_textarea_field( $_POST['busty_bust_routes'] ) );
        echo '<div class="updated"><p>Routes saved.</p></div>';
    }

    // Fetch existing routes
    $routes = get_option( 'busty_bust_routes', '' );
    ?>
    <div class="wrap">
      <h1>Additional Bust Routes</h1>

      <p>Enter one URI substring per line. Any request whose URL contains one of these substrings will be forced no-cache (<code>route-bust</code>).</p>
	  
	        <p><strong>Tip:</strong> To ensure Varnish also bypasses these requests, add the Cookie into your Cache Bypass Rules:(<code>busty_route_bust</code>):</p>
      <form method="post"><?php wp_nonce_field( 'busty_save_routes' ); ?>
        <textarea name="busty_bust_routes" rows="6" class="large-text code"><?php echo esc_textarea( $routes ); ?></textarea>
        <p><button class="button button-primary" name="save_routes">Save Routes</button></p>
      </form>
    </div>
<?php
}
