<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index');
    $rSc = rand(99,999);
    if( in_array($currentMethod,$globalMethods) ) { ?>
        <!-- third party js -->
        <script src="<?php echo base_url()?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.bootstrap4.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.flash.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.select.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/pdfmake/pdfmake.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/pdfmake/vfs_fonts.js"></script>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
        <script> console.log('New Page - <?php echo $rSc; ?>'); </script>
<?php } 
    if($currentMethod == 'index' ) {  // For list All users ?>
        <script type="text/javascript">
            jQuery(document).on('click','#persave_',function(){
                 jQuery("#formper").validate({
                    rules:{
                        name:{
                            required:true,
                        },
                        controller_name:{
                            required:true,
                        },
                        method_name:{
                            required:true,
                        },
                        permission_module: {
                            required:true,
                        },
                    },
                    messages:{
                        name:{
                            required:"* Please Enter name",
                        },
                        controller_name:{
                            required:"* Please Enter cotroller Name",
                        },
                        method_name:{
                            required:"* Please Enter Method Name",
                        },
                        permission_module:{
                            required:"* Please Enter permission",
                        },
                    },
                        submitHandler: function(form){
                            form.submit();
                        }
                 });
            });

            jQuery(document).on('click','#deletePermission',function(e){
            var ids = jQuery(this).attr("ids");
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this permission again!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    showLoaderOnConfirm: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo site_url('Permission/delete')?>",
                            data: { ids: ids },
                            method: 'POST',
                            error: function(data){ console.log(data); },
                            success: function(res){
                                if(res == "TRUE"){
                                swal("Deleted!", "You clicked the button!", "success");
                                jQuery(".Mystyle"+ids).fadeOut();
                                } else {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                                }
                                
                            },
                        })
                    }
                });
            });
        </script>
<?php } // close index ?>


