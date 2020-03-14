<?php
session_start();
header("Content-Type:text/html;charset=utf8");

require "connect.php";
require "functions.php";
logout();
if(isset($_POST['login']) && isset($_POST['password'])) {

	$msg = login($_POST);
	
	if($msg === TRUE) {
		header("Location:index.php");
	}
	else {
		$_SESSION['msg'] = $msg;
		header("Location:".$_SERVER['PHP_SELF']);
	}
	exit();
	
}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AUTHORIZATION</title>
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
	<section class="todo__login">
		<h1>AUTHORIZATION</h1>
		<? unset($_SESSION['msg'])?>
		<form method='POST'>
			<label>login</label>
			<div class="wrap">
				<input type='text' name='login'>
			</div>
			<label>Password</label>
			<div class="wrap">
				<input type='password' name='password'>
			</div>
			<label>Member<input type="checkbox" name='member' value="1"></label>	
			<input type='submit' value='entrance'>
		</form>												
	</section>
</body>
</html>
