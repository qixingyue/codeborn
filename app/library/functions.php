<?php

if(class_exists('LayoutPlugin')) {

	function setLayoutVar($name,$value){
		LayoutPlugin::setVars($name,$value);
	}

	function disableLayout(){
		LayoutPlugin::disable();	
	}

	function setLayoutFile($layoutFileName){
		LayoutPlugin::setLayoutFile($layoutFileName);	
	}

}

function isActive($b){
	echo $b  ? " class = 'active' " : '' ;
}

function cUid(){
	return $_SESSION['logined_uid'];
}

function cUriGroup(){
	$rg = new RequestGroup();
	return $rg->currentGroup();
}

function uriGroupIn($groupName){
	if(cUriGroup() == $groupName ) {
		echo " in ";
	}
}

function isUri($uri){
	$currentUri = RequestGroup::currentUri();	
	return strcmp($uri,$currentUri) == 0;
}

function cUserName(){
	return $_SESSION['logined_user'];
}

function parseTemplateVars($content){
	$p = new Parser();
	$vars = $p->parseVars($content);
	return implode("<br>",$vars);
}

