<?php

class DbModel {

	private $db_util;
	protected $tableName;
	protected $primary_key = 'id';
	private $tablePrefix = "";

	public function __construct(){
		$this->db_util = new DbUtil();	
		$app = Yaf_Application::app();
		$config = $app->getConfig();
		$this->tablePrefix = $config->application->db_prefix;
	}

	protected function howmany($params){
		$sql = "select count(*) as C from " . $this->tName($this->tableName)  .  $this->whereString($params);	
		$d = $this->db_util->readLines($sql);
		if(is_array($d) && isset($d[0]['C'])){
			return $d[0]['C']	;
		}
		return 0;	
	}

	protected function getItems($params){
		$sql = "select * from " . $this->tName($this->tableName)  .  $this->whereString($params);	
		$d = $this->db_util->readLines($sql);
		return $d;
	}

	private function tName($t){
		return $this->tablePrefix . $t;	
	}

	private function whereString($params){
		if(empty($params) || $params == ""){
			return "";	
		}
		$w = " where ";
		if(is_array($params)){
			foreach($params as $k=>$v){
				if(is_array($v)){
					$w .= $k . " " . $v[0] . " " . $v[1] . " AND ";
				} else {
					$w .= $k . " = '" . $v . "' AND ";
				}
			}
			$w = rtrim($w," AND");
		}

		if(is_string($params)) {
			return $w . $params;	
		}
		return $w;
	}

}
