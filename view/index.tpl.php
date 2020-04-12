<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TodoOOP</title>
	<link rel="stylesheet" href="view/style.css">	
</head>
<body>
	<header>
		<a href="?action=registration">REGISTRATION</a><span>|</span>
		<a href="?action=login">AUTHORIZATION</a>
		<?php if(isset($_SESSION['sess'])){ ?>
			<form  method='POST'>
				<span>|</span><input type='submit' name="loguot" value='EXIT'>
			</form>
		<?php } ?>
		<?php if(isset($_SESSION['login'])): ?>
			<span class='spanLogin'><?=$_SESSION['login']; ?></span>
		<?php endif; ?>	
	</header>

	<section class="title">
		<h1>SIMPLE TODO LISTS</h1>
		<span>FROM RUBY GARAGE</span>
	</section>

	<div class="wrap">
		<?php 
		echo $params;
		?>
	</div>	
	<form id="formAddTodoList" class="form">
		<input type="text" name='project' id="addTodoList">
		<input type='submit' name="submit">
	</form>
	<button class="btn">Add TODO List</button>

	<script src='view/script.js'></script>
</body>
</html>