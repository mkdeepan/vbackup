<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Account Information</h1>
		<!--<span class="mainDescription">There are many systems which have a need for user profile pages which display personal information on each member.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Pages</span>
		</li>
		<li class="active">
		<span>Account Information</span>
		</li>
	</ol>-->
</div>
</section>
<?php 
    $read_array = read_access($this->session->userdata('account_id'));
    $write_array = write_access($this->session->userdata('account_id'));

    if($this->session->flashdata('success')) {?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->session->flashdata('success');?> 
    </div>
    <?php } else if($this->session->flashdata('failure')) {?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->session->flashdata('failure');?> 
    </div>
    <?php } 
?>
<!-- end: PAGE TITLE -->

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable">
				<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
					<li class="active">
					<a data-toggle="tab" href="#panel_overview">Overview</a>
					</li>
					<li>
					<a data-toggle="tab" href="#panel_edit_account">Edit Account Information</a>
					</li>
					<li>
					<a data-toggle="tab" href="#panel_edit_signing">Edit Signing Info</a>
					</li>
					<!--<li>
					<a data-toggle="tab" href="#panel_profile">Profile Summary</a></li>-->
					

				</ul>
				<div class="tab-content">
					<div id="panel_overview" class="tab-pane fade in active">
                                           <?php if(in_array('1',$read_array)) {?>
						<div class="row">
							<div class="col-sm-5 col-md-5">
								<div class="user-left">
									<div class="center">
										<h4><?php if(isset($account[0]['accountFirstName'])) echo $account[0]['accountFirstName'].' '.$account[0]['accountLastName']; ?></h4>
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="user-image">
												<div class="fileinput-new thumbnail">
													<img src="<?php if($account[0]['accountPicture']) echo base_url().'uploads/accountImages/'.$account[0]['accountPicture']; else echo empty_image();?>" alt="">
												</div>
											    <!-- <div class="user-image-buttons">
													<span class="btn btn-azure btn-file btn-sm">
													<span class="fileinput-new"><i class="fa fa-pencil"></i></span>
													<span class="fileinput-exists"><i class="fa fa-pencil"></i></span>
													<input type="file">
													</span>
													<a href="#" class="btn fileinput-exists btn-red btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i></a>
												</div> -->
											</div>
										</div>
										<hr>
									</div>
									<table class="table table-condensed">
										<thead>
											<tr>
											<th colspan="3">Personal Information</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											<td align="right">Name:</td>
											<td><a href="#"><?php if(isset($account[0]['accountFirstName'])) echo $account[0]['accountFirstName'].' '.$account[0]['accountLastName']; ?></a></td>
											<td align="left"><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
											<tr>
											<td align="right">Gender:</td>
											<td align="left"><a href=""><?php if(isset($account[0]['gender'])) echo $account[0]['gender']; ?></a></td>
											<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
											<tr>
											<td align="right">Phone:</td>
											<td align="left">
<label class="type-msg" style="color:#B7B2AC" >Mobile</label> 	
														<img class="flag-icon" src="<?=base_url().'source/assets/flags/'.$account[0]['amn_ex'].'.png'?>" alt="" />
														<?php if(isset($account[0]['accountMobilePhone'])) echo $account[0]['accountMobilePhone']; ?>
														<br>
											<?php if(!empty($account[1])) {
													foreach($account[1] as $row){?> 
														<label class="type-msg" style="color:#B7B2AC" > <?php if(isset($row['phoneTypeName'])) echo $row['phoneTypeName'].' ';?> </label>   	
														<img class="flag-icon" src="<?=base_url().'source/assets/flags/'.$row['phoneNumberEx'].'.png'?>" alt="" />
														<?php if(isset($row['phoneNumber'])) echo $row['phoneNumber']; ?>
														<br>
    										<?php }} ?>
    										</td>
    										<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
											<tr>
											<td align="right">Email:</td>
											<td align="left"><a href="">
<label class="type-msg" style="color:#B7B2AC" >Home</label>											
														<?php if(isset($account[0]['accountEmail'])) echo $account[0]['accountEmail']; ?>
														<br>
												<?php if(!empty($account[2])) {
														foreach($account[2] as $row){
														    if(isset($row['emailTypeName'])) echo '<label class="type-msg" style="color:#B7B2AC">'.$row['emailTypeName'].'</label> '; if(isset($row['emailAddress'])) echo $row['emailAddress'].'<br/>'; ?>
											    <?php }} ?>
											</a></td>
											<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
											<tr>
											<td align="right">Address:</td>
											<td align="left"><a href="">
												<?php if(!empty($account[3])) {
														foreach($account[3] as $row){
															echo '<label class="type-msg" style="color:#B7B2AC;vertical-align:top;padding-top:10px">'.$row['addressTypeName'].'</label> ';
															echo '<label style="color: #5b5b60 !important;" >'.@$row['addressFirst'].' '.@$row['addressSecond'].'<br>'.@$row['city'].', '.@$row['stateName'].'<br>'.@$row['countryName'].', '.@$row['zip'].'<br></label><br>';
												}}?>
											</a></td>
											<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
										</tbody>
									</table>
									<table class="table">
										<thead>
											<tr>
											<th colspan="3">Signing Information</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											<td align="right">Username:</td>
											<td align="left"><?php if(isset($account[0]['accountEmail'])) echo $account[0]['accountEmail']; ?></td>
											<td><a href="#panel_edit_signing" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
											<tr>
											<td align="right">Password:</td>
											<td align="left">********<!--<?php if(isset($account[0]['loginPassword'])) echo base64_decode($account[0]['loginPassword']); ?>--></td>
											<td><a href="#panel_edit_signing" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-sm-7 col-md-7">
								<div class="row space20">
									<div class="col-sm-3">
										<button class="btn btn-icon margin-bottom-5 margin-bottom-5 btn-block">
											<i class="ti-layers-alt block text-primary text-extra-large margin-bottom-10"></i>Profiles
										</button>
									</div>
								</div>
								<div class="panel panel-white" id="activities">
									<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Recent Activities</h4>
										<paneltool class="panel-tools" tool-collapse="tool-collapse" tool-refresh="load1" tool-dismiss="tool-dismiss"></paneltool>
									</div>
									<div collapse="activities" ng-init="activities=false" class="panel-wrapper">
										<div class="panel-body">
											<ul class="timeline-xs">
												<li class="timeline-item success">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															2 minutes ago
														</div>
														<p>
															<a class="text-info" href>Steven</a>has completed his account.
														</p>
													</div>
												</li>
												<li class="timeline-item">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															12:30
														</div>
														<p>
															Staff Meeting
														</p>
													</div>
												</li>
												<li class="timeline-item danger">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															11:11
														</div>
														<p>
															Completed new layout.
														</p>
													</div>
												</li>
												<li class="timeline-item info">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															Thu, 12 Jun
														</div>
														<p>
															Contacted <a class="text-info" href> Microsoft </a> for license upgrades.
														</p>
													</div>
												</li>
												<li class="timeline-item">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															Tue, 10 Jun
														</div>
														<p>
															Started development new site
														</p>
													</div>
												</li>
												<li class="timeline-item">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															Sun, 11 Apr
														</div>
														<p>
															Lunch with <a class="text-info" href> Nicole </a>.
														</p>
													</div>
												</li>
												<li class="timeline-item warning">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															Wed, 25 Mar
														</div>
														<p>
															server Maintenance.
														</p>
													</div>
												</li>
												<li class="timeline-item">
													<div class="margin-left-15">
														<div class="text-muted text-small">
															Fri, 20 Mar
														</div>
														<p>
															New User Registration <a class="text-info" href> more details </a>.
														</p>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div> <!-- Activities Panel End -->
							</div> <!-- column end -->
						</div> <!-- row ene -->
                                        <?php } else { ?>
				     <div class="row">
				     <div class="col-sm-10 col-sm-offset-1 page-error">
						<div class="error-number text-azure"> Access denied</div>
						<div class="error-details col-sm-6 col-sm-offset-3">
							<h3>Oops! You don't have permission</h3>
							<!--<p> 								Unfortunately the page you were looking for could not be accessible. 								<br>
								It may be temporarily unavailable, moved or no longer exist.
								<br>
								Check the URL you entered for any mistakes and try again.
								<br>
								<a class="btn btn-red btn-return" href="index.html">
									Return home
								</a>
								<br>
								Still no luck?
								<br>
								Search for whatever is missing, or take a look around the rest of our site.
							</p>-->
						</div>
					</div>
				     </div>
				     <?php } ?>
					</div> <!-- Panel Overivew end -->
					<div id="panel_edit_account" class="tab-pane fade">
                                           <?php if(in_array('1',$write_array)) {?>
						<form  enctype="multipart/form-data" onsubmit="return checkForError();" method="post" name="personal_info" id="personal_info" action="<?php echo base_url().'index.php/user/personalInfo';?>">
							<input type="hidden" name="account_id" id="account_id" value="<?php if(isset($account[0]['accountId'])) echo $account[0]['accountId'];?>" />
							
							<fieldset><legend>Account Info</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												First Name <span class="symbol required" aria-required="true"></span>
											</label>
											<input type="text" placeholder="First Name" class="form-control" id="first_name" name="first_name" value="<?php if(isset($account[0]['accountFirstName'])) echo $account[0]['accountFirstName'];?>">
										</div>
										
										<div class="form-group">
											<label class="control-label">
												Last Name <span class="symbol required" aria-required="true"></span>
											</label>
											<input type="text" placeholder="Last Name" class="form-control" id="last_name" name="last_name" value="<?php if(isset($account[0]['accountLastName'])) echo $account[0]['accountLastName'];?>">
										</div>

										<div class="form-group">
											<label class="control-label">
												Gender <span class="symbol required" aria-required="true"></span>
											</label>
											<div class="clip-radio radio-primary">
												<input type="radio" value="2" name="gender" id="us-female" <?php if(isset($account[0]['accountGender']) && $account[0]['accountGender'] == '2') echo 'checked="checked"'; ?>>
												<label for="us-female">
													Female
												</label>
												<input type="radio" value="1" name="gender" id="us-male" <?php if(isset($account[0]['accountGender']) && $account[0]['accountGender'] == '1') echo 'checked="checked"'; ?>>
												<label for="us-male">
													Male
												</label>
												<input type="radio" value="3" name="gender" id="us-other" <?php if(isset($account[0]['accountGender']) && $account[0]['accountGender'] == '3') echo 'checked="checked"'; ?>>
												<label for="us-other">
													Other
												</label>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label">
												Primary Mobile <span class="symbol required" aria-required="true"></span>
											</label>
											<input type="text" readonly placeholder="Enter mobile number" id="amobile" class="form-control nova-mobile" name="amobile" value="<?php if(isset($account[0]['accountMobilePhone'])) echo $account[0]['accountMobilePhone'];?>"/>
											<input type="hidden" id="amobile_ex" name="amobile_ex" value="<?php if(isset($account[0]['amn_ex'])) echo $account[0]['amn_ex'];?>" />
										</div>

										<div class="form-group">
											<label class="control-label">
												Primary Email
											</label>
											<input type="email" placeholder="Enter a valid E-mail" class="form-control" name="aemail" value="<?php if(isset($account[0]['accountEmail'])) echo $account[0]['accountEmail'];?>" readonly >
										</div>
										<!-- <div class="form-group">
											<label class="control-label">
												Password
											</label>
											<input type="password" placeholder="password" class="form-control" name="password" id="password">
										</div>
										
										<div class="form-group">
											<label class="control-label">
												Confirm Password
											</label>
											<input type="password"  placeholder="password" class="form-control" id="password_again" name="password_again">
										</div> -->
									</div> <!-- Column End -->

									<div class="col-md-6">
										
																
										<div class="form-group">
											<label>
												Account Image
											</label>
											<div class="fileinput fileinput-new" data-provides="fileinput">											
												<?php if($account[0]['accountPicture'])
														{
															$image = $account[0]['accountPicture'];
															$url = base_url().'uploads/accountImages/'.$account[0]['accountPicture'];
														}
														else
														{
															$image = '';
															$url = empty_image();
														}
												?>
												<div class="fileinput-new thumbnail">
												<img src="<?=$url?>" alt="">
												<input type="hidden" name="old_account_picture" value="<?=$image?>" />
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div class="user-edit-image-buttons">
													<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
														<input type="file" name="file_photo" name="file_photo" class="form-control">
													</span>
													<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
														<i class="fa fa-times"></i> Remove
													</a>
												</div>												
											</div>
										</div>
									</div> <!-- column end -->
								</div> <!-- row ene -->
							</fieldset>
							
							<fieldset><legend> Phone </legend>
								<div class="row">
									<div class="phone-reg">
										<?php $i=0;
										     if(!empty($account[1])){
												foreach($account[1] as $phno) { ?>
												  	<div class="phone-row">
												  	 	<div class="col-md-5">
												  	 		<div class="form-group">
												     		    <span class="input-icon">
																    <select class="form-control " id="phone_type" name="phone_type[]">
																    <?php foreach($phone_type as $phone){
																      	   $selected = ($phone['id'] == $phno['ptid'])?'selected':'';
																    ?>		          
																         	<option <?=$selected?> value="<?=$phone['id']?>"><?=$phone['phoneTypeName']?></option>
																    <?php } ?>
																    </select>
												    			</span>
												   			</div>
												    	</div>

												    	<div class="col-md-6">
												   			<div class="form-group">
												     			<span class="input-icon">  
															        <input type="text" name="phone_number[]" value="<?=$phno['phoneNumber']?>" placeholder="Add a phone" class="form-control  phone " id="phone_number<?=$i?>" />
															        <input type="hidden" value="<?=$phno['phoneNumberEx']?>" id="amn_ex" name="amn_ex[]">
												     			</span>         
												    		</div>
												    	</div>

												    	<?php if($i){ ?>
												    	<div class="col-md-1">
												    		<div class="form-group"> 
												    			<span class="input-icon">
												    				<i class="glyphicon glyphicon-remove phone-remove pull-right phone-remove"></i> 
												    			</span>
												   			</div>
												        </div>
												        <?php } ?>
												    </div>  <!-- Phone Row end -->   
												    <?php  $i++; } } else{ ?>
												 	<div class="phone-row">
												  	 	<div class="col-md-5">
												  	 		<div class="form-group">
												     		    <span class="input-icon">
																    <select class="form-control " id="phone_type" name="phone_type[]">
																    <?php foreach($phone_type as $phone){?>		          
																         	<option value="<?=$phone['id']?>"><?=$phone['phoneTypeName']?></option>
																    <?php } ?>
																    </select>
												    			</span>
												   			</div>
												    	</div>

												    	<div class="col-md-6">
												   			<div class="form-group">
												     			<span class="input-icon">  
															        <input type="text" name="phone_number[]" value="" placeholder="Add a phone" class="form-control  phone " id="phone_number<?=$i?>" />
															        <input type="hidden" value="" id="amn_ex" name="amn_ex[]">
												     			</span>         
												    		</div>
												    	</div>
						    	
												    </div> <!-- Phone Row end -->
                                                    <?php } ?>
					                </div> <!-- Phone reg end -->
					            </div> <!-- Row end -->
							</fieldset>

                            <fieldset><legend>Email</legend>
                            <div class="row">
								<div class="email-reg">
									<?php if(!empty($account[2])){ $i=0;
		  									foreach($account[2] as $emails) { ?>
		  										<div class="close-email">
												  	<div class="col-md-5">
												  	  	<div class="form-group">
												      		<span class="input-icon">
															    <select class="form-control " id="email_type" name="email_type[]">
															    <?php foreach($email_type as $email){
															      	$selected = ($email['id'] == $emails['etid'])?' selected':'';?>
															        <option value="<?=$email['id']?>" <?=$selected?>><?=$email['emailTypeName']?></option>
															    <?php } ?>
															    </select>
															</span>
														</div>
													</div>

												    <div class="col-md-6">
												    	<div class="form-group">
												    		<!--<span class="input-icon">-->
												    		    <?php //echo '-'.$emails['emailAddress'].'-';?> 
												      			<input type="text" value="<?php if(isset($emails['emailAddress']) && $emails['emailAddress'] != '') echo $emails['emailAddress'];?>" class="form-control input-personal email-id " placeholder="Add an email" name="email_id[]" id="email_id" />
												     		<!--</span>-->
												    	</div>
												    </div>

												    <?php if($i){ ?>
												    <div class="col-md-1">
												   		<div class="form-group"> 
												    		<span class="input-icon">
												   				<i class="glyphicon glyphicon-remove phone-remove pull-right phone-remove"></i> 
												    		</span>
												    	</div>
												    </div>
												    <?php } ?>
												</div> <!-- close email end -->

												<?php $i++; } } else{ ?>
												<div class="close-email">
												    <div class="col-md-5">
												  	  	<div class="form-group">
												      		<span class="input-icon">
															    <select class="form-control " id="email_type" name="email_type[]">
															    <?php foreach($email_type as $email){?>
															        <option value="<?=$email['id']?>"><?=$email['emailTypeName']?></option>
															    <?php } ?>
															    </select>
															</span>
														</div>
													</div>

												    <div class="col-md-6">
												    	<div class="form-group">
												    		<!--<span class="input-icon"> -->
												    		    <?php //echo '-'.$emails['emailAddress'].'-';?> 
												      			<input type="text" value="" class="form-control input-personal email-id " placeholder="Add an email" name="email_id[]" id="email_id" />
												     		<!--</span>         -->
												    	</div>
												    </div>
												</div> <!-- close email end -->
												<?php } ?>

					            </div> <!-- email reg end -->
					        </div> <!-- row end -->
						</fieldset>
                        
                        <fieldset><legend>Address</legend>
							<div class="row">
								<div class="addr-reg">
									<?php if(!empty($account[3])){
											$i=0;
											foreach($account[3] as $loc) {?>
												<div class="addr-new">
												  	<div class="col-md-3">
												  	  	<div class="form-group">
												      		<span class="input-icon">
															    <select class="form-control addr" id="addr_type" name="addr_type[]">
															        <?php foreach($addr_type as $addr){
															      		$type_select = ($addr['id'] == $loc['atid'])?'selected':'';?>
															         	<option <?=$type_select?> value="<?=$addr['id']?>"><?=$addr['addressTypeName']?></option>
															        <?php } ?>
															    </select>
															</span>
														</div>
													</div>

													<div class="col-md-8">
														<div class="row">
															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Address First Line
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="<?=$loc['addressFirst']?>" name="firstline[]" id="firstline" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>
															     
															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Address Second Line
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="<?=$loc['addressSecond']?>" name="secondline[]" id="secondline" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		City
															    	 </label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="<?=$loc['city']?>" name="add_city[]" id="add_city" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															    	 <label class="control-label">
															       		State
															    	 </label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<select class="form-control addr" name="add_state[]" id="add_state">
															         		<option value="">Select</option>
															         		<?php foreach($state as $st){ 
															         			$state_select = ($st['stateId'] == $loc['stateId'])?'selected':'';?>
															          			<option <?=$state_select?> value="<?=$st['stateId']?>"><?=$st['stateName']?></option>
															         		<?php } ?>
															         	</select>
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															      		Zipcode
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<input type="text" value="<?=$loc['zip']?>" name="add_zip[]" id="add_zip" maxlength="5" class="addr form-control" />
															    	 <!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Country
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<select class="form-control addr" name="add_country[]" id="add_country">
															         	<option value="">Select</option>
															         	<?php foreach($country as $coun){
															          			$img = base_url()."source/assets/flags/".$coun['iso'].".png";  
															          			$country_select = ($coun['countryId'] == $loc['countryId'])?'selected':'';?>
															           			<option <?=$country_select?> value="<?=$coun['countryId']?>"><img src="<?=$img?>" alt="" ><?=$coun['countryName']?></option>
															         	<?php } ?>
															         	</select>
															     	<!--</span>-->        
															    </div>
															</div>
															   
														</div> <!-- Inner row end -->
													</div> <!-- second column end -->
													<?php if($i){ ?>
													<div class="col-md-1">
														<div class="form-group"> 
															<!--<span class="input-icon">-->
															     <i class="glyphicon glyphicon-remove addr-remove pull-right "></i> 
															<!--</span>-->
														</div>
													</div>
													<?php } ?> 
												</div> <!-- addr new end -->
												<?php  $i++; } } else{ ?>
												<div class="addr-new">
												  	<div class="col-md-3">
												  	  	<div class="form-group">
												      		<!--<span class="input-icon">-->
															    <select class="form-control addr" id="addr_type" name="addr_type[]">
															        <?php foreach($addr_type as $addr){?>
															         	<option  value="<?=$addr['id']?>"><?=$addr['addressTypeName']?></option>
															        <?php } ?>
															    </select>
															<!--</span>-->
														</div>
													</div>

													<div class="col-md-8">
														<div class="row">
															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Address First Line
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="" name="firstline[]" id="firstline" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>
															     
															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Address Second Line
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="" name="secondline[]" id="secondline" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		City
															    	 </label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															       		<input type="text" value="" name="add_city[]" id="add_city" class="addr form-control" />
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															    	 <label class="control-label">
															       		State
															    	 </label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<select class="form-control addr" name="add_state[]" id="add_state">
															         		<option value="">Select</option>
															         		<?php foreach($state as $st){ ?>
															          			<option  value="<?=$st['stateId']?>"><?=$st['stateName']?></option>
															         		<?php } ?>
															         	</select>
															     	<!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															      		Zipcode
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<input type="text" value="" name="add_zip[]" id="add_zip" maxlength="5" class="addr form-control" />
															    	 <!--</span>-->        
															    </div>
															</div>

															<div class="col-md-4">
															    <div class="form-group">
															     	<label class="control-label">
															       		Country
															     	</label>        
															    </div>
															</div>

															<div class="col-md-6">
															    <div class="form-group">
															     	<!--<span class="input-icon">-->
															        	<select class="form-control addr" name="add_country[]" id="add_country">
															         	<option value="">Select</option>
															         	<?php foreach($country as $coun){
															          			$img = base_url()."source/assets/flags/".$coun['iso'].".png"; ?>
															           			<option  value="<?=$coun['countryId']?>"><img src="<?=$img?>" alt="" ><?=$coun['countryName']?></option>
															         	<?php } ?>
															         	</select>
															     	<!--</span>-->        
															    </div>
															</div>
															   
														</div> <!-- Inner row end -->
													</div> <!-- second column end -->
													<?php //if($i){ ?>
													<!-- <div class="col-md-1">
														<div class="form-group"> 
															<span class="input-icon">
															     <i class="glyphicon glyphicon-remove addr-remove pull-right "></i> 
															</span>
														</div>
													</div> -->
													<?php // } ?> 
												</div> <!-- addr new end -->
												<?php } ?>
					            </div> <!-- addr reg end -->
					        </div> <!-- Row end -->
						</fieldset>

						<div class="row">
							<div class="col-md-12">
								<div>
									<span class="symbol required" aria-required="true"></span> Required Fields
									<hr>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<p>
									By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
								</p>
							</div>
							<div class="col-md-4">
								<input class="btn btn-primary pull-right" type="submit" id="personal_save" name="personal_save" value="Update"/>
								<!--  <i class="fa fa-arrow-circle-right"></i> -->
							</div>
						</div>
						</form>
                                           <?php } else { ?>
				     <div class="row">
				     <div class="col-sm-10 col-sm-offset-1 page-error">
						<div class="error-number text-azure"> Access denied</div>
						<div class="error-details col-sm-6 col-sm-offset-3">
							<h3>Oops! You don't have permission</h3>
							<!--<p> 								Unfortunately the page you were looking for could not be accessible. 								<br>
								It may be temporarily unavailable, moved or no longer exist.
								<br>
								Check the URL you entered for any mistakes and try again.
								<br>
								<a class="btn btn-red btn-return" href="index.html">
									Return home
								</a>
								<br>
								Still no luck?
								<br>
								Search for whatever is missing, or take a look around the rest of our site.
							</p>-->
						</div>
					</div>
				     </div>
				     <?php } ?>
					</div> <!-- Panel edit ends -->

					<!--<div id="panel_profile" class="tab-pane fade table-responsive">
						<table class="table" id="profile">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Profile Name</th>
									<th>Allergic To</th>
									<th>Emergency Contact #</th>
									<th>More..</th>
								</tr>
							</thead>
							<tbody>
							    <?php if(!empty($summary)){
		 	                 		 	$i=1;
		 	  							foreach($summary as $sum) {?>
											<tr>
												<td><?=$i?></td>
												<td class="hidden-xs"><?=$sum['profileName']?></td>
												<td><?=$sum['allergyName']?></td>
												<td class="hidden-xs"><?=$sum['emergencyContact']?></td>
												<td class="center hidden-xs">
												
												<?php
												 $allergies = $this->allergy_model->getAllergyById($sum['profileId']);
								                 $incidents = $this->allergy_model->getIncidentById($sum['profileId']);
												 ?>
												 <a class="label label-info" href="<?php echo base_url().'user/profile/'.$sum['profileId'].'/?tab=profile_overview';?>">P</a> | 
												 <?php //if(!empty($allergies) && !empty($incidents)) {?>
												 <a class="label label-warning"  href="<?php echo site_url('user/profile/'.$sum['profileId'].'/?tab=allergy_overview');?>">A</a>
												 <?php //} //else {?>
												 <!-- <a class="label label-danger "  href="<?php //echo base_url().'allergy/editInfo/'.$sum['profileId'];?>">A</a>
												 <?php //}?>	
												
												</td>
											</tr>
								<?php $i++; }  } else {?>
								<tr>
									<td colspan="5" class="center hidden-xs"><span class="label label-danger">No Records Found</span></td>
								</tr>
								<?php } ?>
								
							</tbody>
						</table>
					</div>--> <!-- Pannel Profile ends -->
                    
                    <div id="panel_edit_signing" class="tab-pane fade">
                     <?php if(in_array('1',$write_array)) {?>
						<form  enctype="multipart/form-data" method="post" name="change_pwd" id="change_pwd" action="<?php echo base_url().'index.php/user/signingInfo';?>">
							<input type="hidden" name="account_id" id="account_id" value="<?php if(isset($account[0]['accountId'])) echo $account[0]['accountId'];?>" />
							
							<fieldset><legend>Signing Info</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												User Name<span class="symbol required" aria-required="true"></span>
											</label>
											<span class="input-icon">
												<input tabindex="1" type="text" readonly placeholder="User Name" class="form-control" name="username" id="username" value="<?php echo @$account[0]['accountEmail'];?>">
<i class="fa fa-user"></i>
											</span>
										</div>
										
										

										<div class="form-group">
											<label class="control-label">
												 New Password<span class="symbol required"></span>
											</label>
											<span class="input-icon">
											<input tabindex="3" type="password" placeholder="New password" class="form-control" name="new_pwd" id="new_pwd" autocomplete="off">
<i class="fa fa-unlock-alt"></i>
										    </span>
										</div>
										
										
									</div> <!-- Column End -->

									<div class="col-md-6">
										
										<div class="form-group">
											<label class="control-label">
												Old Password<span class="symbol required"></span>
											</label>
											<span class="input-icon">
											<input tabindex="2" type="password" placeholder="Old Password" class="form-control" id="old_pwd" name="old_pwd" value="">
<i class="fa fa-lock"></i>
										    </span>
										</div>

										<div class="form-group">
											<label class="control-label">
												Confirm Password<span class="symbol required"></span>
											</label>
											<span class="input-icon">
											<input type="password" tabindex="4" placeholder="Confirm password" class="form-control" id="c_pwd" name="c_pwd">
<i class="fa fa-unlock-alt"></i>
										    </span>
										</div> 

										<!-- <div class="form-group">
											<label>
												Recovery Phone
											</label>
											<span class="input-icon">
												<input type="text" class="phones" id="recovery" name="recovery" value="<?php echo @$rphone[0]['phoneNumber'];?>" placeholder="(110)454-4584"/>
										    </span>
										</div> -->
										
									</div> <!-- column end -->
								</div> <!-- row end -->
								<hr>
								<div class="row">
									<div class="col-md-8">
										<p>
											By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
										</p>
									</div>
									<div class="col-md-4">
										<input class="btn btn-primary pull-right" type="submit" id="update_password" name="update_password" value="Update"/>
										<!--  <i class="fa fa-arrow-circle-right"></i> -->
									</div>
								</div>
							</fieldset>
						</form>
                                     <?php } else { ?>
				     <div class="row">
				     <div class="col-sm-10 col-sm-offset-1 page-error">
						<div class="error-number text-azure"> Access denied</div>
						<div class="error-details col-sm-6 col-sm-offset-3">
							<h3>Oops! You don't have permission</h3>
							<!--<p> 								Unfortunately the page you were looking for could not be accessible. 								<br>
								It may be temporarily unavailable, moved or no longer exist.
								<br>
								Check the URL you entered for any mistakes and try again.
								<br>
								<a class="btn btn-red btn-return" href="index.html">
									Return home
								</a>
								<br>
								Still no luck?
								<br>
								Search for whatever is missing, or take a look around the rest of our site.
							</p>-->
						</div>
					</div>
				     </div>
				     <?php } ?>
					</div> <!-- Signing info end -->
					


				</div> <!-- tab content end -->
			</div> <!-- tabbable end -->
		</div> <!-- column end -->
	</div> <!-- Row end -->
</div> <!-- Container end -->
<!-- end: USER PROFILE -->
</div>
<script>
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.profile').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
function checkForError()
   {
   	var error;
   	///this_ob.on('change blur keyup',function () {
   	$('.phone').css("border","1px solid #ccc"); 
	 	$('.phone').closest("div").find(".error").remove(); 
   	$('.phone').each(function(){
   	   var cur_obj = $(this);
    		var val = '';
	 	   error = 0;
	 	   var msg = '';
    		val = cur_obj.val();
    		if(val != '' && val.replace(/[^0-9]/g,"").length > 10)
    		{
    			error = 1;
    			msg = 'Enter valid mobile number';
    		}
    	   if(error = 1 && msg != '')
    	   {
    	   	cur_obj.css("border","1px solid #a94442");
	         cur_obj.closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	   }
    	});
    	$('.email-id').css("border","1px solid #ccc"); 
	 	$('.email-id').closest("div").find(".error").remove(); 
   	$('.email-id').each(function(){
   	   var cur_obj = $(this);
    		var val = '';
	 	   error = 0;
	 	   var msg = '';
    		val = cur_obj.val();
    		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
         if(val != '' && !pattern.test(val))
         {
         	error = 1;
         	msg = 'Enter a valid email';
         }
    		
    	   if(error = 1 && msg != '')
    	   {
    	   	cur_obj.css("border","1px solid #a94442");
	         cur_obj.closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	   }
    	});
    	
    if(error){
     return false;
     }else{
     return true;
     }    	
     //});   
   }
  $(document).ready(function() {

   $('.phone').intlTelInput({
   	preferredCountries: ["us", "ca"],
  	   utilsScript:"<?php echo base_url('source/assets/js/utils.js');?>"
  	 });
  	 
  	<?php if(!empty($account[1])){$i=0;
   foreach($account[1] as $phone) { ?>
   $("#phone_number<?=$i++?>").intlTelInput("selectCountry", "<?php echo ($phone['phoneNumberEx'])? $phone['phoneNumberEx']:'us'; ?>");
   <?php }} ?> 

   addDetails();
   function addDetails()
   {
   	$('.phone-remove').click(function(){
	   			$(this).closest('.phone-row').remove();
	   		});
   	//$('.phone').blur(function(){
   	$('.phone').on('change blur keyup',function(e){
   		
   		if(checkValues() == 0)
   		{
   			var ph_ob = $(' <div class="phone-row"><div class="col-md-5"><div class="form-group"><span class="input-icon"><select class="form-control input-sm" id="phone_type" name="phone_type[]"><?php foreach($phone_type as $phone){?><option value="<?=$phone["id"]?>"><?=$phone["phoneTypeName"]?></option><?php } ?></select></span></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><input type="text" name="phone_number[]" placeholder="Add a phone" class="form-control input-sm input-personal phone" id="phone_no" /><input type="hidden" value="" id="amn_ex" name="amn_ex[]"></span></div></div><div class="col-md-1"><div class="form-group"><span class="input-icon"><i class="glyphicon glyphicon-remove phone-remove pull-right phone-remove"></i></span></div></div></div>');
   			/*var txt_bx = ph_ob.find(".col-sm-4 #phone_type");
   			$('.phone-reg').append(ph_ob);
   			txt_bx.focus();
   			*/
   			$('.phone-reg').append(ph_ob);   			
   			$('.phone').intlTelInput({ preferredCountries: ["us", "ca"], utilsScript:"<?php echo base_url('source/assets/js/utils.js');?>" });
   			var txt_bx = ph_ob.find(".col-sm-5 .label-view .intl-tel-input #phone_no");
   			//txt_bx.focus();
   			
   			var countryData1 = $(this).intlTelInput("getSelectedCountryData");
  	 	      $(this).closest('div').next('input').val(countryData1.iso2);
	   		addDetails();
	   		
   		}  	   	
   		checkForError();   	
   	});
   var val ='';
   $(document).on('keypress ','.phone', function(event){
      value = $(this).val();
      
      if(value.replace(/[^0-9]/g,"").length === 10)
      {
      	val = $(this).val();
      }
      
      if(value.replace(/[^0-9]/g,"").length > 10)
      {
      	$(this).val(val);
      	event.preventDefault();
      	
       }
   });
   	
   	$('.email-id').on('change blur keyup',function(e){
   		if(checkValuesEmail() == 0)
   		{
	   		$('.email-reg').append('<div class="close-email"><div class="col-md-5"> <div class="form-group"> <span class="input-icon"> <select class="form-control input-sm" id="email_type" name="email_type[]"> <?php foreach($email_type as $email){?> <option value="<?=$email['id']?>"><?=$email['emailTypeName']?></option> <?php } ?> </select> </span> </div> </div> <div class="col-md-6"> <div class="form-group"> <span class="input-icon"> <input type="text" class="form-control input-personal email-id input-sm" placeholder="Add an email" name="email_id[]" id="email_id" /> </span> </div> </div> <div class="col-md-1"> <div class="form-group"> <span class="input-icon"> <i class="glyphicon glyphicon-remove email-remove pull-right phone-remove"></i></span> </div> </div></div>');
	   		addDetails();
	   		//$('.email-reg input:last-child').focus();
	   		$('.email-remove').click(function(){
	   			$(this).closest('.close-email').remove();
	   		});
   		} 
   		checkForError();   	 	   	   	
   	 });
   	 $('.addr').blur(function(){
   	 	
   		if(checkValuesAddr() == 0)
   		{
	   		//$('.addr-reg').append('<div class="addr-new"><div style="display: inline-block;margin-top: 20%;float: left;width: 26%;margin-left:10px;"> <select class="form-control input-sm addr" id="addr_type" name="addr_type[]"> <?php foreach($addr_type as $addr){?> <option value="<?=$addr['id']?>"><?=$addr['addressTypeName']?></option> <?php } ?> </select> </div> <div class="col-sm-7"><table border="0" class="address" width="100%" style="margin-left:14px;"> <tr> <td colspan="2"> <label for="gender" class="control-label label-view">Address First Line</label><br> <span><input type="text" name="firstline[]" id="firstline" class="addr" /></span> </td> </tr> <tr> <td colspan="2"> <label for="gender" class="control-label label-view">Address Second Line</label><br> <span><input type="text" name="secondline[]" id="secondline" class="addr" /></span> </td> </tr> <tr> <td width="50%" valign="top"> <label for="gender" class="control-label label-view">City</label><br> <span><input type="text" name="add_city[]" id="add_city" class="addr" /></span> </td> <td width="50%" valign="top"> <label for="gender" class="control-label label-view">State</label><br> <span> <select class="form-control input-sm addr" name="add_state[]" id="add_state"> <option value="">Select</option> <?php foreach($state as $st){ ?> <option value="<?=$st['stateId']?>"><?=$st['stateName']?></option> <?php } ?> </select> </span> </td> </tr> <tr> <td width="50%" valign="top"> <label for="gender" class="control-label label-view">Zipcode</label><br> <span><input type="text" name="add_zip[]" id="add_zip" maxlength="5" class="addr" /></span> </td> <td width="50%" valign="top">  <label for="gender" class="control-label label-view">Country</label><br> <span> <select class="form-control input-sm addr" name="add_country[]" id="add_country"> <option value="">Select</option> <?php foreach($country as $coun){ ?> <option value="<?=$coun['countryId']?>"><?=$coun['countryName']?></option> <?php } ?> </select> </span> </td> </tr> </table> </div> <div class="col-sm-1 pull-right"><i class="glyphicon glyphicon-minus addr-remove pull-right"></i> </div></div>');
	   		$('.addr-reg').append('<div class="addr-new"><div class="col-md-3"><div class="form-group"><span class="input-icon"><select name="addr_type[]" id="addr_type" class="form-control input-sm addr"><?php foreach($addr_type as $addr){?><option value="<?=$addr["id"]?>"><?=$addr["addressTypeName"]?></option><?php } ?></select></span></div></div><div class="col-md-8"><div class="row"><div class="col-md-4"><div class="form-group"><label class="control-label">Address First Line</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><input type="text" class="addr form-control" id="firstline" name="firstline[]" value=""></span></div></div><div class="col-md-4"><div class="form-group"><label class="control-label">Address Second Line</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><input type="text" class="addr form-control" id="secondline" name="secondline[]" value=""></span></div></div><div class="col-md-4"><div class="form-group"><label class="control-label">City</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><input type="text" class="addr form-control" id="add_city" name="add_city[]" value=""></span></div></div><div class="col-md-4"><div class="form-group"><label class="control-label">State</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><select id="add_state" name="add_state[]" class="form-control input-sm addr"><option value="">Select</option><?php foreach($state as $st){ ?><option value="<?=$st["stateId"]?>"><?=$st["stateName"]?></option><?php } ?></select></span></div></div><div class="col-md-4"><div class="form-group"><label class="control-label">Zipcode</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><input type="text" class="addr form-control" maxlength="5" id="add_zip" name="add_zip[]" value=""></span></div></div><div class="col-md-4"><div class="form-group"><label class="control-label">Country</label></div></div><div class="col-md-6"><div class="form-group"><span class="input-icon"><select id="add_country" name="add_country[]" class="form-control input-sm addr"><option value="">Select</option><?php foreach($country as $coun){$img = base_url()."assets/flags/".$coun["iso"].".png";?><option value="<?=$coun["countryId"]?>"><img src="<?=$img?>" alt="" ><?=$coun["countryName"]?></option> <?php } ?> </select></span></div></div></div></div> <div class="col-md-1"><div class="form-group"><span class="input-icon"> <i class="glyphicon glyphicon-remove  pull-right addr-remove"></i></span></div></div></div>')
	   		addDetails();
	   		

   		}  	   	   	
   	});
    $('.addr-remove').click(function(){
	   		
	   			$(this).closest('.addr-new').remove();
	   		});
   }

   function checkValues(){
   	var err = 0;
   	$(".phone").each(function () {
   		if($(this).val() == "")
   		 err = 1;
   	})
   	return err;
   }
   function checkValuesEmail(){
   	var err = 0;
   	$(".email-id").each(function () {
   		
   		if($(this).val() == "")
   		 err = 1;
   	})
   	
   	return err;
   }
   function checkValuesAddr(){
   	var err = 0;
   	$(".addr").each(function () {
   		if($(this).val() == "")
   		 err = 1;
   	})
   	return err;
   }
   });
</script>
<script>
  $(document).ready(function () {
  	
  	 $('#recovery').intlTelInput({
  	 	preferredCountries: ["us", "ca"],
  	   utilsScript:"<?php echo base_url('assets/js/utils.js');?>"
  	 });
  	 $("#recovery").intlTelInput("selectCountry", "<?php echo (@$phone[0]['phoneNumberEx'])? @$phone[0]['phoneNumberEx']:'us'; ?>");
  	 $('#recovery').change(function(){
  	 	 var countryData = $("#recovery").intlTelInput("getSelectedCountryData");
  	 	 $('#amn_ex').val(countryData.iso2);
  	 });
  	 
  	 $("#change_pwd").validate({
  	 	rules:{
  	 		username:{
  	 		   required: true,
  	 		   email: true,
  	 		   maxlength:50
  	 		},
  	 		old_pwd:{
  	 			required:true,
  	 			maxlength:20
  	 		},
    		new_pwd:{
    			required:true,
    			minlength: 8,
    			maxlength: 20,
    			pwcheck : true
    		},
    		c_pwd:{
    			required:true,
    			minlength: 8,
    			maxlength: 20,
    			equalTo: "#new_pwd"
    		},
    		recovery:{
    			required:true,
    			//maxlength: 10,
    		}
  	 	},
  	 	messages:{
  	 		username:{
  	 			required:"You can't leave this empty.",
  	 			email:"Enter valid email address.",
  	 		   maxlength:"Not more than 20 characters"
  	 		},
  	 		old_pwd:{
  	 			required:"You can't leave this empty.",
  	 			maxlength:"Not more than 20 characters"
  	 		},
    		new_pwd:{
    			required:"You can't leave this empty.",
    			minlength:"Enter minimum 8 characters.",
    			maxlength:"Enter maximum 20 characters.",
    			pwcheck:"Enter atleast 1 number, 1 Uppercase."
    		},
    		c_pwd:{
    			minlength:"Enter minimum 8 characters.",
    			maxlength:"Enter maximum 20 characters.",
    		   required:"You can't leave this empty.",
    		   equalTo:"Password doesn't matches."
    		}, 
    		recovery:{ 		
	    		required:"You can't leave this empty.",
	    	   maxlength: "Not more than 10 digits.",
    	 }
  	 	}
  	 });
    
  });
   var val ='';
   $(document).on('focus ','#recovery', function(event){
      value = $(this).val();
      console.log(value);
      if(value.replace(/[^0-9]/g,"").length === 10)
      {
      	val = $(this).val();
      	console.log(val);
      }
    }); 
    $(document).on('keypress ','#recovery', function(event){ 
    	new_value = $(this).val();
        if(new_value.replace(/[^0-9]/g,"").length > 10)
        {
      		$(this).val(val);

      		event.preventDefault();
      	
       	}
    });
   
  </script>
