<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {
	function __construct() {
        parent::__construct();
        //$this->load->library('common_model')
        $this->load->library('session');
        $this->load->helper('cookie');
     }
 
   function allergists($options=array(),$opt='record')
   {
   	if(isset($options['offset']) && isset($options['limit']))
 	      $this->db->limit($options['limit'],$options['offset']);
 	
	 	if(isset($options['key']) && $options['key']!='') 	{
	 		$this->db->like('S.stateName',$options['key']);
	 		$this->db->or_like('S.abbr',$options['key']);
	 		$this->db->or_like('C.countryName',$options['key']);
	 		$this->db->or_like('A.firstname',$options['key']);
	 		$this->db->or_like('A.middlename',$options['key']);
	 		$this->db->or_like('A.lastname',$options['key']);
	 		$this->db->or_like('A.addrline1',$options['key']);
	 		$this->db->or_like('A.addrline2',$options['key']);
	 		$this->db->or_like('A.city',$options['key']);
	 	}	  
	   if(isset($options['addition']) && $options['addition']!='') 	{
	 		if($options['addition']=='lastname')
	 		 $this->db->order_by('A.lastname','desc');
	 		if($options['addition']=='rating')
	 		 $this->db->order_by('Sum_rating','desc');
	 	}
		 
	 	$this->db->select('A.*,C.countryName,S.abbr,sum(`ASY`.`avgRating`)/count(`ASY`.`allergistid`) as Sum_rating');
	 	$this->db->from('AllergistProfile A');
	 	$this->db->join('Country C','A.country=C.countryId','left');
	 	$this->db->join('State S','A.state=S.stateId','left');
	 	$this->db->join('AllergistSurvey ASY','ASY.allergistId=A.allergistId','left');
	 	$this->db->group_by("ASY.allergistid");
	 	$query = $this->db->get();
	 	
	 	if($opt == 'record'){
	 		return $query->result_array();	 
	 	}else{
	 		return $query->num_rows();
	 	}
	}  
	
	function restaurant($options=array(),$opt='record')
   {
   	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	
	 	if(isset($options['key']) && $options['key']!='') 	{
	 		$this->db->like('A.accountFirstName',$options['key']);
	 		$this->db->or_like('A.accountLastName',$options['key']);
	 	}
	   if(isset($options['first']) && $options['first']!='') 	{
	 		$this->db->where("date_format(L.timeIn,'%Y-%m-%d')>=",$options['first']);
	 	}
	   if(isset($options['last']) && $options['last']!='') 	{
	 		$this->db->where("date_format(L.timeIn,'%Y-%m-%d')<=",$options['last']);
	 	}
	 
	 	$this->db->select('L.*,A.accountFirstName,A.accountLastName');
	 	$this->db->from('LoginLog L');
	 	$this->db->join('Account A','A.accountId=L.accountId','left');
	 	$this->db->order_by('loginLogId','desc');
	 	$query = $this->db->get();
	 	//debug_last_query();
	 	if($opt == 'record'){
	 		return $query->result_array();	 
	 	}else{
	 		return $query->num_rows();
	 	}
	}  
}