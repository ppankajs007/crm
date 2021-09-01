<!-- Datatables script starts here -->
<?php 
$currentMethod = $this->router->fetch_method();
$globalMethods = array('duplicate_lead');
if( in_array($currentMethod,$globalMethods) ) { ?>
    <!-- third party js -->
    <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
    
     <script> 
        jQuery(document).ready(function() {
            jQuery(".mergelead").click(function(event) {
                var parentid = jQuery(this).attr('data-parent');
                var selfid = jQuery(this).attr('data-self');
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "crm/duplicate/add_merge",
                    data: {parentid:parentid, selfid:selfid},
                    success: function(res) {
                      console.log(res);
                        if(res == 'true'){
                            
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
<?php }