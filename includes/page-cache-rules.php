<?php
// Cache Rules page (Basic & Advanced + Guide & Examples)

function busty_render_cache_rules_page() {
    $cache_rules  = busty_parse_rules( 'busty_cache_control_rules' );
    $cookie_rules = busty_parse_rules( 'busty_cookie_rules' );

    // Basic mode
    if ( isset( $_POST['basic_cache_submit'] ) ) {
        check_admin_referer( 'busty_basic_cache' );
        $p = sanitize_text_field( $_POST['basic_cache_pattern'] );
        $m = sanitize_text_field( $_POST['basic_cache_mode'] );
        $t = intval( $_POST['basic_cache_ttl'] );
        $e = sanitize_text_field( $_POST['basic_cache_extra'] );
        $v = "$m, max-age=$t" . ( $e ? ", $e" : "" );
        $lines = preg_split( '/\r?\n/', get_option( 'busty_cache_control_rules', '' ) );
        $lines[] = "$p|$v";
        update_option( 'busty_cache_control_rules', implode( "\n", $lines ) );
        echo '<div class="updated"><p>Basic cache rule added.</p></div>';
        $cache_rules = busty_parse_rules( 'busty_cache_control_rules' );
    }
    if ( isset( $_POST['basic_cookie_submit'] ) ) {
        check_admin_referer( 'busty_basic_cookie' );
        $p = sanitize_text_field( $_POST['basic_cookie_pattern'] );
        $n = sanitize_text_field( $_POST['basic_cookie_name'] );
        $val = sanitize_text_field( $_POST['basic_cookie_value'] );
        $path = sanitize_text_field( $_POST['basic_cookie_path'] );
        $h  = isset( $_POST['basic_cookie_httponly'] ) ? '; HttpOnly' : '';
        $s  = isset( $_POST['basic_cookie_secure']   ) ? '; Secure'   : '';
        $cookie = "$n=$val; Path=$path$h$s";
        $lines = preg_split( '/\r?\n/', get_option( 'busty_cookie_rules', '' ) );
        $lines[] = "$p|$cookie";
        update_option( 'busty_cookie_rules', implode( "\n", $lines ) );
        echo '<div class="updated"><p>Basic cookie rule added.</p></div>';
        $cookie_rules = busty_parse_rules( 'busty_cookie_rules' );
    }

    // Advanced mode
    if ( isset( $_POST['advanced_submit'] ) ) {
        check_admin_referer( 'busty_advanced' );
        update_option( 'busty_cache_control_rules', sanitize_textarea_field( $_POST['advanced_cache'] ) );
        update_option( 'busty_cookie_rules', sanitize_textarea_field( $_POST['advanced_cookie'] ) );
        echo '<div class="updated"><p>Advanced rules saved.</p></div>';
        $cache_rules  = busty_parse_rules( 'busty_cache_control_rules' );
        $cookie_rules = busty_parse_rules( 'busty_cookie_rules' );
    }
    ?>
    <div class="wrap"><h1>Cache Rules</h1>

      <!-- Basic Mode -->
      <h2>Basic Mode (Guided)</h2>
      <form method="post"><?php wp_nonce_field('busty_basic_cache'); ?>
        <h3>Add Cache-Control Rule</h3>
        <p><label>URL Contains: <input type="text" name="basic_cache_pattern" required></label></p>
        <p><label>Mode:
          <select name="basic_cache_mode">
            <option value="public">public</option>
            <option value="private">private</option>
          </select>
        </label></p>
        <p><label>Max-Age (sec): <input type="number" name="basic_cache_ttl" value="60" required></label></p>
        <p><label>Extra (optional): <input type="text" name="basic_cache_extra" placeholder="e.g. stale-while-revalidate=30"></label></p>
        <p><button class="button button-primary" name="basic_cache_submit">Add Cache Rule</button></p>
      </form>
      <table class="widefat fixed striped"><thead><tr><th>Pattern</th><th>Directive</th></thead><tbody>
        <?php foreach ( $cache_rules as $r ) : ?>
          <tr><td><?php echo esc_html( $r['pattern'] ); ?></td><td><?php echo esc_html( $r['value'] ); ?></td></tr>
        <?php endforeach; ?>
      </tbody></table>

      <form method="post"><?php wp_nonce_field('busty_basic_cookie'); ?>
        <h3>Add Cookie Rule</h3>
        <p><label>URL Contains: <input type="text" name="basic_cookie_pattern" required></label></p>
        <p><label>Cookie Name: <input type="text" name="basic_cookie_name" required></label></p>
        <p><label>Cookie Value: <input type="text" name="basic_cookie_value" required></label></p>
        <p><label>Path: <input type="text" name="basic_cookie_path" value="/" required></label></p>
        <p>
          <label><input type="checkbox" name="basic_cookie_httponly"> HttpOnly</label>
          <label><input type="checkbox" name="basic_cookie_secure"> Secure</label>
        </p>
        <p><button class="button button-primary" name="basic_cookie_submit">Add Cookie Rule</button></p>
      </form>
      <table class="widefat fixed striped"><thead><tr><th>Pattern</th><th>Cookie</th></thead><tbody>
        <?php foreach ( $cookie_rules as $r ) : ?>
          <tr><td><?php echo esc_html( $r['pattern'] ); ?></td><td><?php echo esc_html( $r['value'] ); ?></td></tr>
        <?php endforeach; ?>
      </tbody></table>

      <!-- Advanced Mode -->
      <h2>Advanced Mode (Free-form)</h2>
      <form method="post"><?php wp_nonce_field('busty_advanced'); ?>
        <h3>Cache-Control Rules</h3>
        <textarea name="advanced_cache" rows="6" class="large-text code"><?php echo esc_textarea( get_option( 'busty_cache_control_rules', '' ) ); ?></textarea>
        <h3>Cookie Rules</h3>
        <textarea name="advanced_cookie" rows="6" class="large-text code"><?php echo esc_textarea( get_option( 'busty_cookie_rules', '' ) ); ?></textarea>
        <p><button class="button button-primary" name="advanced_submit">Save Advanced Rules</button></p>
      </form>

      <!-- Instruction Guide & Dictionary -->
      <h2>Instruction Guide & Dictionary</h2>
      <p><strong>Rule Format:</strong> <code>pattern|value</code>. Busty checks if the URL contains <em>pattern</em>, then emits headers based on <em>value</em>.</p>
      <h3>Cache-Control Directives</h3>
      <ul>
        <li><code>public</code>: Shared caches may store the response.</li>
        <li><code>private</code>: Only browsers may cache; shared caches must revalidate.</li>
        <li><code>max-age=&lt;sec&gt;</code>: Seconds before revalidation.</li>
        <li><code>s-maxage=&lt;sec&gt;</code>: TTL for shared caches only.</li>
        <li><code>no-store</code>: Forbid any caching.</li>
        <li><code>no-cache</code>: Force revalidation on every request.</li>
        <li><code>must-revalidate</code>: Serve stale only after revalidation.</li>
        <li><code>stale-while-revalidate=&lt;sec&gt;</code>: Serve stale while fresh fetch occurs.</li>
      </ul>
      <h3>Cookie Options</h3>
      <ul>
        <li><code>Path=/</code>: Cookie applies site-wide.</li>
        <li><code>HttpOnly</code>: JavaScript cannot read this cookie.</li>
        <li><code>Secure</code>: Sent only over HTTPS.</li>
        <li><code>SameSite=Lax|Strict</code>: Controls cross-site usage.</li>
      </ul>

      <!-- Advanced Examples & Use Cases -->
      <h2>Advanced Examples & Use Cases</h2>
      <ul>
        <li><strong>Flaky AJAX endpoint bypass</strong><br>
            <code>/admin-ajax.php?action=status|bypass_cache=1;Path=/;HttpOnly</code><br>
            Let Varnish detect <code>bypass_cache=1</code> and always pass through.</li>
        <li><strong>Segmented API caching</strong><br>
            <code>/wp-json/v1/|public, max-age=60</code><br>
            <code>/wp-json/v2/|no-store</code><br>
            v1 is stable (cache 1 min); v2 is dynamic (no cache).</li>
        <li><strong>SEO landing vs. dynamic pages</strong><br>
            <code>/promo/|public, max-age=7200, stale-while-revalidate=300</code><br>
            <code>?s=|private, max-age=0, no-store</code><br>
            Cache promos 2h, keep search fresh.</li>
        <li><strong>Geolocation TTL control</strong><br>
            <code>/eu/|public, max-age=3600</code><br>
            <code>/us/|public, max-age=1800</code><br>
            Different TTL per region.</li>
        <li><strong>Feature-flag rollout</strong><br>
            <code>/beta-feature/|enable_beta=1;Path=/;Secure;HttpOnly</code><br>
            Downstream can route requests with <code>enable_beta</code> cookie.</li>
      </ul>

    </div>
<?php }
