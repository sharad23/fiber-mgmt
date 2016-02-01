<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noncustomer extends CI_Controller {

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
        $this->load->model('noncustomermodel');
        $this->load->model('splittermodel');
        $this->load->model('fiberconnectionmodel');
        $this->load->model('clientmodel');
        $this->data['page_title'] = "Pod Connection";  
        
    }

    public function index(){

        $this->data['title'] = "Pod Connection";
        $this->data['data'] = $this->noncustomermodel->get_podconn();
        $this->data['template'] = 'noncustomer/index';
        $this->load->view('layout/index',$this->data);
    }

    public function add(){
         
         
        $this->data['title'] = "Add Pod Connection";
        $this->data['template'] = "noncustomer/addform";
        $this->load->view('layout/index',$this->data);

    }
    public function insert(){
            
           
        
        $frompoddata = array('location'=>$_POST['device_location'][0],'device'=>$_POST['device'][0],'port'=>$_POST['port'][0]);
        $this->db->insert('pod',$frompoddata);
        $from_pod_id = $this->db->insert_id();

        $topoddata =  array('location'=>$_POST['device_location'][1],'device'=>$_POST['device'][1],'port'=>$_POST['port'][1]);
        $this->db->insert('pod',$topoddata);
        $to_pod_id = $this->db->insert_id();

        $podconndata= array( 'from_pod_id'=>$from_pod_id,
                             'to_pod_id'=>$to_pod_id,
                             'core_type'=>$_POST['core_type'],
                             'date'=>time());
        $this->db->insert('pod_connection',$podconndata);
        $pod_conn_id = $this->db->insert_id();

        //connection from switch to client
        for($i=0; $i < count($_POST['conn_id']);$i++){

				      $end_enclosure = explode('/',$_POST['end_enclosure'][$i]);  //added
              $conndata = array('connection_id'=>$_POST['conn_id'][$i],
                                'pod_join_id'=>$pod_conn_id,
                                'order'=> $i+1,
								                'start_point_id' => $_POST['start_enclosure'][$i],  /* added */
                                'end_point_id' => $end_enclosure[0],                //added 
                                'connection1_core_id'=>$_POST['core_color1'][$i],
                                'connection2_core_id'=>$_POST['core_color2'][$i]);

              $this->db->insert('pod_fiber_connection',$conndata);

              $coredata = array('flag'=>1);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color1'][$i],$coredata);
              $this->fiberconnectionmodel->update_connection_core($_POST['core_color2'][$i],$coredata);


        

        }

        redirect(base_url().'noncustomer');

       
       
    }

    public function details($id){

          $data =  $this->noncustomermodel->get_podconn(array('id' => $id));
          $data[0]->connection_info = $this->noncustomermodel->get_pod_fiber_connection(array('pod_join_id'=>$id));
          $this->data['data'] = $data;
		      $this->data['title'] = 'Client Information';
		      $this->data['template'] = 'noncustomer/client_detail';
          $this->load->view('layout/index',$this->data);
    }

    public function delete($id){
          
    	     
          $this->db->delete('pod_connection',array('id' => $id));
          $data =  $this->noncustomermodel->get_pod_fiber_connection(array('pod_join__id' => $id));
          foreach($data as $row){

               $this->db->delete('pod_fiber_connection',array('id' =>$row->id));
               $this->fiberconnectionmodel->update_connection_core($row->connection1_core_id,array('flag' => 0));
               $this->fiberconnectionmodel->update_connection_core($row->connection2_core_id,array('flag' => 0));
          }
         
    }

    public function edit($id){
         
        $data =  $this->noncustomermodel->get_podconn(array('id' => $id));
        $data[0]->connection_info = $this->noncustomermodel->get_pod_fiber_connection(array('pod_join_id'=>$id));
        foreach($data[0]->connection_info as $row){

              
              //$row->end_enclosure_list = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->start_enclosure_id,'mode'=> 1));
			   //added /
              $data1 = $this->fiberconnectionmodel->get_connection(array('start_enclosure'=>$row->client_start_point,'mode'=> 1));
              $data2 = $this->fiberconnectionmodel->get_connection(array('end_enclosure'=>$row->client_start_point,'mode' => 1));
              $row->end_enclosure_list = array_merge($data1,$data2);
              //added /
              $row->avl_colors = $this->fiberconnectionmodel->get_connection_core(array('connection_id'=>$row->connection_id,'flag'=> 0));
        }
        $this->data['data'] = $data;
        /*echo '<pre>';
        print_r($this->data);
        echo '</pre>';
        */

        //die();
        $this->data['title'] = "Edit Pod connection";
        $this->data['template'] = "noncustomer/edit";
        
        
        $this->load->view('layout/index',$this->data);
    }                                                                                                                                                                                                                                          

    public function update(){
       
         /*echo '<pre>';
         print_r($_POST);
         echo '</pre>';
         die();
         */
         $this->update_pod();
         $this->update_pod_conn();
         $this->update_pod_fiber_conn();
         redirect(base_url()."noncustomer/details/".$_POST['id']);
    	 
    }

    public function update_pod(){

           $this->noncustomermodel->update_pod_info($_POST['pod_id'][0],array('location'=>$_POST['device_location'][0],'device'=>$_POST['device'][0],'port'=>$_POST['port'][0]));
           $this->noncustomermodel->update_pod_info($_POST['pod_id'][1],array('location'=>$_POST['device_location'][1],'device'=>$_POST['device'][1],'port'=>$_POST['port'][1]));

    }
    public function update_pod_conn(){

          $this->noncustomermodel->update($_POST['id'],array('core_type'=>$_POST['core_type']));
    }

    public function update_pod_fiber_conn(){

         $pod_conn = $this->noncustomermodel->get_pod_fiber_connection(array('pod_join_id' => $_POST['id'] ));
         foreach($pod_conn as &$row){

                  $row = (array)  $row;
         }
         
       
        
        
         for($i = 0 ;$i < count($_POST['conn_id']); $i++){
               
               $present = $this->check_multi_array($_POST['client_conn_id'][$i],$pod_conn);
               if($present !== false){
                    
                    //set the core flag to 0
                    $this->fiberconnectionmodel->update_connection_core($pod_conn[$present]['connection1_core_id'],array('flag' => 0));
                    $this->fiberconnectionmodel->update_connection_core($pod_conn[$present]['connection2_core_id'],array('flag' => 0));
                   
                    $conndata =  array('connection_id'=>$_POST['conn_id'][$i],'start_point_id'=>$_POST['start_enclosure'][$i], 'end_point_id'=>$_POST['end_enclosure'][$i],'connection1_core_id' =>$_POST['core_color1'][$i],'connection2_core_id'=>$_POST['core_color2'][$i],'order'=>$i+1);
                    $this->noncustomermodel->update_pod_connection($_POST['client_conn_id'][$i],$conndata);
                    $this->pop($_POST['client_conn_id'][$i], $pod_conn);
                    
                     
               
               }
               else{

                    $conndata =  array('pod_join_id'=>$_POST['id'],'connection_id'=>$_POST['conn_id'][$i],'start_point_id'=>$_POST['start_enclosure'][$i], 'end_point_id'=>$_POST['end_enclosure'][$i],'connection1_core_id'=>$_POST['core_color1'][$i],'connection2_core_id'=>$_POST['core_color2'][$i],'order'=>$i+1);
                    $this->db->insert('pod_fiber_connection',$conndata);
                    
               }

                 $coredata =  array('flag' => 1);
                 $this->fiberconnectionmodel->update_connection_core($_POST['core_color1'][$i],$coredata);
                 $this->fiberconnectionmodel->update_connection_core($_POST['core_color2'][$i],$coredata);
                
         }
        
         

         foreach($pod_conn as $key => $row){

               $this->db->delete('pod_fiber_connection',array('id' => $row['id']));
               $this->fiberconnectionmodel->update_connection_core($row['connection1_core_id'],array('flag' => 0));
               $this->fiberconnectionmodel->update_connection_core($row['connection2_core_id'],array('flag' => 0));
         }
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

     public function podgraph(){

         $switch =  $this->noncustomermodel->get_podconn();
         foreach($switch as $row){

            $row->connection_info = $this->noncustomermodel->get_pod_fiber_connection(array('pod_join_id'=>$row->id));
            
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

        
         
         $this->data['switch'] = $switch;
         $this->data['data'] = $data;
         $this->data['title'] = "Pod Graph";
         $this->data['template'] = 'noncustomer/podgraph';
         $this->load->view('layout/index',$this->data);


    }

    public function test(){

         $array = array(1,2,3,4,5,6);
         $this->pop_array(6,$array);

         print_r($array);
    }





       


    

   }

 ?>