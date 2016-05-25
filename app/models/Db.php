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

	protected function getItems($params,$offset = 0 ,$limit = 100){
		$sql = "select * from " . $this->tName($this->tableName)  .  $this->whereString($params);	
		$sql .= ' limit ? , ?';
		$d = $this->db_util->readLines($sql,'ii',$offset,$limit);
		return $d;
	}

	protected function newItem($params){
		$fields = array_keys($params);
		$values = array_values($params);
		$fields = array_map(array($this,'wrapField'),$fields);
		$values = array_map(array($this,'wrapValue'),$values);
		$fields = implode(",",$fields);
		$values = implode(",",$values);
		$sql = "INSERT INTO " . $this->tName($this->tableName)  . ' ( ' .$fields . ' ) VALUES ( ' .$values  . ' ) ';
		$d = $this->db_util->insertItem($sql);
		return $d;
	}

	protected function updateItems($params,$w){
			$whereString = $this->whereString($w);
			$sql = 'UPDATE ' . $this->tName($this->tableName) . ' SET ';
			foreach($params as $fieldName=>$fieldValue){
				$sql .= '`'	. trim($fieldName) . '` = \'' . addcslashes($fieldValue , "'") . '\' , ';
			}

			$sql = rtrim($sql,", ");
			$sql .= $whereString ;
			echo $sql . "\n";
			return $this->db_util->updateItem($sql);
	}

	private function tName($t){
		return '`' . $this->tablePrefix . $t . '`';	
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

	private function wrapField($fieldName){
		return '`' . $fieldName . '`';
	}	

	private function wrapValue($value){
		return '\'' . addcslashes($value,"'\"" ). '\'';
	}

	protected function delById($id){
		$sql = 'DELETE FROM ' . $this->tName($this->tableName) . ' WHERE `id` = ? ' ;
		return $this->db_util->delItem($sql,'i',$id);
	}

	protected function findById($id){
		$w = array(
			$this->primary_key => $id		
		);	
		$items = $this->getItems($w);
		if(count($items) != 1) {
			return false;
		} else {
			return $items[0];
		}
	}
}
