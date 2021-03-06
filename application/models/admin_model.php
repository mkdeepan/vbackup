<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
     }

 function get_roles()
  {
  	$this->db->select('*');
  	$query = $this->db->get('Role');
  	return $query->result_array();
  }
 function get_pages()
  {
  	$this->db->select('*');
  	$query = $this->db->get('Pages');
  	return $query->result_array();
  }

 function get_access()
  {
   $this->db->select('*');
   $query = $this->db->get('RoleAccess');
   return $query->result_array();
  }

 function fetch_feedback($options = array(),$opt='record')
  {
 	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	    	
 	$this->db->select('F.*,A.accountFirstName,A.accountLastName');
 	$this->db->from('Feedback F');
 	$this->db->join('Account A','A.accountId=F.accountId','left');
 	$this->db->order_by('feedbackId','desc');
 	$query = $this->db->get();
 	//debug_last_query();
 	if($opt == 'record'){
 		return $query->result_array();	 
 	}else{
 		return $query->num_rows();
 	}
  }
  
 function fetch_tag($options = array(),$opt='record')
  {
 	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	   
 	$this->db->select('TL.*,TY.tagTypeDescription'); 	
 	$this->db->from('TagList TL');
 	$this->db->join('TagType TY','TL.tagTypeId=TY.tagTypeId');
 	$query = $this->db->get();
 	//debug_last_query();
 	if($opt == 'record'){
 		return $query->result_array();	 
 	}else{
 		return $query->num_rows();
 	}
  }


  
  function login_report($options = array(),$opt='record')
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
  
  function location_report($options = array(),$opt='record')
  {
 	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	
 	if(isset($options['key']) && $options['key']!='') 	{
 		$this->db->like('A.accountFirstName',$options['key']);
 		$this->db->or_like('A.accountLastName',$options['key']);
 	}
   if(isset($options['first']) && $options['first']!='') 	{
 		$this->db->where("date_format(L.scannedTime,'%Y-%m-%d')>=",$options['first']);
 	}
   if(isset($options['last']) && $options['last']!='') 	{
 		$this->db->where("date_format(L.scannedTime,'%Y-%m-%d')<=",$options['last']);
 	}
 	
 	$this->db->select('L.*,A.accountFirstName,A.accountLastName');
 	$this->db->from('LocationLog L');
 	//$this->db->join('LocationLogList LL','LL.locationLogId=L.locationLogId','left');
 	$this->db->join('Account A','A.accountId=L.accountId','left');
 	$this->db->order_by('locationLogId','desc');
 	$query = $this->db->get();
 	//debug_last_query();
 	if($opt == 'record'){
 		return $query->result_array();	 
 	}else{
 		return $query->num_rows();
 	}
  }
  
  function getProfileByLocation($id)
  {
  	$this->db->select('P.profileFirstName,P.profileLastName,LL.tagId');
  	$this->db->from('Profile P');
  	$this->db->join('ProfileTagMapping PTM','PTM.profileId=P.profileId');
  	$this->db->join('LocationLogList LL','LL.tagId=PTM.tagId','right');
  	$this->db->where('LL.locationLogId',$id);
  	$query = $this->db->get();
  	//debug_last_query();
  	return $query->result_array();
  }
  
  function activity_log($options = array(),$opt='record')
  {
  	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	
 	if(isset($options['key']) && $options['key']!='') 	{
 		$this->db->like('A.accountFirstName',$options['key']);
 		$this->db->or_like('A.accountLastName',$options['key']);
 	}
   if(isset($options['first']) && $options['first']!='') 	{
 		$this->db->where("date_format(AL.activityTime,'%Y-%m-%d')>=",$options['first']);
 	}
   if(isset($options['last']) && $options['last']!='') 	{
 		$this->db->where("date_format(AL.activityTime,'%Y-%m-%d')<=",$options['last']);
 	}
 	    	
 	$this->db->select('AL.*,A.accountFirstName,A.accountLastName');
 	$this->db->from('ActivityLog AL');
 	$this->db->join('Account A','A.accountId=AL.accountId','left');
 	$this->db->order_by('activityTime','desc');
 	$query = $this->db->get();
 	//debug_last_query();
 	if($opt == 'record'){
 		return $query->result_array();	 
 	}else{
 		return $query->num_rows();
 	}
  }
  
  function master($options = array(),$opt='record')
  {
  	if(isset($options['offset']) && isset($options['limit']))
 	   $this->db->limit($options['limit'],$options['offset']);
 	
 	if(isset($options['key']) && $options['key']!='') 	{
 	  foreach($options['like'] as $key=>$like){
 	  	if(!$key)
 		  $this->db->like($like,$options['key']);
 	     $this->db->or_like($like,$options['key']);
 	  }
 	}
  	    	
 	$this->db->select('*');
 	$this->db->from($options['table']);
 	$query = $this->db->get();
 	//debug_last_query();
 	if($opt == 'record'){
 		return $query->result_array();	 
 	}else{
 		return $query->num_rows();
 	}
  }

  function getIngredientName($id)
  {
    $name='';
    $this->db->select('ingredientName');
    $this->db->where('ingredientId',$id);
    $query= $this->db->get('Ingredients');
    foreach($query->result_array() as $row)
    {
      $name = $row['ingredientName'];
    }
    return $name;
  }

  function fetch_ingredients($options = array(),$opt='record')
  {
  if(isset($options['offset']) && isset($options['limit']))
     $this->db->limit($options['limit'],$options['offset']);
     
  $this->db->select('*');  
  $this->db->from('Ingredients');
  $query = $this->db->get();
  //debug_last_query();
  if($opt == 'record'){
    return $query->result_array();   
  }else{
    return $query->num_rows();
  }
  }
  function fetch_food($options = array(),$opt='record')
  {
  if(isset($options['offset']) && isset($options['limit']))
     $this->db->limit($options['limit'],$options['offset']);
     
  $this->db->select('*');  
  $this->db->from('FoodDetail');
  $query = $this->db->get();
  //debug_last_query();
  if($opt == 'record'){
    return $query->result_array();   
  }else{
    return $query->num_rows();
  }
  }

}

