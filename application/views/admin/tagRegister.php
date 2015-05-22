<style>
.img-rounded{
	height: 55px !important;
}
</style>
<div class="wrap-content container" id="container">
<!-- start: PAGE TITLE -->
<section id="page-title">
<div class="row">
	<div class="col-sm-8">
		<h1 class="mainTitle">Registering Tags</h1>
		<!--<span class="mainDescription">List of tags available for profiles.</span>-->
	</div>
	<!--<ol class="breadcrumb">
		<li>
		<span>Admin</span>
		</li>
		<li class="active">
		<span>Tags</span>
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
			   <button class="btn btn-primary btn-o" data-toggle="modal" data-target="#addtag">
				Add New
			   </button>
	  </div>
			<div class="table-responsive">
										<table id="sample-table-1" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>S.No</th>
													<th>Type</th>
													<th>Description</th>
													<th>MAC Address</th>
													<th>Picture</th>
													<th>Cost</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php if(!empty($tagList)){
												foreach($tagList as $key=>$feed){ ?>
												<tr>
												<td><?=++$offset?></td>
												<td><?=$feed['tagTypeDescription'];?></td>												
												<td><?=$feed['tagDescription']?></td>												
												<td><?=$feed['tagMAC']?></td>												
												<td align="center"><img class="img-rounded" src="<?php echo base_url().'uploads/tags/'.$feed['tagImage'];?>" alt="" ></td>												
												<td>$<?=$feed['tagCost']?></td>
												<td><a href="#" class="edit" data-toggle="modal" data-target="#addtag" 
		                                data-row-id='<?php echo $feed["tagListId"]; ?>'
		                                data-row-type='<?php echo $feed["tagTypeId"]; ?>'
		                                data-row-desc='<?php echo $feed["tagDescription"]; ?>'                           
		                                data-row-mac='<?php echo $feed["tagMAC"]; ?>'                           
		                                data-row-image='<?php echo $feed["tagImage"]; ?>'                           
		                                data-row-cost='<?php echo $feed["tagCost"]; ?>'                           
		                                title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
		                                <a href="#" class="delete" data-toggle="modal" data-target="#deltag" 
		                                data-row-did='<?php echo $feed["tagListId"]; ?>'		                                                         
		                                title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
		                              </td>																												
												</tr>
											<?php } } else {
												echo "<td align='center' colspan='6'>No records found</td>";
											} ?>
											</tbody>
										</table>
										<?php echo $links; ?>
			</div>
		</div>
	</div>
</div>
</div>
        <div class="modal fade" id="addtag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Registering Tag</span></h4>
					</div>
					<form role="form" method="post" enctype="multipart/form-data" id="tag_form" action="<?php echo base_url('admin/tagRegister');?>">
					<input type="hidden" name="tagListId" id="tagListId" value=""/> 
					<input type="hidden" name="save_tagReg" id="save_tagReg" value="Save"  />
					<div class="modal-body">
					<div class="row">
					   <div class="col-md-6 col-xs-12">
					      
					      <div class="form-group">														
							<label>Tag Type</label>
							<select name="tag_type" id="tag_type" class="form-control">
							<option value="">--select type--</option>
							<?php if(!empty($tagType)){
								     foreach($tagType as $tags){
								     	echo "<option value='".$tags['tagTypeId']."'>".$tags['tagTypeDescription']."</option>";
								     }
								   }
							?>
							</select>																							
							</div>
					      
					      <div class="form-group">				
							<label>Tag Description</label>
							<input type="text" class="form-control" name="tag_desc" id="tag_desc" value=""/>		
							</div>
							
							<div class="form-group">				
							<label>MAC Address</label>
							<input type="text" class="form-control" name="tag_mac" id="tag_mac" value=""/>		
							</div>
							
							<div class="form-group">				
							<label>Tag Cost</label>
							<input type="text" class="form-control" name="tag_cost" id="tag_cost" value=""/>		
							</div>
					      
					   </div>													   
						<div class="col-md-6 col-xs-12">
					      
					     <div class="form-group">				
							<label>Tag Picture</label>
							<div data-provides="fileinput" class="fileinput fileinput-new">
								<div class="fileinput-new thumbnail">
								    
								   <img id="old_image" alt="" src="<?=empty_logo()?>">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"></div>
								<div class="user-edit-image-buttons">
									<span class="btn btn-azure btn-file">
									<span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span>
									<span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
									   <input type="hidden" id="old_tag_pic" name="old_tag_pic" value="" />
										<input type="file" class="" name="tag_pic">
									</span>
									<a data-dismiss="fileinput" class="btn fileinput-exists btn-red" href="#">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>								
							</div>	
						</div>
					    
					   </div>				
					</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							Close
						</button>
						<input type="submit" name="save_tag" id="save_tag" value="Save" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deltag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"><span id="addon_header">Paypal addon delete</span></h4>
					</div>
					<form role="form" method="post" id="edit_form" action="<?php echo base_url('admin/tagRegister');?>">
					<input type="hidden" name="del_id" id="del_id" value=""/> 
					<div class="modal-body">
						
						<h5>Are you sure want to delete? </h5>														
						
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-o" data-dismiss="modal">
							No
						</button>
						<input type="submit" name="delete_tag" id="delete_tag" value="Yes" class="btn btn-primary" />
						
					</div>
					</form>
				</div>
			</div>
		</div>
<script>
$(document).ready(function(){
	var base_url = "<?php echo base_url();?>";
	$(".delete").on('click', function(){
	 	var did = $(this).data('row-did');
	 	$('#del_id').val(did);
	 });
	
	$(".edit").on('click', function(){
        
         var id = $(this).data('row-id');
         var tagType = $(this).data('row-type');
         var tagDesc = $(this).data('row-desc');
         var tagMAC = $(this).data('row-mac');
         var tagCost = $(this).data('row-cost');
         var tagImage = $(this).data('row-image');
         
         $('#tagListId').val(id);
         $('#tag_type').val(tagType);
         $('#tag_desc').val(tagDesc);
         $('#tag_mac').val(tagMAC);
         $('#tag_cost').val(tagCost);
         $('#old_tag_pic').val(tagImage);
         $('#old_image').attr('src',base_url+'uploads/tags/'+tagImage);
         
   });
   
   $('body').on('hidden.bs.modal', '.modal', function () {
   	$(this).find('.has-error').removeClass('has-error');
   	$('span.help-block').remove();
   	$(this).find('input').removeClass('help-block');
   	$(this).find('select').removeClass('help-block');
   	   $('#del_id').val('');
         $('#tagListId').val('');
         $('#tag_type').val('');
         $('#tag_desc').val('');
         $('#tag_mac').val('');
         $('#tag_cost').val('');
         $('#old_tag_pic').val('');
         $('#old_image').attr('src','<?=empty_logo()?>');
   });
   
	$('#tag_form').validate({
		rules:{
			tag_type:{
				required: true				
			},
			tag_desc:{
				required:true
			},
			tag_mac:{
				required:true
			},
			tag_cost:{
				required:true,
				number:true
			},
			tag_pic:{
				required:{
					depends:function(element){
					   return !$('#old_tag_pic').val();
				   }  
				},
				extension: "jpg|jpeg|gif|png|bmp"
			}
		},
		messages:{
			tag_type:{
				required:"You can't leave this empty"
			},
			tag_desc:{
				required:"You can't leave this empty"
			},
			tag_mac:{
				required:"You can't leave this empty",
			},
			tag_cost:{
				required:"You can't leave this empty",
				number:"Only number are allowed"
			},
			tag_pic:{
				required:"You can't leave this empty",
				extension: "Upload a valid image file"
			}
		}
	});
});
</script>