<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AUTHORIZATION</title>
	<link rel="stylesheet" href="view/style.css">
</head>
<body>
	<section class="todo__login">
		<h1>AUTHORIZATION</h1>
		<?php echo $_SESSION['msg']; ?>
		<? unset($_SESSION['msg'])?>
		<form method='POST'>
			<label>login</label>
			<div class="">
				<input type='text' name='login'>
			</div>
			<label>Password</label>
			<div class="">
				<input type='password' name='password'>
			</div>
			<label>Member<input type="checkbox" name='member' value="1"></label><br>	
			<input type='submit' value='AUTHORIZATION'>
		</form>												
	</section>
</body>
</html>