<style>
    .des_input {
        width: 49%;
    }
    .des_content,.cost_content,.icon_content,.btn_content{
        display: flex;
    }
    .des_input.des_sec {
        margin-left: 10px;
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
        margin-top: 1em;
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
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>orders">Orders</a></li>
                                <li class="breadcrumb-item"><a href=" <?php echo base_url()."orders/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Order</li>
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
                                <?php  echo modules::run('includes/order_sub_menu');?>
                            </ul>
                        <div class="clear"></div>
                            <div class="row margin-top">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
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
                                            <div class="col-md-3 import_input">
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
                                            <div class="col-md-3 display display_none" data-v="0">
                                                <div class="imp-label">
                                                    <label>Import 2020 Design</label>
                                                </div>
                                                <div class="custom-file">
                                                      <input type="file" class="custom-file-input" id="file_upload" name="file_upload" aria-describedby="inputGroupFileAddon01">
                                                      <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 position-relative">
                                                <div class="btn_content">
                                                    <div class="btn_imp import_btn">
                                                      <button class="btn btn-success waves-effect waves-light append_input" id="importcustpro" name="submit" >Import</button>
                                                    </div>
                                                    <div class="btn_imp down_btn">
                                                      <div class="download-file" style="display:none">
                                                        <a href="<?= base_url(); ?>assets/productOrderfile/orderImportnew.xlsx" class="btn btn-danger waves-effect waves-light">Download Sample</a>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            
                            
                            <?= form_open_multipart($this->uri->uri_string()); ?> 
                                <div class="row margin-top">
                                    <div class="col-1">
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
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="styleName">Style</label>
                                            <select class="form-control" id="styleName" name="style" class="pro_item" >
                                                <option value="0">Select...</option>
                                                <?php 
                                                    foreach ($styles as $st) 
                                                    { 
                                                ?> 
                                                        <option value="<?php echo $st->id; ?>"><?php echo $st->style_name;?></option>
                                                <?php
                                                     } 
                                                ?>
                                            </select> 
                                        </div>
                                    </div> 
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control pro_cat" id="category" name="category" class="pro_item" >
                                                <option value="0">Select...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <div class="subCatogery">
                                                <label for="category">Category</label>
                                                <select class="form-control pro_cat" id="category" name="category" class="pro_item" >
                                                    <option value="0">Select...</option>
                                                </select>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <div class="subchildCatogery">
                                                <label for="category">Category</label>
                                                <select class="form-control pro_cat" id="category" name="category" class="pro_item" >
                                                    <option value="0">Select...</option>
                                                </select>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                           <label for="first_name">Add Item</label>
                                            <select class="js-example-basic-single form-control" id="selectItem" name="selectItem" >
                                            <?php 
                                                if( !empty( $vendor_pro ) ){ ?>
                                                    <option>Select Item</option>
                                                <?php    
                                                    foreach( $vendor_pro as $key => $value ){ 
                                                    ?>
                                                       <option <?php //echo $disble; ?> value = '<?= $value['id']; ?>' ><?= $value['Item_Name']; ?></option> 
                                                <?php }
                                                }
                                            ?>
                                            </select> 
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top">
                                    <div class="col-md-3">
                                         <a href="<?php echo base_url(); ?>orders/change_product" title="Change Product" style="color:#fff !important; width:100%;" data-animation="fadein" data-plugin="custommodal_edit" class="btn btn-success waves-effect waves-light"  data-overlaycolor="#38414a">Change Product</a>
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
                                                  ?>
                                                 <tr id='pro_<?= $value['product_id']; ?>' class="add_row<?= $i; ?>">
                                                <td>
                                                  <input type='hidden' value='<?= $value['Item_Code']; ?>' class='pk_Item_Code' pr-id='<?= $value['product_id']; ?>' name='pk_Item_Code[]'>
                                                  <input type='number' class='form-control qty' style='width:70px;' min = "1" value='<?= $value['qty']; ?>' name='product[<?= $i; ?>][qty]'  data-id = '<?= $i; ?>' id="qty<?= $value['product_id']; ?>" >
                                                </td>
                                                <td>
                                                    <span><?= $value['sc']; ?></span>/
                                                    <span><?= $value['Item_Code']; ?></span>
                                                </td>
                                                <td style="width: 46%;"><p><?= $value['sn'].'/'.$value['pkID']." ".$value['Width']."W x".$value['Height']."H x".$value['Depth']."D x"; ?></p>
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
                                                                        min = '1' value='<?= $values['qty'] ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][qty]'  data-id = '<?= $j; ?>'>
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
                                  </table>
                                </div>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="">Requested Delivery Date</label>
                                        <input type="text" class="form-control" id="requested_delivery_date" name="requested_delivery_date"  value="<?= $edit_order['requested_delivery_date']; ?>" >
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Requested Delivery Date Notes</label>
                                            <textarea class="form-control" id="" name="requested_notes" style="height:39px;" ><?= $edit_order['requested_date_notes']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                           <label class="col-md-6">Is Pick Up</label>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="inlineRadioPick1" value="no" name="is_pickup"  <?php if( $edit_order['is_pickup'] == 'no' ){ echo "checked"; } ?>>
                                              <label for="inlineRadioPick1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="inlineRadioPick2" value="yes" name="is_pickup" <?php if( $edit_order['is_pickup'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="inlineRadioPick2"> Yes </label>
                                           </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12">
                                      <div class=" form-group">
                                         <label class="col-md-6">Hard Date</label>
                                         <div class="radio radio-info form-check-inline">
                                            <input type="radio" id="inlineRadioHard1" value="no" name="hard_date"  <?php if( $edit_order['hard_date'] == 'no' ){ echo "checked"; } ?>>
                                            <label for="inlineRadioHard1"> No </label>
                                         </div>
                                         <div class="radio radio-info form-check-inline">
                                            <input type="radio" id="inlineRadioHard2" value="yes" name="hard_date" <?php if( $edit_order['hard_date'] == 'yes' ){ echo "checked"; } ?>>
                                            <label for="inlineRadioHard2"> Yes </label>
                                         </div>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                        <div class=" form-group">
                                           <label class="col-md-6">Has a Resale Certificate</label>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="inlineRadioHas1" value="no" name="resale_certificate"  <?php if( $edit_order['resale_certificate'] == 'no' ){ echo "checked"; } ?>>
                                              <label for="inlineRadioHas1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="inlineRadioHas2" value="yes" name="resale_certificate" <?php if( $edit_order['resale_certificate'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="inlineRadioHas2"> Yes </label>
                                           </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12">
                                        <div class=" form-group">
                                           <label class="col-md-6">Is Locked</label>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="islocked1" value="no" name="is_locked" <?php if( $edit_order['is_locked'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="islocked1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="islocked2" value="yes" name="is_locked" <?php if( $edit_order['is_locked'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="islocked2"> Yes </label>
                                           </div>
                                        </div>
                                   </div>
                                   <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">Payment Person</label>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="Payment_Person1" value="no" name="payment_person" <?php if( $edit_order['payment_person'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="Payment_Person1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="Payment_Person2" value="yes" name="payment_person" <?php if( $edit_order['payment_person'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="Payment_Person2"> Yes </label>
                                           </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">Has a UEZ / ST-5</label>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="has_a_uez1" value="no" name="has_a_uez" <?php if( $edit_order['has_a_uez'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="has_a_uez1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="has_a_uez2" value="yes" name="has_a_uez" <?php if( $edit_order['has_a_uez'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="has_a_uez2"> Yes </label>
                                           </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">Has a St Form (NY/NJ) </label>
                                           <div class="radio radio-info form-check-inline">
                                               <input type="radio" id="has_a_stform1" value="no" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="has_a_stform1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="has_a_stform2" value="yes" name="has_a_stform" <?php if( $edit_order['has_a_stform'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="has_a_stform2"> Yes </label>
                                           </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">ST8-NJ Hyperlink</label>
                                           <div class="radio radio-info form-check-inline">
                                               <input type="radio" id="st8-nj_hyperlink1" value="no" name="st8_nj_hyperlink" <?php if( $edit_order['st8_nj_hyperlink'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="st8-nj_hyperlink1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="st8-nj_hyperlink2" value="yes" name="st8_nj_hyperlink" <?php if( $edit_order['st8_nj_hyperlink'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="st8-nj_hyperlink2"> Yes </label>
                                           </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">ST124-NY Hyperlink</label>
                                           <div class="radio radio-info form-check-inline">
                                               <input type="radio" id="ST124_hyperlink1" value="no" name="ST124_hyperlink" <?php if( $edit_order['ST124_hyperlink'] == 'no' ){ echo "checked"; } ?> >
                                              <label for="ST124_hyperlink1"> No </label>
                                           </div>
                                           <div class="radio radio-info form-check-inline">
                                              <input type="radio" id="ST124_hyperlink2" value="yes" name="ST124_hyperlink" <?php if( $edit_order['ST124_hyperlink'] == 'yes' ){ echo "checked"; } ?>>
                                              <label for="ST124_hyperlink2"> Yes </label>
                                           </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" col-md-12 ">
                                        <div class=" form-group">
                                           <label class="col-md-6">Is Colourtone</label>
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
                                    
                                    <div class="col-md-12">
                                        <div class=" form-group">
                                           <label class="col-md-6">Is Contract</label>
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
                                  </div>
                                  <div class="col-md-6">
                                    
                                    <div class="col-md-12">
                                    <div class=" form-group">
                                       <label class="col-md-12"><a href="javascript:void(0)" id="ordering_id">Show General/Ordering Notes</a></label>
                                        <div class="col-md-12" id="order_id" style="" >
                                        <textarea rows="2" name="ordering_note" class="form-control" cols="50"><?= $edit_order['ordering_note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" form-group">
                                       <label class="col-md-12"><a href="javascript:void(0)" id="assembly_id">Show Assembly Notes</a></label>
                                         <div class="col-md-12" id="ass_id" style="" >
                                        <textarea rows="2" name="assembly_note" class="form-control" cols="50"><?= $edit_order['assembly_note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" form-group">
                                       <label class="col-md-12"><a href="javascript:void(0)" id="installation_id">Show Installation Notes</a></label>
                                         <div class="col-md-12" id="inst_id" style="" >
                                        <textarea rows="2" name="installation_note" class="form-control" cols="50"><?= $edit_order['installation_note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" form-group">
                                       <label class="col-md-12"><a href="javascript:void(0)" id="delivery_id">Show Delivery Details</a></label>
                                         <div class="col-md-12" id="del_id" style="" >
                                        <textarea rows="2" name="delivery_note" class="form-control" cols="50"><?= $edit_order['delivery_note']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                  </div>
                                </div>
                                    
                              
                              
                             
                               
                               
                               
                               
                                                              
                                
                              
                                
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <input type="submit" class="btn btn-success waves-effect waves-light" value="Save" id="save_" name="submit_product" >
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