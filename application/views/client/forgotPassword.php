<div class="row">
	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<div class="logo">
			<img class="veb-logo" src="<?php echo base_url();?>source/assets/images/alert-logo.jpg" alt="logo"/>
			<hr>
		</div>
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
		<!-- start: LOGIN BOX -->
		<div class="box-forgot">
			<form class="form-forgot" id="forgot_form" method="post" action="<?php echo base_url('login/forgot_password');?>">
						<fieldset>
							<legend>
								Forgot Password?
							</legend>
							<p>
								Enter your e-mail address below to reset your password.
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input type="email" class="form-control" name="fusername" id="fusername" placeholder="Enter your email">
									<i class="fa fa-envelope-o"></i> </span>
							</div>
							<div class="form-actions">
								<a class="btn btn-primary btn-o" href="<?php echo base_url('login');?>">
									<i class="fa fa-chevron-circle-left"></i> Log-In
								</a>
								<button type="submit" class="btn btn-primary pull-right">
									Submit <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</fieldset>
					</form>
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Vebinary Solutions LLC</span>. <span>All rights reserved.</span>
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- end: LOGIN BOX -->
	</div>
</div>
<script>
  jQuery(document).ready(function () {
  	
  	 $("#forgot_form").validate({
  	 	rules:{
  	 		fusername:{
  	 		   required: true,
  	 		   email: true
  	 		}
  	 	},
  	 	messages:{
  	 		fusername:{
  	 			required:"You can't leave this empty.",
  	 			email:"Enter valid email address."
  	 		}
  	 	}
  	 });
  });
  </script>