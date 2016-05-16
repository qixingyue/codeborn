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
