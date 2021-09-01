<div class="content-pageee">
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box">
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url().'orders';?>">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$total_amount['customer_id']; ?>"><?= $total_amount['first_name']; ?> <?= $total_amount['last_name']; ?></a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$this->uri->segment(3); ?>">Order For <?= $total_amount['first_name']; ?> <?= $total_amount['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Payment</li>
                     </ol>
                  </div>
                  <h4 class="page-title">Payment</h4>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <ul class="overview_list" id="lead_sub_menu">   
                       <?php  echo modules::run('includes/order_sub_menu');?>
                     </ul>
                     <div class="clear"></div>
                     <br>
                     <div class="col-md-12">
                        <div class="additional_list">
                           <header class="panel-heading">Payment 
                              <?php 
                                 // if ( $total_amount['Is_Contract'] == 'yes' ) { 
                                 if ( true ) { ?>
                                 
                              <a href="<?php echo base_url()."orders/add_payment/".$this->uri->segment(3); ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i>Add Payment</a>

                           <?php } ?>

                           </header>
                           <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Payment Type</th>
                                    <th>Payment Amount</th>
                                    <th>Payment Reference Number</th>
                                    <th>Date & Time</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $sum = 0;
                                    if( !empty($payment_data) ){
                                       foreach ($payment_data as $key => $value) { ?>
                                          <tr>
                                             <td><?= $value['id'] ?></td>
                                             <td><?= $value['payment_method'] ?></td>
                                             <td><?php if ( $value['payment_amount'] ) echo '$'. number_format($value['payment_amount'],2); ?></td>
                                             <td><?= $value['reference_no'] ?></td>
                                             <td><?php $timestamp = strtotime($value['created_date']);
                                                      echo $newDate = date('m-d-Y h:i a', $timestamp);
                                                 ?>
                                             </td>
                                             <td>
                                                <a href="<?= base_url(); ?>orders/edit_payment/<?= $value['id'] ?>" title="Edit" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>
                                                   <a href="javascript:void(0);" title="Delete" id="deletepayment" class="action-icon" style="color:#808080 !important" ids="<?= $value['id'] ?>" data-order="<?= $value['order_id'] ?>" > 
                                                      <i class="mdi mdi-delete"></i>
                                                </a>
                                             </td>
                                          </tr>
                                    <?php
                                       $sum += $value['payment_amount'];
                                        }
                                     
                                    } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <br>
                     <?php if( !empty($payment_data) ){ ?>
                        <div class="row">
                           <div class="col-md-6"></div>
                           <div class="col-md-6">
                              <div class="float-right">
                                 <p><b>Paid:</b><span class="float-right"> &nbsp;&nbsp;&nbsp; 
                                    $<?= number_format($sum,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                 </p>
                                 <?php ( $total_amount['total'] )? $total =  $total_amount['total'] - $sum: $total = $sum; ?>
                                 <p><b>Total Due:</b><span class="float-right"> &nbsp;&nbsp;&nbsp; 
                                    $<?= number_format($total,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                 </p>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>