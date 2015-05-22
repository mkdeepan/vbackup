<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	function __construct() {
        parent::__construct();
          $this->load->library(array('pagination','form_validation'));
		    $this->load->library('session');
		    $this->load->helper(array('cookie','debug'));
		    $this->load->model('admin_model');
		    $this->load->model('common_model');
          $this->data = array(
            'template' => 'template',
            'controller' => $this->router->fetch_class(),
            'method' => $this->router->fetch_method()
			    );
     }
  function index()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/dashboard', 'errorCls' => NULL,'page_params' => NULL);
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function roles()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/roles_edit', 'errorCls' => NULL,'page_params' => NULL);
  	  $data['roles'] = $this->admin_model->get_roles();
     $data['pages'] = $this->admin_model->get_pages();
     $data['role_access'] = $this->admin_model->get_access();
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function access_save()
  {
    
   $previous_role = array();
    for($i=0; $i<count($_POST['role'])-1;$i++)
    {
       $role = $_POST['role'][$i]; 
       // echo "role-".$role.'<br/>';
       // echo 'previous_role<br/>';
       // var_dump($previous_role);
       if(!empty($previous_role))
       {
        $key = '';
        $key = array_search($role,$previous_role);
       // echo '<br/>key'.$key.'<br/>';
        if($key !== false)
        { 
           $read[$key] = array_unique(array_merge($read[$key],$_POST['read'][$i]));
           $edit[$key] = array_unique(array_merge($read[$key],$_POST['edit'][$i]));
           unset($_POST['read'][$i]);
           unset($_POST['edit'][$i]);

        }
        else
        {
          $read[$i] = $_POST['read'][$i];
          $edit[$i] = $_POST['edit'][$i];
        }
        
       }
       else
        {
          $read[$i] = $_POST['read'][$i];
          $edit[$i] = $_POST['edit'][$i];
        }
      $previous_role[$i] = $_POST['role'][$i];
      // echo "<br/>read-".$i.'<br/>';
      // var_dump($read);
      // echo "<br/>edit-".$i.'<br/>';
      // var_dump($edit);       
    }
   // var_dump($read);
   // var_dump($edit);
    $unique_role = array_unique($_POST['role']);
    for($i=0;$i<count($unique_role)-1;$i++)
    {
      $role = $unique_role[$i];
      $readA[$i] = serialize($read[$i]);
      $editA[$i] = serialize($edit[$i]);

      $data = array(
             'roleId' => $role,
             'readAcccess' => $readA[$i],
             'writeAccess' => $editA[$i]
         );
      
      if($_POST['access_id'][$i] == '')
      {
         $id = $this->common_model->insert_db('RoleAccess',$data);
      }
      else
      {
        $where = array('accessId'=>$_POST['access_id'][$i]);
        $id = $this->common_model->update_data('RoleAccess',$data,$where);
      }
    }
   
    if($id)
    {
        $this->session->set_flashdata('success', "Role Access Permission Saved Successfully");
        redirect('admin/roles');
    }
    else
    {
        $this->session->set_flashdata('failure', "Failed to save permission detail! Please try again");
        redirect('admin/roles');
    }
  }
  
  function tips()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
    $id = '';
  	 
     if(isset($_POST['save']))
      {
        $data = array(
          'atHome' => $_POST['athome'],
          'atSchool' => $_POST['atschool']
        );
        if($_POST['tips_id'] != '')
        {
           $where = array('tipId'=> $_POST['tips_id']);
           $id = $this->common_model->update_data('Tips',$data,$where);
        }
        else
        {
           $id = $this->common_model->insert_db('Tips',$data);
        }
    
      if($id)
      {
        $this->session->set_flashdata('success', "Tips Saved Successfully");
       
      }
      else
      {
        $this->session->set_flashdata('failure', "Failed to save tips detail! Please try again");     
      }
     }
      
     $data = array('title' => 'Tips', 'page' => 'admin/tips', 'errorCls' => NULL,'page_params' => NULL);
     $data['tips'] = $this->common_model->select_from('Tips');
    
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  } 

  function feedback()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/feedback', 'errorCls' => NULL,'page_params' => NULL);
  	  $config = array();
  	  $options = array();
     $config["base_url"] = base_url()."admin/feedback";
     $config['first_url'] = base_url()."admin/feedback";
     $config["suffix"] ="?q=".@$_GET['q'];
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	  $config["per_page"] = 5;
     $config["uri_segment"] = 3;
	  $config["total_rows"] = $this->admin_model->fetch_feedback($options,'count');
	  $options['limit'] = $config["per_page"];  
	  $options['offset'] = $page;  
	  $data["feedback"] = $this->admin_model->fetch_feedback($options,'record');
	  $data['offset'] = $page; 
	  $this->pagination->initialize($config);
     $data["links"] = $this->pagination->create_links();
     //var_dump($data['feedback']);
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function loginReport()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin - Log', 'page' => 'admin/loginReport', 'errorCls' => NULL,'page_params' => NULL);
  	  $config = array();
  	  $options = array();
  	  $q = '';$f = '';$l = '';
  	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  	  if(isset($_GET) && isset($_GET['qsearch']))
  	  {
  	  	 $page = 0;
  	  }
  	  if(isset($_GET) && isset($_GET['q']))
  	  {
  	  	 $q = $_GET['q'];
  	  	 $options['key'] = $q;
  	  }
     if(isset($_GET) && isset($_GET['first']))
  	  {
  	  	 $f = $_GET['first'];
  	  	 $options['first'] = $_GET['first'];  	  	 
  	  }
     if(isset($_GET) && isset($_GET['last']))
  	  {
  	  	 $l = $_GET['last'];
  	  	 $options['last'] = $_GET['last']; 
  	  }
     $config["base_url"] = base_url()."admin/loginReport";
     $config['first_url'] = base_url()."admin/loginReport?q=".$q."&first=".$f."&last=".$l;
     $config["suffix"] = "?q=".$q."&first=".$f."&last=".$l; 
	  $config["per_page"] = 5;
     $config["uri_segment"] = 3;
	  $config["total_rows"] = $this->admin_model->login_report($options,'count');
	  $options['limit'] = $config["per_page"];  
	  $options['offset'] = $page;  
	  $data["log_report"] = $this->admin_model->login_report($options,'record');
	  $data['offset'] = $page; 
	  $this->pagination->initialize($config);
     $data["links"] = $this->pagination->create_links();
     //var_dump($data['log_report']); exit;
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function activityLog()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/activityLog', 'errorCls' => NULL,'page_params' => NULL);
  	  $config = array();
  	  $options = array();
     $q = '';$f = '';$l = '';
  	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  	  if(isset($_GET) && isset($_GET['qsearch']))
  	  {
  	  	 $page = 0;
  	  }
  	  if(isset($_GET) && isset($_GET['q']))
  	  {
  	  	 $q = $_GET['q'];
  	  	 $options['key'] = $q;
  	  }
     if(isset($_GET) && isset($_GET['first']))
  	  {
  	  	 $f = $_GET['first'];
  	  	 $options['first'] = $_GET['first'];  	  	 
  	  }
     if(isset($_GET) && isset($_GET['last']))
  	  {
  	  	 $l = $_GET['last'];
  	  	 $options['last'] = $_GET['last']; 
  	  }
     $config["base_url"] = base_url()."admin/activityLog";
     $config['first_url'] = base_url()."admin/activityLog?q=".$q."&first=".$f."&last=".$l;
     $config["suffix"] = "?q=".$q."&first=".$f."&last=".$l; 
	  $config["per_page"] = 5;
     $config["uri_segment"] = 3;
	  $config["total_rows"] = $this->admin_model->activity_log($options,'count');
	  $options['limit'] = $config["per_page"];  
	  $options['offset'] = $page;  
	  $data["activity_log"] = $this->admin_model->activity_log($options,'record');
	  $data['offset'] = $page; 
	  $this->pagination->initialize($config);
     $data["links"] = $this->pagination->create_links();
     //var_dump($data['activity_log']); exit;
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function locationLog()
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/locationLog', 'errorCls' => NULL,'page_params' => NULL);
  	  $config = array();
  	  $options = array();
     $q = '';$f = '';$l = '';
  	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
  	  if(isset($_GET) && isset($_GET['qsearch']))
  	  {
  	  	 $page = 0;
  	  }
  	  if(isset($_GET) && isset($_GET['q']))
  	  {
  	  	 $q = $_GET['q'];
  	  	 $options['key'] = $q;
  	  }
     if(isset($_GET) && isset($_GET['first']))
  	  {
  	  	 $f = $_GET['first'];
  	  	 $options['first'] = $_GET['first'];  	  	 
  	  }
     if(isset($_GET) && isset($_GET['last']))
  	  {
  	  	 $l = $_GET['last'];
  	  	 $options['last'] = $_GET['last']; 
  	  }
     $config["base_url"] = base_url()."admin/locationLog";
     $config['first_url'] = base_url()."admin/locationLog?q=".$q."&first=".$f."&last=".$l;
     $config["suffix"] = "?q=".$q."&first=".$f."&last=".$l; 
	  $config["per_page"] = 5;
     $config["uri_segment"] = 3;
	  $config["total_rows"] = $this->admin_model->location_report($options,'count');
	  $options['limit'] = $config["per_page"];  
	  $options['offset'] = $page;  
	  $data["location_log"] = $this->admin_model->location_report($options,'record');
	  $data['offset'] = $page; 
	  $this->pagination->initialize($config);
     $data["links"] = $this->pagination->create_links();
     //var_dump($data['location_log']); exit;
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }
  
  function paypalAddon()
   {
   	//var_dump($_REQUEST);//exit;
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin -dashboard', 'page' => 'admin/paypalAddon', 'errorCls' => NULL,'page_params' => NULL);
  	  if($this->input->post('delete_addon'))
  	  {
  	  	 $where = array('addonId' => $this->input->post('del_id'));
  	  	 $res = $this->common_model->delete_from('PaypalAddons',$where);
  	  	 
  	  		if($res){
      	$this->session->set_flashdata('success','Paypal description deleted successfully');
	      }else{
	      	$this->session->set_flashdata('failure','Paypal description deletion failed');
	      }
	    redirect('admin/paypalAddon');
  	  }
  	  if($this->input->post('save_addon'))
  	  {
  	  	
  	  	//var_dump($_POST); exit;
  	  	$addons = array(
  	  	            //'description' => $this->input->post('desc_name'),
  	  	            'amount' => $this->input->post('cost'),
  	  	            'status' => $this->input->post('status')
  	  	          );
  	  	          
  	  	if($this->input->post('addonId'))
  	  	{//update
  	  		$addon_id = array('addonId' => $this->input->post('addonId'));
  	  		//if($addon_id == '4')//discount variable should be minus
  	  		$res = $this->common_model->update_data('PaypalAddons',$addons,$addon_id);
  	  		if($res){
      	$this->session->set_flashdata('success','Paypal description updated successfully');
	      }else{
	      	$this->session->set_flashdata('failure','Paypal description updation failed');
	      }
  	  	}
  	   else
  	   {//add
  	   	$res = $this->common_model->insert_db('PaypalAddons',$addons);
  	   	if($res){
      	$this->session->set_flashdata('success','Paypal description added successfully');
	      }else{
	      	$this->session->set_flashdata('failure','Paypal description adding failed');
	      }
  	   }
      redirect('admin/paypalAddon');
  	  }
  	  $data['payment'] = $this->common_model->select_from('PaypalAddons');
  	  $data = $data + $this->data;
     $this->load->view($data['template'],$data);
   }
   
   public function checkDescription()
    {
   	$description = $this->input->post('description_name');
   	$exist_id = $this->input->post('exist_id');
   	
   	if($exist_id){
   		$where['addonId'] = $exist_id;
   		$sql = "select * from PaypalAddons where description = '".$description."' and addonId != ".$exist_id."";
   	}else{
   		$sql = "select * from PaypalAddons where description = '".$description."'";
   	}
      //var_dump($where); exit;
   	$exist = $this->common_model->custom_query($sql);
   	if(!empty($exist)){
   		echo 'false';
   	}else{
   		echo 'true';
   	}
   
   }
   
   public function tagRegister()
   { 
     //var_dump($_POST); 
     if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $data = array('title' => 'Admin - Tag Register', 'page' => 'admin/tagRegister', 'errorCls' => NULL,'page_params' => NULL);
  	  if($this->input->post('delete_tag'))
  	  {
  	  	 $where = array('tagListId' => $this->input->post('del_id'));
  	  	 $res = $this->common_model->delete_from('TagList',$where);
  	  	 
  	  		if($res){
      	$this->session->set_flashdata('success','Tag deleted successfully');
	      }else{
	      	$this->session->set_flashdata('failure','Tag deletion failed');
	      }
	    redirect('admin/tagRegister');
  	  }
  	  if($this->input->post('save_tag'))
  	  {
  	  	 //var_dump($_POST); exit;
  	  	 if($_FILES['tag_pic']['tmp_name'] !='')   
	      	{
	      	  $datas = $this->do_upload();
	           $pic_name = $datas['upload_data']['file_name'];
	         }
	         else
	         {
	           $pic_name = '';
	         }
	  	  	  
	  	  	  $tagDetails = array(
	  	  	                  'tagTypeId' => $this->input->post('tag_type'),
	  	  	                  'tagDescription' => $this->input->post('tag_desc'),
	  	  	                  'tagCost' => $this->input->post('tag_cost'),
	  	  	                  'tagMAC' => $this->input->post('tag_mac'),
	  	  	                  'tagImage' => $pic_name
	  	  	                );
  	  	 if($this->input->post('tagListId'))
  	  	 {
  	  	 	if(!$pic_name && $this->input->post('old_tag_pic'))
  	  	 	{
  	  	 		$tagDetails['tagImage'] = $this->input->post('old_tag_pic');
  	  	 	}
  	  	 	  $where = array('tagListId'=>$this->input->post('tagListId'));
  	  	 	  $res = $this->common_model->update_data('TagList',$tagDetails,$where);
	  	  	  if($res){
	  	  	  	$this->session->set_flashdata('success','Tag updated successfully');
	  	  	  }else{
	  	  	  	$this->session->set_flashdata('failure','Tag updation failed');
	  	  	  }
  	  	 }
  	    else
  	    {	  	  	 
	  	  	  $res = $this->common_model->insert_db('TagList',$tagDetails);
	  	  	  if($res){
	  	  	  	$this->session->set_flashdata('success','Tag added successfully');
	  	  	  }else{
	  	  	  	$this->session->set_flashdata('failure','Tag creation failed');
	  	  	  }
  	    }
  	    redirect('admin/tagRegister');
  	  }
  	  $config = array();
  	  $options = array();
     $config["base_url"] = base_url()."admin/tagRegister";
     $config['first_url'] = base_url()."admin/tagRegister";
     $config["suffix"] ="";
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	  $config["per_page"] = 5;
     $config["uri_segment"] = 3;
	  $config["total_rows"] = $this->admin_model->fetch_tag($options,'count');
	  $options['limit'] = $config["per_page"];  
	  $options['offset'] = $page;  
	  $data["tagList"] = $this->admin_model->fetch_tag($options,'record');
	  $data['offset'] = $page; 
	  $this->pagination->initialize($config);
     $data["links"] = $this->pagination->create_links();
     $where = array('status'=>'1');
     $data['tagType'] = $this->common_model->select_from('TagType','',$where);
     //var_dump($data['tagType']); exit;
     //var_dump($data['tagList']); exit;
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
   }
   
   function do_upload()
	{		
		$path = "uploads/tags/";
		//echo $path; 
      if(!is_dir($path)) //create the folder if it's not already exists
				    {				      
				      mkdir($path,0777,TRUE);
				      chmod('./uploads/tags', 0777);
					   chmod($path, 0777);
				    } 
		$config['upload_path'] = "./uploads/tags/";
		$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
		
		$this->upload->initialize($config);
		
      if(is_file($config['upload_path']))
          {
             chmod($config['upload_path'], 0777); 
          }
		if ( !$this->upload->do_upload('tag_pic'))
		{
			$this->session->set_flashdata('failure',$this->upload->display_errors());
			return false;
	   }
		else
		{
				if(file_exists("./uploads/tags/".$_POST['old_tag_pic']))
				{			
				   chmod("./uploads/tags/".$_POST['old_tag_pic'],0777);		
					unlink("./uploads/tags/".$_POST['old_tag_pic']);
				}
				$datas = array('upload_data' => $this->upload->data());
				chmod($path.'/'.$datas['upload_data']['file_name'],0777);
				return $datas;
			
		}
	}
  function update($option='allergyname')
  {
  	switch($option){
  		case 'allergyname':
  		   $values = array('allergyNameDescription'=>$this->input->post('desc'));
  		   $where = array('allergyNameId'=>$this->input->post('cid'));
  		   $res = $this->common_model->update_data('AllergyName',$values,$where);
  		   if($res){
  		      return 'true';
  		   }else{
  		   	return 'false';
  		   }
  	      break;
  	   case 'allergytype':
  		   $values = array('allergyTypeDescription'=>$this->input->post('desc'));
  		   $where = array('allergyTypeId'=>$this->input->post('cid'));
  		   $res = $this->common_model->update_data('AllergyType',$values,$where);
  		   if($res){
  		      return 'true';
  		   }else{
  		   	return 'false';
  		   }
  	      break;
  	   case 'severe':
  		   $values = array('symtomSevereDescription'=>$this->input->post('desc'));
  		   $where = array('symtomSevereId'=>$this->input->post('cid'));
  		   $res = $this->common_model->update_data('SymtomsSevere',$values,$where);
  		   if($res){
  		      return 'true';
  		   }else{
  		   	return 'false';
  		   }
  	      break;
  	   case 'mild':
  		   $values = array('symtomMildDescription'=>$this->input->post('desc'));
  		   $where = array('symtomMildId'=>$this->input->post('cid'));
  		   $res = $this->common_model->update_data('SymtomsMild',$values,$where);
  		   if($res){
  		      return 'true';
  		   }else{
  		   	return 'false';
  		   }
  	      break;
  	   case 'roles':
  		   $values = array('roleName'=>$this->input->post('desc'));
  		   $where = array('roleId'=>$this->input->post('cid'));
  		   $res = $this->common_model->update_data('Role',$values,$where);
  		   if($res){
  		      return 'true';
  		   }else{
  		   	return 'false';
  		   }
  	      break;
  	}
  }
  
  function master($pagename='allergyname',$option='')
  {
  	  if(!$this->session->userdata('isLogin'))
		redirect('login');
	  if($this->session->userdata('account_role') == '2')
		redirect('user');
  	  $config = array();
  	  $options = array();
  	  $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
  	  $q='';
  	  if(isset($_GET) && isset($_GET['q']))
  	  {
  	  	 $q = $_GET['q'];
  	  	 $options['key'] = $q;
  	  }
     $config["base_url"] = base_url()."admin/master/".$pagename;
     $config['first_url'] = base_url()."admin/master/".$pagename."?q=".$q;
     $config["suffix"] = "?q=".$q; 
	  $config["per_page"] = 5;
     $config["uri_segment"] = 4;
     switch($pagename) {
     	case 'allergyname':
		     	if($option=='add'){     		
		     		$values = array('allergyNameDescription'=>$this->input->post('allergy_name_desc'));
		  	   	$res = $this->common_model->insert_db('AllergyName',$values);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Allergy name added successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Allergy name addition failed');
		  	   	}
		  	      redirect('admin/master/allergyname');
		     	}elseif($option == 'delete'){
		     		$where = array('allergyNameId'=>$this->input->post('allergynameid'));
		  	   	$res = $this->common_model->delete_from('AllergyName',$where);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Allergy name deleted successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Allergy name delete failed');
		  	   	}
		  	      redirect('admin/master/allergyname');
		     	}else{
		     	   $data = array('title' => 'Admin - Allergy Name', 'page' => 'admin/allergyName', 'errorCls' => NULL,'page_params' => NULL);
		     	   $options['table'] = 'AllergyName';
		     	   $options['like'] = '';
		     	   $config["total_rows"] = $this->admin_model->master($options,'count');
				   $options['limit'] = $config["per_page"];  
				   $options['offset'] = $page;  
				   $data["result_set"] = $this->admin_model->master($options,'record');
				   $data['offset'] = $page; 
				   $this->pagination->initialize($config);
			      $data["links"] = $this->pagination->create_links();
			      //var_dump($data['log_report']); exit;
			   }
		      break;      
     case 'allergytype':
		     	if($option=='add'){     		
		     		$values = array('allergyTypeDescription'=>$this->input->post('allergy_type_desc'));
		  	   	$res = $this->common_model->insert_db('AllergyType',$values);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Allergy type added successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Allergy type addition failed');
		  	   	}
		  	      redirect('admin/master/allergytype');
		     	}elseif($option == 'delete'){
		     		$where = array('allergyTypeId'=>$this->input->post('allergyTypeId'));
		  	   	$res = $this->common_model->delete_from('AllergyType',$where);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Allergy Type deleted successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Allergy Type delete failed');
		  	   	}
		  	      redirect('admin/master/allergytype');
		     	}else{
		     	   $data = array('title' => 'Admin - Allergy Type', 'page' => 'admin/allergyType', 'errorCls' => NULL,'page_params' => NULL);
		     	   $options['table'] = 'AllergyType';
		     	   $options['like'] = '';
		     	   $config["total_rows"] = $this->admin_model->master($options,'count');
				   $options['limit'] = $config["per_page"];  
				   $options['offset'] = $page;  
				   $data["result_set"] = $this->admin_model->master($options,'record');
				   $data['offset'] = $page; 
				   $this->pagination->initialize($config);
			      $data["links"] = $this->pagination->create_links();
			      //var_dump($data['log_report']); exit;
			   }
		      break;
		  case 'severe':
		     	if($option=='add' && $this->input->post('save_symtomsevere')){     		
		     		$values = array('symtomSevereDescription'=>$this->input->post('symtomsevere'));
		  	   	$res = $this->common_model->insert_db('SymtomsSevere',$values);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Symptoms severe added successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Symptoms severe addition failed');
		  	   	}
		  	      redirect('admin/master/severe');
		     	}elseif($option == 'delete' && $this->input->post('delete_severe')){
		     		$where = array('symtomSevereId'=>$this->input->post('symtomSevereId'));
		  	   	$res = $this->common_model->delete_from('SymtomsSevere',$where);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Symptoms severe deleted successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Symptoms severe delete failed');
		  	   	}
		  	      redirect('admin/master/severe');
		     	}else{
		     	   $data = array('title' => 'Admin - Symptoms', 'page' => 'admin/symptomssevere', 'errorCls' => NULL,'page_params' => NULL);
		     	   $options['table'] = 'SymtomsSevere';
		     	   $options['like'] = '';
		     	   $config["total_rows"] = $this->admin_model->master($options,'count');
				   $options['limit'] = $config["per_page"];  
				   $options['offset'] = $page;  
				   $data["result_set"] = $this->admin_model->master($options,'record');
				   $data['offset'] = $page; 
				   $this->pagination->initialize($config);
			      $data["links"] = $this->pagination->create_links();
			      //var_dump($data['log_report']); exit;
			   }
		      break;
		  case 'mild':
		     	if($option=='add' && $this->input->post('save_symtommild')){     		
		     		$values = array('symtomMildDescription'=>$this->input->post('symtommild'));
		  	   	$res = $this->common_model->insert_db('SymtomsMild',$values);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Symptoms mild added successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Symptoms mild addition failed');
		  	   	}
		  	      redirect('admin/master/mild');
		     	}elseif($option == 'delete' && $this->input->post('delete_mild')){
		     		$where = array('symtomMildId'=>$this->input->post('symtomMildId'));
		  	   	$res = $this->common_model->delete_from('SymtomsMild',$where);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','Symptoms mild deleted successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','Symptoms mild delete failed');
		  	   	}
		  	      redirect('admin/master/mild');
		     	}else{
		     	   $data = array('title' => 'Admin - Symptoms', 'page' => 'admin/symptomsmild', 'errorCls' => NULL,'page_params' => NULL);
		     	   $options['table'] = 'SymtomsMild';
		     	   $options['like'] = '';
		     	   $config["total_rows"] = $this->admin_model->master($options,'count');
				   $options['limit'] = $config["per_page"];  
				   $options['offset'] = $page;  
				   $data["result_set"] = $this->admin_model->master($options,'record');
				   $data['offset'] = $page; 
				   $this->pagination->initialize($config);
			      $data["links"] = $this->pagination->create_links();
			      //var_dump($data['log_report']); exit;
			   }
		      break;
		   case 'roles':
		     	if($option=='add' && $this->input->post('save_roles')){     		
		     		$values = array('roleName'=>$this->input->post('rolename'));
		  	   	$res = $this->common_model->insert_db('Role',$values);
		  	   	if($res){
		  	   		$this->session->set_flashdata('success','New role added successfully');
		  	   	}else{
		  	   		$this->session->set_flashdata('failure','New role addition failed');
		  	   	}
		  	      redirect('admin/master/roles');
		     	}elseif($option == 'delete' && $this->input->post('delete_roles')){
		     		//check for if any user avail with this role
		     		$where = array('userRole'=>$this->input->post('roleId'));
		     		$res = $this->common_model->select_from('Account','',$where);
		     		//var_dump($res); exit;
		     		if(empty($res)){
			     		$where = array('roleId'=>$this->input->post('roleId'));
			  	   	$res = $this->common_model->delete_from('Role',$where);
			  	   	$res = $this->common_model->delete_from('RoleAccess',$where);
			  	   	if($res){
			  	   		$this->session->set_flashdata('success','Role deleted successfully');
			  	   	}else{
			  	   		$this->session->set_flashdata('failure','Role delete failed');
			  	   	}		  	      
		  	      }else{
		  	      	$this->session->set_flashdata('failure','Role cannot be delete.');
		  	      }
		  	      redirect('admin/master/roles');
		     	}else{
		     	   $data = array('title' => 'Admin - Symptoms', 'page' => 'admin/roles', 'errorCls' => NULL,'page_params' => NULL);
		     	   $options['table'] = 'Role';
		     	   $options['like'] = '';
		     	   $config["total_rows"] = $this->admin_model->master($options,'count');
				   $options['limit'] = $config["per_page"];  
				   $options['offset'] = $page;  
				   $data["result_set"] = $this->admin_model->master($options,'record');
				   $data['offset'] = $page; 
				   $this->pagination->initialize($config);
			      $data["links"] = $this->pagination->create_links();
			      //var_dump($data['log_report']); exit;
			   }
		      break;
     }	  
     
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
  }

  function ingredients($action='')
  {
    $data = array('title' => 'Admin - Ingredients', 'page' => 'admin/ingredients', 'errorCls' => NULL,'page_params' => NULL);
    
    switch($action)
    {
      case 'add':
      {
            //var_dump($_POST);
            $ingdata = array();
            foreach($_POST['ingredient'] as $ingre)
            {
            	if($ingre != '')
               $ingdata[] = array('ingredientName' => $ingre);
            }
           // var_dump($ingdata);exit;
            //$datas = array('ingredientName' => $this->input->post('ingredient'));
            $res = '';
            if(!empty($ingdata))
            $res = $this->common_model->insert_batch_rec('Ingredients',$ingdata);
            
            if($res){
              $this->session->set_flashdata('success','Ingredients added successfully');
            }else{
              $this->session->set_flashdata('failure','Ingredient addition failed');
            }
             redirect('admin/ingredients');

      }
      case 'update':
      {
           // var_dump($_POST);exit;
            $datas = array('ingredientName' => $this->input->post('name'));
            $where = array('ingredientId' => $this->input->post('ingid'));
            $res = $this->common_model->update_data('Ingredients',$datas,$where);
            if($res){
              echo 'true';
              exit;
            }else{
              echo 'false';
              exit;
            }
            break;
      }
      case 'delete':
      {
           // var_dump($_POST);exit;
            $where = array('ingredientId' => $this->input->post('delingredientId'));
            $res = $this->common_model->delete_from('Ingredients',$where);
            if($res){
              $this->session->set_flashdata('success','Ingredient deleted successfully');
            }else{
              $this->session->set_flashdata('failure','Ingredient deletion failed');
            }
             redirect('admin/ingredients');
            
      }

    }
    $config = array();
    $options = array();
    $config["base_url"] = base_url()."admin/ingredients";
    $config['first_url'] = base_url()."admin/ingredients";
    $config["suffix"] ="";
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $config["per_page"] = 5;
    $config["uri_segment"] = 3;
    $config["total_rows"] = $this->admin_model->fetch_ingredients($options,'count');
    $options['limit'] = $config["per_page"];  
    $options['offset'] = $page;  
    $data["ingredient"] = $this->admin_model->fetch_ingredients($options,'record');
    $data['offset'] = $page; 
    $this->pagination->initialize($config);
    $data["links"] = $this->pagination->create_links();
   
    $data = $data + $this->data;
    $this->load->view($data['template'],$data);
  }

  function food($action='')
  {
    $data = array('title' => 'Admin - Ingredients', 'page' => 'admin/foods', 'errorCls' => NULL,'page_params' => NULL);
    
    switch($action)
    {
      case 'add':
      {
          // var_dump($_POST);
          if(($this->input->post('ingredients')))
           {
            $datas = array('foodTitle' => $this->input->post('food_title'),
                           'foodIngredient' => implode(',',$this->input->post('ingredients')));
            $res = $this->common_model->insert_db('FoodDetail',$datas);
            if($res){
              $this->session->set_flashdata('success','Food Detail added successfully');
            }else{
              $this->session->set_flashdata('failure','Food Detail addition failed');
            }
           }else{
           	  $this->session->set_flashdata('failure','Please add atleast one ingredient.');
           }
             redirect('admin/food');

      }
      case 'update':
      {
           //var_dump($_POST);exit;
           if(($this->input->post('eingredients')))
           {
            $datas = array('foodTitle' => $this->input->post('efood_title'),
                           'foodIngredient' => implode(',',$this->input->post('eingredients')));
            $where = array('foodId' => $this->input->post('ehidid'));
            $res = $this->common_model->update_data('FoodDetail',$datas,$where);
            if($res){
              $this->session->set_flashdata('success','Food Detail updated successfully');
            }else{
              $this->session->set_flashdata('failure','Food Detail addition failed');
            }
           }else{
           	  $this->session->set_flashdata('failure','Please add atleast one ingredient.');
           }
            
           redirect('admin/food');
      }
      case 'delete':
      {
           // var_dump($_POST);exit;
            $where = array('FoodId' => $this->input->post('delfoodId'));
            $res = $this->common_model->delete_from('FoodDetail',$where);
            if($res){
              $this->session->set_flashdata('success','Food Detail deleted successfully');
            }else{
              $this->session->set_flashdata('failure','Food Detail deletion failed');
            }
             redirect('admin/food');
            
      }

    }
    $data['ingredient'] = $this->common_model->select_from('Ingredients','*');
    $config = array();
    $options = array();
    $config["base_url"] = base_url()."admin/food";
    $config['first_url'] = base_url()."admin/food";
    $config["suffix"] ="";
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $config["per_page"] = 5;
    $config["uri_segment"] = 3;
    $config["total_rows"] = $this->admin_model->fetch_food($options,'count');
    $options['limit'] = $config["per_page"];  
    $options['offset'] = $page;  
    $data["food_detail"] = $this->admin_model->fetch_food($options,'record');
    $data['offset'] = $page; 
    $this->pagination->initialize($config);
    $data["links"] = $this->pagination->create_links();
    $data = $data + $this->data;
    $this->load->view($data['template'],$data);
  }
   
}
?>
