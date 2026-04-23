<?php
namespace faqs;

/**
 * @package Internals
 */

// Action hook for AJAX Request
add_action('wp_ajax_page_add_new_faqs', ['faqs\PostData', 'addNewFAQs']);
add_action('wp_ajax_page_add_new_category', ['faqs\PostData', 'addNewCategory']);
add_action('wp_ajax_page_add_faqs_question', ['faqs\PostData', 'addNewFAQsQuestion']);
add_action('wp_ajax_page_delete_faq', ['faqs\PostData', 'deleteFaq']);
add_action('wp_ajax_page_delete_faq_question', ['faqs\PostData', 'deleteFaqQuestion']);

class PostData
{
    public static function addNewFAQs()
    {
        // Get the form data
        $Data = self::getFaqsData();

        if (isset($_POST['update'])) {
            // Insert data into DB
            $RetVal = self::updateFaqsData($Data);
        } else {
            // Insert data into DB
            $RetVal = self::addFaqsData($Data);
        }

        if ($RetVal) {
            $msg = 'Successfully added';
        } else {
            $msg = 'Oops, there seems to be some issue.';
        }

        $response = ['status' => $RetVal, 'msg' => $msg];

        wp_send_json($response);
    }

    public static function addNewFAQsQuestion()
    {
        // Get the form data
        $Data = self::getQuestionData();

        if (isset($_POST['update'])) {
            // Insert data into DB
            $RetVal = self::updateQuestionData($Data);
        } else {
            // Insert data into DB
            $RetVal = self::addQuestionData($Data);
        }

        if ($RetVal) {
            $msg = 'Successfully added';
        } else {
            $msg = 'Oops, there seems to be some issue.';
        }

        $response = ['status' => $RetVal, 'msg' => $msg];

        wp_send_json($response);
    }

    public static function getQuestionData()
    {
        $Data = [];

        $Data['question']       = isset($_POST['question']) ? $_POST['question'] : '';
        $Data['answer']         = isset($_POST['answer']) ? $_POST['answer'] : '';
        $Data['faq_id']         = isset($_POST['faq_id']) ? $_POST['faq_id'] : '0';
        $Data['category_id']    = isset($_POST['category_id']) ? $_POST['category_id'] : '0';
        $Data['question_order'] = isset($_POST['question_order']) ? $_POST['question_order'] : '0';

        $Data['created_at'] = date('Y-m-d H:i:s');
        $Data['updated_at'] = date('Y-m-d H:i:s');

        $Data['misc']   = '';
        $Data['status'] = 1;

        return $Data;
    }

    public static function getFaqsData()
    {
        $Data = [];

        $Data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
        $Data['slug'] = faqsCreateSlug($Data['name']);
        $Data['icon'] = isset($_POST['icon']) ? $_POST['icon'] : '';

        $Data['created_at'] = date('Y-m-d H:i:s');
        $Data['updated_at'] = date('Y-m-d H:i:s');

        $Data['misc']   = '';
        $Data['status'] = 1;

        return $Data;
    }

    public static function addFaqsData($Data)
    {
        global $wpdb;

        $table_prefix = $wpdb->prefix;
        $faqs_details = $table_prefix . 'faqs_details';

        $wpdb->insert($faqs_details, $Data, ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%d']);

        return true;
    }

    public static function addQuestionData($Data)
    {
        global $wpdb;
        $faqs_questions = $wpdb->prefix . 'faqs_questions';

        $wpdb->insert($faqs_questions, $Data, ['%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d']);

        return true;
    }

    public static function updateQuestionData($Data)
    {
        global $wpdb;
        $faqs_questions = $wpdb->prefix . 'faqs_questions';

        $updateID = $_POST['update_id'];

        $wpdb->update($faqs_questions, $Data, ['id' => $updateID], $format = null, $where_format = null);

        return true;
    }

    public static function updateFaqsData($Data)
    {
        global $wpdb;

        $table_prefix = $wpdb->prefix;
        $faqs_details = $table_prefix . 'faqs_details';

        $updateID = $_POST['update_id'];

        $wpdb->update($faqs_details, $Data, ['id' => $updateID], $format = null, $where_format = null);

        return true;
    }

    public static function addNewCategory()
    {
        $RetVal = false;
        $Cat    = isset($_POST['cat_name']) ? $_POST['cat_name'] : '';
        $Data   = FAQsData::checkFaqsCategory($Cat);

        if ($Data) {
            $msg = "Issues adding the category. Make sure the same does'n exist.";
            wp_send_json(['status' => false, 'msg' => $msg]);
        }

        global $wpdb;

        $Data            = self::getCategoryData();
        $faqs_categories = $wpdb->prefix . 'faqs_categories';

        $wpdb->insert($faqs_categories, $Data, ['%s', '%s', '%s', '%s', '%d']);

        $response = ['status' => true, 'msg' => 'Successfully added'];

        wp_send_json($response);
    }

    public static function deleteFaq()
    {
        if (! current_user_can('manage_options')) {
            wp_send_json(['status' => false, 'msg' => 'You are not allowed to delete FAQs.']);
        }

        $faq_id = isset($_POST['faqsid']) ? (int) $_POST['faqsid'] : 0;
        $nonce  = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

        if ($faq_id <= 0 || ! wp_verify_nonce($nonce, 'faqs_delete_' . $faq_id)) {
            wp_send_json(['status' => false, 'msg' => 'Invalid delete request.']);
        }

        global $wpdb;
        $faqs_details   = $wpdb->prefix . 'faqs_details';
        $faqs_questions = $wpdb->prefix . 'faqs_questions';

        $details_result   = $wpdb->update($faqs_details, ['status' => 0], ['id' => $faq_id], ['%d'], ['%d']);
        $questions_result = $wpdb->update($faqs_questions, ['status' => 0], ['faq_id' => $faq_id], ['%d'], ['%d']);

        if (false === $details_result || false === $questions_result) {
            wp_send_json(['status' => false, 'msg' => 'Unable to delete FAQ. Please try again.']);
        }

        wp_send_json(['status' => true, 'msg' => 'FAQ deleted successfully.']);
    }

    public static function deleteFaqQuestion()
    {
        if (! current_user_can('manage_options')) {
            wp_send_json(['status' => false, 'msg' => 'You are not allowed to delete FAQ questions.']);
        }

        $question_id = isset($_POST['questionid']) ? (int) $_POST['questionid'] : 0;
        $nonce       = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

        if ($question_id <= 0 || ! wp_verify_nonce($nonce, 'faqs_question_delete_' . $question_id)) {
            wp_send_json(['status' => false, 'msg' => 'Invalid delete request.']);
        }

        global $wpdb;
        $faqs_questions = $wpdb->prefix . 'faqs_questions';
        $result         = $wpdb->update($faqs_questions, ['status' => 0], ['id' => $question_id], ['%d'], ['%d']);

        if (false === $result) {
            wp_send_json(['status' => false, 'msg' => 'Unable to delete FAQ question. Please try again.']);
        }

        wp_send_json(['status' => true, 'msg' => 'FAQ question deleted successfully.']);
    }

    public static function getCategoryData()
    {
        $Data = [];

        $Data['cat_name'] = isset($_POST['cat_name']) ? $_POST['cat_name'] : '';
        $Data['cat_slug'] = faqsCreateSlug($Data['cat_name']);

        $Data['created_at'] = date('Y-m-d H:i:s');
        $Data['updated_at'] = date('Y-m-d H:i:s');
        $Data['status']     = 1;

        return $Data;
    }
}
