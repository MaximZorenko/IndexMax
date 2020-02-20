<?php
	include 'connect.php';

	if($_POST['message']){
		$postMessage = mysqli_real_escape_string($link,$_POST['message']);
	}

	if(!$postMessage){
		$insertTab = "CREATE TABLE `testajax`.`testajax` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `input1` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
		$queryInsertTab = mysqli_query($link,$insertTab);
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