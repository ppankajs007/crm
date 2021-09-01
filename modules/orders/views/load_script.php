<!-- Datatables script starts here -->
<?php 
$currentMethod = $this->router->fetch_method();
$globalMethods = array('index','edit', 'add', 'emails','product','quote_orders','fabOrders','jkOrders');
?>
<?php if( in_array($currentMethod,$globalMethods) ) { ?>
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
<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
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
				var is_pickup = jQuery("input[name='is_pickup']:checked").val();
				if ( is_pickup == 'no' ) {
					jQuery('.delivery_price').css( 'display','block' );
				}
			});
		</script>
<!-- third party js ends -->
<!-- Datatables init -->
<script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script>
<?php }
	if($currentMethod == 'edit' || $currentMethod == 'add') { ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
					$("#requested_delivery_date").flatpickr({ 
						dateFormat:'m-d-Y'
						});
					$("#hard_date").flatpickr({ 
						dateFormat:'m-d-Y'
						});
					 $("#estimated_delivery_date").flatpickr({ 
						dateFormat:'m-d-Y'
						});
					 $("#schedule_delivery_date").flatpickr({ 
						dateFormat:'m-d-Y'
						});
					 $("#survey_date").flatpickr({ 
						dateFormat:'m-d-Y'
						});    
				});
		</script>
<?php }?>
		<script>
			function deleteOrder( dataTableObj ){
				jQuery(document).on('click','#deleteOrder',function(e){
					 var ids = jQuery(this).attr("ids");
					swal({
							title: "Are you sure?",
						  text: "Once deleted, you will not be able to recover this Order again!",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						  showLoaderOnConfirm: true
							})
							.then((willDelete) => {
							  if (willDelete) {
									$.ajax({
										url: "<?php echo site_url('orders/delete_order')?>",
										data: { ids: ids },
										method: 'POST',
										error: function(data){  },
										success: function(res){
												if(res == "TRUE"){
													swal("Deleted!", "You clicked the button!", "success");
													dataTableObj.draw();
												} else {
													swal('Oops...', 'Something went wrong with ajax !', 'error');
												}   
											},
									})
							  }
							});
					});
				}



				function initCustomBox(){
					$('[data-plugin="custommodalEdit"]').on('click', function(e) {
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
					var dataTable = jQuery('#OrderTable').DataTable({
						"order": [[ 0, "desc" ]],
						"processing": true,
						"serverSide": true,
						"stateSave": true,
						"ajax": {
							"url": "<?php echo base_url('orders/order_row'); ?>",
							"type": "POST",
							error:function(res){
							  
							}
						},
						"initComplete":function( settings, json){
							initCustomBox();
							deleteOrder( dataTable );
						},
						 "createdRow": function( row, data, dataIndex ) {
							let total = data[7].substring(1, data[7].length); 
							let paid = data[8].substring(1, data[8].length); 
							let total_due = total - paid;
	  						let res = total_due *(100/total);
							let pro_per = data[10].toString();
							res = res.toFixed(2)

							pro_per = pro_per.substring(1, pro_per.length);

							   if( res >= 50 || res == 0 || res == 'NaN'  ){
									$( row ).css( {"color":"#5f6265","background-color":"#f2dede"} );
								} else if( res < 50 ){
								 	$( row ).css( {"color":"#5f6265","background-color":"#dff0d8"} );
								}
								console.log( 'red' );

								if ( pro_per < '70' ) {
									$( row ).find('td:eq(10)').css( {"color":"red"} );	
								}
						 },
						 "rowCallback": function( row, data, index ) {
						 	/*console.log( row );
						 	console.log( data[1] );*/
						                if (data[1] == 'Quote') {
						                	console.log( index );
						                    jQuery(row).remove();
						                }
						 }

					});
				});

				jQuery(document).ready(function(){
					var dataTable = jQuery('#Quote').DataTable({
						'order': [[0,'desc']],
						"processing": true,
						"serverSide": true,
						"stateSave": true,
						"ajax": {
							"url": "<?php echo base_url('orders/orders_quote'); ?>",
							"type": "POST",
							error:function(res){
							  
							}
						},
						"initComplete":function( settings, json){
							initCustomBox();
							deleteOrder( dataTable );
						},
						 "createdRow": function( row, data, dataIndex ) {
							 let data_paid = data[8].toString();
							 let res = data_paid.replace("%","");
							   if( res <= 50 || res == 0  ){
									$( row ).css( {"color":"#5f6265","background-color":"#f2dede"} );
								} else if( res > 50 ){
									$( row ).css( {"color":"#5f6265","background-color":"#dff0d8"} );
								}
						 },
					});
				});

				jQuery(document).on('click','#save_',function(){
				 jQuery("#add_order").validate({
						rules: {
							status: {
								required:true,
								},
							vendor: {
								required:true,
								},
							product_type: {
								required:true,
								},
							vendor: {
								required:true,
								},
						},
						messages: {
								status: {
									required:"* Please Select Status",
									},
								vendor: {
									required:"* Please Select Vendor",
									},
								 product_type: {
									required:"* Please Enter Product Type",
									},
								 first_name: {
									required:"* Please Enter First Name",
									},
								},
							submitHandler: function(form) {
								form.submit();
							}
					});
				});

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
							   
							}
						});
					});
				});

				jQuery(document).on('click','#deletepayment',function(e){
					 var ids = jQuery(this).attr("ids");
					swal({
							title: "Are you sure?",
						  text: "Once deleted, you will not be able to recover this Order again!",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						  showLoaderOnConfirm: true
							})
							.then((willDelete) => {
							  if (willDelete) {
									$.ajax({
										url: "<?php echo site_url('orders/delete_payment')?>",
										data: { ids: ids },
										method: 'POST',
										error: function(data){  },
										success: function(res){
												if(res == "TRUE"){
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
	
				jQuery(document).on('change keyup blur','.totalPrice',function(){
					var disprice = jQuery('.discount').val();
					var taxprice = jQuery('.tax').val();
					var totalpriceattr = jQuery('.total').attr('dtotal');
					var afterdis = parseFloat(totalpriceattr) * parseFloat(disprice/100);
					var afterdistotal = parseFloat(totalpriceattr) - parseFloat(afterdis);
					if ( taxprice !='' && taxprice != '0' ) {
					var aftertax =  parseFloat(afterdistotal) * parseFloat(taxprice/100);
					var aftertaxtotal = parseFloat(afterdistotal) + parseFloat(aftertax);
					jQuery( '.total' ).val(aftertaxtotal); 
					}else{
					jQuery( '.total' ).val(afterdistotal); 
			
					}
			
				});
		</script>

<!-- emails  tab js script starts here -->
<?php if ( $currentMethod == 'email' ) { ?>
	<script>
		function initCustomBox(){
		$('[data-plugin="custommodalEdit"]').on('click', function(e) {
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
		var dataTable = jQuery('#emailTable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "<?php echo base_url('orders/get_emails'); ?>",
				"type": "POST",
				error:function(res){
				  
				}
			},
			"initComplete":function( settings, json){
				initCustomBox();
			}
		});
	});
	</script>
<?php } ?>
<?php if ( $currentMethod == 'product' ) { ?>

<script src="<?php echo base_url()?>assets/libs/select2/select2.min.js"></script>

	<script>
		jQuery(document).ready(function() {
			jQuery('.js-example-basic-single').select2({
			  placeholder: 'Select Item',
			  allowClear: true
			});
		});
	
		/*jQuery(document).on('change','#vendorName , #styleName , #category , #subCatogeryFirst , #subCatogerysecond',function(){
					var vID = jQuery('#vendorName').val();    
					var sID = jQuery('#styleName').val();    
					var catID = jQuery('#category').val();
					var subone = jQuery('#subCatogeryFirst').val();
					var subtwo = jQuery('#subCatogerysecond').val();
						jQuery.ajax({
							url:"<?php echo base_url('orders/get_product'); ?>",
							type:"post",
							data:{ vendor_id:vID,style_id:sID,cat_id:catID,subone:subone,subtwo:subtwo },
							error:function(res){  },
							success:function(res){ 
								console.log(res);
								var jsonData = JSON.parse(res);
								var list = "<option value = '0' >Select Item</option>";
								jQuery("#selectItem").html('');
								jQuery.each( jsonData, function( k,i ){
									list += "<option value = '"+ i.id +"' >" + i.Item_Name +"</option>";
								});
								jQuery('#selectItem').append(list);
							}
						});
		});*/
		
	    jQuery(document).on('change','#styleName_',function(){
    		var sID = jQuery('#styleName').val(); 
    		jQuery.ajax({
    			url:"<?php echo base_url('orders/get_product_cat'); ?>",
    			type:"post",
    			data:{ style_id:sID},
    			success:function(res){
    			    console.log(res);
				jQuery('#category').html(res);

    			}
    		});
        });
	
	function add_product(productId) {

		console.log( 'lkdjlasd' );
	    
	    let profitmarg = jQuery("#profit_multipler").val();
		let salemarg = jQuery("#sale_percentage").val();
		var assemble = jQuery("input[name='assemble_value']:checked").val();
			jQuery.ajax({
				url:"<?php echo base_url('orders/add_product') ?>",
				type: "post",
				data:{ productId: productId },
				error:function(res){  },
				success:function(res){
					if(res == 'error') return;
					jsonp = JSON.parse(res);
					
					/*let table_price = jsonp[0].Cabinet_price;
					let profit = table_price * parseFloat(profitmarg/100);
					let sale = table_price * parseFloat(salemarg/100);
					let proSale = parseFloat(table_price) + parseFloat( profit ) + parseFloat( sale );*/
					
					
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

                    ted_pricet  = parseFloat( ted_pricet ).toFixed(2);
                    cust_pricet = parseFloat( cust_pricet ).toFixed(2);
					
					listProduct  = "<tr id='pro_"+jsonp[0].pkpro_id+"' class='add_row"+ counttr +" del_prnt"+jsonp[0].pkpro_id+"'>";
					listProduct += "<td><input type='hidden' value='" + jsonp[0].Item_Code + "' class='pk_Item_Code' pr-id='" + jsonp[0].pkpro_id + "' name='product["+counttr+"][item_code]'>";

					listProduct += "<input type='hidden' value='" + jsonp[0].sid + "' class='pk_Item_Code' pr-id='" + jsonp[0].pkpro_id + "' name='product["+counttr+"][style_id]'>";
					

					listProduct += "<input type='number' class='form-control qty' style='width:70px;' value='1' name='product["+counttr+"][qty]'  data-id = '"+ counttr +"' id='qty"+counttr+"'></td>";

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
			var productId  = jQuery(this).val();
			console.log( productId );
			
			if( jQuery('#pro_'+productId).length ){
			    let prolen = jQuery('#pro_'+productId).length;
			    let qtyVal = jQuery( '#qty'+productId ).val();
			    let totalQty = parseFloat(qtyVal) + parseFloat(prolen);
			    jQuery( '#qty'+productId ).val( totalQty );
			}else{
			    add_product(productId);    
			}
			
// 			jQuery('#selectItem option[value="'+productId+'"]').attr('disabled', 'disabled');
//             $('#selectItem').select2();
		});
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
		
		/* assembaly price calcu */
		
		jQuery( document ).on('keyup','.assembprice',function(){
		    let valuebyinp = jQuery( this ).val();
		    let countbytr  = jQuery( this ).attr('count');
		    let databyasse = jQuery( this ).attr('data-price');
		    console.log( 'value=>'+valuebyinp+' count=>'+countbytr+' data-price=>'+databyasse );
		    
		    jQuery( '.assembprice'+countbytr ).html('');
		    
		    if( valuebyinp!='' ){
    		    let valres = parseFloat(databyasse) - parseFloat(valuebyinp);
    		    let finalval = valres.toFixed(2);
    		    jQuery( '.assembprice'+countbytr ).append(finalval );
		    }
		    
		});
		
	</script>
<?php } ?>

<!-- emails  tab js script ends here -->
	<script type="text/javascript">   
		jQuery(document).on("click",".add-more",function(){ 
			//var rowHtml = jQuery(".addMoreRow .appendRow").html();
			var rowHtml = jQuery(".addMoreRow tr").html();
			var countMain = jQuery('.after-add-more').length;
	
			/*var taskCount = countMain + 1;
			var taskno = rowHtml.replace(/\1/g, ''+taskCount);*/
			var nCount = parseInt(countMain)+1;
			var newHtml = rowHtml.replace(/\main0/g, 'main'+countMain);
			newHtml = newHtml.replace('<td>1</td>', '<td>'+ nCount +'</td>');
			AmountHtml = newHtml.replace('<td>1</td>', '<td>'+ nCount +'</td>');
			jQuery( '.appendExp' ).append( "<tr class='after-add-more'>"+ newHtml +"</tr>" );
		});
		jQuery(document).on("click",".delete_cat",function(){
			var rowHtml = jQuery(".addMoreRow tr").html();
			var countMain = jQuery('.after-add-more').length;
			if( countMain > 1 ){ 
				jQuery(this).parents(".after-add-more").remove();
			}
			var sum = 0;
			$("input[class *= 'expensesprice']").each(function(){
				sum += +jQuery(this).val();
			});
			jQuery(".total").val(sum);
		});
	
		jQuery( document ).on('change keyup blur','.expensesprice',function(){
			var sum = 0;
			$("input[class *= 'expensesprice']").each(function(){
				sum += +jQuery(this).val();
			});
			jQuery(".totalexp").val(sum);
			jQuery(".total").text(sum);
	
		});
	
		jQuery(document).on('click','.deleteorderimg',function(e){
			var ids = jQuery(this).attr("ids");
			var delData = jQuery(this).attr('data-img');
			
			swal({
				title: "Are you sure?",
			  text: "Once deleted, you will not be able to recover this File again!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			  showLoaderOnConfirm: true
				}).then((willDelete) => {
				  if (willDelete) {
						jQuery( '#img_'+delData ).fadeOut("slow");
						jQuery('#'+delData ).remove();
				  }
				});
		});
	
		jQuery( document ).ready(function(){
			var Sumtotal  = jQuery(".totalexp").val();
			if( Sumtotal == 0 || Sumtotal == 'undefined' ){
				jQuery( '.float-right.total-hidden' ).css("display","none");
			} else {
				jQuery( '.float-right.total-hidden' ).css("display","block");
			}
	
		});
		
		jQuery(document).on('click','#deleteexpenses',function(e){
		var ids = jQuery(this).attr("ids");
		var order_id = jQuery(this).attr("data-order");
		swal({
				title: "Are you sure?",
			  text: "Once deleted, you will not be able to recover this Expenses again!",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			  showLoaderOnConfirm: true
				})
				.then((willDelete) => {
				  if (willDelete) {
						$.ajax({
							url: "<?php echo site_url('orders/delete_expenses')?>",
							data: { ids: ids, order_id : order_id },
							method: 'POST',
							error: function(data){  },
							success: function(res){
									if(res == "TRUE"){
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
	</script>

	<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
	<script> // Global Functions
		document.addEventListener('custombox:overlay:complete', function() {
			$("#payee_date").flatpickr({ 
				dateFormat:'m-d-Y'
			});
		});
	
		jQuery(document).ready(function(){
			$("#estimated_delivery_date").flatpickr({ 
				dateFormat:'m-d-Y'
			});
			$("#scheduled_delivery_date").flatpickr({ 
				dateFormat:'m-d-Y'
			});
			$("#survey_date").flatpickr({ 
				dateFormat:'m-d-Y'
			});
			$("#requested_delivery_date").flatpickr({ 
				dateFormat:'m-d-Y'
			});
		});
	</script>

<!-- import data -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>  
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>  

	<script>
		jQuery( document ).on('click','#importcustpro', function(e){
		    e.preventDefault();
		    var id = jQuery( this ).attr('orderId');
			var st_id = jQuery('#styleName').val();
			var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xlsx|.xls)$/; 
			console.log( st_id );
			if( st_id != '0'  ){
				var fileName = $("#file_upload").val().toLowerCase();
			 	if ( fileName.indexOf('.xlsx') || fileName.indexOf('.xls') ) {  
					var xlsxflag = false;
					if ($("#file_upload").val().toLowerCase().indexOf(".xlsx") > 0) {  
						xlsxflag = true;  
					}


				/*if( st_id != '' ){*/
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

							//console.log( exceljson );
							jQuery.ajax({
                                    url:"<?= base_url('orders/check_product') ?>",
                                    type: "POST",
                                    data:{ skuvalue:exceljson,style_id:st_id,id:id},
                                    error:function(res){
                                        //console.log( res );
                                    },
                                    success:function(res){
                                        if( res != "" ){
                                           var exceldata = JSON.parse(res);
                                           //console.log( exceldata);
                                             
                                            	//console.log( exceldata );
                                                 BindTable(exceldata, '.table_append');
                                               
                                             
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
			}else{
				alert("Please select a style");   
			 } 
		});

		function BindTable(jsondata, tableid) { 
			var columns = BindTableHeader(jsondata, tableid); 
				if( jQuery('.table_append table tbody tr:not(.removetr)').length ){
					var counttr = jQuery('.table_append table tbody tr:not(.removetr)').length;
					counttr = GenRandom.Job();

				}else{
					var counttr = 0;    
				}

				var c_counttr = counttr + 1;

				var sc_counttr = c_counttr + 1;

				//console.log( jsondata ); 
			/*if( jQuery("#profit_multipler").val() != '' ){ var profitmarg = jQuery("#profit_multipler").val(); } else { var profitmarg = 0;  }
			if( jQuery("#sale_percentage").val() != '' ){ var salemarg = jQuery("#sale_percentage").val(); } else { var salemarg = 0;  }*/
				//console.log( profitmarg + " fkjdasf "+ salemarg );
			jQuery.each( jsondata, function( i,jsonp ) {
			    /*console.log( jsonp);*/
			    
    		/*let proprice       = jQuery( '#profit_multipler' ).find(":selected").val();
    		let mysale       = jQuery( '#sale_percentage' ).find(":selected").val();
    		
    		let t_price  = jsonp.price;
    		
    		let profit = t_price * parseFloat(proprice/100);
    		let sale = t_price * parseFloat(mysale/100);
    		let proSale = parseFloat(t_price) + parseFloat( profit ) + parseFloat( sale );
    		let cust_price = Math.ceil( proSale );*/

                    let si_val = jsonp.style_Item.split("/");

                    if( jsonp.not_exist == 'yes' ){
                    	var background = "style = 'background:#f2dede;'";
                    }else{
                    	var background = '';
                    }

	                    listProduct  = "<tr id='pro_"+jsonp.pkpro_id+"' " + background + "   class='add_row"+ counttr +"' data-cont = '"+counttr+"'>";
						
						listProduct   += "<td><input type='hidden' value='" + si_val[0] + "' class='pk_Item_Code' pr-id='" + jsonp.pkpro_id + "' name='product["+counttr+"][item_code]'>";
						
						listProduct   +=	"<input type='hidden' value='" + si_val[1] + "' class='pk_Item_Code' pr-id='" + jsonp.pkpro_id + "' name='product["+counttr+"][style_id]'>";

						listProduct   += "<input type='number' class='form-control qty' style='width:70px;' value='"+jsonp.Quantity+"' name='product["+counttr+"][qty]'  data-id = '"+ counttr +"' id='qty"+jsonp.pkpro_id+"'></td>";
						
						listProduct   += "<td><span>"+ jsonp.style_Item+"</span></td>";
						
						listProduct   += "<td style='width: 46%;'><p>"+jsonp.Description+"</p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+counttr+"][description]' value=''></div>";
						
						listProduct   += "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+counttr+"][descriptionII]' value=''></td></div>";
						
						
						listProduct += "<td class='bottomLine'><input class='form-control calcprice change_price' name='product["+counttr+"][u_price]' id='calcprice"+ jsonp.pkpro_id +"' value='' data-price='"+jsonp.pkpro_id+"' afappend-price=''><p></p>";

					    listProduct += "<input class='form-control calcprice assemb_price' name='product["+counttr+"][price]' id='calcprice"+jsonp.pkpro_id+"' value='' data-preal='"+jsonp.pkpro_id+"' asappend-price=''>";
					      
					    listProduct += "</td>";
					      
					    var pers = (jsonp.cabinaet_assemb_c-jsonp.item_cost)/jsonp.item_cost*100;
                        if( isNaN(pers) ) {
                        	pers = 0;
                        }

                        var item_cost_imp_p = parseFloat( jsonp.item_cost ).toFixed(2);
                       var cabinaet_assemb_imp_p =   parseFloat( jsonp.cabinaet_assemb_c ).toFixed(2);

					    listProduct += "<td class='bottomLine'><span class='align-center afterdeff' id='afterdeff"+jsonp.pkpro_id+"' dat_p='"+item_cost_imp_p+"'>"+item_cost_imp_p+"("+Math.ceil(pers)+"%)</span><span class='align-center salePrice' id='finalp"+jsonp.pkpro_id+"' dat_p='"+cabinaet_assemb_imp_p+"' >" + cabinaet_assemb_imp_p + "</span></td>";

						
						listProduct   += '<td><div class="icon_content"><div class="f_icon add_icon">';
	                    
	                    listProduct += '<i data-prid="'+ jsonp.pkpro_id +'" class="mdi mdi-plus-circle mr-1 add_field" data_btn="'+ counttr +'" parent_id="" item_code="'+jsonp.item_co+'" style_id="'+jsonp.sid+'"></i>';
	                    
	                    listProduct   += '<input type="hidden" value="'+ jsonp.pkpro_id +'" name="product['+counttr+'][product_id]"></div>';
	                    
	                    listProduct   += '<div class="f_icon delete_icon"><i data-prid="'+ jsonp.pkpro_id +'" class="mdi mdi-delete delete_Items"></i></div></div></td>';
	                    
	                    listProduct   += "</tr>";

	                   if(  jsonp.child !='' ){

	                   		jQuery.each( jsonp.child, function( i,jsonpchild ) {
   		
   		                    if( jsonpchild.not_exist == 'yes' ){
		                    	var child_back = "style = 'background:#eacbcb;'";
		                    }else{
		                    	var child_back = "style='background:#dff0d8;'";
		                    }
	                   		console.log( jsonpchild ); 
	                   		listProduct  += "<tr id='pro_"+jsonpchild.pkpro_id+"' "+child_back+" class='child_pro child_"+ counttr +"'>";
                        
                        listProduct   += "<td><input type='hidden' value='" + jsonpchild.item_co + "' class='pk_Item_Code' pr-id='" + jsonpchild.pkpro_id + "' name='product["+counttr+"][child_item]["+c_counttr+"][item_code]'>";
                        
                        listProduct   +=    "<input type='hidden' value='" + jsonpchild.sid + "' class='pk_Item_Code' pr-id='" + jsonpchild.pkpro_id + "' name='product["+counttr+"][child_item]["+c_counttr+"][style_id]'>";

                        listProduct   += "<input type='number' class='form-control qty' style='width:70px;' value='"+jsonpchild.Quantity+"' name='product["+counttr+"][child_item]["+c_counttr+"][qty]'  data-id = '"+ jsonpchild.pkpro_id +"' id='qty"+jsonpchild.pkpro_id+"'></td>";
                        
                        listProduct   += "<td><span>"+ jsonpchild.style_Item+"</span></td>";
                        
                        listProduct   += "<td style='width: 46%;'><p>"+jsonpchild.Description+"</p><div class='des_content'><div class='des_input des_first'><input type='text' class='form-control' name='product["+counttr+"][child_item]["+c_counttr+"][description]' value=''></div>";

                        listProduct   += "<div class='des_input des_sec'><input type='text' class='form-control' name='product["+counttr+"][child_item]["+c_counttr+"][descriptionII]' value=''></div></td>";
                        
                        listProduct += "<td class='bottomLine'><input class='form-control calcprice change_price' name='product["+counttr+"][child_item]["+c_counttr+"][u_price]' id='calcprice"+ jsonpchild.pkpro_id +"' value='' data-price='"+jsonpchild.pkpro_id+"' afappend-price=''><p></p>";

                        listProduct += "<input class='form-control calcprice assemb_price' name='product["+counttr+"][child_item]["+c_counttr+"][price]' id='calcprice"+c_counttr+"' value='' data-preal='"+jsonpchild.pkpro_id+"' asappend-price=''>";
                          
                        listProduct += "</td>";
                          
                        var pers = (jsonpchild.cabinaet_assemb_c-jsonpchild.item_cost)/jsonpchild.item_cost*100;
                        
                        if( isNaN(pers) ) {
                        	pers = 0;
                        }

                       var item_cost_imp = parseFloat( jsonpchild.item_cost ).toFixed(2);
                       var cabinaet_assemb_imp =   parseFloat( jsonpchild.cabinaet_assemb_c ).toFixed(2);

                        listProduct += "<td class='bottomLine'><span class='align-center afterdeff' id='afterdeff"+jsonpchild.pkpro_id+"' dat_p='"+item_cost_imp+"'>"+item_cost_imp+"("+Math.ceil(pers)+"%)</span><span class='align-center salePrice' id='finalp"+jsonpchild.pkpro_id+"' dat_p='"+cabinaet_assemb_imp+"' >" + cabinaet_assemb_imp + "</span></td>";
                        
                        listProduct   += '<td><div class="icon_content"><div class="f_icon add_icon">';
                        
                        listProduct   += '<input type="hidden" value="'+ jsonpchild.pkpro_id +'" name="product['+counttr+'][child_item]['+c_counttr+'][product_id]"><input type="hidden" value="'+ jsonp.pkpro_id +'" name="product['+counttr+'][child_item]['+c_counttr+'][pro_parent_id]"></div>';
                        
                        listProduct   += '<div class="f_icon delete_icon">';

                        listProduct += '<i data-prid="'+ jsonpchild.pkpro_id +'" class="mdi mdi-plus-circle mr-1 add_child_field" data_btn="'+ c_counttr +'" parent_id="" item_code="'+jsonpchild.item_co+'" data_prnt="'+counttr+'" style_id="'+jsonpchild.sid+'"></i>';

                        listProduct += '<i data-prid="'+ jsonpchild.pkpro_id +'" class="mdi mdi-delete delete_Items"></i></div></div></td>';
                        
                        listProduct   += "</tr>";
                        c_counttr++;
                    });


	                   }
					
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
 
 jQuery( document ).on('click','.extraTax',function(){
		let proprice       = jQuery( '#profit_multipler' ).find(":selected").val();
		let mysale       = jQuery( '#sale_percentage' ).find(":selected").val();
		
		let table_price  = jQuery( 'table tbody tr:last' ).find('.Productprice').val();
		
		let profit = table_price * parseFloat(proprice/100);
		let sale = table_price * parseFloat(mysale/100);
		let proSale = parseFloat(table_price) + parseFloat( profit ) + parseFloat( sale );
		let finalproSale = Math.ceil( proSale );
		jQuery( 'table tbody tr:last' ).find('.aftercharge').val(finalproSale);

		/*jQuery('.aftercharge').val( finalproSale );*/
		
 });
 
 
	 jQuery(document).on('change','.qty',function(){
		let qValue = jQuery(this).val();
		let qattr = jQuery(this).attr('data-id');
		let finalpA = jQuery('#finalp'+qattr).attr('dat_p');
		let afterdeffA = jQuery('#afterdeff'+qattr).attr('dat_p');
		let calcprice = jQuery('#calcprice'+qattr).val();
		let assemb_price = jQuery('#assemb_price'+qattr).val();

		if( calcprice ) {
			calcprice = calcprice;
		}else{
			calcprice = 0;
		}

		if( assemb_price ) {
			assemb_price = assemb_price;
		}else{
			assemb_price = 0;
		}

		let qafterdeff = (qValue * afterdeffA) + parseFloat(calcprice);
		let qfinalp =    (qValue * finalpA) + parseFloat(assemb_price);

		qafterdeff = qafterdeff.toFixed(2);
		qfinalp = 	qfinalp.toFixed(2);


		var newMorkup = ( qfinalp - qafterdeff)/qafterdeff*100;

		jQuery('#afterdeff'+qattr).html(qafterdeff+'('+newMorkup.toFixed(2)+'%)');
		jQuery('#afterdeff'+qattr).attr('qtyP',qafterdeff);
		jQuery('#finalp'+qattr).html(qfinalp);

		 all_t_price();
	});   


</script>

<script>
	
	jQuery(document).on('click','.deleteIMG',function(e){
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
						
						jQuery(this).parent('span').parent('li').remove();
				  }
				});
		});

</script>


<script>
	jQuery(document).on('click','#restoreOrder',function(e){
		var ids = jQuery(this).attr("ids");
		var order_id = jQuery(this).attr("data-order");
		swal({
			title: "Are you sure?",
			text: "You want to restore, Any changes after it will be lost!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			showLoaderOnConfirm: true
			})
		.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: "<?php echo site_url('orders/restore_order')?>",
						data: { ids: ids },
						method: 'POST',
						error: function(data){ console.log(data); },
						success: function(res){
							if(res == "TRUE"){
							swal("Restored!", "You clicked the button!", "success").then(function(){ 
									   var url = <?php echo "'".base_url()."'"; ?>+"orders/dashboard/"+order_id;
									   window.location.replace(url);
									   }
									);
						   
							} else {
							swal('Oops...', 'Something went wrong with ajax !', 'error');
							}
							
						},
					})
				}
		});
	});
</script>

<!-- Add more field in product -->



<script>
    
     jQuery(document).on('change','#category_',function(){
                var catId = jQuery(this).val(); 
                //var catId = jQuery(this).attr('cat_data');
        	    jQuery.ajax({
        	        url:'<?php echo base_url('orders/appendcat'); ?>',
        	        type:'POST',
        	        data:{ catId:catId},
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

            jQuery(document).on('change','#subCatogeryFirst_',function(){
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
            })
   
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

    jQuery( document ).on('click','#pk_change_product',function(){

    	var style_id = $("select[name^=filterStyle]").val();
    	var Item_Code = [];
    	var product_Id = [];
    	$("input[name^=pk_Item_Code]").each(function() {
			
    		  Item_Code.push( $(this).val() );
    		  product_Id.push( $(this).attr('pr-id') );

		});

		let profitmarg = jQuery("#profit_multipler").val();
		let salemarg = jQuery("#sale_percentage").val();
		jQuery.ajax({
			url:"<?php echo base_url('orders/re_add_product') ?>",
			type: "post",
			data:{ Item_Code: Item_Code , product_Id: product_Id, style_id: style_id },
			error:function(res){  },
			success:function(res){
				//console.log(res);
				jsonpr = JSON.parse(res);
				if( jsonpr.status == 'success' ){
					jQuery('.table_append table tbody').html('');	
					$.each(jsonpr.pros, function () {
						add_product(this);
					});
					$(".pk-error").remove();
					Custombox.modal.close();
				}else if( jsonpr.status == 'error' ) {
					$(".pk-error").remove();

					if (jsonpr.items.length == 1){
						$.each(jsonpr.items, function () {
							$( ".table_append" ).prepend( "<div class='pk-error'><span style='color:red;'><em>" + this + " item doesnt have the selected style!</em></span></div>" );
						});
					}else{
						var item = ' ';
						$.each(jsonpr.items, function () {
							 item += this + ', ';
						});
						item = item.slice(0,-2);
						$( ".table_append" ).prepend( "<div class='pk-error'><span style='color:red;'><em>" + item + " items doesnt have the selected style!</em></span></div>" );
					}

					Custombox.modal.close();
				}

			},
			
		});
    });
    
    jQuery( document ).on('change','#vendorName',function(){

    	var v_id = jQuery(this).val();
    	var o_id = jQuery('option:selected', this).attr('o_id');
		
		if ( v_id == 1 ) {
			jQuery.ajax({
				url:"<?php echo base_url('orders/styleByVendor') ?>",
				type: "post",
				data:{ v_id: v_id },
				success:function(res){
				    jQuery('#styleName').html(res);
				},
			});
		}else if( v_id == 2 ){
			var msi_url = "<?php echo base_url(); ?>orders/FabOrders/edit/"+o_id;
		}else if ( v_id == 3 ) {
			var msi_url = "<?php echo base_url(); ?>orders/jkOrders/edit/"+o_id;
		}else if ( v_id == 4 ) {
			var msi_url = "<?php echo base_url(); ?>orders/cncOrders/edit/"+o_id;
		}else if ( v_id == 5 ) {
			var msi_url = "<?php echo base_url(); ?>orders/wcOrders/edit/"+o_id;
		}else if ( v_id == 6 ) {
			var msi_url = "<?php echo base_url(); ?>orders/tknobsOrders/edit/"+o_id;
		}else if ( v_id == 7 ) {
			var msi_url = "<?php echo base_url(); ?>orders/msiTileOrders/edit/"+o_id;
		}else{
			var msi_url = "<?php echo base_url(); ?>orders/TsgOrders/edit/"+o_id;
		}
		window.location.href = msi_url;
    });
    
    jQuery(document).on('change','#category',function(){
                var catId = jQuery(this).val(); 
        	    jQuery.ajax({
        	        url:'<?php echo base_url('orders/get_pro_by_cat'); ?>',
        	        type:'POST',
        	        data:{ catId:catId},
        	        success:function(res){
        	            console.log( res );
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
	            console.log(res);
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
   		var cat_id = jQuery(this).attr('data-catid');
        var s_name = jQuery('#styleName').val();
        jQuery('.childCats .catHolder').html( jQuery(this).html() );
        jQuery('.childCats .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
		child_product(cat_id,s_name);        
    });

    jQuery(document).on('click','.catHolder',function(){
   		var cat_id = jQuery(this).attr('cat-id');
   		console.log( cat_id );
        var s_name = jQuery('#styleName').val();
        jQuery('.resList ul').hide();
		child_product(cat_id,s_name);        
    });

    function child_product(cat_id,s_name){
    	jQuery.ajax({
			url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_first'},
			success:function(res){

			    var resp = jQuery.parseJSON(res);
			    if(resp.status == 'notfinal'){
			    	console.log( 'bbbb' );
    			    jQuery('.resList ul#subChild').html(resp.res);
    			    jQuery('.resList ul#subChild').show();
			    }else{
			    	console.log( 'aaaaa' );
    			    jQuery('.resList ul#proRes').html(resp.res);
    			    jQuery('.resList ul#proRes').show();
			    }
			}
		});
    }
    
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
			    console.log(resp);
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
        console.log( cat_id + 'hjgashjdas' );
        let s_name = jQuery('#styleName').val();
        jQuery.ajax({
			url:"<?php echo base_url('orders/cat_by_cat_product'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, cat_type : 'sub_category_first'},
			success:function(res){
				console.log( res );
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
    	console.log(jQuery('#pro_'+productId).length);
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
    			    console.log(res);
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

    </script>

    <script>
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
		let rowAppendpro = "<tr class='child_pro child_"+parent_class+" del_prnt"+pr_id+"' style='background:#dff0d8' id='pro_"+countrowpro+"'>";
			
			rowAppendpro+= "<td><input type='number' class='form-control qty' style='width:70px;' min = '1' value='1' name='product["+data_btn+"][child_item]["+countrowpro+"][qty]'  data-id = '"+countrowpro+"'></td>";
			
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
		let data_prnt 	= jQuery( this ).attr('data_prnt');
		let del_prnt 	= jQuery( this ).attr('del_prnt');
		
		
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
					console.log( res );
					console.log( '#style_item'+countIncrease );
					jQuery('#style_item'+countIncrease).html(res);

				}
		});

		let rowAppendpro = "<tr class='child_pro child_"+parent_class+" del_prnt ='"+del_prnt+"'' style='background:#b9d0af' id='pro_"+countIncrease+"'>";
			
			rowAppendpro+= "<td><input type='number' class='form-control qty' style='width:70px;' min = '1' value='1' name='product["+data_prnt+"][child_item]["+data_btn+"][sub_child]["+countIncrease+"][qty]'  data-id = '"+countIncrease+"'></td>";
			
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
				console.log( j.Width );

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

	/*jQuery( document ).on('keyup','.calcprice',function(){
		let calcprice = parseFloat( jQuery(this).val() );
		let dat       = jQuery(this).attr('data-price');

		let costPrice  = parseFloat( jQuery('#afterdeff'+dat).attr('dat_p') );
		let salePrice  = parseFloat( jQuery('#finalp'+dat).attr('dat_p') );

		// console.log(finalp);
		if( !isNaN(calcprice) ){
			if (calcprice > 0) {
				var total_costPrice = costPrice + calcprice;
				var total_salePrice = salePrice + calcprice;
				
			}else{
				calcprice = Math.abs(calcprice);
				var total_costPrice = costPrice - calcprice;
				var total_salePrice = salePrice - calcprice;
			}
		}else{
			var total_costPrice = costPrice;
			var total_salePrice = salePrice;
		}


		var pers = (total_salePrice-total_costPrice)/total_costPrice*100;
		jQuery( '#afterdeff' + dat ).html(total_costPrice+'('+Math.ceil(pers)+'%)');					
		jQuery( '#finalp' + dat ).html(total_salePrice);

	});*/

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

jQuery( document ).on('click','.assemble_val',function(){
	var assemble_value = jQuery( this ).val();
	var order_id = jQuery( this ).attr('order_id');

	console.log( assemble_value );
	jQuery.ajax({
		url: '<?= base_url('orders/assemble_update'); ?>',
		method:'post',
		data: { assemble_value:assemble_value,order_id:order_id },
		error:function(res){
				console.log(res);
		},
		success:function(res){
				console.log(res);
				location.reload();
		}
	});
});
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


	// function calculatePricePerc(objval){
	// 		var sum = jQuery('.subTotal span.SP').text();
 //        	var perc = objval;
	//         var perc_amount = (perc/100) * sum;
	//         var NetPrice = sum - perc_amount;
	//         jQuery('.perc_amount').val(perc_amount.toFixed(2));
	        
	//         var taxx = jQuery('.taxx').text();
	//         var txAmt = (NetPrice/100) * taxx;
	//         var totalP = parseInt(txAmt)+NetPrice;
	//         jQuery('.net_price').val(totalP.toFixed(2));
	// 	}

	// 	function calculatePercAmount(objval){
	// 		var sum = jQuery('.subTotal span.SP').text();
	//     	var perc_amount = objval;
	//         var NetPrice = sum - perc_amount;
	//         var perc = perc_amount * (100/sum);
	    
	//         jQuery('.price_perc').val(perc.toFixed(2));
	      
	//         var taxx = jQuery('.taxx').text();
	//         var txAmt = (NetPrice/100) * taxx;
	//         var totalP = parseInt(txAmt)+NetPrice;
	//         console.log( totalP );
	//         jQuery('.net_price').val(totalP.toFixed(2));
	// 	}

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
		console.log( morkpamt  );
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
		console.log( p_morkpamt + 'p_morkpamt' );
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

	$('#searchPro').keypress(function(event) {
	    if (event.keyCode == 13) event.preventDefault();
	});


	jQuery('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        jQuery(this).siblings('.custom-file-label').html(fileName);
    });



</script>
<!-- custom array -->
<?php 
$user_role = $this->session->userdata('user_role');
if ( ($edit_order['status'] == 'Order' || $edit_order['is_locked']) && $user_role != '1') { ?>
	<script>jQuery('.container-fluid').append("<div id='overlay_locked'></div>");</script>
<?php } ?>