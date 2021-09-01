<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index','edit','files','notes','get_task','pw_form');
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
    if($currentMethod == 'index' ) { ?>
        <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
        <script>
            jQuery(document).ready(function() {
                jQuery('.js-example-basic-multiple').select2();
            });
            var exampleMulti = $(".js-example-basic-multiple").select2();
            jQuery(".js-programmatic-multi-clear").on("click", function () {
                exampleMulti.val(null).trigger("change");
            });
        
            function initCustomBox(){
            $('[data-plugin="custommodal_edit"]').on('click', function(e) {
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
                var dataTable = jQuery('#MRleadsTable').DataTable({ 
                    "processing": true,
                    "serverSide": true,
                    "stateSave": true,
                    "columnDefs": [ {
                        "targets": 12,
                        "orderable": false
                    }],  
                    "autoWidth": false,
                    "columns": [
                        { "width": "10px" },
                        { "width": "180px" },
                        { "width": "30px" },
                        { "width": "110px" },
                        { "width": "70px" },
                        { "width": "30px" },
                        { "width": "50px" },
                        { "width": "30px" },
                        { "width": "35px" },
                        { "width": "28px" },
                        { "width": "40px" },
                        { "width": "80px" },
                        { "width": "80px" },
                        { "width": "80px" },
                    ],
                    "order": [ [0, "desc"] ],
                    "ajax": {
                            "url": "<?php echo base_url('crm/MRLeads/getMRleads'); ?>",
                            "type": "POST",
                            error:function(res){
                              console.log(res);
                              $(".MRleadsTable-error").html("");
                              $("#MRleadsTable").append('<tbody class="MRleadsTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                              $("#MRleadsTable_processing").css("display","none");
                            },
                    },
                    "initComplete":function( settings, json){
                        initCustomBox();
                    }
                });
                    jQuery('#selectAssign').on('change', function(){
                        var search = [];
                        jQuery.each(jQuery('#selectAssign option:selected'), function(){
                            var soc = search.push(jQuery(this).val());
                        });
                           //search = search.join('|');
                        dataTable.column(1).search(search, true, false).draw();  
                    });
            });
        </script>
    <?php }   // close Files
    if($currentMethod == 'files') {?>
        <script>
            jQuery(document).on('click','#save_',function(){
                jQuery.validator.setDefaults({
                    success:"valid"
                });
                jQuery("#add_file").validate({
                        rules: {
                                title: {
                                    required:true,
                                },
                                image_upload:{
                                    required:true,
                               },
                        },
                        messages: {
                                title: {
                                    required:"* Enter Title Name",
                                },
                                image_upload: { 
                                    required:"*Upload The Image",
                                },
                        },
                            submitHandler: function(form) {
                                form.submit();
                            }
                });
            });

           jQuery(document).on('click','#deleteleadfile',function(e){
                var ids = jQuery(this).attr("ids");
                var leads_id = jQuery(this).attr("leads_id");
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this file again!",
                    icon: "warning",
                     buttons: true,
                    dangerMode: true,
                    showLoaderOnConfirm: true
                    })
                .then((willDelete) => {
                if (willDelete) {
                        jQuery.ajax({
                            url: "<?php echo site_url('crm/MRLeads/DeleteFiles')?>",
                            data: { ids: ids, leads_id: leads_id},
                            method: 'POST',
                            error: function(data){ console.log(data); },
                            success: function(res){
                                if(res == "TRUE"){
                                swal("Deleted!", "You clicked the button!", "success").then(function(){ 
                                           location.reload();
                                           }
                                        );
                                var fadeby =jQuery('#deleteRole').attr("ids");
                                var fadrow = jQuery(ids).parent().parent();
                                jQuery(fadrow).fadeOut();
                                /*setTimeout(function(){
                                       window.location.reload(1);
                                    }, 2000);*/
                                } else {
                                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                                    }
                                
                                },
                            })
                        }
                    });

            });
        </script>
    <?php }  // close Files
        if( $currentMethod == 'notes' ) { ?>
            <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
            <script> tinymce.init({ selector:'#noteEditor' }); </script>
    
    <?php  } // end Notes
        if( $currentMethod == 'get_task' ){  ?>
            <script>
                jQuery(document).on('click','#deletetask',function(e){
                    var ids = jQuery(this).attr("ids");
                        swal({
                                title: "Are you sure?",
                              text: "Once deleted, you will not be able to recover this user again!",
                              icon: "warning",
                              buttons: true,
                              dangerMode: true,
                              showLoaderOnConfirm: true
                                })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "<?php echo site_url('crm/MRLeads/Prdelete_task')?>",
                                    data: { ids: ids },
                                    method: 'POST',
                                    error: function(data){ console.log(data); },
                                    success: function(res){
                                        if(res == "TRUE"){
                                        swal("Deleted!", "You clicked the button!", "success").then(function(){ 
                                                   location.reload();
                                                   }
                                                );
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
    <?php } //close delete task
        if($currentMethod == 'edit' ) {  // For list All users ?>
            <script type="text/javascript">
                jQuery('#lost_id').hide(); 
                jQuery( document ).on('change','#lead_status',function(){
                    var lead_statusVal = jQuery(this).find(":selected").attr('ids');  
                    if( lead_statusVal == 8  ){
                        jQuery('#lost_id').show();
                    }
            </script>
    <?php }  if($currentMethod == 'pw_form' ) { ?>

<script>

jQuery(document).on('click','.prequalified',function(){
        var labelVal = jQuery(this).attr('data-val');
        console.log(labelVal);
        if (labelVal == 'yes') {
            jQuery('.preamountDiv').css('display','block');
        }else{
            jQuery('.preamountDiv').css('display','none');
        }
});

</script>

<?php }?>
