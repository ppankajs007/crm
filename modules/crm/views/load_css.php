<?php 

    if($this->router->fetch_method() == 'index' ||$this->router->fetch_method() == 'paperworkpending' )

    {  // For list All users

?>

	<!-- third party js -->

	<link href="<?php echo base_url()?>assets/libs/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url()?>assets/libs/jqueryDatepicker/jquery-datepicker.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url()?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

	<style type="text/css">

		.nine_margin {
    		margin: 3px;
    		padding: 0px;
    		cursor: pointer;
		}

		.green_boxes{
			width: 13px;
			height: 13px;
			border-radius: 100%;
			background: #1abc9c;
		}

		.red_boxes{
			width: 13px;
			height: 13px;
			background: #fb6b5b;
			border-radius: 100%;
		}

		ul.nine_boxesF {
		    width: 100% !important;
		    list-style: none;
		    padding: 0;
		    clear: both;
		}

		ul.nine_boxesF li {
		    float: left;
		    margin: 1px;
		    width: 20px;
		    font-size: 9px;
			cursor: pointer;
		}

		.custombox-content>* {

		    max-width: 100%;

		    /*max-height: unset !important; */

		    overflow-y: scroll;

		}

		.error {
    	color: red;
		}
		
/*	.select2-selection.select2-selection--multiple {
        max-height: 10px;
        overflow-y: scroll;
    }*/
    
    .select2-container .select2-selection--multiple .select2-selection__choice {
    
    font-size: 13px;
}

.select2-container {

    z-index: 1;

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
		.mainCl td{
		    font-weight:bold;
		}
		
		.list-group-item {
		   /* border:none !important; */
             border-top: 1px solid rgba(0,0,0,.125) !important;
            }
            
                
select.js-example-basic-multiple.form-control option {
    display: none !important;
}
select.js-example-basic-multiple.form-control{
    height:38px !important;
    overflow:hidden;
}
.nine_boxes_border {
    border: 2px solid #7dcc90;
    position: relative;
    width: 77px;
    height: 70px;
    background: #fff;
    margin-left: 5px;
}
span.check_mark {
    font-size: 44px;
    color: #7dcc90;
    text-align: center;
    display: block;
}
.nine_boxes_border_yellow{
	border: 2px solid #eab50a;
    position: relative;
    padding: 6px 0px 9px 11px;	 
    width: 77px;
    height: 70px;
    margin-left: 5px;
}

span.check_mark_yellow {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    border: 0;
    font-size: 44px;
    color: #eab50a;
    text-align: center;
    background: white;
}


	</style>
<?php   if($this->router->fetch_method() == 'edit_leads' )  {  ?>

        <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        
 
<?php } ?>
  <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  	#call_customer_meta p{
	    margin-top: 10px;
	}
	#call_customer_meta{
	    margin-top: 20px;
	}
	.hideTrue{
		display: none !important;
	}
	table#leadsTable {
	    margin: 0 auto !important;
	    width: 100% !important;
	    clear: both !important;
	    border-collapse: collapse !important;
	    table-layout: fixed !important;
	    word-break: break-word !important;
	}
	table tr {
		font-size: 12px;
	}
	table.table .action-icon {
	    font-size: 16px;
	    display: inline-block;
	    padding: 0px 3px;
	}
	ul.pagination li.paginate_button.page-item {
	    padding: 1px 1px 1px 2px !important;
	}
  </style>
