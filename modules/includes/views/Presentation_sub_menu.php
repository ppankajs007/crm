<?php
    $id = $this->uri->segment(4);
    $activeMenu = $this->router->fetch_method(); 
    $activeDashboard = $activeNote = $activeFiles =  $activechat = $activesurvey = $activeForm = $task = '';
    if( $activeMenu == 'dashboard' ){
        $activeDashboard = 'active';
    }elseif($activeMenu == 'files'){
        $activeFiles = 'active';
    }elseif($activeMenu == 'survey'){
        $activesurvey = 'active';
    }elseif($activeMenu == 'notes'){
        $activeNote = 'active';
    }elseif($activeMenu == 'chats'){
        $activechat = 'active';
    }elseif($activeMenu == 'KitchenDetail'){
        $activeForm = 'active';
    }elseif($activeMenu == 'get_task'){
        $task = 'active';
    }else{
        $activeDashboard = 'active';
    } 
?>
    <li class="<?php echo $activeDashboard;?>"><a href="<?php echo base_url()?>crm/Presentation/dashboard/<?php echo $id; ?>">Overview</a></li>
    <li class="<?php echo $activeFiles;?>"><a href="<?php echo base_url()?>crm/Presentation/files/<?php echo $id; ?>">Files</a></li>
    <li class="<?php echo $activeNote;?>"><a href="<?php echo base_url()?>crm/Presentation/notes/<?php echo $id; ?>">Notes</a></li>
    <li class="<?php echo $activechat;?>"><a href="<?php echo base_url()?>crm/Presentation/chats/<?php echo $id; ?>">Live Chat</a></li>
    <li class="<?php echo $activesurvey;?>"><a href="<?php echo base_url()?>crm/Presentation/survey/<?php echo $id; ?>">Survey</a></li>
    <li class="<?php echo $activeForm;?>"><a href="<?php echo base_url()?>crm/Presentation/KitchenDetail/<?php echo $id; ?>">Kitchen Details</a></li>
    <li class="<?php echo $task;?>"><a href="<?php echo base_url()?>crm/Presentation/get_task/<?php echo $id; ?>">Task</a></li>
