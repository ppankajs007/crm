<div class="container-fluid"> <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Messenger</li>
                    </ol>
                </div>
                <h4 class="page-title">Messenger</h4>
            </div>
        </div>
    </div><!-- end row --> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2 topBar">
                            <div class="col-sm-4 msgtype">
                                <div class="dropdown">
                                    <select class="btn btn-light messanger-view" type="button" id="dropdownMenuButton" 
                                    aria-haspopup="true" aria-expanded="false">
                                        <?php (isset($_GET["folder"])) ? $folder = $_GET["folder"] : $folder=""; ?>
                                        <option value="unread" <?php if ($folder == "unread" ) echo 'selected' ; ?> >Unread</option>
                                        <option value="read" <?php if ($folder == "read" ) echo 'selected' ; ?> > Read</option>
                                        <option value="followup" <?php if ($folder == "followup" ) echo 'selected' ; ?>  >Follow Up</option>
                                        <option value="done" <?php if ($folder == "done" ) echo 'selected' ; ?> >Done</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-8 msgfolow">
                                <?php if( isset($mlead_id) ) { ?> 
                                <ul class="markoption mLeft">
                                    <li><a title="Mark as Unread" class="markunread <?php if($mnumber['read_status'] == '0'){ echo 'actives'; } ?>" data-id="<?php echo $mlead_id; ?>" href="javascript:;">
                                    <i class="fas fa-envelope-square"></i></a>
                                    </li>
                                    <li>
                                    <a title="Mark as Fav" class="markfav <?php if($mnumber['fav_status'] == '1'){ echo 'actives'; } ?>" data-id="<?php echo $mlead_id; ?>" href="javascript:;">
                                    <i class="far fa-star"></i> </a>
                                    </li>
                                    <li>
                                    <a title="Mark as Done" class="markdone <?php if($mnumber['done_status'] == '1'){ echo 'actives'; } ?>" data-id="<?php echo $mlead_id; ?>" href="javascript:;">
                                    <i class="fas fa-check"></i> </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <div class="mRight">
                                    <a title='New Message.' href="<?php echo base_url();?>messenger/new_chat" class="btn btn-danger customdesign waves-effect waves-light customDes" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i></a></li>
                                </div>
                            </div>  
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="scrollbar" style='max-height: 400px; overflow-y: scroll; '>
                                    <ul class='numberList'>
                                        <?php
                                        if( !empty($leads) ){ foreach($leads as $lead){
                                             $stsms = $this->db->select('*')
                                                        ->from('leads_sms')
                                                        ->where('lead_id',$lead['id'])
                                                        ->order_by("id","desc")
                                                        ->get()->result();
                                            if(!empty( $stsms)){
                                                $smsg =$stsms[0]->sms_text;
                                                $sms_time =$stsms[0]->sms_time;
                                                $msg = mb_substr($smsg, 0, 70);
                                                $sms_type =$stsms[0]->sms_type;
                                             }else{
                                                 $msg=""; 
                                                $sms_time = '';
                                                }
                                        if($lead['phone'] == '') continue;
                                        if($lead['id'] == @$mlead_id){
                                                $cl = 'activeNm';
                                            }else{
                                                $cl = 'nm';
                                            }
                                        if(isset($_GET['folder'])) {
                                            $foldr = $_GET['folder'];
                                        }else{
                                            $foldr = 'unread';
                                            } ?>
                                        <li class="<?php echo $cl; ?>">
                                        <a href="<?php echo base_url();?>messenger/initchat/<?php echo encrypt_decrypt($lead['id'], 'e');?>?folder=<?php echo $foldr;?>" class="lead_no">
                                            <span class='smsl'><?php echo $lead['first_name'].'   '; echo "<small>".$lead['phone']; ?></small></span>
                                            <span class='smslr'><?php echo $msg; ?></span>
                                            <span class='smslr'><?php echo $sms_time; ?></span>
                                            </a>
                                        </li>
                                        <?php } } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8">
                            <?php if( isset($sms) ){ ?>
                                <div class="timeline profile_page_" id="timeline profile_page_" dir="ltr">
                                    <h5><i class="fe-edit-2"></i> &nbsp;Messenger </h5>
                                    <div class="card-text">
                                        <div class='chatbox scrollbar' style='max-height: 350px; overflow-y: scroll;'>
                                            <?php foreach($sms as $sKey => $sVal){
                                                    $sta = (array) App::get_row_by_where('leads', array('id'=>$sVal->lead_id) );
                                                    $day=new DateTime( $sVal->sms_time); 
                                                    $old_date = $day->format('F jS, Y h:i A');
                                                    if($sVal->read_status == 'read'){
                                                        echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>";
                                                            if($sVal->sms_type=='out'){
                                                                if(!empty($sVal->admin_id) && $sVal->admin_id !='0'){
                                                                $sentby = (array) App::get_row_by_where('user_profiles', array('user_id'=>$sVal->admin_id) );
                                                                echo "<span class='smstname sms_admin' >Sent by ".$sentby['name']." ".$old_date."</span>";
                                                                }else{
                                                                    echo "<span class='smstname sms_admin' >Sent by Automated ".$old_date."</span>";
                                                                }
                                                            }else{
                                                                 echo "<span class='smstname sms_timeout' > ".$old_date."</span>";
                                                            }
                                                        }else{
                                                            echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>";
                                                            if($sVal->sms_type=='out'){
                                                                if(!empty($sVal->admin_id) && $sVal->admin_id !='0'){
                                                                $sentby = (array) App::get_row_by_where('user_profiles', array('user_id'=>$sVal->admin_id) );
                                                                echo "<span class='smstname sms_admin' >Sent by ".$sentby['name']." ".$old_date."</span>";
                                                                }else{
                                                                    echo "<span class='smstname sms_admin' >Sent by Automated ".$old_date."</span>";
                                                                }
                                                            }else{
                                                                 echo "<span class='smstname sms_timeout' > ".$old_date."</span>";
                                                            }
                                                        }
                                                       
                                                    }?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="md-form">
                                        <div class='row'>
                                           <div class="col-md-9">
                                               <textarea id="smstext" name='smstext' class="md-textarea form-control" rows="3" required/></textarea>
                                               <input type='hidden' id="lid" name='lid' value='<?php echo $mlead_id; ?>'>
                                               <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $mnumber['phone']; ?>'>
                                            </div>
                                           <div class="col-md-3">
                                                <button type="submit" id="submit" class="btn btn-success waves-effect waves-light"><i class="fe-send"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div> <!-- end col -->
                            </div> <!-- Live chat content end -->
                        </div>
                   </div> <!-- end tab-pane -->
                </div> <!-- container -->