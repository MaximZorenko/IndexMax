<?php
	$link = mysqli_connect('localhost','mylogin','1234','testajax') or die('Ошибка соединения');
	mysqli_set_charset($link,'utf8') or die('ошибка кодировки');