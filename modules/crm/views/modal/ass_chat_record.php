<div class="modal-demo">
<button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">View Message</h4>
        <div class="custom-modal-text text-left">
            <?php 
            // echo "<pre>";
            // print_r($leads);
            // echo "</pre>";

            $cm = json_decode( $leads[0]['chat_mesage'],true );
            foreach ($cm as $cmkey => $cmval){
                
                 $pieces = explode(' ', $cmval['text']);
                $last_word = array_pop($pieces);
                $smstime = date('Y/m/d h:i:s', $cmval['timestamp']);
                echo '<p class="sms">['.$smstime.'] &nbsp; <strong>'.$cmval['author_name'].'</strong> : '.$last_word.'</p>';
           } ?>
        </div>
</div>

