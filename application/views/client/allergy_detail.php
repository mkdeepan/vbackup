<?php 
if(isset($_GET['tab']))
{
	?>
	<script type="text/javascript">
	var id= '<?php echo '#'.$_GET['tab'];?>';
	$(document).ready(function(){
     $('li.active').removeClass('active');
   
    $( ".tab-pane" ).each(function() {
	  if($(this).hasClass('in active'))
	  	$(this).removeClass('in active');
	});
	 $('li:has(a[href="'+id+'"])').addClass('active');
	 
	 $(id).addClass('in active');
	});
	
	</script>
	<?php
}
?>
<style type="text/css">
	.help-block{
		color:#A94442 !important;
	}
</style>
<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">User Profile</h1>
		<!--<span class="mainDescription">There are many systems which have a need for user profile pages which display personal information on each member.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Pages</span>
		</li>
		<li class="active">
		<span>User Profile</span>
		</li>
		<li class="active">
		<span>Allergy</span>
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
    <?php } ?>
<!-- end: PAGE TITLE -->

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable">
				<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
					<li class="active">
					<a data-toggle="tab" href="#profile_overview">Profile Overview</a>
					</li>
					<li >
					<a data-toggle="tab" href="#profile_edit">Edit Profile</a>
					</li>
					<li >
					<a data-toggle="tab" href="#allergy_overview">Allergy Overview</a>
					</li>
					<li>
					<a data-toggle="tab" href="#panel_edit_allergy">Edit Allergy</a>
					</li>
				</ul>
				<div class="tab-content">
				    <div id="profile_overview" class="tab-pane fade in active">
                                     <?php if(in_array('2',$read_array)) {?>
				     <div class="row">
				        <div class="col-sm-5 col-md-4">
							<div class="user-left">
								<div class="center">
									<h4><?php echo $profile[0]['profileFirstName'].''.$profile[0]['profileMiddleName'].' '.$profile[0]['profileLastName'];?></h4>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="user-image">
											<div class="fileinput-new thumbnail">
											    <img class="profile" src="<?php if($profile[0]['profilePicture']) echo base_url().'uploads/profileImages/'.$profile[0]['profilePicture']; else echo empty_image();?>" alt="" >
											</div>
										</div>
									</div>
								</div>
							<table class="table table-condensed">
								<thead>
									<tr>
									<th colspan="3">Personal Information</th>
									</tr>
								</thead>
								<tbody>
									<tr>
									<td>Name</td>
									<td>
									<a href="#">
										<?php echo $profile[0]['profileFirstName'].''.$profile[0]['profileMiddleName'].' '.$profile[0]['profileLastName'];?>
									</a></td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<tr>
									<td>Birthday</td>
									<td>
									<a href="">
										<?php echo Date('F d, Y',strtotime($profile[0]['profileDateOfBirth']));?>
									</a></td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<tr>
									<td>Gender</td>
									<td>
									<a href="">
										<?php echo ($profile[0]['profileGenderId'] == '1')?'Male':(($profile[0]['profileGenderId'] == '2')?'Female':'Other');?>
									</a></td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<tr>
									<td>phone</td>
									<td>
										<?php if($profile[0]['profileMobileEx']){?>
                                        <img class="flag-icon" src="<?=base_url().'source/assets/flags/'.$profile[0]['profileMobileEx'].'.png'?>" alt="" />
                                        <?php } ?>
                                        <?php echo $profile[0]['profileMobilePhone'];?>
									</td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<tr>
									<td>Email</td>
									<td>
									<a href="">
										<?php echo $profile[0]['profileEmail'];?>
									</a></td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<tr>
									<td>Address</td>
									<td>
										<a href="">
											<?php
												$address='';
												if($profile[0]['profileAddressFirstLine'] != '')
													$address .= $profile[0]['profileAddressFirstLine'].',<br/>'; 
												if($profile[0]['profileAddressSecondLine'] != '')
													$address .= $profile[0]['profileAddressSecondLine'].',<br/>';
												if($profile[0]['profileAddressCity'] != '')
													$address .= $profile[0]['profileAddressCity'].',<br/>';
												if($profile[0]['profileAddressStateId'] != '')
													$address .= $profile[0]['profileAddressStateId'].',<br/>';
												if($profile[0]['profileAddressZip'] != '0' && $profile[0]['profileAddressZip'] != '')
													$address .= $profile[0]['profileAddressZip'].',<br/>';
												if($profile[0]['profileAddressCountryId'] != '')
													$address .= $profile[0]['profileAddressCountryId'].',<br/>';
												echo rtrim($address, ",<br/>");
											?>
										</a>
									</td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
								</tbody>
							</table>

							<table class="table">
								<thead>
									<tr>
									<th colspan="3">School information</th>
									</tr>
								</thead>
								<tbody>
								    <tr>
								    <td colspan="3">
								    <div class="center">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="user-image">
												<div class="fileinput-new thumbnail">
												   	<img class="profile" src="<?php if($profile[0]['profileSchoolLogo']) echo base_url().'uploads/school/'.$profile[0]['profileSchoolLogo']; else echo empty_logo();?>" alt="" >
												</div>
											</div>
										</div>
									</div>
								    </td>
								    </tr>
									<tr>
									<td>Name</td>
									<td>
										<?php echo $profile[0]['profileSchoolName'];?>
									</td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
									<!-- <tr>
									<td>Logo</td>
									<td><img class="profile" src="<?php if($profile[0]['profileSchoolLogo']) echo base_url().'uploads/school/'.$profile[0]['profileSchoolLogo'];?>" alt="Logo" >
									</td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr> -->
									<tr>
									<td>Grade</td>
									<td>																		
										<?php echo ($profile[0]['profileSchoolGrade'] !='' && $profile[0]['profileSchoolGrade'] !='0')?$profile[0]['profileSchoolGrade']:'';?>
									</td>
									<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
									</tr>
								</tbody>
							</table>
							</div>
						</div><!-- first Column End -->
						    
						<div class="col-sm-5 col-md-8">
							<div id="activities" class="panel panel-white">
								<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Emergency Contacts</h4>
								</div>
								<div class="user-left">
									<table class="table table-condensed">
										<tbody>
										<?php
            								$records = $this->profile_model->get_emergency_contact($profile_id); 
            								if(!empty($records)) {
             						            foreach ($records as $value) {
             							?>
													
														<tr>
														<td>Name</td>
														<td><?php echo $value['emergencyContactFirstName'].' '.$value['emergencyContactMiddleName'].'  '.$value['emergencyContactLastName'];?></td>
														<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
														</tr>
														<tr>
														<td>Mobile</td>
														<td>
														<?php $flag = base_url().'source/assets/flags/'.$value['emergencyPhoneExtn'].'.png';?>
		                                                <img src="<?=$flag;?>" class="flag-icon">
		                                                <?php echo $value['emergencyContactNumber'];?>
		                                                </td>
														<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
														</tr>
														<tr>
														<td>Relationship</td>
														<td><?php echo $value['emergencyContactRelationship'];?></td>
														<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
														</tr>
													
												<?php } }else { ?>
		             	              					<tr>
														<td colspan="3"> No Records Found </td>
														</tr>
		             							<?php }?>
										</tbody>
									</table>
							    </div> <!-- USER lEFT END -->
							</div> <!-- ACTIVITIES DIV END-->

							
							<div id="activities" class="panel panel-white">
								<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Doctor Information</h4>
								</div>
								<div class="user-left">
									<table class="table table-condensed">
										<tbody>
										<?php
			            					$doctor = $this->profile_model->get_doctor_detail($profile_id);
			            					if(!empty($doctor)) {
			            			            foreach ($doctor as $doc) {
			            				?>
													<tr>
													<td  style="width:40%">Name</td>
													<td>
														<?php echo $doc['doctorFirstName'].''.$doc['doctorMiddleName'].' '.$doc['doctorLastName'];?>
													</td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%"><?php echo $doc['phoneTypeName'];?></td>
													<td>																		
														<?php if($doc['doctorPhoneExtn']){
															$flag = base_url().'source/assets/flags/'.$doc['doctorPhoneExtn'].'.png';?>
															<img src="<?=$flag;?>" class="flag-icon">
														<?php } ?>	
														<?php echo $doc['doctorPhoneNumber'];?>
													</td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%"><?php echo $doc['addressTypeName'];?></td>
													<td><?php
														$address='';
														if($doc['doctorAddressFirstline'] != '')
															$address .= $doc['doctorAddressFirstline'].', '; 
														if($doc['doctorAddressSecondline'] != '')
															$address .= $doc['doctorAddressSecondline'].',<br/>';
														if($doc['doctorCity'] != '')
															$address .= $doc['doctorCity'].', ';
														if($doc['doctorState'] != '')
															$address .= $doc['stateName'].',<br/>';
														if($doc['doctorZip'] != '' && $doc['doctorZip'] != '0')
															$address .= $doc['doctorZip'].',<br/>';
														if($doc['doctorCountry'] != '')
															$address .= $doc['countryName'].',<br/>';
														echo rtrim($address, ",<br/>");
														?>
													</td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<?php }} else { ?>
														<tr>
														<td colspan="3"> No Records Found </td>
														</tr>
													<?php } ?> 
										</tbody>					
									</table>
								</div> <!-- user left end -->
							</div> <!-- Activities tab end -->

							<div id="activities" class="panel panel-white">
								<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Insurance Information</h4>
								</div>
								<div class="user-left">
                                    <table class="table table-condensed">
                                     	<tbody>
										<?php
				            				$insurance = $this->common_model->select_from('Insurance','',array('profileId'=>$profile_id));
				            				if(!empty($insurance)){
				            					foreach($insurance as $ins) { ?>
													<tr>
													<td  style="width:40%">Provider Name</td>
													<td><a href="#"><?php echo $ins['providerName'];?></a></td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%">Plan Id</td>
													<td><a href="#"><?php echo $ins['planId'];?></a></td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%">Group Id</td>
													<td><a href="#"><?php echo $ins['groupId'];?></a></td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%">Payer Id</td>
													<td><a href="#">
													<?php echo $ins['payerId'];?></a></td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%">Expiry Date</td>
													<td><a href="#">
														<?php 
													        $date = $ins['expYear'].'-'.$ins['expMonth'].'-'.$ins['expDay'];
													        if($ins['expYear'] != "" && $ins['expMonth'] != "" && $ins['expDay'] != ""){
													            echo Date('F d, Y',strtotime($date));
													           }
													    ?>
													</a></td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
													<td  style="width:40%">Insurance card scan copy</td>
													<td>
<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="user-image">
												<div class="fileinput-new thumbnail">
												   	<img class="profile" src="<?php echo base_url().'uploads/insurance/front/'.$ins['scanCopyFront'];?>" alt="" >
												</div>
											</div>
										</div>
<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="user-image">
												<div class="fileinput-new thumbnail">
												   	<img class="profile" src="<?php echo base_url().'uploads/insurance/back/'.$ins['scanCopyBack'];?>" alt="" >
												</div>
											</div>
										</div>
													
												
													</td>
													<td><a class="show-tab" href="#profile_edit"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<?php } } else{ ?>
												    <tr>
													<td colspan="3"> No Records Found </td>
													</tr>
												    <?php }?>   
										</tbody>
									</table>
								</div> <!-- user left end -->
							</div> <!-- Activites end -->

							<div id="activities" class="panel panel-white">
								<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Information Sharing</h4>
								</div>
								<div class="user-left">
									<table class="table " >
							           <thead>
							           <tr >
							             <th style="text-align:center;">Topic</th>
							             <th style="text-align:center;">EMS</th>
							             <th style="text-align:center;">Doctor</th>
							             <th style="text-align:center;">School</th>
							             <th style="text-align:center;">Others</th>
							           </tr>
							           </thead>
							           <tbody>
							           <tr>
							           <td>Personal Info</td>
							           
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[0]['personalInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[1]['personalInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff;!important" class="glyphicon glyphicon-<?php echo (@$infosharing[2]['personalInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff;!important"class="glyphicon glyphicon-<?php echo (@$infosharing[3]['personalInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           </tr>
							           <tr>
							           <td>Emergency contact Info</td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[0]['EmergencyContactInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[1]['EmergencyContactInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[2]['EmergencyContactInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[3]['EmergencyContactInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           </tr>
							           <tr>
							           <td>School Info</td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[0]['schoolInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[1]['schoolInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[2]['schoolInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[3]['schoolInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           </tr>
							           <tr>
							           <td>Insurance Info</td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[0]['insuranceInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[1]['insuranceInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[2]['insuranceInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           <td class="center"><i style="color: #007aff; !important" class="glyphicon glyphicon-<?php echo (@$infosharing[3]['insuranceInfo']=='1')?'ok':'remove';?>" style="margin-left: 8px"></i></td>
							           </tr>
							           </tbody>
							        </table>
							    </div> <!-- User left end -->
							</div> <!-- Activities end -->
														
						</div> <!-- second Column End -->
					</div>	<!-- row end -->			   				    
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
				    </div>

				    <div id="profile_edit" class="tab-pane fade">
                                     <?php if(in_array('2',$write_array)) {?>
				    <form name="profile_reg" id="profile_reg" enctype="multipart/form-data" method="post" action="<?php echo base_url('user/editProfile');?>">
<?php //echo "<pre>"; var_dump($profile);
$date = explode('-',@$profile[0]['profileDateOfBirth']);
$dyear = @$date[0];
$dmonth = @$date[1];
$dday = @$date[2];

 ?>
<input type="hidden" name="profile_id" id="profile_id" value="<?=@$profile_id?>" />
<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<fieldset><legend>Enter Personal Info</legend>
		<!--<form >-->
		<div class="form-group">
		<label>Name <span class="symbol required"></span></label>
		  <div class="row">
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" value="<?=@@$profile[0]['profileFirstName']?>" maxlength="20" class="form-control input-sm" name="pfname" id="pfname" placeholder="First">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" value="<?=@@$profile[0]['profileMiddleName']?>" maxlength="20" class="form-control input-sm" name="pmname" id="pmname" placeholder="Middle">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" value="<?=@@$profile[0]['profileLastName']?>" maxlength="20" class="form-control input-sm" name="plname" id="plname" placeholder="Last">
			  </div>
			</div>
		 </div>
		 <div class="form-group">
		 <label>Birthday <span class="symbol required"></span></label>
		  <div class="row">
			  <div class="col-xs-4 col-lg-4 col-md-4">
                            <!--<input type="text" maxlength="2" placeholder="Month" name="pbmonth" id="pbmonth" value="<?=@$dmonth?>" class="form-control input-sm" />-->
			  <select class="form-control input-sm" name="pbmonth" id="pbmonth">
			    <option value="">Month</option>
			    <option <?php echo (@$dmonth == '1')?'selected':''; ?> value="1">January</option>
			    <option <?php echo (@$dmonth == '2')?'selected':''; ?> value="2">February</option>
			    <option <?php echo (@$dmonth == '3')?'selected':''; ?> value="3">March</option>
			    <option <?php echo (@$dmonth == '4')?'selected':''; ?> value="4">April</option>
			    <option <?php echo (@$dmonth == '5')?'selected':''; ?> value="5">May</option>
			    <option <?php echo (@$dmonth == '6')?'selected':''; ?> value="6">June</option>
			    <option <?php echo (@$dmonth == '7')?'selected':''; ?> value="7">July</option>
			    <option <?php echo (@$dmonth == '8')?'selected':''; ?> value="8">August</option>
			    <option <?php echo (@$dmonth == '9')?'selected':''; ?> value="9">September</option>
			    <option <?php echo (@$dmonth == '10')?'selected':''; ?> value="10">October</option>
			    <option <?php echo (@$dmonth == '11')?'selected':''; ?> value="11">November</option>
			    <option <?php echo (@$dmonth == '12')?'selected':''; ?> value="12">December</option>
			    </select>
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			  <select name="pbday" id="pbday" class="form-control input-sm">
					<option value="">Day</option>
					<?php for($day = 1;$day<=31;$day++){
						$selected = ($day == $dday)?'selected':'';
						echo "<option ".$selected." value='".$day."'>".$day."</option>";
					}?>
		     </select>
			    <!--<input type="text" value="<?=@$dday?>" maxlength="2" class="form-control input-sm" name="pbday" id="pbday" placeholder="Day">-->
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			  <select name="pbyear" id="pbyear" class="form-control input-sm">
					<option value="">Year</option>
					<?php for($yr = 1970;$yr<=date('Y');$yr++){
						$selected = ($yr == $dyear)?'selected':'';
						echo "<option ".$selected." value='".$yr."'>".$yr."</option>";
					}?>				
		     </select>
			    <!--<input type="text" value="<?=@$dyear?>" maxlength="4" class="form-control input-sm" name="pbyear" id="pbyear" placeholder="Year">-->
			  </div>
			</div>	 
	     </div>
	   
	    <div class="form-group">
		 
		  <div class="row">
		   
			  <div class="col-xs-6 col-lg-6 col-md-6">
			     <label>Phone <span class="symbol required"></span></label>
			    <input type="text" class="form-control input-sm pphones" value="<?=@$profile[0]['profileMobilePhone']?>" name="pphone" id="pphone" placeholder="Phone">
			    <input type="hidden" value="<?php echo @$profile[0]['profileMobileEx'];?>" name="pphone_ex" id="pphone_ex" />
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Email <span class="symbol required"></span></label>
			    <input type="text" class="form-control input-sm" value="<?=@$profile[0]['profileEmail']?>" name="pemail" id="pemail" placeholder="Email">
			  </div>
			</div>	 
	     </div>
	     
	     
	   <div class="form-group">
		 <label>Gender <span class="symbol required"></span></label>
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			  <div class="clip-radio radio-primary">
					<input type="radio" value="2" name="pgender" class="prgender" id="us-female" <?php if(isset($profile[0]['profileGenderId']) && $profile[0]['profileGenderId'] == '2') echo 'checked=""'; ?>>
					<label for="us-female">
						Female
					</label>
					<input type="radio" value="1" name="pgender" class="prgender" id="us-male" <?php if(isset($profile[0]['profileGenderId']) && $profile[0]['profileGenderId'] == '1') echo 'checked=""'; ?>>
					<label for="us-male">
						Male
					</label>
					<input type="radio" value="3" name="pgender" class="prgender" id="us-other" <?php if(isset($profile[0]['profileGenderId']) && $profile[0]['profileGenderId'] == '3') echo 'checked=""'; ?>>
					<label for="us-other">
						Other
					</label>
				</div>			   
			  </div>		 		  
			</div>	 
	     </div>
	    
		 <label>Address <span class="symbol required"></span></label>
		 <div class="form-group">
		 <div class="row">
		 
			  <div class="col-xs-6 col-lg-6 col-md-6">
			  <label>Firstline</label>
			    <input type="text" class="form-control input-sm" value="<?=@$profile[0]['profileAddressFirstLine']?>" name="profileaddressfirstline" id="profileaddressfirstline" placeholder="Firstline">
			  </div>
			   <div class="col-xs-6 col-lg-6 col-md-6">
			   <label>Secondline</label>
			    <input type="text" class="form-control input-sm" value="<?=@$profile[0]['profileAddressSecondLine']?>" name="profileaddresssecondline" id="profileaddresssecondline" placeholder="Secondline">
			  </div>
			</div>
		</div>	
		<div class="form-group">
			<div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>City</label>
			    <input type="text" class="form-control input-sm" value="<?=@$profile[0]['profileAddressCity']?>" name="profileaddresscity" id="profileaddresscity" placeholder="City">
			  </div>
			   <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Zip</label>
			    <input type="text" maxlength="5" class="form-control input-sm" value="<?php echo ($profile[0]['profileAddressZip'] !='' && $profile[0]['profileAddressZip'] != '0')?$profile[0]['profileAddressZip']:'';?>" name="profileaddresszip" id="profileaddresszip" placeholder="Zip">
			  </div>
			</div>
		</div>	
		<div class="form-group">
			<div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			  <label>State</label>
			    <select class="form-control input-sm" name="profileaddressstate" id="profileaddresstate">
			          <option value="">Select</option>
			          <?php foreach($state as $st){
			          	$selected = (@$profile[0]['profileAddressStateId']==$st['stateId'])?'selected':'';  
			          ?>
			            <option value="<?=$st['stateId']?>"><?=$st['stateName']?></option>
			          <?php } ?>
			          </select>
			  </div>
			   <div class="col-xs-6 col-lg-6 col-md-6">
			   <label>Country</label>
			    <select class="form-control input-sm" name="profileaddresscountry" id="profileaddresscountry">
			          <option value="">Select</option>
			          <?php foreach($country as $coun){
			          	if(@$profile[0]['profileAddressCountryId']==$coun['countryId']){
			          		$selected = 'selected';
			          	}else if($coun['countryId'] == '226')
			          	$selected = 'selected'; 
			          	else $selected = '';
			          ?>			          
			           <option <?=$selected?> value="<?=$coun['countryId']?>"><?=$coun['countryName']?></option>
			          <?php } ?>
			          </select>
			  </div>
			</div>
		</div>
		
		   <div class="checkbox clip-check check-primary checkbox-inline">
														<input type="checkbox" name="sameaddr" <?php echo (@$profile[0]['profileAddressSame'])? 'checked':'';?> value="1" id="checkbox10">
														<label for="checkbox10">
															Same as account address
														</label>
													</div>
			  <!--<div class="col-xs-1 col-lg-1 col-md-1">
			    <input type="checkbox"  name="sameaddr" id="sameaddr" class="">
			  </div>-->
				 
	    <div class="form-group">
				<label>
					Profile Picture
				</label>
				<div data-provides="fileinput" class="fileinput fileinput-new">
					<div class="fileinput-new thumbnail">
					    <?php if($profile[0]['profilePicture'])
								{
									$image = $profile[0]['profilePicture'];
									$url = base_url().'uploads/profileImages/'.$profile[0]['profilePicture'];
								}
								else
								{
									$image = '';
									$url = empty_image();
								}
						?>
					   <img alt="" src="<?=$url?>">
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail"></div>
					<div class="user-edit-image-buttons">
						<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
						   <input type="hidden" name="old_profile_pic" value="<?=@$profile[0]['profilePicture']?>"/>
							<input type="file" class="" name="prof_pic">
						</span>
						<a data-dismiss="fileinput" class="btn fileinput-exists btn-red" href="#">
							<i class="fa fa-times"></i> Remove
						</a>
					</div>
				</div>
			</div>
       <!--<div class="form-group">
		 <label>Profile picture</label>
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <input type="file" class="" name="prof_pic" id="prof_pic">
			    <input type="hidden" name="old_profile_pic" value="<?=@$profile[0]['profilePicture']?>"/>
			    <img class="profile" alt="" src="<?=base_url().'uploads/profileImages/'.@$profile[0]['profilePicture']?>">
			  </div>
			</div>	 
	     </div>-->
		<!--</form>-->
		</fieldset>
		</div>
	</div>

<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<fieldset><legend>Enter Emergency Contact Info</legend>
    	<?php //var_dump($emergency);?>
    	 
    	<div class="emergency">
    	<?php if(!empty($emergency)) {
    	    foreach($emergency as $emergency){ ?>
    	 <div class="emer">
    	 <fieldset class="sub-holder">
    	 <div class="row">
    	 <div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Name:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?php 
		       echo $emergency['emergencyContactFirstName'].' '.$emergency['emergencyContactMiddleName'].' '.$emergency['emergencyContactLastName'];
		       ?></label>
		       <input type="hidden" name="eid[]" id="eid" value="<?=$emergency['emergencyContactId']?>"/>
		       <input type="hidden" name="efirstname[]" id="efirstname" value="<?=$emergency['emergencyContactFirstName']?>" />
		       <input type="hidden" name="emiddlename[]" id="emiddlename" value="<?=$emergency['emergencyContactMiddleName']?>"/>
		       <input type="hidden" name="elastname[]" id="elastname" value="<?=$emergency['emergencyContactLastName']?>"/>
		       <input type="hidden" name="ephonetype[]" id="ephonetype" value="<?=$emergency['emergencyPhoneType']?>" />
		       <input type="hidden" name="emobile[]" id="emobile" value="<?=$emergency['emergencyContactNumber']?>" />
		       <input type="hidden" name="emobile_ex[]" id="emobile_ex" value="<?=$emergency['emergencyPhoneExtn']?>" />
		       <input type="hidden" name="erelation[]" id="erelation" value="<?=$emergency['emergencyContactRelationship']?>" />
		    </div>
		    <div class="col-sm-2">
		    <!--<a href="#" class="edit"><i class="fa fa-pencil-square-o"></i></a>-->
		    <a href="#" class="del"><i class="fa fa-times"></i></a>
		    </div>
		    <div class="col-sm-2">
		    
		    </div>
		    
		 </div>	
		 </div>
		 
		 <div class="row">
		 <div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold"><?php echo $emergency['phoneTypeName'];?>:</span></label>
		    <div class="col-sm-5">
		    <?php $flag = base_url().'source/assets/flags/'.$emergency['emergencyPhoneExtn'].'.png';?>
		    <img src="<?=$flag;?>" class="flag-icon">
		       <label for="name" class="control-label text-info label-view"><?php echo ' '.$emergency['emergencyContactNumber'];?></label>
		    </div>		    
		 </div> 
		 </div>
		 <div class="row">
		 <div class="form-group">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Relationship:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?php echo $emergency['emergencyContactRelationship'];?></label>
		    </div>		    
		 </div>
		 </div>
		 </fieldset>
		 </div>
		 <?php }} ?>  
		 </div>
		<!--<form >-->
		<div class="val-emer">
		<div class="form-group">
		<label>Name</label>
		  <div class="row">
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control clears input-sm" name="efname" id="efname" placeholder="First">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control clears input-sm" name="emname" id="emname" placeholder="Middle">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control clears input-sm" name="elname" id="elname" placeholder="Last">
			  </div>
			</div>
		 </div>
		 <div class="form-group">
		 <label>Phone</label>
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <select class="form-control input-sm" name="ephonetypes" id="ephonetypes">
			    <?php foreach($phone_type as $row) { ?>
			    <option value="<?=$row['id']?>"><?=$row['phoneTypeName']?></option>
			    <?php } ?>
			    </select>
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <input type="text" class="form-control clears input-sm pphones" name="ephone" id="ephone" placeholder="Phone">
			    <input type="hidden" name="ephone_ex" id="ephone_ex" placeholder="Phone">
			  </div>
			</div>	 
	     </div>
	    <div class="form-group">
		 <label>Relationship</label>
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <input type="text" class="form-control clears input-sm" name="erelations" id="erelations" placeholder="Relationship">
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6 pull-right">
			    <input type="button" class="btn btn-default input-sm" name="emer_add" id="emer_add" value="Add More">
			  </div>
			</div>	 
	     </div>
		<!--</form>-->
		</div>
		</fieldset>
		</div>
</div>

<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<fieldset><legend>Enter doctor info</legend>
    	<div class="doctor">
      <?php //var_dump($doctor);?>
      <?php if(!empty($doctor)) {
    	    foreach($doctor as $doctor){ ?>
    	<div class="doc">
    	<fieldset class="sub-holder">
    	<div class="row">
    	 <div class="form-group">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Name:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?php 
		       echo 'Dr. '.$doctor['doctorFirstName'].' '.$doctor['doctorMiddleName'].' '.$doctor['doctorLastName'];
		       ?></label>
		       <input type="hidden" name="did[]" id="did" value="<?=$doctor['doctorDetailsId']?>"/>
		       <input type="hidden" name="dfirstname[]" id="dfirstname" value="<?=$doctor['doctorFirstName']?>" />
		       <input type="hidden" name="dmiddlename[]" id="dmiddlename" value="<?=$doctor['doctorMiddleName']?>"/>
		       <input type="hidden" name="dlastname[]" id="dlastname" value="<?=$doctor['doctorLastName']?>"/>
		       <input type="hidden" name="dphonetype[]" id="dphonetype" value="<?=$doctor['doctorPhoneType']?>"/>
		       <input type="hidden" name="dmobile[]" id="dmobile" value="<?=$doctor['doctorPhoneNumber']?>" />
		       <input type="hidden" name="dphone_ex[]" id="dphone_ex" value="<?=$doctor['doctorPhoneExtn']?>" />
		       <input type="hidden" name="daddr_type[]" id="daddr_type" value="<?=$doctor['doctorAddressType']?>" />
		       <input type="hidden" name="daddrline1[]" id="daddrline1" value="<?=$doctor['doctorAddressFirstline']?>" />
		       <input type="hidden" name="daddrline2[]" id="daddrline2" value="<?=$doctor['doctorAddressSecondline']?>" />
		       <input type="hidden" name="dcity[]" id="dcity" value="<?=$doctor['doctorCity']?>" />
		       <input type="hidden" name="dstate[]" id="dstate" value="<?=$doctor['doctorState']?>" />
		       <input type="hidden" name="dcountry[]" id="dcountry" value="<?=$doctor['doctorCountry']?>" />
		       <input type="hidden" name="dzip[]" id="dzip" value="<?=$doctor['doctorZip']?>" />
		       
		    </div>
		    <div class="col-sm-2">		    
		    <!--<a href="#" class="edit"><i class="fa fa-pencil-square-o"></i></a>-->
		    <a href="#" class="del"><i class="fa fa-times"></i></a>
		    </div>
		 </div>
		 </div>	
		<div class="row">
      <div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold"><?php echo $doctor['phoneTypeName'].':';?></span></label>
		    <div class="col-sm-5">
		       <?php $flag = base_url().'source/assets/flags/'.$doctor['doctorPhoneExtn'].'.png';?>
		       <img src="<?=$flag;?>" class="flag-icon">
		       <label for="name" class="control-label text-info label-view"><?php echo ' '.$doctor['doctorPhoneNumber'];?></label>
		    </div>		    
		 </div> 
		 </div>
		 <div class="row">
		 <div class="form-group">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold"><?php echo $doctor['addressTypeName'].':';?></span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?php echo $doctor['doctorAddressFirstline'].' '.$doctor['doctorAddressSecondline'].' '.$doctor['doctorCity']
		       .''.$doctor['stateName'].', '.$doctor['countryName'].' '.$doctor['doctorZip'];?></label>
		    </div>		    
		 </div>
		 </div>
		 </fieldset>
		</div>
		 <?php }} ?>
		 </div>
		<!--<form >-->
		<div class="val-doc">
		<div class="form-group">
		<label>Name</label>
		  <div class="row">
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control dclears input-sm" name="dfname" id="dfname" placeholder="First">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control dclears input-sm" name="dmname" id="dmname" placeholder="Middle">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" class="form-control dclears input-sm" name="dlname" id="dlname" placeholder="Last">
			  </div>
			</div>
		 </div>
		 <div class="form-group">
		 <label>Phone</label>
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <select class="form-control input-sm" name="dphonetypes" id="dphonetypes">
			    <?php foreach($phone_type as $row) { ?>
			    <option value="<?=$row['id']?>"><?=$row['phoneTypeName']?></option>
			    <?php } ?>
			    </select>
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <input type="text" class="form-control dclears input-sm pphones" name="dphone" id="dphone" placeholder="Phone">
			    <input type="hidden" name="dphone_exs" id="dphone_exs" placeholder="Phone">
			  </div>
			</div>	 
	     </div>
	     
	    <div class="form-group">	    
	    <div class="row">
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label>Address</label>
	    <select class="form-control dclears input-sm addr" id="addr_type" name="addr_type">
		      <option value="">Select</option>
		      <?php foreach($addr_type as $addr){?>
		         	<option value="<?=$addr['id']?>"><?=$addr['addressTypeName']?></option>
		      <?php } ?>
		 </select>
	    </div>
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    
	    </div>
	    </div>	    
	    <div class="row">
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">Address First Line</label>
	    <input type="text" class="form-control dclears input-sm" name="dfline" id="dfline" placeholder="">
	    </div>
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">Address Second Line</label>
	    <input type="text" class="form-control dclears input-sm" name="dsline" id="dsline" placeholder="">
	    </div>
	    </div>	 
	    <div class="row">
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">City</label><br>
	    <input type="text" class="form-control dclears input-sm" name="dcitys" id="dcitys" placeholder="">
	    </div>
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">State</label>			          
       <select class="form-control dclears input-sm addr" name="dstates" id="dstates">
       <option value="">Select</option>
       <?php foreach($state as $st){ ?>
         <option value="<?=$st['stateId']?>"><?=$st['stateName']?></option>
       <?php } ?>
       </select>
	    </div>
	    </div>	 
	    <div class="row">
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">Country</label>			      
          <select class="form-control dclears input-sm addr" name="dcountrys" id="dcountrys">
          <option value="">Select</option>
          <?php foreach($country as $coun){
          	$select = ($coun['countryId']=='226')?'selected':''; 
          ?>
           <option <?=$select?> value="<?=$coun['countryId']?>"><?=$coun['countryName']?></option>
          <?php } ?>
          </select>
	    </div>
	    <div class="col-xs-6 col-lg-6 col-md-6">
	    <label for="gender" class="control-label label-view">Zip Code</label>
		 <input type="text" maxlength='5' class="form-control dclears input-sm" name="dzips" id="dzips" placeholder="">	    
	    </div>
	    </div>	 
	    
	    </div>
	    
	    
	    <div class="form-group">
	    <div class="row pull-right">
	        <div class="col-xs-12 col-lg-12 col-md-12">
			    <input type="button" class="btn btn-default input-sm" name="doctor_add" id="doctor_add" value="Add More">
			  </div>
	    </div>
	    </div>
	     </div>
	    <div class="clearpix"></div>
		<!--</form>-->
		</fieldset>
		</div>
</div>

<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<fieldset><legend>Enter school info</legend> 
		<!--<form >-->
		<div class="row">
		 <div class="col-xs-6 col-lg-6 col-md-6">
		  <div class="form-group">
		    <label>School Name</label>
		    <input type="text" value="<?=@$profile[0]['profileSchoolName']?>" class="form-control input-sm" name="schoolname" id="schoolname" placeholder="School Name">
		  </div>
		  <div class="form-group">
		    <label>School Grade</label>
		    <select class="form-control input-sm" name="grade" id="grade">
			    <option value="">Select</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '1')?'selected':''; ?> value="1">1</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '2')?'selected':''; ?> value="2">2</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '3')?'selected':''; ?> value="3">3</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '4')?'selected':''; ?> value="4">4</option>
             <option <?php echo (@$profile[0]['profileSchoolGrade'] == '5')?'selected':''; ?> value="5">5</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '6')?'selected':''; ?> value="6">6</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '7')?'selected':''; ?> value="7">7</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '8')?'selected':''; ?> value="8">8</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '9')?'selected':''; ?> value="9">9</option>
			    <option <?php echo (@$profile[0]['profileSchoolGrade'] == '10')?'selected':''; ?> value="10">10</option>	
			 </select>
		  </div>
		 </div>	
		 <div class="col-xs-6 col-lg-6 col-md-6">
                  <div class="form-group">
											<label>
												School Logo
											</label>
											<div class="fileinput fileinput-new" data-provides="fileinput">											
												<?php if($profile[0]['profileSchoolLogo'])
														{
															$image = $profile[0]['profileSchoolLogo'];
															$url = base_url().'uploads/school/'.$profile[0]['profileSchoolLogo'];
														}
														else
														{
															$image = '';
															$url = empty_logo();
														}
												?>
												<div class="fileinput-new thumbnail">
												<img src="<?=$url?>" alt="">
												<input type="hidden" name="old_school_logo" value="<?=$image?>" />
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail"></div>
												<div class="user-edit-image-buttons">
													<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
														<input type="file" name="logo" class="form-control">
													</span>
													<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
														<i class="fa fa-times"></i> Remove
													</a>
												</div>												
											</div>
										</div>
		  <!--<div class="form-group">
		   <label>
				School Logo
			</label>
			<div data-provides="fileinput" class="fileinput fileinput-new">
				<div class="fileinput-new thumbnail">
<img src="<?php if($profile[0]['profileSchoolLogo']) echo base_url().'uploads/school/'.$profile[0]['profileSchoolLogo']; else echo empty_logo();?>" alt="" >					
				</div>
				
				<div class="user-edit-image-buttons">
					<span class="btn btn-azure btn-file">
					<span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span>
					   <input type="hidden" name="old_school_logo" value="<?=@$profile[0]['profileSchoolLogo']?>"/>
						<input type="file" class="form-control input-sm" name="logo" id="logo">
					</span>
				</div>
			</div>
		  </div>-->
		 </div>	
		</div>
		
		
	</fieldset>
		</div>
</div>

<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    	<fieldset><legend>Enter insurance info</legend>
    	<div class="insurance">
    	<?php //var_dump($insurance);
    	if(!empty($insurance)){
    	foreach($insurance as $ins){
    	?>
    	<div class="ins">
    	<fieldset class="sub-holder">
    	<div class="row">
    	<div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold"> Provide Name:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?=@$ins['providerName']?></label>
		       <input type="hidden" value="<?=@$ins['insuranceId']?>" name="insuranceid[]" id="" />
		       <input type="hidden" value="<?=@$ins['providerName']?>" name="providername[]" id="" />
		       <input type="hidden" value="<?=@$ins['planId']?>" name="planid[]" id="" />
		       <input type="hidden" value="<?=@$ins['groupId']?>" name="groupid[]" id="" />
		       <input type="hidden" value="<?=@$ins['payerId']?>" name="payerid[]" id="" />
		       <input type="hidden" value="<?=@$ins['expDay']?>" name="edate[]" id="" />
		       <input type="hidden" value="<?=@$ins['expMonth']?>" name="emonth[]" id="" />
		       <input type="hidden" value="<?=@$ins['expYear']?>" name="eyear[]" id="" />
		       <input type="hidden" value="<?=@$ins['scanCopyFront']?>" name="front[]" id="" />
		       <input type="hidden" value="<?=@$ins['scanCopyBack']?>" name="back[]" id="" />
		    </div>		
		    <div class="col-sm-2">
		    <!--<a href="#" class="edit"><i class="fa fa-pencil-square-o"></i></a>-->
		    <a href="#" class="del"><i class="fa fa-times"></i></a>
		    </div>    
		 </div> 
		</div>
		<div class="row">
    	<div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Plan Id:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?=@$ins['planId']?></label>
		    </div>		    
		 </div> 
		</div>
		<div class="row">
		<div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Group Id:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?=@$ins['groupId']?></label>
		    </div>		    
		 </div>
		</div>
		<div class="row">
		 <div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Payer Id:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?=@$ins['payerId']?></label>
		    </div>		    
		 </div> 
		</div>
		<div class="row">
		<div class="form-group ">
		    <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Expiry Date:</span></label>
		    <div class="col-sm-5">
		       <label for="name" class="control-label text-info label-view"><?=@$ins['expMonth'].'-'.@$ins['expDay'].'-'.@$ins['expYear']?></label>
		    </div>		    
		 </div>
		 </div>
		  </fieldset>
		 </div>
		 <?php }} ?>
    	</div>  
    	<div class="clearfix"></div>
    	<br> 
		<!--<form >-->
		<div class="val-ins">
		<div class="form-group">		
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Provider Name</label>
			    <input type="text" class="form-control clears input-sm" name="provider" id="provider" placeholder="Provider Name">
			  </div>			  
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Plan Id</label>
			    <input type="text" class="form-control clears input-sm" name="planids" id="planids" placeholder="Plan Id">
			  </div>			 
			</div>		
		 </div>
	
		<div class="form-group">
		  <div class="row">
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Group Id</label>
			    <input type="text" class="form-control clears input-sm" name="groupids" id="groupids" placeholder="Group Id">
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6">
			    <label>Payer Id</label>
			    <input type="text" class="form-control clears input-sm" name="payid" id="payid" placeholder="Payer Id">
			  </div>
			</div>
		 </div>
		
		 <div class="form-group">
		 <label>Expiry Date</label>
		  <div class="row">
			  <div class="col-xs-4 col-lg-4 col-md-4">
                           <input type="text" maxlength="2" class="form-control clears input-sm" name="imonth" id="imonth" placeholder="Month">
			   <!-- <select class="form-control clears input-sm" name="imonth" id="imonth">
			    <option value="">Month</option>
			    <option value="01">January</option>
			    <option value="02">February</option>
			    <option value="03">March</option>
			    <option value="04">April</option>
			    <option value="05">May</option>
			    <option value="06">June</option>
			    <option value="07">July</option>
			    <option value="08">August</option>
			    <option value="09">September</option>
			    <option value="10">October</option>
			    <option value="11">November</option>
			    <option value="12">December</option>
			    </select>-->
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" maxlength="2" class="form-control clears input-sm" name="iday" id="iday" placeholder="Day">
			  </div>
			  <div class="col-xs-4 col-lg-4 col-md-4">
			    <input type="text" maxlength="4" class="form-control clears input-sm" name="iyear" id="iyear" placeholder="Year">
			  </div>
			</div>	 
	     </div>
		 
	    <div class="form-group">
		 <label>Scan insurance card</label>
		 <div class="file-hide">
		  <div class="row ins-file">
			  <div class="col-xs-6 col-lg-6 col-md-6">	
		 <div class="form-group">
			<label>
				Insurance front
			</label>
			<div class="fileinput fileinput-new" data-provides="fileinput">											
				<div class="fileinput-new thumbnail">
				<img src="<?=empty_logo()?>" alt="">
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail"></div>
				<div class="user-edit-image-buttons">
					<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
						<input type="file" name="logofile1[]" class="form-control">
					</span>
					<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
						<i class="fa fa-times"></i> Remove
					</a>
				</div>												
			</div>
		</div>   
			  </div>
			  <div class="col-xs-6 col-lg-6 col-md-6">
		<div class="form-group">
			<label>
				Insurance back
			</label>
			<div class="fileinput fileinput-new" data-provides="fileinput">											
				<div class="fileinput-new thumbnail">
				<img src="<?=empty_logo()?>" alt="">
				</div>
				<div class="fileinput-preview fileinput-exists thumbnail"></div>
				<div class="user-edit-image-buttons">
					<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
						<input type="file" name="logofile2[]" class="form-control">
					</span>
					<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
						<i class="fa fa-times"></i> Remove
					</a>
				</div>												
			</div>
		</div>	    
			  </div>
			</div>
		  </div>	 
	     </div>
	    <div class="form-group">
	    <div class="row pull-right">
	        <div class="col-xs-12 col-lg-12 col-md-12">
			    <input type="button" class="btn btn-default input-sm" name="insurance_add" id="insurance_add" value="Add More">
			  </div>
	    </div>
	    </div>
	    </div>
	    <div class="clearpix"></div>
		<!--</form>-->
		</fieldset>
		</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	   <fieldset><legend>Information sharing</legend>
	   <div class="clearfix"></div>
        
          <div class="form-group ">
           <div class="col-sm-12">

           <table class="table" >
           <thead>
           <tr>
             <th style="">Topic</th>
             <th style="">EMS</th>
             <th style="">Doctor</th>
             <th style="">School</th>
             <th style="">Others</th>
           </tr>
           </thead>
           <tbody>
           <tr>
           <td>Personal Info</td>
           <input type="hidden" name="personalId" id="" value="<?=@$infosharing[0]['infoSharingId']?>" />
           <input type="hidden" name="emergencyId" id="" value="<?=@$infosharing[1]['infoSharingId']?>" />
           <input type="hidden" name="schoolId" id="" value="<?=@$infosharing[2]['infoSharingId']?>" />
           <input type="hidden" name="insuranceId" id="" value="<?=@$infosharing[3]['infoSharingId']?>" />
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox1" type="checkbox" <?php echo (@$infosharing[0]['personalInfo']=='1')?'checked':'';?> name="ems_personal" id=""/>
                              <label for="checkbox1"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox2" type="checkbox" <?php echo (@$infosharing[1]['personalInfo']=='1')?'checked':'';?> name="doc_personal" id=""/>
           <label for="checkbox2"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox3" type="checkbox" <?php echo (@$infosharing[2]['personalInfo']=='1')?'checked':'';?> name="school_personal" id=""/>
           <label for="checkbox3"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox4" type="checkbox" <?php echo (@$infosharing[3]['personalInfo']=='1')?'checked':'';?> name="other_personal" id=""/>
           <label for="checkbox4"></label></div></td>
           </tr>
           <tr>
           <td>Emergency contact Info</td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox5" type="checkbox" <?php echo (@$infosharing[0]['EmergencyContactInfo']=='1')?'checked':'';?> name="ems_emergency" id=""/>
           <label for="checkbox5"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox6" type="checkbox" <?php echo (@$infosharing[1]['EmergencyContactInfo']=='1')?'checked':'';?> name="doc_emergency" id=""/>
           <label for="checkbox6"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox7" type="checkbox" <?php echo (@$infosharing[2]['EmergencyContactInfo']=='1')?'checked':'';?> name="school_emergency" id=""/>
           <label for="checkbox7"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox8" type="checkbox" <?php echo (@$infosharing[3]['EmergencyContactInfo']=='1')?'checked':'';?> name="other_emergency" id=""/>
           <label for="checkbox8"></label></div></td>
           </tr>
           <tr>
           <td>School Info</td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox9" type="checkbox" <?php echo (@$infosharing[0]['schoolInfo']=='1')?'checked':'';?> name="ems_school" id=""/>
           <label for="checkbox9"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox10_10" type="checkbox" <?php echo (@$infosharing[1]['schoolInfo']=='1')?'checked':'';?> name="doc_school" id=""/>
           <label for="checkbox10_10"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox11" type="checkbox" <?php echo (@$infosharing[2]['schoolInfo']=='1')?'checked':'';?> name="school_school" id=""/>
           <label for="checkbox11"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox12" type="checkbox" <?php echo (@$infosharing[3]['schoolInfo']=='1')?'checked':'';?> name="other_school" id=""/>
           <label for="checkbox12"></label></div></td>
           </tr>
           <tr>
           <td>Insurance Info</td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox13" type="checkbox" <?php echo (@$infosharing[0]['insuranceInfo']=='1')?'checked':'';?> name="ems_ins" id=""/>
           <label for="checkbox13"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox14" type="checkbox" <?php echo (@$infosharing[1]['insuranceInfo']=='1')?'checked':'';?> name="doc_ins" id=""/>
           <label for="checkbox14"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox15" type="checkbox" <?php echo (@$infosharing[2]['insuranceInfo']=='1')?'checked':'';?> name="school_ins" id=""/>
           <label for="checkbox15"></label></div></td>
           <td align=""><div class="checkbox clip-check check-primary checkbox-inline"><input id="checkbox16" type="checkbox" <?php echo (@$infosharing[3]['insuranceInfo']=='1')?'checked':'';?> name="other_ins" id=""/>
           <label for="checkbox16"></label></div></td>
           </tr>
           </tbody>
           </table>
           </div>
          </div>
        </fieldset>   
	</div>
</div>
<div class="row">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<!--<form >-->
	    <div class="form-group">
	    <div class="row pull-right">
	        <div class="col-xs-12 col-lg-12 col-md-12">
			    <a href="<?php echo base_url('home');?>" class="btn btn-danger input-sm" >Cancel</a>
			    <input type="submit" class="btn btn-success input-sm" name="profile_save" value="Save">
			  </div>
	    </div>
	    </div>
	    <div class="clearpix"></div>
		<!--</form>-->
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
				    </div>
				  

					<div id="allergy_overview" class="tab-pane fade">
                                           <?php if(in_array('3',$read_array)) {?>
						<div class="row">							
							<div class="col-md-6 ">
								
								<div class="panel panel-white" id="activities">
									<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Allergy Information</h4>
									</div>
									<div class="user-left">
										<table class="table table-condensed">
											<tbody>
												<?php if(!empty($allergies)){
													    $i =0;
													    foreach($allergies as $aller){ 
													    	if($i != 0) {?>
													    	<tr><td colspan="3">&nbsp;</td></tr>
													    	<?php } ?>
															<tr>
															<td>Allergy Name:</td>
															<td><a href="#"><?=$aller['allergyNameDescription']?></a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
															<td>Allergy Type:</td>
															<td><a href=""><?=$aller['allergyTypeDescription']?></a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
															<td>Symptoms:</td>
															<td><a href="">
																<label for="name" class=""><label class="text-info">Mild:</label><?=$aller['symtomMildDescription']?></label><br>
						     								 	<label for="name" class=""><label class="text-info">Severe:</label><?=$aller['symtomSevereDescription']?></label>
						     								</a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
														<?php $i++;} } else {?>
														<tr>
														<td colspan="3" > No Records Found </td>
														</tr>
												<?php } ?>
											</tbody>
									</table>
									</div>
								</div> <!-- Activities Panel End -->
							</div> <!-- column end -->

							<div class="col-md-6 ">
								
								<div class="panel panel-white" id="activities">
									<div class="panel-heading border-light">
										<h4 class="panel-title text-primary">Allergy Incident Information</h4>
									</div>
									<div class="user-left">
										<table class="table table-condensed">
											<tbody>
												<?php if(!empty($incidents)){
													    $i = 0;
													    foreach($incidents as $inci){ 
													    	if($i != 0) {?>
													        <tr><td colspan="3">&nbsp;</td></tr>
													        <?php } ?>
															<tr>
															<td>Incident Date:</td>
															<td><a href="#"><?=$inci['allergyIncidentDate']?></a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
															<td>Allergy Type:</td>
															<td><a href=""><?=$inci['allergyTypeDescription']?></a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>
															<tr>
															<td>Description:</td>
															<td><a href=""><?=$inci['allergyIncidentDesc']?></a></td>
															<td><a href="#panel_edit_allergy" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
															</tr>

														<?php $i++; } } else {?>
														<tr>
														<td colspan="3" > No Records Found </td>
														</tr>
												<?php } ?>
											</tbody>
									</table>
									</div>
								</div> <!-- Activities Panel End -->
							</div> <!-- column end -->
						</div>  <!-- row ene -->
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
					<div id="panel_edit_allergy" class="tab-pane fade">
			                  <?php if(in_array('3',$write_array)) {?>
					    <form method="post" name="edit_allergy" id="edit_allergy" action="<?php echo site_url('user/editAllergy');?>">
                        <input type="hidden" name="profile_id" value="<?=$profile_id?>" />
					    <fieldset><legend>Enter Allergy Info</legend>
					    
						    <div class="wrappers">
						    	<?php if(!empty($allergies)){
										foreach($allergies as $all){ ?>
										<div class="mods">
										<fieldset class="sub-holder">
											<div class="row">												
											 <div class="form-group">
														<label class="col-md-3 control-label"><span class="text-bold">Allergy Name:</span></label>
																																	
												<div class="col-md-5">
													<!--<div class="form-group">-->
														<!--<span class="input-icon">-->
														   <label class="control-label text-info label-view"><?=$all['allergyNameDescription']?></label>
															<!--<input type="text" readonly class="per-phone" id="view_allergy_name" value="<?=$all['allergyNameDescription']?><?=$all['allergyId']?>" name="view_allergy_name[]"/>-->
															<input type="hidden" id="view_allergy_name_id" name="view_allergy_name_id[]"/>
															<input type="hidden" value="<?=$all['allergyId']?>" name="exist_allergy_id[]" />
														<!--</span>-->
													<!--</div>-->
												</div>
											
												<div class="col-md-2">
													<!--<div class="form-group">-->
														<!--<a href="#" class="edit"><i class="fa fa-pencil-square-o"></i></a>-->
		                                    <a href="#" class="remove_field"><i class="fa fa-times"></i></a>
													<!--</div>-->
												</div>
											  </div>
											</div>

											<div class="row">												
											 <div class="form-group">
														<label class="col-md-3 control-label"><span class="text-bold">Allergy Type:</span></label>
													
												<div class="col-md-5">
													<!--<div class="form-group">-->
														<!--<span class="input-icon">-->
														   <label class="control-label text-info label-view"><?=$all['allergyTypeDescription']?></label>
															<!--<input type="text" readonly class="per-phone" id="view_allergy_type" value="<?=$all['allergyTypeDescription']?>" name="view_allergy_type[]"/>-->
															<input type="hidden" id="view_allergy_type_id" name="view_allergy_type_id[]" />
														<!--</span>-->
													<!--</div>-->
												</div>
											 </div>
											</div>

											<div class="row">												
											 <div class="form-group">
												<label class="col-md-3 control-label"><span class="text-bold">Symptoms:</span></label>													
											
												<div class="col-md-5">
												   	<div class="row">
												   		<div class="col-md-12">
												   		 	<!--<div class="form-group">-->
																<label class="text-info">Mild:</label>								                          
																
																<span class="input-icon">
																 <?=$all['symtomMildDescription']?>
																 <input type="hidden" name="view_mild_id[]"  id="view_mild_id">
										    					 <input type="hidden" id="view_mild_others" name="view_mild_others[]"/>
																</span>
															   <!--</div>-->
												   		</div>
												   	</div>

												   	<div class="row">
												   		<div class="col-md-12">
												   		 	<!--<div class="form-group">-->
																<label class="text-info">Severe</label>
																<span class="input-icon">
																 <?=$all['symtomSevereDescription']?>
																 <input type="hidden"  id="view_severe_others" name="view_severe_others[]"/> 
										    					 <input type="hidden" name="view_severe_id[]"  id="view_severe_id"> 
																</span>
															   <!--</div>-->
												   		</div>
												   	</div>
												</div>
												</div>
											</div>
                               </fieldset>
										</div> <!-- mods end -->
									<?php }} ?>
						    </div> <!-- wrapper end -->
						    <div class="allergy_info">
						    	<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Allergy Name <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clear" name="allergy_name" id="allergy_name">
											    <option value="">Select</option>
											    <?php foreach($allergy_name as $row) { ?>
											    <option value="<?=$row['allergyNameId']?>"><?=$row['allergyNameDescription']?></option>
											    <?php } ?>
											    <option value="others">Other</option>
											    </select>
											</span>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Allergy Type <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clear" name="allergy_type" id="allergy_type">
											    <option value="">Select</option>
											    <?php foreach($allergy_type as $row) { ?>
											    <option value="<?=$row['allergyTypeId']?>"><?=$row['allergyTypeDescription']?></option>
											    <?php } ?>
											    <option value="others">Other</option>
											    </select>
											</span>
										</div>
									</div>
									
								</div>
								<div class="row">

								    <div class="col-md-6">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="name_other">
												<span class="input-icon">
													<input type="text" class="form-control clear " name="allergy_name_others" id="allergy_name_others" placeholder="">
											    </span>
											</div>
										</div>
	                                </div>
					
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="type_other">
												<span class="input-icon">
													<input type="text" class="form-control clear " name="allergy_type_others" id="allergy_type_others" placeholder="">
											    </span>
											</div>
										</div>
	                                </div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Symptoms Severe <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clear" multiple="multiple" name="symptoms_severe[]" id="symptoms_severe">
											    <option value="">Select</option>
											    <?php foreach($symptoms_severe as $row) { ?>
											    <option value="<?=$row['symtomSevereId']?>"><?=$row['symtomSevereDescription']?></option>
											    <?php } ?>
											    <option value="others">Other</option>
											    </select>
											</span>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Symptoms Mild <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clear" multiple="multiple" name="symptoms_mild[]" id="symptoms_mild">
											    <option value="">Select</option>
											    <?php foreach($symptoms_mild as $row) { ?>
											    <option value="<?=$row['symtomMildId']?>"><?=$row['symtomMildDescription']?></option>
											    <?php } ?>
											    <option value="others">Other</option>
											    </select>
											</span>
										</div>
									</div>
									
								</div>

								<div class="row">

								    <div class="col-md-6 ">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="severe_other">
												<span class="input-icon">
													<input type="text" class="form-control clear " name="symptoms_severe_others" id="symptoms_severe_others" placeholder="">
											    </span>
											</div>
										</div>
	                                </div>
									
									
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="mild_other">
												<span class="input-icon">
													<input type="text" class="form-control clear " name="symptoms_mild_others" id="symptoms_mild_others" placeholder="">
											    </span>
											</div>
										</div>
	                                </div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default pull-right" name="allergy_add" id="allergy_add" value="Add More">
									</div>
								</div>
	                            <hr/>
								
	                        
	                        </div> <!-- allergy info end -->
	                        	
	                    </fieldset>

	                    <fieldset><legend>Enter Incident Info</legend>
					    
						    <div class="inci-wrappers">
						    	<?php if(!empty($incidents)){
										foreach($incidents as $in){ ?>
										<div class="incident">
										<fieldset class="sub-holder">
											<div class="row">												
											<div class="form-group">
												<label class="col-md-3 control-label"><span class="text-bold">Incident Date:</span></label>		
												<div class="col-md-5">													
														<!--<span class="input-icon">-->
														   <label class="control-label text-info label-view"><?=$in['allergyIncidentDate']?></label>
															<input type="hidden" value="<?=$in['allergyIncidentId']?>" name="exist_incident_id[]" />
				      									<input type="hidden" value="" id="inci_date" name="inci_date[]" />
														<!--</span>-->													
												</div>
												<div class="col-md-2">												
														<!--<a href="#" class="edit"><i class="fa fa-pencil-square-o"></i></a>-->
		                                    <a href="#" class="incident_remove"><i class="fa fa-times"></i></a>												
												</div>
											</div>
											</div>

											<div class="row">												
											 <div class="form-group">
												<label class="col-md-3 control-label"><span class="text-bold">Allergy Type:</span></label>													
											
												<div class="col-md-5">			
												   		<label class="control-label text-info label-view"><?=$in['allergyTypeDescription']?></label>	
															<input type="hidden" class="per-phone" id="inci_view_allergy" value="<?=$in['allergyTypeDescription']?>" name="inci_view_allergy[]"/>
				      									<input type="hidden" value="" id="inci_view_allergy_id" name="inci_view_allergy_id[]" />									
												</div>
											 </div>
											</div>

											<div class="row">
											 <div class="form-group">
												<label class="col-md-3 control-label"><span class="text-bold">Description:</span></label>													
											
												<div class="col-md-5">			
												   		<label class="control-label text-info label-view"><?=$in['allergyIncidentDesc']?></label>	
															<input type="hidden" value="<?=$in['allergyIncidentDesc']?>" class="per-phone" readonly id="description" name="description[]" />
												</div>
											 </div>																		
											</div>
                               </fieldset>
										</div> <!-- incident end -->
									<?php }} ?>
						    </div> <!-- inci-wrapper end -->
						    <div class="inci-val">
						      <div class="form-group">
							      <label>Incident Date <span class="symbol required"></span></label>
							      <div class="row">
						           <div class="col-md-4">
						           <input type="text" maxlength="2" class="form-control clears " name="amonth" id="amonth" placeholder="Month">
						           </div>
						           <div class="col-md-4">
						           <input type="text" maxlength="2" class="form-control clears " name="aday" id="aday" placeholder="Day">
						           </div>
						           <div class="col-md-4">
						           <input type="text" maxlength="4" class="form-control clears " name="ayear" id="ayear" placeholder="Year">
						           </div>
						         </div>
						    </div>
						  		<!--<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">
												Birthday<span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clears" name="amonth" id="amonth">
											    <option value="">Month</option>
											    <option value="01">January</option>
											    <option value="02">February</option>
											    <option value="03">March</option>
											    <option value="04">April</option>
											    <option value="05">May</option>
											    <option value="06">June</option>
											    <option value="07">July</option>
											    <option value="08">August</option>
											    <option value="09">September</option>
											    <option value="10">October</option>
											    <option value="11">November</option>
											    <option value="12">December</option>
											    </select>
											</span>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="others">
												<span class="input-icon">
													<input type="text" class="form-control clears " name="aday" id="aday" placeholder="Day">
											    </span>
											</div>
										</div>
	                                </div>
	                                <div class="col-md-4">
										<div class="form-group">
											<label class="control-label"></label>
											<div class="others">
												<span class="input-icon">
													 <input type="text" class="form-control clears " name="ayear" id="ayear" placeholder="Year">
											    </span>
											</div>
										</div>
	                                </div>
								</div>-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Allergy Type <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<select class="form-control clears" name="inci_allergy_type" id="inci_allergy_type">
											    <option value="">Select</option>
											    <?php foreach($allergy_type as $row) { ?>
											    <option value="<?=$row['allergyTypeId']?>"><?=$row['allergyTypeDescription']?></option>
											    <?php } ?>
											    <option value="others">Other</option>
											    </select>
											</span>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">
												Description <span class="symbol required"></span>
											</label>
											<span class="input-icon">
												<textarea id="inci_desc" name="inci_desc" class="form-control clears"></textarea>
											</span>
										</div>
									</div>
								</div>

								<div class="row inci_allergy_others">
								    <div class="col-md-6">
										<div class="form-group">
											<label class="control-label"></label>
											<!-- <div class="others"> -->
												<span class="input-icon">
													<input type="text" class="form-control clears " name="inci_allergy_type_others" id="inci_allergy_type_others" placeholder="">
											    </span>
											<!-- </div> -->
										</div>
	                                </div>
									
								</div>

								<div class="row">
									<div class="col-md-12">
										<input type="button" class="btn btn-default pull-right" name="incident_submit" id="incident_submit" value="Add More">
									</div>
								</div>
	                            <hr/>
								<div class="row">
									<div class="col-md-8">
										<p>
											By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
										</p>
									</div>
									<div class="col-md-4">
										<input class="btn btn-primary pull-right" type="submit" id="save" name="save" value="Update"/>
										<!--  <i class="fa fa-arrow-circle-right"></i> -->
									</div>
								</div>
	                        
	                        
	                        </div> <!-- Incident info end -->
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
					</div><!-- Panel edit allergy -->
					
			    </div> <!-- tab content end -->
			</div> <!-- tabbable end -->
		</div> <!-- column end -->
	</div> <!-- Row end -->
</div> <!-- Container end -->
<!-- end: USER PROFILE -->
</div>
<script>
$(document).ready(function(){
	
    $('.name_other').hide();
    $('.type_other').hide();
    $('.severe_other').hide();
    $('.mild_other').hide();
    $('.inci_allergy_others').hide();
    var wrapper         = $(".wrappers"); //Fields wrapper
    var add_button      = $("#allergy_add"); //Add button ID
    
    var hid_name = '';
    var hid_type = '';
    var hid_mild = '';
    var hid_sev = '';
    
    
    //validation on blur action
    $.each($(".allergy_info select, .allergy_info input[type=text]"),function (key,val) {
	    $(this).on('keydown change blur keyup',function () {
	    	$(this).closest("div").find(".error").remove();
		   $(this).css("border","1px solid #ccc");   //initially to clear all red outside text box
	    	var val = $(this).val();
	    	var can_show_error = 1;
	    	var msg = '';
	    	if((val == '' || val == null) && $(this).attr('id')!='allergy_name_others' && $(this).attr('id')!='allergy_type_others' && $(this).attr('id')!='symptoms_severe_others' && $(this).attr('id')!='symptoms_mild_others'){
	    		error = 1;
	    		msg = "Required"; 
	    	}else{
	    		if($('#allergy_name').val() == 'others')
			      {
			      	$('.name_other').show();
			      }
			      else
			      {
			      	$('.name_other').hide();
			      }
	      if($(this).attr('id') == 'allergy_name_others' && $('#allergy_name').val() == 'others')
	      {	
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	 
	      }
	      if($('#allergy_type').val() == 'others')
	      {
	      	$('.type_other').show();
	      }
	      else
	      {
	      	$('.type_other').hide();
	      }
	  if($(this).attr('id') == 'allergy_type_others' && $('#allergy_type').val() == 'others')
	      {	
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	   
	      }
	      if($.inArray('others',$('#symptoms_severe').val()) != -1)
	      {
	      	$('.severe_other').show();
	      }
	      else
	      {
	      	$('.severe_other').hide();
	      }
	  if($(this).attr('id') == 'symptoms_severe_others' && $.inArray('others',$('#symptoms_severe').val()) != -1)	
	      {	
	     
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	   
	      }
	      if($.inArray('others',$('#symptoms_mild').val()) != -1)
	      {
	      	$('.mild_other').show();
	      } 
	   else
	   {
	   	$('.mild_other').hide();
	   } 
	  if($(this).attr('id') == 'symptoms_mild_others' && $.inArray('others',$('#symptoms_mild').val()) != -1 )
	      {	
	          var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	    
	      }
    		if($(this).attr('id') == 'allergy_name' && $(this).val() == 'others' && $('#allergy_name_others').val() == '')
    		{
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";
 		   	$("#allergy_name_others").css("border","1px solid #a94442");
 	      	if($("#allergy_name_others").closest("div").find(".error").length){ $("#allergy_name_others").closest("div").find(".error").remove() }
 	      	$("#allergy_name_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'allergy_type' && $(this).val() == 'others' && $('#allergy_type_others').val() == '')
    		{
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required"; 		   	 
 		   	$("#allergy_type_others").css("border","1px solid #a94442");
 	      	if($("#allergy_type_others").closest("div").find(".error").length){ $("#allergy_type_others").closest("div").find(".error").remove() }
 	      	$("#allergy_type_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'symptoms_severe' && $(this).val() == 'others' && $('#symptoms_severe_others').val() == '')
    		{
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required"; 		   	        
 		   	$("#symptoms_severe_others").css("border","1px solid #a94442");
 	      	if($("#symptoms_severe_others").closest("div").find(".error").length){ $("#symptoms_severe_others").closest("div").find(".error").remove() }
 	      	$("#symptoms_severe_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'symptoms_mild' && $(this).val() == 'others' && $('#symptoms_mild_others').val() == '')
    		{
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";		   	       
 		   	$("#symptoms_mild_others").css("border","1px solid #a94442");
 	      	if($("#symptoms_mild_others").closest("div").find(".error").length){ $("#symptoms_mild_others").closest("div").find(".error").remove() }
 	      	$("#symptoms_mild_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	}
      if(can_show_error == 1 && msg != '')
      {
      	$(this).css("border","1px solid #a94442");
    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
      }    
	    });
    });
    $(add_button).click(function(e){ //on add input button click
    	
    var a_name = $('#allergy_name').val();
    var a_name_other = $('#allergy_name_others').val();
    var a_type = $('#allergy_type').val();
    var a_type_other = $('#allergy_type_others').val();
    var a_s_severe = $('#symptoms_severe').val();
    var a_s_severe_other = $('#symptoms_severe_others').val();
    var a_s_mild = $('#symptoms_mild').val();
    var a_s_mild_other = $('#symptoms_mild_others').val();
    
    
   /* $.each($(".allergy_info .form-group"),function (key,val) {
    	if($(this).find("select").length)
    	{
    		var selector = $(this).find("select");
    		selector.css("border","1px solid #ccc");
    		selector.closest(".row").find(".others input[type=text]").css("border","1px solid #ccc");
    		var others_selector = selector.closest(".row").find(".others input[type=text]");    		
    		var others = others_selector.val();
    		if(selector.val() == "")
    		{
				selector.css("border","1px solid #ff0000");
				return false;
			}
			else if(selector.val() == "others" && others == "")
			{
				selector.closest(".row").find(".others input[type=text]").css("border","1px solid #ff0000");
				return false;
			}
    	}
    });*/
 
    var error = '';
    $(".error").remove(); 
     
    $.each($(".allergy_info select, .allergy_info input[type=text]"),function (key,val) {
    	
	   $(this).css("border","1px solid #ccc");   //initially to clear all red outside text box
    	var val = $(this).val();
    	var can_show_error = 1;
    	var msg = "";   
    	if((val == '' || val == null) && $(this).attr('id')!='allergy_name_others' && $(this).attr('id')!='allergy_type_others' && $(this).attr('id')!='symptoms_severe_others' && $(this).attr('id')!='symptoms_mild_others'){
    		error = 1;
    		msg = "Required"; 
    	}else{
    		if($('#allergy_name').val() == 'others')
		      {
		      	$('.name_other').show();
		      }
		      else
		      {
		      	$('.name_other').hide();
		      }
    		 if($(this).attr('id') == 'allergy_name_others' && $('#allergy_name').val() == 'others')
	      {	
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	 
	      }

	      if($('#allergy_type').val() == 'others')
	      {
	      	$('.type_other').show();
	      }
	      else
	      {
	      	$('.type_other').hide();
	      }
	  if($(this).attr('id') == 'allergy_type_others' && $('#allergy_type').val() == 'others')
	      {	
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	   
	      }

	      if($.inArray('others',$('#symptoms_severe').val()) != -1)
	      {
	      	$('.severe_other').show();
	      }
	      else
	      {
	      	$('.severe_other').hide();
	      }
	  if($(this).attr('id') == 'symptoms_severe_others' && $.inArray('others',$('#symptoms_severe').val()) != -1)	
	      {	
	     
    		   	var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	   
	      }

	      if($.inArray('others',$('#symptoms_mild').val()) != -1)
	      {
	      	$('.mild_other').show();
	      } 
	   else
	   {
	   	$('.mild_other').hide();
	   }   
	  if($(this).attr('id') == 'symptoms_mild_others' && $.inArray('others',$('#symptoms_mild').val()) != -1 )
	      {	
	          var patt=/[^a-zA-Z0-9 ._-]/;
			        if($(this).val().match(patt)){		
			          error = 1;		           
 	      		    msg = 'No special characters';
 	      		  }	    
	      }
    		if($(this).attr('id') == 'allergy_name' && $(this).val() == 'others' && $('#allergy_name_others').val() == '')
    		{
    		
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";
 		   	$("#allergy_name_others").css("border","1px solid #a94442");
 	      	if($("#allergy_name_others").closest("div").find(".error").length){ $("#allergy_name_others").closest("div").find(".error").remove() }
 	      	$("#allergy_name_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'allergy_type' && $(this).val() == 'others' && $('#allergy_type_others').val() == '')
    		{
    			
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";
 		   	$("#allergy_type_others").css("border","1px solid #a94442");
 	      	if($("#allergy_type_others").closest("div").find(".error").length){ $("#allergy_type_others").closest("div").find(".error").remove() }
 	      	$("#allergy_type_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'symptoms_severe' && $(this).val() == 'others' && $('#symptoms_severe_others').val() == '')
    		{
    			
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";
 		   	$("#symptoms_severe_others").css("border","1px solid #a94442");
 	      	if($("#symptoms_severe_others").closest("div").find(".error").length){ $("#symptoms_severe_others").closest("div").find(".error").remove() }
 	      	$("#symptoms_severe_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	   if($(this).attr('id') == 'symptoms_mild' && $(this).val() == 'others' && $('#symptoms_mild_others').val() == '')
    		{
    			can_show_error = 0;
    			error = 1;
 		   	msg = "Required";
 		   	$("#symptoms_mild_others").css("border","1px solid #a94442 !important");
 	      	if($("#symptoms_mild_others").closest("div").find(".error").length){ $("#symptoms_mild_others").closest("div").find(".error").remove() }
 	      	$("#symptoms_mild_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		}
    	}
    	
      if(can_show_error == 1 && msg != '')
      {

      	$(this).css("border","1px solid #a94442");
    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
      }    	
    });
    
    if(error == 1)
    {
    return false;
    }
    
    /*if(a_name == ''){
    	alert('Select allergy name');
    	return false;
    }else if(a_type == ''){
    	alert('Select allergy type');
    	return false;
    }else if(a_s_severe == ''){
    	alert('Select symptoms severe');
    	return false;
    }else if(a_s_mild == ''){
    	alert('Select symptoms mild');
    	return false;
    }*/
    if(a_name == 'others'){
    	if(a_name_other != '')
    	   hid_name = a_name_other;
    }else{
    	hid_name = $("#allergy_name option:selected").text();
    }
    if(a_type == 'others'){
    	if(a_type_other != '')
    	hid_type = a_type_other;
    }else{
    	hid_type = $("#allergy_type option:selected").text();
    }
    /*if(a_s_severe == 'others'){
    	if(a_s_severe_other != '')
    	hid_sev = a_s_severe_other;
    	else{
    	   alert('Enter other symptom severe');
    	   return false;
    	  }
    }else{*/
    	//var str2;
    	var view_others_severe = '';
    	$('#symptoms_severe option:selected').each(function() {
    		if($(this).val() == "others")
    		{
    		 view_others_severe = a_s_severe_other;
    		 hid_sev += '<li>'+a_s_severe_other+'</li>';
    	   }
         else
         {
         	hid_sev += '<li>'+$(this).text()+'</li>';
         }     
      });
    	//hid_sev = $("#symptoms_severe option:selected").text();
    //}
    var view_others_mild = '';
    $('#symptoms_mild option:selected').each(function() {
    		if($(this).val() == "others")
    		{
    		   view_others_mild = a_s_mild_other;
    		   hid_mild += '<li>'+a_s_mild_other+'</li>';
    		}
    		else
    		{
    			hid_mild += '<li>'+$(this).text()+'</li>';
    		}         
      });
    /*if(a_s_mild == 'others'){
    	if(a_s_mild_other != '')
    	hid_mild = a_s_mild_other;
    	else{
    	   alert('Enter other symptom mild');
    	   return false;
    	  }
    }else{
    	hid_mild = $("#symptoms_mild option:selected").text();
    }*/
    //alert(hid_name+'-'+hid_type+'-'+hid_sev+'-'+hid_mild);
    //return false;
    
        e.preventDefault();
     //   alert();
           var html = '';
         
           $(wrapper).append('<div class="mods"> <fieldset class="sub-holder"> <div class="row"> <div class="form-group"> <label class="col-md-3 control-label"><span class="text-bold">Allergy Name:</span></label> <div class="col-md-5"> <label class="text-info"> '+hid_name+'</label> <input type="hidden" class="per-phone" id="view_allergy_name" value="'+hid_name+'" name="view_allergy_name[]"/> <input type="hidden" id="view_allergy_name_id" value="'+a_name+'" name="view_allergy_name_id[]"/> <input type="hidden" value="" name="exist_allergy_id[]" /> </div> <div class="col-md-2"> <a href="#" class="remove_field"><i class="fa fa-times"></i></a> </div> </div> </div> <div class="row"> <div class="form-group"> <label class="col-md-3 control-label"><span class="text-bold"> Allergy Type:</span></label> <div class="col-md-5"> <label class="text-info"> '+hid_type+'</label> <input type="hidden" class="per-phone" id="view_allergy_type" value="'+hid_type+'" name="view_allergy_type[]"/> <input type="hidden" value="'+a_type+'" id="view_allergy_type_id" name="view_allergy_type_id[]" /> </div> </div> </div> <div class="row"> <div class="form-group"> <label class="col-md-3 control-label"><span class="text-bold">Symptoms:</span></label> <div class="col-md-5"> <div class="row"> <div class="col-md-12"> <label class="text-info">Mild:</label> <span class="input-icon"> <input type="hidden" name="view_mild_id[]" value="'+a_s_mild+'" id="view_mild_id"> <input type="hidden" value="'+view_others_mild+'" id="view_mild_others" name="view_mild_others[]"/> '+hid_mild+' </span> </div> </div> <div class="row"> <div class="col-md-12"> <label class="text-info">Severe</label> <span class="input-icon"> <input type="hidden" value="'+view_others_severe+'" id="view_severe_others" name="view_severe_others[]"/> <input type="hidden" name="view_severe_id[]" value="'+a_s_severe+'" id="view_severe_id">  '+hid_sev+'</span></div></div></div></div></div></fieldset> </div>');
           $('.clear').val('');
    $('.name_other').hide();
    $('.type_other').hide();
    $('.severe_other').hide();
    $('.mild_other').hide();
    $('.inci_allergy_others').hide();

   });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.mods').remove();
    });
    
  //-------------------------------------------Incident validation begins here -------------------------------------------------------////  
    var inci_wrapper = $(".inci-wrappers"); //Fields wrapper
    var inci_button = $("#incident_submit"); //Add button ID
    //to clear validation msgs
    var currentYear = (new Date).getFullYear();
 	 var currentMonth = (new Date).getMonth()+1;  
 	 var currentDay = (new Date).getDate(); 
    $.each($(".inci-val input[type=text],.inci-val select,.inci-val textarea"),function (key,val) {
    	$(this).on('keydown change keyup blur',function () {
    		$(this).closest("div").find(".error").remove();
	      $(this).css("border","1px solid #ccc");   //initially to clear all red outside text box
	    	   var arr_months = {1:31,2:28,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31};
	    	   if(parseInt($('#ayear').val()) % 4 == 0 && $('#ayear').val() != ""){ arr_months[2] = 29; }
	    	   var val = parseInt($(this).val());	    	   
	    	   var can_show_err = 1;
	    	   var msg = "";    	  
    		   if($(this).val() == '' && $(this).attr('id')!='inci_allergy_type_others'){
    		      error = 1;   		 
    		      msg = "Required";
    	      }else{
    	      	if($('#inci_allergy_type').val() == 'others')
			      {
			      	$('.inci_allergy_others').show();
			      } 
			     else
			     {
			     	$('.inci_allergy_others').hide();
			     }
    	      	if($(this).attr('id') == 'inci_allergy_type_others' && $('#inci_allergy_type').val() == 'others')
				      {	
			    		   	var patt=/[^a-zA-Z0-9 ._-]/;
						        if($(this).val().match(patt)){		
						          error = 1;		           
			 	      		    msg = 'No special characters';
			 	      		  }	   
				      }
    	      	if($(this).attr('id')=='amonth')
    	      	{
    	      		if(!arr_months.hasOwnProperty(val) ) 
    	      		{ error = 1; msg = "Not a valid month"; }
    	      	   else if(parseInt($('#ayear').val())>currentYear)
					  	{
					  		{ error = 1; msg = "Not a valid month"; }
					  	}
					   else if(parseInt($('#ayear').val())==currentYear)
					   {
					      if (val > currentMonth)
					      { error = 1; msg = "Not a valid month"; }
					   }
    	      	   
    	      	}
    	         if($(this).attr('id')=='aday')
    	      	{
    	      		var mon = parseInt($('#amonth').val());
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   	  
    	      	   else if(parseInt($('#ayear').val())>currentYear)
					  	{
					  		error = 1; msg = "Not a valid day";
					  	}
					   else if(parseInt($('#ayear').val())==currentYear)
					   {
					      if (mon >= currentMonth && val > currentDay){
					        error = 1; msg = "Not a valid day";
					      }
					   }    		
    	      	}
    	         if($(this).attr('id')=='ayear')
    	      	{
    	      		var limit = 100;
    	      		var end_date = (new Date).getFullYear();
    	      		var start_date = end_date - limit;   	      	
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      		if(val < start_date || val > end_date){error = 1; msg = "Range between "+start_date+" & "+end_date;}
    	      	   if(val % 4 == 0){
    	      	   	arr_months[2] = 29;
    	      	   	var mon = parseInt($('#amonth').val());
    	      	      if(parseInt($('#aday').val()) <= 0 || parseInt($('#aday').val()) > arr_months[mon]){
    	      	      	error = 1; msg = "Invalid day";
    	      	      	var can_show_err = 0;
    	      	      	$("#aday").css("border","1px solid #a94442");
    	      	      	if($("#aday").closest("div").find(".error").length){ $("#aday").closest("div").find(".error").remove() }
    	      	      	$("#aday").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      	      }    	      	      
    	      	   }
    	      		
    	      	  /* var mon = parseInt($('#amonth').val());   	      	  
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   */      		
    	      	}
    	         if($(this).attr('id')=='inci_allergy_type')
    		   	{
    		   		if($(this).val() == 'others' && $('#inci_allergy_type_others').val() == '')
    		   		{
    		   			can_show_err = 0;
    		   			error = 1;
    		   			msg = "Required";
    		   			$("#inci_allergy_type_others").css("border","1px solid #a94442");
    	      	      if($("#inci_allergy_type_others").closest("div").find(".error").length){ $("#inci_allergy_type_others").closest("div").find(".error").remove() }
    	      	      $("#inci_allergy_type_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		   		}
    		   		
    		   	}
    	      }
    	      if(can_show_err == 1 && msg !='')
    	      {
    	      	$(this).css("border","1px solid #a94442");
    	      	$(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      }
       });
    });
 
    $(inci_button).click(function(e){ //on add input button click
    var error='';
    var i_month = $('#amonth').val();
    var i_day = $('#aday').val();
    var i_year = $('#ayear').val();
    var i_allergy = $('#inci_allergy_type').val();
    var i_allergy_other = $('#inci_allergy_type_others').val();
    var i_desc = $('#inci_desc').val();
    var hid_aller_name = '';
    var hid_date = '';
    var date_form = '';
    
    if(i_allergy == 'others'){
    	if(i_allergy_other != '')
    	   hid_aller_name = i_allergy_other;
    }else{
    	hid_aller_name = $("#inci_allergy_type option:selected").text();
    }
    hid_date = i_year+'-'+i_month+'-'+i_day;
    hid_date_form = $("#amonth option:selected").text()+' '+i_day+', '+i_year;
    
   
    
    //validation
    $(".error").remove();   
	    $.each($(".inci-val input[type=text],.inci-val select,.inci-val textarea"),function (key,val) {
	    	$(this).css("border","1px solid #ccc");   //initially to clear all red outside text box
	    	   var arr_months = {1:31,2:28,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31};
	    	   if(parseInt($('#ayear').val()) % 4 == 0 && $('#ayear').val() != ""){ arr_months[2] = 29; }
	    	   var val = parseInt($(this).val());
	    	   var can_show_err = 1;
	    	   var msg = "";    	  
    		   if($(this).val() == '' && $(this).attr('id')!='inci_allergy_type_others'){		     
    		      	error = 1;   		 
    		         msg = "Required";    		     
    	      }else{
    	      	if($('#inci_allergy_type').val() == 'others')
				      {
				      	$('.inci_allergy_others').show();
				      } 
				    else
				     {
				     	$('.inci_allergy_others').hide();
				     }
    	      	if($(this).attr('id') == 'inci_allergy_type_others' && $('#inci_allergy_type').val() == 'others')
				      {	
			    		   	var patt=/[^a-zA-Z0-9 ._-]/;
						        if($(this).val().match(patt)){		
						          error = 1;		           
			 	      		    msg = 'No special characters';
			 	      		  }	   
				      }
    	      	if($(this).attr('id')=='amonth')
    	      	{
    	      		if(!arr_months.hasOwnProperty(val) ) 
    	      		{ error = 1; msg = "Not a valid month"; }
    	      	   else if(parseInt($('#ayear').val())>currentYear)
					  	{
					  		{ error = 1; msg = "Not a valid month"; }
					  	}
					   else if(parseInt($('#ayear').val())==currentYear)
					   {
					      if (val > currentMonth)
					      { error = 1; msg = "Not a valid month"; }
					   }
    	      	   
    	      	}
    	         if($(this).attr('id')=='aday')
    	      	{
    	      		var mon = parseInt($('#amonth').val());
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   	  
    	      	   else if(parseInt($('#ayear').val())>currentYear)
					  	{
					  		error = 1; msg = "Not a valid day";
					  	}
					   else if(parseInt($('#ayear').val())==currentYear)
					   {
					      if (mon >= currentMonth && val > currentDay){
					        error = 1; msg = "Not a valid day";
					      }
					   }    		
    	      	}
    	         if($(this).attr('id')=='ayear')
    	      	{
    	      		var limit = 100;
    	      		var end_date = (new Date).getFullYear();
    	      		var start_date = end_date - limit;   	      	
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      		if(val < start_date || val > end_date){error = 1; msg = "Range between "+start_date+" & "+end_date;}
    	      	   if(val % 4 == 0){
    	      	   	arr_months[2] = 29;
    	      	   	var mon = parseInt($('#amonth').val());
    	      	      if(parseInt($('#aday').val()) <= 0 || parseInt($('#aday').val()) > arr_months[mon]){
    	      	      	error = 1; msg = "Invalid day";
    	      	      	var can_show_err = 0;
    	      	      	$("#aday").css("border","1px solid #a94442");
    	      	      	if($("#aday").closest("div").find(".error").length){ $("#aday").closest("div").find(".error").remove() }
    	      	      	$("#aday").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      	      }    	      	      
    	      	   }
    	      		
    	      	  /* var mon = parseInt($('#amonth').val());   	      	  
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   */      		
    	      	}
    	         if($(this).attr('id')=='inci_allergy_type')
    		   	{
    		   		if($(this).val() == 'others' && $('#inci_allergy_type_others').val() == '')
    		   		{
    		   			can_show_err = 0;
    		   			error = 1;
    		   			msg = "Required";
    		   			$("#inci_allergy_type_others").css("border","1px solid #a94442");
    	      	      if($("#inci_allergy_type_others").closest("div").find(".error").length){ $("#inci_allergy_type_others").closest("div").find(".error").remove() }
    	      	      $("#inci_allergy_type_others").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    		   		}
    		   		
    		   	}
    	      }
    	      if(can_show_err == 1 && msg !='')
    	      {
    	      	$(this).css("border","1px solid #a94442");
    	      	$(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      }
       });
       if(error)
         return false;
         
        e.preventDefault();
     //   alert();
           var html = '';
           $(inci_wrapper).append('<div class="incident"> <fieldset class="sub-folder"> <div class="row"> <div class="form-group"> <label for="name" class="col-sm-3 control-label"><span class="text-bold">Incident Date:</span></label>   <div class="col-sm-5">   <label for="name" class="control-label text-info label-view">'+hid_date_form+' <input type="hidden" value="'+hid_date+'" id="inci_date" name="inci_date[]" /> <input type="hidden" value="" name="exist_incident_id[]" /></label> </div> <div class="col-sm-2"><a href="#" class="incident_remove"><i class="fa fa-times"></i></a> </div> </div> </div> <div class="row"> <div class="form-group"> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Allergy Type:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view"> '+hid_aller_name+' <input type="hidden" class="per-phone" id="inci_view_allergy" value="'+hid_aller_name+'" name="inci_view_allergy[]"/> <input type="hidden" value="'+i_allergy+'" id="inci_view_allergy_id" name="inci_view_allergy_id[]" /> </label> </div> </div> </div> <div class="row"> <div class="form-group"> <label for="name" class="col-sm-3 control-label"><span class="text-bold">Description:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_desc+' <input type="hidden" class="per-phone" readonly value="'+i_desc+'" id="description" name="description[]" /></label> </div> </div> </div> </fieldset> </div>');
           $('.clears').val('');
    });
   
    $(inci_wrapper).on("click",".incident_remove", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.incident').remove();
    })

});

$(document).ready(function() {
	
	var limit = 100;
 	var end_date = (new Date).getFullYear();
 	var start_date = end_date - limit; 
 	var currentYear = (new Date).getFullYear();
 	var currentMonth = (new Date).getMonth()+1;  
 	var currentDay = (new Date).getDate(); 
 
   /*$.validator.addMethod("current_day", function(value, element) {
    return value <= currentDay;
   });*/
 
	$('#profile_reg').validate({
                ignore:':hidden:not(".prgender")',
		rules:{
			pfname:{
				required:true,
				alpha:true,
				maxlength:20
			},
			pmname:{
				alpha:true,
				maxlength:20
			},
			plname:{
				required:true,
				alpha:true,
				maxlength:20
			},
			pgender:"required",
			pphone:{
				required:true				
			},
			pbmonth:{
				required:true,
				cmon:true
			},
			pbday:{
				required:true,
				day:true,
			        cday:true,
			},
			pbyear:{
				required: true,
				range:[start_date,end_date]
			},
			pemail:{
				required:true,
				email: true,
				maxlength: 50
			},
			schoolname:{
				school: true
			},
			logo:{
				extension: "gif|jpg|jpeg|tiff|png"
			},
			profileaddresszip:{
				number:true
			}
		},
		messages:{
		   pfname:{
		   	required:"You Can't leave this empty.",
				alpha:"Only alphabets are allowed.",
				maxlength:"Only 20 characters are allowed.",
		   },
		   pmname:{
				alpha:"Only alphabets are allowed.",
				maxlength:"Only 20 characters are allowed.",
		   },
			plname:{
		   	required:"You Can't leave this empty.",
				alpha:"Only alphabets are allowed.",
				maxlength:"Only 20 characters are allowed.",
		   },
			pgender:"You Can't leave this empty.",
			pphone:{
				required:"You Can't leave this empty."				
			},
			pemail:{
				required:"You Can't leave this empty.",
				email: "Enter valid email address.",
				maxlength: "Only 50 characters are allowed."
			},
			pbmonth:{
                                required:"You Can't leave this empty.",
                                cmon:"Not a valid month"
                        },
			pbday:{
				required:"You Can't leave this empty.",
				day: "Invalid day.",
				number: "invalid day",
                                cday:"Not a valid date"
			},
			pbyear:{
				required: "You Can't leave this empty.",
				range:"Year range between "+start_date+" & "+end_date+".",
			},
			schoolname:{
				school: "Only alphabets are allowed."
			},
			logo:{
				extension: "Upload valid image file."
			},
			profileaddresszip:{
				number:"Only number are allowed."
			}
		}
	});
   $('.pphones').intlTelInput({
   	preferredCountries: ["us", "ca"],
  	   utilsScript:"<?php echo base_url('source/assets/js/utils.js');?>"
  	 });
  $('#pphone').change(function(){
  	 	 var countryData1 = $("#pphone").intlTelInput("getSelectedCountryData");
  	 	 $('#pphone_ex').val(countryData1.iso2);
  	});
  	$('#pphone').intlTelInput("selectCountry","<?php echo (@$profile[0]['profileMobileEx'])? @$profile[0]['profileMobileEx']:'us'; ?>");
  	$('#ephone').change(function(){
  	 	 var countryData2 = $("#ephone").intlTelInput("getSelectedCountryData");
  	 	 $('#ephone_ex').val(countryData2.iso2);
  	});
  	$('#dphone').change(function(){
  	 	 var countryData3 = $("#dphone").intlTelInput("getSelectedCountryData");
  	 	 $('#dphone_exs').val(countryData3.iso2);
  	});
  	
   $(".upload").on('click', function(){
         //var phone = $(this).data('row-phone');
         //$('#phone_no').val(phone);
    });

    $('#upload').on('hidden.bs.modal', function () {
         $('#file_photo').val('');
    });
    
    //------------------------------------------for insurance----------------------//////////////
    var ins_wrapper = $(".insurance"); //Fields wrapper
    var ins_button = $("#insurance_add"); //Add button ID
    
    $.each($(".val-ins input[type=text],.val-ins select, val-ins input[type=file]"),function (key,val) {
    	$(this).on('keydown change blur keypress keyup',function () {
    		 $(this).closest("div").find(".error").remove();
	       $(this).css("border","1px solid #ccc");
	    	var arr_months = {1:31,2:28,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31};
	    	   if(parseInt($('#iyear').val()) % 4 == 0 && $('#iyear').val() != ""){ arr_months[2] = 29; }
	    	   var can_show_error = 1;
	    	   var msg = '';  
	    	   var val = $(this).val();	  
    		   if(val == ''){
    		      $(this).css("border","1px solid #a94442");
    		      msg = 'Required';
    		      error = 1;   		 
    	      }else{
    	      	if($(this).attr('id') == 'provider')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z _-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'Only alphabets';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'planids')
    	      	{  
    	      	   var patt=/[^0-9a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'groupids')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'payid')
    	      	{  
    	      	   var patt=/[^0-9a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id')=='imonth')
    	      	{
    	      		vals = parseInt($(this).val());
    	      		if(!arr_months.hasOwnProperty(vals)) { error = 1; msg = "Invalid"; }
    	      	}
    	         if($(this).attr('id')=='iday')
    	      	{
    	      		var mon = parseInt($('#imonth').val());
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   	      		
    	      	}
    	         if($(this).attr('id')=='iyear')
    	      	{
    	      		var limit = 10;
    	      		var start_date = (new Date).getFullYear();
    	      		var end_date = start_date + limit;   	      	
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      		if(val < start_date || val > end_date){error = 1; msg = "Range between "+start_date+" & "+end_date;}
    	      	   if(val % 4 == 0){
    	      	   	arr_months[2] = 29;
    	      	   	var mon = parseInt($('#imonth').val());
    	      	      if(parseInt($('#iday').val()) <= 0 || parseInt($('#iday').val()) > arr_months[mon]){
    	      	      	error = 1; msg = "Invalid day";
    	      	      	var can_show_err = 0;
    	      	      	$("#iday").css("border","1px solid #a94442");
    	      	      	if($("#iday").closest("div").find(".error").length){ $("#iday").closest("div").find(".error").remove() }
    	      	      	$("#iday").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      	      }    	      	      
    	      	   }
    	      	}
    	         if($(this).attr('id')=='logofile1')
    	         {
    	         	if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(val))
    	         	{
    	         		error = 1;
    	         		msg = 'Upload valid image file';
    	         	}
    	         }
    	         if($(this).attr('id')=='logofile2')
    	         {
    	         	if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(val))
    	         	{
    	         		error = 1;
    	         		msg = 'Upload valid image file';
    	         	}
    	         }
    	      }
    	      if(can_show_error == 1 && msg != '')
		      {
		      	$(this).css("border","1px solid #a94442");
		    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      } 
       });
    });
 
    $(ins_button).click(function(e){ //on add input button click
    var error = '';
	    var i_name = $('#provider').val();
	    var i_plan = $('#planids').val();
	    var i_group = $('#groupids').val();
	    var i_payer = $('#payid').val();
	    var i_month = $('#imonth').val();
	    var i_day = $('#iday').val();
	    var i_year = $('#iyear').val();
	    var i_front = $('#logofile1').val();
	    var i_back = $('#logofile2').val();
       
       //validation
       $('.error').remove();
	    $.each($(".val-ins input[type=text],.val-ins select, .val-ins input[type=file]"),function (key,val) {
	    	$(this).css("border","1px solid #ccc");
	    	var arr_months = {1:31,2:28,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31};
	    	   if(parseInt($('#iyear').val()) % 4 == 0 && $('#iyear').val() != ""){ arr_months[2] = 29; }
	    	   var can_show_error = 1;
	    	   var msg = '';  
	    	   var val = $(this).val();	  
    		   if(val == ''){
    		      $(this).css("border","1px solid #a94442");
    		      msg = 'Required';
    		      error = 1;   		 
    	      }else{
    	      	if($(this).attr('id') == 'provider')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'Only alphabets';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'planids')
    	      	{  
    	      	   var patt=/[^0-9a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'groupids')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'payid')
    	      	{  
    	      	   var patt=/[^0-9a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id')=='imonth')
    	      	{
    	      		vals = parseInt($(this).val());
    	      		if(!arr_months.hasOwnProperty(vals)) { error = 1; msg = "Invalid"; }
    	      	}
    	         if($(this).attr('id')=='iday')
    	      	{
    	      		var mon = parseInt($('#imonth').val());
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      	   if(val <= 0 || val > arr_months[mon]){error = 1; msg = "Invalid day"; }   	      		
    	      	}
    	         if($(this).attr('id')=='iyear')
    	      	{
    	      		var limit = 10;
    	      		var start_date = (new Date).getFullYear();
    	      		var end_date = start_date + limit;   	      	
    	      		if(isNaN($(this).val())) { error = 1; msg = "Only Numbers"; }
    	      		if(val < start_date || val > end_date){error = 1; msg = "Range between "+start_date+" & "+end_date;}
    	      	   if(val % 4 == 0){
    	      	   	arr_months[2] = 29;
    	      	   	var mon = parseInt($('#imonth').val());
    	      	      if(parseInt($('#iday').val()) <= 0 || parseInt($('#iday').val()) > arr_months[mon]){
    	      	      	error = 1; msg = "Invalid day";
    	      	      	var can_show_err = 0;
    	      	      	$("#iday").css("border","1px solid #a94442");
    	      	      	if($("#iday").closest("div").find(".error").length){ $("#iday").closest("div").find(".error").remove() }
    	      	      	$("#iday").closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
    	      	      }    	      	      
    	      	   }
    	      	}
    	         if($(this).attr('id')=='logofile1')
    	         {
    	         	if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(val))
    	         	{
    	         		error = 1;
    	         		msg = 'Upload valid image file';
    	         	}
    	         }
    	         if($(this).attr('id')=='logofile2')
    	         {
    	         	if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(val))
    	         	{
    	         		error = 1;
    	         		msg = 'Upload valid image file';
    	         	}
    	         }
    	      }
    	      if(can_show_error == 1 && msg != '')
		      {
		      	$(this).css("border","1px solid #a94442");
		    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      }     	
       });
       
       if(error)
         return false;
         
    e.preventDefault();
        //alert();
           var html = '';
           
           $(ins_wrapper).append('<div class="ins"><fieldset class="sub-holder"><div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Provide Name:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_name+'</label> <input type="hidden" value="" name="insuranceid[]" id="" /> <input type="hidden" value="'+i_name+'" name="providername[]" id="" /> <input type="hidden" value="'+i_plan+'" name="planid[]" id="" /> <input type="hidden" value="'+i_group+'" name="groupid[]" id="" /> <input type="hidden" value="'+i_payer+'" name="payerid[]" id="" /> <input type="hidden" value="'+i_day+'" name="edate[]" id="" /> <input type="hidden" value="'+i_month+'" name="emonth[]" id="" /> <input type="hidden" value="'+i_year+'" name="eyear[]" id="" /></div><div class="col-sm-2"> <a href="#" class="del"><i class="fa fa-times"></i></a></div>     </div></div> <div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Plan Id:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_plan+'</label> </div></div></div><div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Group Id:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_group+'</label> </div></div></div><div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Payer Id:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_payer+'</label> </div> </div> </div> <div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Expiry Date:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+i_month+'-'+i_day+'-'+i_year+'</label> </div></div></div></fieldset></div>');
           $('.ins-file').hide();
           $('.file-hide').append('<div class="row ins-file"> <div class="col-xs-6 col-lg-6 col-md-6">	 <div class="form-group"> <label> Insurance front </label> <div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-new thumbnail"> <img src="<?=empty_logo()?>" alt=""> </div> <div class="fileinput-preview fileinput-exists thumbnail"></div> <div class="user-edit-image-buttons"> <span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span> <input type="file" name="logofile1[]" class="form-control"> </span> <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput"> <i class="fa fa-times"></i> Remove </a> </div> </div> </div>    </div> <div class="col-xs-6 col-lg-6 col-md-6"> <div class="form-group"> <label> Insurance back </label> <div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-new thumbnail"> <img src="<?=empty_logo()?>" alt=""> </div> <div class="fileinput-preview fileinput-exists thumbnail"></div> <div class="user-edit-image-buttons"> <span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span> <input type="file" name="logofile2[]" class="form-control"> </span> <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput"> <i class="fa fa-times"></i> Remove </a> </div></div> </div></div> </div>');
           $('.clears').val('');
    });
   
    $(ins_wrapper).on("click",".del", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.ins').remove();
    })
   //-----------------------------------------------------------------------------------------//////
   //------------------------------------------for doctor----------------------//////////////
    var doc_wrapper = $(".doctor"); //Fields wrapper
    var doc_button = $("#doctor_add"); //Add button ID
    $.each($(".val-doc input[type=text],.val-doc select"),function (key,val) {
    	$(this).on('change blur keyup',function () {
	       $(this).css("border","1px solid #ccc");
	       $(this).closest("div").find(".error").remove();  
	       //$(this).closest("td").find(".error").remove();  
	        var val = $(this).val();  	 
	        var can_show_err = 1;
	        var td = 0;
	    	  var msg = "";    
    		   if(val == '' && $(this).attr('id')!='dmname' && $(this).attr('id')!='dsline'){
    		   	if($(this).attr('id') == 'dfline') td = 1;
    		   	if($(this).attr('id') == 'dsline') td = 1;
    		   	if($(this).attr('id') == 'dcitys') td = 1;
    		   	if($(this).attr('id') == 'dzips') td = 1;
    		   	if($(this).attr('id') == 'dstates') td = 1;
    		   	if($(this).attr('id') == 'dcountrys') td = 1;
    		   	if($(this).attr('id') == 'addr_type') td = 1;
    		      error = 1;   		 
    		      msg = 'Required';
    	      }else{
    	      	if($(this).attr('id') == 'dphone')
    	      	{
    	      		if(val.replace(/[^0-9]/g,"").length > 15)
    	      		{
    	      			error = 1;
    	      			msg = 'Enter valid phone number';
    	      		}
    	      	}
    	      	if($(this).attr('id') == 'dfname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'Only alphabets allowed';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dmname')
    	      	{  
    	      	   var patt=/[^a-zA-Z]/;
				        if(val.match(patt)){																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																						           
    	      		    error = 1;
    	      		    msg = 'Only alphabets allowed';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dlname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'Only alphabets allowed';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dfline')
    	         {
    	         	var patt=/[^0-9a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'No special characters';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dsline') 
    		   	{
    	         	var patt=/[^0-9a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'No special characters';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dcitys')
    		   	{
    	         	var patt=/[^a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'Only alphabets';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dzips')
    		   	{
    	         	var patt=/[^0-9]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'Only numbers';
    	      		  } 
    	      		  if(val.length > 5)
    	      		  {
    	      		  	error =1;
    	      		  	td = 1;
    	      		  	msg = 'Not more than 5 digits';
    	      		  }            	         	
    	         } 
    	     }   	
    	     if(can_show_err == 1 && msg != '')
		      {
		      	if(td)
		      	{
		      		$(this).css("border","1px solid #a94442");
		    	      $(this).closest("td").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      	}
		         else
		         {
			      	$(this).css("border","1px solid #a94442");
			    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		    	   }
		      }   
       });
    });
    $(doc_button).click(function(e){ //on add input button click
    var error ='';
	    var d_dfname = $('#dfname').val();          
	    var d_dmname = $('#dmname').val();
	    var d_dlname = $('#dlname').val();
	    var d_dphonetype = $('#dphonetypes').val();
	    var d_dphone = $('#dphone').val();
	    var d_dphone_ex = $('#dphone_exs').val();
	    var d_atype = $('#addr_type').val();
	    var d_dfline = $('#dfline').val();
	    var d_dsline = $('#dsline').val();
	    var d_dcity = $('#dcitys').val();
	    var d_dstate = $('#dstates').val();
	    var d_dzip = $('#dzips').val();
	    var d_dcountry = $('#dcountrys').val();
	    var d_ptext = $("#dphonetypes option:selected").text();
	    var d_atext = $("#addr_type option:selected").text();
	    var d_state = $("#dstates option:selected").text();
	    var d_country = $("#dcountrys option:selected").text();
	    
	    //validation
	    $(".error").remove(); 
	    $.each($(".val-doc input[type=text],.val-doc select"),function (key,val) {
	    	 $(this).css("border","1px solid #ccc");  
	        var val = $(this).val();  	 
	        var can_show_err = 1;
	        var td = 0;
	    	  var msg = "";    
    		   if(val == '' && $(this).attr('id')!='dmname' && $(this).attr('id')!='dsline'){
    		   	if($(this).attr('id') == 'dfline') td = 1;
    		   	if($(this).attr('id') == 'dsline') td = 1;
    		   	if($(this).attr('id') == 'dcitys') td = 1;
    		   	if($(this).attr('id') == 'dzips') td = 1;
    		   	if($(this).attr('id') == 'dstates') td = 1;
    		   	if($(this).attr('id') == 'dcountrys') td = 1;
    		   	if($(this).attr('id') == 'addr_type') td = 1;
    		      error = 1;   		 
    		      msg = 'Required';
    	      }else{
    	      	if($(this).attr('id') == 'dphone')
    	      	{
    	      		if(val.replace(/[^0-9]/g,"").length > 15)
    	      		{
    	      			error = 1;
    	      			msg = 'Enter valid phone number';
    	      		}
    	      	}
    	      	if($(this).attr('id') == 'dfname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dmname')
    	      	{  
    	      	   var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dlname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'dfline')
    	         {
    	         	var patt=/[^0-9a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'No special characters';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dsline') 
    		   	{
    	         	var patt=/[^0-9a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'No special characters';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dcitys')
    		   	{
    	         	var patt=/[^a-zA-Z ]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'Only alphabets';
    	      		  }          	         	
    	         } 
    		   	if($(this).attr('id') == 'dzips')
    		   	{
    	         	var patt=/[^0-9]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    td = 1;
    	      		    msg = 'Only numbers';
    	      		  }   
    	      		  if(val.length > 5)
    	      		  {
    	      		  	error =1;
    	      		  	td = 1;
    	      		  	msg = 'Not more than 5 digits';
    	      		  }       	         	
    	         } 
    	     }   	
    	     if(can_show_err == 1 && msg != '')
		      {
		      	if(td)
		      	{
		      		$(this).css("border","1px solid #a94442");
		    	      $(this).closest("td").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      	}
		         else
		         {
			      	$(this).css("border","1px solid #a94442");
			    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		    	   }
		      }     
       });
       if(error)
         return false;
         
       e.preventDefault();
           var html = '';
           $(doc_wrapper).append('<div class="doc"><fieldset class="sub-holder"><div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Name:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">Dr.'+d_dfname+' '+d_dmname+' '+d_dlname+'</label> <input type="hidden" name="did[]" id="did" value=""/> <input type="hidden" name="dfirstname[]" id="dfirstname" value="'+d_dfname+'" /> <input type="hidden" name="dmiddlename[]" id="dmiddlename" value="'+d_dmname+'"/> <input type="hidden" name="dlastname[]" id="dlastname" value="'+d_dlname+'"/> <input type="hidden" name="dphonetype[]" id="dphonetype" value="'+d_dphonetype+'"/> <input type="hidden" name="dmobile[]" id="dmobile" value="'+d_dphone+'" /> <input type="hidden" name="dphone_ex[]" id="dphone_ex" value="'+d_dphone_ex+'" /> <input type="hidden" name="daddr_type[]" id="daddr_type" value="'+d_atype+'" /> <input type="hidden" name="daddrline1[]" id="daddrline1" value="'+d_dfline+'" /> <input type="hidden" name="daddrline2[]" id="daddrline2" value="'+d_dsline+'" /> <input type="hidden" name="dcity[]" id="dcity" value="'+d_dcity+'" /> <input type="hidden" name="dstate[]" id="dstate" value="'+d_dstate+'" /> <input type="hidden" name="dcountry[]" id="dcountry" value="'+d_dcountry+'" /> <input type="hidden" name="dzip[]" id="dzip" value="'+d_dzip+'" /> </div> <div class="col-sm-2"> <a href="#" class="del"><i class="fa fa-times"></i></a> </div> </div></div><div class="row"> <div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">'+d_ptext+':</span></label> <div class="col-sm-5"> <img src="<?=base_url()."source/assets/flags/"?>'+d_dphone_ex+'.png"/><label for="name" class="control-label text-info label-view">&nbsp'+d_dphone+'</label> </div></div></div><div class="row"><div class="form-group"> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">'+d_atext+':</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+d_dfline+', '+d_dsline+', '+d_dcity+', '+d_state+', '+d_dzip+', '+d_country+'</label> </div></div> </div></fieldset></div>');
           $('.dclears').val('');
    });
   
    $(doc_wrapper).on("click",".del", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.doc').remove();
    });
   //-----------------------------------------------------------------------------------------//////
   
   //------------------------------------------for emergency----------------------//////////////
    var em_wrapper = $(".emergency"); //Fields wrapper
    var em_button = $("#emer_add"); //Add button ID
    $.each($(".val-emer input[type=text],.val-emer select"),function (key,val) {
    	$(this).on('keydown change blur keypress keyup',function () {
    		$(this).closest("div").find(".error").remove();  
	       $(this).css("border","1px solid #ccc");  
	        var val = $(this).val();  	 
	        var can_show_err = 1;
	        var td = 0;
	    	  var msg = "";    
    		   if(val == '' && $(this).attr('id')!='emname'){
    		   	error = 1;
    		   	msg = "Required";
    		   }else{
    		   	if($(this).attr('id') == 'efname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'only alphabets';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'emname')
    	      	{  
    	      	   var patt=/[^a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'only alphabets';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'elname')
    	      	{    	      		
    	      		var patt=/[^a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'only alphabets';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'ephone')
    	      	{
    	      		if(val.replace(/[^0-9]/g,"").length > 15)
    	      		{
    	      			//alert(val.replace(/[^0-9]/g,"").length);
    	      			error = 1;
    	      			msg = 'Enter valid phone number';
    	      		}
    	      	}
    	      	if($(this).attr('id') == 'erelations')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    		   }
    	    if(can_show_err == 1 && msg != '')
		      {		      
		      	$(this).css("border","1px solid #a94442");
		    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      }
       });
    });
    $(em_button).click(function(e){ //on add input button click
    var error = '';
	    var e_fname = $('#efname').val();          
	    var e_mname = $('#emname').val();
	    var e_lname = $('#elname').val();
	    var e_phonetype = $('#ephonetypes').val();
	    var e_phonetypename = $('#ephonetypes').find('option:selected').text();
	    var e_phone = $('#ephone').val();
	    var e_phone_ex = $('#ephone_ex').val();
	    var e_relation = $('#erelations').val();
	    //validation
	    $(".error").remove(); 
	    $.each($(".val-emer input[type=text],.val-emer select"),function (key,val) {    	  
    		  $(this).css("border","1px solid #ccc");  
	        var val = $(this).val();  	 
	        var can_show_err = 1;
	        var td = 0;
	    	  var msg = "";    
    		   if(val == '' && $(this).attr('id')!='emname'){
    		   	error = 1;
    		   	msg = "Required";
    		   }else{
    		   	if($(this).attr('id') == 'efname')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'emname')
    	      	{  
    	      	   var patt=/[^0-9a-zA-Z]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'elname')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    	         if($(this).attr('id') == 'ephone')
    	      	{
    	      		if(val.replace(/[^0-9]/g,"").length > 15)
    	      		{
    	      			//alert(val);
    	      			error = 1;
    	      			msg = 'Enter valid phone number';
    	      		}
    	      	}
    	      	if($(this).attr('id') == 'erelations')
    	      	{    	      		
    	      		var patt=/[^0-9a-zA-Z_-]/;
				        if(val.match(patt)){				           
    	      		    error = 1;
    	      		    msg = 'No special characters';
    	      		  }
    	      	     if(val.length > 20){
    	      	     	 error = 1;
    	      		    msg = 'Not more than 20 characters';
    	      	     }
    	      	}
    		   }
    	    if(can_show_err == 1 && msg != '')
		      {		      
		      	$(this).css("border","1px solid #a94442");
		    	   $(this).closest("div").append('<div class="error" style="font-size:10px; color:#ff0000; text-align:center; padding-top:5px">'+msg+'</div>');
		      }   
       });
       if(error)
         return false;
         
        e.preventDefault();
        
           var html = '';
           $(em_wrapper).append('<div class="emer"><fieldset class="sub-holder"><div class="row"><div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Name:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view"> '+e_fname+' '+e_mname+' '+e_lname+' </label> <input type="hidden" name="eid[]" id="eid" value=""/> <input type="hidden" name="efirstname[]" id="efirstname" value="'+e_fname+'" /> <input type="hidden" name="emiddlename[]" id="emiddlename" value="'+e_mname+'"/> <input type="hidden" name="elastname[]" id="elastname" value="'+e_lname+'"/> <input type="hidden" name="emobile[]" id="emobile" value="'+e_phone+'" /> <input type="hidden" name="ephonetype[]" id="ephonetype" value="'+e_phonetype+'" /> <input type="hidden" name="ephone_ex[]" value="'+e_phone_ex+'" /> <input type="hidden" name="erelation[]" id="erelation" value="'+e_relation+'" /> </div> <div class="col-sm-2"> <a href="#" class="del"><i class="fa fa-times"></i></a> </div> </div></div><div class="row"> <div class="form-group "> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">'+e_phonetypename+':</span></label> <div class="col-sm-5"> <img src="<?=base_url()."source/assets/flags/"?>'+e_phone_ex+'.png"/><label for="name" class="control-label text-info label-view">&nbsp'+e_phone+'</label><input type="hidden" name="emobile_ex[]" id="emobile_ex" value="'+e_phone_ex+'" /> </div></div></div>  <div class="row"><div class="form-group"> <label for="gender" class="col-sm-3 control-label"><span class="text-bold">Relationship:</span></label> <div class="col-sm-5"> <label for="name" class="control-label text-info label-view">'+e_relation+'</label> </div></div> </div></fieldset></div>');
           $('.clears').val('');
    });
   
    $(em_wrapper).on("click",".del", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('.emer').remove();
    });
   //-----------------------------------------------------------------------------------------//////
	var val ='';
   $(document).on('keypress ','.pphones', function(event){
      value = $(this).val();
      
      if(value.replace(/[^0-9]/g,"").length === 15)
      {
      	val = $(this).val();
      }
      
      if(value.replace(/[^0-9]/g,"").length > 15)
      {
      	$(this).val(val);
      	event.preventDefault();
      	
       }
   });
});
</script>

						
