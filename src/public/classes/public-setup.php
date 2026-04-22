<?php
namespace faqs;

class PublicSetup
{
    protected static $instance = null;

    public static function get_instance()
    {
        // create an object
        null === self::$instance and self::$instance = new self;

        return self::$instance;
    }

    public function init()
    {
        $this->fileIncludes();

        add_action('init', [$this, 'scripts']);
    }

    public function fileIncludes()
    {
        Core::load('modules/post-requests.php');
        Core::load('modules/faqs-data.php');
        Core::load('modules/faqs-listtable.php');
        Core::load('modules/faqs-question-listtable.php');
        Core::load('modules/faqs-helper.php');
        Core::load('modules/faqs-methods.php');
        Core::load('modules/shortcodes/faqs-shortcodes.php');
    }

    public function scripts()
    {
        wp_enqueue_style('faqs-public', FAQ_PLUGIN_URL . 'build/css/public.css', [], FAQS_VERSION, 'all');
        wp_enqueue_script('faqs-public', FAQ_PLUGIN_URL . 'build/js/public.js', ['jquery'], false, true);
    }

}
