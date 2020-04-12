<?php
session_start();
require_once 'install.php';
include 'config.php';
header("Content-Type:text/html;charset=utf8");
require_once 'model/Model.php';
require_once 'controller/AController.php';
require_once 'controller/ACIndex.php';
require_once 'controller/ACRegistration.php';
require_once 'controller/ACLogin.php';

 
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'registration':
			$init = new ACRegistration();
			break;
		case 'login':
			$init = new ACLogin();
			break;
		default:
			$init = new ACIndex();
			return FALSE;
			break;
	}
}
else{
	$init = new ACIndex();
}

echo $init->getBody();
?>