<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends Controller {
	
    function __construct() {
        parent::__construct();
    }

   /**************************************************
                        Example
    **************************************************/


	// unrestricted method
    function example_of_unrestricted_method() {
		
		echo "This is an unrestriced method";

    }

	// method with hosts_restrictions applied
	function example_of_unrestricted_method() {
	
		// load the library 
		$this->load->library('host_restriction_lib');
		
		//evaluate the reponse
		if(!$this->host_restriction_lib->validate('name_of_a_rule_set')) {
		
			echo "Nope....".$this->host_restriction_lib->get_error();
			
		} else {
		
			echo "Yep! Yep!";
			
		}
		
	}

}