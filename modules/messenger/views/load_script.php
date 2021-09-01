<!-- Datatables script starts here -->
<?php 
 if($this->router->fetch_method() == 'index' )
 { ?> 
    <script src="<?php echo base_url()?>assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url()?>assets/libs/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script> <!-- Datatables init -->
<?php 
 } 
 if($this->router->fetch_method() == 'index' )
 {
?>
   <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
   <script>
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

    jQuery(document).on('click','#deleteUser',function(e){
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


</script>
<?php } ?>
<script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
<script src="<?php echo base_url()?>assets/libs/jquery-validate/jqueryMorevalidate.js"></script>


<script type="text/javascript">
    jQuery(document).on('click','#save_',function(){
        jQuery("#new_chat").validate({
                rules:{
                    first_name: {
                    required:true,
                },
                phone:{
                    required:true,
                   
                },
                note:{
                    required:true,
                },
                email:{
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
                
                 note:{
                    required:"* Please Enter Message",
                },
                 email:{
                required:"* Please Enter Email",
            },
                
               
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});



    jQuery(document).on('click','.markunread, .markfav, .markdone',function(){ 
    var cle = jQuery(this);
    var lead_id = jQuery(this).attr('data-id');
    var lead_status = jQuery(this).attr('title');
         jQuery.ajax({
             url:'<?php echo base_url('messenger/getsmsStatus'); ?>',
             type:'POST',
             data:{ lead_id:lead_id,lead_status:lead_status},
             error:function(res){
                 console.log(res);
             },
             success:function(res){
                 console.log(res);
                 cle.addClass('actives');
             }
         });
    });

    jQuery(document).on('change','.messanger-view',function(){
      var messangerValue = jQuery(this).find('option:selected').val();
            if( messangerValue !="" ){
                window.location.href = "<?php echo base_url() ?>messenger/initchat?folder="+messangerValue;
            }
    });

    var winWidth = jQuery(window).width();
    // if( winWidth <= 450){
    //     $('html, body').animate({
    //         scrollTop: jQuery("div.profile_page_").offset().top-100
    //     }, 1000);
    //     console.log('scrollllll');
    // }

</script>
