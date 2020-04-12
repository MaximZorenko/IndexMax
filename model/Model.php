<?php
class Model{
	public $db;

	public function __construct($host,$user,$pass,$db){
		$this->db = new mysqli($host,$user,$pass,$db);
		if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
		}
		// printf("Изначальная кодировка: %s\n", $this->db->character_set_name());
		if (!$this->db->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $this->db->error);
    exit();
		} else {
    // printf("Текущий набор символов: %s\n", $this->db->character_set_name());
		}
		return $this->db;
	}

	public function functProject($post,$user_id){
		$name = $post['project'];
		$hash_pro_id = md5(microtime());
		if(empty($user_id)){
			$sql = "INSERT INTO `projects`(`hash_pro_id`,`name`) VALUES ('$hash_pro_id','$name')";
			$res = $this->db->query($sql);
		}
		$sql = "INSERT INTO `projects`(`hash_pro_id`,`name`, `user_id`) VALUES ('$hash_pro_id','$name','$user_id')";
		$res = $this->db->query($sql);
		$sql = "SELECT * From projects WHERE hash_pro_id = '$hash_pro_id'";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
					$return .= "	
						<div class='wrap_project'>
							<form class='formTask'>
								<h2>".$row['name']."</h2>
								<input type='button' name='correctProject'>
								<input type='button' name='deletProject'>
								<input type='hidden' name='project_id' value='".$row['id']."'>
								<input type='text' name='task'>
								<input type='submit' value='Add Task'>
							</form>
							<div class='wrapTask'></div>
						</div>
					";
			}
			return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcTask($post){
		$task = $post['task'];
		$project_id = $post['project_id'];
		$sql = "INSERT INTO `tasks`(`name`, `project_id`) VALUES ('$task','$project_id')";
		$res = $this->db->query($sql);
		$sql = "SELECT * FROM tasks WHERE project_id = '$project_id'";
		$res = $this->db->query($sql);

		if(mysqli_num_rows($res)>0){
			while($row = mysqli_fetch_assoc($res)){
				$return.="
					<form class='formTaskElement'>
						<input type='checkbox' name='checkbox'".$row['status'].">
						<input type='hidden' name='task_id' value='".$row['id']."'>
						<p>".$row['name']."</p>
						<input type='button' name='correctTask'>
						<input type='button' name='deletTask'>
						<input type='button' name='next'>
						<input type='button' name='prev'>
					</form>
				";
			}
		return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcCheckbox($post){
		$checkbox = $post['checkbox'];
		$task_id = $post['task_id'];
		$sql = "SELECT status FROM tasks WHERE id = '$task_id'";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res)>0){
			$res = mysqli_fetch_assoc($res)['status'];
			if($res == 'checked'){
				$sql = "UPDATE `tasks` SET `status`='' WHERE `id`='$task_id'";
				$res = $this->db->query($sql);
			}else{
				$sql = "UPDATE `tasks` SET `status`='checked' WHERE `id`='$task_id'";
				$res = $this->db->query($sql);
			}
		}else{
			return 'Ошибка';
		}
	}

	public function funcDeletTask($post){
		$deletTask = $post['deletTask'];
		$task_id = $post['task_id'];
		$sql="SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		$resProjectId = mysqli_fetch_assoc($resProjectId)['project_id'];
		$sql = "DELETE FROM `tasks` WHERE id = '$task_id'";
		$res2 = $this->db->query($sql);
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId'";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res)>0){
			while($row = mysqli_fetch_assoc($res)){
				$return.="
					<form class='formTaskElement'>
						<input type='checkbox' name='checkbox'".$row['status'].">
						<input type='hidden' name='task_id' value='".$row['id']."'>
						<p>".$row['name']."</p>
						<input type='button' name='correctTask'>
						<input type='button' name='deletTask'>
						<input type='button' name='next'>
						<input type='button' name='prev'>
					</form>
				";
			}
		return $return;
		}else{
			return FALSE;
		}
	}

	public function funcCorrectTask($post){
		$correctTask = $post['correctTask'];
		$task_id = $post['task_id'];
		$sql="SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		$resProjectId = mysqli_fetch_assoc($resProjectId)['project_id'];
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId'";
		$res = $this->db->query($sql);
		
		if(mysqli_num_rows($res)>0){
			while($row = mysqli_fetch_assoc($res)){
				if($row['id'] == $task_id){
					$return.="
						<form class='formTaskElement'>
							<input type='checkbox' name='checkbox'".$row['status'].">
							<input type='hidden' name='task_id' value='".$row['id']."'>
							<input type='text' name='newValueTask' value='".$row['name']."'>
							<input type='submit' name='submitNewValueTask' value='Ok'>
							<input type='button' name='deletTask'>
							<input type='button' name='next'>
							<input type='button' name='prev'>
						</form>
					";
					continue;
				}	
				$return.="
					<form class='formTaskElement'>
						<input type='checkbox' name='checkbox'".$row['status'].">
						<input type='hidden' name='task_id' value='".$row['id']."'>
						<p>".$row['name']."</p>
						<input type='button' name='correctTask'>
						<input type='button' name='deletTask'>
						<input type='button' name='next'>
						<input type='button' name='prev'>
					</form>
				";
			}
		return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcNewValueTask($post){
		$newValueTask = $post['newValueTask'];
    $task_id = $post['task_id'];
		$sql = "UPDATE tasks SET name='$newValueTask' WHERE id=$task_id";
		$res = $this->db->query($sql);
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		$resProjectId = mysqli_fetch_assoc($resProjectId)['project_id'];
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId'";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res)>0){
			while($row = mysqli_fetch_assoc($res)){
				$return.="
					<form class='formTaskElement'>
						<input type='checkbox' name='checkbox'".$row['status'].">
						<input type='hidden' name='task_id' value='".$row['id']."'>
						<p>".$row['name']."</p>
						<input type='button' name='correctTask'>
						<input type='button' name='deletTask'>
						<input type='button' name='next'>
						<input type='button' name='prev'>
					</form>
				";
			}
		return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcDeletProject($post){
		$deletProject = $post['deletProject'];
    $project_id = $post['project_id'];
		$sql = "DELETE FROM projects WHERE id = $project_id";
		$res = $this->db->query($sql);
		$sql = "DELETE FROM tasks WHERE project_id = $project_id";
		$res = $this->db->query($sql);
	}

	public function funcCorrectProject($post){
		$project_id = $post['project_id'];
		$sql = "SELECT * From projects WHERE id = $project_id";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
					$return .= "	
						<input type='text' name='newValueProject' value='".$row['name']."'>
						<input type='button' name='deletProject'>
						<input type='hidden' name='project_id' value='".$row['id']."'>
						<input type='text' name='task'>
						<input type='submit' name='submitNewValueProject' value='Add Task'>
					";
			}
			return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcNewValueProject($post){
		$newValueProject = $post['newValueProject'];
    $project_id = $post['project_id'];
		$sql = "UPDATE projects SET name= '$newValueProject' WHERE id = $project_id";
		$res = $this->db->query($sql);
		$sql = "SELECT * FROM projects WHERE id = $project_id";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
					$return .= "	
						<h2>".$row['name']."</h2>
						<input type='button' name='correctProject'>
						<input type='button' name='deletProject'>
						<input type='hidden' name='project_id' value='".$row['id']."'>
						<input type='text' name='task'>
						<input type='submit'value='Add Task'>
					";
			}
			return $return;
		}else{
			return 'Ошибка';
		}
	}

	public function funcNext($post){
		$task_id = $post['task_id'];//9999
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id";
		$resPro_id = $this->db->query($sql);
		$resPro_id = mysqli_fetch_assoc($resPro_id)['project_id'];
		$sql = "SELECT id FROM tasks WHERE project_id = $resPro_id AND id < $task_id ORDER BY id DESC LIMIT 1";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res)>0){
			$resIdNext = mysqli_fetch_assoc($res)['id'];//8888
		
			$sql = "UPDATE tasks SET id = -2 WHERE id = $task_id";//9999
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = -1 WHERE id = $resIdNext";//8888
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = $resIdNext WHERE id = -2";//9999
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = $task_id WHERE id = -1";//9999
			$res = $this->db->query($sql);

			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id'";
			$res = $this->db->query($sql);
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					$return.="
						<form class='formTaskElement'>
							<input type='checkbox' name='checkbox'".$row['status'].">
							<input type='hidden' name='task_id' value='".$row['id']."'>
							<p>".$row['name']."</p>
							<input type='button' name='correctTask'>
							<input type='button' name='deletTask'>
							<input type='button' name='next'>
							<input type='button' name='prev'>
						</form>
					";
				}
			return $return;
			}else{
				return 'Ошибка';
			}
		}else{
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id'";
			$res = $this->db->query($sql);
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					$return.="
						<form class='formTaskElement'>
							<input type='checkbox' name='checkbox'".$row['status'].">
							<input type='hidden' name='task_id' value='".$row['id']."'>
							<p>".$row['name']."</p>
							<input type='button' name='correctTask'>
							<input type='button' name='deletTask'>
							<input type='button' name='next'>
							<input type='button' name='prev'>
						</form>
					";
				}
			}
			return $return;
		}		
	}

	public function funcPrev($post){
		$task_id = $post['task_id'];//9999
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id";
		$resPro_id = $this->db->query($sql);
		$resPro_id = mysqli_fetch_assoc($resPro_id)['project_id'];
		$sql = "SELECT id FROM tasks WHERE project_id = $resPro_id AND id > $task_id LIMIT 1";
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res)>0){
			$resPrevId = mysqli_fetch_assoc($res)['id'];		
			$sql = "UPDATE tasks SET id = -2 WHERE id = $task_id";//9999
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = -1 WHERE id = $resPrevId";//8888
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = $resPrevId WHERE id = -2";//9999
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = $task_id WHERE id = -1";//9999
			$res = $this->db->query($sql);
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id'";
			$res = $this->db->query($sql);
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					$return.="
						<form class='formTaskElement'>
							<input type='checkbox' name='checkbox'".$row['status'].">
							<input type='hidden' name='task_id' value='".$row['id']."'>
							<p>".$row['name']."</p>
							<input type='button' name='correctTask'>
							<input type='button' name='deletTask'>
							<input type='button' name='next'>
							<input type='button' name='prev'>
						</form>
					";
				}
			return $return;
			}else{
				return 'Ошибка';
			}
		}else{
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id'";
			$res = $this->db->query($sql);
			if(mysqli_num_rows($res)>0){
				while($row = mysqli_fetch_assoc($res)){
					$return.="
						<form class='formTaskElement'>
							<input type='checkbox' name='checkbox'".$row['status'].">
							<input type='hidden' name='task_id' value='".$row['id']."'>
							<p>".$row['name']."</p>
							<input type='button' name='correctTask'>
							<input type='button' name='deletTask'>
							<input type='button' name='next'>
							<input type='button' name='prev'>
						</form>
					";
				}
			}
			return $return;
		}
	}

	public function logout(){
		unset($_SESSION['sess']);
		unset($_SESSION['login']);
		setcookie('login','',time()-3600);
		setcookie('password','',time()-3600);
		return TRUE;
	}

	public function funcUser($sess){
		$sql = "SELECT id, login FROM users WHERE sess = '$sess'";
		$res = $this->db->query($sql);
		$res = mysqli_fetch_assoc($res);
		$_SESSION['login'] = $res['login'];
		return $res;
	}

	public function funcAddMess($user_id){
		if(!$user_id){
			$sql = "SELECT * FROM projects WHERE user_id IS NULL ORDER BY id DESC";
		}else{
			$sql = "SELECT * FROM projects WHERE user_id = $user_id ORDER BY id DESC";
		}	
		$res = $this->db->query($sql);
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
					$return .= "	
						<div class='wrap_project'>
							<form class='formTask'>
								<h2>".$row['name']."</h2>
								<input type='button' name='correctProject'>
								<input type='button' name='deletProject'>
								<input type='hidden' name='project_id' value='".$row['id']."'>
								<input type='text' name='task'>
								<input type='submit' value='Add Task'>
							</form>
							<div class='wrapTask'>";
					$sqli = "SELECT * FROM tasks WHERE project_id = ".$row['id']."";
					$resi = $this->db->query($sqli);
					if(mysqli_num_rows($resi) > 0){
						while($rowi = mysqli_fetch_assoc($resi)){
							$return.="
								<form class='formTaskElement'>
									<input type='checkbox' name='checkbox'".$rowi['status'].">
									<input type='hidden' name='task_id' value='".$rowi['id']."'>
									<p>".$rowi['name']."</p>
									<input type='button' name='correctTask'>
									<input type='button' name='deletTask'>
									<input type='button' name='next'>
									<input type='button' name='prev'>
								</form>
							";
						}
					}
					$return .="</div></div>";
			}
			return $return;
		}else{
			return FALSE;
		}
	}

	public function clean_data($str){
		return strip_tags(trim($str));
	}

	public function registration($post){
		$login = $this->clean_data($post['reg_login']);
		$password = trim($post['reg_password']);
		$conf_pass = trim($post['reg_password_confirm']);
		$msg = '';
		if(empty($login)){
			$msg .= 'Введите логин</br>';
		}
		if(empty($password)){
			$msg .= 'Введите пароль</br>';
		}
		if($msg){
			$_SESSION['reg']['login'] = $login;
			return $msg;
		}
		if($conf_pass===$password){
			$sql = "SELECT id FROM users WHERE login='%s'";
			$sql = sprintf($sql,mysqli_real_escape_string($this->db,$login));
			$result = $this->db->query($sql);
			if(mysqli_num_rows($result)>0){
				return 'Пользователь с таким логином уже существует';
			}
			$password = md5($password);
			$query = "INSERT INTO users (id,login,password,sess) VALUES (null,'%s','%s','')";
			$query = sprintf($query,mysqli_real_escape_string($this->db,$login),$password);
			$result2 = $this->db->query($query);
			if(!$result2){
				$_SESSION['reg']['login'] = $login;
				return "Ошибка добавления пользователя в база данных";
			}else{return TRUE;}
		}else{
			$_SESSION['reg']['login'] = $login;
			return 'Вы не верно подтвердили пароль';
		}
	}

	public function login($post){
		if(empty($post['login']) || empty($post['password'])){
			return 'Заполните поля';
		}
		$login = $this->clean_data($post['login']);
		$password = md5(trim($post['password']));
		$sql = "SELECT id FROM users WHERE login='%s' AND password='%s'";
		$sql = sprintf($sql,mysqli_real_escape_string($this->db,$login),$password);
		$result = $this->db->query($sql);
		if(!$result || mysqli_num_rows($result) < 1){
			return 'Неправельный логин или пароль';
		}
		$sess = md5(microtime());
		$sql_update = "UPDATE users SET sess='$sess' WHERE login='%s'";
		$sql_update = sprintf($sql_update,mysqli_real_escape_string($this->db,$login));
		if(!$this->db->query($sql_update)){
			return "Ошибка авторизации пользователя";
		}
		$_SESSION['sess'] = $sess;
		if($post['member'] == 1){
			$time = time() + 10*24*3600;
			setcookie('login',$login,$time);
			setcookie('password',$password,$time);
		}
		return TRUE;
	}

}


?>