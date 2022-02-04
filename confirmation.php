<?php  
require_once 'pdo.php';
session_start();
// if (!isset($_SESSION['v_code'])) {
// 	die('Access denied');
// }
if (isset($_POST['submit'])) {
	if ($_SESSION['v_code']==$_POST['v_code']) {
		$fileSignExt=explode('.', $_FILES['sign']['name']);
		$sign_ext=strtolower(end($fileSignExt));
		$fileSealExt=explode('.', $_FILES['seal']['name']);
		$seal_ext=strtolower(end($fileSealExt));
		$target_sign='signatures/'.$_SESSION['user_name']."sign".".".$sign_ext;
		$target_seal='seals/'.$_SESSION['user_name']."seal".".".$seal_ext;
		move_uploaded_file($_FILES['sign']['tmp_name'], $target_sign);
		move_uploaded_file($_FILES['seal']['tmp_name'], $target_seal);

		$stmt=$pdo->prepare('INSERT INTO admins(first_name,last_name,doctor_id,gender,email,phone_no,hospital_name,locality,user_name,password,verf,v_code,sign,seal) VALUES(:first_name,:last_name,:doctor_id,:gender,:email,:phone_no,:hospital_name,:locality,:user_name,:password,1,:v_code,:sign,:seal)');
		$stmt->execute(array(
			':first_name'=>$_SESSION['first_name'],
			':last_name'=>$_SESSION['last_name'],
			':doctor_id'=>$_SESSION['doctor_id'],
			':gender'=>$_SESSION['gender'],
			':email'=>$_SESSION['email'],
			'phone_no'=>$_SESSION['phone_no'],
			':hospital_name'=>$_SESSION['hospital_name'],
			':locality'=>$_SESSION['locality'],
			':user_name'=>$_SESSION['user_name'],
			':password'=>md5($_SESSION['password']),
			':v_code'=>$_SESSION['v_code'],
			'sign'=>$_SESSION['user_name']."sign".".".$sign_ext,
			'seal'=>$_SESSION['user_name']."seal".".".$seal_ext

		));
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['email']);
		unset($_SESSION['user_name']);
		unset($_SESSION['password']);
		unset($_SESSION['v_code']);
		$_SESSION['verf_succ']="account verified and created";
		header('Location:index.php');
		return;
	}
	else{
		$_SESSION['verf_err']="incorrect code try again";
		header('Location:confirmation.php');
		return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>confirmation</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
  	<link rel="stylesheet" type="text/css" href="css/confirm.css">
</head>
<body style="background:linear-gradient(rgba(255,255,255,.4),rgba(255,255,255,.4)),url('new.jpg') no-repeat center center;">
	<?php  
	if (isset($_SESSION['verf_err'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'><i>".$_SESSION['verf_err']."</i><h2/>";
		unset($_SESSION['verf_err']);
	}
	if (isset($_SESSION['signup_succ'])) {
		echo "<h2 style='color:green;position:relative;top:10px;left:20px;'><i>".$_SESSION['signup_succ']."</i><h2/>";
		unset($_SESSION['signup_succ']);
	}
	?>
	<div class="wrapper">
    	<div class="title">
      		Registration
    	</div>
    	<div class="form" >
    		<form method="post" enctype="multipart/form-data">
       			<div class="inputfield">
          			<label>Verification code:</label>
          			<input type="text" required name="v_code" class="input">
       			</div>  
        		<div class="inputfield">
          			<label>Add signature(in PNG or JPG):</label>
          			<input type="file" required name="sign" class="input">
       			</div>    
      			<div class="inputfield">
          			<label>Add seal(in PNG or JPG):</label>
          			<input type="file" required name="seal" class="input">
       			</div> 
        		
      			<div class="inputfield">
        			<input type="submit" value="create" name="submit" id="valuecolor1" class="btn">
        			<input type="button" value="cancel" onclick="redirecttoindex();return false;" id="valuecolor2" class="btn">
      			</div>
      		</form>
    	</div>
	</div>
	
</body>
<script type="text/javascript">
		function redirecttoindex() {
		window.location.href="logout.php";
	}
	document.getElementById('valuecolor1').style.color="black";
	document.getElementById('valuecolor2').style.color="black";
	</script>
</html>