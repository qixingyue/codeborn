<?php

class TemplateModel extends DbModel{

	protected $tableName = "template";

	public function createNew($name,$en_name,$content,$tag){
		$edit_time = $create_time = time();
		$i_data = array(
			'name'		=>	$name,
			'en_name'	=> $en_name,
			'type'		=> $tag,
			'content' => $content,
			'create_time' => $create_time,
			'edit_time' => $edit_time,
			'uid'			=> cUid()
		);

		$lastInsertIndex = $this->newItem($i_data);
		return $lastInsertIndex > 1;
	}

	public function updateItem($id,$name,$en_name,$content,$tag){
		$edit_time = $create_time = time();
		$i_data = array(
			'name'		=>	$name,
			'en_name'	=> $en_name,
			'type'		=> $tag,
			'content' => $content,
			'edit_time' => $edit_time,
		);
		$w = array(
			'id'	=> $id
		);
		return $this->updateItems($i_data,$w);

	}

	public function userTemplates($uid = 0,$offset,$limit){
		$w = array('uid'=>$uid);	
		return  $this->getItems($w,$offset,$limit);
	}

	public function userHowmany($uid){
		$w = array('uid'=>$uid);	
		return $this->howmany($w);
	}

	public function findTemplateByName($en_name){
		$w = array('en_name'=>$en_name);	
		return  $this->getItems($w);
	}

	public function delById($id){
		$delRows = parent::delById($id);	
		return $delRows > 0;
	}

	public function findById($id){
		return parent::findById($id);	
	}


}
