<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
	
	function __construct() {
        parent::__construct();
          error_reporting(E_ALL);
	       $this->load->library('form_validation');
		    $this->load->library('session');
		    $this->load->helper('cookie');
		    $this->load->model('common_model');
          $this->data = array(
            'template' => 'template',
            'controller' => $this->router->fetch_class(),
            'method' => $this->router->fetch_method()
			   /*'user_id' => isset($this->session->userdata['user_id']) ? $this->session->userdata['user_id'] : 0,
            'user_role' => isset($this->session->userdata['user_role']) ? $this->session->userdata['user_role'] : 0,*/
          );
     }
   
    public function allergists()
    {
     	  if(!$this->session->userdata('isLogin'))
		   redirect('login');
	     if($this->session->userdata('account_role') == '1')
		   redirect('admin');
		  $data = array('title' => 'VAert - Allergist', 'page' => 'client/viewAllergist', 'errorCls' => NULL,'page_params' => NULL);
	  	  $config = array();
	  	  $options = array();
	     $config["base_url"] = base_url()."search/allergists";
	     $config['first_url'] = base_url()."search/allergists";
	     $config["suffix"] ="?q=".@$_GET['q'];
		  $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		  $config["per_page"] = 5;
	     $config["uri_segment"] = 3;
		  $config["total_rows"] = "";
		  $options['limit'] = $config["per_page"];  
		  $options['offset'] = $page;  
		  $data["feedback"] = "";
		  $data['offset'] = $page; 
		  //$this->pagination->initialize($config);
	     //$data["links"] = $this->pagination->create_links();
	     //var_dump($data['feedback']);
	     $data = $data + $this->data;
	     $this->load->view($data['template'],$data);
    }
 }