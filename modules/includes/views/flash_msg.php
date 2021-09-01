<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert/sweetalert.css">
<?php 
    if($this->session->flashdata('message')) { 
    	if($this->session->flashdata('response_status') == 'success' ) {
    		$alert_type = 'Success';
    		$alert_class = 'success';
    	}else{
    		$alert_type = 'Error';
    		$alert_class = 'error';
    	    }
    ?>
    <script type="text/javascript">
    			swal({
    				  title: "<?php echo $alert_type;?>",
    				  text: "<?php echo $this->session->flashdata('message');?>",
    				  timer: 3000,
    				  showConfirmButton: false,
    				  icon: "<?=$alert_class?>"
    				});
    		</script>
    		
		
<?php } ?> 