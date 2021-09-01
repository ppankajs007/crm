<div class="content-pageee">
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box">
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>orders">Orders</a></li>
                        <li class="breadcrumb-item"><a href=" <?php echo base_url()."orders/".$this->uri->segment(4); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Order</li>
                     </ol>
                  </div>
                  <h4 class="page-title">Expenses</h4>
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
                        <?php
                           if( !empty($expenses_data) ){ 
                        ?>
                        <div class="additional_list">
                              <header class="panel-heading">Expenses <a href="<?php echo base_url()."orders/add_expenses/".$this->uri->segment(3); ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i>Add Expenses</a></header>
                              <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                 <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Payee</th>
                                       <th>Payment Date</th>
                                       <th>Payment Method</th>
                                       <!-- <th>Category</th> -->
                                       <th>Total</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $i = 1;
                                       foreach ($expenses_data as $key => $value) { 
                                           
                                          $catogery = unserialize( $value['category_meta'] );
                                           ?>
                                          <tr>
                                             <td><?= $i; ?></td>
                                             <td><?= ucfirst($value['payee']); ?></td>
                                             <td><?= $value['payment_date']; ?></td>
                                             <td><?= ucfirst($value['payment_method']); ?></td>
                                             <!-- <td><select class="form-control"> 
                                                    <?php foreach ($catogery as $catkey => $catvalue) { 
                                                         $query = $this->db->select( 'catogery_title' )
                                                                  ->from( 'expenses_category' )
                                                                  ->where( 'id',$catvalue['cat']  )
                                                                  ->get()->result_array();
                                                      ?>
                                                 <option><?= $query[0]['catogery_title']; ?></option>
                                             <?php } ?>
                                             </select>
                                             </td> -->
                                             <td><?= '$'.$value['total']; ?></td>
                                             <td>
                                                <a href="<?= base_url(); ?>orders/edit_expenses/<?= $value['id'] ?>" title="Quick Edit" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:void(0);" title="Delete" id="deleteexpenses" class="action-icon" style="color:#808080 !important" ids="<?= $value['id'] ?>" data-order="<?= $value['order_id'] ?>" > 
                                                   <i class="mdi mdi-delete"></i>
                                                </a>
                                             </td>
                                          </tr>
                                    <?php
                                       $i++;  
                                       }

                                     ?>
                                 </tbody>
                              </table>
                           </div>
                     <?php } else { ?>

                        <div class="card-box" style="text-align: center;">
                            <h2 class="header">Expenses</h2>
                            <h3 class="sub-header">
                                Track your expenses to see how you spend your money
                            </h3>

                            <a href="<?php echo base_url()."orders/add_expenses/".$this->uri->segment(3); ?>" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i>Add Expenses</a>

                            <div class="clearfix"></div>
                        </div>

                     <?php }   ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>