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
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App css -->
        <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="authentication-bg">
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <?php  echo $template['body'];?>
            </div><!-- end container -->
        </div><!-- end page -->
        <footer class="footer footer-alt">
            <?php echo date('Y');?> &copy; Perfection Kitchens CRM by <a href="http://acewebx.com" target="_blank" class="text-white-50">AceWebX</a> 
        </footer>
        <!-- Vendor js -->
        <script src="<?php echo base_url()?>assets/js/vendor.min.js"></script>
        <?php  echo modules::run('includes/flash_msg');?>
        <!-- App js -->
        <script src="<?php echo base_url()?>assets/js/app.min.js"></script>
    </body>
</html>