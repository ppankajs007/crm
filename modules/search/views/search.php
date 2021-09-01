<div class="container-fluid">                       
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                       <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ol>
                </div>
                <h4 class="page-title">Search for <?php echo $_GET['find'];?></h4>
            </div>
        </div>
    </div><!-- end row --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="row mb-2">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                            </div>
                        </div><!-- end col-->
                    </div>

                    <section>
                        <h4>Result from Leads</h4>
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>  
                            <tbody>
                                <?php 
                                if( !empty( $searchResult['leads'] ) && is_array( $searchResult['leads'] )  ) {
                                    foreach ($searchResult['leads'] as  $data ) { 
                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$data->id; ?>"><?php echo $data->full_name;?></a></td>
                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$data->id; ?>"><?php echo $data->email;?></a></td>
                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$data->id; ?>"><?php echo $data->phone;?></a></td>
                                </tr>
                            <?php }} else{?>
                            <tr><td colspan="4">No Leads found</td></tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </section>

                    <section>
                        <h4>Result from Customer</h4>
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>  
                            <tbody>
                                <?php 
                                if( !empty( $searchResult['customer'] ) && is_array( $searchResult['customer'] )  ) {
                                    foreach ($searchResult['customer'] as  $data ) { 
                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url().'customer/dashboard/'.$data->id; ?>"><?php echo $data->full_name;?></a></td>
                                    <td><a href="<?php echo base_url().'customer/dashboard/'.$data->id; ?>"><?php echo $data->email;?></a></td>
                                    <td><a href="<?php echo base_url().'customer/dashboard/'.$data->id; ?>"><?php echo $data->phone;?></a></td>
                                </tr>
                            <?php }} else{?>
                            <tr><td colspan="4">No customer found</td></tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </section>


                    <section>
                        <h4>Result from Order</h4>
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sales</th>
                                    <th data-toggle="tooltip" data-placement="top" title="Vendor" >V</th>
                                    <th data-toggle="tooltip" data-placement="top" title="Scheduled Delivery Date/Requested Delviery Date" >SDD/RDD</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Total Due</th>
                                    <th>Is Pickup</th>
                                </tr>
                            </thead>  
                            <tbody>
                                <?php 
                                //pr( $searchResult );
                                if( !empty( $searchResult['orders'] ) && is_array( $searchResult['orders'] )  ) {
                                    foreach ($searchResult['orders'] as  $data ) { 
                                    /*if( $data->status != 'Order' ){
                                        continue;
                                    } */
                                        ( $data->subtotal ) ? $total_sub = floatval($data->subtotal) + floatval($data->delivery_price) - floatval($data->discount): $total_sub = '';
                

                ( $total_sub ) ? $pro_per = (floatval($total_sub) - floatval($data->cost_t_price))*100/floatval($total_sub): $pro_per = '0.00%'; 

                if( !empty($data->payment_amount) ){ $paid = $data->payment_amount; }else{ $paid = 0; }
                        if( !empty($data->total) ){ $totalp = $data->total; }else{ $totalp = 0; }
                        ( $data->schedule_delivery_date ) ? $sd = $data->schedule_delivery_date.'<br>': $sd = '';
                        $total_due = $totalp - $paid;
                        if( !empty($paid) && !empty($totalp) ){
                            
                            $paidN = ($total_due * 100)/$totalp;
                            $paidP = number_format((float)$paidN, 2, '.', '').'%';
                        } else {
                            $paidP = number_format((float)0, 2, '.', '').'%';
                        }
                        

                        if( $data->vendor_invoice  ){ $vIn = '#'.$data->vendor_invoice; }else{ $vIn =''; };
                        
                        $id = '<a href="'.base_url().'orders/Dashboard/'.$data->pkid.'">'.$data->pkid.'<br>'.$vIn.'</a>';

                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo empty($data->status)? 'N/A' : $data->status;?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo $data->fname;?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo empty( $data->phone )?'N/A' : $data->phone;?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo empty( $data->upname )?'N/A' : $data->upname;?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo empty( $data->vdrcode )?'N/A' : ucfirst($data->vdrcode);?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo $sd.$data->requested_delivery_date;?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo '$'.number_format($data->total,2);?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo '$'.number_format($data->payment_amount,2);?></a></td>
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo '$'.number_format($total_due,2).'<br>'.$paidP;?></a></td><!-- 
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo number_format($pro_per,2).'% P';?></a></td> -->
                            <td><a href="<?php echo base_url().'orders/Dashboard/'.$data->pkid; ?>"><?php echo empty( $data->is_pickup )? 'N/A' : ucfirst($data->is_pickup);?></a></td>
                                </tr>
                            <?php }} else{?>
                            <tr><td colspan="4">No Order found</td></tr>
                        <?php } ?>
                            </tbody>
                        </table>
                    </section>




                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div> <!-- container -->
