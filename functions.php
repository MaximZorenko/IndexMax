<?php
	session_start();
	include 'connect.php';
	// CREATE TABLE `testajax`.`users` ( `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) NOT NULL , `password` VARCHAR(32) NOT NULL , `sess` VARCHAR(32) NOT NULL , PRIMARY KEY (`user_id`)) ENGINE = InnoDB;

	function registration($post){
		global $link;
		$login = clean_data($post['reg_login']);
		$password = trim($post['reg_password']);
		$conf_pass = trim($post['reg_password_confirm']);
		$msg = '';
		if(empty($login)){
			$msg .= 'Введите логин</br>';
		}
		if(empty($password)){
			$msg .= 'Введите пароль</br>';
		}
		if($msg){
			$_SESSION['reg']['login'] = $login;
			return $msg;
		}
		if($conf_pass===$password){
			$sql = "SELECT user_id FROM users WHERE login='%s'";
			$sql = sprintf($sql,mysqli_real_escape_string($link,$login));
			$result = mysqli_query($link,$sql);
			if(mysqli_num_rows($result)>0){
				return 'Пользователь с таким логином уже существует';
			}
			$password = md5($password);
			$query = "INSERT INTO users (user_id,login,password,sess) VALUES (null,'%s','%s','')";
			$query = sprintf($query,mysqli_real_escape_string($link,$login),$password);
			$result2 = mysqli_query($link,$query);
			if(!$result2){
				$_SESSION['reg']['login'] = $login;
				return "Ошибка добавления пользователя в база данных";
			}else{return TRUE;}
		}else{
			$_SESSION['reg']['login'] = $login;
			return 'Вы не верно подтвердили пароль';
		}
	}

	function clean_data($str){
		return strip_tags(trim($str));
	}

	
	function login($post){
		global $link;
		if(empty($post['login']) || empty($post['password'])){
			return 'Заполните поля';
		}
		$login = clean_data($post['login']);
		$password = md5(trim($post['password']));
		$sql = "SELECT user_id FROM users WHERE login='%s' AND password='%s'";
		$sql = sprintf($sql,mysqli_real_escape_string($link,$login),$password);
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1){
			return 'Неправельный логин или пароль';
		}
		$sess = md5(microtime());
		$sql_update = "UPDATE users SET sess='$sess' WHERE login='%s'";
		$sql_update = sprintf($sql_update,mysqli_real_escape_string($link,$login));
		if(!mysqli_query($link,$sql_update)){
			return "Ошибка авторизации пользователя";
		}
		$_SESSION['sess'] = $sess;
		if($post['member'] == 1){
			$time = time() + 10*24*3600;
			setcookie('login',$login,$time);
			setcookie('password',$password,$time);
		}
		return TRUE;
	}

	function logout(){
		unset($_SESSION['sess']);
		unset($_SESSION['login']);
		setcookie('login','',time()-3600);
		setcookie('password','',time()-3600);
		return TRUE;
	}


	function funcLogin(){
		global $link;
		$sess = $_SESSION['sess'];
		$sql = "SELECT login From users WHERE sess='$sess'";
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1){
			return FALSE;
		}elseif(isset($result)){
			$_SESSION['login'] = mysqli_fetch_all($result, MYSQLI_ASSOC)[0]['login'];
			$login = $_SESSION['login'];
			$sql2 = "SELECT login From todo WHERE login='$login'";
			$result2 = mysqli_query($link,$sql2);
			if(!$result2 || mysqli_num_rows($result2)<1){
				$sql3 = "INSERT INTO todo (id,message,login) VALUES(null,'','$login')";
				$result3 = mysqli_query($link,$sql3);
			}
			return TRUE;
		}		
	}
	
	function ajaxMessage(){
		global $link;
		$message = $_POST['message'];
		$login = $_SESSION['login'];
		$strMessage = mysqli_real_escape_string($link,$message);
		$sql = "UPDATE todo SET message='$strMessage' WHERE login='$login'";
		$result = mysqli_query($link,$sql);
		$sql2 = "SELECT message From todo WHERE login='$login'";
		$result2 = mysqli_query($link,$sql2);
		$data = mysqli_fetch_all($result2, MYSQLI_ASSOC);
		return print_r($data[0]['message']);

	}

	function funcMessage(){
		global $link;
		$login = $_SESSION['login'];
		$sql = "SELECT message From todo WHERE login='$login'";
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1){
		return FALSE;
		}
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return print_r($data[0]['message']);
	}

	if($_POST['message']){
		if(isset($_SESSION['sess'])){
			ajaxMessage();
		}elseif(!isset($_SESION['sess'])){
			functUserMessage();
		}	
	}		

	function functUser(){
		global $link;
		$sql = "SELECT message From todo WHERE login='unauthorizedGuest'";
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1){
			$sql2 = "INSERT INTO todo (id,message,login) VALUES (null,'','unauthorizedGuest')";
			$result2 = mysqli_query($link,$sql2);
		}
		return TRUE;
	}

	function functUserMessage(){
		global $link;
		$message = $_POST['message'];
		$strMessage = mysqli_real_escape_string($link,$message);
		$sql = "UPDATE todo SET message='$strMessage' WHERE login='unauthorizedGuest'";
		$result = mysqli_query($link,$sql);
		$sql2 = "SELECT message From todo WHERE login='unauthorizedGuest'";
		$result2 = mysqli_query($link,$sql2);
		$data = mysqli_fetch_all($result2, MYSQLI_ASSOC);
		return print_r($data[0]['message']);

	}
	function functUserMessage2(){
		global $link;
		$sql = "SELECT message From todo WHERE login='unauthorizedGuest'";
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1){
		return FALSE;
		}
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return print_r($data[0]['message']);
	}

	function funcCookie(){
		global $link;
		$login = $_COOKIE['login'];
		$password = $_COOKIE['password'];
		$sql = "SELECT sess	FROM users WHERE login='$login'	AND password='$password'";
		$result = mysqli_query($link,$sql);
		if(!$result || mysqli_num_rows($result) < 1) {
			return FALSE;
		}
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$_SESSION['sess'] = $data[0]['sess'];
		return TRUE;


		// $sql_update = "UPDATE users SET sess='$sess' WHERE login='$login'";
		// $result2 = mysqli_query($link,$sql_update);
		// if(!$result2) {
		// 	return "Ошибка авторизации пользователя";
		// }
		// $sql_select = "SELECT sess FROM users WHERE login='$login'";
		// $result3 = mysqli_query($link,$sql_select);
		// $data = mysqli_fetch_all($result3, MYSQLI_ASSOC);
		// $_SESSION['sess'] = $data[0]['sess'];		
		// return TRUE;	
	}






	
		

	




 ?>