<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
     }
 
   function getCartList($accountId='',$count='')
   { 
      $query = $this->db->query("select TI.*,AOM.*,TL.tagCost,TT.tagTypeDescription,TL.tagDescription,TL.tagImage,P.profileFirstName, P.profileLastName from TagInfo TI 
      join AccountOrderMapping AOM on AOM.accountOrderMappingId = TI.accountOrderMappingId 
      join TagList TL on TL.tagListId = TI.tagId
      join TagType TT on TT.tagTypeId = TL.tagTypeId
      join Profile P on P.profileId = TI.profileId
      where AOM.accountId = ".$accountId." and AOM.paymentStatus = '0'");
      if($count){
      	return $query->num_rows(); 
      }else{
      	return $query->result_array(); 
      }
        	
   }
   
   function getAccountDetail($acc_id='')
   {
   	$this->db->select('P.*,A.accountId');
   	$this->db->from('PaymentInformation P');
   	$this->db->join('Account A','A.accountPaymentId=P.paymentInfoId');
   	$this->db->where('A.accountId',$acc_id);
   	$query = $this->db->get();
   	return $query->result_array();
   }
   
   function getOrderedTags($account_id = '')
   {
   	$sql = "select * from TagInfo where profileId IN (select profileId from Profile where accountId='".$account_id."')";
   	$query = $this->db->query($sql);
   	return $query->result_array();
   }
   
   function getAllergyById($profile_id='',$url='')
   {
   	   $this->db->distinct('allergyNameId');
   		$this->db->select('AN.allergyNameDescription');
   		$this->db->from('Allergy A');
   		$this->db->join('AllergyName AN','AN.allergyNameId=A.allergyNameId');
   		$this->db->where('A.profileId',$profile_id);
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
	   	  $allergyName .= '<br>';
         }
     if($url)
     {
         $url = base_url().'user/profile/'.$profile_id.'/?tab=panel_edit_allergy';
         $allergyName .= "<a href='".$url."'>Edit</a>";
     }
     return $allergyName;
   }
   
   function getTagList()
   {
   	$this->db->select('TL.*,TT.tagTypeDescription');
   	$this->db->where('tagAvail','1');
   	$this->db->from('TagList TL');
   	$this->db->join('TagType TT','TT.tagTypeId=TL.tagTypeId','right');
   	$query = $this->db->get();
   	return $query->result_array();
   }
 }
