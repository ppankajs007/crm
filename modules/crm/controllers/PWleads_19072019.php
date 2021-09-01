<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class PWleads extends MX_Controller 
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
        if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login');
		}
	}

	
	function dashboard($id)
	{ 
	     $data = array();
         $leads = App::get_row_by_where('leads', array('id'=>$id) );
            if(!empty( $leads ) ){
                $data['leads'][] = $leads;
               }
          $data['lsms'] = (array) App::get_by_where('leads_sms', array('lead_id'=>$id) );

          $leads_id =  $id;
    	  $data['lsms'] = (array) App::get_by_where('leads_sms', array('lead_id'=>$leads_id) );
          $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ');
          $this->db->from('activity_record');
          $this->db->where(array('activity_id' => $leads_id, 'activity_name' => 'lead_activity'));
          $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
          $this->db->order_by('activity_recordID', 'DESC');
          $query = $this->db->get();
          $data['activities'] = $query->result('array');
          
           $scstats = App::get_row_by_where('leads', array('id'=>$id , 'qf_status'=>int_lead_Hold_On_Design ) );
               if(!empty($scstats)){
                   
                    $hold_desgin = App::get_row_by_where('hold_on_desgin', array('lead_id'=>$id ) );
                if(!empty( $hold_desgin ) ){
                $data['hold'][] = $hold_desgin;
                  }
               }else{
                   $data['hold'][] = '';
                   
               }
           $Mleads = App::get_row_by_where('leads', array('id'=>$id) );
         
          
            if(!empty( $Mleads ) ){
                $data['Mleads'][] = $Mleads;
                
               }
         
          $Pdata = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
        //   pr($Pdata);
        //   die();
           if(!empty($Pdata)){
                $data['pw_pending']=$Pdata;
              
           }else{
                $data['pw_pending']='';
            }
       $this->template->title(' Leads');
        $this->template
                ->set_layout('inner')
                ->build('paperwork/dashboard', $data);
	}

	function index()
	{ 	
		if (!$this->tank_auth->is_logged_in()) { // logged in
			redirect('auth/login');
		}

        $data = array();
        $data['Select_status'] = $this->crm_model->fetch_all('status_lead');
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->template->title(' Leads');
        $this->template
            ->set_layout('inner')
            ->build('paperworkpending', $data);
	}

    function load_script()
    {
        $data = array();
        $this->load->view('paperwork/load_script', $data);
    }
    
    function load_css()
    {
        $data = array();
        $this->load->view('paperwork/load_css', $data);
    }


    function edit($id){
  
  
      if ( $this->input->post('id') ) {
          
           
                   
           
             $name=$this->input->post('name');
                          $firstname = strtok($name, ' ');
                          $lastname = trim(strstr($name, ' '));
          
           $match=array(
             'id' => $this->input->post('id'),
                          );
          
          
          $post_data = array(
                           'first_name'         => $firstname,
                           'last_name'          => $lastname,
                           'pw_mmethod'        => $this->input->post('pw_mmethod'),
                           'lost_sale_detail'          =>$this->input->post('lost_sale_detail'),
                        // 'pw_fmdate'         =>$this->input->post('pw_fmdate'),
                        // 'pw_fmtime'         =>$this->input->post('pw_fmtime'),
                        // 'pw_fmperson'       =>$this->input->post('pw_fmperson'),
                           'assigned_to'       =>$this->input->post('assigned_to'),   
                           'action_lead'       =>$this->input->post('action_lead'),
                           
                           'lead_status'       => $this->input->post('lead_status'),
                           'qf_status'       => $this->input->post('qf_status'),
                          );
                          
                          $activatypaper = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' =>$this->input->post('id'),
                            'activity'=> 'Paperwork Edit : '. $firstname
                          );
                  /*  echo $this->input->post('reminder_date');
                    die($this->input->post('reminder_date'));*/
                 
                   if(!empty($this->input->post('reminder_date')) ){
                        $post_data['reminder_date'] =crm_dateTime( $this->input->post('reminder_date') );
                   }
                   if( $this->input->post('lead_status') == lead_Qualified ){
                         $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                         $post_data['qf_status'] = int_lead_Not_Started;
                    }else if( $this->input->post('lead_status') == lead_Presentation_Lead ){
                         $post_data['qf_dateAdded'] = date('Y-m-d H:i:s');
                         $post_data['qf_status'] = int_lead_Not_Started;
                    }
                    
            /* lead status start */        
                
                   $get_lead_data_s = get_row_data('*','leads',array('id' => $this->input->post('id') ));
                   $get_lead_status_s = get_row_data('status','status_lead',array('id' => $get_lead_data_s->lead_status ));
                   $new_lead_status_s = get_row_data('status','status_lead',array('id' => $post_data['lead_status'] ));
                   if( $get_lead_status_s->status != $new_lead_status_s->status  ){
                       $db_activity_id_s = log_activity('lead_activity',$id,$get_lead_status_s->status,$new_lead_status_s->status,'Update Lead Status From Paper Work','activity_record');
                       $post_data_s = array( 'activity_id' => $db_activity_id_s, 'new_status' => $new_lead_status_s->status );
                       $post_adding_s = array_merge( $post_data, $post_data_s );
                       log_message('error',serialize($post_adding_s));
                   }
            
            /* lead status end */        
                    
                    
                    
                  $get_lead_data = get_row_data('*','leads',array('id' => $id ));
                   if( !empty( $get_lead_data->qf_status )){
                   $get_lead_status = get_row_data('status','lead_int_status',array('id' => $get_lead_data->qf_status ));
                    $get_lead_s = $get_lead_status->status; 
                   } else {
                       $get_lead_s = "";
                   }

                   $new_lead_status = get_row_data('status','lead_int_status',array('id' => $post_data['qf_status'] ));
                   
                   if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
                  
                    if( ($get_lead_s != $new_l_status) || ($get_lead_s == "" && $new_l_status !="") || ($get_lead_s !="" && $new_l_status =="")  ){
                  
                   $db_activity_id = log_activity('lead_activity',$id,$get_lead_s,$new_l_status,'Update Lead Status Profile','activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_l_status );
                   
                  } else {
                   $db_activity_id = log_activity('lead_activity',$id,$get_lead_status = "",$new_lead_status ="",'Update Paper Work Lead Profile','activity_record');
                   $post_data2 = array( 'activity_id' => $db_activity_id );
                  }
                   $post_adding = array_merge( $post_data, $post_data2 );
                   log_message('error',serialize($post_adding));          
            
                App::update('leads',$match,$post_data);
                App::LogActivity($activatypaper);
                $post_data['success'] = array();
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Paperwork Lead has been Update successfully');
                 redirect('/crm/PWleads/dashboard/'.$id);
          
          
        }
        $data = array();
        
        $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
        $data['lead_statuss'] = $this->crm_model->custom_query("SELECT * FROM status_lead WHERE id IN ( ".lead_Contacted_Paperwork_Pending.", ".lead_Qualified.", ".lead_Lost_sale.", ".lead_Measurement_Required." )",false,'array');
         $data['int_lead_status'] = $this->crm_model->custom_query("SELECT * FROM lead_int_status WHERE id IN ( ".int_lead_Need_More_Info_to_Start.",  ".int_lead_New." )",false,'array');
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        $this->template->title('Edit Leads');
        $this->template
                ->set_layout('inner')
                ->build('paperwork/edit', $data);
    }
  
  function getPWleads(){
    ini_set('max_execution_time', 30000000);
    ini_set('memory_limit','2048M');
    $requestData= $_REQUEST;

      $columns = array(
                    0 => 'id',
                    1 => 'fullname',
                    2 => 'pw_mmethod',
                    3 => 'action_lead',
                    4 => 'reminder_date',
                    5 => 'p.name',
                    6 => 'pw_dateadded'
                  );
                  
                   $vendor_id = $this->session->userdata('vendor_id');

        // getting total number records without any search
     $sql = "SELECT l.*, CONCAT(l.first_name,' ', l.last_name) as fullname, p.name as nsowner ";
      $sql.=" FROM leads l left join user_profiles p on l.assigned_to =p.user_id WHERE vendor_id = $vendor_id AND l.lead_status ='".lead_Contacted_Paperwork_Pending."' ";

      $totalData = $this->crm_model->custom_query($sql,true,'array');
      $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
      
      if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

          $sql.=" AND ( l.id LIKE '".$requestData['search']['value']."%' ";    
          $sql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR l.action_lead LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR l.reminder_date LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR l.pw_mmethod LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR l.pw_dateadded LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR p.name LIKE '%".ucfirst($requestData['search']['value'])."%' ";
         
          $sql.=" OR l.last_name LIKE '".$requestData['search']['value']."%' )";
        
      }
      //assigned to filter
      $AssignFilter = $_REQUEST['columns'][1]['search']['value'];
     if ( !empty($AssignFilter)  ) {
        $sql.= " AND l.assigned_to IN (".$AssignFilter.")";
      }
      
      $totalFiltered = $this->crm_model->custom_query($sql,true,'array'); 

      // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
      /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
      $total_record = $this->crm_model->custom_query($sql,false,'array'); 
    
      $data = array();
      if( is_array( $total_record ) && !empty( $total_record ) )
      { 

          foreach($total_record as $row){
              
              //pr( $row );die();
            
             
            //   if( !empty( $row['lead_status'] ) ){
            //     $leadStatus = (array) App::get_row_by_where('status_lead', array('id'=>$row['lead_status']) );
            //   }else {
            //     $leadStatus= 'NA';
            //   } 
              
                
              if( empty( $row['pw_mmethod'] ) ){ $row['pw_mmethod'] = 'NA'; }
             // if( empty( $row['pw_fmreq'] ) ){ $row['pw_fmreq'] = 'NA'; }
             // if( empty( $row['pw_fmdate'] ) ){ $row['pw_fmdate'] = 'NA'; }
             // if( empty( $row['pw_fmtime'] ) ){ $row['pw_fmtime'] = 'NA'; }
              //if( empty( $row['pw_fmperson'] ) ){ $row['pw_fmperson'] = 'NA'; }
              
              if(!empty($row['action_lead'])) { $nextStep=$row['action_lead']; } else{ $nextStep="NA";  }
             
              
              if(!empty($row['reminder_date'])){ 
                $nextstepDate = crm_date($row['reminder_date']);
              } else {  $nextstepDate="NA"; }   
            
              if( empty( $row['nsowner'] ) ){ $row['nsowner'] = 'NA'; }
            //   if( empty( $row['pw_nsowner'] ) ){ $row['pw_nsowner'] = 'NA'; }
            
              if( empty( $row['pw_dateadded'] ) ){ 
                  $pw_dateadded = 'NA'; 
              }else{
                 $pw_dateadded = crm_date($row['pw_dateadded']);
              }
            //   if( empty( $row['pw_datequalified'] ) ){ $row['pw_datequalified'] = 'NA'; }
              
               $html= '';
               $html .=  '<a href="'.base_url().'crm/PWleads/edit/'.$row['id'].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
               $html .=  '<a href="'.base_url().'crm/PWleads/Dashboard/'.$row['id'].'" title="Dashboard" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
               
              
   
                  $data[] = array(
                          $row["id"], 
                          '<a href="'.base_url().'crm/PWleads/dashboard/'.$row['id'].'" >'.$row["fullname"].'</a>',
                          $row["pw_mmethod"], 
                          $nextStep, 
                          $nextstepDate,
                          $row['nsowner'],
                          $pw_dateadded,
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
  }
  
	

  
   function files(){
      $id = $this->uri->segment(4);
          $data = array();
          $data['file_data'] = $this->crm_model->findWhere('files', array('field_id' => $id ), array('*') );
          //print_r( $data );
          $this->template->title('File');
              $this->template
                      ->set_layout('inner')
                      ->build('paperwork/PwLeads/file', $data);

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
                    'module_name'  => 'PWleads', 
                    'file_name'    => $this->upload->data('file_name'),
                    'title'        => $this->input->post('title'),
                    'lead_file_type'  => $this->input->post('lead_file_type'),
                    'path'         => $this->upload->data('file_path'),
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
                            'activity'=> 'Creat a file Paperwork : '.$data['module_name']
                          );
                if( !$lead_id = App::save_data( 'files', $data )  ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
                } else {
                    
                    
          $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add a file from paperwork lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $data, $post_data2 );
           log_message('error',serialize($post_adding));
                    App::LogActivity($activaty);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File added successfully');
                }
                 redirect('crm/PWleads/files/'.$id);
          }
      }
    $this->load->view('paperwork/modal/add_file',$id);
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
                    'activity'=> 'Created a Note PaperWork: Leads '
                  );
                  
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add a note from paperwork lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $data, $post_data2 );
           log_message('error',serialize($post_adding));      
                  
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Note has been updated');
            App::LogActivity($activaty);
            App::update('leads',$match,$data);
            // echo $this->db->last_query(); die;
            redirect('crm/PWleads/notes/'.$this->input->post('lead_id')); 
        }

        $this->template->title('Leads');
        $this->template
            ->set_layout('inner')
            ->build('paperwork/PwLeads/notes', $data);
    }
    
    function chats($id){
      $id = $this->uri->segment(4);
      
       $data['live_chats'] = (array) App::get_by_where('live_chat', array('lead_id'=>$id));
        $this->template->title('Chat');
              $this->template
                      ->set_layout('inner')
                      ->build('paperwork/PwLeads/livechat', $data);
      
      }
      
       function chat_record(){
         $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('paperwork/modal/chat_record', $data);
    }
    
     function survey($id){
           $data = array();
           // $id =  $this->uri->segment(4);
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
                      $activaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' =>$saveQ['lead_id'],
                            'activity'=> 'Paperwork Survey  : Add'
                          );
                          
           $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add survey from paperwork lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $_POST, $post_data2 );
           log_message('error',serialize($post_adding));      
                           App::LogActivity($activaty);
        	                            
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Survey has been Added');
                    redirect('crm/PWleads/survey/'.$id); 
                 }else{
                     $saveQ = array();
                     
                     
                     foreach($_POST as $qKey => $qVal){
                        $qID = explode('_',$qKey)[1];
                        $match = array ( 'lead_id' => $lead_id,'question_id' => $qID );
                        $saveQ = array(
                                    'answer' => $qVal, 
                                );
                           
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add survey from paperwork lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $_POST, $post_data2 );
           log_message('error',serialize($post_adding));
                            
        	                                                  
                        App::update('survey_answers',$match,$saveQ);
                        
                     }
                      $activaty = array( 
                            'user_id' => $this->tank_auth->get_user_id(),
                            'module'  => 'leads',
                            'field_id' =>$match['lead_id'],
                            'activity'=> 'Paperwork Survey  : Edit'
                          );
                          
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add survey from paperwork lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $_POST, $post_data2 );
           log_message('error',serialize($post_adding));
                      App::LogActivity($activaty);
                      $this->session->set_flashdata('response_status','success'); 
                      $this->session->set_flashdata('message','Survey has been Updated');
                      redirect('crm/PWleads/survey/'.$id);     
                 }  
            }
 
           $this->template->title('survey');
              $this->template
                      ->set_layout('inner')
                      ->build('paperwork/PwLeads/survey', $data);
       
       
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
                
        $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Kitchen Details From Paperwork Lead','activity_record');
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
        				   'option_request'                   => $option_request,
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
                            'activity'=> 'Create Kitchan Details Paperwork : leads'
                          );
                          
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Kitchen Details From Paperwork Lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $post_data, $post_data2 );
           log_message('error',serialize($post_adding));
        	                  App::update('pw_pending_w',$match,$post_data);
        	                  App::LogActivity($activaty);
        	                  $post_data['success'] = array();
                              $this->session->set_flashdata('response_status','success'); 
                              $this->session->set_flashdata('message','PaperWork Update successfully');
                              redirect('crm/PWleads/pw_form/'. $id);
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
                      ->build('paperwork/PwLeads/pwForm', $data);

  }
  
  
  	function edit_task($id){
        //$lead_id = $this->uri->segment(4);
        
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
                      
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Task From Paperwork Lead','activity_record');
           $post_data2 = array( 'activity_id' => $db_activity_id );
           $post_adding = array_merge( $data, $post_data2 );
           log_message('error',serialize($post_adding));
                    
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Task has been updated successfully'); 
                    App::update('task',$match,$data);
                    redirect('crm/PWleads/get_task/'.$lead_id);

                 

            }


            else{
                      $result = $this->db->select('*')->from('assign_team')->get();
                      $data['lead_statuss'] = $result->result('array'); 
                      $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
                     $data['users'] = $userQuery->result('array');
                     $data['task'] = (array) App::get_row_by_where('task', array('id'=>$id) );
                     $this->load->view('paperwork/modal/edit_task', $data);

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
                      ->build('paperwork/PwLeads/taskget', $data);
        
        
        
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
	

   

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */