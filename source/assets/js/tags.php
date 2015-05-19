<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller {
	
   function __construct() {
       parent::__construct();
       $this->load->library('form_validation');
	    $this->load->library('session');
	    $this->load->helper('cookie');
	    $this->load->model('common_model');
	    $this->load->model('tags_model');
       $this->data = array(
         'template' => 'template',
         'controller' => $this->router->fetch_class(),
         'method' => $this->router->fetch_method()
		   //'user_id' => isset($this->session->userdata['user_id']) ? $this->session->userdata['user_id'] : 0,
         //'user_role' => isset($this->session->userdata['user_role']) ? $this->session->userdata['user_role'] : 0,
       );
       error_reporting(0);
   }
   
   public function index()
   {
   	if(!$this->session->userdata('isLogin'))
		redirect('login');
		
		$data = array('title' => 'Ordering Tags', 'page' => 'client/orderingTag', 'errorCls' => NULL,'page_params' => NULL);
		$values = array('profileId','profileFirstName','profileLastName');
		$where = array('accountId'=>$this->session->userdata('account_id'));
		$data['profile'] = $this->common_model->select_from('Profile',$values,$where);
		$data['tags'] = $this->common_model->select_from('TagList');
		//var_dump($data['tags']);
		$data['accountinfo'] = $this->tags_model->getAccountDetail($this->session->userdata('account_id'));
		$data['orderedtags'] = $this->tags_model->getOrderedTags($this->session->userdata('account_id'));
		$data['tagsList'] = $this->tags_model->getCartList($this->session->userdata('account_id'));
		//var_dump($data['tagsList']); 
		$data = $data + $this->data;
		
		$this->load->view($data['template'],$data);
   }
   
   public function save_order()
   {
   	/*echo '<pre>';
   	var_dump($_POST); */
   	if(!empty($_POST['profileid']))
   	{
   		$tag_order = array();
   		$tag_order_update = array();
   		$account_order = array(
   		                   'orderDate'=>date("Y-m-d H:i:s"),       
   		                   'accountId'=>$this->session->userdata('account_id'),
   		                   'totalAmount'=>$_POST['total_amount'],
   		                   'paymentDate'=>'',
   		                   'paymentStatus'=>'0'
   		                 );
   		if(isset($_POST['account_order_id']) && $_POST['account_order_id']!=''){
   			$accountMappingId = $_POST['account_order_id'];
   			$where = array(
   			           'accountOrderMappingId' => $accountMappingId
   			         );
   			$this->common_model->update_data('AccountOrderMapping',$account_order,$where);
   		}else{
   			$accountMappingId = $this->common_model->insert_db('AccountOrderMapping',$account_order);
   		}
   		  
   		     
   		$i = 0;
   		foreach($_POST['profileid'] as $row){
   			if($_POST['profileid'][$i] != '' && $_POST['tagid'][$i] != '' && $_POST['quantity'][$i] != '' && $_POST['amt'][$i] != '')
   			{  		
   			 
   				if($_POST['tag_id'][$i]!=''){
   					$tag_order_update[] = array(
   				                 'profileId'=>$_POST['profileid'][$i],
   				                 'tagId'=>$_POST['tagid'][$i],
   				                 'tagCount'=>$_POST['quantity'][$i],
   				                 'subAmount'=>$_POST['amt'][$i],
   				                 'accountOrderMappingId'=>$accountMappingId,
   				                 'tagInfoId' => $_POST['tag_id'][$i]
   				               );
   				}else{
	   				$tag_order[] = array(
	   				                 'profileId'=>$_POST['profileid'][$i],
	   				                 'tagId'=>$_POST['tagid'][$i],
	   				                 'tagCount'=>$_POST['quantity'][$i],
	   				                 'subAmount'=>$_POST['amt'][$i],
	   				                 'accountOrderMappingId'=>$accountMappingId
	   				               );
   				}
   			}
   		 $i++;
   		}
   	 if(!empty($tag_order))
   	 {	
   	 		$this->common_model->insert_batch_rec('TagInfo',$tag_order);  	 
   	 }
       if(!empty($tag_order_update))
       {
       	/*foreach($tag_order_update as $row){
       		$temp_array = array(
       		                    'profileId'=>$row['profileId'],
   				                 'tagId'=>$row['tagId'],
   				                 'tagCount'=>$row['tagCount'],
   				                 'subAmount'=>$row['subAmount'],
   				                 'accountOrderMappingId'=>$row['accountOrderMappingId']   				                
       		              );
       		 $where = array('tagInfoId'=>$row['tagInfoId']);
       		 $this->common_model->update_data('TagInfo',$temp_array,$where);
       	} */
       	//var_dump($tag_order_update); 
         $res = $this->db->update_batch('TagInfo',$tag_order_update,'tagInfoId');
        
       }
   	 
   	 redirect('tags/review');  
   	}
   }
   
   public function load_allergy()
   {
   	$profile_id = $_POST['id'];
   	$allergies = $this->tags_model->getAllergyById($profile_id,'1');
   	
   	echo $allergies;
   }
   
   public function load_amount()
   {
   	$tagid = $_POST['tid'];
   	$amount = $this->common_model->select_from('TagList',array('tagCost'),array('tagListId'=>$tagid));
   	
   	echo $amount[0]['tagCost'];
   }
   
   public function review()
   {
   	
   	if(!$this->session->userdata('isLogin'))
		redirect('login');
		
		$data = array('title' => 'Tags Review', 'page' => 'client/tagsReview', 'errorCls' => NULL,'page_params' => NULL);
		$data['tagsList'] = $this->tags_model->getCartList($this->session->userdata('account_id'));
		//var_dump($data['tagsList']);
		$data = $data + $this->data;
		$this->load->view($data['template'],$data);
   }

   public function delete_cart()
   {
  	$id = $_POST['cart_id'];
   	$where = array(
   	            'tagInfoId' => $id
   	         );
   	$sub_query = $this->common_model->select_from('TagInfo',array('subAmount','accountOrderMappingId'),$where);
   	$sub_amount = $sub_query[0]['subAmount'];
   	$accountOrderId = $sub_query[0]['accountOrderMappingId'];
   	
   	$sql = "UPDATE AccountOrderMapping AS w SET w.totalAmount = IF(".$sub_amount."=0, @b:=w.totalAmount, @b:=w.totalAmount-".$sub_amount." )
                                 WHERE w.accountordermappingid = ".$accountOrderId."";
                
   	$query = $this->db->query($sql);
   	$res = $this->common_model->delete_from('TagInfo',$where);
   	$res = '';
   	$tagsList = $this->tags_model->getCartList($this->session->userdata('account_id'));
   	$counts = $this->tags_model->getCartList($this->session->userdata('account_id'),'1');
   	$res = "";
   	$res .= '<thead>
					 <th>S.No</th>
					 <th>Profile</th>
					 <th class="hidden-480">Allergic To</th>
					 <th class="hidden-480">Tag</th>
					 <th class="hidden-480">Quantity</th>
					 <th>Cost</th>
					 </thead>';
      if(!empty($tagsList)){
		   	$i=0;
		   	foreach($tagsList as $tag) { 
				$res .= '<tbody>
					 <tr>
				 <input type="hidden" name="accountOrderMappingId" value="'.$tag["accountOrderMappingId"].'"/>				
				 <td>'.($i+1).'</td>
             <td width="150px">'.$tag['profileFirstName'].' '.$tag['profileLastName'].'</td> 
				 <td>'.$this->tags_model->getAllergyById($tag["profileId"]).'</td>				 
				 <td class="hidden-480">
				  '.$tag["tagDescription"].'
				 <input type="hidden" name="item_name[]" value="'.$tag["tagDescription"].'" />
				 </td>			 
				 <td class="hidden-480">
				 '.$tag["tagCount"].'
				 <input type="hidden" name="qty[]" value="'.$tag["tagCount"].'" />
				 </td>				 
				 <td class="hidden-480" align="">
				  <input type="hidden" name="single_unit[]" value="'.$tag["tagCost"].'" />
				  '.$tag["subAmount"].' <br><small class="help-block">(1 unit = $'.$tag["tagCost"].' )</small>
				  <span style="position:absolute;padding-left:100px;margin-top:-40px">
				  <a href="#" class="delete_cart" data-id="'.$tag["tagInfoId"].'" >
				  <img class="review-close" src="'.base_url()."source/assets/img/close.png".'" alt="" ></a></span>
				 </td>	
				</tr>';
			
			    $i++; 
			   } 
			}else{
				$res .= "<tr><td width='100%' colspan='6' align='center'>No items in cart.</td></tr>";
			}
				$res .= '</tbody>';
                        if(!empty($tag["totalAmount"]))
                    {
                        $btndisable='<input type="submit" name="save" id="save" value="Order" class="btn btn-success"/>';
                        $totalamount=$tag["totalAmount"];
                    }
                    else
                    {
                        $totalamount='0';
                        $btndisable='<input type="submit" disabled name="save" id="save" value="Order" class="btn btn-success"/>';
                    }
                                $totalval='<ul class="list-unstyled amounts text-small">
													<li>
														<strong>Sub-Total:</strong> $'.$totalamount.'
													</li>
													<li>
														<strong>Discount:</strong> 0%
													</li>
													<li>
														<strong>VAT:</strong> 0%
													</li>
													<li class="text-extra-large text-dark margin-top-15">
														<strong >Total:</strong>$'.$totalamount.'
													</li>
												</ul>';
/*
<tr class="taginfocolor">
				  <td colspan="4"></td>
				  <td align="right"><label>Total:</label></td>
				  <td align="center">'.@$tag["totalAmount"].'</td>
				</tr>
*/
		  $result = array('html'=>$res,'counts'=>$counts,'totalval'=>$totalval,'btndisable'=>$btndisable);
   	echo json_encode($result);
   }
   
   public function process_order()
   {
		//session_start();
		//include_once("../config.php");
		//include_once("paypal.class.php");

		$PayPalMode 			= 'sandbox'; // sandbox or live
		$PayPalApiUsername 		= 'prakash.kalai-facilitator_api1.vebinary.com'; //PayPal API Username
		$PayPalApiPassword 		= 'HTAPYKHBTLYNAKFF'; //Paypal API password
		$PayPalApiSignature 	= 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AUegpXvjDhJpUlJ3S7JHGpypCiR4'; //Paypal API Signature
		$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
		$PayPalReturnURL 		= site_url('tags/process_order'); //Point to process page
		$PayPalCancelURL 		= site_url('tags/cancel_order'); //Cancel URL if user clicks cancel
		
		$this->load->library('paypal');

		$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';

		if($_POST) //Post Data received from product list page.
		{
			//session for order id to update
			$this->session->set_userdata('orderid',$_POST['accountOrderMappingId']);
			//Other important variables like tax, shipping cost
			//to get variables from db done by deepan
			$where = array('status'=>'1');
			$select = array('*');
			$additional_payments = $this->common_model->select_from('PaypalAddons',$select,$where);
			
			//deepan code ends here
			/*$TotalTaxAmount 	= 2.58;  //Sum of tax for all items in this order. 
			$HandalingCost 	= 2.00;  //Handling cost for this order.
			$InsuranceCost 	= 1.00;  //shipping insurance cost for this order.
			$ShippinDiscount 	= -3.00; //Shipping discount for this order. Specify this as negative number.
			$ShippinCost 		= 3.00; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
         */
			//we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
			//Please Note : People can manipulate hidden field amounts in form,
			//In practical world you must fetch actual price from database using item id. 
			//eg : $ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
			$paypal_data ='';
			$ItemTotalPrice = 0;
			
		    foreach($_POST['item_name'] as $key=>$itmname)
		    {
		    	//var_dump($_POST); exit;
		    	//echo $itmname;
		        //$product_code 	= filter_var($_POST['item_code'][$key], FILTER_SANITIZE_STRING); 
				
				//$results = $mysqli->query("SELECT product_name, product_desc, price FROM products WHERE product_code='$product_code' LIMIT 1");
				//$obj = $results->fetch_object();
				
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='. urlencode($itmname);
		        //$paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.' ='.urlencode($_POST['accountOrderMappingId']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='. urlencode($_POST['single_unit'][$key]);		
				  $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($_POST['qty'][$key]);
		    
				  // item price X quantity
		        $subtotal = ($_POST['single_unit'][$key]*$_POST['qty'][$key]);
				
		        //total price
		        $ItemTotalPrice = $ItemTotalPrice + $subtotal;
				
				//create items for session
				$paypal_product['items'][] = array('itm_name'=>$itmname,
													'itm_price'=>$_POST['single_unit'][$key],
												//	'itm_code'=>$_POST['item_code'][$key], 
													'itm_qty'=>$_POST['qty'][$key]
													);
		    }
			//exit;	
			$additionalCost = 0;
			$additionalDetails = array();
			$paypal_url = '';
			foreach($additional_payments as $payments){			   
				$additionalDetails[$payments['description']]=$payments['amount'];
				$additionalCost += $payments['amount'];
				$paypal_url .= '&PAYMENTREQUEST_0_'.$payments['paypalVariable'].'='.urlencode($payments['amount']);				
			}
			//Grand total including all tax, insurance, shipping cost and discount
			$GrandTotal = ($ItemTotalPrice + $additionalCost);
			$additionalDetails['grandTotal'] = $GrandTotal;
										
			/*$paypal_product['assets'] = array('tax_total'=>$TotalTaxAmount, 
										'handaling_cost'=>$HandalingCost, 
										'insurance_cost'=>$InsuranceCost,
										'shippin_discount'=>$ShippinDiscount,
										'shippin_cost'=>$ShippinCost,
										'grand_total'=>$GrandTotal);*/
	      $paypal_product['assets'] = $additionalDetails;
			
			//create session array for later use
			//$_SESSION["paypal_products"] = $paypal_product;
			$this->session->set_userdata("paypal_products",$paypal_product);
			//Parameters for SetExpressCheckout, which will be sent to PayPal
			$padata = 	'&METHOD=SetExpressCheckout'.
						'&RETURNURL='.urlencode($PayPalReturnURL ).
						'&CANCELURL='.urlencode($PayPalCancelURL).
						'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
						$paypal_data.				
						'&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that does not require shipping
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
						/*'&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
						'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
						'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
						'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
						'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).*/
						$paypal_url.
						'&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
						'&LOCALECODE=GB'. //PayPal pages to match the language on your website.
						'&LOGOIMG='.base_url().'assets/img/logo.png'. //site logo
						'&CARTBORDERCOLOR=FFFFFF'. //border color of cart
						'&ALLOWNOTE=1';
				//echo $padata; exit;
				//We need to execute the "SetExpressCheckOut" method to obtain paypal token
				$paypal= new PayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
				
				//Respond according to message we receive from Paypal
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
				{
						//Redirect user to PayPal store with Token received.
					 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
						header('Location: '.$paypalurl);
				}
				else
				{
					//Show error message
					echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';
				}

		}

		//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
		{
			//we will be using these two variables to execute the "DoExpressCheckoutPayment"
			//Note: we haven't received any payment yet.
			
			$token = $_GET["token"];
			$payer_id = $_GET["PayerID"];
			
			//get session variables
			//$paypal_product = $_SESSION["paypal_products"];
			$paypal_product = $this->session->userdata('paypal_products');
			$paypal_data = '';
			$ItemTotalPrice = 0;

		    foreach($paypal_product['items'] as $key=>$p_item)
		    {		
				$paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='. urlencode($p_item['itm_qty']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($p_item['itm_price']);
		        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($p_item['itm_name']);
		       // $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($p_item['itm_code']);
		        
				// item price X quantity
		        $subtotal = ($p_item['itm_price']*$p_item['itm_qty']);
				
		        //total price
		        $ItemTotalPrice = ($ItemTotalPrice + $subtotal);
		    }

			$padata = 	'&TOKEN='.urlencode($token).
						'&PAYERID='.urlencode($payer_id).
						'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
						$paypal_data.
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
						'&PAYMENTREQUEST_0_TAXAMT='.urlencode($paypal_product['assets']['VAT']).
						'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($paypal_product['assets']['Shipping']).
						'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($paypal_product['assets']['Handling']).
						'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($paypal_product['assets']['Discount']).
						'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($paypal_product['assets']['Insurance']).
						'&PAYMENTREQUEST_0_AMT='.urlencode($paypal_product['assets']['grandTotal']).
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);

			//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
			$paypal= new PayPal();
			$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			//Check if everything went ok..
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
			{

					/*echo '<h2>Success</h2>';
					echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);*/
					
						/*
						//Sometimes Payment are kept pending even when transaction is complete. 
						//hence we need to notify user about it and ask him manually approve the transiction
						*/
						
						if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
						{
							$success_msg = '<h5 style="color:green">Payment Received! Your product will be sent to you very soon!</h5>';
						}
						elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
						{
							$success_msg = '<h5 style="color:red">Transaction Complete, but payment is still pending! '.
							'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></h5>';
						}

						// we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
						// GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
						$padata = 	'&TOKEN='.urlencode($token);
						$paypal= new PayPal();
						$httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

						if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
						{
							
							/*echo '<br /><b>Stuff to store in database :</b><br />';
							
							echo '<pre>';*/
							/*
							#### SAVE BUYER INFORMATION IN DATABASE ###
							//see (http://www.sanwebe.com/2013/03/basic-php-mysqli-usage) for mysqli usage
							//use urldecode() to decode url encoded strings.
							
							$buyerName = urldecode($httpParsedResponseAr["FIRSTNAME"]).' '.urldecode($httpParsedResponseAr["LASTNAME"]);
							$buyerEmail = urldecode($httpParsedResponseAr["EMAIL"]);
							
							//Open a new connection to the MySQL server
							$mysqli = new mysqli('host','username','password','database_name');
							
							//Output any connection error
							if ($mysqli->connect_error) {
								die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
							}		
							
							$insert_row = $mysqli->query("INSERT INTO BuyerTable 
							(BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
							VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");
							
							if($insert_row){
								print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
							}else{
								die('Error : ('. $mysqli->errno .') '. $mysqli->error);
							}
							
							*/
							$update_data = array(
							                  'paymentDate' => date("Y-m-d H:i:s"),
							                  'paymentStatus' => '1',
							                  'tokenId' => $httpParsedResponseAr['TOKEN'],
							                  'transactionId' => $httpParsedResponseAr['PAYMENTREQUESTINFO_0_TRANSACTIONID'],
							               );
							      $where = array(
							                 'accountOrderMappingId' => $this->session->userdata('orderid')
							               );
							$res = $this->common_model->update_data('AccountOrderMapping',$update_data,$where);
							if($res){
								$this->session->set_userdata('orderid','');
							}
							//echo "<a href='".base_url('home')."' class='btn btn-success'>Return home</a>";
							?>
							<link rel="stylesheet" href="http://myvalert.com/source/vendor/bootstrap/css/bootstrap.min.css">
							<div style="margin-bottom:10px"></div>
							<div class="container">
							<div class="col-md-9 col-sm-9 col-xs-12 col-lg-9">
							<div class="bs-example" data-example-id="simple-panel">
							<div class="panel panel-default">
							<div class="panel-body"> 
							<img style="float:right;margin-top:-10px" src="<?php echo base_url();?>source/assets/images/paypal-64.png" alt="" />
							<h4 style="color:#D28039"> Thanks for your order </h4>
							<h5>Your payment of $<?=$GrandTotal?> USD is now complete.</h5>
							<h5><?php echo $success_msg;?></h5>
							<h5><a href="<?php echo base_url('user');?>">Click here </a>to go back to VAlert</h5>
							</div>
							</div>
							</div>
							<p>PayPal. Safer. Simpler. Smarter.</p>
							<p>For more information, see our <a href="https://www.paypal.com/in/webapps/mpp/ua/privacy-full">Privacy Policy</a>, <a href="https://www.paypal.com/in/webapps/mpp/ua/useragreement-full">User Agreement</a> and <a href="https://www.paypal.com/va/webapps/mpp/ua/servicedescription-full">Service Description.</a></p>
							</div>
							</div>
							<?php
							/*echo '<pre>';
							print_r($httpParsedResponseAr);
							echo '</pre>';*/
						} else  {
							echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
							/*echo '<pre>';
							print_r($httpParsedResponseAr);
							echo '</pre>';*/

						}
			
			}else{
					echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';
			}
		}

   }

   function cancel_order()
   {
   	    $data = array('title' => 'Order Cancelled', 'page' => 'ordercancelled', 'errorCls' => NULL,'page_params' => NULL);
		//$data['tagsList'] = $this->common_model->select_from('');
		$data = $data + $this->data;
		$this->load->view($data['template'],$data);
   }
}
 
