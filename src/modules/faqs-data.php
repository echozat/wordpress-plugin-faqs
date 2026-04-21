<?php
namespace faqs;

class FAQsData
{
	public static function getFaqsList()
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$faqs_details = $table_prefix.'faqs_details';	
		
		$QueryforData = $wpdb->prepare( "SELECT * FROM $faqs_details WHERE status = %s", 1);
		$Data = $wpdb->get_results($QueryforData);

		return $Data;
	}

	public static function getFaqsCategory()
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$faqs_categories = $table_prefix.'faqs_categories';	
		
		$QueryforData = $wpdb->prepare( "SELECT * FROM $faqs_categories WHERE status = %s", 1);
		$Data = $wpdb->get_results($QueryforData);

		return $Data;
	}

	public static function checkFaqsCategory($name)
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$faqs_categories = $table_prefix.'faqs_categories';	
		
		$QueryforData = $wpdb->prepare( "SELECT * FROM $faqs_categories WHERE cat_name = '%s' AND status = %s", $name, 1);
		$Data = $wpdb->get_results($QueryforData);

		return $Data;
	}

	public static function getFaqsDetail($id)
	{
		global $wpdb;

		$faqs_details = $wpdb->prefix.'faqs_details';	

		$Query = $wpdb->prepare( "SELECT * FROM $faqs_details WHERE id = %d AND status = %s", $id, 1);	
		$Data = $wpdb->get_row($Query);

		return $Data;
	}

	public static function getFaqsQuestionDetail($quesid, $faqsid)
	{
		global $wpdb;

		$faqs_questions = $wpdb->prefix.'faqs_questions';	

		$Query = $wpdb->prepare( "SELECT * FROM $faqs_questions WHERE id = %d AND faq_id = %d AND status = %s", $quesid, $faqsid, 1);	
		$Data = $wpdb->get_row($Query);

		return $Data;
	}

	public static function getAllFaqs($id, $Args)
	{		
		// Prepare query
		$Data = self::prepareQueryResult($id);

		return $Data;
	}

	public static function prepareQueryResult($id)
	{
		global $wpdb;
		
		$faqs_details = $wpdb->prefix.'faqs_details';
		$faqs_categories = $wpdb->prefix.'faqs_categories';	
		$faqs_questions = $wpdb->prefix.'faqs_questions';

		$Data = $wpdb->get_results("SELECT * FROM $faqs_questions f_questions
		INNER JOIN $faqs_categories f_categories ON f_questions.category_id = f_categories.id		
		INNER JOIN $faqs_details f_details ON f_questions.faq_id = f_details.id		
		WHERE f_questions.faq_id = $id");

		return $Data;
	}
}
?>