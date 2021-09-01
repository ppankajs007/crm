<section id="content">
          <section class="hbox stretch">
            <!-- .aside -->
            <aside>
              <section class="vbox">
               <header class="header bg-white b-b b-light">
				  <a href="<?=base_url()?>permission/module/add" class="btn btn-sm btn-primary pull-right" data-toggle="ajaxModal" ><i class="fa fa-plus"></i><?=lang('new_permission')?> </a> 
                  
                  <p><?=lang('permission')?></p>
                </header>
                <section class="scrollable wrapper">

                  <div class="row">			
				<div class="col-lg-12">
					<section class="panel panel-default">

						<div class="table-responsive">
							<table id="clients" class="table table-striped m-b-none AppendDataTables">
								<thead>
									<tr>
									<th><?=lang('name')?></th>	
									<th><?=lang('description')?> </th>
									<th><?=lang('options')?></th>
									</tr> </thead> <tbody>
			<?php
			if (!empty($permissions)) {
			foreach ($permissions as $key => $user) { ?>
									<tr>
									
									<td><?=$user->name?></td>
									<td><?=ucfirst($user->description)?></td>
									
					<td>
					<a href="<?=base_url()?>permission/module/update/<?=$user->permission_module_id?>" class="btn btn-default btn-xs" data-toggle="ajaxModal" title="<?=lang('edit')?>"><i class="fa fa-edit"></i> </a>
					<?php
					if ($user->username != $this->tank_auth->get_username()) { ?>
					<a href="<?=base_url()?>permission/module/delete/<?=$user->permission_module_id?>" class="btn btn-primary btn-xs" data-toggle="ajaxModal" title="<?=lang('delete')?>"><i class="fa fa-trash-o"></i></a>
					<?php } ?>
					</td>
									</tr>
									<?php } } ?>
									
									
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>

                </section>
              </section>
            </aside>
            <!-- /.aside -->
            
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
        </section>

