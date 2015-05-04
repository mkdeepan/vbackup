<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Vebinary Solutions - Admin</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>source/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>source/vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>source/vendor/themify-icons/themify-icons.min.css">
		<link href="<?php echo base_url();?>source/vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>source/vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>source/vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>source/assets/css/intlTelInput.css"/>
		<!-- end: MAIN CSS -->
		<!-- start: CLIP-TWO CSS -->
		<!--<link rel="stylesheet" href="assets/css/styles.css">-->
        <link rel="stylesheet" href="<?php echo base_url();?>source/assets/css/styles-nova.css">
		<link rel="stylesheet" href="<?php echo base_url();?>source/assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url();?>source/assets/css/themes/theme-1.css" id="skin_color" />
		<script src="<?php echo base_url();?>source/vendor/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>source/assets/js/intlTelInput.min.js"></script>
		<script>
		jQuery(document).ready(function(){
			$('.nova-mobile').intlTelInput({
			  	 	preferredCountries: ["us", "ca"],
			  	   utilsScript:"<?php echo base_url().'source/assets/js/utils.js';?>"
	  	      });	
	  	      
	  	   //to block after entering 10 digits
	  	   var val ='';
		   $(document).on('keypress ','.nova-mobile', function(event){
		      value = $(this).val();		      
		      if(value.replace(/[^0-9]/g,"").length === 10){
		      	val = $(this).val();
		      }    
		      if(value.replace(/[^0-9]/g,"").length > 10){
		      	$(this).val(val);
		      	event.preventDefault();	      	
		      }
         });			
		});
		</script>
		<!-- end: CLIP-TWO CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<body>
		<div id="app">
			<!-- sidebar -->
			<?php if($this->session->userdata('isLogin')){
			 include('sidebar.php');
			}
			?>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<?php $method = $this->router->fetch_method();
				      $ctrl = $this->router->fetch_class();
				     
			    if(!($method == 'index' && $ctrl == 'login')){
			   	include('header.php');
			    } 
			   ?>
			   
				<!-- end: TOP NAVBAR -->
				<?php $ctrl = $this->router->fetch_class();
				      $class = '';
				      if($ctrl != 'login'){
				      	$class = 'main-content';
				      }
				?>
				<div class="<?=$class?>">
					<?php $this->load->view($page); ?>
				</div>
			</div>
			<?php $method = $this->router->fetch_method();
			   if(!($ctrl == 'login' && $method == 'index')){ ?>
			<!-- start: FOOTER -->
			<footer style="margin-left:0px !important">
				<div class="footer-inner">
					<div class="pull-left">&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Vebinary Solutions LLC </span>. <span>All rights reserved</span></div>
					<div class="pull-right">
						<span class="go-top"><i class="ti-angle-up"></i></span>
					</div>
				</div>
			</footer>
			<!-- end: FOOTER -->
			<?php } ?>
			<!-- start: OFF-SIDEBAR -->
			<div id="off-sidebar" class="sidebar">
				<div class="sidebar-wrapper">
					<ul class="nav nav-tabs nav-justified">
						<li class="active">
							<a href="#off-users" aria-controls="off-users" role="tab" data-toggle="tab">
								<i class="ti-comments"></i>
							</a>
						</li>
						<li>
							<a href="#off-favorites" aria-controls="off-favorites" role="tab" data-toggle="tab">
								<i class="ti-heart"></i>
							</a>
						</li>
						<li>
							<a href="#off-settings" aria-controls="off-settings" role="tab" data-toggle="tab">
								<i class="ti-settings"></i>
							</a>
						</li>
					</ul>
					
				</div>
			</div>
			<!-- end: OFF-SIDEBAR -->
			<!-- start: SETTINGS -->
			<?php if($this->session->userdata('isLogin')){
			 include('theme_selector.php');
			}
			?>
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		
		<script src="<?php echo base_url();?>source/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>source/vendor/modernizr/modernizr.js"></script>
		<script src="<?php echo base_url();?>source/vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url();?>source/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="<?php echo base_url();?>source/vendor/switchery/switchery.min.js"></script>
		<script src="<?php echo base_url();?>source/vendor/selectFx/classie.js"></script>
		<script src="<?php echo base_url();?>source/vendor/selectFx/selectFx.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->		
		<script src="<?php echo base_url();?>source/vendor/jquery-validation/jquery.validate.js"></script>	
		<script src="<?php echo base_url();?>source/assets/js/nova.validate.js"></script>	
		<script src="<?php echo base_url();?>source/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="<?php echo base_url();?>source/assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="<?php echo base_url();?>source/assets/js/form-wizard.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormWizard.init();	
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
