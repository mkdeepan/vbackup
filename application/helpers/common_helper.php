<?php
   function profile_verify($aid = NULL,$pid = NULL)
   {
   	$CI =& get_instance();
   	$CI->db->select('*');
   	$where = array(
   	           'profileId' => $pid,
   	           'accountId' => $aid
   	         );
   	$CI->db->where($where);
   	$query = $CI->db->get('Profile');
   	if($result = $query->num_rows() > 0)
   	{
   		return true;
   	}
      else
      {
      	return false;
      } 	   	
   }

   function empty_image()
   {
   	$image = base_url().'uploads/noimage/no-image.png';
   	return $image;
   }

   function empty_logo()
   {
   	$image = base_url().'uploads/noimage/no-logo.png';
   	return $image;
   }

   function read_access($account_id)
   {
   	$CI =& get_instance();
   	$CI->db->select('userRole');
   	$where = array(
   	           'accountId' => $account_id
   	         );
   	$CI->db->where($where);
   	$query = $CI->db->get('Account');
   	$role_id = $query->result_array();
   	$id = $role_id[0]['userRole'];
   	$CI->db->select('readAcccess');
   	$where = array(
   	           'roleId' => $id
   	         );
   	$CI->db->where($where);
   	$query1 = $CI->db->get('RoleAccess');
   	$result = $query1->result_array();
   	return unserialize($result[0]['readAcccess']);
   }
   
   function write_access($account_id)
   {
   	$CI =& get_instance();
   	$CI->db->select('R.writeAccess');
   	$CI->db->from('Account A');
   	$CI->db->join('RoleAccess R','A.userRole = R.roleId');
   	$CI->db->where('A.accountId',$account_id);
   	$query = $CI->db->get();
   	$result = $query->result_array();
   	return unserialize($result[0]['writeAccess']);
   	
   }
   
	function sendMail($from=NULL,$to=NULL,$mailContant=NULL,$attach = NULL,$ccEmail = NULL)
	{
		     /* $ci = &get_instance();
		      echo $from;
		      echo $to;
            var_dump($mailContant); 
            $messageSubject = $mailContant['subject'];
            $messageBody = $mailContant['body'];
            $ci->load->library('email');
            $ci->email->set_mailtype('html');
            $ci->email->from('support@sbap.ca', 'SBAP');
            $ci->email->to($to);
            
            // $link = site_url("user/pass_reset/".$token);
            
            $ci->email->subject($messageSubject);
            $ci->email->message($messageBody);
          
            echo $messageBody; exit;
            if($ci->email->send())
            {
            	echo 'success'; exit;
            	return true; 
            }
            else
            {
            	
            	$ci->email->print_debugger();
            	echo 'fail'; exit;
                return false;
            }*/
        
           $ci = &get_instance();
          
            $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'deepan.kalyan@vebinary.com',
                    'smtp_pass' => 'praiselord@123',
                    'mailtype' => 'html',
                    'charset'  => 'utf-8',
                    'priority' => '1'
                );
            $messageSubject = $mailContant['subject'];
            $messageBody = $mailContant['body'];
            $ci->load->library('email', $config); 
            $ci->email->set_newline("\r\n");   
            $ci->email->from($from, 'vAlert');
            $ci->email->to($to);  
            //$ci->email->bcc('mkdeepan@gmail.com','Deepan');
            if(!empty($attach))
            {
               foreach($attach as $key => $value):
                  $ci->email->attach($value);
               endforeach;
            }
            $ci->email->subject($messageSubject);       
            $ci->email->message($messageBody);
            /*echo 'body '.$messageBody; 
            echo 'true '.$to; */
            if($ci->email->send())
            {
            	
               $ci->session->set_flashdata('success_msg','Mail sent Successfully'); 
               return true;
            }
            else
            {
               echo $ci->email->print_debugger();
               return false;
            }

           
	}

   
?>
