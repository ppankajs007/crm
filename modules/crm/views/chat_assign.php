    <div class="container-fluid"> <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                            <li class="breadcrumb-item active">Un-Assign Chat</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Un-Assign Chat</h4>
                </div>
            </div>
        </div>  <!-- end page title --> 
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                          <table id="scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                                <th>Agent Name</th>
                                                <th>Recent Message</th>
                                                <th>Action</th>
                                            </tr>
                                    </thead>
                                <tbody>
                                    <?php   $myArray = json_decode(json_encode($live_chats), true); 
                                        if(!empty( $myArray ) ){
                                           foreach ($myArray as $key){ 
                                          $last_chat = $this->db->select('*')
                                                                ->from('live_chat')
                                                                ->where('id',$key['id'])
                                                                ->order_by("id","desc")
                                                                ->get()->result();
                                                                $smsg =$last_chat[0]->ready_chat;
                                                                $msg = substr($smsg, 0, 70);
                                                                $pieces = explode(' ', $smsg);
                                              $last_word = array_pop($pieces);?>
                                        <tr>
                                            <td><?php echo $key['id']; ?> </td>
                                            <td> <?php
                                                $chat_message = json_decode($key['agent_data'], true);
                                                if(!empty( $chat_message)){
                                                foreach ($chat_message as $key1) { ?>
                                                    <h5 class="mt-0 mb-1"><a href="<?php echo base_url();?>crm/leads/chat_record/<?php echo $key['id']; ?>" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><?php echo $key1['name']; ?></a></h5>
                                                     <p><?php echo $key1['email']; ?></p>    
                                                      <?php } }?></td>
                                            <td><?php echo  $last_word; ?></td>
                                            <td><a href="<?php echo base_url()."crm/leads/add_assign_chat/".$key['id']; ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i>Assign Lead</a></td>
                                        </tr>
                                            <?php   }}?>
                                    </tbody>
                                </table>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div><!-- end row-->
            </div> <!-- container -->