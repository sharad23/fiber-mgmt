<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		if(!$this->session->userdata('user_id')){
			redirect(base_url().'home');
		}
        $this->load->model('adminmodel');
        $this->data['page_title'] = "Admin Panel";
			  	
		
    }

    public function index(){	
	
		if($this->is_admin()==true){
			$this->data['template'] = 'layout/denied';
			$this->load->view('layout/index',$this->data);
		}else{
        	$this->data['title'] = "Administrator Panel";
        	$this->data['data'] = $this->adminmodel->get_users();
        	$this->data['template'] = 'admin/index';
        	$this->load->view('layout/index',$this->data);
		}
    }

    public function add(){
		
       $this->data['title'] = 'Add User';
       $this->data['template'] = 'admin/addform';
	   $this->load->view('layout/index',$this->data);

    }
	
    public function insert(){
            
       $userdata = array('name'=>$_POST['name'],
	   					'username'=>$_POST['username'],
						'password'=> md5($_POST['username']),
						'user_type'=>$_POST['user_type'],
						'flag'=>$_POST['permission']); 
						
       $this->db->insert('users',$userdata);
	   redirect(base_url().'admin');
      
       
    }

    public function block($id){
          
    	 $this->db->where('id',$id);
		 $this->db->update('users',array('block'=>1));
		 redirect(base_url().'admin');        
         
    }
	
	public function unblock($id){
          
    	 $this->db->where('id',$id);
		 $this->db->update('users',array('block'=>0));
		 redirect(base_url().'admin');        
         
    }

    public function edit($id){
         
        $data = $this->adminmodel->get_users(array('id'=>$id));
		$this->data['data'] = $data;
		$this->data['title'] = 'Edit users';
		$this->data['template'] = 'admin/editform';
		$this->load->view('layout/index',$this->data); 
    }                                                                                                                                                              

    public function update($id){
       
		$userdata = array('name'=>$_POST['name'],
						'username'=>$_POST['username'],
						'user_type'=>$_POST['user_type'],
						'flag'=>$_POST['permission'] );
		
		$this->adminmodel->update($id,$userdata);
		redirect(base_url().'admin');
    	  
       
    }
	
	public function change_password(){
		$this->data['title'] = 'Change Password';
		$this->data['template'] = 'layout/change_password';
		$this->load->view('layout/index',$this->data);
	}
	
	public function update_password($id){
		
		$data = $this->adminmodel->get_users(array('id'=>$id));		
		if($data[0]->password == md5(trim($_POST['old_password']))){
			
			$this->db->where('id',$id);
			$this->db->update('users',array('password'=> md5(trim($_POST['new_password']))));
			
			$this->session->set_flashdata('done','Your password has been changed.');
			redirect(base_url().'admin/change_password');
			
		}else {
			
			$this->session->set_flashdata('password_error','Old password not match');
			redirect(base_url().'admin/change_password');
			
		}
	}

   public function is_admin(){
		
		if($this->session->userdata('master_admin') =='0'){
			return true;
			//$this->data['template'] = 'layout/denied';
			//$this->load->view('layout/index',$this->data);						
		}else {
			return false;
		}    
	}

    
}

 ?>