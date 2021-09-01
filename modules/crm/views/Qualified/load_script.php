<!-- Datatables script starts here -->
<?php 
$currentMethod = $this->router->fetch_method();
$globalMethods = array('index','edit','files','notes','get_task','revision','QualifiedForm');
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
//Datatables script ends here
if($currentMethod == 'index' ) {  // For list All users ?>
    <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('.js-example-basic-multiple').select2();
            var exampleMulti = $(".js-example-basic-multiple").select2();
            jQuery(".js-programmatic-multi-clear").on("click", function () {
                exampleMulti.val(null).trigger("change");
            });
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
 
            var dataTable = jQuery('#qualifiedleadsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "order": [ [7, "desc"] ],
                "search": {
                    "caseInsensitive": true
                 },
                "columnDefs": [ {
                    "targets": 14,
                    "orderable": false
                    },
                     {
                        "targets":  7,
                        "visible": false
                    }
                ],
                 "ajax": {
                    "url": "<?php echo base_url('crm/Qualified/getQualified'); ?>",
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
                 "createdRow": function( row, data, dataIndex ) {
                    var hotnessval = data[6]*2*10;
                    var surveyval = data[5];
                    var holdstatus = data[2];
                    //console.log( surveyval );
                    
                    if( hotnessval > surveyval  ){
                        var graterValue = "yes"; 
                    }else{
                        var graterValue = "no";
                    }
                    
                    if( hotnessval == 100 && surveyval >= 80 && holdstatus != 'Hold On Design'  ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#d4edda"} );
                    
                    } else if ( (hotnessval >= 60 && hotnessval <= 80) && ( surveyval < 80 && surveyval >= 60  ) && holdstatus != 'Hold On Design'    ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#fff3cd"} );
                    
                    } else if ( (hotnessval < 60 && hotnessval >= 10) && ( surveyval < 60 && surveyval > 1  ) && holdstatus != 'Hold On Design' ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#f8d7da"} );
                    
                    } else if ( hotnessval == 0 && surveyval == 0 && holdstatus != 'Hold On Design' ){ 
                        $( row ).css( {"color":"#5f6265","background-color":"rgb(233, 167, 225)"} );
                    }
                    
                    else if( (hotnessval == 100 && surveyval < 100) && holdstatus != 'Hold On Design' || (hotnessval < 100 && surveyval >= 80) && holdstatus != 'Hold On Design' ){
                        $( row ).css( {"color":"#5f6265","background-color":"#d4edda"} );
                    }
                    
                    else if( hotnessval < 100  && (surveyval < 80 && surveyval >= 60 ) && holdstatus != 'Hold On Design' || (hotnessval < 100 && hotnessval >= 60) &&  surveyval < 100 && holdstatus != 'Hold On Design' ){
                        $( row ).css( {"color":"#5f6265","background-color":"#fff3cd"} );
                    }
                    
                    else if( (hotnessval < 60 && hotnessval >= 10) && (surveyval == 0 && surveyval < 60) && holdstatus != 'Hold On Design' || (hotnessval == 0) && (surveyval > 1 && surveyval < 60) && holdstatus != 'Hold On Design' ){
                         $( row ).css( {"color":"#5f6265","background-color":"#f8d7da"} );
                    }
                    
                    else if( holdstatus == 'Hold On Design' ){
                         $( row ).css( {"color":"#5f6265","background-color":"#cce5ff"} );
                    }
                }
                
            });
            
             jQuery('#selectAssign').on('change', function(){
                var search = [];
                jQuery.each(jQuery('#selectAssign option:selected'), function(){
                    var soc = search.push(jQuery(this).val());
                });
                dataTable.column(1).search(search, true, false).draw();  
            });
        });
        
    </script>
<?php } // close index
if($currentMethod == 'edit' ) {  // For list All users ?>
    <script type="text/javascript">
        jQuery('#lost_id').hide(); 
        jQuery( document ).on('change','#lead_status',function(){
    
            var lead_statusVal = jQuery(this).find(":selected").attr('ids');  
            if( lead_statusVal == 8  ){
                jQuery('#lost_id').show();
            }
            
            jQuery(document).on('click','#save_',function(){
                if( lead_statusVal == 11  ){     
                    jQuery("#QualifiedEform").validate({
                        rules: {
                            qf_Kit_File_1: {
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
                            qf_Deck: { 
                                required:"* Please Enter Deck",
                            },
                           
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                }
            });
        });
        jQuery( document ).on('change','#qf_status',function(){
            
            var lostValue = jQuery('#qf_status').find(":selected").attr('ids');
            var leads_id = jQuery('#qf_status').find(":selected").attr('Lds');
            
            if( lostValue == <?php echo int_lead_Need_More_Info_to_Start;?>){
                $("#pstatus_popup").trigger("click");
            }
            
            if( lostValue == <?php echo int_lead_Revision_Required;?>){
                $("#pstatus_popup").trigger("click");
            }
            if( lostValue == <?php echo int_lead_Hold_On_Design;?>){
                $("#hold_popup").trigger("click");
            }
            
            if(lostValue == <?php echo int_lead_Need_More_Info_to_Start;?> || lostValue == <?php echo int_lead_Revision_Required;?>  ){
                
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "crm/Qualified/add_task",
                data: { lostValue:lostValue, leads_id: leads_id, },
                success: function(res) {
                    jQuery('#hiddenstatus').val(lostValue);
                }
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
            $(".deadline_date").flatpickr({ 
                dateFormat:'m-d-Y'
            });
        });
        
        jQuery(document).on("click",".add-more",function(){ 
            var rowHtml = jQuery(".after-add-more").first().html();
            var countMain = jQuery(".after-add-more").length
            var taskCount = countMain + 1;
            var taskno = rowHtml.replace(/\Task 1/g, 'Task '+taskCount);
            var newHtml = taskno.replace(/\main0/g, 'main'+countMain);
    
            jQuery(newHtml).find(".change").html("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");
            jQuery(".after-add-more").last().after("<div class='after-add-more'>"+newHtml+"</div>").fadeIn('slow');
            $(".deadline_date").flatpickr({ 
                dateFormat:'m-d-Y'
            });
        });
        jQuery("body").on("click",".remove",function(){ 
            jQuery(this).parents(".after-add-more").remove();
        });
</script>
    
    
<?php } // close edit 

if( $currentMethod == 'files' ){ ?>
    <script src="<?php echo base_url()?>assets/libs/jquery-validate/jqueryMorevalidate.js"></script>
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
                    required:true
                },
               
            },
            messages: {
                title: {
                    required:"* Enter Title Name",
                },
                
                image_upload: { 
                    required:"*Upload The Image"
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
        }).then((willDelete) => {
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
</script>
<?php } // close Files ?>

<?php  if( $currentMethod == 'notes' ) { ?>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
    <script> tinymce.init({ selector:'#noteEditor' }); </script>
<?php  } // end Notes

if( $currentMethod == 'get_task' ) { ?>
    <script>
    jQuery(document).ready(function(){
        
        jQuery(document).on('click','#deletetask',function(e){
            var ids = jQuery(this).attr("ids");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this user again!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                showLoaderOnConfirm: true
            }).then((willDelete) => {
                  if (willDelete) {
                        $.ajax({
                            url: "<?php echo site_url('crm/Qualified/Prdelete_task')?>",
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

    });
    </script>

<?php } // end get_task
if( $currentMethod == 'revision' ) { ?>
     <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
     <link href="<?php echo base_url();?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <script>
        jQuery(document).ready(function() {
            jQuery('.js-example-basic-multiple').select2();
            var exampleMulti = $(".js-example-basic-multiple").select2();
            jQuery(".js-programmatic-multi-clear").on("click", function () {
                exampleMulti.val(null).trigger("change");
            });
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
 
            var dataTable = jQuery('#qualifiedleadsresTable').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "order": [ [7, "desc"] ],
                "search": {
                    "caseInsensitive": true
                 },
                "columnDefs": [ {
                    "targets": 14,
                    "orderable": false
                    },
                     {
                        "targets":  7,
                        "visible": false
                    }
                ],
                 "ajax": {
                    "url": "<?php echo base_url('crm/Qualified/get_revision'); ?>",   
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
                 "createdRow": function( row, data, dataIndex ) {
                    var hotnessval = data[6]*2*10;
                    var surveyval = data[5];
                    var holdstatus = data[2];
                    //console.log( surveyval );
                    
                    if( hotnessval > surveyval  ){
                        var graterValue = "yes"; 
                    }else{
                        var graterValue = "no";
                    }
                    
                    if( hotnessval == 100 && surveyval >= 80 && holdstatus != 'Hold On Design'  ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#d4edda"} );
                    
                    } else if ( (hotnessval >= 60 && hotnessval <= 80) && ( surveyval < 80 && surveyval >= 60  ) && holdstatus != 'Hold On Design'    ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#fff3cd"} );
                    
                    } else if ( (hotnessval < 60 && hotnessval >= 10) && ( surveyval < 60 && surveyval > 1  ) && holdstatus != 'Hold On Design' ){
                        
                        $( row ).css( {"color":"#5f6265","background-color":"#f8d7da"} );
                    
                    } else if ( hotnessval == 0 && surveyval == 0 && holdstatus != 'Hold On Design' ){ 
                        $( row ).css( {"color":"#5f6265","background-color":"rgb(233, 167, 225)"} );
                    }
                    
                    else if( (hotnessval == 100 && surveyval < 100) && holdstatus != 'Hold On Design' || (hotnessval < 100 && surveyval >= 80) && holdstatus != 'Hold On Design' ){
                        $( row ).css( {"color":"#5f6265","background-color":"#d4edda"} );
                    }
                    
                    else if( hotnessval < 100  && (surveyval < 80 && surveyval >= 60 ) && holdstatus != 'Hold On Design' || (hotnessval < 100 && hotnessval >= 60) &&  surveyval < 100 && holdstatus != 'Hold On Design' ){
                        $( row ).css( {"color":"#5f6265","background-color":"#fff3cd"} );
                    }
                    
                    else if( (hotnessval < 60 && hotnessval >= 10) && (surveyval == 0 && surveyval < 60) && holdstatus != 'Hold On Design' || (hotnessval == 0) && (surveyval > 1 && surveyval < 60) && holdstatus != 'Hold On Design' ){
                         $( row ).css( {"color":"#5f6265","background-color":"#f8d7da"} );
                    }
                    
                    else if( holdstatus == 'Hold On Design' ){
                         $( row ).css( {"color":"#5f6265","background-color":"#cce5ff"} );
                    }
                }
                
            });
            
             jQuery('#selectAssign').on('change', function(){
                var search = [];
                jQuery.each(jQuery('#selectAssign option:selected'), function(){
                    var soc = search.push(jQuery(this).val());
                });
                dataTable.column(1).search(search, true, false).draw();  
            });
        });
        </script>


<?php }if($currentMethod == 'QualifiedForm' ) { ?>

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

<script> // Global Functions
    document.addEventListener('custombox:overlay:complete', function() {
        $("#deadline_date").flatpickr({ 
            dateFormat:'m-d-Y'
        });
        $("#hold_next_step_date").flatpickr({ 
            dateFormat:'m-d-Y'
        });
        
    });
</script>
