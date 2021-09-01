<!-- Datatables script starts here -->
<?php 
$currentMethod = $this->router->fetch_method();
$globalMethods = array('index','edit','files','notes','chats','get_task','get_revision','KitchenDetail');
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
    <script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script> <!-- Datatables init -->
    <script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
    <link href="<?php echo base_url();?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>

    <script type="text/javascript">
        document.addEventListener('custombox:overlay:complete', function() {
            $(".datePick").flatpickr({ 
                dateFormat:'m-d-Y'
            }); 
        });
    </script>

<?php } //Datatables script ends here

    if($currentMethod == 'index' ) { ?>
        <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                
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
        
                jQuery('.js-example-basic-multiple').select2();
                var exampleMulti = $(".js-example-basic-multiple").select2();
            
                jQuery(".js-programmatic-multi-clear").on("click", function () {
                    exampleMulti.val(null).trigger("change");
                });
            
    
                if( jQuery('#presentationleadsTable').length ){
                    var dataTable = jQuery('#presentationleadsTable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "stateSave": true,
                         "columnDefs": [ {
                            "targets": 13,
                            "orderable": false
                            }],
                        "search": {
                            "caseInsensitive": true
                         },
                        "order": [ [0, "desc"] ],
                        "ajax": {
                            "url": "<?php echo base_url('crm/Presentation/getPresentation'); ?>",
                            "type": "POST",
                            error:function(res){
                              console.log(res);
                              $(".getQualified-error").html("");
                              $("#getQualified").append('<tbody class="getQualified-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                              $("#getQualified_processing").css("display","none");
                            },
                        },
                        "initComplete":function( settings, json){
                            // $.App.init();
                            initCustomBox();
                            // deleteStyle( dataTable );
                        },
                        
                    });
                  
                      jQuery('#selectAssign').on('change', function(){
                            var search = [];
                          
                          jQuery.each(jQuery('#selectAssign option:selected'), function(){
                                var soc = search.push(jQuery(this).val());
                          });
                          
                          //search = search.join('|');
                          dataTable.column(1).search(search, true, false).draw();  
                    });
                }
                
            });
        </script>
    <?php }

    if($currentMethod == 'edit' ) { ?>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jqueryMorevalidate.js"></script>
        <script type="text/javascript">
            jQuery( document ).on('change','#qf_status',function(){
                var lostValue = jQuery('#qf_status').find(":selected").attr('ids');
                var leads_id = jQuery('#qf_status').find(":selected").attr('Lds');
                
                if( lostValue == <?php echo int_lead_Revision_Required; ?>){
                    $("#pstatus_popup").trigger("click");
                }
           
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "crm/presentation/add_st",
                    data: { lostValue: lostValue, leads_id: leads_id},
                    success: function(res) { }
                });
               
            });
            
            jQuery( document ).on('change','#lead_status',function(){
                var lostValue = jQuery('#lead_status').find(":selected").attr('ids');
                // alert(lostValue);
                //console.log(lostValue);
                jQuery('#lost_id').hide();        
                if( lostValue == 8  ){
                    jQuery('#lost_id').show();
                } else {
                    jQuery('#lost_id').hide();
                }
                
                if( lostValue == 11  ){
                  
                    jQuery(document).on('click','#save_',function(){
                     
                        jQuery("#QualifiedEform").validate({
                            rules: {
                                qf_Kit_File_1: {
                                    required:true,
                                },
                                qf_Panoramic_D1:{
                                    required:true,
                                },
                                qf_Deck:{
                                    required:true,
                                },
                                   
                            },
                            messages: {
                                qf_Kit_File_1: {
                                    required:"* Please Enter file name",
                                },
                                 qf_Panoramic_D1: {
                                    required:"* Please Enter Panoramic",
                                },
                                qf_Deck: { 
                                    required:"* Please Enter Deck",
                                },
                               
                            },
                            submitHandler: function(form) {
                                form.submit();
                            }
                        });
                    });
            
                }
                if(lostValue == 3 || lostValue == 8 || lostValue == 5 ){
                    jQuery(document).on('click','#save_',function(){
                        $("#QualifiedEform").removeData("validator");
                    });
                }
            });
            
            jQuery(document).ready(function(){
    
                $("#dateMasksnd").flatpickr({ 
                    dateFormat:'m-d-Y'
                });
                $("#dateMaskfst").flatpickr({ 
                    dateFormat:'m-d-Y'
                });
                
            });
            
            jQuery(document).on("click",".add-more",function(){ 
                var rowHtml = jQuery(".after-add-more").first().html();
                var countMain = jQuery(".after-add-more").length
                var taskCount = countMain + 1;
                var taskno = rowHtml.replace(/\Task 1/g, 'Task '+taskCount);
                var newHtml = taskno.replace(/\main0/g, 'main'+countMain);
             
                 //jQuery(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");
              
                jQuery(newHtml).find(".change").html("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");
              
              
                jQuery(".after-add-more").last().after("<div class='after-add-more'>"+newHtml+"</div>");
                $(".datePick").flatpickr({ 
                    dateFormat:'m-d-Y'
                });
             
               
            });
        
            jQuery("body").on("click",".remove",function(){ 
                jQuery(this).parents(".after-add-more").remove();
            });
            
    </script>
<?php }
    
    if($currentMethod == 'files' ) { ?>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
        <script type="text/javascript">
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
                            url: "<?php echo site_url('crm/leads/DeleteFiles')?>",
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
            jQuery(document).on('click','#save_',function(){
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
        </script>
    <?php }

    if($currentMethod == 'notes' ) { ?>
        <script>tinymce.init({ selector:'#noteEditor' });</script>
    <?php }
    
    if($currentMethod == 'get_task' ) { ?>
    <script type="text/javascript">
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
                        url: "<?php echo site_url('crm/Presentation/Prdelete_task')?>",
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
    <?php } if($currentMethod == 'get_revision' ) { ?>
    
     <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                
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
        
                jQuery('.jsa-example-basic-multiple').select2();
                var exampleMulti = $(".js-example-basic-multiple").select2();
            
                jQuery(".js-programmatic-multi-clear").on("click", function () {
                    exampleMulti.val(null).trigger("change");
                });
            
    
                if( jQuery('#presentationleadsrevTable').length ){
                    var dataTable = jQuery('#presentationleadsrevTable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "stateSave": true,
                         "columnDefs": [ {
                            "targets": 13,
                            "orderable": false
                            }],
                        "search": {
                            "caseInsensitive": true
                         },
                        "order": [ [0, "desc"] ],
                        "ajax": {
                            "url": "<?php echo base_url('crm/Presentation/get_revision_data'); ?>",
                            "type": "POST",
                            error:function(res){
                              console.log(res);
                              $(".getQualified-error").html("");
                              $("#getQualified").append('<tbody class="getQualified-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                              $("#getQualified_processing").css("display","none");
                            },
                        },
                        "initComplete":function( settings, json){
                            // $.App.init();
                            initCustomBox();
                            // deleteStyle( dataTable );
                        },
                        
                    });
                  
                      jQuery('#selectAssign').on('change', function(){
                            var search = [];
                          
                          jQuery.each(jQuery('#selectAssign option:selected'), function(){
                                var soc = search.push(jQuery(this).val());
                          });
                          
                          //search = search.join('|');
                          dataTable.column(1).search(search, true, false).draw();  
                    });
                }
                
            });
        </script>
    
    ?>
    <?php }if($currentMethod == 'KitchenDetail' ) { ?>

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

