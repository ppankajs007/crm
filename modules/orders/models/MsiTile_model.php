<?php

class MsiTile_model extends MY_Model{ 


    function __construct(){ 
        parent::__construct();
    }

    function getCatByStyle($styleId){

        $cat = $this->findWhere( 'msiTile_product', array( 'style_id' => $styleId ), TRUE, array( '*' ) );
        foreach( $cat as $key => $value ){
            $cat_value[] = $value['sub_1_category'];  
        }
        $uni_value = array_unique( $cat_value );
        foreach( $uni_value as $key => $value ){
            $data[] = $this->findWhere( 'msiTile_category', array( 'id' => $value ), FALSE, array(  'id','cat_name'  ) );
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

        $product_table_name = 'msiTile_product';
        $cat_table_name = 'msiTile_category';

        if($cat_type == 'sub_1_category') $fetchCat = 'sub_2_category';
        if($cat_type == 'sub_2_category') $fetchCat = 'sub_3_category';
        
        $conditionArray = array( $cat_type => $cat_id ,'style_id' => $p_style);
        if ($mainCat) {
            $conditionArray = array_merge($conditionArray,array('sub_1_category' => $mainCat ));
        }
        if ($childCat) {
            $conditionArray = array_merge($conditionArray,array('sub_2_category' => $childCat ));
        }
        if ($subCat) {
            $conditionArray = array_merge($conditionArray,array('sub_3_category' => $subCat ));
        }
        $catRes = $this->findWhere( $product_table_name, $conditionArray, TRUE, array( '*', 'item_code as display_title' ) );
        // return $this->db->last_query();
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

        $sql = "SELECT jkpro.*, jkpro.id as jkpro_id, sy.*, sy.id as sid FROM msiTile_product jkpro LEFT JOIN msiTile_style sy on jkpro.style_id = sy.id WHERE jkpro.id = '$productId'";
        $data['rows'] = $this->custom_query( $sql, false, 'array' );
        $data['status'] = 'success';
        if( empty( $data ) ){
            $data['status'] = 'error';
            $data['rows'] = '';
            logDbError( 'msiTile_model/getProductByCat', 'error');
        }
        return $data;
    }


    function getChildProStyleName($item_code,$style_id){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM msiTile_product jkp LEFT JOIN msiTile_style sty on sty.id = jkp.style_id  WHERE parent LIKE '%".$item_code."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }


    function getProductFilter($search,$cond){
            
        $output = $this->db->like('Item_Name', $search)->where($cond)->get('msiTile_product')->result_array();

        return $output;
    }

    function getProductById($proId){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM msiTile_product jkp LEFT JOIN msiTile_style sty on sty.id = jkp.style_id  WHERE jkp.id ='".$proId."'";
        $rowCal = $this->custom_query($sql,false,'array')[0];
        if ( empty( $rowCal ) ) {
            logDbError( 'msiTile_model/getProductById', 'error');
        } 

        return $rowCal;
    }

    function getJkProdyctByOrderId($orderId){
        $sql = "SELECT jkPO.* ,jkP.*, jkStl.* from msiTile_product_order as jkPO LEFT JOIN msiTile_product as jkP on jkP.id = jkPO.product_id LEFT JOIN msiTile_style as jkStl on jkStl.id = jkPO.style_id WHERE order_id = '$orderId'";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'msiTile_model/getJkProdyctByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkProdyctChildByOrderId($orderId){
        $sql = "SELECT jkPOC.* ,jkP.*, jkStl.*,jkPOC.id as jkPOCid,jkP.id as jkPid , jkStl.id as jkStlid from msiTile_product_order_child as jkPOC LEFT JOIN msiTile_product as jkP on jkP.id = jkPOC.product_id LEFT JOIN msiTile_style as jkStl on jkStl.id = jkPOC.style_id WHERE order_id = '$orderId'";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'msiTile_model/getJkProdyctChildByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkOrder($orderId){
        $sql = "SELECT pk_order.*, (SELECT SUM( `payment_amount` ) FROM customer_payment WHERE order_id = pk_order.id ) as paid_amount from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'msi_model/getJkOrder', 'error');
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

            $findData =  $this->countNumrows( 'msiTile_product_order', array( 'order_id' => $orderID ) );
            if( $findData == TRUE  ){
                $this->deleteWhere( 'msiTile_product_order',array( 'order_id' => $orderID ) );
            }

            $findDatasub =  $this->countNumrows( 'msiTile_product_order_child', array( 'order_id' => $orderID ) );
                if( $findDatasub == TRUE  ){
                    $this->deleteWhere( 'msiTile_product_order_child',array( 'order_id' => $orderID ) );
                }

                $findDatasubchild =  $this->countNumrows( 'msiTile_product_order_subchild', array( 'order_id' => $orderID ) );
                if( $findDatasubchild == TRUE  ){
                    $this->deleteWhere( 'msiTile_product_order_subchild',array( 'order_id' => $orderID ) );
                } 

            foreach ($orderMeta['product'] as $key => $value) {
                    if ( $value['product_id'] ) {
                        //pr( $value );die;
                        $sql = "INSERT INTO msiTile_product_order ( order_id, product_id,item_code, style_id,sqbox_input,qty,price,u_price,total_price,final_cost,descriptionI,descriptionII) 
                                    VALUES ( '". $orderID ."', '". $value['product_id'] ."', '". $value['item_code'] ."', '". $value['style_id'] ."', '". $value['sqbox_input'] ."', '". $value['qty'] ."', '". $value['price'] ."', '". $value['u_price'] ."', '". $value['total_price'] ."', '". $value['final_cost'] ."', '". $value['descriptionI'] ."', '". $value['descriptionII'] ."')";
                                        $query['data'] = $this->db->query( $sql );
                                        $parent_id = $this->db->insert_id();
                    }
            }
        }else {
            $this->deleteWhere( 'msiTile_product_order',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'msiTile_product_order_child',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'msiTile_product_order_subchild',array( 'order_id' => $orderID ) );
        }
    }
}