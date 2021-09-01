<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index','edit', 'dashboard','files','notes','get_task','assignleads','order','pipeline');
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
        <style>
            .loaderOverlay {
                position: fixed;
                width: 100%;
                height: 100%;
                background: #0006;
                z-index: 99999999;
                top: 0;
            }
            .inner {
                display: block;
                margin: -100px auto 0;
                text-align: center;
                position: relative;
                top: 50%;
            }
        </style>
        <script>
            jQuery(document).ready(function(){
                jQuery( document ).ajaxStart(function() {
                  jQuery( 'body' ).append( "<div class='loaderOverlay'><div class='inner'><img src='https://cdn-camp.mini-sites.net/Publish/53c7f5697dd94d829fcb41e20510e344/9acad7d360bd4f9a8b85ff13b1c61aac/src/images/loader01.gif' /></div></div>" );
                });
                jQuery( document ).ajaxComplete(function() {
                  $( '.loaderOverlay' ).remove();
                });
            });
        </script>
<?php } 
    if($currentMethod == 'index' ) {  // For list All users ?>
        <script>
            
             function initCustomBox(){
                $('[data-plugin="custommodal"]').on('click', function(e) {
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
                var dataTable = jQuery('#pipelineTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "stateSave": true,
                    "order": [ [0, "desc"] ],
                    "ajax": {
                        "url": "<?php echo base_url('pipeline/getPipeline'); ?>",
                        "type": "POST",
                        error:function(res){
                          console.log(res);
                          $("#pipelineTable-error").html("");
                         /* $("#pipelineTable").append('<tbody class="DataTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');*/
                          $("#pipelineTable_processing").css("display","none");
                        },
                    },
                    "initComplete":function( settings, json){
                        initCustomBox();
                    }
                });
            });
            
         
        </script>
<?php }  
    
