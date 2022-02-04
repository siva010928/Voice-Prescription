<?php  
session_start();
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;
require_once 'pdo.php';
// if (!isset($_SESSION['admin_id'])) {
// 	die('Access Denied');
// }
// $stmt=$pdo->prepare('SELECT * FROM admins WHERE admin_id=:admin_id');
// $stmt->execute(array(
// 	':admin_id'=>$_SESSION['admin_id']
// ));
// $row=$stmt->fetch(PDO::FETCH_ASSOC);
// if ($row===false) {
// 	$_SESSION['signup_err']='No such user name is found';
// 	header('Location:edit.php');
// 	return;
// }
if (isset($_POST['submit'])) {
	$stmt=$pdo->prepare('UPDATE admins SET first_name=:first_name,last_name=:last_name,doctor_id=:doctor_id,gender=:gender,email=:email,phone_no=:phone_no,hospital_name=:hospital_name,locality=:locality,user_name=:user_name WHERE admin_id=:admin_id');
	$stmt->execute(array(
		':first_name'=>$_POST['first_name'],
		':last_name'=>$_POST['last_name'],
		':doctor_id'=>$_POST['doctor_id'],
		':gender'=>$_POST['gender'],
		':email'=>$_POST['email'],
		'phone_no'=>$_POST['phone_no'],
		':hospital_name'=>$_POST['hospital_name'],
		':locality'=>$_POST['locality'],
		':user_name'=>$_POST['user_name'],
		':admin_id'=>$_SESSION['admin_id']
	));
	$_SESSION['update_succ']="Profile successfully updated";
	header('Location:voice_pres.php');
	return;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>update</title>
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
      		Edit profile
    	</div>
    	<div class="form">
    		<form method="post">
       			<div class="inputfield">
          			<label>First Name</label>
          			<input type="text" required name="first_name" value="<?=$row['first_name']?>" class="input">
       			</div>  
        		<div class="inputfield">
          			<label>Last Name</label>
          			<input type="text" required name="last_name" value="<?=$row['last_name']?>" class="input">
       			</div>    
      			<div class="inputfield">
          			<label>Your's Id</label>
          			<input type="text" required name="doctor_id" value="<?=$row['doctor_id']?>" class="input">
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
          			<input type="text" required name="email" value="<?=$row['email']?>" class="input">
      			</div> 
      			<div class="inputfield">
          			<label>Phone Number</label>
          			<input type="text"  required name="phone_no" value="<?=$row['phone_no']?>" class="input">
       			</div>
       			<div class="inputfield">
          			<label>Hospital Name</label>
          			<textarea class="textarea" required   name="hospital_name"><?=$row['hospital_name']?></textarea>
       			</div>  
      			<div class="inputfield">
          			<label>Hospital Address</label>
          			<textarea class="textarea" required   name="locality"><?=$row['locality']?></textarea>
       			</div> 
       			<div class="inputfield">
          			<label>user name</label>
          			<input type="text"  required name="user_name" value="<?=$row['user_name']?>" class="input">
       			</div>
      			<div class="inputfield">
        			<input type="submit" value="update" name="submit" id="valuecolor1" class="btn">
        			<input type="button" value="cancel" onclick="redirecttovoice();return false;" id="valuecolor2" class="btn">
      			</div>
      		</form>
    	</div>
	</div>	
	<<script type="text/javascript">
		function redirecttovoice() {
		window.location.href="voice_pres.php";
	}
	document.getElementById('valuecolor1').style.color="black";
	document.getElementById('valuecolor2').style.color="black";
	</script>
</body>
</html>