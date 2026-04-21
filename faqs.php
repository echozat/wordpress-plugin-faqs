<?php
/*
Plugin Name: FAQs
Plugin URI: http://labs.think201.com/plugins/faqs
Description: FAQs (faqs) helps you create FAQs section for your website
Author: Think201
Version: 1.0.1
Author URI: http://www.think201.com
License: GPL v1

FAQs
Copyright (C) 2015, Think201 - hello@think201.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 * @package Main
 */

//start session
if (session_id() == '') {
    session_start();
}

if (version_compare(PHP_VERSION, '5.2', '<')) {
    if (is_admin() && (! defined('DOING_AJAX') || ! DOING_AJAX)) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins(__FILE__);
        wp_die(sprintf(__('FAQs requires PHP 5.2 or higher, as does WordPress 3.2 and higher. The plugin has now disabled itself.', 'Mins To Read'), '<a href="http://wordpress.org/">', '</a>'));
    } else {
        return;
    }
}

if (! defined('FAQS_PATH')) {
    define('FAQS_PATH', plugin_dir_path(__FILE__));
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

require_once FAQS_PLUGIN_DIR . '/includes/faqs-install.php';
require_once FAQS_PLUGIN_DIR . '/includes/faqs-admin.php';
require_once FAQS_PLUGIN_DIR . '/includes/faqs.php';

register_activation_hook(__FILE__, ['FAQS_Install', 'activate']);
register_deactivation_hook(__FILE__, ['FAQS_Install', 'deactivate']);

add_action('plugins_loaded', 'FAQsStart');

function FAQsStart()
{
    $initObj = faqs\FAQSAdmin::get_instance();
    $initObj->init();
}
