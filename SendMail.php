<?php
header('Access-Control-Allow-Origin: *');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require_once '/home/student/vendor/autoload.php';

$mail = new PHPMailer(true);
 
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'witsfreelancing@gmail.com';   //username
    $mail->Password = 'WitsFreelancing1!';   //password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;                    //smtp port
  
    $mail->setFrom('mulisa.r0998@gmail.com', 'FROM_NAME');
    $mail->addAddress('mulisa0998@gmail.com', 'RECEPIENT_NAME');
 
    $mail->isHTML(true);
    $mail->Subject = 'Email Subject';
    $mail->Body    = '<b>It works</b>';
 
    $mail->send();
    echo 'Message has been sent';
} 
catch (Exception $e) {
  echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
}
/*$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port     = 587;  
$mail->Username = "mulisa.r0998@gmail.com";
$mail->Password = "sh12!asv";
$mail->Host     = "smtp.gmail.com";
$mail->Mailer   = "smtp";
$mail->SetFrom("Your from email", "from name");
$mail->AddReplyTo("from email", "PHPPot");
$mail->AddAddress("1627982@students.wits.ac.za");
$mail->Subject = "Test email using PHP mailer";
$mail->WordWrap   = 80;
$content = "<b>This is a test email using PHP mailer class.</b>"; 
$mail->MsgHTML($content);
$mail->IsHTML(true);
if(!$mail->Send()) echo "Problem sending email.";
else echo "email sent.";*/

/*$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'mulisa.r0998@gmail.com';   //username
$mail->Password = 'sh12!asv';   //password
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;   

$mail->setFrom('FROM_EMAIL_ADDRESS', 'FROM_NAME');
$mail->addAddress('1627982@students.wits.ac.za', 'RECEPIENT_NAME');
 
$mail->isHTML(true);
 
$mail->Subject = 'Email subject';
$mail->Body    = '<b>Email Body</b>';
 
$mail->send();
echo 'Message has been sent';*/
