<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Feedback</h1>
		<span class="mainDescription">Client's feedback over the current site.</span>
	</div>
	<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Feedback</span>
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
													<th>Category</th>
													<th>Rating</th>
													<th>Comments</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($feedback)){
												foreach($feedback as $key=>$feed){ ?>
												<tr>
												<td><?=$key+1?></td>
												<td><?php echo ($feed['accountId'])?ucfirst($feed['accountFirstName']).' '.$feed['accountLastName']:'Anonymous';?></td>												
												<td><?=$feed['category']?></td>												
												<td>
												<?php
												for($i=0;$i<$feed['rating'];$i++){
													echo "<span class='glyphicon glyphicon-star'></span>";
												}
												?>
												</td>												
												<td><?=$feed['comments']?></td>												
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