<?php

class RequestGroup {

	public function groups(){

		return array(
			'project'	=> array(
				'/project',
			),
			'template' => array(
				'/template',
			)

		);
	
	}

	public static function currentUri(){
		$dispatcher = Yaf_Dispatcher::getInstance();	
		$request = $dispatcher->getRequest();
		$uri = $request->getRequestUri();
		return $uri;
	}

	public function currentGroup(){
		$uri = self::currentUri();
		$groups = $this->groups();
		foreach($groups as $groupName=>$groupUris){
			foreach($groupUris as $groupUriItem){
				if( 0 == strncmp($groupUriItem,$uri,strlen($groupUriItem)))	{
					return $groupName;	
				}
			}	
		}
	}

}
