<?php

if (version_compare(PHP_VERSION, '5.2', '<')) {
    if (is_admin() && (! defined('DOING_AJAX') || ! DOING_AJAX)) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins(__FILE__);
        wp_die(sprintf(__('FAQs requires PHP 5.2 or higher, as does WordPress 3.2 and higher. The plugin has now disabled itself.', 'Mins To Read'), '<a href="http://wordpress.org/">', '</a>'));
    } else {
        return;
    }
}

if (! defined('FAQS_BASENAME')) {
    define('FAQS_BASENAME', plugin_basename(__FILE__));
}

if (! defined('FAQS_VERSION')) {
    define('FAQS_VERSION', '1.0.1');
}

if (! defined('FAQS_PLUGIN_DIR')) {
    define('FAQS_PLUGIN_DIR', dirname(__FILE__));
}

if (! defined('FAQS_LOAD_JS')) {
    define('FAQS_LOAD_JS', true);
}

if (! defined('FAQS_LOAD_CSS')) {
    define('FAQS_LOAD_CSS', true);
}

faqs\Core::load('core/plugin-setup.php');
// faqs\Core::load('modules/faqs.php');
// Core::load('modules/faqs-admin.php');

register_activation_hook(FAQ_FILE_PATH, ['faqs\PluginSetup', 'activate']);
register_deactivation_hook(FAQ_FILE_PATH, ['faqs\PluginSetup', 'deactivate']);

// add_action('plugins_loaded', 'FAQsStart');

// function FAQsStart()
// {
//     $initObj = faqs\FAQSAdmin::get_instance();
//     $initObj->init();
// }
