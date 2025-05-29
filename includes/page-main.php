<?php
// Overview page for Busty

function busty_render_main_page() { ?>
    <div class="wrap">
      <h1>Busty Cache Busting</h1>
      <p>Busty is the best, most simple and yet advanced, straight forward cache busting plugin. It automatically bussts critical URL's and gives you fine-grained control over when and how pages get cached, so we never end up with stale nonces or other stale content in our admin or API workflows. In a nutshell, it:</p>
      <ul>
        <li>
          <strong>Automatically busts caches on critical admin/API endpoints</strong>
          <ul>
            <li>Disables caching on <code>post.php</code> edit screens (so your ACF/nonces never expire mid-edit)</li>
            <li>Optionally disables caching on <code>admin-ajax.php</code> calls</li>
            <li>Forces <code>no-cache</code> on every REST API response</li>
          </ul>
        </li>
        <li>
          <strong>Lets you define your own rules for Cache-Control headers & cookies</strong>
          <ul>
            <li><em>Basic mode</em>: simple form (URL substring + public/private + TTL + extras) or cookie name/value/path/flags</li>
            <li><em>Advanced mode</em>: free-form <code>pattern|value</code> entries for total flexibility</li>
          </ul>
        </li>
        <li>
          <strong>Supports “route bust”</strong> -- enter URI substrings under <em>Routes</em>, and Busty will automatically add <code>nocache</code> plus an <code>X-Busty-Cache-Bust: route-bust</code> header
        </li>
        <li>
          <strong>Provides real-time debugging</strong> via an Admin Bar menu showing which hook ran (admin-edit, rest-api, route-bust, etc.) and which Busty header was applied
        </li>
        <li>
          <strong>Includes a Dictionary page</strong> explaining every Busty header meaning
        </li>
        <li>
          <strong>Logs every bust event</strong> (when enabled) with time, type, URI, and headers both viewable and clearable in the Logs page
        </li>
        <li>
          <strong>Centralized Settings</strong> for toggling logging, Admin-Bar debug, and AJAX-bust behavior
        </li>
      </ul>
      <p>Overall, Busty ensures our WP admin and custom endpoints never serve stale content, while still letting us apply controlled caching elsewhere.</p>
	<p>Built by a sysadmin. Basically, busty is boss.</p>
    </div>
<?php }
