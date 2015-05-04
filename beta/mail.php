<?php
function sendMail($from,$to,$mailContant,$attachment,$cc)
   { 
     require_once('lib/class.phpmailer.php');
     require_once('lib/class.smtp.php');
     $mail             = new PHPMailer();
    // $body            = "To view the message, please use an HTML compatible email viewer!";
     $mail->IsSMTP(); 
     //$mail->SMTPSecure = "ssl";
     $mail->Host       = "ssl://smtp.gmail.com"; 
     $mail->SMTPAuth   = true;     
     $mail->Port       = 465; 
     $mail->Username   = "deepan.kalyan@vebinary.com";     // SMTP account username
     $mail->Password   = "praiselord@123";        // SMTP account password 
     $mail->setFrom('admin@vebinary.com',$from);
     $mail->Subject = $mailContant['subject'];
     $mail->MsgHTML($mailContant['body']);
     if($attachment!='')
       $mail->AddAttachment($attachment);
     if($cc!='')
       $mail->Cc($cc);
     $mail->AddAddress($to);
     $mail->SMTPDebug = 1;
     $res = $mail->Send();
     if($res){
     	return true;
     }else{
     	return false;
     }
   }
?>
