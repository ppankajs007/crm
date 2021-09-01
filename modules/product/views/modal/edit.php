<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit Product</h4>
    <div class="custom-modal-text text-left">
        <?php echo form_open($this->uri->uri_string(),array('id' => 'product-form')); ?>             
            <div class="form-group">
                <label for="first_name">Item Name</label>
                <input type="text" class="form-control" id="Item_Name" name="Item_Name" placeholder="Enter Product Name" value="<?php echo  $productData->Item_Name ?>">
            </div>
            <div class="form-group">
                <label for="first_name">Item Code</label>
                <input type="text" class="form-control" id="Item_Code" name="Item_Code" placeholder="Enter Product Name" value="<?php echo  $productData->Item_Code ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Style</label>
                <select class="form-control" name="styleAcode" >
                    <option value="">Select a style</option>
                    <?php
                   if( !empty( $style ) ){
                        foreach ($style as $key => $value) { ?>
                           <option value="<?php echo $value->id  ?>" style_data="<?php echo $value->id  ?>"
                            <?php if ($productData->style_name ==  $value->style_name ) echo 'selected' ; ?> >
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
                   if ( !empty( $vendor ) ) {
                        foreach ($vendor as $key => $value) { ?>
                           <option value="<?php echo $value->id  ?>" style_data="<?php echo $value->id  ?>" 
                             <?php if ($productData->vendor_name ==  $value->name ) echo 'selected' ; ?> >
                            <?php echo ucfirst($value->name) ?></option>
                     <?php  
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="last_name">Catogery</label>
                <select class="form-control pro-category select-cat" name="cat_name">
                   <option value="" cat_data="" class="catogeryOption"> Select catogery</option>
                   <?php
                   if( !empty( $category ) ){
                        foreach ($category as $key => $value) { ?>
                           <option value="<?php echo $value['id']  ?>" class="catogeryOption" cat_data="<?php echo $value['id']  ?>" <?php if ($productData->cat_name ==  $value['cat_name'] ) echo 'selected' ; ?> >
                            <?php echo ucfirst($value['cat_name']) ?></option>
                     <?php  }
                   }

                    ?>
                </select>
            </div>
            <div class="form-group subCatogery">
                <?php //pr($productData);
                    if ( !empty( $productData->sub_category_first ) ) { ?>
                        <label for='name'>Sub Category</label>
                        <select class ='form-control' name='subCatogeryFirst' class='subCatogeryFirst'
                         catIdsub=''>
                            <option value='' class='subCatogeryFirst' sub_cat_data=''> Select Sub Category</option>

                            <?php foreach ($subcatfirst as $value) { ?>
                            
                            <option value='<?php echo $value["id"] ?>' class='subCatogeryFirst' sub_cat_data='<?php echo $value["id"] ?>' <?php if( $productData->sub_category_first == $value['id'] ){ echo "selected";} ?> ><?php echo $value['cat_name']; ?></option>
                                    
                            <?php } ?>

                        </select>

                <?php  } ?>
            </div>
            <div class="form-group subchildCatogery">

            <?php  if( !empty( $productData->sub_category_second ) ){ ?>
                        <label for='name'>Sub Category</label>
                        <select class ='form-control' name='subCatogerysecond' class='subCatogerysecond'
                         catIdsub=''>
                            <option value='' class='subCatogerysecond' sub_cat_data=''> Select Sub Category</option>

                            <?php foreach ($subcatsecond as $value) { ?>
                            
                            <option value='<?php echo $value["id"] ?>' class='subCatogerysecond' catIdsub='<?php echo $value["id"] ?>' <?php if( $productData->sub_category_second == $value['id'] ){ echo "selected";} ?> ><?php echo $value['cat_name']; ?></option>
                                    
                            <?php } ?>
                            
                        </select>

            <?php } ?>

            </div>
            <div class="form-group">
                <label for="first_name">Item Description</label>
                <input type="text" class="form-control" id="Item_description" name="Item_description" placeholder="Enter Item Description" value="<?php echo  $productData->Item_description ?>">
            </div>

            <div class="form-group">
                <label for="first_name">Cabinet Price</label>
                <input type="text" class="form-control" id="Cabinet_price" name="Cabinet_price" placeholder="Enter Cabinet Price" value="<?php echo  $productData->Cabinet_price ?>">
            </div>

            <div class="form-group">
                <label for="first_name">Assembly</label>
                <input type="text" class="form-control" id="Assembly" name="Assembly" placeholder="Enter Assembly Name" value="<?php echo  $productData->Assembly ?>">
            </div>

            <div class="form-group">
                <label for="first_name">Assembly Cost</label>
                <input type="text" class="form-control" id="Assembly_Cost" name="Assembly_Cost" placeholder="Enter Assembly Cost" value="<?php echo  $productData->Assembly_Cost ?>">
            </div>
             <div class="form-group">
                <label for="">Width</label>
                <input type="text" class="form-control" id="Width" name="Width" value="<?php echo  $productData->Width ?>" > 
            </div>
            <div class="form-group">
                <label for="">Height</label>
                <input type="text" class="form-control" id="Height" name="Height" value="<?php echo  $productData->Height ?>" >
            </div>
            <div class="form-group">
                <label for="">Depth</label>
                <input type="text" class="form-control" id="Depth" name="Depth" value="<?php echo  $productData->Depth ?>" >
            </div>


            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light save_" id="save_">Update</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>