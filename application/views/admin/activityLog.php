<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Activity Log</h1>
		<span class="mainDescription">Activities performed by user's.</span>
	</div>
	<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Activity Log</span>
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
													<th>Activity</th>
													<th>Time</th>											
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($activity_log)){
												foreach($activity_log as $key=>$act){ ?>
												<tr>
												<td><?=$key+1?></td>
												<td><?php echo ($act['accountId'])?ucfirst($act['accountFirstName']).' '.$act['accountLastName']:'Anonymous';?></td>																							
												<td><?php
												switch($act['title']) {
													case 'scan':
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has performed scan operation.';
													 break;
													case 'personal':
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has updated his personal information.';
													 break;
													case 'signing':
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has updated his signing information.';
													 break;
													case 'infoshare':
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has updated <b>'.common_model::getProfileById($act['profileId']).'</b> information sharing.';
													 break;	
													case 'allergy':
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has updated <b>'.common_model::getProfileById($act['profileId']).'</b> allergy details.';
													 break;		
													case 'profile':
													if($act['action']=='update'){													
													 echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has updated <b>'.common_model::getProfileById($act['profileId']).'</b> profile details.';
													 break;		
												   }else{
												    echo ucfirst($act['accountFirstName']).' '.$act['accountLastName'].' has added a new profile named <b>'.common_model::getProfileById($act['profileId']).'</b>.';
													 break;
												   }								
												}
												?></td>	
												<td><?=$act['activityTime']?></td>																					
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