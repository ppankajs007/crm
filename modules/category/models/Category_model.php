<?php

class Category_model extends MY_Model 
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

    function countdata($table){
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function getRows($limit,$start,$order,$dir,$table){
        $query = $this->db->limit($limit,$start)->order_by($order,$dir)->get($table);
        if( $query->num_rows() > 0){
            return $query->result();
        } else {
            return null;
        }
    }

    function data_search($limit,$start,$search,$order,$dir,$table,$searchvalue){
            $this->db->like('id',$search);
                foreach ($searchvalue as $key => $value) {
                    $this->db->or_like( $value, $search );
                }
            $this->db->limit($limit,$start);
            $this->db->order_by($order,$dir);
            $query = $this->db->get($table);
            if( $query->num_rows() > 0 ){
                return $query->result();
            } else {
                return null;
            }
    }

    

}
?>