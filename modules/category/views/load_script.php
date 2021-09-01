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
        <script> console.log('New Page - <?php echo $rSc; ?>'); </script>
<?php } 
    if($currentMethod == 'index' ) {  // For list All users ?>
        <script>
            jQuery(document).on('click','#deleteCat',function(e){
                var ids = jQuery(this).attr("ids");
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this category again!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    showLoaderOnConfirm: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?php echo site_url('category/delete_category')?>",
                            data: { ids: ids },
                            method: 'POST',
                            error: function(data){ console.log(data); },
                            success: function(res){
                                if(res == "TRUE"){
                                swal("Deleted!", "You clicked the button!", "success").then(function(){ 
                                       location.reload();
                                       }
                                    );
                                 
                                } else {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                                }
                                
                            },
                        })
                    }
                });
            });
        
            // Components.prototype.initCustomModalPlugin = function() {
            //     $('[data-plugin="custommodal"]').on('click', function(e) {
            //     e.preventDefault();
            //         var modal = new Custombox.modal({
            //             content: {
            //                 target: $(this).attr("href"),
            //                 effect: $(this).attr("data-animation"),
            //             },
            //             overlay: {
            //                 color: $(this).attr("data-overlayColor"),
            //                 close:false
            //             }
            //         });
            //         modal.open();
            //     });
            // }

            jQuery(document).ready(function(){
                jQuery.validator.addMethod("alpha", function(value, element) {
                    return this.optional( element ) || /^[a-zA-Z\s]+$/.test( value );
                }, 'Please enter a valid name.');
    
                jQuery(document).on('click','#save_',function(){
                    jQuery("#form").validate({
                        rules: {
                            name: {
                                required:true,
                                alpha:true,
                            },
                            phone: {
                                required:true,
                                number:true
                            },
                            fax: {
                                required:true,
                                number:true
                            },
                            email: {
                                required:true,
                                email:true
                            },
                        },
                        messages: {
                            name: {
                                required:"* Please Enter name",
                            },
                            phone: {
                                required:"* Please Enter phone",
                            },
                            fax: {
                                required:"* Please Enter fax",
                            },
                            email: {
                                required:"* Please Enter Email Id",
                            },
                        },
                            submitHandler: function(form) {
                                form.submit();
                            }
                    });
                });
            });

            jQuery(document).on('click','#save_',function(){
                jQuery("#form").validate({
                    rules: {
                        cat_name: {
                        required:true,
                        },
                    },
                    messages: {
                        cat_name: {
                        required:"* Please Enter category name",
                        },
                    },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });
        </script>
<?php } //close index  ?>







