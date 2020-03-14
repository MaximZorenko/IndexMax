<?php
	session_start();
	include 'install.php';
	include 'connect.php';
	include 'functions.php';
  
  // unset($_SESSION['sess']);
  if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
  	funcCookie();
  }
	if(isset($_POST['loguot'])) {
		$msg = logout();
		
		if($msg === TRUE) {
			$_SESSION['mes'] = "Вы вышли из учетной записи";
			header("Location:".$_SERVER['PHP_SELF']);
			exit();
		}
	}

	if(isset($_SESSION['sess'])){
		funcLogin();
		$_SESSION['mes'] = $_SESSION['login'];
	}
	if(!isset($_SESSION['sess'])){
		functUser();
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SIMPLE TODO LISTS</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
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
	<header>
		<a href="registration.php">REGISTRATION</a>
		<a href="login.php">AUTHORIZATION</a>
		<?php if(isset($_SESSION['sess'])){ ?>
			<form  method='POST'>
				<input type='submit' name="loguot" value='exit'>
			</form>	
		<?php } ?>
		<?php if(isset($_SESSION['mes'])){ ?>
			<span><?php print_r($_SESSION['mes']);?></span>
		<?php } ?>
	</header>

	<!-- <p id="response"></p> -->
	<section>
		<h1>SIMPLE TODO LISTS</h1>
		<span>from ruby garge</span>
		<div class="wrapTodoList">
		</div>
		<button type="button" class="addNewTodoList">Add TODO List</button>
	</section>
	
	<script src="scriptTodo.js"></script>
	
	<?php if(isset($_SESSION['login'])){ ?>
		<script>
			arrayNewTodo = <?php funcMessage(); ?>;
			showTodoList(arrayNewTodo);
		</script>
	<?php }elseif(!isset($_SESION['login'])){ ?>
		<script>
			arrayNewTodo = <?php functUserMessage2(); ?>;
			showTodoList(arrayNewTodo);
		</script>
	<?php } ?>

	
</body>
</html>