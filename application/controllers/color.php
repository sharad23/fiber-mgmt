<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Color extends CI_Controller {

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
        $this->load->model('colormodel');
        $this->data['page_title'] = "Colors";  
        
    }

    public function index(){

        $this->data['title'] = "Colors";
        $this->data['data'] = $this->colormodel->get_color();
        $this->data['template'] = 'color/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
         
        $this->data['title'] = "Add Color";
        $this->data['template'] = "color/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){

        if(isset($_POST['name'])){
            
            //check whether this color already exists
            $_POST['name'] = strtolower($_POST['name']);
            $color = $this->colormodel->get_color(array('name'=>$_POST['name'],'code'=>$_POST['code'],'date'=>time()));
            if(!empty($color)){
                
                 redirect(base_url().'color');
            }
            $data =  array('name'=>$_POST['name'],'code'=>$_POST['code'],'date'=>time());
            $this->db->insert('color',$data);
            redirect(base_url().'color');

        }
       
    }

    public function delete($id){
          
    	    
         $this->db->delete('color',array('id'=>$id));
         redirect(base_url().'color');
         
    }

    public function edit($id){
         
         
        $this->data['title'] = "Edit Color";
        $data = $this->colormodel->get_color(array('id'=>$id));
        if(empty($data)){

            redirect(base_url().'color');  
        }
        $this->data['data'] =  $data;
        $this->data['template'] = "color/edit";
        $this->load->view('layout/index',$this->data);
    }

    public function update(){
       
        
    	  $data = array('name'=>$_POST['name'],'date'=>time(),'code'=>$_POST['code']);
    	  $this->colormodel->update($_POST['id'],$data);
          redirect(base_url().'color');
       
    }


   }

 ?>