<?php
namespace faqs;

class FAQSAdmin
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
        $this->fileInlcudes();

        add_action('admin_menu', [$this, 'menuItems']);

        add_action('init', [$this, 'userFiles']);
    }

    public function fileInlcudes()
    {
        require_once FAQS_PLUGIN_DIR . '/includes/post-requests.php';
        require_once FAQS_PLUGIN_DIR . '/includes/faqs-data.php';
        require_once FAQS_PLUGIN_DIR . '/includes/faqs-listtable.php';
        require_once FAQS_PLUGIN_DIR . '/includes/faqs-question-listtable.php';
        require_once FAQS_PLUGIN_DIR . '/includes/faqs-helper.php';
        require_once FAQS_PLUGIN_DIR . '/includes/faqs-methods.php';
    }

    public function menuItems()
    {
        add_menu_page('FAQs', 'FAQs', 'manage_options', 'faqs', [$this, 'pageDashboard']);

        $PageA = add_submenu_page('faqs', 'Dashboard', 'Dashboard', 'manage_options', 'faqs', [$this, 'pageDashboard']);
        $PageB = add_submenu_page('faqs', 'All FAQs', 'All FAQs', 'manage_options', 'faqs-all-faqs', [$this, 'pageAllFAQs']);
        $PageC = add_submenu_page("", 'View FAQs', 'View FAQs', 'manage_options', 'faqs-view-faqs', [$this, 'pageSingleFAQs']);
        $PageD = add_submenu_page("", 'Create Faqs', 'Create Faqs', 'manage_options', 'faqs-create-faqs', [$this, 'pageCreateFaqs']);
        $PageE = add_submenu_page("", 'Add Question', 'Add Question', 'manage_options', 'faqs-add-question', [$this, 'pageAddQuestion']);
        $PageF = add_submenu_page("", 'Edit Question', 'Edit Question', 'manage_options', 'faqs-edit-question', [$this, 'pageEditQuestion']);
        $PageG = add_submenu_page("", 'Edit FAQs', 'Edit FAQs', 'manage_options', 'faqs-edit-faq', [$this, 'pageEditFaqs']);
        $PageH = add_submenu_page('faqs', 'Categories', 'Categories', 'manage_options', 'faqs-categories', [$this, 'pageCategories']);

        add_action('admin_print_scripts-' . $PageA, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageB, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageC, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageD, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageE, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageF, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageG, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageH, [$this, 'adminScriptStyles']);

    }

    public function adminScriptStyles()
    {
        if (is_admin()) {
            wp_enqueue_media();
            wp_enqueue_script('faqs-ajax-request', plugins_url('faqs/assets/js/faqs-admin.js'), ['jquery'], false, true);
            wp_enqueue_script('faqs-think201-validator', plugins_url('faqs/assets/js/think201-validator.js'), ['jquery'], false, true);
            wp_localize_script('faqs-ajax-request', 'FAQSAjax', ['ajaxurl' => plugins_url('admin-ajax.php')]);
            wp_enqueue_style('faqs-css', plugins_url('faqs/assets/css/faqs.css'), [], FAQS_VERSION, 'all');
        }
    }

    public function userFiles()
    {
        if (! is_admin()) {
            wp_enqueue_style('faqs-usercss', plugins_url('faqs/assets/css/faqs-user.css'), [], FAQS_VERSION, 'all');
            wp_enqueue_script('faqs-userjs', plugins_url('faqs/assets/js/faqs-user.js'), ['jquery'], false, true);
        }
    }

    public function pageDashboard()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-dashboard.php';
    }

    public function pageCreateFaqs()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-create-faqs.php';
    }

    public function pageAddQuestion()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-add-question.php';
    }

    public function pageEditQuestion()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-edit-question.php';
    }

    public function pageEditFaqs()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-edit-faq.php';
    }

    public function pageAllFAQs()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-all-faqs.php';
    }

    public function pageSingleFAQs()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-view-faqs.php';
    }

    public function pageCategories()
    {
        require_once FAQS_PLUGIN_DIR . '/pages/admin-categories.php';
    }
}
