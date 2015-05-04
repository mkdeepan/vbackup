<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct() {
        parent::__construct();
        //$this->load->library('common_model')
        $this->load->library('session');
        $this->load->helper('cookie');
     }
   
   function account_info($id='')
   {
   	$this->db->select('A.*,G.description as gender');
   	$this->db->from('Account A');
   	$this->db->join('Gender G','G.genderId=A.accountGender');
   	$this->db->where('accountId',$id);
   	$query = $this->db->get();
   	$account = $query->result_array();
   	
   	
   	//for phone number
   	$this->db->select('PNT.id,PT.id as ptid,PT.phoneTypeName,PNT.phoneNumber,PNT.phoneNumberEx');
   	$this->db->from('PhoneNumberTable PNT');
   	$this->db->join('PhoneType PT','PT.id=PNT.phoneTypeId');
   	$this->db->where('PNT.accountId',$id);
   	$q_phone = $this->db->get();
   	$phones = $q_phone->result_array();
   	
   	//for email address
   	$this->db->select('ETA.id,ETY.id as etid,ETY.emailTypeName,ETA.emailAddress');
   	$this->db->from('EmailTable ETA');
   	$this->db->join('EmailType ETY','ETY.id=ETA.emailTypeId');
   	$this->db->where('ETA.accountId',$id);
   	$q_email = $this->db->get();
   	$emails = $q_email->result_array();
   	
   	//for location address
      $this->db->select('ATA.*,ATY.id as atid,ATY.addressTypeName,S.*,C.*');
   	$this->db->from('AddressTable ATA');
   	$this->db->join('AddressType ATY','ATY.id=ATA.addressTypeId','left');
   	$this->db->join('State S','S.stateId=ATA.state','left');
   	$this->db->join('Country C','C.countryId=ATA.country','left');
   	$this->db->where('ATA.accountId',$id);
   	$q_loc = $this->db->get();
   	$location = $q_loc->result_array();
   	
   	array_push($account,$phones,$emails,$location);
   	return $account;
   }
   
   function payment_info($id='')
   {
   	$this->db->select('P.*');
   	$this->db->from('PaymentInformation P');
   	$this->db->join('Account A','A.accountPaymentId = P.paymentInfoId','right');
   	$this->db->where('A.accountId',$id);
   	$pay = $this->db->get();
   	$payment = $pay->result_array();
   	return $payment;
   }
   
   function email_list($id)
   {
   	$this->db->select('ETA.id,ETA.emailAddress,ETY.emailTypeName');
   	$this->db->from('EmailTable ETA');
   	$this->db->join('EmailType ETY','ETA.emailTypeId=ETY.id');
   	$this->db->where('ETA.accountId',$id);
   	$query = $this->db->get();
   	return $query->result_array();
   }
   
   function phone_list($id)
   {
   	$this->db->select('PNT.id,PT.phoneTypeName,PNT.phoneNumber,PNT.phoneNumberEx');
   	$this->db->from('PhoneNumberTable PNT');
   	$this->db->join('PhoneType PT','PNT.phoneTypeId=PT.id');
   	$this->db->where('PNT.accountId',$id);
   	$query = $this->db->get();
   	return $query->result_array();
   }
   
   function addr_list($id='')
   {
   	$this->db->select('ATA.*,ATY.addressTypeName,S.*,C.*');
   	$this->db->from('AddressTable ATA');
   	$this->db->join('AddressType ATY','ATY.id=ATA.addressTypeId','left');
   	$this->db->join('State S','S.stateId=ATA.state','left');
   	$this->db->join('Country C','C.countryId=ATA.country','left');
   	$this->db->where('ATA.accountId',$id);
   	$query = $this->db->get();
   	//debug_last_query();
   	return $query->result_array();
   }
   
   public function get_summary_page($id='')
   {
   	$this->db->select('profileId,profileFirstName,profileMiddleName,profileLastName');
   	$this->db->from('Profile');
   	$this->db->where('accountId',$id);
   	$query = $this->db->get();
   	$result = $query->result_array();
   	$data = array();
   	$i=0;
   	foreach($result as $row){
   		$data[$i]['profileId'] = $row['profileId'];
   		$data[$i]['profileName'] = $row['profileFirstName'].' '.$row['profileMiddleName'].' '.$row['profileLastName'];
   		$this->db->distinct('allergyNameId');
   		$this->db->select('AN.allergyNameDescription');
   		$this->db->from('Allergy A');
   		$this->db->join('AllergyName AN','AN.allergyNameId=A.allergyNameId');
   		$this->db->where('A.profileId',$row['profileId']);
   		$allergy_query = $this->db->get();
   		$allergies = $allergy_query->result_array();
   
   		$allergyName = '';
   		if(!empty($allergies)){
   			$j=0;
	   		foreach($allergies as $aller){
	   			if($j){
	   			$allergyName .= ", ".$aller['allergyNameDescription'];
	   			}else{
	   			$allergyName .= $aller['allergyNameDescription'];
	   	    	}
	   	    $j++;
	   		}
	   	  $data[$i]['allergyName'] = $allergyName;
         }else{
           $data[$i]['allergyName'] = '';
         }
   	   $this->db->select('emergencyContactNumber as cnum,emergencyContactFirstName as fname,emergencyContactMiddleName as mname,emergencyContactLastName as lname');
   	   $this->db->where('profileId',$row['profileId']);
   	   $emergency_query = $this->db->get('EmergencyContacts');
   	   //debug_last_query(); exit;
   	   $emergencies = $emergency_query->result_array();
   	   if(!empty($emergencies)){
   	   	$data[$i]['emergencyContact'] = $emergencies[0]['cnum'].'<br>'.$emergencies[0]['fname'].' '.$emergencies[0]['mname'].' '.$emergencies[0]['lname'];
   	   }else{
   	   	$data[$i]['emergencyContact'] = '';
   	   }
         $i++;
   	 // var_dump($data);	
   	}
   	return $data;
   }
}