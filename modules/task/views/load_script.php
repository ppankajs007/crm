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
            function deletetask( dataTableObj ){
                jQuery(document).on('click','#deletetask',function(e){
                    var ids = jQuery(this).attr("ids");
                     var lid = jQuery(this).attr("lid");
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this task again!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        showLoaderOnConfirm: true
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            $.ajax({
                                url: "<?php echo site_url('task/Prdelete_user')?>",
                                data: { ids: ids, lid: lid },
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
                var dataTable = jQuery('#TaskTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url('task/taskRows'); ?>",
                        "type": "POST",
                        error:function(res){
                          console.log(res);
                        }
                    },
                    "initComplete":function( settings, json){
                        initCustomBox();
                        deletetask( dataTable );
                    }
                });
            });

            jQuery(document).ready( function(){
                jQuery(document).on("change","#leadEmail", function(){
                    var email = jQuery(this).val();
                    jQuery.ajax({
                        type : "POST",
                        url  : "<?php echo site_url(); ?>/crm/leads/check_email",
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
            });
    
            jQuery(document).on('click','#save_',function(){
                jQuery("#form_task").validate({
                    rules: {
                        task_title: {
                            required:true,
                        },
                        task_desc: {
                            required:true,
                       },
                    },
                    messages: {
                        task_title: {
                            required:"* Please Enter Task Title",
                            },
                        task_desc: {
                            required:"* Please Enter Task Description",
                        },
                    },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });

            jQuery(document).on('keyup','.searchLead',function(e){
                var assignlead = jQuery(this).val();
                jQuery.ajax({
                        url:'<?php echo base_url('customer/assignleads') ?>',
                        type:'post',
                        data:{assignlead:assignlead},
                        error:function(res){
                            console.log(res);
                        },
                        success:function(res){
                            var jsonDoc = JSON.parse(res);
                            var liData = '';
                            jQuery(".searchlist > ul").html('');
                            jQuery.each( jsonDoc, function( key, value ) {
                                liData += '<li class="list-group-item" data-lid="'+key+'">'+value.first_name+value.last_name+ ' '
                                            + '#'+ value.leads_id +'</li>';
                            });
                            jQuery(".searchlist > ul").append(liData);
                        }
                });       
            });

            jQuery(document).on('click','.list-group-item',function(){
                var leads_id = jQuery(this).attr('data-lid');
                var leads_name = jQuery(this).text();
                jQuery('#lead_id').val(leads_id);
                jQuery('#searchLead').val(leads_name);
                jQuery('.searchlist > ul').html('');
            });
        </script>

<?php } //close index ?>











