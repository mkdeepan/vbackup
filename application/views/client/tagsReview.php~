<script>
<?php if(!empty($tagsList)){ $p=0;
        foreach($tagsList as $tagi) {
         $img_url = base_url().'uploads/tags/'.$tagi['tagImage'];
        	?>
        	
        	// $('#tag-tool-tip<?=$p?>').tooltipster({
//                content: $("<span><img src='<?=$img_url?>' /><strong><?=$tagi['tagName']?>:</strong><?=$tagi['tagDescription']?>.</span>"),
//                position: 'bottom-left'
//            });
        	<?php         	    
         $p++;  }
        }
        ?>

    
$(document).on('click','.delete_cart',function(){
	var id = $(this).data('id');
	$.ajax({
		url:"<?php echo site_url('tags/delete_cart');?>",
      type:'POST',
      data:{cart_id:id},
      async:false,
      dataType:'json',
      success:function (response) {
      	//alert(response.counts);
	     $('#tagListing').html(response.html);
	     $('#badge').html(response.counts);
	     $('#total').html(response.totalval);
             $('#btndis').html(response.btndisable);
      }
	});
});
</script>	 
<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Invoice</h1>
									<span class="mainDescription">Beautifully simple invoicing and payments. Give clients attractive invoices, estimates, and receipts.</span>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>vAlert</span>
									</li>
									<li class="active">
										<span>Review</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: INVOICE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="invoice">
										<div class="row invoice-logo">
											<div class="col-sm-6">
												<img alt="" src="assets/images/your-logo-here.png">
											</div>
											<div class="col-sm-6">
												<p class="text-dark">
													#1233219 / <?php echo date('d M Y')?><small class="text-light"> Lorem ipsum dolor sit amet </small>
												</p>
											</div>
										</div>
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
										<div class="row">
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
    <form class="form-horizontal" method="post" name="personal_info" id="personal_info" action="<?php echo site_url('tags/process_order');?>">
											<div class="col-sm-12">
											 <h5><strong>Order summary</strong>
        	  <span><a href="<?php echo base_url('tags');?>" class="title-link btn-link pull-right">Edit</a></span>
        	</h5>    
												<table class="table table-striped review" id="tagListing">
													<thead>
														<tr>
															<th> S.No </th>
															<th> Profile </th>
															<th class="hidden-480"> Allergic To </th>
															<th class="hidden-480"> Tag </th>
															<th class="hidden-480"> Quantity </th>
															<th> Cost </th>
														</tr>
													</thead>
													<tbody>
													 <?php if(!empty($tagsList)){ //var_dump($tagsList);
												   	$i=0;
												   	foreach($tagsList as $tag) { ?>
														<tr>
														<input type="hidden" name="accountOrderMappingId" value="<?=@$tag['accountOrderMappingId']?>"/>
															<td> <?=$i+1?> </td>
															<td> <?php echo $tag['profileFirstName'].' '.$tag['profileLastName'];?> </td>
															<td class="hidden-480"> <?php echo $this->tags_model->getAllergyById($tag['profileId']);?> </td>
															<td class="hidden-480" > <?=$tag['tagDescription']?>
				 <input type="hidden" name="item_name[]" value="<?=$tag['tagDescription']?>" /> </td>
															<td class="hidden-480">  <?=$tag['tagCount']?>
				 <input type="hidden" name="qty[]" value="<?=$tag['tagCount']?>" /> </td>
															<td> 
				 <input type="hidden" name="single_unit[]" value="<?=$tag['tagCost']?>" />  
															<?=$tag['subAmount']?> <br><small class="help-block">(1 unit = <?php echo '$'.$tag['tagCost'];?> )</small>
				 <span style="position:absolute;padding-left:100px;margin-top:-40px"> <a href="#" class="delete_cart" data-id="<?=$tag['tagInfoId']?>" ><img class="review-close" src="<?php echo base_url().'/source/assets/img/close.png';?>" alt="" ></a> </span></td>
														</tr>
														<?php $i++; 
														   } 
														}else{
															echo "<tr><td width='100%' colspan='6' align='center'>No items in cart.</td></tr>";
														}?>
														
													</tbody>
												</table>
											</div>
										</div>
<?php
                                        if(!empty($tag['totalAmount']))
                                        {
                                            $totalamount=$tag['totalAmount'];
                                        }
                                        else
                                        {

                                            $totalamount='0';
                                        }
                                        ?>
										<div class="row">
											<div class="col-sm-12 invoice-block">
                                                                                             <div id="total">
												<ul class="list-unstyled amounts text-small">
													<li>
														<strong>Sub-Total:</strong> $<?=$totalamount?>
													</li>
													<li>
														<strong>Discount:</strong> 0%
													</li>
													<li>
														<strong>VAT:</strong> 0%
													</li>
													<li class="text-extra-large text-dark margin-top-15">
														<strong >Total:</strong>$<?=$totalamount?>
													</li>
												</ul>
</div>
												<br>
											<!--	<a onclick="javascript:window.print();" class="btn btn-lg btn-primary hidden-print">
													Print <i class="fa fa-print"></i>
												</a>
												<a class="btn btn-lg btn-primary btn-o hidden-print">
													Submit Your Invoice <i class="fa fa-check"></i>-->
													 <?php
           $tagCount = $this->tags_model->getCartList($this->session->userdata('account_id'),'1'); 
             $disable = (@$tagCount == '0')?'disabled':'';
           ?>
		      <a href="<?php echo base_url('user');?>" name="cancel" id="cancel" class="btn btn-default">Cancel</a>
		      <span id="btndis"><input type="submit" <?=$disable?> name="save" id="save" value="Order" class="btn btn-success"/></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						 </form>
						<!-- end: INVOICE -->
					</div>
