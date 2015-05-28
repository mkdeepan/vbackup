<!-- start: PAGE TITLE -->
<div>
<div class="wrap-content container" id="container">
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Search Allergist</h1>
		<!--<span class="mainDescription">Share your thoughts about this site.</span>-->
	</div>

	<!--<ol class="breadcrumb">
		<li>
		<span>Dashboard</span>
		</li>
		<li class="active">
		<span>Feedback</span>
		</li>
	</ol>-->
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

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="search-classic">
										<form action="#" method="get" id="searchi" action="<?php echo base_url('search/allergists');?>" class="well">
											<div class="input-group">
												<input type="text" name="q" id="q" value="<?php echo (isset($_GET['q']))?$_GET['q']:''; ?>" class="form-control" placeholder="Search...">
												<input type="hidden" name="key" id="key" value="" />
											
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit">
														<i class="fa fa-search"></i> Search
													</button> 
											   </span>											  
											</div>
											<!--<p style="text-align:justify" class="search">Sort by: <a class="active arrow-down" href="">Best Match</a> | <a href="">Patient Satisfaction</a> | <a href="">Experience Match</a> | <a href="">Hospital Quality</a> | <a href="">Last Name</a> | <a href="">Distance</a></p>-->
											<p style="text-align:justify" class="search">Sort by: 
											<a class="<?php echo (isset($_GET) && isset($_GET['key']) && $_GET['key']=='lastname')?'active arrow-down':'';?>" id="lastname" href="javascript:void(0);">Last Name</a> | 
											<a class="<?php echo (isset($_GET) && isset($_GET['key']) && $_GET['key']=='rating')?'active arrow-down':'';?>" id="rating" href="javascript:void(0);">Patient Satisfaction</a></p>
										</form>
										<?php if(isset($_GET) && isset($_GET['q']) && $_GET['q'] !='')
										   echo "<h3>Search results for '".$_GET['q']."'</h3>";
										?>
										<hr>
										<?php
										   if(!empty($allergist)){
										   	foreach($allergist as $aller){
										   		?>
										<div class="col-md-12">
										<div class="search-result">
											<h4>
											<a href="#"><?=$aller['prefix']?>. 
											<?php 
											if($aller['firstname']) echo $aller['firstname'].' ';
											if($aller['middlename']) echo $aller['middlename'].' ';
											if($aller['lastname']) echo $aller['lastname'].' '; 
											?> 
											</a>
											<br>
											<small>
											<?php 
											if($aller['addrLine1']) echo $aller['addrLine1'].', ';
											if($aller['addrLine2']) echo $aller['addrLine2'].', ';											
											?><br>
											<?php
											if($aller['city']) echo $aller['city'].', ';
											if($aller['state']) echo $aller['abbr'].', ';
											if($aller['zip']) echo $aller['zip'].'. '; 
											echo "(24.1 miles away)";
											?> 
											</small>		
											</h4>
											<div class="col-md-3 docs">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="user-image">
												<div class="fileinput-new thumbnail">
												<?php
												//$url = base_url().'uploads/allergist/'.$aller['picture'];
												$url = $aller['picture'];
												?>
													<img src="<?php echo $url;?>" alt="">
												</div>											   
											</div>
										   </div>
										   </div>
										   <?php
										   $sql = "SELECT count( DISTINCT accountId ) AS response, sum( avgRating ) AS rating FROM AllergistSurvey WHERE allergistId = '".$aller['allergistId']."'";
    	                           $res = common_model::custom_query($sql);
    	                           $rating = '';
    	                           if($res[0]['rating'])
    	                             $rating = $res[0]['rating']/2;     	                          
										   ?>
										   <div class="col-md-4 docs">										
											<div class="margin-bottom-15 doctor text-extra-large">
											    <span class="bg-effect arrow_box">
														<input type="hidden" class="rating" readonly="readonly" value="<?=$rating?>" data-stop="5"/>														
												 </span>												 
											</div>
											<h2 class="responses">
												 <?php echo $res[0]['response']; ?> <br>  Responses
											</h2>
											<div class="clearfix"></div>											 									
											</div>																				
										   </div>										   									
										</div>
										<div class="bg-dash col-md-12"><p class="share pull-right" style=""><a href="">share</a> | <a href="">save</a></p></div>
										<div class="clearfix"></div>										
										<hr>
										   		<?php
										   	}										   	
										   }else{
										      ?>
										      <div class="bg-dash col-md-12"><h4 class="share">No records found.</h4></div>
										      <?php
										   }									    
										?>															
										
										<?php echo $links; ?>
										
									</div>
								</div>
							</div>
						</div>
</div>
</div>
<script>
$(document).ready(function(){
	$('#lastname').on('click', function(){
		$('#key').val('lastname');
		$('#searchi').submit();
	});
	$('#rating').on('click', function(){
		$('#key').val('rating');
		$('#searchi').submit();
	});
	$('.rating, .rating-tooltip').each(function() {
			$(this).val() > 0 ? $(this).next(".label").show().text($(this).val() || ' ') : $(this).next(".label").hide();
		});
		$('.rating-tooltip').rating({
			extendSymbol: function(rate) {
				$(this).tooltip({
					container: 'body',
					placement: 'bottom',
					title: 'Rate ' + rate
				});
			}
		});
		$('.rating, .rating-tooltip').on('change', function() {
			$(this).next('.label').show().text($(this).val());
		});
});
</script>