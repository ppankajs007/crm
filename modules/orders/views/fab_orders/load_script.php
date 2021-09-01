
<?php 
$currentMethod = $this->router->fetch_method();
$globalMethods = array('index','edit', 'add', 'emails','product','quote_orders');
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

<?php if ( $currentMethod == 'product' || $currentMethod == 'edit') { ?>
<script>

	var isCtrl = false;
	jQuery(document).keyup(function (e) {
	    if(e.which == 17) isCtrl=false;
	}).keydown(function (e) {
	    if(e.which == 17) isCtrl=true;
	    if(e.which == 89 && isCtrl == true) {
	    	jQuery('.editProTable').addClass('showCost');
	    	// jQuery('.subTotArea').addClass('showCost');
			var is_pickup  	   = isPickup();
	    	jQuery( '.cost_price' ).css('display','block');
	    	jQuery( '.hidesub' ).css('visibility','visible');
	    	if (is_pickup == 'no') {
		    	jQuery( '.delivery_cost' ).removeClass('dspln');
	    	}
	    	jQuery( '.subTotalCost' ).removeClass('dspln');
	    	jQuery( '.after_delivery_cost' ).removeClass('dspln');
	    	jQuery( '.subtotal_total' ).removeClass('dspln');
	        return false;
	    }
	});

	function add_product(productId) {
	    var style  = jQuery( "#styleName option:selected" ).val();
	    var cat_id = jQuery( ".catHolder" ).attr('cat-id');
	    
		jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/productByCategory') ?>",
			type: "post",
			data:{ productId: productId,style:style,cat_id:cat_id},
			success:function(res){
				jQuery('.table_append > table > tbody').prepend(res);
				var thisObj = jQuery('.table_append > table > tbody tr:first-child');
				thisObj.find('.slabOne').trigger('keyup');
			  	setTimeout(function(){ calcuateAllProductPrice(); }, 100);
				jQuery('.removetr').remove();
			},
		});
	
	}

</script>
<?php } ?>
<script>    
    jQuery( document ).on('change','#vendorName',function(){

    	var v_id = jQuery(this).val();
    	var o_id = jQuery('option:selected', this).attr('o_id');
		
		if ( v_id == 2 ) {
			jQuery.ajax({
				url:"<?php echo base_url('orders/fabOrders/styleByVendor') ?>",
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
		}else if ( v_id == 8 ) {
			var msi_url = "<?php echo base_url(); ?>orders/AsfgOrders/edit/"+o_id;
		}else if ( v_id == 9 ) {
			var msi_url = "<?php echo base_url(); ?>orders/centuryOrders/edit/"+o_id;
			window.location.href = msi_url;
		}else{
			var msi_url = "<?php echo base_url(); ?>orders/TsgOrders/edit/"+o_id;
		}
		window.location.href = msi_url;
    });
    
    jQuery(document).on('click','.catDrop',function(){
    	var sID = jQuery('#styleName').val();
		jQuery('.resList ul').html('');
		jQuery('.catHolder').html('');
		jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByStyle'); ?>",
			type:"post",
			data:{ style_id:sID},
			success:function(res){
			    jQuery('.resList ul').hide();
			    jQuery('#mainCats').html(res);
        		jQuery('.resList ul#mainCats').show();
			}
		});
    });
        
    jQuery(document).on('click','#mainCats li',function(){
        let cat_id = jQuery(this).attr('data-catid');
        let s_name = jQuery('#styleName').val();        
        jQuery('.catHolder').html('');
        jQuery('.mainCats .catHolder').html( jQuery(this).html() );
        jQuery('.mainCats .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, cat_type : 'category'},
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
        var main_cat = jQuery('.mainCats .catHolder').attr('cat-id');
        jQuery('.resList ul').hide();

    	jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, cat_type : 'sub_1_category'},
			success:function(res){

			    var resp = jQuery.parseJSON(res);
			    if(resp.status == 'notfinal'){
    			    jQuery('.resList ul#subChild').html(resp.res);
    			    jQuery('.resList ul#subChild').show();
			    }else{
			    	console.log( 'aaaaa' );
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

        var main_cat  = jQuery('.mainCats .catHolder').attr('cat-id');
	    var child_cat = jQuery('.childCats .catHolder').attr('cat-id');

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, child_cat : child_cat, cat_type : 'sub_2_category'},
			success:function(res){
			    var resp = jQuery.parseJSON(res);
			    if(resp.status == 'notfinal'){
    			    jQuery('.resList ul#subSubChild').html(resp.res);
    			    jQuery('.resList ul#subSubChild').show();
			    }else{
			    	console.log( 'aaaaa' );
    			    jQuery('.resList ul#proRes').html(resp.res);
    			    jQuery('.resList ul#proRes').show();
			    }
			}
		});
    });
    
    jQuery(document).on('click','#subSubChild li',function(){
        let cat_id = jQuery(this).attr('data-catid');
        let s_name = jQuery('#styleName').val();
        jQuery('.subSubChild .catHolder').html( jQuery(this).html() );
        jQuery('.subSubChild .catHolder').attr( 'cat-id',cat_id);
        jQuery('.resList ul').hide();
    
        var main_cat  = jQuery('.mainCats .catHolder').attr('cat-id');
	    var child_cat = jQuery('.childCats .catHolder').attr('cat-id');
	    var sub_cat   = jQuery('.subChild .catHolder').attr('cat-id');

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, child_cat : child_cat, cat_type : 'sub_category_third'},
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
        jQuery('.subSubChild .catHolder').html('');
        let cat_id   = jQuery(this).attr('cat-id');
        console.log( cat_id + 'hjgashjdas' );
        let s_name = jQuery('#styleName').val();

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, cat_type : 'category'},
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

        var main_cat  = jQuery('.mainCats .catHolder').attr('cat-id');
	    var child_cat = jQuery('.childCats .catHolder').attr('cat-id');

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, child_cat : child_cat, cat_type : 'sub_1_category'},
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

        var main_cat  = jQuery('.mainCats .catHolder').attr('cat-id');
	    var child_cat = jQuery('.childCats .catHolder').attr('cat-id');
	    var sub_cat   = jQuery('.subChild .catHolder').attr('cat-id');

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, child_cat : child_cat, sub_cat : sub_cat, cat_type : 'sub_2_category'},
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
    
    jQuery(document).on('click','.subSubChild .catHolder',function(){
        jQuery('.resList ul').hide();
        let cat_id   = jQuery(this).attr('cat-id');
        let s_name = jQuery('#styleName').val();

        var main_cat    = jQuery('.mainCats .catHolder').attr('cat-id');
	    var child_cat   = jQuery('.childCats .catHolder').attr('cat-id');
	    var sub_cat     = jQuery('.subChild .catHolder').attr('cat-id');
	    var sub_sub_cat = jQuery('.subSubChild .catHolder').attr('cat-id');

        jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/categoryByProduct'); ?>",
			type:"post",
			data:{ cat_id : cat_id, s_name:s_name, main_cat : main_cat, child_cat : child_cat, sub_cat : sub_cat, sub_sub_cat : sub_sub_cat, cat_type : 'sub_2_category'},
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
    		var uniquePro = jQuery('#pro_'+productId).find('.qty').attr('data-slabInput');
    	    var qtyVal = jQuery( '#qty'+uniquePro ).val();
    	    var totalQty = parseFloat(qtyVal) + 1;
    	    jQuery( '#qty'+uniquePro ).val( totalQty );
		  	jQuery( 'body' ).append( "<div class='loaderOverlay'><div class='inner'><img src='https://cdn-camp.mini-sites.net/Publish/53c7f5697dd94d829fcb41e20510e344/9acad7d360bd4f9a8b85ff13b1c61aac/src/images/loader01.gif' /></div></div>" );
		  	setTimeout(function(){ sendAllSlabValue(uniquePro); }, 100);
    	}else{
    	    add_product(productId);
    	}
    });

    jQuery(document).on('keyup input', '#searchPro', function (e) {
        var styleName  = jQuery('#styleName').val();
        var vendorName = jQuery('#vendorName').val();
        var srch = jQuery(this).val();
        
        if (styleName != '' && styleName != '0' ) {

	        if( srch.length > 1 ){
	            jQuery('.resList ul').hide(); 
			    jQuery('.resList ul#proRes').show();
	            jQuery.ajax({
	    			url:"<?php echo base_url('orders/fabOrders/productFilter'); ?>",
	    			type:"post",
	    			data:{ search:srch, vendor_id:vendorName, style_id:styleName},
	    			success:function(res){
	    			    console.log(res);
	    			    var resp = jQuery.parseJSON(res);
	    			    jQuery('.resList ul#proRes').html(resp.res);
	    			}
	    		});
	        }
    	}else{
			alert('Please select a style');    		
    	}
	});

    jQuery(document).on('change','#styleName',function(){
    		var sID = jQuery('#styleName').val();
    		jQuery('.resList ul').html('');
    		jQuery('.catHolder').html('');
    		jQuery.ajax({
    			url:"<?php echo base_url('orders/fabOrders/categoryByStyle'); ?>",
    			type:"post",
    			data:{ style_id:sID},
    			success:function(res){
    			    jQuery('.resList ul').hide();
				    jQuery('#mainCats').html(res);
				    jQuery('.catDrop').trigger('click');
    			}
    		});
        });

    /*  */

    jQuery(document).on('keyup','.slabOne',function(){
		var slabinput = jQuery(this).attr('data-slabInput'); 
		sendAllSlabValue(slabinput);
	});

    jQuery(document).on('keyup','.slabTwo',function(){ 
    	var slabinput = jQuery(this).attr('data-slabInput'); 
		sendAllSlabValue(slabinput);
	});

    jQuery(document).on('keyup','.slabThree',function(){ 
    	var slabinput = jQuery(this).attr('data-slabInput'); 
		sendAllSlabValue(slabinput); 
	});

    jQuery(document).on('keyup change','.qty',function(){ 
    	var slabinput = jQuery(this).attr('data-slabInput'); 
		sendAllSlabValue(slabinput);
 	});

	jQuery( document ).on('keyup','.change_cost',function(){
		var uniquePro = jQuery(this).attr('data-slabInput');
		sendAllSlabValue(uniquePro);
	});

	jQuery( document ).on('keyup','.change_price',function(){
		var uniquePro = jQuery(this).attr('data-slabInput');
		sendAllSlabValue(uniquePro);
	});

	function sendAllSlabValue(slabinput){
		var slabinput  = slabinput;
		var slabVOne   = jQuery('#slabOne'+slabinput).val();
		var slabVTwo   = jQuery('#slabTwo'+slabinput).val();
		var slabVThree = jQuery('#slabThree'+slabinput).val();
		var slabQty	   = jQuery('#qty'+slabinput).val();
		var proId      = jQuery('#proId'+slabinput).val();

    	var change_cost    = jQuery('#change_cost'+slabinput).val();
		var change_price   = jQuery('#change_price'+slabinput).val();

	  /*var styleId    = jQuery( "#styleName option:selected" ).val();*/
		var styleId    = jQuery( "#fabStyle" + slabinput ).val();

		jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/calcuateSlabPrice'); ?>",
			type:"post",
			data:{ proId:proId,slabVOne:slabVOne,slabVTwo:slabVTwo,slabVThree:slabVThree,slabQty:slabQty,styleId:styleId, change_cost:change_cost, change_price:change_price },
			success:function(res){
				var calPrice = jQuery.parseJSON(res);
				console.log( calPrice.console );
				jQuery('#cost_price'+slabinput).attr('data-itemCost',calPrice.cost_price);
				jQuery('#cost_price'+slabinput).html('<span class="morkpamt">$'+calPrice.cost_price+'</span> (<span class="morkpperc">'+calPrice.percent+'</span>%)');
				jQuery('#sale_price'+slabinput).attr('data-itemPrice',calPrice.sale_price);
				jQuery('#sale_price'+slabinput).html('$'+calPrice.sale_price);
				jQuery('#sale_price_input'+slabinput).val(calPrice.sale_price);
				jQuery('#final_cost_input'+slabinput).val(calPrice.cost_price);

				calcuateAllProductPrice();
			}
		});
    }

    /* -------------------------- start subtotal area -------------------------- */

	jQuery( document ).on('click','#clearPro',function(){
		var r = confirm("Are you sure? This action can't be undone.");
		if (r == true) {
		    var orderID  = jQuery('#orderID').val();
			jQuery('.editProTable tbody tr ').remove();
		    var formData = new FormData( jQuery('#productData')[0] );
		    jQuery('#save_').click();
		}
	});
    
    calcuateAllProductPrice();
    function calcuateAllProductPrice( updateDiscountAmt = true ){
		
    	var total_sale_price = 0;
		console.log('%c <<<<<<<<<<<< Price Items >>>>>>>>>>', 'background: #0D0208; font-weight:bold; color: #00FF41; font-size:16px');
		jQuery(".sale_price_input").each(function(){
    		total_sale_price += parseFloat( jQuery(this).val() );
			console.log('%c'+ parseFloat( jQuery(this).val() ), 'color: #000');
    	});

		var total_cost_price = 0;
		console.log('%c <<<<<<<<<<<< Cost Items >>>>>>>>>>', 'background: #0D0208; font-weight:bold; color: #00FF41; font-size:16px');
		jQuery(".final_cost_input").each(function(){
    		total_cost_price += parseFloat( jQuery(this).val() );
			console.log('%c'+ parseFloat( jQuery(this).val() ), 'color: red');
    	});

		console.log('%cSale Price - ' + total_sale_price, 'font-size: 18px; color: Green');
		console.log('%cSale Cost - '+total_cost_price, 'font-size: 18px; color: Red');

		var delivery_price = jQuery('.delivery_price_inp').val();
		var delivery_cost  = jQuery('.delivery_cost_inp').val();
		var is_pickup  	   = isPickup();
    	
    	var resale = taxCostActive();
 
		var price_perc   = jQuery( '.price_perc' ).val();
		var perc_amount  = jQuery( '.perc_amount' ).val();
		var paid_amount  = jQuery( '#paidAmount' ).val();

 		jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/calcuateAllProductPrice'); ?>",
			type:"post",
			data:{ 
				total_price:total_sale_price, 
				total_cost:total_cost_price,
				resale:resale,
				price_perc  :price_perc,
				perc_amount :perc_amount,
				deliveryp : delivery_price,
				deliveryc : delivery_cost,
				is_pickup : is_pickup,
				paid_amount: paid_amount, 
			},
			success:function(res){
				jQuery( '.subTotArea' ).css('visibility','visible');
				var finalCalc = jQuery.parseJSON(res);
				console.table(finalCalc);
				jQuery( '.subtotal' ).val(finalCalc.subtotal);
				jQuery( '.SP').html("$"+finalCalc.subtotal);

				if(updateDiscountAmt) jQuery( '.perc_amount' ).val(finalCalc.perAmt);

				jQuery('.subCostInnter').html('$'+finalCalc.subcost+' ('+finalCalc.subcostPerc+'%)');
				jQuery( '.cost_t_price' ).val(finalCalc.subcost);

				jQuery('#afterDeliveryPrice').val(finalCalc.afterDeliveryPrice);
				jQuery('.afterDeliveryPrice').text('$'+finalCalc.afterDeliveryPrice);

				jQuery('#afterDeliveryCost').val(finalCalc.afterDeliveryCost);
				jQuery('.afterDeliveryCost').html("$"+finalCalc.afterDeliveryCost);

				jQuery('.delivery_cost .dcperc').text("("+finalCalc.afterDeliveryPerc+"%)");

				jQuery('#afterDiscountPrice').val(finalCalc.afterDiscPrice);
				jQuery('.afterDiscountPrice').html("$"+finalCalc.afterDiscPrice);
				
				jQuery('#afterDiscountCost').val(finalCalc.nCostAmt);
				jQuery('.afterDiscountCost').html("$"+finalCalc.nCostAmt+ "("+finalCalc.nCostPrc+"%)");

				jQuery('.taxx').text(finalCalc.taxRate);
				jQuery('.txamt').text(finalCalc.taxValue);
				jQuery('.tax_hidden_val').val(finalCalc.taxValue);
				
				jQuery( '.net_price' ).val(finalCalc.netprice);

				jQuery( '.paidAmountPercent' ).html('('+finalCalc.paidAmountPrc+'%)');

				jQuery( '.totalAmountDue' ).html('$'+finalCalc.totalDue);
				jQuery( '.totalAmountValue' ).val(finalCalc.totalDue);
			}
		});
		
	}

	function isPickup(){
		return jQuery( '[name=is_pickup]:checked' ).val();
	}

	jQuery(document).on('keyup','.delivery_price_inp', function(){
		var deliveryPri  = jQuery( this ).val();
		var deliveryCost = jQuery('.delivery_cost_inp').val();
		var subtotal 	 = jQuery('.subtotal' ).val();
		jQuery.ajax({
			url: '<?php echo base_url('orders/fabOrders/customSum'); ?>',
			type: 'post',
			data:{ deliveryp : deliveryPri, deliveryc : deliveryCost, curprice : subtotal, ptype : 'price'},
			success:function(res){
				var obj = jQuery.parseJSON(res);
				jQuery('#afterDeliveryPrice').val(obj.final_val);
				jQuery('.afterDeliveryPrice').text('$'+obj.final_val);
				jQuery('.delivery_cost .dcperc').text("("+obj.perc+"%)");
				calcuateAllProductPrice();
			}
		});
	});

	jQuery(document).on('keyup','.delivery_cost_inp', function(){
		var deliveryPri  = jQuery('.delivery_price_inp').val();
		var deliveryCost = jQuery( this ).val();
		var cost_t_price = jQuery( '.cost_t_price' ).val();
		jQuery.ajax({
			url: '<?php echo base_url('orders/fabOrders/customSum'); ?>',
			type: 'post',
			data:{ deliveryp : deliveryPri, deliveryc : deliveryCost, curprice : cost_t_price, ptype : 'cost' },
			success:function(res){
				var obj = jQuery.parseJSON(res);
				jQuery('#afterDeliveryCost').val(obj.final_val);
				jQuery('.afterDeliveryCost').html("$"+obj.final_val);
				jQuery('.delivery_cost .dcperc').text("("+obj.perc+"%)");
				calcuateAllProductPrice();
			}
		});
	});

	
jQuery( document ).on('keyup','.perc_amount',function(){
    	var total_sale_price = 0;
		jQuery(".sale_price_input").each(function(){
        		total_sale_price += parseFloat( jQuery(this).val() );
    	});

		var total_cost_price = 0;
		jQuery(".final_cost_input").each(function(){
        		total_cost_price += parseFloat( jQuery(this).val() );
    	});

		var delivery_price = jQuery('.delivery_price_inp').val();
		var delivery_cost  = jQuery('.delivery_cost_inp').val();
		var is_pickup  	   = isPickup();


		var disc_amt = jQuery(this).val();

		var resale = taxCostActive();

    	jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/calcuateAllProductByAmt'); ?>",
			type:"post",
			data:{ 
				total_price : total_sale_price, 
				disc_amt    : disc_amt, 
				total_cost : total_cost_price,
				resale     : resale,
				deliveryp  : delivery_price,
				deliveryc  : delivery_cost,
				is_pickup  : is_pickup,
			},
			success:function(res){
				var finalCalc = jQuery.parseJSON(res);
				// jQuery('.hidesub').html('<span class="morkpamt">$'+finalCalc.nCostAmt+'</span> (<span class="morkpperc">'+finalCalc.nCostPrc+'</span>%)');
				jQuery('.subCostInnter').html('$'+finalCalc.nCostAmt+' ('+finalCalc.nCostPrc+'%)');
				jQuery('.price_perc' ).val(finalCalc.perCent);
				jQuery('.txamt').text(finalCalc.taxAmt);
				jQuery('.tax_hidden_val').val(finalCalc.taxAmt);
				jQuery('.net_price' ).val(finalCalc.netprice);
			
				calcuateAllProductPrice(false);
			
			}
		});
	});

	jQuery( document ).on('keyup','.price_perc',function(){
		var total_cost_price = 0;
		jQuery(".final_cost_input").each(function(){
        		total_cost_price += parseFloat( jQuery(this).val() );
    	});

    	var total_sale_price = 0;
		jQuery(".sale_price_input").each(function(){
        		total_sale_price += parseFloat( jQuery(this).val() );
    	});

		var delivery_price = jQuery('.delivery_price_inp').val();
		var delivery_cost  = jQuery('.delivery_cost_inp').val();
		var is_pickup  	   = isPickup();

		var perc = jQuery(this).val();
    	var resale = taxCostActive();

    	jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/calcuateAllProductByPerc'); ?>",
			type:"post",
			data:{ 
				total_price:total_sale_price, 
				perc:perc, 
				total_cost:total_cost_price, 
				resale:resale,
				deliveryp : delivery_price,
				deliveryc : delivery_cost,
				is_pickup : is_pickup,
			},
			success:function(res){
				var finalCalc = jQuery.parseJSON(res);
				// jQuery('.hidesub').html('<span class="morkpamt">$'+finalCalc.nCostAmt+'</span> (<span class="morkpperc">'+finalCalc.nCostPrc+'</span>%)');
				jQuery('.subCostInnter').html('$'+finalCalc.nCostAmt+' ('+finalCalc.nCostPrc+'%)');
				jQuery('.txamt').text(finalCalc.taxAmt);
				jQuery('.tax_hidden_val').val(finalCalc.taxAmt);

				jQuery( '.perc_amount' ).val(finalCalc.perAmt);
				jQuery( '.net_price' ).val(finalCalc.netprice);
				calcuateAllProductPrice();
			}
		});
	});

	function calcuateTax(resale){
		var subtotal = jQuery( '.subtotal' ).val();
		var perc_amount = jQuery( '.perc_amount' ).val();
		jQuery.ajax({
			url: '<?php echo base_url('orders/fabOrders/calcuateTax'); ?>',
			type: 'post',
			data:{ subtotal,perc_amount,resale },
			success:function(res){
				var calPrice = jQuery.parseJSON(res);
				jQuery('.taxx').text(calPrice.taxOrder);
				jQuery('.net_price').val(calPrice.netprice);
				jQuery('.txamt').text(calPrice.taxValue);
				jQuery('.tax_hidden_val').val(calPrice.taxValue);
			}
		});
	}

	jQuery( document ).on('keyup','.net_price',function(){

		var delTotalP  = jQuery('#afterDeliveryPrice').val();
		var delTotalC  = jQuery('#afterDeliveryCost').val();
		var resale 	   = taxCostActive();
		var net_price  = jQuery(this).val();
		var paid_amount  = jQuery( '#paidAmount' ).val();

    	jQuery.ajax({
			url:"<?php echo base_url('orders/fabOrders/calcuateAllProductByNetPrice'); ?>",
			type:"post",
			data:{ total_price:delTotalP, net_price:net_price, total_cost:delTotalC, resale:resale, paid_amount:paid_amount},
			success:function(res){
				var finalCalc = jQuery.parseJSON(res);
				jQuery('#afterDiscountPrice').val(finalCalc.afterDiscPrice);
				jQuery('.afterDiscountPrice').html("$"+finalCalc.afterDiscPrice);
				
				jQuery('#afterDiscountCost').val(finalCalc.nCostAmt);
				jQuery('.afterDiscountCost').html("$"+finalCalc.nCostAmt+ "("+finalCalc.nCostPrc+"%)");

				jQuery('.taxx').text(finalCalc.taxRate);
				jQuery('.txamt').text(finalCalc.taxValue);
				jQuery('.tax_hidden_val').val(finalCalc.taxValue);
				
				jQuery('.perc_amount').val(finalCalc.descAmt);
				jQuery('.price_perc').val(finalCalc.descPer);

				jQuery( '.paidAmountPercent' ).html('('+finalCalc.paidAmountPrc+'%)');

				jQuery( '.totalAmountDue' ).html('$'+finalCalc.totalDue);
				jQuery( '.totalAmountValue' ).val(finalCalc.totalDue);
			}
		});
	});

	jQuery( document ).on('change','.resale_certificate',function(){
		var resale = taxCostActive();
		calcuateAllProductPrice();
	});

	jQuery( document ).on('change','.has_a_uez',function(){
		var resale = taxCostActive();
		calcuateAllProductPrice();
	});

	jQuery( document ).on('change','.has_a_stform',function(){
		var resale = taxCostActive();
		calcuateAllProductPrice();		
	});

	function taxCostActive(){

		var resale_certificate = jQuery( '[name=resale_certificate]:checked' ).attr('data_check');
		var has_uez    		   = jQuery('[name=has_a_uez]:checked').attr('data_check');
		var has_stform 		   = jQuery('[name=has_a_stform]:checked').attr('data_check');

		if( typeof resale_certificate == "undefined" && 
			typeof has_uez == "undefined" && 
			typeof has_stform == "undefined" ){
			return 'yes';
		}

		if ( resale_certificate == 'yes' || has_uez == 'yes' || has_stform == 'yes' ) {
			var resale = 'yes';
		}else{
			var resale = 'no';
		}
		return resale;
	}

	/* -------------------------- end subtotal  area -------------------------- */
	


	jQuery(document).on('click','#ordering_id',function(){
		jQuery("#order_id").toggle();
	});
	jQuery(document).on('click','#assembly_id',function(){
		jQuery("#ass_id").toggle();
	});
	jQuery(document).on('click','#installation_id',function(){
		jQuery("#inst_id").toggle();
	});
	jQuery(document).on('click','#delivery_id',function(){
		jQuery("#del_id").toggle();
	});

	jQuery( document ).on('change','.resale_certificate',function(){
		var resale_certificate = jQuery(this).val();
		if (resale_certificate != 'yes') {
			jQuery('.has_resale_certificate').addClass('dspln');
		}else{
			jQuery('.has_resale_certificate').removeClass('dspln');
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

	jQuery( document ).on('change','.has_a_uez',function(){
		var has_a_uez = jQuery(this).val();
		if (has_a_uez != 'yes') {
			jQuery('.has_a_uez_cer').addClass('dspln');
		}else{
			jQuery('.has_a_uez_cer').removeClass('dspln');
		}
	});

	jQuery( document ).on('change','.is_pickup',function(){
		var is_pickup = jQuery(this).val();
		if (is_pickup == 'no') {
			jQuery('.delivery_price').show();
			if ( jQuery( ".editProTable" ).hasClass( "showCost" ) ) {
				jQuery('.delivery_cost').removeClass('dspln');
			}
		}else{
			jQuery('.delivery_price').hide();
			jQuery('.delivery_cost').addClass('dspln');
		}
		calcuateAllProductPrice();	
	});

	jQuery(document).on('click','.delete_Items',function(){
		jQuery(this).closest('tr').fadeOut().remove();
		calcuateAllProductPrice();
	});
	
	jQuery( document ).on('click','#importcustpro', function(e){
	    e.preventDefault();
	    var orderID  = jQuery('#orderID').val();
	    var formData = new FormData( jQuery('#productData')[0] );
	    formData.append('file_upload', jQuery('input[type=file]')[0].files[0]); 

		jQuery.ajax({
			url: "<?php echo base_url('orders/fabOrders/edit/'); ?>"+orderID,
		    type: "post",
		    data: formData,
		    contentType: false,
		    processData: false,
		    async: false,
			success:function(res){
				location.reload();
			}
		});
	});


	$('#searchPro').keypress(function(event) {
	    if (event.keyCode == 13) event.preventDefault();
	});

</script>

<?php 
$user_role = $this->session->userdata('user_role');
if ( ($edit_order['status'] == 'Order' || $edit_order['is_locked']) && $user_role != '1') { ?>
	<script>jQuery('.container-fluid').append("<div id='overlay_locked'></div>");</script>
<?php } ?>