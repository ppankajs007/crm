<?php

class Asfg_model extends MY_Model{ 


    function __construct(){ 
        parent::__construct();
    }

    function getCatByStyle($styleId){

        $cat = $this->findWhere( 'asfg_product', array( 'style_id' => $styleId ), TRUE, array( '*' ) );
        foreach( $cat as $key => $value ){
            $cat_value[] = $value['category'];  
        }
        $uni_value = array_unique( $cat_value );
        foreach( $uni_value as $key => $value ){
            $data[] = $this->findWhere( 'asfg_category', array( 'id' => $value ), FALSE, array(  'id','cat_name'  ) );
        }
        return $data;
    }

    function getCatByProduct(
        $cat_id,
        $cat_type,
        $p_style,
        $res_status,
        $mainCat   ="",
        $childCat  ="",
        $subCat    ="",
        $subSubCat ="" ){

        $product_table_name = 'asfg_product';
        $cat_table_name = 'category';

        if($cat_type == 'category') $fetchCat = 'sub_1_category';
        if($cat_type == 'sub_1_category') $fetchCat = 'sub_2_category';
        
        $conditionArray = array( $cat_type => $cat_id ,'style_id' => $p_style);
        if ($mainCat) {
            $conditionArray = array_merge($conditionArray,array('category' => $mainCat ));
        }
        if ($childCat) {
            $conditionArray = array_merge($conditionArray,array('sub_1_category' => $childCat ));
        }
        if ($subCat) {
            $conditionArray = array_merge($conditionArray,array('sub_2_category' => $subCat ));
        }

        $catRes = $this->findWhere( $product_table_name, $conditionArray, TRUE, array( '*', 'item_code as display_title' ) );
        // echo $this->db->last_query();
        $dbRes['result'] = $catRes;
        $dbRes['rtype'] = 'product';
        if ($subSubCat == '') {
            if ( $catRes ) {
                foreach ($catRes as $key => $value) {
                    $sub_cat_name = $this->findWhere( $cat_table_name, array('id' => $value[$fetchCat] ), false, array( '*', 'cat_name as display_title' ) );
                    if($sub_cat_name){
                        $uni_value[$sub_cat_name['id']] = $sub_cat_name['cat_name'];
                    }
                }
                if($uni_value){
                    $dbRes['result'] = $uni_value;
                    $dbRes['rtype'] = 'category';
                }
            }
        }

        return $dbRes;
    }

    function getProductByCat($productId){

        $sql = "SELECT jkpro.*, jkpro.id as jkpro_id, sy.*, sy.id as sid FROM asfg_product jkpro LEFT JOIN asfg_style sy on jkpro.style_id = sy.id WHERE jkpro.id = '$productId'";
        $data['rows'] = $this->custom_query( $sql, false, 'array' );
        $data['status'] = 'success';
        if( empty( $data ) ){
            $data['status'] = 'error';
            $data['rows'] = '';
            logDbError( 'TSG_model/getProductByCat', 'error');
        }
        return $data;
    }


    function getChildProStyleName($item_code,$style_id){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid, item_code as item_code FROM asfg_product jkp LEFT JOIN asfg_style sty on sty.id = jkp.style_id  WHERE jkp.parent_id LIKE '%".$item_code."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }


    function getProductFilter($search,$cond){
            
        $output = $this->db->like('item_came', $search)->where($cond)->get('asfg_product')->result_array();

        return $output;
    }

    function getProductById($proId){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM asfg_product jkp LEFT JOIN asfg_style sty on sty.id = jkp.style_id  WHERE jkp.id ='".$proId."'";
        $rowCal = $this->custom_query($sql,false,'array')[0];
        if ( empty( $rowCal ) ) {
            logDbError( 'tsg_model/getProductById', 'error');
        } 
        return $rowCal;
    }

    function getJkProdyctByOrderId($orderId){
        $sql = "SELECT jkPO.* ,jkP.*, jkStl.*,jkPO.id as POProId ,jkPO.style_id as POStyleId from asfg_product_order as jkPO LEFT JOIN asfg_product as jkP on jkP.id = jkPO.product_id LEFT JOIN asfg_style as jkStl on jkStl.id = jkPO.style_id WHERE order_id = '$orderId' ORDER BY jkStl.style_name,jkPO.item_code";

        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tsg_model/getJkProdyctByOrderId', 'error');
        }
        return $jkOrderPros;
    }


    function getJkOrder($orderId){
        $sql = "SELECT pk_order.*, (SELECT SUM( `payment_amount` ) FROM customer_payment WHERE order_id = pk_order.id ) as paid_amount from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'asfg_model/getJkOrder', 'error');
        }else {
            $rowCal = $rowCal[0];
        }
        return $rowCal;
    }

    function saveJkOrder($orderID, $orderMeta){

        $postData = array(
             'vendor'                     => $orderMeta['vendor'],
            'style_id'                   => $orderMeta['style'],  
            'requested_delivery_date'    => $orderMeta['requested_delivery_date'],  
            'requested_date_notes'       => $orderMeta['requested_notes'],          
            'hard_date'                  => $orderMeta['hard_date'],
            'resale_certificate'         => $orderMeta['resale_certificate'],
            'is_pickup'                  => $orderMeta['is_pickup'],
            'is_locked'                  => $orderMeta['is_locked'],
            'payment_person'             => $orderMeta['payment_person'],
            'payment_person_name'        => $orderMeta['payment_person_name'],
            'has_a_uez'                  => $orderMeta['has_a_uez'],
            'has_a_stform'               => $orderMeta['has_a_stform'],
            'st8_nj_hyperlink'           => $orderMeta['st8_nj_hyperlink'],
            'ST124_hyperlink'            => $orderMeta['ST124_hyperlink'],
            'Is_Colourtone'              => $orderMeta['Is_Colourtone'],
            'ordering_note'              => $orderMeta['ordering_note'],
            'assembly_note'              => $orderMeta['assembly_note'],
            'installation_note'          => $orderMeta['installation_note'],
            'delivery_note'              => $orderMeta['delivery_note'],
            'Is_Contract'                => $orderMeta['Is_Contract'],
            'discount'                   => $orderMeta['discount'],
            'discount_per'               => $orderMeta['discount_per'],
            'total'                      => $orderMeta['total'],
            'tax'                        => $orderMeta['tax'],
            'delivery_price'             => $orderMeta['delivery_price'],
            'delivery_cost'              => $orderMeta['delivery_cost'],
            'cost_t_price'               => $orderMeta['cost_t_price'],
            'subtotal'                   => $orderMeta['subtotal'],
            'assemble_value'             => $orderMeta['assemble_value'],
            'paid'                       => $orderMeta['paid'],
            'total_due'                  => $orderMeta['total_due'],
        );
        App::update( 'pk_order',array('id' => $orderID),$postData );
        if( !empty( $orderMeta['product'] ) ){          

            $findData =  $this->countNumrows( 'asfg_product_order', array( 'order_id' => $orderID ) );
            if( $findData == TRUE  ){
                $this->deleteWhere( 'asfg_product_order',array( 'order_id' => $orderID ) );
            }
            foreach ($orderMeta['product'] as $key => $value) {
                                    
                    $sql = "INSERT INTO asfg_product_order ( order_id, product_id,item_code, style_id,description,descriptionII, qty,price,u_price,total_price,final_cost) 
                                VALUES ( '". $orderID ."', '". $value['product_id'] ."', '". $value['item_code'] ."', '". $value['style_id'] ."',
                                '". $value['description'] ."', '". $value['descriptionII'] ."', '". $value['qty'] ."', '". $value['price'] ."',
                                 '". $value['u_price'] ."', '". $value['total_price'] ."','". $value['final_cost'] ."' )";
                    $query['data'] = $this->db->query( $sql );
                    $parent_id_i = $this->db->insert_id();
                    
                    if( !empty( $value['aftertotal'] ) ){
                        $sumTotal += $value['aftertotal'];
                    }

            }
        }else {
            $this->deleteWhere( 'asfg_product_order',array( 'order_id' => $orderID ) );
        }
    }

}