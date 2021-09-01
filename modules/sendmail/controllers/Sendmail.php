<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

// https://www.formget.com/codeigniter-gmail-smtp/
class Sendmail extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
	    $this->load->library('email');
	}
    public function index() {
        $smtp = $this->config->item('smtp');
        pr($smtp);
    }

	public function dynamic_email () {
	    $eData = array(
	        '_emailto' => 'webbninja2@gmail.com',
	        '{name}' => 'Webb Ninja',
	        '{website}' => 'https://perfectionkitchens.com/crm',
        );
	    echo send_email('welcome',$eData);
	    
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */