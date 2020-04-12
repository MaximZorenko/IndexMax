<?php
class ACIndex extends AController{
	
	public function getBody(){
		parent::getBody();


		if($_POST['project']){
			if(!$_SESSION){
				$user = FALSE;
			}
			if(isset($_SESSION['sess'])){
				$user = $this->db->funcUser($_SESSION['sess']);
			}
			$msg = $this->db->functProject($_POST,$user['id']);
			exit($msg);
		}
		if($_POST['task']){
			$msg = $this->db->funcTask($_POST);
			exit($msg);
		}
		if($_POST['checkbox']){
			$msg = $this->db->funcCheckbox($_POST);
			exit($msg);
		}
		if($_POST['deletTask']){
			$msg = $this->db->funcDeletTask($_POST);
			exit($msg);
		}
		if($_POST['correctTask']){
			$msg = $this->db->funcCorrectTask($_POST);
			exit($msg);
		}
		if($_POST['newValueTask']){
			$msg = $this->db->funcNewValueTask($_POST); 
			exit($msg);
		}
		if($_POST['deletProject']){
			$msg = $this->db->funcDeletProject($_POST);
			exit($msg); 
		}
		if($_POST['correctProject']){
			$msg = $this->db->funcCorrectProject($_POST); 
			exit($msg);
		}
		if($_POST['newValueProject']){
			$msg = $this->db->funcNewValueProject($_POST);
			exit($msg);
		}
		if($_POST['next']){
			$msg = $this->db->funcNext($_POST); 
			exit($msg);
		}
		if($_POST['prev']){
			$msg = $this->db->funcPrev($_POST); 
			exit($msg); 
		}
		// if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
		// 	funcCookie();
		// }
		if(isset($_POST['loguot'])) {
			$msg = $this->db->logout();
			
			if($msg === TRUE) {
				header("Location:".$_SERVER['PHP_SELF']);
				exit();
			}
		}
		if(!$_SESSION){
			$text = $this->db->funcAddMess(FALSE);
		}
		if(isset($_SESSION['sess'])){
			$user = $this->db->funcUser($_SESSION['sess']);
			$text = $this->db->funcAddMess($user['id']);
		}

		return $this->render('index',$text);
	}
}


?>
