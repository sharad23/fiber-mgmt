<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiberconnection extends CI_Controller {

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

        $this->load->model('fiberconnectionmodel');
        $this->load->model('mastermodel');
        $this->load->model('fibermodel');
        $this->load->model('bunchmodel');
        $this->load->model('clientmodel');
        $this->load->model('noncustomermodel');
        $this->load->model('splittermodel');
        $this->data['page_title'] = "Fiber Connections";  
        
    }

    public function index(){

        $this->data['title'] = "Connections";
        $this->data['data'] = $this->fiberconnectionmodel->get_connection(array('order'=>'asc','order_by'=>'id','mode'=> 1));
        $this->data['template'] = 'fiber_connection/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
        $this->data['fiber'] = $this->fibermodel->get_fiber(array('live_fiber'=>1));
        $this->data['title'] = "Add Connections";
        $this->data['template'] = "fiber_connection/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){
        

        if(isset($_POST['fiber_id'])){
            
            $this->convert_to_lower();
            $start_enclosure_id = $this->check_enclosure(0);
            $end_enclosure_id  =  $this->check_enclosure(1);
            $length =   $this->calculate_length();
            $conn_id = $this->insert_to_conn_table($start_enclosure_id,$end_enclosure_id,$length);
            $fiber = $this->update_fiber_info($length);
            $this->generate_core_of_connection($fiber,$conn_id);
			      redirect(base_url().'fiberconnection');
 
        }
       
    }

    public function details($id){
        
            $data = $this->fiberconnectionmodel->get_connection(array('id'=>$id));
            //$data[0]->core_info = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$id));
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
                //add this code manoj
                $childrow->masterinfo = $this->mastermodel->get_client_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->masterinfo)){
                    
                      $childrow->masterinfo[0]->master_name = $this->mastermodel->get_client(array('id'=> $childrow->masterinfo[0]->master_id));
                }
                //till here
            }
            
            }
            /*echo '<pre>';
            print_r($data);
            echo '</pre>';
            die();
            */
            $this->data['data'] = $data;
			      $this->data['title'] = "Fiber Detail";
        	  $this->data['template'] = "fiber_connection/fiber_detail";
			      $this->load->view('layout/index',$this->data);
    }

    public function disable($id){
          
    	   //check if all the cores are vacant or not
         $data =  $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$id));
         foreach($data as $row){

              if($row->flag == 1){
                   
                   $flag = 1;
                   break;
              }
         }
         if(!isset($flag)){
             
             $updatedata =  array('mode'=> 0);
             $this->fiberconnectionmodel->update($id,$updatedata);
         
         }
        redirect(base_url().'fiberconnection');
         
    }



    public function convert_to_lower(){
         
         /*foreach($data as $row){
             
             if(is_array($row)){
                  
                  $this->convert_to_lower($row);
             } 
             else{

                $test[] = strtolower($row);
                //echo $row." ";

             }

         }

         return $test;
         */
         $_POST['objective'] =  strtolower($_POST['objective']);
         $_POST['enclosure'][0] = strtolower( $_POST['enclosure'][0]);
         $_POST['enclosure'][1] = strtolower( $_POST['enclosure'][1]);
         $_POST['location'][0] = strtolower( $_POST['location'][0]);
         $_POST['location'][1] = strtolower( $_POST['location'][1]);

    }

    public function check_enclosure($point_no){

          $data = $this->fiberconnectionmodel->get_enclosure(array('name'=>$_POST['enclosure'][$point_no]));
          if(empty($data)){

               $pointdata =  array('name'=>$_POST['enclosure'][$point_no],'location'=>$_POST['location'][$point_no],'longitude'=>$_POST['longitude'][$point_no],
                              'lattitude'=>$_POST['lattitude'][$point_no]);
               $this->db->insert('enclosure',$pointdata);
               $enclosure_id = $this->db->insert_id();
          }
          else{

               $enclosure_id = $data[0]->id;
          }

          return $enclosure_id;

    }

    public function calculate_length(){

        $length = $_POST['point'][1] - $_POST['point'][0];
        return $length;
    }

    public function insert_to_conn_table($start_enclosure_id,$end_enclosure_id,$length){

       $conndata = array('fiber_id'=>$_POST['fiber_id'],'objective'=>$_POST['objective'],'start_enclosure'=>$start_enclosure_id,
                          'end_enclosure'=>$end_enclosure_id,'length'=>$length,'start_point'=>$_POST['point'][0],'end_point'=>$_POST['point'][1],'date'=>time());
       $this->db->insert('fiber_connection',$conndata);
       $conn_id = $this->db->insert_id();
       return $conn_id;
    
    }

    public function update_fiber_info($length){

       $fiber = $this->fibermodel->get_fiber(array('id'=>$_POST['fiber_id']));
       $avl_length = $fiber[0]->available_length  - $length;
       $this->fibermodel->update($_POST['fiber_id'],array('available_length'=>$avl_length));
       return $fiber;

    }

    public function generate_core_of_connection($fiber=array(),$conn_id){
      
        $cores = $this->bunchmodel->get_bunch_color(array('bunch_id'=>$fiber[0]->bunch_id));
        foreach($cores  as $row){

               $coredata =  array('connection_id'=>$conn_id,'core_id'=>$row->id,'flag'=> 0);
               $this->db->insert('connection_core',$coredata);

        }


    }

    public function ajax_enclosure($id){

      $data =  $this->fiberconnectionmodel->get_enclosure(array('id'=>$id));
      echo json_encode($data);

    }

    public function ajax_keyword_enclosure($keyword){
      
      $keyword = strtolower($keyword);
      $data =  $this->fiberconnectionmodel->get_enclosure(array('keyword'=>$keyword));
      echo json_encode($data);
    }

    public function fiberbreak($id=""){
            
            if(isset($_POST['submit'])) {
                  
                
                 //update the connection of conn_id
                  $enclosure_id = $this->add_break_enclosure();
                  $this->update_connection($enclosure_id);
                  $new_conn_id = $this->add_new_connection($enclosure_id);
                  
                  //get all the client with conn_id[0]
                  $this->update_client_connection($new_conn_id,$enclosure_id);
                  $this->update_pod_connection($new_conn_id,$enclosure_id);
                  $this->update_splitter_connection($new_conn_id,$enclosure_id);
                  $this->update_master_connection($new_conn_id,$enclosure_id);
                  redirect(base_url()."fiberconnection");
                 
                  
               
            }
            else{

              
                $data = $this->fiberconnectionmodel->get_connection(array('id'=>$id));
                $data[0]->core_info = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$id));
                $fiber =  $this->fibermodel->get_fiber();
                $this->data['data'] = $data;
                $this->data['fiber'] = $fiber;
                $this->data['title'] = "Breaking A Fiber";
                $this->data['template'] = "fiber_connection/break";
                $this->load->view('layout/index',$this->data);
            }
    }


    public function add_break_enclosure(){

          $enclosuredata = array('name'=>$_POST['enclosure'][1],'location'=>$_POST['location'][1],'longitude'=>$_POST['longitude'][1],'lattitude'=>$_POST['latitude'][1]); 
          $this->db->insert('enclosure',$enclosuredata);
          return $this->db->insert_id();
    
    }
    
    public function update_connection($enclosure_id){
          
          $length =  $_POST['point'][1] - $_POST['point'][0]; 
          $data   =  array('end_enclosure'=>$enclosure_id, 'end_point'=> $_POST['point'][1],'objective'=>$_POST['objective'][0],'length'=>$length);
          $this->fiberconnectionmodel->update($_POST['conn_id'][0],$data);

    }
   
    public function add_new_connection($enclosure_id){
          
          $connection_array =  array();
          $length = $_POST['point'][3] - $_POST['point'][2];
          $end_enclosure_id = $this->fiberconnectionmodel->get_enclosure(array('name' => $_POST['enclosure'][3]));
          foreach($_POST['fiber_id'] as $row){
               
               $data = array('start_enclosure' => $enclosure_id, 'end_enclosure' => $end_enclosure_id[0]->id , 'start_point'=>$_POST['point'][2],'end_point'=>$_POST['point'][3],'fiber_id'=>$row,'length' => $length, 'date'=>time(),'objective'=>$_POST['objective'][1]); 
               $this->db->insert('fiber_connection', $data);
               $conn_id = $this->db->insert_id();
               //get the fiber info 
               $fiber = $this->fibermodel->get_fiber(array('id' => $row));
               $this->generate_core_of_connection($fiber , $conn_id);
               $connection_array[] = $conn_id; 
          }

          return $connection_array;
    }
   
    public function update_client_connection($new_conn_id,$enclosure_id){

            $connection = $this->clientmodel->get_client_connection(array('connection_id' => $_POST['conn_id'][0]));
            foreach($connection as $client_row){
                   
                  //get the before break connection info
                  $orginal_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$_POST['conn_id'][0]));
                  //get the new connection
                  $new_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$new_conn_id[0]));

                  if($orginal_conn[0]->start_enclosure == $client_row->start_point_id){  
                        
                        //update the end enclosure of that connection
                        $this->clientmodel->update_client_connection($client_row->id, array('end_point_id'=> $enclosure_id));

                        //get all the connections of that client 
                        $order = $client_row->order;
                        $client_full_conn_after_break = $this->clientmodel->get_client_connection(array('greater_than_order' => $order, 'client_id' =>$client_row->client_id)); 
                        foreach($client_full_conn_after_break as $row){
                             
                            $this->clientmodel->update_client_connection($row->id,array('order'=> $row->order + 1));
                        }
                        
                        //get the pervious conn id
                        //get connection core 1 and connection core 2 the connection with that partiular client
                        //get the 

                        //insert the new client connection
                        $data = array('client_id' => $client_row->client_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$new_conn[0]->end_enclosure);
                        $this->db->insert('client_fiber_connection' , $data);



                  }
                  else{
                      
                          //update the end enclosure of that connection
                        $this->clientmodel->update_client_connection($client_row->id,array('end_point_id'=>$enclosure_id));

                        //get all the connections of that client 
                        $order = $client_row->order;
                        $client_full_conn_after_break = $this->clientmodel->get_client_connection(array('greater_than_order' => $order, 'client_id' =>$client_row->client_id)); 
                        foreach($client_full_conn_after_break as $row){
                             
                           
                             $this->clientmodel->update_client_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('client_id' => $client_row->client_id,'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$orginal_conn[0]->start_enclosure);
                        $this->db->insert('client_fiber_connection' , $data);

                  }
                        

            }

    }

    

     public function update_splitter_connection($new_conn_id = array(),$enclosure_id){

            /*$connection = $this->splittermodel->get_splitter_connection(array('connection_id' => $_POST['conn_id'][0]));
            foreach($connection as $splitter_row){
                   

                  //get all the connections of that client 
                  $order = $splitter_row->order;
                  $splitter_full_conn_after_break = $this->splittermodel->get_splitter_connection(array('greater_than_order' => $order, 'splitter_id' =>$splitter_row->splitter_id)); 
                  foreach($splitter_full_conn_after_break as $row){
                       
                     
                       $this->splittermodel->update_splitter_connection($row->id , array('order'=> $row->order + 1));
                  }
                  
                  //insert the new_connection
                  $data = array('splitter_id' => $splitter_row->splitter_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1);
                  $this->db->insert('splitter_connection',$data);
                  

            }
            */
             $connection = $this->splittermodel->get_splitter_connection(array('connection_id' => $_POST['conn_id'][0]));
             foreach($connection as $splitter_row){
                   
                  //get the before break connection info
                  $orginal_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$_POST['conn_id'][0]));
                  //get the new connection
                  $new_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$new_conn_id[0]));

                  if($orginal_conn[0]->start_enclosure == $splitter_row->start_point_id){  
                        
                        //update the end enclosure of that connection
                        $this->splittermodel->update_splitter_connection($splitter_row->id, array('end_point_id'=> $enclosure_id));

                        //get all the connections of that client 
                        $order = $splitter_row->order;
                        $splitter_full_conn_after_break = $this->splittermodel->get_splitter_connection(array('greater_than_order' => $order, 'splitter_id' =>$splitter_row->splitter_id)); 
                        foreach($splitter_full_conn_after_break as $row){
                             
                           
                             $this->splittermodel->update_splitter_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('splitter_id' => $splitter_row->splitter_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$new_conn[0]->end_enclosure);
                        $this->db->insert('splitter_fiber_connection' , $data);

                   }
                   else{
                      
                          //update the end enclosure of that connection
                        $this->splittermodel->update_splitter_connection($splitter_row->id,array('end_point_id'=>$enclosure_id));

                        //get all the connections of that client 
                        $order = $splitter_row->order;
                        $splitter_full_conn_after_break = $this->splittermodel->get_splitter_connection(array('greater_than_order' => $order, 'splitter_id' =>$splitter_row->splitter_id)); 
                        foreach($splitter_full_conn_after_break as $row){
                             
                           
                             $this->splittermodel->update_splitter_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('splitter_id' => $splitter_row->splitter_id,'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$orginal_conn[0]->start_enclosure);
                        $this->db->insert('splitter_fiber_connection' , $data);

                   }
                        

            }


    }

     public function update_pod_connection($new_conn_id = array(),$enclosure_id){

            /*$connection = $this->noncustomermodel->get_pod_fiber_connection(array('connection_id' => $_POST['conn_id'][0]));
            foreach($connection as $pod_row){
                   

                  //get all the connections of that client 
                  $order = $pod_row->order;
                  $pod_full_conn_after_break = $this->noncustomermodel->get_pod_fiber_connection(array('greater_than_order' => $order, 'pod_join_id' =>$pod_row->pod_join_id)); 
                  foreach($pod_full_conn_after_break as $row){
                       
                     
                       $this->noncustomermodel->update_pod_connection($row->id , array('order'=> $row->order + 1));
                  }
                  
                  //insert the new_connection
                  $data = array('pod_join_id' => $pod_row->pod_join_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1);
                  $this->db->insert('pod_fiber_connection' , $data);
                  

            }*/

             $connection = $this->noncustomermodel->get_pod_fiber_connection(array('connection_id' => $_POST['conn_id'][0]));
             foreach($connection as $pod_row){
                   
                  //get the before break connection info
                  $orginal_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$_POST['conn_id'][0]));
                  //get the new connection
                  $new_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$new_conn_id[0]));

                  if($orginal_conn[0]->start_enclosure == $pod_row->start_point_id){  
                        
                        //update the end enclosure of that connection
                        $this->noncustomermodel->update_pod_connection($pod_row->id, array('end_point_id'=> $enclosure_id));

                        //get all the connections of that client 
                        $order = $pod_row->order;
                        $pod_full_conn_after_break = $this->noncustomermodel->get_pod_fiber_connection(array('greater_than_order' => $order, 'pod_join_id' =>$pod_row->pod_join_id)); 
                        foreach($pod_full_conn_after_break as $row){
                             
                           
                             $this->noncustomermodel->update_pod_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('pod_join_id' => $pod_row->pod_join_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$new_conn[0]->end_enclosure);
                        $this->db->insert('pod_fiber_connection' , $data);

                   }
                   else{
                      
                          //update the end enclosure of that connection
                        $this->noncustomermodel->update_pod_connection($pod_row->id,array('end_point_id'=>$enclosure_id));

                        //get all the connections of that client 
                        $order = $pod_row->order;
                        $pod_full_conn_after_break = $this->noncustomermodel->get_pod_fiber_connection(array('greater_than_order' => $order, 'pod_join_id' =>$pod_row->pod_join_id)); 
                        foreach($pod_full_conn_after_break as $row){
                             
                           
                             $this->noncustomermodel->update_pod_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('pod_join_id' => $pod_row->pod_join_id,'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$orginal_conn[0]->start_enclosure);
                        $this->db->insert('pod_fiber_connection' , $data);

                   }
                        

            }

    }

    public function update_master_connection($new_conn_id = array(),$enclosure_id){

            /*$connection = $this->mastermodel->get_client_connection(array('connection_id' => $_POST['conn_id'][0]));
            foreach($connection as $master_row){
                   

                  //get all the connections of that client 
                  $order = $master_row->order;
                  $master_full_conn_after_break = $this->mastermodel->get_client_connection(array('greater_than_order' => $order, 'master_id' =>$master_row->master_id)); 
                  foreach($master_full_conn_after_break as $row){
                       
                     
                       $this->mastermodel->update_client_connection($row->id , array('order'=> $row->order + 1));
                  }
                  
                  //insert the new_connection
                  $data = array('master_id' => $master_row->master_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1);
                  $this->db->insert('master_fiber_connection' , $data);
                  

            }*/

             $connection = $this->mastermodel->get_client_connection(array('connection_id' => $_POST['conn_id'][0]));
             foreach($connection as $master_row){
                   
                  //get the before break connection info
                  $orginal_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$_POST['conn_id'][0]));
                  //get the new connection
                  $new_conn = $this->fiberconnectionmodel->get_connection(array('id'=>$new_conn_id[0]));

                  if($orginal_conn[0]->start_enclosure == $master_row->start_point_id){  
                        
                        //update the end enclosure of that connection
                        $this->mastermodel->update_client_connection($master_row->id, array('end_point_id'=> $enclosure_id));

                        //get all the connections of that client 
                        $order = $master_row->order;
                        $master_full_conn_after_break = $this->mastermodel->get_client_connection(array('greater_than_order' => $order, 'master_id' =>$master_row->master_id)); 
                        foreach($master_full_conn_after_break as $row){
                             
                           
                             $this->mastermodel->update_client_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('master_id' => $master_row->master_id , 'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$new_conn[0]->end_enclosure);
                        $this->db->insert('master_fiber_connection' , $data);

                   }
                   else{
                      
                          //update the end enclosure of that connection
                        $this->mastermodel->update_client_connection($master_row->id,array('end_point_id'=>$enclosure_id));

                        //get all the connections of that client 
                        $order = $master_row->order;
                        $master_full_conn_after_break = $this->mastermodel->get_client_connection(array('greater_than_order' => $order, 'master_id' =>$master_row->master_id)); 
                        foreach($master_full_conn_after_break as $row){
                             
                           
                             $this->mastermodel->update_client_connection($row->id , array('order'=> $row->order + 1));
                        }
                        
                        //insert the new client connection
                        $data = array('master_id' => $master_row->master_id,'connection_id' => $new_conn_id[0], 'order' => $order + 1,'start_point_id'=>$enclosure_id,'end_point_id'=>$orginal_conn[0]->start_enclosure);
                        $this->db->insert('master_fiber_connection' , $data);

                   }
                        

            }

    }



    public function networkgraph(){

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
                //add this code manoj
                $childrow->masterinfo = $this->mastermodel->get_client_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->masterinfo)){
                    
                      $childrow->masterinfo[0]->master_name = $this->mastermodel->get_client(array('id'=> $childrow->masterinfo[0]->master_id));
                }
                //till here
            }


         
         }


         
        
         $this->data['data'] = $data;
         $this->data['title'] = "Network Graph";
         $this->data['template'] = 'fiber_connection/networkgraph';
         $this->load->view('layout/index',$this->data);


    }

    public function ajax_check_fiber_length($fiberid,$fiberlength){
         
          $fiber = $this->fibermodel->get_fiber(array('id'=>$fiberid));
          $avl_length = $fiber[0]->available_length;
          if($fiberlength > $avl_length){
              
               echo 0;
          }
          else{

               echo 1;
          } 

    }

   

   

   


   }

 ?>