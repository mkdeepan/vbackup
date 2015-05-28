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
       $this->load->model('profile_model');
       $this->data = array(
         'template' => 'template',
         'controller' => $this->router->fetch_class(),
         'method' => $this->router->fetch_method(),
		   'account_id' => isset($this->session->userdata['account_id']) ? $this->session->userdata['account_id'] : 0,
         //'user_role' => isset($this->session->userdata['user_role']) ? $this->session->userdata['user_role'] : 0,
       );
       error_reporting(E_ALL);
    }
  public function index()
  {
     if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
     $data = array('title' => 'Dashboard', 'page' => 'dashboard', 'errorCls' => NULL,'page_params' => NULL);
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
	
	public function account_info()
	{
		if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
	  $data = array('title' => 'Account Information', 'page' => 'client/user_detail', 'errorCls' => NULL,'page_params' => NULL);
   	$data = $data + $this->data;
   	$data['addr_type'] = $this->common_model->select_from('AddressType');
   	$data['phone_type'] = $this->common_model->select_from('PhoneType');
   	$data['email_type'] = $this->common_model->select_from('EmailType');
   	$data['state'] = $this->common_model->select_from('State');
   	$data['country'] = $this->common_model->select_from('Country');
   	//echo $data['account_id']; exit;
    $data['summary'] = $this->user_model->get_summary_page($data['account_id']); //summary tab information
   	$data['account'] = $this->user_model->account_info($data['account_id']); // overview and account tab
    $data['rphone'] = $this->common_model->select_from('PhoneNumberTable',array('phoneNumber','phoneNumberEx'),array('accountId'=>$data['account_id'])); // signing info tab

   
	  
     //$data['payment'] = $this->common_model->select_from('PaymentInformation','',array('paymentInfoId'=>$data['account'][0]['accountPaymentId']));
   	
   	$this->load->view($data['template'],$data);
		
	}

   public function personalInfo()
   {
      if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
   	// var_dump($_FILES);
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
         //var_dump($email_array);
         if(!empty($email_array)){
         	//var_dump($email_array);
         	$del = $this->common_model->delete_from('EmailTable',array('accountId'=>$this->session->userdata('account_id')));
         	//echo $del; 
          if($del){
             $this->common_model->insert_batch_rec('EmailTable',$email_array);
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
   	   redirect('user/account_info');
      }
     redirect('user/account_info');
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
				if(file_exists("./uploads/accountImages/".$_POST['old_account_picture']))
				{
					unlink("./uploads/accountImages/".$_POST['old_account_picture']);
				}
				$datas = array('upload_data' => $this->upload->data());
				chmod($path.'/'.$datas['upload_data']['file_name'],0777);
				return $datas;
			
		}
	}

  public function signingInfo()
   {
    if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
    
    if($this->input->post('update_password'))
     {
      $id = $this->session->userdata('account_id');
      //var_dump($_POST); exit;
      $where = array(
                 'accountEmail' => $this->input->post('username'),
                 'accountId' => $id,
                 'loginPassword' => base64_encode($this->input->post('old_pwd'))
                );
      $select = array('*');
      $res = $this->common_model->select_from('Account',$select,$where);
      
      if($res){
        $values = array(
                 'loginPassword' => base64_encode($this->input->post('new_pwd')),
                );
        $where = array(
                   'accountId' => $id
                 );
        $update = $this->common_model->update_data('Account',$values,$where);
        if($update){
          $this->session->set_flashdata('success','Password changed successfully.');
        }else{
          $this->session->set_flashdata('failure','Password updation failed.');
        }
        
      }else{
        $this->session->set_flashdata('failure',"Username / Password invalid.");
      }
      
       redirect('user/account_info');
     }
      
   }

   function profile($profile_id='')
   {

    if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
    
    $data = array('title' => 'Account Information', 'page' => 'client/allergy_detail', 'errorCls' => NULL,'page_params' => NULL);
    
    $data['state'] = $this->common_model->select_from('State');
    $data['country'] = $this->common_model->select_from('Country');
    $data['phone_type'] = $this->common_model->select_from('PhoneType');
    $data['addr_type'] = $this->common_model->select_from('AddressType');
    $data['account'] = $this->user_model->account_info($this->session->userdata('account_id'));
    $data['allergy_name'] = $this->common_model->select_from('AllergyName');
    $data['allergy_type'] = $this->common_model->select_from('AllergyType');
    $data['symptoms_severe'] = $this->common_model->select_from('SymtomsSevere');
    $data['symptoms_mild'] = $this->common_model->select_from('SymtomsMild');
    $data['allergies'] = $this->allergy_model->getAllergyById($profile_id);
    $data['incidents'] = $this->allergy_model->getIncidentById($profile_id);
    $data['profile_id'] = $profile_id;
    $data['profile'] = $this->profile_model->profile_info($profile_id);
    $data['emergency'] = $this->profile_model->get_emergency_contact($profile_id);
    $data['doctor'] = $this->profile_model->get_doctor_detail($profile_id);
    //var_dump($data['profile']);
    $where = array('profileId'=>$profile_id);
    $data['infosharing'] = $this->common_model->select_from('InformationSharing','',$where);
    $data = $data + $this->data;
    $this->load->view($data['template'],$data);
   }
   
   public function editAllergy($proid='')
   {
    if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
    
  //  $data = array('title' => 'Allergy Information', 'page' => 'editAllergy', 'errorCls' => NULL,'page_params' => NULL);
    if($this->input->post('save') && $this->input->post('profile_id')){
      /*echo "<pre>";
      var_dump($_POST); exit;*/
      
      $id = $_POST['profile_id'];
    //division for allergy area
      $allergy_ids = array();
      $new_allergy_id = array(); //fetching new allergy id for deleting purpose in line no 133
      $i=0;
      if(!empty($_POST['view_allergy_name_id'])){
      foreach($_POST['view_allergy_name_id'] as $input){
        
        if($_POST['exist_allergy_id'][$i] == ''){
          
          if($_POST['view_allergy_name_id'][$i] == 'others'){
              $allerName_id = $this->common_model->insert_db('AllergyName',array('allergyNameDescription'=>$_POST['view_allergy_name'][$i]));
            }else{
              $allerName_id = $_POST['view_allergy_name_id'][$i];
            }
          if($_POST['view_allergy_type_id'][$i] == 'others'){
              $allerType_id = $this->common_model->insert_db('AllergyType',array('allergyTypeDescription'=>$_POST['view_allergy_type'][$i]));
            }else{
              $allerType_id = $_POST['view_allergy_type_id'][$i];
            }
         
          /*if($_POST['view_mild_id'][$i] == 'others'){
              $symMild_id = $this->common_model->insert_db('SymtomsMild',array('symtomMildDescription'=>$_POST['view_mild'][$i]));
            }else{
              $symMild_id = $_POST['view_mild_id'][$i];
            }*/
          
          /*if($_POST['view_severe_id'][$i] == 'others'){
              $symSev_id = $this->common_model->insert_db('SymtomSevere',array('symtomSevereDescription'=>$_POST['view_severe'][$i]));
            }else{
              $symSev_id = $_POST['view_severe_id'][$i];
            }*/
          $input_allergy = array(
                              'allergyNameId' => $allerName_id,
                              'allergyTypeId' => $allerType_id,                             
                              'profileId' => $id
                           );
        
          $new_allergy_id[] = $allergy_id = $this->common_model->insert_db('Allergy',$input_allergy);
          
          //mild array
           $mild_ids = explode(',',$_POST['view_mild_id'][$i]);
           if(!empty($mild_ids)){
            foreach($mild_ids as $mid){
               if($mid == 'others'){
                $symMild_id = $this->common_model->insert_db('SymtomsMild',array('symtomMildDescription'=>$_POST['view_mild_others'][$i]));
              }else{
                $symMild_id = $mid;
              }
               $mild_array[] = array(
                                 'allergyId'=>$allergy_id,
                                 'symtomMildId'=>$symMild_id
                               );
            }
             $this->common_model->insert_batch_rec('ProfileSymtomsMild',$mild_array);
           }
       
             //severe array
           $severe_ids = explode(',',$_POST['view_severe_id'][$i]);
           if(!empty($severe_ids)){
            foreach($severe_ids as $severe){
               if($severe == 'others'){
                $symSev_id = $this->common_model->insert_db('SymtomsSevere',array('symtomSevereDescription'=>$_POST['view_severe_others'][$i]));
              }else{
                $symSev_id = $severe;
              }
               $severe_array[] = array(
                                 'allergyId'=>$allergy_id,
                                 'symtomSevereId'=>$symSev_id
                               );
            }
              $this->common_model->insert_batch_rec('ProfileSymtomsSevere',$severe_array);
           }
         }else{
            $allergy_ids[]=$_POST['exist_allergy_id'][$i];
        }                 
        $i++;
       }  
      }
   //allergy ids which exist in db and deleting section
       $allergy_exist_ids = $this->common_model->select_from('Allergy',array('allergyId'),array('profileId'=>$id));
    
       if(!empty($allergy_exist_ids)){
        foreach($allergy_exist_ids as $row){
          $allergy_exist_id[] = $row['allergyId'];
        }
         $all_allergy_ids = array_diff($allergy_exist_id,$allergy_ids);
         $delete_ids = array_diff($all_allergy_ids,$new_allergy_id);
         
    // var_dump($delete_ids); exit;
            $this->load->model('profile_model');
         $this->profile_model->delete_ids('Allergy','allergyId',$delete_ids);
         $this->profile_model->delete_ids('ProfileSymtomsMild','allergyId',$delete_ids);
         $this->profile_model->delete_ids('ProfileSymtomsSevere','allergyId',$delete_ids);
         
       }
   // division for incident entries
       $i=0;
       $incident_allergy = array();
       $incident_ids = array();
       if(!empty($_POST['inci_date'])){
      foreach($_POST['inci_date'] as $input){
        
        if($_POST['exist_incident_id'][$i]=='') {
          
          if($_POST['inci_view_allergy_id'][$i] == 'others'){
              $allerType_id = $this->common_model->insert_db('AllergyType',array('allergyTypeDescription'=>$_POST['inci_view_allergy'][$i]));
          }else{
              $allerType_id = $_POST['inci_view_allergy_id'][$i];
          }
          
          $incident_allergy[] = array(
                              'allergyIncidentDate' => $_POST['inci_date'][$i],
                              'allergyIncidentDesc' => $_POST['description'][$i],
                              'allergyTypeId' => $allerType_id,
                              'profileId' => $id
                           );
          $where = array(
                     'profileId'=>$id
                   );
                   
          //$this->common_model->insert_db('AllergyIncidentSymptoms',$incident_allergy);  
        }else{
            $incident_ids[]=$_POST['exist_incident_id'][$i];
        }                 
        $i++;
       }
      }
        //delete the hidden records
        $inci_exist_ids = $this->common_model->select_from('AllergyIncidentSymptoms',array('allergyIncidentId'),array('profileId'=>$id));
    
       if(!empty($inci_exist_ids)){
        foreach($inci_exist_ids as $row){
          $inci_exist_id[] = $row['allergyIncidentId'];
        }
         $delete_ids = array_diff($inci_exist_id,$incident_ids);
         $this->profile_model->delete_ids('AllergyIncidentSymptoms','allergyIncidentId',$delete_ids);
       }
       //bulk array entry in db
       $res = '';
       if(!empty($incident_allergy))
          $res = $this->common_model->insert_batch_rec('AllergyIncidentSymptoms',$incident_allergy);
       
       if($res){
        $this->session->set_flashdata('success','Allergy Information saved successfully.');
       }else{
        $this->session->set_flashdata('success','Allergy Information saved successfully.');
       }
      redirect('user/profile/'.$id);
      }
      redirect('user/profile/'.$id);
    // $data['allergy_name'] = $this->common_model->select_from('AllergyName');
    // $data['allergy_type'] = $this->common_model->select_from('AllergyType');
    // $data['symptoms_severe'] = $this->common_model->select_from('SymtomsSevere');
    // $data['symptoms_mild'] = $this->common_model->select_from('SymtomsMild');
    // $data['allergies'] = $this->allergy_model->getAllergyById($proid);
    // $data['incidents'] = $this->allergy_model->getIncidentById($proid);
    // $data['profile_id'] = $proid;
    //  $data = $data + $this->data;
    // $this->load->view($data['template'],$data);
   }
   
   function editProfile()
   {
     if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
   	if($this->input->post('profile_save'))
		{			
			 var_dump($_FILES);
			 var_dump($_POST); exit;
			 
			 //profile picture upload
			 if($_FILES['prof_pic']){
			    $config = array();
			    $config['upload_path'] = './uploads/profileImages/';
			    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
			    $config['max_size'] = '100000';
			    //$config['max_width'] = '1024';
			    //$config['max_height'] = '768';
			    $this->load->library('upload', $config, 'profile'); // Create custom object for cover upload
			    $this->profile->initialize($config);
			    $upload_profile = $this->profile->do_upload('prof_pic');
			    if(!$profile = $this->profile->data())
			    {
				   $this->session->set_flashdata('failure','Profile picture upload failed.');
			    }
                            if($upload_profile)
			    {
                                if($_POST['old_profile_pic']!='')
			    	{
			    	if(file_exists("./uploads/profileImages/".$_POST['old_profile_pic']))
					{
						unlink("./uploads/profileImages/".$_POST['old_profile_pic']);
					}
                                }
			    }
	       }   //var_dump($profile); exit;
		    		
		    //school image upload
		    if($_FILES['logo']['error']==0){
			    $config = array();
			    $config['upload_path'] = './uploads/school/';
			    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
			    $config['max_size'] = '1000000';
			    $this->load->library('upload', $config, 'logos');  // Create custom object for catalog upload
			    $this->logos->initialize($config);
			    $upload_logo = $this->logos->do_upload('logo');		    
			    if(!$logo = $this->logos->data())
			    {
			        $this->session->set_flashdata('failure','School logo upload failed.');
			    }
                            if($upload_logo)
			    {
                                if($_POST['old_school_logo']!='')
			    	{
			    	if(file_exists("./uploads/school/".$_POST['old_school_logo']))
					{
						unlink("./uploads/school/".$_POST['old_school_logo']);
					}
                                }
			    }
	       }
	       //for same address
	       $where = array(
	                  'accountId' => $this->session->userdata('account_id')
	                );
          $address = $this->common_model->select_from('AddressTable','',$where);	 
              
		    if(!empty($address)){   
		       $same_on = array(
		                 'profileAddressFirstLine' => $address[0]['addressFirst'],
		                 'profileAddressSecondLine' => $address[0]['addressSecond'],
		                 'profileAddressCity' => $address[0]['city'],
		                 'profileAddressStateId' => $address[0]['state'],
		                 'profileAddressZip' => $address[0]['zip'],
		                 'profileAddressCountryId' => $address[0]['country'],
		             );
		        }else{
		        	$same_on = array();
		        }
		
	       $same_off = array(
	                 'profileAddressFirstLine' => $_POST['profileaddressfirstline'],
	                 'profileAddressSecondLine' => $_POST['profileaddresssecondline'],
	                 'profileAddressCity' => $_POST['profileaddresscity'],
	                 'profileAddressStateId' => $_POST['profileaddressstate'],
	                 'profileAddressZip' => $_POST['profileaddresszip'],
	                 'profileAddressCountryId' => $_POST['profileaddresscountry'],
	               );
			
			 $common = array(
			           'accountId' => $this->session->userdata('account_id'),
			           'profileFirstName' => $this->input->post('pfname'),
			           'profileMiddleName' => $this->input->post('pmname'),
			           'profileLastName' => $this->input->post('plname'),
			           'profileDateOfBirth' => $this->input->post('pbyear').'-'.$this->input->post('pbmonth').'-'.$this->input->post('pbday'),
			           'profileGenderId' => $this->input->post('pgender'),
			           'profileMobilePhone' => $this->input->post('pphone'),
			           'profileMobileEx' => $this->input->post('pphone_ex'),
			           'profileEmail' => $this->input->post('pemail'),
			           'profileAddressSame' => ($this->input->post('sameaddr'))?'1':'0',				           
			           'profilePicture' => ($profile['file_name'])?$profile['file_name']:$this->input->post('old_profile_pic'),			           
			           'profileSchoolName' => $this->input->post('schoolname'),            
			           'profileSchoolLogo' => (isset($logo['file_name']))?$logo['file_name']:$this->input->post('old_school_logo'),				           
			           'profileSchoolGrade' => $this->input->post('grade'),				           			           
			          );
				//var_dump($common); exit;
		    //merge for same address
		    if($this->input->post('sameaddr') == 'on')
		    {
		    	$common = array_merge($common,$same_on);
		    }else{
		    	$common = array_merge($common,$same_off);
		    }		   
	//var_dump($common); exit;
			 if($this->input->post('profile_id'))
			 {
			 	$where = array('profileId' => $this->input->post('profile_id'));
			 	$result = $this->common_model->update_data('Profile',$common,$where);
			 	$profile_id = $this->input->post('profile_id');
			 }
		    else
		    {
		    	$profile_id = $result = $this->common_model->insert_db('Profile',$common);		    	
		    }
		         
			//for emergency contact update
			if(!empty($_POST['efirstname']))
			{
				
				 $i = 0;
				 foreach($_POST['efirstname'] as $emer)
				 {
				 	if($_POST['eid'][$i] == '') {
				 		$emergency[] = array(
				 		                'emergencyContactFirstName' => $_POST['efirstname'][$i],
				 		                'emergencyContactMiddleName' => $_POST['emiddlename'][$i],
				 		                'emergencyContactLastName' => $_POST['elastname'][$i],
				 		                'emergencyPhoneType' => $_POST['ephonetype'][$i],
				 		                'emergencyContactRelationship' => $_POST['erelation'][$i],
				 		                'profileId' => $profile_id,
				 		                'emergencyPhoneExtn' => $_POST['emobile_ex'][$i],
				 		                'emergencyContactNumber' => $_POST['emobile'][$i],
				 		                
				 		             ); 
				 		     //$this->common_model->insert_db('emergency',$emergency);
				 	}else{
				 		$emergency_ids[]=$_POST['eid'][$i];
				 	}
				   $i++; 
				 }
		    
			 //ids which exist in db
			 $exist_ids = $this->common_model->select_from('EmergencyContacts',array('emergencyContactId'),array('profileId'=>$profile_id));
		
			 if(!empty($exist_ids) && !empty($emergency_ids)){
			 	foreach($exist_ids as $row){
			 		$exist_id[] = $row['emergencyContactId'];
			 	}
			   $delete_ids = array_diff($exist_id,$emergency_ids);
			   $this->profile_model->delete_ids('EmergencyContacts','emergencyContactId',$delete_ids);
			 }
		   			   
			 if(!empty($emergency))
			    $this->common_model->insert_batch_rec('EmergencyContacts',$emergency);
			 //emergency closed here
			} 
			  
		  if(!empty($_POST['dfirstname']))
			{	
			    //for doctor update
				 $i = 0;
				 foreach($_POST['dfirstname'] as $doc)
				 {
				 	if($_POST['did'][$i] == '') {
				 		$doctor[] = array(
				 		                'doctorFirstName' => $_POST['dfirstname'][$i],
				 		                'doctorMiddleName' => $_POST['dmiddlename'][$i],
				 		                'doctorLastName' => $_POST['dlastname'][$i],
				 		                'doctorPhoneType' => $_POST['dphonetype'][$i],
				 		                'doctorPhoneNumber' => $_POST['dmobile'][$i],
				 		                'doctorPhoneExtn' => $_POST['dphone_ex'][$i],
				 		                'doctorAddressType' => $_POST['daddr_type'][$i],
				 		                'doctorAddressFirstline' => $_POST['daddrline1'][$i],
				 		                'doctorAddressSecondline' => $_POST['daddrline2'][$i],
				 		                'doctorCity' => $_POST['dcity'][$i],
				 		                'doctorState' => $_POST['dstate'][$i],
				 		                'doctorCountry' => $_POST['dcountry'][$i],
				 		                'doctorZip' => $_POST['dzip'][$i],
				 		                'profileId' => $profile_id
				 		             ); 
				 		//$this->common_model->insert_db('DoctorDetails',$doctor);
				 	}else{
				 		$doctor_ids[]=$_POST['did'][$i];
				 	}
				   $i++; 
				 }
			 //ids which exist in db
			 $doc_exist_ids = $this->common_model->select_from('DoctorDetails',array('doctorDetailsId'),array('profileId'=>$profile_id));
		
			 if(!empty($doc_exist_ids) && !empty($doctor_ids)){
			 	foreach($doc_exist_ids as $row){
			 		$doc_exist_id[] = $row['doctorDetailsId'];
			 	}
			   $delete_ids = array_diff($doc_exist_id,$doctor_ids);
			   $this->profile_model->delete_ids('DoctorDetails','doctorDetailsId',$delete_ids);
			 }
		  
			 if(!empty($doctor))
			    $res = $this->common_model->insert_batch_rec('DoctorDetails',$doctor);
			    
			 //doctor closed here
		}
	
	   if(!empty($_POST['providername']))
			{
				
			    //for insurance update
				 $i = 0;
				 foreach($_POST['providername'] as $ins)
				 {
				 	if($_POST['insuranceid'][$i] == '') {
				 		
				 		//insurance scanned image upload front
				 		$j = 0;
						 if($_FILES['logofile1']['name']){
							 $config = array();
							  $_FILES['userfile']['name']= $_FILES['logofile1']['name'][$j];
					        $_FILES['userfile']['type']= $_FILES['logofile1']['type'][$j];
					        $_FILES['userfile']['tmp_name']= $_FILES['logofile1']['tmp_name'][$j];
					        $_FILES['userfile']['error']= $_FILES['logofile1']['error'][$j];
					        $_FILES['userfile']['size']= $_FILES['logofile1']['size'][$j]; 
				
						    $config['upload_path'] = './uploads/insurance/front/';
						    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
						    $config['max_size'] = '100000';
						    $this->load->library('upload', $config, 'scanfront'); // Create custom object for cover upload
						    $this->scanfront->initialize($config);
						    $upload_profile = $this->scanfront->do_upload('userfile');
						    if(!$scan_front = $this->scanfront->data())
						    {
							   $this->session->set_flashdata('failure','Uploading scan front page failed.');
						    }
						   //var_dump($scan_front);  
				       }
					    		
					    if($_FILES['logofile2']['name'][$j]){
							 $config = array();
							  $_FILES['userfile']['name']= $_FILES['logofile2']['name'][$j];
					        $_FILES['userfile']['type']= $_FILES['logofile2']['type'][$j];
					        $_FILES['userfile']['tmp_name']= $_FILES['logofile2']['tmp_name'][$j];
					        $_FILES['userfile']['error']= $_FILES['logofile2']['error'][$j];
					        $_FILES['userfile']['size']= $_FILES['logofile2']['size'][$j]; 
				
						    $config['upload_path'] = './uploads/insurance/back/';
						    $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
						    $config['max_size'] = '100000';
						    $this->load->library('upload', $config, 'scanback'); // Create custom object for cover upload
						    $this->scanback->initialize($config);
						    $upload_profile = $this->scanback->do_upload('userfile');
						    if(!$scan_back = $this->scanback->data())
						    {
							   $this->session->set_flashdata('failure','Uploading scan back page failed.');
						    }
						   //var_dump($scan_back); exit;
				       }  
				 
				 		$insurance[] = array(
				 		                'providerName' => $_POST['providername'][$i],
				 		                'planId' => $_POST['planid'][$i],
				 		                'groupId' => $_POST['groupid'][$i],
				 		                'payerId' => $_POST['payerid'][$i],
				 		                'expMonth' => $_POST['emonth'][$i],
				 		                'expYear' => $_POST['eyear'][$i],
				 		                'expDay' => $_POST['edate'][$i],
				 		                'scanCopyFront' => ($scan_front['file_name'])?$scan_front['file_name']:$_POST['front'][$i],
				 		                'scanCopyBack' => ($scan_back['file_name'])?$scan_back['file_name']:$_POST['back'][$i],
				 		                'profileId' => $profile_id,
				 		             ); 
				 		  //$this->common_model->insert_db('Insurance',$insurance);
				 	}else{
				 		$insurance_ids[]=$_POST['insuranceid'][$i];
				 	}
				   $i++; 
				 }
			 //ids which exist in db
			 $ins_exist_ids = $this->common_model->select_from('Insurance',array('insuranceId'),array('profileId'=>$profile_id));
		
			 if(!empty($ins_exist_ids) && !empty($insurance_ids)){
			 	foreach($ins_exist_ids as $row){
			 		$ins_exist_id[] = $row['insuranceId'];
			 	}
			   $delete_ids = array_diff($ins_exist_id,$insurance_ids);
			   $del_suc = $this->profile_model->delete_ids('Insurance','insuranceId',$delete_ids);
                           if($del_suc){
			   	foreach($delete_ids as $did){
			   		if(file_exists("./uploads/insurance/front/".$scanCopyFront[$did]))
						{
							unlink("./uploads/insurance/front/".$scanCopyFront[$did]);
						}
					   if(file_exists("./uploads/insurance/back/".$scanCopyBack[$did]))
						{
							unlink("./uploads/insurance/back/".$scanCopyBack[$did]);
						}
			   	}
			   }
			 }
		   			   
			 if(!empty($insurance))
			    $this->common_model->insert_batch_rec('Insurance',$insurance);
			 //insurance closed here
			
			}else{
				$copies = $this->common_model->select_from('Insurance',array('*'),array('profileId'=>$profile_id));
				if(!empty($copies)){
				foreach($copies as $cpy){
			   		if(file_exists("./uploads/insurance/front/".$cpy['scanCopyFront']))
						{
							unlink("./uploads/insurance/front/".$cpy['scanCopyFront']);
						}
					   if(file_exists("./uploads/insurance/back/".$cpy['scanCopyBack']))
						{
							unlink("./uploads/insurance/back/".$cpy['scanCopyBack']);
						}
			   }}
				$this->common_model->delete_from('Insurance',array('profileId'=>$profile_id));
			}
		//echo $profile_id; exit;
		   //information sharing
		   $infomation_sharing[] = array(
		                           'profileId' => $profile_id,
		                           'userTypeId' => '1', 
		                           'personalInfo' => (isset($_POST['ems_personal']))?'1':'0', 
		                           'emergencyContactInfo' => (isset($_POST['ems_emergency']))?'1':'0', 
		                           'schoolInfo' => (isset($_POST['ems_school']))?'1':'0',  
		                           'insuranceInfo' => (isset($_POST['ems_ins']))?'1':'0',  
		                         );
		   $infomation_sharing[] = array(
		                           'profileId' => $profile_id, 
		                           'userTypeId' => '2', 
		                           'personalInfo' => (isset($_POST['doc_personal']))?'1':'0',  
		                           'emergencyContactInfo' => (isset($_POST['doc_emergency']))?'1':'0',   
		                           'schoolInfo' => (isset($_POST['doc_school']))?'1':'0', 
		                           'insuranceInfo' => (isset($_POST['doc_ins']))?'1':'0',   
		                         );
		   $infomation_sharing[] = array(
		                           'profileId' => $profile_id, 
		                           'userTypeId' => '3', 
		                           'personalInfo' => (isset($_POST['school_personal']))?'1':'0',  
		                           'emergencyContactInfo' => (isset($_POST['school_emergency']))?'1':'0',  
		                           'schoolInfo' => (isset($_POST['school_school']))?'1':'0',  
		                           'insuranceInfo' => (isset($_POST['school_ins']))?'1':'0',   
		                         );
		   $infomation_sharing[] = array(
		                           'profileId' => $profile_id, 
		                           'userTypeId' => '4', 
		                           'personalInfo' => (isset($_POST['other_personal']))?'1':'0',  
		                           'emergencyContactInfo' => (isset($_POST['other_emergency']))?'1':'0',  
		                           'schoolInfo' => (isset($_POST['other_school']))?'1':'0',  
		                           'insuranceInfo' => (isset($_POST['other_ins']))?'1':'0',   
		                         );   
		   //var_dump($infomation_sharing); exit;        
		   if(!empty($infomation_sharing))
		   {
		   	//echo 'fool'; exit;
		     if($_POST['personalId'] != '')
		     {
		     	 $where1 = array('infoSharingId'=>$this->input->post('personalId'));
		     	 $this->common_model->update_data('InformationSharing',$infomation_sharing[0],$where1);
		     	 $where2 = array('infoSharingId'=>$this->input->post('emergencyId'));
		     	 $this->common_model->update_data('InformationSharing',$infomation_sharing[1],$where2);
		     	 $where3 = array('infoSharingId'=>$this->input->post('schoolId'));
		     	 $this->common_model->update_data('InformationSharing',$infomation_sharing[2],$where3);
		     	 $where4 = array('infoSharingId'=>$this->input->post('insuranceId'));
		     	 $this->common_model->update_data('InformationSharing',$infomation_sharing[3],$where4);
		     }
		     else
		     {
		     	 $this->common_model->insert_batch_rec('InformationSharing',$infomation_sharing);
		     }
		   }
		   /*var_dump($infomation_ems);                                 
		   var_dump($infomation_doc);                                 
		   var_dump($infomation_school);                                 
		   var_dump($infomation_other);  exit;    */                           
		    $this->session->set_flashdata('success','Profile updated successfully.');
			 redirect('user/profile/'.$profile_id);
		 }
   }

   function new_profile()
   {
   	if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '1')
		redirect('admin');
		
   	$data = array('title' => 'Account Information', 'page' => 'client/newProfile', 'errorCls' => NULL,'page_params' => NULL);
   	$data = $data + $this->data;
   	$data['state'] = $this->common_model->select_from('State');
   	$data['country'] = $this->common_model->select_from('Country');
	   $data['phone_type'] = $this->common_model->select_from('PhoneType');
	   $data['addr_type'] = $this->common_model->select_from('AddressType');
	   $data['summary'] = $this->user_model->get_summary_page($data['account_id']); //summary tab information   
      $this->load->view($data['template'],$data);	
   }
}
