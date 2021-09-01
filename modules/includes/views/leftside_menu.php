<?php
    $mainController = $this->uri->segment(1);
    $Lauth = $Lcrm = $Lmessenger = $Ldepartment = $Lrole = $Lpermission = $Lvendor = $Task =  $livechat = $Dlead = '';
    $Lcategory = $Lstyle = $Lcustomer = $Lorder = $Lquote = $Lproduct = '';
        
        switch ( $mainController ){
            case 'auth':
                $Lauth = 'active';
                break;
            case 'crm':
                $Lcrm = 'active';
            break;
            case 'messenger':
                $Lmessenger = 'active';
            break;
             case 'department':
                $Ldepartment = 'active';
            break;
            case 'role':
                $Lrole = 'active';
            break;
            case 'permission':
                $Lpermission = 'active';
            break;
            case 'vendor':
                $Lvendor = 'active';
            break;
            case 'category':
                $Lcategory = 'active';
            break;
            case 'style':
                $Lstyle = 'active';
            break;
            case 'customer':
                $Lcustomer = 'active';
            break;
            case 'orders':
                $Lorder = 'active';
            break;
            case 'product':
                $Lproduct = 'active';
            break;
            case 'task':
                $Task = 'active';
            break;
            case 'livechat':
                $livechat = 'active';
            break;
            case 'dlead':
                $Dlead = 'active';
            break;
            case 'pipeline':
                $pipeline = 'active';
                break;
            
            // case 'revision':
            //     $revision = 'active';
            // break;
            
        }
    $leadController = $this->uri->segment(2);
    $Lleads = $LPWleads = $LMRleads = $LQualified = $LPresentation = $LDuplicate = $new_product = $pipeline = $fabOrders = '';
    
    $leadSubController = $this->uri->segment(3);
    $get_revision = $revision = '';
    
    if (!empty( $this->uri->segment(2) )) {
           
            switch ( $leadController ){
            case 'leads':
                $Lleads = 'active';
            break;
            case 'PWleads':
                $LPWleads = 'active';
            break;
            case 'MRLeads':
                $LMRleads = 'active';
            break;
            case 'Qualified':
                $LQualified = 'active';
            break;
            case 'Presentation':
                $LPresentation = 'active';
            break;
             case 'Duplicate':
                $LDuplicate = 'active';
            break;
            case 'new_product':
                $new_product = 'active';
            break;
            case 'fabOrders':
                $fabOrders = 'active';
            break;
            case 'quote_orders':
                $Lquote = 'active';
            break;
        }
    }
    if( !empty( $this->uri->segment(3) ) ) {
        switch ( $leadSubController ){
            case 'get_revision':
                $get_revision = 'active';
            break;
            
            case 'revision':
                $revision = 'active';
            break;
          }
    }
   
?>
<style>
        .custombox-content > * {
        overflow:auto;
        
        }
        fieldset {
        min-width: unset;
        border: 1px solid #ededed;
        padding: 0 10px;
        margin: 4px 0;
        margin-bottom: 4px;
        background: #f8f8f8;
        margin-bottom: 20px;
        }
        fieldset legend{
        width: auto;
        font-size: 17px;
        color: #717171;
        font-weight: 400;
        }
        fieldset textarea{
        
        resize:none;
        }
/*li.list-group-item:nth-child(1),li.list-group-item:last-child {*/
/*    border: none !important;*/
/*}*/
        .boder.change a.add-more {
        cursor: pointer;
        color:#6658dd;
        }
        ul.lead_list {
        margin: 14px 0 0px;
        padding: 0;
        }
        ul.lead_list li:last-child {
        float: right;
        margin: 0;
        width:auto;
        }
        ul.lead_list li span.select2.select2-container {
        width: auto !important;
        min-width: 100%;
        }
        ul.lead_list li li {
        margin-bottom: 0;
        width:auto;
        }
        ul.lead_list li:last-child .btn {
        float: left;
        margin-top: 27px;
        margin-right: 0 !important;
        }
        select.js-example-basic-multiple.form-control option {
        display: none !important;
        }
        select.js-example-basic-multiple.form-control{
        height:38px !important;
        overflow:hidden;
        }
        ul.lead_list.assign_list {
        display: flex;
        }
        .select2-selection.select2-selection--multiple{
        overflow-y: unset;
        }
        .ad_space_ form#form {
        padding: 15px 15px;
        }
        .notes_form form#form {
        padding: 10px;
        }
        .update_btn {
        margin-top: 10px;
        }
        .additional_list form#form {
        padding: 12px;
        }
</style>
<div class="slimscroll-menu"> <!--- Sidemenu -->
    <div id="sidebar-menu">
        <ul class="metismenu" id="side-menu">
            <li class="menu-title">Navigation</li>
            <li>
                <a href="<?php echo base_url()?>dashboard">
                    <i class="fe-airplay"></i>
                    <span>Dashboard</a></span>
                </a>
            </li>
            <li class="<?php $Lauth ?>" >
                <a href="javascript: void(0);">
                    <i class="fas fa-user-friends"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                    </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                            </li>
                            <li class="<?php $Lauth ?>" >
                            <a class="<?php $Lauth ?>" href="<?php echo base_url()?>auth">Manage Users</a>
                            </li>                                                                       
                        </ul>
                    </li>
                    <li class="<?php echo $Lcrm; ?>" >
                    <a class="<?php echo $Lcrm; ?>" href="javascript: void(0);">
                        <i class="fe-crosshair"></i>
                        <span>Leads</span>
                        <span class="menu-arrow"></span>
                    </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lleads ?>" >
                                <a href="<?php echo base_url()?>crm/leads">Manage Leads</a>
                            </li>
                            <li class="<?php echo $LPWleads ?>" >
                                <a  href="<?php echo base_url()?>crm/PWleads">Paperwork Pending</a>
                            </li>
                            <li class="<?php echo $LMRleads ?>" >
                                <a href="<?php echo base_url()?>crm/MRLeads">Measurement Required</a>
                            </li>
                            <!--<li class="<?php //echo $LQualified ?>" >-->
                            <!--    <a href="<?php //echo base_url()?>crm/Qualified">Qualified Leads</a>-->
                                <li class="<?php echo $LQualified ?>">
                                    <a href="javascript: void(0);" aria-expanded="false">Qualified
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul class="nav-third-level nav" aria-expanded="false">
                                        <li class="<?php echo $LQualified ?>">
                                            <a href="<?php echo base_url()?>crm/Qualified">Qualified Leads</a>
                                        </li>
                                        <li class="<?php echo $revision ?>">
                                            <a href="<?php echo base_url()?>crm/Qualified/revision">Revision Leads</a>
                                        </li>
                                    </ul>
                                </li>
                            <!--</li>-->
                            <!--<li class="<?php //echo $LPresentation ?>" >-->
                            <!--    <a href="<?php// echo base_url()?>crm/Presentation">Presentation Leads</a>-->
                            <!--</li>-->
                            <li>
                                <a href="javascript: void(0);" aria-expanded="false">Presentation
                                    <!--<span class="menu-arrow"></span>-->
                                </a>
                                <ul class="nav-third-level nav" aria-expanded="false">
                                    <li class="<?php echo $LPresentation ?>">
                                        <a href="<?php echo base_url()?>crm/Presentation">Presentation Leads</a>
                                    </li>
                                    <li class="<?php echo $get_revision ?>">
                                        <a href="<?php echo base_url()?>crm/Presentation/get_revision">Revision Leads</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="<?php echo $LDuplicate ?>" >
                                <a href="<?php echo base_url()?>crm/duplicate/duplicate_lead">Duplicate Leads</a>
                            </li>
                            <li class="<?php echo $pipeline ?>" >
                                <a href="<?php echo base_url()?>pipeline">Pipeline</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo  $Lmessenger ?>" >
                    <a class="<?php echo $Lmessenger ?>" href="<?php echo base_url()?>messenger/initchat?folder=unread">
                        <i class="fas fa-sms"></i><span>Messenger</span>
                    </a>
                    </li>
                    <li class="<?php echo $Lcustomer ?>" >
                        <a class="<?php echo $Lcustomer ?>"  href="javascript: void(0);">
                            <i class="fe-briefcase"></i>
                            <span>Customers</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lcustomer ?>" >
                                <a href="<?php echo base_url()?>customer">Manage Customers</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Lorder ?>" >
                        <a class="<?php echo $Lorder ?>"  href="javascript: void(0);">
                            <i class="fa fa-cart-arrow-down"></i>
                            <span>Orders</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <?php if($Lquote){$Lorder = ''; } ?>
                            <li class="<?php echo $Lquote ?>" >
                                <a href="<?php echo base_url()?>orders/quote_orders">Manage Quotes</a>
                            </li>
                            <li class="<?php echo $Lorder ?>" >
                                <a href="<?php echo base_url()?>orders">Manage Orders</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php $Lvendor ?>" >
                        <a class="<?php echo $Lvendor ?>" href="javascript: void(0);">
                            <i class="fe-users"></i>
                            <span>Vendors</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php $Lvendor ?>" >
                                <a href="<?php echo base_url()?>vendor">Manage Vendors</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Ldepartment ?>" >
                        <a class="<?php $Ldepartment ?>" href="javascript: void(0);">
                            <i class="fe-users"></i>
                            <span>Departments</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php $Ldepartment ?>" >
                                <a href="<?php echo base_url()?>department">Manage Departments</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Lrole ?>" >
                        <a class="<?php $Lrole ?>" href="javascript: void(0);">
                            <i class="ti-id-badge"></i>
                            <span>Roles</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <a class="<?php $Lrole ?>" href="<?php echo base_url()?>role">Manage Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Lpermission ?>" >
                        <a class="<?php $Lpermission ?>" href="javascript: void(0);">
                            <i class="fe-lock"></i>
                            <span>Permissions</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lpermission ?>" >
                                <a href="<?php echo base_url()?>permission">Manage Permissions</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Lcategory ?>" >
                        <a class="<?php echo $Lcategory ?>" href="javascript: void(0);">
                            <i class="fe-list"></i>
                            <span>Category</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lcategory ?>" >
                                <a href="<?php echo base_url()?>category">Manage Category</a>
                            </li>
                        </ul>
                    </li>
                     <li class="<?php echo $Lstyle ?>" >
                        <a href="javascript: void(0);">
                            <i class="fe-users"></i>
                            <span>Style</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lstyle ?>" >
                                <a href="<?php echo base_url()?>style">Manage Style</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Task ?>" >
                        <a class="<?php echo $Task ?>"  href="javascript: void(0);">
                           <i class="fas fa-tasks"></i>
                            <span>Task</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Task ?>" >
                                <a href="<?php echo base_url()?>task">Manage Task</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $livechat ?>" >
                        <a class="<?php echo $livechat ?>"  href="javascript: void(0);">
                           <i class="fab fa-rocketchat"></i>
                            <span>Un-Assign Chat</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $livechat ?>" >
                                <a href="<?php echo base_url()?>crm/leads/assign_livechat">Manage Un-Assign</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo $Lproduct ?>" >
                        <a href="javascript: void(0);">
                            <i class="fe-shopping-cart"></i>
                            <span> eCommerce </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="<?php echo $Lproduct ?>">
                                <a href="<?php echo base_url()?>product">Products</a>
                            </li>
                            <li class="<?php echo $new_product ?>">
                                <a href="<?php echo base_url()?>product/new_product">New Products</a>
                            </li>
                        </ul>
                    </li>
      
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>