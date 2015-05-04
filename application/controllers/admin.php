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
     $config["suffix"] ="";
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
     $config["base_url"] = base_url()."admin/loginReport";
     $config['first_url'] = base_url()."admin/loginReport";
     $config["suffix"] ="";
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
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
     $config["base_url"] = base_url()."admin/activityLog";
     $config['first_url'] = base_url()."admin/activityLog";
     $config["suffix"] ="";
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
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
     $config["base_url"] = base_url()."admin/locationLog";
     $config['first_url'] = base_url()."admin/locationLog";
     $config["suffix"] ="";
	  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
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
   
}
?>
