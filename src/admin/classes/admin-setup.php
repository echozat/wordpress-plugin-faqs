<?php
namespace faqs;

class AdminSetup
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
        // add_action('admin_init', [AdminFaqsActions::get_instance(), 'maybeDeleteFaq']);

        add_action('admin_menu', [$this, 'menuItems']);

    }

    public function fileIncludes()
    {
        Core::load('modules/post-requests.php');
        Core::load('modules/faqs-data.php');
        Core::load('modules/faqs-listtable.php');
        Core::load('modules/faqs-categories-listtable.php');
        Core::load('modules/faqs-question-listtable.php');
        Core::load('modules/faqs-helper.php');
        Core::load('modules/faqs-methods.php');

    }

    public function menuItems()
    {

        add_menu_page('FAQs', 'FAQs', 'manage_options', 'faqs', [$this, 'pageAllFAQs']);

        $PageB = add_submenu_page('faqs', 'All FAQs', 'All FAQs', 'manage_options', 'faqs-all-faqs', [$this, 'pageAllFAQs']);
        $PageC = add_submenu_page('', 'View FAQs', 'View FAQs', 'manage_options', 'faqs-view-faqs', [$this, 'pageSingleFAQs']);
        $PageD = add_submenu_page('', 'Create Faqs', 'Create Faqs', 'manage_options', 'faqs-create-faqs', [$this, 'pageCreateFaqs']);
        $PageE = add_submenu_page('', 'Add Question', 'Add Question', 'manage_options', 'faqs-add-question', [$this, 'pageAddQuestion']);
        $PageF = add_submenu_page('', 'Edit Question', 'Edit Question', 'manage_options', 'faqs-edit-question', [$this, 'pageEditQuestion']);
        $PageG = add_submenu_page('', 'Edit FAQs', 'Edit FAQs', 'manage_options', 'faqs-edit-faq', [$this, 'pageEditFaqs']);
        $PageH = add_submenu_page('faqs', 'Categories', 'Categories', 'manage_options', 'faqs-categories', [$this, 'pageCategories']);

        add_action('admin_print_scripts-' . $PageB, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageC, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageD, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageE, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageF, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageG, [$this, 'adminScriptStyles']);
        add_action('admin_print_scripts-' . $PageH, [$this, 'adminScriptStyles']);

        add_filter('parent_file', [$this, 'setMenuParent']);
        add_filter('submenu_file', [$this, 'setSubmenuFile']);

    }

    public function adminScriptStyles()
    {
        if (is_admin()) {
            #
            wp_enqueue_media();
            wp_enqueue_script('faqs-admin', FAQ_PLUGIN_URL . 'build/js/admin.js', ['jquery'], false, true);
            wp_enqueue_script('faqs-think201-wp', FAQ_PLUGIN_URL . 'assets/admin/js/think201-wp.js', ['jquery', 'faqs-admin'], FAQS_VERSION, true);
            wp_localize_script('faqs-ajax-request', 'FAQSAjax', ['ajaxurl' => plugins_url('admin-ajax.php')]);
            wp_enqueue_style('faqs-admin', FAQ_PLUGIN_URL . 'build/css/admin.css', [], FAQS_VERSION, 'all');
        }
    }

    private function isHiddenFaqPage()
    {
        $page = isset($_GET['page']) ? sanitize_key(wp_unslash($_GET['page'])) : '';
        return in_array($page, ['faqs-view-faqs', 'faqs-create-faqs', 'faqs-add-question', 'faqs-edit-question', 'faqs-edit-faq'], true);
    }

    public function setMenuParent($parent_file)
    {
        if ($this->isHiddenFaqPage()) {
            return 'faqs';
        }

        return $parent_file;
    }

    public function setSubmenuFile($submenu_file)
    {
        return $this->isHiddenFaqPage() ? 'faqs-all-faqs' : $submenu_file;
    }

    public function pageDashboard()
    {
        Core::load('admin/views/admin-dashboard.php');
    }

    public function pageCreateFaqs()
    {
        Core::load('admin/views/admin-create-faqs.php');
    }

    public function pageAddQuestion()
    {
        Core::load('admin/views/admin-add-question.php');
    }

    public function pageEditQuestion()
    {
        Core::load('admin/views/admin-edit-question.php');
    }

    public function pageEditFaqs()
    {
        Core::load('admin/views/admin-edit-faq.php');
    }

    public function pageAllFAQs()
    {
        Core::load('admin/views/admin-all-faqs.php');
    }

    public function pageSingleFAQs()
    {
        Core::load('admin/views/admin-view-faqs.php');
    }

    public function pageCategories()
    {
        Core::load('admin/views/admin-categories.php');
    }
}
