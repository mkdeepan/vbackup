<?php
class User extends CI_Controller {
    
    function __construct()
    {
    	 parent::__construct();
    	 $this->load->library('form_validation');
	    $this->load->library('session');
	    $this->load->helper('cookie');
	    $this->load->model('user_model');
	    $this->load->model('common_model');
	    $this->load->model('allergy_model');
       $this->data = array(
         'template' => 'template',
         'controller' => $this->router->fetch_class(),
         'method' => $this->router->fetch_method(),
		   'account_id' => isset($this->session->userdata['account_id']) ? $this->session->userdata['account_id'] : 8,
         //'user_role' => isset($this->session->userdata['user_role']) ? $this->session->userdata['user_role'] : 0,
       );
       error_reporting(E_ALL);
    }
  public function index()
  {
     if(!$this->session->userdata('isLogin'))
        redirect('login');
     $data = array('title' => 'Dashboard', 'page' => 'dashboard', 'errorCls' => NULL,'page_params' => NULL);
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
	public function account_info()
	{
		if(!$this->session->userdata('isLogin'))
		redirect('login');
		
	   $data = array('title' => 'Account Information', 'page' => 'client/user_detail', 'errorCls' => NULL,'page_params' => NULL);
   	$data = $data + $this->data;
   	$data['addr_type'] = $this->common_model->select_from('AddressType');
   	$data['phone_type'] = $this->common_model->select_from('PhoneType');
   	$data['email_type'] = $this->common_model->select_from('EmailType');
   	$data['state'] = $this->common_model->select_from('State');
   	$data['country'] = $this->common_model->select_from('Country');
   	//echo $data['account_id']; exit;
      $data['summary'] = $this->user_model->get_summary_page($data['account_id']);
   	$data['account'] = $this->user_model->account_info($data['account_id']);
	   $data['payment'] = $this->common_model->select_from('PaymentInformation','',array('paymentInfoId'=>$data['account'][0]['accountPaymentId']));
   	
   	$this->load->view($data['template'],$data);
		
	}

   public function personalInfo()
   {
   	// var_dump($_FILES);
   	//echo '<pre>';
     // var_dump($_POST);exit;
   
      if($this->input->post('personal_save'))
      {
         
      	
      	$phone_array = array();
      	$email_array = array();
      	$address_array = array();
      	if(!empty($_POST['phone_type']))
      	{
      		$i = 0;
      		foreach($_POST['phone_type'] as $phone)
      		{
      			if($_POST['phone_type'][$i] != '' && $_POST['phone_number'][$i]!='')
      			{
      				$phone_array[] = array(
      				                 'accountId'=>$this->session->userdata('account_id'),
      				                 'phoneTypeId'=>$_POST['phone_type'][$i],
      				                 'phoneNumber'=>$_POST['phone_number'][$i],
      				                 'phoneNumberEx'=>$_POST['amn_ex'][$i]
      				               );
      			}
      		  $i++;
      		}
      	}
      //	var_dump($phone_array);
         if(!empty($phone_array)){
         	//var_dump($phone_array);
         	$del = $this->common_model->delete_from('PhoneNumberTable',array('accountId'=>$this->session->userdata('account_id')));
         	//echo $del;exit;
         	if($del){
         		$res = $this->common_model->insert_batch_rec('PhoneNumberTable',$phone_array);
         	
         	}
         }
           
           
         if(!empty($_POST['email_type']))
      	{
      		$j = 0;
      		foreach($_POST['email_type'] as $email)
      		{
      			if($_POST['email_type'][$j] != '' && $_POST['email_id'][$j]!='')
      			{
      				$email_array[] = array(
      				                 'accountId'=>$this->session->userdata('account_id'),
      				                 'emailTypeId'=>$_POST['email_type'][$j],
      				                 'emailAddress'=>$_POST['email_id'][$j]      				        
      				               );
      			}
      		 $j++;
      		}
      	}
         
         if(!empty($email_array)){
         	//var_dump($email_array);
         	$del = $this->common_model->delete_from('EmailTable',array('accountId'=>$this->session->userdata('account_id')));
         	
          if($del){
             $res = $this->common_model->insert_batch_rec('EmailTable',$email_array);          
             //debug_last_query();exit;
         	}
         }
           
           
         if(!empty($_POST['addr_type']))
      	{
      		$k = 0;
      		foreach($_POST['addr_type'] as $addr)
      		{
      			if($_POST['firstline'][$k] != '' && $_POST['add_country'][$k]!='')
      			{
      				$address_array[] = array(
      				                   'accountId' =>$this->session->userdata('account_id'),
      				                   'addressTypeId' =>$_POST['addr_type'][$k],
      				                   'addressFirst' =>$_POST['firstline'][$k],
      				                   'addressSecond' =>$_POST['secondline'][$k],
      				                   'city' =>$_POST['add_city'][$k],
      				                   'state' =>$_POST['add_state'][$k],
      				                   'zip' =>$_POST['add_zip'][$k],
      				                   'country' =>$_POST['add_country'][$k]
      				                 );
      			}
      		 $k++;
      		}
      	}
         if(!empty($address_array)){
         	$del = $this->common_model->delete_from('AddressTable',array('accountId'=>$this->session->userdata('account_id')));
         	if($del){
         	  $this->common_model->insert_batch_rec('AddressTable',$address_array);
         	}
         }
            
            
      	if($_FILES['file_photo']['tmp_name'] !='')   
      	{
      	  $datas = $this->do_upload();
           $pic_name = $datas['upload_data']['file_name'];
         }
         else
         {
           $pic_name = $this->input->post('old_account_picture');
         }
     
      	$account_id = $this->input->post('account_id');
      	
      	$values = array(
   		           'accountFirstName' => $this->input->post('first_name'),
   		           'accountLastName' => $this->input->post('last_name'),
   		           'accountGender' => $this->input->post('gender'),
   		           'accountPicture' => $pic_name   	
   		          );
   		$where = array(
   		           'accountId' => $account_id
   		         );
   		$res = $this->common_model->update_data('Account',$values,$where);
   		if($res){
   			$this->session->set_userdata('profile_img_url', base_url().'uploads/accountImages/'.$pic_name);
   		   $this->session->set_flashdata('success','Account information updated successfully.');
   		}else{
   			$this->session->set_flashdata('failure','Account information updation failed.');
   		}
   	   redirect('user');
      }
     redirect('user');
   }
   
   function do_upload()
	{		
		$path = "uploads/accountImages/";
		//echo $path; 
      if(!is_dir($path)) //create the folder if it's not already exists
				    {				      
				      mkdir($path,0777,TRUE);
				      chmod('./uploads/accountImages', 0777);
					   chmod($path, 0777);
				    } 
		$config['upload_path'] = "./uploads/accountImages/";
		$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
		
		$this->upload->initialize($config);
		
      if(is_file($config['upload_path']))
          {
             chmod($config['upload_path'], 0777); 
          }
		if ( !$this->upload->do_upload('file_photo'))
		{
			$this->session->set_flashdata('failure',$this->upload->display_errors());
			return false;
	   }
		else
		{
				$datas = array('upload_data' => $this->upload->data());
				chmod($path.'/'.$datas['upload_data']['file_name'],0777);
				return $datas;
			
		}
	}
}
