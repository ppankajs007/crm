<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index','edit_leads', 'quick_edit','files','notes','get_task','assignleads','new_product');
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
    if($currentMethod == 'index' || $currentMethod == 'new_product' ) {  // For list All users ?>
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
                    modal.open();
        
                });
            }

            jQuery(document).ready(function(){
                let dataTable = jQuery('#productsTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [ [0, "desc"] ],
                        "ajax": {
                            "url": "<?php echo base_url('product/getProducts'); ?>",
                            "type": "POST",
                            error:function(res){
                              console.log(res);
                               $(".productsTable-error").html("");
                               $("#productsTable").append('<tbody class="productsTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                               $("#productsTable_processing").css("display","none");
                            },
                        },
                        "initComplete":function( settings, json){
                            // $.App.init();
                            initCustomBox();
                            $("#productsTable_processing").css("display","none");
                            // deleteStyle( dataTable );
                        }
                });
            });

             jQuery(document).ready(function(){
                let newdataTable = jQuery('#newproductsTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [ [0, "desc"] ],
                        "ajax": {
                            "url": "<?php echo base_url('product/get_new_products'); ?>",
                            "type": "POST",
                            error:function(res){
                              console.log(res);
                               $(".newproductsTable-error").html("");
                               $("#newproductsTable").append('<tbody class="newproductsTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                               $("#newproductsTable_processing").css("display","none");
                            },
                        },
                        "initComplete":function( settings, json){
                            // $.App.init();
                            initCustomBox();
                            $("#newproductsTable_processing").css("display","none");
                            // deleteStyle( dataTable );
                        },
                        "createdRow": function( row, data, dataIndex ) {
                            $( row ).css( {"color":"#5f6265","background-color":"#f2dede"} );
                        }
                });
            });


            jQuery(document).on('click','#deleteProduct',function(e){
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
                            url: "<?php echo site_url('product/deleteProduct')?>",
                            data: { ids: ids },
                            method: 'POST',
                            error: function(data){ console.log(data); },
                            success: function(res){
                                if(res == "TRUE"){
                                jQuery('.deleteProduct'+ids).remove();
                                swal("Deleted!", "You clicked the button!", "success");
                                location.reload();
                                } else {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                                }
                                
                            },
                        })
                    }
                });
            });

            jQuery(document).on('click','.catogeryOption',function(){
                var catVal = jQuery(this).val(); 
                var catId = jQuery(this).attr('cat_data');
        	    jQuery.ajax({
        	        url:'<?php echo base_url('product/appendcat'); ?>',
        	        type:'POST',
        	        data:{ catId:catId},
        	        error:function(res){
        	            console.log(res);
        	        },
        	        success:function(res){
        	            if( res != 'false' ){
        		            var jsonCat   = JSON.parse(res);
        		            var listcat   = '';
        		            jQuery('.subCatogery').html('');
        		            listcat += "<div class='form-group'>";
        		                listcat += "<label for='name'>Sub Category</label>";
        		                listcat += "<select class ='form-control' name='subCatogeryFirst' class='subCatogeryFirst' catId=''>";
        		            	listcat += "<option value='' class='subCatogeryFirst' sub_cat_data=''>Select Sub Category</option>";
        		            	jQuery.each(jsonCat, function(key,value){
        		                	listcat += "<option value='"+key+"' class='subCatogeryFirst' sub_cat_data='"+key+"'>"+value.cat_name+"</option>";
        		            	});
        		                listcat += "</select>";
        		                listcat += "</div>";
        		                jQuery('.subCatogery').append(listcat);
                        }else{
        		        	jQuery('.subCatogery').html('');
        		        }
        	        }
        	    });
            });

            jQuery(document).on('click','.subCatogeryFirst',function(){
            catId = jQuery(this).attr('sub_cat_data');
        	jQuery.ajax({
        			url:'<?php echo base_url('product/appendcat'); ?>',
        			type:'POST',
        			data:{ catId:catId },
        			error:function(res){ console.log(res); },
        			success:function(res){ //console.log(res); 
        				if( res != 'false' ){
        		            var jsonCat   = JSON.parse(res);
        		            var listcat   = '';
        		            jQuery('.subchildCatogery').html('');
        		            listcat += "<div class='form-group'>";
        		                listcat += "<label for='name'>Sub Category</label>";
        		                listcat += "<select class ='form-control' name='subCatogerysecond' class='subCatogerysecond' catIdsub=''>";
        		                listcat += "<option value='' class='subCatogeryFirst' sub_cat_data=''>Select Sub Category</option>";
        		            	jQuery.each(jsonCat, function(key,value){
        		                	listcat += "<option value='"+key+"' class='subCatogerysecond' catIdsub='"+key+"'>"+value.cat_name+"</option>";
        		            	});
        		                listcat += "</select>";
        		                listcat += "</div>";
        		                jQuery('.subchildCatogery').append(listcat);
                        }else{
            		        	jQuery('.subchildCatogery').html('');
            		        }
                    }
        	    });
            })

            jQuery(document).on('click','#subCatogeryFirst',function(){
            	catId = jQuery(this).attr('sub_cat_data');
                	jQuery.ajax({
                			url:'<?php echo base_url('product/appendcat'); ?>',
                			type:'POST',
                			data:{ catId:catId },
            			error:function(res){ console.log(res); },
            			success:function(res){ //console.log(res); 
            				if( res != 'false' ){
            		            var jsonCat   = JSON.parse(res);
            		            var listcat   = '';
            		            jQuery('.subchildCatogery').html('');
            		            listcat += "<div class='form-group'>";
            		                listcat += "<label for='name'>Sub Category</label>";
            		                listcat += "<select class ='form-control' name='subCatogerysecond' class='subCatogerysecond' catIdsub=''>";
            		                listcat += "<option value='' class='subCatogeryFirst' sub_cat_data=''>Select Sub Category</option>";
            		            	jQuery.each(jsonCat, function(key,value){
            		                	listcat += "<option value='"+key+"' class='subCatogerysecond' catIdsub='"+key+"'>"+value.cat_name+"</option>";
            		            	});
            		                listcat += "</select>";
            		                listcat += "</div>";
            		                jQuery('.subchildCatogery').append(listcat);
                            }else{
            		        	jQuery('.subchildCatogery').html('');
            		            }
                    	}
                	});
                
                })

                jQuery(document).on('click','#save_',function(){
                    jQuery("#product-form").validate({
                            rules: {
                                Item_Name: {
                                    required:true,
                                },
                                Item_Code:{
                                    required:true,
                                },
                                styleAcode:{
                                    required:true,
                                },
                                vendor:{
                                    required:true,
                                    
                                },
                                Item_description: {
                                    required:true,
                                },
                                Cabinet_price:{
                                    required:true,
                                },
                                Assembly:{
                                    required:true,
                                },
                                Assembly_Cost:{
                                    required:true,
                                    
                                },
                                Width:{
                                    required:true,
                                },
                                Height:{
                                    required:true,
                                },
                                Depth:{
                                    required:true,
                                    
                                },
                                
                            },
                        messages: {
                            Item_Name: {
                                    required:"* Please enter item name",
                                },
                                Item_Code:{
                                    required:"* Please enter item code",
                                },
                                styleAcode:{
                                    required:"* Please select  style name",
                                },
                                vendor:{
                                    required:"* Please select vendor name",
                                    
                                },
                                Item_description: {
                                    required:"* Please enter item description",
                                },
                                Cabinet_price:{
                                    required:"* Please enter cabinet price",
                                },
                                Assembly:{
                                    required:"* Please enter assembly",
                                },
                                Assembly_Cost:{
                                    required:"* Please enter assembly cost",
                                    
                                },
                                Width:{
                                    required:"* Please enter width",
                                },
                                Height:{
                                    required:"* Please enter height",
                                },
                                Depth:{
                                    required:"* Please enter depth",
                                    
                                },
                            },
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
            	});

                jQuery(document).on('click','#importsave_',function(){
            		jQuery("#importform").validate({
            			rules:{
            				file_upload:{
            					required:true,
            				},
            			},
            			message:{
            				file_upload:{
            					required: "* Please Upload File",
            				}
            			},
            			submitHandler:function(form){
            				form.submit();
            			}
            
            		});
            	});

</script>

<?php } ?>
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
<script>tinymce.init({ selector:'#noteEditor' });</script>
<!-- editor plugin js ends -->

