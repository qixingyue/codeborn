<?php

class AppController extends Yaf_Controller_Abstract {

	protected $layoutFile = "admin.html";

	public function init(){
		LayoutPlugin::setLayoutFile($this->layoutFile);
	}

	public function indexAction(){
		Yaf_Dispatcher::getInstance()->disableView();
		LayoutPlugin::disable();
	}

	protected function dump(){
		$args = func_get_args();	
		foreach($args as $arg){
			var_dump($arg);
		}
		exit();
	}

	protected function isGet(){
		return $this->getRequest()->isGet();
	}

	protected function isPost(){
		return $this->getRequest()->isPost();
	}

	protected function setLayoutFile($layoutFile){
		LayoutPlugin::setLayoutFile($layoutFile);
	}

}
