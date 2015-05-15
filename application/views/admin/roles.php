<style>
.img-rounded{
	height: 55px !important;
}

</style>
<?php //var_dump($result_set); ?>
<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">User Roles</h1>
		<!--<span class="mainDescription">Master table for User Roles.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Master</span>
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
<!--<?php var_dump($feedback);?>-->

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
		<div class="">
			   <button class="btn btn-primary btn-o" data-toggle="modal" data-target="#addrole">
				Add New
			   </button>
	  </div>
			<div class="table-responsive">
										<table id="sample-table-1" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>													
													<th>Role Name</th>													
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($result_set)){
												foreach($result_set as $key=>$alg){ ?>
												<tr>												
												<td><?=$key+1?></td>
												<td id="desc_<?php echo $alg['roleId'];?>"><?=$alg['roleName'];?></td>																																																							
												<td id="action_<?php echo $alg['roleId'];?>">
		                                <a href="#" class="edit" id="edit_<?php echo $alg['roleId'];?>" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
		                                <a href="#" class="delete" data-toggle="modal" data-target="#delrole" 
		                                data-row-did='<?php echo $alg["roleId"]; ?>'		                                                         
		                                title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
		                              </td>		                              
											
												<!--<input type="text" name="editallergyname" id="editallergyname" value="<?=$alg['allergyNameDescription'];?>" /></td>
												<input type="button" name="save_a" id="save_a" value="save"/></td>-->
												
												</tr>
											<?php } } else {
												echo "<td align='center' colspan='3'>No records found</td>";
											} ?>
											</tbody>
										</table>
										<?php echo $links; ?>
			</div>
		</div>
	</div>
</div>
</div>
        <div class="modal fade" id="addrole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Add Role</span></h4>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" id="role_form" action="<?php echo base_url('admin/master/roles/add');?>">
				
					<div class="modal-body">
					<div class="row">
					   <div class="col-md-12 col-xs-12">				      
					   
					      <div class="form-group">				
							<label>Role Name</label>
							<input type="text" class="form-control" name="rolename" id="rolename" value=""/>		
							</div>						
					      
					   </div>													   	
					</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>
						<input type="submit" name="save_roles" id="save_roles" value="Save" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="delrole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Symptom Mild Delete</span></h4>
					</div>
					<form role="form" method="post" id="delrole_form" action="<?php echo base_url('admin/master/roles/delete');?>">
					<input type="hidden" name="roleId" id="roleId" value=""/> 
					<div class="modal-body">
						
						<h5>Are you sure want to delete? </h5>														
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							No
						</button>
						<input type="submit" name="delete_mild" id="delete_mild" value="Yes" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>
<script>
$(document).ready(function(){
	$("body").on('click','.edit', function(){
		var id = $(this).attr("id").replace("edit_","");
		//alert(id);
		var value = $('#desc_'+id).html();
		//alert(value);
		/*$('<input>').attr({
         type: 'text',
         id: 'descrip_'+id,
         name: 'descrip_'+id,
         value: value
      }).appendTo("#desc_"+id);
      $('<input>').attr({
         type: 'button',
         value : 'save'        
      }).appendTo("#action_"+id);
      $('<input>').attr({
         type: 'button',
         id: 'edit_cancel_'+id,
         name: 'edit_cancel_'+id,
         value : 'cancel',
         class : 'edit_cancel'
      }).appendTo("#action_"+id);*/
		$("#desc_"+id).html("<input type='hidden' id='descrip_hid_"+id+"' value='"+value+"'/><input type='text' class='form-control' name='descrip_"+id+"' id='descrip_"+id+"' value='"+value+"'/>");
		$("#action_"+id).html("<input type='button' id='edit_save_"+id+"' class='edit_save' value='save'/><input type='button' id='edit_cancel_"+id+"' class='edit_cancel' value='cancel'/>");
		
	});
	$("body").on('click','.edit_save', function(){
		var id = $(this).attr('id').replace("edit_save_","");
		var desc_val = $('#descrip_'+id).val();
		$('#desc_'+id).html(desc_val);
		$.ajax({
			url:"<?php echo base_url('admin/update/roles');?>",
			data:{cid:id,desc:desc_val},
			type:'post',
			async:false,
			success:function(response){
				if(response=='false')
				 alert('update failed');
			}			
		});
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#delrole" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	$("body").on('click','.edit_cancel', function(){
		var id = $(this).attr('id').replace("edit_cancel_","");
		var desc_val = $('#desc_'+id).html();
		var desc_hid_val = $('#descrip_hid_'+id).val();
		//alert(desc_hid_val);
		$('#desc_'+id).html(desc_hid_val);
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#delrole" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	
	$("body").on('click','.delete', function(){
	 	var did = $(this).data('row-did');
	 	//alert(did);
	 	$('#roleId').val(did);
	});
	 
	$('body').on('hidden.bs.modal', '.modal', function () {
   	$(this).find('.has-error').removeClass('has-error');
   	$('span.help-block').remove();
   	$(this).find('input').removeClass('help-block');
   	$(this).find('select').removeClass('help-block');
   	   $('#rolename').val('');
         $('#roleId').val('');
     
   });
   $('#role_form').validate({
		rules:{
			rolename:{
				required: true				
			}
		},
		messages:{
			rolename:{
				required:"You can't leave this empty"
			}
		}
	});
	
});
</script>