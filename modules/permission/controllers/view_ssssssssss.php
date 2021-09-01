<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class View extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('tank_auth');
		// if ($this->tank_auth->user_role($this->tank_auth->get_role_id()) != 'admin') {
		// 	$this->session->set_flashdata('message', lang('access_denied'));
		// 	redirect('');
		// }
		$this->load->model('permission_model','permission');
	}
	
	function add()
	{	$this->load->model('permission_model');
		if ($this->input->post())
		{
			if (($this->form_validation->run('permission', 'add_permission') == TRUE)) // Validation ok
			{
				$_POST['name'] = $this->input->post('name');
				$_POST['description'] = $this->input->post('description');
				$permission = $this->permission_model->add('permission_module', $_POST);
				$this->applib->redirect_to('permission', lang('permission_added_successfully'));
			} 
			else
			{
				$data['name'] = $this->input->post('name');
				$data['description'] = $this->input->post('description');
				$this->load->view('modal/add_permission',$data);

			}
				
		}
	$this->load->view('modal/add_permission');		
	}
	
	
	function update()
	{
		$this->load->view('modal/edit_permission',$data);
	}

	function delete()
	{
		$this->load->view('modal/delete_permission',$data);
	}
}

/* End of file view.php */
