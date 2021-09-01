<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class email_template extends MX_Controller
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
        $this->load->model('email_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login');
		}
       
    }
    /**
    * Functionality : index
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();        
        $data['emailFetch'] = $this->email_model->resultArray('emailSetting');
        $this->template->title('Email');
        $this->template
                ->set_layout('inner')
                ->build('email', $data);
    }/* End Function index */ 

    /**
    * Functionality : loads script load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End Function load_script */ 

    /**
    * Functionality : loads css load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* End Function load_css */ 
    
    /**
    * Functionality : Edit Email 
    */
    public function edit($id) {
        $data = array();
        $id = $this->uri->segment(4);        
        
        if( !empty($this->input->post()) ){
            $postData = array(
                'subject' => $this->input->post('subject'),
                'msg' => $this->input->post('emailBody')
            );
            if($this->email_model->edit('emailSetting',$id,$postData)){    
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Email has been updated');
            } else {
                $this->session->set_flashdata('response_status','error'); 
                $this->session->set_flashdata('message','Email not updated');
            }
            redirect('setting/email_template/edit/'.$this->input->post('emailID'));
        }
        $data['emailData'] = $this->email_model->findWhere('emailSetting',array('id' => $id ),FALSE,array('*'));
        $this->template->title('Email');
        $this->template
                ->set_layout('inner')
                ->build('edit', $data);

     }/* End Function Edit */ 
     
    /**
    * Default route for rendering view
    *
    * @param String $log_date
    */
    public function Log($log_date = NULL) {
		$this->load->library('log_library');
        if ($log_date == NULL) {
        	// default: today
        	$log_date = date('Y-m-d');
        }
        $data['cols'] = $this->log_library->get_file('log-'. $log_date . '.php');
        $data['log_date'] = $log_date;
        $this->load->view('log_view', $data);
	}/* End Function log */ 
     



}