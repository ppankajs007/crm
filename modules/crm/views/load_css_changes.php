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
/* new css table listing */

.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
table{
    table-layout: fixed;
    word-wrap:break-word;
}
/*end table */

/* edit page*/
 	.error {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .75rem;
    color: #f1556c;
    display: block;
}
	.task_b {
    position: absolute;
    visibility: hidden;
}
/* end edit page*/

/* dashboard */

  .overview_list {
            padding: 0;
            margin: 0;
            border-bottom: 1px solid #ccc;
            float: left;
            width: 100%;
        }
            .overview_list li {
               float: left;
                margin-bottom: 9px;
                list-style: none;
            }
            .overview_list li a {
                margin-right: 2px;
                line-height: 1.42857143;
                border: 1px solid transparent;
                border-radius: 2px 2px 0 0;
                color: #428bca;
                padding: 10px 8px;
            }    
            .overview_list li.active a {
                border-bottom: 2px solid #566676;
                border-radius: 0px;
            }
            .clear {
                clear: both;
            }
            .box_outer label {
                color: #979797;
                font-size: 85%;
                margin-bottom: 0;
            }
            .box_outer h4 {
                color: #2c96dd;
                font-size: 11px;
                margin-top: 1px;
            }
           
            .box_outer h5 {
                 color: #666;
                 font-size: 18px;
            }
            .box_outer {
                text-align: center;
                border-right: 1px solid #E7E7E7;
                padding: 5px 0;
                margin-bottom: 16px;
                margin-top: 29px;

            }
            .additional_list {
                border: 2px solid #e8e8e8;
                padding: 0px 0;
                border-radius: 3px;
                margin-top: 23px;
            }
            .additional_list .panel-heading {
               background: #f5f5f5;
              padding: 10px;
              color: #000;
              font-size: 13px;
           }
           .list-group.no-radius .pull-right {
               float: right;
            }
            .additional_list ul li {
                border-left: none;
                border-radius: ;
                border-right: none;
            }
            .information_outer {

                float: left;
                width: 100%;
                height: 1px;
                width: 100%;
                background: #ddd;

            }
          .clear { clear:both; }  
.sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
.sms_out { float: right;     background-color: #1abc9c; color: #fff;}
.smst { padding: 4px 8px; border-radius: 4px;clear: both; margin:10px; }
.smst span{ margin-left:0px; }
.btn-success {display: block; width: 100%;}
.timeline:before {
    background-color: #dee2e6;
    bottom: 0;
    content: "";
    left: 50%;
    position: absolute;
    top: 30px;
    width: 2px;
    z-index: 0;
    display:none;
}
.timeline {
    margin-bottom: 8px;
    position: relative;
    padding: 10px 10px 0;
}
.add_file{
    float: right;
  
}
.additional_list.activ .slimscroll {
    max-height:409px !important
}

.additional_list.messenger .chatbox.slimscroll {
    height: 322px !important;
}

.comment-list {
    position: relative;
}

.comment-list:before {
    position: absolute;
    top: 0;
    bottom: 35px;
    left: 18px;
    width: 1px;
    background: #e0e4e8;
    content: '';
}

.comment-list .comment-item {
    margin-top: 18px;
    position: relative;
}

.text-info {
    color: #4cc0c1;
}

    .comment-list .comment-item .comment-body {
        margin-left: 46px;
    }
    
    .comment-list article span.fa-stack {
      float: left;
    }
    
    .comment-list .comment-item:last-child {
    margin-bottom: 16px;
}
 li.list-group-item:nth-child, li.list-group-item:last-child {
    border: block !important;
}



/*end dashboard */
/* fie css*/

  .overview_list {
            padding: 0;
            margin: 0;
            border-bottom: 1px solid #ccc;
            float: left;
            width: 100%;
        }
            .overview_list li {
               float: left;
                margin-bottom: 9px;
                list-style: none;
            }
            .overview_list li a {
                margin-right: 2px;
                line-height: 1.42857143;
                border: 1px solid transparent;
                border-radius: 2px 2px 0 0;
                color: #428bca;
                padding: 10px 8px;
            }    
            .overview_list li.active a {
                border-bottom: 2px solid #566676;
                border-radius: 0px;
            }
            .clear {
                clear: both;
            }
            .box_outer label {
                color: #979797;
                font-size: 85%;
                margin-bottom: 0;
            }
            .box_outer h4 {
                color: #2c96dd;
                font-size: 11px;
                margin-top: 1px;
            }
           
            .box_outer h5 {
                 color: #666;
                 font-size: 18px;
            }
            .box_outer {
                text-align: center;
                border-right: 1px solid #E7E7E7;
                padding: 5px 0;
                margin-bottom: 16px;
                margin-top: 29px;

            }
            .additional_list {
                border: 1px solid #e8e8e8;
                padding: 0px 0;
                border-radius: 3px;
                margin-top: 23px;
            }
            .additional_list .panel-heading {
               background: #f5f5f5;
              padding: 10px;
              color: #000;
              font-size: 13px;
           }
           .list-group.no-radius .pull-right {
               float: right;
            }
            .additional_list ul li {
                border-left: none;
                border-radius: ;
                border-right: none;
            }
            .information_outer {

                float: left;
                width: 100%;
                height: 1px;
                width: 100%;
                background: #ddd;

            }

           .add_file {
                float: right;
                font-size: 17px;
                margin: 4px 12px;
                margin-top: 0px;
            }
            .fileorder{
                cursor:pointer;
            }


/** file end */


	</style>
<?php   if($this->router->fetch_method() == 'edit_leads' )  {  ?>

        <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        
 
<?php } ?>
