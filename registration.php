<?php
 session_start();
	header("Content-Type:text/html;charset=utf8");

	require "connect.php";
	require "functions.php";

	logout();
	if(isset($_POST['reg'])){
		$msg = registration($_POST);
		if($msg === TRUE){
			$_SESSION['msg'] = "Вы зарегестрировались";
			header("Location: login.php");
			exit;
		}else{
			$_SESSION['msg'] = $msg;
		}
		header("Location:".$_SERVER['PHP_SELF']);
		exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>REGISTRATION</title>
	<link rel="stylesheet" href="style.css">
	<style type="text/css">
		body{
			margin: 0;
			padding: 0;
			/*height: 100vh;*/
			font-family: 'Open Sans', sans-serif;
			background: linear-gradient(to top, #cf8814 40%, #cbcab4 60%) no-repeat;
		}
		button,input[type=submit],input[type=checkbox]{
			cursor: pointer;
		}
		form.ourForm{
			margin: 0;
		}
	</style>
</head>
<body>
	<section class="todo__registration">
		<h1>REGISTRATION</h1>

		<?php
			echo $_SESSION['msg'];
		?>

		<?php 
			unset($_SESSION['msg']);
		?>

		<form method='POST'>
			<label for="">Логин</label>
			<div class="wrap">
				<input type='text' name='reg_login' value="<?=$_SESSION['reg']['login'];?>">
			</div>
			<label for="">Пароль</label>
			<div class="wrap">
				<input type='password' name='reg_password'>
			</div>
			<label for="">Подтвердите пароль</label>
			<div class="wrap">
				<input type='password' name='reg_password_confirm'>
			</div>
			<input type='submit' name='reg' value='registration'>
		</form>														
	</section>
<? unset($_SESSION['reg']);?>
</body>
</html>

