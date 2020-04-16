<?php
session_start();
header("Content-Type:text/html;charset=utf8");
use controller\{ACIndex,ACRegistration,ACLogin};
spl_autoload_register('autoloadClass');
function autoloadClass($class){
	$class = str_replace("\\", "/",$class);
	$file = __DIR__."/{$class}.php";
	if(file_exists($file)){
		require_once $file;
	}
}
 

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