<?php
$stmt=$pdo->prepare('SELECT * FROM admins WHERE admin_id=:admin_id');
// $stmt->execute(array(
// 	':admin_id'=>$_SESSION['admin_id']
// ));
// $row=$stmt->fetch(PDO::FETCH_ASSOC);
// if ($row===false) {
// 	$_SESSION['signup_err']='No such user name is found';
// 	header('Location:edit.php');
// 	return;
// }