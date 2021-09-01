<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Search extends MX_Controller
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
        $this->load->model('search_model');
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
        
        $search = $_GET['find'];
        if( empty( $search ) )
        {   
            redirect( $_SERVER['HTTP_REFERER'] );
        }
        $data['searchResult'] = $this->search_model->search( $search );
        $this->template->title("Searching For {$search}");
        $this->template
                ->set_layout('inner')
                ->build('search', $data);
       
    }/* end function index */
    
    public function search_result(){
        $search = $_POST['inputVal'];
        if( !empty( $search ) )
        {   
	        
	        $option = "<ul class='list-group search_ul'>";

	        if($search){
	            
	            $data = $this->search_model->search( $search );
	            foreach( $data as $key => $value ){
	                
	                if ( $value ) {
	                	$option.= "<li class='list-group-item option_group_li'>".$key." </li>";
	                }
	                	                
	                if( $key == 'leads' ){
	                    $corePath = 'crm/leads';
	                }else{
	                    $corePath = $key;
	                }
	                
	                foreach( $value as $valuekey => $valuename  ){
	                    if( $key == 'orders' ){
	                        $displayName = '<b>#'.$valuename->id.'</b> - '.$valuename->full_name;
	                    }else{
	                        $displayName = $valuename->full_name." - ".$valuename->email;
	                    }

	                    
	                    	$option.=  "<li class='list-group-item'><a href='".base_url().$corePath."/dashboard/".$valuename->id."'>".$displayName."</a><li>";

	                }
	            }
	            
	        }
	        $option.= "</ul>";

	        echo $option; 
        
    	}

    }


}

/* End of file Search */