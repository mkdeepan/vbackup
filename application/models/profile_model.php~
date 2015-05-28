<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
     }

     public function profile_info($profileId='')
     {
       $this->db->select('P.*, S.stateName as profileAddressStateId,C.countryName as profileAddressCountryId,D.*,I.providerName,I.planId,I.groupId,I.payerId,I.expMonth,I.expYear,I.expDay,I.scanCopyFront,I.scanCopyBack');
       $this->db->join('State S','S.stateId= P.profileAddressStateId','left');
       $this->db->join('Country C','C.countryId= P.profileAddressCountryId','left');
       $this->db->join('DoctorDetails D','D.profileId=P.profileId','left');
       $this->db->join('Insurance I','I.profileId=P.profileId','left');
       //$this->db->join('schooldetail SD','SD.profileId=P.profileId');
       $this->db->where('P.profileId',$profileId);
       $query = $this->db->get('Profile P');
       //debug_last_query(); exit;
       return $query->result_array();
     }

     public function get_emergency_contact($profileId='')
     {
        //echo $profileId; exit;
     	$this->db->select('*');
     	$this->db->where('profileId',$profileId);
     	$this->db->from('EmergencyContacts E');
     	$this->db->join('PhoneType P','P.id=E.emergencyPhoneType');
     	$query = $this->db->get();
     	return $query->result_array();
     }
 
     public function get_doctor_detail($profileId='')
     {
     	$this->db->select('*');
     	$this->db->from('DoctorDetails D');
     	$this->db->join('AddressType AT','AT.id=D.doctorAddressType','left');
     	$this->db->join('PhoneType P','P.id=D.doctorPhoneType','left');
     	$this->db->join('State S','S.stateId=D.doctorState','left');
     	$this->db->join('Country C','C.countryId=D.doctorCountry','left');
     	$this->db->where('D.profileId',$profileId);
     	$query=$this->db->get();
     	//debug_last_query();
     	return $query->result_array();
     }
 
     public function profile_details($id='')
     {
     	 $this->db->select('P.*,EXTRACT(MONTH from P.profileDateOfBirth) as dobMonth,EXTRACT(YEAR from P.profileDateOfBirth) as dobYear,EXTRACT(DAY from P.profileDateOfBirth) as dobDay');
     	 $this->db->from('Profile P');
     	 //if($id !='')
     	 $this->db->where('P.profileId',$id);
     	  
     	 $query = $this->db->get();
     	 //debug_last_query();
     	 return $query->result_array();
     }
 
     public function delete_ids($table='',$field='',$where_in=array())
     {
     	if(!empty($where_in))
     	{
     	 $this->db->where_in($field,$where_in);
     	 $res = $this->db->delete($table);
     	 if($res){
     	 	return true;
     	 }else{
     	 	return false;
     	 }
      }else 
      return false;
     	 
     }
   
   }
   ?>
