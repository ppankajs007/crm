<?php
    require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
    function pr( $data, $die = false ){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
            if( $die ) die;
    }
    
    function active_menu( $controller, $function = '' ) { 
        $ci =& get_instance();
        $cc = $ci->router->fetch_class();
        $cf = $ci->router->fetch_method();
        if( !empty( $controller ) && !empty( $function ) ) {
            return ( $cc == $controller && $cf == $function ) ? 'active' : '';    
        }else{
            return ( $cc == $controller ) ? 'active' : '';
        }
    }

    function encrypt_decrypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'jhgfdf89g5df7g5@';
        $secret_iv = 'jhb^&%&*^kljhjg@';
        $result = false;
        $enc_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0,16 );
        if( $action == 'e' ) {
            $result = base64_encode( openssl_encrypt( $string, $enc_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $result = openssl_decrypt( base64_decode( $string ), $enc_method, $key, 0, $iv );
        }
        return $result;
    }

    function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }

    function humanTiming ( $time,$customTime ='' ) {
        if($customTime != ''){
            $time = $customTime - $time;
        }else{
            $time = time() - $time; // to get the time since that moment   
        }
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }
    
    function array_compare_by_id($element1, $element2) { 
        $el1 = strtotime($element1['id']); 
        $el2 = strtotime($element2['id']); 
        return $el1 - $el2; 
    }
    
    function send_email($type, $data){
        $ci =& get_instance();
        $emailtemp = $ci->db->select('*')->from('emailSetting')->where(array('type' => $type))->get()->row();
        if($emailtemp){
            $newMsg = $ci->load->view('email/email_header', $view_data = array(), TRUE);
            $newMsg .= "<div style='text-align: left;padding: 20px 30px; background: #f9f9f9;'>".str_replace('\"','"',strtr($emailtemp->msg, $data))."</div>";
            $newMsg .= $ci->load->view('email/email_footer', $view_data = array(), TRUE);
            $ci->load->library('email');
            $smtp = $ci->config->item('smtp');
            $ci->email->from($smtp['customer_email'], $smtp['customer_name']);
            $ci->email->reply_to($smtp['customer_email'], $smtp['customer_name']);
            $ci->email->to($data['_emailto']);
            $ci->email->subject( str_replace('\"','"',strtr($emailtemp->subject, $data)) );
            $ci->email->message($newMsg);
            $ci->email->set_alt_message($newMsg);
            if( $ci->email->send() ){
                $res = "Email Sent";
            }else{
                $res = "Error";
            }
        }else{
            $res = "No Template found";
        }
        return $res;
    }
    
    function log_activity($activity_name, $module_id, $old_value = '', $new_value = '', $activity='',$table){
        $time = date("Y/m/d h:i:s");
        $ci =& get_instance();
        $respose = $ci->db->insert($table, array(
                                            'activity_name' => $activity_name,
                                            'activity_id' => $module_id,
                                            'old_val' => $old_value,
                                            'new_val' => $new_value,
                                            'user_id' => $ci->tank_auth->get_user_id(),
                                            'activity_message' => $activity,
                                            'activity_time' => $time
                                        ));
        return $ci->db->insert_id();
    }
        
    function get_row_data($column = array(),$table, $where_id ){
        $ci =& get_instance();
        $query = $ci->db->select($column)->from($table)->where($where_id)->get()->row();
        return $query;
    }
    
    function crm_date($inputdate){
        $result = "";
        if(!empty($inputdate)){
            $result =  date('m-d-Y', strtotime($inputdate));
        }
        return $result;
    }
    
    function crm_dateTime($inputDate){
        $dateFormat =  explode("-",$inputDate);
        return $dateFormat[2]."-".$dateFormat[0]."-".$dateFormat[1]." ".date("H:i:s");
    }
    
    function pushalert($post_vars){
        $apiKey = "dd29ab6189c613703718a00d730da114";
        $curlUrl = "https://api.pushalert.co/rest/v1/send";    
        $headers = Array();
        $headers[] = "Authorization: api_key=".$apiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $output = json_decode($result, true);
        if($output["success"]) {
            return true;
        }else{
            return false;
        }
    }
    
    function log_orders($order_id,$user_id,$method='') {
        
    $ci =& get_instance();
    
    $order_data = $ci->db->where( array( 'id' => $order_id ) )->get('pk_order')->row();
    
    if ($order_data->vendor == 1) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('product_order_subchild')->result_array();

    } else if ($order_data->vendor == 2) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('fab_product_order')->result_array();
        $child_product_data ="";
        $subchild_product_data ="";

    } else if ($order_data->vendor == 3) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('jk_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('jk_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('jk_product_order_subchild')->result_array();

    } else if ($order_data->vendor == 4) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('cnc_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('cnc_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('cnc_product_order_subchild')->result_array();
        
    } else if ($order_data->vendor == 5) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('wc_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('wc_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('wc_product_order_subchild')->result_array();
        
    } else if ($order_data->vendor == 6) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('tknobs_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('tknobs_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('tknobs_product_order_subchild')->result_array();
        
    } else if ($order_data->vendor == 7) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('msiTile_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('msiTile_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('msiTile_product_order_subchild')->result_array();
        
    } else if ($order_data->vendor == 8) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('asfg_product_order')->result_array();
        $child_product_data ="";
        $subchild_product_data ="";
        
    } else if ($order_data->vendor == 9) {
        $product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('21century_product_order')->result_array();
        $child_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('21century_product_order_child')->result_array();
        $subchild_product_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('21century_product_order_subchild')->result_array();
        
    }


    $customer_payment_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('customer_payment')->result_array();
    $expenses_data = $ci->db->where( array( 'order_id' => $order_id ) )->get('expenses')->result_array();
    $files_data = $ci->db->where(  array( 'field_id' => $order_id, 'module_name' => 'order-'.$order_id ) )->get('files')->result_array();
    
    $ci->db->where('id', $order_id);
    $ci->db->update('pk_order', array( 'current_version' => '0')); 

    $response = $ci->db->insert('order_logs', array(
        'order_id'      => $order_id,
        'user_id'       => $user_id,
        'vendor_id'   => $order_data->vendor,
        'order_data'     => json_encode($order_data),
        'product_data'   => ( !empty($product_data)  ? json_encode($product_data) : ''),
        'child_product_data'   => ( !empty($child_product_data)  ? json_encode($child_product_data) : ''),
        'subchild_product_data'   => ( !empty($subchild_product_data)  ? json_encode($subchild_product_data) : ''),
        'payment_data'   => ( !empty($customer_payment_data)  ? json_encode($customer_payment_data) : ''),
        'expenses_data'   => ( !empty($expenses_data)  ? json_encode($expenses_data) : ''),
        'files_data'   => ( !empty($files_data)  ? json_encode($files_data) : ''),
        'method'   => $method,
        'created_on'    => time()
    ));
    return $ci->db->insert_id();
    }
    
    function get_field($tablename, $where, $field){
        $ci =& get_instance();
        $field_val = $ci->db->where( $where )->get($tablename)->row()->$field;
        return $field_val;
    }

    function logDbError( $errorTitle, $logType , $logDescription = ''){
        $ci = &get_instance();
        // echo $logDesc = ($logDescription != '') ? $logDescription : 'Error: ' . $ci->db->_error_message() .'| Last Query: ' . $ci->db->last_query();
        if( $logDescription == '') {
            $logDescription = 'Last Query: ' . $ci->db->last_query();
        }

        $ci->db->insert('error_log', array( 
            'title'       => $errorTitle,
            'description' => $logDescription,
            'log_type'    => $logType,
            'created_by'  => $ci->tank_auth->get_user_id()
        ));
    }

    function decimalValue($value){
        return number_format((float)$value, 2, '.', '');
    }

    function phoneNumberPattern($phoneNo){
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phoneNo,  $matches ) )
        {
            $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
            return $result;
        }        
    }

    function createLeadsAge($createDate){
        $date1  = date('Y-m-d', strtotime($createDate));
        $date2  = date('Y-m-d');
        $diff   = abs(strtotime($date2) - strtotime($date1));
        $years  = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        return $days;

    }

    function sendClickSMS($smsto,$messege){
        
        $url = 'https://api-mapper.clicksend.com/http/v2/send.php';
        $fields = array(
            'username'  => 'tbeaudry',
            'key'       => 'FB78E17B-46DF-10CB-D3B7-8D0618603E2C',
            'from'      => '+17325043371',
            'to'        => $smsto,
            'message'   => $messege
        );

        //open connection
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields) );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        //execute post
        $res = curl_exec($ch);
        logDbError( 'sendClickSMS', 'Send SMS Log' , json_encode($res));
        //close connection
        curl_close($ch);
        return $res;
    }

    function selfRedirect(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        redirect($actual_link);
    }

    function multiArrSort($arr,$colum){
        $columns = array_column($arr, $colum);
        array_multisort($columns, SORT_ASC, $arr);
        return $arr;
    }

    function getOrderMeta($orderId){
        $ci =& get_instance();
        return $ci->db->where( array('id' => $orderId) )->get('pk_order')->row();
    }