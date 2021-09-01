<?php 
    $counttr = uniqid();

    if ( !isset($parent_counter) ) {
        $pCount = $data_row_count['data_row_count'];
    }else{
        $pCount = $parent_counter;
    }
    
    if ( isset($childparent_counter) ) {
        $counttr = $childparent_counter;
    }
?>
<tr id='pro_<?php echo $jkPOCid; ?>' class='ischild parent_row<?php echo $pCount ?> add_row<?php echo $counttr; ?>' style="background: #00800052;">
    <td>
        <input type='number' min="1" data-proInput='<?php echo $counttr ?>' class='form-control qty' style='width:50px;' value='<?php echo $pro_qty; ?>' name='product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][qty]'  data-slabInput = '<?php echo $counttr ?>' id='qty<?php echo $counttr ?>'>
    </td>
    <td>
        
        <select class='child_item_name form-control' data_row_count = "<?php echo $counttr;  ?>" id='child_item_name<?php echo $counttr; ?>' >
            <option>Select....</option>
            <?php 
                if ($jk_product) {
                    $adoptedPro = true;
                    foreach ($jk_product as $key => $value) { 
                        if ( $item_code == $value['item_code']) $adoptedPro = false;
                        ?>
                        <option <?php if( $value['jkpid'] == $jkPOCid ) {echo 'selected';} ?> value="<?php echo $value['jkpid']; ?>"><?php echo $value['style_code'].'/'.$value['item_code']; ?></option>
            <?php } 
                    if ( $adoptedPro && $item_code != '') { ?>
                         <option selected value="<?php echo $jkPOCid; ?>"><?php echo $style_code.'/'.$item_code; ?></option>
                    <?php }
                }else{ ?>
                    <option selected value="<?php echo $jkPOCid; ?>"><?php echo $style_code.'/'.$item_code; ?></option>
            <?php } ?>                      
        </select>
        <input type="hidden" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][item_code]" value="<?php echo $item_code ?>" id="item_code<?php echo $counttr; ?>">
        <input type="hidden" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][style_id]" value="<?php echo $style_id; ?>" id="style_id<?php echo $counttr; ?>">
    </td>
    <td style="width: 46%;">
        <?php 
            if (!$item_description) {
                $item_description = $style_name.' / '.$description;
            }else{
                $item_description = $style_name.' / '.$item_description;
            }

         ?>
        <span id="description<?php echo $counttr; ?>"><?php echo $item_description; ?></span>
            <div class="des_content">
                <div class="des_input des_first">
                    <input type="text" autocomplete="off" name='product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][description]' 
                        value="<?= $description ?>" class="form-control">
                </div>
                <div class="des_input des_sec">
                    <input type="text" autocomplete="off" name='product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][descriptionII]' 
                                        value="<?= $descriptionII ?>" class="form-control">
                </div>
            </div>
    </td>
    <?php
     if ( $parent_id['parent_id'] ) {
                $proParentId =  $parent_id['parent_id'];
            }else{
                $proParentId = $pro_parent_id;
            }

            if ( !empty($jkPOCid) ) {
                $proId = $jkPOCid;
            }else{
               $proId = $jk_product['jkpro_id'];
            }

     ?>  
    <td class="bottomLine"> 
            <div class="input_contant">
                <input type="text" autocomplete="off"  class="form-control calcprice change_cost" data-proInput='<?php echo $counttr ?>' name='product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][u_price]' value="<?php echo $u_price;  ?>" id="change_cost<?= $counttr; ?>" data-price='<?= $counttr; ?>' afappend-price="">
                <p></p>
                <input type="text" autocomplete="off" class="form-control calcprice change_price" data-proInput='<?php echo $counttr ?>' name='product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][price]' value="<?php echo $price;  ?>" id="change_price<?= $counttr ?>" data-preal="<?= $counttr ?>" asappend-price=""  >
            </div>

    </td>
    <td>
        <span class='align-center cost_price' id="cost_price<?= $counttr; ?>" data-itemcost="<?= decimalValue($item_cost); ?>" data_cost_price="<?= decimalValue($item_cost); ?>" >$<?= decimalValue($item_cost); ?></span>
        <span class='align-center sale_price' id="sale_price<?= $counttr ; ?>" data-itemprice = '<?= decimalValue($item_price); ?>"' dat_p="<?= decimalValue($item_price); ?>">$<?= decimalValue($item_price); ?></span>
    </td>
    <td>
       <div class="icon_content">
        <div class="f_icon add_icon">
            
          <i data-product_id="" class="mdi mdi-plus-circle mr-1 add_subchild" id="add_subchild<?php echo $counttr; ?>" data_row_count = '<?php echo $counttr; ?>' data_parent_row="<?php echo $pCount; ?>" data_parent_id="<?php echo $pro_parent_id; ?>" data_item_code="<?php echo $item_code; ?>" data_style_id="<?php echo $style_id; ?>"></i>



             <input type="hidden" id="sale_price_input<?php echo $counttr ?>" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][total_price]" class="sale_price_input" value="<?php echo decimalValue($item_price); ?>">
        <input type="hidden" id="final_cost_input<?php echo $counttr ?>" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][final_cost]" class="final_cost_input" value="<?php echo decimalValue( $item_cost ); ?>">   

             <input type="hidden" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][product_id]" id="proId<?php echo $counttr ?>" value="<?php echo $jkPOCid; ?>">
             
            <input type="hidden" value="<?php echo $proId; ?>" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][product_id]" id="product_id<?php echo $counttr; ?>" >
            
            <input type="hidden" value="<?php echo $proParentId; ?>" name="product[<?php echo $pCount; ?>][child_product][<?php echo $counttr ?>][parent_pro_id]"  >
        </div>
        <div class="f_icon delete_icon"><i data_row_count="<?php echo $counttr; ?>" class="mdi mdi-delete delete_Items"></i>
        </div>
       </div>
    </td>
</tr>