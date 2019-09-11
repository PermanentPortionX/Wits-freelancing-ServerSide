<?php
header('Access-Control-Allow-Origin: *');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require_once '/home/student/vendor/autoload.php';



class SendMail{
    private $email;

    function __construct()
    {
        $this -> email  = new PHPMailer(true);
    }

    function sendMail($recipientEmail, $recipientId, $message, $title){
        try {
            $this -> email ->isSMTP();
            $this -> email ->Host = 'smtp.googlemail.com';  //gmail SMTP server
            $this -> email ->SMTPAuth = true;
            $this -> email ->Username = 'witsfreelancing@gmail.com';   //username
            $this -> email ->Password = 'WitsFreelancing1!';   //password
            $this -> email ->SMTPSecure = 'ssl';
            $this -> email ->Port = 465;                    //smtp port

            $this -> email ->setFrom('witsfreelancing@gmail.com', 'Wits Freelancing');
            $this -> email ->addAddress($recipientEmail, $recipientId);

            $this -> email ->isHTML(true);
            $this -> email ->Subject = $title;
            $this -> email ->Body    = $message;

            $this -> email ->send();
            echo 'Message has been sent';
        }
        catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: '. $this -> email ->ErrorInfo;
        }
    }
}
