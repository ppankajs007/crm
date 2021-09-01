<?php

class Tknobs_model extends MY_Model{ 


    function __construct(){ 
        parent::__construct();
    }

    function getCatByStyle($styleId){

        $cat = $this->findWhere( 'tknobs_product', array( 'style_id' => $styleId,'is_sub_item !=' => 'Y'), TRUE, array( '*' ) );
        foreach( $cat as $key => $value ){
            $cat_value[] = $value['category'];  
        }
        $uni_value = array_unique( $cat_value );
        foreach( $uni_value as $key => $value ){
            $data[] = $this->findWhere( 'tknobs_category', array( 'id' => $value ), FALSE, array(  'id','cat_name'  ) );
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

        $product_table_name = 'tknobs_product';
        $cat_table_name = 'tknobs_category';

        if($cat_type == 'category') $fetchCat = 'sub_1_category';
        if($cat_type == 'sub_1_category') $fetchCat = 'sub_2_category';
        if($cat_type == 'sub_2_category') $fetchCat = 'sub_3_category';
        
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
        if ($subSubCat) {
            $conditionArray = array_merge($conditionArray,array('sub_3_category' => $subSubCat ));
        }
        $catRes = $this->findWhere( $product_table_name, $conditionArray, TRUE, array( '*', 'item_code as display_title' ) );
        
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

        $sql = "SELECT jkpro.*, jkpro.id as jkpro_id, sy.*, sy.id as sid FROM tknobs_product jkpro LEFT JOIN tknobs_style sy on jkpro.style_id = sy.id WHERE jkpro.id = '$productId'";
        $data['rows'] = $this->custom_query( $sql, false, 'array' );
        $data['status'] = 'success';
        if( empty( $data ) ){
            $data['status'] = 'error';
            $data['rows'] = '';
            logDbError( 'JK_model/getProductByCat', 'error');
        }
        return $data;
    }

    function getProductFindByVariants($variants,$style_id){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM tknobs_product jkp LEFT JOIN tknobs_style sty on sty.id = jkp.style_id  WHERE jkp.variants LIKE '%".$variants."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }

    function getChildProStyleName($item_code,$style_id){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM tknobs_product jkp LEFT JOIN tknobs_style sty on sty.id = jkp.style_id  WHERE parent LIKE '%".$item_code."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }


    function getProductFilter($search,$cond){
            
        $output = $this->db->like('Item_Name', $search)->where($cond)->get('tknobs_product')->result_array();

        return $output;
    }

    function getProductById($proId){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM tknobs_product jkp LEFT JOIN tknobs_style sty on sty.id = jkp.style_id  WHERE jkp.id ='".$proId."'";
        $rowCal = $this->custom_query($sql,false,'array')[0];
        if ( empty( $rowCal ) ) {
            logDbError( 'tknobs_model/getProductById', 'error');
        } 

        return $rowCal;
    }

    function getJkProdyctByOrderId($orderId){
        $sql = "SELECT jkPO.* ,jkP.*, jkStl.*,jkPO.id as POProId, jkPO.style_id as POStyleId  from tknobs_product_order as jkPO LEFT JOIN tknobs_product as jkP on jkP.id = jkPO.product_id LEFT JOIN tknobs_style as jkStl on jkStl.id = jkPO.style_id WHERE order_id = '$orderId' ORDER BY jkStl.style_name, jkPO.item_code";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tknobs_model/getJkProdyctByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkProdyctChildByOrderId($orderId){
        $sql = "SELECT jkPOC.* ,jkP.*, jkStl.*,jkPOC.id as jkPOCid,jkP.id as jkPid , jkStl.id as jkStlid from tknobs_product_order_child as jkPOC LEFT JOIN tknobs_product as jkP on jkP.id = jkPOC.product_id LEFT JOIN tknobs_style as jkStl on jkStl.id = jkPOC.style_id WHERE order_id = '$orderId'";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tknobs_model/getJkProdyctChildByOrderId', 'error');
        }
        return $jkOrderPros;
    }
     function getJkProdyctSubChildByOrderId($orderId){
        $sql = "SELECT jkPOC.* ,jkP.*, jkStl.*,jkPOC.id as jkPOCid,jkP.id as jkPid , jkStl.id as jkStlid from tknobs_product_order_subchild as jkPOC LEFT JOIN tknobs_product as jkP on jkP.id = jkPOC.product_id LEFT JOIN tknobs_style as jkStl on jkStl.id = jkPOC.style WHERE order_id = '$orderId'";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tknobs_model/getJkProdyctSubChildByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkOrder($orderId){
        $sql = "SELECT pk_order.*, (SELECT SUM( `payment_amount` ) FROM customer_payment WHERE order_id = pk_order.id ) as paid_amount from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'tknobs_model/getJkOrder', 'error');
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

            if ($orderMeta['is_import'] == 'no') {
                $findData =  $this->countNumrows( 'tknobs_product_order', array( 'order_id' => $orderID ) );
                if( $findData == TRUE  ){
                    $this->deleteWhere( 'tknobs_product_order',array( 'order_id' => $orderID ) );
                }
                $findDatasub =  $this->countNumrows( 'tknobs_product_order_child', array( 'order_id' => $orderID ) );
                    if( $findDatasub == TRUE  ){
                        $this->deleteWhere( 'tknobs_product_order_child',array( 'order_id' => $orderID ) );
                    }

                $findDatasubchild =  $this->countNumrows( 'tknobs_product_order_subchild', array( 'order_id' => $orderID ) );
                if( $findDatasubchild == TRUE  ){
                    $this->deleteWhere( 'tknobs_product_order_subchild',array( 'order_id' => $orderID ) );
                } 
            }

            foreach ($orderMeta['product'] as $key => $value) {
                                    
                    $sql = "INSERT INTO tknobs_product_order ( order_id, product_id,item_code, style_id,description,descriptionII, qty,price,u_price,total_price,final_cost) 
                                VALUES ( '". $orderID ."', '". $value['product_id'] ."', '". $value['item_code'] ."', '". $value['style_id'] ."', '". $value['description'] ."', '". $value['descriptionII'] ."', '". $value['qty'] ."', '". $value['price'] ."', '". $value['u_price'] ."', '". $value['total_price'] ."','". $value['final_cost'] ."' )";
                    $query['data'] = $this->db->query( $sql );
                    $parent_id_i = $this->db->insert_id();
                    
                    if( !empty( $value['aftertotal'] ) ){
                        $sumTotal += $value['aftertotal'];
                    }
                
                
                if( isset($value['child_product']) ){
                    $parent_sub_id_i = 0;
                    foreach ($value['child_product'] as $key => $values) {

                        if( !empty($values['product_id'] ) ){

                            $sqlsub = "INSERT INTO tknobs_product_order_child ( order_id, pro_order_id, qty, item_code, style_id, description,descriptionII,price,u_price,product_id,pro_parent_id,total_price,final_cost) 
                                        VALUES ( '". $orderID ."', '". $parent_id_i ."', '". $values['qty'] ."', '". $values['item_code'] ."', '". $values['style_id'] ."', '". $values['description'] ."', '". $values['descriptionII'] ."', '". $values['price'] ."', '". $values['u_price'] ."', '". $values['product_id'] ."', '". $value['product_id'] ."', '". $values['total_price'] ."','". $values['final_cost'] ."' )";
                            $querysub['data'] = $this->db->query( $sqlsub );
                            $parent_sub_id_i = $this->db->insert_id();

                        }
                            
                        if( isset($values['subchild']) ){

                            foreach ($values['subchild'] as $key => $subvalues) {
                                if( !empty($subvalues['product_id'] ) ){
                                    $sqlsubchild = "INSERT INTO tknobs_product_order_subchild ( order_id, pro_order_id, qty, item, style, description,descriptionII, price,u_price,product_id,total_price,final_cost,pro_parent_id) 
                                                VALUES ( '". $orderID ."', '". $parent_sub_id_i ."', '". $subvalues['qty'] ."', '". $subvalues['item_code'] ."','". $subvalues['style_id'] ."', '". $subvalues['description'] ."', '". $subvalues['descriptionII'] ."', '". $subvalues['price'] ."', '". $subvalues['u_price'] ."', '". $subvalues['product_id'] ."','". $subvalues['total_price'] ."','". $subvalues['final_cost'] ."', '". $values['product_id'] ."')";

                                    $querysubchild['data'] = $this->db->query( $sqlsubchild );
                                }
                            } 
                        }   
                    }
                }
            }
        }else {
            $this->deleteWhere( 'tknobs_product_order',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'tknobs_product_order_child',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'tknobs_product_order_subchild',array( 'order_id' => $orderID ) );
        }
    }

    function getProductDetails($orderID){
        
        $proRes = $this->db->select('pk.*,p_o.*,pk.id as pkid,p_o.id as POProId, pk.item_code as pkIN,pk.item_description as pkIdes,pk.retail_price as pkcap,st.*,p_o.qty,st.style_name as sn')
                ->from('tknobs_product_order p_o')->join('tknobs_product pk', 'pk.id = p_o.product_id')->join('tknobs_style st','st.id = pk.style_id')->where( 'order_id',$orderID )->get()->result();

            if ( empty( $proRes ) ) {
                logDbError( 'tknobs_model/getProductDetails', 'error');
            }else {
                return $proRes;
            }

    }

    function getChildProductQuote($id){

        $sqldata = "SELECT p_o_c.*,p_o_c.id as p_o_cid,pkpro.retail_price as pkprocap, pkpro.*,pkpro.id as pkpro_id,s.style_name as sn,s.style_code as sc FROM tknobs_product_order_child p_o_c LEFT JOIN tknobs_product pkpro on p_o_c.product_id = pkpro.id LEFT JOIN tknobs_style s on s.id = p_o_c.style_id WHERE order_id = '$id' ORDER BY pkpro.item_code";
        $data = $this->custom_query( $sqldata, false, 'object' );

        if( empty( $data ) ){
                logDbError( 'tknobs_model/getChildProductQuote', 'error');
        }else{
            return $data;
        }

    }

    function getSubChildProductQuote($id){

        $sqlChildData = "SELECT p_o_sc.*,p_o_sc.id as p_o_scid,pkpro.retail_price as pkprocap, pkpro.*,pkpro.id as pkpro_id,s.style_name as sn,s.style_code as sc FROM tknobs_product_order_subchild p_o_sc LEFT JOIN tknobs_product pkpro on p_o_sc.product_id = pkpro.id LEFT JOIN tknobs_style s on s.id = p_o_sc.style WHERE order_id = '$id'";
        $data = $this->custom_query( $sqlChildData, false, 'object' );

        if( empty( $data ) ){
                 logDbError( 'tknobs_model/getSubChildProductQuote', 'error');
        }else{
            return $data;
        }

    }
}