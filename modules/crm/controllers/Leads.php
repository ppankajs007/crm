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
    /*
    *   Functionality - List all leads on dashboard page 
    *   Call from :  /dashboard
    */
    public function dashboard( $id ) {  
        $data = array();
        $leads = App::get_row_by_where('leads', array( 'id' => $id ) );
        if(!empty( $leads ) ){ $data['leads'][] = $leads; }
        $Mleads = App::get_row_by_where('leads', array( 'id' => $id ) );
        if(!empty( $Mleads ) ){ $data['Mleads'][] = $Mleads; }
        $scstats = App::get_row_by_where('leads',  array('id' => $id,'qf_status' => int_lead_Hold_On_Design  ) );
        if(!empty($scstats)){ 
            $hold_desgin = App::get_row_by_where('hold_on_desgin', array('lead_id'=>$id ) );
            if(!empty( $hold_desgin ) ){
                $data['hold'][] = $hold_desgin;
                }
            }else{
                $data['hold'][] = '';
                }
        $leads_id =  $this->uri->segment(4);
        $data['nine_boxes'] = $this->crm_model->findWhere('nine_boxes', array('l_id' => $leads_id ), array('*') );
        $data['lsms'] = (array) App::get_by_where('leads_sms', array( 'lead_id' => $leads_id ) );
        $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ')
             ->from('activity_record')
             ->where(array(
                          'activity_id' => $leads_id,
                          'activity_name' => 'lead_activity',
                          'activity_record.user_id' => $this->tank_auth->get_user_id() )
                          );
        $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
        $this->db->order_by('activity_recordID', 'DESC');
        $query = $this->db->get();
        $Pdata = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $leads_id ), array('*') );
            if( !empty($pdata )){
                $data['pw_pending'] = $pdata;
            }else{ 
                $data['pw_pending'] = '';
                }
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
    }/* End Function Dashboard */

    /*
    *   Functionality - Listing Leads on index  : 
    *   Call from :  index
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
            }
        $data = array();
        $data['Select_status'] = $this->crm_model->fetch_all('status_lead');
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->load->view('auth/index', $data);
        $this->template->title(' Leads');
        $this->template->set_layout('inner')->build('leads', $data);
    }/* End Function index */

    /*
    *   Functionality - Get facebook  Leads  : 
    *   Call from :  getFBLead
    */
    public function getFBLead() {
        $name = $_REQUEST['full_name'];
        if(!empty($name)){
           $firstname = strtok($name,' ');
           $lastname = strstr($name,' '); 
        }else{
            $firstname = 'No';
            $lastname = 'Name';
            }
        $phone = $_REQUEST['phone'];
        $lemail = $_REQUEST['email'];
        App::save_data('log_data', array('log_type'=>'facebook','log_data'=> json_encode( $_REQUEST ) )  );  
        $post_data = array(
                        'first_name'    => $firstname,
                        'last_name'     => $lastname,
                        'email'         => $lemail,
                        'phone'         =>  $phone,
                        'source_url'    => 'facebook',
                        'created'       => date('Y-m-d H:i:s'),
                        'lead_code'     => time(),
                        'vendor_id'     => '1',
                        'ip'            => $this->input->ip_address(),
                   );


        if( !$lead_id = App::save_data( 'leads', $post_data ) ) {
            log_message( 'error', 'Leads_getFBLead' . $this->db->_error_message() );
        }else{
    
            logDbError( 'sendClickSMS', 'Send SMS Log' , "Before sendClickSMS getFBLead");
            sendClickSMS('+16102231415,+19085811802,+19083995654',"New Lead in CRM");

            $db_activity_id = log_activity('lead_activity',$lead_id, $get_lead_status = "", $new_lead_status="",'Add Lead Facebook: '.$firstname. " ".$lastname,'activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $post_data, $post_data2 );
            log_message('error',serialize( $post_adding ));
            $message = 'From Facebook. #'.$this->db->insert_id().'-'.$firstname;
            $url =  base_url()."crm/leads";
            $imageurl = base_url()."assets/leadsfiles/logo_192_by_192.png";
            $post_vars = array(
                      "icon" => $imageurl,
                      "title" => 'New Lead',
                      "message" => $message,
                      "url" => $url,
                      "subscriber" => 'ila14nl0QiZZfT0YsmSGFA==',
                    );
                    pushalert($post_vars); 
                 }
    } /* End Function getFBLead */
    
    /*
    * Functionality - add note iin Leads  : 
    * Call from :  notes
    */
    public function notes( $id ) {   
        $data = array();
        $data['leads'] = (array) App::get_row_by_where('leads', array( 'id' => $id ) );
        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array'); 
        $userQuery = $this->db->select('*')
                                  ->from('users')
                                  ->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')
                                  ->get();
        $data['users'] = $userQuery->result('array');
        if ( $this->input->post('lead_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('lead_id');
            $match = array ( 'id' => $this->input->post('lead_id') );
            $data = array( 'note'  => $this->input->post('note') );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Note has been updated');
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
    }/* End Function note */
    
    /*
    *   Functionality - Get files  Leads  : 
    *   Call from : files
    */
    public function files() {
        $id = $this->uri->segment(4);
        $data = array();
        $data['file_data'] = $this->crm_model->findWhere('files', array('field_id' => $id ), array('*') );
        $this->template->title('File');
        $this->template
             ->set_layout('inner')
             ->build('leads/file', $data);
    }/* End Function files */

    /*
    *   Functionality - Get chats  Leads  : 
    *   Call from :  chats/
    */  
    public function chats( $id ){
        $id = $this->uri->segment(4);
        $data['live_chats'] = (array) App::get_by_where('live_chat', array( 'lead_id' => $id ));
        $this->template->title('Chat');
        $this->template
              ->set_layout('inner')
              ->build('leads/livechat', $data);
      
    }/* End Function chats */

    /*
    *   Functionality - Get chat_record  Leads : 
    *   Call from :     chat_record
    */       
    public function chat_record() {
        $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array( 'id' => $id ) );
        $this->load->view('crm/modal/chat_record', $data);
    }/* End Function chats */

    /*
    *   Functionality - add_file File in Leads  : 
    *   Call from :  add_file
    */ 

    public  function add_file() {
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
        }else{
        if(!empty($this->input->post() ) ){
            $query = $this->crm_model->select_where('first_name','leads',array('id' => $this->input->post('leads_id') ));
            $data = array( 
                        'field_id'        => $this->input->post('leads_id'),
                        'module_name'     => 'leads', 
                        'file_name'       => $this->upload->data('file_name'),
                        'title'           => $this->input->post('title'),
                        'deck_one'        => $this->input->post('deck_one'),
                        'deck_two'        => $this->input->post('deck_two'),
                        'deck_three'      => $this->input->post('deck_three'),
                        'path'            => $this->upload->data('file_path'),
                        'lead_file_type'  => $this->input->post('lead_file_type'),
                        'ext'             => $this->upload->data('file_ext'),
                        'size'            => $this->upload->data('file_size'),
                        'is_image'        => $this->upload->data('is_image'),
                        'description'     => $this->input->post('description'),
                        'created_by'      => $this->tank_auth->get_user_id()
                    );
            if( !$lead_id = App::save_data( 'files', $data )  ) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
            }else{
                $db_activity_id = log_activity('lead_activity',$id, $get_lead_status = '',
                                                              $new_lead_status = '',
                                                              'Add a file : '.$query->first_name,
                                                              'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $data, $post_data2 );
                log_message('error',serialize( $post_adding ));
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', 'File added successfully');
                }
                redirect('/crm/leads/files/'.$id);
            }
        }
           $this->load->view('modal/add_file', $id);
    }/* End Function add_file */

    /*
    *   Functionality - add  Lead : 
    *   Call from :  add
    */ 
    public function add() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $post_data = array(
                            'first_name'    => $this->input->post('first_name'),
                            'last_name'     => $this->input->post('last_name'),
                            'email'         => $this->input->post('email'),
                            'phone'         => $this->input->post('phone'),
                            'source'        => $this->input->post('lead_source'),
                            'note'          => $this->input->post('note'),
                            'created'       => date('Y-m-d H:i:s'),
                            'lead_status'   => $this->input->post('lead_status'),
                            'lead_code'     => time(),
                            'ip'            => $this->input->ip_address(),
                            'vendor_id'     => $this->session->userdata('vendor_id')
                        );
            if( !$lead_id = App::save_data( 'leads', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Lead didn\'t save, Try again!');
                    redirect('/crm/leads');
            }else{  
                $message = 'New Lead Created. #'.$this->db->insert_id().'-'.$this->input->post('first_name');
                //pushalert starts
                $url =  base_url()."crm/leads";
                $imageurl = base_url()."assets/leadsfiles/logo_192_by_192.png";
                $post_vars = array(
                                "icon"    => $imageurl,
                                "title"   => 'New Lead',
                                "message" => $message,
                                "url"     => $url,
                                "subscriber" => 'ila14nl0QiZZfT0YsmSGFA==',
                            );
                pushalert($post_vars); 
                //pushalert ends
                $post_data = array(
                                'lead_id'   => $lead_id,
                                'note'      => $this->input->post('note'),
                                'created'   => date('Y-m-d H:i:s')
                            );
                $db_activity_id = log_activity('lead_activity',$post_data['lead_id'],$get_lead_status = "", $new_lead_status="",'Add Lead: '.$this->input->post('first_name'). " ".$this->input->post('last_name'),'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $post_data, $post_data2 );
                log_message('error',serialize( $post_adding ));
                App::save_data( 'lead_notes', $post_data );
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', 'Lead added successfully');
                redirect('/crm/leads');
                }
            }
        } 
        $data = array();
        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array');
        $this->load->view('modal/lead_add', $data);
    }/* End Function add */

    /*
    *   Functionality - check_email  in  Lead : 
    *   Call from :  check_email
    */ 
    public function check_email() {
        if( $email = $_POST['email']) {
        $count = $this->crm_model->check_data_exist($table = 'leads', $key = 'email', $val = $email);
        if( $count > 0 ) {
            echo "true";
            }
        }

    } /* End Function check_email */

    /*
    *   Functionality - Prdelete_user  delete  Lead : 
    *   Call from :  Prdelete_user
    */
    public function Prdelete_user() {
        if( isset( $_POST['ids'] ) ){
            $ids = $_POST['ids'];
            $data['userDel'] = $this->user_model->Pkdelete_query( $ids, 'leads');
            $query = $this->crm_model->select_where('first_name','leads',array('id' => $_POST['ids'] ));
            if($data == true) {
               $activaty = array( 
                                'user_id' => $this->tank_auth->get_user_id(),
                                'module'  => 'leads',
                                'field_id' => $leads_id,
                                'activity'=> 'Delete a file : '.$query->first_name
                            );
                $db_activity_id = log_activity('lead_activity',$_POST['ids'],
                                                               $get_lead_status = "",
                                                               $new_lead_status =  "",
                                                               'Delete a lead : '.$query->first_name,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize( $post_adding ));      
                echo "TRUE";
            }else{
                echo "FALSE";
                 }
        }
    }/* End Function Prdelete_user */

    /*
    *   Functionality - DeleteFiles  delete  lead file : 
    *   Call from :  DeleteFiles
    */
    public function DeleteFiles() {
        if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            $leads_id = $_POST['leads_id'];
            $data['userDel'] = $this->crm_model->Pkdelete_file(array('file_id' => $ids ),'files');
            if( $data == true ){
                $query = $this->crm_model->select_where('first_name','leads',array('id' => $leads_id ));
                $activaty = array( 
                                'user_id' => $this->tank_auth->get_user_id(),
                                'module'  => 'leads',
                                'field_id' => $leads_id,
                                'activity'=> 'Delete a file : '.$query->first_name
                            );
                $db_activity_id = log_activity('lead_activity',$_POST['ids'],
                                                               $get_lead_status = "",
                                                               $new_lead_status =  "",
                                                               'Delete a file : '.$query->first_name,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize( $post_adding ));              
                App::LogActivity( $activaty );
                echo "TRUE";
            }else{
                return "false";
                 }
        }
    }/* End Function Prdelete_user */

    /*
    *   Functionality - view_profile  Details  lead : 
    *   Call from :  view_profile
    */
    public function view_profile( $id ) {
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
             ->set_layout('inner')
             ->build('view_profile',$data);
    }/* End Function view_profile */

    /*
    *   Functionality - stripslashes_deep Flesh message : 
    *   Call from :  stripslashes_deep
    */
    public function stripslashes_deep( $value ) {
        $value = is_array( $value ) ?
        array_map('stripslashes_deep', $value ) :
        stripslashes( $value );
        return $value;
    }/* End Function stripslashes_deep */

    /*
    *   Functionality - recive_sms Sms message : 
    *   Call from :  stripslashes_deep
    */
    public function recive_sms() {
        if (get_magic_quotes_gpc()) {
            $_POST = $this->stripslashes_deep( $_POST );
        }
        App::save_data('log_data',array('log_type'=>'sms_receive','log_data'=> json_encode($_POST) ) );

        if(isset($_POST['to'] ) ) {
            $to_sms      = $_POST['from'];
            $from_sms    = $_POST['message'];
            $raw         = json_encode($_POST);
            $timestamp   = $_POST['timestamp'];
            $datetime    = date('Y:m:d H:i:s');
            $newstring   = substr($to_sms, -10);
            $this->db->select('*');
            $this->db->from('leads');
            $this->db->like("phone","$newstring");
            $query=$this->db->get();
            $from_sms_api = $query->row();
            $adminID = $this->tank_auth->get_user_id();
            $leadData = array(
                            'lead_id'       => $from_sms_api->id,
                            'sms_text'      => $from_sms,
                            'sms_to'        => $to_sms,
                            'sms_type'      => 'in',
                            'read_status'   => 'unread',
                            'sms_time'      => $datetime,
                           );
            $db_activity_id = log_activity('lead_activity',$from_sms_api->id,$get_lead_status="",$new_lead_status="",'SMS Received '.$leadData['sms_to'],'activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $leadData, $post_data2 );
            log_message('error',serialize($post_adding));
            App::update('leads', array('id' =>$from_sms_api->id) , array('last_sms' => time()) );
            
            $this->crm_model->updateWhere('leads',array('lead_id' => $lid),array('last_action' => 'Customer Sent SMS','last_action_time' => crm_dateTime( date('m-d-Y') ) ));

            App::save_data( 'leads_sms',$leadData);
            
            logDbError( 'sendClickSMS', 'Send SMS Log' , "Before sendClickSMS SMS Received");
            sendClickSMS('+16102231415,+19085811802,+19083995654',"New SMS in Perfection Messenger");

            $message = $from_sms;
            //push alert start
            $url =  base_url()."messenger/initchat/".encrypt_decrypt($from_sms_api->id, 'e'); 
            $imageurl = base_url()."assets/leadsfiles/logo_192_by_192.png";
            $post_vars = array(
                            "icon"        => $imageurl,
                            "title"       => 'New SMS',
                            "message"     => $message,
                            "url"         => $url,
                            "subscriber" => 'ila14nl0QiZZfT0YsmSGFA==',
                        );
            pushalert($post_vars); 
            //push alert end
            App::create_activity('lead_activity',$from_sms_api->id,'SMS Received',json_encode($_POST));
        }
    }/* End Function stripslashes_deep */
    
    /*
    *   Functionality - recive_sms Sms message : 
    *   Call from :  stripslashes_deep
    */
    public function sendSms() {
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
                                'admin_id'  => $adminID,
                                'sms_text'  => $sms,
                                'sms_to'    => $nmbr,
                                'sms_type'  => 'out',
                                'sms_time'  => date('Y:m:d H:i:s'),
                        );
                $db_activity_id = log_activity('lead_activity',$lid,$get_lead_status="",$new_lead_status="",'SMS Send '.$leadData['sms_to'],'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_lead_status->status );
                $post_adding = array_merge( $leadData, $post_data2 );
                log_message('error',serialize($post_adding));
                App::update('leads', array('id' =>$lid) , array('last_sms' => time()) );

                 $query = $this->crm_model->updateWhere('leads',array('id' => $lid),array('last_action' => 'You Sent SMS','last_action_time' => crm_dateTime( date('m-d-Y') ) ));

                $creat_date = $this->crm_model->findWhere('leads', array('id' => $lid ), array('*') );                
                $days = createLeadsAge($creat_date[0]['created']);

                    if ( $days <= 14  ) {

                        $this->db->select('id');
                        $this->db->from('nine_boxes');
                        $this->db->where('l_id',$lid);
                        $id = $this->db->get()->num_rows();
                        if ( $id > 0  ) {
                            $call_status = $this->crm_model->findWhere('nine_boxes', array('l_id' => $lid ), array('*') );
                              if ( empty($call_status[0]['sms1']) && empty($call_status[0]['sms2']) && empty($call_status[0]['sms3'] ) ) {
                                        $this->crm_model->updateWhere('nine_boxes', array('l_id' => $lid ),array( 'sms1' => '1','sms1_date' => date('Y-m-d') ));
                                 }elseif ( !empty($call_status[0]['sms1']) && empty($call_status[0]['sms2']) && empty($call_status[0]['sms3'] ) ) {
                                        $this->crm_model->updateWhere('nine_boxes', array('l_id' => $lid ),array( 'sms2' => '1','sms2_date' => date('Y-m-d') ));
                                 }elseif ( !empty($call_status[0]['sms1']) && !empty($call_status[0]['sms2']) ) {
                                     $this->crm_model->updateWhere('nine_boxes', array('l_id' => $lid ),array( 'sms3' => '1','sms3_date' => date('Y-m-d') ));
                                 }
                         }else{
                            $this->db->insert('nine_boxes', array('l_id' => $lid, 'sms1' => '1','sms1_date' => date('Y-m-d') ));
                         }
                    }
                /* nine boxes sms values end  */

                App::save_data( 'leads_sms', $leadData );
                App::create_activity('lead_activity',$lid,'SMS Sent',json_encode($leadData));
                
            } catch (Exception $e) {
                echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
                 }
        }
    }/* End Function stripslashes_deep */
    
    /*
    *   Functionality - get_live_chat chat on leads : 
    *   Call from :  get_live_chat
    */
    public function get_live_chat() {
        $data = file_get_contents('php://input');
        App::save_data('log_data',array('log_type' => 'livechat','log_data' => $data) );
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
        $date_time   = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
        $lemail      = $ddata['visitor']['email'];
        $lname       = $ddata['visitor']['name'];
        $lsource_url = $ddata['visitor']['page_current'];
        if(!empty($lemail)) {
            $result = App::get_row_by_where($table = 'leads', array('email' => $lemail), $order_by = array()); 
            $lead_id = $result->id;
        }else{
            $post_data = array(
                        'first_name'     => 'unkwon',
                        'last_name'      => '',
                        'email'          => 'unkown@perfectionkitchens.com',
                        'source'         => 3,
                        'vendor_id'      => vendor_id,
                        'source_url'     => $lsource_url,
                        'created'        => date('Y-m-d H:i:s'),
                        'lead_code'      => time(),
                        'ip'             => $this->input->ip_address(),
                    );
            $result  = App::get_row_by_where($table = 'leads', array('email' => $post_data['email']), $order_by = array()); 
            $lead_id = $result->id;
            if( $result->parent_lead  ){ $lead_id = $result->parent_lead; }
            if(!empty( $result )) {
                $clData = array(
                            'lead_id'      => $lead_id,
                            'agent_data'   => json_encode($agents_data),
                            'ready_chat'   => $rt,
                            'chat_mesage'  => $msgs,
                            'meta_data'    => $data,
                            'log_time'     =>time(),
                            'chart_time'   => $date_time
                        );
                App::save_data('live_chat',$clData );
            }else{
                if( !$lead_id = App::save_data( 'leads', $post_data ) ) {
                    log_message( 'error', 'get_live_chatBLead' . $this->db->_error_message() );
                }
                App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode($post_data));
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
                $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Add a lead form messanger','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $clData, $post_data2 );
                log_message('error',serialize($post_adding));
                App::save_data('live_chat',$clData );
                App::create_activity('lead_activity',$lead_id,'Live Chat End',json_encode($clData));
                }
            }
        if( $result ){ $lead_id = $result->id;
           }else{
            $post_data = array(
                            'first_name'    => $lname,
                            'last_name'     => '',
                            'email'         => $lemail,
                            'source'        => 3,
                            'source_url'    => $lsource_url,
                            'created'       => date('Y-m-d H:i:s'),
                            'lead_code'     => time(),
                            'ip'            => $this->input->ip_address(),
                        );
            if( !$lead_id = App::save_data( 'leads', $post_data ) ) {
                log_message( 'error', 'get_live_chatFBLead' . $this->db->_error_message() );
                }
            $adminID = $this->tank_auth->get_user_id();
            $logData_liv = array(
                                'user_id'    => $this->tank_auth->get_user_id(),
                                'module'     => 'Leads',
                                'field_id'   => $lead_id,
                                'activity'   => 'Live Chat End'                      
                            );
            $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Add a lead form messanger','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $logData_liv, $post_data2 );
            log_message('error',serialize( $post_adding ));
            App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode( $post_data ));
        }
        $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
        if(!empty( $ddata['chat']['agents']) ){
            foreach($ddata['chat']['agents'] as $akey => $aVal ){
                $agents_data[] = array('name' => $aVal['name'], 'email' => $aVal['login']);
            }
        }
        $clData = array(
                    'lead_id'        => $lead_id,
                    'agent_data'     => json_encode( $agents_data ),
                    'ready_chat'     => $rt,
                    'chat_mesage'    => $msgs,
                     'log_time'      =>time(),
                    'meta_data'      => $data,
                    'chart_time'     => $date_time
                  );
        App::save_data('live_chat', $clData );
        App::create_activity('lead_activity', $lead_id,'Live Chat End',json_encode( $clData ));
    }/* End Function get_live_chat */
    /*
    *   Functionality - live_chat show chats : 
    *   Call from :  live_chat
    */
    function live_chat(){
        $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('crm/modal/live_chat', $data);
    }/* End Function live_chat */
    
    /*
    *   Functionality - edit_leads leads : 
    *   Call from :  edit_leads
    */
    public  function edit_leads($id){
        if ( $this->input->post('id') ) {
            $olddata = (array) App::get_row_by_where( 'leads', array( 'id' => $id ) );
            $lead_statusredirect =$this->input->post('lead_status');
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
            $newphn = $this->input->post('phone');
            $getlead = (array) App::get_row_by_where('leads', array('phone'=>$newphn) );
            $name = $this->input->post('first_name');
            $firstname = strtok($name,' ');
            $lastname = trim(strstr($name,' '));
            $oldphn = $getlead['phone'];
            $idd = $getlead['id'];
            // Temp Disabled
            // if($oldphn == $newphn AND $id != $idd ){
            //     $this->session->set_flashdata('response_status','error'); 
            //     $this->session->set_flashdata('message','Phone number Already Exists ');
            //     redirect('/crm/leads');
            // }
            $match = array( 'id' => $this->input->post('id') );
            $image = $this->input->post('image_upload');
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
                if (!empty($old_status)){
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
            $ass = $this->input->post('assigned_to'); 
            $assnto = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
            $leads_ass = (array) App::get_row_by_where('leads', array('id'=>$id) );
            $assign_to_name =  $get_lead_status = get_row_data('name','user_profiles',array('id' => $leads_ass['assigned_to'] ));
            if(empty( $assign_to_name->name)){$assignName="";}else{$assignName=$assign_to_name->name; }
            if($ass != $leads_ass['assigned_to']){
                $assntoo = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                if(empty($assntoo)){ $asignto= "";}else{$asignto=$assntoo['name']; }
                $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status=$assignName,$new_lead_status=$asignto,'Assgin Change : '.$asignto,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $lead_ass, $post_data2 );
                log_message('error',serialize($post_adding));
            }
            
            $assgn         = $this->input->post('action_lead');
            $lastAction    = $this->input->post('last_action');
            $oldActionLead = $this->input->post('old_action_lead');
            $oldLastAction = $this->input->post('old_last_action');
            
            if( $assgn != 'noval' && $assgn != $oldActionLead  ){
                $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status=$action,$new_lead_status=$assgn,'Next Step change :','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $assgdata, $post_data2 );
                log_message('error',serialize($post_adding));
            }
            if($assgn == ''){
                $assgn = $oldActionLead;
            }
            if($lastAction == ''){
                $lastAction = $oldLastAction;
            }

            $post_data = array(
                            'first_name'        => $firstname,
                            'last_name'         => $lastname,
                            'email'             => $this->input->post('email'),
                            'second_phone'      => $this->input->post('second_phone'),
                            'contact_preprence' => $this->input->post('contact_preprence'),
                            'comments'          => $this->input->post('comments'),
                            'assigned_to'       => $this->input->post('assigned_to'),
                            'lead_status'       => $this->input->post('lead_status'),
                            'lost_sale_detail'  => $this->input->post('lost_sale_detail'),
                            'hoteness'          => $this->input->post('hoteness'),   
                            'note'              => $this->input->post('note'),
                            'action_lead'       => $assgn,
                            'last_action'       => $lastAction,
                            'last_action_note'  => $this->input->post('last_action_note'),
                            'call_start_time'   => $this->input->post('call_start_time'),
                            'call_end_time'     => $this->input->post('call_end_time'),
                            'last_action_time'  => crm_dateTime( date('m-d-Y') ),
                            'phone'             => $newphn,
                            'image_upload'      => $image,
                            'lead_code'         => time(),
                            'ip'                => $this->input->ip_address(),
                            'secondry_email'    => $this->input->post('secondry_email'),
                            'qf_lead_status'    => $this->input->post( 'qf_lead_status' ),
                            'qf_low_amount'     => $this->input->post( 'qf_low' ),
                            'qf_high_amount'     => $this->input->post( 'qf_high' ),
                        );


                /* nine boxes value insert start */
                    $call_status = $this->crm_model->findWhere('leads', array('id' => $id ), array('*') );
                    /*if ( $call_status[0]['last_action'] != $post_data['last_action'] ) {*/
                        if ( !empty( $post_data['last_action'] ) ) {
                            $date1=date_create($this->input->post('created_lead'));
                            $date2=date_create(date('Y-m-d'));
                            $diff=date_diff($date1,$date2);
                            $leadage = $diff->format("%a");
                            $ctime = date( 'H',time() );
                            $cbyday = date('D'); 
                            $cday =  array('Mon','Tue','Wed','Thu','Fri');

                            if (in_array($cbyday , $cday)){ $wDays = 'yes'; }else{ $wDays = 'no'; }

                            if ( $post_data['last_action'] == 'You Called' ) {
                                if ( $leadage <= 7  ){
                                    if ( $wDays == 'yes' ) {
                                        if ( $ctime >= 9 && $ctime < 17  ) {
                                            $collup = 'w1d';
                                            $calldate = 'w1d_date';
                                        }elseif ( $ctime >= 17 && $ctime < 22 ) {
                                            $collup = 'w1n';
                                            $calldate = 'w1n_date';
                                        }
                                    }elseif ( $wDays == 'no' ) {
                                        if ( $ctime <= 9 && $ctime > 22 ) {
                                            $collup = 'w1e';
                                            $calldate = 'w1e_date';
                                        }                                    
                                    }
                                }else if ( $leadage > 7 && $leadage <= 14   ){
                                    if ( $wDays == 'yes' ) {
                                        if ( $ctime >= 9 && $ctime < 17  ) {
                                            $collup = 'w2d';
                                            $calldate = 'w2d_date';
                                        }elseif ( $ctime >= 17 && $ctime < 22 ) {
                                            $collup = 'w2n';
                                            $calldate = 'w2n_date';
                                        }
                                    }elseif ( $wDays == 'no' ) {
                                            if ( $ctime >= 9 && $ctime < 22 ) {
                                                $collup = 'w2e';
                                                $calldate = 'w2e_date';   
                                            }                                    
                                    }
                                }
                                $col_exist = $this->crm_model->countNumrows('nine_boxes', array('l_id' => $match['id'] ) );
                                
                                if ( $col_exist ) {
                                    App::update('nine_boxes', array('l_id' => $match['id']),array($collup => '1',$calldate => date('Y-m-d') ));

                                }else{
                                    $this->db->insert('nine_boxes',array('l_id' => $match['id'],$collup => '1',$calldate => date('Y-m-d')));
                                }
                            }
                        }

                    /* nine boxes value insert end */


            if (!empty($this->input->post('reminder_date') ) ){
                $post_data['reminder_date'] = crm_dateTime( $this->input->post('reminder_date') );
            }
            if ( $this->input->post('lead_status') == lead_Contacted_Paperwork_Pending ){
                $post_data['pw_dateadded'] = date('Y-m-d H:i:s');
                $post_data['qf_status'] = '17';
            }else if( $this->input->post('lead_status') == int_lead_Need_More_Info_to_Start ){
                $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                $post_data['qf_status'] = int_lead_Not_Started;
                $ldata = (array) App::get_row_by_where('leads', array('id'=>$id) );
                $firstname= $ldata['first_name'];
                $lastname = $ldata['last_name'];
                $ur = base_url('crm/leads/dashboard/'.$id);
                $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                $emailVar['_emailto'] = $PST;
                $emailVar['{name}'] = $firstname.' '.$lastname;
                $emailVar['{lead_url}'] =$ur;
                $emailSent = send_email('lead_qualified', $emailVar);
                $LogArr = array( 'sent_email' => $emailSent, 'lead' => $ur );
                
                
            }else if( $this->input->post('lead_status') == lead_Presentation_Lead ){
                $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                $post_data['qf_status'] = int_lead_Not_Started;
                }   
            $get_lead_data = get_row_data('*','leads',array('id' => $id ));
            if( !empty( $get_lead_data->lead_status )){
                $get_lead_status = get_row_data('status','status_lead',array('id' => $get_lead_data->lead_status ));
                $get_lead_s = $get_lead_status->status; 
            }else{
                $get_lead_s = "";
                  }
            $new_lead_status = get_row_data('status','status_lead',array('id' => $post_data['lead_status'] ));
            if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
            if( ($get_lead_s != $new_l_status) || ($get_lead_s == "" && $new_l_status !="") || ($get_lead_s !="" && $new_l_status =="")  ){
                $db_activity_id = log_activity('lead_activity',$id,  $get_lead_s, $new_l_status,'Update Lead Status','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_l_status );
            }else{
                $db_activity_id = log_activity('lead_activity',$id, $get_lead_status = "", $new_lead_status ="",'Update Lead Profile','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                }
            $post_adding = array_merge( $post_data, $post_data2 );
            log_message('error',serialize( $post_adding ));
            App::update('leads', $match, $post_data);
            $post_data['success'] = array();
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Lead has been Update successfully');
            if($lead_statusredirect == lead_Contacted_Schedule_In_Home_Appointment){
                    redirect('/crm/MRLeads/dashboard/'.$id);
                }else if ($lead_statusredirect == int_lead_Need_More_Info_to_Start ){
                    redirect('/crm/Qualified/dashboard/'.$id);
                }else if($lead_statusredirect == lead_Presentation_Lead ){
                        redirect('/crm/Presentation/dashboard/'.$id);
                }else if ($lead_statusredirect == lead_Contacted_Paperwork_Pending ){
                    redirect('/crm/PWleads/dashboard/'.$id);
                }else if ($lead_statusredirect == lead_Lost_sale ){
                        redirect('/crm/leads/dashboard/'.$id);
                }else{
                redirect('/crm/leads/edit_leads/'.$id);  
                }
        }else{
            $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
            $result = $this->db->select('*')->from('status_lead')->order_by("status", "asc")->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.user_id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $this->template->title('Edit Lead');
            $this->template
                 ->set_layout('inner')->build('edit',$data);
       }
    }/* End Function edit_leads */
    
    /*
    *   Functionality - quick_edit Edit lead : 
    *   Call from :  quick_edit
    */
    public function quick_edit($id){
        if ( $this->input->post('id') ) {
            $adminID = $this->tank_auth->get_user_id();
            $ass = $this->input->post('assigned_to'); 
            $assnto = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
            $leads_ass = (array) App::get_row_by_where('leads', array('id'=>$id) );
            if($ass != $leads_ass['assigned_to']){
                $assntoo = (array) App::get_row_by_where('user_profiles', array('user_id'=>$ass) );
                $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status="",$new_lead_status="",'Quick Edit Assgin Change  : '.$assntoo['name'],'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = @array_merge( $ass, $post_data2 );
                log_message('error',serialize($post_adding));
                
             }
            $assgn =$this->input->post('action_lead');
            $assnlead = (array) App::get_row_by_where('leads', array('id'=>$id) );
            $action =$assnlead['action_lead'];
            if($assgn != $action  ){
                $db_activity_id = log_activity('lead_activity',$this->input->post('id'),$get_lead_status="",$new_lead_status="",'Next Step change : '.$action .'  to  '.$assgn,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = @array_merge( $assgn, $post_data2 );
                log_message('error',serialize($post_adding));
            }
            $match = array('id' => $this->input->post('id'));
            $timestamp = strtotime( str_replace("-","/",$this->input->post('reminder_date')) ); 
            $new_date = date('Y-m-d', $timestamp);
            $curr_time = date('h:i:sa');
            $post_data = array(
                            'assigned_to'        =>$this->input->post('assigned_to'),
                            'action_lead'        =>$this->input->post('action_lead'),
                            'reminder_date'      => $new_date.' '.$curr_time,
                            'ip'                 => $this->input->ip_address(),
                        );
                                  
            App::update('leads', $match, $post_data);
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
    }/* End Function quick_edit */
    
    /*
    *   Functionality - load_script Use js : 
    *   Call from :  load_script
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End Function load_script */

    public  function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* End Function load_css */
    
    /*
    *   Functionality - getLeads Get Leads in table : 
    *   Call from :  getLeads
    */
    public function getLeads(){
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $Select_status = $this->crm_model->resultArray('status_lead');
        $columns = array(
                        0  => 'lids',
                        1  => 'p.name',
                        2  => 'username',
                        3  => 'w1d',
                        4  => 'last_action',
                        5  => 'sl.status',
                        6  => 'last_action_time',
                        7  => 'hs',
                        8  => 'reminder_date',
                        9  => 'action_lead'
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
        
        $sql = "SELECT l.*, l.id as lids, CONCAT(l.first_name,' ', l.last_name) as username,l.email,l.phone,l.lead_status,l.action_lead,l.reminder_date,l.hoteness,l.created,l.assigned_to,l.qf_status,p.name as assign,p.id as ids,sl.*,sl.id as slids,nb.*,
       ( SELECT SUM(`point`) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id)) AS survey,
       ( SELECT SUM(`point`)+ (SELECT hoteness*2*10  FROM leads WHERE id = l.id) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id) ) AS hs
        FROM leads l  left join user_profiles p on l.assigned_to =p.user_id left join nine_boxes nb on nb.l_id = l.id left join status_lead sl on l.lead_status = sl.id WHERE 1 = '1' ";
        
        $totalData = $this->crm_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;

        $statusFilter = $_REQUEST['columns'][5]['search']['value'];
        $AssignFilter = $_REQUEST['columns'][1]['search']['value'];
        $nStepFilter  = $_REQUEST['columns'][10]['search']['value'];
        $searchfilter = $requestData['search']['value'];

        if ( empty($searchfilter) ) {
            $newSql = '';
            if ( !empty($statusFilter) ) {
                $newSql .= " AND l.lead_status IN (".$statusFilter.")";
            }
            if ( !empty($AssignFilter) ) {
                $newSql .= " AND l.assigned_to IN (".$AssignFilter.")";
            }
            if ( !empty($nStepFilter) ) {
                $contArr = explode(',', $nStepFilter);
                $fString = '';
                foreach ($contArr as $cKey => $cValue) {
                    if ($cKey > 0) {
                        $fString .= ' OR ';
                    }
                    $fString .= "l.action_lead like '%$cValue%'";
                }
                $newSql .= " AND ( $fString )";
            }
            $sql .= $newSql;
        }
        $sql.= $likesql;

        // echo $sql; die;

        // if( !empty( $requestData['search']['value'] ) && empty( $statusFilter ) && empty( $AssignFilter )  ) {  
        //     $sql.= $likesql;
        // }elseif ( empty($searchfilter) && !empty( $statusFilter ) && empty( $AssignFilter ) ) {
        //     $sql.= " AND l.lead_status IN (".$statusFilter.")";
        // }elseif ( empty( $searchfilter ) && empty( $statusFilter ) && !empty( $AssignFilter )  ) {
        //     $sql.= " AND l.assigned_to IN (".$AssignFilter.")";
        // }elseif( empty( $searchfilter ) && !empty( $statusFilter ) && !empty( $AssignFilter ) ){
        //     $sql.= " AND l.assigned_to IN (".$AssignFilter.") AND l.lead_status IN (".$statusFilter.")  ";
        // }elseif( !empty($searchfilter) && !empty($statusFilter) && !empty($AssignFilter) ){
        //     $sql.= " AND l.assigned_to IN (".$AssignFilter.") AND l.lead_status IN (".$statusFilter.") ";
        //     $sql.= $likesql;
        // }elseif ( !empty( $searchfilter ) && !empty( $statusFilter ) && empty( $AssignFilter ) ) {
        //     $sql.= " AND l.lead_status IN (".$statusFilter.") ";
        //     $sql.= $likesql;
        // }elseif ( !empty($searchfilter) && empty($statusFilter) && !empty($AssignFilter) ) {
        //     $sql.= " AND l.assigned_to IN (".$AssignFilter.") ";
        //     $sql.= $likesql;
        // }
    
        $totalFiltered = $this->crm_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // echo $sql;
        $total_record = $this->crm_model->custom_query($sql,false,'array'); 
        
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) ) {
        foreach( $total_record as $row){

           if( empty( $row['assign'] ) ){
                $assignName = $row['assign'] = 'N/A';
            }else{
                $assignName =  ucfirst($row["assign"]);
            }
        if( !empty( $row['lead_status'] ) ){
                $sta = (array) App::get_row_by_where('status_lead', array( 'id' => $row['lead_status']) );
            }else{
                $sta = array('status' =>'Not contacted');
                }  
        if(!empty($row['action_lead'])) { $led= $row['last_action']; }else{ $led="NA";  } 
            if(!empty($row['reminder_date'])){ 
                $rem = crm_date($row['reminder_date']);
            }else{  $rem="NA"; }   
        if(!empty($row['hoteness'])) { $hot=$row['hoteness']; } else{ $hot="0"; } 
            $dt = new DateTime();
            $olddate = strtotime( $row['created'] );
            $curdate = strtotime( $dt->format('Y-m-d') );
            $age= humanTiming($olddate);
            $leademail = $row['email']; $leadphone = $row['phone'];
        if(!empty( $leadphone )){
            $sql1 = "SELECT leads_id FROM customer WHERE email = '$leademail' AND phone = '$leadphone'";
            $countRows = $this->crm_model->custom_query($sql1,true,'array');
        }else{
            $sql1 = "SELECT leads_id FROM customer WHERE email = '$leademail'";
            $countRows = $this->crm_model->custom_query($sql1,true,'array');
            }
        if( empty($row['survey']) ){ $row['survey'] = 0; }
        $html= '';
                if( $countRows < 1 ){      
                $html .=  '<a href="'.base_url().'customer/customer/add/'.$row['lids'].'" data-toggle="tooltip" data-placement="top" title="Add Customer" style="color:#808080 !important" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fa fa-plus-square" aria-hidden="true" ></i></a>';
                 } else {                            
                $html .=  '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Already Customer"  class="action-icon create-customer" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fas fa-ban"></i></a>';
                }                                 
                $html .=  '<a href="'.base_url().'crm/leads/edit_leads/'.$row['lids'].'" data-toggle="tooltip" data-placement="top" title="Edit Lead" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';

                $html .=  '<a href="'.base_url().'crm/leads/quick_edit/'.$row['lids'].'" data-toggle="tooltip" data-placement="top" title="Quick Edit" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal_edit" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>';
                $html .=   '<a href="'.base_url().'crm/leads/dashboard/'.$row['lids'].'" data-toggle="tooltip" data-placement="top" title="Dashboard" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                $html .=   '<a href="javascript:void(0);"data-toggle="tooltip" data-placement="top" title="Delete" id="deleteUser" class="action-icon" style="color:#808080 !important" ids="'.$row['lids'].'"> <i class="mdi mdi-delete"></i></a>';
                $pending = "pending";

            $nine_array = array( 'w1d','w1n','w1e','w2d','w2n','w2e','sms1','sms2','sms3');

            $days           = createLeadsAge($row['created']);
            $check_mark     = array( '2','15','22','3','10','4','16','17','23','24','19','5','6','18','7' );
            $after_two_week = array( '2','15','3','10','4','16','17','19','5','6','18','7' );

            
            $box_border  = '';
            $mark = '';
            $BoxesAndClause  = $this->checkBoxesAndClause($row);
            $BoxesOrClause   = $this->checkBoxesOrClause($row);
            $BoxesOneBox     = $this->checkBoxesOneEmpty( $row );
            $countFillColumn = $this->crm_model->sumOfFillColumn($row['lids']);
            //echo $BoxesOrClause; echo $row['lids']. '<br>';continue;
            if ( $days <= 14 && $row['lead_status'] != '21' ){
                if(in_array($row['lead_status'],$check_mark )) {
                    $box_border  = 'nine_boxes_border';
                    $mark = '<span class="check_mark">&#x2714;</span>';
                }elseif( $BoxesAndClause == 1 && $row['lead_status'] == '13' ){
                          $box_border  = 'nine_boxes_border';
                          $mark = '<span class="check_mark">--</span>';
                }elseif ( ($BoxesOrClause == '1' || $BoxesAndClause == 1 ) && $row['lead_status'] == '8'  ) {
                          $box_border  = 'nine_boxes_border';
                          $mark = '<span class="check_mark">L</span>';
                }
            }elseif ( $BoxesAndClause == 1 && $row['lead_status'] == '21' ) {
                $box_border  = 'nine_boxes_border';
                $mark        = '<span class="check_mark">N</span>';
            }

            if ( $days >= 14 ) {
                if ( $BoxesOneBox == true){
                    if( $row['lead_status'] == '1' || $row['lead_status'] == '13' ){
                        $box_border  = 'nine_boxes_border_yellow';
                        $mark        = '<span class="check_mark_yellow">'.$countFillColumn[0]['sum_fill_column'].'</span>';
                    }elseif ( $row['lead_status'] == '8' ) {
                        $box_border  = 'nine_boxes_border_yellow';
                        $mark        = '<span class="check_mark_yellow">'.$countFillColumn[0]['sum_fill_column'].' L</span>';
                    }elseif ( $row['lead_status'] == '21' ) {
                        $box_border  = 'nine_boxes_border_yellow';
                        $mark        = '<span class="check_mark_yellow">'.$countFillColumn[0]['sum_fill_column'].' N</span>';
                    }elseif ( in_array($row['lead_status'],$after_two_week ) ) {
                        $box_border  = 'nine_boxes_border_yellow';
                        $mark        = '<span class="check_mark_yellow">'.$countFillColumn[0]['sum_fill_column'].'</span>';
                    }
                }
                
            }
            
            
            $qfClass = '';
            $qfletter = '';
            $range = '';
            if( $row['qf_lead_status'] == 'qualified'    ){
                $qfClass = 'qfboxgreen';
                $qfletter = 'Q';
                $qftooltip = 'Qualified';
                if( $row['qf_low_amount'] >= '7000' && $row['qf_low_amount'] <= '10000'   ){
                        $range = $row['qf_low_amount'] .'-'. $row['qf_high_amount'];    
                }
            }elseif( $row['qf_lead_status'] == 'disqualified' ){
                $qfClass  = 'qfboxred';
                $qfletter = 'DQ';
                $qftooltip = 'DisQualified';
                $range = '';
                
            }elseif( $row['qf_lead_status'] == 'unqualified' ){
                $qfClass = 'qfboxyellow';
                $qfletter = 'UQ';
                $qftooltip = 'UnQualified';
                $range = '';
            }

            $qfBox = "<div class='qfbox ".$qfClass."'>";
            $qfBox.= "<span data-toggle='tooltip' data-placement='top' title='".$qftooltip."'>".$qfletter."<br>".$range."</span>";
            $qfBox.= "<div>";
            
            $nine  = "<div class='".$box_border."'>";
            if (!$box_border) {
                $nine .= '<ul class="nine_boxesF"><li></li><li>WD</li><li>WN</li><li>WE</li></ul>';
                $nine .= '<ul class="nine_boxesF">';
                $wc = 0;
                foreach ($nine_array as $key => $value) {
                    $Ndate = $row[$value.'_date'];
                    
                    if($wc == 0){
                        $nine .= '<li>W1</li>';
                    }
                    if($wc == 3){
                        $nine .= '</ul><ul class="nine_boxesF"><li>W2</li>';
                    }
                    if($wc == 6){
                        $nine .= '</ul><ul class="nine_boxesF"><li>SMS</li>';
                    }
                    $nine .= ( $row[$value] ) ? '<li><div class="green_boxes" data-toggle="tooltip" title="'.crm_date( $Ndate ).'"></div></li>': '<li><div class="red_boxes" data-toggle="tooltip" title="NC"></div></li>'; 

                    $wc++;
                }
                $nine .= '</ul>';
            }
            $nine .= $mark;
            $nine .= '</div>';

        if($row["email"]!='unkown@perfectionkitchens.com' && $row['parent_lead'] =='0' ){

        $data[] = array(
                        $row["lids"],
                        $qfBox,
                        $assignName, 
                        '<a href="'.base_url().'crm/leads/dashboard/'.$row['lids'].'" >'
                         . $row["username"].'</a><br>'.$row["email"].'<br>'.phoneNumberPattern($row["phone"]), 
                        $nine,
                        $led." / <b>".crm_date($row['last_action_time'])."</b>",
                        $row['status'],
                        $row['action_lead']." / <b>".$rem."</b>",
                        $row['survey'].'/'.$hot,
                        $age,
                        $html,
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

    function checkBoxesAndClause($nineBoxCol){

        $allFill = false;
        if ( $nineBoxCol['w1d'] && $nineBoxCol['w1n'] && $nineBoxCol['w1e'] && 
             $nineBoxCol['w2d'] && $nineBoxCol['w2n'] && $nineBoxCol['w2e'] && 
             $nineBoxCol['sms1'] && $nineBoxCol['sms2'] && $nineBoxCol['sms3'] ) {
             $allFill = true;
        }
        return $allFill;
    }

    function checkBoxesOrClause($nineBoxCol){

        $allFill = false;
        if ( $nineBoxCol['w1d'] || $nineBoxCol['w1n'] || $nineBoxCol['w1e'] || 
             $nineBoxCol['w2d'] || $nineBoxCol['w2n'] || $nineBoxCol['w2e'] || 
             $nineBoxCol['sms1'] || $nineBoxCol['sms2'] || $nineBoxCol['sms3'] ) {
            $allFill =  true;
        }
        return $allFill;
    }

    function checkBoxesOneEmpty($nineBoxCol){

        $allFill = false;
        if ( $nineBoxCol['w1d'] == false || $nineBoxCol['w1n'] == false || $nineBoxCol['w1e'] == false || 
             $nineBoxCol['w2d'] == false || $nineBoxCol['w2n'] == false || $nineBoxCol['w2e'] == false || 
             $nineBoxCol['sms1'] == false || $nineBoxCol['sms2'] == false || $nineBoxCol['sms3'] == false ) {
            $allFill =  true;
        }
        return $allFill;
    }



    public function survey( $id ){
        $data = array();
        $id =  $this->uri->segment(4);
        $data['lead_id'] = $id;
        $sql = "SELECT * FROM survey_questions WHERE 1=1 ";
        $totalQuestions = $this->crm_model->custom_query($sql,false,'array');
        foreach( $totalQuestions as $key ){
            $totalOptions = array();
            $sql = "SELECT * FROM survey_qoptions WHERE question_id = ".$key['id'];
            $totalOptions = $this->crm_model->custom_query($sql,false,'array');
            $ansQuery = "SELECT * FROM survey_answers WHERE lead_id = ".$id." AND question_id = ".$key['id'];
            $ans = $this->crm_model->custom_query($ansQuery,false,'array');
            $data['qa'][] = array(
                               'ques'    => $key, 
                               'options' =>$totalOptions,
                               'ans'     => $ans
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
                                  'lead_id'     => $lead_id,
                                  'answer'      => $qVal, 
                                  'question_id' => $qID
                                  );
                    App::save_data('survey_answers',$saveQ);
                }
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Survey Score','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                log_message('error',serialize( $post_data2 ));    
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Survey has been Updated');
                redirect('/crm/leads/survey/'.$id); 
            }else{
                $saveQ = array();
                foreach( $_POST as $qKey => $qVal){
                    $qID = explode('_',$qKey)[1];
                    $match = array ( 'lead_id' => $lead_id,'question_id' => $qID );
                    $saveQ = array( 'answer' => $qVal );
                    App::update('survey_answers', $match, $saveQ );
                }
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Update Survey Score','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                log_message('error',serialize( $post_data2 ));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Survey has been Updated');
                redirect('/crm/leads/survey/'.$id);     
                }  
        }
        $this->template->title('survey');
        $this->template
             ->set_layout('inner')
             ->build('leads/survey', $data);
    }/* End Function survey */
    
    /*
    *   Functionality - qualified lead show : 
    *   Call from :  survey
    */    
    public function qualified() {
        $data = array();
        $this->template->title(' Leads');
        $this->template
             ->set_layout('inner')
             ->build('qualified', $data);
    }/* End Function qualified */
    
    /*
    *   Functionality - pw_form add  Kittchen details: 
    *   Call from :  pw_form
    */    
    public function pw_form(){
        
        $id = $this->uri->segment(4);
        
        if( $this->input->post() ) {
            if( !empty( $this->input->post('option_request') ) ){
                $option_request = implode(", ",$this->input->post('option_request'));
            }else{ 
            	$option_request='';  
            }

            $match = array('lead_id' => $id );
            $post_data = array(
            	'lead_id' 						   => $id,
                'cabinet_manufacturer'             => $this->input->post('cabinet_manufacturer'),
                'door_style'                       => $this->input->post('door_style'),
                'desired_flooring_type'            => $this->input->post('desired_flooring_type'),
                'desired_flooring_color'           => $this->input->post('desired_flooring_color'),
                'backsplash'                       => $this->input->post('backsplash'),
                'countertop_type'                  => $this->input->post('countertop_type'),
                'countertop_color'                 => $this->input->post('countertop_color'),
                'knobs_and_handles'                => $this->input->post('knobs_and_handles'),
                'sink_type'                        => $this->input->post('sink_type'),
                'sink_color'                       => $this->input->post('sink_color'),
                'sink_bowls'                       => $this->input->post('sink_bowls'),
                'keeping_existing'                 => $this->input->post('keeping_existing'),
                'dishwasher_size'                  => $this->input->post('dishwasher_size'),
                'desired_dishwasher_color'         => $this->input->post('desired_dishwasher_color'),
                'dishwasher_quantity'              => $this->input->post('dishwasher_quantity'),
                'range_size'                       => $this->input->post('range_size'),
                'cooktop_size_p'                   => $this->input->post('cooktop_size_p'),
                'wall_oven_count'                  => $this->input->post('wall_oven_count'),
                'wall_oven_width'                  => $this->input->post('wall_oven_width'),
                'cooktop_size'                     => $this->input->post('cooktop_size_p'),
                'microwave'                        => $this->input->post('microwave'),
                'microwave_width'                  => $this->input->post('microwave_width'),
                'hood'                             => $this->input->post('hood'),
                'refrigerator_width'               => $this->input->post('refrigerator_width'),
                'refrigerator_depth'               => $this->input->post('refrigerator_depth'),
                'applicance_other'                 => $this->input->post('applicance_other'),
                'crown_molding'                    => $this->input->post('crown_molding'),
                'crown_molding_touch_ceiling'      => $this->input->post('crown_molding_touch_ceiling'),
                'light_rail'                       => $this->input->post('light_rail'),
                'cabinet_wall_height'              => $this->input->post('cabinet_wall_height'),
                'option_request'                   => $option_request,
                'ceiling_height'                   => $this->input->post('ceiling_height'),
                'soffit'                           => $this->input->post('soffit'),
                'soffit_yes_keeping'               => $this->input->post('soffit_yes_keeping'),
                'walls_be_moved'                   => $this->input->post('walls_be_moved'),
                'doors_be_moved'                   => $this->input->post('doors_be_moved'),
                'plumbing_be_moved'                => $this->input->post('plumbing_be_moved'),
                'range_location_be_moved'          => $this->input->post('range_location_be_moved'),
                'refrigerator_location_be_moved'   => $this->input->post('refrigerator_location_be_moved'),
                'prequalified'                     => ( $this->input->post('prequalified') ) ? $this->input->post('prequalified') : 'no',
                'kitchen_note'                     => $this->input->post('kitchen_note'),
                'preamount'                        => $this->input->post('preamount')
            );
            
            $db_activity_id = log_activity('lead_activity', $id, $get_lead_status="",
                                                                 $new_lead_status="",
                                                                 'Add Kitchen Details','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $post_data, $post_data2 );
            
            $Pwdata = (array) App::get_row_by_where('pw_pending_w', array( 'lead_id' => $id ) );
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $post_data, $post_data2 );
            log_message('error',serialize($post_adding));
            
            if( empty( $Pwdata ) ) {
                App::save_data( 'pw_pending_w', $post_data );
            }else{
                App::update('pw_pending_w', $match, $post_data );
            }
            
            $post_data['success'] = array();
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Paper Work  Update successfully');
            redirect('crm/leads/pw_form/'. $id);
        }
       
        $data['pw_pending'] = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
            
        $this->template->title('P pending');
        $this->template
             ->set_layout('inner')
             ->build('leads/pwForm', $data);
    }/* End Function pw_form */
    
    /*
    *   Functionality - assignleads the lead: 
    *   Call from :  assignleads
    */    
    public function assignleads() {
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
            }else{ echo "false"; }
        }
    }/* End Function assignleads */
    
    /*
    *   Functionality - assign_livechat  unassign chat: 
    *   Call from :  assign_livechat
    */  
    public  function assign_livechat(){
        $Lid = (array) App::get_by_where('leads', array('email'=>'unkown@perfectionkitchens.com'));
        if(!empty($Lid)){
           $leadid =$Lid[0]->id;
        }else{
            $leadid=""; 
            }
        $this->db->select('*');
        $this->db->from('live_chat');
        $this->db->where(array('lead_id' => $leadid ));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $data['live_chats'] = $query->result('array');
        $this->template->title('P chat');
        $this->template
              ->set_layout('inner')
              ->build('crm/chat_assign',$data);
    }/* End Function assign_livechat */
    
    /*
    *   Functionality - add_assign_chat  Add lead unassign chats : 
    *   Call from :  add_assign_chat
    */ 
    public function add_assign_chat(){
        $id =  $this->uri->segment(4);
        if ( $this->input->post('email') ) {    
            $data['errors'] = array();
            $email = $this->input->post('email');
            $leaddata =$this->crm_model->findWhere('leads', array('email' => $email, ), array('*') );
            if(!empty( $leaddata)){
                $lid=$leaddata[0]['id'];
                $match = array ('id' => $this->uri->segment(4));
                $data = array('lead_id'  => $lid);
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Assign Chat has been updated successfully'); 
                App::update('live_chat',$match,$data);
                redirect('crm/leads/assign_livechat'); 
            }else{
                $vendor_id = $this->session->userdata('vendor_id');
                $post_data = array(
                                'first_name'    =>'No',
                                'Last_name'     =>'Name',
                                'email'         => $this->input->post('email'),
                                'created'       => date('Y-m-d H:i:s'),
                                'vendor_id'     => $vendor_id,
                                'lead_code'     => time(),
                                'ip'            => $this->input->ip_address()
                            );
                if( !$lead_id = App::save_data( 'leads', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Assign Chat didn\'t save, Try again!');
                    redirect('/crm/leads/assign_livechat');
                }else{  
                    $match = array ('id' => $this->uri->segment(4));
                    $data = array('lead_id'  => $lead_id);
                    App::update('live_chat',$match,$data);
                    $db_activity_id = log_activity('lead_activity',$this->uri->segment(4), $get_lead_status = "", $new_lead_status="",'Add Lead Live chat: '.$post_data['first_name']. " ".$post_data['last_name'],'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $post_data, $post_data2 );
                    log_message('error',serialize( $post_adding ));
                    //psuhalert
                    $message = 'From Live chat. #'.$this->db->insert_id().'-'. $post_data['email'];
                    $url =  base_url()."crm/leads";
                    $imageurl = base_url()."assets/leadsfiles/logo_192_by_192.png";
                    $post_vars = array(
                                      "icon" => $imageurl,
                                      "title" => 'New Lead',
                                      "message" => $message,
                                      "url" => $url,
                                      "subscriber" => 'ila14nl0QiZZfT0YsmSGFA==',
                                    );
                            pushalert($post_vars); 
                    //pushalert        
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Assign Chat successfully');
                    redirect('/crm/leads/assign_livechat');
                    }
                }
        }
        $this->load->view('modal/assign_lead',$id);
    }/* End Function add_assign_chat */
    
    /*
    *   Functionality - ass_chat_record_  show chat unassign chats : 
    *   Call from :  ass_chat_record_
    */ 
    public function ass_chat_record_() {
        $id = $this->uri->segment(4);
        $this->db->select('*');
        $this->db->from('live_chat');
        $this->db->where(array('id' =>  $id));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $data['leads'] = $query->result('array');
        $this->load->view('crm/modal/ass_chat_record', $data);
    }/* End Function ass_chat_record_ */
    
    /*
    *   Functionality - duplicate_lead  show dupicate leads : 
    *   Call from :  duplicate_lead
    */ 
    public function duplicate_lead() {
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
        echo "askaksnlasnlnsclansclnasclnasclnasclansc";
        $this->load->view('auth/index', $data);
        $this->template->title(' DLeads');
        $this->template->set_layout('inner')->build('duplicate_lead', $data);
   }/* End Function duplicate_lead */
    
    /*
    *   Functionality - add_merge  add lead leads : 
    *   Call from :  add_merge
    */ 
    public function add_merge(){
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
                    'parent_lead'     => $pid,
                    'secondry_email'  => $Pemail,
                    'secondry_phone'  => $Pphone,
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
    }/* End Function add_merge */
    
    /*
    *   Functionality - send_status_email  send_status_email : 
    *   Call from :  send_status_email
    */ 
    public function send_status_email(){
        $date = date('Y/m/d H:i:s');
        $qc_after_2_hour = $this->crm_model->custom_query("SELECT id, qf_status, qf_dateAdded FROM leads WHERE qf_status='Not Started' AND qf_dateAdded <= (NOW() - INTERVAL 2 HOUR)",false,'array');
        $qc_after_1_hour = $this->crm_model->custom_query("SELECT id, qf_status, qc_start_date FROM leads WHERE qf_status='Ready for Q/C' AND  qc_start_date <= (NOW() - INTERVAL 1 HOUR)",false,'array');
    }/* End Function send_status_email */
    
    /*
    *   Functionality - edit_task  task : 
    *   Call from :  edit_task
    */ 
    public function edit_task( $id ) {
        $lead_id = $this->input->post('lead_id');
        if ( $this->input->post('task_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('task_id');
            $status = $this->input->post('status');
            if($status = 'completed'){
                $ldata = (array) App::get_row_by_where('leads', array( 'id' => $lead_id ) );
                $firstname= $ldata['first_name'];
                $lastname = $ldata['last_name'];
                $ur=base_url('crm/leads/dashboard/'.$lead_id);
                $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                $emailVar['_emailto'] = $PST;
                $emailVar['{name}'] = $firstname.' '.$lastname;
                $emailVar['{lead_url}'] =$ur;
                send_email('task_completed', $emailVar);
            }
            $match = array ( 'id' => $this->input->post('task_id'));
            $data = array(
                        'task_title'        => $this->input->post('task_title'),
                        'task_desc'         => $this->input->post('task_desc'),
                        'assigned_team'     => $this->input->post('assigned_team'),
                        'status'            => $this->input->post('status'),
                    );
            $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Edit  Task lead ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Task has been updated successfully'); 
                        App::update('task',$match,$data);
                        redirect('crm/leads/get_task/'.$lead_id);
        }else{
            $result = $this->db->select('*')->from('assign_team')->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $data['task'] = (array) App::get_row_by_where('task', array('id'=>$id) );
            $this->load->view('modal/edit_task', $data);
        }
    }/* End Function edit task */
    
    /*
    *   Functionality - get_task  task : 
    *   Call from :  get_task
    */   
    public  function get_task(){
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
    }/* End Function get task */
    
    /*
    *   Functionality - Prdelete_task  Delete : 
    *   Call from :  Prdelete_task
    */   
    public function Prdelete_task(){
          if ( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            $query = $this->crm_model->select_where('lead_id','task',array('id' => $ids ));
            $query_name = $this->crm_model->select_where('first_name','leads',array('id' =>$query->lead_id ));
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'task');
            if($data == true){
                $activaty = array( 
                                'user_id' => $this->tank_auth->get_user_id(),
                                'module'  => 'leads',
                                'field_id' => $leads_id,
                                'activity'=> 'Delete a file : '
                            );
                $db_activity_id = log_activity('lead_activity',$query->lead_id,
                                                               $get_lead_status = "",
                                                               $new_lead_status =  "",
                                                               'Delete a task : '.$query_name->first_name,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize( $post_adding ));              
                App::LogActivity( $activaty );
                echo "TRUE";
            }else{
                echo "FALSE";
                }
        }
    }/* End Function Prdelete_task  */
    
    /*
    *   Functionality - coll_menu  menu  : 
    *   Call from :  coll_menu
    */  
    public function coll_menu() {
        if( isset( $_POST['valuebtn'] ) ){
            $user_id =  $this->tank_auth->get_user_id();
            $query =  $this->crm_model->findWhere('coll_menu',array('user_id' => $user_id),FALSE,array('coll_value'));
            if(!empty($query) ){
                switch ($query['coll_value']) {
                          case '0':
                $this->crm_model->updateWhere('coll_menu',array('user_id' => $user_id),array('coll_value' => '1'));
                            break;
                          case '1':
                 $this->crm_model->updateWhere('coll_menu',array('user_id' => $user_id),array('coll_value' => '0'));
                          break;
                }
            }else{
                $data = array(
                           'user_id' => $user_id,
                           'coll_value' => '1'
                         );
                $query =  $this->db->insert('coll_menu',$data);
                }
        }
    }/* End Function coll_menu  */
    
    /**
     *   Functionality : Save subscriber ids from pushalert api : 
     *   Call from : pushalert script in head section layout/inner.php
     */  
    public function pushalert() {
        
        $subs_id = $_POST['subs_id'];
        $subs_info = $_POST['subs_info'];
        $user_id = $this->session->userdata('user_id');
        
        if( isset( $_POST['subs_id'] ) ) {
            
            if( $subs_info == 'true' ) {
                
                $sql = "SELECT * FROM push_alert WHERE user_id = '$user_id' AND subs_id = '$subs_id' ";
                $count = $this->crm_model->custom_query($sql,TRUE,'array');
                // if user is already subcribed but subscriber id not found then insert 
                if( $count == 0 ) {
                    
                     $post_data = array(
                        'user_id' => $user_id,
                        'subs_id' => $subs_id,
                        'created_on' => time() 
                    ); 
                    $insert_id = App::save_data( 'push_alert', $post_data ); 
                     
                }
                
            }else{
                
                $post_data = array(
                        'user_id' => $user_id,
                        'subs_id' => $subs_id,
                        'created_on' => time() 
                    ); 
                $insert_id = App::save_data( 'push_alert', $post_data );
            }
            
        }
        
    }/*  pushalert() ends  */
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
