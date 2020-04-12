<?php
	$link = mysqli_connect('localhost','root','') or die('Ошибка соединения');
	$query = "CREATE DATABASE IF NOT EXISTS todo DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
	if(!mysqli_query($link,$query)) die("Не удалось создать БД");
	mysqli_select_db($link,'todo') or die("Нет соединения с БД");
	

	$query = "CREATE TABLE IF NOT EXISTS `todo`.`users` (
	  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	  `login` varchar(255) NOT NULL,
	  `password` varchar(32) NOT NULL,
	  `sess` varchar(32) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	if(!mysqli_query($link,$query)) die("Не удалось создать таблицы");



	$query = "CREATE TABLE IF NOT EXISTS `todo`.`tasks` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `status` varchar(255) DEFAULT NULL,
	  `project_id` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	if(!mysqli_query($link,$query)) die("Не удалось создать таблицы");

	$query = "CREATE TABLE IF NOT EXISTS `todo`.`projects` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `hash_pro_id` varchar(32) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `user_id` int(11) DEFAULT NULL, 
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	if(!mysqli_query($link,$query)) die("Не удалось создать таблицы");


?>