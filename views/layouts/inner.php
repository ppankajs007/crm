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
        
        <!-- Push crew notification script starts -->
       <!-- 
       <script type="text/javascript">
        (function(p,u,s,h){
            p._pcq=p._pcq||[];
            p._pcq.push(['_currentTime',Date.now()]);
            s=u.createElement('script');
            s.type='text/javascript';
            s.async=true;
            s.src='https://cdn.pushcrew.com/js/53cc5fce286756215f70fe31a89f9ec8.js';
            h=u.getElementsByTagName('script')[0];
            h.parentNode.insertBefore(s,h);
        })(window,document);
        </script> 
        -->
        <!-- Push crew notification script ends -->
        
        <!-- PushAlert -->
        <?php if( $this->router->fetch_class() != 'messenger' ){  ?>
            <script type="text/javascript">
                (function(d, t) {
                        var g = d.createElement(t),
                        s = d.getElementsByTagName(t)[0];
                        g.src = "https://cdn.pushalert.co/integrate_f7582d406d779acef6c6df2096d715cb.js";
                        s.parentNode.insertBefore(g, s);
                }(document, "script"));
                
                // On succesfully subscription save subscriber id
                // (pushalertbyiw = window.pushalertbyiw || []).push(['onSuccess', callbackOnSuccess]);
            
                // function callbackOnSuccess(result) {
                //     //console.log(result.subscriber_id); //will output the user's subscriberId
                //     //console.log(result.alreadySubscribed); // False means user just Subscribed
                //     var subs_id = result.subscriber_id;
                //     var subs_info = result.alreadySubscribed;
                //     jQuery.ajax({
                //         type: "POST",
                //         url: "<?php echo base_url(); ?>" + "crm/leads/pushalert",
                //         data: { subs_id : subs_id, subs_info : subs_info },
                //         success: function(res) {
                //             //console.log(res);  
                //         }
                //     });

                // }

            </script>
        <!-- End PushAlert -->
        <?php } ?>
    </head>
    <body><!-- Begin page -->
        <div id="wrapper"><!-- Topbar Start -->
            <div class="navbar-custom">
                <?php  echo modules::run('includes/topbar_menu');?>
            </div><!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <?php  echo modules::run('includes/leftside_menu');?>
            </div><!-- Left Sidebar End -->
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
        <script> 
            jQuery(document).ready(function() {
                jQuery("#submit").click(function(event) {
                var lid = jQuery("#lid").val();
                var nmbr = jQuery("#lnmbr").val();
                var sms = jQuery("#smstext").val();
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "crm/leads/sendSms",
                    data: {lid:lid, nmbr:nmbr, sms:sms},
                    success: function(res) {
                        jQuery("#smstext").val('');
                        jQuery("#smstext").text('');
                        jQuery('.chatbox').append('<p class="smst sms_out"><span>'+sms+'</span></p>');
                    }
                });
                });
            });
        </script>
    </body>
</html>