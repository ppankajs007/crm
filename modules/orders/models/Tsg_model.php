<?php

class Tsg_model extends MY_Model{ 


    function __construct(){ 
        parent::__construct();
    }

    function getCatByStyle($styleId){

        $cat = $this->findWhere( 'pk_product', array( 'style_id' => $styleId,'is_sub_item_only !=' => 'Y' ), TRUE, array( '*' ) );
        foreach( $cat as $key => $value ){
            $cat_value[] = $value['category'];  
        }
        $uni_value = array_unique( $cat_value );
        foreach( $uni_value as $key => $value ){
            $data[] = $this->findWhere( 'category', array( 'id' => $value ), FALSE, array(  'id','cat_name'  ) );
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

        $product_table_name = 'pk_product';
        $cat_table_name = 'category';

        if($cat_type == 'category') $fetchCat = 'sub_category_first';
        if($cat_type == 'sub_category_first') $fetchCat = 'sub_category_second';
        
        $conditionArray = array( $cat_type => $cat_id ,'style_id' => $p_style);
        if ($mainCat) {
            $conditionArray = array_merge($conditionArray,array('category' => $mainCat ));
        }
        if ($childCat) {
            $conditionArray = array_merge($conditionArray,array('sub_category_first' => $childCat ));
        }
        if ($subCat) {
            $conditionArray = array_merge($conditionArray,array('sub_category_second' => $subCat ));
        }

        $catRes = $this->findWhere( $product_table_name, $conditionArray, TRUE, array( '*', 'Item_Code as display_title' ) );
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

        $sql = "SELECT jkpro.*, jkpro.id as jkpro_id, sy.*, sy.id as sid FROM pk_product jkpro LEFT JOIN style sy on jkpro.style_id = sy.id WHERE jkpro.id = '$productId'";
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
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid, Item_Code as item_code FROM pk_product jkp LEFT JOIN style sty on sty.id = jkp.style_id  WHERE jkp.parent_id LIKE '%".$item_code."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }

    function getProductFindByItem($item_code,$style_id,$variants){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid, Item_Code as item_code FROM pk_product jkp LEFT JOIN style sty on sty.id = jkp.style_id  WHERE (jkp.Item_Code = '".$item_code."' OR jkp.user_code_variants = '".$variants."')  AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        //echo $this->db->last_query();
        return $data;
    }

    function getProductFindByVariants($variants,$style_id){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid, Item_Code as item_code FROM pk_product jkp LEFT JOIN style sty on sty.id = jkp.style_id  WHERE jkp.user_code_variants LIKE '%".$variants."%' AND style_id ='".$style_id."'";
        $data = $this->custom_query($sql,false,'array');
        return $data;
    }


    function getProductFilter($search,$cond){
            
        $output = $this->db->like('Item_Name', $search)->where($cond)->get('pk_product')->result_array();

        return $output;
    }

    function getProductById($proId){
        $sql = "SELECT jkp.*,jkp.id as jkpid,sty.*,sty.id as styid FROM pk_product jkp LEFT JOIN style sty on sty.id = jkp.style_id  WHERE jkp.id ='".$proId."'";
        $rowCal = $this->custom_query($sql,false,'array')[0];
        if ( empty( $rowCal ) ) {
            logDbError( 'tsg_model/getProductById', 'error');
        } 
        return $rowCal;
    }

    function getJkProdyctByOrderId($orderId){
        $sql = "SELECT jkPO.* ,jkP.*, jkStl.*,jkPO.id as POProId, jkPO.style_id as POStyleId from product_order as jkPO LEFT JOIN pk_product as jkP on jkP.id = jkPO.product_id LEFT JOIN style as jkStl on jkStl.id = jkPO.style_id WHERE order_id = '$orderId' ORDER BY jkStl.style_name,jkPO.Item_code";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tsg_model/getJkProdyctByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkProdyctChildByOrderId($orderId){
        $sql = "SELECT jkPOC.* ,jkP.*, jkStl.*,jkPOC.id as jkPOCid,jkP.id as jkPid , jkStl.id as jkStlid,jkPOC.style as POStyleId from product_order_child as jkPOC LEFT JOIN pk_product as jkP on jkP.id = jkPOC.product_id LEFT JOIN style as jkStl on jkStl.id = jkPOC.style WHERE order_id = '$orderId' ORDER BY jkPOC.item";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tsg_model/getJkProdyctChildByOrderId', 'error');
        }
        return $jkOrderPros;
    }

    function getJkProdyctSubChildByOrderId($orderId){
        $sql = "SELECT jkPOC.* ,jkP.*, jkStl.*,jkPOC.id as jkPOCid,jkP.id as jkPid , jkStl.id as jkStlid, jkPOC.style as POStyleId from product_order_subchild as jkPOC LEFT JOIN pk_product as jkP on jkP.id = jkPOC.product_id LEFT JOIN style as jkStl on jkStl.id = jkPOC.style WHERE order_id = '$orderId' ORDER BY jkPOC.item";
        
        $jkOrderPros = $this->custom_query($sql,FALSE,'array');
        if ( empty( $jkOrderPros ) ) {
            logDbError( 'tsg_model/getJkProdyctSubChildByOrderId', 'error');
        }
        return $jkOrderPros;
    }


    function getJkOrder($orderId){
        $sql = "SELECT pk_order.*, (SELECT SUM( `payment_amount` ) FROM customer_payment WHERE order_id = pk_order.id ) as paid_amount from pk_order WHERE id = '$orderId'";
        $rowCal = $this->custom_query($sql,FALSE,'array');
        if ( empty( $rowCal ) ) {
            logDbError( 'tsg_model/getJkOrder', 'error');
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
                $findData =  $this->countNumrows( 'product_order', array( 'order_id' => $orderID ) );
                if( $findData == TRUE  ){
                    $this->deleteWhere( 'product_order',array( 'order_id' => $orderID ) );
                }
                $findDatasub =  $this->countNumrows( 'product_order_child', array( 'order_id' => $orderID ) );
                    if( $findDatasub == TRUE  ){
                        $this->deleteWhere( 'product_order_child',array( 'order_id' => $orderID ) );
                    }

                $findDatasubchild =  $this->countNumrows( 'product_order_subchild', array( 'order_id' => $orderID ) );
                if( $findDatasubchild == TRUE  ){
                    $this->deleteWhere( 'product_order_subchild',array( 'order_id' => $orderID ) );
                } 
            }

            foreach ($orderMeta['product'] as $key => $value) {
                                    
                    $sql = "INSERT INTO product_order ( order_id, product_id,Item_code, style_id,description,descriptionII, qty,price,u_price,total_price,final_cost) 
                                VALUES ( '". $orderID ."', '". $value['product_id'] ."', '". $value['item_code'] ."', '". $value['style_id'] ."',
                                '". $value['description'] ."', '". $value['descriptionII'] ."', '". $value['qty'] ."', '". $value['price'] ."',
                                 '". $value['u_price'] ."', '". $value['total_price'] ."','". $value['final_cost'] ."' )";
                    $query['data'] = $this->db->query( $sql );
                    $parent_id_i = $this->db->insert_id();
                    
                    if( !empty( $value['aftertotal'] ) ){
                        $sumTotal += $value['aftertotal'];
                    }
                
                
                if( isset($value['child_product']) ){
                    foreach ($value['child_product'] as $key => $values) {

                        if( !empty($values['product_id'] ) ){

                            $sqlsub = "INSERT INTO product_order_child ( order_id, pro_order_id, qty, item, style, description,descriptionII,price,u_price,product_id,pro_parent_id,total_price,final_cost) 
                                        VALUES ( '". $orderID ."', '". $parent_id_i ."', '". $values['qty'] ."', '". $values['item_code'] ."',
                                        '". $values['style_id'] ."', '". $values['description'] ."', '". $values['descriptionII'] ."', '". $values['price'] ."', '". $values['u_price'] ."', '". $values['product_id'] ."', '". $value['product_id'] ."', '". $values['total_price'] ."','". $values['final_cost'] ."' )";
                            $querysub['data'] = $this->db->query( $sqlsub );
                            $parent_sub_id_i = $this->db->insert_id();
                            // pr( $querysub['data'] );continue;
                        }
                            
                        if( isset($values['subchild']) ){

                            foreach ($values['subchild'] as $key => $subvalues) {
                                if( !empty($subvalues['product_id'] ) ){
                                    $sqlsubchild = "INSERT INTO product_order_subchild ( order_id, pro_order_id, qty, item, style, description,descriptionII, price,u_price,product_id,total_price,final_cost,pro_parent_id) 
                                                VALUES ( '". $orderID ."', '". $parent_sub_id_i ."', '". $subvalues['qty'] ."', '". $subvalues['item_code'] ."',
                                                '". $subvalues['style_id'] ."', '". $subvalues['description'] ."', '". $subvalues['descriptionII'] ."', '". $subvalues['price'] ."', '". $subvalues['u_price'] ."', '". $subvalues['product_id'] ."','". $subvalues['total_price'] ."','". $subvalues['final_cost'] ."', '". $values['product_id'] ."')";

                                    $querysubchild['data'] = $this->db->query( $sqlsubchild );
                                }
                            } 
                        }   
                    }
                }
            }
        }else {
            $this->deleteWhere( 'product_order',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'product_order_child',array( 'order_id' => $orderID ) );
            $this->deleteWhere( 'product_order_subchild',array( 'order_id' => $orderID ) );
        }
    }

    function addCustomProduct($data){

        $proRes = $this->db->select('id')
        ->from('pk_product')
        ->where( array( 
            "Item_Code" => $data['Item_Code'],
            "style_id"  => $data['style_id']
            ) )
        ->get()->row();

        if ( empty( $proRes ) ) {
            $this->db->insert( 'pk_product',$data);
            return $this->db->insert_id();
        }else{
           return $proRes->id;     
        }
    }

    function saveNotExistProduct($data){

        $proRes = $this->db->select('id')
        ->from('pk_product')
        ->where( array( 
            "Item_Code" => $data['Item_Code'],
            "style_id"  => $data['style_id']
            ) )
        ->get()->row();

        if ( empty( $proRes ) ) {
            $this->db->insert( 'pk_product',$data);
            return $this->db->insert_id();
        }else{
           return $proRes->id;     
        }
    }

    function getProductDetails($orderID){
        
        $proRes = $this->db->select('pk.*,p_o.*,pk.id as pkid,p_o.id as POProId, pk.Item_Code as pkIN,pk.Item_description as pkIdes,pk.cabinet_assembly_price as pkcap,st.*,p_o.qty,st.style_name as sn')
                ->from('product_order p_o')->join('pk_product pk', 'pk.id = p_o.product_id')->join('style st','st.id = pk.style_id')->where( 'order_id',$orderID )->get()->result();

            if ( empty( $proRes ) ) {
                logDbError( 'tsg_model/getProductDetails', 'error');
            }else {
                return $proRes;
            }

    }

    function getChildProductQuote($id){

        $sqldata = "SELECT p_o_c.*,p_o_c.id as p_o_cid,pkpro.cabinet_assembly_price as pkprocap, pkpro.*,pkpro.id as pkpro_id,s.style_name as sn,s.style_code as sc FROM product_order_child p_o_c LEFT JOIN pk_product pkpro on p_o_c.product_id = pkpro.id LEFT JOIN style s on s.id = p_o_c.style WHERE order_id = '$id' ORDER BY pkpro.Item_Code";
        $data = $this->custom_query( $sqldata, false, 'object' );

        if( empty( $data ) ){
                logDbError( 'tsg_model/getChildProductQuote', 'error');
        }else{
            return $data;
        }

    }

    function getSubChildProductQuote($id){

        $sqlChildData = "SELECT p_o_sc.*,p_o_sc.id as p_o_scid,pkpro.cabinet_assembly_price as pkprocap, pkpro.*,pkpro.id as pkpro_id,s.style_name as sn,s.style_code as sc FROM product_order_subchild p_o_sc LEFT JOIN pk_product pkpro on p_o_sc.product_id = pkpro.id LEFT JOIN style s on s.id = p_o_sc.style WHERE order_id = '$id'";
        $data = $this->custom_query( $sqlChildData, false, 'object' );

        if( empty( $data ) ){
                 logDbError( 'tsg_model/getSubChildProductQuote', 'error');
        }else{
            return $data;
        }

    }

}