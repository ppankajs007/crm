<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->load->model('permission_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
    }
    
    /**
    *Functionality: index view
    */
    public function index() {
        if ( $this->tank_auth->get_user_id() == 1 ) {           
            $this->active();
        }else{
            $this->session->set_flashdata('response_status', 'error');
            $this->session->set_flashdata('message', lang('access_denied'));
            redirect('');           
        }
    }/* function End index */

    public function active() {
        $this->load->module('layouts');
        $this->load->library('template');
        $data['datatables'] = TRUE;
        $data['form'] = TRUE;
        $data['permissions']        = $this->permission_model->get( 'fx_permission' );
        $data['permission_module']  = $this->permission_model->get( 'fx_permission_module' );
        $this->template
        ->set_layout('inner')
        ->build('permissions',isset($data) ? $data : NULL);
    }/* function End active */
    
    /* function auth add user details */
    public function auth() {
        if ($this->input->post()) {
        $user_password = $this->input->post('password');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        if(!empty($user_password)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
        }
        if ($this->form_validation->run() == FALSE) {
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
    }/* function End auth */

    /**
    *Functionality: Delete Permission
    */
    public function delete() {       
        if( isset($_POST['ids']) ){
            echo $ids = $_POST['ids'];
            $data['Del'] = $this->permission_model->delete('fx_permission','permission_id', $ids);
            if($data == TRUE){
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        }

    }/* function End delete */

    /**
    *Functionality: Update Permissions
    */
    public function update() {   
        if ( $this->input->post() )  {
            $this->input->post('id');
            $this->input->post('name');
            $this->input->post('controller_name');
            $this->input->post('method_name');
            $this->input->post('description');
            $this->input->post('permission_module');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('controller_name', 'Controller', 'required');
            $this->form_validation->set_rules('method_name', 'Method Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('permission_module', 'Module Name', 'required');
            if( $this->form_validation->run() == FALSE ) {   
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', 'Unable to update, Please fill all fields');
                redirect('permission');     
            }else {   
                $add_data   = array(    
                                        'permission_name'           => $this->input->post('name'),
                                        'controller_name'           => $this->input->post('controller_name'),
                                        'method_name'               => $this->input->post('method_name'),
                                        'description'               => $this->input->post('description'),
                                        'fk_permission_module_id'   => $this->input->post('permission_module'),
                                        'hidden'                    => $this->input->post('hidden') =='on' ? 1 : 0,
                                    );
                $this->db->where( 'permission_id', $this->input->post('id') );
                if( $this->db->update( 'fx_permission', $add_data ) ) {                   
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Permission Has Been Update Successfully');
                    redirect('permission');                 
                }
            }
        }else{
            $where_data         = array( 'permission_id' => $this->uri->segment(3) );
            $permission_data    = $this->permission_model->get( 'fx_permission', $where_data );
            $permission_module_data     = $this->permission_model->get( 'fx_permission_module' );
            $data['permission_id']              = $this->uri->segment(3);
            $data['permission_data']            = $permission_data;
            $data['permission_module_data']     = $permission_module_data;
            $this->load->view('modal/edit_permission', $data);          
        }
    }/* function End update */

    /**
    *Functionality: Add permission
    */
    public function add() {   
        if ( $this->input->post() )  {       
            $this->input->post('name');
            $this->input->post('controller_name');
            $this->input->post('method_name');
            $this->input->post('description');
            $this->input->post('permission_module');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span style="color:red">', '</span><br>');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('controller_name', 'Controller', 'required');
            $this->form_validation->set_rules('method_name', 'Method Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('permission_module', 'Module Name', 'required');
            if( $this->form_validation->run() == FALSE ) {   
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', 'Unable to add, Please fill all fields');
                redirect('permission');
            }
            else
            {   
                $add_data   = array(    
                        'permission_name'           => $this->input->post('name'),
                        'controller_name'           => $this->input->post('controller_name'),
                        'method_name'               => $this->input->post('method_name'),
                        'description'               => $this->input->post('description'),
                        'fk_permission_module_id'   => $this->input->post('permission_module'),
                        'hidden'                    => $this->input->post('hidden') =='on' ? 1 : 0
                );              
                if( $this->db->insert( 'fx_permission', $add_data ) )
                {
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Permission Has Been Add Successfully');
                    redirect('permission');                 
                }

            }
        }

        else
        {   
            $data['permission_module'] = $this->permission_model->get( 'fx_permission_module' );
            $this->load->view( 'modal/add_permission', $data );
        }   
    }/* function End add */

    /**
    *Functionality: loads load_script
    */
    public function load_script(){
        $data = array();
        $this->load->view('load_script', $data);
    }/* function End load script */
    
    /**
    *Functionality: loads load_css
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* function End load_css */

}

/* End of file Permission.php */
