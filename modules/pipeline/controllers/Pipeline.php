<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Pipeline extends MX_Controller
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
        $this->load->model('pipeline_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    }

    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }
    public function load_css(){
        $data = array();
        $this->load->view('load_css', $data);
    }

    public function index()
    {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $this->load->view('index', $data);
        $this->template->title('pipeline');
        $this->template
                ->set_layout('inner')
                ->build('pipeline', $data);
       
    }

    
    
    public function getPipeline(){
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
        $columns = array(
                        0 => 'c.id',
                        1 => 'Name',   
                        2 => 'hs',    
                        3 => 'phone',
                        4 => 'unweighted_pipeline',
                        5 => 'Status',
                        6 => 'Weight',
                        7 => 'weighted_pipeline',
                        8 => 'current status',
                        9 => 'next_step',
                        10 => 'next_step_date',
                        11 => 'next_step_owner'
                      );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT c.*,c.id as cid,c.leads_id as cl_id,l.*,p.name as nsowner,s.status as ss,( SELECT SUM(subtotal) FROM pk_order WHERE customer_id = cid ) as totalOcost,( SELECT SUM(`point`) + (SELECT hoteness*2*10  FROM leads WHERE id = l.id) FROM `survey_qoptions` WHERE id IN (SELECT answer FROM `survey_answers` WHERE lead_id = l.id) ) AS hs FROM customer c LEFT JOIN leads l on l.id = c.leads_id left join user_profiles p on l.assigned_to =p.user_id left join status_lead s on s.id = l.lead_status WHERE c.vendor_id = '$vendor_id'";
        $totalData = $this->pipeline_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;
        if( !empty($requestData['search']['value']) ) {
            $sql.=" AND ( c.id LIKE '".$requestData['search']['value']."%' ";    
            $sql.=" OR c.full_name LIKE '".$requestData['search']['value']."%' )";
        }
        $totalFiltered = $this->pipeline_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $total_record = $this->pipeline_model->custom_query($sql,false,'array'); 
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) )  {
            foreach ($total_record as $row) {

                switch ($row['lead_status']) {
                    case 5: $num = 10; break;
                    case 6: $num = 25; break;
                    case 19: $num = 50; break;
                    case 18: $num = 80; break;
                    case 7: $num = 100; break;
                    default: $num = 0; break;
                }

                $nsowner    = ( $row['nsowner'] ) ? $row['nsowner'] : 'N/A';
                $totalOcost = ( $row['totalOcost'] ) ? '$'.number_format($row['totalOcost'],2) : '$0.00';
                $hs         = ( $row['hs'] ) ? $row['hs'] : 00;
                $totalper   = ($row['totalOcost'] * $num)/100;
                $data[] = array(
                      $row['cid'],
                      ucfirst($row['full_name']),
                      $hs,
                      $row['phone'],
                      $totalOcost,
                      $row['ss'],
                      $num.'%',
                      '$'.number_format($totalper,2),
                      $row['last_action_note'],
                      $row['action_lead'],
                      $row['last_action_time'],
                      $nsowner
                  );
              }
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $data
        );

      echo json_encode($json_data);
         
    }



}

/* End of file Customer.php */