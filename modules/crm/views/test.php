      <div class="content-page">
                <div class="content">
     <div class="col-xl-4">
     <?php    if( empty($leads) ) return;;
                extract($leads);
               $name= @$first_name.' '.@$last_name;  ?>
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Chat</h4>

                                    <div class="chat-conversation">
                                        <ul class=" chatbox conversation-list slimscroll" style="max-height: 350px;">
 <?php     foreach($lsms as $sKey => $sVal){?>
                                            <li class="clearfix">
                                                <!-- <div class="chat-avatar">
                                                    <img src="assets/images/users/user-5.jpg" alt="male">
                                                    <i>10:00</i>
                                                </div> -->
                                                <div class="conversation-text">

                                                    <div class="ctext-wrap">
                                                    <i>John Deo</i>
                          <?php  echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>";?>
                       
                                                        <i>John Deo</i>
                                                        <p>
                                                            Hello!
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }?>
                                           
                                        </ul>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control chat-input"value='<?php echo $id; ?>'
                                                 placeholder="Enter your text">
                                                  <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $phone; ?>'>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" id="submit" class="btn btn-danger chat-send btn-block waves-effect waves-light">Send</button>
                                            </div>
                                        </div>
                                    </div> <!-- .chat-conversation -->
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
                        </div></div>