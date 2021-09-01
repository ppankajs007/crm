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
  .editProTable tr.child_icon_content, 
  .editProTable tr.child_pro  {
      box-shadow: 0px 8px 22px -17px #252525 inset;
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
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$this->uri->segment(3); ?>">Order For <?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
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
                     <div class="row margin-top">
                        <div class="col-md-6">
                            <div class="form-group">
                              <div class="radio radio-info form-check-inline">
                                  <input autocomplete="off" type="radio" id="assemble_item" class="assemble_val" value="0" name="assemble_value" <?php if( $edit_order['assemble_value'] == 0 ){ echo 'checked'; } ?> order_id = "<?= $this->uri->segment(3); ?>">
                                  <label for="assemble_item"> Assembled </label>
                              </div>
                              <div class="radio form-check-inline">                            
                                  <input autocomplete="off" type="radio" id="uassemble_item" class="assemble_val" value="1" name="assemble_value"
                                   <?php if( $edit_order['assemble_value'] == 1 ){ echo 'checked'; } ?> order_id = "<?= $this->uri->segment(3); ?>" >
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
                                      <select class="form-control" id="vendorName" name="vendor" class="vendorName pro_item" >
                                         <option value="0">Select...</option>
                                         <?php 
                                         if($this->uri->segment(2) == 'product'){ $uri_string = '1'; }
                                            foreach ($vendors as $ven) 
                                            { 
                                            ?> 
                                         <option value="<?php echo $ven->id; ?>" <?php if( $ven->id == $uri_string ){ echo 'selected'; } ?>  o_id = "<?= $this->uri->segment(3); ?>" >
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
                                         <?php 

                                         if ( !empty( $styles ) ) {
                                            
                                            foreach ($styles as $key => $value) { ?>
                                              <option value="<?= $value->id ?>" ><?= $value->style_name; ?></option>
                                            <?php }

                                         }

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
                                       <a href="javascript:;" class="append_input btn btn-success waves-effect waves-light" id="importcustpro" name="submit" orderId = "<?= $this->uri->segment(3);  ?>" >Import</a>
                                    </div>
                                    <div class="btn_imp down_btn">
                                       <div class="download-file">
                                          <a href="<?= base_url(); ?>assets/productOrderfile/orderImport.xlsx" class="download-anc">Download Sample</a>
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
                                    <?php for( $i = 15; $i <= 40; $i++ ){ ?>
                                        <option value="<?= $i/10; ?>" ><?= $i/10 .'%'; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                                <div class="col-md-4">
                                   <a href="<?php echo base_url(); ?>orders/change_product" title="Change Product" data-animation="fadein" data-plugin="custommodal_edit" class="change-pro margin-top"  data-overlaycolor="#38414a">Change Product</a>
                                </div>
                                </div>
                           </div>
                        </div>                     
                    	<div class="table-responsive mt-4 table_append">
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
                              	$cPrice = 0;
								$sPrice = 0;
                                 if ( !empty( $product_order ) ) {
                                   $i = 0;
                                   $j = 1;
                                   $k = 2;
                                       foreach ($product_order as $Key => $value) {
                                            if( $value['product_id'] == 0 ){ $color = "style='background:#f2dede'"; }else{ $color="";} 
                                            if( $value['product_id'] == 0 ){ $itemcode = $value['Item_code']; }else{ $itemcode = $value['pkIC']; } 
                                            if( $value['product_id'] == 0 ){ $style = $value['styId']; }else{ $style = $value['sc']; }

                                            if( !empty( $value['qty'] ) ){ $qtys = $value['qty']; }else{ $qtys = '1'; }


                                        ?>
                              <tr id='pro_<?= $value['product_id']; ?>' class="add_row<?= $i; ?> del_prnt<?= $value['product_id'] ?>" <?= $color; ?>>
                                 <td>
                                    <input type='hidden' value='<?= $itemcode; ?>' class='pk_Item_Code' pr-id='<?= $value['product_id']; ?>' name='product[<?= $i; ?>][item_code]'>
                                    <input type='hidden' value='<?= $style; ?>' class='pk_Item_Code' pr-id='<?= $value['product_id']; ?>' name='product[<?= $i; ?>][style_id]'>
                                    <input autocomplete="off" type='number' class='form-control qty' style='width:70px;' min = "1" value='<?= $qtys; ?>' name='product[<?= $i; ?>][qty]'  data-id = '<?= $value['product_id']; ?>' id="qty<?= $value['product_id']; ?>" >
                                 </td>
                                 <td width="20%">
                                    <span><?= $style; ?></span>/
                                    <span><?= $itemcode; ?></span>
                                 </td>
                                 <td style="width: 46%;">
                                  <?php
                                  	$width = '';
                                    $height = '';
                                    $depth = '';
                                    if ( $value['Width'] != '' && $value['Width'] != 'NA'  ) $width = $value['Width']."W x ";  
                                    if ( $value['Height'] != '' && $value['Height'] != 'NA' ) $height = $value['Height']."H x ";
                                    if ( $value['Depth'] != '' && $value['Depth'] != 'NA' ) $depth = $value['Depth']."D"; ?>
                                    <p><?= $value['sn'].'/'.$value['pkID']." ".$width.$height.$depth;?> </p>

                                    <div class="des_content">
                                       <div class="des_input des_first">
                                          <input type="text" autocomplete="off" name='product[<?= $i; ?>][description]' 
                                             value="<?= $value['description'] ?>" class="form-control">
                                       </div>
                                       <div class="des_input des_sec">
                                          <input type="text" autocomplete="off" name='product[<?= $i; ?>][descriptionII]' 
                                             value="<?= $value['descriptionII'] ?>" class="form-control">
                                       </div>
                                    </div>
                                 </td>
                                 <td class="bottomLine"> 
                                  <div class="input_contant">
                                      <input type="text" autocomplete="off"  class="form-control calcprice change_price" name='product[<?= $i; ?>][u_price]' value="<?= $value['u_price']; ?>" id="calcprice<?= $value['product_id']; ?>" data-price='<?= $value['product_id']; ?>' afappend-price="">
                                      <p></p>
                                      <input type="text" autocomplete="off" class="form-control calcprice assemb_price" name='product[<?= $i; ?>][price]' value="<?= $value['price']; ?>" id="assemb_price<?= $value['product_id']; ?>" data-preal="<?= $value['product_id']; ?>" asappend-price="" >
                                  </div>
                                 </td>
                                 <td class="bottomLine"><?php 
                                    if( $edit_order['assemble_value'] == 1 ){
                                        $ted_price = $value['item_cost'];
                                        $cust_price = $value['unassembled_retail_item_price'];
                                    }else{
                                        $ted_price = $value['cabinet_assembly_price'];
                                        $cust_price = $value['assembled_retail_item_price'];
                                    }

                                  if ( !empty( $value['u_price'] ) ) {
                                      if ($value['u_price'] > 0) {
                                        $item_cost = $ted_price + $value['u_price'];
                                      }else{
                                        $item_cost = $ted_price - $value['u_price'];
                                      }
                                  }else{
                                      $item_cost = $ted_price;
                                  }

                                  if ( !empty( $value['price'] ) ) {
                                      if ($value['price'] > 0) {
                                        $cabinet_assembly_price = $cust_price + $value['price'];
                                      }else{
                                        $cabinet_assembly_price = $cust_price - $value['price'];
                                      }
                                  }else{
                                      $cabinet_assembly_price = $cust_price;
                                  }

                                 if( empty($item_cost) && $item_cost == 'NA'){
                                    	$item_cost = 0;  
                            	 }

                          		if( empty($cabinet_assembly_price) && $cabinet_assembly_price == 'NA'){
                            		$cabinet_assembly_price = 0;
                          		}

                                  $per = ($cabinet_assembly_price-$item_cost)/$item_cost*100;
                                  ?>
                                  <span class='align-center afterdeff' id="afterdeff<?= $value['product_id']; ?>" dat_p="<?= number_format($ted_price,2); ?>" qtyP = '<?= number_format($item_cost,2)?>' ><?= number_format($item_cost,2).'('.ceil($per).'%)'; ?></span>
                                  <span class='align-center salePrice' id="finalp<?= $value['product_id']; ?>" dat_p="<?= number_format($cust_price,2); ?>"><?= number_format($cabinet_assembly_price,2); ?></span>
                                  
                                  <?php $cPrice += number_format($item_cost,2); ?>
                                  <?php $sPrice += number_format($cabinet_assembly_price,2); ?>

                                </td>
                                 <td>
                                    <div class="icon_content">
                                       <div class="f_icon add_icon">
                                          <i data-prid='<?= $value['product_id']; ?>' class="mdi mdi-plus-circle mr-1 add_field" data_btn="<?= $i; ?>" parent_id="<?= $value['product_id']; ?>" item_code="<?= $value['Item_Code']; ?>" style_id="<?= $value['style_id']; ?>" ></i>
                                          <input type="hidden" value="<?= $value['product_id']; ?>" name="product[<?= $i ?>][product_id]">
                                          <input type="hidden" value="<?= $this->uri->segment(3); ?>" name="product[<?= $i ?>][order_id]">
                                       </div>
                                       <div class="f_icon delete_icon">
                                          <i data-prid='<?= $value['product_id']; ?>' class="mdi mdi-delete delete_Items" parent_remove ="Yes"></i>
                                       </div>
                                    </div>
                                 </td>
                              </tr>

                              <!--  end parent product   -->


                              <?php if(!empty( $product_order_child ) ){
                                       foreach( $product_order_child as $values ){

                                     //pr( $values );
                                                                   
                                         if( $value['p_oid'] == $values['pro_order_id']  ){ ?>
                                              <tr class='child_<?= $i ?> del_prnt<?= $value['product_id'] ?>' style='background:#dff0d8' id='pro_<?= $j; ?>'>
  
                                              <td><input type='number' autocomplete="off" class='form-control qty' style='width:70px;' min = '1' value='<?= $values['qty']; ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][qty]'  data-id = '<?= $j; ?>'></td>
                                  <?php                                       
                                      $sqls = "SELECT pro.*,pro.id as proid,sty.*,sty.id as styid FROM pk_product pro LEFT JOIN style sty on sty.id = pro.style_id  WHERE parent_id LIKE '%".$value['Item_Code']."%' AND style_id ='".$value['style_id']."'";
                                  
                                      $data = $this->order_model->custom_query( $sqls, false, 'array' );

                                  ?>

                                  <td>
                                    <select class='form-control style_item' id='style_item<?= $j; ?>' data-sl='<?= $j; ?>'>
                                      
                                    <option value=''>Select Child</option>
                                    <?php foreach ($data as $key => $styleval) { ?>
                                      <option <?php if( $values['product_id'] == $styleval['proid'] ){ echo 'selected'; } ?> value='<?= $styleval['proid'] ?>'><?= $styleval['style_code']."/".$styleval['Item_Code'] ?></option>
                                    <?php } ?>
                                  </select></td>


                                  <td style='width: 46%;'><p class='subdes' id='desc<?= $j; ?>'>

                                    <?php
                                    if ( $values['Width'] != '' && $values['Width'] != 'NA'  ) {
                                      $width = $values['Width']."W x ";  
                                    }else{
                                      $width = '';
                                    }

                                    if ( $values['Height'] != '' && $values['Height'] != 'NA' ) {
                                      $height = $values['Height']."H x ";  
                                    }else{
                                      $height = '';
                                    }

                                    if ( $values['Depth'] != '' && $values['Depth'] != 'NA' ) {
                                      $depth = $values['Depth']."D";  
                                    }else{
                                      $depth = '';
                                  	}
                                    echo $value['sn'].'/'.$values['Item_description']." ".$width.$height.$depth; ?>
                                    </p>

                                    <div class='des_content'><div class='des_input des_first'><input type='text' autocomplete="off" class='form-control' name='product[<?= $i; ?>][child_item][<?= $j; ?>][description]' value='<?= $values['description'] ?>'></div>

                                    <div class='des_input des_sec'><input type='text' autocomplete="off" class='form-control' name='product[<?= $i; ?>][child_item][<?= $j; ?>][descriptionII]' value="<?= $values['descriptionII'] ?>"></div>
                                </td>

                                  <td class="bottomLine">
                                   <div class="input_contant">
                                    <input type="text" class='form-control calcprice change_price' autocomplete="off" name='product[<?= $i; ?>][child_item][<?= $j; ?>][u_price]' id='calcprice<?= $values['product_id']; ?>' value='<?= $values['u_price']; ?>' data-price='<?= $values['product_id']; ?>' afappend-price="">
                                  
                                      <p></p>
                                  
                                    <input type="text" autocomplete="off" class="form-control calcprice assemb_price" name='product[<?= $i; ?>][child_item][<?= $j; ?>][price]' value="<?= $values['price']; ?>" id="calcprice<?= $values['product_id']; ?>" data-preal="<?= $values['product_id']; ?>" asappend-price="" >
                                  </div>
                                  </td>

                                  <td class="bottomLine">
                                  	<?php 
		                                  if( $edit_order['assemble_value'] == 1 ){
		                                        $ted_price = $values['item_cost'];
		                                        $cust_price = $values['unassembled_retail_item_price'];
		                                  }else{
		                                        $ted_price = $values['cabinet_assembly_price'];
		                                        $cust_price = $values['assembled_retail_item_price'];
		                                  }

		                                   if ( !empty( $values['u_price'] ) ) {
                                      			if ($values['u_price'] > 0) {
                                        			$item_cost = $ted_price + $values['u_price'];
                                      			}else{
                                        			$item_cost = $ted_price - $values['u_price'];
			                                  	}
			                              }else{
			                                  $item_cost = $ted_price;
			                              }

		                                  if ( !empty( $values['price'] ) ) {
		                                      if ($values['price'] > 0) {
		                                        $cabinet_assembly_price = $cust_price + $values['price'];
		                                      }else{
		                                        $cabinet_assembly_price = $cust_price - $values['price'];
		                                      }
		                                  }else{
		                                      $cabinet_assembly_price = $cust_price;
		                                  }

		                                  if( empty($item_cost) && $item_cost == 'NA'){
		                                    	$item_cost = 0;  
		                            	  }

		                          		 if( empty($cabinet_assembly_price) && $cabinet_assembly_price == 'NA'){
		                            		$cabinet_assembly_price = 0;
		                          		  }

                                    
                                  $per = ($cabinet_assembly_price-$item_cost)/$item_cost*100;
                                  ?>
                                  <span class='align-center afterdeff' id="afterdeff<?= $values['product_id']; ?>" dat_p="<?= number_format($ted_price,2); ?>"><?= number_format($item_cost,2).'('.ceil($per).'%)'; ?></span>
                                  <span class='align-center salePrice' id="finalp<?= $values['product_id']; ?>" dat_p="<?= number_format($cust_price,2); ?>" ><?= number_format($cabinet_assembly_price,2); ?></span>
                                  <?php $cPrice += number_format($item_cost,2); ?>
                                  <?php $sPrice += number_format($cabinet_assembly_price,2); ?>
                                </td>
                                <td>
                                    <input type='hidden' value='<?= $values['product_id']; ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][product_id]' id='product_id<?= $j; ?>'>

	                                <i data-prid='<?= $values['product_id']; ?>' class="mdi mdi-plus-circle mr-1 add_child_field" data_btn="<?= $j; ?>" parent_id="<?= $values['product_id']; ?>" item_code="<?= $values['Item_Code']; ?>" style_id="<?= $values['style_id']; ?>" subChild_name = "yes" del_prnt="$value['product_id']" data_prnt = "<?= $i; ?>" ></i>

                                    <i class='mdi mdi-delete delete_Items' data-prid='<?= $j; ?>'></i>
                                    <input type='hidden' name='product[<?= $i; ?>][child_item][<?= $j; ?>][parent_id]' value='<?= $values['pro_parent_id']; ?>' id='total_p<?= $j; ?>'>
                                </td>
                              </tr>

                              <!--  start sub child product  -->

                              <?php if(!empty( $product_order_sub_child ) ){
                                       foreach( $product_order_sub_child as $subvalues ){

                                     /* pr( $subvalues );*/
                                      
                                                                   
                                         if( $values['p_o_cid'] == $subvalues['pro_order_id']  ){ ?>
                                              <tr class='child_<?= $i ?> del_prnt<?= $value['product_id'] ?>' style='background:#b9d0af' id='pro_<?= $k; ?>'>
  
                                              <td><input type='number' autocomplete="off" class='form-control qty' style='width:70px;' min = '1' value='<?= $subvalues['qty']; ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][qty]'  data-id = '<?= $k; ?>'></td>
                                  <?php                                       
                                      $sqls = "SELECT pro.*,pro.id as proid,sty.*,sty.id as styid FROM pk_product pro LEFT JOIN style sty on sty.id = pro.style_id  WHERE parent_id LIKE '%".$values['Item_Code']."%' AND style_id ='".$values['style_id']."'";
                                  
                                      $data = $this->order_model->custom_query( $sqls, false, 'array' );

                                  ?>

                                  <td>
                                    <select class='form-control style_item' id='style_item<?= $k; ?>' data-sl='<?= $k; ?>'>
                                      
                                    <option value=''>Select Child</option>
                                    <?php foreach ($data as $key => $styleval) { ?>
                                      <option <?php if( $subvalues['product_id'] == $styleval['proid'] ){ echo 'selected'; } ?> value='<?= $styleval['proid'] ?>'><?= $styleval['style_code']."/".$styleval['Item_Code'] ?></option>
                                    <?php } ?>
                                  </select></td>


                                  <td style='width: 46%;'><p class='subdes' id='desc<?= $k; ?>'>

                                    <?php
                                    if ( $subvalues['Width'] != '' && $subvalues['Width'] != 'NA'  ) {
                                      $subwidth = $subvalues['Width']."W x ";  
                                    }else{
                                      $subwidth = '';
                                    }

                                    if ( $subvalues['Height'] != '' && $subvalues['Height'] != 'NA' ) {
                                      $subheight = $subvalues['Height']."H x ";  
                                    }else{
                                      $subheight = '';
                                    }

                                    if ( $subvalues['Depth'] != '' && $subvalues['Depth'] != 'NA' ) {
                                      $depth = $values['Depth']."D";  
                                    }else{
                                      $depth = '';
                                  	}
                                    echo $value['sn'].'/'.$subvalues['Item_description']." ".$subwidth.$subheight.$subdepth; ?>
                                    </p>

                                    <div class='des_content'><div class='des_input des_first'><input type='text' autocomplete="off" class='form-control' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][description]' value='<?= $subvalues['description'] ?>'></div>

                                    <div class='des_input des_sec'><input type='text' autocomplete="off" class='form-control' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][descriptionII]' value="<?= $subvalues['descriptionII'] ?>"></div>
                                </td>

                                  <td class="bottomLine">
                                   <div class="input_contant">
                                    <input type="text" autocomplete="off" class='form-control calcprice change_price' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][u_price]' id='calcprice<?= $subvalues['product_id']; ?>' value='<?= $subvalues['u_price']; ?>' data-price='<?= $subvalues['product_id']; ?>' afappend-price="">
                                  
                                      <p></p>
                                  
                                    <input type="text" autocomplete="off" class="form-control calcprice assemb_price" name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][price]' value="<?= $subvalues['price']; ?>" id="calcprice<?= $subvalues['product_id']; ?>" data-preal="<?= $subvalues['product_id']; ?>" asappend-price="" >
                                  </div>
                                  </td>

                                  <td class="bottomLine"><?php 
                                  if( $edit_order['assemble_value'] == 1 ){
                                        $subted_price = $subvalues['item_cost'];
                                        $subcust_price = $subvalues['unassembled_retail_item_price'];
                                    }else{
                                        $subted_price = $subvalues['cabinet_assembly_price'];
                                        $subcust_price = $subvalues['assembled_retail_item_price'];
                                    }

                                    if( empty($subted_price) || $subted_price == 'NA'){
                                    	$subted_price = 0;  
                            	 	}

                          			if( empty($subcust_price) || $subcust_price == 'NA'){
                            			$subcust_price = 0;
                          			}

                                  if ( !empty( $subvalues['price'] ) ) {
                                      if ($subvalues['price'] > 0) {
                                        $item_cost = $subted_price + $subvalues['u_price'];
                                        $cabinet_assembly_price = $subcust_price + $subvalues['price'];
                                      }else{
                                        $item_cost = $subted_price - abs($subvalues['u_price']);
                                        $cabinet_assembly_price = $subcust_price - abs($values['price']);
                                      }
                                  }else{
                                      $item_cost = $subted_price;
                                      $cabinet_assembly_price = $subcust_price;
                                  }
                                  $per = ($cabinet_assembly_price-$item_cost)/$item_cost*100;
                                  ?>
                                  <span class='align-center afterdeff' id="afterdeff<?= $subvalues['product_id']; ?>" dat_p="<?= number_format($subted_price,2); ?>"><?= number_format($item_cost,2).'('.ceil($per).'%)'; ?></span>
                                  <span class='align-center salePrice' id="finalp<?= $subvalues['product_id']; ?>" dat_p="<?= number_format($subcust_price,2); ?>" ><?= number_format($cabinet_assembly_price,2); ?></span>
                                    <?php $cPrice += number_format($item_cost,2); ?>
                                  	<?php $sPrice += number_format($cabinet_assembly_price,2); ?>
                                </td>
                                <td>
                                    <input type='hidden' value='<?= $subvalues['product_id']; ?>' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][product_id]' id='product_id<?= $k; ?>'>

                                    <i class='mdi mdi-delete delete_Items' data-prid='<?= $k; ?>'></i>
                                    <input type='hidden' name='product[<?= $i; ?>][child_item][<?= $j; ?>][sub_child][<?= $k; ?>][parent_id]' value='<?= $subvalues['pro_parent_id']; ?>' id='total_p<?= $k; ?>'>
                                </td>
                              </tr>

                              <?php 
                          	  		}
                          	  		$k++;
                          		}
                          	 }

                              ?>

                              <!--  end sub child product  -->
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
                              <input type="hidden" class="cost_t_price" name="cost_t_price" value="<?= $cPrice; ?>">
                              <input type="hidden" class="subtotal" name="subtotal" value="<?= $sPrice;; ?>">
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
	                        			<?php 
                                        if( $edit_order['resale_certificate'] != 'yes' && $edit_order['has_a_uez'] != 'yes' && $edit_order['has_a_stform'] != 'yes' ){
	                        				$taxAmt = ($sPrice/100) * 6.255;
	                        				$ttP = $sPrice+$taxAmt;
                                 // echo $ttP.'no'; 
                                        }else{
                                            $ttP = $sPrice;
                                   //         echo $ttP.'yess';
                                        }
	                        			?>
										<input type='text' autocomplete="off" name="total" data-total='<?php echo number_format($ttP,2); ?>' value="<?php echo number_format($ttP,2); ?>" class="net_price">
									</span>
	                        	</div>
	                        </div>
	                    </div><br><br>
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