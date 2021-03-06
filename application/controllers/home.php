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
  
   public function charts()
   {
   	$phone = $this->input->post('phone');
   	$count = $this->input->post('count');
   	$date = $this->input->post('dates');
   	$timestamp = strtotime(date("Y-m-d", strtotime($date)) . " - ".$count." DAY");
      $expired = date('Y-m-d', $timestamp);
   	
   	//$sql = "select timeIn,count(*) as counts from LoginLog where phoneType = '$phone' and DATE_FORMAT(timeIn,'%Y-%m-%d') between date_add( '$date' , interval -$count day) and '$date' group by timeIn between date_add('$date', interval -$count day) and '$date'";
   	$sql = "select DATE_FORMAT(timeIn,'%Y-%m-%d') as timeIn,count(*) as counts from LoginLog where phoneType = '$phone' and DATE_FORMAT(timeIn,'%Y-%m-%d') between '$expired' and '$date' group by timeIn between '$expired' and '$date'";
   	$res = $this->common_model->custom_query($sql);
   	
   	$result = array();
   	$flag = 0;
   	for($i=0;$i<$count;$i++)
   	{
   		$times = strtotime(date("Y-m-d", strtotime($expired)) . "+ ".$i." DAY");
         $start = date('Y-m-d', $times);
   		foreach($res as $dat){
   			if($start == $dat['timeIn']){
   				//echo $start.$dat['timeIn'];
   				//$result[$start] = $dat['counts'];
   				$result[] = $dat['counts'];
   				$flag = 1;
   			}else{
   				$flag = 0;
   				//$result[$start] = '';
   				//$result[] = '';
   			}   		 
   		}   
   		if(!$flag){
   		  	 $result[] = '';
   		}		
   	}
   	//var_dump($result);
   	echo json_encode($result);   	
   }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
