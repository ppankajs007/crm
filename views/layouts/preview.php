<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->config->item('website_name', 'tank_auth');?> - <?php  echo $template['title'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon-32x32.png">

        <!-- third party css -->
         <?php  
          // For load script based on module
          echo modules::run($this->router->fetch_class() .'/load_css');
        ?>
        <!-- third party css end -->
        <!-- App css -->
        <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/libs/custombox/custombox.min.css" rel="stylesheet">

    </head>
    <body><!-- Begin page -->
        <div id="wrapper"><!-- Topbar Start -->
            <div class="navbar-custom">
                <?php  echo modules::run('includes/topbar_menu');?>
            </div><!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
          
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content"> <!-- Start Content-->
                    <!--main content start-->
                    <?php  echo $template['body'];?>
                    <!--main content end-->
                </div> <!-- content -->
                <!-- Footer Start -->
                <footer class="footer">
                    <?php  echo modules::run('includes/footer');?>
                </footer> <!-- end Footer -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div><!-- END wrapper -->
        <!-- Right Sidebar -->
        <div class="right-bar">
            <?php  echo modules::run('includes/rightside_menu');?>
        </div><!-- /Right-bar -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- Vendor js -->
        <script src="<?php echo base_url()?>assets/js/vendor.min.js"></script>
        <!-- Modal-Effect -->
        <script src="<?php echo base_url()?>assets/libs/custombox/custombox.min.js"></script>
        <?php  echo modules::run('includes/flash_msg');?>
        <!-- App js -->
        <script src="<?php echo base_url()?>assets/js/app.js"></script>
        <?php  
          // For load script based on module
          echo modules::run($this->router->fetch_class() .'/load_script');
        ?>
    </body>
</html>