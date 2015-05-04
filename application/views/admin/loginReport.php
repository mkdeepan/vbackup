<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Login Report</h1>
		<span class="mainDescription">User signing-in information.</span>
	</div>
	<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Login Report</span>
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
													<th>Device Type</th>
													<th>Phone Type</th>
													<th>OS Version</th>
													<th>Model Number</th>
													<th>Latitude</th>
													<th>Longitude</th>
													<th>Time-In</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($log_report)){
												foreach($log_report as $key=>$login){ ?>
												<tr>
												<td><?=$key+1?></td>
												<td><?php echo ($login['accountId'])?ucfirst($login['accountFirstName']).' '.$login['accountLastName']:'Anonymous';?></td>												
												<td><?=$login['deviceType']?></td>												
												<td><?=$login['phoneType']?></td>												
												<td><?=$login['osVersion']?></td>												
												<td><?=$login['modelNumber']?></td>												
												<td><?=$login['latitude']?></td>												
												<td><?=$login['longitude']?></td>												
												<td><?=$login['timeIn']?></td>												
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