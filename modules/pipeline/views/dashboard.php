        <style type="text/css">
           .overview_list {
            padding: 0;
            margin: 0;
            border-bottom: 1px solid #ccc;
            float: left;
            width: 100%;
        }
            .overview_list li {
               float: left;
                margin-bottom: 9px;
                list-style: none;
            }
            .overview_list li a {
                margin-right: 2px;
                line-height: 1.42857143;
                border: 1px solid transparent;
                border-radius: 2px 2px 0 0;
                color: #428bca;
                padding: 10px 8px;
            }    
            .overview_list li.active a {
                border-bottom: 2px solid #566676;
                border-radius: 0px;
            }
            .clear {
                clear: both;
            }
            .box_outer label {
                color: #979797;
                font-size: 85%;
                margin-bottom: 0;
            }
            .box_outer h4 {
                color: #2c96dd;
                font-size: 11px;
                margin-top: 1px;
            }
           
            .box_outer h5 {
                 color: #666;
                 font-size: 18px;
            }
            .box_outer {
                text-align: center;
                border-right: 1px solid #E7E7E7;
                padding: 5px 0;
                margin-bottom: 16px;
                margin-top: 29px;

            }
            .additional_list {
                border: 2px solid #e8e8e8;
                padding: 0px 0;
                border-radius: 3px;
                margin-top: 23px;
            }
            .additional_list .panel-heading {
               background: #f5f5f5;
              padding: 10px;
              color: #000;
              font-size: 13px;
           }
           .list-group.no-radius .pull-right {
               float: right;
            }
            .additional_list ul li {
                border-left: none;
                border-radius: ;
                border-right: none;
            }
            .information_outer {

                float: left;
                width: 100%;
                height: 1px;
                width: 100%;
                background: #ddd;

            }
          .clear { clear:both; }  
.sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
.sms_out { float: right;     background-color: #1abc9c; color: #fff;}
.smst { padding: 4px 8px; border-radius: 4px;clear: both;}
.smst span{ margin-left:0px; }
.btn-success {display: block; width: 100%;}
.timeline:before {
    background-color: #dee2e6;
    bottom: 0;
    content: "";
    left: 50%;
    position: absolute;
    top: 30px;
    width: 2px;
    z-index: 0;
    display:none;
}
.side{
   float: right;
    margin-top: 14px;
}
.additional_list .panel-headings {
    background: #E3E7EC;
    padding: 10px;
    color: #000;
    font-size: 13px;
    margin-top: -29px;
}
.address {
    margin-top: 37px;
}
.add_file {
    float: right;
}
a.action-icon.create-customer.edit_butt {
    margin-left: 310px;
}
.comment-list {
    position: relative;
}

.comment-list:before {
    position: absolute;
    top: 0;
    bottom: 35px;
    left: 18px;
    width: 1px;
    background: #e0e4e8;
    content: '';
}

.comment-list .comment-item {
    margin-top: 18px;
    position: relative;
}

.text-info {
    color: #4cc0c1;
}

.comment-list .comment-item .comment-body {
    margin-left: 46px;
}

.comment-list article span.fa-stack {
    float: left;
}

.comment-list .comment-item:last-child {
    margin-bottom: 16px;
}

li.list-group-item:nth-child,
li.list-group-item:last-child {
    border: block !important;
}
        </style>

    <div class="container-fluid">   <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <?php if( empty($customer) ) return;  extract($customer); ?>
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>customer">Customers</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active"><?php echo $full_name;?></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Customers</h4>
                </div>
            </div>
        </div><!-- end row --> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="overview_list" id="lead_sub_menu">
                            <?php echo modules::run('includes/customer_submenu');?>
                        </ul>
                        <div class="clear"></div>
                        <div class="row total_list">
                            <div class="col-md-3">
                                <div class="box_outer">
                                    <label>Comming Soon</label>
                                    <h4 class="cursor-pointer text-open small">Payments</h4>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="box_outer">
                                    <label style="">Comming Soon</label>
                                    <h4 class="cursor-pointer text-open small">- Expenses</h4>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="box_outer">
                                    <label >Comming Soon</label>
                                    <h4 class="cursor-pointer text-open small" style="color:#F05050">Pending</h4>
                                    <!-- <h5><strong>  <?php// echo $rem;?>   </strong>  </h5>  -->
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="box_outer" style="border:none;">
                                    <label>Assign</label>
                                    <h4 class="cursor-pointer text-success small" style="color:#F05050">Pending</h4>
                                    <!-- <h5><strong>  <?php //echo $name;?>  </strong>  </h5>  -->
                                </div> 
                            </div>
                            <div class="information_outer"></div>
                            <div class="col-md-4">
                                <div class="additional_list">
                                    <header class="panel-heading">Details<a href="<?php echo base_url();?>customer/edit/<?php echo $this->uri->segment(3); ?>" class="add_file" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable"><i class="fe-edit-2"></i></a></header>
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right text"><?php echo $full_name;?></span>
                                            <span class="text-muted"> Customer Name </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $email;?></span>
                                            <span class="text-muted">Email </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $phone;?> </span>
                                            <span class="text-muted">Main Phone </span>
                                        </li>
                                    </ul>
                                </div>                                                
                            </div>
                            <div class="col-md-4">
                            <div class="additional_list activ">
                                <header class="panel-heading">Activities</header>
                                    <div class='slimscroll' style='max-height: 350px;'>
                                        <section class="comment-list block">
                                            <?php
                                            if( isset( $activities ) && !empty( $activities ) ) {
                                            foreach( $activities as $activity ){ ?>
                                                <article class="comment-item">
                                                    <span class="fa-stack pull-left m-l-xs"> 
                                                        <i class="fa fa-circle text-success fa-stack-2x"></i> 
                                                        <i class="fe-edit-2 text-white fa-stack-1x"></i> 
                                                    </span>
                                                    <section class="comment-body m-b-lg">
                                                        <header> 
                                                            <strong><?php echo $activity['name'] ?></strong>
                                                            <span class="text-muted text-xs"> at <?php echo $activity['activity_time'] ?> </span>
                                                        </header>
                                                            <div><?php echo $activity['activity_message']  ?></div>
                                                            <?php if( !empty($activity['old_val']) && !empty($activity['new_val'])  ){ ?>
                                                            <div> <b><?php echo $activity['old_val'] ?> =&gt; <?php echo $activity['new_val'] ?> </b></div>
                                                            <?php } ?>
                                                    </section>
                                                </article>
                                            <?php  }}?>
                                        </section>
                                    </div>
                            </div>                                                
                        </div>
                                <div class="col-md-4">
                                    <div class="additional_list">
                                        <!--<header class="panel-heading">Address <a href="<?php echo base_url();?>customer/address_ads/<?php echo $this->uri->segment(3); ?>" class="add_file" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Address</a></header>-->
                                        <?php if( isset($customer_address) ){ 
                                                $this->db->select('*');
                                                $this->db->from('customer');
                                                $this->db->join('customer_address', 'customer.id = customer_address.customer_id');
                                                $this->db->where('customer.id', $customer_address[0]->customer_id);
                                                $get =$query = $this->db->get();
                                                $cdata = $get->result('array');
                                                
                                                $bill = array_search('Billing', array_column($cdata, 'address_type'));
                                                $ship = array_search('Shipping', array_column($cdata, 'address_type'));
                                                ?>
                                                    <div class="address">
                                                        <div class="address">
                                                            <address class="panel-headings">
                                                                   <h6>Billing Address</h6>
                                                              <?php 
                                                                    if( in_array('Billing', array_column($cdata, 'address_type')) ){
                                                                        echo $cdata[$bill]['full_name']."<br>";
                                                                        if ($cdata[$bill]['addressline_one']) echo $cdata[$bill]['addressline_one'].'<br>';
                                                                        if ($cdata[$bill]['addressline_two']) echo $cdata[$bill]['addressline_two'].'<br>';
                                                                        
                                                                        echo $cdata[$bill]['state'];?>,<?php echo $cdata[$bill]['country']."<br>";
                                                                        echo '<a href="'.base_url().'customer/edit_address/'.$cdata[$bill]['id'].'/Billing" title="Edit" class="action-icon create-customer edit_butt" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a> ';
                                                                        echo '<a href="javascript:void(0);" id="deleteAddress" class="action-icon de_button" ids="'.$cdata[$bill]['id'].'" cids="'.$this->uri->segment(3).'" data-toggle="" data-placement="top" title="Delete Lead"> <i class="mdi mdi-delete"></i></a>';
                                                                    }else{
                                                                        echo '<a href="'.base_url().'customer/address_ads/'.$this->uri->segment(3).'/Billing" title="add" class="add_file" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Address</a> ';
                                                                    }
                                                                   // echo $errorAddr;
                                                                 ?>
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="address">
                                                        <address class="panel-headings">
                                                               <h6>Shipping Address</h6>
                                                            <?php 
                                                                if( in_array('Shipping', array_column( $cdata, 'address_type') ) ){
                                                                    echo $cdata[$ship]['full_name']."<br>";
                                                                    if ($cdata[$ship]['addressline_one']) echo $cdata[$ship]['addressline_one'].'<br>';
                                                                    if ($cdata[$ship]['addressline_two']) echo $cdata[$ship]['addressline_two'].'<br>';

                                                                    echo $cdata[$ship]['state'];?>,<?php echo $cdata[$ship]['country']."<br>";
                                                                    echo '<a href="'.base_url().'customer/edit_address/'.$cdata[$ship]['id'].'/Shipping" title="Edit" class="action-icon create-customer edit_butt" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a> ';
                                                                    echo '<a href="javascript:void(0);" id="deleteAddress" class="action-icon de_button" ids="'.$cdata[$ship]['id'].'" cids="'.$this->uri->segment(3).'" data-toggle="" data-placement="top" title="Delete Lead"> <i class="mdi mdi-delete"></i></a>';
                                                                }else{
                                                                    echo '<a href="'.base_url().'customer/address_ads/'.$this->uri->segment(3).'/Shipping" title="add" class="add_file" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Address</a> ';
                                                                }
                                                              ?>
                                                        </address>
                                                    </div>
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div><!-- end row-->
    </div> <!-- container -->
                  