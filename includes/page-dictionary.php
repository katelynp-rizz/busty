<?php
// includes/page-dictionary.php

/**
 * Renders the Busty Dictionary page, listing all Busty specific headers
 * and the Varnish cookie used for cache bypass.
 */
function busty_render_dictionary_page() {
    ?>
    <div class="wrap">
      <h1>Busty Dictionary</h1>

      <table class="widefat fixed striped">
        <thead>
          <tr>
            <th>Header</th>
            <th>Meaning</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><code>X-Busty-Cache-Bust: admin-edit</code></td>
            <td>Indicates cache was bypassed for admin or post-edit operations.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: rest-api</code></td>
            <td>Indicates cache was bypassed for REST API responses.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: route-bust</code></td>
            <td>Indicates bypass based on a user-defined route pattern.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: gf-ajax</code></td>
            <td>Indicates bypass for Gravity Forms AJAX submissions or previews.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: gf-embed</code></td>
            <td>Indicates bypass for front-end pages containing Gravity Forms embeds.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: gf-rest</code></td>
            <td>Indicates bypass for Gravity Forms REST API endpoints.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Custom-Cache</code></td>
            <td>Custom <code>Cache-Control</code> header emitted based on defined cache rules.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Custom-Cookie</code></td>
            <td>Custom <code>Set-Cookie</code> header emitted based on defined cookie rules.</td>
          </tr>
          <tr>
            <td><code>X-Busty-Cache-Bust: none</code></td>
            <td>No cache-busting logic was applied to this request.</td>
          </tr>
        </tbody>
      </table>

      <h2>Varnish Cache Bypass Cookie</h2>
      <p>
        Whenever a route-based bust occurs, Busty sets the following cookie:
      </p>
      <pre><code>Set-Cookie: busty_route_bust=1; Path=/; HttpOnly</code></pre>
	 
    </div>
    <?php
}
