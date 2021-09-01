<?php 

    if($this->router->fetch_method() == 'index' || $this->router->fetch_method() == 'emails' )

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
		ul.pagination li.paginate_button:hover {
    background: transparent !important;
    border: none !important;
}

	</style>

<?php } ?>

<style type="text/css">
	
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
  .searchlist > ul{
            max-height: 150px;
  } 
  .searchlist li{
            cursor: pointer;
  }

  .importOrder{
  	margin-top: 23px;
  }
  .log_active{
      background: #4caf503d;
  }

</style>
<?php   if($this->router->fetch_method())  {  ?>

        <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        
 
<?php } ?>

<?php   if ($this->router->fetch_method() == 'product')  {  ?>
    <link href="<?php echo base_url()?>assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
<?php } ?>
