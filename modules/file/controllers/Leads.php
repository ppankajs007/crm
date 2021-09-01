<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class Leads extends MX_Controller
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
        $this->load->model('crm_model');
       
	}

	

	function index()
	{ 	
		if (!$this->tank_auth->is_logged_in()) { // logged in
			redirect('auth/login');
		}

		$data = array();
		// $result = $this->db->select('*')->from('leads')->get();
		// $data['leads'] = $result->result('array');	
  
    $this->db->select('leads.*,status_lead.status, user_profiles.name');    
    $this->db->from('leads');
    $this->db->join('status_lead','status_lead.id = leads.lead_status');
    $this->db->join('user_profiles', 'leads.assigned_to = user_profiles.id');
    $query = $this->db->get();
    $data['leads'] = $query->result('array');
    $this->load->view('auth/index', $data);
		$this->template->title(' Leads');
        $this->template
                ->set_layout('inner')
                ->build('leads', $data);
	}
/**
	 * Change user password
	 * @author Parveen
	 * @return void
	 */
	function add()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			if( $this->input->post() ){

				$post_data = array(
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'source'		=> $this->input->post('lead_source'),
					'created'		=> date('Y-m-d H:i:s'),
					'lead_code'		=> time(),
					'ip'			=> $this->input->ip_address(),
				);

				if( !$lead_id = App::save_data( 'leads', $post_data ) )
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Lead didn\'t save, Try again!');
                    redirect('/crm/leads');
                }
                else
                {		
                	$post_data = array(
                		'lead_id'	=> $lead_id,
                		'note'		=> $this->input->post('note'),
                		'created'	=> date('Y-m-d H:i:s')
                	);
                	App::save_data( 'lead_notes', $post_data );
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Lead added successfully');
                    redirect('/crm/leads');
                }
			}

			} $data = array();
			$this->load->view('modal/lead_add', $data);
	}
	function load_script()
    {
        $data = array();
        $this->load->view('load_script', $data);
    }

    function load_css()
    {
        $data = array();
        $this->load->view('load_css', $data);
    }
    function check_email(){

    	if( $email = $_POST['email'])
    	{
    	 	$count = $this->crm_model->check_data_exist($table = 'leads', $key = 'email', $val = $email);
    	 	if( $count > 0 ){
    	 		echo "true";
    	 	}
    	}

    }
    
    function Prdelete_user(){
	    if( isset($_POST['ids']) ){
	        $ids = $_POST['ids'];
	        
	        $data['userDel'] = $this->user_model->Pkdelete_query($ids,'leads');
	        echo "TRUE";
	    }
	}
	function view_profile($id){
        $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
        $data['lsms'] = (array) App::get_by_where('leads_sms', array('lead_id'=>$id) );

        $order_by = array(
            'column'=> 'chart_time',
            'order' => 'DESC'
        );
        $data['live_chat'] = (array) App::get_by_where('live_chat', array('lead_id'=>$id), $order_by);
        
        
         $order_by = array(
            'column'=> 'activity_message',
            'order' => 'DESC'
        );
        $data['activity_record'] = (array) App::get_by_where('activity_record', array('activity_id'=>$id));

        $this->load->view('auth/index', $data);
        $this->template->title('View Profile');
        $this->template
        ->set_layout('inner')->build('view_profile',$data);
	}
	
	function recive_sms(){
	       
	   // $_POST = array (
    //       'originalsenderid' => '+19179354988',
    //       'body' => 'Chat with you started 5157248',
    //       'message' => 'Chat with you started 5157248',
    //       'sms' => '+16102231415',
    //       'custom_string' => '',
    //       'to' =>'+16102231415',
    //       'original_message_id' => '',
    //       'originalmessageid' => '',
    //       'customstring' => '',
    //       'from' => '+918591041420',
    //       'originalmessage' => '',
    //       'user_id' => '73872',
    //       'subaccount_id' => '86325',
    //       'original_body' => '',
    //       'timestamp' => '1556179523',
    //       'message_id' => 'FBF799B1-2BDC-4D29-86EE-4F9EC69931D7',
    //     );
     App::save_data('log_data',array('log_type'=>'sms_receive','log_data'=> json_encode($_POST) ) );
	    if(isset($_POST['to'] ) ){
            $to_sms = $_POST['to'];
            $from_sms = $_POST['message'];
            $raw = json_encode($_POST);
            $timestamp = $_POST['timestamp'];
            $datetime = date('Y:m:d H:i:s');
            
           // $from_sms_api = (array) App::get_by_where('leads_sms', array('sms_to'=>$to_sms) );
          
            $newstring = substr($to_sms, -10);
            $this->db->select('*');
            $this->db->from('leads');
            $this->db->like("phone","$newstring");
            $query=$this->db->get();
            $from_sms_api = $query->row();
    
          $leadData = array(
        	    'lead_id'   =>$from_sms_api->id,
				'sms_text'	=> $from_sms,
				'sms_to'	=> $to_sms,
				'sms_type'	=> 'in',
				'sms_time'	=> $datetime,
			);
            App::save_data( 'leads_sms',$leadData);
            App::create_activity('lead_activity',$from_sms_api->id,'SMS Received',json_encode($_POST));
	    }
	}
	
	function sendSms() {
	   // if(!$this->input->is_ajax_request){ exit('No Direct call');}
	   if( $_POST ){
	        $adminID = $this->tank_auth->get_user_id();
	        $lid  = $_POST['lid'];
            $nmbr = $_POST['nmbr'];
            $sms  = strip_tags( trim($_POST['sms']) );

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
    				'admin_id'	=> $adminID,
    				'sms_text'	=> $sms,
    				'sms_to'	=> $nmbr,
    				'sms_type'	=> 'out',
    				'sms_time'	=> date('Y:m:d H:i:s'),
    			);
            	App::save_data( 'leads_sms', $leadData );
     	        App::create_activity('lead_activity',$lid,'SMS Sent',json_encode($leadData));
     	        
			} catch (Exception $e) {
			    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
			}
		}
	}
	
	
	// function get_live_chat(){
 //        $data = file_get_contents('php://input');
 //        App::save_data('log_data',array('log_type'=>'livechat','log_data'=>$data) );
 //        $ddata = json_decode($data,true);
    
 //        $msgs = json_encode($ddata['chat']['messages']);
 //        $rt = ''; $rc = 1;
 //        foreach($ddata['chat']['messages'] as $tkey => $tVal){
 //            if($rc <= '2'){
 //                $rt .= $tVal['text'].',';
 //            }
 //        $rc++;}

 //       $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
 //       $lemail = $ddata['visitor']['email'];
 //       $lname = $ddata['visitor']['name'];
 //       $lsource_url = $ddata['visitor']['page_current'];
 //       $result = App::get_row_by_where($table = 'leads', array('email' => $lemail), $order_by = array());
       
 //        if( $result ){ $lead_id = $result->id;
 //        }else{
 //             $post_data = array(
	// 			'first_name'	=> $lname,
	// 			'last_name'		=> '',
	// 			'email'			=> $lemail,
	// 			'source'		=> 3,
	// 			'source_url'    => $lsource_url,
	// 			'created'		=> date('Y-m-d H:i:s'),
	// 			'lead_code'		=> time(),
	// 			'ip'			=> $this->input->ip_address(),
	// 		);
			
 //   	        if( !$lead_id = App::save_data( 'leads', $post_data ) ) { die('DB Error'); }
	//         App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode($post_data));
 //        }
    
 //        $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
 //        foreach($ddata['chat']['agents'] as $akey => $aVal){
 //            $agents_data[] = array('name' => $aVal['name'], 'email' => $aVal['login']);
 //        }
 //        $clData = array(
 //            'lead_id'      => $lead_id,
 //            'agent_data'   => json_encode($agents_data),
 //            'ready_chat'   => $rt,
 //            'chat_mesage'  => $msgs,
 //            'meta_data'    => $data,
 //            'chart_time'   => $date_time
 //    	);
   
 //        App::save_data('live_chat',$clData );
 //        App::create_activity('lead_activity',$lead_id,'Live Chat End',json_encode($clData));
 //    }
    
    /* live_chat**/
    function live_chat(){
         $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('crm/modal/live_chat', $data);
    }

    /* edit_lead**/
	   function edit_leads($id){


                       if ( $this->input->post('id') ) {

                         $newphn=$this->input->post('phone');
             $getlead = (array) App::get_row_by_where('leads', array('phone'=>$newphn) );

                        $name=$this->input->post('first_name');
                       
                        $firstname = strtok($name, ' ');
                        $lastname = strstr($name, ' ');
                   $oldphn=$getlead['phone'];
                              $idd=$getlead['id'];
                              $newphn=$this->input->post('phone');
                                //$newstring = substr($oldphn, -9);
                            if($oldphn == $newphn AND $id != $idd ){

                    $post_data['error'] = array();
                    $this->session->set_flashdata('response_status','error'); 
                    $this->session->set_flashdata('message','Phone number Already Exits ');

                    
                    redirect('/file/leads');

                                

                                      }
             $match=array(
                 'id' => $this->input->post('id'),
                 );
                $config['upload_path']          = './assets/images/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                //$config['max_size']             = 100;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image_upload')){
                $error = array('error' => $this->upload->display_errors());
                print_r( $error );
 
        }else{
            $post_data = array(
            'first_name'    => $firstname,
            'last_name'     => $lastname,
             'email'         => $this->input->post('email'),
             'second_phone'   =>$this->input->post('second_phone'),
             'contact_preprence' =>$this->input->post('contact_preprence'),
             'survey'             =>$this->input->post('survey'),
             'comments'          =>$this->input->post('comments'),
             'assigned_to'        =>$this->input->post('assigned_to'),
             'lead_status'       =>$this->input->post('lead_status'),
             'lost_sale_detail'  =>$this->input->post('lost_sale_detail'),
             'hoteness'          =>$this->input->post('hoteness'),   
             'action_lead'      =>$this->input->post('action_lead'),
             'reminder_date'    => $this->input->post('reminder_date'),
             'note'             => $this->input->post('note'),
             'phone'         => $newphn,
             'image_upload'  =>$this->upload->data('full_path'),
             'created'       => date('Y-m-d H:i:s'),
             'lead_code'     => time(),
            'ip'            => $this->input->ip_address(),
            );
            
        }
              
                  
                    App::update('leads',$match,$post_data);
                    $post_data['success'] = array();
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','User has been Update successfully');
                    
                     redirect('/file/leads/');
                 
                      
                 }else{
                     $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
                     $result = $this->db->select('*')->from('status_lead')->get();
                     $data['lead_statuss'] = $result->result('array'); 
                     $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
                    $data['users'] = $userQuery->result('array');
                     $this->template->title('Edit Lead');
                     $this->template
                    ->set_layout('inner')->build('edit',$data);


                 }
    
    }

    
               
                  
               


}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */