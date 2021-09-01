<style>.clear { clear:both; }  
.sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
.sms_out { float: right;     background-color: #1abc9c; color: #fff;}
.smst { padding: 4px 8px; border-radius: 4px;clear: both;}
.smst span{ margin-left:0px; }
.btn-success {display: block; width: 100%;}

   .timeline.profile_page_ .timeline-box span.arrow-alt {
         border-left: 12px solid #f5f5f5!important;
         }
         .timeline.profile_page_ .timeline-box {
         background: #f5f5f5;
         box-shadow: none;
         }
         .timeline.profile_page_ .timeline-box span.arrow {
         border-right: 12px solid #f5f5f5 !important;
         }
         .profile_messages_box{
         margin: 0;
         border-left: 0;
         padding: 0;
         }
         .card-box.text-center.user_profiles_outer img {
         margin-right: 22px;
         }
         .user_profiles_outer h4.mb-0 {
         margin-top: 0;
         margin-bottom: 5px !important;
         }
         .user_profiles_outer p {
         margin-bottom: 0px !important;
         }
            .card-box.mb-2.user_activity .media img {
                width: 29px;
                height: 29px;
                margin-right: 15px !important;
                align-self: center!important;
            }
            .card-box.mb-2.user_activity h4 {
                font-size: 14px !important;
                margin-bottom: 1px !important;
            }
            .card-box.mb-2.user_activity {
                padding: 10px 15px;
            }
            .card-box.mb-2.user_activity p b {
               font-size: 12px;
            }
          .card-box.mb-2.user_activity p {
              margin-bottom: 0 !important;
              font-size: 13px;
           }
           .card-box.mb-2.user_activity p i {
            font-size: 18px;
            position: relative;
            top: 2px;
          }
          .time_bor {
            position: relative;
            bottom: 1px;
          }
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

</style>



<!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
     <div class="row">
                     <div class="col-lg-12 col-xl-12">
                         
                           <?php 
             if( empty($leads) ) return;;
                extract($leads);
               $name= @$first_name.' '.@$last_name;  ?>
                        <div class="card-box text-center user_profiles_outer">
                           <div class="media">
                              <img src="<?php echo base_url();?>assets/images/avatar_icon1.png" class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">
                              <div class="text-left media-body">
                                 <h4 class="mb-0"><?php echo $name; ?></h4>
                                 <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 "><?php echo $email; ?></span></p>
                                 <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span class="ml-2"><?php echo $ip;?></span></p>
                              </div>
                           </div>
                           <!-- end card-box -->
                        </div>
                        <!-- end col-->
                     </div>
                     <div class="col-lg-12 col-xl-12">
                        <div class="card-box">
                           <ul class="nav nav-pills navtab-bg nav-justified">
                              <li class="nav-item">
                                 <a href="#aboutme" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                 Messanger
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#timeline" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                 Live Chat
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                 Inbox
                                 </a>
                              </li>
                               <li class="nav-item">
                                 <a href="#activity" data-toggle="tab" aria-expanded="false" class="nav-link">
                                 Activity
                                 </a>
                              </li>
                           </ul>
                             <div class="tab-content">
                              <div class="tab-pane active" id="aboutme">
                                 <!-- Live chat content start -->
                                
                                 <div class="row">
                                 <div class="col-12">
                                 <!-- Live chat content start -->
                                
                                 <div class="row">
                                 <div class="col-12">
                                    <div class="timeline profile_page_" dir="ltr">
                                    <h5 class="card-title"><i class="fe-edit-2"></i> &nbsp;Messenger <?php echo $name; ?></h5>
                    <div class="card-text">
                        <div class='chatbox slimscroll' style='max-height: 350px;'>
                    <?php 
                        // echo "<pre>"; var_dump($lsms); echo "<pre>";
                        foreach($lsms as $sKey => $sVal){
                            echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>";
                        } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="md-form">
                          <div class='row'>
                      
                              <div class="col-md-9">
                                  <textarea id="smstext" name='smstext' class="md-textarea form-control" rows="1" required/></textarea>
                                  <input type='hidden' id="lid" name='lid' value='<?php echo $id; ?>'>
                                  <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $phone; ?>'>
                                  
                              </div>
                            
                            <div class="col-md-3">
                                <button type="submit" id="submit" class="btn btn-success waves-effect waves-light"><i class="fe-send"></i></button>
                            </div>
                              </div>
                        </div>
                                                       
                                                        <!-- end timeline -->
                                                    </div> <!-- end col -->
                                                </div> <!-- Live chat content end -->

                                           

                                        </div> <!-- end tab-pane -->
                                       
                                    <!-- end timeline -->
                                 </div>
                                 <!-- end col -->
                              </div>
                              <!-- Live chat content end -->
                           </div>
                           <!-- end tab-pane -->
                           
                           
                             <div class="tab-pane show " id="timeline">
                              <!-- timeline box -->
                              <div class="container-fluid">
                                 <h4></h4>
                                 <ul class="list-unstyled timeline-sm">
                                   <?php
                                           $myArray = json_decode(json_encode($live_chat), true); 
                                            foreach ($myArray as $key){ ?> 
                                                  <li class="timeline-sm-item">
                                                    <span class="timeline-sm-date"><?php echo  date('Y-m-d',strtotime($key['chart_time'])); ?></span>
                                                 
                                              <?php
                                                  $chat_message = json_decode($key['agent_data'], true);
                                                  foreach ($chat_message as $key1) { ?>
                                                    <h5 class="mt-0 mb-1"><a href="<?php echo base_url();?>crm/leads/live_chat/<?php echo $key['id']; ?>" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><?php echo $key1['name']; ?></a></h5>
                                                    <p><?php echo $key1['email']; ?></p>    
                                                <?php } ?>
                                                  <p class="text-muted mt-2"><?php echo  $key['ready_chat']; ?></p>      

                                                </li>
                                        <?php
                                              } 
                                           ?>
                                 </ul>
                                 <!-- end row -->
                              </div>
                              <!-- timeline end -->
                              <div class="text-center">
                                 <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                              </div>
                           </div>
                           <!-- end timeline content-->
                           <div class="tab-pane" id="settings">
                              <div class="container-fluid">
                                 <!-- start page title -->
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="page-title-box">
                                          <div class="page-title-right">
                                             <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Email</a></li>
                                                <li class="breadcrumb-item active">Inbox</li>
                                             </ol>
                                          </div>
<!--                                           <h4 class="page-title">Inbox</h4>
 -->                                       </div>
                                    </div>
                                 </div>
                                 <!-- end page title --> 
                                 <div class="row">
                                    <!-- Right Sidebar -->
                                    <div class="col-12">
                                       <div class="card-box">
                                          <div class="inbox-rightbar profile_messages_box">
                                             <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-archive font-18"></i></button>
                                                <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-alert-octagon font-18"></i></button>
                                                <button type="button" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-delete-variant font-18"></i></button>
                                             </div>
                                             <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-folder font-18"></i>
                                                <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                   <span class="dropdown-header">Move to</span>
                                                   <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                </div>
                                             </div>
                                             <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-label font-18"></i>
                                                <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                   <span class="dropdown-header">Label as:</span>
                                                   <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                                   <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                                </div>
                                             </div>
                                             <div class="mt-3">
                                                <ul class="message-list">
                                                     <?php
                                                    /* Connecting Gmail server with IMAP */
                                                    $connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'ted@perfectionkitchens.com', 'Cabinets1010!') or die('Cannot connect to Gmail: ' . imap_last_error());

                                                    /* Search Emails having the specified keyword in the email subject */
                                                    // $emailData = imap_search($connection, 'SUBJECT "Article "');
                                                    // $emailData = imap_search($connection,'FROM "webbninja2@gmail.com" SINCE "09-May-2019"');
                                                     $emailData = imap_search($connection,'FROM "webbninja2@gmail.com" SINCE "10-May-2019"');

                                                    if (! empty($emailData)) {
                                                       rsort($emailData);
                                                

                                                     foreach ($emailData as $emailIdent) {
                
                                                       $overview = imap_fetch_overview($connection, $emailIdent, 0);
                                                       $header = imap_header($connection, $emailIdent);
                                                       $fromaddress = $overview[0]->from;
                                                       $toaddress = $overview[0]->to;
                                                       $from = $header->from[0]->mailbox ."@". $header->from[0]->host;
                                                       $to = $header->to[0]->mailbox ."@". $header->to[0]->host;
                                                       $subject = $overview[0]->subject;
                                                       $date = date("d F, Y", strtotime($overview[0]->date));
                                                       $message = imap_fetchbody($connection, $emailIdent,1.1);
                                                         // if ($message == "") { // no attachments is the usual cause of this
                                                         // $message = imap_fetchbody($connection, $emailIdent, 2);
                                                         // }
                                                         if(trim($message) == ""){
                                                         $message = imap_fetchbody($connection, $emailIdent, 1);
                                                         }

                                                         $message = quoted_printable_decode($message);
                                                      $messageExcerpt = substr($message, 0, 55);


                                                  ?>
                                                   <li class="unread"  data-toggle="" data-target=".bs-example-modal-lg">
                                                      <div class="col-mail col-mail-1">
                                                         <div class="checkbox-wrapper-mail">
                                                            <input type="checkbox" id="chk1">
                                                            <label for="chk1" class="toggle"></label>
                                                         </div>
                                                         <span class="star-toggle far fa-star text-warning"></span>
                                                         <?php echo $fromaddress; ?> 
                                                      </div>
                                                      <div class="col-mail col-mail-2">
                                                            <?php echo $subject; ?>&nbsp;–&nbsp;
                                                         <span class="teaser"><?php echo $messageExcerpt; ?></span>
                                                        
                                                         <div class="date"><?php echo $date; ?></div>
                                                      </div>
                                                   </li>

                                                   <?php
                                                          } //foreach loop closed
                                                       } //if loop closed
                                                       imap_close($connection);

                                                   ?>
                                                   </ul>
                                             </div>
                                                  
                                             <!-- end .mt-4 -->
                                             <div class="row">
                                                <div class="col-7 mt-1">
                                                   Showing 1 - 20 of 289
                                                </div>
                                                <!-- end col-->
                                                <div class="col-5">
                                                   <div class="btn-group float-right">
                                                      <button type="button" class="btn btn-light btn-sm"><i class="mdi mdi-chevron-left"></i></button>
                                                      <button type="button" class="btn btn-info btn-sm"><i class="mdi mdi-chevron-right"></i></button>
                                                   </div>
                                                </div>
                                                <!-- end col-->
                                             </div>
                                             <!-- end row-->
                                          </div>
                                          <!-- end inbox-rightbar-->
                                          <div class="clearfix"></div>
                                       </div>
                                       <!-- end card-box -->
                                    </div>
                                    <!-- end Col -->
                                 </div>
                                 <!-- End row -->
                              </div>
                           </div>

                           <div class="tab-pane" id="activity">
                                 <div class="roow">
                                    <div class="col-xl-12 order-xl-1 order-2">
                               
                               <?php  foreach($activity_record as $arKey => $arVal){ ?>
                                    <div class="card-box mb-2 user_activity">
                                        <div class="row align-items-center">
                                            <div class="col-sm-12">
                                                <div class="media">
                                                    <img class="d-flex align-self-center mr-3 rounded-circle" src="<?php echo base_url();?>assets/images/avatar_icon1.png" alt="Generic placeholder image" height="64">
                                                    <div class="media-body">
                                                        <h4 class="mt-0 mb-2 font-16"><?php echo $arVal->activity_message ?></h4>
                                                        <p class="mb-1"><b><i class="mdi mdi-calendar-text"></i></b> <?php echo $arVal->activity_time ?></p>
                                                        <!--<p class="mb-0"><b>Created By:</b> Geneva </p>-->
                                                    </div>
                                                </div>
                                            </div>
                                           <!-- end col-->
                                        </div> <!-- end row -->
                                    </div> <!-- end card-box-->
                                        
                                <?php } ?>
                                <!-- <div class="text-center my-4">
                                    <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                                </div> -->

                            </div> <!-- end col -->

                        
                        </div>
                           </div>
                           <!-- end settings content-->
                        </div>
                        <!-- end tab-content -->
                     </div>
                     <!-- end card-box-->
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row-->
            </div>
            <!-- container -->
         </div>
         <!-- content -->
         <!-- Footer Start -->
         <footer class="footer">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     2015 - 2019 &copy; UBold theme by <a href="">Coderthemes</a> 
                  </div>
                  <div class="col-md-6">
                     <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- end Footer -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
      </div>
      <!-- END wrapper -->
      <!-- Right Sidebar -->
      <div class="right-bar">
         <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0 text-white">Settings</h5>
         </div>
         <div class="slimscroll-menu">
            <!-- User box -->
            <div class="user-box">
               <div class="user-img">
                  <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                  <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
               </div>
               <h5><a href="javascript: void(0);">Geneva Kennedy</a> </h5>
               <p class="text-muted mb-0"><small>Admin Head</small></p>
            </div>
            <!-- Settings -->
            <hr class="mt-0" />
            <h5 class="pl-3">Basic Settings</h5>
            <hr class="mb-0" />
            <div class="p-3">
               <div class="checkbox checkbox-primary mb-2">
                  <input id="Rcheckbox1" type="checkbox" checked>
                  <label for="Rcheckbox1">
                  Notifications
                  </label>
               </div>
               <div class="checkbox checkbox-primary mb-2">
                  <input id="Rcheckbox2" type="checkbox" checked>
                  <label for="Rcheckbox2">
                  API Access
                  </label>
               </div>
               <div class="checkbox checkbox-primary mb-2">
                  <input id="Rcheckbox3" type="checkbox">
                  <label for="Rcheckbox3">
                  Auto Updates
                  </label>
               </div>
               <div class="checkbox checkbox-primary mb-2">
                  <input id="Rcheckbox4" type="checkbox" checked>
                  <label for="Rcheckbox4">
                  Online Status
                  </label>
               </div>
               <div class="checkbox checkbox-primary mb-0">
                  <input id="Rcheckbox5" type="checkbox" checked>
                  <label for="Rcheckbox5">
                  Auto Payout
                  </label>
               </div>
            </div>
            <!-- Timeline -->
            <hr class="mt-0" />
            <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
            <hr class="mb-0" />
            <div class="p-3">
               <div class="inbox-widget">
                  <div class="inbox-item">
                     <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                     <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                     <p class="inbox-item-text">I've finished it! See you so...</p>
                  </div>
                  <div class="inbox-item">
                     <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                     <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                     <p class="inbox-item-text">This theme is awesome!</p>
                  </div>
                  <div class="inbox-item">
                     <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                     <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                     <p class="inbox-item-text">Nice to meet you</p>
                  </div>
                  <div class="inbox-item">
                     <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                     <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                     <p class="inbox-item-text">Hey! there I'm available...</p>
                  </div>
                  <div class="inbox-item">
                     <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                     <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                     <p class="inbox-item-text">This theme is awesome!</p>
                  </div>
               </div>
               <!-- end inbox-widget -->
            </div>
            <!-- end .p-3-->
         </div>
         <!-- end slimscroll-menu-->
      </div>
      <!-- /Right-bar -->
      <!-- Right bar overlay-->
      <div class="rightbar-overlay"></div>
      <!--  email modal cod start -->
      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               ...
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /email.modal-dialog -->
      <!-- Vendor js -->
   
             
         
<!------old--->
          
