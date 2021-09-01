
<div class="container-fluid">    <!-- start page title -->
	<div class="row">
	    <div class="col-8">
	        <div class="page-title-box">
	            <h4 class="page-title">Reporting</h4>
	            <!-- <div class="page-title-right">
	                <ol class="breadcrumb m-0">
	                    <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
	                    <li class="breadcrumb-item active">Reporting</li>
	                </ol>
	            </div> -->
	        </div>
	    </div>
		<div class="col-4">
			<?php $type =  $this->uri->segment(1);
				echo form_open($type, array('id'=>'date_filter', 'method' => 'get')); ?>
					
					<div class="form-group row">
	                    <label for="daterange" class="col-3 col-form-label">Date Range</label>
	                    <div class="col-9">
	                    	<input type="text" class="form-control" id="daterange" name="daterange" />
	                    </div>
	                </div>

			<?php echo form_close(); ?>
		</div>
	</div>
	
	<div class="row">
	    <div class="col-12">
			<div class="card-box">
				<div id="campaignReport"></div>
		   	</div>
		</div> 
	</div>    
	<div class="row">
	    <div class="col-6">
	        <div class="card-box">
	        	<div id="campaignPieVar"></div>
	        </div>
	    </div>
	    <div class="col-6">

	        <div class="card-box">
	        	<div id="campaignPie"></div>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-12">
	        <div class="card-box">
	        	<div id="growthChart"></div>
	        </div>
	    </div>
	</div>
</div>