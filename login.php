<?php  
session_start();
require_once 'pdo.php';
if (isset($_POST['submit'])) {
	header('Location:voice_pres.php');
	return;
	$stmt=$pdo->prepare('SELECT * FROM admins WHERE user_name=:user_name AND password=:password');
	$stmt->execute(array(
		':user_name'=>$_POST['user_name'],
		':password'=>md5($_POST['password'])
	));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if ($row===false) {
		$_SESSION['login_err']="incorrect user_name or password";
		header('Location:login.php');
		return;
	}
	else{
		$_SESSION['admin_id']=$row['admin_id'];
		$_SESSION['login_succ']="successfully logged in";
		header('Location:voice_pres.php');
		return;

	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background:linear-gradient(rgba(255,255,255,.1),rgba(255,255,255,.1)),url('new.jpg') no-repeat center center;">
<?php  
	if (isset($_SESSION['login_err'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'><i>".$_SESSION['login_err']."</i><h2/>";
		unset($_SESSION['login_err']);
	}
?>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form  method="post">
				<img src="img/avatar.svg">
				<h2 class="title">Welcome</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
           		   		<input type="text" required name="user_name" class="input" >
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" required name="password" class="input">
            	   </div>
            	</div>
            	<a href="forgotpass.php" class=" btn-link">Forgot Password?</a>
            	<input type="submit" name="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
