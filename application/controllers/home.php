<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
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

   public function index()
	{
		if($this->session->userdata('isLogin'))
		redirect('user');
		$data = array('title' => 'vAlert-Home', 'page' => '', 'errorCls' => NULL,'page_params' => NULL);
    
      $data = $data + $this->data;
      $this->load->view('client/landingPage',$data);
   }
	
   public function tips()
   {
     $data = array('title' => 'Tips', 'page' => 'client/tips', 'errorCls' => NULL,'page_params' => NULL);
     $data['tips'] = $this->common_model->select_from('Tips');
    
     $data = $data + $this->data;
     $this->load->view($data['template'],$data);
   }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
