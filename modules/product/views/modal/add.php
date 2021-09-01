<div class="modal-demo">
    <?php echo form_open($this->uri->uri_string(),array('id' => 'product-form')); ?>
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add Product</h4>
        <div class="custom-modal-text text-left"> 
            <div class="form-group">
                <label for="Item_Name">Item Name</label>
                <input type="text" class="form-control" name="Item_Name" />
            </div>
            <div class="form-group">
                <label for="">Item Code</label>
                <input type="text" class="form-control" name="Item_Code" />  
            </div>    
            <div class="form-group">
                <label for="last_name">Style</label>
                <select class="form-control" name="styleAcode" >
                    <option value="">Select a style</option>
                    <?php
                    if ( !empty( $style ) ) {
                        foreach ($style as $key => $value) { ?>
                           <option value="<?php echo $value->id  ?>" style_data="<?php echo $value->id  ?>">
                            <?php echo ucfirst($value->style_name) ?></option>
                    <?php  }
                    }
                    ?>
                </select>
            </div>   
            <div class="form-group">
                <label for="first_name">Vendor</label>
                <select class="form-control" name="vendor" >
                    <option value="">Select a vendor</option>
                    <?php
                   if( !empty( $vendor ) ){
                        foreach ($vendor as $key => $value) { ?>
                           <option value="<?php echo $value->id  ?>" style_data="<?php echo $value->id  ?>">
                            <?php echo ucfirst($value->name) ?></option>
                     <?php  }
                   }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="last_name">Category</label>
                <select class="form-control pro-category" name="cat_name">
                   <option value="" cat_data="" class="catogeryOption"> Select catogery</option>
                   <?php
                   if ( !empty( $category ) ) {
                        foreach ($category as $key => $value) { ?>
                           <option value="<?php echo $value['id']  ?>" class="catogeryOption" cat_data="<?php echo $value['id']  ?>">
                            <?php echo ucfirst($value['cat_name']) ?></option>
                     <?php  }
                   }

                    ?>
                </select>
            </div>
                    
            <div class="subCatogery">    
            </div>
            <div class="subchildCatogery">
            </div>

            <div class="form-group">
                <label for="">Item Description</label>
                <input type="text" class="form-control" id="Item_description" name="Item_description" placeholder="Enter Description">
            </div>
            <div class="form-group">
                <label for="">Cabinet Price </label>
                <input type="text" class="form-control" id="Cabinet_price" name="Cabinet_price" placeholder="Enter Cabinet Price">
            </div>
            <div class="form-group">
                <label for="">Assembly </label>
                <input type="text" class="form-control" id="Assembly" name="Assembly" >
            </div>
            <div class="form-group">
                <label for="">Assembly Cost </label>
                <input type="text" class="form-control" id="Assembly_Cost" name="Assembly_Cost" >
            </div>
            <div class="form-group">
                <label for="">Width</label>
                <input type="text" class="form-control" id="Width" name="Width" > 
            </div>
            <div class="form-group">
                <label for="">Height</label>
                <input type="text" class="form-control" id="Height" name="Height" >
            </div>
            <div class="form-group">
                <label for="">Depth</label>
                <input type="text" class="form-control" id="Depth" name="Depth" >
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light save_" id="save_">Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
               
        </div>
    <?php echo form_close(); ?>
</div>