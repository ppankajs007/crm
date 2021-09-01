<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class Presentation extends MX_Controller 
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
        $this->load->model('crm_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
			redirect('auth/login');
		}
	}

	/*
    * Funtionality : View Presentation dashboard lead .
    * Call From : dashboard
    */
	public function dashboard( $id ){ 
	    $data = array();
        $leads = App::get_row_by_where('leads', array( 'id' => $id ) );
        if(!empty( $leads ) ){
            $data['leads'][] = $leads;
        }
        $data['lsms'] = (array) App::get_by_where('leads_sms', array('lead_id' => $id) );
        $this->db->select('activity_record.*, activity_record.id as activity_recordID,user_profiles.name ');
        $this->db->from('activity_record');
        $this->db->where(array('activity_id' => $id, 'activity_name' => 'lead_activity'));
        $this->db->join('user_profiles', 'user_profiles.user_id = activity_record.user_id');
        $this->db->order_by('activity_recordID', 'DESC');
        $query = $this->db->get();
        $data['activities'] = $query->result('array');
        $data['pw_Leads'] = $this->crm_model->findWhere('pw_pending_w',array('lead_id' => $id),false,array('*'));
        $Mleads = App::get_row_by_where('leads', array('id' => $id ) );
        if(!empty( $Mleads ) ){
            $data['Mleads'][] = $Mleads;
        }
        $Pdata = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
        if(!empty($Pdata)){
            $data['pw_pending'] = $Pdata;
        }else{
            $data['pw_pending'] = '';
        }
        $scstats = App::get_row_by_where('leads', array('id'=>$id , 'qf_status'=>int_lead_Hold_On_Design ) );
        if(!empty($scstats)){
            $hold_desgin = App::get_row_by_where('hold_on_desgin', array('lead_id' => $id) );
            if(!empty( $hold_desgin ) ){
                $data['hold'][] = $hold_desgin;
            }
        }else{
           $data['hold'][] = '';
        }
        $KFileId = array('lead_file_type' => 'kit 1', 'field_id' => $id );
        $query = $this->db->select('*')->from('files')->where($KFileId)->order_by("created", "desc")->limit(3)->get();
        $data['KitFilesF'] =  $query->result_array();
        $this->template->title('Presentation');
        $this->template
                ->set_layout('inner')
                ->build('Presentation/dashboard', $data);
	}/* End function dashboard*/

    /*
    * Funtionality : Leads listing view 
    * Call From : Presentation Leads
    */
	public function index()	{ 	
		if (!$this->tank_auth->is_logged_in()) { // logged in
			redirect('auth/login');
		}
        $data = array();
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->template->title('Presentation');
        $this->template
            ->set_layout( 'inner' )
            ->build( 'Presentation/Presentation', $data);
	}/* End function index*/

    /*
    * Funtionality : PLead edit  
    * Call From : edit
    */
    public function edit($id) {
        if ( $this->input->post('id') ) {
            $id = $this->input->post('id');
            $new_date = $this->input->post('reminder_date');
            $name=$this->input->post('name');
            $firstname = strtok($name, ' ');
            $lastname = trim(strstr($name, ' '));
            $match = array('id' => $this->input->post('id'),);
            $qf_status = $this->input->post('qf_status');
            $lead_status =$this->input->post('lead_status');
            $post_data = array(
                            'first_name'                      => $firstname,
                            'last_name'                       => $lastname,
                            'qf_status'                       => $qf_status,
                            'lead_status'                     => $this->input->post('lead_status'),
                            'qf_designAssigned'               => $this->input->post('qf_designAssigned'),
                            'qf_Kit_File_1'                   => $this->input->post('qf_Kit_File_1'),
                            'qf_Kit_File_2'                   => $this->input->post('qf_Kit_File_2'),
                            'qf_Panoramic_D1'                 => $this->input->post('qf_Panoramic_D1'),
                            'qf_Panoramic_D2'                 => $this->input->post('qf_Panoramic_D2'),
                            'qf_Deck'                         => $this->input->post('qf_Deck'),
                            'lost_sale_detail'                => $this->input->post('lost_sale_detail'),
                            'qf_LIVE_PRESENTATION_TIME'       => $this->input->post('qf_LIVE_PRESENTATION_TIME'),
                            'qf_Qualifying_Promotions'        => $this->input->post('qf_Qualifying_Promotions'),
                            'qf_Notes_for_Nicarter'           => $this->input->post('qf_Notes_for_Nicarter')
                        );
            if ( !empty($this->input->post('qf_dateRecieved')) ){
                $post_data['qf_dateRecieved'] = crm_dateTime( $this->input->post('qf_dateRecieved') );
            }
            if( $this->input->post( 'lead_status' ) == lead_Quote_Proactive_In_Design ){
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
            }
            
            if ( !empty($this->input->post('qf_LIVE_PRESENTATION_DATE')) ){
               $post_data['qf_LIVE_PRESENTATION_DATE'] = crm_dateTime( $this->input->post('qf_LIVE_PRESENTATION_DATE') );
            }

            switch ($this->input->post('lead_status')) {
                case '5':
                    $post_data_s =array('qf_dateSent' => date('Y-m-d H:i:s') );
                    $post_marge = array_merge( $post_data,$post_data_s );
                    break;
            }

            switch ($this->input->post('qf_status')) {
                case int_lead_Started:
                   $post_data_s =array('qf_datestarted' => date('Y-m-d H:i:s') );
                   $post_marge = array_merge( $post_data,$post_data_s );
                break;
                case int_lead_Completed:
                    $post_data_s =array('qf_dateCompleted' => date('Y-m-d H:i:s') );
                    $post_marge = array_merge( $post_data,$post_data_s );
                break;/*
                case int_lead_Sent_to_Customer:
                    $post_data_s =array('qf_dateSent' => date('Y-m-d H:i:s') );
                    $post_marge = array_merge( $post_data,$post_data_s );
                break;*/
                case int_lead_Ready_for_QC:
                    $post_data_s =array('qc_start_date' => date('Y-m-d H:i:s') );
                    $post_marge = array_merge( $post_data,$post_data_s );
                break;
            }
            $get_lead_data_s = get_row_data('*','leads',array( 'id' => $id ));
            if( !empty( $get_lead_data_s->qf_status )){
                $get_lead_status_s = get_row_data('status','lead_int_status',array('id' => $get_lead_data_s->qf_status ));
                $get_lead_s = $get_lead_status_s->status; 
            }else{
                $get_lead_s = "";
            }
            $new_lead_status_s = get_row_data('status','lead_int_status',array('id' => $this->input->post('qf_status') ));
            if( empty( $new_lead_status_s->status ) ){ $new_l_status_s = ""; }else{ $new_l_status_s = $new_lead_status_s->status ; }
                if( ($get_lead_s != $new_l_status_s) || ($get_lead_s == "" && $new_l_status_s != "") || ($get_lead_s != "" && $new_l_status_s == "") ) {
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_s,$new_l_status_s,'Update Lead Presentation Status','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    log_message('error',serialize($post_data2));
            }
            if( isset($post_marge)  ){ 
                $qualifieddata = $post_marge; 
            }else{ 
                $qualifieddata = $post_data; 
            }
            $get_lead_data = get_row_data('*','leads',array('id' => $id ));
            if( !empty( $get_lead_data->lead_status )){
                $get_lead_status = get_row_data('status','status_lead',array('id' => $get_lead_data->lead_status ));
                $get_lead = $get_lead_status->status; 
            }else{
                $get_lead = "";
            }
            $new_lead_status = get_row_data('status','status_lead',array('id' => $post_data['lead_status'] ));
            if( empty( $new_lead_status->status ) ){ $new_l_status = ""; }else{ $new_l_status = $new_lead_status->status ; }
            if( ($get_lead != $new_l_status) || ($get_lead == "" && $new_l_status != "") || ($get_lead != "" && $new_l_status == "")  ){
                $db_activity_id = log_activity('lead_activity',$id,$get_lead,$new_l_status,'Update Lead Presentation','activity_record');
                $post_data3 = array( 'activity_id' => $db_activity_id );
            }else{
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status = "",$new_lead_status ="",'Update Lead Presentation Profile','activity_record');
                $post_data3 = array( 'activity_id' => $db_activity_id );
            }
            $post_adding = array_merge( $post_data, $post_data3 );
            log_message('error',serialize($post_adding));
            App::update('leads',$match,$qualifieddata);
            $post_data['success'] = array();
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Presentation Lead has been Update successfully');
            if($lead_status == lead_Presentation_Lead ){
                redirect('/crm/Presentation/dashboard/'.$id);
            }else if ($lead_status == lead_Quote_Proactive_In_Design ){
                redirect('/crm/Qualified/dashboard/'.$id);
            }else if ($lead_status == lead_Contacted_Paperwork_Pending ){
                redirect('/crm/PWleads/dashboard/'.$id);
            }else if ($lead_status == lead_Lost_sale ){
                redirect('/crm/leads/dashboard/'.$id);
            }
        }
        $data = array();
        $data['leads'] = (array) App::get_row_by_where('leads', array( 'id' => $id ) );
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        $data['pw_data'] = (array) App::get_row_by_where('pw_pending_w', array('id'=>$id) ); 
        $KFileId = array('lead_file_type' => 'kit 1', 'field_id' => $id );
        $query = $this->db->select('*')->from('files')->where($KFileId)->order_by("created", "desc")->limit(3)->get();
        $data['KitFilesF'] =  $query->result_array();
        //lead status
        $data['lead_statuss'] = $this->crm_model->custom_query("SELECT * FROM status_lead WHERE id IN ( ".lead_Contacted_Paperwork_Pending.", ".lead_Quote_Proactive_In_Design.", ".lead_Lost_sale.", ".lead_Presentation_Lead." )",false,'array');
        //internal status
        $data['int_lead_status'] = $this->crm_model->custom_query("SELECT * FROM lead_int_status WHERE id IN (  ".int_lead_Revision_Required.", ".int_lead_Sent_to_Customer.", ".int_lead_Final_Paperwork.",".int_lead_Appointment_Pending." )",false,'array');
        $this->template->title('Edit Leads');
        $this->template
                ->set_layout('inner')
                ->build('Presentation/edit', $data);
    }/* End function index*/

    /*
    * Funtionality : Lead getPresentation listing  
    * Call From : getPresentation
    */
    public function getPresentation() {
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                        'lid',
                        'first_name',
                        'last_name',
                        'p.name',
                        'qf_designAssigned',
                        'qf_datestarted',
                        'qf_dateRecieved', 
                        'qf_dateCompleted',
                        'qf_designAssigned',
                        'qf_dateAdded',
                        'hoteness',
                        12=>'qf_dateSent'
                    );
        $vendor_id = $this->session->userdata('vendor_id');
        // getting total number records without any search
        $sql = "SELECT l.*, l.id as lid,  CONCAT(l.first_name,' ', l.last_name) as fullname,l.qf_dateRecieved,l.qf_designAssigned,l.qf_datestarted,p.name as nsowner, pw.*, s.status AS int_status  ";
        $sql.=" FROM leads l left join user_profiles p on l.assigned_to =p.user_id left join pw_pending_w pw ON pw.lead_id = l.id left join lead_int_status s on l.qf_status = s.id WHERE vendor_id = $vendor_id AND  l.lead_status ='".lead_Presentation_Lead."' ";
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
        if ( is_array( $total_record ) && !empty( $total_record ) ) { 
            foreach ($total_record as $row) {
                if( !empty($row['nsowner'])){ $leadsName = $row['nsowner']; }else{ $leadsName = 'N/A'; }
                if( !empty($row['hoteness'])){ $hotee = $row['hoteness']; }else{ $hotee = 'N/A'; }
                if( !empty($row['qf_datestarted'])){ 
                    $datestarted = crm_date($row['qf_datestarted']);
                }else{ $datestarted = 'N/A'; }
                if( !empty( $row['int_status'] ) ){ $Qstatus = $row['int_status'];  } else { $Qstatus = 'Qualified'; }
                if( !empty( $row["qf_dateRecieved"] ) ){ 
                        $Recieved = crm_date($row["qf_dateRecieved"]);
                }else{ $Recieved = 'N/A'; }
                if( !empty( $row["qf_dateCompleted"] ) ){ 
                    $Completed = crm_date($row["qf_dateCompleted"]); 
                      } else { $Completed = 'N/A'; }
                if( !empty( $row["qf_dateSent"] ) ){ $send = crm_date($row["qf_dateSent"]);  } else { $send = 'N/A'; }
                if( !empty( $row["qf_designAssigned"] ) ){ $designAssigned = $row["qf_designAssigned"];  } else { $designAssigned = 'N/A'; }
                if(!empty($row["qf_dateAdded"])){ $qfnewDate = crm_date($row["qf_dateAdded"]); }else{ $qfnewDate="N/A"; }
                if(!empty($row["qf_dateCompleted"])  ) {
                    $date1=date_create($row["qf_dateAdded"]);
                    $date2=date_create($row['qf_dateCompleted']);
                    $diff=date_diff($date1,$date2);
                    $Quee= $diff->format("%R%a days");
                }else{
                   $Quee= 'N/A';
                }
                $html = '';
                $html .=  '<a href="'.base_url().'crm/Presentation/edit/'. $row["lid"].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                $html .=  '<a href="'.base_url().'crm/Presentation/Dashboard/'.$row['lid'].'" title="Dashboard" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                $surveyQus = $this->crm_model->findWhere('survey_answers', array('lead_id' => $row['id']), true, array('answer') );
                $sum = 0;
                foreach ($surveyQus as $value ) {
                    $point = 0;
                    $surveypoint = $this->crm_model->findWhere( $table = 'survey_qoptions', $where_data = array('id' => $value['answer']), $multi_record = true, $select = array('point') );
                    if( isset($surveypoint[0]['point']) ){
                        $point = $surveypoint[0]['point'];
                        $sum += $point;
                    }
                }
               
                if($row["qf_status"]!=int_lead_Revision_Required){
                    $data[] = array(
                                $row["lid"], 
                                '<a href="'.base_url().'crm/Presentation/dashboard/'.$row['lid'].'" >'.$row["fullname"].'</a>',
                                $Qstatus, 
                                $leadsName,
                                $designAssigned,
                                $sum,
                                $hotee,
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
                              "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                              "recordsTotal"    => intval( $totalData ),  // total number of records
                              "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                              "data"            => $data   // total data array
                              );

            echo json_encode($json_data);  // send data as json format
    }/* End function index*/

    /*
    * Funtionality : PLead KitchenDetail add  
    * Call From : KitchenDetail
    */ 
	public function KitchenDetail() {
        $id = $this->uri->segment(4);
        $Pwdata = (array) App::get_row_by_where('pw_pending_w', array('lead_id' => $id) );
        if ( empty($Pwdata) ) {    
	        $post_data = array(
                            'lead_id'          	             => $id,
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
                            'refrigerator_width'              => '',
                            'refrigerator_depth'              => '',
                            'applicance_other'                => '',
                            'crown_molding'                   => '',
                            'crown_molding_touch_ceiling'     => '',
                            'light_rail'                      => '',
                            'cabinet_wall_height'             => '',
                            'option_request'                  => '',
                            'ceiling_height'                  => '',
                            'soffit'                          => '',
                            'soffit_yes_keeping'              => '',
                            'walls_be_moved'                  => '',
                            'doors_be_moved'                  => '',
                            'plumbing_be_moved'               => '',
                            'range_location_be_moved'         => '',
                            'refrigerator_location_be_moved'  => '',
                            'prequalified'                      => '',
                            'notes'                            => '',
                            'preamount'                        => '' 
            			); 
			App::save_data( 'pw_pending_w', $post_data );
        }else{
            if (isset($_POST)) { 
	            if ($this->input->post('lead_id')) {
                    if( !empty( $this->input->post('option_request') ) ){
	                            $option_request = implode(", ",$this->input->post('option_request'));
	                }else{ $option_request='';  }
                    $match = array( 'lead_id' => $this->input->post('lead_id') );
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
                            'refrigerator_width'              => $this->input->post('refrigerator_width'),
                            'refrigerator_depth'              => $this->input->post('refrigerator_depth'),
                            'applicance_other'                => $this->input->post('applicance_other'),
                            'crown_molding'                   => $this->input->post('crown_molding'),
                            'crown_molding_touch_ceiling'     => $this->input->post('crown_molding_touch_ceiling'),
                            'light_rail'                      => $this->input->post('light_rail'),
                            'cabinet_wall_height'             => $this->input->post('cabinet_wall_height'),
                            'option_request'                  => $option_request,
                            'ceiling_height'                  => $this->input->post('ceiling_height'),
                            'soffit'                          => $this->input->post('soffit'),
                            'soffit_yes_keeping'              => $this->input->post('soffit_yes_keeping'),
                            'walls_be_moved'                  => $this->input->post('walls_be_moved'),
                            'doors_be_moved'                  => $this->input->post('doors_be_moved'),
                            'plumbing_be_moved'               => $this->input->post('plumbing_be_moved'),
                            'range_location_be_moved'         => $this->input->post('range_location_be_moved'),
                            'refrigerator_location_be_moved'  => $this->input->post('refrigerator_location_be_moved'),
                             'prequalified'                     => $this->input->post('prequalified'),
                            'kitchen_note'                            => $this->input->post('kitchen_note'),
                            'preamount'                        => $this->input->post('preamount')
                                    
			           	);
			        $activaty = array( 
                        'user_id'  => $this->tank_auth->get_user_id(),
                        'module'   => 'leads',
                        'field_id' => $this->input->post('lead_id'),
                        'activity' => 'Create Kitchan Details Presentation : Leads '
                    );
                    $db_activity_id = log_activity(
                        'lead_activity',
                        $id,
                        $get_lead_status = "",
                        $new_lead_status = "",
                        'Add Kitchen Details From Presentation',
                        'activity_record'
                    );
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $activaty, $post_data2 );
                    log_message('error',serialize($post_adding));
                    App::update('pw_pending_w',$match,$post_data);
                    $post_data['success'] = array();
                    $this->session->set_flashdata('response_status','success'); 
                    $this->session->set_flashdata('message','Presentation Kitchen Details Update successfully');
                    redirect('/crm/Presentation/KitchenDetail/'.$id);
                }
	        }
	    }
        $data = array();
            if(!empty($id)) {
                $data['pw_pending'] = $this->crm_model->findWhere('pw_pending_w', array('lead_id' => $id ), array('*') );
            }else{
                $data['pw_pending'] = '';
            }
        $this->template->title('Lead Kitchen Details');
        $this->template
              ->set_layout('inner')
              ->build('crm/Presentation/PresentationLeads/PresentationForm', $data);

    }/* End function kittchen*/

    /*
    * Funtionality : PLead files listng  
    * Call From : files
    */ 
    public function files(){
        $id = $this->uri->segment(4);
        $data = array();
        $data['file_data'] = $this->crm_model->findWhere('files', array('field_id' => $id ), array('*') );
        //print_r( $data );
        $this->template->title('File');
        $this->template
              ->set_layout('inner')
              ->build('Presentation/PresentationLeads/file', $data);
    }/* End function files*/

    /*
    * Funtionality : Lead add_file add  
    * Call From : add_file
    */ 
    public function add_file(){
        $id =  $this->uri->segment(4);
        $data = array();
        $config = array(
            'upload_path'   => "assets/leadsfiles",
            'allowed_types' => "*"
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('image_upload')) {
            $error = array('error' => $this->upload->display_errors());
        }else{
            if (!empty($this->input->post() ) ) {
                $query = $this->crm_model->select_where('first_name','leads',array('id' => $this->input->post('leads_id') ));
                $data = array( 
                            'field_id'       => $this->input->post('leads_id'),
                            'module_name'    => 'leads', 
                            'file_name'      => $this->upload->data('file_name'),
                            'title'          => $this->input->post('title'),
                             'deck_one'      => $this->input->post('deck_one'),
                            'deck_two'       => $this->input->post('deck_two'),
                            'deck_three'     => $this->input->post('deck_three'),
                            'lead_file_type' => $this->input->post('lead_file_type'),
                            'path'           => $this->upload->data('file_path'),
                            'ext'            => $this->upload->data('file_ext'),
                            'size'           => $this->upload->data('file_size'),
                            'is_image'       => $this->upload->data('is_image'),
                            'description'    => $this->input->post('description'),
                            'created_by'     => $this->tank_auth->get_user_id()
                        );
                if( !$lead_id = App::save_data( 'files', $data )  ){
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'File didn\'t save, Try again!');
                }else{
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add File From Presentation ','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $data, $post_data2 );
                    log_message('error',serialize($post_adding));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'File added successfully');
                }
                redirect('crm/Presentation/files/'.$id);
            }
        }
        $this->load->view('Presentation/modal/add_file',$id);
    }/* End function add_file*/

    /*
    * Funtionality : PLead notes add  
    * Call From : add_file
    */ 
    public function notes($id) {   
        $data = array();
        $data['leads'] = (array) App::get_row_by_where('leads', array('id' => $id) );
        $result = $this->db->select('*')->from('status_lead')->get();
        $data['lead_statuss'] = $result->result('array'); 
        $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
        $data['users'] = $userQuery->result('array');
        if ( $this->input->post('lead_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('lead_id');
            $match = array ('id' => $this->input->post('lead_id') );
            $data = array( 'note'  => $this->input->post('note') );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Note has been updated');
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Note From Presentation ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));
            App::update('leads',$match,$data);
            redirect('crm/Presentation/notes/'.$this->input->post('lead_id')); 
        }
        $this->template->title('Leads');
        $this->template
            ->set_layout('inner')
            ->build('Presentation/PresentationLeads/notes', $data);
    }/* End function notes*/

    /*
    * Funtionality : Lead chats listing  
    * Call From : chats
    */ 
    public function chats($id) {
        $id = $this->uri->segment(4);
        $data['live_chats'] = (array) App::get_by_where('live_chat', array('lead_id' => $id));
        $this->template->title('Chat');
        $this->template
              ->set_layout('inner')
              ->build('Presentation/PresentationLeads/livechat', $data);
      
      }/* End function chats*/

    /*
    * Funtionality : PLead chat_record view  
    * Call From : chat_record
    */  
    public function chat_record(){
        $id = $this->uri->segment(4);
        $data['leads'] = (array) App::get_row_by_where('live_chat', array('id' => $id) );
        $this->load->view('Presentation/modal/chat_record', $data);
    }/* End function chat_record*/

    /*
    * Funtionality : PLead survey  add   
    * Call From : survey
    */  
    public function survey($id) {
        $data = array();
        $data['lead_id'] = $id;
        $sql = "SELECT * FROM survey_questions WHERE 1=1 ";
        $totalQuestions = $this->crm_model->custom_query($sql,false,'array');
        foreach ($totalQuestions as $key) {
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
                foreach ($_POST as $qKey => $qVal) {
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
                    'activity'=> 'Presentation  Survey  : Add'
                );
                $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Survey From Qualified ','activity_record');
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize($post_adding));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message','Presentation Survey has been Added');
                redirect('crm/Presentation/survey/'.$id); 
            }else{
                $saveQ = array();
                foreach ($_POST as $qKey => $qVal) {
                    $qID = explode('_',$qKey)[1];
                    $match = array ( 'lead_id' => $lead_id,'question_id' => $qID );
                    $saveQ = array(
                                'answer' => $qVal, 
                    );    
                    App::update('survey_answers',$match,$saveQ);
                }
                $activaty = array( 
                    'user_id' => $this->tank_auth->get_user_id(),
                    'module'  => 'leads',
                    'field_id' =>$match['lead_id'],
                    'activity'=> 'Presentation  Survey  : Edit'
                );
                $db_activity_id = log_activity(
                    'lead_activity',
                    $id,$get_lead_status = "",
                    $new_lead_status = "",
                    'Add Survey From Qualified',
                    'activity_record'
                );
                $post_data2 = array( 'activity_id' => $db_activity_id );
                $post_adding = array_merge( $activaty, $post_data2 );
                log_message('error',serialize($post_adding));
                $this->session->set_flashdata('response_status','success'); 
                $this->session->set_flashdata('message',' Presentation Survey has been Updated');
                redirect('crm/Presentation/survey/'.$id);     
             }  
        }
        $this->template->title( 'survey' );
        $this->template
            ->set_layout( 'inner' )
            ->build( 'Presentation/PresentationLeads/survey', $data ); 
    }/* End function survey*/

    /*
    * Funtionality : PLead add_task  add   
    * Call From : add_task
    */  
    public function add_task() {
       if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $id = $this->uri->segment(4);
                foreach ( $_POST['task'] as $key => $value ) {
                    $post_data = array(
                        'task_desc'		=> $value['task_desc'],
                        'assigned_team'	 => $value['assigned_team'],
                        'vendor_id'     => $this->session->userdata('vendor_id'),
                        'created'		=> date('Y-m-d H:i:s'),
                        'created_by'     =>$this->session->userdata('user_id'),
                        'status'        => 'Pending',
                        'lead_id'		=> $value['lead_id']
                    );
                    if(!empty($value['task_title'])){
                        $post_data['task_title'] = $value['task_title'];
                    }
                    if(!empty($value['deadline_date']) ){
                        $post_data['deadline_date'] = crm_dateTime($value['deadline_date']);
                    }
                    if(!empty($value['task_title']) || $value['task_desc'] ) {
                        $db_activity_id = log_activity('lead_activity',
                            $id,
                            $get_lead_status = "",
                            $new_lead_status="",
                            'Add Task From Presentation ',
                            'activity_record'
                        );
                        $post_data2 = array( 'activity_id' => $db_activity_id );
                        log_message('error',serialize($post_data2));
                        $add= App::save_data( 'task', $post_data );
                    }
                }
                if (!empty($add)) {
                    $matchstatus = array (
                        'id' => $id,
                    );
                    $datastaus = array (
                        'qf_status' => int_lead_Revision_Required,
                    );
                    App::update('leads',$matchstatus,$datastaus);
                    $ldata = (array) App::get_row_by_where('leads', array('id' => $id) );
                    $firstname = $ldata['first_name'];
                    $lastname = $ldata['last_name'];
                    $ur = base_url('crm/leads/dashboard/'.$id);
                    $PST = get_row_data(array('email'),'assign_team', array('code' => 'PST') )->email;
                    $emailVar['_emailto'] = $PST;
                    $emailVar['{name}'] = $firstname.' '.$lastname;
                    $emailVar['{lead_url}'] = $ur;
                    send_email('task_created', $emailVar);
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Task has Been  add successfully');
                    redirect('crm/Presentation/edit/'.$id);
                }else{	
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Task didn\'t save, Try again!');
                    redirect('crm/Presentation/edit/'.$id);
                }
            }
        }	
            $data = array();
            $result = $this->db->select('*')->from('assign_team')->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $this->load->view('Presentation/modal/add_task', $data);
	}/* End function add_task*/

    /*
    * Funtionality : PLead add_hold_desgin  add   
    * Call From : add_hold_desgin
    */  
	public function add_hold_desgin(){
	    if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
    		redirect('/auth/login/');
    	}else{
    		if ( $this->input->post() ) {
                $id = $this->input->post('lead_id');
                $holdData = App::get_row_by_where('hold_on_desgin', array('lead_id' => $id) );
                if (!empty($holdData)) {
                    $hdID = $holdData->id;       
                }else{
                    $hdID = '0';  
                }
                if($hdID != $this->input->post('id') ) {
                    $timestamp = strtotime($this->input->post('hold_next_step_date')); 
                    $new_date = date('Y-m-d', $timestamp);
                    $curr_time = date('h:i:sa');
                    $post_data = array(
                                    'hold_reason'	        => $this->input->post('hold_reason'),
                                    'hold_next_step_date'	=> $new_date.' '.$curr_time,
                                    'hold_next_step'	 	=> $this->input->post('hold_next_step'),
                                    'hold_owner'            => $this->input->post('hold_owner'),
                                    'lead_id'	          	=> $id
                                );
                    if( !$department_id = App::save_data( 'hold_on_desgin', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Task didn\'t save, Try again!');
                    redirect('crm/Presentation/edit/'.$id);
                    }else{	
                        $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Task From Presentation ','activity_record');
                        $post_data2 = array( 'activity_id' => $db_activity_id );
                        $post_adding = array_merge( $post_data, $post_data2 );
                        log_message('error',serialize($post_adding));
                        $this->session->set_flashdata('response_status', 'success');
                        $this->session->set_flashdata('message', 'Hold on desgin has Been add successfully');
                        redirect('crm/Presentation/edit/'.$id);
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
                    App::update('hold_on_desgin',$match,$pdata); 
                    $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Add Task From Presentation ','activity_record');
                    $post_data2 = array( 'activity_id' => $db_activity_id );
                    $post_adding = array_merge( $post_data, $post_data2 );
                    log_message('error',serialize($post_adding));
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Hold on desgin has Been  add successfully');
                    redirect('crm/Presentation/edit/'.$id);
                }
            }
    	}
        $id = $this->uri->segment(4);
        $data['hold'] = App::get_row_by_where('hold_on_desgin', array('lead_id' => $id) );
        $this->load->view('Presentation/modal/add_hold_design', $data);
    }/* End function add_hold_desgin*/

    /*
    * Funtionality : PLead gettime  add   
    * Call From : gettime
    */ 
	public function gettime() {
        $sql = "select * from leads where qc_start_date >= DATE_SUB(NOW(),INTERVAL 2 HOUR)";
        $result = $this->crm_model->custom_query($sql,false,'array'); 
        
	}/* End function getting */
	
   /*
    * Funtionality : edit_task
    */
    public function edit_task($id) {
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
                send_email('task_created', $emailVar);
            }
            $match = array ('id' => $this->input->post('task_id') );
            $data = array(
                        'task_title'    => $this->input->post('task_title'),
                        'task_desc'     => $this->input->post('task_desc'),
                        'assigned_team' => $this->input->post('assigned_team'),
                        'status'        => $this->input->post('status')
                    );
            $db_activity_id = log_activity('lead_activity',$id,$get_lead_status="",$new_lead_status="",'Edit  Task Presentation ','activity_record');
            $post_data2 = array( 'activity_id' => $db_activity_id );
            $post_adding = array_merge( $data, $post_data2 );
            log_message('error',serialize($post_adding));
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Task has been updated successfully'); 
            App::update('task',$match,$data);
            redirect('crm/Presentation/get_task/'.$lead_id);   
        }else{
            $result = $this->db->select('*')->from('assign_team')->get();
            $data['lead_statuss'] = $result->result('array'); 
            $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.id', 'FULL OUTER JOIN')->get();
            $data['users'] = $userQuery->result('array');
            $data['task'] = (array) App::get_row_by_where('task', array('id' => $id) );
            $this->load->view('Presentation/modal/edit_task', $data);
        }
    }/* End function Edit Task*/	

	/*
    * Funtionality : get_task listing task
    */
    public function get_task(){
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
            ->build('Presentation/PresentationLeads/taskget', $data);   
        
    }/* End function get_task*/
    
    /*
    * Funtionality : delete task
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
    }/* End function add_hold_desgin*/

   
    
    public function get_revision_data() {
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                        'lid',
                        'first_name',
                        'last_name',
                        'p.name',
                        'qf_designAssigned',
                        'qf_datestarted',
                        'qf_dateRecieved', 
                        'qf_dateCompleted',
                        'qf_designAssigned',
                        'qf_dateAdded',
                        'hoteness',
                        12=>'qf_dateSent'
                    );
        $vendor_id = $this->session->userdata('vendor_id');
        // getting total number records without any search
        $sql = "SELECT l.*, l.id as lid,  CONCAT(l.first_name,' ', l.last_name) as fullname,l.qf_dateRecieved,l.qf_designAssigned,l.qf_datestarted,p.name as nsowner, pw.*, s.status AS int_status  ";
        $sql.=" FROM leads l left join user_profiles p on l.assigned_to =p.user_id left join pw_pending_w pw ON pw.lead_id = l.id left join lead_int_status s on l.qf_status = s.id WHERE vendor_id = $vendor_id AND  l.lead_status ='".lead_Presentation_Lead."' AND l.qf_status='".int_lead_Revision_Required."' ";
        $totalData = $this->crm_model->custom_query($sql,false,'array');
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
        if ( is_array( $total_record ) && !empty( $total_record ) ) { 
            foreach ($total_record as $row) {
                if( !empty($row['nsowner'])){ $leadsName = $row['nsowner']; }else{ $leadsName = 'N/A'; }
                if( !empty($row['hoteness'])){ $hotee = $row['hoteness']; }else{ $hotee = 'N/A'; }
                if( !empty($row['qf_datestarted'])){ 
                    $datestarted = crm_date($row['qf_datestarted']);
                }else{ $datestarted = 'N/A'; }
                if( !empty( $row['int_status'] ) ){ $Qstatus = $row['int_status'];  } else { $Qstatus = 'Qualified'; }
                if( !empty( $row["qf_dateRecieved"] ) ){ 
                        $Recieved = crm_date($row["qf_dateRecieved"]);
                }else{ $Recieved = 'N/A'; }
                if( !empty( $row["qf_dateCompleted"] ) ){ 
                    $Completed = crm_date($row["qf_dateCompleted"]); 
                      } else { $Completed = 'N/A'; }
                if( !empty( $row["qf_dateSent"] ) ){ $send = crm_date($row["qf_dateSent"]);  } else { $send = 'N/A'; }
                if( !empty( $row["qf_designAssigned"] ) ){ $designAssigned = $row["qf_designAssigned"];  } else { $designAssigned = 'N/A'; }
                if(!empty($row["qf_dateAdded"])){ $qfnewDate = crm_date($row["qf_dateAdded"]); }else{ $qfnewDate="N/A"; }
                if(!empty($row["qf_dateCompleted"])  ) {
                    $date1=date_create($row["qf_dateAdded"]);
                    $date2=date_create($row['qf_dateCompleted']);
                    $diff=date_diff($date1,$date2);
                    $Quee= $diff->format("%R%a days");
                }else{
                   $Quee= 'N/A';
                }
                $html = '';
                $html .=  '<a href="'.base_url().'crm/Presentation/edit/'. $row["lid"].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                $html .=  '<a href="'.base_url().'crm/Presentation/Dashboard/'.$row['lid'].'" title="Dashboard" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>';
                $surveyQus = $this->crm_model->findWhere('survey_answers', array('lead_id' => $row['id']), true, array('answer') );
                $sum = 0;
                foreach ($surveyQus as $value ) {
                    $point = 0;
                    $surveypoint = $this->crm_model->findWhere( $table = 'survey_qoptions', $where_data = array('id' => $value['answer']), $multi_record = true, $select = array('point') );
                    if( isset($surveypoint[0]['point']) ){
                        $point = $surveypoint[0]['point'];
                        $sum += $point;
                    }
                }
                $data[] = array(
                            $row["lid"], 
                            '<a href="'.base_url().'crm/Presentation/dashboard/'.$row['lid'].'" >'.$row["fullname"].'</a>',
                            $Qstatus, 
                            $leadsName,
                            $designAssigned,
                            $sum,
                            $hotee,
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
                              "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                              "recordsTotal"    => intval( $totalData ),  // total number of records
                              "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                              "data"            => $data   // total data array
                              );

            echo json_encode($json_data);  // send data as json format
    }/* End function get_revision*/
    
    public function get_revision(){
        
        $data = array();
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->template->title('Presentation');
        $this->template
            ->set_layout( 'inner' )
            ->build( 'Presentation/revision_lead', $data);    
    }
    
     /*
    * Funtionality : load jss
    */
    public function load_script() {
        $data = array();
        $this->load->view('Presentation/load_script', $data);
    }/* End function load_script*/

    /*
    * Funtionality :  load Css
    */
    public function load_css(){
        $data = array();
        $this->load->view('Presentation/load_css', $data);
    }/* End function load_css*/
    
    

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */