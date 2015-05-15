<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('cookie');
     }
   
   function insert_db($table='',$values = array(),$where = array())
   {
   	if(!empty($where))
   	  $this->db->where($where);
   	  
   	if(!empty($values))
   	  $result = $this->db->insert($table,$values);
   	 
   	if($result)
   	  return $this->db->insert_id();
   	 else 
   	  return false;
   }
   
   function insert_batch_rec($table='',$values = array(),$where=array())
   { 	
   
   	if(!empty($where))
   	  $this->db->where($where);
   	  
   	if(!empty($values))
   	  $result = $this->db->insert_batch($table,$values);
   	 // debug_last_query();
   	if($result)
   	  return true;
   	 else 
   	  return false;
   }
   
   function select_from($table='',$select = array(),$where =array())
   {
   	if(!empty($select))
   	  $this->db->select($select);
   	
   	if(!empty($where))
   	  $this->db->where($where);
   	  
   	$result = $this->db->get($table);
   	//debug_last_query();
   	return $result->result_array();
   }
   
   function update_data($table='',$values = array(),$where = array())
   {
   	if(!empty($where))
   	  $this->db->where($where);
   	  
   	$result = $this->db->update($table, $values); 
   	//debug_last_query();
   	if($result){
   		return true;
   	}else{
   		return false;
   	}
   }
   
   function delete_from($table='',$where=array())
   {
   	if(!empty($where))
   	  $this->db->where($where);
   	  
   	$result = $this->db->delete($table); 
   
   	if($result){
   		return true;
   	}else{
   		return false;
   	}
   }
   
   function custom_query($sql='')
   {
   	if($sql !=''){
   		$res = $this->db->query($sql);
   		return $res->result_array();
   	}else{
   		return false;
   	}
      
   }
   
   function getProfileById($id)
   {
    if($id)
    {	
   	$this->db->select('profileFirstName,profileLastName');
   	$this->db->where('profileId',$id);
   	$query = $this->db->get('Profile');
   	if($query->num_rows() > 0)
   	{
   	  $res = $query->result_array();
   	  return $res[0]['profileFirstName'].' '.$res[0]['profileLastName'];
      }
      else
      {
      	return '';
      }
    }
    else
    {
    	return '';
    }
   }
     
  }
