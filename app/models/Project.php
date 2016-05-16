<?php

class ProjectModel extends DbModel{

	public function create($name,$en_name,$type){
		$sql = 'insert into cb_project ( name , en_name , type ) values ( ? , ? , ? )';
		$id = $this->insertItem($sql,'sss',$name,$en_name,$type);
		return $id > 0 ; 
	}

}
