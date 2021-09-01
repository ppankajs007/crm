<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index','edit', 'dashboard','files','notes','get_task','assignleads','order');
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
            var GenRandom =  {
                Stored: [],
                Job: function(){
                    var newId = Date.now().toString().substr(6); // or use any method that you want to achieve this string
                    if( !this.Check(newId) ){
                        this.Stored.push(newId);
                        return newId;
                    }
                    return this.Job();
                },
                Check: function(id){
                    for( var i = 0; i < this.Stored.length; i++ ){
                        if( this.Stored[i] == id ) return true;
                    }
                    return false;
                }
                
            };

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
            jQuery(document).on('click','#deleteRole',function(e){
            var ids = jQuery(this).attr("ids");
                swal({
                        title: "Are you sure?",
                      text: "Once deleted, you will not be able to recover this role again!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                      showLoaderOnConfirm: true
                        })
                .then((willDelete) => {
                    if (willDelete) {
                        jQuery.ajax({
                            url: "<?php echo site_url('customer/customer/delete_role')?>",
                            data: { ids: ids },
                            method: 'POST',
                            error: function(data){ console.log(data); },
                            success: function(res){
                                if(res == "TRUE"){
                                swal("Deleted!", "You clicked the button!", "success");
                                var fadeby =jQuery('#deleteRole').attr("ids");
                                var fadrow = jQuery(ids).parent().parent();
                                jQuery(fadrow).fadeOut();
                                } else {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                                }
                            },
                        })
                    }
                });
            }); 
            
            jQuery(document).on('click','#deleteCustomer',function(e){
            var ids = jQuery(this).attr("ids");
                swal({
                        title: "Are you sure?",
                      text: "Once deleted, you will not be able to recover this Customer again!",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                      showLoaderOnConfirm: true
                        })
                .then((willDelete) => {
                  if (willDelete) {
                        jQuery.ajax({
                            url: "<?php echo site_url('customer/delete_Customer')?>",
                            data: { ids: ids },
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
                var dataTable = jQuery('#customerTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "stateSave": true,
                    "order": [ [0, "desc"] ],
                    "ajax": {
                        "url": "<?php echo base_url('customer/customer/getCustomer'); ?>",
                        "type": "POST",
                        error:function(res){
                          console.log(res);
                          $("#customerTable-error").html("");
                         /* $("#customerTable").append('<tbody class="DataTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');*/
                          $("#customerTable_processing").css("display","none");
                        },
                    },
                    "initComplete":function( settings, json){
                        // $.App.init();
                        initCustomBox();
                        // deleteStyle( dataTable );
                    }
                });
            });
            
         
        </script>
<?php }  
    if($currentMethod == 'edit' ) { ?>
        <script type="text/javascript">
            jQuery(document).on('click','#save_',function(){
                jQuery("#form").validate({
                    onkeyup: true,
                    onclick: false,
                    rules: {
                        full_name:{
                            required:true,
                        },
                        address:{
                            required:true,
                        },
                        city:{
                            required:true,
                        },
                        state:{
                            required:true,
                        },
                        zipcode:{
                            required:true,
                            number: true,
                        },
                        phone:{
                            required:true,
                            number: true,
                        },
                        fax:{
                            required:true,
                            number: true,
                        },
                        email:{
                            required:true,
                             email: true,
                        },
                        is_customer:{
                            required:true,
                        },
                    },
                    messages: {
                        full_name:{
                                required:"* Please Enter Full Name",
                            },
                            address:{
                                required:"* Please Enter Address",
                            },
                            city:{
                                required:"* Please Enter City",
                            },
                            state:{
                                required:"* Please Enter State",
                            },
                            zipcode:{
                                required:"* Please Enter Zipcode",
                                required:"* Please Enter Numeric value",
                            },
                            phone:{
                                required:"* Please Enter Phone Number",
                                required:"* Please Enter Numeric value",
        
                            },
                            fax:{
                                required:"* Please Enter Fax Number",
                                required:"* Please Enter Numeric value",
                            },
                            email:{
                                required:"* Please Enter Email",
                                required:"please enter a valid email",
                            },
                            is_customer:{
                                required:"* Please Select Customer",
                            }
                    },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });

        </script>
<?php }  
    if ($currentMethod == 'dashboard') {?>
        <script>
            jQuery(document).on('click','#save_address',function(){
                jQuery("#form_address").validate({
                     onkeyup: true,
                     onclick: false,
                        rules: {
                            addressline_one:{
                                required:true,
                            },
                            address_type:{
                                required:true,
                            },
                            city:{
                                required:true,
                            },
                            state:{
                                required:true,
                            },
                            zipcode:{
                                required:true,
                                number: true,
                            },
                        },
                        messages: {
                                addressline_one:{
                                    required:"* Please Enter Address",
                                },
                            address_type:{
                                    required:"* Please Select Address Type",
                                },
                                city:{
                                    required:"* Please Enter City",
                                },
                                state:{
                                    required:"* Please Enter State",
                                },
                                zipcode:{
                                    required:"* Please Enter Zipcode",
                                    required:"* Please Enter Numeric value",
                                },
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });  

           /* jQuery(document).on('click','#edit_add',function(){
                jQuery("#edit_address").validate({
                    onkeyup: true,
                    onclick: false,
                    rules: {
                        addressline_one:{
                            required:true,
                            },
                        address_type:{
                            required:true,
                            },
                        city:{
                            required:true,
                            },
                        state:{
                            required:true,
                            },
                        zipcode:{
                            required:true,
                            number: true,
                            },
                        country:{
                            required:true,
                           
                            },
                        fax:{
                            required:true,
                            number: true,
                            },
                    },
                    messages: {
                        addressline_one:{
                                required:"* Please Enter Address",
                            },
                        address_type:{
                                required:"* Please Select Address Type",
                            },
                        city:{
                                required:"* Please Enter City",
                            },
                        state:{
                                required:"* Please Enter State",
                            },
                        country:{
                                required:"* Please Enter Country",
                            },
                        zipcode:{
                                required:"* Please Enter Zipcode",
                                required:"* Please Enter Numeric value",
                            },
                        fax:{
                                required:"* Please Enter Fax Number",
                                required:"* Please Enter Numeric value",
                            },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });*/  

            jQuery(document).on('click','#deleteAddress',function(e){
            var ids = jQuery(this).attr("ids");
             var cids = jQuery(this).attr("cids");
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Address again!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    showLoaderOnConfirm: true
                })
                .then((willDelete) => {
                    if (willDelete) {
                        jQuery.ajax({
                            url: "<?php echo site_url('customer/delete_address')?>",
                            data: { ids: ids, cids: cids },
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

<?php }
    if ($currentMethod == 'files') { ?>
        <script>
            jQuery(document).on('click','#save_',function(){
                jQuery.validator.setDefaults({
                    success: "valid"
                });
                    jQuery("#add_file").validate({
                        rules: {
                            title: {
                                required:true,
                            },
                            description:{
                                required:true,
                            },
                            image_upload:{
                                required:true,
                                //extension: "jpg|jpeg|png|pdf",
                            },
                        },
                        messages: {
                            title: {
                                required:"* Enter Title Name",
                            },
                             description: {
                                required:"* Enter Title Discription",
                            },
                            image_upload: { 
                                required:"*Upload The Image",
                                 //extension: "Only jpg, jpeg, png, pdf files assepted",
                            },
                           
                        },
                        submitHandler: function(form) {
                            form.submit();
                        }
                });
            });
    
            jQuery(document).on('click','#deleteleadfile',function(e){
            var ids = jQuery(this).attr("ids");
            var customer_id = jQuery(this).attr("leads_id");
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this File again!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        showLoaderOnConfirm: true
                    })
                .then((willDelete) => {
                    if (willDelete) {
                        jQuery.ajax({
                            url: "<?php echo site_url('customer/deleteFile')?>",
                            data: { ids: ids, customer_id: customer_id},
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
                                }else{
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                                }
                            },
                        })
                    }
                });
            });
        </script>
<?php }
    if ($currentMethod == 'notes') {  ?>
        <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=m3du3yxjp1hhj0rqhr1g5vtzjonkiz8ek1q5qiypgc38e4hx"></script>
        <script>tinymce.init({ selector:'#noteEditor' });</script>
<?php }
 if ($currentMethod == 'order') {
?>
<script>
    
    $(document).ready(function(){
            jQuery(document).on('click','#ordering_id',function(){
                jQuery("#order_id").toggle();
            })
            jQuery(document).on('click','#assembly_id',function(){
                jQuery("#ass_id").toggle();
            })
            jQuery(document).on('click','#installation_id',function(){
                jQuery("#inst_id").toggle();
            })
            jQuery(document).on('click','#delivery_id',function(){
                jQuery("#del_id").toggle();
            })

        });
</script>
<?php }?>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jqueryMorevalidate.js"></script>
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
                            //console.log(res);
                            var jsonDoc = JSON.parse(res);
                            //console.log(jsonDoc);
                            var liData = '';
                            jQuery(".searchlist > ul").html('');
                            jQuery.each( jsonDoc, function( key, value ) {
                                liData += '<li class="list-group-item" data-lid="'+key+'" value="'+value.leads_id+'">'+value.first_name+value.last_name+ ' '
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
        <script type="text/javascript">
            jQuery(document).on('click','#save_',function(){
                jQuery('#Assignform').validate({
                    rules:{
                      searchLead:{
                          required:true,
                        },
                    },
                    messages:{
                      searchLead:{
                      required:"* Select lead name",
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
        <!-- start product script  -->
        <script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script> 
        <script>
            jQuery(document).ready(function() {
                jQuery('.js-example-basic-single').select2({
                  placeholder: 'Select Item',
                  allowClear: true
                });
            });



    function add_product(productId) {
        
        let profitmarg = jQuery("#profit_multipler").val();
        let salemarg = jQuery("#sale_percentage").val();
        var assemble = jQuery("input[name='assemble_value']:checked").val();
            jQuery.ajax({
                url:"<?php echo base_url('orders/add_product') ?>",
                type: "post",
                data:{ productId: productId,assemble:assemble },
                error:function(res){  },
                success:function(res){
                    if(res == 'error') return;
                    jsonp = JSON.parse(res);
                    
                   
                    
                    
                    if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
                        var counttr = jQuery('.table_append table tbody tr:not(.removetr)').length;
                        counttr = GenRandom.Job();
                    }else{
                        var counttr = 0;    
                    }

                    if ( jsonp[0].Width != '' || jsonp[0].Width != 'NA'  ) {
                        var width = jsonp[0].Width+"W x ";  
                    }else{
                        var width = '';
                    }

                    if ( jsonp[0].Height != '' || jsonp[0].Width != 'NA' ) {
                        var height = jsonp[0].Height+"H x ";    
                    }else{
                        var height = '';
                    }

                    if ( jsonp[0].Depth != '' || jsonp[0].Width != 'NA' ) {
                        var depth = jsonp[0].Depth+"D x ";  
                    }else{
                        var depth = '';
                    }
                    
                    /*if( typeof jsonp[0].Item_descriptionII == 'undefined'  ){ kdescII =  "N/A"; }else{ kdescII =  jsonp[0].Item_descriptionII; }*/


                    if( assemble == '1' ){
                        console.log( assemble );
                        console.log( jsonp[0].item_cost );
                        console.log( jsonp[0].unassembled_retail_item_price );

                        var ted_pricet = jsonp[0].item_cost;
                        var cust_pricet = jsonp[0].unassembled_retail_item_price;
                    }else{
                        var ted_pricet = jsonp[0].cabinet_assembly_price;
                        var cust_pricet = jsonp[0].assembled_retail_item_price;
                    }

                    if ( ted_pricet == '' && ted_pricet == 'NA'  ) {
                        ted_pricet = 0;
                    }

                    if ( cust_pricet == '' && cust_pricet == 'NA'  ) {
                        cust_pricet = 0;
                    }
                    let profit = ted_pricet * parseFloat(profitmarg/100);
                    let sale = cust_pricet * parseFloat(salemarg/100);

                    
                    ted_pricet  = parseFloat( ted_pricet ) + parseFloat( profit );
                    cust_pricet = parseFloat( cust_pricet ) + parseFloat( sale );

                    ted_pricet = ted_pricet.toFixed(2);
                    cust_pricet = cust_pricet.toFixed(2);
                    
                    listProduct  = "<tr id='pro_"+jsonp[0].pkpro_id+"' class='add_row"+ counttr +" del_prnt"+jsonp[0].pkpro_id+"'>";
                    listProduct += "<td><input type='hidden' value='" + jsonp[0].Item_Code + "' class='pk_Item_Code' pr-id='" + jsonp[0].pkpro_id + "' name='product["+counttr+"][item_code]'>";

                    listProduct += "<input type='hidden' value='" + jsonp[0].sid + "' class='pk_Item_Code' pr-id='" + jsonp[0].pkpro_id + "' name='product["+counttr+"][style_id]'>";
                    

                    listProduct += "<input type='number' class='qty' style='width:70px;' value='1' name='product["+counttr+"][qty]'  data-id = '"+ counttr +"' id='qty"+jsonp[0].pkpro_id+"'></td>";

                    listProduct += "<td><span>" + jsonp[0].style_code + "</span>/<span>"+jsonp[0].Item_Code+"</span></td>";

                    listProduct += "<td style='width: 46%;'><p name='product["+counttr+"][multides]'>"+jsonp[0].style_name+"/" + jsonp[0].Item_description +" "+ width + height + depth+"</p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+counttr+"][description]' value=''></div>";

                    listProduct += "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+counttr+"][descriptionII]' value=''></td></div>";

                    
                    listProduct += "<td class='bottomLine'><input class='form-control calcprice change_price' name='product["+counttr+"][aftercharge]' id='calcprice"+ counttr +"' value='' data-price='"+counttr+"' afappend-price=''><p></p>";

                    listProduct += "<input class='form-control calcprice assemb_price' name='product["+counttr+"][price]' id='calcprice"+counttr+"' value='' data-preal='"+counttr+"' asappend-price=''>";
                    
                    listProduct += "</td>";
                    
                    var pers = (cust_pricet-ted_pricet)/ted_pricet*100;

                    listProduct += "<td class='bottomLine'><span class='align-center afterdeff' id='afterdeff"+counttr+"' dat_p='"+ted_pricet+"'>"+ted_pricet+"("+Math.ceil(pers)+"%)</span><span class='align-center salePrice' id='finalp"+counttr+"' dat_p='"+cust_pricet+"' >" + cust_pricet + "</span></td>";
                    
                    listProduct += '<td><div class="icon_content"><div class="f_icon add_icon">';
                    
                    listProduct += '<i data-prid="'+ jsonp[0].pkpro_id +'" class="mdi mdi-plus-circle mr-1 add_field" data_btn="'+ counttr +'" parent_id="" item_code="'+jsonp[0].Item_Code+'" style_id="'+jsonp[0].sid+'"></i>';
                    
                    listProduct += '<input type="hidden" value="'+ jsonp[0].pkpro_id +'" name="product['+counttr+'][product_id]"></div>';
                    
                    listProduct += '<div class="f_icon delete_icon"><i data-prid="'+ jsonp[0].pkpro_id +'" class="mdi mdi-delete delete_Items" parent_remove ="Yes"></i></div></div></td>';
                    
                    listProduct += "</tr>";

                    jQuery('.table_append > table').append(listProduct);
                    jQuery('.removetr').remove();
    
                },


            });
    
    }
            
            jQuery(document).on('select2:select', '#selectItem', function (e) {
                    let productId  = jQuery(this).val();
                    
                if( jQuery('#pro_'+productId).length ){
    			    let prolen = jQuery('#pro_'+productId).length;
    			    let qtyVal = jQuery( '#qty'+productId ).val();
    			    let totalQty = parseFloat(qtyVal) + parseFloat(prolen);
    			    jQuery( '#qty'+productId ).val( totalQty );
		        }else{
                    
                    let profitmarg = jQuery("#profit_multipler").val();
                    let salemarg = jQuery("#sale_percentage").val();
                    
                    jQuery.ajax({
                        url:"<?php echo base_url('orders/add_product') ?>",
                        type: "post",
                        data:{ productId: productId },
                        error:function(res){ console.log(res); },
                        success:function(res){
                            jsonp = JSON.parse(res);
                            let table_price = jsonp[0].Cabinet_price;
                            let profit = table_price * parseFloat(profitmarg/100);
                            let sale = table_price * parseFloat(salemarg/100);
                            let proSale = parseFloat(table_price) + parseFloat( profit ) + parseFloat( sale );
                            console.log( "total = " + table_price + " afterprice = " + proSale );
                            
                            if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
                                var counttr = jQuery('.table_append table tbody tr:not(.removetr)').length;
                            }else{
                                var counttr = 0;    
                            }
                            console.log(counttr);
                            listProduct  = "<tr id='pro_"+jsonp[0].pkpro_id+"' class='add_row"+ counttr +"'>";
        					listProduct += "<td><input type='hidden' value='" + jsonp[0].Item_Code + "' class='pk_Item_Code' pr-id='" + jsonp[0].pkpro_id + "' name='pk_Item_Code[]'>";
        					listProduct += "<input type='number' class='qty' style='width:70px;' value='1' name='product["+counttr+"][qty]'  data-id = '"+ counttr +"' id='qty"+jsonp[0].pkpro_id+"'></td>";
        					listProduct += "<td><span>" + jsonp[0].style_code + "</span>/<span>"+jsonp[0].Item_Name+"</span></td>";
        					listProduct += "<td style='width: 46%;'><p name='product["+counttr+"][multides]'>"+jsonp[0].style_name+"/" + jsonp[0].Item_description +" "+ jsonp[0].Width+"W x " + jsonp[0].Height+"H x " + jsonp[0].Depth+"D"+"</p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+counttr+"][description]' value=''></div>";
        					listProduct += "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+counttr+"][descriptionII]' value=''></td></div>";
        					
        					listProduct += "<td><div class='cost_content'><div class='cost_input cost_first'><div class='input-group'><input type='text' width='100px' class='form-control assembprice' name='product["+counttr+"][price]' id='assembprice"+ counttr +"' value='' data-price='" + jsonp[0].item_assembly_price + "' count='"+ counttr +"' ><div class='input-group-append'><span class='input-group-text assembprice"+ counttr +"'></span></div></div></div>";
        					listProduct += "<div class='cost_input cost_sec'><input class='form-control aftercharge' name='product["+counttr+"][aftercharge]' id='aftercharge"+ counttr +"' value='"+ jsonp[0].item_assembly_price +"' data-price=''></div></div></td>";
        					listProduct += "<td><span class='align-center' >" + jsonp[0].cabinet_assembly_price + "</span></td>";
        					listProduct += '<td><div class="icon_content"><div class="f_icon add_icon">';
                            listProduct += '<i data-prid="'+ jsonp[0].pkpro_id +'" class="mdi mdi-plus-circle mr-1 add_field" data_btn="'+ counttr +'" parent_id=""></i>';
                            listProduct += '<input type="hidden" value="'+ jsonp[0].pkpro_id +'" name="product['+counttr+'][product_id]"></div>';
                            listProduct += '<div class="f_icon delete_icon"><i data-prid="'+ jsonp[0].pkpro_id +'" class="mdi mdi-delete delete_Items"></i></div></div></td>';
                            listProduct += "</tr>";
                            jQuery('.table_append > table').append(listProduct);
                            jQuery('.removetr').remove();
            
                        },
                        
                    });
		        }
            
                });
                
            jQuery( document ).on('keyup','.assembprice',function(){
    		    let valuebyinp = jQuery( this ).val();
    		    let countbytr  = jQuery( this ).attr('count');
    		    let databyasse = jQuery( this ).attr('data-price');
    		    
    		    jQuery( '.assembprice'+countbytr ).html('');
    		    
    		    if( valuebyinp!='' ){
        		    let valres = databyasse - valuebyinp;
        		    jQuery( '.assembprice'+countbytr ).append( valres );
    		    }
		    
		    });
    
                jQuery(document).on('click','.delete_Items',function(){
                    let parent_remove = jQuery(this).attr('parent_remove');
                    console.log(parent_remove);
                    let data_prid = jQuery(this).attr('data-prid');
                    if( parent_remove == 'Yes' ){
                        jQuery('.del_prnt'+data_prid).remove();
                    }else{

                        jQuery(this).closest('tr').fadeOut().remove();
                    }
                    all_t_price();

                });
    
                jQuery( document ).on('click','#importcustpro', function(){ 
                     var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/;  
                     if (regex.test($("#file_upload").val().toLowerCase())) {  
                         var xlsxflag = false;
                         if ($("#file_upload").val().toLowerCase().indexOf(".xlsx") > 0) {  
                             xlsxflag = true;  
                         }  
                        if (typeof (FileReader) != "undefined") {  
                             var reader = new FileReader();  
                             reader.onload = function (e) {  
                                 var data = e.target.result;  
                                 if (xlsxflag) {  
                                     var workbook = XLSX.read(data, { type: 'binary' });  
                                 }else{  
                                     var workbook = XLS.read(data, { type: 'binary' });  
                                 }  
                                var sheet_name_list = workbook.SheetNames;  
                  
                                var cnt = 0; 
                                sheet_name_list.forEach(function (y) {   
                                     if (xlsxflag) {  
                                         var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);  
                                     }else{  
                                         var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);  
                                    }
                                    jQuery.ajax({
                                        url:"<?= base_url('orders/check_product') ?>",
                                        type: "POST",
                                        data:{ skuvalue:exceljson},
                                        error:function(res){
                                            console.log( res );
                                        },
                                        success:function(res){
                                            if( res != "" ){
                                               var exceldata = jQuery.parseJSON(res);
                                                if (exceldata.length > 0 && cnt == 0) { 
                                                     BindTable(exceldata, '.table_append');  
                                                     cnt++;  
                                                }  
                                            }
                                        },
                                    }); 
                                 });  
                                 $('.table_append').show();  
                             }  
                             if (xlsxflag) { 
                                 reader.readAsArrayBuffer($("#file_upload")[0].files[0]);  
                             }else{  
                                 reader.readAsBinaryString($("#file_upload")[0].files[0]);  
                             }  
                        }else{  
                             alert("Sorry! Your browser does not support HTML5!");  
                         }  
                    }else{  
                         let data_v = jQuery( '.display' ).attr('data-v');
        			    if( data_v == 1 ){
        			        alert("Please upload a valid Excel file!");   
        			    }else{
            			    jQuery( '.display' ).removeClass('display_none');
            			    jQuery( '.display' ).addClass('display_t');
            			    jQuery( '#importcustpro' ).addClass('btn btn-success waves-effect waves-light');
            			    jQuery( '.append_input' ).removeClass('importclass');
            			    jQuery( '.download-file' ).show();
            			    jQuery( '.display' ).attr('data-v','1');
        			    } 
                     }  
                });
     
                function BindTable(jsondata, tableid) { 
                    var columns = BindTableHeader(jsondata, tableid); 
                        if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
                            var counttr = jQuery('.table_append table tbody tr:not(.removetr)').length;
                        }else{
                            var counttr = 0;    
                        }
                    if( jQuery("#profit_multipler").val() != '' ){ var profitmarg = jQuery("#profit_multipler").val(); } else { var profitmarg = 0;  }
                    if( jQuery("#sale_percentage").val() != '' ){ var salemarg = jQuery("#sale_percentage").val(); } else { var salemarg = 0;  }
                        console.log( profitmarg + " fkjdasf "+ salemarg );
                    jQuery.each( jsondata, function( i,jsonp ) {
                         
                        let table_price = '0';
                        let profit = '0';
                        let sale = '0';
                        let proSale = '0';
                         
                           /* console.log(k);         
                            if( typeof k['Description'] == "undefined" ){ var kdescII = ''; }else{ var kdescII = k['Description']; }*/
                
                    listProduct  = "<tr id='pro_"+jsonp.pkpro_id+"' class='add_row"+ counttr +"'>";
					listProduct += "<td><input type='hidden' value='" + jsonp.Item_Code + "' class='pk_Item_Code' pr-id='" + jsonp.pkpro_id + "' name='pk_Item_Code[]'>";
					listProduct += "<input type='number' class='qty' style='width:70px;' value='"+jsonp.Quantity+"' name='product["+counttr+"][qty]'  data-id = '"+ counttr +"' id='qty"+jsonp.pkpro_id+"'></td>";
					listProduct += "<td><span>"+ jsonp.style_Item+"</span></td>";
					listProduct += "<td style='width: 46%;'><p name='product["+counttr+"][multides]'>"+jsonp.Description+"</p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+counttr+"][description]' value=''></div>";
					listProduct += "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+counttr+"][descriptionII]' value=''></td></div>";
					
					listProduct += "<td><div class='cost_content'><div class='cost_input cost_first'><div class='input-group'><input type='text' width='100px' class='form-control assembprice' name='product["+counttr+"][price]' id='assembprice"+ counttr +"' value='' data-price='" + jsonp.Assembly + "' count='"+ counttr +"' ><div class='input-group-append'><span class='input-group-text assembprice"+ counttr +"'>" + jsonp.Assembly + "</span></div></div></div>";
					listProduct += "<div class='cost_input cost_sec'><input class='form-control aftercharge' name='product["+counttr+"][aftercharge]' id='aftercharge"+ counttr +"' value='"+ jsonp.Assembly +"' data-price=''></div></div></td>";
					listProduct += "<td><span class='align-center' >" + jsonp.price + "</span></td>";
					listProduct += '<td><div class="icon_content"><div class="f_icon add_icon">';
                    listProduct += '<i data-prid="'+ jsonp.pkpro_id +'" class="mdi mdi-plus-circle mr-1 add_field" data_btn="'+ counttr +'" parent_id=""></i>';
                    listProduct += '<input type="hidden" value="'+ jsonp.pkpro_id +'" name="product['+counttr+'][product_id]"></div>';
                    listProduct += '<div class="f_icon delete_icon"><i data-prid="'+ jsonp.pkpro_id +'" class="mdi mdi-delete delete_Items"></i></div></div></td>';
                    listProduct += "</tr>";
                            
                            
                            jQuery('.table_append > table').append(listProduct);
                            jQuery('.removetr').remove();
                        counttr++;
                     });
                } 
 
                function BindTableHeader(jsondata, tableid) {
                    var columnSet = [];  
                    var headerTr$ = $('<tr/>');  
                    for (var i = 0; i < jsondata.length; i++) {  
                    var rowHash = jsondata[i];  
                        for (var key in rowHash) {  
                            if (rowHash.hasOwnProperty(key)) {  
                                if ($.inArray(key, columnSet) == -1) {
                                    columnSet.push(key);  
                                    headerTr$.append($('<th/>').html(key));  
                                }  
                            }  
                        }  
                    }  
                    return columnSet;  
                }
                
        	/* assembaly price calcu */
		
		jQuery( document ).on('keyup','.assembprice',function(){
		    let valuebyinp = jQuery( this ).val();
		    let countbytr  = jQuery( this ).attr('count');
		    let databyasse = jQuery( this ).attr('data-price');
		    console.log( 'value=>'+valuebyinp+' count=>'+countbytr+' data-price=>'+databyasse );
		    
		    jQuery( '.assembprice'+countbytr ).html('');
		    
		    if( valuebyinp!='' ){
    		    let valres = parseFloat(databyasse) - parseFloat(valuebyinp);
    		    jQuery( '.assembprice'+countbytr ).append( valres );
		    }
		    
		});
 
        jQuery( document ).on('click','.extraTax',function() {
            let proprice       = jQuery( '#profit_multipler' ).find(":selected").val();
            let mysale       = jQuery( '#sale_percentage' ).find(":selected").val();
            let table_price  = jQuery( 'table tbody tr:last' ).find('.Productprice').val();
            let profit = table_price * parseFloat(proprice/100);
            let sale = table_price * parseFloat(mysale/100);
            let proSale = parseFloat(table_price) + parseFloat( profit ) + parseFloat( sale );
            let finalproSale = Math.ceil( proSale );
            jQuery( 'table tbody tr:last' ).find('.aftercharge').val(finalproSale);
        });
 
    jQuery(document).on('change','.qty',function(){
        let qValue = jQuery(this).val();
        let qattr = jQuery(this).attr('data-id');
        let finalpA = jQuery('#finalp'+qattr).attr('dat_p');
        let afterdeffA = jQuery('#afterdeff'+qattr).attr('dat_p');
        let calcprice = jQuery('#calcprice'+qattr).val();
        let assemb_price = jQuery('#assemb_price'+qattr).val();
        if( calcprice == '' ) { calcprice = 0; }
        if( assemb_price == '' ) { assemb_price = 0; }
        let qafterdeff = (qValue * afterdeffA) + parseFloat(calcprice);
        let qfinalp =    (qValue * finalpA) + parseFloat(assemb_price);
        qafterdeff = qafterdeff.toFixed(2);
        qfinalp =   qfinalp.toFixed(2);
        var newMorkup = ( qfinalp - qafterdeff)/qafterdeff*100;
        jQuery('#afterdeff'+qattr).html(qafterdeff+'('+newMorkup.toFixed(2)+'%)');
        jQuery('#finalp'+qattr).html(qfinalp);
        all_t_price();
    }); 
        jQuery( document ).on('click','.add_field',function(){
        let data_btn  = jQuery( this ).attr('data_btn');
        let parent_id = jQuery( this ).attr('parent_id');
        let pr_id     = jQuery( this ).attr('data-prid');
        let item_code =  jQuery( this ).attr('item_code');
        let style_id =  jQuery( this ).attr('style_id');
        let subChild_name =  jQuery( this ).attr('subChild_name');
        
        let parent_class = jQuery( this ).parent().parent().attr('class');

        if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
            var countrowpro = jQuery('.table_append table tbody tr:not(.removetr)').length;
            countrowpro = GenRandom.Job();

        }else{
            var countrowpro = 0;     
        }
        jQuery.ajax({
                url: "<?php echo site_url('orders/get_child_product')?>",
                data: { item_code:item_code,style_id:style_id },
                method: 'POST',
                error: function(res){ console.log(res); },
                success: function(res){
                    jQuery('#style_item'+countrowpro).html(res);
                }
        });

        let countIncrease = countrowpro + 1;
        let rowAppendpro = "<tr class='child_"+parent_class+" del_prnt"+pr_id+"' style='background:#dff0d8' id='pro_"+countrowpro+"'>";
            
            rowAppendpro+= "<td><input type='number' class='qty' style='width:70px;' min = '1' value='1' name='product["+data_btn+"][child_item]["+countrowpro+"][qty]'  data-id = '"+countrowpro+"'></td>";
            
            rowAppendpro+= "<td><select class='form-control style_item' id='style_item"+countrowpro+"' data-sl='"+countrowpro+"'></select></td>";
            
            rowAppendpro+= "<td style='width: 46%;'><p class='subdes' id='desc"+countrowpro+"'></p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+data_btn+"][child_item]["+countrowpro+"][description]' value=''></div>";
            rowAppendpro+= "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+data_btn+"][child_item]["+countrowpro+"][descriptionII]' value=''></div></td>";

            rowAppendpro += "<td class='bottomLine'><input class='form-control calcprice change_price' name='product["+data_btn+"][child_item]["+countrowpro+"][u_price]' id='calcprice"+countrowpro+"' value='' data-price='"+countrowpro+"' afappend-price=''><p></p>";

            rowAppendpro += "<input class='form-control calcprice assemb_price' name='product["+data_btn+"][child_item]["+countrowpro+"][price]' id='calcprice"+countrowpro+"' value='' data-price='"+countrowpro+"' data-preal='"+countrowpro+"' asappend-price=''>";
            rowAppendpro += "</td>";

            rowAppendpro += "<td class='bottomLine'><span class='align-center afterdeff' id='afterdeff"+countrowpro+"'></span><span class='align-center salePrice' id='finalp"+countrowpro+"' dat_p = ''></span></td>";
            
            rowAppendpro+= "<td>";
            rowAppendpro+= "<input type='hidden' value='' name='product["+data_btn+"][child_item]["+countrowpro+"][product_id]' id='product_id"+countrowpro+"'>";

            rowAppendpro += '<i data-prid="'+countrowpro+'" class="mdi mdi-plus-circle mr-1 add_child_field" id="add_child'+countrowpro+'" data_btn="'+ countrowpro +'" parent_id="" item_code="" data_prnt="'+data_btn+'" style_id="'+style_id+'" del_prnt="'+pr_id+'" ></i>';

            rowAppendpro+= "<i class='mdi mdi-delete delete_Items' data-prid='"+countrowpro+"'></i><input type='hidden' name='product["+data_btn+"][child_item]["+countrowpro+"][parent_id]' value='"+ parent_id +"' id='total_p"+countrowpro+"'></td>";
            
            rowAppendpro+= "</tr>";
                
        jQuery( '.add_row'+data_btn ).after( rowAppendpro );

        
    });

        jQuery( document ).on('click','.add_child_field',function(){
        let data_btn  = jQuery( this ).attr('data_btn');
        let parent_id = jQuery( this ).attr('parent_id');
        let pr_id     = jQuery( this ).attr('data-prid');
        let item_code =  jQuery( this ).attr('item_code');
        let style_id =  jQuery( this ).attr('style_id');
        let subChild_name =  jQuery( this ).attr('subChild_name');
        let data_prnt   = jQuery( this ).attr('data_prnt');
        let del_prnt    = jQuery( this ).attr('del_prnt');
        
        
        let parent_class = jQuery( this ).parent().parent().attr('class');

        if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
            var countrowpro = jQuery('.table_append table tbody tr:not(.removetr)').length;
            countrowpro = GenRandom.Job();
        }else{
            var countrowpro = 0;    
        }

        let countIncrease = countrowpro + 3;
        jQuery.ajax({
                url: "<?php echo site_url('orders/get_child_product')?>",
                data: { item_code:item_code,style_id:style_id },
                method: 'POST',
                error: function(res){ console.log(res); },
                success: function(res){
                    jQuery('#style_item'+countIncrease).html(res);

                }
        });

        let rowAppendpro = "<tr class='child_"+parent_class+" del_prnt ='"+del_prnt+"'' style='background:#b9d0af' id='pro_"+countIncrease+"'>";
            
            rowAppendpro+= "<td><input type='number' class='qty' style='width:70px;' min = '1' value='1' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][qty]'  data-id = '"+countIncrease+"'></td>";
            
            rowAppendpro+= "<td><select class='form-control style_item' id='style_item"+countIncrease+"' data-sl='"+countIncrease+"'></select></td>";
            

            rowAppendpro+= "<td style='width: 46%;'><p class='subdes' id='desc"+countIncrease+"'></p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][description]' value=''></div>";

            rowAppendpro+= "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][descriptionII]' value=''></div></td>";

            rowAppendpro += "<td class='bottomLine'><input class='form-control calcprice change_price' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][u_price]' id='calcprice"+countIncrease+"' value='' data-price='"+countIncrease+"' afappend-price=''><p></p>";

            rowAppendpro += "<input class='form-control calcprice assemb_price' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][price]' id='calcprice"+countIncrease+"' value='' data-price='"+countIncrease+"' data-preal='"+countIncrease+"' asappend-price=''>";
            rowAppendpro += "</td>";

            rowAppendpro += "<td class='bottomLine'><span class='align-center afterdeff' id='afterdeff"+countIncrease+"'></span><span class='align-center salePrice' id='finalp"+countIncrease+"' dat_p = ''></span></td>";
            
            rowAppendpro+= "<td>";
            rowAppendpro+= "<input type='hidden' value='' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][product_id]' id='product_id"+countIncrease+"'>";
            rowAppendpro+= "<i class='mdi mdi-delete delete_Items' data-prid='"+countIncrease+"'></i><input type='hidden' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][parent_id]' value='"+ parent_id +"' id='total_p"+countIncrease+"'></td>";
            
            rowAppendpro+= "</tr>";

        jQuery( '#pro_'+data_btn ).after( rowAppendpro );
        
    });

        </script>

        <script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
        <script>
            jQuery(document).ready(function(){
                 $("#requested_delivery_date").flatpickr({ 
                    dateFormat:'m-d-Y'
                            });
                            
            });
        </script>
        
    <script>
    
     jQuery(document).on('change','#category',function(){
                var catId = jQuery(this).val(); 
                //var catId = jQuery(this).attr('cat_data');
        	    jQuery.ajax({
        	        url:'<?php echo base_url('orders/appendcat'); ?>',
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
        		            jQuery('.subchildCatogery').html('');
        		            listcat += "<div class='form-group'>";
        		                listcat += "<label for='name'>Sub Category</label>";
        		                listcat += "<select class ='form-control' name='subCatogeryFirst' class='subCatogeryFirst' id='subCatogeryFirst' catId=''>";
        		            	listcat += "<option value='0' class='subCatogeryFirst' sub_cat_data=''>Select Sub Category</option>";
        		            	jQuery.each(jsonCat, function(key,value){
        		                	listcat += "<option value='"+key+"' class='subCatogeryFirst' sub_cat_data='"+key+"'>"+value.cat_name+"</option>";
        		            	});
        		                listcat += "</select>";
        		                listcat += "</div>";
        		                jQuery('.subCatogery').append(listcat);
                        }else{
        		        	jQuery('.subCatogery').html('');
        		        	jQuery('.subchildCatogery').html('');
        		        }
        	        }
        	    });
    });

    jQuery(document).on('change','#subCatogeryFirst',function(){
    catId = jQuery(this).val();
	jQuery.ajax({
			url:'<?php echo base_url('orders/appendcat'); ?>',
			type:'POST',
			data:{ catId:catId },
			error:function(res){ console.log(res); },
			success:function(res){ 
				if( res != 'false' ){
		            var jsonCat   = JSON.parse(res);
		            var listcat   = '';
		            jQuery('.subchildCatogery').html('');
		            listcat += "<div class='form-group'>";
		                listcat += "<label for='name'>Sub Category</label>";
		                listcat += "<select class ='form-control' name='subCatogerysecond' class='subCatogerysecond' id='subCatogerysecond' catIdsub=''>";
		                listcat += "<option value='0' class='subCatogeryFirst' sub_cat_data=''>Select Sub Category</option>";
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
    });
      
    
    
    jQuery( document ).on('change','#vendorName',function(){

    	var v_id = jQuery(this).val();
		jQuery.ajax({
			url:"<?php echo base_url('orders/get_style_by_vi') ?>",
			type: "post",
			data:{ v_id: v_id },
			success:function(res){
			    jQuery('#styleName').html(res);
			},
		});
    });
    
   jQuery( document ).on('change','#vendorName',function(){

        var v_id = jQuery(this).val();
        jQuery.ajax({
            url:"<?php echo base_url('orders/get_style_by_vi') ?>",
            type: "post",
            data:{ v_id: v_id },
            success:function(res){
                jQuery('#styleName').html(res);
            },
        });
    });
    
    jQuery(document).on('change','#category',function(){
                var catId = jQuery(this).val(); 
        	    jQuery.ajax({
        	        url:'<?php echo base_url('orders/get_pro_by_cat'); ?>',
        	        type:'POST',
        	        data:{ catId:catId},
        	        success:function(res){
        		            var listcat   = '';
        		            jQuery('.subCatogery').html('');
        		            listcat += "<div class='form-group'>";
        		                listcat += "<label for='name'>Sub Category</label>";
        		                listcat += "<select class ='form-control' name='subCatogeryFirst' class='subCatogeryFirst' id='subCatogeryFirst' catId=''>";
        		            	listcat += res;
        		                listcat += "</select>";
        		                listcat += "</div>";
        		                jQuery('.subCatogery').append(listcat);
        	        }
        	    });
            });
            
            
    jQuery(document).on('change','#subCatogeryFirst',function(){
        let sub_cid = jQuery(this).val();
        let st_id = jQuery('#styleName').val();    
		let c_id = jQuery('#category').val();
	    jQuery.ajax({
	        url:'<?php echo base_url('orders/get_pro_by_subcat'); ?>',
	        type:'POST',
	        data:{st_id:st_id,c_id:c_id,sub_cid:sub_cid},
	        success:function(res){
				jQuery('#selectItem').html(res);
				jQuery('#selectItem').select2();
	        }
	    });
    });

    jQuery(document).on('click','.catDrop',function(){
        jQuery('.resList ul').hide();
        jQuery('.catHolder').html('');
        jQuery('.resList ul#mainCats').show();
    });
        
    jQuery(document).on('click','#mainCats li',function(){
        let cat_id = jQuery(this).attr('data-catid');
        let s_name = jQuery('#styleName').val();        
        jQuery('.catHolder').html('');
        jQuery('.mainCats .catHolder').html( jQuery(this).html() );
        jQuery('.mainCats .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'Category'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                if(resp.status == 'notfinal'){
                    jQuery('.resList ul#childCats').html(resp.res);
                    jQuery('.resList ul#childCats').show();
                }else{
                    jQuery('.resList ul#proRes').html(resp.res);
                    jQuery('.resList ul#proRes').show();
                }
            }
        });
    });

    jQuery(document).on('click','#childCats li',function(){
        let cat_id = jQuery(this).attr('data-catid');
        let s_name = jQuery('#styleName').val();
        jQuery('.childCats .catHolder').html( jQuery(this).html() );
        jQuery('.childCats .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_first'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                if(resp.status == 'notfinal'){
                    jQuery('.resList ul#subChild').html(resp.res);
                    jQuery('.resList ul#subChild').show();
                }else{
                    jQuery('.resList ul#proRes').html(resp.res);
                    jQuery('.resList ul#proRes').show();
                }
            }
        });
    });
    
    jQuery(document).on('click','#subChild li',function(){
        let cat_id = jQuery(this).attr('data-catid');
        let s_name = jQuery('#styleName').val();
        jQuery('.subChild .catHolder').html( jQuery(this).html() );
        jQuery('.subChild .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_second'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                jQuery('.resList ul#proRes').html(resp.res);
                jQuery('.resList ul#proRes').show();
            }
        });
    });
    
    jQuery(document).on('click','.mainCats .catHolder',function(){
        jQuery('.resList ul').hide();
        jQuery('.childCats .catHolder').html('');
        jQuery('.subChild .catHolder').html('');
        let cat_id   = jQuery(this).attr('cat-id');
        let s_name = jQuery('#styleName').val();
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_first'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                jQuery('.resList ul#childCats').html(resp.res);
                jQuery('.resList ul#childCats').show();
            }
        });
    });
    
    jQuery(document).on('click','.childCats .catHolder',function(){
        jQuery('.resList ul').hide();
        jQuery('.subChild .catHolder').html('');
        let cat_id   = jQuery(this).attr('cat-id');
        let s_name = jQuery('#styleName').val(); 
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_second'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                jQuery('.resList ul#subChild').html(resp.res);
                jQuery('.resList ul#subChild').show();
            }
        });
    });
    
    jQuery(document).on('click','.subChild .catHolder',function(){
        jQuery('.resList ul').hide();
        let cat_id   = jQuery(this).attr('cat-id');
        let s_name = jQuery('#styleName').val();
        jQuery.ajax({
            url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
            type:"post",
            data:{ cat_id : cat_id, s_name:s_name, cat_type : 'product'},
            success:function(res){
                var resp = jQuery.parseJSON(res);
                jQuery('.resList ul#proRes').html(resp.res);
                jQuery('.resList ul#proRes').show();

            }
        });
    });
    
    jQuery(document).on('dblclick', '#proRes li', function (e) {
        var productId  = jQuery(this).attr('data-catid');
        if( jQuery('#pro_'+productId).length ){
            let prolen = jQuery('#pro_'+productId).length;
            let qtyVal = jQuery( '#qty'+productId ).val();
            let totalQty = parseFloat(qtyVal) + parseFloat(prolen);
            jQuery( '#qty'+productId ).val( totalQty );
        }else{
            add_product(productId);
            setTimeout(function(){ all_t_price(); }, 1000);
        }
    });

    jQuery(document).on('keyup', '#searchPro', function (e) {
        var styleName  = jQuery('#styleName').val();
        var vendorName = jQuery('#vendorName').val();
        var srch = jQuery(this).val();
        
        if( srch.length > 1 ){
            jQuery('.resList ul').hide(); 
            jQuery('.resList ul#proRes').show();
            jQuery.ajax({
                url:"<?php echo base_url('orders/get_product_filter'); ?>",
                type:"post",
                data:{ search:srch, vendor_id:vendorName, style_id:styleName},
                success:function(res){
                    var resp = jQuery.parseJSON(res);
                    jQuery('.resList ul#proRes').html(resp.res);
                }
            });
        }
    });
        
    /* new category function */
    jQuery(document).on('change','#styleName',function(){
            var sID = jQuery('#styleName').val();
            jQuery('.resList ul').html('');
            jQuery('.catHolder').html('');
            jQuery.ajax({
                url:"<?php echo base_url('orders/cat_by_style'); ?>",
                type:"post",
                data:{ style_id:sID},
                success:function(res){
                    jQuery('.resList ul').hide();
                    jQuery('#mainCats').html(res);
                }
            });
        });

    jQuery(document).on('change','.style_item',function(){
            let productId = jQuery(this).val();
            let data_sl = jQuery(this).attr('data-sl');

            jQuery.ajax({
            url:"<?php echo base_url('orders/add_product_p') ?>",
            type: "post",
            data:{ productId:productId },
            error:function(res){  },
            success:function(res){
                if(res == 'error') return;
                let j = jQuery.parseJSON(res);

                if ( (j.Width != '') && (j.Width != 'NA')  ) {
                    var widthj = j.Width+"W x ";    
                }else{
                    var widthj = '';
                }

                if ( (j.Height != '') && (j.Height != 'NA' ) ) {
                    var heightj = j.Height+"H x ";  
                }else{
                    var heightj = '';
                }

                if ( (j.Depth != '' ) && (j.Depth != 'NA' ) ) {
                    var depthj = j.Depth+"D";   
                }else{
                    var depthj = '';
                }

                let descr = j.style_name+'/'+j.Item_description+' '+widthj+heightj+depthj;

                var childassemble = jQuery("input[name='assemble_value']:checked").val();

                if( childassemble == '1' ){
                    var ted_price_child = j.item_cost;
                    var cust_price_child = j.unassembled_retail_item_price;
                }else{
                    var ted_price_child = j.cabinet_assembly_price;
                    var cust_price_child = j.assembled_retail_item_price;
                }

                if ( ted_price_child == '' || ted_price_child == 'NA'  ) {
                    ted_price_child = 0;
                }

                if ( cust_price_child == '' || cust_price_child == 'NA'  ) {
                    cust_price_child = 0;
                }

                ted_price_child = parseFloat( ted_price_child ).toFixed(2);
                cust_price_child =   parseFloat( cust_price_child ).toFixed(2);


                jQuery('#desc'+data_sl).html(descr);
                /*var pers = (j.cabinet_assembly_price-j.item_cost)/j.item_cost*100;*/

                var pers = (cust_price_child-ted_price_child)/ted_price_child*100;

                jQuery('#afterdeff'+data_sl).html(ted_price_child+'('+Math.ceil(pers)+'%)');
                jQuery('#afterdeff'+data_sl).attr('dat_p',ted_price_child);

                jQuery('#finalp'+data_sl ).html(cust_price_child);
                jQuery('#finalp'+data_sl ).attr('dat_p',cust_price_child);
                
                jQuery('#product_id'+data_sl ).val(j.pkpro_id);
                jQuery( '#add_child'+data_sl ).attr('item_code',j.Item_Code);
                all_t_price();
            },
        });
    });

      jQuery( document ).on('keyup','.change_price',function(){
        let change_price = parseFloat( jQuery(this).val() );
        let dat          = jQuery(this).attr('data-price'); 
        let afterdef  = parseFloat( jQuery('#afterdeff'+dat).attr('dat_p') );
        let salePrice  = parseFloat( jQuery('#finalp'+dat).attr('dat_p') );
        let asappend_price = jQuery('#finalp'+dat).attr('asappend-price');

        if( !isNaN(change_price) ){
                let change_abs = change_price;
                var total_change_price = parseFloat(afterdef) + parseFloat(change_abs);

        }else{

            var total_change_price = afterdef;

        }

        if( asappend_price == '' || asappend_price == undefined ){
            total_salePrice = salePrice;
        }else{
            total_salePrice = asappend_price;
        }
        //console.log( total_salePrice + '=>' + total_change_price );
        total_change_price =  total_change_price.toFixed(2);
        // total_change_price =  total_change_price.toString().substring(0, total_change_price.toString().indexOf(".") + 3);

        var pers = (total_salePrice-total_change_price)/total_change_price*100;
        jQuery( '#afterdeff' + dat ).attr('afappend-price',total_change_price);
        jQuery( '#afterdeff' + dat ).html(total_change_price+'('+Math.ceil(pers)+'%)');

    });

    jQuery( document ).on('keyup','.assemb_price',function(){
        let assemb_price = parseFloat( jQuery(this).val() );
        let dat          = jQuery(this).attr('data-preal'); 
        
        let salePrice  = parseFloat( jQuery('#finalp'+dat).attr('dat_p') );
        let afterdef  = parseFloat( jQuery('#afterdeff'+dat).attr('dat_p') );
        let afappend_price = jQuery('#afterdeff'+dat).attr('afappend-price');

        if( !isNaN(assemb_price) ){
                let assemb_abs = assemb_price;
                var total_assemb_price = parseFloat(salePrice) + parseFloat(assemb_abs);
        }else{
            var total_assemb_price  = salePrice; 
        }
        if( afappend_price == '' || afappend_price == undefined ){
            total_salePrice = afterdef;
        }else{
            total_salePrice = afappend_price;
        }
        total_assemb_price = total_assemb_price.toFixed(2);
        // total_assemb_price = total_assemb_price.toString().substring(0, total_assemb_price.toString().indexOf(".") + 3)
        var pers = (total_assemb_price-total_salePrice)/total_salePrice*100;
        jQuery('#finalp'+dat).html(total_assemb_price);
        jQuery('#finalp'+dat).attr('asappend-price',total_assemb_price);

        jQuery( '#afterdeff' + dat ).html(total_salePrice+'('+Math.ceil(pers)+'%)');

    });
    /*jQuery( document ).on('keyup','.change_price',function(){
    });*/
    var isCtrl = false;
    jQuery(document).keyup(function (e) {
        if(e.which == 17) isCtrl=false;
    }).keydown(function (e) {
        if(e.which == 17) isCtrl=true;
        if(e.which == 89 && isCtrl == true) {

            jQuery( '.afterdeff' ).css('display','block');
            jQuery( '.hidesub' ).css('visibility','visible');
            jQuery( '.delivery_cost' ).css('visibility','visible');
            return false;
        }
    });

/*jQuery( document ).on('click','.assemble_val',function(){
    var assemble_value = jQuery( this ).val();
    var order_id = jQuery( this ).attr('order_id');

    jQuery.ajax({
        url: '<?= base_url('orders/assemble_update'); ?>',
        method:'post',
        data: { assemble_value:assemble_value,order_id:order_id },
        error:function(res){
                console.log(res);
        },
        success:function(res){
                location.reload();
        }
    });
});*/
    jQuery(document).ready(function(){  

        jQuery( ".price_perc" ).keyup(function() { all_t_price(); });
        jQuery( ".net_price" ).keyup(function() { calculateNetPrice(jQuery(this).val()); });
        
    });

    jQuery( document ).on('keyup','.change_price',function(){ all_t_price(); });
    jQuery( document ).on('keyup','.assemb_price',function(){ all_t_price(); });

    jQuery( document ).on('keyup','.perc_amount',function(){
        var dis_val = jQuery(this).val();
        var saleP = jQuery('.SP').text();
        let affterdis = saleP - dis_val;
        let amount_per = 100 * (dis_val/saleP);
        var txxRate = jQuery('#txxRate').attr('data-tax');
        var ttax = (txxRate/100) * affterdis;
        var price_w = affterdis + ttax;

        jQuery('.txamt').text(ttax.toFixed(2));
        jQuery('.price_perc').val(amount_per.toFixed(2));
        jQuery('.net_price').val( price_w.toFixed(2) ); 

        var morkpamt  = jQuery('.morkpamt').text();
        var newMorkup = ( price_w.toFixed(2) - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
    });

    jQuery( document ).on('keyup','.delivery_price_inp',function(){ all_t_price() });   
    jQuery( document ).on('keyup','.delivery_cost_inp',function(){ all_t_price() });

    jQuery( document ).on('change','.is_pickup',function(){
        var is_pickup = jQuery(this).val();
        if (is_pickup == 'no') {
            jQuery('.delivery_price').show();
        }else{
            jQuery('.delivery_price').hide();
        }
    });
    

    function discount_val(total_price){
        let discount_val = jQuery( '.perc_amount' ).val();
        let amount_per = 100 * (discount_val/total_price);
        let affterdis = total_price - amount_per;
        jQuery('.price_perc').val( amount_per.toFixed(2) );
        jQuery('.net_price').val( affterdis.toFixed(2) ); 

        var morkpamt  = jQuery('.morkpamt').text();
        var newMorkup = ( affterdis.toFixed(2) - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));

    }

    function calculateNetPrice(total_price){
        
        var saleP = jQuery('.SP').text();
        var txxRate = jQuery('#txxRate').attr('data-tax');
        var ttax = (txxRate/100) * total_price;
        var price_wot = total_price-ttax;

        var discAmt = saleP-price_wot;
        var disPerc = (discAmt/saleP)*100;
        jQuery('.txamt').text(ttax.toFixed(2));
        jQuery('.price_perc').val(disPerc.toFixed(2));
        jQuery('.perc_amount').val(discAmt.toFixed(2));

        var morkpamt  = jQuery('.morkpamt').text();
        var newMorkup = ( total_price - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
    }

    function all_t_price(){
        var add_affprice = 0;
        jQuery(".afterdeff").each(function(){
            if( jQuery(this).text() ){
                add_affprice += parseFloat(jQuery(this).text());
            }
        });

        var add_salePrice = 0;
        jQuery(".salePrice").each(function(){
            if( jQuery(this).text() ){
                add_salePrice += parseFloat(jQuery(this).text());
            }
        });

        let pers = (add_salePrice-add_affprice)/add_salePrice*100;

        jQuery('.hidesub').html('<span class="morkpamt">'+add_affprice+'</span>(<span class="morkpperc">'+Math.ceil(pers)+'</span>%)');
        jQuery('.SP').html(add_salePrice.toFixed(2));
        jQuery( '.cost_t_price' ).val(add_affprice.toFixed(2));
        jQuery( '.subtotal' ).val(add_salePrice.toFixed(2));
        
        /* tax calc */
        discount_per( add_salePrice );      
    }

    function discount_per(total_price){ 
        let discount_val = jQuery( '.price_perc' ).val();
        let total_dis = total_price * (discount_val/100);
        let affterdis = total_price - total_dis;
        jQuery('.perc_amount').val( total_dis.toFixed(2) );
        jQuery('.net_price').val( affterdis.toFixed(2) );

        var morkpamt  = parseFloat(jQuery('.morkpamt').text());
        var newMorkup = ( affterdis - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
        tax_va(affterdis);
    }

    function tax_va(total_price){
        let Has_c = jQuery("input[name='resale_certificate']:checked").attr('data_check');
        let has_a = jQuery("input[name='has_a_uez']:checked").attr('data_check');
        let has_stform = jQuery("input[name='has_a_stform']:checked").attr('data_check');
        
        if ( Has_c == 'yes' || has_a == 'yes' || has_stform == 'yes'  ) {
            var sub_t_price = total_price;
            jQuery('.taxx').text('0.00');
            jQuery('.txamt').text('0.00');
            jQuery('.tax_hidden_val').val('0.00');
        }else{
            var txxRate = jQuery('#txxRate').attr('data-tax');
            let per_price = (txxRate/100) * total_price;
            var sub_t_price = parseFloat(total_price) + parseFloat(per_price);
            jQuery('.net_price').val( sub_t_price.toFixed(2) );
            jQuery('.taxx').text(txxRate);
            jQuery('.tax_hidden_val').val(per_price.toFixed(2));
            jQuery('.txamt').text( per_price.toFixed(2) );
        }
        

        var morkpamt  = jQuery('.morkpamt').text();
        var newMorkup = ( sub_t_price - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
        delevery_price( sub_t_price);
    }

    function delevery_price(total_price){
        let delivery_price_inp = jQuery( '.delivery_price_inp' ).val(); 
        if(delivery_price_inp){
            delivery_price_inp = jQuery( '.delivery_price_inp' ).val();
        }else{
            delivery_price_inp = 0;
        }
        let price_w = parseFloat(total_price) + parseFloat(delivery_price_inp);
        jQuery('.net_price').val( price_w.toFixed(2) ); 

        var morkpamt  = jQuery('.morkpamt').text();
        var newMorkup = ( price_w - morkpamt)/morkpamt*100;
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
        delivery_cost_inp(price_w);
    }

    function delivery_cost_inp(total_price){
        let delivery_cost_inp = jQuery( '.delivery_cost_inp' ).val();
        var morkpamt  = jQuery('.morkpamt').text();
        var p_morkpamt  = jQuery('.morkpamt').attr('price-morkpamt');
        var p_mamt  = jQuery('.morkpamt').attr('p_mamt');
        if(delivery_cost_inp){
            delivery_cost_inp = jQuery( '.delivery_cost_inp' ).val();
        }else{
            delivery_cost_inp = 0;
        }

        if ( p_mamt != '' ) {
            var price_w = parseFloat(morkpamt) + parseFloat(delivery_cost_inp);
        }else{
            var price_w = morkpamt;
        }
        jQuery('.net_price').val( total_price.toFixed(2) );

        var newMorkup = ( total_price - price_w)/price_w*100;
        jQuery('.morkpamt').text(price_w.toFixed(2));
        jQuery('.morkpamt').attr('p_mamt',price_w.toFixed(2));
        jQuery('.morkpperc').text(newMorkup.toFixed(2));
    }

    jQuery( document ).on('change','.hard_date',function(){
        var hard_date = jQuery(this).val();
        if (hard_date == 'yes') {
            jQuery('.hard_date_wrap').append('<span class="is_yes_hard">- Hard Date</span>');
        }else{
            jQuery('.is_yes_hard').remove();
        }
    });

    jQuery( document ).on('change','.payment_person',function(){
        var payment_person = jQuery(this).val();
        if (payment_person != 'no') {
            jQuery('.payment_person_wrap').addClass('dspln');
        }else{
            jQuery('.payment_person_wrap').removeClass('dspln');
        }
    });
    jQuery( document ).on('change','.resale_certificate',function(){
        var resale_certificate = jQuery(this).val();
        if (resale_certificate != 'yes') {
            jQuery('.has_resale_certificate').addClass('dspln');
        }else{
            jQuery('.has_resale_certificate').removeClass('dspln');
        }
        all_t_price();
    });
    
    jQuery( document ).on('change','.has_a_uez',function(){
        var has_a_uez = jQuery(this).val();
        if (has_a_uez != 'yes') {
            jQuery('.has_a_uez_cer').addClass('dspln');
        }else{
            jQuery('.has_a_uez_cer').removeClass('dspln');
        }
        all_t_price();
    });

    jQuery( document ).on('change','.has_a_stform',function(){ all_t_price(); });



    jQuery(document).ready(function(){
        jQuery(document).on('click','#shipping_option',function(){
            if(jQuery("#shipping_option").is(':checked'))
                jQuery("#shipping-content").show();  // checked
            else
                jQuery("#shipping-content").hide();  // unchecked
        });
        
         
    });

</script>


