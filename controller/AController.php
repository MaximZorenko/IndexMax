<?php
namespace controller;
use model\Model;

abstract class AController{
	public $db;

	public function getBody(){
		$this->db = new Model('mysql:host=localhost;dbname=todo', 'root', '');
	}
// DATABASE_URL
// $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
	public function render($file,$params){
		$params = $params;
		ob_start();
		include("view/".$file.".tpl.php");
		return ob_get_clean();
	}



}





?>