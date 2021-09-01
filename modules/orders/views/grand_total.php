	
	<div class="wrapper">
		<div><label>Discount %</label>  <input type='text' name="" class="price_perc"></div>
		<div><label>Amount</label> <input type='text' name="perc_amount" class="perc_amount"></div>
		<div><label>Net price</label>   <input type='text' name="net_price" class="net_price"></div>
	</div>

<script>
jQuery(document).ready(function(){
    
    jQuery( ".price_perc" ).keydown(function() {
        
    	var sum = 0;
    	var perc = jQuery(this).val();
        jQuery('.finalp').each(function() {
            sum += Number(jQuery(this).val());
        });
        
        var perc_amount = (perc/100) * sum;
        var NetPrice = sum - perc_amount;
    
        jQuery('.perc_amount').val(perc_amount);
        jQuery('.net_price').val(NetPrice);
    
        console.log('%' + perc + ' amount in perc: ' + perc_amount + ' total: ' + NetPrice);
    
    });
    
    jQuery( ".perc_amount" ).keydown(function() {
    	var sum = 0;
    	var perc_amount = jQuery(this).val();
        jQuery('.finalp').each(function() {
            sum += Number(jQuery(this).val());
        });
        
        var NetPrice = sum - perc_amount;
        var perc = perc_amount * (100/sum);
    
        jQuery('.price_perc').val(perc);
        jQuery('.net_price').val(NetPrice);
    
        console.log('%' + perc + ' amount in perc: ' + perc_amount + ' total: ' + NetPrice);
    
    });
    
    jQuery( ".net_price" ).keydown(function() {
    	var sum = 0;
    	var NetPrice = jQuery(this).val();
        jQuery('.finalp').each(function() {
            sum += Number(jQuery(this).val());
        });
    
        var perc_amount = sum - NetPrice;
        var perc = perc_amount * (100/sum);
    
        jQuery('.perc_amount').val(perc_amount);
        jQuery('.price_perc').val(perc);
    
        console.log('%' + perc + ' amount in perc: ' + perc_amount + ' total: ' + NetPrice);
    
    });
});
</script>