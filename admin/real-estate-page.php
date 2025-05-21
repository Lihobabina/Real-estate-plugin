<?php
add_action('admin_menu', 'reh_register_settings_page');

function reh_register_settings_page() {
    add_menu_page(
        'Real Estate Settings',
        'Real Estate',
        'manage_options',
        'real-estate-settings',
        'reh_settings_page_callback',
        'dashicons-building',
        30
    );
}

function reh_settings_page_callback() {
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'api';
    ?>
    <div class="wrap">
        <h1>Real Estate Settings</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=real-estate-settings&tab=api" class="nav-tab <?php echo $active_tab === 'api' ? 'nav-tab-active' : ''; ?>">API</a>
            <a href="?page=real-estate-settings&tab=manual" class="nav-tab <?php echo $active_tab === 'manual' ? 'nav-tab-active' : ''; ?>">Manual Run</a>
            <a href="?page=real-estate-settings&tab=log" class="nav-tab <?php echo $active_tab === 'log' ? 'nav-tab-active' : ''; ?>">Log</a>
        </h2>

        <?php
        if ($active_tab === 'api') {
            ?>
            <form method="post" action="options.php">
                <?php
                settings_fields('real_estate_settings_group');
                do_settings_sections('real-estate-api-settings');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="reh_api_key">API Key</label></th>
                        <td><input type="text" id="reh_api_key" name="reh_api_key" value="<?php echo esc_attr(get_option('reh_api_key')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="reh_basic_url">Basic URL</label></th>
                        <td><input type="text" id="reh_basic_url" name="reh_basic_url" value="<?php echo esc_attr(get_option('reh_basic_url')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="reh_per_run_limit">Per Run Limit</label></th>
                        <td><input type="number" id="reh_per_run_limit" name="reh_per_run_limit" value="<?php echo esc_attr(get_option('reh_per_run_limit', 5)); ?>" min="1" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <?php
        } elseif ($active_tab === 'manual') {
            ?>
            <button type="button" id="reh_run_import" class="button-primary"  style="margin-top: 20px;">Run Import</button>
            <div id="reh_import_result" style="margin-top: 15px;"></div>
            <?php
        } elseif ($active_tab === 'log') {
            ?>
            <form method="post" action="options.php">
                <?php
                settings_fields('real_estate_settings_group');
                do_settings_sections('real-estate-log-settings');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="reh_log_output">Log Output</label></th>
                        <td><textarea id="reh_log_output" name="reh_log_output" readonly rows="10" cols="60"><?php echo esc_textarea(get_option('reh_log_output')); ?></textarea></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
}

add_action('admin_init', 'reh_register_settings');

function reh_register_settings() {
    register_setting('real_estate_settings_group', 'reh_api_key');
    register_setting('real_estate_settings_group', 'reh_basic_url');
    register_setting('real_estate_settings_group', 'reh_per_run_limit');
    register_setting('real_estate_settings_group', 'reh_log_output');
}

function reh_write_log($message) {
    $log_file = REH_PLUGIN_DIR . '/log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[{$timestamp}] - {$message}\n";

    file_put_contents($log_file, $log_message, FILE_APPEND);
    $log_content = file_get_contents($log_file);
    update_option('reh_log_output', $log_content);
}

add_action('admin_enqueue_scripts', 'reh_enqueue_scripts');

function reh_enqueue_scripts($hook) {
    if ($hook === 'toplevel_page_real-estate-settings') {
        wp_enqueue_script('reh-ajax-runner', plugin_dir_url(__FILE__) . '../js/ajax-runner.js', ['jquery'], null, true);

        wp_localize_script('reh-ajax-runner', 'reh_ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('reh_run_parser_nonce'),
            'per_run_limit' => get_option('reh_per_run_limit' ) 
        ]);
    }
}