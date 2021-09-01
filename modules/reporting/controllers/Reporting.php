<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/fbapi/vendor/autoload.php';

class Reporting extends MX_Controller
{
	public $fb;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->module('layouts');
        $this->load->library('template');
        $this->load->model('Reporting_model');
        $this->load->model('user_model');
        $this->load->helper('file');

        // if (!$this->tank_auth->is_logged_in()) redirect('auth/login');  

        $this->fb = new \Facebook\Facebook([
		  'app_id' => '300068154224107', // Replace {app-id} with your app id
		  'app_secret' => 'e4cac8b0a10bab258d83f5670147c356',
		  'default_graph_version' => 'v5.0',
		]);
    }

    public function index()
    {   

    	$helper = $this->fb->getRedirectLoginHelper();
		$permissions = ['manage_pages','ads_read','ads_management']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('https://perfectionkitchens.com/crm/administrator/reporting/callback', $permissions);

		$data['loginUrl'] = $loginUrl;
		$data['fb_data'] = $graphNode;

        $data['campaign'] = [
	                [
	                    'name'      =>  "Labor Day Savings Sale",
	                    'y'         =>  100,
	                    'drilldown' =>  "Labor Day Savings Sale",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",9],
						                    ["2 January",6],
						                    ["3 January",8],
						                    ["4 January",5],
						                    ["5 January",5],
						                    ["6 January",7],
						                    ["7 January",1],
						                    ["8 January",6],
						                    ["9 January",8],
						                    ["10 January",2],
		                				]),
	                ],
	                [
	                    'name'      =>  "Store traffic",
	                    'y'         =>  98,
	                    'drilldown' =>  "Store traffic",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",6],
						                    ["2 January",9],
						                    ["3 January",2],
						                    ["4 January",4],
						                    ["5 January",5],
						                    ["6 January",7],
						                    ["7 January",9],
						                    ["8 January",6],
						                    ["9 January",9],
						                    ["10 January",7],
		                				]),

	                ],
	                [
	                    'name'      =>  "Summer Sale Toms River",
	                    'y'         =>  63,
	                    'drilldown' =>  "Summer Sale Toms River",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",6],
						                    ["2 January",5],
						                    ["3 January",7],
						                    ["4 January",5],
						                    ["5 January",8],
						                    ["6 January",7],
						                    ["7 January",1],
						                    ["8 January",8],
						                    ["9 January",3],
						                    ["10 January",7],
		                				]),

	                ],
	                [
	                    'name'      =>  "End of Quarter Clearance",
	                    'y'         =>  12,
	                    'drilldown' =>  "End of Quarter Clearance",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",2],
						                    ["2 January",6],
						                    ["3 January",9],
						                    ["4 January",5],
						                    ["5 January",7],
						                    ["6 January",7],
						                    ["7 January",9],
						                    ["8 January",6],
						                    ["9 January",8],
						                    ["10 January",3],
		                				]),

	                ],
	                [
	                    'name'      =>  "Mother's Day Sale",
	                    'y'         =>  11,
	                    'drilldown' =>  "Mother's Day Sale",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",3],
						                    ["2 January",6],
						                    ["3 January",9],
						                    ["4 January",5],
						                    ["5 January",8],
						                    ["6 January",7],
						                    ["7 January",1],
						                    ["8 January",9],
						                    ["9 January",8],
						                    ["10 January",2],
		                				]),

	                ],
	                [
	                    'name'      =>  "Tax Refund Sales Event",
	                    'y'         =>  52,
	                    'drilldown' =>  "Tax Refund Sales Event",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",5],
						                    ["2 January",6],
						                    ["3 January",8],
						                    ["4 January",5],
						                    ["5 January",6],
						                    ["6 January",6],
						                    ["7 January",1],
						                    ["8 January",7],
						                    ["9 January",8],
						                    ["10 January",9],
		                				]),

	                ],
	                [
	                    'name'      =>  "New Years Sale",
	                    'y'         =>  68,
	                    'drilldown' =>  "New Years Sale",
	                    'drillArr'  =>  json_encode([
					                        ["1 January",2],
						                    ["2 January",6],
						                    ["3 January",7],
						                    ["4 January",5],
						                    ["5 January",6],
						                    ["6 January",7],
						                    ["7 January",3],
						                    ["8 January",6],
						                    ["9 January",8],
						                    ["10 January",1],
		                				]),

	                ]
	            ];

        $this->load->view('auth/index', $data);
        $this->template->title('Product');
        $this->template
            ->set_layout('inner')
            ->build('dashboard', $data);
    }

    public function callback()
    {
    	$helper = $this->fb->getRedirectLoginHelper();

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
		    header('HTTP/1.0 401 Unauthorized');
		    echo "Error: " . $helper->getError() . "\n";
		    echo "Error Code: " . $helper->getErrorCode() . "\n";
		    echo "Error Reason: " . $helper->getErrorReason() . "\n";
		    echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
		    header('HTTP/1.0 400 Bad Request');
		    echo 'Bad request';
		  }
		  exit;
		}

		$oAuth2Client = $this->fb->getOAuth2Client();
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		$tokenMetadata->validateAppId('300068154224107'); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
		    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (\Facebook\Exceptions\FacebookSDKException $e) {
		    echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
		    exit;
		  }
		  echo '<h3>Long-lived</h3>';
		  var_dump($accessToken->getValue());
		}

		$_SESSION['fb_access_token'] = (string) $accessToken;

		try {
		    $response = $fb->get('/act_360233495/campaigns',$accessToken);
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		$user = $response->getGraphUser();
		pr($user);
    }

    /*
    * webhook_callback() is a callback function called on lead insert
    * return  true
    */
    public function webhook_callback(){
    	$challenge = $_REQUEST['hub_challenge'];
		$verify_token = $_REQUEST['hub_verify_token'];
		if ($verify_token === '300068154224107') {
			echo $challenge;
		}
		$inpData = file_get_contents('php://input');
		// $inpData = '{"object": "page", "entry": [{"id": "0", "time": 1577376930, "changes": [{"field": "leadgen", "value": {"ad_id": "444444444", "form_id": "444444444444", "leadgen_id": "444444444444", "created_time": 1577376930, "page_id": "444444444444", "adgroup_id": "44444444444"}}]}]}';
		$repirt_data 	= json_decode($inpData); 
		$ad_id 			= $repirt_data->entry[0]->changes[0]->value->ad_id;
	    $form_id 		= $repirt_data->entry[0]->changes[0]->value->form_id;
	    $leadgen_id 	= $repirt_data->entry[0]->changes[0]->value->leadgen_id;
	    $created_time 	= $repirt_data->entry[0]->changes[0]->value->created_time;
	    $page_id 		= $repirt_data->entry[0]->changes[0]->value->page_id;
	    $adgroup_id 	= $repirt_data->entry[0]->changes[0]->value->adgroup_id;
		$date_created	= gmdate("Y:m:d H:i:s", $created_time);
		$rData= array(
				'ad_id'			=> 	$ad_id,
				'form_id'		=> 	$form_id,
				'leadgen_id'	=>	$leadgen_id,
				'created_time'	=>	$date_created,
				'page_id'		=>	$page_id,
				'adgroup_id'	=>	$adgroup_id,
				'report_data'	=>	$inpData
			);
		App::save_data( 'lead_reporting', $rData );
		write_file(APPPATH . 'third_party/file.txt', $inpData."<br /><br />", 'a+');
    }

    

    public function get_compain(){



//  try {
//   // Returns a `FacebookFacebookResponse` object
//   $response = $this->fb->get(
//     '/act_360233495/campaigns',
//     'EAAEQ6QZB9resBAPl2PrAKegA2uDMucGxxOiXmPCoICeBPnz7vEgZCJ2oms4piliCvplZCFKKtGWnsRRKHPBqyRESDhZBvCZCcAX0Qo81dOA0W6XMQxAXeTaBbjkeiqSwYZBd75ZBZBSklnQlZAgIOS0b0TeZB2dgWfCg7xM0g6ZAhGtdrImLkWKmY2rbfZCTlnbdxMwvqlqUmW8J0OyOvirX7BUlcPs3a8HfnsMl33NMZAVjEyAZDZD'
//   );

// } catch(FacebookExceptionsFacebookResponseException $e) {
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(FacebookExceptionsFacebookSDKException $e) {
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }
// $graphNode = $response->getGraphNode();

// 	//print_r($graphNode);
   }
   
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* function End load_script */

       public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* function End load_script */

}