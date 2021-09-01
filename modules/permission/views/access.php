<?php session_start();?>

<div class="row">
  <div class="col-md-12 view_header">
     <!--   <a href="<?php echo base_url(); ?>users/groups/add_dept/redirect" data-toggle="ajaxModal" class="btn btn-sm btn-primary pull-right m-r"><i class="fa fa-plus"></i> Add group</a> 
     	<p>Group</p> -->
  </div>
</div>

<!-- <section id="content">
          <section class="hbox stretch">
            
            <aside>
              <section class="vbox">
               <header class="header bg-white b-b b-light">
               	 <a href="<?php echo base_url(); ?>users/groups/add_dept" data-toggle="ajaxModal" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add group</a> 

                <p>Access</p>
                 
                </header>
                 -->

                <section class="scrollable wrapper">              
					<section class="panel panel-default dataTables_length">
						<?php get_work_block($workspaces,$workspace_id, $projects, $project_id); ?>

<?php
if( !$workspace_id OR !$project_id ) { }
else {
?>
<?php if ( $this->applib->has_permission( 'access','access','edit_access' ) ) { ?>

				<div class="clear"></div>
					<div class="row">
						<div class="col-sm-12">

							<form class="form-inline" data-validate="parsley" action="<?php echo base_url()?>permission/access/add_user" method="post">
								
							<input type="hidden" name="workspace_id" value="<?php echo $workspace_id; ?>" >
							<input type="hidden" name="project_id" 	 value="<?php echo $project_id; ?>"   >

							<div class="form-group col-sm-6">
								<label for="">Users</label>
							   <select id="" class="select2-option" parsley-validated data-required="true" multiple="multiple" style="width:260px" name="selected_users[]" >
							   	
					    			<?php
				                        if (!empty($all_users)) 
				                        {
				                            foreach ($all_users as $user) 
			                            	{ ?>
			                                	
			                                	<option value="<?=$user->id?>">
													<?php echo ucfirst($user->fullname); ?>                    				
	                                			</option>
			                				<?php 		
			                				} 		
				            			} 
				            		?>
					    		</select>
					    		
					    		<br>
					    		<br>

								<button type="submit" class=" col-sm-offset-2 btn btn-md btn-primary">
									<i class="fa fa-plus"></i> Add users
								</button>
							</div>
							</form>

							<div class="form-group col-sm-offset-1 col-sm-5">
								<form  data-validate="parsley"  class="form-inline" action="<?php echo base_url()?>permission/access/add_group" method="post">
								
									<input type="hidden" name="workspace_id" value="<?php echo $workspace_id; ?>" >
									<input type="hidden" name="project_id" 	 value="<?php echo $project_id; ?>"   >
									<label for="">Groups</label>
									<select id="" class="select2-option" parsley-validated data-required="true" multiple="multiple" style="width:260px" name="selected_groups[]" >
						    			<?php
					                        if (!empty($all_groups)) 
					                        {
					                            foreach ($all_groups as $group) 
				                            	{ ?>
				                                	
				                                	<option value="<?=$group->group_id?>">
														<?php echo ucfirst($group->name); ?>                    				
		                                			</option>
				                				<?php 		
				                				} 		
					            			} 
					            		?>
						    		</select>
						    		
						    		<br>
						    		<br>

									<button type="submit" class=" col-sm-offset-2 btn btn-md btn-primary">
										<i class="fa fa-plus"></i> Add users group
									</button>

								</form>
							</div>
					</div>
				</div>
<?php } ?>
<?php } ?>
			</section>



                  <div class="row"  style="min-height:294px;" >			
				<div class="col-lg-12">

					<section class="panel panel-default panel-body">

<?php
if(!$workspace_id) { echo '<h6>Please choose the <span class="text-danger">Workspace</span> first!</h6>'; }
else if(!$project_id) { echo '<h6>Please choose the <span class="text-danger">Project</span> first!</h6>'; }
else {
?>

						<div class="table-responsive">
							<table id="user_access" class="table table-striped m-b-none">
								<thead>
									<tr>
										<th><?=lang('full_name')?></th>	
										<th><?=lang('username')?> </th>
										<th>Email </th>
										<th>Role</th>
										<th class="text-center">Access</th>
										<th class="text-center">Action </th>
									</tr> 
								</thead>
							<tbody>
								<?php
								
								if (!empty($users)) {
								foreach ($users as $user) { ?>
														<tr>
														
										<td><?=$user->fullname?></td>
										
										<td><?=ucfirst($user->username)?></td>
										
										<td>
											<?= $user->email ;?>
										</td> 
										
										<td>
											<span><?=ucfirst($this->user_profile->role_by_id($user->role_id))?></span>
										</td>

										<td class="text-center">
						                    <ul class="list-group no-radius " style="list-style-type: none;     width: 100px;">
					                           <li class="change_access">                                        
						                            <!-- <a adclass="btn-warning"   status="0"  accessid="<?=$user->access_id; ?>" class="btn btn-xs <?php echo $user->access == '0' ? 'btn-warning'    : 'btn-default' ?> "  title="View"  >        <i class="fa ">V</i></a>
					                                <a adclass="btn-success"   status="1"  accessid="<?=$user->access_id; ?>" class="btn btn-xs <?php echo $user->access == '1' ? 'btn-success'    : 'btn-default' ?> "  title="Edit"  >  <i class="fa ">E</i></a> -->
<?php if ( $this->applib->has_permission( 'access','access','permissions' ) ) { ?>					                                
					                                <a href="<?=base_url()?>permission/access/permissions/<?=$user->id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="Permisssions"><i class="fa fa-lock"></i> </a>
<?php } ?>					                                
					                            </li>
					                        </ul>
										</td>
										
										<td class="text-center">
<?php if ( $this->applib->has_permission( 'access','access','edit_access' ) ) { ?>
											<a href="<?=base_url()?>permission/access/delete_user/<?=$workspace_id.'/'.$project_id.'/'.$user->access_id?>" class="btn btn-danger btn-xs" data-toggle="ajaxModal" title="Remove"><i class="fa fa-trash"></i></a>
<?php } ?>											
										</td>
										
										</tr>
														<?php } } ?>
														
														
								</tbody>
							</table>
						</div>
<?php } ?>						
					</section>
				</div>
			</div>
			<?php company_footer(); ?>
                </section>
              <!-- </section> -->
            <!-- </aside> -->
            <!-- /.aside -->



          
          <!-- </section> -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
          
<!--     <div id="loader_stories" class="loader_stories" >
      <div  class="loader_block">
        <p>Processing</p>
        <p class=""><i class="fa fa-spinner fa fa-spin fa fa-2x"></i></p>
      </div>
    </div> -->

        <!-- </section> -->
<script type="text/javascript">



</script>
