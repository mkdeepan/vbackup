<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct() {
        parent::__construct();
          error_reporting(E_ALL);
	       $this->load->library('form_validation');
		    $this->load->library('session');
		    $this->load->helper('cookie');
		    $this->load->model('common_model');
                    $this->load->helper('string');
          $this->data = array(
            'template' => 'template',
            'controller' => $this->router->fetch_class(),
            'method' => $this->router->fetch_method()
			   /*'user_id' => isset($this->session->userdata['user_id']) ? $this->session->userdata['user_id'] : 0,
            'user_role' => isset($this->session->userdata['user_role']) ? $this->session->userdata['user_role'] : 0,*/
          );
     }
   
    function index(){
    	
    	 if($this->session->userdata('isLogin'))
		 redirect('user');
		 
    	 $data = array('title' => 'Login', 'page' => 'client/login', 'errorCls' => NULL,'page_params' => NULL);
    	 if($this->input->post('username'))
		 {
			$select = array('*');
			$where = array(
			             'accountEmail' => $this->input->post('username'),
			             'loginPassword' => base64_encode($this->input->post('password')),
			         );
			$result = $this->common_model->select_from('Account',$select,$where);
			if(!empty($result))
			{
			 if($result[0]['status'] == '1')
			 {
				$account_image = ($result[0]['accountPicture'])?$result[0]['accountPicture']:'no-image.png';
				
				$account_details = array(
				                      'profilename'=>$result[0]['accountFirstName'].' '.$result[0]['accountLastName'],
				                      'account_id'=>$result[0]['accountId'],
				                      'username'=>$result[0]['loginName'],
				                      'account_mail'=>$result[0]['accountEmail'],
				                      'account_role'=>$result[0]['userRole'],
				                      'isLogin' => '1',
				                      'profile_img_url' => base_url().'uploads/accountImages/'.$account_image
				                      );
				                      //var_dump($account_details); exit;
	      	                $this->session->set_userdata($account_details);
				$this->session->set_flashdata('success','Logged-in successfully.');
				if($result[0]['userRole'] == '1'){
				 redirect('admin');
				}else if($result[0]['userRole'] == '2'){
				 redirect('user');
			   }
			 }
		    else
		    {
		    	$this->session->set_flashdata('failure','Please verify email authentication process');
		    	redirect('login');
		    }
				
			}
		   else 
		   {
		   	$this->session->set_flashdata('failure','Username/Password invalid.');
		   	redirect('login');
		   }
		}
    	 $data = $data + $this->data;
		 $this->load->view($data['template'],$data); 	
    }

    function registration(){
    	 $data = array('title' => 'Registration', 'page' => 'client/registration', 'errorCls' => NULL,'page_params' => NULL);
    	 $data['countries'] = $this->common_model->select_from('Country',array('countryId','countryName'));
       if($this->input->post('reg-submit'))
		 {
		 	//echo '<pre>';
		 	//var_dump($_POST); exit;
		 	$result = $this->insert_post($_POST);
		 	if($result){
		 		$this->session->set_flashdata('success','Account registered successfully');
		 	}else{
		 		$this->session->set_flashdata('failure','Account registration failed');
		 	}
		 	redirect('login/registration');
		 }
    	 $data = $data + $this->data;
		 $this->load->view($data['template'],$data); 	
    }
  
    public function insert_post($input)
    {
    	$unique_key = random_string('alnum',5);
   	$account_details = array(
   	                      'accountFirstName'=>$input['afname'],
   	                      'accountLastName'=>$input['alname'],
   	                      'accountEmail'=>$input['aemail'],
   	                      'loginPassword'=>base64_encode($input['apassword']),
   	                      'accountGender'=>$input['agender'], 
                              'accountMobilePhone'=>$input['amobile'],   	                     
   	                      'amn_ex'=>$input['amobile_ex'],  
   	                      'status' => '0',
   	                      'uniqueKey' => md5($unique_key)
   	                   );
   	$account_id = $this->common_model->insert_db('Account',$account_details);
   	if($account_id){
   		  $toMail = $input['aemail'];
   		  $url = base_url().'login/verify/'.urlencode($input['aemail']).'/'.urlencode($unique_key);
   		  $mailContant = array(
   		                   'subject' => 'vAlert Registration',
   		                   'body' => "Dear ".$input['afname']." ".$input['alname'].",<br><br>Thanks for registering in vAlert. Please activate your vAlert account by 

clicking the following link.<br><br>
   		                              ".$url."<br><br>Thanks." 
   		                 );
   		  
   	     $profile_details = array(
   								'profileFirstName' => $input['pfname'],
   								'profileMiddleName' => $input['pmname'],
   								'profileLastName' => $input['plname'],
   								'profileDateOfBirth' => $input['pbyear'].'-'.$input['pbmonth'].'-'.$input['pbday'],   								
   								'profileMobilePhone' => $input['pmobile'],
   								'profileMobileEx' => $input['pmobile_ex'],
   								'profileEmail' => $input['pemail'],
   								'profileGenderId' => $input['pgender'],
   								'accountId' => $account_id
   	                   );
   	     $profile_id = $this->common_model->insert_db('Profile',$profile_details);
   	     sendMail('vAlert',$toMail,$mailContant,$attach = NULL,$ccEmail = NULL);
   	     return $profile_id;
   	}else{
   		return false;
   	}      
    }
 
    public function checkEmail()
    {
   	$email = $this->input->post('aemail');
   	$where = array('accountEmail'=>$email);
   	$exist = $this->common_model->select_from('Account','',$where);
   	if(!empty($exist)){
   		echo 'false';
   	}else{
   		echo 'true';
   	}
   
   }
   
   public function forgot_password()
   {
   	$data = array('title' => 'Forgot password', 'page' => 'client/forgotPassword', 'errorCls' => NULL,'page_params' => NULL);
   	$data = $data + $this->data;
   	if($this->input->post('fusername'))
   	{
   		//var_dump($_POST); exit;
   		$select = array('*');
			$where = array(
			             'accountEmail' => $this->input->post('fusername')
			         );
			$result = $this->common_model->select_from('Account',$select,$where);
			if(!empty($result))
			{
			 if($result[0]['status'] == '1')
			 {
				$forgot_key = random_string('alnum',6);
				$toMail = $result[0]['accountEmail'];
   		   $mailContant = array(
   		                   'subject' => 'vAlert - Password recovery:',
   		                   'body' => "Dear ".$result[0]['accountFirstName']." ".$result[0]['accountLastName'].",<br><br>
   		                    Your password has been reseted successfully. Please login with following details.<br><br>
   		                    <b>New password :</b> ".$forgot_key."<br><br>
   		                    Please <a href='".base_url('login')."'>login</a> here.<br><br>Thanks." 
   		                 );
   		   $values = array('loginPassword' => base64_encode($forgot_key));
   		   $where = array('accountId' => $result[0]['accountId']);
   		   $this->common_model->update_data('Account',$values,$where);
   		   sendMail('vAlert - Recovery',$toMail,$mailContant,$attach = NULL,$ccEmail = NULL);
				$this->session->set_flashdata('success','Password reseted successfully, please check your mail.');
				redirect('login/forgot_password');
			 }
		    else
		    {
		    	$this->session->set_flashdata('failure','Status of your account is in-active. Please activate your account by clicking the activate link in your email address.');
		    	redirect('login/forgot_password');
		    }
				
			}
		   else 
		   {
		   	$this->session->set_flashdata('failure','Enter valid registered email address.');
		   	redirect('login/forgot_password');
		   }
   	}
		$this->load->view($data['template'],$data); 	
   }

   public function logout()
   {
   	$account_details = array(
				                      'profilename'=>'',
				                      'account_id'=>'',
				                      'username'=>'',
				                      'account_mail'=>'',
				                      'account_role'=>'',
				                      'isLogin' => '',
				                      'profile_img_url' => ''
				                      );
   	$this->session->unset_userdata($account_details);
	   redirect('login');
   }
   
   public function verify($email='',$key='')
   {
   	if($email != '' && $key != '')
   	{
   	   $select = array('*');
			$where = array(
			             'accountEmail' => urldecode($email),
			             'uniqueKey' => md5(urldecode($key))
			         );
			$result = $this->common_model->select_from('Account',$select,$where);
			if(!empty($result))
			{
				if($result[0]['status'] == '0')
				{
					$values = array('status'=>'1');
					$where = array('accountEmail'=>urldecode($email));
					$update = $this->common_model->update_data('Account',$values,$where);
					if($update){
					 $msg=ucfirst($result[0]['accountFirstName']).' '.ucfirst($result[0]['accountLastName']).', your account is now activated.';
						$this->session->set_flashdata('success',$msg);
					}else{
						$this->session->set_flashdata('failure','Account status updation failed');
					}
	   	   }else{
	   	   	$this->session->set_flashdata('success','Account status already updated');
	   	   }			  			
			}else{
				$this->session->set_flashdata('failure','Account details not found');
			}
		  redirect('login');	
		}
	   else
	   {
	   	redirect('login');
	   }
   }
   
   public function testmail()
   {
   	$this->load->helper('string');
   	echo md5(random_string('alnum',5)); exit;
   	echo uniqid(); exit;
   	$mailContant = array(
   	               );
   	sendMail('mkdeeps','deepan.k@quadrupleindia.com',$mailContant,$attach = NULL,$ccEmail = NULL);
   }
}
 
