<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index','edit_leads', 'quick_edit','files','notes','get_task','assignleads');
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
        <script src="<?php echo base_url();?>assets/libs/tippy-js/tippy.all.min.js"></script>
        <script> console.log('New Page - <?php echo $rSc; ?>'); </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <?php } 
    if($currentMethod == 'index' ) {  // For list All users ?>
        
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

        function inittooltip(){
            $('[data-toggle="tooltip"]').tooltip();

        }

        jQuery(document).ready(function(){
            console.log('new js');
            var dataTable = jQuery('#leadsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "scrollX": true,
                "order": [ [0, "desc"] ],
                "aaSorting": [ [0,"desc" ]],
                "ajax": {
                    "url": "<?php echo base_url('crm/leads/getLeads'); ?>",
                    "type": "POST",
                    error:function(res){
                      console.log(res);
                      $(".leadsTable-error").html("");
                      $("#leadsTable").append('<tbody class="leadsTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                      $("#leadsTable_processing").css("display","none");
                    },
                },
                "autoWidth": false,
                "columns": [
                    { "width": "10px" },
                    { "width": "20px" },
                    { "width": "30px" },
                    { "width": "110px" },
                    { "width": "70px" },
                    { "width": "45px" },
                    { "width": "50px" },
                    { "width": "45px" },
                    { "width": "15px" },
                    { "width": "15px" },
                    { "width": "80px" },
                ],
                initComplete:function( settings, json){
                    // $.App.init();
                    initCustomBox();
                    inittooltip();
                },
            });

            jQuery('#selectStatus').on('change', function(){
                var search = [];
                jQuery.each(jQuery('#selectStatus option:selected'), function(){
                    var soc = search.push(jQuery(this).val());
                });
                dataTable.column(5).search(search, true, false).draw();  
            });

            jQuery('#selectAssign').on('change', function(){
                var search = [];
                jQuery.each(jQuery('#selectAssign option:selected'), function(){
                    var soc = search.push(jQuery(this).val());
                });
                dataTable.column(1).search(search, true, false).draw();  
            });

            jQuery('#nextAction').on('change', function(){
                var search = [];
                jQuery.each(jQuery('#nextAction option:selected'), function(){
                    var soc = search.push(jQuery(this).val());
                });
                dataTable.column(10).search(search, true, false).draw();  
            });
        }); 

            jQuery(document).on('click','#save_',function(){
                jQuery("#add_lead").validate({
                    rules:{
                        first_name: {
                            required:true,
                        },
                         last_name: {
                            required:true,
                        },
                        phone:{
                            required:true,
                           
                        },
                        note:{
                            required:true,
                        },
                
                    },
                    messages:{
                            first_name:{
                                required:"* Please Enter Name",
                            },
                            last_name:{
                                required:"* Please Enter Name",
                            },
                            phone:{
                                required:"* Please Enter Phone Number",
                               // remote:"gfasuidgfe",
                            },
                             note:{
                                required:"* Please Enter note",
                            },
                         
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                 });
            });
            
            jQuery(document).on('click','#deleteUser',function(e){
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
                            url: "<?php echo site_url('crm/Leads/Prdelete_user')?>",
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
        
        
              jQuery(document).on('click','#save_',function(){
                jQuery("#quick_edit").validate({
                        rules: {
                            action_lead: {
                                required:true,
                            },
                            reminder_date:{
                                required:true,
                            },
                            assigned_to:{
                                required:true,
                            },
                        },
                        messages: {
                            action_lead: {
                                required:"* Please select Next Step",
                            },
                             reminder_date: {
                                required:"* Please select a date",
                            },
                            assigned_to: { 
                                required:"* Please select a Assign",
                            },
                           
                        },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
            
            
            document.addEventListener('custombox:overlay:complete', function() {
                $("#reminder_date").flatpickr({ 
                dateFormat:'m-d-Y'
                });
            });

            
   </script>
<?php } // close index 
        if($currentMethod == 'edit_leads' ) { ?>
            <script>
                jQuery(document).on('click','#save_',function(){
                jQuery("#edit_form").validate({
                        rules:{
                            first_name: {
                                required:true,
                            },
                            phone:{
                                required:true,
                               
                            },
                        },
                        messages:{
                            first_name:{
                                required:"* Please Enter Name",
                            },
                            phone:{
                                required:"* Please Enter Phone Number",
                               // remote:"gfasuidgfe",
                            },
                         },
                            submitHandler: function(form) {
                                form.submit();
                            }
                    });
                });
                
                $("#dateMasksnd").flatpickr({ 
                    dateFormat:'m-d-Y'
                });

                $("#call_customer_meta input").flatpickr({ 
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                });
                
                document.addEventListener('custombox:overlay:complete', function() {
                $("#reminder_date").flatpickr({ 
                    dateFormat:'m-d-Y'
                    });
                });
                
                jQuery( document ).on('change','#lead_status',function(){
                    var lostValue = jQuery('#lead_status').find(":selected").attr('ids');
                    jQuery('#lost_id').hide();        
                    if( lostValue == 8  ){
                        jQuery('#lost_id').show();
                    } else {
                        jQuery('#lost_id').hide();
                    }
                });
                jQuery( document ).on('change','#next_action',function(){
                    if ( jQuery(this).val() == 'Call Customer') {
                        jQuery('#call_customer_meta').removeClass('hideTrue');
                    }else{
                        jQuery('#call_customer_meta').addClass('hideTrue');
                    }
                });

                jQuery( document ).on('change','#qf_lead_status',function(){

                        var qfVal = jQuery( this ).val();
                        console.log( qfVal );
                        if(  qfVal == 'qualified' ){
                            jQuery( '.qfAmount' ).css('display','block');
                            jQuery( '.qfAmount' ).css('display','flex');
                        }else{
                            jQuery( '.qfAmount' ).css('display','none');
                        }

                });

        </script>
<?php } // close edit
    if($currentMethod == 'files' ) {?>
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
 <?php } // close files  
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
                                    url: "<?php echo site_url('crm/leads/Prdelete_task')?>",
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

<?php } // close delete task 
    if ( $currentMethod == 'notes' ){ ?>
        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
        <script>tinymce.init({ selector:'#noteEditor' });</script>
<?php } // close notes 
    if ( $currentMethod == 'assignleads'){ ?>
        <script>
            jQuery(document).on('keyup','.searchLead',function(e){
                var assignlead = jQuery(this).val();
                jQuery.ajax({
                        url:'<?php echo base_url('crm/leads/assignleads') ?>',
                        type:'post',
                        data:{assignlead:assignlead},
                        error:function(res){
                            console.log(res);
                        },
                        success:function(res){
                            //console.log(res);
                            var jsonDoc = JSON.parse(res);
                            //console.log(jsonDoc);
                            var liData = '';
                            jQuery(".searchlist > ul").html('');
                            jQuery.each( jsonDoc, function( key, value ) {
                                liData += '<li class="list-group-item" data-lid="'+key+'">'+value.first_name+value.last_name+ ' '
                                            + '#'+ value.leads_id +'</li>';
                            });
                            jQuery(".searchlist > ul").append(liData);
                
                            //jQuery(".lead_id").val(jsonDoc.id);
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


<?php } 
if($currentMethod == 'pw_form' ) { ?>

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
<!-- 
<script src="https://unpkg.com/jquery-input-mask-phone-number@1.0.11/dist/jquery-input-mask-phone-number.js"></script>
<script>
 jQuery(document).ready(function () {                
    jQuery('#phone').usPhoneFormat();
    jQuery('#second_phone').usPhoneFormat();
});
</script> -->
