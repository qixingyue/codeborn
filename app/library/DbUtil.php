<?php

class DbUtil{

	private static $db_read;
	private static $db_write;
	private static $app;
	private static $init = false;

	public function __construct(){

		if(self::$init == false) {

			self::$app = Yaf_Application::app();
			$config = self::$app->getConfig();

			self::$db_read = new mysqli(
				$config->application->dbs_host,
				$config->application->dbs_user,
				$config->application->dbs_pwd,
				$config->application->dbs_name
			);	

			if(mysqli_connect_errno()){
				exit(mysqli_connect_error());	
			}

			self::$db_write = new mysqli(
				$config->application->dbm_host,
				$config->application->dbm_user,
				$config->application->dbm_pwd,
				$config->application->dbm_name
			);

			if(mysqli_connect_errno()){
				exit(mysqli_connect_error());	
			}

			self::$init = true;

		}
	}


	public function readLines($sql,$format = '',$args = array()){
		$args = func_get_args();
		$sql = array_shift($args);
		$stmt = self::$db_read->prepare($sql);
		if($stmt == false || null == $stmt ) {
			return array();
		}
		if(!empty($args)){
			call_user_func_array(array($stmt,'bind_param'),$this->refValues($args));
		}
		$stmt->execute();

		$result = $stmt->get_result();
		if($result == false) {
			return array();
		}
		$result_arr = array();

		while($result_item = $result->fetch_array(MYSQLI_BOTH)){
			$result_arr[] = $result_item;	
		}

		return $result_arr;	
	}

	public function updateItem($sql,$format = '', $params = array()){
		$args = func_get_args();
		$sql = array_shift($args);
		$stmt = self::$db_write->prepare($sql);
		if($stmt == false || null == $stmt ) {
			return false;
		}
		if(!empty($args)){
			call_user_func_array(array($stmt,'bind_param'),$this->refValues($args));
		}
		$stmt->execute();
		return $stmt->affected_rows;	
	}

	public function delItem($sql,$format = '' , $params = array()){
		$args = func_get_args();
		$sql = array_shift($args);
		$stmt = self::$db_write->prepare($sql);
		if($stmt == false || null == $stmt ) {
			return false;
		}
		if(!empty($args)){
			call_user_func_array(array($stmt,'bind_param'),$this->refValues($args));
		}
		$stmt->execute();
		return $stmt->affected_rows;	
	}

	public function insertItem($sql,$format = '', $params = array()){
		$args = func_get_args();
		$sql = array_shift($args);
		$stmt = self::$db_write->prepare($sql);
		if($stmt == false || null == $stmt ) {
			return false;
		}
		if(!empty($args)){
			call_user_func_array(array($stmt,'bind_param'),$this->refValues($args));
		}
		$stmt->execute();
		return $stmt->insert_id;
	}

	protected function refValues(array &$arr) {
		if (strnatcmp(phpversion(), '5.3') >= 0) {
			$refs = array();
			foreach ($arr as $key => $value) {
				$refs[$key] = & $arr[$key];
			}
			return $refs;
		}
		return $arr;
	}

	public function closeDb(){
		self::$db_read->close();	
		self::$db_write->close();	
	}

}
