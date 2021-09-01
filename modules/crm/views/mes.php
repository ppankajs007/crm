        <style>
    .clear { clear:both; }  
.sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
.sms_out { float: right;     background-color: #1abc9c; color: #fff;}
.smst { padding: 4px 8px; border-radius: 4px;clear: both;}
.smst span{ margin-left:0px; }
.btn-success {display: block; width: 100%;}
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
.no_list{
    overflow-y: scroll;
    overflow-x: hidden;
    height: 300px;
}
 
</style>
        <div class="container-fluid">                       
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                            <li class="breadcrumb-item active">Messenger</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Messenger</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                      <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <div class="no_list">
                                                    <?php
                                                   $leads;
                                                    foreach($leads as $lead){ ?>
                                                         <div class="row">
                                                            <div class="col-md-12"><a href="javascript:void(0);" id="lead_id" class="data-in" ids="<?php echo $lead['id']; ?>"><?php echo $lead['phone']; ?> </a></div>
                                                           
                                                         </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                              <div class="timeline profile_page_" dir="ltr">
                                    <h5 class="card-title"><i class="fe-edit-2"></i> &nbsp;Messenger </h5>
                    <div class="card-text">
                        <div class='chatbox slimscroll' style='max-height: 350px;'>
                    <?php 
                         //echo "<pre>"; var_dump($lsms); echo "<pre>";
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
                                  <input type='hidden' id="lid" name='lid' value='<?php echo $leads['id']; ?>'>
                                  <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $leads['phone']; ?>'>
                                  
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
                                        </div>
                        <!-- end row-->
        </div> <!-- container -->