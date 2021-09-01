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
            function deleteRole( dataTableObj ){
                jQuery(document).on('click','#deleteRole',function(e){
                 var ids = jQuery(this).attr("ids");
                    jQuery.ajax({
                            url: "<?php echo base_url('role/check_user_role'); ?>",
                            type: 'POST',
                            data: { ids: ids },
                            error:function(res){
                                console.log(res);
                            },
                            success:function(res){
                                if(res == 'false'){
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover this role again!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                        showLoaderOnConfirm: true
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                $.ajax({
                                                    url: "<?php echo site_url('role/delete_role')?>",
                                                    data: { ids: ids },
                                                    method: 'POST',
                                                    error: function(data){ console.log(data); },
                                                    success: function(res){
                                                        if(res == "TRUE"){
                                                         swal("Deleted!", "You clicked the button!", "success");/*.then(function(){ 
                                                                   location.reload();
                                                                   }
                                                                );*/
                                                            dataTableObj.draw();
                                                        jQuery(".Mystyle"+ids).fadeOut();
                                                        } else {
                                                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                                                        }
                                                        
                                                    },
                                                })
                                            }
                                        });
                                }else{
                                        swal('Oops...', "This role assign some users,first of all you change user's role.", 'error');
                                } 
                            }
                    });
                 });
            }

            function initCustomBox(){
                $('[data-plugin="custommodalEdit"]').on('click', function(e) {
                    e.preventDefault();
                    var modal = new Custombox.modal({
                        content: {
                            target: $(this).attr("href"),
                            effect: $(this).attr("data-animation"),
                        },
                        overlay: {
                                color: $(this).attr("data-overlayColor"),
                                close:false
                        }
                    });
                    modal.open();
                });
            }

            jQuery(document).ready(function(){
                var dataTable = jQuery('#roleTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [ [0, "desc"] ],
                    "ajax": {
                        "url": "<?php echo base_url('role/getRoles'); ?>",
                        "type": "POST",
                        error:function(res){
                          console.log(res);
                        }
                    },
                    "initComplete":function( settings, json){
                        initCustomBox();
                        deleteRole( dataTable );
                    },
                });
            });

            jQuery(document).on('click','#save_',function(){
                jQuery("#form").validate({
                    rules: {
                        role_title: {
                            required:true,
                        },
                        role_desc: {
                            required:true,
                        },
                    },
                    messages: {
                        role_title: {
                            required:"* Please Enter Role Title",
                        },
                        role_desc: {
                            required:"* Please Enter Role Description",
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
    
           
        </script>
<?php } // close index ?>

