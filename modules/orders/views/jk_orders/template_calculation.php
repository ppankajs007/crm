<div class="row">
    <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="subTotal clearfix">
                <label class="rAl partEq">Subtotal</label>
                <span class="lAl partEq">
                    <span class='hidesub'> <span class="morkpamt" price-morkpamt = "" p_mamt="" ></span>(<span class="morkpperc"></span>%)<br></span>
                    <span class="SP"><?php echo $sPrice; ?></span>
                </span>
                <input type="hidden" class="cost_t_price" name="cost_t_price" value="<?= $cPrice; ?>">
                <input type="hidden" class="subtotal" name="subtotal" value="<?= $sPrice;; ?>">
            </div>
            <div class="proDisc clearfix">
                <label class="rAl partEq">Discount</label>
                <span class="lAl partEq">
                    <input type='text' autocomplete="off" value="" name="discount_per" class="price_perc"> %<br>
                    <input type='text' autocomplete="off" value="" name="discount" class="perc_amount"> $<br> 
                </span>
            </div>
            <div class="proTax clearfix">
                <label class="rAl partEq">Tax</label>
                <span class="lAl partEq"><span class="taxx">0</span>% (<span class="txamt">0.00</span>) </span>
                <input type="hidden" id="txxRate" data-tax='' value="0">
            </div>

            <div class="proDisc delivery_price">
                <label class="rAl partEq">Delivery Price</label>
                <span class="lAl partEq">
                    <input type='text' autocomplete="off" value="" name="delivery_price" class="delivery_price_inp">
                </span>
            </div>
            <div class="proDisc delivery_cost">
                <label class="rAl partEq">Delivery Cost</label>
                <span class="lAl partEq">
                    <input type='text' autocomplete="off" value="" name="delivery_cost" class="delivery_cost_inp">
                </span>
            </div>
            <div class="proGtotal clearfix">
                <label class="rAl partEq">Total</label>
                <span class="lAl partEq">
                    <input type='text' autocomplete="off" name="total" data-total='' value="<?php echo $sPrice; ?>" class="net_price">
                </span>
            </div>
      </div>
  </div>