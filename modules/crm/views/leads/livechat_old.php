 <style type="text/css">

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

        </style>



        <div class="container-fluid">                       

                        <!-- start page title -->

                        <div class="row">

                            <div class="col-12">

                                <div class="page-title-box">

                                    <div class="page-title-right">

                                        <ol class="breadcrumb m-0">

                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/leads">Leads</a></li>
                                            <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/leads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>

                                            <li class="breadcrumb-item active">Live Chat</li>

                                        </ol>

                                    </div>

                                    <?php  $id=$this->uri->segment(4);
                                    
                                    $lead= App::get_by_where('leads', array('id'=>$id) );
                                    
                                    //print_r($lead);
                                    
                                    ?>
                                    <h4 class="page-title">Leads(#<?php echo $lead[0]->id. ' '  .$lead[0]->first_name.' '.$lead[0]->last_name;?>)</h4>

                                </div>

                            </div>

                        </div>     

                       

                        <div class="row">

                            <div class="col-12">

                                <div class="card">

                                    <div class="card-body">

                                            <ul class="overview_list" id="lead_sub_menu">

                                              <?php  echo modules::run('includes/lead_sub_menu');?>

                                             </ul>



                                        <div class="clear"></div>

                                        <div class="row total_list">

        

                                            <div class="col-md-12">

                                                <div class="additional_list">

                                                    <header class="panel-heading">Live Chat</header>

                                                   

                                              

                              <ul class="list-unstyled timeline-sm">

                                   <?php

                                   

                                  

                                 

                                           $myArray = json_decode(json_encode($live_chats), true); 

                                            if(!empty( $myArray ) ){

                                    

                                            foreach ($myArray as $key){ ?> 

                                                  <li class="timeline-sm-item">

                                       <span class="timeline-sm-date"><?php echo  date('m-d-Y',strtotime($key['chart_time'])); ?></span>

                                                 

                                              <?php

                                                  $chat_message = json_decode($key['agent_data'], true);

                                                  foreach ($chat_message as $key1) { ?>

                                                    <h5 class="mt-0 mb-1"><a href="<?php echo base_url();?>crm/leads/chat_record/<?php echo $key['id']; ?>" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><?php echo $key1['name']; ?></a></h5>

                                                    <p><?php echo $key1['email']; ?></p>    

                                                <?php } ?>

                                                  <p class="text-muted mt-2"><?php echo  $key['ready_chat']; ?></p>      



                                                </li>
 <?php
                                              } }else{
                                                ?>
                                                <p class="record">No record found</p>  
                                                <?php 
                                                 } ?>
                                                  </ul>
                                              


                                 </ul>

                                                      













                                       </div>

                                       </div></div></div></div></div></div>         

                                </div> <!-- end card -->

                            </div><!-- end col-->

                        </div>

                        <!-- end row-->

                    </div> <!-- container -->

                 <style type="text/css">.record{ margin-left: 580px;}

                 </style>