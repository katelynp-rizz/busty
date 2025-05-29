<?php
// Settings page

function busty_render_settings_page() {
    if ( isset( $_POST['save'] ) ) {
        check_admin_referer( 'busty_save' );
        update_option( 'busty_enable_logging',      isset( $_POST['busty_enable_logging'] ) );
        update_option( 'busty_enable_topbar_debug', isset( $_POST['busty_enable_topbar_debug'] ) );
        update_option( 'busty_bust_ajax',           isset( $_POST['busty_bust_ajax'] ) );
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }
    $log = busty_is_logging_enabled();
    $tb  = busty_is_topbar_debug_enabled();
    $aj  = busty_is_bust_ajax_enabled();
    ?>
    <div class="wrap">
      <h1>Busty Settings</h1>
      <form method="post"><?php wp_nonce_field('busty_save'); ?>
        <p><label><input type="checkbox" name="busty_enable_logging" <?php checked( $log ); ?>> Enable request logging</label></p>
        <p><label><input type="checkbox" name="busty_enable_topbar_debug" <?php checked( $tb ); ?>> Show Busty info in Admin Bar</label></p>
        <p><label><input type="checkbox" name="busty_bust_ajax" <?php checked( $aj ); ?>> Bust admin-ajax.php requests</label></p>
        <p><button class="button button-primary" name="save">Save Settings</button></p>
      </form>
    </div>
<?php }
