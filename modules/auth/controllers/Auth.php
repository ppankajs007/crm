<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller
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
        $this->load->model('user_model');
	}

	public function index()
	{ 	
		if (!$this->tank_auth->is_logged_in()) {									// logged in
			redirect('auth/login');
		}
		$data = array();
        $vendor_id = $this->session->userdata('vendor_id');
        
	    $userQuery = $this->db->select('*')->from('users')->join('user_profiles', 'users.id = user_profiles.user_id', 'FULL OUTER JOIN')->where('users.vendor_id', $vendor_id)->get();
		$data['allUsersQuery'] = $userQuery->result('array');
	

		$data['current_user'] =$this->tank_auth->get_user_id();
		$this->load->view('auth/index', $data);
		$this->template->title(' Users');
        $this->template
                ->set_layout('inner')
                ->build('index',isset($allUsersQuery) ? $allUsersQuery : NULL);
	}

	/**
	 * Login user on the site
	 *
	 * @return void
	 */
	public function login()
	{
	    $vendor =  $this->uri->segment(3); 
	    if($vendor == 'atul'){
	       $vendor_id = 3; 
	    }else if($vendor == 'pankaj'){
	        $vendor_id = 12; 
	    }else if($vendor == 'jarnail'){
	        $vendor_id = 13; 
	    }else if($vendor == 'cpankaj'){
	        $vendor_id = 14; 
	    }else if($vendor == 'debug'){
	        $vendor_id = 15; 
	    }else if($vendor == 'mark'){
	        $vendor_id = 37; 
	    }else{
	        $vendor_id = 1;
	    }
	    if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} else {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));					
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$vendor_id,
						$data['login_by_username'],
						$data['login_by_email'])) {								// success
					redirect('dashboard');

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('/auth/send_again/');

					} else {													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				//$data['show_captcha'] = TRUE;
				$data['show_captcha'] = FALSE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					//$data['captcha_html'] = $this->_create_captcha();
				}
			}
			//$this->load->view('auth/auth/login_form', $data);
			$this->template->title(' Users');
	        $this->template
	                ->set_layout('login')
	                ->build('auth/auth/login_form',$data);
	                
		}
	}

	/**
	 * Logout user
	 *
	 * @return void
	 */
	function logout()
	{
		$this->tank_auth->logout();
		$this->session->set_userdata(array('twitter_id' => '', 'facebook_id' => ''));
		$this->_show_message($this->lang->line('auth_message_logged_out'));
	}

	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function register()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} elseif (!$this->config->item('allow_registration', 'tank_auth')) {	// registration is off
			$this->_show_message($this->lang->line('auth_message_registration_disabled'));

		} else {
			$use_username = $this->config->item('use_username', 'tank_auth');
			if ($use_username) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->config->item('username_min_length', 'tank_auth').']|max_length['.$this->config->item('username_max_length', 'tank_auth').']|alpha_dash');
			}
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');

			$captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
			$use_recaptcha		  = $this->config->item('use_recaptcha', 'tank_auth');
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				} else {
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
				}
			}
			$data['errors'] = array();

			$email_activation = $this->config->item('email_activation', 'tank_auth');

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->create_user(
						$use_username ? $this->form_validation->set_value('username') : '',
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password'),
						$email_activation))) {									// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					if ($email_activation) {									// send "activate" email
						$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

						$this->_send_email('activate', $data['email'], $data);

						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

					} else {
						if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

							$this->_send_email('welcome', $data['email'], $data);
						}
						unset($data['password']); // Clear password (just for any case)

						$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));
					}
				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			if ($captcha_registration) {
				if ($use_recaptcha) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
			$data['use_username'] = $use_username;
			$data['captcha_registration'] = $captcha_registration;
			$data['use_recaptcha'] = $use_recaptcha;
			$this->load->view('auth/auth/register_form', $data);
		}
	}



	/**
	 * Register user on the site
	 *
	 * @return void
	 */
	function registerUser()
	{
        $vendor_id = $this->session->userdata('vendor_id');
		$use_username = $this->config->item('use_username', 'tank_auth');		
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		$captcha_registration	= $this->config->item('captcha_registration', 'tank_auth');
		$use_recaptcha			= $this->config->item('use_recaptcha', 'tank_auth');
		if ($captcha_registration) {
			if ($use_recaptcha) {
				$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
			} else {
				$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
		}
		$data['errors'] = array();

		$email_activation = $this->config->item('email_activation', 'tank_auth');

		if ($this->form_validation->run()) {
			$this->session->set_flashdata('response_status','success'); 
			$name = $_POST['name'];
			if (!is_null($data = $this->tank_auth->create_user(
					$use_username ? $this->form_validation->set_value('username') : '',
					$name,
					$this->form_validation->set_value('email'),
					$this->form_validation->set_value('role'),
					$this->form_validation->set_value('department'),
					$this->form_validation->set_value('password'),
					$email_activation,
					$vendor_id))) { // success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				if ($email_activation) {									// send "activate" email
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					unset($data['password']); // Clear password (just for any case)

					$this->_show_message($this->lang->line('auth_message_registration_completed_1'));

				} else {
					if ($this->config->item('email_account_details', 'tank_auth')) {	// send "welcome" email

						$this->_send_email('welcome', $data['email'], $data);
					}
					unset($data['password']); // Clear password (just for any case)

					//$this->_show_message($this->lang->line('auth_message_registration_completed_2').' '.anchor('/auth/login/', 'Login'));

					$this->session->set_flashdata('response_status','success'); 
					$this->session->set_flashdata('message','User has been register successfully'); 
					redirect('auth/index');
				}

				$this->session->set_flashdata('response_status','success'); 
				$this->session->set_flashdata('message','User has been register successfully'); 
				redirect('auth/index');
			} else {
				$errors = $this->tank_auth->get_error_message();
				foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
			}
		}
		if ($captcha_registration) {
			if ($use_recaptcha) {
				$data['recaptcha_html'] = $this->_create_recaptcha();
			} else {
				$data['captcha_html'] = $this->_create_captcha();
			}
		}
		$data['use_username'] = $use_username;
		$data['captcha_registration'] = $captcha_registration;
		$data['use_recaptcha'] = $use_recaptcha;
		$data['roles'] = (array) App::get_by_where('roles', array('1' => 1 ));
		$data['depts'] = (array) App::get_by_where('department', array('1' => 1 ));
		$this->load->view('auth/auth/register_form', $data);
		
	}

	/**
	 * Send activation email again, to the same or new email address
	 *
	 * @return void
	 */
	function send_again()
	{
		if (!$this->tank_auth->is_logged_in(FALSE)) {							// not logged in or activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->change_email(
						$this->form_validation->set_value('email')))) {			// success

					$data['site_name']	= $this->config->item('website_name', 'tank_auth');
					$data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

					$this->_send_email('activate', $data['email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/auth/send_again_form', $data);
		}
	}

	/**
	 * Activate user account.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function activate()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Activate user
		if ($this->tank_auth->activate_user($user_id, $new_email_key)) {		// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_activation_completed').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_activation_failed'));
		}
	}

	/**
	 * Generate reset code (to change password) and send it to user
	 *
	 * @return void
	 */
	function forgot_password()
	{
		if ($this->tank_auth->is_logged_in()) {									// logged in
			redirect('');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} else {
			$this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->forgot_password(
						$this->form_validation->set_value('login')))) {

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with password activation link
					$this->_send_email('forgot_password', $data['email'], $data);

					$this->session->set_flashdata('response_status','success'); 
					$this->session->set_flashdata('message',$this->lang->line('auth_message_new_password_sent')); 
					redirect('/auth/login');

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->template->title(' Users');
	        $this->template
	                ->set_layout('login')
	                ->build('auth/auth/forgot_password_form',$data);
		}
	}

	/**
	 * Replace user password (forgotten) with a new one (set by user).
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_password()
	{
		$user_id		= $this->uri->segment(3);
		$new_pass_key	= $this->uri->segment(4);

		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
		$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

		$data['errors'] = array();

		if ($this->form_validation->run()) {								// validation ok
			if (!is_null($data = $this->tank_auth->reset_password(
					$user_id, $new_pass_key,
					$this->form_validation->set_value('new_password')))) {	// success

				$data['site_name'] = $this->config->item('website_name', 'tank_auth');

				// Send email with new password
				$this->_send_email('reset_password', $data['email'], $data);

				$this->_show_message($this->lang->line('auth_message_new_password_activated').' '.anchor('/auth/login/', 'Login'));

			} else {														// fail
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		} else {
			// Try to activate user by password key (if not activated yet)
			if ($this->config->item('email_activation', 'tank_auth')) {
				$this->tank_auth->activate_user($user_id, $new_pass_key, FALSE);
			}

			if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
				$this->_show_message($this->lang->line('auth_message_new_password_failed'));
			}
		}
		$this->load->view('auth/auth/reset_password_form', $data);
	}

	/**
	 * Change user password
	 *
	 * @return void
	 */
	function change_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/auth/change_password_form', $data);
		}
	}



	

	/**
	 * Change user email
	 *
	 * @return void
	 */
	function change_email()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if (!is_null($data = $this->tank_auth->set_new_email(
						$this->form_validation->set_value('email'),
						$this->form_validation->set_value('password')))) {			// success

					$data['site_name'] = $this->config->item('website_name', 'tank_auth');

					// Send email with new email address and its activation link
					$this->_send_email('change_email', $data['new_email'], $data);

					$this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));

				} else {
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/auth/change_email_form', $data);
		}
	}

	/**
	 * Replace user email with a new one.
	 * User is verified by user_id and authentication code in the URL.
	 * Can be called by clicking on link in mail.
	 *
	 * @return void
	 */
	function reset_email()
	{
		$user_id		= $this->uri->segment(3);
		$new_email_key	= $this->uri->segment(4);

		// Reset email
		if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) {	// success
			$this->tank_auth->logout();
			$this->_show_message($this->lang->line('auth_message_new_email_activated').' '.anchor('/auth/login/', 'Login'));

		} else {																// fail
			$this->_show_message($this->lang->line('auth_message_new_email_failed'));
		}
	}

	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function unregister()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->delete_user(
						$this->form_validation->set_value('password'))) {		// success
					$this->_show_message($this->lang->line('auth_message_unregistered'));

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			$this->load->view('auth/auth/unregister_form', $data);
		}
	}

	/**
	 * Show info message
	 *
	 * @param	string
	 * @return	void
	 */
	function _show_message($message)
	{
		$this->session->set_flashdata('message', $message);
		redirect('/auth/');
	}

	/**
	 * Send email message of given type (activate, forgot_password, etc.)
	 *
	 * @param	string
	 * @param	string
	 * @param	array
	 * @return	void
	 */
	function _send_email($type, $email, &$data)
	{
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));
		$this->email->set_alt_message($this->load->view('email/'.$type.'-txt', $data, TRUE));
		$this->email->send();
	}

	/**
	 * Create CAPTCHA image to verify user as a human
	 *
	 * @return	string
	 */
	function _create_captcha()
	{
		$this->load->helper('captcha');

		$cap = create_captcha(array(
			'img_path'		=> './'.$this->config->item('captcha_path', 'tank_auth'),
			'img_url'		=> base_url().$this->config->item('captcha_path', 'tank_auth'),
			'font_path'		=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
			'font_size'		=> $this->config->item('captcha_font_size', 'tank_auth'),
			'img_width'		=> $this->config->item('captcha_width', 'tank_auth'),
			'img_height'	=> $this->config->item('captcha_height', 'tank_auth'),
			'show_grid'		=> $this->config->item('captcha_grid', 'tank_auth'),
			'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
		));

		// Save captcha params in session
		$this->session->set_flashdata(array(
				'captcha_word' => $cap['word'],
				'captcha_time' => $cap['time'],
		));

		return $cap['image'];
	}

	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
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

    function demo()
    {
        $data = array();
        $this->load->view('demo', $data);
    }

    function email_validation_check(){
    	$email = $_POST['email'];

    	$this->db->from('users');
		$this->db->where('email', $email );
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
		{
			echo "true";
    	}
    }



    /**
	 * Change user password
	 * @author Parveen
	 * @return void
	 */
	function update_password()
	{
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|matches[new_password]');


			$data['errors'] = array();
			
			if ($this->form_validation->run()) {
			$user_id = $this->uri->segment(4, 0);
			if (is_null($user = $this->Users->get_user_by_id(encrypt_decrypt($user_id, 'd'), TRUE))) {
				$this->session->set_flashdata('response_status','error'); 
					$this->session->set_flashdata('message','Invalid key!'); 
					redirect('auth/index');
			}		
									// validation ok
			// echo $this->form_validation->set_value('new_password'); die;
				if ($this->tank_auth->update_password(
						$this->form_validation->set_value('new_password'),
						encrypt_decrypt($user_id, 'd')
						) ) {	// success
					$this->session->set_flashdata('response_status','success'); 
					$this->session->set_flashdata('message',$this->lang->line('auth_message_password_changed')); 
					redirect('auth/index');

				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					die('Server Error!');
				}
			}
			$this->load->view('auth/modal/update_password', $data);
		}
	}


	/**
	 * Delete user from the site (only when user is logged in)
	 *
	 * @return void
	 */
	function delete_user()
	{	
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {

			$data['errors'] = array();

			if ($this->tank_auth->delete_user( $user_id ) ) {		// success
				$this->_show_message($this->lang->line('auth_message_unregistered'));

			} else {														// fail
				
			}

		}
	}
	
	function Prdelete_user(){
	    if( isset($_POST['ids']) ){
	        $ids = $_POST['ids'];
	        $data['userDel'] = $this->user_model->Pkdelete_query($ids,'users');
	        if($data == TRUE){
                echo "TRUE";
            } else {
                echo "FALSE";
            }
	    }
	}
	function edit_user($id){
		
                  //print_r($_POST);
			if($this->input->post('id')){

				$user_id=$this->input->post('id');

				$data['success'] = array();

				$data = array(
				'role'      => $this->input->post('role'),
				'department'  => $this->input->post('department'),
				'last_login'  =>date('Y:m:d H:i:s')
				);

				
                $data1 = array(
				'name'  => $this->input->post('name')
			     );
			
				$this->db->where('id',$user_id);
				$this->db->update('users',$data);
				$this->db->where('id',$user_id);
				$this->db->update('user_profiles',$data1);


					        $this->session->set_flashdata('response_status','success'); 
                            $this->session->set_flashdata('message','User has been Update successfully');
					redirect('auth/index');
             }else{
                        $data['errors'] = array();
                        $this->session->set_flashdata('response_status','error'); 
                        $this->session->set_flashdata('message','User has been Not Update successfully');


             }
				
                $this->db->select('*');
				$this->db->from('users');
				$this->db->join('user_profiles', 'users.id = user_profiles.id');
				$this->db->where('users.id',$id);
				$query=$this->db->get();
				$data['users']=$query->row();
                $data['user_info'] = (array) App::get_row_by_where('users', array('id'=>$id) );
				$data['roles'] = (array) App::get_by_where('roles', array('1' => 1 ));
				$data['depts'] = (array) App::get_by_where('department', array('1' => 1 ));
                $this->load->view('auth/edit_user',$data);
	
	}

	function edit_user111($id){
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		if ( $this->input->post('lead_id') ) {
			$this->form_validation->set_rules('name', 'Username', 'required');
			// $this->form_validation->set_rules('password', 'Password', 'required');
			// $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('password', 'New Password', 'trim|required');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');         
			$data['errors'] = array();
			$this->session->set_flashdata('response_status','error'); 
			$this->session->set_flashdata('message','Confirm Password Not Match'); 
			$id = $this->input->post('lead_id');
			if($this->form_validation->run()){
	  			$data = array(
					'password'  => md5($this->input->post('password')),
					'role'      => $this->input->post('role'),
				    'last_login'  =>date('Y:m:d H:i:s')
				  );
	            $data1 = array(
					'name'  => $this->input->post('name')
					
				);
				
				$this->db->where('id',$id);
				$this->db->update('users',$data);
				$this->db->where('id',$id);
				$this->db->update('user_profiles',$data1);
				// App:: $db->where($match)->update('users',$data);
				// App:: $db->where($match)->update('user_profiles',$data1);
				$data['success'] = array();
				$this->session->set_flashdata('response_status','success'); 
				$this->session->set_flashdata('message','User has been Update successfully'); 
				redirect('auth/index');
			}else{
				$data['errors'] = array();
				$this->session->set_flashdata('response_status','error'); 
				$this->session->set_flashdata('message','error'); 
				redirect('auth/index');
                       
			}

		}else{
			//$data['users'] = (array) App::get_row_by_where('users', array('id'=>$id) );
			$this->db->select('*');
			$this->db->from('users');
			$this->db->join('user_profiles', 'users.id = user_profiles.id');
			$this->db->where('users.id', $id);
			$query=$this->db->get();
			$data['users']=$query->row();
			$this->load->view('auth/edit_user',$data);
			//$this->load->view('auth/modal/edit_user',$data);

 }

	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */