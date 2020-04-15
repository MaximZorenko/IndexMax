<?php
abstract class AController{
	public $db;

	public function getBody(){
		$this->db = new Model(DATABASE_URL);
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