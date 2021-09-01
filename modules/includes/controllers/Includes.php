<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Includes extends MX_Controller {
        function __construct() {
    		parent::__construct();
        }
    	public function topbar_menu() {
            $this->load->view('topbar_menu',isset($data) ? $data : NULL);
    	}
    	public function collaborator_menu() {
    		$data['languages'] = App::languages();
    		$this->load->view('collaborator_menu',isset($data) ? $data : NULL);
    	}
    	public function leftside_menu() { 
    		$this->load->view('leftside_menu',isset($data) ? $data : NULL);
    	}
        public function lead_sub_menu() { 
    		$this->load->view('lead_sub_menu',isset($data) ? $data : NULL);
    	}
        public function customer_submenu() { 
    		$this->load->view('customer_submenu',isset($data) ? $data : NULL);
    	}
    	public function PwLeads_sub_menu() { 
    		$this->load->view('PWleads_sub_menu',isset($data) ? $data : NULL);
    	}
    	public function Qualified_sub_menu()
    	{ 
    		$this->load->view('Qualified_sub_menu',isset($data) ? $data : NULL);
    	}
    	
    	public function Presentation_sub_menu() { 
    		$this->load->view('Presentation_sub_menu',isset($data) ? $data : NULL);
    	}
        public function MRLeads_sub_menu() { 
    		$this->load->view('mrleads_sub_menu',isset($data) ? $data : NULL);
    	}
    	public function order_sub_menu() { 
            $id1 = $this->uri->segment(3);
            $id2 = $this->uri->segment(4);
            
            if ( is_numeric($id1) ) { $id = $id1;
            }else{ $id = $id2; }

            $data['vendorId'] = $this->db->select('vendor')->from('pk_order')->where('id',$id)->get()->row_array();
            $data['orderID']  = $id;
    		$this->load->view('order_sub_menu',isset($data) ? $data : NULL);
    	}
        public function faborder_sub_menu() {
            $this->load->view('faborder_sub_menu');
        }
        public function footer() {
    		$this->load->view('footer',isset($data) ? $data : NULL);
    	}
        public function rightside_menu() { 
    		$this->load->view('rightside_menu',isset($data) ? $data : NULL);
    	}
        public function scripts() {
    		$this->load->view('scripts/uni_scripts',isset($data) ? $data : NULL);
    	}
    	public function flash_msg() {
    		$this->load->view('flash_msg',isset($data) ? $data : NULL);
    	}
    	

    }
/* End of file sidebar.php */