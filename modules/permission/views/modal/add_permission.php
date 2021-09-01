<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Permission</h4>
    <?php 
        $attributes = array('id' => 'formper'); 
        echo form_open($this->uri->uri_string(),$attributes); 
    ?>
            <div class="custom-modal-text text-left">
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" class="form-control" value="" name="name" >
                </div>
               
                <div class="form-group">
                    <label for="controller_name">Controller Name</label>
                    <input type="text" class="form-control" value="" name="controller_name" >
                </div> 
                <div class="form-group">
                    <label for="method_name">Method Name</label>
                    <input type="text" class="form-control" value="" name="method_name" >
                </div> 
                <div class="form-group">
                    <label for="description">Description</label>
                   <textarea name="description" class="form-control"></textarea> 
                </div>
                <div class="form-group">
		            <label>Hidden</label>
		                <label class="switch">
		                  <input type="checkbox" name="hidden">
		                </label>
            	</div>
            	<div class="form-group">
           			 <label class="col-lg-4 ">Permission Module</label>
					    <select class="form-control" name="permission_module" >
	                        <option value="" >select</option>
	                    <?php 
	                         // echo "<pre>";
	                         // print_r( $permission_module );
	                         // echo "<pre>";
	                         foreach ($permission_module as $module) 
	                           { ?>
	                            
	                        <option value="<?php echo $module->permission_module_id; ?>" ><?php echo $module->name; ?></option>                  
	                    <?php  } ?>
	                    </select>
            	</div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light" id="persave_">Save</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                </div>
            </div>
    <?php echo form_close(); ?>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>