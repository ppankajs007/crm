<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Product</h4>
        <?php echo form_open($this->uri->uri_string(),array('id' => 'addCustomProduct')); ?>
	    <div class="custom-modal-text text-left">
	        <div class="row">
		        <div class="form-group col-md-6" >
		            <label for="tsg_style">Select Style</label>
		            <select class="form-control style" name="tsg_style">
	          	       <?php
				          foreach ($jk_style as $key => $value) { ?>
				              <option value="<?php echo $value->id; ?>">
				                  <?php echo ucfirst($value->style_name); ?>      
				              </option>
				         <?php } ?>
		            </select>
		        </div>

		        <div class="form-group col-md-6" >
		            <label for="item_code">Item Code</label>
		            <input type="text" class="form-control" name="item_code">
		        </div>

		        <div class="form-group col-md-6" >
		            <label for="item_cost">Item Cost</label>
		            <input type="text" class="form-control" name="item_cost">
		        </div>

		        <div class="form-group col-md-6" >
		            <label for="item_price">Item Price</label>
		            <input type="text" class="form-control" name="item_price">
		        </div>

		        <div class="form-group col-md-12" >
		            <label for="item_description">Description</label>
		            <input type="text" class="form-control" name="item_description">
		        </div>
		    </div>
	        <div class="text-right">
	        	<input type="hidden" name="user" value="<?php echo $this->session->userdata( 'user_id' ); ?>" >
	        	<input type="hidden" name="order_id" value="<?php echo $this->uri->segment(4); ?>" >
	        	<a href="javascript:;" title="Add Custom" class="btn btn-success waves-effect waves-light" id="save_custom_product">Add Product</a>
	            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
	        </div>
	    </div><?php echo form_close(); ?>
</div>