<?php
    $id = $this->uri->segment(3);
    $activeMenu = $this->router->fetch_method(); 
    $activeDashboard = $activeNote = $activeFiles = $activeCustomerLead =  $activechat = '';
    if( $activeMenu == 'dashboard' ){
	    $activeDashboard = 'active';
    }
    elseif($activeMenu == 'files'){
	    $activeFiles = 'active';
    }
    elseif($activeMenu == 'customer_lead'){
	    $activeCustomerLead = 'active';
    }
    elseif($activeMenu == 'notes'){
	    $activeNote = 'active';
    }
    elseif($activeMenu == 'chats'){
	    $activechat = 'active';
    }
    else{
	    $activeDashboard = 'active';
    } 
?>
    <li class="<?php echo $activeDashboard;?>"><a href="<?php echo base_url()?>customer/dashboard/<?php echo $id; ?>">Overview</a></li>
    <li class="<?php echo $activeFiles;?>"><a href="<?php echo base_url()?>customer/files/<?php echo $id; ?>">Files</a></li>
    <li class="<?php echo $activeCustomerLead;?>"><a href="<?php echo base_url()?>customer/customer_lead/<?php echo $id; ?>">Customer Lead</a></li>
    <li class="<?php echo $activeNote;?>"><a href="<?php echo base_url()?>customer/notes/<?php echo $id; ?>">Notes</a></li>
    <li class="<?php echo $activechat;?>"><a href="<?php echo base_url()?>customer/chats/<?php echo $id; ?>">Live Chat</a></li>
