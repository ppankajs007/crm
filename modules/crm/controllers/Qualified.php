<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
class Qualified extends MX_Controller 
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
    /*
    *   Functionality - List all leads on dashboard page 
    *   Call from :  /dashboard
    */
    public function dashboard( $id ) { 
        $data = array();
        $leads = App::get_row_by_where('leads', array( 'id' => $id ) );
        if(!empty( $leads ) ){
            $data['leads'][] = $leads;
        }
        $data['lsms'] = (array) App::get_by_where('leads_sms', array( 'lead_id' => $id ) );
        $leads_id =  $id;
	    $data['lsms'] = (array) App::get_by_where('leads_sms', array( 'lead_id' => $leads_id) );
        $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ');
        $this->db->from('activity_record');
        $this->db->where(array('activity_id' => $leads_id, 'activity_name' => 'lead_activity'));
        $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
        $this->db->order_by('activity_recordID', 'DESC');
        $query = $this->db->get();
        $data['activities'] = $query->result('array');
        $data['pw_Leads'] = $this->crm_model->findWhere('pw_pending_w',array( 'lead_id'=> $id ),false,array('*'));
        $Mleads = App::get_row_by_where('leads', array('id'=>$id) );
        if(!empty( $Mleads ) ){
            $data['Mleads'][] = $Mleads;
        }
        $scstats = App::get_row_by_where('leads', array( 'id' => $id , 'qf_status'=>int_lead_Hold_On_Design ) );
        if(!empty($scstats)){
            $hold_desgin = App::get_row_by_where('hold_on_desgin', array( 'lead_id' => $id ) );
        if(!empty( $hold_desgin ) ){
            $data['hold'][] = $hold_desgin;
        }
        }else{
            $data['hold'][] = '';
            }
        $Pdata = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
        if(!empty($Pdata)){
            $data['pw_pending']=$Pdata;
        }else{
            $data['pw_pending']='';
            }
        $KFileId = array('field_id' => $id );
        $query = $this->db->select('*')->from('files')->where($KFileId)->order_by("created", "desc")->limit(3)->get();
        $data['KitFilesF'] =  $query->result_array();
        $this->template->title(' Leads');
        $this->template
             ->set_layout('inner')
             ->build('Qualified/dashboard', $data);
	}/* end function dashborad */
    /*
    *   Functionality - List all index on index page 
    *   Call from :  /index
    */
	public function index() { 	
		if (!$this->tank_auth->is_logged_in()) { // logged in
			redirect('auth/login');
		}
        $data = array();
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->template->title('QualifiedLeads');
        $this->template
             ->set_layout('inner')
             ->build('Qualified/Qualified', $data);
    }/* end function */
    /*
    *   Functionality - edit lead 
    *   Call from :  /edit
    */
    public function edit( $id ) {
        $data = array();
        if ( $this->input->post('id') ) {
            $new_date = $this->input->post('reminder_date');
            $lead_status =$this->input->post('lead_status');
            $name=$this->input->post('name');
            $firstname = strtok($name, ' ');
            $lastname = trim(strstr($name, ' '));
            $match=array('id' => $this->input->post('id'));
            $get_init_lead = get_row_data('qf_status','leads',array('id' => $id ));
            if( !empty( $get_init_lead->qf_status )){
                $get_lead_status = get_row_data('status,id','lead_int_status',array('id' => $get_init_lead->qf_status ));
                $old_qf_status   = $get_lead_status->id;
                $get_lead_s      = $get_lead_status->status; 
            }else{
                $old_qf_status = ""; $get_lead_s = "";
            }

        $qf_status = $this->input->post('qf_status');
        $new_lead_status = get_row_data('status','lead_int_status',array('id' => $qf_status ));
        if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
            if($old_qf_status != $qf_status){
                $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                $PMT = get_row_data(array('email'),'assign_team', array('code'=>'PMT') )->email;
                $DT = get_row_data(array('email'),'assign_team', array('code'=>'DT') )->email;
                $ST = get_row_data(array('email'),'assign_team', array('code'=>'ST') )->email;
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_s,$new_l_status,'Change Lead Qualified Status','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                log_message('error',serialize($post_data2));
                if($qf_status == int_lead_Need_More_Info_to_Start){
                    $emailVar['_emailto'] = $PST.','.$PMT;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    send_email('need_more_info_to_start', $emailVar);
                }else if($qf_status == int_lead_Revision_Required){
                    $emailVar['_emailto'] = $DT;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    send_email('revision_required', $emailVar);
                }else if($qf_status == int_lead_Approved_for_Deck){
                    $emailVar['_emailto'] = $DT;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    send_email('approved_for_deck', $emailVar);
                }else if($qf_status == int_lead_Completed){
                    $emailVar['_emailto'] = $ST;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    send_email('completed', $emailVar);
                }
            }
        $post_data = array(
                      'first_name'                      => $firstname,
                      'last_name'                       => $lastname,
                      'qf_status'                       => $qf_status,
                      'lead_status'                     =>$this->input->post('lead_status'),
                      'qf_designAssigned'               =>$this->input->post('qf_designAssigned'),
                      'qf_Kit_File_1'                   =>$this->input->post('qf_Kit_File_1'),
                      'qf_Kit_File_2'                   =>$this->input->post('qf_Kit_File_2'),
                      'qf_Panoramic_D1'                 =>$this->input->post('qf_Panoramic_D1'),
                      'qf_Panoramic_D2'                 =>$this->input->post('qf_Panoramic_D2'),
                      'qf_Deck'                         =>$this->input->post('qf_Deck'),
                      'lost_sale_detail'                =>$this->input->post('lost_sale_detail'),
                      'qf_LIVE_PRESENTATION_TIME'       =>$this->input->post('qf_LIVE_PRESENTATION_TIME'),
                      'qf_Qualifying_Promotions'        =>$this->input->post('qf_Qualifying_Promotions'),
                      'qf_Notes_for_Nicarter'           =>$this->input->post('qf_Notes_for_Nicarter'),
                      'action_lead'       => $this->input->post('action_lead'),

                     'last_action'       => $this->input->post('last_action'),
                     'last_action_note'  => $this->input->post('last_action_note'),
                     'last_action_time'  => crm_dateTime( date('m-d-Y') ),
                  );
            if( !empty($this->input->post('qf_dateRecieved') ) ) {
                $post_data['qf_dateRecieved'] = crm_dateTime( $this->input->post('qf_dateRecieved') );
            }
            if( !empty($this->input->post('qf_LIVE_PRESENTATION_DATE'))  ){
                $post_data['qf_LIVE_PRESENTATION_DATE'] = crm_dateTime( $this->input->post('qf_LIVE_PRESENTATION_DATE') );
            }
            switch($qf_status){
            case '7':
               $post_data_s =array('qf_datestarted' => date('Y-m-d H:i:s') );
               $post_marge = array_merge( $post_data,$post_data_s );
            break;
            case '11':
                $post_data_s =array('qf_dateCompleted' => date('Y-m-d H:i:s') );
                $post_marge = array_merge( $post_data,$post_data_s );
            break;
            }
            if( isset($post_marge)  ){ $qualifieddata = $post_marge;}else{ $qualifieddata = $post_data; }
            $lead_s_text = get_row_data('*','leads',array('id' => $id ));
            if( !empty( $lead_s_text->lead_status )){
                   $find_old_status = get_row_data('status','status_lead',array('id' => $lead_s_text->lead_status ));
                   $find_old_Values = $find_old_status->status; 
            }else{
                $find_old_Values = ""; 
            }
            $find_new_status = get_row_data('status','status_lead',array('id' => $post_data['lead_status'] ));
            if( empty( $find_new_status->status ) ){ $new_status = ""; }else{ $new_status = $find_new_status->status ; }
            if( ($find_old_Values != $new_status) || ($find_old_Values == "" && $new_status !="") || ($find_old_Values !="" && $new_status ==""))
            {
                $db_activity_id = log_activity('lead_activity',$id,$find_old_Values,$new_status,'Update Lead Status','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id, 'new_status' => $new_status );  
            }else{
                $db_activity_id = log_activity('lead_activity',$id,$find_old_Values = "",$new_status ="",'Update Lead Qualified Profile','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
            }
            $post_adding = array_merge( $post_data, $post_data2 );
            log_message('error',serialize($post_adding));
            App::update('leads',$match,$qualifieddata);
            $post_data['success'] = array();
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Qualified Lead has been Update successfully');
            if ($lead_status == lead_Contacted_Schedule_In_Home_Appointment ){
                    redirect('/crm/Qualified/dashboard/'.$id);
                }else if($lead_status == lead_Presentation_Lead ){
                        redirect('/crm/Presentation/dashboard/'.$id);
                }else if ($lead_status == lead_Contacted_Paperwork_Pending ){
                        redirect('/crm/PWleads/dashboard/'.$id);
                }else if ($lead_status == lead_Lost_sale ){
                        redirect('/crm/leads/dashboard/'.$id);
                }
        }
        $data['leads'] = (array) App::get_row_by_where('leads', array('id'=>$id) );
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        $data['pw_data'] = (array) App::get_row_by_where('pw_pending_w', array('id'=>$id) );
        $data['lead_statuss'] = $this->crm_model->custom_query("SELECT * FROM status_lead WHERE id IN ( ".lead_Contacted_Paperwork_Pending.", ".lead_Contacted_Schedule_In_Home_Appointment.", ".lead_Lost_sale.", ".lead_Presentation_Lead." )",false,'array');
        $data['int_lead_status'] = $this->crm_model->custom_query("SELECT * FROM lead_int_status WHERE id IN ( ".int_lead_Need_More_Info_to_Start.", ".int_lead_Not_Started.", ".int_lead_Started.", ".int_lead_Ready_for_QC.", ".int_lead_Revision_Required.", ".int_lead_Approved_for_Deck.", ".int_lead_Completed.", ".int_lead_Hold_On_Design." )",false,'array');
        
        $data['KitFilesF']   = $this->leadFileType('kit 1',$id);
        $data['deck1']       = $this->leadFileType('Deck 1',$id); 
        $data['deck2']       = $this->leadFileType('Deck 2',$id); 
        $data['deck3']       = $this->leadFileType('Deck 3',$id); 
        $data['worksheet']   = $this->leadFileType('Worksheet',$id); 

        $this->template->title('Edit Leads');
        $this->template
            ->set_layout('inner')
            ->build('Qualified/edit', $data);
    }/* end function Edit */
    /*
    *   Functionality - getQualified lead 
    *   Call from :  /getQualified
    */

    function leadFileType($typename,$id){
        $KFileId = array('lead_file_type' => $typename, 'field_id' => $id );
        $query = $this->db->select('*')->from('files')->where($KFileId)->order_by("created", "desc")->limit(3)->get();
        $fileData = $query->result_array();
        return $fileData;
    }


    public function getQualified(){
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                      0 => 'lid',
                      1 => 'fullname',
                      2 => 'qf_status',
                      3 => 'qf_designAssigned',
                      4 => 'qf_datestarted',
                      5 => 'survey',
                      6 => 'hoteness',
                      7 => 'hs',
                      8 => 'qf_dateRecieved',
                      9 => 'qf_dateAdded',
                      10 => 'qf_datestarted',
                      11 => 'qf_dateCompleted',
                      12 => 'qf_dateCompleted',
                      13 => 'qf_dateSent'
                );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT l.*, l.id as lid,  CONCAT(l.first_name,' ', l.last_name) as fullname,l.qf_dateRecieved,l.qf_designAssigned,l.qf_datestarted,p.name as nsowner, pw.*,
        ( SELECT SUM(`point`) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id)) AS survey,
        ( SELECT SUM(`point`)+ (SELECT hoteness*2*10  FROM leads WHERE id = l.id) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id) ) AS hs, s.status AS int_status";
        $sql.=" FROM leads l left join user_profiles p on l.assigned_to =p.user_id left join pw_pending_w pw ON pw.lead_id = l.id left join lead_int_status s on l.qf_status=s.id WHERE (l.vendor_id = '$vendor_id') AND  l.lead_status ='".lead_Quote_Proactive_In_Design."'";
        $totalData = $this->crm_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND ( l.id LIKE '".$requestData['search']['value']."%' ";    
            $sql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' ";    
            $sql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_designAssigned LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_dateRecieved LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_dateAdded LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_datestarted LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR l.hoteness LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR p.name LIKE '%".ucfirst($requestData['search']['value'])."%' "; 
            $sql.=" OR s.status LIKE '".$requestData['search']['value']."%' )";
        }
     // assigned to filter
        $AssignFilter = $_REQUEST['columns'][1]['search']['value'];
        if ( !empty($AssignFilter)  ) {
            $sql.= " AND l.assigned_to IN (".$AssignFilter.")"; 
        }
        $totalFiltered = $this->crm_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $total_record = $this->crm_model->custom_query($sql,false,'array'); 
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) ) { 
            foreach ($total_record as $row) {
                if( empty( $row['survey']) ){ $row['survey'] = '0';  }
                if( !empty($row['nsowner'])){ $leadsName = $row['nsowner']; }else{ $leadsName = 'N/A'; }
                if( !empty($row['hoteness'])){ $hotee = $row['hoteness']; }else{ $hotee = '0'; }
                if( !empty($row['qf_datestarted'])){ 
                    $datest = $row['qf_datestarted'];
                    $datestarted = date("m/d/Y", strtotime($datest));
                }else{ $datestarted = 'N/A'; }
                if( !empty( $row['int_status'] ) ){ $Qstatus = $row['int_status'];  } else { $Qstatus = 'Qualified'; }
                if( !empty( $row["qf_dateRecieved"] ) ){ 
                    $Recieved = crm_date($row["qf_dateRecieved"]);
                }else{ $Recieved = 'N/A'; }
                if( !empty( $row["qf_dateCompleted"] ) ){ 
                    $Completed = crm_date($row["qf_dateCompleted"]);
                }else{ 
                    $Completed = 'N/A'; 
                }
                if( !empty( $row["qf_dateSent"] ) ){ $send = crm_date($row["qf_dateSent"]); } else { $send = 'N/A'; }
                if( !empty( $row["qf_designAssigned"] ) ){ $designAssigned = $row["qf_designAssigned"];  } else { $designAssigned = 'N/A'; }
                if( !empty( $row["qf_dateAdded"] ) ){ $qfnewDate = crm_date($row["qf_dateAdded"]);  } else { $qfnewDate = 'N/A'; }
                if(!empty($row["qf_dateCompleted"])  ){
                    $date1=date_create($row["qf_dateAdded"]);
                    $date2=date_create($row['qf_dateCompleted']);
                    $diff=date_diff($date1,$date2);
                    $Quee= $diff->format("%R%a days");
                }else{
                    $Quee= 'N/A';
                    }
                if( empty($row['hs']) ){ $row['hs'] = '0'; }
                $html= '';
                $html .=  '<a href="'.base_url().'crm/Qualified/edit/'. $row["lid"].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                $html .=  '<a href="'.base_url().'crm/Qualified/Dashboard/'.$row['lid'].'" title="Dashboard" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                if($row["qf_status"]!= int_lead_Revision_Required ){
               
                $data[] = array(
                        $row["lid"], 
                        '<a href="'.base_url().'crm/Qualified/dashboard/'.$row['lid'].'" >'.$row["fullname"].'</a>',
                        $Qstatus, 
                        $leadsName,
                        $designAssigned,
                        $row['survey'],
                        $hotee,
                        $row['hs'],
                        $Recieved, 
                        $qfnewDate,
                        $datestarted,
                        $Completed,
                        $Quee,
                        $send,
                        $html
                );
                }
            }
        }
        $json_data = array(
                          "draw"            => intval( $requestData['draw'] ),
                          "recordsTotal"    => intval( $totalData ),  // total number of records
                          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then 
                          "data"            => $data   // total data array
                    );
         echo json_encode($json_data);  // send data as json format
   }/* end function getQualified  */
    
    /*
    *   Functionality - QualifiedForm  KITHCHEN
    *   Call from :  /QualifiedForm
    */
    public function QualifiedForm(){
        $id = $this->uri->segment(4);
        $Pwdata = (array) App::get_row_by_where('pw_pending_w', array('lead_id'=>$id) );
        if( empty($Pwdata) ){
            $post_data = array(
                            'lead_id'          	               => $id,
                            'cabinet_manufacturer'		       => '',
                            'door_style'			           => '',
                            'desired_flooring_type'		       => '',
                            'desired_flooring_color'		   => '',
                            'backsplash'                       => '',
                            'countertop_type'                  => '',
                            'countertop_color'                 => '',
                            'knobs_and_handles'                => '',
                            'sink_type'                        => '',
                            'sink_color'                       => '',
                            'sink_bowls'                       => '',
                            'keeping_existing'                 => '',
                            'dishwasher_size'                  => '',
                            'desired_dishwasher_color'         => '',
                            'dishwasher_quantity'              => '',
                            'range_size'                       => '',
                            'cooktop_size_p'                   => '',
                            'wall_oven_count'                  => '',
                            'wall_oven_width'                  => '',
                            'cooktop_size'                     => '',
                            'microwave'                        => '',
                            'microwave_width'                  => '',
                            'hood'                             => '',
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
		 App::save_data( 'pw_pending_w', $post_data );
        }else{
            if(isset($_POST)){ 
                if($this->input->post('lead_id')){
                if( !empty( $this->input->post('option_request') ) ){
                    $option_request = implode(", ",$this->input->post('option_request'));
                }else{ $option_request='';  }
                $match=array('lead_id' => $this->input->post('lead_id'), );
    	        $post_data = array(
                                'cabinet_manufacturer'		       => $this->input->post('cabinet_manufacturer'),
                                'door_style'			           => $this->input->post('door_style'),
                                'desired_flooring_type'		       => $this->input->post('desired_flooring_type'),
                                'desired_flooring_color'		   => $this->input->post('desired_flooring_color'),
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
                                'cooktop_size'                     => $this->input->post('cooktop_size'),
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
    		            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Kitchen Details From Qualified','activity_record');
                        $post_data2 = array( 'activity_id' => $db_activity_id );
                        $post_adding = array_merge( $post_data, $post_data2 );
                        log_message('error',serialize($post_adding));
                        App::update('pw_pending_w',$match,$post_data);
                        
                        $post_data['success'] = array();
                        $this->session->set_flashdata('response_status','success'); 
                        $this->session->set_flashdata('message','Qualified Kitchen Details Update successfully');
    
                        redirect('/crm/Qualified/QualifiedForm/'.$id);
                   }
            }
        }
	    $data = array();
        if(!empty($id)){
            $data['pw_pending'] = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
        }else{
            $data['pw_pending'] = '';
        }
        $this->template->title('Lead QualifiedForm');
        $this->template
              ->set_layout('inner')
              ->build('Qualified/QualifiedLeads/QualifiedForm', $data);
    }/* end function QualifiedForm  */
    
    /*
    *   Functionality - files   listing 
    *   Call from :  /files
    */
    public  function files(){
        $id = $this->uri->segment(4);
        $data = array();
        $data['file_data'] = $this->crm_model->findWhere('files', array('field_id' => $id ), array('*') );
        $this->template->title('File');
        $this->template
             ->set_layout('inner')
             ->build('Qualified/QualifiedLeads/file', $data);
    }/* end function files  */

    /*
    *   Functionality - files   listing 
    *   Call from :  /files
    */
    public function add_file(){
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
                        'lead_file_type'  => $this->input->post('lead_file_type'),
                        'path'            => $this->upload->data('file_path'),
                        'ext'             => $this->upload->data('file_ext'),
                        'size'            => $this->upload->data('file_size'),
                        'is_image'        => $this->upload->data('is_image'),
                        'description'     => $this->input->post('description'),
                        'created_by'      => $this->tank_auth->get_user_id()
                    );

                $leads_id = $this->input->post('leads_id');
                $lead_file_type = $this->input->post('lead_file_type');
                $file_name =  base_url().'assets/leadsfiles/'.$this->upload->data('file_name');
                $imgData =  array();
                
                if ( $lead_file_type == 'kit 1' ){
                    $old_qf_Kit_File_1 = $this->crm_model->select_where('qf_Kit_File_1','leads',array('id' => $leads_id ));
                  
                    if ( empty($old_qf_Kit_File_1) ) {
                        $imgData['qf_Kit_File_1'] = $file_name;
                    } else {
                        $imgData['qf_Kit_File_1'] = $file_name;
                        $imgData['qf_Kit_File_2'] = $old_qf_Kit_File_1->qf_Kit_File_1;
                    }
                }else if ( $lead_file_type == 'kit 2' ){
                     $imgData['qf_Kit_File_2'] = $file_name;
                }
                

                if ( !empty($imgData) ) {
                    $match = array ( 'id' => $leads_id );
                    App::update('leads',$match,$imgData);
                }

                if( !$lead_id = App::save_data( 'files', $data )  ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
                }else{
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add File From Qualified ','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $data, $post_data2 );
                    log_message('error',serialize($post_adding));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File added successfully');
                    }
                redirect('crm/Qualified/files/'.$id);
            }
           }
        $this->load->view('Qualified/modal/add_file',$id);
    }/* end function add_file  */

    /*
    *   Functionality - notes   add 
    *   Call from :  /notes
    */
    function notes( $id ){   
        $data = array();
        $data['leads'] = (array) App::get_row_by_where('leads', array( 'id' => $id ) );
        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array'); 
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        if ( $this->input->post('lead_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('lead_id');
            $match = array ( 'id' => $this->input->post('lead_id') );
            $data = array( 'note'  => $this->input->post('note') );
            $query = $this->crm_model->select_where('first_name','leads',array('id' => $this->input->post('lead_id') ));
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Note has been updated');
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add a note from Qualified ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));
            App::update('leads',$match,$data);
            redirect('crm/Qualified/notes/'.$this->input->post('lead_id')); 
        }
        $this->template->title('Leads');
        $this->template
              ->set_layout('inner')
              ->build('Qualified/QualifiedLeads/notes', $data);
    }/* end function notes  */

    /*
    *   Functionality - chats   add 
    *   Call from :  /chats
    */
    public function chats( $id ) {
        $id = $this->uri->segment(4);
        $data['live_chats'] = (array) App::get_by_where('live_chat', array('lead_id'=>$id));
        $this->template->title('Chat');
        $this->template
              ->set_layout('inner')
              ->build('Qualified/QualifiedLeads/livechat', $data);
    }/* end function notes  */

    /*
    *   Functionality - chats   add 
    *   Call from :  /chats
    */
    public function chat_record(){
        $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id'=>$id) );
        $this->load->view('Qualified/modal/chat_record', $data);
    }/* end function chat_record  */

    /*
    *   Functionality - survey   add 
    *   Call from :  /survey
    */
    public function survey($id){
        $data = array();
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
                            'user_id'     => $this->tank_auth->get_user_id(),
                            'module'      => 'leads',
                            'field_id'    =>$saveQ['lead_id'],
                            'activity'    => 'Qualified  Survey  : Add'
                            );
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Survey From Qualified ','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize($post_adding));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Qualified Survey has been Added');
                redirect('crm/Qualified/survey/'.$id); 
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
                $activaty = array( 
                        'user_id'      => $this->tank_auth->get_user_id(),
                        'module'       => 'leads',
                        'field_id'     =>$match['lead_id'],
                        'activity'     => 'Qualified  Survey  : Edit'
                        );
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Survey From Qualified ','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize($post_adding));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message',' Qualified Survey has been Updated');
                redirect('crm/Qualified/survey/'.$id);     
            }  
        }
        $this->template->title('survey');
        $this->template
              ->set_layout('inner')
              ->build('Qualified/QualifiedLeads/survey', $data);
    }/* end function survey  */

    /*
    *   Functionality - add_task   add 
    *   Call from :  /add_task
    */
    public function add_task() {
        if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
    		redirect('/auth/login/');
        }else{
        	if( $this->input->post() ){
    		$id = $this->uri->segment(4);
    		
            $new_date = $this->input->post('reminder_date');
            $lead_status =$this->input->post('lead_status');
            $name = $this->input->post('fullname');
            $url = base_url().'crm/Qualified/edit/'.$id;
            $firstname = strtok($name, ' ');
            $lastname = trim(strstr($name, ' '));


    		$get_init_lead = get_row_data('qf_status','leads',array('id' => $id ));
            if( !empty( $get_init_lead->qf_status )){
                $get_lead_status = get_row_data('status,id','lead_int_status',array('id' => $get_init_lead->qf_status ));
                $old_qf_status   = $get_lead_status->id;
                $get_lead_s      = $get_lead_status->status; 
            }else{
                $old_qf_status = ""; $get_lead_s = "";
            }
            
    		$qf_status = $this->input->post('qf_status');
            $new_lead_status = get_row_data('status','lead_int_status',array('id' => $qf_status ));
            
            if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
                if($old_qf_status != $qf_status){
                    $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                    $PMT = get_row_data(array('email'),'assign_team', array('code'=>'PMT') )->email;
                    $DT = get_row_data(array('email'),'assign_team', array('code'=>'DT') )->email;
                    $ST = get_row_data(array('email'),'assign_team', array('code'=>'ST') )->email;
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_s,$new_l_status,'Change Lead Qualified Status','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    log_message('error',serialize($post_data2));
                    if($qf_status == int_lead_Need_More_Info_to_Start){
                        $emailVar['_emailto'] = $PST.','.$PMT;
                        $emailVar['{name}'] = $firstname.' '.$lastname;
                        $emailVar['{lead_url}'] = $url;
                        send_email('need_more_info_to_start', $emailVar);
                    }else if($qf_status == int_lead_Revision_Required){
                        $emailVar['_emailto'] = $PST.','.$PMT;
                        $emailVar['{name}'] = $firstname.' '.$lastname;
                        $emailVar['{lead_url}'] = $url;
                        send_email('revision_required', $emailVar);
                    }else if($qf_status == int_lead_Approved_for_Deck){
                        $emailVar['_emailto'] = $PST.','.$PMT;
                        $emailVar['{name}'] = $firstname.' '.$lastname;
                        $emailVar['{lead_url}'] = $url;
                        send_email('approved_for_deck', $emailVar);
                    }else if($qf_status == int_lead_Completed){
                        $emailVar['_emailto'] = $PST.','.$PMT;
                        $emailVar['{name}'] = $firstname.' '.$lastname;
                        $emailVar['{lead_url}'] = $url;
                        send_email('completed', $emailVar);
                    }
                }
                
            foreach( $_POST['task'] as $key => $value ){
                    $post_data = array(
                				    'task_desc'	       => $value['task_desc'],
                				 	'assigned_team'	   => $value['assigned_team'],
                				 	'vendor_id'        => $this->session->userdata('vendor_id'),
                				 	'created'		   => date('Y-m-d H:i:s'),
                				 	'created_by'       =>$this->session->userdata('user_id'),
                				 	'status'           => 'Pending',
                				 	'lead_id'		   => $value['lead_id']
                				);
    				if(!empty($value['task_title'])){
                        $post_data['task_title'] = $value['task_title'];
                    }
    			    if(!empty($value['deadline_date']) ){
                        $post_data['deadline_date'] = crm_dateTime($value['deadline_date']);
                    }
    				if(!empty($value['task_title']) || $value['task_desc'] ){
                        $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Task From Qualified ','activity_record');
                        $post_data2 = array( 'activity_id' => $db_activity_id );
                        log_message('error',serialize($post_data2));
                        $add= App::save_data( 'task', $post_data ) ;				 
    				}
                }
                if( $add != ''){
                    //$qf_status= $this->input->post('qf_status');
                   if($this->input->post('qf_status')==int_lead_Need_More_Info_to_Start){
                    $match = array ( 'id' => $id );
                    $data = array (
                                'lead_status' => lead_Contacted_Paperwork_Pending,
                                'qf_status' =>$this->input->post('qf_status')
                            );
                    App::update('leads',$match,$data);
                   }else{
                        $match = array ( 'id' => $id );
                        $data = array (
                              'qf_status' =>$this->input->post('qf_status')
                            );
                    App::update('leads',$match,$data);
                    }
                    
                    $ldata = (array) App::get_row_by_where('leads', array('id'=>$id) );
                    $firstname= $ldata['first_name'];
                    $lastname = $ldata['last_name'];
                    $ur = base_url('crm/leads/dashboard/'.$id);
                    $PST = get_row_data(array('email'),'assign_team', array('code'=>'PST') )->email;
                    $emailVar['_emailto'] = $PST;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    $emailVar['{lead_url}'] =$ur;
                    $emailSent = send_email('task_created', $emailVar);
                    $LogArr = array( 'sent_email' => $emailSent, 'lead' => $ur );
                    log_message('error',serialize($post_data2));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Task has Been  add successfully');
                    redirect('crm/Qualified/edit/'.$id);
                }else{	
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Task didn\'t save, Try again!');
                    redirect('crm/Qualified/edit/'.$id);
                }
    	    }
    	    
        }
        $data = array();
        $result = $this->db->select('*')->from('assign_team')->get();
        $data['lead_statuss'] = $result->result('array'); 
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        $this->load->view('Qualified/modal/add_task', $data);
    }/* end function add_task  */

    /*
    *   Functionality - add_hold_desgin   add 
    *   Call from :  /add_hold_desgin
    */
    public function add_hold_desgin(){
        if( $this->input->post() ){
            $id = $this->input->post('lead_id');
            $holdData  = App::get_row_by_where('hold_on_desgin', array('lead_id'=>$id) );
            if( !empty( $holdData ) ){
                $hdID = $holdData->id;       
            }else{    			     
                $hdID ='0';  
            }
            if($hdID != $this->input->post('id') ){
                $timestamp             = strtotime($this->input->post('hold_next_step_date')); 
                $new_date             = date('Y-m-d', $timestamp);
                $curr_time            = date('h:i:sa');
                $post_data = array(
                		      'hold_reason'	             => $this->input->post('hold_reason'),
                		      'hold_next_step_date'	     => $new_date.' '.$curr_time,
                		      'hold_next_step'	 	     => $this->input->post('hold_next_step'),
                		      'hold_owner'               => $this->input->post('hold_owner'),
                		      'lead_id'	          	     => $id,
                	        );
                if( !$hold_id = App::save_data( 'hold_on_desgin', $post_data ) ) {
                        $this->session->set_flashdata('response_status', 'error');
                        $this->session->set_flashdata('message', 'Task didn\'t save, Try again!');
                        redirect('crm/Qualified/edit/'.$id);
                }else{		
                    $match = array ('id' => $this->input->post('lead_id') );
                    $phdata = array('qf_status'         => int_lead_Hold_On_Design);
                    App::update('leads', $match, $phdata);  
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'add  on hold ','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $post_data, $post_data2 );
                    log_message('error',serialize($post_adding));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Hold on desgin has Been  add successfully');
                    redirect('crm/Qualified/edit/'.$id);
                    }  
            }else{
                $timestamp = strtotime($this->input->post('hold_next_step_date')); 
                $new_date = date('Y-m-d', $timestamp);
                $curr_time = date('h:i:sa');
                $match = array ('id' => $this->input->post('id') );
                $pdata = array(
            				'hold_reason'	        => $this->input->post('hold_reason'),
            				'hold_next_step_date'	=> $new_date.' '.$curr_time,
            				'hold_next_step'	 	=> $this->input->post('hold_next_step'),
            				'hold_owner'            => $this->input->post('hold_owner'),
            				'lead_id'	          	=> $id,
                        	);
                $match = array ( 'id' => $this->input->post('lead_id'));
                $phdata = array( 'qf_status'         => int_lead_Hold_On_Design);
                App::update('leads',$match,$phdata); 
                App::update('hold_on_desgin',$match,$pdata);
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'add  on hold ','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $post_data, $post_data2 );
                log_message('error',serialize($post_adding));
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', 'Hold on desgin has Been  add successfully');
                redirect('crm/Qualified/edit/'.$id);
               }
            }
        $id = $this->uri->segment(4);
        $data['hold'] = App::get_row_by_where('hold_on_desgin', array( 'lead_id' => $id ) );
        $this->load->view('Qualified/modal/add_hold_desgin', $data);
    }/* end function add_hold_desgin  */

    /*
    *   Functionality - edit_task   edit 
    *   Call from :  /edit_task
    */
    public function edit_task($id){
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
            $match = array ('id' => $this->input->post('task_id'));
            $data = array(
                        'task_title'        => $this->input->post('task_title'),
                        'task_desc'         => $this->input->post('task_desc'),
                        'assigned_team'		=> $this->input->post('assigned_team'),
                        'status'            => $this->input->post('status'),
                        );
            $db_activity_id = log_activity('lead_activity',$lead_id,$get_lead_status="",$new_lead_status="",'Edit task paperwork ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $post_data, $post_data2 );
            log_message('error',serialize($post_adding));            
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Task has been updated successfully'); 
            App::update('task',$match,$data);
            redirect('crm/Qualified/get_task/'.$lead_id);
        }else{
            $result = $this->db->select('*')->from('assign_team')->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $data['task'] = (array) App::get_row_by_where('task', array('id'=>$id) );
            $this->load->view('Qualified/modal/edit_task', $data);
            }
    }/* end function edit_task  */

    /*
    *   Functionality - get_task   get task Lead 
    *   Call from :  /get_task
    */	
    public function get_task() {
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
              ->build('Qualified/QualifiedLeads/taskget', $data);
    }/* end function get_task  */

    /*
    *   Functionality - Prdelete_task   delete task 
    *   Call from :  /get_task
    */  
    public function Prdelete_task() {
        if( isset($_POST['ids']) ){
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
    }/* end function Prdelete_task  */

    /*
    *   Functionality - load_script   js 
    *   Call from :  /load_script
    */  
    public function load_script() {
        $data = array();
        $this->load->view('Qualified/load_script', $data);
    }/* end function load_script  */

    /*
    *   Functionality - load_css   css 
    *   Call from :  /load_css
    */  
    public function load_css() {
        $data = array();
        $this->load->view('Qualified/load_css', $data);
    }/* end function Prdelete_task  */

    /*
    *   Functionality - load_script   js 
    *   Call from :  /get_task
    */  
    public function hitemail() {
        $emailVar['_emailto'] = 'webbninja2@gmail.com';
        $emailVar['{name}'] = "WebbNinja";
        send_email('need_more_info_to_start', $emailVar);
    }/* end function Prdelete_task  */
    
     public function revision(){
        $data = array();
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->template->title('revisionLeads');
        $this->template
         ->set_layout('inner')
         ->build('Qualified/Qualifiedrevs', $data);         
   }/* end function getQualifiedrevd  */

    function get_revision(){
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                      0 => 'lid',
                      1 => 'fullname',
                      2 => 'qf_status',
                      3 => 'qf_designAssigned',
                      4 => 'qf_datestarted',
                      5 => 'survey',
                      6 => 'hoteness',
                      7 => 'hs',
                      8 => 'qf_dateRecieved',
                      9 => 'qf_dateAdded',
                      10 => 'qf_datestarted',
                      11 => 'qf_dateCompleted',
                      12 => 'qf_dateCompleted',
                      13 => 'qf_dateSent'
                );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT l.*, l.id as lid,  CONCAT(l.first_name,' ', l.last_name) as fullname,l.qf_dateRecieved,l.qf_designAssigned,l.qf_datestarted,p.name as nsowner, pw.*,
        ( SELECT SUM(`point`) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id)) AS survey,
        ( SELECT SUM(`point`)+ (SELECT hoteness*2*10  FROM leads WHERE id = l.id) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id) ) AS hs, s.status AS int_status";
        $sql.=" FROM leads l left join user_profiles p on l.assigned_to =p.user_id left join pw_pending_w pw ON pw.lead_id = l.id left join lead_int_status s on l.qf_status=s.id WHERE l.vendor_id = '$vendor_id' AND  l.lead_status ='".lead_Contacted_Schedule_In_Home_Appointment."'AND l.qf_status='".int_lead_Revision_Required."' ";
        $totalData = $this->crm_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND ( l.id LIKE '".$requestData['search']['value']."%' ";    
            $sql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' ";    
            $sql.=" OR l.first_name LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_designAssigned LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_dateRecieved LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_dateAdded LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR l.qf_datestarted LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR l.hoteness LIKE '%".$requestData['search']['value']."%' "; 
            $sql.=" OR p.name LIKE '%".ucfirst($requestData['search']['value'])."%' "; 
            $sql.=" OR s.status LIKE '".$requestData['search']['value']."%' )";
        }
     // assigned to filter
        $AssignFilter = $_REQUEST['columns'][1]['search']['value'];
        if ( !empty($AssignFilter)  ) {
            $sql.= " AND l.assigned_to IN (".$AssignFilter.")"; 
        }
        $totalFiltered = $this->crm_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $total_record = $this->crm_model->custom_query($sql,false,'array'); 
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) ) { 
            foreach ($total_record as $row) {
                if( empty( $row['survey']) ){ $row['survey'] = '0';  }
                if( !empty($row['nsowner'])){ $leadsName = $row['nsowner']; }else{ $leadsName = 'N/A'; }
                if( !empty($row['hoteness'])){ $hotee = $row['hoteness']; }else{ $hotee = '0'; }
                if( !empty($row['qf_datestarted'])){ 
                    $datest = $row['qf_datestarted'];
                    $datestarted = date("m/d/Y", strtotime($datest));
                }else{ $datestarted = 'N/A'; }
                if( !empty( $row['int_status'] ) ){ $Qstatus = $row['int_status'];  } else { $Qstatus = 'Qualified'; }
                if( !empty( $row["qf_dateRecieved"] ) ){ 
                    $Recieved = crm_date($row["qf_dateRecieved"]);
                }else{ $Recieved = 'N/A'; }
                if( !empty( $row["qf_dateCompleted"] ) ){ 
                    $Completed = crm_date($row["qf_dateCompleted"]);
                }else{ 
                    $Completed = 'N/A'; 
                }
                if( !empty( $row["qf_dateSent"] ) ){ $send = crm_date($row["qf_dateSent"]); } else { $send = 'N/A'; }
                if( !empty( $row["qf_designAssigned"] ) ){ $designAssigned = $row["qf_designAssigned"];  } else { $designAssigned = 'N/A'; }
                if( !empty( $row["qf_dateAdded"] ) ){ $qfnewDate = crm_date($row["qf_dateAdded"]);  } else { $qfnewDate = 'N/A'; }
                if(!empty($row["qf_dateCompleted"])  ){
                    $date1=date_create($row["qf_dateAdded"]);
                    $date2=date_create($row['qf_dateCompleted']);
                    $diff=date_diff($date1,$date2);
                    $Quee= $diff->format("%R%a days");
                }else{
                    $Quee= 'N/A';
                    }
                if( empty($row['hs']) ){ $row['hs'] = '0'; }
                $html= '';
                $html .=  '<a href="'.base_url().'crm/Qualified/edit/'. $row["lid"].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                $html .=  '<a href="'.base_url().'crm/Qualified/Dashboard/'.$row['lid'].'" title="Dashboard" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                $data[] = array(
                        $row["lid"], 
                        '<a href="'.base_url().'crm/Qualified/dashboard/'.$row['lid'].'" >'.$row["fullname"].'</a>',
                        $Qstatus, 
                        $leadsName,
                        $designAssigned,
                        $row['survey'],
                        $hotee,
                        $row['hs'],
                        $Recieved, 
                        $qfnewDate,
                        $datestarted,
                        $Completed,
                        $Quee,
                        $send,
                        $html
                );
            }
        }
        
        $json_data = array(
                          "draw"            => intval( $requestData['draw'] ),
                          "recordsTotal"    => intval( $totalData ),  // total number of records
                          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then 
                          "data"            => $data   // total data array
                    );
         echo json_encode($json_data);  // send data as json format
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */