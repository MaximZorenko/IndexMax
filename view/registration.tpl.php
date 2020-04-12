<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>REGISTRATION</title>
	<link rel="stylesheet" href="view/style.css">
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
			<div class="">
				<input type='text' name='reg_login' value="<?=$_SESSION['reg']['login'];?>">
			</div>
			<label for="">Пароль</label>
			<div class="">
				<input type='password' name='reg_password'>
			</div>
			<label for="">Подтвердите пароль</label>
			<div class="">
				<input type='password' name='reg_password_confirm'>
			</div>
			<input type='submit' name='reg' value='REGISTRATION'>
		</form>														
	</section>
<? unset($_SESSION['reg']);?>
</body>
</html>
