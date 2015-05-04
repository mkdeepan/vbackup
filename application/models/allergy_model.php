<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Allergy_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
     }
 
    public function getAllergyById($id='')
    {
    	$aller = $this->db->query("select A.*,AN.allergyNameDescription, AT.allergyTypeDescription
		        	         from Allergy A 
		        	         join AllergyName AN on AN.allergyNameId = A.allergyNameId
		        	         join AllergyType AT on AT.allergyTypeId = A.allergyTypeId
		                  
								where A.profileId = '".$id."'");
								/*join SymtomsMild SM on SM.symtomMildId = A.symtomMildId
		                  join SymtomsSevere SS on SS.symtomSevereId = A.symtomSevereId*/
       $allergies = $aller->result_array();
       //debug_last_query();
       $i=0;
       $data = array();
       foreach($allergies as $aller){
       	$data[$i]['allergyId'] = $aller['allergyId'];
       	$data[$i]['allergyNameDescription'] = $aller['allergyNameDescription'];
       	$data[$i]['allergyTypeDescription'] = $aller['allergyTypeDescription'];
       	$data[$i]['symtomMildDescription'] = $this->getSymtomsMildById($aller['allergyId']);
       	$data[$i]['symtomSevereDescription'] = $this->getSymtomsSevereById($aller['allergyId']);
       	$i++;
       }
		 return $data;																			
    }
    public function getSymtomsSevereById($id = '')
    {
    	 $this->db->select('SS.symtomSevereDescription');
    	 $this->db->from('ProfileSymtomsSevere PSS');
    	 $this->db->join('SymtomsSevere SS','SS.symtomSevereId=PSS.symtomSevereId');
    	 $this->db->where('PSS.allergyId',$id);
    	 $query = $this->db->get();
    	 $result = $query->result_array();
    	 //debug_last_query();
    	 //var_dump($result); 
    	 $severe = '';
    	 foreach($result as $k => $res){

    	 	$class = "";
    	 	if($k % 2 == 0)
    	 	  $class = ""; 

			$severe .= '<li class="symptoms '.$class.'">'.$res['symtomSevereDescription'].'</li>'; 

    	 }
       return $severe; 
    }
    public function getSymtomsMildById($id = '')
    {
    	 $this->db->select('SM.symtomMildDescription');
    	 $this->db->from('ProfileSymtomsMild PSM');
    	 $this->db->join('SymtomsMild SM','SM.symtomMildId=PSM.symtomMildId');
    	 $this->db->where('PSM.allergyId',$id);
    	 $query = $this->db->get();
    	 $result = $query->result_array();
    	 //debug_last_query();
    	 //var_dump($result); 
    	 $mild = '';
    	 $i=0;
    	 foreach($result as $k => $res){
    	 	$class = "";
    	 	if($k % 2 == 0)
    	 	  $class = ""; 

			$mild .= '<li class="symptoms '.$class.'">'.$res['symtomMildDescription'].'</li>'; 
    	 }
       return $mild; 
    }
    public function getIncidentById($id='')
    {
    	$inci = $this->db->query("select AIS.*,AT.allergyTypeDescription, AIS.allergyIncidentDesc, AIS.allergyIncidentDate
					        	         from AllergyIncidentSymptoms AIS
					        	         join AllergyType AT on AT.allergyTypeId = AIS.allergyTypeId
											where AIS.profileId = '".$id."'");
		 $incidents = $inci->result_array();
		 
		 return $incidents;
	 }
 }
