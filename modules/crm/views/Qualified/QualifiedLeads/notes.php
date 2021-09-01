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
                                              <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/Qualified/">Qualified Leads</a></li>
                                              <li class="breadcrumb-item"><a href=" <?php echo base_url();?>crm/Qualified/dashboard/<?php echo $leads['id']; ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Notes</li>
                                        </ol>
                                    </div>
                                    <?php  $id=$this->uri->segment(4);
                                    
                                    $lead= App::get_by_where('leads', array('id'=>$id) );
                                    
                                    //print_r($lead);
                                    
                                    ?>

                                    <h4 class="page-title">Qualified Leads(#<?php echo $id. ' '.$lead[0]->first_name;?>)</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <?php // pr($leads); ?><?php // echo $leads['note']; ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                            <ul class="overview_list" id="lead_sub_menu">
                                              <?php  echo modules::run('includes/Qualified_sub_menu');?>
                                             </ul>

                                        <div class="clear"></div>
                                        <div class="row total_list">
        
                                            <div class="col-md-12">
                                                <div class="additional_list notes_form">
                                                    <header class="panel-heading">Notes</header>
                                                    <?php $attributes = array('id' => 'form'); echo form_open($this->uri->uri_string(),$attributes); ?>
                                                    <input type="hidden" name="lead_id" value="<?php echo $leads['id']; ?>">

                                                    <textarea id="noteEditor" name="note" class="form-control"><?php echo $leads['note']; ?></textarea>  
<!-- 
                                                        <hr>
                                                        <input type="hidden" name="note">
                                                    <div id="noteEditor style="height: 300px;">
                                                            <h3><span class="ql-size-large">Hello World!</span></h3>
                                                            <p><br></p>
                                                            <h3>This is an simple editable area.</h3>
                                                            <p><br></p>
                                                            <ul>
                                                            <li>
                                                            Select a text to reveal the toolbar.
                                                            </li>
                                                            <li>
                                                            Edit rich document on-the-fly, so elastic!
                                                            </li>
                                                            </ul>
                                                            <p><br></p>
                                                            <p>
                                                            <?php echo $leads['note']; ?>
                                                            End of simple area
                                                            </p>

                                                    </div> --> <!-- end Snow-editor-->






                                                    <input type="submit" class="btn btn-success waves-effect waves-light update_btn" value="Update">
                                                    <?php echo form_close(); ?>


                                                </div>  
                                                
                                            </div>





                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    </div> <!-- container -->
                 