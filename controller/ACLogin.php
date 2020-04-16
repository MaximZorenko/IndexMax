<?php
namespace controller;

class ACLogin extends AController{
	public function getBody(){
		parent::getBody();

		$this->db->logout();
		if(isset($_POST['login']) && isset($_POST['password'])) {
			$msg = $this->db->login($_POST);	
			if($msg === TRUE) {
				
				header("Location:index.php");
			
			}
			else {
				$_SESSION['msg'] = $msg;
				header("Location:?action=login");
			}
			exit();	
		}
	


		return $this->render('login',array('id=>1'));
	}
}

?>