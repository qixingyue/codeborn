<?php

class UserModel extends DbModel {

	protected $tableName = "user";

	public function logined(){
		return isset($_SESSION['logined_user']);			
	}

	public function authLogin($email,$pwd){
		$w = array(
			"email"=>$email,
			"password"=>$this->encrptPassword($pwd)
		);

		$many = $this->howmany($w);		
		if($many > 0){
			$items = $this->getItems($w);
			$this->rememberUser($items[0]);
			return true;	
		}
		return false;
	}

	public function forgetUser(){
		unset($_SESSION['logined_user']);
		unset($_SESSION['logined_uid']);
	}

	private function encrptPassword($pwd){
		$d = $pwd;
		for($i = 0; $i < 10; $i++){
			$d = ( $i % 3 == 0 ) ? sha1($d) : md5($d);
		}	
		return $d;
	}

	private function rememberUser($item){
		$_SESSION['logined_user'] = $item['uname'];
		$_SESSION['logined_uid'] = $item['id'];
	}

}

