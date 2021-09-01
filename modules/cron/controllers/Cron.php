<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Cron extends MX_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->module('layouts');
        $this->load->library('template');
        $this->load->model('cron_model');
        $this->load->model('user_model');
           
	}

    /* functionnallty send email status */
	public function send_status_email() {
	    $lead_id = "";
        $PMT = get_row_data(array('email'),'assign_team', array('code'=>'PMT') )->email;
        $QT = get_row_data(array('email'),'assign_team', array('code'=>'QT') )->email;
        $qf_date = $this->cron_model->custom_query("SELECT id, first_name, last_name, qf_status, qf_dateAdded as added_date FROM leads WHERE qf_email_sent ='0'  AND qf_status='Not Started' AND qf_dateAdded <= (NOW() - INTERVAL 2 HOUR)",false,'array');
        $qc_date = $this->cron_model->custom_query("SELECT id, first_name, last_name, qf_status, qc_start_date as added_date FROM leads WHERE qc_email_sent ='0'  AND qf_status='Ready for Q/C' AND qc_start_date <= (NOW() - INTERVAL 1 HOUR)",false,'array');
	    if( isset( $qf_date ) && !empty( $qf_date ) ){
    	   foreach( $qf_date as $qf => $qfVal) {
                $emailVar['_emailto'] = $PMT;
                $emailVar['{name}'] = $qfVal['first_name'].' '.$qfVal['last_name'];
                $mStatus = send_email('not_started', $emailVar);
                if( $mStatus == 'Email Sent'){
                    $where = array( 'id' => $qfVal['id'] );
                    $updateData = array( 'qf_email_sent' => '1');
                    App::update('leads',$where,$updateData);
                    /* log message  */
                    $db_activity_id = log_activity('lead_activity',$lead_id, $get_lead_status = $PMT, $new_lead_status = $qfVal['first_name']."  ".$qfVal['last_name'],'Add Lead Facebook: '.$firstname. " ".$lastname,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    log_message('error',serialize( $post_data2 ));
                }
    	   }
	    }
	    if( isset( $qc_date ) && !empty( $qc_date ) ){
       	   foreach( $qc_date as $qc => $qcVal){
                $emailVar['_emailto'] = $QT;
                $emailVar['{name}'] = $qcVal['first_name'].' '.$qcVal['last_name'];
                $mStatus = send_email('ready_for_qc', $emailVar);
                if( $mStatus == 'Email Sent'){
                    $where = array( 'id' => $qcVal['id'] );
                    $updateData = array( 'qc_email_sent' => '1');
                    App::update('leads',$where,$updateData);
                    /* log message  */
                    $db_activity_id = log_activity('lead_activity',$lead_id, $get_lead_status = $PMT, $new_lead_status = $qfVal['first_name']."  ".$qfVal['last_name'],'Add Lead Facebook: '.$firstname. " ".$lastname,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    log_message('error',serialize( $post_data2 ));
                }
            }
	   }
    }

}

/* End of file Cron.php */
