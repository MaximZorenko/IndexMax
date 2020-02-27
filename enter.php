<?php
	session_start();
	if($_SESSION['admin']){
		header("Location: index.php");
		exit;
	}
	$admin = 'admin';
	$pass = '202cb962ac59075b964b07152d234b70';
	if($_POST['submit']){
		if($admin==$_POST['user'] AND $pass == md5($_POST['pass'])){
			$_SESSION['admin'] = $admin;
			header("Location: index.php");
			exit;
		}else{ echo 'Пароль не верный'; }
	}

?>
<h1>Страница авторизации</h1>
<form action="" method="POST">
	<input type="text" name="user"><br>
	<input type="password" name="pass"><br>
	<input type="submit" name="submit" value="Войти">
</form>
<!-- md5() -->