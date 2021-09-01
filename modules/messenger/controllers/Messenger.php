<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class messenger extends MX_Controller
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
    $this->load->model('Msg_model');
    $this->load->model('user_model');
    $current_router = $this->router->fetch_method();
    $expectArr = array('getFBLead','new_message','new_chat');
    if(!in_array( $current_router,$expectArr )){
        if (!$this->tank_auth->is_logged_in()) {
    			redirect('auth/login');
    	}
    }
       
    }
    /*
    *   Functionality - index listing message : 
    *   Call from :  index
    */ 
    public function index() {   
        $data = array();
        $sql = "SELECT * FROM leads ORDER BY last_sms DESC";
        $data['leads'] = $this->Msg_model->custom_query($sql,false,'array');
        $this->load->view('auth/index', $data);
        $this->template->title('messenger');
        $this->template->set_layout('inner')->build('messengers', $data);
   }/* end function initchat */
        
    /*
    *   Functionality - initchat sms : 
    *   Call from :  initchat
    */ 
    public function initchat() {   
        $data = array();
        $con = 'where 1 = 1';
        if(isset($_GET['folder'])){
            $status_type = $_GET['folder']; 
            if($status_type == 'unread'){
                $con = " WHERE read_status = '0' ";
            }else if($status_type == 'read'){
                $con = " WHERE read_status = '1' ";
            }else if($status_type == 'followup'){
                $con = " WHERE fav_status = '1' ";
            }else if($status_type == 'done'){
                $con = " WHERE done_status = '1' ";
            }
        }
        $vendor_id = $this->session->userdata('vendor_id');
        if( empty( $vendor_id ) ) { $vendor_id = '1'; }
            $sql = "SELECT * FROM leads  $con AND vendor_id = '$vendor_id' ORDER BY last_sms DESC ";
            $data['leads'] = $this->Msg_model->custom_query($sql,false,'array');
            $lead_id = $this->uri->segment(3);
        if($lead_id != ''){
            $lead_id = encrypt_decrypt($lead_id,'d');
            $data['sms'] = (array) App::get_by_where('leads_sms', array('lead_id'=> $lead_id ) );
            $data['mlead_id'] = $lead_id;
            $data['mnumber'] = (array) App::get_row_by_where('leads', array('id'=> $lead_id ) );
            App::update('leads_sms', array('lead_id'=> $lead_id, 'sms_type' => 'in' ) , array( 'read_status' => 'read' ));
            App::update('leads', array('id'=> $lead_id ), array( 'read_status' => 1 ));
        }
        $this->load->view('auth/index', $data);
        $this->template->title('messenger');
        $this->template->set_layout('inner')->build('messengers', $data);
    }/* end function initchat */
        
    /*
    *   Functionality - getFBLead facebook lead : 
    *   Call from :  getFBLead
    */ 
    public function getFBLead() {
        $name = $_REQUEST['full_name'];
        $firstname = strtok($name,' ');
        $lastname = strstr($name,' ');
        $phone = $_REQUEST['phone'];
        $lemail = $_REQUEST['email'];
        App::save_data('log_data',array('log_type'=>'facebook','log_data'=> json_encode($_REQUEST) ) ); 
            $post_data = array(
                        'first_name'     => $firstname,
                        'last_name'      => $lastname,
                        'email'          => $lemail,
                        'phone'          =>  $phone,
                        'source_url'     => 'facebook',
                        'created'        => date('Y-m-d H:i:s'),
                        'lead_code'      => time(),
                        'ip'             => $this->input->ip_address(),
                    );
        if( !$lead_id = App::save_data( 'leads', $post_data ) ) { 
            log_message( 'error', 'Leads_getFBLead' . $this->db->_error_message() );
        }else{
            $leadactivaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' => $lead_id,
                            'activity'=> 'Facebook lead added'
                         );
            App::LogActivity($leadactivaty);
              }
    }/* end function getFBLead */
        
  
        
    /*
    *   Functionality - check_email lead check_email email Exits : 
    *   Call from :  check_email
    */ 
    public function check_email(){
        if( $email = $_POST['email']) {
            $count = $this->Msg_model->check_data_exist($table = 'leads', $key = 'email', $val = $email);
            if( $count > 0 ){
                echo "true";
            }
        }
        
    }/* end function check_email */
        
    /*
    *   Functionality - new_message lead new_message : 
    *   Call from :  new_message
    */ 
    public function new_message() {
        if( isset( $_REQUEST )) {
            $message   = $_REQUEST['message'];
            $to_sms    = $_REQUEST['to_sms'];
            $lead_id = $this->Msg_model->findWhere('leads',array('phone' => $to_sms ),FALSE,array('id'));
            $data = array(
                    'lead_id'     => $lead_id['id'],
                    'sms_to'      => $to_sms,
                    'sms_text'    => $message,
                    'read_status' => 'read',
                    'sms_type'    => 'out',
                    'admin_id'    => '1',
                    'sms_time'    => date('Y-m-d h:i:s')
                );
            $query = $this->db->insert('leads_sms',$data);
                if( $query == true ){
                    echo "new data insert";
                   

                }

            }
    }/* end function New_message */
    
    /*
    *   Functionality - new_chat lead add Through chat : 
    *   Call from :  new_chat
    */  
    public function new_chat() {
        if( $this->input->post() ){
            $out_no = $this->input->post('phone');
            $newstring = substr($out_no, -10);
            $this->db->select('*');
            $this->db->from('leads');
            $this->db->like("phone","$newstring");
            $query=$this->db->get();
            $no_api = $query->row();
                if(!empty($no_api->phone)){
                    $oldphn=$no_api->phone;
                }else{
                    $oldphn='';
                }
            if($oldphn != $out_no) {
                $name=$this->input->post('first_name');
                $firstname = strtok($name,' ');
                $lastname = strstr($name,' ');
                $vendor_id = $this->session->userdata('vendor_id');
                $post_data = array(
                            'first_name'     => $firstname,
                            'last_name'      => $lastname,
                            'email'          => $this->input->post('email'),
                            'phone'          => $this->input->post('phone'),
                            'note'           => $this->input->post('note'),
                            'source'         => 'other',
                            'vendor_id'      => $vendor_id,
                            'note'           =>$this->input->post('note'),
                            'created'        => date('Y-m-d H:i:s'),
                            'lead_code'      => time(),
                            'last_sms'       => time(),
                            'ip'             => $this->input->ip_address(),
                        );
                if( !$lead_id = App::save_data( 'leads', $post_data ) ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Lead didn\'t save, Try again!');
                }else{
                    $adminID = $this->tank_auth->get_user_id();
                    $lid  = $lead_id;
                    $nmbr = $this->input->post('phone');
                    $sms  = strip_tags( trim($this->input->post('note')) );
                    $config = ClickSend\Configuration::getDefaultConfiguration()
                    ->setUsername('tbeaudry')
                    ->setPassword('FB78E17B-46DF-10CB-D3B7-8D0618603E2C');
                    $apiInstance = new ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);
                    $msg = new \ClickSend\Model\SmsMessage();
                    $msg->setFrom('+17325043371'); 
                    $msg->setBody($sms); 
                    $msg->setTo($nmbr);
                    $msg->setSource("sdk");
                    // \ClickSend\Model\SmsMessageCollection | SmsMessageCollection model
                    $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
                    $sms_messages->setMessages([$msg]);
                        try {
                            $result = $apiInstance->smsSendPost($sms_messages);
                            $leadData = array(
                                          'lead_id'   => $lid,
                                          'admin_id'  => $adminID,
                                          'sms_text'  => $sms,
                                          'sms_to'    => $nmbr,
                                          'sms_type'  => 'out',
                                          'sms_time'  => date('Y:m:d H:i:s'),
                                        );
                            App::update('leads', array('id' =>$lid) , array('last_sms' => time()) );
                            App::save_data( 'leads_sms', $leadData );
                            $db_activity_id = log_activity('lead_activity',$lid, $get_lead_status = "", $new_lead_status="",'Add Lead in Sms: '.$firstname. " ".$lastname,'activity_record');
                            $post_data2 = array( 'activity_id' => $db_activity_id );
                            $post_adding = array_merge( $post_data, $post_data2 );
                            log_message('error',serialize( $post_adding ));
                            
                            //pushalert starts
                            $message = 'From Sms. #'.$this->db->insert_id().'-'.$firstname;
                            $url =  base_url()."crm/leads";
                            $imageurl = base_url()."assets/leadsfiles/logo_192_by_192.png";
                            $post_vars = array(
                                            "icon"    => $imageurl,
                                            "title"   => 'New Lead',
                                            "message" => $message,
                                            "url"     => $url,
                                        );
                            pushalert($post_vars); 
                            //pushalert ends
                            } catch (Exception $e) {
                                echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
                                }
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Message send successfully');
                    $liddd = encrypt_decrypt($lid,'e');
                    redirect('messenger/initchat/'.$liddd);
                    }
                }else{
                    $out_no = $this->input->post('phone');
                    $newstring = substr($out_no, -10);
                    $this->db->select('*');
                    $this->db->from('leads');
                    $this->db->like("phone","$newstring");
                    $query=$this->db->get();
                    $no_api = $query->row();
                    $idd=$no_api->id;
                    $adminID = $this->tank_auth->get_user_id();
                    $lid  = $idd;
                    $nmbr = $this->input->post('phone');
                    $sms  = strip_tags( trim($this->input->post('note')) );
                    $config = ClickSend\Configuration::getDefaultConfiguration()
                    ->setUsername('tbeaudry')
                    ->setPassword('FB78E17B-46DF-10CB-D3B7-8D0618603E2C');
                    $apiInstance = new ClickSend\Api\SMSApi(new GuzzleHttp\Client(),$config);
                    $msg = new \ClickSend\Model\SmsMessage();
                    $msg->setFrom('+17325043371'); 
                    $msg->setBody($sms); 
                    $msg->setTo($nmbr);
                    $msg->setSource("sdk");
                    $sms_messages = new \ClickSend\Model\SmsMessageCollection(); 
                    $sms_messages->setMessages([$msg]);
                        try {
                            $result = $apiInstance->smsSendPost($sms_messages);
                               $leadData = array(
                                              'lead_id'   => $lid,
                                              'admin_id'  => $adminID,
                                              'sms_text'  => $sms,
                                              'sms_to'    => $nmbr,
                                              'sms_type'  => 'out',
                                              'sms_time'  => date('Y:m:d H:i:s'),
                                            );
                            App::update('leads', array('id' =>$lid) , array('last_sms' => time()) );
                            App::save_data( 'leads_sms', $leadData );
                            $liddd = encrypt_decrypt($lid,'e');
                            redirect('messenger/initchat/'.$liddd);
                            } catch (Exception $e) {
                                echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
                                }
                    }
        }
        $this->load->view('modal/new_chat');
    }/* end function new_chat */
        
    /*
    *   Functionality - getsmsStatus lead sms : 
    *   Call from :  getsmsStatus
    */ 
    public function getsmsStatus() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $lead_id = $_POST['lead_id'];
        $lead_status_type = $_POST['lead_status'];
        if($lead_id != ''){
            if ($lead_status_type =='Mark as Done') {
                $col = array (
            'done_status' => 1
            );
            }else if($lead_status_type =='Mark as Fav'){
                $col = array (
                        'fav_status' => 1
                        );
            }else if($lead_status_type =='Mark as Unread'){
                $col = array (
                        'read_status' => 0
                        );
                }
            App::update('leads', array('id'=> $lead_id ), $col);
            echo $this->db->last_query();
            $data['lead'] = (array) App::get_row_by_where('leads', array('id'=> $lead_id ) );
            $return = array( 
                        'read_status'  => $data['lead']['read_status'], 
                        'fav_status'   => $data['lead']['fav_status'], 
                        'done_status'  => $data['lead']['done_status']
                        );  
            echo json_encode($return);  
        }
    } /* end function getsmsStatus */
    
      /*
    *   Functionality - load_script Js file load : 
    *   Call from :  load_script
    */ 
    public  function load_script()  {
        $data = array();
        $this->load->view('load_script', $data);
    }

    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* end function load_css */
    

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */