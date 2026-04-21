<?php

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once FAQS_PLUGIN_DIR . '/includes/faqs-install.php';

if (class_exists('FAQS_Install') && method_exists('FAQS_Install', 'delete')) {
    FAQS_Install::delete();
}
