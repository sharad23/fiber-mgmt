<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller {

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
        $this->load->model('splittermodel');
        $this->load->model('noncustomermodel');
        $this->load->model('fiberconnectionmodel');
        $this->data['page_title'] = "Client";  
        
    }

    public function index(){

        $this->data['title'] = "Client";
        $this->data['data'] = $this->clientmodel->get_client();
        $this->data['template'] = 'client/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
         
        $this->data['title'] = "Add Client";
        $this->data['template'] = "client/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){
            
           
       
        $poddata = array('location'=>$_POST['device_location'],'device'=>$_POST['device'],'port'=>$_POST['port']);
        $this->db->insert('pod',$poddata);
        $pod_id = $this->db->insert_id();

        $clientdata= array('name'=>$_POST['name'],
                            'location'=>$_POST['location'],
                            'longitude'=>$_POST['longitude'],
                            'latittude'=>$_POST['lattitude'],
                            'type'=>$_POST['type'],
                            'service_type'=>$_POST['service_type'],
                            'core_type'=>$_POST['core_type'],
                            'pod_id'=>$pod_id,
                            'date'=>time());
        $this->db->insert('client',$clientdata);
        $client_id = $this->db->insert_id();

        if($_POST['service_type'] == 2){

             $this->splittermodel->update_splitter_output($_POST['splitter_output_id'],array('output_client_id' => $client_id));
        }



        //connection from switch to client
        for($i=0; $i < count($_POST['conn_id']);$i++){

              $end_enclosure = explode('/',$_POST['end_enclosure'][$i]);  //added
              
              $conndata = array('connection_id'=>$_POST['conn_id'][$i],
                                'client_id'=>$client_id,
                                'order'=> $i+1,
                                'start_point_id' => $_POST['start_enclosure'][$i],  /* added */
                                'end_point_id' => $end_enclosure[0],                //added 
                                'connection1_core_id'=>$_POST['core_color1'][$i],   
                                'connection2_core_id'=>$_POST['core_color2'][$i]);

              $this->db->insert('client_fiber_connection',$conndata);

              $coredata = array('flag'=>1);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color1'][$i],$coredata);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color2'][$i],$coredata);


        

        }

        redirect(base_url().'client');

       
       
    }

    public function details($id){

          $data =  $this->clientmodel->get_client(array('id' => $id));
          if($data[0]->service_type == 2){

            $data[0]->splitter_info = $this->splittermodel->get_splitter_output(array('output_client_id' => $id));

          }
          $data[0]->connection_info = $this->clientmodel->get_client_connection(array('client_id'=>$id));
        
          $this->data['data'] = $data;
          $this->data['title'] = 'Client Information';
	        $this->data['template'] = 'client/client_detail';
	        $this->load->view('layout/index',$this->data);
    }

    public function delete($id){
          
    	    $client_info = $this->clientmodel->get_client(array('id'=>$id));
          $data =  $this->clientmodel->get_client_connection(array('client_id' => $id));
          $this->db->delete('client',array('id' => $id));
          
          foreach($data as $row){

               $this->db->delete('client_fiber_connection',array('id' =>$row->id));
               $this->fiberconnectionmodel->update_connection_core($row->connection1_core_id,array('flag' => 0));
               $this->fiberconnectionmodel->update_connection_core($row->connection2_core_id,array('flag' => 0));
          }

          



          //keep logs of the client
          $this->keep_logs($client_info , $data);
         
    }

     public function keep_logs($client_info,$client_conn_info){

          
          $client_log = array('name'=>$client_info[0]->name,'location'=>$client_info[0]->location,'core'=>$client_info[0]->core_type,'added_date'=>$client_info[0]->date,'terminated_date'=>time()); 
          if($client_info[0]->service_type == 1){

               $client_log['service'] = "Normal";
               $client_log['device_name'] = $client_info[0]->device_name;
               $client_log['device_location'] = $client_info[0]->device_location;
               $client_log['device_port'] = $client_info[0]->device_port;

          }
          elseif($client_info[0]->service_type == 2){
                
               $splitter_info = $this->splittermodel->get_splitter_output(array('output_client_id' => $client_info[0]->id));
               //if the src is splitter then empty that splitter output also
               $this->splittermodel->update_splitter_output($splitter_info[0]->id,array('output_client_id' => 0));
               $client_log['service'] = "FTTH";
               $client_log['device_name'] = $splitter_info[0]->org_name;
               $client_log['device_location'] = $splitter_info[0]->org_location;
               $client_log['device_port'] = $splitter_info[0]->output_no;


          }
          elseif($client_info[0]->service_type == 0){
              
              $client_log['service'] = "Dark";
               
          }

          $this->db->insert('log_client',$client_log);
          $client_id = $this->db->insert_id();

          foreach($client_conn_info as $row){

                $log_info_data = array('start_location'=>$row->start_location,'end_location'=>$row->end_location,'start_enclosure'=>$row->start_enclosure,'end_enclosure'=>$row->end_enclosure,'start_longitude'=>$row->start_longitude,'start_latitude'=>$row->start_lattitude,'end_longitude'=>$row->end_longitude,'end_latitude'=>$row->end_lattitude,'core_color1'=>$row->color1,'core_color2'=>$row->color2,'log_client_id'=>$client_id);
                $this->db->insert('log_client_connection',$log_info_data);
          }


    }

    public function edit($id){
         

        $data =  $this->clientmodel->get_client(array('id' => $id));
        if($data[0]->service_type == 2){

            $data[0]->splitter_info = $this->splittermodel->get_splitter_output(array('output_client_id' => $id));

        }

        $data[0]->connection_info = $this->clientmodel->get_client_connection(array('client_id'=>$id));
        

        
        foreach($data[0]->connection_info as $row){

              
              //$row->end_enclosure_list = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->start_enclosure_id,'mode'=> 1));
              //added /
              $data1 = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->client_start_point,'mode'=> 1));
              $data2 = $this->fiberconnectionmodel->get_connection(array('end_enclosure'=>$row->client_start_point,'mode' => 1));
              $row->end_enclosure_list = array_merge($data1,$data2);
              //added /
              $row->avl_colors = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$row->connection_id,'flag'=> 0));
        }

        /*echo '<pre>';
        print_r($data);
        echo '</pre>';
        */
        
        $this->data['data'] = $data;
        
        $this->data['title'] = "Edit Client";
        $this->data['template'] = "client/edit";
        $this->load->view('layout/index',$this->data);
    }                                                                                                                                                                                                                                          

    public function update(){
       
        /* echo '<pre>';
         print_r($_POST);
         echo '</pre>';
         */
        // die();
         
         $pod_id = $this->update_pod();
         $this->update_client($pod_id);
         $this->update_client_conn(); //changes this function
         redirect(base_url()."client/details/".$_POST['id']);
    	 
    }

    public function update_pod(){

           $this->clientmodel->update_pod_info($_POST['pod_id'],array('location'=>$_POST['device_location'],'device'=>$_POST['device'],'port'=>$_POST['port']));
           //$this->db->insert('pod', array('location'=>$_POST['device_location'],'device'=>$_POST['device'],'port'=>$_POST['port']));
           //return  $this->db->insert_id();
           return $_POST['pod_id'];
    }
    public function update_client($pod_id){

          $this->clientmodel->update($_POST['id'],array('name'=>$_POST['name'],'location'=>$_POST['location'],'service_type'=>$_POST['service_type'],'core_type'=>$_POST['core_type'],'type'=>$_POST['type'],'longitude'=>$_POST['longitude'],'latittude'=>$_POST['lattitude'],'pod_id'=>$pod_id));
    }

   
    
      public function update_client_conn(){
        

         $client_conn = $this->clientmodel->get_client_connection(array('client_id' => $_POST['id'] ));
         foreach($client_conn as &$row){

                  $row = (array)  $row;
         }
         
       
        
        
         for($i = 0 ;$i < count($_POST['conn_id']); $i++){
               
               $present = $this->check_multi_array($_POST['client_conn_id'][$i],$client_conn);
               if($present !== false){
                    
                    //set the core flag to 0
                    $this->fiberconnectionmodel->update_connection_core($client_conn[$present]['connection1_core_id'],array('flag' => 0));
                    $this->fiberconnectionmodel->update_connection_core($client_conn[$present]['connection2_core_id'],array('flag' => 0));
                    //change this
                    $conndata =  array('connection_id'=>$_POST['conn_id'][$i],'start_point_id'=>$_POST['start_enclosure'][$i], 'end_point_id'=>$_POST['end_enclosure'][$i],'connection1_core_id' =>$_POST['core_color1'][$i],'connection2_core_id'=>$_POST['core_color2'][$i],'order'=>$i+1);
                    $this->clientmodel->update_client_connection($_POST['client_conn_id'][$i],$conndata);
                    $this->pop($_POST['client_conn_id'][$i], $client_conn);
                    
                     
               
               }
               else{
                    
                    //change this
                    $conndata =  array('client_id'=>$_POST['id'],'connection_id'=>$_POST['conn_id'][$i],'start_point_id'=>$_POST['start_enclosure'][$i],'end_point_id'=>$_POST['end_enclosure'][$i],'connection1_core_id'=>$_POST['core_color1'][$i],'connection2_core_id'=>$_POST['core_color2'][$i],'order'=>$i+1);
                    $this->db->insert('client_fiber_connection',$conndata);
                    
               }

                 $coredata =  array('flag' => 1);
                 $this->fiberconnectionmodel->update_connection_core($_POST['core_color1'][$i],$coredata);
                 $this->fiberconnectionmodel->update_connection_core($_POST['core_color2'][$i],$coredata);
                
         }
        
         

         foreach($client_conn as $key => $row){

               $this->db->delete('client_fiber_connection',array('id' => $row['id']));
               $this->fiberconnectionmodel->update_connection_core($row['connection1_core_id'],array('flag' => 0));
               $this->fiberconnectionmodel->update_connection_core($row['connection2_core_id'],array('flag' => 0));
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

    public function clientgraph(){

         $client =  $this->clientmodel->get_client();
         foreach($client as $row){

            $row->connection_info = $this->clientmodel->get_client_connection(array('client_id'=>$row->id));
            
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
                 $childrow->masterinfo = $this->mastermodel->get_client_connection(array('connection1_core_id'=>$childrow->id));
                if(!empty($childrow->masterinfo)){
                    
                      $childrow->masterinfo[0]->master_name = $this->mastermodel->get_client(array('id'=> $childrow->masterinfo[0]->master_id));
                }
                

            }
         }

        
         
         $this->data['client'] = $client;
         $this->data['data'] = $data;
        /* echo '<pre>';
         print_r($data);
         echo '</pre>';

         die();*/
         $this->data['title'] = "Client Graph";
         $this->data['template'] = 'client/clientgraph';
         $this->load->view('layout/index',$this->data);


    }

    public function test(){

          echo json_encode(array('id'=>'1','name'=>'sharad','conn'=>array(array('source'=>23.231,'dest.'=>56.56),array('source'=>23.231,'dest.'=>56.56))));
    }

   





       


    

   }

 ?>