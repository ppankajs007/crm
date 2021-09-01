<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MX_Controller {
function __construct() {
		parent::__construct();
    if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
        $this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
	}
    public function index()
	{
		$this->load->view('index');
	}
}
