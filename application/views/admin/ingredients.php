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
		<h1 class="mainTitle">Ingsredients</h1>
		<span class="mainDescription">Master table for Ingredients.</span>
	</div>
	<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Ingredients</span>
		</li>
	</ol>
</div>
</section>
<div id="update_message" class="alert alert-success alert-dismissible" role="alert" style="display:none">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    
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
<!-- end: PAGE TITLE -->
<!--<?php var_dump($feedback);?>-->

<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
	<div class="row">
		<div class="col-md-12">
		<div class="">
			   <button class="btn btn-primary btn-o" data-toggle="modal" data-target="#addingname">
				Add New
			   </button>
	  </div>
			<div class="table-responsive">
										<table id="sample-table-1" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>													
													<th>Ingredient</th>													
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($ingredient)){
												foreach($ingredient as $key=>$ing){ ?>
												<tr>												
												<td><?=$key+1?></td>
												<td id="name_<?php echo $ing['ingredientId'];?>"><?=$ing['ingredientName'];?></td>																																																							
												<td id="action_<?php echo $ing['ingredientId'];?>">
		                               			<a href="#" class="edit" id="edit_<?php echo $ing['ingredientId'];?>" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
		                               			<a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='<?php echo $ing["ingredientId"]; ?>' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
		                                        </td>		                              
											
												</tr>
											<?php } } else {
												echo "<td align='center' colspan='3'>No records found</td>";
											} ?>
											</tbody>
										</table>
										<?php //echo $links; ?>
			</div>
		</div>
	</div>
</div>
</div>
        <div class="modal fade" id="addingname" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Ingredient Name</span></h4>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" id="ingredient_form" action="<?php echo base_url('admin/ingredients/add');?>">
					<input type="hidden" name="ingredientId" id="ingredientId" value=""/> 
					<div class="modal-body basemodal">
					<label>Ingredient</label>
					<div class="row ">
					   <div class="col-md-12 col-xs-12">				      
					   
					      <div class="form-group">				
							
							<input type="text" class="form-control" name="ingredient[]" id="ingredient" value=""/>		
							</div>						
					      
					   </div>													   	
					</div>
					
					</div>
					<a href="#" class="addmore" style="margin-left: 520px;font-weight:bold">Add More</a>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>
						<input type="submit" name="save_ingredient" id="save_ingredient" value="Save" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deling" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Delete Ingredient</span></h4>
					</div>
					<form role="form" method="post" id="edit_form" action="<?php echo base_url('admin/ingredients/delete');?>">
					<input type="hidden" name="delingredientId" id="delingredientId" value=""/> 
					<div class="modal-body">
						
						<h5>Are you sure want to delete? </h5>														
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							No
						</button>
						<input type="submit" name="delete_ingredient" id="delete_ingredient" value="Yes" class="btn btn-primary" />
						
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
		var value = $('#name_'+id).html();
		
		$("#name_"+id).html("<input type='hidden' id='name_hid_"+id+"' value='"+value+"'/><input type='text' class='form-control' name='ename_"+id+"' id='ename_"+id+"' value='"+value+"'/>");
		$("#action_"+id).html("<input type='button' id='edit_save_"+id+"' class='edit_save' value='save'/><input type='button' id='edit_cancel_"+id+"' class='edit_cancel' value='cancel'/>");
		
	});
	$("body").on('click','.edit_save', function(){
		var id = $(this).attr('id').replace("edit_save_","");
		var desc_val = $('#ename_'+id).val();
		$('#name_'+id).html(desc_val);
		$.ajax({
			url:"<?php echo base_url('admin/ingredients/update');?>",
			data:{ingid:id,name:desc_val},
			type:'post',
			async:false,
			success:function(response){
				$("#update_message").show();
				if(response=='false')
				{
					$("#update_message").append('Updation Failed');
				}
				else
				{
					$("#update_message").append('Ingredient Updated Successfully');
				}
			}			
		});
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	$("body").on('click','.edit_cancel', function(){
		var id = $(this).attr('id').replace("edit_cancel_","");
		var desc_val = $('#name_'+id).html();
		var desc_hid_val = $('#name_hid_'+id).val();
		//alert(desc_hid_val);
		$('#name_'+id).html(desc_hid_val);
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	
	$(".delete").on('click', function(){
	 	var did = $(this).data('row-did');
	 	$('#delingredientId').val(did);
	});
	 
	$('body').on('hidden.bs.modal', '.modal', function () {
   	$(this).find('.has-error').removeClass('has-error');
   	$('span.help-block').remove();
   	$(this).find('input').removeClass('help-block');
   	$(this).find('select').removeClass('help-block');
   	   $('#ingredientId').val('');
         $('#ingredient').val('');
         $("#delingredientId").val('');
     
   });

   $(".addmore").on('click', function(){
       
      $(".basemodal").append('<div class="row "><div class="col-md-11 col-xs-11"><div class="form-group"><input type="text" class="form-control" name="ingredient[]" id="ingredient" value=""/></div></div><div class="col-md-1 col-xs-1"><div class="form-group"><a href="#" class="removediv"><i class="glyphicon glyphicon-remove"></i></a></div></div></div>');
      $("a.removediv").on('click',function(){
      	  $(this).parents('.row').remove();
       });
   
   });
     
   $('#ingredient_form').validate({
		rules:{
			'ingredient[]':{
				required: true				
			}
		},
		messages:{
			'ingredient[]':{
				required:"You can't leave this empty"
			}
		}
	});
	
});
</script>