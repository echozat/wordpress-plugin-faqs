<?php
/**
 * @package            FAQs
 *
 * Plugin Name:        FAQs
 * Plugin URI:         https://echozat.com/wordpress/plugins/faqs-wordpress-plugin/
 * Description:        FAQs (faqs) helps you create FAQs sections for your website
 *
 * Version:            1.0.1
 *
 * Author:             Echozat
 * Author URI:         https://echozat.com
 *
 * License:            GPLv2
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! defined('FAQS_PATH')) {
    define('FAQS_PATH', plugin_dir_path(__FILE__));
}

if (! defined('FAQ_FILE_PATH')) {
    define('FAQ_FILE_PATH', __FILE__);
}

if (! defined('FAQ_PLUGIN_URL')) {
    define('FAQ_PLUGIN_URL', plugin_dir_url(__FILE__));
}

require_once FAQS_PATH . 'src/core/core.php';
require_once FAQS_PATH . 'src/core/loader.php';
