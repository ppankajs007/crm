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
        <script>
            function deleteDepartment( dataTableObj ){
                jQuery(document).on('click','#deleteDepartment',function(e){
                var ids = jQuery(this).attr("ids");
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this department again!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        showLoaderOnConfirm: true
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: "<?php echo site_url('department/Prdelete_user')?>",
                                data: { ids: ids },
                                method: 'POST',
                                error: function(data){ console.log(data); },
                                success: function(res){
                                        if(res == "TRUE"){
                                            swal("Deleted!", "You clicked the button!", "success");
                                            dataTableObj.draw();
                                        } else {
                                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                                        }   
                                    },
                            })
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
                var dataTable = jQuery('#DepartmentTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url('department/departmentRows'); ?>",
                        "type": "POST",
                        error:function(res){
                          console.log(res);
                        }
                    },
                    "initComplete":function( settings, json){
                        initCustomBox();
                        deleteDepartment( dataTable );
                    }
                });
            });

            jQuery(document).on('click','#save_',function(){
                jQuery("#form").validate({
                    rules: {
                        department_title: {
                            required:true,
                            },
                        department_desc: {
                            required:true,
                            },
                    },
                    messages: {
                            department_title: {
                                required:"* Please Enter Department Title",
                            },
                            department_desc: {
                                required:"* Please Enter Department Description",
                            },
                    },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });
        </script>
<?php } // close index ?>












