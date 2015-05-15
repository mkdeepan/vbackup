
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
		<h1 class="mainTitle">Food & Ingredient</h1>
		<!--<span class="mainDescription">Master table for Food & Ingredients.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Food & Ingredients</span>
		</li>
	</ol>-->
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
													<th>Food Title</th>													
													<th>Ingredients</th>													
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($food_detail)){
												foreach($food_detail as $key=>$food){ ?>
												<tr>												
												<td><?=$key+1?></td>
												<td id="food_<?php echo $food['foodId'];?>"><?=$food['foodTitle'];?></td>	
												<td id="fooding_<?php echo $food['foodId'];?>">
												<span id="foodings_<?php echo $food['foodId'];?>" style="display:none"><?php echo $food['foodIngredient'];?></span>
												<?php
												if($food['foodIngredient'] != ''){
												$ingre = explode(',', $food['foodIngredient']);
												$inname = array();
												foreach($ingre as $ing)
                                                 {
                                                 	$inname[] = Admin_model::getIngredientName($ing);
                                                 }
                                                 echo implode(',',$inname);
                                                }

												?>
												</td>																																																							
												<td id="action_<?php echo $food['foodId'];?>">
		                               			<a href="#" class="edit" id="edit_<?php echo $food['foodId'];?>" title="Edit" data-toggle="modal" data-target="#editingname" data-row-did='<?php echo $food["foodId"]; ?>' ><i class="glyphicon glyphicon-edit"></i></a>
		                               			<a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='<?php echo $food["foodId"]; ?>' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
		                                        </td>		                              
											
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
        <div class="modal fade" id="addingname" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Food & Ingredients</span></h4>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" id="food_form" action="<?php echo base_url('admin/food/add');?>">
					<input type="hidden" name="foodId" id="foodId" value=""/> 
					<div class="modal-body basemodal">
					
					<div class="row ">
					   <div class="col-md-6 col-xs-6">				      
					   
					      <div class="form-group">				
							<label>Food </label>
							<input type="text" class="form-control" name="food_title" id="food_title" value=""/>		
							</div>						
					      
					   </div>	
					   <div class="col-md-6 col-xs-6">				      
					   
					      <div class="form-group">				
							<label>Ingredients</label>
							<select name="ingredients[]" id="ingredients" class="form-control" multiple="multiple">
								
								<?php
								 foreach($ingredient as $ing)
								 {
								?>
                                   <option value="<?php echo $ing['ingredientId'];?>"><?php echo $ing['ingredientName'];?></option>
								<?php
								 }
								?>
							</select>		
							</div>						
					      
					   </div>													   	
					</div>
					
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>
						<input type="submit" name="save_food" id="save_food" value="Save" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="editingname" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Food & Ingredients</span></h4>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" id="food_form_edit" action="<?php echo base_url('admin/food/update');?>">
					<input type="hidden" name="ehidid" id="ehidid" value=""/> 
					<div class="modal-body basemodal">
					
					<div class="row ">
					   <div class="col-md-6 col-xs-6">				      
					   
					      <div class="form-group">				
							<label>Food </label>
							<input type="text" class="form-control" name="efood_title" id="efood_title" value=""/>		
							</div>						
					      
					   </div>	
					   <div class="col-md-6 col-xs-6">				      
					   
					      <div class="form-group">				
							<label>Ingredients</label>
							<select name="eingredients[]" id="eingredients" class="form-control" multiple="multiple">
								
								<?php
								 foreach($ingredient as $ing)
								 {
								?>
                                   <option value="<?php echo $ing['ingredientId'];?>"><?php echo $ing['ingredientName'];?></option>
								<?php
								 }
								?>
							</select>		
							</div>						
					      
					   </div>													   	
					</div>
					
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>

						<input type="submit" name="save_food" id="save_food" value="Save" class="btn btn-primary" />
						
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
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Delete Food & Ingredients</span></h4>
					</div>
					<form role="form" method="post" id="edit_form" action="<?php echo base_url('admin/food/delete');?>">
					<input type="hidden" name="delfoodId" id="delfoodId" value=""/> 
					<div class="modal-body">
						
						<h5>Are you sure want to delete? </h5>														
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							No
						</button>
						<input type="submit" name="delete_food" id="delete_food" value="Yes" class="btn btn-primary" />
						
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
		var value = $('#food_'+id).html();
		var ingre = $('#foodings_'+id).html();
		$('#ehidid').val(id);
        $("#efood_title").val(value);
        var selectedOptions = ingre.split(",");
		for(var i in selectedOptions) {
		    var optionVal = selectedOptions[i];
		    $("#eingredients").find("option[value="+optionVal+"]").prop("selected", "selected");
		}
		$("#eingredients").multiselect('refresh');
        //$("#eingredients").val(ingre);
        

		
	});
	$("body").on('click','.edit_save', function(){
		var id = $(this).attr('id').replace("edit_save_","");
		var food_title = $('#efoodTitle_'+id).val();
		var food_ingredient = $('#efoodIng_'+id).val();
		$('#food_'+id).html(food_title);
		$('#fooding_'+id).html(food_ingredient);
		$.ajax({
			url:"<?php echo base_url('admin/food/update');?>",
			data:{foodid:id,food_title:food_title,food_ingredient:food_ingredient},
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
					$("#update_message").append('Food Detail Updated Successfully');
				}
			}			
		});
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	$("body").on('click','.edit_cancel', function(){
		var id = $(this).attr('id').replace("edit_cancel_","");
		var food_val = $('#food_'+id).html();
		var food_hid_val = $('#food_hid_'+id).val();
		var fooding_val = $('#fooding_'+id).html();
		var fooding_hid_val = $('#fooding_hid_'+id).val();
		//alert(desc_hid_val);
		$('#food_'+id).html(food_hid_val);
		$('#fooding_'+id).html(fooding_hid_val);
		$("#action_"+id).html('<a href="#" class="edit" id="edit_'+id+'" title="Edit"><i class="glyphicon glyphicon-edit"></i> </a> <a href="#" class="delete" data-toggle="modal" data-target="#deling" data-row-did='+id+' title="Delete"><i class="glyphicon glyphicon-remove"></i></a>');
	});
	
	$(".delete").on('click', function(){
	 	var did = $(this).data('row-did');
	 	$('#delfoodId').val(did);
	});
	 
	$('body').on('hidden.bs.modal', '.modal', function () {
   	$(this).find('.has-error').removeClass('has-error');
   	$('span.help-block').remove();
   	$(this).find('input').removeClass('help-block');
   	$(this).find('select').removeClass('help-block');
   	   $('#foodId').val('');
         $('#food_title').val('');
          $('#ingredients').val('');
         $("#delfoodId").val('');
     
   });

   
   $('#food_form').validate({
		rules:{
			'food_title':{
				required: true				
			}
		},
		messages:{
			'food_title':{
				required:"You can't leave this empty"
			}
		}
	});
   
   $('#food_form_edit').validate({
		rules:{
			'efood_title':{
				required: true				
			}
		},
		messages:{
			'efood_title':{
				required:"You can't leave this empty"
			}
		}
	});
	
});
</script>