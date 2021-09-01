<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class Customer2 extends MX_Controller
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
        $this->load->model('customer_model');
        $this->load->model('user_model');
       
    }

    

    function index()
    {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }

        $data = array();
        $result = $this->db->select('*')->from('customer')->get();
        $data['customer'] = $result->result('array'); 

        $this->load->view('index', $data);
        $this->template->title('Customer');
        $this->template
                ->set_layout('inner')
                ->build('customer', $data);
        //print_r( $data ); 
    }
   

   function dashboard($id)
   {
         $leads_id =  $this->uri->segment(3);
       
        echo $id =  $this->uri->segment(3);
        die('hello');
        $result1 = $this->db->select('*')->from('leads')->get();
        $data['leads_ass'] = $result1->result('array');
        
        $data['customer'] = $this->customer_model->findWhere('customer',array('id' => $id),$multi_record = FALSE,array('*'));

         $data['customer_address'] = $this->customer_model->findWhere('customer_address',array('id' => $id),$multi_record = TRUE,array('*'));

        // $result1 = $this->db->select('*')->from('customer_address')->get();
        // $data['customer_address'] = $result1->result('array');

    
       

        /*$result = $this->db->select('*')->from('customer')->get_by_where(array('id' => $id));*/

      //  $this->load->view('dashboard', $data);

        // $this->db->from('pk_activities');
        // $this->db->where(array('field_id' => $leads_id, 'module' => 'customer'));
        
        // $query = $this->db->get();
        // $data['activities'] = $query->result('object');

         $this->template->title('View Profile');
        $this->template
        ->set_layout('inner')->build('dashboard',$data);


   }

    /**
     * Change user password
     * @author Parveen
     * @return void
     */
    function add()
    {   
        //echo $leads_id =  $this->uri->segment(4);

        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');

        } else {
            if( $this->input->post() ){

                $post_data = array(
                    'leads_id'      => $this->input->post('leads_id'),
                    'full_name'     => $this->input->post('full_name'),
                    'gender'        => $this->input->post('gender'),
                    'address'       => $this->input->post('address'),
                    'city'          => $this->input->post('city'),
                    'state'         => $this->input->post('state'),
                    'zipcode'       => $this->input->post('zipcode'),
                    'phone'         => $this->input->post('phone'),
                    'fax'           => $this->input->post('fax'),
                    'email'         => $this->input->post('email'),
                    'is_customer'   => $this->input->post('is_customer'),
                    'unique_check'  => $this->input->post('unique_check'),
                    'comment'       => $this->input->post('comment')
                            );
                    $data = array(
                                'user_id' => $this->tank_auth->get_user_id(),
                                'module'  => 'lead',
                                'field_id' => $post_data["leads_id"],
                                'activity' => 'Created New Customer: '. $post_data['full_name']                        
                    );


                if( !$role_id = $this->customer_model->add('customer', $post_data ) )
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Customer data didn\'t save, Try again!');
                }else{
                    $activitie =  (array) App::LogActivity( $data );     
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Customer added successfully');
                }
                redirect('/crm/leads');
            }

            }  
            
            $this->load->view('modal/customer_add', $data);
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
    
    function delete_role(){
        if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'customer');
            if($data == true){
            echo "TRUE";
            } else {
                echo "FALSE";
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
                'sms_text'  => $from_sms,
                'sms_to'    => $to_sms,
                'sms_type'  => 'in',
                'sms_time'  => $datetime,
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
                    'admin_id'  => $adminID,
                    'sms_text'  => $sms,
                    'sms_to'    => $nmbr,
                    'sms_type'  => 'out',
                    'sms_time'  => date('Y:m:d H:i:s'),
                );
                App::save_data( 'leads_sms', $leadData );
                App::create_activity('lead_activity',$lid,'SMS Sent',json_encode($leadData));
                
            } catch (Exception $e) {
                echo 'Exception when calling SMSApi->smsSendPost: ', $e->getMessage(), PHP_EOL;
            }
        }
    }
    
    
    // function get_live_chat(){
    //     $data = file_get_contents('php://input');
    //     App::save_data('log_data',array('log_type'=>'livechat','log_data'=>$data) );
    //     $ddata = json_decode($data,true);
    
    //     $msgs = json_encode($ddata['chat']['messages']);
    //     $rt = ''; $rc = 1;
    //     foreach($ddata['chat']['messages'] as $tkey => $tVal){
    //         if($rc <= '2'){
    //             $rt .= $tVal['text'].',';
    //         }
    //     $rc++;}

    //   $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
    //   $lemail = $ddata['visitor']['email'];
    //   $lname = $ddata['visitor']['name'];
    //   $lsource_url = $ddata['visitor']['page_current'];
    //   $result = App::get_row_by_where($table = 'leads', array('email' => $lemail), $order_by = array());
       
    //     if( $result ){ $lead_id = $result->id;
    //     }else{
    //          $post_data = array(
    //             'first_name'    => $lname,
    //             'last_name'     => '',
    //             'email'         => $lemail,
    //             'source'        => 3,
    //             'source_url'    => $lsource_url,
    //             'created'       => date('Y-m-d H:i:s'),
    //             'lead_code'     => time(),
    //             'ip'            => $this->input->ip_address(),
    //         );
            
    //         if( !$lead_id = App::save_data( 'leads', $post_data ) ) { die('DB Error'); }
    //         App::create_activity('lead_activity',$lead_id,'lead Inserted',json_encode($post_data));
    //     }
    
    //     $date_time = date('Y-m-d H:i:s',$ddata['chat']['started_timestamp']);
    //     foreach($ddata['chat']['agents'] as $akey => $aVal){
    //         $agents_data[] = array('name' => $aVal['name'], 'email' => $aVal['login']);
    //     }
    //     $clData = array(
    //         'lead_id'      => $lead_id,
    //         'agent_data'   => json_encode($agents_data),
    //         'ready_chat'   => $rt,
    //         'chat_mesage'  => $msgs,
    //         'meta_data'    => $data,
    //         'chart_time'   => $date_time
    //     );
   
    //     App::save_data('live_chat',$clData );
    //     App::create_activity('lead_activity',$lead_id,'Live Chat End',json_encode($clData));
    // }
    
    /* live_chat**/
    function live_chat(){
         $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('crm/modal/live_chat', $data);
    }

    /* customer edit**/
    function edit($id){
        $data = array();
            if ( $this->input->post('custm_id') ) {    
                   $data['errors'] = array();
                  
                    $id = $this->input->post('custm_id');

                    $match = array (
                        'id' => $this->input->post('custm_id'),
                    );
                    $data = array(
                            'full_name'     => $this->input->post('full_name'),
                            'gender'        => $this->input->post('gender'),
                            'address'       => $this->input->post('address'),
                            'city'          => $this->input->post('city'),
                            'state'         => $this->input->post('state'),
                            'zipcode'       => $this->input->post('zipcode'),
                            'phone'         => $this->input->post('phone'),
                            'fax'           => $this->input->post('fax'),
                            'is_customer'   => $this->input->post('is_customer'),
                            'unique_check'  => $this->input->post('unique_check'),
                            'comment'       => $this->input->post('comment')
                            );
                    
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Role has been updated'); 
                    App::update('customer',$match,$data);
                    redirect('/customer');

            }
             else{
               
                     $data['role'] = (array) App::get_row_by_where('customer', array('id'=>$id) );
                     //$this->load->view('modal/edit_customer', $data);
                      $this->template->title('Edit Customer');
                      $this->template
                       ->set_layout('inner')->build('edit_customer',$data);


                 }

     }


     function files(){
      $id = $this->uri->segment(3);
          $data = array();
          $data['file_data'] = $this->customer_model->findWhere('files', array('field_id' => $id ), array('*') );
          
          $this->template->title('File');
              $this->template
                      ->set_layout('inner')
                      ->build('cust_leads/file', $data);

  }

   function add_file(){
      $id =  $this->uri->segment(3);
   $data = array();
      $config = array(
          'upload_path' => "assets/leadsfiles",
          'allowed_types' => "gif|jpg|png|jpeg|pdf"
          );
      $this->load->library('upload', $config);

      if(!$this->upload->do_upload('image_upload')){
        $error = array('error' => $this->upload->display_errors());
      } else {

          if(!empty($this->input->post() ) ){
          $query = $this->customer_model->select_where('full_name','customer',array('id' => $this->input->post('id') ));
          $data = array( 

                    'field_id'     => $this->input->post('id'),
                    'module_name'  => $query->full_name, 
                    'file_name'    => $this->upload->data('file_name'),
                    'title'        => $this->input->post('title'),
                    'path'         => $this->upload->data('file_path'),
                    'ext'          => $this->upload->data('file_ext'),
                    'size'         => $this->upload->data('file_size'),
                    'is_image'     => $this->upload->data('is_image'),
                    'description'  => $this->input->post('description'),
                    'created_by'   => $this->tank_auth->get_user_id()

                  );
            $activaty = array( 
                            'user_id' => $data['created_by'],
                            'module'  => 'customer',
                            'field_id' => $data['field_id'],
                            'activity'=> 'Created a file : '.$data['module_name']
                          );
                if( !$lead_id = App::save_data( 'files', $data )  ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
                } else {
                    App::LogActivity($activaty);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File added successfully');
                }
                 redirect('/customer/files/'.$id);
          }
      }
    $this->load->view('modal/add_file');
  }


   function notes($id)
  {   
          $data = array();
           $data['leads'] = (array) App::get_row_by_where('customer', array('id'=>$id) );


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
                    $data = array(
                            'comment'  => $this->input->post('comment'),
                           
                      );
                    $query = $this->customer_model->select_where('full_name','customer',array('id' => $this->input->post('lead_id') ));
                     $activaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'customer',
                            'field_id' => $match['id'],
                            'activity'=> 'Created a Note : '.$query->full_name
                          );
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Note has been updated');
                    App::LogActivity($activaty);
                    App::update('customer',$match,$data);
                    // echo $this->db->last_query(); die;
                    redirect('/customer/notes/'.$this->input->post('lead_id')); 

            }

            $this->template->title('Leads');
              $this->template
                      ->set_layout('inner')
                      ->build('cust_leads/notes', $data);



  }
  function customer_lead(){
      
        $data = array();
        $this->template->title('Leads');
            $this->template
                ->set_layout('inner')
                    ->build('cust_leads/customer_lead', $data);
  }



  function address_ads()
    {   
       // $customer_id =  $this->uri->segment(3);

        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');

        } else {
            if( $this->input->post() ){

                $post_data = array(
                    'customer_id'      => $this->input->post('customer_id'),
                    'addressline_one'   => $this->input->post('addressline_one'),
                    'address_type'   => $this->input->post('address_type'),
                    'city'          => $this->input->post('city'),
                    'state'         => $this->input->post('state'),
                    'zipcode'       => $this->input->post('zipcode'),
                    'fax'           => $this->input->post('fax'),
                   'country'       => $this->input->post('country')
                            );
                    $data = array(
                                'user_id' => $this->tank_auth->get_user_id(),
                                'module'  => 'customer Address',
                                'field_id' => $post_data["customer_id"],
                                'activity' => 'Created New address: '. $post_data['addressline_one']                        
                    );


                if( !$role_id = $this->customer_model->add('customer_address', $post_data ) )
                {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Customer data didn\'t save, Try again!');
                }else{
                    $activitie =  (array) App::LogActivity( $data );     
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Address added successfully');
                }
                redirect('/customer/customer2/dashboard/'.$this->input->post('lead_id'));
            }

            }  
            
            $this->load->view('modal/add_address');
    }

        function edit_address($id){
        $data = array();
            if ( $this->input->post('id') ) {    
                   $data['errors'] = array();
                  
                    $id = $this->input->post('id');

                    $match = array (
                        'id' => $this->input->post('id'),
                    );
                    $data = array(
                            'addressline_one'       => $this->input->post('addressline_one'),
                            'city'          => $this->input->post('city'),
                            'customer_id'    => $this->input->post('customer_id'),
                            'state'         => $this->input->post('state'),
                            'zipcode'       => $this->input->post('zipcode'),
                            'address_type'  => $this->input->post('address_type'),
                            'fax'           => $this->input->post('fax'),
                            'country'       => $this->input->post('country')
                            );
                    
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Role has been updated'); 
                    App::update('customer_address',$match,$data);
                    redirect('/customer');

            }
             else{
               
                     $data['role'] = (array) App::get_row_by_where('customer_address', array('id'=>$id) );
                     //$this->load->view('modal/edit_customer', $data);
                      $this->template->title('Edit Customer');
                      $this->template
                       ->set_layout('inner')->build('edit_customer',$data);


                 }

     }



}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */