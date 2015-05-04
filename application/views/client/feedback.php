<!-- start: PAGE TITLE -->
<?php if($this->session->userdata('isLogin')){?>
<div>
<div class="wrap-content container" id="container">
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Feedback</h1>
		<span class="mainDescription">Share your thoughts about this site.</span>
	</div>

	<ol class="breadcrumb">
		<li>
		<span>Dashboard</span>
		</li>
		<li class="active">
		<span>Feedback</span>
		</li>
	</ol>
</div>
</section>
<?php } else { ?>
<div class="row">
  <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<div class="logo">
			<a href="<?php echo base_url('login');?>"><img class="veb-logo" src="<?php echo base_url();?>source/assets/images/alert-logo.jpg" alt="logo"/></a>
			<hr>
		</div>
<?php } ?>
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
<div class="<?php echo ($this->session->userdata('isLogin'))?'container-fluid container-fullw bg-white':'box-login';?>">
	<div class="row">
		<div class="<?php echo ($this->session->userdata('isLogin'))?'col-md-6':'col-md-12';?>">
		<fieldset><legend>Send us feedback</legend>
		<form id="feedback_form" name="feedback_form" method="post" action="<?php echo base_url('feedback/index') ?>" >
		<div class="form-group">
		<div class="row">
		<p><strong>We value your opinion. Please rate your experience (required):</strong></p>
		</div>
		<div class="row">
		<p align="justify">To protect your identity, don't submit personal or account information. Note that we can't reply to questions asked via this form, but please call us directly if you have any account or service-related issues.</p>
		</div>
		<div class="row">
		<div class="margin-bottom-10 text-extra-large">
			<input type="hidden" name="rating" id="rating" class="rating-tooltip" data-filled="fa fa-star margin-right-5 text-yellow" data-empty="fa fa-star-o margin-right-5"/>
			<!--<span class="label label-success"></span>-->
		</div>
		</div>
		<div class="row">			
				<label>Category</label>
				<select class="form-control" name="category" id="category">
				<option value="">Select a Feedback Category</option>
				<option value="1">Option 1</option>
				<option value="2">Option 2</option>
				</select>
		</div>
		<div class="row">
		   <label></label>		  
		   <textarea class="form-control" name="comments" id="comments"></textarea>
		</div>
		<div class="row">
		<label></label>
		<p align="justify">
		By submitting feedback you agree that Bank of America, its affiliates, and any parties authorized may use, commercialize or reproduce the feedback without restriction or compensation to you.
		</p>
		</div>
		<div class="row" align="center">
		<label></label>
		<!--<button class="btn btn-wide btn-primary" type="submit">Submit</button>-->
		<input type="submit" class="btn btn-wide btn-primary" value="Submit" name="feed_submit" id="feed_submit" />
		</div>
		</div>
		</form>
		</fieldset>
		<?php if(!$this->session->userdata('isLogin')){?>
		<div class="copyright">
				&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Vebinary Solutions LLC</span>. <span>All rights reserved.</span>				
		</div>
		<?php } ?>
		</div>
	</div>
</div>
</div>
</div>
<script>
$(document).ready(function(){
	
		$("#feedback_form").validate({
	  	 	rules:{
	  	 		rating:{
	  	 		   required: true
	  	 		},
	    		category:{
	    			required:true
	    		},
	    		comments:{
	    			required:true
	    		}
	  	 	},
	  	 	messages:{
	  	 		rating:{
	  	 			required:"You can't leave this empty."
	  	 		},
	    		category:{
	    			required:"You can't leave this empty."
	    		},
	    		comments:{
	    			required:"You can't leave this empty."
	    		}	    		
	  	 	}
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