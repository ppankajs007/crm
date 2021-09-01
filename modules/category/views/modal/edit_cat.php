<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php if( empty($category) ) return; ?>
    <h4 class="custom-modal-title">Edit Category</h4>
    <div class="custom-modal-text text-left">
        <?php  $attributes = array('id' => 'form'); echo form_open($this->uri->uri_string(),$attributes); ?>
            <input type="hidden" id="id" name="cat_id" value='<?php echo $category['id'];?>'>
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name"  name="cat_name" value='<?php echo $category["cat_name"];?>'>
        </div>
        <div class="form-group">
            <label for="">Category Description</label>
           <textarea name="cat_desc" class="form-control"><?php echo $category['cat_desc'];?></textarea> 
        </div>
        <div class="form-group">
            <label for="parent-select">Select Parent Category</label>
            <select class="form-control" name="cat_parent" id="parent-select">
                <option value="" id="selected" selected>Select...</option>
              
                <?php if( !empty($categories) ) { foreach ( $categories as $cate ) { ?>
              
                    <option value ="<?php echo $cate['parent']->id; ?>" <?php echo ( ( $category['cat_parent'] == $cate['parent']->id ) ? 'selected': '') ?> >
                        <?php echo $cate['parent']->cat_name; ?>
                    </option>
                    
                    <?php if ($cate['child']) { foreach ($cate['child'] as $cKey => $cValue) { ?>
                    
                        <option value ="<?php echo  $cValue->id; ?>" <?php echo ( ( $category['cat_parent'] == $cValue->id ) ? 'selected': '') ?> >
                            <?php echo '- '.$cValue->cat_name; ?>
                        </option>
                        
                    <?php   } 
                          
                        }
                    }
                } 
              ?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div><?php echo form_close(); ?>
    </div>
</div>


