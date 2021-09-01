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
<script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>


<!-- third party js ends -->

<!-- Datatables init -->
<script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script>

<script>
function deleteVendor( dataTableObj )
  {
jQuery(document).on('click','#deleteVendor',function(e){
     var ids = jQuery(this).attr("ids");
     // var table = $('#deleteVendor').DataTable();

    swal({
            title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this vendor again!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          showLoaderOnConfirm: true
            })
            .then((willDelete) => {
              if (willDelete) {
                    $.ajax({
                        url: "<?php echo site_url('vendor/delete_vendor')?>",
                        data: { ids: ids },
                        method: 'POST',
                        error: function(data){ console.log(data); },
                        success: function(res){
                            if(res == "TRUE"){
                            swal("Deleted!", "You clicked the button!", "success");
                            dataTableObj.draw();
                            
                            // location.reload();
                            } else {
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                            }
                            
                        },
                    })
              }
            });

});
}
</script>





<script>
    function initCustomBox(){


    $('[data-plugin="custommodal1"]').on('click', function(e) {

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

            // Open

            modal.open();

        });
    }
jQuery(document).ready(function(){
    var dataTable = jQuery('#vendorTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [ [0, "desc"] ],
        "ajax": {
            "url": "<?php echo base_url('vendor/getVendor'); ?>",
            "type": "POST",
            error:function(res){
              console.log(res);
            }
        },
        "initComplete":function( settings, json){
            initCustomBox();
            deleteVendor( dataTable );
        }
    });
});



jQuery(document).ready(function(){
jQuery.validator.addMethod("alpha", function(value, element) {
  return this.optional( element ) || /^[a-zA-Z\s]+$/.test( value );
}, 'Please enter a valid name.');

jQuery(document).on('click','#save_',function(){
 jQuery("#form").validate({
                rules: {
            name: {
                required:true,
                alpha:true,
            },
            phone: {
                required:true,
                number:true
            },
            fax: {
                required:true,
                number:true
            },
            email: {
                required:true,
                email:true
            },
            contact:{
                
                required:true,
                }
            
             },
            messages: {
                name: {
                    required:"* Please Enter name",
                },
                phone: {
                    required:"* Please Enter phone",
                },
                fax: {
                    required:"* Please Enter fax",
                },
                email: {
                    required:"* Please Enter Email Id",
                },
                contact: {
                    required:"* Please Enter contact",
                },

            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

});

</script>





<?php }  ?>


<script type="text/javascript">

</script>

<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
<script>tinymce.init({ selector:'#noteEditor' });</script>

<!-- <script src="<?php echo base_url()?>assets/libs/DataTableServer/jquery.dataTables.min.js"></script> -->





