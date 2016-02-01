<?php 
       class Bunchmodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_bunch($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('id',$cond['id']);
              }
              
              if(isset($cond['core'])){

                  $this->db->where('core',$cond['core']);
              }
              $this->db->order_by('core','asc');
              $this->db->select('*');
              $this->db->from('bunch');
			        $query = $this->db->get();
              $result = $query->result();

              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('bunch',$data);
           
           }

            public function get_bunch_color($cond = array()){


              if(isset($cond['id'])){

                  $this->db->where('B.id',$cond['id']);
              }
              if(isset($cond['bunch_id'])){

                 $this->db->where('B.bunch_id',$cond['bunch_id']);
              }
              if(isset($cond['color'])){


              }
              
              $this->db->select('B.*,C.name as color_name');
              $this->db->from('bunch-color  as B');
              $this->db->join('bunch as D','B.bunch_id = D.id','left');
              $this->db->join('color as C','B.color_id = C.id','left');
              $query = $this->db->get();
              $result = $query->result();
              return $result;

           }


           public function update_bunch_color($id,$data){

              $this->db->where('id',$id);
              $this->db->update('bunch-color',$data);
           
           }
        }
 ?>   