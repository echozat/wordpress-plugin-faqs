<?php
namespace faqs;
/**
 * @package Internals
 */

// Action hook for AJAX Request
add_action('wp_ajax_page_add_new_faqs', array('faqs\PostData', 'addNewFAQs'));
add_action('wp_ajax_page_add_new_category', array('faqs\PostData', 'addNewCategory'));
add_action('wp_ajax_page_add_faqs_question', array('faqs\PostData', 'addNewFAQsQuestion'));


class PostData
{
	public static function addNewFAQs()
	{
		// Get the form data
		$Data = self::getFaqsData();

		if(isset($_POST['update']))
		{
			// Insert data into DB
			$RetVal = self::updateFaqsData($Data);
		}
		else
		{
			// Insert data into DB
			$RetVal = self::addFaqsData($Data);
		}
	
		if($RetVal)
		{
			$msg = 'Successfully added';
		}
		else
		{
			$msg = 'Oops, there seems to be some issue.';
		}

		$response = array('status' => $RetVal, 'msg' 	=> $msg);
		
		wp_send_json($response);
	}

	public static function addNewFAQsQuestion()
	{
		// Get the form data
		$Data = self::getQuestionData();

		if(isset($_POST['update']))
		{
			// Insert data into DB
			$RetVal = self::updateQuestionData($Data);
		}
		else
		{
			// Insert data into DB
			$RetVal = self::addQuestionData($Data);
		}
	
		if($RetVal)
		{
			$msg = 'Successfully added';
		}
		else
		{
			$msg = 'Oops, there seems to be some issue.';
		}

		$response = array('status' => $RetVal, 'msg' 	=> $msg);
		
		wp_send_json($response);
	}

	public static function getQuestionData()
	{
		$Data = array();

		$Data['question'] 		= isset($_POST['question']) ? $_POST['question'] : ''; 	
		$Data['answer'] 			= isset($_POST['answer']) ? $_POST['answer'] : ''; 	
		$Data['faq_id'] 			= isset($_POST['faq_id']) ? $_POST['faq_id'] : '0'; 	
		$Data['category_id'] 	= isset($_POST['category_id']) ? $_POST['category_id'] : '0'; 	
		$Data['question_order'] = isset($_POST['question_order']) ? $_POST['question_order'] : '0'; 	

		$Data['created_at']     = date('Y-m-d H:i:s');
		$Data['updated_at'] 		= date('Y-m-d H:i:s'); 

		$Data['misc'] 				= ''; 
		$Data['status'] 			= 1;

		return $Data;
	}

	public static function getFaqsData()
	{
		$Data = array();

		$Data['name'] 				= isset($_POST['name']) ? $_POST['name'] : ''; 	
		$Data['slug'] 				= faqsCreateSlug($Data['name']); 	
		$Data['icon'] 				= isset($_POST['icon']) ? $_POST['icon'] : '';	

		$Data['created_at']     = date('Y-m-d H:i:s');
		$Data['updated_at'] 		= date('Y-m-d H:i:s'); 

		$Data['misc'] 				= ''; 
		$Data['status'] 			= 1;

		return $Data;
	}

	public static function addFaqsData($Data)
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$faqs_details = $table_prefix.'faqs_details';
		
		$wpdb->insert($faqs_details, $Data,	array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d','%s', '%s','%s','%d') ); 

		return true;
	}

	public static function addQuestionData($Data)
	{
		global $wpdb;		
		$faqs_questions = $wpdb->prefix.'faqs_questions';
		
		$wpdb->insert($faqs_questions, $Data,	array('%s', '%s', '%d', '%d', '%s', '%s', '%s','%s', '%d') ); 

		return true;
	}

	public static function updateQuestionData($Data)
	{
		global $wpdb;
		$faqs_questions = $wpdb->prefix.'faqs_questions';

		$updateID = $_POST['update_id'];

		$wpdb->update($faqs_questions, $Data, array('id'=> $updateID), $format = null, $where_format = null );
		
		return true;
	}	

	public static function updateFaqsData($Data)
	{
		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$faqs_details = $table_prefix.'faqs_details';

		$updateID = $_POST['update_id'];

		$wpdb->update($faqs_details, $Data, array('id'=> $updateID), $format = null, $where_format = null );
		
		return true;
	}	

	public static function addNewCategory()
	{
		$RetVal = false;
		$Cat = isset($_POST['cat_name']) ? $_POST['cat_name'] : '';
		$Data = FAQsData::checkFaqsCategory($Cat);

		if($Data)
		{
			$msg = "Issues adding the category. Make sure the same does'n exist.";
			wp_send_json(array('status' => false, 'msg' 	=> $msg));
		}

		global $wpdb;

		$Data = self::getCategoryData();
		$faqs_categories = $wpdb->prefix.'faqs_categories';
		
		$wpdb->insert($faqs_categories, $Data,	array('%s', '%s', '%s', '%s', '%d') ); 

		$response = array('status' => true, 'msg' => 'Successfully added');
		
		wp_send_json($response);		
	}

	public static function getCategoryData()
	{
		$Data = array();

		$Data['cat_name'] = isset($_POST['cat_name']) ? $_POST['cat_name'] : ''; 	
		$Data['cat_slug'] = faqsCreateSlug($Data['cat_name']); 	
		
		$Data['created_at']     	= date('Y-m-d H:i:s');
		$Data['updated_at'] 		= date('Y-m-d H:i:s'); 
		$Data['status'] 			= 1;

		return $Data;
	}
}
?>