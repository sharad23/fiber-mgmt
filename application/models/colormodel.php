<?php 
       class Colormodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_color($cond = array()){


              if(isset($cond['id'])){

              	  $this->db->where('id',$cond['id']);
              }
              
              if(isset($cond['name'])){

                  $this->db->where('name',$cond['name']);
              }
              
              $this->db->select('*');
              $this->db->from('color');
              $query = $this->db->get();
              $result = $query->result();

              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('color',$data);
           
           }
        }
 ?>