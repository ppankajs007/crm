<?php 

    if($this->router->fetch_method() == 'index' ||$this->router->fetch_method() == 'paperworkpending' )

    {  // For list All users

?>

	<!-- third party js -->

	<link href="<?php echo base_url()?>assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url()?>assets/libs/jqueryDatepicker/jquery-datepicker.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url()?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

	<style type="text/css">

		.custombox-content>* {

		    max-width: 100%;

		    /*max-height: unset !important; */

		    overflow-y: scroll;

		}

		.error {
    	color: red;
		}
		
	.select2-selection.select2-selection--multiple {
        max-height: 10px;
        overflow-y: scroll;
    }


	</style>

<?php } ?>

<style type="text/css">

		.create-customer {
    		font-size: 15px;
		}
		
		.header {
			    width: 100%;
			    padding: 14px;
			    background: #566676;
			    margin: 23px 0px;
			    color: rgba(255,255,255,.6);
		}

	</style>
	<!-- flatpicker css used in edit method -->
<?php   if($this->router->fetch_method() == 'edit' )  {  ?>

        <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
      
<?php } ?>