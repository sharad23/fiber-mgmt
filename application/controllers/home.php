<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public $data = array();
   
    public function __construct()
    {
          
        parent::__construct();        
        $this->data['page_title'] = "Login";  
        
    }

    public function index(){      
       
		$this->data['title'] = 'Fiber Network Management';
        $this->load->view('layout/login',$this->data);
    }
	
	public function do_login(){
		
		$data = array('username'=>trim($_POST['username']),'password'=>trim(md5($_POST['password'])));
		$valid = $this->verify($data);
				
		if(count($valid)==1){
			
			$this->session->set_userdata('user_id',$valid[0]->id);
			$this->session->set_userdata('username',$valid[0]->username);
			$this->session->set_userdata('user_type',$valid[0]->user_type);//return 0 or 1
			$this->session->set_userdata('permision',$valid[0]->flag);//return 0 or 1
			$this->session->set_userdata('master_admin',$valid[0]->user_type);//master_admin=1,admin=0
			$this->session->set_userdata('is_logged_in',TRUE);
			redirect(base_url().'admin');
			
		}
		else{
			
			$this->session->set_flashdata('Login_error','<p style="color:#f30;margin-left:12px;padding:2px;">Login failed. Try again...</p>');
			
			redirect(base_url().'fiberconnection');
		}
	}
	
	public function verify($data){
		
		$data = $this->db->get_where('users',$data);		
		return $data->result();
		 		
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'home');
	}
}