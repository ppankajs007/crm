<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Task extends MX_Controller
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
        $this->load->model('Task_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    }
    
    /**
    *Functionality: Loads View task.php
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $this->template->title('Task');
        $this->template
             ->set_layout('inner')
             ->build('task', $data);
    }/* function End index */

    /**
    *Functionality: Create Task
    */
    public function add() {
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $post_data = array(
                    'task_title'        => $this->input->post('task_title'),
                    'task_desc'         => $this->input->post('task_desc'),
                    'assigned_to'       => $this->input->post('assigned_to'),
                    'lead_id'           => $this->input->post('lead_id'),
                    'created'           => date('Y-m-d H:i:s')
                );
                if( !$department_id = App::save_data( 'task', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Task didn\'t save, Try again!');
                    redirect('/task/task');
                }else{       
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Task has Been  add successfully');
                    redirect('/task');
                }
       
            }
        }
        $data = array();
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        $this->load->view('modal/task_add', $data);
    }/* function End add */

    /**
    *Functionality: loads load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* function End load_script */

    /**
    *Functionality: loads load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* function End load_css */

    /**
    *Functionality: Emai check
    */
    public function check_email(){
        if( $email = $_POST['email']) {
            $count = $this->crm_model->check_data_exist($table = 'leads', $key = 'email', $val = $email);
            if( $count > 0 ){
                echo "true";
            }
        }

    }/* function End email_check */
    
    /**
    *Functionality: loads load_css.php
    */
    public function Prdelete_user() {
        if( isset($_POST['ids']) ) {
            $ids = $_POST['ids'];
            $lid = $_POST['lid'];
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'task');
            $db_activity_id = log_activity('lead_activity',$lid,$get_lead_status="",$new_lead_status="",'Delete a task ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));
            echo "TRUE";
        }
    }/* function End Prdelete_users */

    /**
    *Functionality: Edit task
    */
    public function edit($id) {
        if ( $this->input->post('task_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('task_id');
            $lead_id = $this->input->post('lead_id');
            $status = $this->input->post('status');
            if($status = 'completed') {
                    $ldata = (array) App::get_row_by_where('leads', array('id'=>$lead_id) );
                    $firstname= $ldata['first_name'];
                    $lastname = $ldata['last_name'];
                    $ur=base_url('crm/leads/dashboard/'.$lead_id);
                    $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                    $emailVar['_emailto'] = $PST;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    $emailVar['{lead_url}'] =$ur;
                    send_email('task_created', $emailVar);
            }
            $match = array ('id' => $this->input->post('task_id') );
            $data = array(
                        'task_title'        => $this->input->post('task_title'),
                        'task_desc'         => $this->input->post('task_desc'),
                        'assigned_team'     => $this->input->post('assigned_team'),
                        'status'            => $this->input->post('status')
                );
            $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Edit  Task lead ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));    
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Task has been updated successfully'); 
            App::update('task',$match,$data);
            redirect('/task');
        }else{
            $result = $this->db->select('*')->from('assign_team')->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $data['task'] = (array) App::get_row_by_where('task', array('id' => $id) );
            $this->load->view('modal/edit_task', $data);
            }

     }/* function End edit */
  
    /**
    *Functionality: Get Data For Datatable listing of tasks
    */
    public function taskRows() {
        $columns = array(
                      0 => 'id',
                      1 => 'task_title',
                      2 => 'assigned_team',
                      3 => 'lead_id',
                      4 => 'id'
                 );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "select * from task t where vendor_id = '$vendor_id'";
        $totalData = $this->Task_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;
        if( !empty( $this->input->post('search')['value'] ) ){
            $sql.= "AND ( t.id LIKE '%" . $_REQUEST['search']['value'] . "%'";
            $sql.= "OR t.task_title LIKE '%".$_REQUEST['search']['value']. "%'";
            $sql.= "OR t.task_desc LIKE'%" .$_REQUEST['search']['value']."%'";
            $sql.= "OR t.lead_id LIKE'%" .$_REQUEST['search']['value']."%')";
        }
        $totalFiltered = $this->Task_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$_REQUEST['order'][0]['column']]."   ".$_REQUEST['order'][0]['dir']."  LIMIT ".$_REQUEST['start']." ,".$_REQUEST['length']."   ";
        $total_record = $this->Task_model->custom_query($sql,false,'array');    
        $data = array();  
        if (!empty($total_record)) {
            foreach ($total_record as $task) {
            $daname= (array) App::get_row_by_where('leads', array('id'=>$task['lead_id']) ); 
               $data[] = array( 
                        $task['id'],  
                        $task['task_title'], 
                        $task['assigned_team'],
                        $task['status'],
                        '<a href="'.base_url().'crm/leads/dashboard/'. $task['lead_id'].'">'.$daname['first_name'].' '.$daname['last_name'].'</a>',
                        '<a href="'.base_url().'task/edit/'. $task['id'].'" title="Edit task" class="action-icon" data-animation="fadein" data-plugin="custommodalEdit" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" id="deletetask" title="Delete" class="action-icon" ids="'. $task['id'].'" lid="'.$task['lead_id'].'"> <i class="mdi mdi-delete"></i></a>'

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
    }/* function End task_row */
    
    /**
    *Functionality: assignleads 
    */
    public function assignleads() {
        if( isset($_POST['assignlead'])) {
            $this->db->select("*");
            $this->db->from('leads');
            $this->db->like('first_name', $_POST['assignlead']);
            $this->db->or_like('last_name', $_POST['assignlead']);
            $data = $this->db->get()->result();
            if( !empty($data ) ){
                foreach ($data as $key => $value) {
                    $leads[$value->id] = array(
                        'first_name' => $value->first_name, 
                        'last_name'  => $value->last_name, 
                        'leads_id'  => $value->id
                    );
                }
                echo json_encode($leads);
            }else{ 
                echo "false"; 
            }
        }
    }/* function End assignleads */


}

/* End of file Task.php */