<?php 
    if($this->router->fetch_method() == 'index' )
    {  // For list All users
?>
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



<!-- third party js ends -->

<!-- Datatables init -->
<script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script>

<script>
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
                            swal("Deleted!", "You clicked the button!", "success");
                            jQuery(".Mystyle"+ids).fadeOut();
                            } else {
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                            }
                            
                        },
                    })
              }
            });

/*	swal({
	  title: "Are you sure?",
	  text: "Once deleted, you will not be able to recover this user again!",
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	  showLoaderOnConfirm: true,
	  preConfirm: function() {
      return new Promise(function(resolve) {
        $.ajax({
           url: 'delete.php',
           type: 'POST',
           data: 'delete='+productId,
           dataType: 'json'
        })
        .done(function(response){
           swal('Deleted!', response.message, response.status);
           readProducts();
               })
        .fail(function(){
           swal('Oops...', 'Something went wrong with ajax !', 'error');
        });
      }); 
   },
   allowOutsideClick: false     
   });
*/

});





</script>

<?php } ?>


<script>
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
</script>
</script>

<script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery(document).on('click','#save_',function(){
    // var phone = jQuery('#phone').val();
    // var id = jQuery('#id').val();
   // alert(phone);

 jQuery("#edit_form").validate({
                rules: {
            first_name: {
                required:true,
            },
            phone: {
                required:true,
                // remote:{
                //     url:'<?php// echo base_url("crm/leads/check_no"); ?>',
                //     type:'POST',
                //     data:{phone:phone,id:id},
                //     /*success:function(res){
                //         console.log(res);
                //     },*/
                //      }
            },
            survey: {
                required:true,
            },
            
            comments: {
                required:true,
            },
            
            lost_sale_detail: {
                required:true,
            },
            reminder_date:{
                required:true,
            },
            contact_preprence:{
                required:true,
            },
            
            
             },
            messages: {
                first_name: {
                    required:"* Please Enter Name",
                },
                phone: {
                    required:"* Please Enter Phone Number",
                    remote:"fgwugwurw",
                },
                 survey: {
                    required:"* Please Enter Survey",
                },
                 comments: {
                    required:"* Please Enter Comments",
                },
                lost_sale_detail: {
                    required:"* Please Enter Lost Sale Details",
                },
                 reminder_date: {
                    required:"* Please Select Date",
                },
                contact_preprence: {
                    required:"* Please Enter Contact Preprence",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

</script>

<!-- <script type="text/javascript">
jQuery(document).on('click','#save_',function(){
  var(phone)= jQuery(.phone).val();
  alert(phone);
 jQuery("#edit_form").validate({
                rules: {
            first_name: {
                required:true,
            },
            phone: {
                required:true,
                remote: {
                        url: "<?php// echo base_url();?>crm/leads/edit_leads",
                        type: "post",
                        data: {
                              
                        }
                    }
            },
            survey: {
                required:true,
            },
            
            comments: {
                required:true,
            },
            
            lost_sale_detail: {
                required:true,
            },
            reminder_date:{
                required:true,
            },
            
            
             },
            messages: {
                first_name: {
                    required:"* Please Enter Name",
                },
                phone: {
                    required:"* Please Enter Phone Number",
                    remote:"gfasuidgfe",
                },
                 survey: {
                    required:"* Please Enter Survey",
                },
                 comments: {
                    required:"* Please Enter Comments",
                },
                lost_sale_detail: {
                    required:"* Please Enter Lost Sale Details",
                },
                 reminder_date: {
                    required:"* Please Select Date",
                },
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

</script> -->
<!-- <script type="text/javascript">
jQuery(document).on('click','#save_',function(){
    var phone = jQuery('#phone').val();
    var id = jQuery('#id').val();
   alert(phone);

 jQuery("#edit_form2").validate({
                rules: {
           
            phone: {
                required:true,
                remote:{
                    url:'<?php// echo base_url("crm/leads/check_no"); ?>',
                    type:'POST',
                    data:{phone:phone,id:id},
                    /*success:function(res){
                        console.log(res);
                    },*/
                     }
            },
          
            
            
             },
            messages: {
              
                phone: {
                    required:"* Please Enter Phone Number",
                    remote:"fgwugwurw",
                },
                
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

</script> -->