<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
        private static $db;
        function __construct(){
            parent::__construct();
            self::$db = &get_instance()->db;
        }
    function add(  $table, $data ) {
        if ( empty( $data ) || empty( $table ) ) {
            return false;
        }
        $this->db->insert( $table , $data);
        if($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    function edit(  $table = null, $id = null, $data = null ) {
        if ( empty( $data ) || empty( $table ) || !is_numeric( $id ) )
            return false;
        $this->db->where(array('id'=>$id));
        $this->db->update( $table, $data );
        return true;
    }

    function destroy( $table = null, $field = null, $ids = array()  ) {   
        if ( empty( $table ) || empty( $field ) ){
            return false;
        }
        $this->db->where_in( $field, $ids );
        if($this->db->delete( $table ))
            return TRUE;
        else
            return FALSE;
        }

    function uWhere( $table, $where_data, $data ) {
        if( !empty( $table )  && is_array( $where_data ) && !empty( $where_data ) )    
        $result = $this->db->update( $table, $data, $where_data );   
        if( $result ) {
            return true;
        }else{
            return false;
        }
    }
    
    function dWhere( $table, $where_data ) {
        if( !empty( $table )  && is_array( $where_data ) && !empty( $where_data ) )    
        $result = $this->db->delete( $table, $where_data );
        if( $result ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Find data using where clause from a table
     *
     * @param $where_data
     * @return mixed <p>Array is returned as result and FALSE in case of no
     * result found</p>
     */
    function fWhere( $table, $where_data, $multi_record = TRUE, $select = array() ) {
        $this->db->where( $where_data );
        if( !empty( $select ) && is_array( $select ) ) {
            $this->db->select( $select );
        }
        $result = $this->db->get( $table );
        if ( $result ) {
            if ( $multi_record ) {
                return $result->result_array();
            }else{
                return $result->row_array();
            }
        }else{
            return FALSE;
        }
    }


    /**
     * Find records where $field is matching with $where_in_array
     *
     * @param string $field
     * @param array $where_in_array
     */
    function fWhereIn( $field, $where_in_array ) {
        $this->db->where_in( $field, $where_in_array );
        $result = $this->db->get( $this->table );
        if ( $result->num_rows() > 0 ) {
            return $result->result_array();
        }else{
            return false;
        }
    }

    /**
     * Returns last insert id
     *
     * @return number
     */
    function lastId() {
        return $this->db->insert_id();
    }

    /*
    *
    *  Get all data with pagination
    *
    */
    function getAll( $table, $page, $per_page = 10, $count=false ) {        
        $this->db->order_by("id", "desc");
        $this->db->from( $table );
        if( $count ) {
            $data = $this->db->get();
            return count( $data->result() );
        }else{
            $this->db->limit( $per_page, $page );
            $data = $this->db->get();
            if(count($data->result()) > 0){
                return $data->result();
            }else{
                return false;
            }
        }
    }

    function fetchAll( $table ){
        if( empty( $table ) ) {
            return false;
        }
        $this->db->from( $table );
        $data = $this->db->get();
        if(count($data->result()) > 0) {
            return $data->result();
        }else{
            return false;
        } 
    }
    
    public function customQuery($query,$count=false,$format = 'object'){
        $sqlQuery = $this->db->query($query);
        if ($count) {
                return count( $sqlQuery->result() );
        }
        if ($format  == 'array') {
            if( $res = $sqlQuery->result_array() ){
                    return $res;
                }else{
                    return false;
                }   
        }else{
            if( $res = $sqlQuery->result() ){
                return $res;
            }else{
                return false;
            }
        }

    }

}
