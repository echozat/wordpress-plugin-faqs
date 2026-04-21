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

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! defined('FAQS_PATH')) {
    define('FAQS_PATH', plugin_dir_path(__FILE__));
}

if (! defined('FAQ_FILE_PATH')) {
    define('FAQ_FILE_PATH', __FILE__);
}

require_once FAQS_PATH . 'src/core/core.php';
require_once FAQS_PATH . 'src/core/loader.php';
