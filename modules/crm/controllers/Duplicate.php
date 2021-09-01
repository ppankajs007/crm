<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class Duplicate extends MX_Controller
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
    * Funtionality : listig leads
    * Call From : index 
    */ 
	public function index()
	{ 	
		if (!$this->tank_auth->is_logged_in()) { // logged in
			redirect('auth/login');
		}
        $data = array();
        $data['Select_status'] = $this->crm_model->fetch_all('status_lead');
        $data['SelectAssign'] = $this->crm_model->fetch_all('user_profiles');
        $this->load->view('auth/index', $data);
        $this->template->title(' Leads');
        $this->template->set_layout('inner')->build('dupicate_lead', $data);
	}/* end function */
	
	/*
    * Funtionality : use js
    * Call From : load_script
    */
    public function load_script() {
        $data = array();
        $this->load->view('Duplicate/load_script', $data);
    }/* end function  load_script*/

    /*
    * Funtionality : use css
    * Call From : load_css
    */
    public function load_css() {
        $data = array();
        $this->load->view('Duplicate/load_css', $data);
    }/* end function  load_css*/

    /*
    * Funtionality : listing duplicate lead
    * Call From : duplicate_lead 
    */
    public function duplicate_lead() {
        $vendor_id = $this->session->userdata('vendor_id');
        $data = array(); 
        $phData = $this->crm_model->custom_query("SELECT phone, COUNT(*) AS total from leads where vendor_id = '$vendor_id' group by phone HAVING total > 1 ",false,'array');
        $emData = $this->crm_model->custom_query("SELECT email, COUNT(*) as total FROM leads where vendor_id = '$vendor_id' GROUP BY email HAVING total > 1 ",false,'array');
        if( isset( $phData ) && !empty( $phData ) ) {
            foreach ($phData as $value){ 
                if($value['phone'] == '') continue;
                $clData = App::get_by_where('leads', array('phone'=>$value['phone']),array(),true );
                foreach ($clData as $tempVal) { 
                    $notINN[] = $tempVal['id']; 
                }
                $data['ldata'][$value['phone']] = $clData;
            }
        }
        $andC = '';
        if( isset($notINN) && is_array($notINN) && $notINN != ''){
            $notINN = implode(',',$notINN);
            $andC = " AND id NOT IN ($notINN)";
        }
        if( isset( $emData ) && !empty( $emData ) ) {    
            foreach ($emData as $value){  if($value['email'] == '') continue;
                $qRes = $this->crm_model->custom_query("SELECT * from leads where email = '".$value['email']."'".$andC,false,'array');
                if( $qRes != '') $data['ldata'][$value['email']] = $qRes; 
                }
        }
        $this->load->view('auth/index', $data);
        $this->template->title(' DLeads');
        $this->template->set_layout('inner')->build('Duplicate/duplicate_lead', $data);
    }/* end function duplicate lead */
    
    /*
    * Funtionality : use merge lead
    * Call From :  add_merge
    */
    public function add_merge() {
        $return = 'false';
        $pid    = $_POST['parentid'];
        $cid    = $_POST['selfid'];
        $Plead  = App::get_row_by_where('leads', array('id'=>$pid) );
        $Clead  = App::get_row_by_where('leads', array('id'=>$cid) );
        $Pphone = $Plead->phone;
        $Pemail = $Plead->email;
        $Cphone = $Clead->phone;
        $Cemail = $Clead->email;
        $pdata  = array(
                    'parent_lead'  => $pid,
                    'secondry_email' => $Pemail,
                    'secondry_phone' => $Pphone );
        $cdata  = array(
                    'secondry_email' => $Cemail,
                    'secondry_phone' => $Cphone );
        $scdata  = array(
                    'secondry_emailII' => $Cemail,
                    'secondry_phoneII' => $Cphone );

        $Tcdata  = array(
                    'secondry_emailIII' => $Cemail,
                    'secondry_phoneIII' => $Cphone );

        $Fcdata  = array(
                    'secondry_emailIV' => $Cemail,
                    'secondry_phoneIV' => $Cphone );

        if( App::update('leads',array ('id' => $cid ),$pdata)){
            $return = 'true';
        }else{ $return = 'false';  }

        
        $Pdata = $this->crm_model->findWhere('leads', array('id' => $pid ), array('*') );
        if ( empty($Pdata[0]['secondry_phone'])  ) {
   
            if(App::update('leads',array ('id' => $pid ),$cdata)){
                $return = 'true';
            }else{  $return = 'false';  }
                echo $return;
            
        }else if ( !empty($Pdata[0]['secondry_phone'] ) ) {

            if(App::update('leads',array ('id' => $pid ),$scdata)){
                $return = 'true';
            }else{  $return = 'false';  }
            echo $return;

        }else if ( !empty($Pdata[0]['secondry_phoneII'] ) ) {
            
            if(App::update('leads',array ('id' => $pid ),$Tcdata)){
                $return = 'true';
            }else{  $return = 'false';  }
            echo $return;
   
        }else if ( !empty($Pdata[0]['secondry_phoneIII'] ) ) {
            
            if(App::update('leads',array ('id' => $pid ),$Fcdata)){
                $return = 'true';
            }else{  $return = 'false';  }
            echo $return;
        
        }

    }/* end function add_merg */


}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
