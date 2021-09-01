<style>
   .des_input {
     width: 100%;
   }
   .des_first{
    margin-bottom: 10px;
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
  .subTotal{
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
      padding: 0 2%;
  }
  label.rAl {
      text-align: right;
      width: 75%;
      padding-right: 10%;
  }
  .lAl {
      width: 23%;
  }
  .lAl input {
      display: inline-block;
      width: 80px;
      padding: 1px 6px;
      margin: 5px 0;
  }
  .editProTable tr {
      border-bottom: 1px solid #ccc;
  }
  input.qty {
      width: 48px !important;
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
  .delivery_cost{
    visibility: hidden;
  }
  .delivery_price{
    display: none;
  }
  .proDisc.delivery_cost {
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

</style>
<div class="content-pageee">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>order">Order</a></li>
                                <li class="breadcrumb-item"><a href=" <?php echo base_url()."order/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Create Order</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Create Order</h4>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-12">   
                    <div class="card">
                        <div class="card-body">
                          <div class="row margin-top">
                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="radio radio-info form-check-inline">
                                    <input autocomplete="off" type="radio" id="assemble_item" class="assemble_val" value="0" name="assemble_value" checked="" order_id="81">
                                    <label for="assemble_item"> Assembled </label>
                                </div>
                                <div class="radio form-check-inline">                            
                                    <input autocomplete="off" type="radio" id="uassemble_item" class="assemble_val" value="1" name="assemble_value" order_id="81">
                                    <label for="uassemble_item"> Unassembled </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6"> 
                            </div>
                          </div>

                     <?= form_open_multipart($this->uri->uri_string()); ?> 
                     <div class="row margin-top border_bottom" >
                         <div class="col-md-6">
                             <div class="row">
                                <div class="col-5">
                                   <div class="form-group">
                                      <label for="vendorName">Vendor</label>
                                      <select class="form-control" id="vendorName" name="vendor" class="pro_item" >
                                         <option value="0">Select...</option>
                                         <?php 
                                            foreach ($vendors as $ven) 
                                            { 
                                            ?> 
                                         <option value="<?php echo $ven->id; ?>" <?= (($ven->id == $edit_order['vendor'])?"selected":""); ?> >
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
                                      <select class="form-control" id="styleName" name="style" class="pro_item" >
                                         <option value="0">Select...</option>
                                         
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
                                            <p class='catHolder'></p>
                                        </div>
                                        <div class="subChild clickAcc">
                                            <p class='catHolder'></p>
                                        </div>
                                        <div class="resList clickAcc">
                                            <ul id="mainCats"></ul>
                                            <ul id="childCats"></ul>
                                            <ul id="subChild"></ul>
                                            <ul id="proRes"></ul>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                        <div class="col-md-6">
                           <div class="row">
                              <div class="col-md-6 display" data-v="1">
                                 <div class="imp-label">
                                    <label>Import 2020 Design</label>
                                 </div>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file_upload" name="file_upload" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                 </div>
                              </div>
                              <div class="col-md-6 position-relative">
                                 <div class="btn_content">
                                    <div class="btn_imp">
                                       <a href="javascript:;" class="append_input btn btn-success waves-effect waves-light" id="importcustpro" name="submit" >Import</a>
                                    </div>
                                    <div class="btn_imp down_btn">
                                       <div class="download-file">
                                          <a href="<?= base_url(); ?>assets/productOrderfile/orderImportnew.xlsx" class="download-anc">Download Sample</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                          </div>
                          <div class="row margin-top">
                              <div class="col-md-4">
                                 <label for="vendorName">Profit Multiplier</label>
                                 <select class="form-control extraTax" id="profit_multipler" name="profit_multipler">
                                    <option value="0" >00</option>
                                    <?php 
                                       for( $i = 5; $i <= 75; $i++ ){ ?>
                                    <option value="<?= $i/100; ?>" ><?= $i/100 .'%'; ?></option>
                                    <?php }
                                       ?>
                                 </select>
                              </div>
                              <div class="col-md-4 import_input">
                                 <label for="vendorName">Sale Percentage</label>
                                 <select class="form-control extraTax" id="sale_percentage" name="sale_percentage">
                                    <option value="0">00</option>
                                    <?php 
                                       for( $i = 15; $i <= 40; $i++ ){ ?>
                                    <option value="<?= $i/10; ?>" ><?= $i/10 .'%'; ?></option>
                                    <?php }
                                       ?>
                                 </select>
                              </div>
                                <div class="col-md-4">
                                   <a href="<?php echo base_url(); ?>orders/change_product" title="Change Product" data-animation="fadein" data-plugin="custommodal_edit" class="change-pro margin-top"  data-overlaycolor="#38414a">Change Product</a>
                                </div>
                                </div>
                           </div>
                        </div>
                     <div class="table-responsive mt-4 table_append">
                        <table class="table table-bordered table-centered mb-0">
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
                                 if ( !empty( $product_order ) ) {
                                   $i = 0;
                                   $j = 0;
                                       foreach ($product_order as $Key => $value) {
                                        if( $value['product_id'] == 0 ){ $color = "style='background:#f2dede'"; }else{ $color="";} 
                                        if( $value['product_id'] == 0 ){ $itemcode = $value['Item_code']; }else{ $itemcode = $value['pkIC']; } 
                                        if( $value['product_id'] == 0 ){ $style = $value['styId']; }else{ $style = $value['sc']; }

                                        if( !empty( $value['qty'] ) ){ $qtys = $value['qty']; }else{ $qtys = '1'; }



                                        ?>
                              <tr id='pro_<?= $value['product_id']; ?>' class="add_row<?= $i; ?>" <?= $color; ?>>
                                 <td>
                                    <input type='hidden' value='<?= $itemcode; ?>' class='pk_Item_Code' pr-id='<?= $value['product_id']; ?>' name='product[<?= $i; ?>][item_code]'>
                                    <input type='hidden' value='<?= $style; ?>' class='pk_Item_Code' pr-id='<?= $value['product_id']; ?>' name='product[<?= $i; ?>][style_id]'>
                                    <input type='number' class='form-control qty' style='width:70px;' min = "1" value='<?= $qtys; ?>' name='product[<?= $i; ?>][qty]'  data-id = '<?= $i; ?>' id="qty<?= $value['product_id']; ?>" >
                                 </td>
                                 <td>
                                    <span><?= $style; ?></span>/
                                    <span><?= $itemcode; ?></span>
                                 </td>
                                 <td style="width: 46%;">
                                    <p><?= $value['sn'].'/'.$value['pkID']." ".$value['Width']."W x".$value['Height']."H x".$value['Depth']."D x"; ?></p>
                                    <div class="des_content">
                                       <div class="des_input des_first">
                                          <input type="text" name='product[<?= $i; ?>][description]' 
                                             value="<?= $value['description'] ?>" class="form-control">
                                       </div>
                                       <div class="des_input des_sec">
                                          <input type="text" name='product[<?= $i; ?>][descriptionII]' 
                                             value="<?= $value['descriptionII'] ?>" class="form-control">
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <?php
                                       if( !empty( $value['price'] ) ){
                                           $totalpr = $value['item_assembly_price'] - $value['price'];
                                       }else{
                                           $totalpr = $value['item_assembly_price'];
                                       }
                                       
                                       if( !empty( $value['u_price'] || $value['u_price'] != '0'  ) ){
                                           $valp = $value['u_price'];
                                       }else{
                                           $valp = $value['item_assembly_price'];
                                       }
                                       
                                       if( !empty( $value['price'] ) ){
                                           $vp = $value['price'];
                                       }else{
                                           $vp = '0';
                                       }
                                       
                                       ?>
                                    <div class="cost_content">
                                       <div class="cost_input cost_first">
                                          <input type='text' width='100px' class='form-control assembprice' name='product[<?= $i ?>][price]' id='assembprice<?= $i ?>' value='<?= $vp ?>' data-price='<?= $valp; ?>' count='<?= $i ?>' >
                                          <div class='input-group-append'>
                                             <span class='input-group-text assembprice<?= $i ?>'><?= $totalpr; ?></span>
                                          </div>
                                       </div>
                                       <div class="cost_input cost_sec">
                                          <input type="text" class="form-control aftercharge" name='product[<?= $i; ?>][aftercharge]' value="<?= $valp; ?>" id="aftercharge<?= $i; ?>">
                                       </div>
                                    </div>
                                 </td>
                                 <td><span class='align-center' ><?= $value['cabinet_assembly_price'] ?></span></td>
                                 <td>
                                    <div class="icon_content">
                                       <div class="f_icon add_icon">
                                          <i data-prid='<?= $value['product_id']; ?>' class="mdi mdi-plus-circle mr-1 add_field" data_btn="<?= $i; ?>" parent_id="<?= $value['id']; ?>"></i>
                                          <input type="hidden" value="<?= $value['product_id']; ?>" name="product[<?= $i ?>][product_id]">
                                          <input type="hidden" value="<?= $this->uri->segment(3); ?>" name="product[<?= $i ?>][order_id]">
                                       </div>
                                       <div class="f_icon delete_icon">
                                          <i data-prid='<?= $value['product_id']; ?>' class="mdi mdi-delete delete_Items"></i>
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                              <?php if(!empty( $product_order_child ) ){
                                 foreach( $product_order_child as $values ){ 
                                     
                                 
                                     if( $value['id'] == $values['pro_order_id']  ){
                                 
                                 ?>
                              <tr style='background:#dff0d8'>
                                 <td>
                                  
                                    <input type='number' class='form-control qty' style='width:70px;' 
                                       min = '1' value='<?= $values['qty']; ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][qty]'  data-id = '<?= $j; ?>'>
                                 </td>
                                 <td>
                                    <span name='product[<?= $i; ?>][child_item][<?= $j; ?>][Item_code]'><?= $values['item'] ?></span>/
                                    <span name='product[<?= $i; ?>][child_item][<?= $j; ?>][style_id]'><?= $values['style'] ?></span>
                                 </td>
                                 <td>
                                    <input type='text' name='product[<?= $i; ?>][child_item][<?= $j; ?>][description]' value='<?= $values['description'] ?>' class='form-control'>
                                 </td>
                                 <td></td>
                                 <td>
                                    <input class='form-control aftercharge' name='product[<?= $i; ?>][child_item][<?= $j; ?>][price]' id='aftercharge<?= $j; ?>' value='<?= $values['price'] ?>' data-price='<?= $values['price'] ?>'>
                                 </td>
                                 <td>
                                    <i class='mdi mdi-delete delete_Items'></i><input type='hidden' name='product[<?= $i; ?>][child_item][<?= $j; ?>][parent_id]' value='<?= $values['pro_order_id'] ?>'>
                                 </td>
                              </tr>
                              <?php } $j++;  }
                                 } 
                                 ?>
                              <?php $i++;  }
                                 } else { ?>
                              <tr class="removetr">
                                 <td colspan="7" style="text-align:center;">No Products</td>
                              </tr>
                              <?php }
                                 ?>
                           </tbody>
                        </table><br>
                      </div>
                        <div class="row">
                          <div class="col-md-6"></div>
                          <div class="col-md-6">
                            <div class="subTotal clearfix">
                              <label class="rAl partEq">Subtotal</label>
                              <span class="lAl partEq">
                    <span class='hidesub'> <span class="morkpamt" price-morkpamt = "<?= $cPrice; ?>" p_mamt="" ><?php echo $cPrice; ?></span>(<span class="morkpperc"><?php echo ceil( ($sPrice-$cPrice)/$cPrice*100); ?></span>%)<br></span>
                                <span class="SP"><?php echo $sPrice; ?></span>
                              </span>
                              <input type="hidden" class="cost_t_price" name="cost_t_price" value="">
                              <input type="hidden" class="subtotal" name="subtotal" value="">
                            </div>
                            <div class="proDisc clearfix">
                               <?php if ( !empty($edit_order['discount'])  ) {
                                    $total_dis = $edit_order['discount'];
                                    $sPrice = $sPrice - $total_dis;
                                  } ?>
                              <label class="rAl partEq">Discount</label>
                              <span class="lAl partEq">
                                <input type='text' autocomplete="off" value="<?= $edit_order['discount_per'] ?>" name="discount_per" class="price_perc"> %<br>
                                <input type='text' autocomplete="off" value="<?= $edit_order['discount'] ?>" name="discount" class="perc_amount"> $<br> 
                              </span>
                            </div>
                            <div class="proTax clearfix">
                              <label class="rAl partEq">Tax</label>
                                    <?php 
                                        if( $edit_order['resale_certificate'] == 'yes' || $edit_order['has_a_uez'] == 'yes' || $edit_order['has_a_stform'] == 'yes'  ){
                                    ?>
                                        
                                        <span class="lAl partEq"><span class="taxx">0</span>% (<span class="txamt">0.00</span>) </span>
                                        <input type="hidden" id="txxRate" data-tax='<?php echo order_tax; ?>' value="0">
                                  <?php }else{ ?>
                                   <span class="lAl partEq"><span class="taxx"><?php echo order_tax; ?></span>% (<span class="txamt"><?php echo number_format( ($sPrice/100) * order_tax,2); ?></span>) </span>
                                         <input type="hidden" id="txxRate" data-tax='<?php echo order_tax; ?>' value="<?php echo order_tax; ?>">
                                    <?php } ?>

                                     <input type="hidden" name="tax" class="tax_hidden_val" value="<?= $edit_order['tax'] ?>">
                            </div>  
                            <div class="proDisc delivery_price">
                              <label class="rAl partEq">Delivery Price</label>
                              <span class="lAl partEq">
                                <input type='text' autocomplete="off" value="<?= $edit_order['delivery_price'] ?>" name="delivery_price" class="delivery_price_inp">
                              </span>
                            </div>
                            <div class="proDisc delivery_cost">
                              <label class="rAl partEq">Delivery Cost</label>
                              <span class="lAl partEq">
                                <input type='text' autocomplete="off" value="<?= $edit_order['delivery_cost'] ?>" name="delivery_cost" class="delivery_cost_inp">
                              </span>
                            </div>
                            <div class="proGtotal clearfix">
                              <label class="rAl partEq">Total</label>
                              <span class="lAl partEq">
                    <input type='text' autocomplete="off" name="total" data-total='<?php echo number_format($ttP,2); ?>' value="<?php echo number_format($ttP,2); ?>" class="net_price">
                  </span>
                            </div>
                          </div>
                      </div><br><br>
                     </div>

                     <div class="col-md-12 margin-top shrinkTbl">
                           <div class="form-group row">
                              <label class="col-md-3">Delivery Options</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input class="is_pickup" type="radio" id="inlineRadioPick1" required value="no" name="is_pickup"  <?php if( $edit_order['is_pickup'] == 'no' ){ echo "checked"; } ?>>
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
                                   <input type="radio" id="inlineRadioHard1" value="no" required class="hard_date" name="hard_date"  <?php if( $edit_order['hard_date'] == 'no' ){ echo "checked"; } ?>>
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
                                   <input type="radio" id="inlineRadioHas1" value="no" required class="resale_certificate" data_check="no" name="resale_certificate"  <?php if( $edit_order['resale_certificate'] == 'no' ){ echo "checked"; } ?>>
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
                                   <input type="radio" id="islocked1"  value="no" required class="is_lock" name="is_locked" <?php if( $edit_order['is_locked'] == 'no' ){ echo "checked"; } ?> >
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
                                   <input type="radio" id="Payment_Person1" value="no" required class="payment_person" name="payment_person" <?php if( $edit_order['payment_person'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="Payment_Person1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Payment_Person2" value="yes" class="payment_person" name="payment_person" <?php if( $edit_order['payment_person'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="Payment_Person2"> Yes </label>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row payment_person_wrap <?php if( $edit_order['payment_person'] == 'yes' ){ echo "dspln"; } ?> ?>">
                                <label class="col-md-3">Payment Person Name</label>
                                <div class="col-md-9">
                                <input type="text" class="radio radio-info form-check-inline" name="payment_person_name" placeholder="Enter name..." id="payment_person_name" value="<?php echo $edit_order['payment_person_name']; ?>">
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Has a ST-5</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_uez1" value="no" required class="has_a_uez" data_check = "no" name="has_a_uez" <?php if( $edit_order['has_a_uez'] == 'no' ){ echo "checked"; } ?> >
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
                                   <input type="radio" id="has_a_stform1" value="no" class="has_a_stform" required data_check = "no" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'no' ){ echo "checked"; } ?> >
                                   <label for="has_a_stform1"> No </label>
                                </div>
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="has_a_stform2" value="yes" class="has_a_stform" data_check = "yes" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="has_a_stform2"> Yes </label>

                                   <p class="has_a_stform_cer"><a target="_blank" href="https://www.state.nj.us/treasury/taxation/pdf/other_forms/sales/st8.pdf">ST8-NJ</a> | <a target="_blank" href="https://www.tax.ny.gov/pdf/current_forms/st/st124_fill_in.pdf">ST124-NY</a></p>
                                </div>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-3">Is Colourtone</label>
                              <div class="col-md-9">
                                <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="Is_Colourtone1" value="no" name="Is_Colourtone" required <?php if( $edit_order['Is_Colourtone'] == 'no' ){ echo "checked"; } ?> >
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
                                   <input type="radio" id="Is_Contract1" value="no" name="Is_Contract" required <?php if( $edit_order['Is_Contract'] == 'no' ){ echo "checked"; } ?> >
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
                              <div class="col-md-12">
                                 <input type="text" autocomplete="off" class="form-control" id="requested_delivery_date" name="requested_delivery_date" required value="<?= $edit_order['requested_delivery_date']; ?>" >
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="" class="col-md-12">Requested Delivery Date Notes</label>
                              <div class="col-md-12">
                                 <textarea class="form-control col-md-12" id="" rows="2" name="requested_notes" ><?= $edit_order['requested_date_notes']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="ordering_id">Show General/Ordering Notes</a></label>
                              <div class="col-md-12" id="order_id" style="display: none;" >
                                 <textarea rows="2" name="ordering_note" class="form-control" cols="50"><?= $edit_order['ordering_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="assembly_id">Show Assembly Notes</a></label>
                              <div class="col-md-12" id="ass_id" style="display: none;" >
                                 <textarea rows="2" name="assembly_note" class="form-control" cols="50"><?= $edit_order['assembly_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="installation_id">Show Installation Notes</a></label>
                              <div class="col-md-12" id="inst_id" style="display: none;" >
                                 <textarea rows="2" name="installation_note" class="form-control" cols="50"><?= $edit_order['installation_note']; ?></textarea>
                              </div>
                           </div>
                           <div class="form-group row">
                              <label class="col-md-12"><a href="javascript:void(0)" id="delivery_id">Show Delivery Details</a></label>
                              <div class="col-md-12" id="del_id" style="display: none;" >
                                 <textarea rows="2" name="delivery_note" class="form-control" cols="50"><?= $edit_order['delivery_note']; ?></textarea>
                              </div>
                           </div>
                        </div>
                      
                     <div class="row">
                        <div class="col-md-12">
                           <div class="text-right">
                              <input type="submit" class="btn btn-lg btn-success waves-effect waves-light" value="Save" id="save_" name="submit_product" >
                           </div>
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