<?php
/**
 * Created by PhpStorm.
 * User: Mulisa
 * Date: 2019/09/05
 * Time: 9:04 AM
 */
header('Access-Control-Allow-Origin: *');
require_once("Constants.php");
require_once("ServerInfo.php");
require_once("SendMail.php");

class NotificationManager{

    private $SM;

    function __construct()
    {
        $this -> SM = new SendMail();
    }

    public function sendNotification($recipientId, $notificationMessage, $notificationTitle){
        $time = date(Constants::TIME_FORMAT);
        $date = date(Constants::DATE_FORMAT);
        $message = "
        <!DOCTYPE html>
<html>
<head>
<style>
html{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}

body{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}

.main{
	width: 300px;
	margin: 0 auto;
	padding: 0;
	text-align: center;
	background-repeat: no-repeat;
	background-size: 800px;
	background-position: right top;
}

.wave{
  text-align: center;
  background: linear-gradient(to bottom, #f0f0f0, #c2c2c2);
  position: relative;
}

.wave::before{
  content: \"\";
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  background-repeat: repeat-x;
  height: 10px;
  background-size: 20px 20px;
  background-image: radial-gradient(circle at 10px -5px, transparent 12px, white 13px);
}

.wave::after{
  content: \"\";
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  background-repeat: repeat-x;
  height: 15px;
  background-size: 40px 20px;
  background-image: radial-gradient(circle at 10px 15px, white 12px, transparent 13px);
}

</style>
</head>
<body>
	<div class=\"main\">
		<div class=\"wave\">
			<p>
				<image src=\"http://1627982.ms.wits.ac.za/~student/wf_logo.png\" alt=\"Wits freelancing logo\" width=\"120\" height=\"120\" style=\"margin-top:40px;\">
			</p>
			<p align=\"right\" style=\"margin-right: 3em; margin-left: 3em; font-size: 14px; font-weight: bold;\">
				<span style=\"float: left\">".$time."</span>
				<span style=\"float: right\">".$date."</span>
			</p>
			<p style=\"margin: 0; padding: 0; \">
				<hr class=\"dotted\"/>
			</p>
		</div>
		<p style=\"margin: 0; padding: 0; \">
			<hr style=\"margin-left:2em; margin-right:2em;\"/>
		</p>
		<p align=\"justify\" style=\"margin-top: 2em; margin-left: 2em; margin-right: 2em;\">".$notificationMessage."</p>
		<p style=\"margin: 0; padding: 0; \">
			<hr style=\"margin-top: 2em; margin-left:2em; margin-right:2em;\"/>
		</p>
		<p align=\"left\" style=\"font-size: 10px; font-weight: bold; margin-top: 1em; margin-left: 2em;\">Wits freelancing</p>
	</div>
</body>
</html>";

        $recipientEmail = $recipientId."@students.wits.ac.za";
        $this -> SM -> sendMail($recipientEmail, $recipientId, $message, $notificationTitle);
    }

    public function sendTransactionNotification($id, $amount, $newAmount, $message) {

    }

    public function sendReceipt($employeeId, $employeeAmount, $transactionFee, $total, $employerId, $jobTitle)
    {

        $time = date(Constants::TIME_FORMAT);
        $date = date(Constants::DATE_FORMAT);
        $innerMessage = "Payment by ".$employerId." for job titled \"".$jobTitle."\"";

        $message = "
            <!DOCTYPE html>
            <html>
<head>
<style>
html{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}

body{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}

.main{
	width: 300px;
	margin: 0 auto;
	padding: 0;
	text-align: center;
	background-repeat: no-repeat;
	background-size: 800px;
	background-position: right top;
}

.wave{
  text-align: center;
  background: linear-gradient(to bottom, #f0f0f0, #c2c2c2);
  position: relative;
}

.wave::before{
  content: \"\";
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  background-repeat: repeat-x;
  height: 10px;
  background-size: 20px 20px;
  background-image: radial-gradient(circle at 10px -5px, transparent 12px, white 13px);
}

.wave::after{
  content: \"\";
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  background-repeat: repeat-x;
  height: 15px;
  background-size: 40px 20px;
  background-image: radial-gradient(circle at 10px 15px, white 12px, transparent 13px);
}

</style>
</head>
<body>
	<div class=\"main\">
		<div class=\"wave\">
			<p>
				<image src=\"http://1627982.ms.wits.ac.za/~student/wf_logo.png\" alt=\"Wits freelancing logo\" width=\"120\" height=\"120\" style=\"margin-top:40px;\">
			</p>
			<p align=\"right\" style=\"margin-right: 3em; margin-left: 3em; font-size: 14px; font-weight: bold;\">
				<span style=\"float: left\">".$time."</span>
				<span style=\"float: right\">".$date."</span>
			</p>
			<p style=\"margin: 0; padding: 0; \">
				<hr class=\"dotted\"/>
			</p>
		</div>
		
		
		
		<p><b><i>Transaction Receipt</i></b></p>
		<p align=\"left\" style=\"margin-left: 3em; margin-right: 3em; font-weight: bold; font-size: 12px;\"><i>Job Payment: R".$employeeAmount."</i><br><i>Transaction Fee: R".$transactionFee."</i><br><i>Total: R".$total."</i></br></p>
		<p style=\"margin: 0; padding: 0; \">
			<hr style=\"margin-left:2em; margin-right:2em;\"/>
		</p>
		<p align=\"justify\" style=\"margin-top: 2em; margin-left: 2em; margin-right: 2em;\">".$innerMessage."</p>
		<p style=\"margin: 0; padding: 0; \">
			<hr style=\"margin-top: 2em; margin-left:2em; margin-right:2em;\"/>
		</p>
		<p align=\"left\" style=\"font-size: 10px; font-weight: bold; margin-top: 1em; margin-left: 2em;\">Wits freelancing</p>
	</div>
</body>
</html>";

        $recipientEmail = $employeeId."@students.wits.ac.za";
        $this -> SM -> sendMail($recipientEmail, $employeeId, $message, "Recipient");
    }


}