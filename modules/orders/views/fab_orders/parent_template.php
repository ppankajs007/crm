<?php 
    $counttr = uniqid();

if ( $display == 'AAY_G_Q' || $style_id == '3' || $style_id == '4' ) {
	$display_none = 'style="display:none;"';
}else{
	$display_none = '';
}

if ( $display == 'MSI_QQQ' ) {
	$slap_none = 'style="display:none;"';
	$readonly  = 'readonly';
}else{
	$slap_none = '';
	$readonly = '';

}?>
<tr id='pro_<?php echo $fabpro_id; ?>' class='proIparent add_row<?php echo $counttr ?>'>
	<td style='width: 12%;'>
		<input type='number' min="1" class='form-control qty' style='width:70px;' value='<?php echo $pro_qty ?>' name='fab_product[<?php echo $counttr ?>][qty]'  data-slabInput = '<?php echo $counttr ?>' id='qty<?php echo $counttr ?>'>
	</td>
	<td style='width: 20%;'><span><?php echo $style_code ?></span>/<span><?php echo $item_code ?></span>
		<input type="hidden" name="fab_product[<?php echo $counttr ?>][item_code]" value="<?php echo $item_code; ?>">
		<input type="hidden" name="fab_product[<?php echo $counttr ?>][style_id]" value="<?php echo $style_id; ?>" id="fabStyle<?php echo $counttr ?>" >
	</td>
	<td style='width: 46%;'>
		<p><?php echo $style_name ?>/<?php echo $item_description ?> <?php echo $width ?><?php echo $height ?> <?php echo $depth ?></p>
		
		<div class='slab_content' <?php echo $display_none;  ?>>
			<ul class="slab_boxes slab_title">
				<li>Slab ID</li>
				<li>Sq.ft</li>
			</ul>
			<ul class="slab_boxes">
				<li>Slab 1</li>
				<li><input type="text" class="form-control" value="<?php echo $slab1_id; ?>" name="fab_product[<?php echo $counttr ?>][slab1_id]" <?php echo $readonly; ?>></li>
				<li><input type="text" value="<?php echo decimalValue($slab1_sqft); ?>" name="fab_product[<?php echo $counttr ?>][slab1_sqft]" class="slabOne form-control" data-slabInput="<?php echo $counttr ?>" id="slabOne<?php echo $counttr ?>" <?php echo $readonly; ?> ></li>
			</ul>	
			
			<ul class="slab_boxes" <?php echo $slap_none; ?> >
				<li>Slab 2</li>
				<li><input type="text" class="form-control" value="<?php echo $slab2_id; ?>" name="fab_product[<?php echo $counttr ?>][slab2_id]"></li>
				<li><input type="text" value="<?php echo $slab2_sqft; ?>" name="fab_product[<?php echo $counttr ?>][slab2_sqft]" class="slabTwo form-control" data-slabInput="<?php echo $counttr ?>" id="slabTwo<?php echo $counttr ?>"></li>
			</ul>
			<ul class="slab_boxes" <?php echo $slap_none; ?> >
				<li>Slab 3</li>
				<li><input type="text" class="form-control" value="<?php echo $slab3_id; ?>" name="fab_product[<?php echo $counttr ?>][slab3_id]"></li>
				<li><input type="text" value="<?php echo $slab3_sqft; ?>" name="fab_product[<?php echo $counttr ?>][slab3_sqft]" class="slabThree form-control" data-slabInput="<?php echo $counttr ?>" id="slabThree<?php echo $counttr ?>"></li>
			</ul>
		</div>
        <div class="des_content">
            <div class="des_input des_first">
                <input type="text" autocomplete="off" name='fab_product[<?= $counttr; ?>][description]' value="<?php echo $description; ?>" class="form-control">
            </div>
            <div class="des_input des_sec">
                <input type="text" autocomplete="off" name='fab_product[<?= $counttr; ?>][descriptionII]' value="<?php echo $descriptionII; ?>" class="form-control">
            </div>
        </div>
	</td>
    <td  style='width: 10%' class="bottomLine"> 
        <div class="input_contant">
            <input type="text" autocomplete="off"  class="form-control calcprice change_cost" data-slabInput='<?php echo $counttr ?>' name='fab_product[<?= $counttr; ?>][u_price]' value="<?php echo $u_price ?>" id="change_cost<?= $counttr; ?>" data-price='<?= $counttr; ?>'>
            <p></p>
            <input type="text" autocomplete="off" class="form-control calcprice change_price" data-slabInput='<?php echo $counttr ?>' name='fab_product[<?= $counttr; ?>][price]' value="<?php echo $price ?>" id="change_price<?= $counttr ?>" data-preal="<?= $counttr ?>">
        </div>
    </td>
	<td style='width: 12%;'>
		<input type="hidden" name="fab_product[<?php echo $counttr ?>][product_id]" id="proId<?php echo $counttr ?>" value="<?php echo $fabpro_id ?>">
	<span class="cost_price" id="cost_price<?php echo $counttr ?>" data-spanCId = "<?php echo $counttr ?>" data-itemCost="<?php echo decimalValue($item_cost);  ?>"><span class="morkpamt">$<?php echo decimalValue($item_cost);  ?></span> (<span class="morkpperc"><?php echo $prcnt_cost;  ?></span>%)</span><br>
	<span class="sale_price" id="sale_price<?php echo $counttr ?>" data-itemPrice="<?php echo decimalValue($item_price) ?>">$<?php echo decimalValue($item_price);  ?></span>
    <input type="hidden" id="sale_price_input<?php echo $counttr ?>" name="fab_product[<?php echo $counttr ?>][total_price]" class="sale_price_input" value="<?php echo decimalValue($item_price); ?>">
    <input type="hidden" id="final_cost_input<?php echo $counttr ?>" name="fab_product[<?php echo $counttr ?>][final_cost]" class="final_cost_input" value="<?php echo decimalValue($item_cost); ?>">
	</td>
	<td>
		<div class="icon_content">
	       <div class="f_icon delete_icon">
	          <i data-prid="1" class="mdi mdi-delete delete_Items"></i>
	       </div>
	    </div>
	</td>
<tr>