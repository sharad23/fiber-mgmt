<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Splitter extends CI_Controller {

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
        $this->load->model('mastermodel');
        $this->load->model('clientmodel');
        $this->load->model('noncustomermodel');
        $this->load->model('splittermodel');
        $this->load->model('fiberconnectionmodel');
        $this->data['page_title'] = "Splitter";  
        
    }

    public function index(){

        $this->data['title'] = "Splitter";
        $this->data['data'] = $this->splittermodel->get_splitter();
        $this->data['template'] = 'splitter/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
         
        $this->data['title'] = "Add splitter";
        $this->data['template'] = "splitter/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){
             
        
        if($_POST['type'] == 1){

            $oltdata = array('name'=>$_POST['olt_name'],'port'=>$_POST['olt_port']);
            $this->db->insert('olt',$oltdata);
            $olt_id = $this->db->insert_id();
        }
        else{

            $olt_id = "";
        }
       
      

        $splitterdata = array( 'name'=>$_POST['name'],
                               'location'=>$_POST['location'],
                               'longitude'=>$_POST['longitude'],
                               'latittude'=>$_POST['lattitude'],
                               'type'=>$_POST['type'],
                               'olt_id'=>$olt_id,
                               'date'=>time());
        $this->db->insert('splitter',$splitterdata);
        $splitter_id = $this->db->insert_id();

        for($i = 1; $i <= $_POST['output_ratio'];$i++){
            
            $splitter_output =  array('output_no'=>$i,'splitter_id'=>$splitter_id);
            $this->db->insert('splitter_output',$splitter_output);
        }

        //connection from switch to client
        for($i=0; $i < count($_POST['conn_id']);$i++){
              
              $end_enclosure = explode('/',$_POST['end_enclosure'][$i]);
              $conndata = array('connection_id'=>$_POST['conn_id'][$i],
                                'splitter_id'=>$splitter_id,
                                'order'=> $i+1,
                                'core_id'=> $_POST['core_color1'][$i],
                                'start_point_id' => $_POST['start_enclosure'][$i],
                                'end_point_id' => $end_enclosure[0]
                               );

              $this->db->insert('splitter_connection',$conndata);

              $coredata = array('flag' => 1);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color1'][$i],$coredata);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color2'][$i],$coredata);
        
        }

        if($_POST['type'] == 0){

            $output =  array('output_splitter_id' => $splitter_id);
            $this->splittermodel->update_splitter_output($_POST['splitter_output_id'],$output);
        }

        redirect(base_url().'splitter');

       
       
    }

    public function details($id){

          $data =  $this->splittermodel->get_splitter(array('id' => $id));
          if($data[0]->type == 0){

              //get the parent splitter
              $data[0]->parent_splitter = $this->splittermodel->get_splitter_output(array('output_splitter_id'=>$data[0]->id));
          }
          $data[0]->connection_info = $this->splittermodel->get_splitter_connection(array('splitter_id'=>$id));
          $data[0]->outputs = $this->splittermodel->get_splitter_output(array('splitter_id' => $id));
          foreach($data[0]->outputs as $row){
               
               if($row->output_client_id !=  0){
                  
                    $row->output_connection_info = $this->clientmodel->get_client_connection(array( 'client_id' => $row->output_client_id));
               
               }
               elseif($row->output_splitter_id != 0){

                  
                  $row->output_connection_info = $this->splittermodel->get_splitter_connection(array( 'splitter_id' => $row->output_splitter_id));
               }
               else{

               }
               
               
          }
          
         
          /*echo '<pre>';
          print_r($data);
          echo '</pre>';
          die();
          */
          $this->data['data'] = $data;
          $this->data['title'] = 'splitter Information';
	        $this->data['template'] = 'splitter/splitter_detail';
	        $this->load->view('layout/index',$this->data);
    }

    public function delete($id){
          
    	    //check if all its ouptup is empty, if empty then only delete it
          $splitter_output =  $this->splittermodel->get_splitter_output(array('splitter_id'=> $id));
          $empty_splitter_output = $data =  $this->splittermodel->get_splitter_output(array('splitter_id'=> $id,'output_splitter_id'=> 0,'output_client_id'=>0));
          if(count($splitter_output) != count($empty_splitter_output)){  redirect(base_url().'splitter'); }
          $this->db->delete('splitter',array('id' => $id));
          $data =  $this->splittermodel->get_splitter_connection(array('splitter_id' => $id));
          foreach($data as $row){

               $this->db->delete('splitter_connection',array('id' =>$row->id));
               $this->fiberconnectionmodel->update_connection_core($row->core_id,array('flag' => 0));
               
          }
          
          $this->db->delete('splitter_output',array('splitter_id' => $id));
          $this->db->where('output_splitter_id',$id);
          $this->db->update('splitter_output',array('output_splitter_id' => 0));

         




         
    }

    public function edit($id){
         
        $data =  $this->splittermodel->get_splitter(array('id' => $id));
        $data[0]->connection_info = $this->splittermodel->get_splitter_connection(array('splitter_id'=>$id));
        foreach($data[0]->connection_info as $row){

              
              //$row->end_enclosure_list = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->start_enclosure_id,'mode'=> 1));
              $data1 = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->client_start_point,'mode'=> 1));
              $data2 = $this->fiberconnectionmodel->get_connection(array('end_enclosure'=>$row->client_start_point,'mode' => 1));
              $row->end_enclosure_list = array_merge($data1,$data2);
              $row->avl_colors = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$row->connection_id,'flag'=> 0));
        }

        $this->data['data'] = $data;
        $this->data['title'] = "Edit splitter";
        $this->data['template'] = "splitter/edit";
        $this->load->view('layout/index',$this->data);
    }                                                                                                                                                                                                                                          

    public function update(){
       
         /*echo '<pre>';
         print_r($_POST);
         echo '</pre>';
         die();
         */
         $this->update_olt();
         $this->update_splitter();
         $this->update_splitter_conn();
         redirect(base_url()."splitter/details/".$_POST['id']);
    	 
    }

    public function update_olt(){

           $this->splittermodel->update_olt_info($_POST['olt_id'],array('name'=>$_POST['name'],'port'=>$_POST['port']));

    }
    public function update_splitter(){

          $this->splittermodel->update($_POST['id'], array('name'=>$_POST['name'],'location'=>$_POST['location'],'longitude'=>$_POST['longitude'],'latittude'=>$_POST['lattitude']));
    }

   
    
      public function update_splitter_conn(){
        

         $splitter_conn = $this->splittermodel->get_splitter_connection(array('splitter_id' => $_POST['id'] ));
         foreach($splitter_conn as &$row){

                  $row = (array)  $row;
         }
         
       
        
        
         for($i = 0 ;$i < count($_POST['conn_id']); $i++){
               
               $present = $this->check_multi_array($_POST['splitter_conn_id'][$i],$splitter_conn);
               if($present !== false){
                    
                    //set the core flag to 0
                    $this->fiberconnectionmodel->update_connection_core($splitter_conn[$present]['core_id'],array('flag' => 0));
                    $conndata =  array('connection_id'=>$_POST['conn_id'][$i],'core_id' =>$_POST['core_color'][$i],'order'=>$i+1,'start_point_id'=>$_POST['start_enclosure'][$i],'end_point_id'=>$_POST['end_enclosure'][$i]);
                    $this->splittermodel->update_splitter_connection($_POST['splitter_conn_id'][$i],$conndata);
                    $this->pop($_POST['splitter_conn_id'][$i], $splitter_conn);
                    
               }
               else{

                    $conndata =  array('splitter_id'=>$_POST['id'],'connection_id'=>$_POST['conn_id'][$i],'core_id'=>$_POST['core_color'][$i],'order'=>$i+1,'start_point_id'=>$_POST['start_enclosure'][$i],'end_point_id'=>$_POST['end_enclosure'][$i]);
                    $this->db->insert('splitter_connection',$conndata);
                    
               }

                 $coredata =  array('flag' => 1);
                 $this->fiberconnectionmodel->update_connection_core($_POST['core_color'][$i],$coredata);
                 
                
         }
        
         

         foreach($splitter_conn as $key => $row){

               $this->db->delete('splitter_connection', array('id' => $row['id']));
               $this->fiberconnectionmodel->update_connection_core($row['core_id'],array('flag' => 0));
              
         }
         
    }

    public function pop_array($element,&$array){

        if(($key = array_search($element, $array)) !== false) {
            unset($array[$key]);
        }

    }

    public function ajax_get_location($keyword){
         
         $keyword = strtolower($keyword);
         $data = $this->fiberconnectionmodel->get_enclosure(array('like_location'=>$keyword));
         echo json_encode($data);
    }

    public function ajax_get_enclosure($keyword="naxal"){

         $keyword = strtolower($keyword);
         $data = $this->fiberconnectionmodel->get_enclosure(array('location'=>$keyword));
         echo json_encode($data);
    }

    public function ajax_get_connected_enclosure($enclosureid){
         
         $data1 = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$enclosureid,'mode'=> 1));
         $data2 = $this->fiberconnectionmodel->get_connection(array('end_enclosure'=>$enclosureid,'mode' => 1));
         $data = array_merge($data1,$data2);
         echo json_encode($data);

    }

    public function ajax_get_connction_core($conn_id = "16"){
         
         $data =  $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$conn_id,'flag'=> 0));
         echo json_encode($data);

    }

    public function ajax_get_L1_splitter(){
        
        $data =  $this->splittermodel->get_splitter(array('type'=> 1));
        echo json_encode($data);

    }

     public function ajax_get_splitter($type){
        
        $data =  $this->splittermodel->get_splitter(array('type'=> $type));
        echo json_encode($data);

    }
    
     public function ajax_get_splitter_output($id){
        
        $data =  $this->splittermodel->get_splitter_output(array('splitter_id'=> $id,'output_splitter_id'=> 0,'output_client_id'=>0));
        echo json_encode($data);

    }

    public function ajax_get_splitter_connection($id){

        
        $data =  $this->splittermodel->get_splitter_connection(array('splitter_id'=> $id ));
        echo json_encode($data);

    }
   

   

    public function check_multi_array($id=2,$array=array(array('id'=> 2 ,'name'=>'sharad'),array('id'=> 2,'name'=>'sharad'))){

          foreach($array as $key => $first_array){

                  if(array_search($id , $first_array) == "id"){

                        return $key;
                  }
          
          }
          
          return false;
        


    }

    public function pop($id,&$array){
        
           foreach($array as $key => $first_array){

                  if(array_search($id , $first_array) == "id"){

                        unset($array[$key]);
                  }
          
           }
      



    }

    public function splittergraph(){

         $splitter =  $this->splittermodel->get_splitter();
         foreach($splitter as $row){

            $row->connection_info = $this->splittermodel->get_splitter_connection(array('splitter_id'=>$row->id));
            
         }
         
         $data =  $this->fiberconnectionmodel->get_connection(array('order_by'=>'id','order'=>'asc'));
         foreach($data as $row){

            $row->core_info = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$row->id));
            foreach($row->core_info as $childrow){

                $childrow->clientinfo = $this->clientmodel->get_client_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->clientinfo)){
                    $childrow->clientinfo[0]->client_name = $this->clientmodel->get_client(array('id'=> $childrow->clientinfo[0]->client_id));
                }

                $childrow->podinfo = $this->noncustomermodel->get_pod_fiber_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->podinfo)){
                    
                      $childrow->podinfo[0]->pod_name = $this->noncustomermodel->get_podconn(array('id'=> $childrow->podinfo[0]->pod_join_id));
                }

                $childrow->splitterinfo = $this->splittermodel->get_splitter_connection(array('core_id'=>$childrow->id));
                if(!empty($childrow->splitterinfo)){
                    
                      $childrow->splitterinfo[0]->splitter_name = $this->splittermodel->get_splitter(array('id'=> $childrow->splitterinfo[0]->splitter_id));
                }
                //added by manoj
                $childrow->masterinfo = $this->mastermodel->get_client_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->masterinfo)){
                    
                      $childrow->masterinfo[0]->master_name = $this->mastermodel->get_client(array('id'=> $childrow->masterinfo[0]->master_id));
                }
                //till here
            }
         }
         
         $this->data['splitter'] = $splitter;
         $this->data['data'] = $data;
         $this->data['title'] = "splitter Graph";
         $this->data['template'] = 'splitter/splittergraph';
         $this->load->view('layout/index',$this->data);


    }

    public function test(){

       
           $data = $this->splittermodel->get_splitter_connection(array( 'splitter_id' => null ));
           echo '<pre>';
           print_r($data);
           echo '</pre>';


          //echo json_encode(array('id'=>'1','name'=>'sharad','conn'=>array(array('source'=>23.231,'dest.'=>56.56),array('source'=>23.231,'dest.'=>56.56))));
    }





       


    

   }

 ?>