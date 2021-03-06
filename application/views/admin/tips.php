<script type="text/javascript" src="<?php echo base_url(); ?>source/vendor/tinymce/tinymce.min.js"></script>
 <script type="text/javascript">
            
  tinyMCE.init({
    // theme : "modern",
    // mode: "exact",
    // elements : "atschool",
    // theme_advanced_toolbar_location : "top",
    // theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
    // + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
    // + "bullist,numlist,outdent,indent",
    // theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
    // +"undo,redo,cleanup,code,separator,sub,sup,charmap",
    // theme_advanced_buttons3 : "",
    
      selector: "textarea",
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
        ],

        toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
        toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
        toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

        menubar: false,
        toolbar_items_size: 'small',

        style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],

        templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
        ],
        height:"auto",
      //  width:"600px"

});
$(document).ready(function () {
$('.error').hide();
$("#tips").submit(function(){
	 validity = true;
	 tinymce.triggerSave();
	 if($("#athome").val() == '')
	 {
	 	validity = false;
	 	$("#athome_error").show();
	 }
	 	
	 if($("#atschool").val() == '')
	 {
	 	validity = false;
	 	$("#atschool_error").show();
	 }
	 	
	 return validity

});
});
</script>
<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Tips</h1>
		<!--<span class="mainDescription">There are many systems which have a need for user profile pages which display personal information on each member.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Tips</span>
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
			<div class="tabbable">
				<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
					<li class="active">
					<a data-toggle="tab" href="#tips_page">Tips</a>
					</li>								
				</ul>
				<div class="tab-content tips_page">
					<div id="panel_overview" class="tab-pane fade in active">
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					<form name="tips" id="tips" method="post" accept="<?php site_url('admin/tips');?>">					
					 <fieldset><legend>At Home</legend>
					 <div class="row">
					 <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
					   <div class="form-group">
					     <textarea name="athome" id="athome" class="required" cols="30" rows="3" style="width: 335px; height: 89px;"><?php echo $tips[0]['atHome'];?></textarea>					     
					   </div>					 
					 </div>
					 </div>
					 </fieldset>
					 <fieldset><legend>At School</legend>
					 <div class="row">
					 <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
					    <div class="form-group">
					     <textarea name="atschool" id="atschool" class="required"><?php echo $tips[0]['atSchool'];?></textarea>
					    </div>
					 </div>
					 </div>
					 </fieldset>
					 <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						 <div class="input-group pull-right" style="padding-top:15px;padding-bottom:15px;">
				            <input type="hidden" name="tips_id" id="tips_id" value="<?php echo $id=(isset($tips[0]['tipId']))?$tips[0]['tipId']:'';?>">
						      <input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-default"/>
						      <input type="submit" name="save" id="save" value="Save" class="btn btn-success"/>    
					    </div>
						</div>
					 </div>					
					</form>
					</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>