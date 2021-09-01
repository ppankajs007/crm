<?php

class Search_model extends MY_Model 
{	


    function __construct(){ 
        parent::__construct();
    }
    
    function search( $string )
    {
        $tempSearch = explode(' ', $string);
        if ( isset($tempSearch[1]) ) {
            $this->db->where('first_name', $tempSearch[0]);
            $this->db->like('last_name', $tempSearch[1], 'both', false);
        }else{
            $this->db->or_like('email', $string, 'both', false);
            $this->db->or_like('phone', $string, 'both', false);
            $this->db->or_like('first_name', $string, 'both', false);
        }
        $result['leads'] = $this->db->select('leads.*,CONCAT(leads.first_name, " ", leads.last_name) as full_name')->from('leads')->get()->result();
        // echo $this->db->last_query();
        
        $this->db->or_like('email', $string, 'both', false);
        $this->db->or_like('phone', $string, 'both', false);
        $this->db->or_like('full_name', $string, 'both', false);
        $result['customer'] = $this->db->select('*')->from('customer')->get()->result();

        $sql = "SELECT pkr.*,pkr.id as pkid, CONCAT(pkr.first_name, ' ', pkr.last_name) AS fname, cust.full_name, cust.phone, vdr.code as vdrcode,up.name as upname ,
            ( SELECT SUM( payment_amount ) FROM customer_payment WHERE order_id = pkr.id ) AS payment_amount
             FROM pk_order pkr 
                LEFT JOIN  customer cust on pkr.customer_id = cust.id LEFT JOIN vendor vdr on vdr.id = pkr.vendor LEFT JOIN user_profiles up on pkr.sales_primary = up.user_id"; 
        
            $sql.= " WHERE 1 = '1'";
            if ( isset($tempSearch[1]) ) {
                $sql.= " AND pkr.first_name = '".$tempSearch[0]."' ";
                $sql.= " AND pkr.last_name LIKE '%".$tempSearch[1]."%' ";
            }else{
                $sql.= " AND ( pkr.id LIKE '".$string."%'";    
                $sql.= " OR pkr.status LIKE '%".$string."%' ";    
                $sql.= " OR pkr.first_name LIKE '%".$string."%' ";
                $sql.= " OR pkr.last_name LIKE '%".$string."%' ";
                $sql.= " OR cust.phone LIKE '%".$string."%' ";
                $sql.= " OR vdr.name LIKE '%".$string."%' ";
                $sql.= " OR up.name LIKE '%".$string."%' ";
                $sql.= " OR pkr.sales_secondary LIKE '%".$string."%' ";
                $sql.= " OR pkr.vendor_invoice LIKE '%".$string."%' ";
                $sql.= " OR pkr.total LIKE '%".$string."%' ";
                $sql.= " OR pkr.paid LIKE '%".$string."%' ";
                $sql.= " OR pkr.total_due LIKE '%".$string."%'";
                $sql.= " OR pkr.is_pickup LIKE '%".$string."%'";
                $sql .= " )";
            }
            // echo $sql; die;    
        $result['orders'] = $this->custom_query($sql);
        return $result;
    } 

}
?>