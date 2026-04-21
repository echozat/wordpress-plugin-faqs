<?php

class FAQS_Install
{

    //Function to Setup DB Tables
    public static function activate()
    {
        global $wpdb;

        $faqs_details = $wpdb->prefix.'faqs_details';
        $faqs_query = "CREATE TABLE IF NOT EXISTS $faqs_details(
        id INT(9) NOT NULL AUTO_INCREMENT,    
        name VARCHAR(100) NOT NULL,     
        slug VARCHAR(100) NOT NULL,            
        icon VARCHAR(500),
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        misc VARCHAR(50),
        status TINYINT(5) DEFAULT 1,
        Primary Key id (id)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $wpdb->query($faqs_query); 


        $faqs_categories = $wpdb->prefix.'faqs_categories';
        $faqs_categories_query = "CREATE TABLE IF NOT EXISTS $faqs_categories(
        id INT(9) NOT NULL AUTO_INCREMENT, 
        cat_name VARCHAR(100) NOT NULL,    
        cat_slug VARCHAR(100) NOT NULL,                       
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,        
        status TINYINT(5) DEFAULT 1,
        Primary Key id (id)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $wpdb->query($faqs_categories_query);


        $faqs_questions = $wpdb->prefix.'faqs_questions';
        $faqs_questions_query = "CREATE TABLE IF NOT EXISTS $faqs_questions(
        id INT(9) NOT NULL AUTO_INCREMENT,                
        question VARCHAR(500) NOT NULL,
        answer VARCHAR(2000),
        faq_id INT(9) NOT NULL,  
        category_id INT(9) NOT NULL,
        question_order INT(9) NOT NULL,   
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        misc VARCHAR(50),
        status TINYINT(5) DEFAULT 1,
        Primary Key id (id)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $wpdb->query($faqs_questions_query);

        // Insert default category
        $wpdb->insert($faqs_categories, 
                        array(
                            'name'   => 'General',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'status' => 1
                            ),
                        array('%s', '%s', '%s', '%s', '%d') ); 

    }

    public static function deactivate()
    {
      return true;
    }

    public static function delete()
    {
        global $wpdb;

        $faqs_details = $wpdb->prefix.'faqs_details';
        $faqs_details_query = "DROP TABLE $faqs_details;";        
        $wpdb->query($faqs_details_query);

        $faqs_categories = $wpdb->prefix.'faqs_categories';
        $faqs_categories_query = "DROP TABLE $faqs_categories;";        
        $wpdb->query($faqs_categories_query);

        $faqs_questions = $wpdb->prefix.'faqs_questions';
        $faqs_questions_query = "DROP TABLE $faqs_questions;";        
        $wpdb->query($faqs_questions_query);
    }
}

?>