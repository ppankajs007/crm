<?php

class Fab_model extends MY_Model{ 


    function __construct(){ 
        parent::__construct();
    }

    function getCatByStyle($styleId){

        $cat = $this->findWhere( 'fab_product', array( 'style_id' => $styleId ), TRUE, array( '*' ) );
        foreach( $cat as $key => $value ){
            $cat_value[] = $value['category'];  
        }
        $uni_value = array_unique( $cat_value );
        foreach( $uni_value as $key => $value ){
            $data[] = $this->findWhere( 'fab_category', array( 'id' => $value ), FALSE, array(  'id','cat_name'  ) );
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

        $product_table_name = 'fab_product';
        $cat_table_name = 'fab_category';

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

        $sql = "SELECT fabpro.*, fabpro.id as fabpro_id, sy.*, sy.id as sid FROM fab_product fabpro LEFT JOIN fab_style sy on fabpro.style_id = sy.id WHERE fabpro.id = '$productId'";
        $data['rows'] = $this->custom_query( $sql, false, 'array' );
        $data['status'] = 'success';
        if( empty( $data ) ){
            $data['status'] = 'error';
            $data['rows'] = '';
            logDbError( 'Fab_model/getProductByCat', 'error');
        }
        return $data;
    }

    function getProductById($proId){
        $rowCal = $this->findWhere( 'fab_product', array( 'id' => $proId), false, array( '*' ) );
        if ( empty( $rowCal ) ) {
            logDbError( 'Fab_model/getProductById', 'error');
        } 
        return $rowCal;
    }

    function getFabProdyctByOrderId($orderId){
        
        $sql = "SELECT fabPO.* ,fabP.*, fabStl.* from fab_product_order as fabPO LEFT JOIN fab_product as fabP on fabP.id = fabPO.product_id LEFT JOIN fab_style as fabStl on fabStl.id = fabPO.style_id WHERE order_id = '$orderId'";
        
        $fabOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $fabOrderPros ) ) {
            logDbError( 'Fab_model/getFabProdyctByOrderId', 'error');
        }
        return $fabOrderPros;
    }

/*    function getFabOrder($orderId){
        $sql = "SELECT * from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'Fab_model/getFabOrder', 'error');
        }else {
            $rowCal = $rowCal[0];
        }
        return $rowCal;
    }*/

    function getFabOrder($orderId){
        $sql = "SELECT pk_order.*, (SELECT SUM( `payment_amount` ) FROM customer_payment WHERE order_id = pk_order.id ) as paid_amount from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'fab_model/getJkOrder', 'error');
        }else {
            $rowCal = $rowCal[0];
        }
        return $rowCal;
    }

    function saveFabOrder($orderID, $orderMeta){
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
        if( !empty( $orderMeta['fab_product'] ) ){

            $findData =  $this->countNumrows( 'fab_product_order', array( 'order_id' => $orderID ) );
            if( $findData == TRUE  ){
                $this->deleteWhere( 'fab_product_order',array( 'order_id' => $orderID ) );
            }
            foreach ($orderMeta['fab_product'] as $key => $value) {
                    if ( $value['product_id'] ) {
                        $sql = "INSERT INTO fab_product_order ( order_id, product_id,description,descriptionII,qty, price, u_price, style_id,item_code,slab_one_id,slab_two_id,slab_three_id,slab_one_sqft,slab_two_sqft,slab_three_sqft,total_price,final_cost) 
                                    VALUES ( '". $orderID ."', '". $value['product_id'] ."', '". $value['description'] ."', '". $value['descriptionII'] ."', '". $value['qty'] ."', '". $value['price'] ."', '". $value['u_price'] ."', '". $value['style_id'] ."','". $value['item_code'] ."', '". $value['slab1_id'] ."', '". $value['slab2_id'] ."', '". $value['slab3_id'] ."', '". $value['slab1_sqft'] ."', '". $value['slab2_sqft'] ."', '". $value['slab3_sqft'] ."', '". $value['total_price'] ."', '". $value['final_cost'] ."')";
                        $query['data'] = $this->db->query( $sql );
                    }
            }
        }else {
            $this->deleteWhere( 'fab_product_order',array( 'order_id' => $orderID ) );
        }
    }
}