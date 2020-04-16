<?php
namespace controller;
class ACRegistration extends AController{
	
	public $init;

	public function getBody(){
		parent::getBody();

		$this->db->logout();
		if(isset($_POST['reg'])){
			$msg = $this->db->registration($_POST);
			if($msg === TRUE){
				$_SESSION['msg'] = "Вы зарегестрировались";
				header("Location:?action=login");
				exit;
			}else{
				$_SESSION['msg'] = $msg;
			}
			header("Location:?action=registration");
			exit;
		}
		return $this->render('registration',array('id'=>1,'name'=>'Max'));
	}
}


?>