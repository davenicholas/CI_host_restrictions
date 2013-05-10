<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Host_restriction_lib {
	
	private $_error = "";
	private $_candidate_ip = "";
	private $_CI = "";
	
	public function __construct() {
        if(isset($_SERVER['REMOTE_ADDR'])) {
			$this->_candidate_ip = $_SERVER['REMOTE_ADDR'];
		}
		$this->CI =& get_instance();
    }

	public function validate($rule_set) {
		
		$rules = $this->CI->config->item('host_restrictions');
		$allowed_ip_array = $rules[$rule_set];
		
		if(!$this->is_valid_ip($this->_candidate_ip)) {
			$this->set_error('Candidate IP address is NOT valid');
			return false;
		}
		
		$ip_candidate_segs = explode(".", $this->_candidate_ip);
		
		$match_found = false;
		
		foreach($allowed_ip_array as $k => $ip) {
			
			$ip_segs = explode(".", $ip);
			
			if($ip_segs[0]==$ip_candidate_segs[0] &&
				$ip_segs[1]==$ip_candidate_segs[1] &&
				$ip_segs[2]==$ip_candidate_segs[2]) {
					
				if($ip_segs[3] == $ip_candidate_segs[3])
					return true;
				
				if($ip_segs[3] == "*")
					return true;
				
				if(strpos($ip_segs[3], "-")!==false) {
					$ip_range = explode('-', $ip_segs[3]);
					if(in_array($ip_candidate_segs[3], range($ip_range[0], $ip_range[1]))) {
						return true;
					}
				}
			}
		}
		
		if(!$match_found) {
			$this->set_error('No matches found.');
			return false;
		}
		
	}
	
	private function set_error($error) {
		$this->_error = $error;
	}
	
	public function get_error() {
		return $this->_error;
	}
	
	private function is_valid_ip($ip) {
		if(function_exists('filter_var'))
			return filter_var($ip, FILTER_VALIDATE_IP);
		return true;
	}
		
}