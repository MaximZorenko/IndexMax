<?php
	include 'connect.php';
	include 'functions.php';

	$selectInput1 = "SELECT `input1` FROM `testajax` WHERE id = 1 ";
	$res_selectInput1 = mysqli_query($link,$selectInput1);
	$dataSelectInput1 = mysqli_fetch_all($res_selectInput1, MYSQLI_ASSOC);
	$postMessageInput1 = $dataSelectInput1[0]['input1'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SIMPLE TODO LISTS</title>
	<link rel="stylesheet" href="style.css">
	<style type="text/css">
		body{
			margin: 0;
			padding: 0;
			height: 100vh;
			font-family: 'Open Sans', sans-serif;
			background: linear-gradient(to top, #cf8814 40%, #cbcab4 60%);
		}
		button,input[type=submit],input[type=checkbox]{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<section>
		<h1>SIMPLE TODO LISTS</h1>
		<span>from ruby garge</span>
		<div class="wrapTodoList">
		</div>
		<button type="button" class="addNewTodoList">Add TODO List</button>
	</section>
	

	<script src="scriptTodo.js"></script>
	<script>
<?php if($postMessageInput1){ ?>
	arrayNewTodo = <?php if($postMessageInput1){print_r($postMessageInput1);} ?>;
	showTodoList(arrayNewTodo);
<? } ?>		
	</script>
</body>
</html>