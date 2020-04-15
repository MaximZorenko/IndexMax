<?php
class Model{
	public $db;

	public function __construct($host_user_pass_db){
		$url = parse_url(getenv($host_user_pass_db));
		try{
		$this->db = new PDO("pgsql:" . sprintf(
		    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
		    $url["host"],
		    $url["port"],
		    $url["user"],
		    $url["pass"],
		    ltrim($url["path"], "/")
		));
		} catch (PDOException $e) {
		    echo 'Подключение не удалось: ' . $e->getMessage();
		}

		// try{
		// $this->db = new PDO($host,$user,$pass);
		// } catch (PDOException $e) {
		//     echo 'Подключение не удалось: ' . $e->getMessage();
		// }
		return $this->db;
	}

	public function functProject($post,$user_id){
		$name = $post['project'];
		$hash_pro_id = md5(microtime());
		if(empty($user_id)){
			$sql = "INSERT INTO projects(hash_pro_id,name) VALUES ('$hash_pro_id','$name')";
			$res = $this->db->query($sql);
		}
		$sql = "INSERT INTO projects(hash_pro_id,name, user_id) VALUES ('$hash_pro_id','$name','$user_id')";
		$res = $this->db->query($sql);
		$sql = "SELECT * From projects WHERE hash_pro_id = '$hash_pro_id'";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
	}

	public function funcTask($post){
		$task = $post['task'];
		$project_id = $post['project_id'];
		$sql = "INSERT INTO tasks(name, project_id) VALUES ('$task','$project_id')";
		$res = $this->db->query($sql);
		$sql = "SELECT * FROM tasks WHERE project_id = '$project_id'";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
	}

	public function funcCheckbox($post){
		$checkbox = $post['checkbox'];
		$task_id = $post['task_id'];
		$sql = "SELECT status FROM tasks WHERE id = '$task_id'";
		$res = $this->db->query($sql);
		foreach($res as $row){
			$result=$row['status'];
		}
		if($result == 'checked'){
			$sql = "UPDATE tasks SET status='' WHERE id='$task_id'";
			$this->db->query($sql);
		}else{
			$sql = "UPDATE tasks SET status='checked' WHERE id='$task_id'";
			$this->db->query($sql);
		}
		return $return;
	}

	public function funcDeletTask($post){
		$deletTask = $post['deletTask'];
		$task_id = $post['task_id'];
		$sql="SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		foreach ($resProjectId as $row) {
			$resProjectId = $row['project_id'];
		}
		$sql = "DELETE FROM tasks WHERE id = '$task_id'";
		$this->db->query($sql);
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId' ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
	}

	public function funcCorrectTask($post){
		$correctTask = $post['correctTask'];
		$task_id = $post['task_id'];
		$sql="SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		foreach($resProjectId as $row){
			$resProjectId = $row['project_id'];
		}
		
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId' ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
	}

	public function funcNewValueTask($post){
		$newValueTask = $post['newValueTask'];
    	$task_id = $post['task_id'];
		$sql = "UPDATE tasks SET name='$newValueTask' WHERE id=$task_id";
		$res = $this->db->query($sql);
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id";
		$resProjectId = $this->db->query($sql);
		foreach($resProjectId as $row){
			$resProjectId = $row['project_id'];
		}
		$sql = "SELECT * FROM tasks WHERE project_id = '$resProjectId' ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
		$sql = "SELECT * From projects WHERE id = $project_id ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
					$return .= "	
						<input type='text' name='newValueProject' value='".$row['name']."'>
						<input type='button' name='deletProject'>
						<input type='hidden' name='project_id' value='".$row['id']."'>
						<input type='text' name='task'>
						<input type='submit' name='submitNewValueProject' value='Add Task'>
					";
		}
		return $return;
	}

	public function funcNewValueProject($post){
		$newValueProject = $post['newValueProject'];
    $project_id = $post['project_id'];
		$sql = "UPDATE projects SET name= '$newValueProject' WHERE id = $project_id";
		$res = $this->db->query($sql);
		$sql = "SELECT * FROM projects WHERE id = $project_id ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
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
	}

	public function funcNext($post){
		$task_id = $post['task_id'];//9999
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id";
		$resPro_id = $this->db->query($sql);
		foreach($resPro_id as $row){
			$resPro_id = $row['project_id'];
		}
		$sql = "SELECT id FROM tasks WHERE project_id = $resPro_id AND id < $task_id ORDER BY id DESC LIMIT 1";
		$res = $this->db->query($sql);
		foreach($res as $row){
			$resIdNext = $row['id'];
		}		
		if($resIdNext > 0){		
			$sql = "UPDATE tasks SET id = -2 WHERE id = $task_id";//9999
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = -1 WHERE id = $resIdNext";//8888
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = $resIdNext WHERE id = -2";//9999
			$res = $this->db->query($sql);

			$sql = "UPDATE tasks SET id = $task_id WHERE id = -1";//9999
			$res = $this->db->query($sql);

			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id' ORDER BY id";
			$res = $this->db->query($sql);
			foreach($res as $row){
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
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id' ORDER BY id";
			$res = $this->db->query($sql);
			foreach($res as $row){
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
		}		
	}

	public function funcPrev($post){
		$task_id = $post['task_id'];//9999
		$sql = "SELECT project_id FROM tasks WHERE id = $task_id ORDER BY id";
		$res = $this->db->query($sql);
		foreach($res as $row){
			$resPro_id = $row['project_id'];
		}
		$sql = "SELECT id FROM tasks WHERE project_id = $resPro_id AND id > $task_id ORDER BY id LIMIT 1";
		$res = $this->db->query($sql);
		foreach($res as $row){
			$resPrevId = $row['id'];
		}
		if($resPrevId > 0){
			$sql = "UPDATE tasks SET id = -2 WHERE id = $task_id";//9999
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = -1 WHERE id = $resPrevId";//8888
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = $resPrevId WHERE id = -2";//9999
			$res = $this->db->query($sql);
			$sql = "UPDATE tasks SET id = $task_id WHERE id = -1";//9999
			$res = $this->db->query($sql);
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id' ORDER BY id";
			$res = $this->db->query($sql);
			foreach($res as $row){
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
			$sql = "SELECT * FROM tasks WHERE project_id = '$resPro_id' ORDER BY id";
			$res = $this->db->query($sql);
			foreach($res as $row){
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
		foreach($res as $row){
			$_SESSION['login'] = $row['login'];
			$return = $row['id'];
		}

		return $return;
	}

	public function funcAddMess($user_id){
		if(!$user_id){
			$sql = "SELECT * FROM projects WHERE user_id IS NULL ORDER BY id DESC";
		}else{
			$sql = "SELECT * FROM projects WHERE user_id = $user_id ORDER BY id DESC";
		}	
		$res = $this->db->query($sql);
		foreach($res as $row){
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
					$sqli = "SELECT * FROM tasks WHERE project_id = ".$row['id']." ORDER BY id";
					$resi = $this->db->query($sqli);
					foreach($resi as $rowi){
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
					$return .="</div></div>";
			}
			return $return;
	}

	public function clean_data($str){
		return strip_tags(trim($str));
	}

	public function registration($post){
		$login = $post['reg_login'];
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
			$sql = "SELECT id FROM users WHERE login='$login'";
			$res = $this->db->query($sql);
			foreach($res as $row){
				$resi = $row['id'];
			}
			if($resi > 0){
				return 'Пользователь с таким логином уже существует';
			}
				$password = md5($password);
				$sql = "INSERT INTO users (login,password,sess) VALUES ('$login','$password','')";
				$res = $this->db->exec($sql);
				if($res == 0){
					return "вставка не выполнена";
				}
					return TRUE;
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
		$sql = "SELECT id FROM users WHERE login='$login' AND password='$password'";
		$res = $this->db->query($sql);
		foreach($res as $row){
				$resi = $row['id'];
			}
		if($resi > 0){
					$sess = md5(microtime());
					$sql = "UPDATE users SET sess='$sess' WHERE login='$login'";
					$this->db->exec($sql);
					$_SESSION['sess'] = $sess;
					if($post['member'] == 1){
						$time = time() + 10*24*3600;
						setcookie('login',$login,$time);
						setcookie('password',$password,$time);
					}
					return TRUE;
		}else{
			return 'Неправельный логин или пароль';
		}
	}
		
	

}

?>