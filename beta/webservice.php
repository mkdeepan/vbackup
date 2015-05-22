<?php
require 'Slim/Slim.php';
require 'db.php';
require 'mail.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

function is_json($string) {
     $data = json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE);
}

$app->post('/hello', function () {
	global $app;
        $request = $app->request();
        $body = $request->getBody();
        $input = json_decode($body); 	
        var_dump($input); exit;
       
});

$app->notFound(function () {
   $errorCodes = array('statusCode'=>'404','errorMessage'=>'Not Found');
   echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->get('/', function () {
	$errorCodes = array('statusCode'=>'404','errorMessage'=>'Not Found');
   echo '{"Result":'. json_encode($errorCodes).'}';
});

//tips
$app->get('/tips', function () {
    $sql = "SELECT * FROM Tips";
    try {
        $dbCon = getConnection();
        $stmt = $dbCon->prepare($sql);
        $stmt->execute();
        $tips = $stmt -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        $errorCodes = array(
                         'statusCode'=>'99',
                         'errorMessage'=>'',
                         'tips' => $tips                         
                      );
        echo '{"Result": ' . json_encode($errorCodes) . '}';
    } catch(PDOException $e) {
        $errorCodes = array('statusCode'=>'1011','errorMessage'=>'Error connecting to the database.');
        echo '{"Result":'. json_encode($errorCodes).'}';
    }
});

$app->post('/validateUser',function() {

    global $app;
	
	 $request = $app->request();
    $body = $request->getBody();
    $error = 0;
	 $errorCodes = array();
    if(is_json($body)){
    $input = json_decode($body); 	 
		if(!empty($input)){
              
          if(!isset($input->id) || !isset($input->password) || !isset($input->deviceType) || !isset($input->phoneType) || !isset($input->osVersion) || !isset($input->modelNumber) || !isset($input->latitude) || !isset($input->longitude))
		  	 {
		  	 	$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	   goto res;
		  	 }

			 $logDetails = array(
			                     'id'=>$input->id, 
										'pwd'=>$input->password, 
										'device'=>$input->deviceType, 
									   'phone'=>$input->phoneType, 
									   'os'=>$input->osVersion, 
									   'model'=>$input->modelNumber, 
									   'lat'=>$input->latitude, 
									   'long'=>$input->longitude
									  );
		
			 foreach($logDetails as $log){
			 	if($log == ''){
			 		$error = 1;
			 	}
			 }
		
		    if(!$error){
		       
		       if(!filter_var($logDetails['id'], FILTER_VALIDATE_EMAIL)) {
		            $errorCodes = array('statusCode'=>'1002','errorMessage'=>'Invalid email address format.');
		  	         goto res;
		       }	
		       
		       /*if(!filter_var($logDetails['lat'], FILTER_VALIDATE_FLOAT) || !filter_var($logDetails['long'], FILTER_VALIDATE_FLOAT) || !($logDetails['lat'] >= -90 && $logDetails['lat'] <= 90) || !($logDetails['long'] >= -180 && $logDetails['long'] <= 180)){
		       	   $errorCodes = array('statusCode'=>'108','errorMessage'=>'Latitude, Longitude error');		       	   
		  	         goto res;
		       }*/
				    	
			    $sql = "SELECT * FROM Account where accountEmail=:id and loginPassword=:password";
			    try {
			        $dbCon = getConnection();
			        $stmt = $dbCon->prepare($sql);
			        $stmt->bindParam("id", $logDetails['id']);
			        $stmt->bindParam("password", base64_encode($logDetails['pwd']));
			        $res = $stmt->execute();
			        $user = $stmt->rowCount(); 			        
			        if($user){
				        $vals = $stmt->fetchAll(PDO::FETCH_OBJ);	
				        if($vals[0]->status){			        
					        $accountId = $vals[0]->accountId;
					        $device = $logDetails['device'];
					        $phone = $logDetails['phone'];
					        $os = $logDetails['os'];
					        $model = $logDetails['model'];
					        $lat = $logDetails['lat'];
					        $long = $logDetails['long'];			                
					        $time = date('Y-m-d H:i:s'); 
					        $login_log_insert = "insert into LoginLog (`accountId`, `deviceType`, `phoneType`, `osVersion`, `modelNumber`, `latitude`, `longitude`, `timeIn`) 
					                   VALUES ('$accountId','$device','$phone','$os','$model','$lat','$long','$time')";
					       
					        $logs = $dbCon->prepare($login_log_insert);
					        $logs->execute();
					        $dbCon = null;
					        $errorCodes = array(
					                   'statusCode'=>'99',
					                   'errorMessage'=>'',
					                   'accountId'=>$vals[0]->accountId,
					                   'accountPicture'=> base_url().'uploads/accountImages/'.$vals[0]->accountPicture,
					                );
					        goto res;
					     }else{
					     	  $errorCodes = array('statusCode'=>'1018','errorMessage'=>'Please activate your account.');
  	                    goto res;
					     }
			        }else{
			            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	                  goto res;
			        }
			    }catch(PDOException $e) {
			        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	              goto res;
			    }
		    }else{
		    	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields.');
  	         goto res;
		    }	    
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/accountInformation',function() {

   global $app;
	
	$request = $app->request();
   $body = $request->getBody();
   $error = 0;
	$errorCodes = array();
   if(is_json($body)){
	   $input = json_decode($body); 
		if(!empty($input)){
			
			if(!isset($input->id) || !isset($input->password))
		  	{
		  	 	$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	   goto res;
		  	}
		   if($input->id == '')
		  	{
		  	 	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields.');
		  	   goto res;
		  	}
		   if(!filter_var($input->id, FILTER_VALIDATE_EMAIL)) {
            $errorCodes = array('statusCode'=>'1002','errorMessage'=>'Invalid email address format.');
  	         goto res;
		   }	
		  
			$id = $input->id; 
			$pwd = base64_encode($input->password); 
		
		   $account = "SELECT accountId, accountFirstName, accountMiddleName, accountLastName,accountEmail,loginPassword, accountMobilePhone,amn_ex as countryExtn, A.description AS gender, accountPicture, P . *
								FROM Account
								JOIN Gender A ON A.genderId = Account.accountGender
								LEFT JOIN PaymentInformation P ON P.paymentInfoId = Account.accountPaymentId 
							where Account.accountEmail='".$id."' and Account.loginPassword='".$pwd."'";
						
			$email = "SELECT E . * , ET.emailTypeName
							FROM EmailTable E
							JOIN Account A ON A.accountId = E.accountId
							JOIN EmailType ET ON E.emailTypeId = ET.id 
			          where A.accountEmail='".$id."' and A.loginPassword='".$pwd."'";	
			          
			$phone = "SELECT PNT . * , PT.phoneTypeName
							FROM PhoneNumberTable PNT
							JOIN PhoneType PT ON PT.id = PNT.phoneTypeId
							JOIN Account A ON A.accountId = PNT.accountId
						 where A.accountEmail='".$id."' and A.loginPassword='".$pwd."'"; 
								
		   $address = "SELECT AT . * , ATY.addressTypeName
								FROM AddressTable AT
								JOIN AddressType ATY ON ATY.id = AT.addressTypeId
								JOIN Account A ON A.accountId = AT.accountId
							where A.accountEmail='".$id."' and A.loginPassword='".$pwd."'"; 
		    
		    try {
		        $dbCon = getConnection();
		        $acc = $dbCon->prepare($account);
		        $acc->execute();
		        $exist = $acc->rowCount(); 		
		        if($exist){
			        $account_info = $acc -> fetchAll(PDO::FETCH_OBJ);
			        
			        if($account_info[0]->accountPicture)
			           $account_info[0]->accountPicture = base_url() .'uploads/accountImages/'.$account_info[0]->accountPicture;      
			        
			        $em = $dbCon->prepare($email);
			        $em->execute();
			        $email_info = $em->fetchAll(PDO::FETCH_OBJ);
			        
			        $ph = $dbCon->prepare($phone);
			        $ph->execute();
			        $phone_info = $ph->fetchAll(PDO::FETCH_OBJ);
			        
			        $addr = $dbCon->prepare($address);
			        $addr->execute();
			        $address_info = $addr->fetchAll(PDO::FETCH_OBJ);			        
			   
			        $account_info[0]->emails = $email_info;
			        $account_info[0]->phones = $phone_info;
			        $account_info[0]->addresses = $address_info;
			        
			        $dbCon = null;
			        $errorCodes = array(
					                   'statusCode'=>'99',
					                   'errorMessage'=>'',
					                   'accountInformation'=>$account_info
					                );
					  goto res;
			        //echo '{"AccountInformation": ' . json_encode($merged) . '}';
		        }else{
		            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	               goto res;
			     }		    
		    } catch(PDOException $e) {
		        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	           goto res;
		    }
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
	}else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/getTags',function() {
    global $app;
        $request = $app->request();
        $body = $request->getBody();
        $error = 0;
			$errorCodes = array();
		   if(is_json($body)){
			   $input = json_decode($body); 
				if(!empty($input)){
				     $tagsInformation = array();
				     $acc_id = $input->id; 
				        //for profiles
				        $sql_p = "select profileId, profileFirstName, profileLastName from Profile 
				                  join Account on Account.accountId=Profile.accountId where Account.accountId = '".$acc_id."'";
				            	
			
			        try {
			        $dbCon = getConnection();
			        $profile = $dbCon->prepare($sql_p);
			        $profile->execute();
			        $profiles = $profile -> fetchAll(PDO::FETCH_OBJ);
			        foreach($profiles as $pro)
			        {
			                //for allergies
			        	$sql_a = "select distinct AN.allergyNameId, AN.allergyNameDescription
			        	         from ProfileTagMapping PTM 
			        	         join Allergy A on A.profileId = PTM.profileId
			        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
						 where PTM.profileId = '".$pro->profileId."'";	
				        
				$allergy = $dbCon->prepare($sql_a);
			        $allergy->execute();
			        $allergies = $allergy -> fetchAll(PDO::FETCH_OBJ);
			                //for tags
				        $sql_t = "select TI.tagId, TT.tagTypeDescription, sum(TI.tagCount) as tagCounts from TagInfo TI 
				                  join TagList TL on TL.tagListId=TI.tagId 
				                  join TagType TT on TT.tagTypeId=TL.tagListId
				                  where profileId = '".$pro->profileId."' group by TI.tagId ";
				                  
			        $tag = $dbCon->prepare($sql_t);
			        $tag->execute();
			        $tags = $tag -> fetchAll(PDO::FETCH_OBJ);
			        
			        $tagsInformation[] = array(
			                'profileId'=>$pro->profileId,
			                'profileFirstName'=>$pro->profileFirstName,
			                'profileLastName'=>$pro->profileLastName,
			                'allergy'=>$allergies,
			                'tags'=>$tags
			                );
			         }
			         $dbCon = null;
			        //$tagsInformation = array_merge((array)$profiles,(array)$tags_aller);
			        //echo '{"tagInfo": ' . json_encode($tagsInformation) . '}';
			        $errorCodes = array(
					                   'statusCode'=>'99',
					                   'errorMessage'=>'',
					                   'tagInfo'=>$tagsInformation
					                );
					  goto res;
			    } catch(PDOException $e) {
			        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>$e->getMessage());
  	              goto res;
			    }
			}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
	}else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/accountInformationById',function() {

   global $app;
	
	$request = $app->request();
   $body = $request->getBody();
   $error = 0;
	$errorCodes = array();
   if(is_json($body)){
	   $input = json_decode($body); 
		if(!empty($input)){
			$id = $input->id; 
			
		   $account = "SELECT accountId, accountFirstName, accountMiddleName, accountLastName, A.description AS gender, accountPicture, P . *
								FROM Account
								JOIN Gender A ON A.genderId = Account.accountGender
								LEFT JOIN PaymentInformation P ON P.paymentInfoId = Account.accountPaymentId 
							where Account.accountId='".$id."' ";
						
			$email = "SELECT E . * , ET.emailTypeName
							FROM EmailTable E
							JOIN Account A ON A.accountId = E.accountId
							JOIN EmailType ET ON E.emailTypeId = ET.id 
			          where A.accountId='".$id."' ";	
			          
			$phone = "SELECT PNT . * , PT.phoneTypeName
							FROM PhoneNumberTable PNT
							JOIN PhoneType PT ON PT.id = PNT.phoneTypeId
							JOIN Account A ON A.accountId = PNT.accountId
						 where A.accountId='".$id."'"; 
								
		   $address = "SELECT AT . * , ATY.addressTypeName
								FROM AddressTable AT
								JOIN AddressType ATY ON ATY.id = AT.addressTypeId
								JOIN Account A ON A.accountId = AT.accountId
							where A.accountId='".$id."' "; 
		    
		    try {
		        $dbCon = getConnection();
		        $acc = $dbCon->prepare($account);
		        $acc->execute();
		        $exist = $acc->rowCount(); 		
		        if($exist){
			        $account_info = $acc -> fetchAll(PDO::FETCH_OBJ);
			        
			        if($account_info[0]->accountPicture)
			          $account_info[0]->accountPicture = base_url() .'uploads/accountImages/'.$account_info[0]->accountPicture;
			                
			        $em = $dbCon->prepare($email);
			        $em->execute();
			        $email_info = $em->fetchAll(PDO::FETCH_OBJ);
			        
			        $ph = $dbCon->prepare($phone);
			        $ph->execute();
			        $phone_info = $ph->fetchAll(PDO::FETCH_OBJ);
			        
			        $addr = $dbCon->prepare($address);
			        $addr->execute();
			        $address_info = $addr->fetchAll(PDO::FETCH_OBJ);			        
			        
			        $account_info[0]->emails = $email_info;
			        $account_info[0]->phones = $phone_info;
			        $account_info[0]->addresses = $address_info;
			        
			        $dbCon = null;
			        $errorCodes = array(
					                   'statusCode'=>'99',
					                   'errorMessage'=>'',
					                   'accountInformation'=>$account_info
					                );
					  goto res;
			       
			     }else{
		            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	               goto res;
			     }		    
		     } catch(PDOException $e) {
		        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	           goto res;
		    }
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
	}else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/getProfiles',function() {
    global $app;
    $request = $app->request();
    $body = $request->getBody();
    $error = 0;
	 $errorCodes = array();
    if(is_json($body)){
	    $input = json_decode($body); 
		 if(!empty($input)){
		 	 if(!isset($input->ids) || !isset($input->lat) || !isset($input->long) || !isset($input->accountId))
		 	 {
		 		$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	   goto res;
		 	 }
		 
			 $users = $input->ids; 
		    $lat = $input->lat;
			 $long = $input->long;
			 $accountId = $input->accountId;
		   
		        if(!empty($users)){
		           $sql = "SELECT P.profileId as profileid,CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds, P.*,G.description as gender,PT.*,S.stateName,C.countryName,D.*,E.*,I.* FROM Profile P 
		                  left join DoctorDetails D on D.doctorDetailsId = P.profileDoctorDetailsId 
								left join EmergencyContacts E on E.emergencyContactId = P.profileEmergencyContactId 
								left join Insurance I on I.insuranceId = P.profileInsuranceId 
								left join ProfileTagMapping PT on PT.profileId = P.profileId 
								left join Gender G on G.genderId = P.profileGenderId		
		                                                left join State S on S.stateId = P.profileAddressStateId
		                                                left join Country C on C.countryId = P.profileAddressCountryId
								WHERE PT.tagId IN ('".implode("','",$users)."')";
		        }else{
		           $sql = "SELECT P.profileId as profileid, CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds, P.*,G.description as gender,PT.*,S.stateName,C.countryName,D.*,E.*,I.* FROM Profile P 
		                  left join DoctorDetails D on D.doctorDetailsId = P.profileDoctorDetailsId 
								left join EmergencyContacts E on E.emergencyContactId = P.profileEmergencyContactId 
								left join Insurance I on I.insuranceId = P.profileInsuranceId 
								left join ProfileTagMapping PT on PT.profileId = P.profileId
								left join Gender G on G.genderId = P.profileGenderId
								left join State S on S.stateId = P.profileAddressStateId
		                                                left join Country C on C.countryId = P.profileAddressCountryId";   
		        }
		
		    try {
		        $dbCon = getConnection();
		        //for inserting location log
			        $location_sql = "insert into LocationLog (accountId,latitude,longitude) values ('$accountId','$lat','$long')";
			        $location = $dbCon->prepare($location_sql);
			        $location->execute();
			        $locationLogId = $dbCon->lastInsertId();
			        
			        $val = '';
			        if(!empty($users)){
			        	$location_list = "insert into LocationLogList (locationLogId,tagId) values ";
			        	$userids = new ArrayIterator( $users );
			        	$cit = new CachingIterator( $userids );
				        foreach($cit as $tid){
				        		$val .= "('".$locationLogId."','".$tid."')"; 
				        		if($cit->hasNext())
				        		{
				        			$val .= ",";
				        		}       	
				        }
			        }
			        if($val){
			        	$location_list .= $val;
			        	$locationList = $dbCon->prepare($location_list);
			        	$locationList->execute();
			        }
			   //end of inserting location logs
			   
			   //for activity log
			   $activity_sql = "insert into ActivityLog(accountId,action,title) values ('$accountId','scan','scan')";
			   $activity = $dbCon->prepare($activity_sql);
			      $activity->execute();
			   //end of activity log
		        $stmt = $dbCon->prepare($sql);
		        $stmt->execute();
		        $user  = $stmt->fetchAll(PDO::FETCH_OBJ);
		        foreach($user as $usr){
		 
		        	$aller_arr = array();
		        	$usr_id = $usr->profileid;
		        	if($usr->profilePicture)
		        	  $usr->profilePicture = base_url().'uploads/profileImages/'.$usr->profilePicture;
		        	if($usr->profileSchoolLogo)
		        	  $usr->profileSchoolLogo = base_url().'uploads/school/'.$usr->profileSchoolLogo;
		        	
		        	  
		        	//for allergies
			      $sql_a = "select A.allergyId, AN.allergyNameDescription, AT.allergyTypeDescription
		        	         from Allergy A 
		        	         left join AllergyName AN on AN.allergyNameId = A.allergyNameId
		        	         left join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
								where A.profileId = '".$usr_id."'";
								
		
		         $aller = $dbCon->prepare($sql_a);
		         $aller->execute();
		         $allergies = $aller -> fetchAll(PDO::FETCH_OBJ);
		         foreach($allergies as $key => $algy) {
		         	
			        	$sql_b = "select A.allergyId,AN.allergyNameId, AN.allergyNameDescription,AT.allergyTypeId, AT.allergyTypeDescription
		        	         from Allergy A 
		        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
		        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
								where A.allergyId = '".$algy->allergyId."'";
					   $allergy_array = $dbCon->prepare($sql_b);
			        	$allergy_array->execute();
			        	
			        	$allers = $allergy_array->fetchAll(PDO::FETCH_ASSOC);
			        	$temp_array = array();
			        	if(!empty($allers)){
			        	   $temp_array = array(
			        	                'allergyId' => $allers[0]['allergyId'],
		                                        'allergyNameId' => $allers[0]['allergyNameId'],
			        	                'allergyNameDescription' => $allers[0]['allergyNameDescription'],
		                                        'allergyTypeId' => $allers[0]['allergyTypeId'],
			        	                'allergyTypeDescription' => $allers[0]['allergyTypeDescription']
			        	                );
			        	}
			        	
			        	$aller_arr[] = $temp_array;
						
			        	$sql_sym_mild = "select PSM.ProfileSymtomMildId, SM.symtomMildId, SM.symtomMildDescription from SymtomsMild SM join ProfileSymtomsMild PSM on 
			        	                 PSM.symtomMildId = SM.symtomMildId where PSM.allergyId = '".$algy->allergyId."'";
			        	                 //echo $sql_sym_mild; exit;
			        	$pro_mild = $dbCon->prepare($sql_sym_mild);
			        	$pro_mild->execute();
			        	$mild = $pro_mild->fetchAll(PDO::FETCH_ASSOC);
			        	
			        	$aller_arr[$key]["mild"] = $mild;
			        	
			        
			         $sql_sym_sev = "select PSS.profileSymtomSevereId, SS.symtomSevereId, SS.symtomSevereDescription from SymtomsSevere SS join ProfileSymtomsSevere PSS on 
			        	                 PSS.symtomSevereId = SS.symtomSevereId where PSS.allergyId = '".$algy->allergyId."'";
			        	$pro_sev = $dbCon->prepare($sql_sym_sev);
			        	$pro_sev->execute();
			        	$severe = $pro_sev->fetchAll(PDO::FETCH_ASSOC);
			        	 		
			        	$aller_arr[$key]["severe"] = $severe;	        	
       
		         }
		         
		         //for incident
		         $sql_i = "select AT.allergyTypeId,AT.allergyTypeDescription, AIS.allergyIncidentDesc, AIS.allergyIncidentDate
		        	         from ProfileTagMapping PTM 
		        	         join AllergyIncidentSymptoms AIS on AIS.profileId = PTM.profileId
		        	         join AllergyType AT on AT.allergyTypeId = AIS.allergyTypeId
								where PTM.profileId = '".$usr_id."'";
		
		
		         $incident = $dbCon->prepare($sql_i);
		         $incident->execute();
		         $incidents = $incident -> fetchAll(PDO::FETCH_OBJ);
		         
		         //for emergency contacts
		         $sql_con = "select E.*,P.phoneTypeName from EmergencyContacts E join PhoneType P on P.id = E.emergencyPhoneType
		                     where E.profileId = '".$usr_id."'";
		
		
		         $emergency = $dbCon->prepare($sql_con);
		         $emergency->execute();
		         $contacts = $emergency -> fetchAll(PDO::FETCH_OBJ);     
		         
		         //for doctor info
		         $sql_doc = "select D.*,P.phoneTypeName,A.addressTypeName,S.stateName,C.countryName from DoctorDetails D 
		                     left join PhoneType P on P.id = D.doctorPhoneType
		                     left join AddressType A on A.id = D.doctorAddressType
		                     left join State S on S.stateId = D.doctorState
		                     left join Country C on C.countryId = D.doctorCountry
		                     where D.profileId = '".$usr_id."'";
		
		
		         $doctor = $dbCon->prepare($sql_doc);
		         $doctor->execute();
		         $doc_info = $doctor -> fetchAll(PDO::FETCH_OBJ);       
		         
		         //for insurance
		         $sql_ins = "select * from Insurance
		                     where profileId = '".$usr_id."'";
		
		
		         $insure = $dbCon->prepare($sql_ins);
		         $insure->execute();
		         $insurance = $insure -> fetchAll(PDO::FETCH_OBJ);  
		         foreach($insurance as $ins)
		         {
		           if($ins->scanCopyFront)
		        	  $ins->scanCopyFront = base_url().'uploads/insurance/front/'.$ins->scanCopyFront;
		           if($ins->scanCopyBack)
		        	  $ins->scanCopyBack = base_url().'uploads/insurance/back/'.$ins->scanCopyBack;
		         }
		        // var_dump($insurance); exit;
		         $total_arr = array(
		                            'allergies'=>$aller_arr,
		                            'incidents'=>$incidents,
		                            'emergency' => $contacts,
		                            'doctor'=>$doc_info,
		                            'insurance' => $insurance
		                            );
		         $merged[] = array_merge((array)$usr,(array)$total_arr);
		        
		        }
		       
		        $dbCon = null;
		       
		        $errorCodes = array(
					                   'statusCode'=>'99',
					                   'errorMessage'=>'',
					                   'profiles'=>$merged
					                );
				  goto res;
				  
		    } catch(PDOException $e) {
		        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	           goto res;
		    }
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
    }else{
		  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
			 goto res;
    } 
	 res:
	 echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/getProfileDetails',function() {
   
   global $app;
   $request = $app->request();
   $body = $request->getBody();
   $error = 0;
	$errorCodes = array();
   if(is_json($body)){
	   $input = json_decode($body);
	     if(!empty($input)){
		   $tagid = $input->id; 
			$sql = "SELECT P.profileId as profileid, CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds, P.*,PT.*,D.*,E.*,I.* FROM Profile P left join DoctorDetails D on D.doctorDetailsId = P.profileDoctorDetailsId 
								left join EmergencyContacts E on E.emergencyContactId = P.profileEmergencyContactId 
								left join Insurance I on I.insuranceId = P.profileInsuranceId 
								left join ProfileTagMapping PT on PT.profileId = P.profileId 
								where PT.tagId = :tagid";
							//	echo $sql; exit;
								
		    try {
			        $dbCon = getConnection();
			        $stmt = $dbCon->prepare($sql);
			        $stmt->bindParam("tagid", $tagid);
			        $stmt->execute();
			        $exist = $stmt->rowCount();
			        if($exist){
				        $user = $stmt->fetchAll(PDO::FETCH_OBJ);    
				        $user_id = $user[0]->profileid; 
				       
				      if($user[0]->profilePicture)
			        	  $user[0]->profilePicture = base_url().'uploads/profileImages/'.$user[0]->profilePicture;
			        	if($user[0]->profileSchoolLogo)
			        	  $user[0]->profileSchoolLogo = base_url().'uploads/school/'.$user[0]->profileSchoolLogo;
			        	if($user[0]->scanCopyFront)
			        	  $user[0]->scanCopyFront = base_url().'uploads/insurance/front/'.$user[0]->scanCopyFront;
			         if($user[0]->scanCopyBack)
			        	  $user[0]->scanCopyBack = base_url().'uploads/insurance/back/'.$user[0]->scanCopyBack;
				     
				      //for allergies
				      $sql_a = "select A.allergyId, AN.allergyNameDescription, AT.allergyTypeDescription
			        	         from ProfileTagMapping PTM 
			        	         join Allergy A on A.profileId = PTM.profileId
			        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
			        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
									where PTM.profileId = '".$user_id."'";
									
			
			         $aller = $dbCon->prepare($sql_a);
			         $aller->execute();
			         $allergies = $aller -> fetchAll(PDO::FETCH_OBJ);
			         $mild = array();
			         $severe = array();
			         foreach($allergies as $key => $algy) {
			         	
				        	$sql_b = "select A.allergyId, AN.allergyNameDescription, AT.allergyTypeDescription
			        	         from ProfileTagMapping PTM 
			        	         join Allergy A on A.profileId = PTM.profileId
			        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
			        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
									where A.allergyId = '".$algy->allergyId."'";
						   $allergy_array = $dbCon->prepare($sql_b);
				        	$allergy_array->execute();
				        $allers = $allergy_array->fetchAll(PDO::FETCH_ASSOC);
				        	$temp_array = array(
				        	                'allergyId' => $allers[0]['allergyId'],
				        	                'allergyNameDescription' => $allers[0]['allergyNameDescription'],
				        	                'allergyTypeDescription' => $allers[0]['allergyTypeDescription']
				        	                );
				        	
				        	$aller_arr[] = $temp_array;
							
				        	$sql_sym_mild = "select PSM.ProfileSymtomMildId, SM.symtomMildId, SM.symtomMildDescription from SymtomsMild SM join ProfileSymtomsMild PSM on 
				        	                 PSM.symtomMildId = SM.symtomMildId where PSM.allergyId = '".$algy->allergyId."'";
				        	                 //echo $sql_sym_mild; exit;
				        	$pro_mild = $dbCon->prepare($sql_sym_mild);
				        	$pro_mild->execute();
				        	$mild = $pro_mild->fetchAll(PDO::FETCH_ASSOC);
				        	
				        	$aller_arr[$key]["mild"] = $mild;
				        
				        
				         $sql_sym_sev = "select PSS.profileSymtomSevereId, SS.symtomSevereId, SS.symtomSevereDescription from SymtomsSevere SS join ProfileSymtomsSevere PSS on 
				        	                 PSS.symtomSevereId = SS.symtomSevereId where PSS.allergyId = '".$algy->allergyId."'";
				        	$pro_sev = $dbCon->prepare($sql_sym_sev);
				        	$pro_sev->execute();
				        	$severe = $pro_sev->fetchAll(PDO::FETCH_ASSOC);
				       
				        	$aller_arr[$key]["severe"] = $severe;
				        
			        
			         }
			        
			         //for incident
			         $sql_i = "select AT.allergyTypeDescription, AIS.allergyIncidentDesc, AIS.allergyIncidentDate
			        	         from ProfileTagMapping PTM 
			        	         join AllergyIncidentSymptoms AIS on AIS.profileId = PTM.profileId
			        	         join AllergyType AT on AT.allergyTypeId = AIS.allergyTypeId
									where PTM.profileId = '".$user_id."'";
			
			
			         $incident = $dbCon->prepare($sql_i);
			         $incident->execute();
			         $incidents = $incident -> fetchAll(PDO::FETCH_OBJ);
			         
			         $user[0]->allergies = $aller_arr;
			         $user[0]->incidents = $incidents;
			         $dbCon = null;
				      $errorCodes = array(
						                   'statusCode'=>'99',
						                   'errorMessage'=>'',
						                   'profileDetail'=>$user
						                );
						goto res;
					  }else{
			            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	                  goto res;
			        }
			    } catch(PDOException $e) {
			      $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	            goto res;
			    }
			}else{
				$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
			  	goto res;
		   }
		}else{
		  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
			 goto res;
   } 
   res:
   echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->get('/allergyCounts',function() {
     $pro_sql = "select count(distinct profileId) as profilecount from Profile";
     $aller_sql = "select count(distinct profileId) as allergycount from Allergy";
           // echo $sql; exit;
    try {
        $dbCon = getConnection();
        $aller = $dbCon->prepare($aller_sql);
        $pro = $dbCon->prepare($pro_sql);
        $aller->execute();
        $pro->execute();
        $profile = $pro -> fetchAll(PDO::FETCH_OBJ);
        $allergy = $aller -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        
        $counts[] = array(
                    'profileCount' =>  $profile[0]->profilecount,
                    'allergyCount' =>  $allergy[0]->allergycount
                  );
        $errorCodes = array(
			                   'statusCode'=>'99',
			                   'errorMessage'=>'',
			                   'allergy'=>$counts
			                );
		  echo '{"Result":'. json_encode($errorCodes).'}';
        //echo '{"allergy": ' . json_encode($counts) . '}';
    } catch(PDOException $e) {
        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
        echo '{"Result":'. json_encode($errorCodes).'}';
    }
});

$app->get('/allergies',function() {
     $sql = "select i.allergyTypeId, AT.allergyTypeDescription, count(*) as count from 
			     (select profileId,allergyTypeId from Allergy group by profileId, allergyTypeId) as i 
			     join AllergyType AT on AT.allergyTypeId = i.allergyTypeId 
			     group by allergyTypeId";
			     
    try {
        $dbCon = getConnection();
        $items = $dbCon->prepare($sql);
        $items->execute();
        $handicap = $items -> fetchAll(PDO::FETCH_OBJ);
        $dbCon = null;
        $errorCodes = array(
			                   'statusCode'=>'99',
			                   'errorMessage'=>'',
			                   'allergies'=>$handicap
			                );
		  echo '{"Result":'. json_encode($errorCodes).'}';
        //echo '{"allergies": ' . json_encode($handicap) . '}';
    } catch(PDOException $e) {
        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
        echo '{"Result":'. json_encode($errorCodes).'}';
    }
});

$app->post('/getProfileHistory',function() {
    
    global $app;
    $request = $app->request();
    $body = $request->getBody();
    $error = 0;
	 $errorCodes = array();
    if(is_json($body)){
		 $input = json_decode($body);
		 if(!empty($input)){
		    $id = $input->id; 
		    
		    $sql1 = "select P.*,M.*,CONCAT('SJ',LPAD(P.profileId,3,'0')) as profileIds from Profile P 
		                  join ProfileTagMapping M on P.profileId = M.profileId where M.tagId = :id";
		    $sql2 = "select AT.allergyTypeDescription, AIS.allergyIncidentDesc, AIS.allergyIncidentDate
		        	         from ProfileTagMapping PTM 
		        	         join AllergyIncidentSymptoms AIS on AIS.profileId = PTM.profileId
		        	         join AllergyType AT on AT.allergyTypeId = AIS.allergyTypeId
								where PTM.tagId = :id order by AIS.allergyIncidentDate desc";
								
		    $sql3 = "select A.allergyId, AN.allergyNameDescription, AT.allergyTypeDescription
		        	         from ProfileTagMapping PTM 
		        	         join Allergy A on A.profileId = PTM.profileId
		        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
		        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
								where PTM.tagId = :id";
		
		
		    try {
		        $dbCon = getConnection();
		        $prof = $dbCon->prepare($sql1);
		        $prof->bindParam("id", $id);
		        $prof->execute();
			     $exist = $prof->rowCount();
			     if($exist) {  
			        $profile = $prof -> fetchObject();
			        
			         if($profile->profilePicture)
			        	  $profile->profilePicture = base_url().'uploads/profileImages/'.$profile->profilePicture;
			       	if($profile->profileSchoolLogo)
			        	  $profile->profileSchoolLogo = base_url().'uploads/school/'.$profile->profileSchoolLogo;
			        	if($profile->scanCopyFront)
			        	  $profile->scanCopyFront = base_url().'uploads/insurance/front/'.$profile->scanCopyFront;
			         if($profile->scanCopyBack)
			        	  $profile->scanCopyBack = base_url().'uploads/insurance/back/'.$profile->scanCopyBack;
			        	  
			        $his = $dbCon->prepare($sql2);
			        $his->bindParam("id", $id);
			        $his->execute();
			        $history = $his -> fetchAll(PDO::FETCH_OBJ);
			        
			        $dis = $dbCon->prepare($sql3);
			        $dis->bindParam("id", $id);
			        $dis->execute();
			        $allergies = $dis -> fetchAll(PDO::FETCH_OBJ);
			        foreach($allergies as $key => $algy) {
			         	
				        	$sql_b = "select A.allergyId, AN.allergyNameDescription, AT.allergyTypeDescription
			        	         from ProfileTagMapping PTM 
			        	         join Allergy A on A.profileId = PTM.profileId
			        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
			        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
									where A.allergyId = '".$algy->allergyId."'";
						   $allergy_array = $dbCon->prepare($sql_b);
				        	$allergy_array->execute();
				        	$allers = $allergy_array->fetchAll(PDO::FETCH_ASSOC);
				        	$temp_array = array(
				        	                'allergyId' => $allers[0]['allergyId'],
				        	                'allergyNameDescription' => $allers[0]['allergyNameDescription'],
				        	                'allergyTypeDescription' => $allers[0]['allergyTypeDescription']
				        	                );
				        	
				        	$aller_arr[] = $temp_array;
							
				        	$sql_sym_mild = "select PSM.ProfileSymtomMildId, SM.symtomMildId, SM.symtomMildDescription from SymtomsMild SM join ProfileSymtomsMild PSM on 
				        	                 PSM.symtomMildId = SM.symtomMildId where PSM.allergyId = '".$algy->allergyId."'";
				        	                 //echo $sql_sym_mild; exit;
				        	$pro_mild = $dbCon->prepare($sql_sym_mild);
				        	$pro_mild->execute();
				        	$mild = $pro_mild->fetchAll(PDO::FETCH_ASSOC);
				        
				        	$aller_arr[$key]["mild"] = $mild;
				        	
				        
				         $sql_sym_sev = "select PSS.profileSymtomSevereId, SS.symtomSevereId, SS.symtomSevereDescription from SymtomsSevere SS join ProfileSymtomsSevere PSS on 
				        	                 PSS.symtomSevereId = SS.symtomSevereId where PSS.allergyId = '".$algy->allergyId."'";
				        	$pro_sev = $dbCon->prepare($sql_sym_sev);
				        	$pro_sev->execute();
				        	$severe = $pro_sev->fetchAll(PDO::FETCH_ASSOC);
				        		
				        	$aller_arr[$key]["severe"] = $severe;
				        
				      
			        
			         }
			        $dbCon = null;
			        $errorCodes = array(
						                   'statusCode'=>'99',
						                   'errorMessage'=>'',
						                   'profile'=>$profile,
						                   'history'=> $history,
						                   'allergies'=> $aller_arr
						                );
					  goto res;
		        //echo '{"profile": ' . json_encode($profile) . ',"history": ' . json_encode($history) . ',"allergies": ' . json_encode($aller_arr) . '}';
		       }else{
		            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	               goto res;
			    }	  
		    } catch(PDOException $e) {
		        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
              goto res;
		    }
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
		}
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/getInformationSharing',function() {
   
   global $app;
   $request = $app->request();
   $body = $request->getBody();
   $error = 0;
	$errorCodes = array();
   if(is_json($body)){
		$input = json_decode($body);
		if(!empty($input)){

		   $tagid = $input->id; 
		
			$sql = "select S.*,U.* from InformationSharing S join UserType U on U.userTypeId = S.userTypeId
								join ProfileTagMapping PT on PT.profileId = S.profileId 
								where PT.tagId = :tagid";
		    try {
			         $dbCon = getConnection();
			         $stmt = $dbCon->prepare($sql);
			         $stmt->bindParam("tagid", $tagid);
			         $stmt->execute();
			         $exist = $stmt->rowCount();
			      if($exist){
			         $info = $stmt -> fetchAll(PDO::FETCH_OBJ);	  
			         $dbCon = null;
		         }else{
	            $errorCodes = array('statusCode'=>'1008','errorMessage'=>'User not found');
  	               goto res;
		         }	  
		         $errorCodes = array(
						                   'statusCode'=>'99',
						                   'errorMessage'=>'',
						                   'informationsharing' => $info
						                );
					  goto res;
				     echo '{"informationsharing": ' . json_encode($info) .'}';
			  } catch(PDOException $e) {
				   $errorCodes = array('statusCode'=>'1011','errorMessage'=>'Error connecting to the database.');
  	            goto res;
			  }
		}else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
     }
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});
		
$app->get('/defaultInputs',function() {
			 $header = array('country','states','addresstype','emailtype','phonetype','gender','allergyname','allergytype','symptomsmild','symptomssevere','role');
		    $input[0] = "select countryId, countryName from Country";
		    $input[1] = "select stateId, stateName, countryId from State";
		    $input[2] = "select id as addressTypeId, addressTypeName from AddressType";
		    $input[3] = "select id as emailTypeId, emailTypeName from EmailType";
		    $input[4] = "select id as phoneTypeId, phoneTypeName from PhoneType";
		    $input[5] = "select * from Gender";
		    $input[6] = "select * from AllergyName";
		    $input[7] = "select * from AllergyType";  
		    $input[8] = "select * from SymtomsMild";
		    $input[9] = "select * from SymtomsSevere";
		    $input[10] = "select * from Role where roleId <> 1";
		    
		    $rs = '';
		    try {
		        $dbCon = getConnection();
		        //$app->headers->set("Content-type", "application/json;charset=utf-8"); 
		        //$dbCon->set_charset('utf8');
		        for($i=0;$i < 11;$i++)
		        {
		        	  $prepare[$i] = $dbCon->prepare($input[$i]);
		        	  $prepare[$i]->execute();
		        	  $result[$i] = array($header[$i] => $prepare[$i] -> fetchAll(PDO::FETCH_OBJ));        	  
		        }
		     //var_dump($result); exit;
		        $dbCon = null;
		        $errorCodes = array(
			                   'statusCode'=>'99',
			                   'errorMessage'=>'',
			                   'default'=>$result
			                );
		        goto res;
		        //echo json_encode(array('default'=>$result));	    
		    } catch(PDOException $e) {
		        $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
              goto res;
		    }
	res:
   echo '{"Result":'. json_encode($errorCodes).'}';
		
});

//---------------------------------------------Code for edit purpose-------------------------//
$app->post('/editPersonal',function() {
	
    global $app;
        $request = $app->request();
        $body = $request->getBody();
        $error = 0;
	     $errorCodes = array();
        if(is_json($body)){
		   $input = json_decode($body);
		   if(!empty($input)){  
		        $dbCon = getConnection();
		        $phones = array(); 
		        $emails = array(); 
		        $address = array(); 
		        
		        $account_id = $input->accountId;
		        if($account_id == '')
		        {
		        	 $errorCodes = array('statusCode'=>'1000','errorMessage:'=>'Please enter all mandatory fields.');
                goto res;
		        }
		        $exist_check = "select * from Account where accountId='".$account_id."'";
		        //echo $exist_check; exit;
		        $acc_chk = $dbCon->prepare($exist_check);
		        $acc_chk->execute();
		        $count = $acc_chk->fetchAll();
		        if(count($count))
		        {
		            //for activity log
				      $activity_sql = "insert into ActivityLog(accountId,action,title) values ('$account_id','update','personal')";
				      $activity = $dbCon->prepare($activity_sql);
				      $activity->execute();
		            //end of activity log
		        	  if($input->accountPicture != '')
		        	  {
		        	  	  $name = '';
		        	  	  $data = $input->accountPicture;
		        	  	  //$data = explode(",",$data);
		        	  	  //if(!empty($data) && isset($data[1]))
		        	  	  //{
					        $data = base64_decode($data);
					        $path = '../uploads/accountImages/';
					        //$name = uniqid() . date('Y-m-dH:i:s') . '.jpeg';
					        $name = "profile".$account_id.'.jpeg';
					        $file = $path . $name;
					        $success = file_put_contents($file, $data);
				        //}
				        
		        	  }
			        $account = array(
			                      'accountFirstName' => $input->accountFirstName,
			                      'accountMiddleName' => $input->accountMiddleName,
			                      'accountLastName' => $input->accountLastName,
			                      'accountGender' => $input->gender	                     
			                   );
		                if($input->accountPicture)
		                {
		                   $account['accountPicture'] = $name;
		                }
		
			        $update_acc = "update Account set accountFirstName='".$account['accountFirstName']."', accountMiddleName='".$account['accountMiddleName']."',
			                       accountLastName='".$account['accountLastName']."', accountGender='".$account['accountGender']."', accountPicture='".$account['accountPicture']."'
			                       where accountId = '$account_id'";
			                       
			        //echo $update_acc; //exit;
			        foreach($input->phones as $phn)
			        {
			        	 //phone and flag validation
			        	 $phones[] = "('$account_id','$phn->phoneTypeId','$phn->phoneNumber','$phn->phoneNumberEx')";
			        }   
			        
			        foreach($input->emails as $email)
			        {
			        	 if(!filter_var($email->emailAddress, FILTER_VALIDATE_EMAIL)) {
				            $errorCodes = array('statusCode'=>'1002','errorMessage'=>'Invalid email address format.');
				  	         goto res;
				       }
			        	 $emails[] = "('$account_id','$email->emailTypeId','$email->emailAddress')";
			        }
			        
			        foreach($input->addresses as $addr)
			        {
			        	 $address[] = "('$account_id','$addr->addressTypeId','$addr->addressFirst','$addr->addressSecond','$addr->city','$addr->state','$addr->zip','$addr->country')";
			        }
			        $phone_arr = implode(",",$phones);    
			        $email_arr = implode(",",$emails);  
			        $addr_arr = implode(",",$address);   
			        $phone_del = "delete from PhoneNumberTable where accountId='$account_id'";
			        $email_del = "delete from EmailTable where accountId='$account_id'";
			        $addr_del = "delete from AddressTable where accountId='$account_id'";
			        $insert_phone = "insert into PhoneNumberTable (accountId,phoneTypeId,phoneNumber,phoneNumberEx) values ".$phone_arr."";
			        $insert_email = "insert into EmailTable (accountId,emailTypeId,emailAddress) values ".$email_arr."";
			        $insert_address = "insert into AddressTable (accountId,addressTypeId,addressFirst,addressSecond,city,state,zip,country) values ".$addr_arr."";
			        /*echo $insert_phone;
			        echo $insert_email;
			        echo $insert_address; exit;*/
			        try {
		             
		              $acc1 = $dbCon->prepare($update_acc);
			           $acc1->execute();
			           $del1 = $dbCon->prepare($phone_del);
			           $del1->execute();
			           $del2 = $dbCon->prepare($email_del);
			           $del2->execute();
			           $del3 = $dbCon->prepare($addr_del);
			           $del3->execute();
			           $insert1 = $dbCon->prepare($insert_phone);
			           $insert1->execute();
			           $insert2 = $dbCon->prepare($insert_email);
			           $insert2->execute();
			           $insert3 = $dbCon->prepare($insert_address);
			           $insert3->execute();
			           
			           $errorCodes = array('statusCode'=>'99','errorMessage:'=>'');
                    goto res;
		           }catch(PDOException $e) {
		           	  $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
                    goto res;          
		           }
		        }
		      else
		        {
		        	 $errorCodes = array('statusCode'=>'1009','errorMessage:'=>'Invalid account id.');
                goto res;
		        }  
		  }else{
				$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
			  	goto res;
		    }
       }else{
		  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
			 goto res;
		 } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';      
});

$app->post('/editSigninfo',function() {
	
    global $app;
        $request = $app->request();
        $body = $request->getBody();
        $error = 0;
	     $errorCodes = array();
        if(is_json($body)){
		   $input = json_decode($body);
		   if(!empty($input)){        
		        $account_id = $input->accountId;
		        $username = $input->userName;
		        $pwd = base64_encode($input->password);
		        $mobile = $input->accountMobilePhone;
		        $mob_extn = $input->mobileExtn;
		        if($account_id == '' || $username == '' || $pwd=='' || $mobile=='' || $mob_extn=='')
		        {
		        	  $errorCodes = array('statusCode'=>'1000','errorMessage:'=>'Please enter all mandatory fields.');
                 goto res;
		        }		  
		        if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
		            $errorCodes = array('statusCode'=>'1002','errorMessage'=>'Invalid email address format.');
		  	         goto res;
		        }
		        if(0){
		        	   $errorCodes = array('statusCode'=>'1005','errorMessage'=>'Password should have at least 1 uppercase, 1 lowercase, 1 digit and more than 8 characters');
		  	         goto res;
		        }	
		        if(0){
		        	   $errorCodes = array('statusCode'=>'1004','errorMessage'=>'Invalid phone number.');
		  	         goto res;
		        }	
		        if(0){
		        	   $errorCodes = array('statusCode'=>'1014','errorMessage'=>'Invalid country extension');
		  	         goto res;
		        }	      
		        $sql = "select * from Account where accountEmail = '".$username."' and accountId <> '".$account_id."'";
		        try{
		        	  $dbCon = getConnection();
		        	  $count = $dbCon->prepare($sql);
		        	  $count->execute();
		        	  $rows = $count->fetchAll();
		        	  if(count($rows) == 0)
		        	  {
		        	  	  $update = "update Account set accountEmail='".$username."', loginPassword='".$pwd."', accountMobilePhone='".$mobile."',
		        	  	             amn_ex='".$mob_extn."' where accountId = '".$account_id."'";
		        	  	  $acc_upd = $dbCon->prepare($update);
		        	     $res = $acc_upd->execute();
		        	     if($res){
			              //for activity log
					        $activity_sql = "insert into ActivityLog(accountId,action,title) values ('$account_id','update','signing')";
						     $activity = $dbCon->prepare($activity_sql);
						     $activity->execute();
						     //end of activity log
			        	     $errorCodes = array('statusCode'=>'99','errorMessage'=>'');
	  	                 goto res;
		        	     }else {
		        	     	  $errorCodes = array('statusCode'=>'403','errorMessage'=>'Forbidden');
  	                    goto res;
		        	     }
		        	  	
		        	  }
		           else
		           {
		           	 $errorCodes = array('statusCode'=>'1003','errorMessage:'=>'Email address already exists.');
                   goto res;
		           }
		        }catch(PDOException $e){
		        	  $errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
                 goto res;
		        }
		    }else{
				$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
			  	goto res;
		    }
       }else{
		  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
			 goto res;
		 } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
        
});

$app->post('/editProfile', function(){
	global $app;
        $request = $app->request();
        $body = $request->getBody();
        $error = 0;
	     $errorCodes = array();
        if(is_json($body)){
		   $input = json_decode($body);
		   if(!empty($input)){  
		        $dbCon = getConnection();
		        $emergency = array();
		        $insurance = array();
		        $doctor = array();     
		        
		        //var_dump($input); exit;
		        $account_id = $input->accountId;
		        $profile_id = $input->profileId;
		        $dob = $input->profileDateOfBirth;
		        $date = '';
		        if($dob){
		        	$temp = explode('-',$dob);
		        	if(!empty($temp)){
		        		$date = $temp[1].'/'.$temp[2].'/'.$temp[0];
		        	}
		        }
		        
		        $username = $input->profileEmail;
		        if($account_id !='')
		        {
		        	  if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
			            $errorCodes = array('statusCode'=>'1002','errorMessage'=>'Invalid email address format.');
			  	         goto res;
			        }
			        if(!preg_match("/^((0?[13578]|10|12)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[01]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1})))$/",$date))
					  {
					      $errorCodes = array('statusCode'=>'1001','errorMessage'=>'Invalid date format');
						  	goto res;
					  }
				     else{
				     	$current_date = date('Y-m-d');
				     	if($current_date < $dob){
				     		$errorCodes = array('statusCode'=>'1001','errorMessage'=>'Invalid date format');
						  	goto res;
				     	}
				     }
			        if(0){
			        	   $errorCodes = array('statusCode'=>'1004','errorMessage'=>'Invalid phone number.');
			  	         goto res;
			        }	
			        if(0){
			        	   $errorCodes = array('statusCode'=>'1014','errorMessage'=>'Invalid country extension');
			  	         goto res;
			        }	      
		        	 $profilename = '';
		        	 if($input->profilePicture != '')
		        	  {        	  	  
		        	  	  $data = $input->profilePicture;
		        	  	  
		        	  	  	  if(!$profile_id){
		        	  	  	  	$profile_id = date('Y-m-d_H:i:s');
		        	  	  	  }
		                           if(strlen($data) > 100)
		                            {
					        $data = base64_decode($data);
					        $path = '../uploads/profileImages/';
					        //$name = uniqid() . date('Y-m-dH:i:s') . '.jpeg';
					        $profilename = "profile".$profile_id.'.jpeg';
					        $file = $path . $profilename;
					        $success = file_put_contents($file, $data);
		                            }
		                         else
		                         {
		                                $array = explode('/',$data);
		                                $profilename = end($array);
		                         }
				        //}
				      }
		                  $SchoolLogo = '';
		           if($input->profileSchoolLogo != '')
		        	  {        	  	  
		        	  	  $data = $input->profileSchoolLogo;
		        	  
		        	  	  	  if(!$profile_id){
		        	  	  	  	$profile_id = date('Y-m-d_H:i:s');
		        	  	  	  }
		                           if(strlen($data) > 100)
		                            {
					        $data = base64_decode($data);
					        $path = '../uploads/profileImages/';
					        //$name = uniqid() . date('Y-m-dH:i:s') . '.jpeg';
					        $SchoolLogo = "school".$profile_id.'.jpeg';
					        $file = $path . $SchoolLogo;
					        $success = file_put_contents($file, $data);
		                            }
		                         else
		                         {
		                                $array = explode('/',$data);
		                                $SchoolLogo = end($array);
		                         }
				        //}
				      }
		        	  $activity_action = 'new';
			        $profile = array(
			                      'profileFirstName' => $input->profileFirstName,
			                      'profileMiddleName' => $input->profileMiddleName,
			                      'profileLastName' => $input->profileLastName,
			                      'profileDateOfBirth' => $input->profileDateOfBirth,
			                      'profileGenderId' => $input->gender,
			                      'profileMobilePhone' => $input->profileMobilePhone,
			                      'profileMobileEx' => $input->profileMobileEx,
			                      'profileEmail' => $input->profileEmail,
			                      'profileAddressFirstLine' => $input->profileAddressFirstLine,
			                      'profileAddressSecondLine' => $input->profileAddressSecondLine,
			                      'profileAddressCity' => $input->profileAddressCity,
			                      'profileAddressStateId' => $input->profileAddressState,
			                      'profileAddressZip' => $input->profileAddressZip,
			                      'profileAddressCountryId' => $input->profileAddressCountry,	                      
			                      'profileSchoolName' => $input->profileSchoolName,	                      
			                      'profileSchoolGrade' => $input->profileSchoolGrade
			                   );
		               if($input->profilePicture)
		               {
		                  $profile['profilePicture'] = $profilename;
		               } 
		               if($input->profileSchoolLogo)
		               {
		                  $profile['profileSchoolLogo'] = $SchoolLogo;
		               } 
			       if($profile_id){
			        $activity_action = 'update';
			        $update_pro = "update Profile set profileFirstName='".$profile['profileFirstName']."', 
			                                          profileMiddleName='".$profile['profileMiddleName']."',
			                                          profileLastName='".$profile['profileLastName']."', 
			                                          profileDateOfBirth='".$profile['profileDateOfBirth']."', 
			                                          profileGenderId='".$profile['profileGenderId']."',
			                                          profileEmail='".$profile['profileEmail']."',
			                                          profileMobilePhone='".$profile['profileMobilePhone']."',
			                                          profileMobileEx='".$profile['profileMobileEx']."',
			                                          profileAddressFirstLine='".$profile['profileAddressFirstLine']."',
			                                          profileAddressSecondLine='".$profile['profileAddressSecondLine']."',
			                                          profileAddressCity='".$profile['profileAddressCity']."',
			                                          profileAddressStateId='".$profile['profileAddressStateId']."',
			                                          profileAddressZip='".$profile['profileAddressZip']."',
			                                          profileAddressCountryId='".$profile['profileAddressCountryId']."',
			                                          profilePicture= '$profilename',
			                                          profileSchoolName='".$profile['profileSchoolName']."',
			                                          profileSchoolLogo='".$SchoolLogo."',                                          
			                                          profileSchoolGrade='".$profile['profileSchoolGrade']."'	                                          
			                       where profileId = '$profile_id'";
			      }else{ //new profile creation
			        $update_pro = "insert into Profile(`accountId`, `profileFirstName`, `profileMiddleName`, `profileLastName`, `profileDateOfBirth`, `profileGenderId`, `profileMobilePhone`, `profileMobileEx`, `profileEmail`, `profilePicture`, `profileAddressFirstLine`, `profileAddressSecondLine`, `profileAddressCity`, `profileAddressStateId`, `profileAddressZip`, `profileAddressCountryId`, `profileSchoolName`, `profileSchoolLogo`, `profileSchoolGrade`) values
			                       ('$account_id','$input->profileFirstName','$input->profileMiddleName','$input->profileLastName','$input->profileDateOfBirth','$input->gender','$input->profileMobilePhone','$input->profileMobileEx','$input->profileEmail','$input->profilePicture','$input->profileAddressFirstLine','$input->profileAddressSecondLine','$input->profileAddressCity', '$input->profileAddressState','$input->profileAddressZip','$input->profileAddressCountry','$input->profileSchoolName','$input->profileSchoolLogo', '$input->profileSchoolGrade')";
			                       
			      }               
			        //echo $update_pro; exit;
			        foreach($input->Emergency as $emer)
			        {
			        	  if(0){
				        	   $errorCodes = array('statusCode'=>'1004','errorMessage'=>'Invalid phone number.');
				  	         goto res;
				        }	
				        if(0){
				        	   $errorCodes = array('statusCode'=>'1014','errorMessage'=>'Invalid country extension');
				  	         goto res;
				        }	      
			        	 $emergency[] = "(:profileid,'$emer->emergencyContactFirstName','$emer->emergencyContactMiddleName','$emer->emergencyContactLastName',
			        	                  '$emer->emergencyPhoneType','$emer->emergencyContactNumber','$emer->emergencyPhoneExtn','$emer->emergencyContactRelationship')";
			        }   
			        
			        foreach($input->Doctor as $doc)
			        {
			        	 if(0){
				        	   $errorCodes = array('statusCode'=>'1004','errorMessage'=>'Invalid phone number.');
				  	         goto res;
				        }	
				        if(0){
				        	   $errorCodes = array('statusCode'=>'1014','errorMessage'=>'Invalid country extension');
				  	         goto res;
				        }	      
			        	 $doctor[] = "(:profileid,'$doc->doctorFirstName','$doc->doctorMiddleName','$doc->doctorLastName',
			        	               '$doc->doctorPhoneType','$doc->doctorPhoneNumber','$doc->doctorPhoneExtn','$doc->doctorAddressType',
			        	               '$doc->doctorAddressFirstline','$doc->doctorAddressSecondline','$doc->doctorCity','$doc->doctorState',
			        	               '$doc->doctorZip','$doc->doctorCountry')";
			        }
			        
			        foreach($input->Insurance as $ins)
			        {
			        	  
			        	   $date = $ins->expMonth.'/'.$ins->expDay.'/'.$ins->expYear;
			        	   
			        	   	if (!preg_match("/^((0?[13578]|10|12)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[01]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1})))$/",$date))
							    {
							       $errorCodes = array('statusCode'=>'1001','errorMessage'=>'Invalid date format');
								  	 goto res;
							    }else{
							    	$current_date = date('m/d/Y');
							    	if($current_date > $date){
							    		$errorCodes = array('statusCode'=>'1001','errorMessage'=>'Invalid date format');
						  	         goto res;
							    	}
							    }
					      
	                   $front = '';
	                   if($ins->scanCopyFront != '')
				        	  {
				        	  	  
				        	  	  $data = $ins->scanCopyFront;
				        	  	  
				        	  	  	  if(!$profile_id){
				        	  	  	  	$profile_id = date('Y-m-d_H:i:s');
				        	  	  	  }
				                      
				                       if(strlen($data) > 100)
				                         {
							        $data = base64_decode($data);
							        $path = '../uploads/insurance/front/';
							        //$name = uniqid() . date('Y-m-dH:i:s') . '.jpeg';
							        $front = "front".uniqid().$profile_id.'.jpeg';
							        $file = $path . $front;
							        $success = file_put_contents($file, $data);
				                         }
				                         else
				                         {
				                                $array = explode('/',$data);
				                                $front = end($array);
				                         }
						        //}
						     }
               $back = '';
               if($ins->scanCopyBack != '')
		        	  {
		        	  	  
		        	  	  $data = $ins->scanCopyBack;
		        	  	 
		        	  	  	  if(!$profile_id){
		        	  	  	  	$profile_id = date('Y-m-d_H:i:s');
		        	  	  	  }
		                          if(strlen($data) > 100)
		                          {
					        $data = base64_decode($data);
					        $path = '../uploads/insurance/back/';
					      
					        $back = "back".uniqid().$profile_id.'.jpeg';
					        $file = $path . $back;
					        $success = file_put_contents($file, $data);
		                           }
		                           else
		                         {
		                                $array = explode('/',$data);
		                                $back = end($array);
		                         }
				        
				   } 
			        	 $insurance[] = "(:profileid,'$ins->providerName','$ins->planId','$ins->groupId','$ins->payerId','$ins->expMonth','$ins->expYear','$ins->expDay','$front','$back')";
			     }
			        $emer_arr = implode(",",$emergency);    
			        $doc_arr = implode(",",$doctor);  
			        $ins_arr = implode(",",$insurance);   
			        $emer_del = "delete from EmergencyContacts where profileId=:profileid";
			        $doc_del = "delete from DoctorDetails where profileId=:profileid";
			        $ins_del = "delete from Insurance where profileId=:profileid";
			        $insert_emergency = "insert into EmergencyContacts (profileId,emergencyContactFirstName,emergencyContactMiddleName,emergencyContactLastName,emergencyPhoneType,emergencyContactNumber,emergencyPhoneExtn,emergencyContactRelationship) values ".$emer_arr."";
			        $insert_doctor = "insert into DoctorDetails (profileId,doctorFirstName,doctorMiddleName,doctorLastName,doctorPhoneType,doctorPhoneNumber,doctorPhoneExtn,doctorAddressType,doctorAddressFirstline,doctorAddressSecondline,doctorCity,doctorState,doctorZip,doctorCountry) values ".$doc_arr."";
			        $insert_insurance = "insert into Insurance (profileId,providerName,planId,groupId,payerId,expMonth,expYear,expDay,scanCopyFront,scanCopyBack) values ".$ins_arr."";
			     
			        try {
			        	
			        	if($profile_id){
			        		$pro1 = $dbCon->prepare($update_pro);
			            $pro1->execute();	        		
			        	}else{
			        		$pro1 = $dbCon->prepare($update_pro);
			            $pro1->execute();
			            $profile_id = $dbCon->lastInsertId();
			        	}
		   //for activity log
			$activity_sql = "insert into ActivityLog(accountId,profileId,action,title) values ('$account_id','$profile_id','$activity_action','profile')";
			//$activity = $dbCon->prepare($activity_sql);
			//$activity->execute();
			//end of activity log
			           $del1 = $dbCon->prepare($emer_del);
			           $del1->bindParam("profileid", $profile_id);
			           $del1->execute();
			           $del2 = $dbCon->prepare($doc_del);
			           $del2->bindParam("profileid", $profile_id);
			           $del2->execute();
			           $del3 = $dbCon->prepare($ins_del);
			           $del3->bindParam("profileid", $profile_id);
			           $del3->execute();
			       if(!empty($emer_arr)){
			           $insert1 = $dbCon->prepare($insert_emergency);
			           $insert1->bindParam("profileid", $profile_id);
			           $insert1->execute();			      
			       }
			       if(!empty($doc_arr)){
			           $insert2 = $dbCon->prepare($insert_doctor);
			           $insert2->bindParam("profileid", $profile_id);
			           $insert2->execute();
			       }
			       if(!empty($ins_arr)){
			           $insert3 = $dbCon->prepare($insert_insurance);
			           $insert3->bindParam("profileid", $profile_id);
			           $insert3->execute();
			        }   
			           $errorCodes = array('statusCode'=>'99','errorMessage'=>'');
	                 goto res;    
		           }catch(PDOException $e) {
		           	  $errorCodes = array('statusCode'=>'1011','errorMessage'=>'Error connecting to the database.');
  	                 goto res;      
		           }
		        }
		      else
		        {
		        	 $errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields.');
		  	       goto res;
		        }   
		 }else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
     }
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';          
	
});

$app->post('/editAllergy', function(){
	global $app;
        $request = $app->request();
        $body = $request->getBody();
        $error = 0;
	     $errorCodes = array();
        if(is_json($body)){
		    $input = json_decode($body);
		    if(!empty($input)){
             $input = json_decode($body);
		        //var_dump($input); exit;
		        $profile_id = $input->profileId;
		        $account_id = $input->accountId;
		        //account id check
		        if($account_id != get_account_id($profile_id))
		        {
		        	 $errorCodes = array('statusCode'=>'1015','errorMessage'=>'Could not match profile id and account id');
  	             goto res;
		        }
		        $dbCon = getConnection();
		        if($profile_id && $account_id ){
		        	  foreach($input->allergies as $row){
		        	  	 if($row->allergyNameId=='' || $row->allergyTypeId==''){
		        	  	 	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
  	                  goto res;
		        	  	 }
		        	  	 foreach($row->mild as $mil){
		        	  	 	if($mil->symtomMildId==''){
		        	  	 		$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
  	                     goto res;
		        	  	 	}
		        	  	 }
		        	    foreach($row->severe as $sev){
		        	  	 	if($sev->symtomSevereId==''){
		        	  	 		$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
  	                     goto res;
		        	  	 	}
		        	  	 }
		        	  }		   
		        	  foreach($input->incidents as $row){
		        	  	 if($row->allergyTypeId=='' || $row->allergyIncidentDesc=='' ||$row->allergyIncidentDate==''){
		        	  	 	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
  	                  goto res;
		        	  	 }
		        	  }     	  
			        //	var_dump($input->allergies); exit;
			        $del_mild = "delete PM from `ProfileSymtomsMild` as PM JOIN `Allergy` as A ON A.allergyId = PM.allergyId WHERE A.profileId = '".$profile_id."'";
			        $mild_del = $dbCon->prepare($del_mild);
				     $mild_del->execute(); 
			 	         
				     $del_severe = "delete PS from `ProfileSymtomsSevere` as PS JOIN `Allergy` as A ON A.allergyId = PS.allergyId WHERE A.profileId = '".$profile_id."'";           
			        $severe_del = $dbCon->prepare($del_severe);
				     $severe_del->execute();
			        
				            
			        $del_aller = "delete from Allergy where profileId = '".$profile_id."'";
			        $allergy_del = $dbCon->prepare($del_aller);
				     $sucs1 = $allergy_del->execute();
			        
			        foreach($input->allergies as $key => $row){
			                      
			            //get old allergy id and delete it
			            $old_allergy_id = $row->allergyId;         
				        
			            $allergyNameId = $row->allergyNameId;
			            $allergyTypeId = $row->allergyTypeId;
			            
			            try{           	
				            
			            	$sql_a = "insert into Allergy(profileId,AllergyNameId,AllergyTypeId) values ('$profile_id','$allergyNameId','$allergyTypeId')";
			            	$allergy = $dbCon->prepare($sql_a);
				            $allergy->execute();
				            $allergy_id = $dbCon->lastInsertId();
				            
				            //insert into mild table
				            if(!empty($row->mild)){
				            	foreach($row->mild as $m){
				            		$sql_m = "insert into ProfileSymtomsMild(allergyId,SymtomMildId) values ('$allergy_id','$m->symtomMildId')";
				            		$mild = $dbCon->prepare($sql_m);
				                  $mild->execute();
				            	}
				            }
				            
				            //insert into severe table
				            if(!empty($row->severe)){
				            	foreach($row->severe as $s){
				            		$sql_s = "insert into ProfileSymtomsSevere(allergyId,SymtomSevereId) values ('$allergy_id','$s->symtomSevereId')";
				            		$severe = $dbCon->prepare($sql_s);
				                  $severe->execute();
				            	}
				            }
				            
			            }catch(PDOException $e){
			            	$errorCodes = array('statusCode'=>'1011','errorMessage'=>'Error connecting to the database.');
  	                     goto res;
			            }
			        }
			      if($profile_id){
			      	   $sql_d = "delete from AllergyIncidentSymptoms where profileId='".$profile_id."'";
			      	   $inci_del = $dbCon->prepare($sql_d);
				         $inci_del->execute();
			      }
			  
			      foreach($input->incidents as $key => $row){
			      	
			         $sql = "insert into AllergyIncidentSymptoms(profileId,allergyTypeId,allergyIncidentDesc,allergyIncidentDate) values 
			                 ('$profile_id','$row->allergyTypeId','$row->allergyIncidentDesc','$row->allergyIncidentDate')";
			         $incident = $dbCon->prepare($sql);
				      $incident->execute();
			      }
			      //for activity log
			      $activity_sql = "insert into ActivityLog(accountId,profileId,action,title) values ('$account_id','$profile_id','update','allergy')";			    
			      $activity = $dbCon->prepare($activity_sql);
			      $activity->execute();
			      //end of activity log			
			      $errorCodes = array('statusCode'=>'99','errorMessage'=>'');
	            goto res;    
			 }else{
			 	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
	         goto res;    
			 }  
     }else{
			$errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	goto res;
     }
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';     
        
});

$app->post('/editSharingInfo', function(){
	global $app;
        $request = $app->request();
        $body = $request->getBody();
      if(is_json($body)){
        $input = json_decode($body);
     
      if(!empty($input)){
        $error = 0;
        $errorCodes = array(); 
        $dbCon = getConnection();
        $success = 0;
        //var_dump($input); //exit;
        $profile_id = $input->informationsharing[0]->profileId; 
       if($profile_id){
        $dbCon = getConnection();
        foreach($input->informationsharing as $row){
        	if($row->profileId == '' || $row->userTypeId=='' || $row->personalInfo=='' || $row->EmergencyContactInfo=='' || $row->schoolInfo=='' || $row->insuranceInfo=='')
        	{
        		$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
	         goto res;        		
        	}
        }
        foreach($input->informationsharing as $row)
        {
        	 if($row->infoSharingId)
        	 {
        	    $info_sql = "update InformationSharing set personalInfo='".$row->personalInfo."', schoolInfo='".$row->schoolInfo."', 
        	              insuranceInfo='".$row->insuranceInfo."', EmergencyContactInfo='".$row->EmergencyContactInfo."' where infoSharingId='".$row->infoSharingId."'";
        	 }
          else
          {
          	 $info_sql = "insert into (`profileId`, `userTypeId`, `personalInfo`, `EmergencyContactInfo`, `schoolInfo`, `insuranceInfo`)
          	              values ('$profile_id','$row->userTypeId','$row->personalInfo','$row->EmergencyContactInfo','$row->schoolInfo','$row->insuranceInfo')";
          }
          try{         
        	 $inci = $dbCon->prepare($info_sql);
	       $inci->execute();
	       $success = 1;
          	
         }catch(PDOException $e){
         	$errorCodes = array('statusCode'=>'1018','errorMessage'=>'Please activate your account.');
  	         goto res;
         }
        	              
        }
       if($success){
	       //for activity log
		    $account_id = get_account_id($profile_id);
			 $activity_sql = "insert into ActivityLog(accountId,profileId,action,title) values ('$account_id','$profile_id','update','infosharing')";
			 $activity = $dbCon->prepare($activity_sql);
			 $activity->execute();
			 //end of activity log
        	 $errorCodes = array('statusCode'=>'99','errorMessage'=>'');
  	       goto res;          
        }else{
        	  $errorCodes = array('statusCode'=>'403','errorMessage'=>'Forbidden');
  	        goto res;
        }
      }else{
      	$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields');
	      goto res;   
      }
	  }else{
	  	 $errorCodes = array('statusCode'=>'107','errorMessage'=>'API require inputs to handle');
	  	 goto res;
	  }
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});

$app->post('/signUp', function(){
	global $app;
        $request = $app->request();
        $body = $request->getBody();
      if(is_json($body)){
        $input = json_decode($body);
     
      if(!empty($input)){
        $error = 0;
        $errorCodes = array(); 
        $accountdetails = array(
	        'accountFirstName' => $input->signup->accountFirstName,
	        'accountMiddleName' => $input->signup->accountMiddleName,
	        'accountLastName' => $input->signup->accountLastName,
	        'accountMobilePhone' => $input->signup->accountMobilePhone,
	        'countryExtn' => $input->signup->countryExtn,
	        'accountGender' => $input->signup->accountGender,
	        'accountEmail' => $input->signup->accountEmail,
	        'password' => $input->signup->password,
	        'rPassword' => $input->signup->rPassword,
	        'profileFirstName' => $input->signup->profileFirstName,
	        'profileMiddleName' => $input->signup->profileMiddleName,
	        'profileLastName' => $input->signup->profileLastName,
	        'profileDateOfBirth' => $input->signup->profileDateOfBirth,
	        'profileGenderId' => $input->signup->profileGenderId,
	        'profileMobilePhone' => $input->signup->profileMobilePhone,
	        'profileMobileEx' => $input->signup->profileMobileEx,
	        'profileEmail' => $input->signup->profileEmail,
           'accountCountry' => $input->signup->accountCountry,
           'userRole' => $input->signup->userRole
        );
       //var_dump($accountdetails); exit;
       //validation process
       foreach($accountdetails as $key=>$value){
       	if($key != 'accountMiddleName' && $key != 'profileMiddleName' && $value == ''){
       		$error = 1;
       	}
       }
   
       if(!$error){
       	if(!filter_var($accountdetails['accountEmail'], FILTER_VALIDATE_EMAIL) || !filter_var($accountdetails['profileEmail'], FILTER_VALIDATE_EMAIL)) {
            $errorCodes = array('statusCode'=>'101','errorMessage'=>'Invalid email format');
  	         goto res;
         }
     
         $phone_pattern = '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/';
         if(!preg_match($phone_pattern, $accountdetails['accountMobilePhone'] ) || !preg_match($phone_pattern, $accountdetails['profileMobilePhone'] )){
         	$errorCodes = array('statusCode'=>'102','errorMessage'=>'Invalid valid phone number');
  	         goto res;
         }
     
         $uppercase = preg_match('@[A-Z]@', $accountdetails['password']);
         $lowercase = preg_match('@[a-z]@', $accountdetails['password']);
         $number    = preg_match('@[0-9]@', $accountdetails['password']);
			if(!$uppercase || !$lowercase || !$number || strlen($accountdetails['password']) < 8) {
			   $errorCodes = array('statusCode'=>'103','errorMessage'=>'Password should have atleast 1 uppercase, 1 lowercase, 1 digit and more than 8 character');
  	         goto res;
			}
		   
		   if($accountdetails['password'] != $accountdetails['rPassword']){
		   	$errorCodes = array('statusCode'=>'104','errorMessage'=>'Passwords are not same');
  	         goto res;
		   }
	      if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $accountdetails['profileDateOfBirth'])){
	         $current_date = date('Y-m-d');
	         if($accountdetails['profileDateOfBirth'] > $current_date){
	         	$errorCodes = array('statusCode'=>'105','errorMessage'=>'Invalid date');
  	            goto res;
	         }
	      }else{
	      	$errorCodes = array('statusCode'=>'105','errorMessage'=>'Invalid date');
  	         goto res;
	      }
	  
	  //validation ends if not error process continues to execute
	      if(!$error){
	      	$dbCon = getConnection();
	      	$sql = "select * from Account where accountEmail='".$accountdetails['accountEmail']."'";
	      	try{         
        	         $email = $dbCon->prepare($sql);
       	         $email->execute();
       	         $exist = $email->rowCount();
	               if(!$exist){
	               	$unique_key = time();
	               	$enc_pwd = base64_encode($accountdetails['password']);
	               	$afirstname = $accountdetails['accountFirstName'];
	               	$amiddlename = $accountdetails['accountMiddleName'];
	               	$alastname = $accountdetails['accountLastName'];
	               	$amobile = $accountdetails['accountMobilePhone'];
	               	$aextn = $accountdetails['countryExtn'];
	               	$aemail = $accountdetails['accountEmail'];
	               	$agender = $accountdetails['accountGender'];
                     $country = $accountdetails['accountCountry'];
	               	$arole = $accountdetails['userRole'];
	               	$astatus = '0';
	               	$akey = md5($unique_key);
	               	$ins_acc_sql = "insert into Account (`loginPassword`, `accountFirstName`, `accountMiddleName`, `accountLastName`, `accountMobilePhone`, `amn_ex`, `accountEmail`, `accountGender`,`accountCountry`, `userRole`, `status`, `uniqueKey`) values 
	               	                ('$enc_pwd','$afirstname','$amiddlename','$alastname','$amobile','$aextn','$aemail','$agender','$country','$arole','$astatus','$akey')";
	               	$account = $dbCon->prepare($ins_acc_sql);
       	            $account->execute();
       	            $account_id = $dbCon->lastInsertId();
       	            
       	            $pfirstname = $accountdetails['profileFirstName'];
	               	$pmiddlename = $accountdetails['profileMiddleName'];
	               	$plastname = $accountdetails['profileLastName'];
	               	$pmobile = $accountdetails['profileMobilePhone'];
	               	$pextn = $accountdetails['profileMobileEx'];
	               	$pemail = $accountdetails['profileEmail'];
	               	$pgender = $accountdetails['profileGenderId'];
	               	$dob = $accountdetails['profileDateOfBirth'];
	               	$ins_pro_sql = "insert into Profile ( `accountId`, `profileFirstName`, `profileMiddleName`, `profileLastName`, `profileDateOfBirth`, `profileGenderId`, `profileMobilePhone`, `profileMobileEx`, `profileEmail`) values 
	               	                ('$account_id','$pfirstname','$pmiddlename','$plastname','$dob','$pgender','$pmobile','$pextn','$pemail')";
	               	$profile = $dbCon->prepare($ins_pro_sql);
       	            $profile->execute();
       	            
       	            //success mail
       	            $toMail = $aemail;
   		            $url = base_url().'login/verify/'.urlencode($aemail).'/'.urlencode($unique_key);
   		            $mailContant = array(
   		                   'subject' => 'vAlert Registration',
   		                   'body' => "Dear ".$afirstname." ".$alastname.",<br>Thanks for registering in vAlert. Please activate your vAlert account by clicking the following link.<br><br>
   		                              ".$url."<br><br>Thanks." 
   		                 );
   		            sendMail('vAlert',$toMail,$mailContant,$attach = NULL,$ccEmail = NULL);
       	            
	               	$errorCodes = array('statusCode'=>'99','errorMessage'=>'');
  	                  goto res;
	               }else{
	               	$errorCodes = array('statusCode'=>'106','errorMessage'=>'Email id already exists');
  	                  goto res;
	               }
            }
            catch(PDOException $e){
            	$errorCodes = array('statusCode'=>'110','errorMessage'=>'Database error');
  	            goto res;
	         }
	       }else{
	       	$errorCodes = array('statusCode'=>'100','errorMessage'=>'Enter all mandatory fields');
  	         goto res;
	       }
    }else{
	       	$errorCodes = array('statusCode'=>'100','errorMessage'=>'Enter all mandatory fields');
  	         goto res;
	       }
  }else{
  	 $errorCodes = array('statusCode'=>'107','errorMessage'=>'API require inputs to handle');
  	 goto res;
  }
  }else{
  	 $errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	 goto res;
  } 
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
});
//common function to accountId
function get_account_id($profileId) {
	$dbCon = getConnection();
	$get_sql = "select accountId from Profile where profileId='".$profileId."'";
	$profile = $dbCon->prepare($get_sql);
	$profile->execute();
	$fetch = $profile->fetchAll(PDO::FETCH_ASSOC);
	return $fetch[0]['accountId']; 
}

$app->post('/feedback',function(){
	global $app;
	$request = $app->request();
   $body = $request->getBody();
	if(is_json($body)){
     $input = json_decode($body);   
     //var_dump($input); exit;
      if(!empty($input)){
      	if($input->rating == '' || $input->category == '' || $input->comments == ''){
      		$errorCodes = array('statusCode'=>'1000','errorMessage'=>'Please enter all mandatory fields.');
  	         goto res;
      	}else{
      		$insert = "insert into Feedback(accountId,rating,category,comments) values ('$input->accountId','$input->rating','$input->category','$input->comments')";
      		//echo $insert; exit;
      		try{
      			$dbCon = getConnection();
               $stmt = $dbCon->prepare($insert);
               $stmt->execute();
                $errorCodes = array('statusCode'=>'99','errorMessage'=>'');
  	             goto res;
      		}catch(PDOException $e){
      			$errorCodes = array('statusCode'=>'1011','errorMessage:'=>'Error connecting to the database.');
  	            goto res;
      		}
      	}
      }else{
      	 $errorCodes = array('statusCode'=>'1012','errorMessage'=>'API parameter missing');
		  	 goto res;
      }
   }else{
   	$errorCodes = array('statusCode'=>'1017','errorMessage'=>'JSON format error');
	   goto res;
   }
  res:
  echo '{"Result":'. json_encode($errorCodes).'}';
	
});

$app->run();

?>
