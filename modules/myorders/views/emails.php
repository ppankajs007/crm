
<div class="container-fluid"><!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">CRM</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'orders'; ?>">Orders</a></li>
                        <li class="breadcrumb-item active">Emails</li>
                    </ol>
                </div>
                <h4 class="page-title">Emails</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card-box">
               <ul class="overview_list" id="lead_sub_menu" class="lead_sub_menu">
                  <?php  echo modules::run('includes/order_sub_menu');?>
               </ul>
               <div class="clear"></div>
             </div>
        </div>
    </div>  
      <?php 
             if(! empty($order_emails) ){
               
                 foreach( $order_emails as $value ){ ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box project-box">
                <?php  
                $id =  $this->uri->segment(3);
                $order_data = App::get_row_by_where('pk_order', array( 'id' => $id ) );
                $order_id = $order_data->id;
                $customer_name = $order_data->first_name;
                
               $newStr = str_replace("{name}",$customer_name, $value['message']);
               $newStr = str_replace("{order_id}",'#'.$order_id, $newStr);
                ?>
                <!--Fetch current customer_name-->
                <!--Fetch current order_id-->
                
                <!--{name} replace it with customer_name-->
                <!--{order_id} replace it with Order ID-->
                
                <!-- Title-->
                <h4 class="mt-0"><a href="javascript: void(0);" class="text-dark"><?php echo $value['subject']; ?></a></h4>
               
                <p class="text-muted font-13 mb-3 sp-line-2"><?php echo $newStr; ?></p>
              </div> <!-- end card box-->
        </div><!-- end col-->
   </div> <!-- end row -->
   <?php } }?>
   
</div> <!-- container -->
<script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
