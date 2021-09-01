<div class="modal-demo">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
<script>
    jQuery(document).ready( function(){
        //alert('hfhf');
        jQuery(document).on("change","#email", function(){
            var email = jQuery(this).val();
            jQuery.ajax({
                type : "POST",
                url  : "<?php echo site_url(); ?>/messenger/check_email",
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

<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">New Chat</h4>
            
                <?php $attr = array( 'id' => 'new_chat'); echo form_open($this->uri->uri_string(),$attr); ?>
            <div class="custom-modal-text text-left">
           
                    <div class="form-group">
                        <label for="first_name">Full Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter The Name">
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
                        <label for="note">Message</label>
                       <textarea name="note" class="form-control"></textarea> 
                    </div>

<div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light save_btn" id="save_">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
                </form>
            </div>
<?php echo form_close(); ?>
</div>



<style type="text/css">
    
    .save_btn {
      width: auto;
      display: inline;
    }
    .error{ color:red;}
</style>
