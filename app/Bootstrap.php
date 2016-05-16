<?php

Yaf_loader::import("functions.php");

class Bootstrap extends Yaf_Bootstrap_Abstract {

	private $app;
	private $config;

	public function _initUTF8(){
		header("Content-type:text/html;charset=utf-8");
	}

	public function _initObjectIntern(Yaf_Dispatcher $dispatcher){
		$this->app = $dispatcher->getApplication();	
		$this->config = $this->app->getConfig();
		define('BASE_HOST',$this->config->application->base_host);
	}

	public function _initErrorReport(Yaf_Dispatcher $dispatcher){
		if($this->config->application->debug)	{
			error_reporting(E_ALL ^E_NOTICE);	
			ini_set("display_errors","On");	
		} else {
			error_reporting(E_STRICT);	
			ini_set("display_errors","Off");	
		}
	}

	public function _initSession(){
		session_start();	
	}

	public function _initLoginJump(Yaf_Dispatcher $dispatcher){
		$request = $dispatcher->getRequest();
		$uri = $request->getRequestUri();

		$nologin_uris = array(
			"/index/login",
			"/index/index",
			"/index/logout",
			"/"	
		);

		if(in_array($uri,$nologin_uris)){
			return ;	
		}

		$user = new UserModel();
		if(!$user->logined()){
			header("Location:http://codeborn.istrone.com/index/login"  );
			exit();
		}
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher){
		$router = Yaf_Dispatcher::getInstance()->getRouter();
	}


	public function _initPlugin(Yaf_Dispatcher $dispatcher){
		foreach($this->_getPlugins() as $pluginName){
			$pluginItem = Yaf_Registry::get($pluginName);
			$dispatcher->registerPlugin($pluginItem);
		}
	}


	public function _initCliDisableView(Yaf_Dispatcher $dispatcher){
		if($dispatcher->getRequest()->isCli()) {
			//cli init code ...
			LayoutPlugin::disable();
			$dispatcher->disableView();
		}

	}

	private function _getPlugins(){
		$layout = new LayoutPlugin('layout.html');
		Yaf_Registry::set('layout', $layout);
		return array('layout');	
	}

}

