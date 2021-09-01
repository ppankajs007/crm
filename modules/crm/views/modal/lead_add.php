<div class="modal-demo slimscroll">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
    <script>
        jQuery(document).ready( function(){
            jQuery(document).on("change","#email", function(){
                var email = jQuery(this).val();
                jQuery.ajax({
                    type : "POST",
                    url  : "<?php echo site_url(); ?>/auth/email_validation_check",
                    data:{
                      "email":email,
                    },
                    success:function(data){
                        console.log(jQuery.type(data));
                        if(data == 'true'){
                            jQuery(".email_error").text("This Email is already exist");
                            jQuery("#save_").prop('disabled', true);
                        }else{
                            jQuery(".email_error").text("");
                            jQuery("#save_").prop('disabled', false);
                        }
                    },
                    error: function(error) {
                       console.log(data);
                    }
                });
            });
            jQuery(document).ready(function() {
                jQuery('#DataTable').DataTable({
                    "paging": true,
                    "pagingType": "full_numbers"
                });
    
            });
        });
    </script>
        <?php $attr = array( 'id' => 'add_lead'); echo form_open($this->uri->uri_string(),$attr); ?>
        <?php if(validation_errors() != false) 
                  { echo '<ul class="text-danger">' . validation_errors() . "</ul>";}  
                if( isset($errors) && !empty($errors) )
                { 
                  echo '<ul class="text-danger">';
                  foreach ($errors as $v) {
                    echo "<li>{$v}</li>";
                  }
                  echo "</ul>";
                }?>
        
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Add New Lead</h4>
        <div class="custom-modal-text text-left">
            <?php echo form_open($this->uri->uri_string()); ?>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name">
            </div>
            <div class="form-group">
                <label for="leadEmail">Email</label>
                <input autocomplete="false" type="text" class="form-control" id="leadEmail" name="email" placeholder="Enter Email">
                <span class="email_error" style="color: red;"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="phone">Status</label>
                <select class="form-control" name="lead_status">
                    <option value="" id="0">Select option</option>
                    <?php foreach ($lead_statuss as $st) { ?> 
                    <option value="<?php echo $st['id'];?>" id="0"><?php echo $st['status'];?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea name="note" class="form-control"></textarea> 
            </div>
            <div class="form-group">
                <?php $lead_source = $this->config->item('lead_source', 'tank_auth');?>
                <label for="lead_source">Lead Source</label>
                <select class="form-control" id="lead_source" name="lead_source">
                    <?php foreach ($lead_source as $id => $source) {
                         echo "<option value='{$id}'>{$source}</option>";  } ?>
                </select>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
            </form>
        </div>
    </div><?php echo form_close(); ?>
</div>