<?php 
require_once 'pdo.php'; 
session_start();
// if (!isset($_SESSION['v_code'])) {
// 	die('Access denied');
// }
if (isset($_POST['submit'])) {
		if ($_SESSION['v_code']==$_POST['v_code']) {
			$password_check=$_POST['new_password'];
			$uppercase = preg_match('@[A-Z]@', $password_check);
			$lowercase = preg_match('@[a-z]@', $password_check);
			$number    = preg_match('@[0-9]@', $password_check);
			$specialChars = preg_match('@[^\w]@', $password_check);
			$specialChars = preg_match('@[^\w]@', $password_check);
			if(!$uppercase || !$lowercase || !$number ||  !$specialChars || strlen($password_check) < 8) {
   	 			$_SESSION['forgotpass_fail']='Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
				header('Location:forgotpass.php');
				return;
			}
			$stmt=$pdo->prepare('UPDATE admins SET password=:password WHERE user_name=:user_name');
			$stmt->execute(array(
				':user_name'=>$_SESSION['user_name'],
				'password'=>md5($_POST['new_password'])
			));
			$_SESSION['forgotpass_succ']='Password has been updated';
			header('Location:index.php');
			return;
		}
		else{
			$_SESSION['forgotpass_succ']='Password has been updated';
			header('Location:index.php');
			return;
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
	if (isset($_SESSION['forgotpass_fail'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'><i>".$_SESSION['forgotpass_fail']."</i><h2/>";
		unset($_SESSION['forgotpass_fail']);
	}
	?>
	<div class="wrapper">
    	<div class="title">
      		Registration
    	</div>
    	<div class="form" enctype="multipart/form-data">
    		<form method="post">
        		<div class="inputfield">
          			<label>Verification code:</label>
          			<input type="password" required name="v_code" class="input">
       			</div>    
      			<div class="inputfield">
          			<label>New password:</label>
          			<input type="password" required name="new_password" class="input">
       			</div> 
        		
      			<div class="inputfield">
        			<input type="submit" value="Reset" name="submit" id="valuecolor1" class="btn">
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