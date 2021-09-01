<?php

class Msg_model extends MY_Model 
{	


    function __construct(){ 
        parent::__construct();
    }
    
    public function Pkdelete_file($array,$table){
        $this->db->where($array);
            $query = $this->db->delete($table);
            //echo $this->db->last_query();
            if($query == true){
                return 'true';
            } else {
                return 'false';
            } 

    }

}
?>