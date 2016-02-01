<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiber extends CI_Controller {

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
        $this->load->model('bunchmodel');
        $this->load->model('fibermodel');
        $this->load->model('fiberconnectionmodel');
        $this->data['page_title'] = "Fiber Inventory";  
        
    }

    public function index(){

        $this->data['title'] = "Fiber Inventory";       
		    $this->data['data'] = $this->fibermodel->get_fiber();
        $this->data['template'] = 'fiber/index';
        $this->load->view('layout/index',$this->data);
    }

   public function add(){
         
        $this->data['bunch'] = $this->bunchmodel->get_bunch(); 
        $this->data['title'] = "Add Fiber";
        $this->data['template'] = "fiber/addform";
        $this->load->view('layout/index',$this->data);

    }

    public function deadfiber(){

        $this->data['data'] = $this->fibermodel->get_fiber(array('dead_fiber'=>'dead_fiber'));
        $this->data['title'] = "Dead Fiber";
        $this->data['template'] = "fiber/deadfiber";
        $this->load->view('layout/index',$this->data);
    }
   
    public function insert(){
           
           
	   if(isset($_POST['submit'])){
		
				
		$bunch = $this->fibermodel->get_fiber(array('drum_no'=>$_POST['drum_no']));
		if(!empty($bunch)){
			
			 redirect(base_url().'fiber');
		}		 
		
		$data =  array('bunch_id'=>$_POST['bunch'],'drum_no'=>$_POST['drum_no'],'brand_name'=>$_POST['brand_name'],'total_length'=>$_POST['total_length'],'available_length'=>$_POST['total_length']);
		
		$this->db->insert('fiber',$data);
		redirect(base_url().'fiber');

		}
      
       
    }
	

    public function edit($id){         
         
        $this->data['title'] = "Edit Fiber";
		$this->data['bunch'] = $this->bunchmodel->get_bunch(); 
		$data = $this->fibermodel->get_fiber(array('id'=>$id));       
       
        if(empty($data)){

            redirect(base_url().'fiber');  
        }
       	
        $this->data['data'] =  $data;		
        $this->data['template'] = "fiber/edit";
        $this->load->view('layout/index',$this->data);
    }

    public function update(){
       
          
    	  $data = array('bunch_id'=>$_POST['bunch'],'drum_no'=>$_POST['drum_no'],'brand_name'=>$_POST['brand_name'],'total_length'=>$_POST['total_length'],'available_length'=>$_POST['total_length']);
          $this->fibermodel->update($_POST['id'],$data);  

          //get all the connection associated wit that fiber
          $fiber_conn = $this->fiberconnectionmodel->get_connection(array('fiber_id'=>$_POST['id']));
          
          
          foreach($fiber_conn as $conn){
              
              //delete all the connection core with that fiber
              $this->db->delete('connection_core', array('connection_id'=>$conn->id));
              
              //update all the connection_core_id of the client
              $this->db->where('connection_id',$conn->id);
              $this->db->update('client_fiber_connection',array('connection1_core_id'=> 0,'connection2_core_id'=> 0));

              //update all the connection_core_id of the master
              $this->db->where('connection_id',$conn->id);
              $this->db->update('master_fiber_connection',array('connection1_core_id'=> 0,'connection2_core_id'=> 0));

               //update all the connection_core_id of the master
              $this->db->where('connection_id',$conn->id);
              $this->db->update('pod_fiber_connection',array('connection1_core_id'=> 0,'connection2_core_id'=> 0));
              
               //update all the connection_core_id of the splitter
              $this->db->where('connection_id',$conn->id);
              $this->db->update('splitter_connection',array('core_id'=> 0));
              
              
              
              //get the number of cores from the bunch id
              $bunch_color = $this->bunchmodel->get_bunch_color(array('bunch_id'=>$_POST['bunch']));
              //add the new connection core

              foreach($bunch_color as $row){

                    $data =  array('flag'=> 0,'connection_id'=>$conn->id,'core_id'=>$row->id);
                    $this->db->insert('connection_core',$data);
              }

          }
          redirect(base_url().'fiber');
       
    }

	/*
    public function delete($id){
          
    	    
         $this->db->delete('fiber',array('id'=>$id));        
         redirect(base_url().'fiber');
         
    }*/

    

   }

 ?>