<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Role extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->module('layouts');
        $this->load->library('template');
        $this->load->model('Role_model');
        if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login');
		}
       
    }

    /**
    * Functionality: loads view roles.php
    */
    public function index()
    {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $result = $this->db->select('*')->from('roles')->get();
        $data['roles'] = $result->result('array');  
        $this->template->title('Department');
        $this->template
                ->set_layout('inner')
                ->build('roles', $data);
    }/* End Function index */

    /**
    * Functionality: Add Role
    * View: modal/role_add.php
    */
    public function add() {
        if (!$this->tank_auth->is_logged_in()) {     // not logged in or not activated
            redirect('/auth/login/');

        }else{
            if( $this->input->post() ){
                $post_data = array(
                    'role_title'    => $this->input->post('role_title'),
                    'role_desc'     => $this->input->post('role_desc'),
                    'parent_role'     => $this->input->post('parent_role'),
                );
                if( !$role_id = App::save_data( 'roles', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Role didn\'t save, Try again!');
                    redirect('/role/role');
                }else{       
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Role Has Been added successfully');
                    redirect('/role');
                }
            }

        }  
        $data['roles'] = (array) App::get_by_where('roles', array('1' => 1 ));
        $this->load->view('modal/role_add', $data);
    }/* End Function add */

    /**
    * Functionality: loads js script load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End Function load_script */

    /**
    * Functionality: loads js script load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* End Function load_css */

    /**
    * Functionality: Delete Role
    */
    public function delete_role()  {
        if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            $data['roleDel'] = $this->user_model->Pkdelete_query($ids,'roles');
            if($data == true){
                echo "TRUE";
            }else{
                echo "FALSE";
            }
        }
    }/* End Function delete role */

    /**
    * Functionality: Datatable Roles Listing
    * Call From: load_script.php
    * View: Roles.php
    */
    public function getRoles() {
        $column = array(
                      0 => 'id',
                      1 => 'role_title',
                      2 => 'role_desc'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $column[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->Role_model->countdata('roles');
        $totalFiltered = $totalData;
        $data = $row = array();
        if( empty( $this->input->post('search')['value'] ) )
        {
            $roleData = $this->Role_model->getRows($limit,$start,$order,$dir,'roles');
        }else{
            $search = $_POST['search']['value'];
            $roleData = $this->Role_model->data_search($limit,$start,$search,$order,$dir,'roles',$column);
            $totalFiltered = $this->Role_model->data_search_count($search,'roles',$column);
        }
        if (!empty($roleData)) {
                $startvalue = $start;
                foreach($roleData as $roles){
                    $startvalue++;
                    $data[] = array(
                            $roles->id,  
                            $roles->role_title, 
                            $roles->role_desc, 
                            '<a href="'.base_url().'role/edit/'.$roles->id.'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodalEdit" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                            <a href="javascript:void(0);" id="deleteRole" title="Delete" class="action-icon" ids="'. $roles->id.'"><i class="mdi mdi-delete"></i></a>'

                        );
                }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );
        
        echo json_encode($output);
    }/* End Function get_role */

    /**
    * Functionality: Edit Role
    * View: modal/edit_role.php
    */
    public function edit($id) {
       if ( $this->input->post('role_id') ) {    
                    $data['errors'] = array();
                    $id = $this->input->post('role_id');
                    $match = array (
                        'id' => $this->input->post('role_id')
                    );
                    $data = array(
                            'role_title'  => $this->input->post('role_title'),
                            'role_desc'   => $this->input->post('role_desc'),
                            'parent_role' => $this->input->post('parent_role')
                      );

                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Role has been updated successfully'); 
                    App::update('roles',$match,$data);
                    redirect('/role');

            }else{
                $data['role'] = (array) App::get_row_by_where('roles', array('id' => $id) );
                $data['roles'] = (array) App::get_by_where('roles', array('1' => 1 ));
                $this->load->view('modal/edit_role', $data);
            }
    }/* End Function edit */


    /**
    * Functionality: checks user role
    */
    public function check_user_role(){
       
        if (isset($_POST['ids'] ) ) {
            $id = $_POST['ids'];
            $query =  $this->Role_model->countNumrows( 'users', array( 'role' => $id ) );
            if( $query == 1){
                echo "true";
            } else {
                echo "false";
            }
        }
    }/* End Function index */
      


}

/* End of file Role.php */