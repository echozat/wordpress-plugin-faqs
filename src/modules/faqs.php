<?php
namespace faqs;

class FAQS
{
	protected static $instance = null;

	public function __construct()
    {
    }

    public static function get_instance() 
    {
	 	// create an object
	 	NULL === self::$instance and self::$instance = new self;

	 	return self::$instance;
	 }

    // Initiation Hook
    public function init()
    {
        

    }
}

?>