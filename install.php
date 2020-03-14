<?php
	$link = mysqli_connect('localhost','mylogin','1234') or die('Ошибка соединения');

	$query = "CREATE DATABASE IF NOT EXISTS testajax DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
	if(!mysqli_query($link,$query)) die("Не удалось создать БД");
	mysqli_select_db($link,'testajax') or die("Нет соединения с БД");

	$query = "CREATE TABLE IF NOT EXISTS `testajax`.`users` ( `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `login` VARCHAR(255) NOT NULL , `password` VARCHAR(32) NOT NULL , `sess` VARCHAR(32) NOT NULL , PRIMARY KEY (`user_id`)) ENGINE = InnoDB";
	if(!mysqli_query($link,$query)) die("Не удалось создать таблицы");

	$query = "CREATE TABLE IF NOT EXISTS `testajax`.`todo` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `message` TEXT NOT NULL , `login` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
	if(!mysqli_query($link,$query)) die("Не удалось создать таблицы");


?>