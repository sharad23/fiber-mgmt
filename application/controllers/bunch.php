<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bunch extends CI_Controller {

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
        $this->load->model('colormodel');
        $this->data['page_title'] = "Bunch";  
        
    }

    public function index(){

        $this->data['title'] = "Bunch";
        $this->data['data'] = $this->bunchmodel->get_bunch();
        $this->data['template'] = 'bunch/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
        $this->data['colors'] = $this->colormodel->get_color(); 
        $this->data['title'] = "Add Bunch";
        $this->data['template'] = "bunch/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){
            
           
           if(isset($_POST['core'])){
            
            
            
            $bunch = $this->bunchmodel->get_bunch(array('core'=>$_POST['core']));
            if(!empty($bunch)){
                
                 redirect(base_url().'bunch');
            }
            $data =  array('core'=>$_POST['core'],'date'=>time());
            $this->db->insert('bunch',$data);
            $bunch_id = $this->db->insert_id();
            for($i = 0; $i < count($_POST['color']); $i++){

                 $bunch_color =  array('color_id'=>$_POST['color'][$i],'bunch_id'=>$bunch_id);
                 $this->db->insert('bunch-color',$bunch_color);
            }

            redirect(base_url().'bunch');

        }
      
       
    }

    public function delete($id){
          
    	    
         $this->db->delete('bunch',array('id'=>$id));
         $this->db->delete('bunch-color',array('bunch_id'=>$id));
         redirect(base_url().'bunch');
         
    }

    public function edit($id){
         
        $this->data['colors'] = $this->colormodel->get_color();  
        $this->data['title'] = "Edit bunch";
        $data = $this->bunchmodel->get_bunch(array('id'=>$id));
       
        if(empty($data)){

            redirect(base_url().'bunch');  
        }
        $data[0]->bunch_core = $this->bunchmodel->get_bunch_color(array('bunch_id'=>$id));
        $this->data['data'] =  $data;
        $this->data['template'] = "bunch/edit";
        $this->load->view('layout/index',$this->data);
    }                                                                                                                                                                                                                                          

    public function update(){
       

    	  $data = array('core'=>$_POST['core'],'date'=>time());
          $this->bunchmodel->update($_POST['id'],$data);
          for($i = 0; $i < count($_POST['color']); $i++){

                 $bunch_color =  array('color_id'=>$_POST['color'][$i]);
                 $this->bunchmodel->update_bunch_color($_POST['bunch_color_id'][$i],$bunch_color);
          }

    	  
          redirect(base_url().'bunch');
       
    }

    public function show_color($bunch_id){
          
          $this->data['colors'] = $this->colormodel->get_color(); 
          $this->data['data'] = $this->bunchmodel->get_bunch_color(array('bunch_id'=>$bunch_id));
          $this->data['template'] = "bunch/show_color";
          $this->data['title'] = "Bunch Color";
          
          $this->load->view('layout/index',$this->data);


    }

    

   }

 ?>