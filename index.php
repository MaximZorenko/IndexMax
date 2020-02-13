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

	<div id="response"></div>
	<button type="button" class="addNewTodoList">addNewTodoList</button>
	<div class="wrapTodoList">

<!-- 		<div class="wrapTodoList__new">
			<form action="" name="ourForm">
				<input type="text" name="message" class="message">
				<input type='submit' name="add" class="add" value="Отправить">
			</form>
			<ul class="todo"></ul>
		</div> -->

	</div>



	



	
	<script src="scriptTodo.js"></script>
	<script src="scriptTEst1.js"></script>
		<script>
			if(document.querySelector('.wrapTodoList__new')){
					array = <?php if($postMessageInput1){print_r($postMessageInput1);} ?>;
				show();
			}
	</script>
</body>
</html>