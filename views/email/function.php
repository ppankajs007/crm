<?php
    function send_email($type, $data) {   
        $ci =& get_instance();
        $emailtemp = $ci->db->select('*')->from('email_template')->where(array('type' => $type))->get()->row();
        if($emailtemp){
            $newMsg = $ci->load->view('email/email_header', $view_data = array(), TRUE);
            $newMsg .= str_replace('\"','"',strtr($emailtemp->msg, $data));
            $newMsg .= $ci->load->view('email/email_footer', $view_data = array(), TRUE);
            $ci->load->library('email');
            $smtp = $ci->config->item('smtp');
            $ci->email->from($smtp['customer_email'], $smtp['customer_name']);
            $ci->email->reply_to($smtp['customer_email'], $smtp['customer_name']);
            $ci->email->to($data['{emailto}']);
            $ci->email->subject($emailtemp->subject);
            $ci->email->message($newMsg);
            $ci->email->set_alt_message($newMsg);
            if( $ci->email->send() ) {
                return true;
            }else{
                web_log('order_shipment_customer','Orders.php Customer Shipment  : '.$ci->email->print_debugger());
            }
        }
    }