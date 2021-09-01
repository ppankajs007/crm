<?php

class Cron_model extends MY_Model 
{	
    function __construct(){ 
        parent::__construct();
    }
    
    public function Pkdelete_file($array,$table){
        $this->db->where($array);
            $query = $this->db->delete($table);
            if($query == true){
                return 'true';
            }else{
                return 'false';
            } 
    }

}
?>