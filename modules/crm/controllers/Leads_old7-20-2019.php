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
        $this->load->model('user_model');
        
        $currentMethod = $this->router->fetch_method();
        $exceptArr = array('getFBLead','recive_sms','get_live_chat','sendSms');
        if( !in_array($currentMethod,$exceptArr) ){
            if (!$this->tank_auth->is_logged_in()) {
    			redirect('auth/login');
    		}
    	}
	}

	
	function dashboard($id)
	{ 	
        $data = array();
        $leads = App::get_row_by_where('leads', array('id'=>$id) );
        if(!empty( $leads ) ){ $data['leads'][] = $leads; }
        $Mleads = App::get_row_by_where('leads', array('id'=>$id ) );
        
        if(!empty( $Mleads ) ){ $data['Mleads'][] = $Mleads; }
        
        $scstats = App::get_row_by_where('leads', array('id'=>$id , 'qf_status'=>int_lead_Hold_On_Design ) );
        
        if(!empty($scstats)){
            $hold_desgin = App::get_row_by_where('hold_on_desgin', array('lead_id'=>$id ) );
            if(!empty( $hold_desgin ) ){
                $data['hold'][] = $hold_desgin;
            }
        } else {
            $data['hold'][] = '';
        }
        
        $leads_id =  $this->uri->segment(4);
        $data['lsms'] = (array) App::get_by_where('leads_sms', array('lead_id'=>$leads_id) );
        $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ');
        $this->db->from('activity_record');
        $this->db->where(array('activity_id' => $leads_id, 'activity_name' => 'lead_activity','activity_record.user_id' => $this->tank_auth->get_user_id() ));
        $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
        $this->db->order_by('activity_recordID', 'DESC');
        $query = $this->db->get();
        $Pdata = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $leads_id ), array('*') );
       
        if(!empty($pdata)){ $data['pw_pending']=$pdata; } else { $data['pw_pending']=''; }
        $data['activities'] = $query->result('array');
        $data['pw_pending'] = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $leads_id ), array('*') );
        $this->db->select('*');
        $this->db->from('task');
        $this->db->where(array('lead_id' => $leads_id));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $data['task'] = $query->result('array');
        
        $this->template->title(' Leads');
              $this->template
                      ->set_layout('inner')
                      ->build('dashboard', $data);
	}

	function index()
	{ 	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login');
		}

		$data = array();
		$data['Select_status'] = $this->crm_model->fetch_all('status_lead');
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        
        $this->load->view('auth/index', $data);
        $this->template->title(' Leads');
        $this->template->set_layout('inner')->build('leads', $data);
	}
	
	function getFBLead()
	{
	    $name = $_REQUEST['full_name'];
	    $firstname = strtok($name,' ');
        $lastname = strstr($name,' ');
	    $phone = $_REQUEST['phone'];
	    $lemail = $_REQUEST['email'];
	  
	    App::save_data('log_data',array('log_type'=>'facebook','log_data'=> json_encode($_REQUEST) ) );	

	    $post_data = array(
			'first_name'	=> $firstname,
			'last_name'		=> $lastname,
			'email'			=> $lemail,
			'phone'         =>  $phone,
			'source_url'    => 'facebook',
			'created'		=> date('Y-m-d H:i:s'),
			'lead_code'		=> time(),
			'vendor_id'     => '1',
			'ip'			=> $this->input->ip_address(),
		);

        if( !$lead_id = App::save_data( 'leads', $post_data ) ) {  die('DB Error'); } else {
                    //Push Alert Web Notification
                    $message = 'From Facebook. #'.$this->db->insert_id().'-'.$firstname;
                    $url = "https://perfectionkitchens.com/crm/administrator/crm/leads";
                    //POST variables
                    $post_vars = array(
                    	"icon" => "https://perfectionkitchens.com/logo_192_by_192.png",
                    	"title" => 'New Lead',
                    	"message" => $message,
                    	"url" => $url,
                    );
                    pushalert($post_vars); 
        }
    }
	
     function notes($id){   
        $data = array();
        $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array'); 
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
      
        if ( $this->input->post('lead_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('lead_id');
            
            $match = array (
                'id' => $this->input->post('lead_id'),
            );
            $data = array( 'note'  => $this->input->post('note') );
            $query = $this->crm_model->select_where('first_name','leads',array('id' => $this->input->post('lead_id') ));
            $activaty = array( 
                    'user_id' => $this->tank_auth->get_user_id(),
                    'module'  => 'leads',
                    'field_id' => $match['id'],
                    'activity'=> 'Created a Note : '.$query->first_name
                  );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Note has been updated');
            App::LogActivity($activaty);
            
           $db_activity_id = log_activity('lead_activity',$id,$old = '',$new = '','Update a Note','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $data, $post_data2 );
           log_message('error',serialize($post_adding));
            
           App::update('leads',$match,$data);
           redirect('/crm/leads/notes/'.$this->input->post('lead_id')); 
        }

        $this->template->title('Leads');
        $this->template
            ->set_layout('inner')
            ->build('leads/notes', $data);
    }

    function files(){
      $id = $this->uri->segment(4);
          $data = array();
          $data['file_data'] = $this->crm_model->findWhere('files', array('field_id' => $id ), array('*') );
          $this->template->title('File');
              $this->template
                      ->set_layout('inner')
                      ->build('leads/file', $data);
  }
  
  function chats($id){
      $id = $this->uri->segment(4);
      
       $data['live_chats'] = (array) App::get_by_where('live_chat', array('lead_id'=>$id));
        $this->template->title('Chat');
              $this->template
                      ->set_layout('inner')
                      ->build('leads/livechat', $data);
      
      }
      
    function chat_record(){
         $id = $this->uri->segment(4);
         $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
         $this->load->view('crm/modal/chat_record', $data);
    }


    function add_file(){
        $id =  $this->uri->segment(4);
        $data = array();
        $config = array(
            'upload_path' => "assets/leadsfiles",
            'allowed_types' => "*"
        );
   
      $this->load->library('upload', $config);
         $this->upload->initialize($config);

      if(!$this->upload->do_upload('image_upload')){
        $error = array('error' => $this->upload->display_errors());
      } else {

          if(!empty($this->input->post() ) ){
              
          $query = $this->crm_model->select_where('first_name','leads',array('id' => $this->input->post('leads_id') ));
          $data = array( 

                    'field_id'     => $this->input->post('leads_id'),
                    'module_name'  => 'leads', 
                    'file_name'    => $this->upload->data('file_name'),
                    'title'        => $this->input->post('title'),
                    'path'         => $this->upload->data('file_path'),
                    'lead_file_type' => $this->input->post('lead_file_type'),
                    'ext'          => $this->upload->data('file_ext'),
                    'size'         => $this->upload->data('file_size'),
                    'is_image'     => $this->upload->data('is_image'),
                    'description'  => $this->input->post('description'),
                    'created_by'   => $this->tank_auth->get_user_id()

                  );


            $activaty = array( 
                            'user_id' => $data['created_by'],
                            'module'  => 'leads',
                            'field_id' => $data['field_id'],
                            'activity'=> 'Created a file : '.$data['module_name']
                          );
                if( !$lead_id = App::save_data( 'files', $data )  ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
                } else {
                    
                   $db_activity_id = log_activity('lead_activity',$id,$get_lead_status = '',$new_lead_status = '','Created a file : '.$data['module_name'],'activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id);
                   $post_adding = array_merge( $data, $post_data2 );
                   log_message('error',serialize($post_adding));
                    
                    App::LogActivity($activaty);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File added successfully');
                }
                 redirect('/crm/leads/files/'.$id);
          }
      }
     
    $this->load->view('modal/add_file',$id);
  }

	function add()
	{
    if (!$this->tank_auth->is_logged_in()) {							
			redirect('/auth/login/');

		} else {
			if( $this->input->post() ){

				$post_data = array(
					'first_name'	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
					'email'			=> $this->input->post('email'),
					'phone'			=> $this->input->post('phone'),
					'source'		=> $this->input->post('lead_source'),
                    'note'    => $this->input->post('note'),
					'created'		=> date('Y-m-d H:i:s'),
                    'lead_status' => $this->input->post('lead_status'),
					'lead_code'		=> time(),
					'ip'			=> $this->input->ip_address(),
					'vendor_id'     => $this->session->userdata('vendor_id')
				);

				if( !$lead_id = App::save_data( 'leads', $post_data ) )
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Lead didn\'t save, Try again!');
                    redirect('/crm/leads');
                }
                else
                {	
                    //Push Alert Web Notification
                    $message = 'New Lead Created. #'.$this->db->insert_id().'-'.$this->input->post('first_name');
                    $url = "https://perfectionkitchens.com/crm/administrator/crm/leads";
                    //POST variables
                    $post_vars = array(
                    	"icon" => "https://perfectionkitchens.com/logo_192_by_192.png",
                    	"title" => 'New Lead',
                    	"message" => $message,
                    	"url" => $url,
                    );
                    pushalert($post_vars); 
                    
                	$post_data = array(
                		'lead_id'	=> $lead_id,
                		'note'		=> $this->input->post('note'),
                		'created'	=> date('Y-m-d H:i:s')
                	);

                   $leadactivaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' => $post_data['lead_id'],
                            'activity'=> 'Add Lead :'.$this->input->post('first_name')
                          );
                    
                   $db_activity_id = log_activity('lead_activity',$post_data['lead_id'],$get_lead_status = "",$new_lead_status="",'Add Lead: '.$this->input->post('first_name'). " ".$this->input->post('last_name'),'activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id );
                   $post_adding = array_merge( $post_data, $post_data2 );
                   log_message('error',serialize($post_adding));
                          
                	App::save_data( 'lead_notes', $post_data );
                    App::LogActivity($leadactivaty);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Lead added successfully');
                    redirect('/crm/leads');
                }
			}

			} $data = array();

        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array');
        $this->load->view('modal/lead_add', $data);
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
            if($data == true){
            echo "TRUE";
            } else {
                echo "FALSE";
            }
        }
    }


  function DeleteFiles(){
      if( isset($_POST['ids']) ){
          $ids = $_POST['ids'];
          $leads_id = $_POST['leads_id'];
          
          $data['userDel'] = $this->crm_model->Pkdelete_file(array('file_id' => $ids),'files');
          if( $data == true ){
            $query = $this->crm_model->select_where('first_name','leads',array('id' => $leads_id ));
            $activaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' => $leads_id,
                            'activity'=> 'Delete a file : '.$query->first_name
                          );
             $db_activity_id = log_activity('lead_activity',$_POST['ids'],$get_lead_status = "",$new_lead_status="",'Delete a file : '.$query->first_name,'activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id );
                   $post_adding = array_merge( $activaty, $post_data2 );
                   log_message('error',serialize($post_adding));              
            
            
           App::LogActivity($activaty);
            echo "TRUE";
          } else {
            return "false";
          }
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
	function stripslashes_deep($value) {
    $value = is_array($value) ?
      array_map('stripslashes_deep', $value) :
      stripslashes($value);
    return $value;
  }

	function recive_sms(){
	
       if (get_magic_quotes_gpc()) {
          $_POST = $this->stripslashes_deep($_POST);
        }
     App::save_data('log_data',array('log_type'=>'sms_receive','log_data'=> json_encode($_POST) ) );
	    if(isset($_POST['to'] ) ){
            $to_sms = $_POST['from'];
            $from_sms = $_POST['message'];
            $raw = json_encode($_POST);
            $timestamp = $_POST['timestamp'];
            $datetime = date('Y:m:d H:i:s');
            $newstring = substr($to_sms, -10);
            $this->db->select('*');
            $this->db->from('leads');
            $this->db->like("phone","$newstring");
            $query=$this->db->get();
            $from_sms_api = $query->row();
          $adminID = $this->tank_auth->get_user_id();
          $leadData = array(
                'lead_id'   => $from_sms_api->id,
				'sms_text'	=> $from_sms,
				'sms_to'	=> $to_sms,
				'sms_type'	=> 'in',
				'read_status'	=> 'unread',
				'sms_time'	=> $datetime,
			);

           $logData = array(
                                'user_id' => $adminID,
                                'module'  => 'Leads',
                                'field_id' => $from_sms_api->id,
                                'activity' => 'SMS Received'.$leadData['sms_to']                      
                    );
                    
           
           $db_activity_id = log_activity('lead_activity',$from_sms_api->id,$get_lead_status="",$new_lead_status="",'SMS Received '.$leadData['sms_to'],'activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $leadData, $post_data2 );
           log_message('error',serialize($post_adding));
            
           App::update('leads', array('id' =>$from_sms_api->id) , array('last_sms' => time()) );
           App::save_data( 'leads_sms',$leadData);
             //Push Alert Web Notification
            $message = $from_sms;
            $url =  base_url()."messenger/initchat/".encrypt_decrypt($from_sms_api->id, 'e'); 
            //POST variables
            $post_vars = array(
            	"icon" => "https://perfectionkitchens.com/logo_192_by_192.png",
            	"title" => 'New SMS',
            	"message" => $message,
            	"url" => $url,
            );
            pushalert($post_vars); 
             $activitie =  (array) App::LogActivity( $logData );
            App::create_activity('lead_activity',$from_sms_api->id,'SMS Received',json_encode($_POST));
	    }
	}
	
	function sendSms() {
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
                 $logData = array(
                                'user_id' => $adminID,
                                'module'  => 'Leads',
                                'field_id' => $lid,
                                'activity' => 'SMS Sent:'.$leadData['sms_to']                     
                    );
                    
           $db_activity_id = log_activity('lead_activity',$lid,$get_lead_status="",$new_lead_status="",'SMS Send '.$leadData['sms_to'],'activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_lead_status->status );
           $post_adding = array_merge( $leadData, $post_data2 );
           log_message('error',serialize($post_adding));
                
                App::update('leads', array('id' =>$lid) , array('last_sms' => time()) );
            	App::save_data( 'leads_sms', $leadData );
                $activitie =  (array) App::LogActivity( $logData );
     	        App::create_activity('lead_activity',$lid,'SMS Sent',json_encode($leadData));
     	        
			} catch (Exception $e) {
			    echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
			}
		}
	}
	
	
	function get_live_chat(){
	    
        $data = file_get_contents('php://input');
        App::save_data('log_data',array('log_type'=>'livechat','log_data'=>$data) );
        $ddata = json_decode($data,true);
        
        $msgs = json_encode($ddata['chat']['messages']);
        $rt = ''; $rc = 1;
        if(!empty($ddata['chat']['messages'])){
        foreach($ddata['chat']['messages'] as $tkey => $tVal){
            if($rc <= '2'){
                $rt .= $tVal['text'].',';
            }
        $rc++;}
        
        }

        $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
        $lemail = $ddata['visitor']['email'];
        $lname = $ddata['visitor']['name'];
        $lsource_url = $ddata['visitor']['page_current'];
        if(!empty($lemail)){
            $result = App::get_row_by_where($table = 'leads', array('email' => $lemail), $order_by = array()); 
            $lead_id = $result->id;
        }else{
            
          
           
            $post_data = array(
				'first_name'	=> 'unkwon',
				'last_name'		=> '',
				'email'			=> 'unkown@perfectionkitchens.com',
				'source'		=> 3,
				'vendor_id'      =>vendor_id,
				'source_url'    => $lsource_url,
				'created'		=> date('Y-m-d H:i:s'),
				'lead_code'		=> time(),
				'ip'			=> $this->input->ip_address(),
    		);
            $result = App::get_row_by_where($table = 'leads', array('email' => $post_data['email']), $order_by = array()); 
            $lead_id = $result->id;
            if( $result->parent_lead  ){ $lead_id = $result->parent_lead; }
            
            if(!empty($result)){
                   
                $clData = array(
                    'lead_id'      => $lead_id,
                    'agent_data'   => json_encode($agents_data),
                    'ready_chat'   => $rt,
                    'chat_mesage'  => $msgs,
                    'meta_data'    => $data,
                    'log_time'     =>time(),
                    'chart_time'   => $date_time
            	);
                	
                $livData = array(
                    'user_id' => $this->tank_auth->get_user_id(),
                    'module'  => 'Leads',
                    'field_id' => $clData['lead_id'],
                    'activity' => 'Live Chat End'                      
                );
                App::save_data('live_chat',$clData );
            }else{
                if( !$lead_id = App::save_data( 'leads', $post_data ) ) { die('DB Error'); }
                    
                    $adminID = $this->tank_auth->get_user_id();
                    $logData_liv = array(
                        'user_id' => $this->tank_auth->get_user_id(),
                        'module'  => 'Leads',
                        'field_id' => $lead_id,
                        'activity' => 'Live Chat End'                      
                    );
        	        App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode($post_data));
                    App::LogActivity($logData_liv);
        
                    $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
                    if(!empty($ddata['chat']['agents'])){
                        foreach($ddata['chat']['agents'] as $akey => $aVal){
                            $agents_data[] = array('name' => $aVal['name'], 'email' => $aVal['login']);
                        }
                    }
                    $clData = array(
                        'lead_id'      => $lead_id,
                        'agent_data'   => json_encode($agents_data),
                        'ready_chat'   => $rt,
                        'chat_mesage'  => $msgs,
                        'meta_data'    => $data,
                        'log_time'     =>time(),
                        'chart_time'   => $date_time
                	);
                    $livData = array(
                        'user_id' => $this->tank_auth->get_user_id(),
                        'module'  => 'Leads',
                        'field_id' => $clData['lead_id'],
                        'activity' => 'Live Chat End'                      
                    );
                    
                    $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Add a lead form messanger','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $clData, $post_data2 );
                    log_message('error',serialize($post_adding));
                    
                    App::save_data('live_chat',$clData );
                    App::create_activity('lead_activity',$lead_id,'Live Chat End',json_encode($clData));
                    App::LogActivity($livData); 
                }
    
       }
      
      if( $result ){ $lead_id = $result->id;
        }else{
             $post_data = array(
				'first_name'	=> $lname,
				'last_name'		=> '',
				'email'			=> $lemail,
				'source'		=> 3,
				'source_url'    => $lsource_url,
				'created'		=> date('Y-m-d H:i:s'),
				'lead_code'		=> time(),
				'ip'			=> $this->input->ip_address(),
			);

        if( !$lead_id = App::save_data( 'leads', $post_data ) ) { die('DB Error'); }
            $adminID = $this->tank_auth->get_user_id();
            $logData_liv = array(
                'user_id' => $this->tank_auth->get_user_id(),
                'module'  => 'Leads',
                'field_id' => $lead_id,
                'activity' => 'Live Chat End'                      
                );
            $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Add a lead form messanger','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $logData_liv, $post_data2 );
            log_message('error',serialize($post_adding));
    	    App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode($post_data));
            App::LogActivity($logData_liv);
        }
        $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
        if(!empty($ddata['chat']['agents'])){
            foreach($ddata['chat']['agents'] as $akey => $aVal){
                $agents_data[] = array('name' => $aVal['name'], 'email' => $aVal['login']);
            }
        }
        $clData = array(
            'lead_id'      => $lead_id,
            'agent_data'   => json_encode($agents_data),
            'ready_chat'   => $rt,
            'chat_mesage'  => $msgs,
             'log_time'     =>time(),
            'meta_data'    => $data,
            'chart_time'   => $date_time
    	);
        $livData = array(
            'user_id' => $this->tank_auth->get_user_id(),
            'module'  => 'Leads',
            'field_id' => $clData['lead_id'],
            'activity' => 'Live Chat End'                      
        );
        
        App::save_data('live_chat',$clData );
        App::create_activity('lead_activity',$lead_id,'Live Chat End',json_encode($clData));
        App::LogActivity($livData);
    
	    
	}
  
   function live_chat(){
         $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('crm/modal/live_chat', $data);
    }

	 function edit_leads($id){


                       if ( $this->input->post('id') ) {
                            
                            //check if email already exists starts
                            $olddata = (array) App::get_row_by_where( 'leads', array( 'id' => $id ) );
                            $new_email = $this->input->post('email');
                            // if ( $new_email != $olddata['email'] ) {
                    
                            //     $sql = "SELECT * FROM leads WHERE email = '$new_email' AND id <> '$id'";
                            //     $count = $this->crm_model->custom_query($sql,TRUE,'array');
                            //     if ( $count > 0 ) {
                            //         $this->session->set_flashdata('response_status','error'); 
                            //         $this->session->set_flashdata('message','Email Already Exists ');
                            //         redirect('/crm/leads');
                            //     }  
                            // }
                            //check if email already exists ends
                            
                            $newphn=$this->input->post('phone');
                            $getlead = (array) App::get_row_by_where('leads', array('phone'=>$newphn) );

                              $name=$this->input->post('first_name');
                              $firstname = strtok($name,' ');
                              $lastname = trim(strstr($name,' '));
                              $oldphn=$getlead['phone'];
                              $idd=$getlead['id'];
                               
                            if($oldphn == $newphn AND $id != $idd ){

                    $this->session->set_flashdata('response_status','error'); 
                    $this->session->set_flashdata('message','Phone number Already Exits ');

                    
                    redirect('/crm/leads');
         
                                      }
                  $match=array(
                 'id' => $this->input->post('id'),
                              );
               
                  $image=$this->input->post('image_upload');
                 $new_date1 = strtotime($this->input->post('reminder_date'));
                  $new_date = date('Y-m-d', $new_date1);
                  $lead_status = (array) App::get_row_by_where('leads', array('id'=>$id) );
                  $old=$lead_status['lead_status'];
                  $rem_date=$lead_status['reminder_date'];

                   $timestamp = strtotime( $rem_date); 
                 $rem = date('m-d-Y', $timestamp);

            

                  $timestamp = strtotime($this->input->post('reminder_date')); 
                 $ndate = date('m/d/Y', $timestamp);


                 $old_status = (array) App::get_row_by_where('status_lead', array('id'=>$old) );
                 if(!empty($old_status)){
                     $ol=$old_status['status'];
                 }else{
                      $ol='';
                 }
                 
                 $st= $this->input->post('lead_status');
                 $get_status = (array) App::get_row_by_where('status_lead', array('id'=>$st) );
                 if(!empty($get_status)){
                      $add_stauts= $get_status['status'];
                 }else{
                     
                     $add_stauts="";
                 }
                
         
                 $adminID = $this->tank_auth->get_user_id();
                 $status_id= $lead_status['lead_status'];
                  
              if($status_id != $st  ){
                                    $status_data = array( 
                                              'user_id' => $adminID,
                                              'module'  => 'leads',
                                              'field_id' => $this->input->post('id'),
                                              'activity'=> 'Status change : '.$ol .'  to  '.$add_stauts
                                              );
                                          App::LogActivity($status_data);
                                            }
           if($ndate != $rem  ){
                                    $date_status = array( 
                                              'user_id' => $adminID,
                                              'module'  => 'leads',
                                              'field_id' => $this->input->post('id'),
                                              'activity'=> 'Next Step Date  change : '.$rem .'  to  '.$ndate
                                              );
                                    
                                          App::LogActivity($date_status);
                                            }
                                             $ass = $this->input->post('assigned_to'); 

                                              $assnto = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                                              $leads_ass = (array) App::get_row_by_where('leads', array('id'=>$id) );
                                              $assign_to_name =  $get_lead_status = get_row_data('name','user_profiles',array('id' => $leads_ass['assigned_to'] ));
                                            
                                            if(empty( $assign_to_name->name)){$assignName="";}else{$assignName=$assign_to_name->name;}
                                          
                                          if($ass != $leads_ass['assigned_to']){
                                               $assntoo = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                                               if(empty($assntoo)){ $asignto= "";}else{$asignto=$assntoo['name']; }
                                                            $lead_ass = array( 
                                                                      'user_id' => $adminID,
                                                                      'module'  => 'leads',
                                                                      'field_id' => $this->input->post('id'),
                                                                      'activity'=> 'Assgin Change : '.$assignName 
                                                                      );
                                                                      
           $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status=$assignName,$new_lead_status=$asignto,'Assgin Change : '.$asignto,'activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $lead_ass, $post_data2 );
           log_message('error',serialize($post_adding));
                                                                  App::LogActivity($lead_ass);
                                                                    }

                                                   $assgn =$this->input->post('action_lead');
                                                   $assnlead = (array) App::get_row_by_where('leads', array('id'=>$id) );
                                                   
                                                   if( empty( $assnlead['action_lead'] ) ){
                                                       $action = "";
                                                   } else {
                                                       $action =$assnlead['action_lead'];
                                                   }

                                             if( $assgn != $action  ){
                                         $assgdata = array( 
                                              'user_id' => $adminID,
                                              'module'  => 'leads',
                                              'field_id' => $this->input->post('id'),
                                              'activity'=> 'Next Step change : '.$action .'  to  '.$assgn
                                              );
            $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status=$action,$new_lead_status=$assgn,'Next Step change :','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $assgdata, $post_data2 );
           log_message('error',serialize($post_adding));
                                          App::LogActivity($assgdata);
                                            }
                                            
                                  
                            $post_data = array(
                              'first_name'    => $firstname,
                              'last_name'     => $lastname,
                               'email'         => $this->input->post('email'),
                               'second_phone'   =>$this->input->post('second_phone'),
                               'contact_preprence' =>$this->input->post('contact_preprence'),
                                'comments'          =>$this->input->post('comments'),
                               'assigned_to'        =>$this->input->post('assigned_to'),
                               'lead_status'       =>$this->input->post('lead_status'),
                               'lost_sale_detail'  =>$this->input->post('lost_sale_detail'),
                               'hoteness'          =>$this->input->post('hoteness'),   
                               'action_lead'      =>$this->input->post('action_lead'),
                               'note'             => $this->input->post('note'),
                               'phone'         => $newphn,
                               'image_upload'  =>$image,
                                'lead_code'     => time(),
                              'ip'            => $this->input->ip_address(),
                          );
                          
                    if(!empty($this->input->post('reminder_date') ) ){
                        $post_data['reminder_date'] = crm_dateTime( $this->input->post('reminder_date') );
                    }
                          
                    if ( $this->input->post('lead_status') == lead_Contacted_Paperwork_Pending ){
                        $post_data['pw_dateadded'] = date('Y-m-d H:i:s');
                        $post_data['qf_status'] = '17';
                    }else if( $this->input->post('lead_status') == lead_Qualified ){
                         $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                         $post_data['qf_status'] = int_lead_Not_Started;
                    }else if( $this->input->post('lead_status') == lead_Presentation_Lead ){
                         $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                         $post_data['qf_status'] = int_lead_Not_Started;
                    }
                    
                  
                    
                   $get_lead_data = get_row_data('*','leads',array('id' => $id ));
                   if( !empty( $get_lead_data->lead_status )){
                   $get_lead_status = get_row_data('status','status_lead',array('id' => $get_lead_data->lead_status ));
                    $get_lead_s = $get_lead_status->status; 
                   } else {
                       $get_lead_s = "";
                   }
                   
                   $new_lead_status = get_row_data('status','status_lead',array('id' => $post_data['lead_status'] ));
                   
                   if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
                  
                    if( ($get_lead_s != $new_l_status) || ($get_lead_s == "" && $new_l_status !="") || ($get_lead_s !="" && $new_l_status =="")  ){
                  
                   $db_activity_id = log_activity('lead_activity',$id,$get_lead_s,$new_l_status,'Update Lead Status','activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_l_status );
                   
                  } else {
                   $db_activity_id = log_activity('lead_activity',$id,$get_lead_status = "",$new_lead_status ="",'Update Lead Profile','activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id );
                  }
                   $post_adding = array_merge( $post_data, $post_data2 );
                   log_message('error',serialize($post_adding));

                    App::update('leads',$match,$post_data);
                    $post_data['success'] = array();
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Lead has been Update successfully');
                    
                     redirect('/crm/leads/dashboard/'.$id);
                 
                      
                 }else{
                     $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
                     $result = $this->db->select('*')->from('status_lead')->get();
                     $data['lead_statuss'] = $result->result('array'); 
                    $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.user_id', 'FULL OUTER JOIN')->get();
                  $data['users'] = $userQuery->result('array');
                   
                    
                     $this->template->title('Edit Lead');
                     $this->template
                    ->set_layout('inner')->build('edit',$data);


                 }
    
    }

    function quick_edit($id){

       if ( $this->input->post('id') ) {
                                 $adminID = $this->tank_auth->get_user_id();
                                 $ass = $this->input->post('assigned_to'); 
                                 $assnto = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                                $leads_ass = (array) App::get_row_by_where('leads', array('id'=>$id) );
                                if($ass != $leads_ass['assigned_to']){
                                 $assntoo = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                                    $lead_ass = array( 
                                        'user_id' => $adminID,
                                        'module'  => 'leads',
                                        'field_id' => $this->input->post('id'),
                                        'activity'=> 'Quick Edit Assgin Change  : '.$assntoo['name'] 
                                 );
                                 
                                $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status="",$new_lead_status="",'Quick Edit Assgin Change  : '.$assntoo['name'],'activity_record');
                               $post_data2 = array( 'activity_id' => $db_activity_id );
                               $post_adding = @array_merge( $ass, $post_data2 );
                               log_message('error',serialize($post_adding));
                                 
                                     App::LogActivity($lead_ass);
                            }

                            $assgn =$this->input->post('action_lead');
                            $assnlead = (array) App::get_row_by_where('leads', array('id'=>$id) );
                            $action =$assnlead['action_lead'];

                             if($assgn != $action  ){
                                    $status_data = array( 
                                              'user_id' => $adminID,
                                              'module'  => 'leads',
                                              'field_id' => $this->input->post('id'),
                                              'activity'=> 'Next Step change : '.$action .'  to  '.$assgn
                                              );
                                
            
                            $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status="",$new_lead_status="",'Next Step change : '.$action .'  to  '.$assgn,'activity_record');
                            $post_data2 = array( 'activity_id' => $db_activity_id );
                            $post_adding = @array_merge( $assgn, $post_data2 );
                            log_message('error',serialize($post_adding));
                                             
                                          App::LogActivity($status_data);
                                            }
    
                             $match=array(
                               'id' => $this->input->post('id'),
                               );
                             
                             $timestamp = strtotime( str_replace("-","/",$this->input->post('reminder_date')) ); 
                             $new_date = date('Y-m-d', $timestamp);
                             $curr_time = date('h:i:sa');
                                
                                  $post_data = array(
                                    'assigned_to'        =>$this->input->post('assigned_to'),
                                    'action_lead'        =>$this->input->post('action_lead'),
                                    'reminder_date'    => $new_date.' '.$curr_time,
                                     'ip'            => $this->input->ip_address(),
                              );
                              
                            App::update('leads',$match,$post_data);
                            $post_data['success'] = array();
                            $this->session->set_flashdata('response_status','success'); 
                            $this->session->set_flashdata('message','Lead has been Update successfully');
                            
                             redirect('/crm/leads/');

                             }

                     $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
                     $result = $this->db->select('*')->from('status_lead')->get();
                     $data['lead_statuss'] = $result->result('array'); 
                     $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.user_id', 'FULL OUTER JOIN')->get();
                     $data['users'] = $userQuery->result('array');
                     $this->load->view('crm/modal/quick_edit', $data);


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

   
  function getLeads(){
    ini_set('max_execution_time', 30000000);
    ini_set('memory_limit','2048M');
   
   
    $requestData= $_REQUEST;
    
    $Select_status = $this->crm_model->resultArray('status_lead');

    $columns = array(
                0 => 'lids',
                1 => 'full_name',
                2 => 'first_name',
                3 => 'email',
                4 => 'phone',
                5 => 'sl.status',
                6 => 'action_lead',
                7 => 'reminder_date',
                8 => 'survey',
                9 => 'hoteness',
                10 => 'created'
                
               
              );
              
              
        $vendor_id = $this->session->userdata('vendor_id');
                  
        $likesql = "AND ( l.id LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR p.name LIKE '%".$requestData['search']['value']."%'";
        $likesql.=" OR l.last_name LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR l.phone LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR l.action_lead LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR l.hoteness LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR l.created LIKE '%".$requestData['search']['value']."%' ";
        $likesql.=" OR sl.status LIKE '%".$requestData['search']['value']."%'";
        $likesql.=" OR l.reminder_date LIKE '%".$requestData['search']['value']."%'";
        $likesql.=" OR l.email LIKE '%".$requestData['search']['value']."%' )";
                  
    $sql = "SELECT l.*, l.id as lids, CONCAT(l.first_name,' ', l.last_name) as username,l.email,l.phone,l.lead_status,l.action_lead,l.reminder_date,l.hoteness,l.created,l.assigned_to,l.qf_status,p.name as assign,p.id as ids,sl.*,sl.id as slids,
    ( SELECT SUM(`point`) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id)) AS survey,
    ( SELECT SUM(`point`)+ (SELECT hoteness*2*10  FROM leads WHERE id = l.id) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id) ) AS hs
    FROM leads l  left join user_profiles p on l.assigned_to =p.user_id left join status_lead sl on l.lead_status = sl.id WHERE l.vendor_id =  '$vendor_id' ";

   $totalData = $this->crm_model->custom_query($sql,true,'array');
   $totalFiltered = $totalData;

      $statusFilter = $_REQUEST['columns'][5]['search']['value'];
      $AssignFilter = $_REQUEST['columns'][1]['search']['value'];
      $searchfilter = $requestData['search']['value'];

      if( !empty($requestData['search']['value']) && empty($statusFilter) && empty($AssignFilter)  ) {  

          $sql.= $likesql;

      }elseif ( empty($searchfilter) && !empty($statusFilter) && empty($AssignFilter) ) {

           $sql.= " AND l.lead_status IN (".$statusFilter.")";
      
      } elseif ( empty($searchfilter) && empty($statusFilter) && !empty($AssignFilter)  ) {

        $sql.= " AND l.assigned_to IN (".$AssignFilter.")";
      
      } elseif( empty($searchfilter) && !empty($statusFilter) && !empty($AssignFilter) ){
          $sql.= " AND l.assigned_to IN (".$AssignFilter.") AND l.lead_status IN (".$statusFilter.")  ";
      } elseif( !empty($searchfilter) && !empty($statusFilter) && !empty($AssignFilter) ){
          $sql.= " AND l.assigned_to IN (".$AssignFilter.") AND l.lead_status IN (".$statusFilter.") ";
          $sql.= $likesql;
      }elseif ( !empty($searchfilter) && !empty($statusFilter) && empty($AssignFilter) ) {
          $sql.= " AND l.lead_status IN (".$statusFilter.") ";
          $sql.= $likesql;
      }elseif ( !empty($searchfilter) && empty($statusFilter) && !empty($AssignFilter) ) {
          $sql.= " AND l.assigned_to IN (".$AssignFilter.") ";
          $sql.= $likesql;
      }
      $totalFiltered = $this->crm_model->custom_query($sql,true,'array'); 
      
      $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
      $total_record = $this->crm_model->custom_query($sql,false,'array'); 
      //echo $this->db->last_query();
      
     // pr( $total_record );die;
      
      
      
      $data = array();
      if( is_array( $total_record ) && !empty( $total_record ) )
      {

        foreach($total_record as $row){
             if( empty( $row['assign'] ) ){
                $assignName = $row['assign'] = 'N/A';
              } else {
                $assignName =  ucfirst($row["assign"]);
              }
             
              if( !empty( $row['lead_status'] ) ){
                    $sta = (array) App::get_row_by_where('status_lead', array('id'=>$row['lead_status']) );
            
              } else {
                  $sta = array('status' =>'Not contacted');
              }  
              if(!empty($row['action_lead'])) { $led=$row['action_lead']; } else{ $led="NA";  } 
              if(!empty($row['reminder_date'])){ 
               
                $rem = crm_date($row['reminder_date']);
              } else {  $rem="NA"; }   

              if(!empty($row['hoteness'])) { $hot=$row['hoteness']; } else{ $hot="0"; } 

              $dt = new DateTime();
              $olddate = strtotime( $row['created'] );
              $curdate = strtotime( $dt->format('Y-m-d') );
              $age= humanTiming($olddate);
          
              $leademail = $row['email']; $leadphone = $row['phone'];

              if(!empty($leadphone)){
                   $sql1 = "SELECT leads_id FROM customer WHERE email = '$leademail' AND phone = '$leadphone'";
                   $countRows = $this->crm_model->custom_query($sql1,true,'array');

              }else{
                   $sql1 = "SELECT leads_id FROM customer WHERE email = '$leademail'";
                   $countRows = $this->crm_model->custom_query($sql1,true,'array');
              }
              
              if( empty($row['survey']) ){ $row['survey'] = 0; }
              
              
                $html= '';
                if( $countRows < 1 ){      
                $html .=  '<a href="'.base_url().'customer/customer/add/'.$row['lids'].'" title="Add Customer" style="color:#808080 !important" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fa fa-plus-square" aria-hidden="true" ></i></a>';
                 } else {                            
                $html .=  '<a href="javascript:void(0);" title="Already Customer" class="action-icon create-customer" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fas fa-ban"></i></a>';
                }                                 
                $html .=  '<a href="'.base_url().'crm/leads/edit_leads/'.$row['lids'].'" title="Edit Lead" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                $html .=  '<a href="'.base_url().'crm/leads/quick_edit/'.$row['lids'].'" title="Quick Edit" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>';
                $html .=   '<a href="'.base_url().'crm/leads/dashboard/'.$row['lids'].'" title="Dashboard" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                $html .=   '<a href="javascript:void(0);" title="Delete" id="deleteUser" class="action-icon" style="color:#808080 !important" ids="'.$row['lids'].'"> <i class="mdi mdi-delete"></i></a>';

                $pending = "pending";
                
                                       
                     if($row["email"]!='unkown@perfectionkitchens.com' && $row['parent_lead'] =='0' ){
                        $data[] = array(
                          $row["lids"],  
                          $assignName, 
                          '<a href="'.base_url().'crm/leads/dashboard/'.$row['lids'].'" >'.$row["username"].'</a>',  
                          $row["email"],    
                          $row["phone"],    
                          $row['status'],
                          $led,
                          $rem,
                          $row['survey'],
                          $hot,
                          $age,
                          $html
                      ); 
                     }
                  
              }
      }

    $json_data = array(
                  "draw"            => intval( $requestData['draw'] ),
                  "recordsTotal"    => intval( $totalData ),
                  "recordsFiltered" => intval( $totalFiltered ),
                  "data"            => $data 
                  );

      echo json_encode($json_data);
      
   }     
   
   
   function survey($id){
           $data = array();
           $id =  $this->uri->segment(4);
           $data['lead_id'] = $id;
           $sql = "SELECT * FROM survey_questions WHERE 1=1 ";
           $totalQuestions = $this->crm_model->custom_query($sql,false,'array');
           
           foreach($totalQuestions as $key){
                   $totalOptions = array();
                   $sql = "SELECT * FROM survey_qoptions WHERE question_id = ".$key['id'];
                   $totalOptions = $this->crm_model->custom_query($sql,false,'array');
                   $ansQuery = "SELECT * FROM survey_answers WHERE lead_id = ".$id." AND question_id = ".$key['id'];
                   $ans = $this->crm_model->custom_query($ansQuery,false,'array');
                   $data['qa'][] = array(
                       'ques' => $key, 
                       'options' =>$totalOptions,
                       'ans' => $ans
                   ); 
           }
           
           
            if ( $this->input->post('Survey') ) { 
               
                $lead_id  = $_POST['lead_id'];
                unset($_POST['lead_id']);
                unset($_POST['Survey']);
            
            
                $countQuery = "SELECT * FROM survey_answers WHERE lead_id = ".$lead_id ;
                $count = $this->crm_model->custom_query($countQuery,true);
                if($count <= 0){
                    
                    foreach($_POST as $qKey => $qVal){
                        $qID = explode('_',$qKey)[1];
                        $saveQ = array(
                                    'lead_id' => $lead_id,
                                    'answer' => $qVal, 
                                    'question_id' => $qID
                                );
                        App::save_data('survey_answers',$saveQ);
                    }
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Survey has been Updated');
                    redirect('/crm/leads/survey/'.$id); 
                 }else{
                     $saveQ = array();
                     
                     
                     foreach($_POST as $qKey => $qVal){
                        $qID = explode('_',$qKey)[1];
                        $match = array ( 'lead_id' => $lead_id,'question_id' => $qID );
                        $saveQ = array(
                                    'answer' => $qVal, 
                                );
                                
                        
                            
                        App::update('survey_answers',$match,$saveQ);
                     }
                     
                     
          $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Survey Score','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           
           log_message('error',serialize($post_data2));
                     
                      $this->session->set_flashdata('response_status','success'); 
                      $this->session->set_flashdata('message','Survey has been Updated');
                      redirect('/crm/leads/survey/'.$id);     
                 }  
            }
 
           $this->template->title('survey');
              $this->template
                      ->set_layout('inner')
                      ->build('leads/survey', $data);
       
       
   }

  function qualified(){
      $data = array();
      $this->template->title(' Leads');
        $this->template
                ->set_layout('inner')
                ->build('qualified', $data);
  }
  
  
 function pw_form(){
                   $id = $this->uri->segment(4);
                $Pwdata = (array) App::get_row_by_where('pw_pending_w', array('lead_id'=>$id) );
                    
                 if( empty($Pwdata) ){
                     
	                 $post_data = array(
					'lead_id'          	               => $id,
					'cabinet_manufacturer'		      => '',
					'door_style'			          => '',
					'desired_flooring_type'		      => '',
					'desired_flooring_color'		  => '',
                      'backsplash'                      => '',
                      'countertop_type'                 => '',
                      'countertop_color'                => '',
                      'knobs_and_handles'               => '',
                      'sink_type'                       => '',
                      'sink_color'                      => '',
                      'sink_bowls'                      => '',
                      'keeping_existing'                => '',
                      'dishwasher_size'                 => '',
                      'desired_dishwasher_color'        => '',
                      'dishwasher_quantity'             => '',
                      'range_size'                      => '',
                      'cooktop_size_p'                  => '',
                      'wall_oven_count'                 => '',
                      'wall_oven_width'                 => '',
                      'cooktop_size'                    => '',
                      'microwave'                       => '',
                      'microwave_width'                 => '',
                      'hood'                            => '',
				   'refrigerator_width'               => '',
				   'refrigerator_depth'               => '',
				   'applicance_other'                 => '',
				   'crown_molding'                    => '',
				   'crown_molding_touch_ceiling'      => '',
				   'light_rail'                       => '',
				   'cabinet_wall_height'              => '',
				   'option_request'                   => '',
				   'ceiling_height'                   => '',
				   'soffit'                           => '',
				   'soffit_yes_keeping'               => '',
				   'walls_be_moved'                   => '',
				   'doors_be_moved'                   => '',
				   'plumbing_be_moved'                => '',
				   'range_location_be_moved'          => '',
				   'refrigerator_location_be_moved'   => '',
				   
				 
				);
				
				
          $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Kitchen Details','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $post_data, $post_data2 );
           log_message('error',serialize($post_adding));
				
				App::save_data( 'pw_pending_w', $post_data );
                     
	                }else{

	             if(isset($_POST)){ 
	                   if($this->input->post('lead_id')){
	                       
	                       if( !empty( $this->input->post('option_request') ) ){
	                            $option_request = implode(", ",$this->input->post('option_request'));
	                       }else{ $option_request='';  }
                     $match=array(
                       'lead_id' => $this->input->post('lead_id'),
                                    );
	           	$post_data = array(
        					'cabinet_manufacturer'		      => $this->input->post('cabinet_manufacturer'),
        					'door_style'			          => $this->input->post('door_style'),
        					'desired_flooring_type'		      => $this->input->post('desired_flooring_type'),
        					'desired_flooring_color'		  => $this->input->post('desired_flooring_color'),
                            'backsplash'                      => $this->input->post('backsplash'),
                            'countertop_type'                 => $this->input->post('countertop_type'),
                            'countertop_color'                => $this->input->post('countertop_color'),
                            'knobs_and_handles'               => $this->input->post('knobs_and_handles'),
                            'sink_type'                       => $this->input->post('sink_type'),
                            'sink_color'                      => $this->input->post('sink_color'),
                            'sink_bowls'                      => $this->input->post('sink_bowls'),
                            'keeping_existing'                => $this->input->post('keeping_existing'),
                            'dishwasher_size'                 => $this->input->post('dishwasher_size'),
                            'desired_dishwasher_color'        => $this->input->post('desired_dishwasher_color'),
                            'dishwasher_quantity'             => $this->input->post('dishwasher_quantity'),
                            'range_size'                      => $this->input->post('range_size'),
                            'cooktop_size_p'                  => $this->input->post('cooktop_size_p'),
                            'wall_oven_count'                 => $this->input->post('wall_oven_count'),
                            'wall_oven_width'                 => $this->input->post('wall_oven_width'),
                            'cooktop_size'                    => $this->input->post('cooktop_size'),
                            'microwave'                       => $this->input->post('microwave'),
                            'microwave_width'                 => $this->input->post('microwave_width'),
                            'hood'                            => $this->input->post('hood'),
        				   'refrigerator_width'               => $this->input->post('refrigerator_width'),
        				   'refrigerator_depth'               => $this->input->post('refrigerator_depth'),
        				   'applicance_other'                 => $this->input->post('applicance_other'),
        				   'crown_molding'                    => $this->input->post('crown_molding'),
        				   'crown_molding_touch_ceiling'      => $this->input->post('crown_molding_touch_ceiling'),
        				   'light_rail'                       => $this->input->post('light_rail'),
        				   'cabinet_wall_height'              => $this->input->post('cabinet_wall_height'),
        				   'option_request'                   =>$option_request,
        				   'ceiling_height'                   => $this->input->post('ceiling_height'),
        				   'soffit'                           => $this->input->post('soffit'),
        				   'soffit_yes_keeping'               => $this->input->post('soffit_yes_keeping'),
        				   'walls_be_moved'                   => $this->input->post('walls_be_moved'),
        				   'doors_be_moved'                   => $this->input->post('doors_be_moved'),
        				   'plumbing_be_moved'                => $this->input->post('plumbing_be_moved'),
        				   'range_location_be_moved'          => $this->input->post('range_location_be_moved'),
        				   'refrigerator_location_be_moved'   => $this->input->post('refrigerator_location_be_moved'),
				   
				 
			           	);
			           	
			           	 $activaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' =>$this->input->post('lead_id'),
                            'activity'=> 'Create Kitchan Details : PWleads'
                          );
                          
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Kitchen Details','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $post_data, $post_data2 );
           log_message('error',serialize($post_adding));
        	                
        	                 App::LogActivity($activaty);
        	                 App::update('pw_pending_w',$match,$post_data);
        	                 $post_data['success'] = array();
                             $this->session->set_flashdata('response_status','success'); 
                             $this->session->set_flashdata('message','Paper Work  Update successfully');
                              redirect('crm/leads/pw_form/'. $id);
          }
	      }
	    }
	                    
                  
	                    
	                   
	        
      
          $data = array();
          if(!empty($id)){
              $data['pw_pending'] = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
              
          }else{
            $data['pw_pending'] = '';
          }
          
          $this->template->title('P pending');
              $this->template
                      ->set_layout('inner')
                      ->build('leads/pwForm', $data);

  }
  
 
  
   function assignleads(){
        if( isset($_POST['assignlead'])){
                $this->db->select("*");
            $this->db->from('leads');
            $this->db->like('first_name', $_POST['assignlead']);
            $this->db->or_like('last_name', $_POST['assignlead']);
            $data = $this->db->get()->result();

            if( !empty($data ) ){
                foreach ($data as $key => $value) {
                        
                        $leads[$value->id] = array('first_name' => $value->first_name, 'last_name' => $value->last_name, 'leads_id' => $value->id) ;
                }
    
                echo json_encode($leads);
            } else { echo "false"; }
        }
    }
  
 function assign_livechat(){
     
 
       $Lid = (array) App::get_by_where('leads', array('email'=>'unkown@perfectionkitchens.com'));
    
        if(!empty($Lid)){
       $leadid =$Lid[0]->id;
        }else{
            $leadid=""; 
            
        }
       
        $this->db->select('*');
        $this->db->from('live_chat');
        $this->db->where(array('lead_id' => $leadid));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $data['live_chats'] = $query->result('array');
        $this->template->title('P chat');
              $this->template
                      ->set_layout('inner')
                      ->build('crm/chat_assign',$data);

        
    }
    
     function add_assign_chat(){
          $id =  $this->uri->segment(4);
             if ( $this->input->post('email') ) {    
                   $data['errors'] = array();
                 // echo $id;
                    $email = $this->input->post('email');
                    
                    
                    $leaddata =$this->crm_model->findWhere('leads', array('email' => $email, ), array('*') );
                    
                  if(!empty( $leaddata)){
                      
                        
                      $lid=$leaddata[0]['id'];
                 
                     
                    $match = array (
                        'id' => $this->uri->segment(4)
                    );
                    $data = array(
                            'lead_id'  => $lid,
                            
                      );
                      
                      
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Assign Chat has been updated successfully'); 
                    App::update('live_chat',$match,$data);
                    
                    redirect('crm/leads/assign_livechat'); 
                  }else{
                    
            	$post_data = array(
					'email'			=> $this->input->post('email'),
					'created'		=> date('Y-m-d H:i:s'),
                    'lead_code'		=> time(),
					'ip'			=> $this->input->ip_address(),
				);

				if( !$lead_id = App::save_data( 'leads', $post_data ) )
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Assign Chat didn\'t save, Try again!');
                    redirect('/crm/leads/assign_livechat');
                }
                else
                {	
                     $match = array (
                        'id' => $this->uri->segment(4)
                    );
                    $data = array(
                            'lead_id'  => $lead_id,
                            
                      );
                    App::update('live_chat',$match,$data);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Assign Chat successfully');
                    redirect('/crm/leads/assign_livechat');
                }
		
                      
                      
                  }
                 
              }
     
    $this->load->view('modal/assign_lead',$id);
  }

   function ass_chat_record_(){
         $id = $this->uri->segment(4);
        
        $this->db->select('*');
        $this->db->from('live_chat');
        $this->db->where(array('id' =>  $id));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
       
        $data['leads'] = $query->result('array');
        // pr($data);
        $this->load->view('crm/modal/ass_chat_record', $data);
    }
    
  function duplicate_lead(){
     
    $phData = $this->crm_model->custom_query("SELECT phone, COUNT(*) AS total from leads group by phone HAVING total > 1",false,'array');
    $emData = $this->crm_model->custom_query("SELECT email, COUNT(*) as total FROM leads GROUP BY email HAVING total > 1",false,'array');

    foreach($phData as $value){ if($value['phone'] == '') continue;
        $clData = App::get_by_where('leads', array('phone'=>$value['phone']),array(),true );
        foreach($clData as $tempVal){ $notINN[] = $tempVal['id']; }
        $data['ldata'][$value['phone']] = $clData;
    }
    
    $andC = '';
    if( is_array($notINN) && $notINN != ''){
        $notINN = implode(',',$notINN);
        $andC = " AND id NOT IN ($notINN)";
    }
        
    foreach($emData as $value){  if($value['email'] == '') continue;
        
        $qRes = $this->crm_model->custom_query("SELECT * from leads where email = '".$value['email']."'".$andC,false,'array');
        if( $qRes != '') $data['ldata'][$value['email']] = $qRes; 
    }

    $this->load->view('auth/index', $data);
    $this->template->title(' DLeads');
    $this->template->set_layout('inner')->build('duplicate_lead', $data);
 }
 
 function add_merge(){
       $return = 'false';
    $pid=$_POST['parentid'];
    $cid=$_POST['selfid'];
     
     $Plead = App::get_row_by_where('leads', array('id'=>$pid) );
      $Clead = App::get_row_by_where('leads', array('id'=>$cid) );
     
       $Pphone= $Plead->phone;
      $Pemail = $Plead->email;
       $Cphone= $Clead->phone;
      $Cemail = $Clead->email;
      
                    $pdata = array(
                            'parent_lead'  => $pid,
                            'secondry_email' => $Pemail,
                            'secondry_phone' => $Pphone,
                      );
                       $cdata = array(
                            'secondry_email' => $Cemail,
                            'secondry_phone' => $Cphone,
                      );
                   
                    if( App::update('leads',array ('id' => $cid ),$pdata)){
                        $return = 'true';
                    }else{ $return = 'false';  }
                    if(App::update('leads',array ('id' => $pid ),$cdata)){
                         $return = 'true';
                    }else{  $return = 'false';  }
            echo $return;
     
 }
	function send_status_email(){
	  
	    $date = date('Y/m/d H:i:s');
	    pr($date);
	  
	   $qc_after_2_hour = $this->crm_model->custom_query("SELECT id, qf_status, qf_dateAdded FROM leads WHERE qf_status='Not Started' AND qf_dateAdded <= (NOW() - INTERVAL 2 HOUR)",false,'array');
	   $qc_after_1_hour = $this->crm_model->custom_query("SELECT id, qf_status, qc_start_date FROM leads WHERE qf_status='Ready for Q/C' AND  qc_start_date <= (NOW() - INTERVAL 1 HOUR)",false,'array');

	    pr($qc_after_2_hour);
	    pr($qc_after_1_hour);
	}
	
	function edit_task($id){
      
        
         $lead_id = $this->input->post('lead_id');

            if ( $this->input->post('task_id') ) {    
                   $data['errors'] = array();
                  
                    $id = $this->input->post('task_id');
                    
                     $status = $this->input->post('status');
                     
                     if($status = 'completed'){
                         $ldata = (array) App::get_row_by_where('leads', array('id'=>$lead_id) );
                            $firstname= $ldata['first_name'];
                                 $lastname = $ldata['last_name'];
                                 $ur=base_url('crm/leads/dashboard/'.$lead_id);
                                  $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                                 $emailVar['_emailto'] = $PST;
                                 $emailVar['{name}'] = $firstname.' '.$lastname;
                                 $emailVar['{lead_url}'] =$ur;
                                 send_email('task_completed', $emailVar);
                     }
                    
                    
                   

                    $match = array (
                        'id' => $this->input->post('task_id'),
                    );
                    $data = array(
                            'task_title'  => $this->input->post('task_title'),
                            'task_desc'       => $this->input->post('task_desc'),
                            'assigned_team'		=> $this->input->post('assigned_team'),
                            'status'       => $this->input->post('status'),
                      );
                    
      
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Task has been updated successfully'); 
                    App::update('task',$match,$data);
                    redirect('crm/leads/get_task/'.$lead_id);

                 

            }


            else{
                      $result = $this->db->select('*')->from('assign_team')->get();
                      $data['lead_statuss'] = $result->result('array'); 
                      $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
                     $data['users'] = $userQuery->result('array');
                     $data['task'] = (array) App::get_row_by_where('task', array('id'=>$id) );
                     $this->load->view('modal/edit_task', $data);

                 }


     }	


	
    function get_task(){
         $data=array();
         $lead_id = $this->uri->segment(4);
         $vendor_id = $this->session->userdata('vendor_id');
       
         $this->db->select("*");
         $this->db->from('task');
         $this->db->where("lead_id = '$lead_id' AND vendor_id ='$vendor_id'");
         $data['task'] = $this->db->get()->result();
        
       
         $this->template->title('survey');
              $this->template
                      ->set_layout('inner')
                      ->build('leads/taskget', $data);
        
        
        
    }
    
     function Prdelete_task(){
           if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
             $data['userDel'] = $this->user_model->Pkdelete_query($ids,'task');
            if($data == true){
            echo "TRUE";
            } else {
                echo "FALSE";
            }
        }
    }
    
    function coll_menu(){
        if( isset( $_POST['valuebtn'] ) ){
          $user_id =  $this->tank_auth->get_user_id();
          $query =  $this->crm_model->findWhere('coll_menu',array('user_id' => $user_id),FALSE,array('coll_value'));
          /*pr($query);die;*/
          if(!empty($query) ){
                switch ($query['coll_value']) {
                  case '0':
                  
                     $this->crm_model->updateWhere('coll_menu',array('user_id' => $user_id),array('coll_value' => '1'));
                    break;
                  case '1':
                  
                      $this->crm_model->updateWhere('coll_menu',array('user_id' => $user_id),array('coll_value' => '0'));
                  break;
                }
          } else {
            $data = array(
                'user_id' => $user_id,
                'coll_value' => '1'
            );
            $query =  $this->db->insert('coll_menu',$data);
          }

        }
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
