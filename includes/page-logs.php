<?php
function busty_render_logs_page() {
    if ( isset( $_POST['toggle_log'] ) ) {
        check_admin_referer( 'busty_toggle_log' );
        update_option( 'busty_enable_logging', isset( $_POST['busty_enable_logging'] ) );
        echo '<div class="updated"><p>Logging ' . ( busty_is_logging_enabled() ? 'enabled' : 'disabled' ) . '.</p></div>';
    }
    if ( isset( $_POST['busty_clear_logs'] ) ) {
        check_admin_referer( 'busty_clear' );
        busty_ensure_log_dir();
        file_put_contents( BUSTY_LOG_FILE, '' );
        echo '<div class="updated"><p>Logs cleared.</p></div>';
    }

    $log = busty_is_logging_enabled(); ?>
    <div class="wrap"><h1>Busty Logs</h1>
      <form method="post"><?php wp_nonce_field( 'busty_toggle_log' ); ?>
        <p><label><input type="checkbox" name="busty_enable_logging" value="1" <?php checked( $log ); ?>> Enable logging</label></p>
        <p><button class="button" name="toggle_log">Save</button></p>
      </form>
      <form method="post"><?php wp_nonce_field( 'busty_clear' ); ?>
        <p><button class="button" name="busty_clear_logs">Clear Logs</button></p>
      </form>
      <?php busty_ensure_log_dir();
      if ( file_exists( BUSTY_LOG_FILE ) ) {
          $lines = file( BUSTY_LOG_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
          echo '<table class="widefat fixed striped"><thead><tr><th>Time</th><th>Type</th><th>URI</th><th>Header</th></tr></thead><tbody>';
          foreach ( $lines as $l ) {
              $d = json_decode( $l, true );
              if ( ! $d ) continue;
              $hd = 'none';
              foreach ( $d['response_headers'] as $h ) {
                  if ( 0 === stripos( $h, 'X-Busty-Cache-Bust:' ) ) {
                      $hd = trim( substr( $h, strlen( 'X-Busty-Cache-Bust:' ) ) );
                      break;
                  }
              }
              echo '<tr><td>' . esc_html( $d['time'] ) . '</td><td>' . esc_html( $d['type'] ) . '</td><td>' . esc_html( $d['uri'] ) . '</td><td>' . esc_html( $hd ) . '</td></tr>';
          }
          echo '</tbody></table>';
      } else {
          echo '<p>No logs found.</p>';
      } ?>
    </div>
<?php }
