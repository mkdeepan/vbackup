<script>
  $(document).ready(function () {
  
  	$('.error').hide();
  	 
    
    $("#accessinfo").submit(function(){
    	var valid=[];
    	var $tableBody = $('#table_access').find("tbody");
        $trLast = $tableBody.find("tr:last");
        $role = ($trLast.find('.role'));
        var roleid = $role.attr('id');
        $read = ($trLast.find('.read'));
        var readid = $read.attr('id');
        $edit = ($trLast.find('.edit'));
        var editid = $edit.attr('id');
        var elementcount = $('.role').length;
        if(elementcount > 1)
        {
	    	var role=[];
	    	var i =0;
	    	$.each($('.role'), function() {
	        if ($(this).val() == '' && $(this).attr('id') != roleid){
	        	$("#error"+$(this).attr('id')).show();
			    valid[i] = 'false';
			}else{
			    $("#error"+$(this).attr('id')).hide();
		        valid[i] = 'true';
			}
			i=i+1;
			});

			var read=[];
			
	    	$.each($('.read'), function() {
	    		
	        if ($(this).val() == null && $(this).attr('id') != readid){
	      	    $("#error"+$(this).attr('id')).show();
			    valid[i] = 'false';
			}else{
			    $("#error"+$(this).attr('id')).hide();
		        valid[i] = 'true';
			}
			i=i+1;
			});

			var edit=[];
			
	    	$.each($('.edit'), function() {
	        if ($(this).val() == null && $(this).attr('id') != editid){
	      	  
	      	    $("#error"+$(this).attr('id')).show();
			    valid[i] = 'false';
			}else{
				$("#error"+$(this).attr('id')).hide();
			    valid[i] = 'true';
			}
			i=i+1;
			});
		}
		else
		{
			
			if($("#role0").val() == '')
			{
			    $("#errorrole0").show();
			    valid['0'] = 'false';
			}else{
			    $("#errorrole0").hide();
		        valid['0'] = 'true';
			}
			

			if($("#read0").val() == null)
			{
			    $("#errorread0").show();
			    valid['1'] = 'false';
			}else{
			    $("#errorread0").hide();
		        valid['1'] = 'true';
			}

			if($("#edit0").val() == null)
			{
			    $("#erroredit0").show();
			    valid['2'] = 'false';
			}else{
			    $("#erroredit0").hide();
		        valid['2'] = 'true';
			}

		}
		if($.inArray("false", valid) == -1)
		{
			return true;
		}
		else
		{
    		return false;
        }
    });

   
   $(document).on('change', '.role', function(){
   
    var $tableBody = $('#table_access').find("tbody");
    $trLast = $tableBody.find("tr:last");

    if($(this).closest('tr').attr('id') == $trLast.attr('id'))
    {
	    $trNew = $trLast.clone();
	  	var id = $trLast.attr('id');
		id = id.substr(id.length - 1);
		id= Number(id)+1;
		var sno = $trLast.find("td:first").html();
		sno = Number(sno.slice(0,-1))+1;
		$trNew.attr('id','accessrow'+id);
		$trNew.find("td:first").html(sno+'.');
		$role = ($trNew.find('.role'));
		$role.attr('id','role'+id);
		$('#role'+id).val('');
		$rolee = ($trNew.find('.oerror'));
		$rolee.attr('id','errorrole'+id);
		$rolee.hide();
		
		$read = ($trNew.find('.read'));
		$read.attr('id','read'+id);
		$read.attr('name','read['+id+'][]');
		$('#read'+id).val('');
		$reade = ($trNew.find('.rerror'));
		$reade.attr('id','errorread'+id);
		$reade.hide();

		$edit = ($trNew.find('.edit'));
		$edit.attr('id','edit'+id);
		$edit.attr('name','edit['+id+'][]');
		$('#edit'+id).val('');
		$edite = ($trNew.find('.eerror'));
		$edite.attr('id','erroredit'+id);
		$edite.hide();

		$access = ($trNew.find('.access_id'));
		$access.attr('id','access_id'+id);
		$('#access_id'+id).val('');
				
	    $trLast.after($trNew);
    }
   });

  });
  </script>
<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Roles Setup</h1>
		<span class="mainDescription">Roles Page</span>
	</div>
	<ol class="breadcrumb">
		<li class="active">
		<span>Roles Page</span>
		</li>
		<li class="active">
		<span>Admin</span>
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

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
			<div class="tabbable">
				<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
					<li class="active">
					<a data-toggle="tab" href="#roles_overview">Roles view</a>
					</li>
					<li >
					<a data-toggle="tab" href="#roles_edit">Roles edit</a>
					</li>
				</ul>
				<div class="tab-content">
				    <div id="roles_overview" class="tab-pane fade in active">
				     <div class="row">
				      <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
					      <table class="table table-condensed">
						      <thead>
						       <tr>
						        <th>S.No</th>
						        <th>Role</th>
						        <th>Read Access To</th>
						        <th>Edit Access To</th>
						       </tr>
						      </thead>
						      <tbody>
						       <div class="taglisting">
								    <?php //var_dump($role_access);
						             $i = 0;
						             foreach($role_access as $access)
						             {
						             	?>
						             <tr id="accessrow<?php echo $i;?>" class="tr_clone">
										 <td id="sno"><?php echo $i+1;?></td>
										 <td>
										 <?php 
										 $role = common_model::select_from('Role',array('roleName'),array('roleId'=>$access['roleId']));
										 echo $role['0']['roleName'] ;  ?>
										 </td>
										 
										 <td>
										  <?php 
										  $access_read = unserialize($access['readAcccess']);
										  if(!empty($access_read) && $access_read[0] != ''){
										  foreach($access_read as $key=>$page){
										  $pagename = common_model::select_from('Pages',array('pageName'),array('pageId'=>$page));
										  	echo ($key)?', '.$pagename[0]['pageName']:$pagename[0]['pageName'];
										   }}?>										  
										 </td>
										 
										 <td>										 
										  <?php 
										  $access_edit = unserialize($access['writeAccess']);										  
										  if(!empty($access_edit) && $access_edit[0] != ''){
										  foreach($access_edit as $key=>$page){
										  	$pagename = common_model::select_from('Pages',array('pageName'),array('pageId'=>$page));
										  	echo ($key)?', '.$pagename[0]['pageName']:$pagename[0]['pageName'];
										  }}?>										 
										 </td>
										 
										</tr>
						             	<?php
						             	$i=$i+1;
						             }
								    ?>			 
						
									</div>
						      </tbody>
					      </table>
				      </div>
				     </div>
				    </div>
				    <div id="roles_edit" class="tab-pane fade in">
	<form class="" method="post" name="accessinfo" id="accessinfo" action="<?php echo site_url('admin/access_save');?>">
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
		 <div style="color:#666666;font-weight:bold;display:block;font-size:16px;padding: 10px 3px;">Choose a Role and it's access rights</div>
		 <table class="table table-condensed" id="table_access">
		 <thead>
		 <th width="5%">S.No</th>
		 <th width="25%">Role</th>
		 <th width="35%">Read Access To</th>
		 <th width="35%">Edit Access To</th>
		 
		 </thead>
		 <tbody>
		    <div class="taglisting">
		    <?php //var_dump($role_access);
             $i = 0;
             foreach($role_access as $access)
             {
             	?>
                 <tr id="accessrow<?php echo $i;?>" class="tr_clone">
				<td id="sno"><?php echo $i+1;?>
				<input type="hidden" name="access_id[]" id="access_id<?php echo $i;?>" value="<?php echo $access['accessId'];?>"/>
				</td>
				 <td >
				  <select class="form-control input-sm role" name="role[]" id="role<?php echo $i;?>">
				  <option value="">Select...</option>
				  <?php foreach($roles as $role){
				  	  $val = ($access['roleId'] == $role['roleId'])?'selected="selected"':''; 
				      echo "<option value='".$role['roleId']."'".$val.">".$role['roleName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="role<?php echo $i;?>" id="errorrole<?php echo $i;?>" class="error oerror">You can't leave this empty.</label>
				 </td>
				 
				 <td>

				 <select class="form-control input-sm read" name="read[<?php echo $i;?>][]" id="read<?php echo $i;?>" multiple="multiple">
				  <option value="">Select...</option>
				  <?php 
				 $access_read = unserialize($access['readAcccess']);
				  foreach($pages as $page){
				  	$read_acc = '';
				  	if(in_array($page['pageId'],$access_read))
				  		$read_acc = 'selected="selected"';
				      echo "<option value='".$page['pageId']."' ".$read_acc.">".$page['pageName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="read<?php echo $i;?>" id="errorread<?php echo $i;?>" class="error rerror">You can't leave this empty.</label>
				 </td>
				 
				 <td width="130px">
				 <select class="form-control input-sm edit" name="edit[<?php echo $i;?>][]" id="edit<?php echo $i;?>" multiple="multiple">
				  <option value="">Select...</option>
				  <?php 
				  $access_edit = unserialize($access['writeAccess']);
				  foreach($pages as $page){
				  	$edit_acc = '';
				  	if(in_array($page['pageId'],$access_edit))
				  		$edit_acc = 'selected="selected"';
				      echo "<option value='".$page['pageId']."' ".$edit_acc.">".$page['pageName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="edit<?php echo $i;?>" id="erroredit<?php echo $i;?>" class="error eerror">You can't leave this empty.</label>
				 </td>
				 
				</tr>
             	<?php
             	$i=$i+1;
             }
		    ?>
			  <tr id="accessrow<?php echo $i;?>" class="tr_clone">
				<td id="sno"><?php echo $i+1;?>

				</td>
				 <td >
				  <select class="form-control input-sm role" name="role[]" id="role<?php echo $i;?>">
				  <option value="">Select...</option>
				  <?php foreach($roles as $role){
				      echo "<option value='".$role['roleId']."'>".$role['roleName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="role<?php echo $i;?>" id="errorrole<?php echo $i;?>" class="error oerror">You can't leave this empty.</label>
				 </td>
				 
				 <td>
				 <select class="form-control input-sm read" name="read[<?php echo $i;?>][]" id="read<?php echo $i;?>" multiple="multiple">
				  <option value="">Select...</option>
				  <?php foreach($pages as $page){
				      echo "<option value='".$page['pageId']."'>".$page['pageName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="read<?php echo $i;?>" id="errorread<?php echo $i;?>" class="error rerror">You can't leave this empty.</label>
				 </td>
				 
				 <td width="130px">
				 <select class="form-control input-sm edit" name="edit[<?php echo $i;?>][]" id="edit<?php echo $i;?>" multiple="multiple">
				  <option value="">Select...</option>
				  <?php foreach($pages as $page){
				      echo "<option value='".$page['pageId']."'>".$page['pageName']."</option>";
				   } ?>
				  </select>
				  <br/><label for="edit<?php echo $i;?>" id="erroredit<?php echo $i;?>" class="error eerror">You can't leave this empty.</label>
				 <input type="hidden" class="access_id" name="access_id[]" id="access_id<?php echo $i;?>" value=""/>
				 </td>
				 
				</tr>


				
				
			</div>
		 
		 </tbody>
		 </table>

		 
    </div>
   </div>
     <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		 <div class="input-group pull-right" style="padding-top:15px;padding-bottom:15px;">
 
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
		 