<?php

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

if (! defined('FAQS_PATH')) {
    define('FAQS_PATH', plugin_dir_path(__FILE__));
}

require_once FAQS_PATH . 'src/core/plugin-setup.php';

if (class_exists('faqs\PluginSetup') && method_exists('faqs\PluginSetup', 'delete')) {
    faqs\PluginSetup::delete();
}
