<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">View Message</h4>
    <div class="custom-modal-text text-left">
        <?php 
        $cm = json_decode( $leads['chat_mesage'],true );
        foreach ($cm as $cmkey => $cmval){
            $smstime = date('Y/m/d h:i:s', $cmval['timestamp']);
            echo '<p class="sms">['.$smstime.'] &nbsp; <strong>'.$cmval['author_name'].'</strong> : '.$cmval['text'].'</p>';
        } 
       ?>
    </div>
</div>

