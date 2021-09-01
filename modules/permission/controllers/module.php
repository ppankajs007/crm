<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Module extends MX_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->model('permission_model');
		$this->user = $this->tank_auth->get_user_id();
		$this->company_id = $this->applib->get_company_id();
	}
	function index(){
		if ( $this->tank_auth->get_user_id()  == 1 ) 
		{			
			$this->active();
		}
		else
		{
		$this->session->set_flashdata('response_status', 'error');
		$this->session->set_flashdata('message', lang('access_denied'));
		redirect('');			
		}
	}

	function active()
	{
	$this->load->module('layouts');
	$this->load->library('template');
	$this->template->title(lang('permission').' - '.$this->config->item('company_name'). ' '. $this->config->item('version'));
	$data['page'] = lang('permission');
	$data['datatables'] = TRUE;
	$data['form'] = TRUE;
	$data['permissions'] = $this->permission_model->permissions();
	$this->template
	->set_layout('users')
	->build('permissions_module',isset($data) ? $data : NULL);
	}

	function auth()
	{
		if ($this->input->post()) {
		$user_password = $this->input->post('password');

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if(!empty($user_password)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
        }
		
		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', lang('operation_failed'));
				redirect('users/account');
		}else{	
		$user_id =  $this->input->post('user_id');
			$profile_data = array(
			                'username' => $this->input->post('username'),
			                'email' => $this->input->post('email'),
			                'role_id' => $this->input->post('role_id'),
			                'modified' => date("Y-m-d H:i:s")             
			            );

			$this->db->where('id',$user_id)->update('users', $profile_data); 

			if(!empty($user_password)) {
                $this->tank_auth->set_new_password($user_id,$user_password);
            }

					$params['user'] = $this->tank_auth->get_user_id();
					$params['module'] = 'Users';
					$params['module_field_id'] = $user_id;
					$params['activity'] = ucfirst(lang('activity_updated_system_user').$this->input->post('fullname'));
					$params['icon'] = 'fa-edit';
					modules::run('activity/log',$params); //log activity

			$this->session->set_flashdata('response_status', 'success');
			$this->session->set_flashdata('message', lang('user_edited_successfully'));
			redirect('users/account');
		}
		}else{
		$data['user_details'] = $this-> user_model ->user_details($this->uri->segment(4));
		$data['roles'] = $this-> user_model ->roles();
		$data['companies'] = $this -> AppModel->get_all_records($table = 'companies',
		$array = array(
			'co_id >' => '0'),$join_table = '',$join_criteria = '','date_added');
		$this->load->view('modal/edit_login',$data);
		}
	}

	function delete()
	{		

		// If delete button is pressed from modal pop up

		if ( $this->input->post() ) 
		{
			$where_data = array( 'permission_module_id' => $this->input->post('id') );

			$this->db->where( $where_data );
			if( $this->db->delete( 'fx_permission_module') )
			{				
				$this->session->set_flashdata('response_status', 'success');
				$this->session->set_flashdata('message', 'Information Deleted Successfully');
				redirect('permission/module');
			}
			else
			{
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', 'Unable to Delete');
				redirect('permission/module');	
			}
			
		}	

		// else when delete button is pressed from permissions page to open modal
		
		else
		{			
			$data['id'] = $this->uri->segment(4);		
			$this->load->view('modal/delete_permission_module', $data);				
		}
	}



	function update()
	{	

		if ( $this->input->post() ) 
		{
			
			$this->input->post('id');
			$this->input->post('name');
			$this->input->post('description');
			
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if( $this->form_validation->run() == FALSE )
			{	
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', 'Unable to update, Please fill all fields');
				redirect('permission/module');
			}
			else
			{	
				$where_data 	= array( 'permission_module_id' => $this->input->post('id') );
				$update_data 	= array( 	'name' => $this->input->post('name'), 
											'description' => $this->input->post('description'),
										);
				$this->db->where( $where_data );
				if( $this->db->update( 'fx_permission_module', $update_data ) )
				{
					$this->session->set_flashdata('response_status', 'success');
					$this->session->set_flashdata('message', 'Information Updated Successfully');
					redirect('permission/module');			
				}

			}
		}

		else
		{
			$where_data = array( 'permission_module_id' => $this->uri->segment(4) );
			$permission_data = $this->db->get_where( 'fx_permission_module', $where_data )->result();
			
			$data['permission_id'] = $this->uri->segment(4);
			$data['permission_data'] = $permission_data;

			$this->load->view('modal/edit_permission_module', $data);			
		}
	}


	function add()
	{	

		if ( $this->input->post() ) 
		{		
		
			$this->input->post('name');
			$this->input->post('description');
			
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');

			if( $this->form_validation->run() == FALSE )
			{	
				$this->session->set_flashdata('response_status', 'error');
				$this->session->set_flashdata('message', 'Unable to add, Please fill all fields');
				redirect('permission/module');
			}
			else
			{	
				
				$add_data 	= array( 	'name' => $this->input->post('name'), 
											'description' => $this->input->post('description'),
										);				
				if( $this->db->insert( 'fx_permission_module', $add_data ) )
				{
					$this->session->set_flashdata('response_status', 'success');
					$this->session->set_flashdata('message', 'Information Added Successfully');
					redirect('permission/module');			
				}

			}
		}

		else
		{
			$this->load->view('modal/add_permission_module');
		}	
	}


	function defaultPermission()
	{				 
			$this->load->module('layouts');
			$this->load->library('template');
			$this->template->title(lang('permission_default').' - '.$this->config->item('company_name'). ' '. $this->config->item('version'));
			$data['page'] = 'settings';
			$data['group'] = 'defaultPermission';
			$data['datatables'] = TRUE;
			$data['form'] = TRUE;

			$data['permissions'] 		= $this->permission_model->permissions();
			$data['permission_module'] 	= $this->permission_model->get('fx_permission_module');
			$data['permission'] 		= $this->permission_model->get('permission');

			$data['department'] 		= $this->db->where('company_id',$this->company_id)->get('departments')->result();  
			$data['department_role'] 	= $this->db->where('company_id',$this->company_id)->get('roles')->result();  
			$data['department_count'] 	= $this->permission_model->get_count('fx_permission_module');
			$this->template
			->set_layout('users')
			->build('permissions_default',isset($data) ? $data : NULL);
	}


	function get_role_name()
	{
		$department_id 	= $this->input->post('department_id');
		$where_data 	= array( 'fx_roles' => $department_id );
		$data 			= $this->permission_model->get( 'fx_permission', $where_data );
		echo json_encode($data); 
	}


	// function assign_permissions()
	// {
		
	// 	$permissions_ser 	= serialize( $this->input->post( 'permissions' ) );
	// 	$department_id 		= $this->input->post( 'department' );
	// 	$role_id 			= $this->input->post( 'role' );

	// 	$where_data = array(
	// 							'department_id' => $this->input->post( 'department' ),
	// 							'role_id' 		=> $this->input->post( 'role' ),									
	// 							'company_id' 	=> $this->company_id,									
	// 						);

	// 	if( $this->permission_model->get( 'fx_permissions_default', $where_data ) )
	// 	{	

	// 		$add_data = array(
	// 							'permissions' 	=> serialize($this->input->post('permissions')),
	// 							'department_id' => $this->input->post('department'),
	// 							'company_id' 	=> $this->company_id,
	// 						);	
	// 		$this->db->where( $where_data );	
	// 		$inserted = $this->db->update( 'fx_permissions_default', $add_data );	
	// 	}

	// 	else
	// 	{
	// 		$add_data = array(
	// 							'permissions' 	=> serialize($this->input->post('permissions')),
	// 							'department_id' => $this->input->post('department'),
	// 							'role_id' 		=> $this->input->post('role'),
	// 							'company_id' 	=> $this->company_id,
	// 						);				
	// 		$inserted = $this->permission_model->add( 'fx_permissions_default', $add_data );

	// 	}

	// 	if( $inserted )
	// 	{	
	// 		$where_data 	= array( 'role_id' => $role_id );
	// 		$update_data 	= array( 	'permissions' => $permissions_ser );
	// 		$this->db->where( $where_data );
	// 		$this->db->update( 'users', $update_data );	
	// 		echo "Success";			
	// 	}

	// 	else
	// 	{
	// 		echo "Try Again";
	// 	}
	// }


	function get_permission_info()
	{
		$department_id 	= $this->input->post('department_id');
		$role_id 		= $this->input->post('role_id');
		$where_data 	= array( 'department_id' => $department_id, 'role_id' => $role_id );
		$data = $this->permission_model->get( 'permissions_default', $where_data );
		//$data = $this->db->last_query(); 
		echo json_encode((unserialize(($data[0]->permissions))));
	}




}

/* End of file account.php */