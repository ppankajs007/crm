<?php 

    if($this->router->fetch_method() == 'index' )

    {  // For list All users

?>

	<!-- third party js -->

	<link href="<?php echo base_url()?>assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

	<style type="text/css">

		.custombox-content>* {

		    max-width: 100%;

		    /*max-height: unset !important; */

		    overflow-y: scroll;

		}
		.error{
			color:red;
		}

		.form-control.error {
    		border: 1px solid red !important;

		}
		.searchlist > ul{
		    max-height: 150px;
		} 
		.searchlist li{
			cursor: pointer;
		}

	</style>

<?php } ?>



