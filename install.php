<?php
	//////////для pgAdmin
	"CREATE TABLE IF NOT EXISTS projects (
	  id SERIAL NOT NULL PRIMARY KEY,
	  hash_pro_id varchar(32) NOT NULL,
	  name varchar(255) NOT NULL,
	  user_id integer DEFAULT NULL
	)"
	"CREATE TABLE IF NOT EXISTS tasks (
	  id SERIAL NOT NULL PRIMARY KEY,
	  name varchar(255) NOT NULL,
	  status varchar(25) DEFAULT NULL,
	  project_id integer NOT NULL
	)"
	"CREATE TABLE IF NOT EXISTS users (
	  id SERIAL NOT NULL PRIMARY KEY,
	  login varchar(255) NOT NULL,
	  password varchar(32) DEFAULT NULL,
	  sess varchar(32) NOT NULL
	)"
	//
	['Host']=> 'ec2-34-204-22-76.compute-1.amazonaws.com'
	['Database']=> 'daerruhvja8gpq'
	['User]'=>'houlcmfrtgftnk'
	['Port']=>'5432'
	['Password']=>'a5a2fc3a362a2d76b60059f99a45de4edb88d98d50db73daceb42e5c6445da74'
	['URI']=>['postgres://houlcmfrtgftnk:a5a2fc3a362a2d76b60059f99a45de4edb88d98d50db73daceb42e5c6445da74@ec2-34-204-22-76.compute-1.amazonaws.com:5432/daerruhvja8gpq']
	['Heroku CLI']=>'heroku pg:psql postgresql-rectangular-24901 --app quiet-tundra-73149'
	///////////
	['connect']'postgresql-rectangular-24901'
	DATABASE_URL
	/////////////////////////////
	$query = "CREATE DATABASE IF NOT EXISTS todo DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
	
	

	$query = "CREATE TABLE IF NOT EXISTS `todo`.`users` (
	  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	  `login` varchar(255) NOT NULL,
	  `password` varchar(32) NOT NULL,
	  `sess` varchar(32) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";




	$query = "CREATE TABLE IF NOT EXISTS `todo`.`tasks` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `status` varchar(255) DEFAULT NULL,
	  `project_id` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";




	$query = "CREATE TABLE IF NOT EXISTS `todo`.`projects` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `hash_pro_id` varchar(32) NOT NULL,
	  `name` varchar(255) NOT NULL,
	  `user_id` int(11) DEFAULT NULL, 
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


	
?>