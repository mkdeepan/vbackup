<meta http-equiv="cache-control" content="max-age=0" /> <meta http-equiv="cache-control" content="no-cache" /> <meta http-equiv="expires" content="0" /> <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" /> <meta http-equiv="pragma" content="no-cache" />
<script src="<?php echo base_url(); ?>source/assets/js/jquery.creditCardValidator.js"></script>
<script>
$(function() {
        /*$('#my-tooltip').tooltipster({
                content: $('<span>This is tag ordering page.</span>'),
                position: 'bottom'
            });*/
        <?php if($tags){ $p=0;
        foreach($tags as $tagi) {
        	?>
        	/* $('#tag-tool-tip<?=$p?>').tooltipster({
                content: $('<span><img src="<?php echo base_url().'uploads/tags/'.$tagi['tagImage'];?>" />This is tag ordering page.</span>'),
                position: 'top-right'
            });*/
        	<?php         	    
         $p++;  }
        }
        ?>
      /*  $("#cardno").validateCreditCard(function(result) {
           if(result.valid)
           {
            if(result.card_type.name != null )
             {
               var file = '';
               switch(result.card_type.name)
               {
                   case 'amex':
                          file = 'american_express.png';
                          break;
                   case 'diners_club_carte_blanche':
                          file = 'diners_club.png';
                          break;
                   case 'diners_club_international':
                          file = 'diners_club.png';
                          break;
                   case 'jcb':
                          file = 'jcb.png';
                          break;
                   case 'laser':
                          file = 'laser.png';
                          break;
                   case 'visa_electron':
                          file = 'visa_electron.png';
                          break;
                   case 'visa':
                          file = 'visa.png';
                          break;
                   case 'mastercard':
                          file = 'master_card.png';
                          break;
                   case 'maestro':
                          file = 'maestro.png';
                          break;
                   case 'discover':
                          file = 'discover.png';
                          break;
               }
              $('.log').html('<img src="<?php echo base_url(); ?>assets/img/'+file+'" style="margin-top:-50px;"/>');
            }
           }
            else
            {
              //$('.log').html('');
            }
        });*/
   $(document).on('change', '.tagid', function(){
   	   $('.quantity').change();
   	});
   $(document).on('change', '.quantity', function(){
   	var this_obj = $(this).attr('id');
      var current_id = this_obj.substr(this_obj.length - 1); 	
    
      if($('#tagid'+current_id).val()!='' && $('#quantity'+current_id).val()!='')
      {
      	var total_amount = 0;
      	var tagid = $('#tagid'+current_id).val();
      	var quan = $('#quantity'+current_id).val();
      	var subtot = '';
      	$.ajax({
   			url:'<?php echo base_url()."index.php/tags/load_amount";?>',
   			type:'post',
   			data:{tid:tagid},
   			async: false,
   			success:function(response){
   				var sum = parseFloat(response) * parseFloat(quan);
   				//var hid_tot = parseFloat(Math.round(sum * 100) / 100).toFixed(2);
   				//subtot = '$'+parseFloat(Math.round(sum * 100) / 100).toFixed(2);
   				subtot = '$'+sum;
   				var quote = "<br><p class='help-block'>(1 Unit = $"+parseFloat(response)+")</p>";
   				subtot += quote;
   			   $("#amount"+current_id).html(subtot);
   			   $("#amt"+current_id).val(sum);
   			},  			
   		});
   	  $('.subamount').each(function (key,val) {
            total_amount += Number($(this).val());
        });
        $('#total_amount').val(total_amount);
        
        $('.total_amount').html('$'+total_amount);
        
      }
      
   });  
     
   $(document).on('change', '.profileid', function(){
   	
    //for allergy load process and tag cost
      var this_obj = $(this).attr('id');
      var current_id = this_obj.substr(this_obj.length - 1);
   	var val = $(this).val();
   	var value = '';
   
    //for row iteration process
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
		
		$profile = ($trNew.find('.profileid'));
		$profile.attr('id','profileid'+id);
		$('#profileid'+id).val('');
		
		
		$allergy = ($trNew.find('.allergy'));
		$allergy.attr('id','allergy'+id);
		$('#allergy'+id).empty();
		
		
		$tag = ($trNew.find('.tagid'));
		$tag.attr('id','tagid'+id);
		$('#tagid'+id).val('');
	

		$quantity = ($trNew.find('.quantity'));
		$quantity.attr('id','quantity'+id);
		$('#quantity'+id).val('');
	
      
      $amount = ($trNew.find('.amount'));
		$amount.attr('id','amount'+id);
		$('#amount'+id).empty('');
		
		$samount = ($trNew.find('.subamount'));
		$samount.attr('id','amt'+id);
		$('#amt'+id).empty('');
                $('#amt'+id).val('');
		
		
		$access = ($trNew.find('.tag_id'));
		$access.attr('id','tag_id'+id);
		$('#tag_id'+id).val('');
				
	   $trLast.after($trNew);
    }
     if(val != '')
   	{
   		$.ajax({
   			url:'<?php echo base_url()."index.php/tags/load_allergy";?>',
   			type:'post',
   			data:{id:val},
   			async: false,
   			success:function(response){
   			   $("#allergy"+current_id).html(response);
   			},  			
   		});
   		
   	} 
   	else
   	{
   		$("#allergy"+current_id).html('');
   	}
   });
    });
</script>
<div class="wrap-content container" id="container">
<form class="form-horizontal" method="post" name="ordering_tag" id="ordering_tag" action="<?php echo base_url('index.php/tags/save_order');?>">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Ordering Tags</h1>
									<!--<span class="mainDescription">Beautifully simple invoicing and payments. Give clients attractive invoices, estimates, and receipts.</span>-->
								</div>
								<!--<ol class="breadcrumb">
									<li>
										<span>vAlert</span>
									</li>
									<li class="active">
										<span>Tags</span>
									</li>
								</ol>-->
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: INVOICE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="invoice">
										<!--<div class="row invoice-logo">
											<div class="col-sm-6">
												<img alt="" src="assets/images/your-logo-here.png">
											</div>
											<div class="col-sm-6">
												<p class="text-dark">
													#1233219 / <?php echo date('d M Y')?> <small class="text-light"> Lorem ipsum dolor sit amet </small>
												</p>
											</div>
										</div>-->
										<hr>
										<div class="row">
											<div class="col-sm-4">
												<h4>Client:</h4>
												<div class="well">
													<address>
														<strong class="text-dark">Customer Company, Inc.</strong>
														<br>
														1 Infinite Loop
														<br>
														Cupertino, CA 95014
														<br>
														<abbr title="Phone">P:</abbr> (123) 456-7890
													</address>
													<address>
														<strong class="text-dark">E-mail:</strong>
														<a href="mailto:#">
															info@customer.com
														</a>
													</address>
												</div>
											</div>
											<div class="col-sm-4">
												<h4>We appreciate your business.</h4>
												<div class="padding-bottom-30 padding-top-10 text-dark">
													Thanks for being a customer.
													A detailed summary of your invoice is below.
													<br>
													If you have questions, we're happy to help.
													<br>
													Email support@cliptheme.com or contact us through other support channels.
												</div>
											</div>
											<div class="col-sm-4 pull-right">
												<h4>Payment Details:</h4>
												<ul class="list-unstyled invoice-details padding-bottom-30 padding-top-10 text-dark">
													<li>
														<strong>V.A.T Reg #:</strong> 233243444
													</li>
													<li>
														<strong>Account Name:</strong> Company Ltd
													</li>
													<li>
														<strong>SWIFT code:</strong> 1233F4343ABCDEW
													</li>
													<li>
														<strong>DATE:</strong> 01/01/2014
													</li>
													<li>
														<strong>DUE:</strong> 11/02/2014
													</li>
												</ul>
											</div>
										</div>
										<hr>
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
										<div class="row">
											<div class="col-sm-12">
												<table class="table table-striped" id="table_access">
													<thead>
														<tr>
															<th> S.No </th>
															<th> Profile </th>
															<th class="hidden-480"> Allergic To </th>
															<th class="hidden-480"> Tag </th>
															<th class="hidden-480"> Quantity </th>
															<th class="center"> Cost </th>
														</tr>
													</thead>
													<tbody>
													<?php
													 if(!empty($profile)){
													 $i=0;
													 if(!empty($tagsList)){
														 foreach($tagsList as $taglist)
														 {?>
																	
															<tr id="accessrow<?php echo $i;?>" class="tr_clone">
															 <td class="sno"><?php echo ($i+1).'.';?></td>
															  <input type="hidden" name="tag_id[]" id="tag_id<?php echo $i;?>" value="<?php echo $taglist['tagInfoId'];?>"/>
					                                <input type="hidden" name="account_order_id" id="account_order_id<?php echo $i;?>" value="<?php echo $taglist['accountOrderMappingId'];?>"/>
					
															<td>
															<select class="form-control profileid" name="profileid[]" id="profileid<?php echo $i;?>">
																	<option value="">Select a Profile</option>
																	<?php foreach($profile as $pro){
					  	$selected = ($pro['profileId'] == $taglist['profileId'])?'selected':'';
					      echo "<option $selected value='".$pro['profileId']."'>".$pro['profileFirstName'].' '.$pro['profileLastName']."</option>";
					   } ?>
																</select>
																									 		</td>
															<td class="hidden-480"><div id="allergy<?php echo $i;?>" class="allergy"><?php echo $this->tags_model->getAllergyById($taglist['profileId'],'1');?></div> </td>
															<td class="hidden-480"> 
															<select class="form-control tagid" name="tagid[]" id="tagid<?php echo $i;?>">
																	<option value="">Select a Tag</option>
															<?php if($tags) { $k=0; foreach($tags as $tag){
					  	$select_tag = ($tag['tagListId']==$taglist['tagId'])?'selected':'';
					      echo "<option id='tag-tool-tip".$k."' $select_tag value='".$tag['tagListId']."'>".$tag['tagDescription']."</option>";
					   $k++; } }?>
					  </select>
					 	</select>
															</td>
															<td> 
															<select class="form-control quantity input-sm" id="quantity<?php echo $i;?>" name="quantity[]">
															 <option value="">Select...</option>
															 <?php
															 for($j=1;$j<=10;$j++){
															 	$select_quan = ($j==$taglist['tagCount'])?'selected':'';
															 	echo "<option $select_quan value='".$j."'>".$j."</option>";
															 } 
															 ?>
															 </select>
					   									 </td>
															<td>  
															<div class="center" id="amount<?php echo $i;?>" class="amount"><?='$'.$taglist['subAmount']?>
															 <br>
										                <p class="help-block">(1 Unit = <?php echo '$'.$taglist['tagCost'];?>)</p>
										                </div>
										                <input type="hidden" class="subamount" name="amt[]" value="<?=$taglist['subAmount']?>" id="amt<?php echo $i;?>"/>				 
															 </td>
														</tr>
														 <?php $i=$i+1; }
	     													 }  ?>
														<tr id="accessrow<?php echo $i;?>" class="tr_clone">
															<td class="sno"> <?php echo ($i+1).'.';?> </td>
															<td> 
															<select class=" form-control profileid"  name="profileid[]" id="profileid<?php echo $i;?>">
															<option value="" selected>Select a Profile</option>
															 <?php foreach($profile as $pro){
					      echo "<option value='".$pro['profileId']."'>".$pro['profileFirstName'].' '.$pro['profileLastName']."</option>";
					   } ?>
					   									</select>
					   									 </td>
															<td class="hidden-480"><div id="allergy<?php echo $i;?>" class="allergy">
					 </div></td>
															<td class="hidden-480">
															<select class="form-control tagid" name="tagid[]" id="tagid<?php echo $i;?>">
																<option value="" selected >Select a Tag</option>
															<?php if($tags){ $k=0; foreach($tags as $tag){
					      echo "<option value='".$tag['tagListId']."'>".$tag['tagDescription']."</option>";
					   $k++; }} ?>
					   									</select> 
															 </td>
															<td class="hidden-480"> 
															<select class="form-control quantity" id="quantity<?php echo $i;?>" name="quantity[]" style="hieght:20px;overflow:auto;">
																<option value="" selected>Select a Quantity</option>
															<?php
					 for($j=1;$j<=10;$j++){
					 	echo "<option value='".$j."'>".$j."</option>";
					 } 
					 ?>
					   									</select> 
															</td>
															<td align="center"> 
															 <div id="amount<?php echo $i;?>" class="amount">
					 </div>
															<input type="hidden" class="subamount" name="amt[]" value="" id="amt<?php echo $i;?>"/>	 </td>
														</tr>
														<?php
		 } else {
		 	echo "<tr><td colspan='6' align='center'>No Profiles in this account.</td></tr>";
		 } ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 invoice-block">
												<ul class="list-unstyled amounts text-small">
													<li style="display:inline-block;">
														<strong>Sub-Total:</strong>  <span class="total_amount"><?php echo (@$taglist['totalAmount']!= '')?'$'.@$taglist['totalAmount']:'$0';?></span>
			      <input type="hidden" id="total_amount" name="total_amount" value="<?=@$taglist['totalAmount']?>" />
													</li>
													<!--<li>
														<strong>Discount:</strong> 0%
													</li>
													<li>
														<strong>VAT:</strong> 0%
													</li>-->
													<li class="text-extra-large text-dark margin-top-15">
														<strong >Total:</strong> <span class="total_amount"><?php echo (@$taglist['totalAmount'] != '')?'$'.@$taglist['totalAmount']:'$0';?></span>
													</li>
												</ul>
												<br>
												<!--<a onclick="javascript:window.print();" class="btn btn-lg btn-primary hidden-print">
													Print <i class="fa fa-print"></i>
												</a>
												<a class="btn btn-lg btn-primary btn-o hidden-print">
													Submit Your Invoice <i class="fa fa-check"></i>
												</a>-->
											<a href="<?php echo site_url('home');?>" name="cancel" id="cancel" class="btn btn-default">Cancel</a>
		      <input type="submit" name="save" id="save" value="Review" class="btn btn-success"/>
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						 </form>
						<!-- end: INVOICE -->
					</div>
