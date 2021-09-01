<div class="modal-demo">
    <?php 
    $attributes = array('id' => 'form'); 
    echo form_open($this->uri->uri_string(),$attributes); 
    ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Category</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="cat_name" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="">Category Description</label>
           <textarea name="cat_desc" class="form-control"></textarea> 
        </div>
        <div class="form-group">
            <label for="parent-select">Select Parent Category</label>
            <select class="form-control" name="cat_parent" id="parent-select">
                <option value="" id="selected" selected>Select...</option>
              <?php if( !empty($categories) ) { foreach ( $categories as $cate ) { ?>
              
                    <option value ="<?php echo $cate['parent']->id; ?>" ><?php echo $cate['parent']->cat_name; ?></option>
                    
                    <?php if ($cate['child']) { foreach ($cate['child'] as $cKey => $cValue) { ?>
                    
                        <option value ="<?php echo  $cValue->id; ?>" >- <?php echo $cValue->cat_name; ?></option>
                        
                    <?php   } 
                          
                        }
                    }
                } 
              ?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>          
    </div><?php echo form_close(); ?>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>