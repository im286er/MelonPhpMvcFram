<?php
	class authModel{

		function checkauth($username, $password){
			$adminobj = M('admin');
			$auth = $adminobj -> findOne_by_username($username);
			echo $password;
			if((!empty($auth))&&$auth['password']==$password){
				return $auth;
			}else{
				return false;
			}
		}
		private function checkuser($username,$password){
			$adminobj = M('admin');
			$auth = $adminobj->findOne_by_username($username);

			if((!empty($auth))&&$auth['password']==$password){
				return $auth;
			}else{
				return false;
			}
		}

		public function loginsubmit(){//进行登录验证的一些列业务逻辑
			if(empty($_POST['username'])||empty($_POST['password'])){
				return false;
			}
			$username = addslashes($_POST['username']);
			$password = addslashes($_POST['password']);
			//用户的验证操作-> 拆分到另外一个方法里
			if($this->auto=$this->checkuser($username,$password)){
				$_SESSION['auth'] = $this->auth;
				return true;
			}else{
				return false;
			}
		}
		public function getauth(){
			return $this->auth;
		}

		public function logout(){
			unset($_SESSION['auth']);
			$this->auth='';
		}


	}
?>