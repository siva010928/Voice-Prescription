<?php  
session_start();
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;
require '/home/sivaprakash/voice_prescription/Exception.php';
require '/home/sivaprakash/voice_prescription/PHPMailer.php';
require '/home/sivaprakash/voice_prescription/SMTP.php';
require_once 'pdo.php';
if (isset($_POST['submit'])) {
	$stmt=$pdo->prepare('SELECT * FROM admins WHERE user_name=:user_name');
	$stmt->execute(array(
		':user_name'=>$_POST['user_name']
	));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$_SESSION['v_code']=uniqid('',true);
	$_SESSION['first_name']=$_POST['first_name'];
	$_SESSION['last_name']=$_POST['last_name'];
	$_SESSION['email']=$_POST['email'];
	$_SESSION['user_name']=$_POST['user_name'];
	$_SESSION['password']=$_POST['password'];
	$_SESSION['doctor_id']=$_POST['doctor_id'];
	$_SESSION['phone_no']=$_POST['phone_no'];
	$_SESSION['hospital_name']=$_POST['hospital_name'];
	$_SESSION['locality']=$_POST['locality'];
	$_SESSION['gender']=$_POST['gender'];
	if ($row===false) {
		$password_check=$_POST['password'];
		$uppercase = preg_match('@[A-Z]@', $password_check);
		$lowercase = preg_match('@[a-z]@', $password_check);
		$number    = preg_match('@[0-9]@', $password_check);
		$specialChars = preg_match('@[^\w]@', $password_check);
		$specialChars = preg_match('@[^\w]@', $password_check);
		if(!$uppercase || !$lowercase || !$number ||  !$specialChars || strlen($password_check) < 8) {
   	 		$_SESSION['signup_err']='Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
			header('Location:signup.php');
			return;
		}
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
			$mail->addAddress($_POST['email'], $_POST['first_name']); 
			$mail->isHTML(true);								 
			$mail->Subject = 'Voice Prescription';			//Sets the Subject of the message
			$mail->Body = "<p>Your verification code is:"."\n<h1>".$_SESSION['v_code']."</h1></p>";
			$mail->AltBody = 'Body in plain text for non-HTML mail clients'; 
			$mail->send(); 
			echo "Mail has been sent successfully!"; 
			header('Location:confirmation.php');
			$_SESSION['signup_succ']='Verification Email has been sent to your mail';
			return;
		} catch (Exception $e) { 
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
		} 

	}
	else{
		header('Location:signup.php');
		$_SESSION['signup_err']='account already exists go to login page';
		return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>signup</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
  	<link rel="stylesheet" type="text/css" href="css/signup.css">
</head>
<body style="background:linear-gradient(rgba(255,255,255,.4),rgba(255,255,255,.4)),url('new.jpg') no-repeat center center;">
	<?php  
	if (isset($_SESSION['signup_err'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'>".$_SESSION['signup_err']."<h2/>";
		unset($_SESSION['signup_err']);
	}
	?>
	<div class="wrapper">
    	<div class="title">
      		Registration
    	</div>
    	<div class="form">
    		<form method="post">
       			<div class="inputfield">
          			<label>First Name</label>
          			<input type="text" required name="first_name" class="input">
       			</div>  
        		<div class="inputfield">
          			<label>Last Name</label>
          			<input type="text" required name="last_name" class="input">
       			</div>    
      			<div class="inputfield">
          			<label>Your's Id</label>
          			<input type="text" required name="doctor_id" class="input">
       			</div> 
        		<div class="inputfield">
          			<label>Gender</label>
          			<div class="custom_select">
            			<select name="gender" required>
              				<option value="">Select</option>
              				<option value="male">Male</option>
              				<option value="female">Female</option>
            			</select>
          			</div>
       			</div> 
        		<div class="inputfield">
          			<label>Email Address</label>
          			<input type="text" required name="email" class="input">
      			</div> 
      			<div class="inputfield">
          			<label>Phone Number</label>
          			<input type="text"  required name="phone_no" class="input">
       			</div>
       			<div class="inputfield">
          			<label>Hospital Name</label>
          			<textarea class="textarea" required  name="hospital_name"></textarea>
       			</div>  
      			<div class="inputfield">
          			<label>Hospital Address</label>
          			<textarea class="textarea" required  name="locality"></textarea>
       			</div> 
       			<div class="inputfield">
          			<label>user name</label>
          			<input type="text"  required name="user_name" class="input">
       			</div>
       			<div class="inputfield">
          			<label>Password</label>
          			<input type="password" required  name="password" class="input">
       			</div>
      			<div class="inputfield">
        			<input type="submit" value="Register" name="submit" id="valuecolor1" class="btn">
        			<input type="button" value="cancel" onclick="redirecttoindex();return false;" id="valuecolor2" class="btn">
      			</div>
      		</form>
    	</div>
	</div>	
	<script type="text/javascript">
		function redirecttoindex() {
		window.location.href="index.php"
	}
	document.getElementById('valuecolor1').style.color="black";
	document.getElementById('valuecolor2').style.color="black";
	</script>
</body>
</html>
