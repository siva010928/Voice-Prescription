<?php 
require_once 'pdo.php'; 
session_start();
// if (!isset($_SESSION['admin_id'])) {
// 	die('Access Denied');
// }
// $stmt=$pdo->prepare('SELECT * FROM admins WHERE admin_id=:admin_id');
// $stmt->execute(array(
// 	':admin_id'=>$_SESSION['admin_id']
// ));
// $row=$stmt->fetch(PDO::FETCH_ASSOC);
// if ($row===false) {
// 	$_SESSION['forgotpass0_fail']='No such user name is found';
// 	header('Location:delete.php');
// 	return;
// }
if (isset($_POST['submit'])) {	
	$_SESSION['forgotpass_succ_mail']='Successfully Deleted';
	header('Location:index.php');
	return;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete account</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
  	<link rel="stylesheet" type="text/css" href="css/deleting.css">
</head>
<body style="background:linear-gradient(rgba(255,255,255,.4),rgba(255,255,255,.4)),url('new.jpg') no-repeat center center;">
	<?php
	if (isset($_SESSION['forgotpass0_fail'])) {
		echo "<h2 style='color:red;position:relative;top:10px;left:20px;'><i>".$_SESSION['forgotpass0_fail']."</i><h2/>";
		unset($_SESSION['forgotpass0_fail']);
	}
	?>
	<div class="wrapper">
    	
    	<div class="form" enctype="multipart/form-data">
    		<form method="post">
       			<div class="title">
          			User name:<?php echo "\n\n\n".$row['user_name']?>
       			</div>  
        		
      			<div class="inputfield">
        			<input type="submit" value="delete your account" name="submit" id="valuecolor1" class="btn btn-light">
        			<input type="button" value="cancel" onclick="redirecttovoice();return false;" id="valuecolor2" class="btn btn-link">
      			</div>
      		</form>
    	</div>
	</div>
	<script type="text/javascript">
		function redirecttovoice() {
		window.location.href="voice_pres.php";
	}
	document.getElementById('valuecolor1').style.color="black";
	document.getElementById('valuecolor2').style.color="black";
	</script>
</body>
</html>