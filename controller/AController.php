<?php
abstract class AController{
	public $db;

	public function getBody(){
		$this->db = new Model(HOST,USER,PASS,DB);
	}

	public function render($file,$params){
		$params = $params;
		ob_start();
		include("view/".$file.".tpl.php");
		return ob_get_clean();
	}



}





?>