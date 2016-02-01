<?php 
       class Mastermodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_client($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('C.id',$cond['id']);
              }
              
              $this->db->select('C.*,P.location as device_location,P.device as device_name, P.port as device_port');
              $this->db->from('master as C');
              $this->db->join('pod as P','C.pod_id = P.id','left');
			        $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('master',$data);
           
           }

           public function get_client_connection($cond = array()){

               if(isset($cond['id'])){

                  $this->db->where('C.id',$cond['id']);
              }
              if(isset($cond['master_id'])){

                  $this->db->where('C.master_id',$cond['master_id']);
              }
              if(isset($cond['connection1_core_id'])){

                  $this->db->where('C.connection1_core_id',$cond['connection1_core_id']);
                  $this->db->or_where('C.connection2_core_id',$cond['connection1_core_id']);
              }
              
              if(isset($cond['connection_id'])){

                  $this->db->where('C.connection_id',$cond['connection_id']);
              }
              if(isset($cond['greater_than_order'])){

                  $this->db->where('C.order >',$cond['greater_than_order']);
              }
             
              $this->db->order_by('C.order','asc');
			  
			  
			 
              $this->db->select('C.*,J.name as client_start_point,J.location as client_start_point_location, J.longitude as client_start_point_longitude,J.lattitude as client_start_point_lattitude , I.name as client_end_point, I.location as client_end_point_location,I.longitude as client_end_point_longitude,I.lattitude as client_end_point_lattitude ,F.length as length, S.name as start_enclosure ,S.location as start_location,S.longitude as start_longitude,
                                 F.start_enclosure as start_enclosure_id , F.end_enclosure as end_enclosure_id, 
                                 S.lattitude as start_lattitude, E.name as end_enclosure , E.location as end_location, E.longitude as end_longitude,
                                 E.lattitude as end_lattitude, N.name as color1 ,N.code as color1_code, Q.name as color2, Q.code as color2_code, Z.core as connection_core');
              $this->db->from('master_fiber_connection as C');
			  
			  $this->db->join('enclosure as J','C.start_point_id = J.id','left');  //added
              $this->db->join('enclosure as I','C.end_point_id = I.id','left');    //added
			  
			  
              $this->db->join('fiber_connection as  F','C.connection_id = F.id','left');
              $this->db->join('enclosure as S','F.start_enclosure = S.id','left');
              $this->db->join('enclosure as E','F.end_enclosure = E.id','left');
              
              $this->db->join('connection_core as  B','C.connection1_core_id = B.id','left');
              $this->db->join('bunch-color as  M','B.core_id = M.id','left');
              $this->db->join('color as N','M.color_id = N.id','left');

              $this->db->join('connection_core as  K','C.connection2_core_id = K.id','left');
              $this->db->join('bunch-color as  L','K.core_id = L.id','left');
              $this->db->join('color as Q','L.color_id = Q.id','left');
              
              $this->db->join('bunch as Z','M.bunch_id = Z.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }
           public function update_client_connection($id,$data){

              $this->db->where('id',$id);
              $this->db->update('master_fiber_connection',$data);  
           }
           
            public function update_pod_info($id,$data){

              $this->db->where('id',$id);
              $this->db->update('pod',$data);  
           }

         
        }
 ?>   