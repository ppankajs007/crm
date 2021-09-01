<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Department extends MX_Controller
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
        $this->load->model('Department_model');
       if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
    }

    /**
    * Functionality:  loads view departments.php
    */
    public function index()
    {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $result = $this->db->select('*')->from('department')->get();
        $data['department'] = $result->result('array'); 
        $this->template->title('Department');
        $this->template
                ->set_layout('inner')
                ->build('departments', $data);
    }/* End Function index */

    /**
    * Functionality:  Add Department
    * view:  modal/department_add.php
    */
    public function add() {
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
                redirect('/auth/login/');
            }else{
                if ( $this->input->post() ) {
                    $post_data = array(
                        'department_title'  => $this->input->post('department_title'),
                        'department_desc'       => $this->input->post('department_desc')
                    );
                    if( !$department_id = App::save_data( 'department', $post_data ) ) {
                        $this->session->set_flashdata('response_status', 'error');
                        $this->session->set_flashdata('message', 'Department didn\'t save, Try again!');
                        redirect('/department/department');
                    }else{       
                        $this->session->set_flashdata('response_status', 'success');
                        $this->session->set_flashdata('message', 'Department has Been  add successfully');
                        redirect('/department');
                    }
                }

            }
            $data = array();
            $this->load->view('modal/department_add', $data);

    }/* End Function add */

    /**
    * Functionality:  loads script load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End Function load_script */

    /**
    * Functionality: loads css load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }

    /**
     * Functionality: Department Edit
     * Call From: Department Action Listing View
     */
    public function edit($id) {
        if ( $this->input->post('department_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('department_id');
            $match = array ('id' => $this->input->post('department_id'));
            $data = array(
                        'department_title'  => $this->input->post('department_title'),
                        'department_desc'       => $this->input->post('department_desc')
                    );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Department has been updated successfully'); 
            App::update('department',$match,$data);
            redirect('/department');
            }else{
               $data['department'] = (array) App::get_row_by_where('department', array('id'=>$id) );
               $this->load->view('modal/edit_department', $data);
            }
    }/* End Function Edit */

    /**
    * Functionality: Department Delete
    */
    /*
    public function delete($id) {

        if( App::delete('department', array('id' => $id) ) ){
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Department has been deleted successfully');
            redirect('/department'); 
        }

    }
    */

    /**
    * Functionality: Department Datatable listing
    * Call From: load_scipt.php
    * View: load_scipt.php
    */
    public function departmentRows() {
        $column = array(
                      0 => 'id',
                      1 => 'department_title',
                      2 => 'department_desc'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $column[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->Department_model->countdata('department');
        $totalFiltered = $totalData;
        $data = $row = array();
        if( empty( $this->input->post('search')['value'] ) ) {
            $departmentData = $this->Department_model->getRows($limit,$start,$order,$dir,'department');
        }else{
            $search = $_POST['search']['value'];
            $departmentData = $this->Department_model->data_search($limit,$start,$search,$order,$dir,'department',$column);
            $totalFiltered = $this->Department_model->data_search_count($search,'department',$column);
        }
        if (!empty($departmentData)) {
                foreach($departmentData as $department){
                    $data[] = array( 
                            $department->id,  
                            $department->department_title, 
                            $department->department_desc, 
                            '<a href="'.base_url().'department/department/edit/'.$department->id.'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodalEdit" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                            <a href="javascript:void(0);" id="deleteDepartment" title="Delete" class="action-icon" ids="'. $department->id.'"> <i class="mdi mdi-delete"></i></a>'
                        );
                }
        }
        $output = array(
                    "draw"            => $_POST['draw'],
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data
                );
        echo json_encode($output);

    }/* End Function departmentRow */


}

/* End of file Department.php */