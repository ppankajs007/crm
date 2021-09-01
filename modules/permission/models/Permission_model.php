<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package	Freelancer Office
 * @author	William M
 */
class Permission_model extends MY_Model
{
	
	function __construct(){ 
        parent::__construct();
    }

	function permissions()
	{
		$query = $this->db->get('permission_module');
		if ($query->num_rows() > 0){
			return $query->result();
		} 
	}
	
// Add a new item
		/* already defined in MY_model
		public function add($table_name,$data = array())
		{
			$this -> db -> insert($table_name, $data);
			return $this -> db -> insert_id();
		}
		*/



// Fetch data from table
		public function get( $table_name, $where_data = null ,$order_by='' )
		{	
			if ( $where_data == null ) 
			{
				if ($order_by != '') {
					# code...
				$data = $this->db->order_by($order_by)->get( $table_name );
				}else{
				$data = $this->db->get( $table_name );

				}
			}
			else
			{
				$data = $this->db->get_where( $table_name, $where_data );
			}

			return $data->result();

		}


		public function get_count( $table_name, $where_data = null )
		{	
			if ( $where_data == null ) 
			{
				$data = $this->db->get( $table_name );
			}
			else
			{
				$data = $this->db->get_where( $table_name, $where_data );
			}

			return $data->num_rows();

		}

		
		public function update( $table_name, $where_data, $add_data )
		{	
			$this->db->where( $where_data );
			$data = $this->db->update( $table_name, $add_data );
			
			return $data->result();

		}
		
		public function delete( $table = null, $field = null, $ids = array()  )
		{   
		    if ( empty( $table ) || empty( $field ) ){
		        return FALSE;
		    }
		    $this->db->where_in( $field, $ids );
		    //$this->db->where_in('id', $this->input->post('ids'));
		    if($this->db->delete( $table ))
		        return TRUE;
		    else
		        return FALSE;
		}

}

/* End of file model.php */
