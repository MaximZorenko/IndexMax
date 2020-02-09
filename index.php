<?php
	include 'connect.php';
	include 'functions.php';

	//выборка с поля input1
	$selectInput1 = "SELECT `input1` FROM `testajax` WHERE id = 1 ";
	$res_selectInput1 = mysqli_query($link,$selectInput1);//отсылаю запрос
		$dataSelectInput1 = mysqli_fetch_all($res_selectInput1, MYSQLI_ASSOC);//
	$postMessageInput1 = $dataSelectInput1[0]['input1'];
	

	// $insert3 = "SELECT `input1` FROM `testajax` WHERE id = 1 ";
	// $res_isert = mysqli_query($link,$insert3);//отсылаю запрос
	// $data = mysqli_fetch_all($res_isert, MYSQLI_ASSOC);//восзврат массива БД
	// // print_r($data[0]['input1']);
	// $result = $data[0]['input1'];
	// echo $result;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style.css">
	

</head>
<body>
	<?php 
	// echo '<pre>' . print_r($_POST,true) . '</pre>';
	 ?>
	<div id="response"></div>
<!-- 	<form action="" name="ourForm">
		<input type="text" name="ourForm_inp">
		<button type="submit" name="ourForm_btn">Отправить</button>
	</form> -->


	<form action="" name="ourForm">
		<input type="text" name="message" class="message">
		<input type='submit' name="add" class="add" value="Отправить">
	</form>

	<ul class="todo"></ul>



	<script src="scriptTEst1.js"></script>
	<script src="scriptTodo.js"></script>
		<script>
		array = <?php if($postMessageInput1){print_r($postMessageInput1);} ?>;
		show();
	</script>
</body>
</html>