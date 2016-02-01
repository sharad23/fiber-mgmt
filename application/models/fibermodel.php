<?php 
       class Fibermodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_fiber($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('F.id',$cond['id']);
              }
              
              if(isset($cond['drum_no'])){

                  $this->db->where('F.drum_no',$cond['drum_no']);
              }
              
              if(isset($cond['live_fiber'])){

                  $this->db->where('F.available_length >', 0);
              }
              
              if(isset($cond['dead_fiber'])){

                  $this->db->where('F.available_length <=', 0);
              }
              $this->db->select('F.*,B.core as no_of_cores');
              $this->db->from('fiber as F');
              $this->db->join('bunch as B','F.bunch_id = B.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }

          public function update($id,$data){
			
              $this->db->where('id',$id);
              $this->db->update('fiber',$data);
           
           }
 
        }
 ?>   