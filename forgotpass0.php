<?php 
require_once 'pdo.php'; 
session_start();
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\PHPMailer\src\Exception.php';
require 'PHPMailer\PHPMailer\src\PHPMailer.php';
require 'PHPMailer\PHPMailer\src\SMTP.php';
if (isset($_POST['submit'])) {
	$stmt=$pdo->prepare('SELECT * FROM admins WHERE user_name=:user_name');
	$stmt->execute(array(
		':user_name'=>$_POST['user_name']
	));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if ($row===false) {
		$_SESSION['forgotpass0_fail']='No such user name is found';
		header('Location:forgotpass0.php');
		return;
	}
	else{
		$_SESSION['v_code']=uniqid('',true);
		$_SESSION['user_name']=$_POST['user_name'];
		$mail = new PHPMailer(true);
		try { 
			$mail->SMTPDebug = 2;									 
			$mail->isSMTP();											 
			$mail->Host	 = 'smtp.gmail.com';					 
			$mail->SMTPAuth = true;							 
			$mail->Username = 'siva010928@gmail.com';				 
			$mail->Password = 'taqwunzgjzzdrnpl';						 
			$mail->SMTPSecure = 'tls';							 
			$mail->Port	 = 587; 
			$mail->setFrom('siva010928@gmail.com', 'Siva');		 
			$mail->addAddress($row['email'], $row['first_name']); 
			$mail->isHTML(true);								 
			$mail->Subject = 'Voice Prescription';			//Sets the Subject of the message
			$mail->Body = "<p>Your verification code is:"."\n<h1>".$_SESSION['v_code']."</h1></p>";
			$mail->AltBody = 'Body in plain text for non-HTML mail clients'; 
			$mail->send(); 
			echo "Mail has been sent successfully!"; 
			header('Location:forgotpass.php');
			$_SESSION['forgotpass_succ_mail']='Verification Email has been sent to your mail';
			return;
		} catch (Exception $e) { 
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
		} 
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>forgot password</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
  	<link rel="stylesheet" type="text/css" href="css/forgotpass.css">
</head>
<body style="background:linear-gradient(rgba(255,255,255,.4),rgba(255,255,255,.4)),url('new.jpg') no-repeat center center;">
	<?php
	if (isset($_SESSION['forgotpass_succ_mail'])) {
		echo "<h2 style='color:green;position:relative;top:10px;left:20px;'><i>".$_SESSION['forgotpass_succ_mail']."</i><h2/>";
		unset($_SESSION['forgotpass_succ_mail']);
	}  
	if (isset($_SESSION['forgotpass0_fail'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'><i>".$_SESSION['forgotpass0_fail']."</i><h2/>";
		unset($_SESSION['forgotpass0_fail']);
	}
	?>
	<div class="wrapper">
    	<div class="title">
      		Registration
    	</div>
    	<div class="form" enctype="multipart/form-data">
    		<form method="post">
       			<div class="inputfield">
          			<label>User name:</label>
          			<input type="text" required name="user_name" class="input">
       			</div>  
        		
      			<div class="inputfield">
        			<input type="submit" value="send code" name="submit" id="valuecolor1" class="btn">
        			<input type="button" value="cancel" onclick="redirecttoindex();return false;" id="valuecolor2" class="btn">
      			</div>
      		</form>
    	</div>
	</div>
	<script type="text/javascript">
		function redirecttoindex() {
		window.location.href="logout.php";
	}
	document.getElementById('valuecolor1').style.color="black";
	document.getElementById('valuecolor2').style.color="black";
	</script>
</body>
</html>