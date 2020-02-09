<?php
	include 'connect.php';

// if(isset($_POST['message'])){
// 	 $test = mysqli_real_escape_string($link,$_POST['message']);
// 	//$insert1 = "INSERT INTO `testajax`(`input1`, `input2`) VALUES ('".$_POST['Form_inp']."','".$_POST['Form_inp']."')";//форма запроса на добавление поля
// 	$insert2 = "UPDATE `testajax` SET `input1`= '$test' WHERE id = 1";//форма запроса на обновление поля
// 	$res_isert1 = mysqli_query($link,$insert2);//отсылаю запрос
	
// 	$insert3 = "SELECT `input1` FROM `testajax` WHERE id = 1 ";
// 	$res_isert = mysqli_query($link,$insert3);//отсылаю запрос
// 	$data = mysqli_fetch_all($res_isert, MYSQLI_ASSOC);//восзврат массива БД
// 	print_r($data[0]['input1']);
// 	echo 'helloe';

// }
	if($_POST['message']){
		$postMessage = mysqli_real_escape_string($link,$_POST['message']);
	}


	if(!$postMessage){
		$insert = "INSERT INTO `testajax`(`id`, `input1`) VALUES (1,'')";
		$queryInsert = mysqli_query($link,$insert);

	}elseif($postMessage){
		$updata = "UPDATE `testajax` SET `input1`='$postMessage' WHERE `id`=1";
		$queryUpdata = mysqli_query($link,$updata);

		$select = "SELECT `input1` FROM `testajax` WHERE id = 1 ";
		$res_select = mysqli_query($link,$select);//отсылаю запрос
		$data = mysqli_fetch_all($res_select, MYSQLI_ASSOC);//восзврат массива БД
		print_r($data[0]['input1']);
	} 
	



 ?>