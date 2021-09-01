<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Customer extends MX_Controller
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
        $this->load->model('customer_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    }
    /**
     *Functionality:  Loads customer.php View
    */
    public function index()
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
       
    }/* end function index */
   
    /**
     *Functionality:  Loads customer view Dashboard.php
    */
    public function dashboard($id) {
        $leads_id =  $this->uri->segment(3);
        $cust_id =  $this->uri->segment(3);
        $result1 = $this->db->select('*')->from('leads')->get();
        $data['leads_ass'] = $result1->result('array');
        $data['customer'] = $this->customer_model->findWhere('customer',array('id' => $id),$multi_record = FALSE,array('*'));
        $data['customer_address'] = (array) App::get_by_where('customer_address', array('customer_id'=>$cust_id));

        $ordrSql = "SELECT pkr.*,pkr.id as pkid, CONCAT(pkr.first_name, ' ', pkr.last_name) AS fname, cust.full_name, cust.phone, vdr.name as vdrcode,up.name as upname ,
            ( SELECT SUM( payment_amount ) FROM customer_payment WHERE order_id = pkr.id ) AS payment_amount
             FROM pk_order pkr 
                LEFT JOIN  customer cust on pkr.customer_id = cust.id LEFT JOIN vendor vdr on vdr.id = pkr.vendor LEFT JOIN user_profiles up on pkr.sales_primary = up.user_id WHERE ( status IS NULL OR status <> 'Quote' ) AND pkr.customer_id = '$id'";
        $ordrCal = $this->customer_model->custom_query($ordrSql,FALSE,'array');
        $ordrRes = array();
        if ( !empty( $ordrCal ) ) {
            $ordrRes = $ordrCal;
        }
        $data['customer_orders'] = $ordrRes;

        $quoteSql = "SELECT pkr.*,pkr.id as pkid, CONCAT(pkr.first_name, ' ', pkr.last_name) AS fname, cust.full_name, cust.phone, vdr.name as vdrcode,up.name as upname ,
            ( SELECT SUM( payment_amount ) FROM customer_payment WHERE order_id = pkr.id ) AS payment_amount
             FROM pk_order pkr 
                LEFT JOIN  customer cust on pkr.customer_id = cust.id LEFT JOIN vendor vdr on vdr.id = pkr.vendor LEFT JOIN user_profiles up on pkr.sales_primary = up.user_id WHERE ( status IS NULL OR status = 'Quote' ) AND pkr.customer_id = '$id'";
        $quoteCal = $this->customer_model->custom_query($quoteSql,FALSE,'array');
        $quoteRes = array();
        if ( !empty( $quoteCal ) ) {
           $quoteRes = $quoteCal;
        }
        $data['customer_quotes'] = $quoteRes;

        $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ')
             ->from('activity_record')
             ->where(array(
                          'activity_id' => $cust_id,
                          'activity_name' => 'customer_activity',
                          'activity_record.user_id' => $this->tank_auth->get_user_id() )
                          );
        $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
        $this->db->order_by('activity_recordID', 'DESC');
        $query = $this->db->get();
        $data['activities'] = $query->result('array');
        // $this->db->from('pk_activities');
        // $this->db->where(array('field_id' => $leads_id, 'module' => 'customer'));
        // $this->db->order_by('id', 'DESC');
        // $query = $this->db->get();
        // $data['activities'] = $query->result('object');
        
        $this->template->title('Dashboard');
        $this->template
        ->set_layout('inner')->build('dashboard',$data);
    }/* end function dashboard */

    /**
     * function  Add Customer
     */
    public function add() {   
        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');
        }else{
            $id = $this->uri->segment(4);
            $data['leads_info'] = $this->customer_model->findWhere('leads',array('id' => $id),FALSE);
            if( $this->input->post() ){
                $vendor_id = $this->session->userdata('vendor_id');
                $post_data = array(
                                'leads_id'      => $this->input->post('leads_id'),
                                'full_name'     => $this->input->post('full_name'),
                                'gender'        => $this->input->post('gender'),
                                'phone'         => $this->input->post('phone'),
                                'email'         => $this->input->post('email'),
                                'vendor_id'     => $vendor_id,
                            );
                if( !$customer_id = $this->customer_model->add('customer', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Customer data didn\'t save, Try again!');
                }else{
                    $customer_laed = array(
                                        'customer_id'   => $customer_id,
                                        'created_by'    => $this->tank_auth->get_user_id(),
                                        'leads_id'      => $post_data["leads_id"]
                                    );
                    $logData = array(
                                    'user_id' => $this->tank_auth->get_user_id(),
                                    'module'  => 'customer',
                                    'field_id' => $customer_id,
                                    'activity' => 'Created New Customer: '. $post_data['full_name']                        
                                );
                    $this->customer_model->add('pk_customer_leads', $customer_laed );
                    
                    $db_activity_id = log_activity('customer_activity',$customer_id, $get_lead_status = "", $new_lead_status="",'Add Customer: '.$post_data['full_name'],'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $post_data, $post_data2 );
                    log_message('error',serialize( $post_adding ));
                    //$activitie =  (array) App::LogActivity( $logData ); 
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Customer Has Been Add successfully');
                }
                redirect('/customer/dashboard/'.$customer_id);
            }
        }  
            
        $this->load->view('modal/customer_add', $data);
    }/* end function add */

    /**
     *Functionality:  Loads load_script.php
     */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* end function load_script */

    /**
     *Functionality:  Loads load_css.php
     */
    public function load_css(){
        $data = array();
        $this->load->view('load_css', $data);
    }/* end function load_css */

    /**
     *Functionality:  Loads check email
     */
    public function check_email(){
        if( $email = $_POST['email']) {
            $count = $this->crm_model->check_data_exist($table = 'leads', $key = 'email', $val = $email);
            if( $count > 0 ){
                echo "true";
            }
        }
    }/* end function check_email */

    /**
     *Functionality:  Delete Customer
     */
    public function delete_Customer(){
        if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            $return="FALSE";
            $query = $this->customer_model->select_where('full_name','customer',array('id' =>  $ids ));
            if( App::delete('customer', array('id' => $ids))){
                if( App::delete('pk_customer_leads', array('customer_id' => $ids))){
                   
                    $db_activity_id = log_activity('customer_activity',$ids,
                                                               $get_lead_status = "",
                                                               $new_lead_status =  "",
                                                               'Delete a Customer: '.$query->full_name,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $activaty, $post_data2 );
                    log_message('error',serialize( $post_adding ));
                     $return="TRUE";
                    }else{
                         $return="FALSE";
                      }
 
            }else{
                $return="FALSE";
            }
            echo  $return;
        }
    }

    /**  customer_id
     *Functionality:  Loads load_script.php
     */
    public function deleteFile(){
        $return = "FALSE";
        if( isset($_POST['ids']) ) {
          $ids = $_POST['ids'];
          $cust_id = $_POST['customer_id'];
            $fileData = (array) App::get_row_by_where('files', array('file_id' => $ids,'field_id' => $cust_id) );
            $file = $fileData['path'].$fileData['file_name'];
            if(unlink($file)){
                if( App::delete('files', array('file_id' => $ids,'field_id' => $cust_id)) ){
                    $query = $this->customer_model->select_where('full_name','customer',array('id' =>  $cust_id ));
                    $db_activity_id = log_activity('customer_activity',$ids,
                                                               $get_lead_status = "",
                                                               $new_lead_status =  "",
                                                               'Delete a file customer'.$query->full_name,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $activaty, $post_data2 );
                    log_message('error',serialize( $post_adding ));              
                    $return= "TRUE";
                }else{
                    $return= "FALSE";
                }
                   $return= "TRUE";

            }else{

                 $return= "FALSE";

            }
        }
        echo $return;
    }/* end function delete file */

    /**
     *Functionality:  view profile
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
    }/* end function view_profile */
    
    /**
     *Functionality:  recive sms
     */
    public function recive_sms() {
        App::save_data('log_data',array('log_type'=>'sms_receive','log_data'=> json_encode($_POST) ) );
        if(isset($_POST['to'] ) ){
            $to_sms = $_POST['to'];
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
    }/* end function recive_sms */
    
    /**
    *Functionality: 
    */
    public function sendSms() {
       if ( $_POST ) {
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
    }/* end function send_sms */
    
    /**
    *Functionality: Live Chat
    */
    public function live_chat(){
         $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('crm/modal/live_chat', $data);
    }

    /**
    *Functionality: Retrieve Chats view chat
    */
    public function chats($id) {
        $id = $this->uri->segment(3);
        $lead_id= App::get_by_where('customer', array('id' => $id));
        $Lid = $lead_id[0]->leads_id;
        $data['live_chats'] = (array) App::get_by_where('live_chat', array('lead_id' => $Lid));
        $this->template->title('Chat');
        $this->template
              ->set_layout('inner')
              ->build('cust_leads/livechat', $data);
      
      }/* end function chat */

    /**
    *Functionality: Edit Customer data
    */
    public function edit($id){
        $data = array();
            if ( $this->input->post('id') ) {    
                $data['errors'] = array();
                $id = $this->input->post('id');
                $match = array ('id' => $this->input->post('id') );
                $data = array(
                            'full_name'    => $this->input->post('full_name'),
                            'email'        => $this->input->post('email'),
                            'gender'       => $this->input->post('gender'),
                            'phone'        => $this->input->post('phone'),
                            'comment'      => $this->input->post('comment')
                        );
                $db_activity_id = log_activity('customer_activity',$id, $get_lead_status = "", $new_lead_status="",'Edit Customer: '.$data['full_name'],'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $data, $post_data2 );
                log_message('error',serialize( $post_adding ));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Customer has been updated successfully');
                App::update('customer',$match,$data);
                redirect('/customer/dashboard/'.$id);
            }else{
                $data['customer'] = (array) App::get_row_by_where('customer', array('id' => $id) );
                $this->template->title('Edit Customer');
                $this->template->set_layout('inner')->build('edit_customer',$data);
            }
    }/* end function edit */

    /**
    *Functionality: files listing
    */
    public function files(){
        $id = $this->uri->segment(3);
        $data = array();
        $data['file_data'] = $this->customer_model->findWhere('files', array('field_id' => $id ), array('*') );
        $Leaddata = $this->customer_model->findWhere('pk_customer_leads', array('customer_id' => $id ), array('leads_id') );
        if (!empty( $Leaddata ) ) {
            foreach ($Leaddata  as $value) {
                $data['leads_data'][] = $this->customer_model->findWhere('files', array('field_id' => $value['leads_id'],'module_name' => 'leads'), array('*'));
            }
            $data['leads_data'] = array_filter($data['leads_data']);
        
        }
        $this->template->title('File');
        $this->template
              ->set_layout('inner')
              ->build('cust_leads/file', $data);
    }/* end function file */

    /**
    *Functionality:  add_file customer dashboard
    */
    function add_file(){
        $id =  $this->uri->segment(3);
        $data = array();
         $config = array(
                      'upload_path' => "assets/leadsfiles",
                      'allowed_types' => "*"
                    );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image_upload')) {
            $error = array('error' => $this->upload->display_errors());
        }else{
            if(!empty($this->input->post() ) ) {
                $query = $this->customer_model->select_where('full_name','customer',array('id' => $this->input->post('id') ));
                $data = array( 
                            'field_id'     => $this->input->post('id'),
                            'module_name'  => 'customer', 
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
                }else{
                    $db_activity_id = log_activity('customer_activity',$id, $get_lead_status = "", $new_lead_status="",'Add File: '.$query->full_name,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $data, $post_data2 );
                    log_message('error',serialize( $post_adding ));
                    //App::LogActivity($activaty);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File Has been add successfully');
                }
                redirect('/customer/files/'.$id);
          }
      }
    $this->load->view('modal/add_file');

  }/* end function add_file */

    /**
    *Functionality: Dashboard Notes Tab
    */
    Public function notes($id) {   
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
                                'activity'=> 'Created a Note'
                              );
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Note has been updated successfully');
                //App::LogActivity($activaty);
                $db_activity_id = log_activity('customer_activity',$id, $get_lead_status = "", $new_lead_status="",'Update Notes: '.$query->full_name,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $data, $post_data2 );
                log_message('error',serialize( $post_adding ));
                App::update('customer',$match,$data);
                redirect('/customer/notes/'.$this->input->post('lead_id')); 

        }
        $this->template->title('Leads');
        $this->template
              ->set_layout('inner')
              ->build('cust_leads/notes', $data);

    }/* end function notes */

    /**
    *Functionality: address_ads add address for customer
    */
    public function address_ads()  {   
        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $post_data = array(
                        'customer_id'     => $this->input->post('customer_id'),
                        'addressline_one' => $this->input->post('addressline_one'),
                        'addressline_two' => $this->input->post('addressline_two'),
                        'address_type'    => $this->input->post('address_type'),
                        'city'            => $this->input->post('city'),
                        'state'           => $this->input->post('state'),
                        'zipcode'         => $this->input->post('zipcode'),
                    );

                $catID = $this->input->post('customer_id');
                $Pdata = $this->customer_model->findWhere('customer_address', array('customer_id' => $catID ,' address_type'=>'Shipping' ), array('*') );

                $shipping_option = $this->input->post('shipping_option');
                if( !empty($Pdata) ){
                    $post_data['shipping_option'] = "yes";
                    if( isset($shipping_option) ){
                        App::delete('customer_address', array('customer_id' => $catID));
                    }
                }
                if( isset($shipping_option) ){
                        $post_data['shipping_option'] = $shipping_option;
                        $shipping_data = array(
                            'customer_id'     => $this->input->post('customer_id'),
                            'addressline_one' => $this->input->post('s_addressline_one'),
                            'addressline_two' => $this->input->post('s_addressline_two'),
                            'address_type'    => 'Shipping',
                            'city'            => $this->input->post('s_city'),
                            'state'           => $this->input->post('s_state'),
                            'zipcode'         => $this->input->post('s_zipcode'),
                            'shipping_option' => $shipping_option,
                        );
                        $this->customer_model->add('customer_address', $shipping_data );
                    }else{
                         $shipping_data = array(
                            'customer_id'     => $this->input->post('customer_id'),
                            'addressline_one' => $this->input->post('addressline_one'),
                            'addressline_two' => $this->input->post('addressline_two'),
                            'address_type'    => 'Shipping',
                            'city'            => $this->input->post('city'),
                            'state'           => $this->input->post('state'),
                            'zipcode'         => $this->input->post('zipcode'),
                        );
                        $this->customer_model->add('customer_address', $shipping_data );
                    }

               
                $post_data['shipping_option'] = "yes";
               

                $data = array(
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'customer',
                            'field_id' => $post_data["customer_id"],
                            'activity' => 'Created New address: '. $post_data['addressline_one']                        
                        );
                if( !$customer_id = $this->customer_model->add('customer_address', $post_data ) ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Address data didn\'t save, Try again!');
                }else{
                   // $activitie =  (array) App::LogActivity( $data ); 
                $query = $this->customer_model->select_where('full_name','customer',array('id' => $post_data["customer_id"] ));   
                $db_activity_id = log_activity('customer_activity',$post_data["customer_id"], $get_lead_status = "", $new_lead_status="",'Add  Address: '.$query->full_name,'activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $post_data, $post_data2 );
                log_message('error',serialize( $post_adding ));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Address Has been add successfully');
                }
                redirect('customer/dashboard/'.$this->input->post('customer_id'));
            }

        }  
         $catID= $this->uri->segment(3);
         $Pdata = $this->customer_model->findWhere('customer_address', array('customer_id' => $catID ,' address_type'=>'Shipping' ), array('*') );
         if(!empty($Pdata)){
            $data['shipping_address']= "yes";
            
         }

        $this->load->view('modal/add_address',$data);
    }/* end function address_add */

    /**
    *Functionality:  edit_address customer
    */
    public function edit_address($id)  {
        $data = array();
        if ( $this->input->post('id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('id');
            $match = array ('id' => $this->input->post('id'));
            $data = array(
                    'addressline_one' => $this->input->post('addressline_one'),
                    'addressline_two' => $this->input->post('addressline_two'),
                    'city'            => $this->input->post('city'),
                    'customer_id'     => $this->input->post('customer_id'),
                    'state'           => $this->input->post('state'),
                    'zipcode'         => $this->input->post('zipcode'),
                    'address_type'    => $this->input->post('address_type'),
                    // 'shipping_option' => @$this->input->post('shipping_option'),
                    'customer_id'     => $this->input->post('customer_id'),
            );
            $address_data = array(
                        'user_id' => $this->tank_auth->get_user_id(),
                        'module'  => 'customer',
                        'field_id' => $data["customer_id"],
                        'activity' => 'Edit address: '. $data['addressline_one']                        
            );
            $query = $this->customer_model->select_where('full_name','customer',array('id' => $id ));   
            $db_activity_id = log_activity('customer_activity',$id, $get_lead_status = "", $new_lead_status="",'Edit  Address: '.$query->full_name,'activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize( $post_adding ));
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Addess has been updated successfully'); 
            App::update('customer_address',$match,$data);
            redirect('customer/dashboard/'.$data['customer_id']);
        }else{
            $data['role'] = (array) App::get_row_by_where('customer_address', array('id' => $id) );
            $this->load->view('modal/edit_address', $data);

        }

    }/* end function edit_address */

    /**
    *Functionality: Delete Address
    */
    public function delete_address(){
        if ( isset($_POST['ids']) ) {
           
            $ids = $_POST['ids'];
            $cids = $_POST['cids'];
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'customer_address');
            $query = $this->customer_model->select_where('full_name','customer',array('id' => $cids ));
            if ($data == true) {
            $db_activity_id = log_activity('customer_activity',$cids,
                                                       $get_lead_status = "",
                                                       $new_lead_status =  "",
                                                       'Delete a address :'.$query->full_name,'activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize( $post_adding ));    
            echo "TRUE";
            }else{
                echo "FALSE";
            }
        }
    }/* end function delete_address */
    
    /**
    *Functionality:  assign
    */
    public function assign(){
        $this->db->select("*");
        $this->db->from('leads');
        $this->db->where("id NOT IN (SELECT customer.leads_id
                       FROM customer)");
        $data['leads_name'] = $this->db->get()->result();
        if($this->input->post('custm_id') != '' && $this->input->post('lead_id') !='' ) {
            $postdata = array(
                            'customer_id' => $this->input->post('custm_id'),
                            'leads_id'    => $this->input->post('lead_id'),
                            'created_by'  => $this->tank_auth->get_user_id()
                    );

            $query = $this->customer_model->select_where('first_name','leads',array('id' => $postdata['leads_id'] ));
            $data = array(
                        'user_id' => $this->tank_auth->get_user_id(),
                        'module'  => 'customer',
                        'field_id' => $postdata["leads_id"],
                        'activity' => 'Created assign lead: '. $query->first_name                        
                );
            $selectRow = (array) App::get_row_by_where('pk_customer_leads',array( 'leads_id' => $postdata["leads_id"]  ));
            if ( $selectRow == false  ) {
                if( !$customer_assign = $this->customer_model->add('pk_customer_leads', $postdata ) ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Customer data didn\'t save, Try again!');
                    redirect('/customer');
                }else{
                    $db_activity_id = log_activity('customer_activity',$postdata['customer_id'], $get_lead_status = "", $new_lead_status="",'Assign Lead  : '.$query->first_name,'activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $data, $post_data2 );
                    log_message('error',serialize( $post_adding ));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Assign lead to customer successfully');
                    redirect('/customer/customer_lead/'.$postdata['customer_id']);
                } 
            }else{
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Leads already Assign\'exits, Add another ');
                    redirect('/customer');
                }
        }
        $this->load->view('modal/assign',$data);

  }
    public function assignleads(){
        if ( isset($_POST['assignlead']) ) {
            $this->db->select("*");
            $this->db->from('leads');
            $this->db->where("id NOT IN (SELECT pk_customer_leads.leads_id
                                            FROM pk_customer_leads)");
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
    }
    
    
    public function customer_lead() {
        $custid =  $this->uri->segment(3);
        $this->db->select("*");
        $this->db->from('leads');
        $this->db->where("id  IN (SELECT leads_id
                       FROM pk_customer_leads WHERE customer_id = '$custid' )");
        $data['leads'] = $this->db->get()->result();
        $this->template->title('Leads');
        $this->template
            ->set_layout('inner')
                ->build('cust_leads/customer_lead', $data);
    }
    
    
    /* start Product  */
    
    function order($id) {
        $data = array();
        $id = $this->uri->segment(3);          
        $customer_row = (array) App::get_row_by_where('customer', array( 'id' => $id ) );
        
        $first_name = strtok($customer_row['full_name'],' ');
        $last_name = trim( strstr($customer_row['full_name'],' ') ); 
        $post_data = array(
                'first_name'                 => $first_name,
                'last_name'                  => $last_name,
                'status'                     => "Quote",
                'vendor'                     => '1',
                'customer_id'                => $id,
                'user_id'                    => $this->session->userdata('user_id'),
            );
            
        $insert_sql =  $this->db->insert('pk_order',$post_data );
        $insert_id = $this->db->insert_id();
        redirect( 'orders/TsgOrders/edit/'.$insert_id );     
    }
    

    function get_product()
    {
        $pData = array();
        $vendor_id = $_POST['vendor_id'];
        $style_id = $_POST['style_id'];
        $cat_id = $_POST['cat_id'];
        $where = array(
            '1' => 1
        );
        if ( !empty($vendor_id) ) {
            $where['vendor_id'] = $vendor_id;
        }
        if ( !empty($style_id) ) {
            $where['style_id'] = $style_id;
        }
        if ( !empty($cat_id) ) {
            $where['category'] = $cat_id;
        }
        if ( !empty($vendor_id) || !empty($style_id) || !empty($cat_id) ){
            $pData = (array) App::get_by_where('pk_product', $where );
        }
        
        $json = json_encode($pData);
        echo $json;
    }
    
    function find_product()
    {
        if( isset( $_POST['provalue'] ) ){
            //$sql = "SELECT pkpro.*,pkpro.id as pkid,s.style_code FROM pk_product pkpro JOIN style s on pkpro.style_id = s.id WHERE Item_Name LIKE '".$_POST['provalue']."%'";
            $ids = '';
            foreach ($_POST['provalue'] as $id) {
                $ids .= "'".$id."' ,"; 
            }
            $ids = rtrim($ids,',');

            $sql = "SELECT pkpro.*,pkpro.id as pkid,s.style_code 
                    FROM pk_product pkpro 
                    JOIN style s on pkpro.style_id = s.id 
                    WHERE pkpro.id IN ( $ids ) ";

            $data = $this->customer_model->custom_query( $sql, false, 'array' );
            if( !empty( $data ) )
            {
                foreach ( $data as $key => $value ) {
                     $data[] = $value;
                }
                echo json_encode($data);
            }
        }
    }

    function add_product()
    {
        if ( isset( $_POST['productId'] ) ) {
            $productId = $_POST['productId'];

            $sql = "SELECT pkpro.*,pkpro.id as pkpro_id,sy.*,sy.id as sid FROM pk_product pkpro LEFT JOIN style sy on pkpro.style_id = sy.id WHERE pkpro.id = '$productId'";
            
            $data = $this->customer_model->custom_query( $sql, false, 'array' );

            if( !empty( $data ) )
            {
                echo json_encode($data);
            }
        }
    }
    
    function import_view(){
        
        $this->load->view('modal/import');
    }

    function Import($id)
    {
      $data = array();
      $id = $this->uri->segment(3);
          $config = array(
                  'upload_path' => "assets/productOrderfile",
                  'allowed_types' => "xlsx|xls|csv"
                  );
          $this->load->library('upload', $config);
          
          if(!$this->upload->do_upload('file_upload')){
                  $error['error'] = array('error' => $this->upload->display_errors());
          } else {
            $uploaddata = array('upload' => $this->upload->data() );
            $exttrim = ltrim($uploaddata['upload']['file_ext'],".");
                switch ( $exttrim ) {
                  case 'xlsx':
                    $reader = ReaderFactory::create(Type::XLSX);                
                    break;
                  case 'xls':
                    $reader = ReaderFactory::create(Type::XLS);                
                    break;
                  case 'csv':
                    $reader = ReaderFactory::create(Type::CSV);                
                    break;
                }
                $reader->open($uploaddata['upload']['full_path']);
                $count = 1;
                foreach ($reader->getSheetIterator() as $sheet) {             
                    foreach ($sheet->getRowIterator() as $row) {
                        
                        pr( $row );
                        /*if ($count > 1) {
                            //$query  = $this->order_model->custom('product_order',array('Item_code' => $row[1],'order_id' => ));
                            $mySql = "SELECT * FROM product_order WHERE Item_code = '$row[1]' AND order_id = '$id'";
                            $query = $this->customer_model->custom_query( $mySql, TRUE,'array');
                            if( $query == False  ){
                                $pro_Id =  $this->customer_model->findWhere( 'pk_product',array( 'Item_Code' => $row[1] ), False, array('id',
                                                'Cabinet_price') );
                                if( !empty( $pro_Id['id'] ) ) { $pro_value = $pro_Id['id']; } else { $pro_value = ''; }
                                if( !empty( $pro_Id['Cabinet_price'] ) ) { $pro_price = $pro_Id['Cabinet_price']; 
                                } else { $pro_price = $row[4] ; }

                                $sql = "INSERT INTO product_order ( order_id, product_id,Item_code, style_id,description, qty, price) VALUES ( '". $id ."', '". $pro_value ."', '". $row[1] ."', '". $row[2] ."', '". $row[3] ."', '". $row[0] ."',
                                         '". $pro_price ."'  )";
                                $query = $this->db->query( $sql );
                            }

                        }*/
                        //$count++;
                    }
                }
                redirect("/customer/product/".$id);
                 $reader->close();
          }
    }
    
    /* end product */
    
    
    public function getCustomer(){
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                        0 => 'id',
                        1 => 'full_name',   
                        2 => 'email',    
                        3 => 'phone'
                      );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT *";
        $sql.=" FROM customer WHERE vendor_id = $vendor_id";
        $totalData = $this->customer_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;
        if( !empty($requestData['search']['value']) ) {
            $sql.=" AND ( customer.id LIKE '".$requestData['search']['value']."%' ";    
            $sql.=" OR customer.full_name LIKE '%".$requestData['search']['value']."%' )";
        }
        $totalFiltered = $this->customer_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $total_record = $this->customer_model->custom_query($sql,false,'array'); 
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) )  {
            foreach ($total_record as $row) {
                $html  = '';
                $html .= '<a href="'.base_url().'customer/assign/'.$row['id'].'" title="Assign Leads" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fa fa-user" aria-hidden="true"></i></a>';
                $html .= '<a href="'.base_url().'customer/edit/'.$row['id'].'" title="Edit" class="action-icon create-customer" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>';
                $html .= '<a href="'.base_url().'customer/order/'.$row['id'].'" title="Add Order" class="action-icon create-customer" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"><i class="fa fa-plus-square" aria-hidden="true" ></i></i></a>';
                $html .= '<a href="javascript:void(0);" id="deleteCustomer" class="action-icon" ids="'.$row['id'].'" title="Delete" data-toggle="" data-placement="top" title="Delete Customer"> <i class="mdi mdi-delete"></i></a>';
                
                /*action button conditions*/                        
                $data[] = array(
                      $row["id"],  
                      '<a href="'.base_url().'customer/dashboard/'.$row['id'].'" >'.$row["full_name"].'</a>', 
                      $row['email'],
                      $row['phone'],
                      $html
                  );
              }
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );

      echo json_encode($json_data);  // send data as json format
         
    }/* end function get_customer */



}

/* End of file Customer.php */