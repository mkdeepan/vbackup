<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Location Log</h1>
		<span class="mainDescription">List out the profiles that are scanned in user's device.</span>
	</div>
	<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Location Log</span>
		</li>
	</ol>
</div>
</section>
 <?php if($this->session->flashdata('success')) {?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->session->flashdata('success');?> 
    </div>
    <?php } else if($this->session->flashdata('failure')) {?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->session->flashdata('failure');?> 
    </div>
    <?php } ?>
<!-- end: PAGE TITLE -->
<!--<?php var_dump($feedback);?>-->

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
										<table id="sample-table-1" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Account Name</th>
													<th>Latitude</th>
													<th>Longitude</th>
													<th>Scanned Time</th>
													<th>Profiles Found</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($location_log)){
												foreach($location_log as $key=>$location){ ?>
												<tr>
												<td><?=$key+1?></td>
												<td><?php echo ($location['accountId'])?ucfirst($location['accountFirstName']).' '.$location['accountLastName']:'Anonymous';?></td>												
												<td><?=$location['latitude']?></td>												
												<td><?=$location['longitude']?></td>												
												<td><?=$location['scannedTime']?></td>												
												<td>
												<?php
												$profiles = admin_model::getProfileByLocation($location['locationLogId']);
												foreach($profiles as $key=>$pro){
													if($key)
													 echo ($pro['profileFirstName']||$pro['profileLastName'])?', '.$pro['profileFirstName'].' '.$pro['profileLastName']:', '.$pro['locationLogId'];
													else
													 echo ($pro['profileFirstName']||$pro['profileLastName'])?$pro['profileFirstName'].' '.$pro['profileLastName']:$pro['tagId'];
												} 
												?>												
												</td>												
												</tr>
											<?php } } else {
												echo "<td align='center' colspan='5'>No records found</td>";
											} ?>
											</tbody>
										</table>
										<?php echo $links; ?>
			</div>
		</div>
	</div>
</div>
</div>