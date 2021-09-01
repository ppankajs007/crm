<?php

class Import_model extends MY_Model 
{   
    function __construct(){ 
        parent::__construct();
    }

    function findNameid($tableName,$columnName,$columnValue,$styleName=''){
        $result = $this->findWhere( $tableName, array($columnName => $columnValue ), false, array( 'id' ) );
        if (!$result['id']) {
            $tbType = explode('_', $tableName);
            $insertData = array($columnName => $columnValue );

            if ($styleName == '') {
                if ( in_array('style', $tbType) ) {
                    $sn = array('style_name' => $columnValue); 
                    $insertData = array_merge($insertData,$sn);
                }
            }else{
                $sn = array('style_name' => $styleName); 
                $insertData = array_merge($insertData,$sn);
            }

            $this->insert_data($tableName,$insertData);
            return $this->db->insert_id();
        }
        return $result['id'];
    }

    function findProductExist($table_name,$where){
        return $this->db->select('id')->from($table_name)->where($where)->get()->num_rows();
    }
}