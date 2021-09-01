<?php

class Crm_model extends MY_Model 
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

    public function sumOfFillColumn($lead_id){
        $sql =  "SELECT ( IF( w1d_date is null ,0,1 ) + IF( w1n_date is null ,0,1 ) + IF( w1e_date is null ,0,1 ) + IF( w2d_date is null ,0,1 ) + IF( w2n_date is null ,0,1 ) + IF( w2e_date is null ,0,1 ) + IF( sms1_date is null ,0,1 ) + IF( sms2_date is null ,0,1 ) + IF( sms3_date is null ,0,1 ) ) as sum_fill_column FROM nine_boxes WHERE l_id = '$lead_id'";
        $rowData = $this->crm_model->custom_query($sql,false,'array');

        if ( $rowData ) {
            $data = $rowData;
        }else{
            $data = '0';
        }

        return $data;
    }

}
?>