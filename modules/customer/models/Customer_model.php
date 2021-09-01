<?php

class Customer_model extends MY_Model 
{	


    function __construct(){ 
        parent::__construct();
    }
    
    /* public function Pkdelete_query($ids,$table){
        $this->db->where('id',$ids);
        $query = $this->db->delete($table);
        if($query == true){
            return 'true';
        } else {
            return 'false';
        }    
    }*/



}
?>