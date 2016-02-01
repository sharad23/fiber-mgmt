<?php if(! defined('BASEPATH')) exit('No direct script is allowed');

class Mylib {
	
	public function __construct(){
		
		parent::__construct();
	}		
	public function is_logged_in(){
		
		if($this->session->userdata('is_logged_in')==TRUE){
			return true;
		}
	}
	
	
			
}