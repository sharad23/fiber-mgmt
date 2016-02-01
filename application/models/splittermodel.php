<?php 
       class Splittermodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_splitter($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('S.id',$cond['id']);
              }
              if(isset($cond['type'])){

                  $this->db->where('S.type',$cond['type']);
              }
              
              $this->db->select('S.*,O.name as device_name, O.port as device_port');
              $this->db->from('splitter as S');
              $this->db->join('olt as O','S.olt_id = O.id','left');
			        $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('splitter',$data);
           
           }

           public function get_splitter_connection($cond = array()){

               if(isset($cond['id'])){

                  $this->db->where('C.id',$cond['id']);
              }
              if(isset($cond['splitter_id'])){

                  $this->db->where('C.splitter_id',$cond['splitter_id']);
              }
              if(isset($cond['connection1_core_id'])){

                  $this->db->where('C.connection1_core_id',$cond['connection1_core_id']);
                  
              }

               if(isset($cond['core_id'])){

                  $this->db->where('C.core_id',$cond['core_id']);
                  
              }
              
              if(isset($cond['connection_id'])){

                  $this->db->where('C.connection_id',$cond['connection_id']);
              }
              if(isset($cond['greater_than_order'])){

                  $this->db->where('C.order >',$cond['greater_than_order']);
              }
             
              $this->db->order_by('C.order','asc');
              $this->db->select('C.*,J.name as client_start_point,J.location as client_start_point_location, J.longitude as client_start_point_longitude,J.lattitude as client_start_point_lattitude , I.name as client_end_point, I.location as client_end_point_location,I.longitude as client_end_point_longitude,I.lattitude as client_end_point_lattitude  ,F.length as length, S.name as start_enclosure ,S.location as start_location,S.longitude as start_longitude,
                                 F.start_enclosure as start_enclosure_id , F.end_enclosure as end_enclosure_id, 
                                 S.lattitude as start_lattitude, E.name as end_enclosure , E.location as end_location, E.longitude as end_longitude,
                                 E.lattitude as end_lattitude, N.name as color ,N.code as color_code, Z.core as connection_core');
              
              $this->db->from('splitter_connection as C');
              
              
              $this->db->join('enclosure as J','C.start_point_id = J.id','left');
              $this->db->join('enclosure as I','C.end_point_id = I.id','left');
              
              $this->db->join('fiber_connection as  F','C.connection_id = F.id','left');
              $this->db->join('enclosure as S','F.start_enclosure = S.id','left');
              $this->db->join('enclosure as E','F.end_enclosure = E.id','left');
              
              $this->db->join('connection_core as  B','C.core_id = B.id','left');
              $this->db->join('bunch-color as  M','B.core_id = M.id','left');
              $this->db->join('color as N','M.color_id = N.id','left');

              $this->db->join('bunch as Z','M.bunch_id = Z.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

           public function get_splitter_output($cond = array()){
              
               if(isset($cond['id'])){

                  $this->db->where('O.id',$cond['id']);
              }
              
              if(isset($cond['splitter_id'])){

                  $this->db->where('O.splitter_id',$cond['splitter_id']);
              }
              
              if(isset($cond['output_splitter_id'])){

                  $this->db->where('O.output_splitter_id',$cond['output_splitter_id']);
              }
              
              if(isset($cond['output_client_id'])){

                  $this->db->where('O.output_client_id',$cond['output_client_id']);
              }
              $this->db->select('O.*,E.name as org_name,E.latittude as org_latittude,E.longitude as org_longitude,E.location as org_location,F.name as olt_name,F.port as olt_port,S.name as output_splitter_name,S.latittude as output_splitter_latittude,S.longitude as output_splitter_longitude,C.name as output_client_name,C.latittude as output_client_latittude,C.longitude as output_client_longitude,');
              $this->db->from('splitter_output as O');
              $this->db->join('splitter as E','O.splitter_id = E.id','left');
              $this->db->join('olt as F','E.olt_id = F.id','left');
              $this->db->join('splitter as S','O.output_splitter_id = S.id','left');
              $this->db->join('client as C','O.output_client_id = C.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }
           public function update_splitter_connection($id,$data){

              $this->db->where('id',$id);
              $this->db->update('splitter_connection',$data);  
           }
           
            public function update_olt_info($id,$data){

              $this->db->where('id',$id);
              $this->db->update('olt',$data);  
           }

            public function update_splitter_output($id,$data){

              $this->db->where('id',$id);
              $this->db->update('splitter_output',$data);  
           }

         
        }
 ?>   