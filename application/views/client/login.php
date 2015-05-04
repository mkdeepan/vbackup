<div class="row">
	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<div class="logo">
			<a href="<?php echo base_url('home');?>"><img class="veb-logo" src="<?php echo base_url();?>source/assets/images/alert-logo.jpg" alt="logo"/></a>
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
		<div class="box-login">
			<form class="form-login" id="login_form" method="post" action="<?php echo base_url('login/index');?>">
				<fieldset>
					<legend>
						Login to your <img class="valert" src="<?php echo base_url();?>source/assets/images/alert-logo.jpg" alt="" > account
					</legend>
					<p>
						Please enter your email id and password to log in.
					</p>
					
					<div class="form-group">
						<span class="input-icon">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
							<i class="fa fa-user"></i> </span>
					</div>
					<div class="form-group form-actions">
						<span class="input-icon">
							<input type="password" class="form-control password" id="password" name="password" placeholder="Password">
							<i class="fa fa-lock"></i>
							<a class="forgot" href="<?php echo base_url('login/forgot_password');?>">
								I forgot my password
							</a> </span>
					</div>
					<div class="form-actions">
						<div class="checkbox clip-check check-primary">
							<input type="checkbox" id="remember" value="1">
							<label for="remember">
								Keep me logged in
							</label>
						</div>
						<button type="submit" class="btn btn-primary pull-right">
							Login <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
					<div class="new-account">
						Don't have an account yet?
						<a href="<?php echo base_url('login/registration');?>">
							Create an account
						</a>
					</div>
				</fieldset>
			</form>
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Vebinary Solutions LLC</span>. <span>All rights reserved.</span>
				<a href="<?php echo base_url('feedback');?>">Feedback</a>
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- end: LOGIN BOX -->
	</div>
</div>
<script>
  jQuery(document).ready(function () {
  	
  	 $("#login_form").validate({
  	 	rules:{
  	 		username:{
  	 		   required: true,
  	 		   email: true
  	 		},
    		password:{
    			required:true
    		}
  	 	},
  	 	messages:{
  	 		username:{
  	 			required:"You can't leave this empty.",
  	 			email:"Enter valid email address."
  	 		},
    		password:{
    			required:"You can't leave this empty."
    		}
    		
  	 	}
  	 });
  });
  </script>
