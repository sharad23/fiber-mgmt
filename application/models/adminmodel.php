<?php 
       class Adminmodel extends CI_Model{
           

           public function __construct()
            {
               parent::__construct();   
            }

           public function get_users($cond = array()){


              if(isset($cond['id'])){

              	  $this->db->where('id',$cond['id']);
              }
              
              if(isset($cond['flag'])){

                  $this->db->where('flag',$cond['flag']);
              }
			  if(isset($cond['user_type'])){
			  		$this->where('user_type',$cond['user_type']);
			  }
              
              $this->db->select('*');
              $this->db->from('users');
              $query = $this->db->get();
              $result = $query->result();

              return $result;

           }

           public function update($id,$data){

              $this->db->where('id',$id);
              $this->db->update('users',$data);
           
           }
        }
 ?>