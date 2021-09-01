<?php  
if ( !isset($main_counter) ) {
    $counttr = uniqid();
}else{
    $counttr = $main_counter;
}
    $pro_qty = ( $pro_qty )? $pro_qty: '1'; 
?>
<tr id='pro_<?php echo $jkpro_id; ?>' class='proIparent add_row<?php echo $counttr ?>'>
    <td>
        <input type='number' class='form-control qty' style='width:70px;' value='<?php echo $pro_qty; ?>' name='product[<?php echo $counttr ?>][qty]'  data-proInput = '<?php echo $counttr ?>' id='qty<?php echo $counttr ?>'>
    </td>
    <td><span><?php echo $style_code ?></span>/<span><?php echo $item_code ?></span>
        <input type="hidden" name="product[<?php echo $counttr ?>][item_code]" value="<?php echo $item_code; ?>">
        <input type="hidden" name="product[<?php echo $counttr ?>][style_id]" value="<?php echo $style_id; ?>">
    </td>
    <td style="width: 46%;">
        <?php
            $width = ''; $height = ''; $depth = '';
            if ( $width != '' && $width != 'NA'  ) $width = $width."W x ";  
            if ( $height != '' && $height != 'NA' ) $height = $height."H x ";
            if ( $depth != '' && $depth != 'NA' ) $depth = $depth."D"; ?>
            <p><?= $style_name.'/'.$item_description." ".$width.$height.$depth;?> </p>
            <div class="des_content">
                <div class="des_input des_first">
                    <input type="text" autocomplete="off" name='product[<?= $counttr; ?>][description]' value="<?php echo $description; ?>" class="form-control">
                </div>
                <div class="des_input des_sec">
                    <input type="text" autocomplete="off" name='product[<?= $counttr; ?>][descriptionII]' value="<?php echo $descriptionII; ?>" class="form-control">
                </div>
            </div>
    </td>
    <td class="bottomLine"> 
        <div class="input_contant">
            <input type="text" autocomplete="off"  class="form-control calcprice change_cost" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][u_price]' value="<?php echo $u_price ?>" id="change_cost<?= $counttr; ?>" data-price='<?= $counttr; ?>'>
            <p></p>
            <input type="text" autocomplete="off" class="form-control calcprice change_price" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][price]' value="<?php echo $price ?>" id="change_price<?= $counttr ?>" data-preal="<?= $counttr ?>">
        </div>
    </td>
    <td>
        <input type="hidden" name="product[<?php echo $counttr ?>][product_id]" id="proId<?php echo $counttr ?>" value="<?php echo $jkpro_id ?>">

        <span class="cost_price" id="cost_price<?php echo $counttr ?>" data-spanCId = "<?php echo $counttr ?>" data-itemCost="<?php echo decimalValue($item_cost);  ?>"><span class="morkpamt">$<?php echo decimalValue($item_cost);  ?></span> (<span class="morkpperc"><?php echo $prcnt_cost;  ?></span>%)</span>

        <span class="sale_price" id="sale_price<?php echo $counttr ?>" data-itemPrice="<?php echo decimalValue($item_price); ?>">$<?php echo decimalValue($item_price);  ?></span>

        <input type="hidden" id="sale_price_input<?php echo $counttr ?>" name="product[<?php echo $counttr ?>][total_price]" class="sale_price_input" value="<?php echo decimalValue($item_price); ?>">
        <input type="hidden" id="final_cost_input<?php echo $counttr ?>" name="product[<?php echo $counttr ?>][final_cost]" class="final_cost_input" value="<?php echo decimalValue($item_cost); ?>">
    </td>
    <td>
       <div class="icon_content">
        <div class="f_icon add_icon">
          <i data-product_id="" class="mdi mdi-plus-circle mr-1 add_child" data_row_count = '<?php echo $counttr; ?>' data_parent_id="<?php echo $jkpro_id; ?>" data_item_code="<?php echo $item_code; ?>" data_style_id="<?php echo $style_id; ?>"></i>
            <input type="hidden" value="<?php echo $jkpro_id; ?>" name="product[<?php echo $counttr; ?>][product_id]">
            <input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="product[<?php echo $counttr; ?>][order_id]">
        </div>
        <div class="f_icon delete_icon"><i data-prid="" class="mdi mdi-delete delete_Items" parent_remove="Yes" data_row_count = "<?php echo $counttr; ?>" ></i>
        </div>
       </div>
    </td>
</tr>