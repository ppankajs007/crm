<?php
    $id = $this->uri->segment(4);
    $activeMenu = $this->router->fetch_method(); 
    $activeDashboard = $activeNote = $activeFiles =  $activechat = $activesurvey = $activeForm = $task = '';
        if( $activeMenu == 'dashboard' ){
            $activeDashboard = 'active';
        }
        elseif($activeMenu == 'files'){
            $activeFiles = 'active';
        }
        elseif($activeMenu == 'survey'){
            $activesurvey = 'active';
        }
        elseif($activeMenu == 'notes'){
            $activeNote = 'active';
        }
        elseif($activeMenu == 'chats'){
            $activechat = 'active';
        }
        elseif($activeMenu == 'QualifiedForm'){
            $activeForm = 'active';
        }
        elseif($activeMenu == 'get_task'){
            $task = 'active';
        }
        else{
            $activeDashboard = 'active';
        } 
?>
    <li class="<?php echo $activeDashboard;?>"><a href="<?php echo base_url()?>crm/Qualified/dashboard/<?php echo $id; ?>">Overview</a></li>
    <li class="<?php echo $activeFiles;?>"><a href="<?php echo base_url()?>crm/Qualified/files/<?php echo $id; ?>">Files</a></li>
    <li class="<?php echo $activeNote;?>"><a href="<?php echo base_url()?>crm/Qualified/notes/<?php echo $id; ?>">Notes</a></li>
    <li class="<?php echo $activechat;?>"><a href="<?php echo base_url()?>crm/Qualified/chats/<?php echo $id; ?>">Live Chat</a></li>
    <li class="<?php echo $activesurvey;?>"><a href="<?php echo base_url()?>crm/Qualified/survey/<?php echo $id; ?>">Survey</a></li>
    <li class="<?php echo $activeForm;?>"><a href="<?php echo base_url()?>crm/Qualified/QualifiedForm/<?php echo $id; ?>">Kitchen Details</a></li>
    <li class="<?php echo $task;?>"><a href="<?php echo base_url()?>crm/Qualified/get_task/<?php echo $id; ?>">Task</a></li>
