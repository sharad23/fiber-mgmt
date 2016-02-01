<?php 
       class Fiberconnectionmodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_connection($cond = array()){


              if(isset($cond['id'])){

              	  $this->db->where('C.id',$cond['id']);
              }
              
              if(isset($cond['fiber_id'])){

                  $this->db->where('C.fiber_id',$cond['fiber_id']);
              }

              if(isset($cond['mode'])){

                  $this->db->where('C.mode',$cond['mode']);
              }
              
              if(isset($cond['objective'])){

                  $this->db->where('C.objective',$cond['objective']);
              }
              
              if(isset($cond['start_enclosure'])){

                  $this->db->where('C.start_enclosure',$cond['start_enclosure']);
              }
              
              if(isset($cond['end_enclosure'])){

                  $this->db->where('C.end_enclosure',$cond['end_enclosure']);
              }
              if(isset($cond['order'])){

                 $this->db->order_by('C.'.$cond['order_by'],$cond['order']);
              }
              $this->db->select('C.*,S.name as start_name,S.location as start_location,S.longitude as start_longitude,S.lattitude as start_lattitude,E.name as end_name,E.location end_location,E.longitude as end_longitude,E.lattitude as end_lattitude,F.drum_no,F.brand_name,B.core');
              $this->db->from('fiber_connection as C');
              $this->db->join('enclosure as S','C.start_enclosure = S.id','left');
              $this->db->join('enclosure as E','C.end_enclosure = E.id','left');
              $this->db->join('fiber as F','C.fiber_id = F.id','left');
              $this->db->join('bunch as B','F.bunch_id = B.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

            public function get_enclosure($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('id',$cond['id']);
              }
              
              if(isset($cond['name'])){

                  $this->db->where('name',$cond['name']);
              }

              if(isset($cond['keyword'])){

                 $this->db->like('name',$cond['keyword'],'after');
              
              }

              if(isset($cond['like_location'])){
                
                $this->db->like('location',$cond['like_location'],'after');

              }
              
               if(isset($cond['location'])){
                
                $this->db->where('location',$cond['location']);

              } 
              
              $this->db->select('*');
              $this->db->from('enclosure');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('fiber_connection',$data);
           
           }

           public function get_connection_core($cond = array()){

              
              if(isset($cond['id'])){

                  $this->db->where('C.id',$cond['id']);
              }
              
              if(isset($cond['connection_id'])){

                  $this->db->where('C.connection_id',$cond['connection_id']);
              }

              if(isset($cond['flag'])){

                  $this->db->where('C.flag',$cond['flag']);
              }
              
              $this->db->select('C.*,E.name');
              $this->db->from('connection_core as C');
              $this->db->join('bunch-color as D','C.core_id = D.id','left');
              $this->db->join('color as E','D.color_id = E.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

           public function update_connection_core($id,$data){

              $this->db->where('id',$id);
              $this->db->update('connection_core',$data);
           
           }
        }
 ?>