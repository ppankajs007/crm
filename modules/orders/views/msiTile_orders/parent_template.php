<?php 
    $counttr = uniqid();
    $pro_qty = ( !empty($pro_qty) )? $pro_qty: '1' ;
 ?>
<tr id='pro_<?php echo $jkpro_id; ?>' class='add_row<?php echo $counttr ?>'>
	<td>
		<input type='number' class='form-control qty' readonly style='width:70px;' value='<?php echo $pro_qty; ?>' name='product[<?php echo $counttr ?>][qty]'  data-proInput = '<?php echo $counttr ?>' id='qty<?php echo $counttr ?>'>
	</td>
	<td><span><?php echo $style_code ?></span>/<span><?php echo $item_code ?></span>
		<input type="hidden" name="product[<?php echo $counttr ?>][item_code]" value="<?php echo $item_code; ?>">
		<input type="hidden" name="product[<?php echo $counttr ?>][style_id]" value="<?php echo $style_id; ?>">
	</td>
	<td style="width: 46%;">
            <p><?= $style_name.'/'.$item_description; ?></p>
            <div class="des_content">
                <div class="msi_description">
                  <div class="msi_des msi_f_des">
                    <input type="text" autocomplete="off"  placeholder="Quote/Contract Note" class="form-control" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][descriptionI]' value="<?php echo $descriptionI; ?>" data-price='<?= $counttr; ?>'>    
                  </div>
                  <div class="msi_des msi_s_des">
                    <input type="text" autocomplete="off" placeholder="Purchase Order Note" class="form-control" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][descriptionII]' value="<?php echo $descriptionII; ?>" data-preal="<?= $counttr ?>">     
                  </div>                 
                </div>
                <div class="des_input des_first">
                    <label>
                        <?php 
                            if ($calculation_type =='SQ/FT BOX') {
                                echo "ENTER SQ FT (ROUNDS UP TO BOX)";
                            }else if ($calculation_type =='SQ/FT') {
                                echo "ENTER SQ FT (ROUNDS UP TO PIECE)";
                            }else if ($calculation_type =='Linear') {
                                echo "ENTER TOTAL LENGTH IN INCHES";
                            }else if ($calculation_type =='Each') {
                                echo "ENTER QUANTITY NEEDED";
                            }
                        ?>
                    </label>
		            <input type="text" autocomplete="off"  class="form-control sqbox_input"  name='product[<?= $counttr; ?>][sqbox_input]' value="<?php echo $sqbox_input; ?>" id="sqbox_input<?= $counttr; ?>" data_row_count = "<?php echo $counttr; ?>" data_ctype = "<?php echo $calculation_type; ?>">
                    <span class="sqftCalcuateType<?php echo $counttr; ?>"></span>
                </div>
            </div>
    </td>
    <td class="topLine"> 
        <div class="input_contant">
            <div class="price_calcuate">
                <input type="text" autocomplete="off"  class="form-control calcprice change_cost" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][u_price]' value="<?php echo $u_price; ?>" id="change_cost<?= $counttr; ?>" data-price='<?= $counttr; ?>'>    
            </div>
            <div class="price_calcuate">
                <input type="text" autocomplete="off" class="form-control calcprice change_price" data-proInput='<?php echo $counttr ?>' name='product[<?= $counttr; ?>][price]' value="<?php echo $price; ?>" id="change_price<?= $counttr ?>" data-preal="<?= $counttr ?>">
            </div>
        </div>
    </td>
    <td>
        <span class="cost_price" id="cost_price<?php echo $counttr ?>" data-spanCId = "<?php echo $counttr ?>" data-itemCost="<?php echo decimalValue($item_cost);  ?>"><span class="morkpamt">$<?php echo decimalValue($item_cost)?:'0.00'; ?></span> (<span class="morkpperc"><?php echo ($prcnt_cost)?:'0.00';  ?></span>%)</span>

        <span class="sale_price" id="sale_price<?php echo $counttr ?>" data-itemPrice="<?php echo decimalValue($item_price); ?>">$<?php echo decimalValue($item_price)?:'0.00'; ?></span>

        <input type="hidden" id="sale_price_input<?php echo $counttr ?>" name="product[<?php echo $counttr ?>][total_price]" class="sale_price_input" value="<?php echo decimalValue($item_price)?:'0.00'; ?>">
        <input type="hidden" id="final_cost_input<?php echo $counttr ?>" name="product[<?php echo $counttr ?>][final_cost]" class="final_cost_input" value="<?php echo decimalValue($item_cost)?:'0.00'; ?>">
    </td>
    <td>
       <div class="icon_content">
        <div class="f_icon add_icon">
          <i data-product_id="" class="mdi mdi-plus-circle mr-1 add_child" data_row_count = '<?php echo $counttr; ?>' data_parent_id="<?php echo $jkpro_id; ?>" data_item_code="<?php echo $item_code; ?>" data_style_id="<?php echo $style_id; ?>"></i>
          <input type="hidden" name="product[<?php echo $counttr ?>][product_id]" id="proId<?php echo $counttr ?>" value="<?php echo $jkpro_id ?>">
            <input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="product[<?php echo $counttr; ?>][order_id]">
        </div>
        <div class="f_icon delete_icon"><i data-prid="" class="mdi mdi-delete delete_Items" parent_remove="Yes"></i>
        </div>
       </div>
    </td>
</tr>