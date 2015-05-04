<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {
	
	function __construct() {
        parent::__construct();
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
  
   function index()
   {
     $data = array('title' => 'Feedback', 'page' => 'client/feedback', 'errorCls' => NULL,'page_params' => NULL);
     if($this->input->post('feed_submit'))
     {
     	 if($this->session->userdata('isLogin')){
     	 	$accountId = $this->session->userdata('account_id');
     	 }else{
     	 	$accountId = '0';
     	 }  
     	    
          $feedback_details = array(
                            'accountId' => $accountId,
                            'rating' => $_POST['rating'],
                            'category' => $_POST['category'],
                            'comments' => $_POST['comments']
                           );
          $rs = $this->common_model->insert_db('Feedback',$feedback_details);
          if($rs){
          	$this->session->set_flashdata('success','Feedback submitted successfully.');
          }else{
          	$this->session->set_flashdata('failure','Feedback submission failed.');
          }
       redirect('feedback');
     }    
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
   }
}