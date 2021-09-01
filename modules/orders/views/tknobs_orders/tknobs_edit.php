<style>
   .des_input {
     width: 100%;
   }
  .des_first{
      margin: 10px 0 0;
  }
   .cost_content,.icon_content,.btn_content{
   display: flex;
   }
    td.bottomLine {
      vertical-align: bottom !important;
  }
  .bottomLine p {
      margin: 11px;
  }
   .cost_input.cost_first {
   display: flex;
   margin-right: 10px;
   }
   .cost_input {
   width: 49%;
   }
   .f_icon.add_icon {
   margin-right: 10px;
   color: green;
   }
   .f_icon.delete_icon {
   color: #f44336;
   }
   .cost_content {
   margin-bottom: -34px;
   }
   .down_btn {
   margin-left: 17px;
   }
   .btn_content {
   position: absolute;
   bottom: 0px;
   }
   .margin-top {
   margin-top: 2em;
   }
   .display_none{
   display:none;
   transition-duration:.2s;
   }
   .display_type{
   display:block;
   transition-duration:1s;
   }
   .table .table-bordered .table-centered{
   text-align:center;
   }
   .importclass {
   font-size: 17px;
   line-height: 39px;
   text-decoration:underline;
   }
   a.download-anc {
   line-height: 38px;
   font-size: 16px;
   }
   .jrCats ul{
       display:none;
   }
    .clickAcc ul{
       display:none;
    }
    .clickAcc li, .catHolder {
        cursor: pointer;
    }
    .jrCats ul li {
        list-style: circle !important;
    }
    .catWrap {
        background: #efefef;
        width: 82.5%;
        border-radius: 4px;
        padding: 20px;
        border: 1px solid #ccc;
    }
    .resList.clickAcc {
        border-top: 1px solid #9c9c9c;
        padding-top: 10px;
    }
    .border_bottom {
        border-bottom: 1px solid #ccc;
        padding-bottom: 39px;
    }
    .resList {
        max-height: 200px;
        overflow: auto;
    }
    #searchPro {
        float: right;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-top: -7px;
    }
    #searchPro:focus{
        outline: none !important;
    }
   a.change-pro {
    line-height: 5.5 !important;
    font-size: 16px;
  }

  .afterdeff{
    display: none;
    color: red;
    margin-bottom: 20px;
  }
  .hidesub {
      visibility: hidden;
      color: red;
      margin-bottom: 3px;
      margin-top: -25px;
      display: inherit;
  }
  .subTotalPrice{
      margin-top: 20px;
  }

  .input-height .form-control {
    display: block;
    width: 100%;
    height: calc(1em + .9rem + 2px);
    padding:7px;
  }
  .partEq {
      float: left;
      /*padding: 0 2%;*/
  }
  label.rAl {
      text-align: right;
      width: 60%;
      padding-right: 10%;
  }
  .lAl {
      width: 40%;
  }
  .lAl input {
      display: inline-block;
      width: 72px;
      padding: 1px 6px;
      margin: 5px 0;
  }
  .proIparent {
      /*border-top: 4px solid #444;*/
  }

  .ischild {
    /*border-left: 100px solid #fff;*/
  }
  .issubchild {
    /*border-left: 200px solid #fff;*/
  }
  .proIparent .qty {
    border-left: 10px solid #777;
  }
  .ischild .qty {
      border-left: 10px solid #0080007d;
      margin-left: 10px;
  }
  .issubchild .qty {
      border-left: 10px solid #add6ad;
      margin-left: 10px;
  }
  input.qty {
      width: 60px !important;
  }
  .editProTable tbody td {
      padding-left: 5px;
      padding-right: 5px;
  }
  .editProTable tbody td p {
      margin-bottom: 0;
  }
  #proRes {
    padding-left: 14px;
    font-size: 11px;
  }
  #proRes li{
    margin-bottom: 5px;
  }
  .icon_content i{
    cursor: pointer;
    font-size: 18px;
  }
  .delivery_price{
    display: none;
  }
  .proDisc.delivery_cost,
  .delivery_cost,
  .subTotalCost ,
  .after_delivery_cost,
  .subtotal_total {
      color: red;
  }
  .is_yes_hard{
    color: red;
  }
  .dspln{
    display: none;
  }
  p.has_resale_certificate, .has_a_uez_cer, .has_a_stform_cer {
    position: relative;
    top: 8px;
    left: 10px;
}
.payment_person_wrap input {
    box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 3px 10px;
}
.shrinkTbl .form-group{
  margin-bottom: 0px;
}

.text {
    margin-left: 15px;
    margin-bottom: 15px;
}

input#save_ {
    font-size: 15px;
    margin: 10px;
}

/* flab_order table */

  .slab_boxes {
    display: flex;
    list-style: none;
    padding: 0px;
}
.slab_boxes li {
    margin: 0 13px 0 0px;
    padding: 0px;
}

ul.slab_boxes li input {
    width: 59px;
}

ul.slab_boxes.slab_title {
    width: 176px;
    margin-left: 53px;
}
ul.slab_boxes.slab_title li {
    width: 46%;
}
.cost_price{
  color: red;
  display: none;
}
.clearfix {
    clear: both;
}
.subTotArea{
  visibility: hidden;
}
a#clearPro {
    margin: 10px 0;
    display: block;
    float: right;
    font-size: 13px;
    color: #f44336;
}
.showCost .cost_price,
.showCost .delivery_cost {
  display: block;
}

.col-md-4.add_custom_row {
    padding: 9px;
}

.custom_item{
  width: 82px;
}
.input-height .form-control.qty{
  display: inline !important;
}
.des_input input {
  margin:10px 0 0px 0;
}
</style>
<?php $unassemble = $this->uri->segment(4); ?>
<div class="content-pageee">
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box">
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url().'orders';?>">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$edit_order['customer_id']; ?>"><?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$edit_order['id']; ?>">Order For <?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Edit</li>

                     </ol>
                  </div>
                  <h4 class="page-title">Order</h4>
               </div>
            </div>
         </div>
         <div cla="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                    <ul class="overview_list" id="lead_sub_menu">
                        <?php  echo modules::run('includes/order_sub_menu'); ?>
                     </ul> 
                     <div class="clear"></div>
                     <?= form_open_multipart($this->uri->uri_string(),'id="productData"'); ?>

                      <div class="row margin-top border_bottom" >
                         <div class="col-md-6">
                             <div class="row">
                                <div class="col-5">
                                   <div class="form-group">
                                      <label for="vendorName">Vendor</label>
                                      <select class="form-control" id="vendorName" name="vendor" class="vendorName pro_item" >
                                         <option value="0">Select...</option>
                                         <?php 
                                          $vSelected = ( $this->uri->segment(2) == 'tknobsOrders' )? '6':'';
                                         foreach ($vendor as $ven) { ?> 
                                         <option value="<?php echo $ven->id; ?>" <?php if( $vSelected == $ven->id ){echo 'selected';} ?> o_id = '<?php echo $this->uri->segment(4); ?>' >
                                            <?php echo ucfirst($ven->name); ?>      
                                         </option>
                                         <?php 
                                            } 
                                            ?>
                                      </select>
                                   </div>
                                </div>
                                <div class="col-5">
                                   <div class="form-group">
                                      <label for="styleName">Style</label>
                                      <select class="form-control" id="styleName" name="style" class="styleName" >
                                         <option value="0">Select...</option>
                                         <?php
                                          foreach ($jk_style as $key => $value) { ?>
                                              <option value="<?php echo $value->id; ?>" <?php if( $edit_order['style_id'] == $value->id ){echo 'selected';} ?>>
                                                  <?php echo ucfirst($value->style_name); ?>      
                                              </option>
                                         <?php }

                                          ?>
                                      </select>
                                   </div>
                                </div>
                            </div>
                             <div class="row margin-top">
                                <div class="col-md-12">
                                    <label>Category Wireframe</label>
                                    <div class="catWrap">
                                        <div class="mainCats clickAcc">
                                            <input type="text" id="searchPro" class='searchFound' placeholder="Search..." />
                                            <a class='catDrop' href='javascript:;'>< Categories ></a><p></p>
                                            <p class='catHolder'></p>
                                        </div>
                                        <div class="childCats clickAcc">
                                            <p class='catHolder catpro' data-child='yes'></p>
                                        </div>
                                        <div class="subChild clickAcc">
                                            <p class='catHolder'></p>
                                        </div>
                                        <div class="subSubChild clickAcc">
                                            <p class='catHolder'></p>
                                        </div>
                                        <div class="resList clickAcc">
                                            <ul id="mainCats"></ul>
                                            <ul id="childCats"></ul>
                                            <ul id="subChild"></ul>
                                            <ul id="subSubChild"></ul>
                                            <ul id="proRes"></ul>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                     </div>                     
                      <div class="table_append">
                          <a href="javascript:;" title="Remove all products." data-animation="fadein" data-plugin="custommodal_edit" id="clearPro"  data-overlaycolor="#38414a">Clear All</a>
                        <table class="table table-bordere editProTable table-centered mb-0 input-height">
                           <thead class="thead-light">
                              <tr>
                                 <th>Quantity</th>
                                 <th>Style/Item</th>
                                 <th>Description</th>
                                 <th>Cost</th>
                                 <th>Price</th>
                                 <th></th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php 
                            $total_product = []; 
                            if ( !empty($jk_products)) {
                                    foreach ($jk_products as $key => $fProduct) {
                                      /*pr( $fProduct );*/
                                        $parentC = uniqid();
                                        $style_id = ( $fProduct['style_id'] ) ? $fProduct['style_id']:$fProduct['POStyleId'];
                                        $newProArr = array(
                                            'jkpro_id'         =>  $fProduct['product_id'],
                                            'pro_qty'           => $fProduct['qty'],
                                            'style_id'          => $style_id,
                                            'style_code'        => $fProduct['style_code'],
                                            'style_name'        => $fProduct['style_name'],
                                            'item_code'         => $fProduct['item_code'],
                                            'item_description'  => $fProduct['item_description'],
                                            'width'             => $fProduct['width'],
                                            'height'            => $fProduct['height'],
                                            'depth'             => $fProduct['depth'],
                                            'price'             => $fProduct['price'],
                                            'description'       => $fProduct['description'],
                                            'descriptionII'     => $fProduct['descriptionII'],
                                            'u_price'           => $fProduct['u_price'],
                                            'item_cost'         => ($fProduct['final_cost']) ? :'0.00',
                                            'item_price'        => ($fProduct['total_price']) ? : '0.00',
                                            'main_counter'      => $parentC,
                                        );    

                                        $total_product[] = $fProduct['qty'];

                                        $calcPerc = ( ($newProArr['item_price']-$newProArr['item_cost'])/$newProArr['item_cost'] ) *100;
                                        $newProArr['prcnt_cost'] = decimalValue($calcPerc);
                                        $this->view('tknobs_orders/parent_template',$newProArr);
                                        
                                        foreach ($jk_products_child as $childkey => $childvalue) {
                                          $ChildCounter = uniqid();
                                          $Cstyle_id = ( $childvalue['style_id'] ) ? $childvalue['style_id']:$childvalue['POStyleId'];
                                          
                                          if ( $childvalue['pro_order_id'] == $fProduct['POProId'] ) {
                                            $newChildProArr = array(
                                              'jkPOCid'           => $childvalue['product_id'],
                                              'pro_parent_id'     => $childvalue['pro_parent_id'],
                                              'pro_qty'           => $childvalue['qty'],
                                              'style_id'          => $Cstyle_id,
                                              'style_code'        => $childvalue['style_code'],
                                              'style_name'        => $childvalue['style_name'],
                                              'item_code'         => $childvalue['item_code'],
                                              'width'             => $childvalue['width'],
                                              'height'            => $childvalue['height'],
                                              'depth'             => $childvalue['depth'],
                                              'price'             => $childvalue['price'],
                                              'u_price'           => $childvalue['u_price'],
                                              'item_description'  => $childvalue['item_description'],
                                              'description'       => $childvalue['description'],
                                              'descriptionII'     => $childvalue['descriptionII'],
                                              //'item_price'        => $childvalue['item_cost_unassembled_tariff'],
                                              'item_cost'         => ($childvalue['final_cost']) ? : '0.00',
                                              'item_price'        => ($childvalue['total_price']) ? : '0.00',
                                              'jk_product'        => $jkClass->getChildProducts( $fProduct['style_id'],$fProduct['item_code']),
                                              'parent_counter'    => $parentC,
                                              'childparent_counter' => $ChildCounter,
                                            );

                                            $total_product[] = $childvalue['qty'];

                                            $calcChildPerc = ( ($newChildProArr['item_price']-$newChildProArr['item_cost'])/$newChildProArr['item_cost'] ) *100;
                                            

                                            $newChildProArr['prcnt_cost'] = decimalValue($calcChildPerc);
                                            echo $this->load->view('tknobs_orders/child_template', $newChildProArr, TRUE);

                                          foreach ($jk_products_subchild as $subchildkey => $subchildvalue) {
                                          if ( $subchildvalue['pro_order_id'] == $childvalue['jkPOCid'] ) {

                                            $SCstyle_id = ( $subchildvalue['style_id'] ) ? $subchildvalue['style_id']:$subchildvalue['POStyleId'];
                                            $newSubChildProArr = array(
                                              'jkPOCid'             => $subchildvalue['product_id'],
                                              'pro_parent_id'       => $subchildvalue['pro_parent_id'],
                                              'pro_qty'             => $subchildvalue['qty'],
                                              'style_id'            => $SCstyle_id,
                                              'style_code'          => $subchildvalue['style_code'],
                                              'style_name'          => $subchildvalue['style_name'],
                                              'item_code'           => $subchildvalue['item'],
                                              'description'         => $subchildvalue['description'],
                                              'descriptionII'       => $subchildvalue['descriptionII'],
                                              'width'               => $subchildvalue['width'],
                                              'height'              => $subchildvalue['height'],
                                              'depth'               => $subchildvalue['depth'],
                                              'price'               => $subchildvalue['price'],
                                              'u_price'             => $subchildvalue['u_price'],
                                              'description'         => $subchildvalue['description'],
                                              'descriptionII'       => $subchildvalue['descriptionII'],
                                              'item_description'    => $subchildvalue['item_description'],
                                              'item_cost'           => ($subchildvalue['final_cost']) ?: '0.00',
                                              'item_price'          => ($subchildvalue['total_price']) ?: '0.00',
                                              'jk_product'          => $jkClass->getChildProducts( $childvalue['style_id'],$fProduct['Item_code']), 
                                              'parent_counter'      => $parentC,
                                              'childparent_counter' => $ChildCounter,
                                            );

                                            $total_product[] = $subchildvalue['qty'];

                                            $calcSubChildPerc = ( ($newSubChildProArr['item_price']-$newSubChildProArr['item_cost'])/$newSubChildProArr['item_cost'] ) *100;

                                            $newSubChildProArr['prcnt_cost'] = decimalValue($calcSubChildPerc);
                                            echo $this->load->view('tknobs_orders/subchild_template', $newSubChildProArr, TRUE);
                                          }
                                        } 
                                      }
                                    }
                                  }
                                } 
                              ?>
                           </tbody>
                        </table><br>
                      </div>
                    <div class="row subTotArea border_bottom">
                          <div class="col-md-6"></div>
                          <div class="col-md-6"><br>
                            <!-- <div class="subTotalPrice clearfix">
                              <label class="rAl partEq">Total Product</label>
                              <span class="total_product"><?php echo array_sum( $total_product ); ?></span>
                            </div> -->

                              <div class="subTotalPrice clearfix">
                                <label class="rAl partEq">Item Total Price</label>
                                <span class="SP"><?php echo decimalValue($edit_order['subtotal']); ?></span>
                                <input type="hidden" class="subtotal" name="subtotal" value="<?= $edit_order['subtotal']; ?>">
                              </div>

                              <div class="proDisc subTotalCost clearfix dspln">
                                <label class="rAl partEq">Item Total Cost</label>
                                <span class='subCostInnter hidesub'></span>
                                <input type="hidden" class="cost_t_price" name="cost_t_price" value="<?= $cPrice; ?>">
                              </div>
        
                              <div class="proDisc delivery_price clearfix">
                                <label class="rAl partEq">Delivery Price</label>
                                <span class="lAl partEq">
                                  <input type='text' autocomplete="off" value="<?php echo $edit_order['delivery_price']; ?>" name="delivery_price" class="delivery_price_inp">
                                </span>
                              </div>
                              <div class="proDisc delivery_cost dspln clearfix">
                                <label class="rAl partEq">Delivery Cost</label>
                                <span class="lAl partEq">
                                  <input type='text' autocomplete="off" value="<?php echo $edit_order['delivery_cost']; ?>" name="delivery_cost" class="delivery_cost_inp"> <span class="dcperc"></span>
                                </span>
                              </div>

                              <div class="proDisc after_delivery_price clearfix">
                                <label class="rAl partEq">Item/Delivery Price Subtotal</label>
                                <span class="lAl partEq afterDeliveryPrice">$<?= $edit_order['subtotal']; ?></span>
                                <input type="hidden" id="afterDeliveryPrice" name="afterDeliveryPrice" value="<?= $edit_order['subtotal']; ?>">
                              </div>
                              <div class="proDisc after_delivery_cost dspln clearfix">
                                <label class="rAl partEq">Item/Delivery Cost Subtotal</label>
                                <span class="lAl partEq afterDeliveryCost">$<?php echo $cPrice; ?></span>
                                <input type="hidden" id="afterDeliveryCost" value="<?php echo $cPrice; ?>" name="afterDeliveryCost">
                              </div>

                              <div class="proDisc clearfix">
                                <label class="rAl partEq">Discount</label>
                                <span class="lAl partEq">
                                  $ <input type='text' autocomplete="off" value="<?php echo $edit_order['discount']; ?>" name="discount" class="perc_amount"> - <input type='text' autocomplete="off" value="<?php echo $edit_order['discount_per']; ?>" name="discount_per" class="price_perc"> %<br>
                                </span>
                              </div>

                              <div class="proDisc clearfix">
                                <label class="rAl partEq">Subtotal</label>
                                <span class="lAl partEq afterDiscountPrice"></span>
                                <input type="hidden" id="afterDiscountPrice" name="afterDiscountPrice">
                              </div>
                              <div class="proDisc subtotal_total dspln clearfix">
                                <label class="rAl partEq">Subtotal Cost</label>
                                <span class="lAl partEq afterDiscountCost"></span>
                                <input type="hidden" id="afterDiscountCost" name="afterDiscountCost">
                              </div>

                              <div class="proTax clearfix">
                                <label class="rAl partEq">Sales Tax</label>
                                      <?php 
                                          if( $edit_order['resale_certificate'] == 'no' && $edit_order['has_a_uez'] == 'no' && $edit_order['has_a_stform'] == 'no'  ){ ?>
                                            <span class="lAl partEq"><span class="taxx"><?php echo order_tax; ?></span>% (<span class="txamt"><?php echo decimalValue( ($edit_order['total'] * order_tax) / 100 ); ?></span>) </span>
                                          <input type="hidden" name="tax" class="tax_hidden_val" value="<?= $edit_order['tax'] ?>">
                                          <input type="hidden" id="txxRate" data-tax='<?php echo order_tax; ?>' value="<?php echo order_tax; ?>">
                                          
                                    <?php }else{ ?>

                                          <span class="lAl partEq"><span class="taxx">0</span>% (<span class="txamt">0.00</span>) </span>
                                          <input type="hidden" name="tax" class="tax_hidden_val" value="0">
                                          <input type="hidden" id="txxRate" data-tax='<?php echo order_tax; ?>' value="0">

                                      <?php } ?>

                              </div> 
                               <div class="proGtotal clearfix">
                                <label class="rAl partEq">Grand Total</label>
                                  <span class="lAl partEq">
                                    <?php 
                                        if ( !empty( $edit_order['discount'] ) ) {
                                          $subDis = $edit_order['subtotal'] - $edit_order['discount'];
                                        }else{
                                          $subDis = $edit_order['discount'];
                                        }
                                        
                                        if( !empty( $edit_order['tax'] ) ){
                                            $ttP = $edit_order['tax'] + $subDis;
                                         }
                                          
                                    ?>
                                      <input type='text' autocomplete="off" name="total" data-total='<?php echo decimalValue($ttP); ?>' value="<?php echo decimalValue($ttP); ?>" class="net_price">
                                  </span>
                              </div>
                              <div class="proDisc after_delivery_price clearfix">
                                <label class="rAl partEq">Paid</label>
                                <span class="paidAmount">$<?= ( $edit_order['paid_amount'] ) ? decimalValue($edit_order['paid_amount']):'0.00'; ?>
                                <span class="paidAmountPercent"></span></span>
                                <input type="hidden" id="paidAmount" name="paid"  value="<?= ( $edit_order['paid_amount'] ) ? decimalValue($edit_order['paid_amount']):'0.00'; ?>">
                              </div>
                              <div class="proDisc totalDue clearfix">
                                <label class="rAl partEq">Total Due</label>
                                <span class="lAl partEq totalAmountDue"></span>
                                <input type="hidden" name="total_due" class="totalAmountValue" value="">
                              </div>
                        </div><br><br>
                      </div>
                      <div class="col-md-12 margin-top shrinkTbl">
                           <div class="form-group row">
                              <label class="col-md-3">Delivery Options</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input class="is_pickup" type="radio" id="inlineRadioPick1" value="no" name="is_pickup"  <?php if( $edit_order['is_pickup'] == 'no' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioPick1"> Customer </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input class="is_pickup" type="radio" id="inlineRadioPick2"  value="yes" name="is_pickup" <?php if( $edit_order['is_pickup'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioPick2"> Showroom </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input class="is_pickup" type="radio" id="inlineRadioPick3"  value="mf" name="is_pickup" <?php if( $edit_order['is_pickup'] == 'mf' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioPick3"> Manufacturer </label>

                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Hard Date</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="inlineRadioHard1" value="no" class="hard_date" name="hard_date"  <?php if( $edit_order['hard_date'] == 'no' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioHard1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="inlineRadioHard2" value="yes" class="hard_date" name="hard_date" <?php if( $edit_order['hard_date'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioHard2"> Yes </label>
                                </div>
                              </div>
                           </div>

                           <div class="form-group row">
                              <label class="col-md-3">Has a Resale Certificate</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="inlineRadioHas1" value="no" class="resale_certificate" data_check="no" name="resale_certificate"  <?php if( $edit_order['resale_certificate'] == 'no' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioHas1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="inlineRadioHas2" value="yes"  class="resale_certificate" data_check="yes" name="resale_certificate" <?php if( $edit_order['resale_certificate'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioHas2"> Yes </label>
                                   <p class="has_resale_certificate <?php if( $edit_order['resale_certificate'] != 'yes' ){ echo "dspln"; } ?>"><a target="_blank" href="https://www.state.nj.us/treasury/taxation/pdf/other_forms/sales/st3.pdf">Reseller certificate</a></p>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Is Locked</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="islocked1"  value="no" class="is_lock" name="is_locked" <?php if( $edit_order['is_locked'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="islocked1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="islocked2" onclick="on()" value="yes" class="is_lock" name="is_locked" <?php if( $edit_order['is_locked'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="islocked2"> Yes </label>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Payment Person</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Payment_Person1" value="no" class="payment_person" name="payment_person" <?php if( $edit_order['payment_person'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="Payment_Person1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Payment_Person2" value="yes" class="payment_person" name="payment_person" <?php if( $edit_order['payment_person'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="Payment_Person2"> Yes </label>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row payment_person_wrap <?php if( $edit_order['payment_person'] != 'no' ){ echo "dspln"; } ?> ?>">
                                <label class="col-md-3">Payment Person Name</label>
                                <div class="col-md-9">
                                <input type="text" class="radio radio-info form-check-inline" name="payment_person_name" placeholder="Enter name..." id="payment_person_name" value="<?php echo $edit_order['payment_person_name']; ?>">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Has a ST-5</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_uez1" value="no" class="has_a_uez" data_check = "no" name="has_a_uez" <?php if( $edit_order['has_a_uez'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="has_a_uez1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_uez2" value="yes" class="has_a_uez" data_check = "yes" name="has_a_uez" <?php if( $edit_order['has_a_uez'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="has_a_uez2"> Yes </label>
                                  <p class="has_a_uez_cer <?php if( $edit_order['has_a_uez'] != 'yes' ){ echo "dspln"; } ?>"><a target="_blank" href="https://www.state.nj.us/treasury/taxation/pdf/other_forms/sales/reg1e.pdf">ST-5 certificate</a></p>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Has a St Form (NY/NJ) </label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_stform1" value="no" class="has_a_stform" data_check = "no" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="has_a_stform1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_stform2" value="yes" class="has_a_stform" data_check = "yes" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="has_a_stform2"> Yes </label>

                                   <p class="has_a_stform_cer <?php if( $edit_order['has_a_stform'] != 'yes' ){ echo "dspln"; } ?>"><a target="_blank" href="https://www.state.nj.us/treasury/taxation/pdf/other_forms/sales/st8.pdf">ST8-NJ</a> | <a target="_blank" href="https://www.tax.ny.gov/pdf/current_forms/st/st124_fill_in.pdf">ST124-NY</a></p>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Is Colourtone</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Is_Colourtone1" value="no" name="Is_Colourtone" <?php if( $edit_order['Is_Colourtone'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="Is_Colourtone1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Is_Colourtone2" value="yes" name="Is_Colourtone" <?php if( $edit_order['Is_Colourtone'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="Is_Colourtone2"> Yes </label>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Is Contract</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Is_Contract1" value="no" name="Is_Contract" <?php if( $edit_order['Is_Contract'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="Is_Contract1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Is_Contract2" value="yes" name="Is_Contract" <?php if( $edit_order['Is_Contract'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="Is_Contract2"> Yes </label>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="" class="col-md-12 hard_date_wrap">
                                Requested Delivery Date 
                                <?php 
                                if( $edit_order['hard_date'] == 'yes' ){ 
                                  echo "<span class='is_yes_hard'>- Hard Date</span>";
                                } ?>
                              </label>
                              <div class="col-md-5">
                                 <input type="text" autocomplete="off" class="form-control" id="requested_delivery_date" name="requested_delivery_date" value="<?= $edit_order['requested_delivery_date']; ?>" ><br>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="" class="col-md-12">Requested Delivery Date Notes</label>
                              <div class="col-md-5">
                                 <textarea class="form-control col-md-12" id="" rows="2" name="requested_notes" ><?= $edit_order['requested_date_notes']; ?></textarea><br>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="ordering_id">Show General/Ordering Notes</a></label>
                              <div class="col-md-5" id="order_id" style="display: none;" >
                                 <textarea rows="2" name="ordering_note" class="form-control" cols="50"><?= $edit_order['ordering_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="assembly_id">Show Assembly Notes</a></label>
                              <div class="col-md-5" id="ass_id" style="display: none;" >
                                 <textarea rows="2" name="assembly_note" class="form-control" cols="50"><?= $edit_order['assembly_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="installation_id">Show Installation Notes</a></label>
                              <div class="col-md-5" id="inst_id" style="display: none;" >
                                 <textarea rows="2" name="installation_note" class="form-control" cols="50"><?= $edit_order['installation_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="delivery_id">Show Delivery Details</a></label>
                              <div class="col-md-5" id="del_id" style="display: none;" >
                                 <textarea rows="2" name="delivery_note" class="form-control" cols="50"><?= $edit_order['delivery_note']; ?></textarea>
                              </div>
                           </div>
                        </div>

                     <div class="row">
                         <div class="col-md-12">
                            <input type="hidden" id="orderID" name="order_id" value="<?php echo $this->uri->segment(4); ?>">
                            <input type="submit" class="btn btn-lg btn-success waves-effect waves-light" value="Save" id="save_" name="submit_product" >
                         </div>
                     </div>
                     <?= form_close(); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>