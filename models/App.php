<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class App extends CI_Model
{

	private static $db;

	function __construct(){
		parent::__construct();
		self::$db = &get_instance()->db;
	}


	/**
	* Counts num of records in TABLE
	*/

	static function counter($table,$where = array()) {

		return self::$db->where($where)->get($table)->num_rows();
	}

	// Get activities
	static function get_activity($limit = NULL) {
		return self::$db->order_by('activity_date','desc')->get('activities',$limit)->result();
	}

  	/**
	* Insert data to logs table
	*/
	static function Log($data = array()) {
		return self::$db->insert('activities',$data);
	}

	static function get_by_where($table, $array = NULL, $order_by = array(),$isOBJ = false){
		if(count($order_by) > 0) { self::$db->order_by($order_by['column'],$order_by['order']) ; }
		if($isOBJ) return self::$db->where($array)->get($table)->result_array();
		return self::$db->where($array)->get($table)->result();
	}

	static function get_row_by_where($table, $array = NULL, $order_by = array()){
		if(count($order_by) > 0) { self::$db->order_by($order_by['column'],$order_by['order']) ; }
    	return self::$db->where($array)->get($table)->row();
	}
	
	// Save any data
	static function save_data($table, $data){
		self::$db->insert($table,$data);
		return self::$db->insert_id();
	}

	/**
	* Update records in $table matching $match.
	*
	* @return Affected rows int
	*/

	static function update($table,$match = array(),$data = array()) {

		self::$db->where($match)->update($table,$data);
		return self::$db->affected_rows();
	}

	/**
	* Deletes data matching $where in $table.
	*
	* @return boolean
	*/

	static function delete($table,$where = array()) {

		return self::$db->delete($table,$where);
	}
	
	/**
	* Create Activty_record in $table.
	*
	*/
    static function create_activity($aName,$aID,$aMessage,$aMeta) {
    		self::$db->insert('activity_record',array(
    		    'activity_name' => $aName,
    		    'activity_id' => $aID,
    		    'activity_message' => $aMessage,
    		    'meta_data' => $aMeta,
    		    'activity_time' => date('Y:m:d H:i:s'),
    		    ));
    		return self::$db->insert_id();
	}

	static function LogActivity($insertData){
			self::$db->insert('pk_activities',$insertData);
			return self::$db->insert_id();
	}
	static function findParent($useremail, $userphone){
	    
	    $parent = self::$db->query("SELECT * FROM leads where (parent_lead = '0') AND ( email LIKE '%$useremail%' OR phone LIKE '%$userphone%' )");
	    $parent = $parent->result('array');
	    
	    if( COUNT($parent) > 1) return true;
	    return false;
        
    }

}

/* End of file model.php */