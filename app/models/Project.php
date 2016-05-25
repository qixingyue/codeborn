<?php

class ProjectModel extends DbModel{

	protected $tableName = "project";

	public function create($name,$en_name,$type){
		return $id > 0 ; 
	}

	public function userProjects($uid = 0){
		$w = array('uid'=>$uid);	
		return  $this->getItems($w);
	}

	public function createProject($name,$en_name,$type,$uid){
		$edit_time = $create_time = time();
		$i_data = array(
			'name'		=>	$name,
			'en_name'	=> $en_name,
			'type'		=> $type,
			'create_time' => $create_time,
			'edit_time' => $edit_time
		);

		$lastInsertIndex = $this->newItem($i_data);
		return $lastInsertIndex > 1;
	}

}
